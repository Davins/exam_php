<?php
session_start();

require_once(__DIR__ . '/../globals.php');

// TODO validate will add for exam


$db = _api_db();
// create a unique ID for each image

$user_id = $_SESSION['user_id'];
try {
   $image_id = uniqid();
   $item_id = bin2hex(random_bytes(16));
   $q = $db->prepare('INSERT INTO items VALUES(:item_id, :item_name, :item_desc, :item_price, :item_owner, :user_id, :item_image)');
   $q->bindValue(':item_id', $item_id);
   $q->bindValue(':item_name', $_POST['item_name']);
   $q->bindValue(':item_desc', $_POST['item_desc']);
   $q->bindValue(':item_price', $_POST['item_price']);
   $q->bindValue(':item_owner', $user_id);
   $q->bindValue(':user_id', $user_id);
   $q->bindValue(':item_image', $image_id);

   $q->execute();

   // move files to item-images folder on upload
   file_put_contents($_FILES['item_img']['tmp_name'], __DIR__ . '/../item-images/' . $image_id);
   // Success
   _res(200, ['info' => 'item created']);

} catch (Exception $ex) {
   _res(500, ['info' => 'System under maintenance']);
}
