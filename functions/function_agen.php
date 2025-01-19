<?php

require_once 'koneksi.php';
include_once 'helper.php';

function getData()
{
    global $conn;
    $sql     = "SELECT * FROM agents";
    $result    = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_free_result($result);
    mysqli_close($conn);
}

function addData($ktp, $name, $email, $phone, $address)
{
    global $conn;
    $sql     = "INSERT INTO agents (ktp, name, email, phone, address) 
                    VALUES ('$ktp', '$name', '$email','$phone', '$address')";
    $result    = mysqli_query($conn, $sql);
    return ($result) ? true : false;
    mysqli_close($conn);
}

function showData($id_agents)
{
    global $conn;
    $fixid     = mysqli_real_escape_string($conn, $id_agents);
    $sql     = "SELECT * FROM agents WHERE id_agents='$fixid'";
    $result    = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_close($conn);
}

function editData($id_agents, $ktp, $name, $email, $phone, $address)
{
    global $conn;
    $fixid     = mysqli_real_escape_string($conn, $id_agents);
    $sql     = "UPDATE agents SET ktp='$ktp', name='$name', email='$email', phone='$phone', address='$address'
                    WHERE id_agents='$fixid'";
    $result    = mysqli_query($conn, $sql);
    return ($result) ? true : false;
    mysqli_close($conn);
}

function deleteData($id_agents)
{
    global $conn;
    $sql     = "DELETE FROM agents WHERE id_agents='$id_agents'";
    $result    = mysqli_query($conn, $sql);
    return ($result) ? true : false;
    mysqli_close($conn);
}

if (isset($_POST['add'])) {
    $ktp            = mysqli_real_escape_string($conn, $_POST['ktp']);
    $name        = mysqli_real_escape_string($conn, $_POST['name']);
    $email        = mysqli_real_escape_string($conn, $_POST['email']);
    $phone            = mysqli_real_escape_string($conn, $_POST['phone']);
    $address            = mysqli_real_escape_string($conn, $_POST['address']);
    $add                 = addData($ktp, $name, $email, $phone, $address);
    session_start();
    unset($_SESSION["message"]);
    if ($add) {
        $_SESSION['message'] = $added;
    } else {
        $_SESSION['message'] = $failed;
    }
    header("location:../data_agen.php");
} elseif (isset($_POST['edit'])) {
    $id_agents        = mysqli_real_escape_string($conn, $_POST['id_agents']);
    $ktp            = mysqli_real_escape_string($conn, $_POST['ktp']);
    $name            = mysqli_real_escape_string($conn, $_POST['name']);
    $email        = mysqli_real_escape_string($conn, $_POST['email']);
    $phone        = mysqli_real_escape_string($conn, md5($_POST['phone']));
    $address            = mysqli_real_escape_string($conn, $_POST['address']);
    $edit             = editData($id_agents, $ktp, $name, $email, $phone, $address);
    session_start();
    unset($_SESSION["message"]);
    if ($edit) {
        $_SESSION['message'] = $edited;
    } else {
        $_SESSION['message'] = $failed;
    }
    header("location:../data_agen.php");
} elseif (isset($_GET['hapus'])) {
    $id_agents    = mysqli_real_escape_string($conn, $_GET['hapus']);
    $delete = deleteData($id_agents);
    session_start();
    unset($_SESSION["message"]);
    if ($delete) {
        $_SESSION['message'] = $deleted;
    } else {
        $_SESSION['message'] = $failed;
    }
    header("location:../data_agen.php");
}
