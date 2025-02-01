<?php

require_once 'koneksi.php';
include_once 'helper.php';

function getData()
{
    global $conn;
    $sql     = "SELECT * FROM tb_mitra";
    $result    = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_free_result($result);
    mysqli_close($conn);
}

function addData($registration_number, $id_mitra, $gen_id, $ktp, $sim, $name, $email, $phone, $address, $leader_id, $upper_i, $upper_ii, $upper_iii, $bonus_i, $bonus_ii, $bonus_iii)
{
    global $conn;
    $sql     = "INSERT INTO tb_mitra (registration_number, id_mitra, gen_id, ktp, sim, name, email, phone, address, leader_id, upper_i, upper_ii, upper_iii, bonus_i, bonus_ii, bonus_iii) 
                    VALUES ('$registration_number', '$id_mitra', '$gen_id', '$ktp', '$sim', '$name', '$email', '$phone', '$address', '$leader_id', '$upper_i', '$upper_ii', '$upper_iii', '$bonus_i', '$bonus_ii', '$bonus_iii')";
    $result    = mysqli_query($conn, $sql);
    mysqli_close($conn);
}

function showData($id_mitra)
{
    global $conn;
    $fixid     = mysqli_real_escape_string($conn, $id_mitra);
    $sql     = "SELECT * FROM tb_mitra WHERE id_mitra='$fixid'";
    $result    = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_close($conn);
}

function editData($registration_number, $id_mitra, $gen_id, $ktp, $sim, $name, $email, $phone, $address, $leader_id, $upper_i, $upper_ii, $upper_iii, $bonus_i, $bonus_ii, $bonus_iii, )
{
    global $conn;
    $fixid     = mysqli_real_escape_string($conn, $id_mitra);
    $sql     = "UPDATE tb_mitra SET registration_number='$registration_number', id_mitra='$id_mitra', gen_id='$gen_id',  sim='$sim', 'ktp='$ktp', name='$name', email='$email', phone='$phone', address='$address', leader_id='$leader_id', upper_i='$upper_i', upper_ii='$upper_ii', upper_iii='$upper_iii', bonus_i='$bonus_i', bonus_ii='$bonus_ii', bonus_iii='$bonus_iii'
                    WHERE id_mitra='$fixid'";
    $result    = mysqli_query($conn, $sql);
    return ($result) ? true : false;
    mysqli_close($conn);
}

function deleteData($id_mitra)
{
    global $conn;
    $sql     = "DELETE FROM tb_mitra WHERE id_mitra='$id_mitra'";
    $result    = mysqli_query($conn, $sql);
    return ($result) ? true : false;
    mysqli_close($conn);
}

if (isset($_POST['add'])) {
    $registration_number            = mysqli_real_escape_string($conn, $_POST['registration_number']);
    $id_mitra                       = mysqli_real_escape_string($conn, $_POST['id_mitra']);
    $gen_id                         = mysqli_real_escape_string($conn, $_POST['gen_id']);
    $sim                            = mysqli_real_escape_string($conn, $_POST['sim']);
    $ktp                            = mysqli_real_escape_string($conn, $_POST['ktp']);
    $name                           = mysqli_real_escape_string($conn, $_POST['name']);
    $email                          = mysqli_real_escape_string($conn, $_POST['email']);
    $phone                          = mysqli_real_escape_string($conn, $_POST['phone']);
    $address                        = mysqli_real_escape_string($conn, $_POST['address']);
    $leader_id                      = mysqli_real_escape_string($conn, $_POST['leader_id']);
    $upper_i                        = mysqli_real_escape_string($conn, $_POST['upper_i']);
    $upper_ii                       = mysqli_real_escape_string($conn, $_POST['upper_ii']);
    $upper_iii                      = mysqli_real_escape_string($conn, $_POST['upper_iii']);
    $bonus_i                        = mysqli_real_escape_string($conn, $_POST['bonus_i']);
    $bonus_ii                       = mysqli_real_escape_string($conn, $_POST['bonus_ii']);
    $bonus_iii                      = mysqli_real_escape_string($conn, $_POST['bonus_iii']);
    $add                            = addData($registration_number, $id_mitra,$gen_id, $sim, $ktp, $name, $email, $phone, $address, $leader_id, $upper_i, $upper_ii, $upper_iii, $bonus_i, $bonus_ii, $bonus_iii);
    session_start();
    unset($_SESSION["message"]);
    if ($add) {
        $_SESSION['message'] = $added;
    } else {
        $_SESSION['message'] = $failed;
    }
    header("location:../data_mitra.php");
} elseif (isset($_POST['edit'])) {
    $registration_number        = mysqli_real_escape_string($conn, $_POST['registration_number']);
    $id_mitra                   = mysqli_real_escape_string($conn, $_POST['id_mitra']);
    $gen_id                     = mysqli_real_escape_string($conn, $_POST['gen_id']);
    $sim                        = mysqli_real_escape_string($conn, $_POST['sim']);
    $ktp                        = mysqli_real_escape_string($conn, $_POST['ktp']);
    $name                       = mysqli_real_escape_string($conn, $_POST['name']);
    $email                      = mysqli_real_escape_string($conn, $_POST['email']);
    $phone                      = mysqli_real_escape_string($conn, ($_POST['phone']));
    $address                    = mysqli_real_escape_string($conn, $_POST['address']);
    $leader_id                  = mysqli_real_escape_string($conn, $_POST['leader_id']);
    $upper_i                    = mysqli_real_escape_string($conn, $_POST['upper_i']);
    $upper_ii                   = mysqli_real_escape_string($conn, $_POST['upper_ii']);
    $upper_iii                  = mysqli_real_escape_string($conn, $_POST['upper_iii']);
    $bonus_i                    = mysqli_real_escape_string($conn, $_POST['bonus_i']);
    $bonus_ii                   = mysqli_real_escape_string($conn, $_POST['bonus_ii']);
    $bonus_iii                  = mysqli_real_escape_string($conn, $_POST['bonus_iii']);
    $edit                       = editData($registration_number, $id_mitra, $gen_id, $sim,  $ktp, $name, $email, $phone, $address, $leader_i, $upper_i, $upper_ii, $upper_iii, $bonus_i, $bonus_ii, $bonus_iii);
    session_start();
    unset($_SESSION["message"]);
    if ($edit) {
        $_SESSION['message'] = $edited;
    } else {
        $_SESSION['message'] = $failed;
    }
    header("location:../data_mitra.php");
} elseif (isset($_GET['hapus'])) {
    $id_mitra    = mysqli_real_escape_string($conn, $_GET['hapus']);
    $delete = deleteData($id_mitra);
    session_start();
    unset($_SESSION["message"]);
    if ($delete) {
        $_SESSION['message'] = $deleted;
    } else {
        $_SESSION['message'] = $failed;
    }
    header("location:../data_mitra.php");
}
