<?php
require "database/database.php";
function getAllAccount()
{



    $sql = "SELECT a.acc_id as account_id, u.full_name as fullname,  a.username as username , r.name, a.password  FROM users as u INNER JOIN accounts as a ON a.user_id = u.id INNER JOIN roles as r ON r.id=a.role_id WHERE a.deleted_at IS NULL ";
    $db = connectionDb();
    $stmt = $db->prepare($sql);
    $data = [];
    if ($stmt) {
        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        }
    }


    disconnectDb($db);
    return $data;
}

function deleteAccountById($id = 0)
{
    $sql = "UPDATE `accounts` SET `deleted_at` = :deleted_at WHERE `acc_id` = :id";
    $db = connectionDb();
    $checkDelete = false;
    $deleteTime = date("Y-m-d H:i:s");
    $stmt = $db->prepare($sql);
    if ($stmt) {
        $stmt->bindParam(':deleted_at', $deleteTime, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $checkDelete = true;
        }
    }
    disconnectDb($db);
    return $checkDelete;
}
