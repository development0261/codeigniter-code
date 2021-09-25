<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
 
class Stripe_lib{ 
    var $CI; 
    var $api_error; 
     
    function __construct(){ 
        $this->api_error = ''; 
        $this->CI =& get_instance(); 

        // Include the Stripe PHP bindings library 
        require APPPATH .'third_party/stripe-php/init.php'; 
        
        // Set API key 
        \Stripe\Stripe::setApiKey(STRIPE_PRIVATE_KEY); 
    } 
 
    function addCustomer($email, $token, $name){ 
        try { 
            // Add customer to stripe 
            $customer = \Stripe\Customer::create(array( 
                'email' => $email, 
                'source'  => $token,
                'name' => $name,
                'address' => [
                    'line1'       => 'Brisbane',
                    'postal_code' => '2900',
                    'city'        => 'Nambour',
                    'state'       => 'Queensland',
                    'country'     => 'AU',                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  
                ], 
            )); 
            return $customer; 
        }catch(Exception $e) { 
            $this->api_error = $e->getMessage(); 
            return false; 
        } 
    } 
     
    function createCharge($customerId, $itemName, $itemPrice, $orderID, $token){ 
        // Convert price to cents 
        $itemPriceCents = ($itemPrice*100); 
        $currency = 'aud'; 
         
        try { 
            // Charge a credit or a debit card 
            $charge = \Stripe\Charge::create(array( 
                'customer' => $customerId, 
                'amount'   => $itemPriceCents, 
                'currency' => $currency, 
                'description' => $itemName, 
                'metadata' => array( 
                    'order_id' => $orderID 
                ) 
            )); 
             
            // Retrieve charge details 
            $chargeJson = $charge->jsonSerialize(); 
            echo 'AA<pre>';
            print_r($chargeJson);
            exit;
            return $chargeJson; 
        }catch(Exception $e) { 
            // echo 'AA<pre>';
            // print_r($e->getMessage());
            // exit;
            $this->api_error = $e->getMessage(); 
            return false; 
        } 
    } 

    function refund($charge = NULL){ 
        try {            
            // Set API key 
            \Stripe\Stripe::setApiKey(STRIPE_PRIVATE_KEY); 
            
              $refund = \Stripe\Refund::create([ 
                'charge' => $charge,
              ]);             
               
            return $refund; 
        } catch(Exception $e) { 
            $this->api_error = $e->getMessage(); 
            return false; 
        } 
    } 
}