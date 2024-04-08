<?php
require "database/database.php";

function getAllUsers()
{
    $sql = "SELECT u.id AS userId ,u.extra_code , u.full_name, u.email,u.address, u.avatar, u.birthday, r.name AS roleName FROM users as u  INNER JOIN roles as r ON r.id=u.role_id WHERE u.deleted_at IS NULL ";
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

function insertUser($code, $roleId, $firstName, $lastName, $fullName, $email, $phone, $address, $birthday, $gender, $avatar, $infor, $status, $currentDate)
{
    $sql = "INSERT INTO `users`( `extra_code`, `role_id`, `first_name`, `last_name`, `full_name`, `email`, `phone`, `address`, `birthday`, `gender`, `avatar`, `information`, `status`, `created_at`) VALUES (:code,:roleID,:firstName,:lastName,:fullName,:email,:phone,:addressUser,:birthday,:gender,:avatar,:infor,:statusUser,:createdAt)";
    $db = connectionDb();
    $stmt = $db->prepare($sql);
    $currentDate = date('Y-m-d H:i:s');
    if ($stmt) {
        $stmt->bindParam(':code', $code, PDO::PARAM_STR);
        $stmt->bindParam(':roleID', $roleId, PDO::PARAM_INT);
        $stmt->bindParam(':firstName', $firstName, PDO::PARAM_STR);
        $stmt->bindParam(':lastName', $lastName, PDO::PARAM_STR);
        $stmt->bindParam(':fullName', $fullName, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
        $stmt->bindParam(':addressUser', $address, PDO::PARAM_STR);
        $stmt->bindParam(':birthday', $birthday, PDO::PARAM_STR);
        $stmt->bindParam(':gender', $gender, PDO::PARAM_STR);
        $stmt->bindParam(':avatar', $avatar, PDO::PARAM_STR);
        $stmt->bindParam(':infor', $infor, PDO::PARAM_STR);
        $stmt->bindParam(':statusUser', $status, PDO::PARAM_INT);
        $stmt->bindParam(':createdAt', $currentDate, PDO::PARAM_STR);
        if ($stmt->execute()) {
            $checkInsert = true;
        }
    }
    disconnectDb($db); // ngat ket noi toi database
    // tra ve true insert thanh cong va nguoc lai
    return $checkInsert;
}

function deleteUser($id = 0)
{
    $sql = "UPDATE `users` SET `deleted_at` = :deleted_at WHERE `id` = :id";
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
