<?php
class Push_Notification
{
    public function __construct()
    {
    }

    public function sendPushNotification($message = '', $title='', $web_url = '', $notification_id = '', $deviceInfo_array = array(), $page_url = '')
    {       
        //$token is the array of devices latest tokens
        $result_array = array();
        $success_count = 0;
        $failure_count = 0;
        $deviceid_array = array();
        $android_array = array();
        $ios_array     = array();
        /*
        * Check devices and make seratrate user_token arrays for Android & IOS
        */
        if (!empty($deviceInfo_array)) {
            foreach ($deviceInfo_array as $key_Info => $value_info) {
                if (!empty($value_info)) {
                    $record_info = json_decode($value_info['deviceInfo'], true);    
                    
                    if ($record_info['platform'] == 'iOS' || $record_info['platform'] == 'IOS' || $record_info['platform'] == 'ios') {
                        /*
                        * Created token array of IOS devices
                        */
                        $ios_array[] = !empty($value_info['deviceid'])? $value_info['deviceid']: ''; 
                    } else {
                            /*
                            * Created token array of android devices
                            */
                            $android_array[] = !empty($value_info['deviceid'])? $value_info['deviceid']: ''; 
                    }                    
                }
            }
            /*
            * Send notifications to Android Array
            */
            if (!empty($android_array)) {
                $fields = array(
                    'registration_ids' => $android_array,
                    'priority' => "high",
                    'notification'=>
                            array(
                                'title' => $title,
                                'body' =>  $message ,
                                'sound'=>'Default',
                                'image'=>'',
                                "icon"=>"fcm_push_icon",
                                'page_url' =>$page_url,
                                'web_url'=> $web_url,
                                'notification_id'=> $notification_id
                        )
                );
                $result_json = $this->callCustomFunction($fields);
                $result = json_decode($result_json, true);
                if ($result['success'] >= 1) {
                    $success_count = $success_count + 1;
                } elseif ($result['failure'] >= 1) {
                    $failure_count = $failure_count + 1;
                }
            }
            /*
            * Send notifications to IOS Array
            */
            if (!empty($ios_array)) {
                $fields = array(
                    'registration_ids' => $ios_array,
                    'priority' => "high",
                    'notification' => array(
                        'title' => $title,
                        'body' =>  $message ,
                        'sound'=>'Default',
                        'image'=>'',
                        "icon"=>"fcm_push_icon"
                    ),
                    'data'=>
                            array(
                                'page_url' =>$page_url,
                                'web_url'=> $web_url,
                                'notification_id'=> $notification_id
                        )
                );
                $result_json = $this->callCustomFunction($fields);
                $result = json_decode($result_json, true);
                if ($result['success'] >= 1) {
                    $success_count = $success_count + 1;
                } elseif ($result['failure'] >= 1) {
                    $failure_count = $failure_count + 1;
                }
            }
        }

        $result_array = json_encode(array("success"=> $success_count, "failure"=> $failure_count));
        return $result_array;
    }       

    public function callCustomFunction($fields = null)
    {
        $path_to_firebase_cm = 'https://fcm.googleapis.com/fcm/send';
        $headers = array(
            'Authorization:key=' . FCM_API_KEY,
            'Content-Type:application/json'
        );
        //log_message('debug', print_r($fields, true));
        // Open connection
        $ch = curl_init();
        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $path_to_firebase_cm);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        // Execute post
        $result = curl_exec($ch);
        // echo '\n=====callCustomFunction=====<pre>';
        // echo 'headers<pre>';
        // print_r($headers);
        // echo 'fields<pre>';
        // print_r($fields);
        // echo 'result<pre>';
        // print_r($result);
        // exit;
        // Close connection
        curl_close($ch);
        return $result;
    }
}
