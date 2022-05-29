<?php
require_once('globals.php');

if (!isset($_POST['to_phone'])) {_res(400, ['info' => 'number required']);}
if (strlen($_POST['to_phone']) != 8) {_res(400, ['info' => 'number must be 8 digits']);}
if (!isset($_POST['message'])) {_res(400, ['info' => 'can not send empty sms']);}
if (strlen($_POST['message']) < 2) {_res(400, ['info' => 'message must be at least 2 characters']);}
if (strlen($_POST['message']) > 30) {_res(400, ['info' => 'message can be a maximum of 30 characters']);}

try {
    $post_request = array(
        'to_phone' => $_POST['to_phone'],
        'message' => $_POST['message'],
        'api_key' => 'b1167dc3-157c-4371-af28-a15159edb465',
        'user_id' => 'a1056400-1605-4eb0-8457-c6cb808e10b1'
    ); 
    $cURLConnection = curl_init('https://fatsms.com/send-sms');
    curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, $post_request);
    curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
    $apiResponse = curl_exec($cURLConnection);
    curl_close($cURLConnection);
    $jsonArrayResponse = json_decode($apiResponse);
    header('Content-Type: application/json');


} catch (Exception $ex) {
    http_response_code(500);
    echo 'Try again please';
    exit();
}

_res(200, ['info' => 'sms sent']);