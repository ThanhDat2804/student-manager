<?php
//m = ten cua ham nam trong thu muc controller
$m = trim($_GET['m'] ?? 'index'); //ham mac dinh trong controller la index
$m = strtolower($m); //viet thuong tat ca ten ham
require 'model/DepartmentModel.php';
require 'model/CourseModel.php';
switch ($m) {
    case 'index':
        index();
        break;
    case 'add':
        Add();
        break;
    case 'handle-add':
        handleAdd();
        break;
    case 'edit':
        edit();
        break;
    case 'handle-edit':
        handleEdit();
        break;
    case 'delete':
        handleDelete();
        break;
    default:
        index();
        break;
}
function index()
{
    if (!isLoginUser()) {
        header("location:index.php");
        exit();
    }
    $courses = getAllDataCourse();

    require 'view/courses/index_view.php';
}
function Add()
{
    $departments = getAllDataDepartments();
    require 'view/courses/add_view.php';
}

function handleAdd()
{
    if (isset($_POST['btnSave'])) {
        $name = $_POST['name'];
        $department_id = $_POST['department_id'];
        $status = $_POST['status'];
        $_SESSION['error_add_course'] = [];
        if (empty($name)) {
            $_SESSION['error_add_course']['name'] = 'Enter name of course,please';
        } else {
            $_SESSION['error_add_course']['name'] = null;
        }
        if (empty($department_id)) {
            $_SESSION['error_add_course']['department'] = 'Choose department, please';
        } else {
            $_SESSION['error_add_course']['department'] = null;
        }
        $flagCheckingError = false;
        foreach ($_SESSION['error_add_course'] as $error) {
            if (!empty($error)) {
                $flagCheckingError = true;
                break;
            }
        }
        if (!$flagCheckingError) {
            $createdAt = trim($_POST['date_beginning'] ?? null);
            $createdAt = date('Y-m-d', strtotime($createdAt));
            $slug = slug_string($name);
            $insert = insertCourse($name, $slug, $department_id, $status, $createdAt);
            if ($insert) {
                header("location:index.php?c=courses&state=success");
            } else {
                header("location:index.php?c=courses&m=add&state=error");
            }
        } else {
            //thong bao loi cho nguoi dung biet 
            header("location:index.php?c=courses&m=add&state=fail");
        }
    }
}
function edit()
{
    if (!isLoginUser()) {
        header("location:index.php");
        exit();
    }
    $id = trim($_GET['id'] ?? null);
    $id = is_numeric($id) ? $id : 0;
    $info = getDetailCourseById($id);
    $departments = getAllDataDepartments();


    if (!empty($info)) {
        require 'view/courses/edit_view.php';
    } else {
        require 'view/error_view.php';
    }
}
function handleEdit()
{
    if (isset($_POST['btnUpdate'])) {
        $name = $_POST['name'];
        $department_id = $_POST['department_id'];
        $status = $_POST['status'];
        $id = trim($_GET['id']);
        $id = is_numeric($id) ? $id : 0;
        $createdAt = trim($_POST['date_beginning'] ?? null);
        $createdAt = date('Y-m-d', strtotime($createdAt));
        $slug = slug_string($name);
        $updatedAt = trim($_POST['date_beginning'] ?? null);
        $updatedAt = date('Y-m-d', strtotime($updatedAt));
        $slug = slug_string($name);
        $info = getDetailCourseById($id);
        if (empty($name)) {
            $_SESSION['error_add_course']['name'] = 'Enter name of course,please';
        } else {
            $_SESSION['error_add_course']['name'] = null;
        }
        if (empty($department_id)) {
            $_SESSION['error_add_course']['department'] = 'Choose department, please';
        } else {
            $_SESSION['error_add_course']['department'] = null;
        }

        $flagCheckingError = false;
        foreach ($_SESSION['error_add_course'] as $error) {
            if (!empty($error)) {
                $flagCheckingError = true;
                break;
            }
        }
        if (!$flagCheckingError) {

            $update = updateCourseById($name, $slug, $department_id, $status, $id);
            if ($update) {
                header("location:index.php?c=courses&state=success");
            } else {
                header("location:index.php?c=courses&m=edit&id=$id&state=error");
            }
        } else {
            //thong bao loi cho nguoi dung biet 
            header("location:index.php?c=courses&m=edit&id=$id&state=fail");
        }
    }
}
function handleDelete()
{
    if (!isLoginUser()) {
        header("location:index.php");
        exit();
    }
    $id = trim($_GET['id'] ?? null);
    $id = is_numeric($id) ? $id : 0;
    $delete = deleteCourseById($id);
    if ($delete) {
        //xoa thanh cong
        header("location:index.php?c=courses&state_del=success");
    } else {
        //xoa that bai
        header("location:index.php?c=courses&state_del=failure");
    }
}
