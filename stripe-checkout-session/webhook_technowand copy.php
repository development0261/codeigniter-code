<?php    
    $payload = @file_get_contents('php://input');
    $event= json_decode( $payload, TRUE );    
    mail("subhamoy84@gmail.com","Stripe Webhook Post",print_r($event, true));

    $conn = new mysqli('localhost', 'sweetbit_webapi', 'IWTSMLRzf?aE', 'sweetbit_webapi');
    
    $VIDEO_PURCHASE_TABLE = 'yvdnsddqu_workout_video_purchases';
    $VIDEO_PURCHASE_RECURRING_ENTRIES = 'yvdnsddqu_workout_video_purchases_recurring_entries';
    $VIDEO_PURCHASE_ONETIME_ENTRIES = 'yvdnsddqu_workout_video_purchases_onetime_payments';
    $ALL_SUBSCRIPTION_RECORDS = 'yvdnsddqu_workout_video_purchases_subscription_records';
    
    if($event['type'] == 'charge.succeeded'){
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

            $res = get_records($VIDEO_PURCHASE_TABLE, $selected_fields = 'video_purchase_id, charge_id, purchase_type, subscription_id, subscription_payment_iteration', $conditions = array('email'=>$customer_email, 'is_active'=>'1'), $conn);

            if(empty($res)){  // Insert other records if subscription id is not inserted                    
                    // Insert new record
                    $result = insert_update_table($VIDEO_PURCHASE_TABLE, $record_array, $conditions = array(), $conn);
                    $last_insert_id = mysqli_insert_id($conn); // Gte latest video_purchase_id                 
            } else {
                    /*
                    * Check previous type. If previous type andn current type does not match then cancel previous plan and insert
                    */
                    if(trim($res['purchase_type']) != 'subscription') { // Check if previous purchase type was different. 
                        mail("subhamoy84@gmail.com","Call Subscription Cancel", print_r($res, true));
                        cancel_payment_plan($res, $conn, $VIDEO_PURCHASE_TABLE);

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
                        } 
                    }                                       
            }
            
            // Insert into child 'recurring' payment table
            $video_purchase_id = !empty($last_insert_id) ? $last_insert_id : $res['video_purchase_id'];
            $record_array = array(
                'video_purchase_id'=> $video_purchase_id, 'email' => $customer_email, 'txn_id' => $txn_id, 'charge_id' => $charge_id, 'purchase_date' => $purchase_date
             );
             $result = insert_update_table($VIDEO_PURCHASE_RECURRING_ENTRIES, $record_array, $conditions = array(), $conn);
                       
            //mail("subhamoy84@gmail.com","Subscription SQL",$sql);
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
            $res = get_records($VIDEO_PURCHASE_TABLE, $selected_fields = 'video_purchase_id, purchase_type, subscription_id,subscription_payment_iteration', $conditions = array('email'=>$metadata['email'], 'is_active'=>'1'), $conn);            
            if(empty($res)){                    
                    // Insert new record                    
                    $result = insert_update_table($VIDEO_PURCHASE_TABLE, $record_array, $conditions = array(), $conn);
                    $last_insert_id = mysqli_insert_id($conn); // Gte latest video_purchase_id        

            } else {
                    /*
                    * Check previous type. If previous type andn current type does not match then cancel previous plan and insert
                    */
                    if(trim($res['purchase_type']) != 'fixed') { // Check if previous purchase type was different. 
                        cancel_payment_plan($res, $conn, $VIDEO_PURCHASE_TABLE);

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
                    Subscription Price: AUD".$to_amount."
                    <br>
                    Content Provider: Lee Priest Fitness Training Program
                    <br>
                    Date Accepted: ".date("F j, Y", strtotime($to_date))."
                    <br>
                    Start Date: starting 06 July 2021
                </p>
                <p>We are thrilled to announce that we are launching the Lee Priest Fitness Training Program on Tuesday, 6th July.</p>
                <p>We will send a reminder before the start date and keep you posted.</p>
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
    // Subscription create call
    if($event['type'] == 'customer.subscription.created'){
        $metadata  = $event['data']['object']['metadata'];
        $subscription_id = $event['data']['object']['id'];

        mail("subhamoy84@gmail.com","Subscription customer.subscription.created => subscription_id =".$subscription_id,print_r($metadata, true));

        $resinfo = get_records($VIDEO_PURCHASE_TABLE, $selected_fields = 'video_purchase_id', $conditions = array('email'=>$metadata['email'], 'is_active'=>'1'), $conn);
        // Update recurring entries table
        $record_array = array();
        $conditions = array();
        if(!empty($resinfo)) { // Update subscription id
            $record_array = array( 'subscription_id' => $subscription_id );
            $conditions   = array('email' => $metadata['email'], 'is_active'=>'1');    
        }  
        else { // Insert subscription id
            $record_array = array('email' => $metadata['email'], 'subscription_id' => $subscription_id, 'is_active'=>'1' );
        }                       
        $result = insert_update_table($VIDEO_PURCHASE_TABLE, $record_array, $conditions, $conn);

        // Insert into subscription_records table
        $record_array = array(
                        'email' => $metadata['email'], 'subscription_id'  => $subscription_id, 'purchase_date'  => date('Y-m-d H:i:s')
                        );
        $result = insert_update_table($ALL_SUBSCRIPTION_RECORDS, $record_array, $conditions = array(), $conn);
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

                mail("subhamoy84@gmail.com","Record inserted successfully",$INSERT_SQL);

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

                mail("subhamoy84@gmail.com","Record updated successfully",$UPDATE_SQL);

                $result = $dbconnection->query($UPDATE_SQL);
            }
        }
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
        //mail("subhamoy84@gmail.com","Select record successfully",$SQL);

        $result = $dbconnection->query($SQL);
        $rows   = mysqli_fetch_assoc($result);
        return $rows;
    }

    /*
    * Cancel existing payment plan to insert new plan
    */
    function cancel_payment_plan($record = array(), $dbconnection = NULL, $VIDEO_PURCHASE_TABLE = ''){
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
    }

    /*
    * Cancel subscription plan from stripe
    */
    function stripe_subscription_cancel($stripeinfo = array()){
        mail("subhamoy84@gmail.com","Subscription Cancel ID =".$stripeinfo['subscription_id'], "");
        //include Stripe PHP library
        //include Stripe PHP library
        require_once('stripe-php/init.php');    
        try { 
            //set stripe secret key
            $stripe = new \Stripe\StripeClient(
                'sk_test_51GxRVFJpxyLWDkuo0rVAU4nxTR0eyPLidiQ92igKB3MsUuK2R5uhEbH2LEGIszV7sTLrGDNWLyt8yNDlufBioYNG00A3K8ZAuY'
            );

            $stripe->subscriptions->cancel(
                $stripeinfo['subscription_id'],
            []
            );
        } catch(Exception $e) { 
            mail("subhamoy84@gmail.com","Subscription Cancel failure =".$stripeinfo['subscription_id'], print_r($e->getMessage(), true));
            //$this->api_error = $e->getMessage(); 
            return false; 
        }  
        
    }
?>