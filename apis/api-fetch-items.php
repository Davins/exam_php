<?php

// Start the session
session_start();

// Require the global configuration
require_once(__DIR__.'/../globals.php');

// Connect to the DB
$db = _api_db();

// Prepare the Read statement and fetch all items
try {
    $q = $db->prepare('SELECT * FROM items WHERE user_id = :user_id');
    $q->bindValue(':user_id', $_POST['user_id']);
    $q->execute();
    $row = $q->fetchAll();
    header('Content-Type: application/json');
    
    // Send the fetched content back json_encoded
    echo json_encode($row);
  
} catch (Exception $ex) {

    // If something is wrong with the API, send 500
    _res(500, ['info' => 'system under maintainance']);
}