<?php

require_once 'koneksi.php';
include_once 'helper.php';

function getData()
{
    global $conn;
    $sql     = "SELECT * FROM tb_user";
    $result    = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_free_result($result);
    mysqli_close($conn);
}

            function addData($code_user, $name, $username, $password, $role)
{
    global $conn;
    $sql     = "INSERT INTO tb_user (code_user, name, username, password, role) 
                    VALUES ('$code_user', '$name', '$username', '$password','$role')";
    $result    = mysqli_query($conn, $sql);
    return ($result) ? true : false;
    mysqli_close($conn);
}

function showData($id_user)
{
    global $conn;
    $fixid     = mysqli_real_escape_string($conn, $id_user);
    $sql     = "SELECT * FROM tb_user WHERE id_user='$fixid'";
    $result    = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_close($conn);
}

function editData($id_user, $code_user, $name, $username, $password, $role)
{
    global $conn;
    $fixid     = mysqli_real_escape_string($conn, $id_user);
    $sql     = "UPDATE tb_user SET code_user='$code_user, name='$name',  username='$username', password='$password', role='$role'
                    WHERE id_user='$fixid'";
    $result    = mysqli_query($conn, $sql);
    return ($result) ? true : false;
    mysqli_close($conn);
}

function deleteData($id_user)
{
    global $conn;
    $sql     = "DELETE FROM tb_user WHERE id_user='$id_user'";
    $result    = mysqli_query($conn, $sql);
    return ($result) ? true : false;
    mysqli_close($conn);
}

if (isset($_POST['add'])) {
    $code_user       = mysqli_real_escape_string($conn, $_POST['code_user']);
    $name            = mysqli_real_escape_string($conn, $_POST['name']);
    $username        = mysqli_real_escape_string($conn, $_POST['username']);
    $password        = mysqli_real_escape_string($conn, md5($_POST['password']));
    $role            = mysqli_real_escape_string($conn, $_POST['role']);
    $add             = addData($code_user, $name, $username, $password, $role);
    session_start();
    unset($_SESSION["message"]);
    if ($add) {
        $_SESSION['message'] = $added;
    } else {
        $_SESSION['message'] = $failed;
    }
    header("location:../data_user.php");
} elseif (isset($_POST['edit'])) {
    $code_user       = mysqli_real_escape_string($conn, $_POST['code_user']);
    $id_user         = mysqli_real_escape_string($conn, $_POST['id_user']);
    $name            = mysqli_real_escape_string($conn, $_POST['name']);
    $username        = mysqli_real_escape_string($conn, $_POST['username']);
    $password        = mysqli_real_escape_string($conn, md5($_POST['password']));
    $role            = mysqli_real_escape_string($conn, $_POST['role']);
    $edit            = editData($code_user, $id_user, $name, $username, $password, $role);
    session_start();
    unset($_SESSION["message"]);
    if ($edit) {
        $_SESSION['message'] = $edited;
    } else {
        $_SESSION['message'] = $failed;
    }
    header("location:../data_user.php");
} elseif (isset($_GET['hapus'])) {
    $id_user    = mysqli_real_escape_string($conn, $_GET['hapus']);
    $delete = deleteData($id_user);
    session_start();
    unset($_SESSION["message"]);
    if ($delete) {
        $_SESSION['message'] = $deleted;
    } else {
        $_SESSION['message'] = $failed;
    }
    header("location:../data_user.php");
}
