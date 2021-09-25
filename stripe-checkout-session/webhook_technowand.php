<?php
    $payload = @file_get_contents('php://input');
    $event= json_decode( $payload, TRUE );

    $conn = new mysqli('localhost', 'sweetbit_webapi', 'IWTSMLRzf?aE', 'sweetbit_webapi');

    $VIDEO_PURCHASE_TABLE = 'yvdnsddqu_workout_video_purchases';
    $VIDEO_PURCHASE_RECURRING_ENTRIES = 'yvdnsddqu_workout_video_purchases_recurring_entries';
    $VIDEO_PURCHASE_ONETIME_ENTRIES = 'yvdnsddqu_workout_video_purchases_onetime_payments';
    $ALL_SUBSCRIPTION_RECORDS_TABLE = 'yvdnsddqu_workout_video_purchases_subscription_records';
    echo '11';
    if($event['type'] == 'charge.succeeded'){

        error_log('======== Stripe Response '.date('Y-m-d H:i:s').' ===== '.PHP_EOL, 3, "./purchase_event_stripe_response.log");
        error_log(print_r($event, true).PHP_EOL, 3, "./purchase_event_stripe_response.log");

        $metadata  = $event['data']['object']['metadata'];
        $charge_id = $event['data']['object']['id'];
        $amount    = ((int)$event['data']['object']['amount']) / 100;
        $txn_id    = $event['data']['object']['balance_transaction'];

        $purchase_date = date('Y-m-d H:i:s');
        $description   = strtolower($event['data']['object']['description']);

        $to_email      = '';
        $to_amount     = $amount;
        $to_date       = date('Y-m-d');
        $recurring_entry = false;
        $fixed_entry = false;

        $MAIL_SEND_FLAG = false;

        if (strpos($description, 'subscription') !== false) // For SUBSCRIPTION
        {
            $customer_email     = $event['data']['object']['billing_details']['email'];
            $currency           = $event['data']['object']['currency'];
            $to_email           = $customer_email;

            $recurring_entry    = true;
            $last_insert_id     = '';
            /*
            * Check recurring status
            */
            $record_array = array(
                'first_name' => '', 'last_name'  => '', 'email'  => $customer_email, 'product_name' => 'Lee Priest Video', 'currency' => $currency, 'unit_amount' => $amount, 'quantity' => '1', 'workout_video_id' => '8', 'message' => '', 'price' => $amount, 'txn_id' => $txn_id, 'charge_id' => $charge_id, 'purchase_date' => $purchase_date, 'purchase_type' => 'subscription', 'is_active' => '1', 'subscription_payment_iteration' => '1'
                 );

            $res = get_records($VIDEO_PURCHASE_TABLE, $selected_fields = 'video_purchase_id, email, charge_id, purchase_type, subscription_id, subscription_payment_iteration', $conditions = array('email'=>$customer_email, 'is_active'=>'1'), $conn);

            if(empty($res)){  // Insert other records if subscription id is not inserted
                    // Update record_array
                    $raw_sql = "SELECT `subscription_payment_iteration` FROM `".$VIDEO_PURCHASE_TABLE."` WHERE `email` = '".$customer_email."' ORDER BY `video_purchase_id` DESC LIMIT 1";
                    $iteration_record = get_records_customsql($raw_sql, $conn);
                    if(!empty($iteration_record)){
                        $record_array['subscription_payment_iteration'] = intval($record_array['subscription_payment_iteration']) + intval($iteration_record['subscription_payment_iteration']);
                    }
                    /*
                    * This is used to check whether subscription_id exists in all subscription records table
                    */
                    $data_all_subscription = get_records($ALL_SUBSCRIPTION_RECORDS_TABLE, $selected_fields = 'subscription_id', $conditions = array('email'=>$customer_email, 'is_active'=>'1'), $conn);
                    if(!empty($data_all_subscription['subscription_id'])){
                        $record_array['subscription_id'] = $data_all_subscription['subscription_id'];
                    }

                    // Insert new record
                    $result = insert_update_table($VIDEO_PURCHASE_TABLE, $record_array, $conditions = array(), $conn);
                    $last_insert_id = mysqli_insert_id($conn); // Gte latest video_purchase_id
            } else {
                    /*
                    * Check previous type. If previous type andn current type does not match then cancel previous plan and insert
                    */
                    if(trim($res['purchase_type']) != 'subscription') { // Check if previous purchase type was different.

                        cancel_payment_plan($res, $conn, $VIDEO_PURCHASE_TABLE, $ALL_SUBSCRIPTION_RECORDS_TABLE);

                        // Update record_array
                        $record_array['subscription_payment_iteration'] = intval($record_array['subscription_payment_iteration']) + $res['subscription_payment_iteration'];

                        // Insert new record
                        $result = insert_update_table($VIDEO_PURCHASE_TABLE, $record_array, $conditions = array(), $conn);
                        $last_insert_id = mysqli_insert_id($conn); // Gte latest video_purchase_id

                    } else {
                        if(!empty($res['subscription_id']) && empty($res['charge_id']))
                        { // Update other records if sub_id inserted first
                            $conditions   = array('subscription_id' => $res['subscription_id'], 'email'  => $customer_email, 'is_active'=>'1');
                            $result = insert_update_table($VIDEO_PURCHASE_TABLE, $record_array, $conditions, $conn);
                        }
                        else
                        {
                            $subscription_iteration = !empty($res['subscription_payment_iteration']) ? $res['subscription_payment_iteration'] + 1 : 1;
                            $record_array = array( 'subscription_payment_iteration' => $subscription_iteration );
                            $conditions   = array('email' => $customer_email, 'is_active'=>'1');
                            $result = insert_update_table($VIDEO_PURCHASE_TABLE, $record_array, $conditions, $conn);

                            $MAIL_SEND_FLAG = false;
                        }
                    }
            }

            // Insert into child 'recurring' payment table
            $video_purchase_id = !empty($last_insert_id) ? $last_insert_id : $res['video_purchase_id'];
            $record_array = array(
                'video_purchase_id'=> $video_purchase_id, 'email' => $customer_email, 'txn_id' => $txn_id, 'charge_id' => $charge_id, 'purchase_date' => $purchase_date
             );
             $result = insert_update_table($VIDEO_PURCHASE_RECURRING_ENTRIES, $record_array, $conditions = array(), $conn);
        }
        else // For ONETIME Payment
        {
            $to_email           = $metadata['email'];
            $fixed_entry        = true;
            $record_array = array(
                'first_name' => $metadata['first_name'], 'last_name'  => $metadata['last_name'], 'email'  => $metadata['email'], 'product_name' => $metadata['product_name'], 'currency' => $metadata['currency'], 'unit_amount' => $metadata['unit_amount'], 'quantity' => $metadata['quantity'], 'workout_video_id' => $metadata['video_id'], 'message' => $metadata['message'], 'price' => $amount, 'txn_id' => $txn_id, 'charge_id' => $charge_id, 'purchase_date' => $purchase_date, 'purchase_type' => 'fixed', 'is_active' => '1', 'subscription_payment_iteration' => '4'
                );
            /*
            * Check recurring status
            */
            $res = get_records($VIDEO_PURCHASE_TABLE, $selected_fields = 'video_purchase_id, email, purchase_type, subscription_id,subscription_payment_iteration', $conditions = array('email'=>$metadata['email'], 'is_active'=>'1'), $conn);
            if(empty($res)){
                    // Update record_array
                    $raw_sql = "SELECT `subscription_payment_iteration` FROM `".$VIDEO_PURCHASE_TABLE."` WHERE `email` = '".$metadata['email']."' ORDER BY `video_purchase_id` DESC LIMIT 1";
                    $iteration_record = get_records_customsql($raw_sql, $conn);
                    if(!empty($iteration_record)){
                        $record_array['subscription_payment_iteration'] = intval($record_array['subscription_payment_iteration']) + intval($iteration_record['subscription_payment_iteration']);
                    }

                    // Insert new record
                    $result = insert_update_table($VIDEO_PURCHASE_TABLE, $record_array, $conditions = array(), $conn);
                    $last_insert_id = mysqli_insert_id($conn); // Gte latest video_purchase_id

            } else {
                    /*
                    * Check previous type. If previous type andn current type does not match then cancel previous plan and insert
                    */
                    if(trim($res['purchase_type']) != 'fixed') { // Check if previous purchase type was different.
                        cancel_payment_plan($res, $conn, $VIDEO_PURCHASE_TABLE, $ALL_SUBSCRIPTION_RECORDS_TABLE);

                        // Update record_array
                        $record_array['subscription_payment_iteration'] = intval($record_array['subscription_payment_iteration']) + $res['subscription_payment_iteration'];

                        // Insert new record
                        $result = insert_update_table($VIDEO_PURCHASE_TABLE, $record_array, $conditions = array(), $conn);
                        $last_insert_id = mysqli_insert_id($conn); // Gte latest video_purchase_id
                    }
                    else
                    {
                        $subscription_iteration = !empty($res['subscription_payment_iteration']) ? $res['subscription_payment_iteration'] + 4 : 4;
                        $record_array = array('subscription_payment_iteration' => $subscription_iteration);
                        $conditions   = array('email' => $metadata['email'], 'is_active'=>'1');
                        $result = insert_update_table($VIDEO_PURCHASE_TABLE, $record_array, $conditions, $conn);
                    }
            }
            // Insert into child 'recurring' payment table
            $video_purchase_id = !empty($last_insert_id) ? $last_insert_id : $res['video_purchase_id'];
            $record_array = array(
                'video_purchase_id'=> $video_purchase_id, 'email' => $metadata['email'], 'txn_id' => $txn_id, 'charge_id' => $charge_id, 'purchase_date' => $purchase_date
            );
            $result = insert_update_table($VIDEO_PURCHASE_ONETIME_ENTRIES, $record_array, $conditions = array(), $conn);
        }

        // Send Email Templates
        if($MAIL_SEND_FLAG === true){
            $to = $to_email;
            $subject = 'Lee Priest Fitness Training Program';

            $headers = "From: noreply@ignitit.com.au\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

            $message = "<!DOCTYPE html>
            <html lang='en'>
            <meta charset='UTF-8'>
            <title>Lee Priest Fitness Training Program</title>
            <meta name='viewport' content='width=device-width,initial-scale=1'>
            <body>
                <div>
                    <p>Hello,</p>
                    <p>Thank you for subscribing to the Lee Priest Fitness Training Program.</p>
                    <p>We've successfully received your payment:</p>
                    <p>
                        App: Ignitit
                        <br>
                        Subscription Price: AUD ".$to_amount."
                        <br>
                        Content Provider: Lee Priest Fitness Training Program
                        <br>
                        Date Accepted: ".date("F j, Y", strtotime($to_date))."
                    </p>
                    <p>
                        Kind Regards,
                        <br>
                        Lee Priest Cartel Team
                    </p>
                </div>

            </body>
            </html>";

            mail($to, $subject, $message, $headers);
        }

    }
    // Subscription create call
    if($event['type'] == 'customer.subscription.created'){

        error_log('======== Stripe Response '.date('Y-m-d H:i:s').' ===== '.PHP_EOL, 3, "./purchase_event_stripe_response.log");
        error_log(print_r($event, true).PHP_EOL, 3, "./purchase_event_stripe_response.log");

        // Slow script scecution
        sleep(3);

        $metadata  = $event['data']['object']['metadata'];
        $subscription_id = $event['data']['object']['id'];

        error_log('====== Subscription customer.subscription.created => subscription_id ='.$subscription_id .' = '.date('Y-m-d H:i:s').' ===== '.PHP_EOL, 3, "./purchase_records.log");
		error_log(print_r($metadata, true).PHP_EOL, 3, "./purchase_records.log");

        $resinfo = get_records($VIDEO_PURCHASE_TABLE, $selected_fields = 'video_purchase_id', $conditions = array('email'=>$metadata['email'], 'is_active'=>'1'), $conn);
        // Update recurring entries table
        $record_array = array();
        $conditions = array();
        if(!empty($resinfo))
        { // Update subscription id
            $record_array = array( 'subscription_id' => $subscription_id );
            $conditions   = array('email' => $metadata['email'], 'is_active'=>'1');
        }
        else
        { // Insert subscription id
            $record_array = array('email' => $metadata['email'], 'subscription_id' => $subscription_id, 'is_active'=>'1', 'product_name' => 'Lee Priest Video', 'currency' => $metadata['currency'], 'unit_amount' => $metadata['unit_amount'], 'quantity' => $metadata['quantity'], 'workout_video_id' => '8', 'price' => $metadata['unit_amount'], 'purchase_date' => date('Y-m-d H:i:s'), 'purchase_type' => 'subscription',  'subscription_payment_iteration' => '1');
        }
        $result = insert_update_table($VIDEO_PURCHASE_TABLE, $record_array, $conditions, $conn);

        // Insert into subscription_records table
        $record_array = array(
                        'email' => $metadata['email'], 'subscription_id'  => $subscription_id, 'purchase_date'  => date('Y-m-d H:i:s'), 'is_active'  => '1'
                        );
        $result = insert_update_table($ALL_SUBSCRIPTION_RECORDS_TABLE, $record_array, $conditions = array(), $conn);
    }

    /*
    * Insert into video purchase table
    */
    function insert_update_table($table = '', $records = array(), $conditions = array(), $dbconnection = NULL){
        $SQL = '';
        $DATA = '';
        $SQL_CONDITION = '';
        if(empty($conditions)){ // Insert record
            $INSERT_SQL = 'INSERT INTO '.$table;
            if(!empty($records)){
                foreach($records as $key=>$value){
                    $DATA .= empty($DATA)? " `".$key."` = '".$value."'" : ", `".$key."` = '".$value."'";
                }
            }
            if(!empty($DATA)){
                $INSERT_SQL = $INSERT_SQL.' SET '.$DATA.' '.$SQL_CONDITION;

                error_log('====== Record inserted successfully = '.date('Y-m-d H:i:s').' ===== '.PHP_EOL, 3, "./purchase_records.log");
		        error_log($INSERT_SQL.PHP_EOL, 3, "./purchase_records.log");

                $result = $dbconnection->query($INSERT_SQL);
            }
        } else { // Update record
            $UPDATE_SQL = 'UPDATE '.$table;
            if(!empty($records)){
                foreach($records as $key=>$value){
                    $DATA .= empty($DATA)? " `".$key."` = '".$value."'" : ", `".$key."` = '".$value."'";
                }
            }
            if(!empty($conditions)){
                foreach($conditions as $key=>$value){
                    $SQL_CONDITION .= empty($SQL_CONDITION)? " WHERE `".$key."` = '".$value."'" : " AND `".$key."` = '".$value."'";
                }
            }
            if(!empty($DATA)){
                $UPDATE_SQL = $UPDATE_SQL.' SET '.$DATA.' '.$SQL_CONDITION;

                error_log('====== Record updated successfully = '.date('Y-m-d H:i:s').' ===== '.PHP_EOL, 3, "./purchase_records.log");
		        error_log($UPDATE_SQL.PHP_EOL, 3, "./purchase_records.log");

                $result = $dbconnection->query($UPDATE_SQL);
            }
        }
        return true;
    }

    /*
    * Fetch records from table
    */
    function get_records($table = '', $selected_fields = '*', $filters = array(), $dbconnection = NULL){

        $SQL = "SELECT ".$selected_fields." FROM ".$table;
        $CONDITIONS = '';
        if(!empty($filters)){
            foreach($filters as $key=>$value){
                $CONDITIONS .= empty($CONDITIONS)?"  WHERE `".$key."`='".$value."'" : " AND `".$key."`='".$value."'";
            }
        }

        $SQL    = $SQL.$CONDITIONS;

        $result = $dbconnection->query($SQL);
        $rows   = mysqli_fetch_assoc($result);
        return $rows;
    }

    /*
    * Fetch records from table
    */
    function get_records_customsql($SQL = '', $dbconnection = NULL){
        $result = $dbconnection->query($SQL);
        $rows   = mysqli_fetch_assoc($result);
        return $rows;
    }

    /*
    * Cancel existing payment plan to insert new plan
    */
    function cancel_payment_plan($record = array(), $dbconnection = NULL, $VIDEO_PURCHASE_TABLE = '', $ALL_SUBSCRIPTION_RECORDS_TABLE = ''){
        /*
        * if previous plan is 'subscription' then cancel subscription first to insert one time payment
        */
        if($record['purchase_type'] == 'subscription' && !empty($record['subscription_id'])){
            stripe_subscription_cancel($record);
        }

        // Make 'is_active' to 0
        $record_array = array('is_active' => '0');
        $conditions   = array('video_purchase_id' => $record['video_purchase_id'], 'is_active'=>'1');
        $result = insert_update_table($VIDEO_PURCHASE_TABLE, $record_array, $conditions, $dbconnection);

        // Update "is_active" = 0 in yvdnsddqu_workout_video_purchases_subscription_records table
        $conditions   = array('subscription_id' => $record['subscription_id'], 'is_active'=>'1');
        $result = insert_update_table($ALL_SUBSCRIPTION_RECORDS_TABLE, $record_array, $conditions, $dbconnection);

        return true;
    }

    /*
    * Cancel subscription plan from stripe
    */
    function stripe_subscription_cancel($stripeinfo = array()){
        //include Stripe PHP library
        //include Stripe PHP library
        require_once('stripe-php/init.php');
        include 'stripe_keys.php';
        try {
            //set stripe secret key
            $stripe = new \Stripe\StripeClient(STRIPE_KEY);

            $stripe->subscriptions->cancel(
                $stripeinfo['subscription_id'],
            []
            );
        } catch(Exception $e) {
            error_log('====== Subscription Cancel failure = '.$stripeinfo['subscription_id'].' ==='.date('Y-m-d H:i:s').' ===== '.PHP_EOL, 3, "./purchase_records.log");
		    error_log(print_r($e->getMessage(), true).PHP_EOL, 3, "./purchase_records.log");
            //$this->api_error = $e->getMessage();
            return false;
        }

    }
?>