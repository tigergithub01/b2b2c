<?php

$data = $GLOBALS['HTTP_RAW_POST_DATA'];
//var_dump($data);

//$data = file_get_contents("php://input"); //接收post数据


/*
$log = fopen("nofity_log.txt", "w") or die("Unable to open file!");
fwrite($log,'['.date('Y-m-d H:i:s').']');
fwrite($log, $data);
fclose($log);
*/

file_put_contents("notify_log.txt", '['.date('Y-m-d H:i:s').']', FILE_APPEND);
file_put_contents("notify_log.txt", PHP_EOL, FILE_APPEND);
file_put_contents("notify_log.txt", $data, FILE_APPEND);
file_put_contents("notify_log.txt", PHP_EOL, FILE_APPEND);

// var_dump($data);

//$xml = simplexml_load_string($file_in);//转换post数据为simplexml对象


$notify_url = 'http://'.$_SERVER['HTTP_HOST'].'/index.php?r=/sale/wxpay-sdk/notify';
// create a new curl resource
$ch = curl_init();
// set URL and other appropriate options
curl_setopt($ch, CURLOPT_URL,$notify_url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
// grab URL, and print
curl_exec($ch);
curl_close($ch);

exit();