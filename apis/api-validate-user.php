<?php
require_once(__DIR__.'/../globals.php');


//  Verify the key (must be 32 characters)
if(!isset($_POST['key'])){
    _res(400, ['info'=> 'mmm... that is strange (key is missing)']);
  
  }
  
  if(strlen($_POST['key']) != 32){
    _res(400, ['info'=> 'mmm... suspicious (key is not 32 characters)']);
  
  }


$db = _api_db();


  try{
    $q = $db->prepare('SELECT verification_key FROM users WHERE verification_key = :verification_key');
    $q->bindValue(':verification_key', $_POST['key']);
    $q->execute();
    $row = $q->fetch();

    if(!$row){
    _res(400, ['info'=> 'key not found,expired']);
    }

  } catch(Exception $ex){
    _res(500, ['info'=>'system under maintainance', 'error'=>__LINE__]);
  }


  try{
    $q = $db->prepare('UPDATE users set verified = :verified where verification_key = :verification_key');
    $q->bindValue(':verified', true);
    $q->bindValue(':verification_key', $_POST['key']);
    $q->execute();

    $row = $q->rowCount();

    if(!$row){
    _res(400, ['info'=> 'failed to update']);
    }
    
    _res(200, ['info'=> 'Verifying email']);
    //require_once(__DIR__ . '/../private/send_sms.php');
  } catch(Exception $ex){
    _res(500, ['info'=>'system under maintainance', 'error'=>__LINE__]);
  }
  


