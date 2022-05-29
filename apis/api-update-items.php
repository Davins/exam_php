<?php
session_start();
require_once(__DIR__ . '/../globals.php');
// TODO Validate Will add for exam




$db = _api_db();

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
        move_uploaded_file($_FILES['item-image-edit']['tmp_name'], __DIR__ . '/../item-images/' . $image_id);
    }







    _res(200, ['info' => 'items updated']);
} catch (Exception $ex) {
    $db->rollback();
    _res(500, ['info' => $ex]);
};
