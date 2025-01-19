<?php
require_once 'koneksi.php';


function getTotalAgents()
{
    global $conn;
    $sql = "SELECT COUNT(*) AS total FROM agents";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    $stmt->close();
    return $data['total'];
}
function getTotalUsers()
{
    global $conn;
    $sql = "SELECT COUNT(*) AS total FROM tb_user";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    $stmt->close();
    return $data['total'];
}
