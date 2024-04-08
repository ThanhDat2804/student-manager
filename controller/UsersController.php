<?php
$m = trim($_GET['m'] ?? 'index'); //ham mac dinh trong controller la index
$m = strtolower($m); //viet thuong tat ca ten ham
require 'model/UsersModel.php';
// require 'model/CourseModel.php';
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
    $users = getAllUsers();
    require 'view/users/index_view.php';
}

function Add()
{

    require 'view/users/add_view.php';
}

function handleAdd()
{
    if (isset($_POST['btnAdd'])) {
        $extraCode = $_POST['extraCode'];
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $fullName = $_POST['fullName'];
        $role = $_POST['role'];
        $gender = $_POST['gender'];
        $address = $_POST['address'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $beginningDate = trim($_POST['date_beginning'] ?? null);
        $beginningDate = date('Y-m-d', strtotime($beginningDate));
        if (!empty($_FILES['avt']['tmp_name'])) {
            $user_image = uploadFile($_FILES['avt'], 'public/upload/images/', ['image/png', 'image/jpg', 'image/jpeg'], 5 * 1024 * 1024);


            if (empty($logo)) {
                $_SESSION['error_add_department']['logo'] = 'File only accept extension is .png, .jpg, .jpeg, .gif and file <= 5Mb';
            } else {
                $_SESSION['error_add_department']['logo'] = null;
            }
        }
        $status = $_POST['status'];
        $birthday = $_POST['birthday'];
        $insert = insertUser($extraCode, $role, $fname, $lname, $fullName, $email, $phone, $address, $birthday, $gender, $user_image, null, $status, $beginningDate);
        if ($insert) {
            header("location:index.php?c=users&state=success");
        } else {
            header("location:index.php?c=users&m=add&state=error");
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
    $delete = deleteUser($id);
    if ($delete) {
        //xoa thanh cong
        header("location:index.php?c=users&state_del=success");
    } else {
        //xoa that bai
        header("location:index.php?c=users&state_del=failure");
    }
}
