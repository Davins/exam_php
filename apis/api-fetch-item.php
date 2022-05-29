<?php

// Start the session
session_start();

// Require the global configuration
require_once(__DIR__.'/../globals.php');

// Connect to the DB
$db = _api_db();

// Prepare the Read statement and fetch a single item
try {
    $q = $db->prepare('SELECT * FROM items WHERE item_id = :item_id');
    $q->bindValue(':item_id', $_POST['item_id']);
    $q->execute();
    $row = $q->fetch();
    header('Content-Type: application/json');
    
    // Send the fetched content back json_encoded
    echo json_encode($row);
  
} catch (Exception $ex) {

    // If something is wrong with the API, send 500
    _res(500, ['info' => 'system under maintainance']);
}