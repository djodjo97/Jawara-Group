<?php
require_once 'koneksi.php';


function getTotalMitra()
{
    {
        global $conn;
        $sql = "SELECT MONTH(created_at) AS bulan, COUNT(*) AS total FROM tb_mitra GROUP BY bulan";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
    
        $data = array_fill(0, 12, 0); // Default 12 bulan (Jan - Des)
        while ($row = $result->fetch_assoc()) {
            $data[$row['bulan'] - 1] = $row['total'];
        }
    
        $stmt->close();
        return $data;
    }
}
function getTotalUsers()
{
    {
        global $conn;
        $sql = "SELECT MONTH(created_at) AS bulan, COUNT(*) AS total FROM tb_user GROUP BY bulan";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
    
        $data = array_fill(0, 12, 0); // Default 12 bulan (Jan - Des)
        while ($row = $result->fetch_assoc()) {
            $data[$row['bulan'] - 1] = $row['total'];
        }
    
        $stmt->close();
        return $data;
    }
}
