<?php
$m = trim($_GET['m'] ?? 'index'); //ham mac dinh trong controller la index
$m = strtolower($m); //viet thuong tat ca ten ham
require 'model/DepartmentModel.php';
require 'model/termModel.php';

require 'model/GroupModel.php';
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
    $group = getAllGroup();
    require 'view/group/index_view.php';
}

function Add()
{
    $term = getAllTerm();
    $departments = getAllDataDepartments();
    require 'view/group/add_view.php';
}

function handleAdd()
{
    if (isset($_POST['btnSave'])) {
        $name = $_POST['name'];

        $department_id = $_POST['department_id'];
        $term_id = $_POST['term_id'];
        $status = $_POST['status'];
        $studentMember = $_POST['studentMember'];
        $teacher = $_POST['teacher'];
        $currentDate = date('Y-m-d H:i:s');
        $slug = slug_string($name);
    }
    $group = insertGroup($name, $slug, $department_id, $term_id, $studentMember, $teacher, $status, $currentDate);
    if ($group) {
        header("location:index.php?c=group&state=success");
    } else {
        header("location:index.php?c=group&m=add&state=error");
    }
}

function edit()
{
    if (!isLoginUser()) {
        header("location:index.php");
        exit();
    }
    $departments = getAllDataDepartments();
    $term = getAllTerm();

    $id = $_GET['id'];
    $group = getGroupById($id);

    require 'view/group/edit_view.php';
}

function handleEdit()
{
    if (isset($_POST['btnUpdate'])) {
        $name = $_POST['name'];
        $id = trim($_GET['id']);
        $id = is_numeric($id) ? $id : 0;
        $department_id = $_POST['department_id'];
        $term_id = $_POST['term_id'];
        $status = $_POST['status'];
        $studentMember = $_POST['studentMember'];
        $teacher = $_POST['teacher'];
        $currentDate = date('Y-m-d H:i:s');
        $slug = slug_string($name);
    }
    $group = getGroupById($id);

    $update = updateGroup($name, $slug, $department_id, $term_id, $studentMember, $teacher, $status, $currentDate, $id);
    if ($update) {
        header("location:index.php?c=group&state=success");
    } else {
        header("location:index.php?c=group&m=add&state=error");
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
    $delete = deleteGroup($id);
    if ($delete) {
        //xoa thanh cong
        header("location:index.php?c=group&state_del=success");
    } else {
        //xoa that bai
        header("location:index.php?c=group&state_del=failure");
    }
}
