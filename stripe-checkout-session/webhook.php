<?php      
    $payload = @file_get_contents('php://input');
    $event= json_decode( $payload, TRUE );    
    mail("subhamoy84@gmail.com","Stripe Live Webhook Post",print_r($event, true));
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

        $conn = new mysqli('localhost', 'ignititc_db', 'ignititc_db1234#', 'ignititc_db');
        if (strpos($description, 'subscription') !== false) {
            $customer_email     = $event['data']['object']['billing_details']['email'];
            $currency           = $event['data']['object']['currency'];
            $to_email           = $customer_email;

            $recurring_entry    = true; 
            /*
            * Check recurring status
            */
            $query = "SELECT `video_purchase_id` FROM `yvdnsddqu_workout_video_purchases` WHERE `email` = '".$customer_email."' AND `is_active` = '1'";
            $result = $conn->query($query);
            $count_rows = mysqli_num_rows($result);
            if($count_rows ==  0){
                $sql = "INSERT INTO `yvdnsddqu_workout_video_purchases` (`first_name`, `last_name`, `email`, `product_name`, `currency`, `unit_amount`, `quantity`, `workout_video_id`, `message`, `price`, `txn_id`, `charge_id`, `purchase_date`, `purchase_type`, `is_active`, `subscription_payment_iteration`) VALUES ('', '', '".$customer_email."', 'Lee Priest Video', '".$currency."', '".$amount."', '1', '8' , '' , '".$amount."' , '".$txn_id."' , '".$charge_id."' , '".$purchase_date."', 'subscription', '1', '1')";
            } else {
                $sql = "UPDATE `yvdnsddqu_workout_video_purchases` SET `subscription_payment_iteration` = '".($count_rows + 1)."' WHERE `email` = '".$customer_email."' ";
            }
            
            $recurring_sql = "INSERT INTO `yvdnsddqu_workout_video_purchases_recurring_entries` (`email`, `txn_id`, `charge_id`, `purchase_date`) VALUES ('".$customer_email."', '".$txn_id."' , '".$charge_id."' , '".$purchase_date."')"; 

            
            mail("subhamoy84@gmail.com","Subscription Live SQL",$sql);
        } else {
            $to_email           = $metadata['email'];

            $sql = "INSERT INTO `yvdnsddqu_workout_video_purchases` (`first_name`, `last_name`, `email`, `product_name`, `currency`, `unit_amount`, `quantity`, `workout_video_id`, `message`, `price`, `txn_id`, `charge_id`, `purchase_date`, `purchase_type`, `is_active`, `subscription_payment_iteration`) VALUES ('".$metadata['first_name']."', '".$metadata['last_name']."', '".$metadata['email']."', '".$metadata['product_name']."', '".$metadata['currency']."', '".$metadata['unit_amount']."', '".$metadata['quantity']."', '".$metadata['video_id']."' , '".$metadata['message']."' , '".$amount."' , '".$txn_id."' , '".$charge_id."' , '".$purchase_date."', 'fixed', '1', '1')";

            mail("subhamoy84@gmail.com","Record Live inserted successfully",print_r($event['data']['object']['metadata'], true));
        }        

        if ($conn->query($sql) === TRUE) {
            /*
            * Recurring entry
            */
            if($recurring_entry == true){                
                mail("subhamoy84@gmail.com","Subscription Live Recurring SQL",$recurring_sql);
                $recurring_result = $conn->query($recurring_sql);
            }
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

            @mail($to, $subject, $message, $headers);
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        
    }

    if($event['type'] == 'customer.subscription.created'){
        $metadata  = $event['data']['object']['metadata'];
        $subscription_id = $event['data']['object']['id'];

        $conn = new mysqli('localhost', 'ignititc_db', 'ignititc_db1234#', 'ignititc_db');
        $sql = "UPDATE `yvdnsddqu_workout_video_purchases` SET `subscription_id` = '".$subscription_id."' WHERE `email` = '".$metadata['email']."' ";
        mail("subhamoy84@gmail.com","Subscription customer.subscription.created",$sql);
        $result = $conn->query($sql);
    }
?>