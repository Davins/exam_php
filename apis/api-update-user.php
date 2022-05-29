<?php
require_once(__DIR__ ."/../globals.php");

if (!isset($_POST['user_name'])) {
    _res(400, ['info' => 'Name required']);
}


if (strlen($_POST['user_name']) < 2) {
    _res(400, ['info' => 'name is too short']);
}
if (strlen($_POST['user_name']) > 20) {
    _res(400, ['info' => 'name too long']);
}
// last name validation
if (!isset($_POST['user_last_name'])) {
    _res(400, ['info' => 'Lastname required']);
}
if (strlen($_POST['user_last_name']) < 2) {
    _res(400, ['info' => 'last name is too short']);
}
if (strlen($_POST['user_last_name']) > 20) {
    _res(400, ['info' => 'last name is too long']);
}

// email validation
if (!isset($_POST['user_email'])) {
    _res(400, ['info' => 'Email required']);
}
if (!filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)) {
    _res(400, ['info' => 'Email is not valid']);
}


$db = _api_db();

try {

    $q = $db->prepare('UPDATE users SET user_name = :user_name, user_last_name = :user_last_name, user_email = :user_email, user_phone = :user_phone WHERE user_id = :user_id');
    $q->bindValue(':user_id', $_SESSION['user_id']);
    $q->bindValue(':user_name', $_POST['user_name']);
    $q->bindValue(':user_last_name', $_POST['user_last_name']);
    $q->bindValue(':user_email', $_POST['user_email']);
    $q->bindValue(':user_phone', $_POST['user_phone']);
    $q->execute();
    session_start();
    $_SESSION['user_name'] = $_POST['user_name'];
    $_SESSION['user_last_name'] = $_POST['user_last_name'];
    $_SESSION['user_email'] = $_POST['user_email'];
    $_SESSION['user_phone'] = $_POST['user_phone'];
   
    

    _res(200, ['info'=> 'information updated']);
} catch (Exception $ex) {

    _res(500, ['info' => 'system under maintenance']);
};
