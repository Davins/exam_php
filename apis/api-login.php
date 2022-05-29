<?php
require_once(__DIR__."/../globals.php");
$body = file_get_contents('php://input');
$data = json_decode($body, true);
$_POST = $data;


if (!isset($_POST['user_email'])) {
    _res(400, ['info' => 'email required']);
}
if (!filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)) {
    _res(400, ['info' => 'email not valid']);
}
if (!isset($_POST['password'])) {
    _res(400, ['info' => 'password required']);
    
}
if (strlen($_POST['password']) < 8) {
    _res(400, ['info' => 'password must be at least 8 characters']);
}
    
if (strlen($_POST['password']) > 30) {
    _res(400, ['info' => 'password can be maximum of 30 characters']);
    
}

$db = _api_db();
try {
    $q = $db->prepare('SELECT * FROM users WHERE user_email = :user_email');
    $q->bindValue(':user_email', $_POST['user_email']);
    $q->execute();
    $user = $q->fetch();
    if (!$user) {
        _res(400, ['info' => 'Not a user']);
    }
    $pwdCheck = password_verify($_POST['password'], $user['user_password']);
    if ($pwdCheck == false) {
        _res(401, ['info' => 'unauthorized']);
    } else {
        session_start();
       session_regenerate_id();
        $_SESSION['user_name'] = $user['user_name'];
        $_SESSION['user_last_name'] = $user['user_last_name'];
        $_SESSION['user_email'] = $user['user_email'];
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['user_phone'] = $user['user_phone'];
        session_write_close();
        //header("Location: profile");
        //echo $user['user_name'];
        //_res(200, ['info' => 'does this work?', 'status' => 200]);
        echo json_encode(array('status' => 200));
        http_response_code(200);
        exit();
    }
} catch (Exception $ex) {
    _res(500, ['info' => 'Not a user']);
}