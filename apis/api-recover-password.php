<?php

// Require the global configuration
require_once(__DIR__ . '/../globals.php');

$db = _api_db();

// Prepare query statement to fetch the user's email
try {

$q = $db->prepare('SELECT * FROM users WHERE user_email = :user_email');
$q->bindValue(':user_email', $_POST['user_email']);
$q->execute();
$row = $q->fetch();


// validate that the email exists
if(!$row){
    _res(400, ['info' => 'Email does not exists']);
}


// grab the recoverykey from earlier fetch
$recovery_key = $row['recovery_key'];

// Email recipient
$_to_email = $_POST['user_email'];

// Template message to recover password
$_message = "Hello, forgot the password?  <a href=http://localhost/new-password.php?key=$recovery_key>Click here to create a new one. </a>";
require_once(__DIR__.'/../private/send_email.php');

// Succesful email sent
_res(200, ['info' => 'email has been sent']);




}catch(Exception $ex){

      // If something is wrong with the API, send 500
    _res(500, ['info' => 'system under maintainance']);
}
