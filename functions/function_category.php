<?php

require_once 'koneksi.php';
include_once 'helper.php';


if (isset($_POST['add'])) {
    $dataInput = [
        'category_code'    => trim(htmlspecialchars($_POST['category_code'])),
        'category_name'    => trim(htmlspecialchars($_POST['category_name'])),
    ];

    $add = addData($dataInput);

    $_SESSION['message'] = $add ? "Data berhasil ditambahkan!" : "Gagal menambahkan data.";
    header("location:../category.php");
    exit;
}

if (isset($_GET['remove'])) {
    $id_mitra = trim(htmlspecialchars($_GET['remove']));
    $remove = removeData($id_mitra);

    $_SESSION['message'] = $remove ? "Data berhasil dihapus!" : "Gagal menghapus data.";
    header("location:../category.php");
    exit;
}

function getAllData()
{
    global $conn;
    $stmt = $conn->query("SELECT * FROM package_category");

    if (!$stmt) {
        die("Query Error: " . $conn->error);
    }

    $res = $stmt->fetch_all(MYSQLI_ASSOC);
    $stmt->free_result();
    return $res;
}

function addData($data)
{
    global $conn;
    $stmt = $conn->prepare("INSERT INTO package_category (category_code, category_name) VALUES (?, ?)");

    if (!$stmt) {
        die("Query Error: " . $conn->error);
    }

    $stmt->bind_param("ss", $data['category_code'], $data['category_name']);
    $res = $stmt->execute();

    if (!$res) {
        error_log("Insert Error: " . $stmt->error);
    }

    $stmt->close();
    return $res;
}

function removeData($id)
{
    global $conn;
    $stmt = $conn->prepare("DELETE FROM package_category WHERE category_code = ?");

    if (!$stmt) {
        die("Query Error: " . $conn->error);
    }

    $stmt->bind_param("s", $id);
    $result = $stmt->execute();

    if (!$result) {
        error_log("Delete Error: " . $stmt->error);
    }

    $stmt->close();
    return $result;
}

function getCategoryProducts()
{
    global $conn;
    $stmt = $conn->query("SELECT DISTINCT category_name FROM package_category");

    if (!$stmt) {
        die("Query Error: " . $conn->error);
    }

    $res = $stmt->fetch_all(MYSQLI_ASSOC);
    $stmt->free_result();
    return $res;
}

