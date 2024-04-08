<?php
//m = ten cua ham nam trong thu muc controller
$m = trim($_GET['m'] ?? 'index'); //ham mac dinh trong controller la index
$m = strtolower($m); //viet thuong tat ca ten ham
require 'model/AccountsModel.php';
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
function Add()
{

    require 'view/courses/add_view.php';
}

function index()
{
    if (!isLoginUser()) {
        header("location:index.php");
        exit();
    }
    $accounts = getAllAccount();

    require 'view/accounts/index_view.php';
}

function handleDelete()
{
    if (!isLoginUser()) {
        header("location:index.php");
        exit();
    }
    $id = trim($_GET['id'] ?? null);
    $id = is_numeric($id) ? $id : 0;
    $delete = deleteAccountById($id);
    if ($delete) {
        //xoa thanh cong
        header("location:index.php?c=account&state_del=success");
    } else {
        //xoa that bai
        header("location:index.php?c=account&state_del=failure");
    }
}
