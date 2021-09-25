<?php
	$myfile = fopen("webhook_response.txt", "w") or die("Unable to open file!");
	fwrite($myfile, '======== Razor pay webhook ========='.date('Y-m-d'));
	fwrite($myfile, print_r($_POST, true));
	fclose($myfile);
	
?>