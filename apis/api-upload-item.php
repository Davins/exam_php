<?php
session_start();

require_once(__DIR__ . '/../globals.php');

// TODO validate will add for exam
// if(!isset($_POST['submit'])){
//    header('Location: /profile');
//    exit();
// }

// echo json_encode($_FILES['item_image']);


$db = _api_db();

print_r($_POST);

try {
   // Undefined | Multiple Files | $_FILES Corruption Attack
   // If this request falls under any of them, treat it invalid.
   if (
       !isset($_FILES['item_image']['error']) ||
       is_array($_FILES['item_image']['error'])
   ) {
       throw new RuntimeException('Invalid parameters.');
   }
} catch (RuntimeException $e) {
   echo "error echo", $e->getMessage();
}

if (file_exists($_FILES['item_image']['tmp_name'])) {

   $image_id = uniqid();
} else {
   $image_id = $_POST['item-image'];
}


if(!isset($_FILES['item_image'])){
   echo "no image";
   exit();
}

if($_FILES['item_image']['error']){
   // header('Location: /profile');
   echo $_FILES['item_image']['error'];
   exit();
}

// create a unique ID for each image
$_FILES['item_image']['fileExt'] = mime_content_type($_FILES['File']['tmp_name']);
$_FILES['item_image']['fileExt'] = explode('/', $_FILES['File']['fileExt']);
$_FILES['item_image']['fileExt'] = strtolower(end($_FILES['File']['fileExt']));
$_FILES['item_image']['allowed'] = array('jpg', 'jpeg', 'png', 'gif');

if(!in_array($_FILES['item_image']['fileExt'], $_FILES['item_image']['allowed'])){
   _res(500, ['info' => 'Incorrect file extension.']);
}



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

   $destination = $_SERVER['DOCUMENT_ROOT'].'/item-images';

   chmod($destination,0755); //Change the file permissions if allowed

   $_FILES['item_image']['name'] = $image_id.".".$_FILES['item_image']['fileExt'];
   $FileDestination = "$destination"."/".$_FILES['File']['name'];
   // move files to item-images folder on upload
   move_uploaded_file($_FILES['item_image']['tmp_name'], $FileDestination);
   // Success
   _res(200, ['info' => 'item created']);

} catch (Exception $ex) {
   _res(500, ['info' => 'System under maintenance']);
}
