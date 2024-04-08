<?php

function getAllGroup()
{
    $sql = "SELECT g.id AS groupId, g.name, g.student_numbers, g.teacher,g.status, d.name AS departmentName,d.id AS departmentId, t.name AS termName FROM `departments` AS d INNER JOIN `groups` AS g ON d.id = g.department_id
            INNER JOIN `term` AS t ON  t.id = g.term_id WHERE g.deleted_at IS NULL
    ";
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

function getGroupById($id)
{
    $sql = "SELECT g.id AS groupId, g.name, g.student_numbers, g.teacher,g.status, d.name AS departmentName, d.id AS departmentId, t.name AS termName, t.id AS termID FROM `departments` AS d INNER JOIN `groups` AS g ON d.id = g.department_id
            INNER JOIN `term` AS t ON  t.id = g.term_id WHERE g.id = :id";
    $db = connectionDb();
    $stmt = $db->prepare($sql);
    $data = [];
    if ($stmt) {
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        }
    }


    disconnectDb($db);
    return $data;
}

function insertGroup($name, $slug, $departmentId, $termId, $studentMember, $teacher, $status, $currentDate)
{

    $insertGroup = "INSERT INTO `groups`( `department_id`, `term_id`, `name`, `slug`, `student_numbers`, `teacher`,  `status`, `created_at`) VALUES (:departmentId,:termId,:nameGroup,:slug,:studentMember,:teacher,:statusGroup,:createdAt)";
    $checkInsert = false;

    $db = connectionDb();
    $stmt = $db->prepare($insertGroup);
    $currentDate = date('Y-m-d H:i:s');
    if ($stmt) {
        $stmt->bindParam(':departmentId', $departmentId, PDO::PARAM_INT);
        $stmt->bindParam(':termId', $termId, PDO::PARAM_INT);
        $stmt->bindParam(':nameGroup', $name, PDO::PARAM_STR);
        $stmt->bindParam(':slug', $slug, PDO::PARAM_STR);
        $stmt->bindParam(':studentMember', $studentMember, PDO::PARAM_STR);
        $stmt->bindParam(':teacher', $teacher, PDO::PARAM_STR);
        $stmt->bindParam(':statusGroup', $status, PDO::PARAM_INT);
        $stmt->bindParam(':createdAt', $currentDate, PDO::PARAM_STR);
        if ($stmt->execute()) {
            $checkInsert = true;
        }
    }
    disconnectDb($db); // ngat ket noi toi database
    // tra ve true insert thanh cong va nguoc lai
    return $checkInsert;
}

function updateGroup($name, $slug, $departmentId, $termId, $studentMember, $teacher, $status, $currentDate, $id)
{
    $sql = "UPDATE `groups` SET `department_id`= :departmentId,`term_id`=:termId,`name`=:nameGroup,`slug`=:slug,`student_numbers`=:studentMember,`teacher`=:teacher,`status`=:statusGroup,`updated_at`=:updatedAt  WHERE id = :id AND `deleted_at` IS NULL";
    $checkInsert = false;

    $db = connectionDb();
    $stmt = $db->prepare($sql);
    $currentDate = date('Y-m-d H:i:s');
    if ($stmt) {
        $stmt->bindParam(':departmentId', $departmentId, PDO::PARAM_INT);
        $stmt->bindParam(':termId', $termId, PDO::PARAM_INT);
        $stmt->bindParam(':nameGroup', $name, PDO::PARAM_STR);
        $stmt->bindParam(':slug', $slug, PDO::PARAM_STR);
        $stmt->bindParam(':studentMember', $studentMember, PDO::PARAM_STR);
        $stmt->bindParam(':teacher', $teacher, PDO::PARAM_STR);
        $stmt->bindParam(':statusGroup', $status, PDO::PARAM_INT);
        $stmt->bindParam(':updatedAt', $currentDate, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $checkInsert = true;
        }
    }
    disconnectDb($db); // ngat ket noi toi database
    // tra ve true insert thanh cong va nguoc lai
    return $checkInsert;
}

function deleteGroup($id)
{
    $sql = "UPDATE `groups` SET `deleted_at` = :deleted_at WHERE `id` = :id";
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
