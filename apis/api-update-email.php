<?php
require_once(__DIR__ ."/../globals.php");


  
  // Validate the input password
  if (!isset($_POST['password'])) {
    _res(400, ['info' => 'password required']);
  }
  if (strlen($_POST['password']) < _PASSWORD_MIN_LEN) {
    _res(400, ['info' => 'password min ' . _PASSWORD_MIN_LEN . ' characters']);
  }
  if (strlen($_POST['password']) > _PASSWORD_MAX_LEN) {
    _res(400, ['info' => 'password max ' . _PASSWORD_MAX_LEN . ' characters']);
  }


$db = _api_db();

try {
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $q = $db->prepare('UPDATE users SET user_password = :user_password WHERE recovery_key = :recovery_key');
    $q->bindValue(':user_password', $password);
    $q->bindValue(':recovery_key', $_POST['recovery_key']);
    
    $q->execute();
  
  
   
    

    _res(200, ['info'=> 'information updated']);
} catch (Exception $ex) {

    _res(500, ['info' => 'system under maintenance']);
};
