<?php
session_start();
require_once(__DIR__ . '/../globals.php');
// TODO Validate Will add for exam




$db = _api_db();


if ($_FILES['item_image']['error']) {
    // header('Location: /profile');
    echo $_FILES['item_image']['error'];
    exit();
}

// create a unique ID for each image
$_FILES['item_image']['fileExt'] = mime_content_type($_FILES['item_image']['tmp_name']);
$_FILES['item_image']['fileExt'] = explode('/', $_FILES['item_image']['fileExt']);
$_FILES['item_image']['fileExt'] = strtolower(end($_FILES['item_image']['fileExt']));
$_FILES['item_image']['allowed'] = array('jpg', 'jpeg', 'png', 'gif');

if (!in_array($_FILES['item_image']['fileExt'], $_FILES['item_image']['allowed'])) {
    _res(500, ['info' => 'Incorrect file extension.']);
}

try {
    if (file_exists($_FILES['item-image-edit']['tmp_name'])) {

        $image_id = uniqid();
    } else {
        $image_id = $_POST['item-image'];
    }





    $db->beginTransaction();
    $q = $db->prepare('UPDATE items SET item_name = :item_name, item_desc = :item_desc, item_price = :item_price, item_image = :item_image WHERE item_id = :item_id');
    $q->bindValue(':item_id', $_POST['item_id']);
    $q->bindValue(':item_name', $_POST['item-name-edit']);
    $q->bindValue(':item_desc', $_POST['item-desc-edit']);
    $q->bindValue(':item_price', $_POST['item-price-edit']);
    $q->bindValue(':item_image', $image_id);
    $q->execute();
    $db->commit();
    if (file_exists($_FILES['item-image-edit']['tmp_name'])) {
        $destination = $_SERVER['DOCUMENT_ROOT'] . '/item-images';

        chmod($destination, 0755); //Change the file permissions if allowed

        $_FILES['item_image']['name'] = $image_id . "." . $_FILES['item_image']['fileExt'];
        $FileDestination = "$destination" . "/" . $_FILES['item_image']['name'];
        // move files to item-images folder on upload
        move_uploaded_file($_FILES['item_image']['tmp_name'], $FileDestination);
    }







    _res(200, ['info' => 'items updated']);
} catch (Exception $ex) {
    $db->rollback();
    _res(500, ['info' => $ex]);
};
