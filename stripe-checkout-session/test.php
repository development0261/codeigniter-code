<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Authorization, token, Content-Type');

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
            $first_name  = !empty($post->first_name)?$post->first_name:'';
            $last_name   = !empty($post->last_name)?$post->last_name:'';
            $email       = !empty($post->email)?$post->email:'';
            $video_id    = !empty($post->video_id)?$post->video_id:'';
            $message     = !empty($post->message)?$post->message:'';
            $success_url = !empty($post->success_url)?$post->success_url:'';
            $cancel_url  = !empty($post->cancel_url)?$post->cancel_url:'';

            $currency    = !empty($post->currency)?$post->currency:'aud';
            $product_name= !empty($post->product_name)?$post->product_name:'';
            $unit_amount = !empty($post->unit_amount)?$post->unit_amount:'';
            $quantity    = !empty($post->quantity)?$post->quantity:'';

            //include Stripe PHP library
            require_once('stripe-php/init.php');    
            //set stripe secret key
            \Stripe\Stripe::setApiKey('sk_test_51GxRVFJpxyLWDkuo0rVAU4nxTR0eyPLidiQ92igKB3MsUuK2R5uhEbH2LEGIszV7sTLrGDNWLyt8yNDlufBioYNG00A3K8ZAuY');    

            //add customer to stripe
            $pricedata = \Stripe\Price::create([
                'unit_amount' =>  $unit_amount * 100,
                'currency' => 'aud',
                'recurring' => ['interval' => 'month'],
                'product' => 'prod_Je9gtDCgC2hlZ3',
            ]);

            //add customer to stripe
            $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price' => $pricedata->id,
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

            $session_id = $session->id;
        }
    }
}
// Response
echo json_encode(array('id'=>$session_id));
exit;


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