<?php
// Đọc file CSV (dòng đầu tiên là tiêu đề)
$file = '65HTTT_Danh_sach_diem_danh.csv';

if (!file_exists($file)) {
    die("Không tìm thấy file sinhvien.csv trong cùng thư mục!");
}

$lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
if (!$lines) {
    die("File rỗng hoặc không đọc được!");
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Bài 3 - Danh sách sinh viên</title>
</head>
<body style="font-family:Arial; margin:40px;">

<h2>DANH SÁCH SINH VIÊN</h2>

<table border="1" cellpadding="8" cellspacing="0">
    <tr style="background:#ddd;">
        <?php
        // In tiêu đề (dòng đầu tiên của CSV)
        $header = str_getcsv($lines[0]);
        foreach ($header as $h) {
            echo "<th>" . htmlspecialchars($h) . "</th>";
        }
        ?>
    </tr>

    <?php
    // Bỏ qua dòng tiêu đề
    for ($i = 1; $i < count($lines); $i++) {
        $row = str_getcsv($lines[$i]);
        echo "<tr>";
        foreach ($row as $cell) {
            echo "<td>" . htmlspecialchars($cell) . "</td>";
        }
        echo "</tr>";
    }
    ?>
</table>

<p><i>Tổng cộng: <?= count($lines)-1 ?> sinh viên</i></p>

</body>
</html>