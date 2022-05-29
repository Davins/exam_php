<?php
//demonstrate global variables
define('_PASSWORD_MIN_LEN', 8);
define('_PASSWORD_MAX_LEN', 30);

//response message with json
function _res($status, $message = [])
{
  http_response_code($status);
  header('Content-Type: application/json');
  echo json_encode($message);
  exit();
}

// db connection
function _api_db(){
  try{
    $database_user_name = 'root';
    $database_password = '';
    $database_connection = 'mysql:host=localhost; dbname=exam; charset=utf8mb4';
    
    $database_options = [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      // PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ];
    return new PDO( $database_connection, $database_user_name, $database_password, $database_options ); 
  }catch(Exception $ex){
    http_response_code(500);
    echo "System under maintainance";
  }
}











