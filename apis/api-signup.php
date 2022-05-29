<?php
require_once(__DIR__."/../globals.php");

// Validate First name
if (!isset($_POST['user_name'])) {
  _res(400, ['info' => 'Name required']);
}
if (strlen($_POST['user_name']) < 2) {
  _res(400, ['info' => 'Your first name has to be at least 2 characters.']);
}
if (strlen($_POST['user_name']) > 16) {
  _res(400, ['info' => 'Your first name has to be a maximum of 16 characters.']);
}

// Validate Last name
if (!isset($_POST['user_last_name'])) {
  _res(400, ['info' => 'Lastname required']);
}
if (strlen($_POST['user_last_name']) < 2) {
  _res(400, ['info' => 'last name is too short']);
}
if (strlen($_POST['user_last_name']) > 20) {
  _res(400, ['info' => 'last name is too long']);
}

// Validate email
if (!isset($_POST['user_email'])) {
  _res(400, ['info' => 'Email required.']);
}
if (!filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)) {
  _res(400, ['info' => 'Email invalid.']);
}

// Validate phone number
if (!isset($_POST['user_phone'])) {
  _res(400, ['info' => 'Phone number required.']);
}
//if (strlen($_POST['user_phone'] != 8)) {
//  _res(400, ['info' => 'Number must be 8 digits.']);
//}

// Validate password
if (!isset($_POST['password'])) {
  _res(400, ['info' => 'Password required']);
}
if (strlen($_POST['password']) < _PASSWORD_MIN_LEN) {
  _res(400, ['info' => 'Password needs to be at least 8 characters.']);
}
if (strlen($_POST['password']) > _PASSWORD_MAX_LEN) {
  _res(400, ['info' => 'Password can only be a maximum of 30 characters.']);
}

// Hash password, set the verification and recovery keys to random bin2hex and set verified to 0
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$verification_key = bin2hex(random_bytes(16));
$recovery_key = bin2hex(random_bytes(16));
$verified = 0;

$db = _api_db();

// prepare the sequel statement to get check if email is already in the database
try {

  $q = $db->prepare('SELECT user_email FROM users WHERE user_email = :user_email');
  $q->bindValue(':user_email', $_POST['user_email']);
  $q->execute();
  $row = $q->fetch();

  if ($row) {
      // if email is already in use, send 400
      _res(400, ['info' => 'Email already exists']);
  }
} catch (Exception $ex) {

  // If something is wrong with the API, send 500
  _res(500, ['info' => 'system under maintainance']);
}


// prepare sequel statement to insert the values in to the users table in the DB
try {

  $q = $db->prepare('INSERT INTO users (user_name, user_last_name, user_email, user_phone, user_password, verified, verification_key, recovery_key) 
  VALUES(:user_name, :user_last_name, :user_email, :user_phone, :user_password, :verified, :verification_key, :recovery_key)');
  $q->bindValue(':user_name', $_POST['user_name']);
  $q->bindValue(':user_last_name', $_POST['user_last_name']);
  $q->bindValue(':user_email', $_POST['user_email']);
  $q->bindValue(':user_phone', $_POST['user_phone']);
  $q->bindValue(':user_password', $password);
  $q->bindValue(':verified', $verified);
  $q->bindValue(':verification_key', $verification_key);
  $q->bindValue(':recovery_key', $recovery_key);

  $q->execute();

  $user_id = $db->lastInsertId();
  if (!$user_id) {

      // If something is wrong with the API, send 500
      _res(500, ['info' => 'something went wrong']);
  }


  // send email upon signing up successfully
  $name = $_POST['user_name'];
  $_to_email = 'webdevdd95@gmail.com';
  $_message = "Thank you for signing up, <a href=http://localhost/validate-user.php?key=$verification_key>Click here for e-mail validation.</a>";
  require_once(__DIR__ ."/../private/send_email.php");
  _res(200, ['info' => 'user created', 'user_id' => intval($user_id)]);
} catch (Exception $ex) {

  // If something is wrong with the API, send 500
  _res(500, ['info' => json_encode($ex)]);
};





