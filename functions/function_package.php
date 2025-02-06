<?php

require_once 'koneksi.php';
include_once 'helper.php';

function getData()
{
    global $conn;
    $sql     = "SELECT * FROM packages";
    $result    = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_free_result($result);
    mysqli_close($conn);
}

function addData($package_code, $package_name, $category_code, $smell_type, $gender, $price, $commission, $ship_code, $description)
{
    global $conn;
    $sql     = "INSERT INTO packages (package_code, package_name, category_code, smell_type, gender, price, commission, ship_code, description) 
                    VALUES ('$package_code', '$package_name', '$category_code', '$smell_type', '$gender', '$price', '$commission', '$ship_code', '$description')";
    $result    = mysqli_query($conn, $sql);
    mysqli_close($conn);
}

function showData($package_code)
{
    global $conn;
    $fixid     = mysqli_real_escape_string($conn, $package_code);
    $sql     = "SELECT * FROM packages WHERE package_code='$fixid'";
    $result    = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_close($conn);
}

function editData($package_code, $package_name, $category_code, $smell_type, $gender, $price, $commission, $ship_code, $description )
{
    global $conn;
    $fixid     = mysqli_real_escape_string($conn, $package_code);
    $sql     = "UPDATE packages SET package_code='$package_code', package_name='$package_name', category_code='$category_code',  smell_type='$smell_type', gender='$gender', price='$price', commission='$commission', ship_code='$ship_code', description='$description'
                    WHERE package_code='$fixid'";
    $result    = mysqli_query($conn, $sql);
    mysqli_close($conn);
    return ($result) ? true : false;
}

function deleteData($package_code)
{
    global $conn;
    $sql     = "DELETE FROM packages WHERE package_code='$package_code'";
    $result    = mysqli_query($conn, $sql);
    return ($result) ? true : false;
    mysqli_close($conn);
}

if (isset($_POST['add'])) {
    $package_code                          = mysqli_real_escape_string($conn, $_POST['package_code']);
    $package_name                          = mysqli_real_escape_string($conn, $_POST['package_name']);
    $category_code                         = mysqli_real_escape_string($conn, $_POST['category_code']);
    $smell_type                            = mysqli_real_escape_string($conn, $_POST['smell_type']);
    $gender                                = mysqli_real_escape_string($conn, $_POST['gender']);
    $price                                 = mysqli_real_escape_string($conn, $_POST['price']);
    $commission                            = mysqli_real_escape_string($conn, $_POST['commission']);
    $ship_code                             = mysqli_real_escape_string($conn, $_POST['ship_code']);
    $description                           = mysqli_real_escape_string($conn, $_POST['description']);
    $add                                   = addData($package_code, $package_name,$category_code, $smell_type, $gender, $price, $commission, $ship_code, $description);
    session_start();
    unset($_SESSION["message"]);
    if ($add) {
        $_SESSION['message'] = $added;
    } else {
        $_SESSION['message'] = $failed;
    }
    header("location:../data_package.php");
} elseif (isset($_POST['edit'])) {
    $package_code                   = mysqli_real_escape_string($conn, $_POST['package_code']);
    $package_name                   = mysqli_real_escape_string($conn, $_POST['package_name']);
    $category_code                  = mysqli_real_escape_string($conn, $_POST['category_code']);
    $smell_type                     = mysqli_real_escape_string($conn, $_POST['smell_type']);
    $gender                         = mysqli_real_escape_string($conn, $_POST['gender']);
    $price                          = mysqli_real_escape_string($conn, $_POST['price']);
    $commission                     = mysqli_real_escape_string($conn, $_POST['commission']);
    $ship_code                      = mysqli_real_escape_string($conn, ($_POST['ship_code']));
    $description                    = mysqli_real_escape_string($conn, $_POST['description']);

    $edit                           = editData($package_code, $package_name, $category_code, $smell_type,  $gender, $price, $commission, $ship_code, $description);
    session_start();
    unset($_SESSION["message"]);
    if ($edit) {
        $_SESSION['message'] = $edited;
    } else {
        $_SESSION['message'] = $failed;
    }
    header("location:../data_package.php");
} elseif (isset($_GET['hapus'])) {
    $package_code    = mysqli_real_escape_string($conn, $_GET['hapus']);
    $delete = deleteData($package_code);
    session_start();
    unset($_SESSION["message"]);
    if ($delete) {
        $_SESSION['message'] = $deleted;
    } else {
        $_SESSION['message'] = $failed;
    }
    header("location:../data_package.php");
}
