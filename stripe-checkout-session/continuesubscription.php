<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Authorization, token, Content-Type');
include 'stripe_keys.php';

$json = file_get_contents('php://input');
// Converts it into a PHP object
$post = json_decode($json);   
$session_id = '';

$headers = getAuthorizationHeader();
// HEADER: Get the access token from the header
if (!empty($headers)) 
{ 
  
    if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) 
    {
       
        $auth =  !empty($matches[1])? $matches[1] : '';
        $token= 'APA91bFLlj-REFznYhBY8mA7yEvMG-asXsjecb9iSMs8lYzpQaifWuh6QLkEazi6WBTAkrcBDNbPv2rHewGhVj_m3e7936w-75f00Ss6wj-t1bUVCbVt6tgi4QrJyP-xvJjb01zXTAhh';

        if($auth == $token)
        {
            if(!empty($post->email) && !empty($post->type))
            {

                // Check email exists
                $conn = new mysqli('localhost', 'sweetbit_webapi', 'IWTSMLRzf?aE', 'sweetbit_webapi');
                $sql = "SELECT * FROM `yvdnsddqu_workout_video_purchases` WHERE `email` = '".$post->email."'";
                $result = $conn->query($sql);
                $count_rows = mysqli_num_rows($result);
                
                $record = mysqli_fetch_assoc($result); 

                $first_name  = !empty($record['first_name'])?$record['first_name']:'';
                $last_name   = !empty($record['last_name'])?$record['last_name']:'';
                $email       = !empty($record['email'])?$record['email']:$post->email;
                $video_id    = !empty($record['workout_video_id'])?$record['workout_video_id']:'8';
                $message     = !empty($record['message'])?$record['message']:'';
                $success_url = 'http://sweetbits.com.au/eatapp/stripe-checkout-session/success.php';
                $cancel_url  = 'http://sweetbits.com.au/eatapp/stripe-checkout-session/failure.php';

                $currency    = !empty($record['currency'])?$record['currency']:'aud';
                $product_name= !empty($record['product_name'])?$record['product_name']:'Lee Priest Video';
                $unit_amount = !empty($post->unit_amount)?$post->unit_amount:$record['unit_amount'];
                $quantity    = !empty($record['quantity'])?$record['quantity']:'1';                

                //include Stripe PHP library
                require_once('stripe-php/init.php');    
                //set stripe secret key
                \Stripe\Stripe::setApiKey(STRIPE_KEY);    
                // Check payment type
                if($post->type == 'fixed'){ // For fixed payment                    
                    //add customer to stripe
                    $session = \Stripe\Checkout\Session::create([
                        'payment_method_types' => ['card'],
                        'line_items' => [[
                            'price_data' => [
                            'currency' => $currency,
                            'product_data' => [
                                'name' => $product_name,
                            ],
                            'unit_amount' => $unit_amount * 100,
                            ],
                            'quantity' => $quantity,
                        ]],
                        'payment_intent_data' => [
                            "metadata" => [
                                'video_id' => $video_id,
                                'first_name' => $first_name,
                                'last_name' => $last_name,
                                'email' => $email,
                                'message' => $message,
                                'product_name' => $product_name,
                                'currency' => $currency,
                                'unit_amount' => $unit_amount,
                                'quantity' => $quantity
                            ]
                            ] ,
                        'mode' => 'payment',
                        'success_url' => $success_url,
                        'cancel_url' => $cancel_url,
                        ]);

                } else if($post->type == 'subscription'){
                    //add customer to stripe
                    $session = \Stripe\Checkout\Session::create([
                        'customer_email' => $email,
                        'payment_method_types' => ['card'],
                        'line_items' => [[
                            'price' => PRICE_KEY,
                            'quantity' => $quantity,
                        ]],
                        'subscription_data' => [
                            "metadata" => [
                                'video_id' => $video_id,
                                'first_name' => $first_name,
                                'last_name' => $last_name,
                                'email' => $email,
                                'message' => $message,
                                'product_name' => $product_name,
                                'currency' => $currency,
                                'unit_amount' => $unit_amount,
                                'quantity' => $quantity       
                            ]
                        ],
                        'mode' => 'subscription',
                        'success_url' => $success_url,
                        'cancel_url' => $cancel_url
                        ]);
                }                

                $session_id = $session->id;
                // Response
                echo json_encode(array('id'=>$session_id));
                exit;                 
            } 
            else 
            {
                echo json_encode(array('error'=>'Pass required parameters'));
                exit;
            }
        }
    }
}



/** 
 * Get header Authorization
 * 
 **/
function getAuthorizationHeader()
{
    $headers = null;
    if (isset($_SERVER['Authorization'])) 
    {
        $headers = trim($_SERVER["Authorization"]);
    }
    else if (isset($_SERVER['HTTP_AUTHORIZATION'])) 
    { //Nginx or fast CGI
        $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
    } elseif (function_exists('apache_request_headers')) 
    {
        $requestHeaders = apache_request_headers();
        // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
        $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
        //print_r($requestHeaders);
        if (isset($requestHeaders['Authorization'])) 
        {
            $headers = trim($requestHeaders['Authorization']);
        }
    }
    return $headers;
}
?>