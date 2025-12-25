<?php
$conn = new mysqli("localhost:3307", "root", "", "web_hoa");   // đổi 3307 thành cổng thật của bạn

if ($conn->connect_error) {
    die("Kết nối CSDL thất bại: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");
?>