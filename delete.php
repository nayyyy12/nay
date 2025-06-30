<?php
include 'conn.php';

if (isset($_POST['id'])) {
    $id = intval($_POST['id']);

    // ดึงชื่อไฟล์ก่อนลบ
    $stmt = $conn->prepare("SELECT filename FROM work WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($filename);
    $stmt->fetch();
    $stmt->close();

    if ($filename && file_exists("uploads/$filename")) {
        unlink("uploads/$filename"); // ลบไฟล์จริง
    }

    // ลบข้อมูลจากฐานข้อมูล
    $stmt = $conn->prepare("DELETE FROM work WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

$conn->close();
header("Location: work.php");
exit();
?>
