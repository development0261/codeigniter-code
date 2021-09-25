<?php

$ch = curl_init();
$url = 'http://localhost/spotneat-web/cron/check_reserve_time';
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
$store = curl_exec($ch);
if($store === false) {
    echo "Curl failed with error: ", curl_error($ch);
}else{
	echo "Curl executed successfully! Report sent to all the active users.";	
}
curl_close($ch);

?>