<?php
include 'conn.php';

$title = $_POST['title'] ?? '';
$description = $_POST['description'] ?? '';

$targetDir = "uploads/";
$filename = basename($_FILES["fileToUpload"]["name"]);
$targetFile = $targetDir . $filename;
$imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
$uploadOk = 1;

$allowed = ["jpg", "jpeg", "png", "gif"];
if (!in_array($imageFileType, $allowed)) {
    echo "อนุญาตเฉพาะ JPG, JPEG, PNG, GIF เท่านั้น.";
    $uploadOk = 0;
}

if ($_FILES["fileToUpload"]["size"] > 5000000) {
    echo "ไฟล์ใหญ่เกิน 5MB";
    $uploadOk = 0;
}

if ($uploadOk && move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
    $stmt = $conn->prepare("INSERT INTO work (filename, title, description) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $filename, $title, $description);
    $stmt->execute();
    $stmt->close();
    echo "อัปโหลดเรียบร้อยแล้ว!<br><a href='work.php'>กลับไปหน้าผลงาน</a>";
} else {
    echo "อัปโหลดไม่สำเร็จ";
}

$conn->close();
?>