<?php
$ketnoi = new mysqli("localhost:3307", "root", "", "bt4");
$ketnoi->set_charset("utf8mb4");
if ($ketnoi->connect_error) die("Lỗi kết nối CSDL");

// XỬ LÝ UPLOAD QUIZ.TXT
if (isset($_FILES['file_quiz']) && $_FILES['file_quiz']['error'] == 0) {
    $file = $_FILES['file_quiz']['tmp_name'];
    $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    $ketnoi->query("TRUNCATE TABLE cauhoi"); // xóa cũ

    $question = ""; $a=$b=$c=$d=""; $ans="";
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line == "") continue;

        if (strpos($line, 'ANSWER:') === 0) {
            $ans = trim(substr($line, 7));
            $ketnoi->query("INSERT INTO cauhoi (noidung, dapan_A, dapan_B, dapan_C, dapan_D, dapandung) 
                            VALUES ('$question', '$a', '$b', '$c', '$d', '$ans')");
            $question = $a = $b = $c = $d = "";
        }
        elseif (strpos($line, 'A.') === 0) $a = trim(substr($line, 2));
        elseif (strpos($line, 'B.') === 0) $b = trim(substr($line, 2));
        elseif (strpos($line, 'C.') === 0) $c = trim(substr($line, 2));
        elseif (strpos($line, 'D.') === 0) $d = trim(substr($line, 2));
        else $question = $line;
    }
    echo "<p style='color:green'>Đã import thành công file quiz.txt!</p>";
}

// XỬ LÝ UPLOAD SINHVIEN.CSV
// === THAY ĐOẠN NÀY (từ dòng khoảng 40 trở đi) ===
if (isset($_FILES['file_csv']) && $_FILES['file_csv']['error'] == 0) {
    $file = $_FILES['file_csv']['tmp_name'];
    $handle = fopen($file, "r");
    if ($handle === FALSE) die("Không mở được file CSV");

    $ketnoi->query("TRUNCATE TABLE sinhvien");
    $first = true;

    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        if ($first) { $first = false; continue; } // bỏ qua dòng tiêu đề

        // Kiểm tra đủ 5 cột không
        if (count($data) < 5) continue;

        $masv     = $ketnoi->real_escape_string(trim($data[0]));
        $hoten    = $ketnoi->real_escape_string(trim($data[1]));
        $lop      = $ketnoi->real_escape_string(trim($data[2]));
        $ngaysinh = trim($data[3]);
        $diem     = floatval($data[4]);

        $sql = "INSERT INTO sinhvien (masv, hoten, lop, ngaysinh, diem) 
                VALUES ('$masv', '$hoten', '$lop', '$ngaysinh', $diem)";
        $ketnoi->query($sql);
    }
    fclose($handle);
    echo "<p style='color:green'>Đã import thành công file sinhvien.csv!</p>";
}
?>

<!DOCTYPE html>
<html><head><meta charset="UTF-8"><title>Bài 4 - Upload & Import CSDL</title></head>
<body style="font-family:Arial;margin:40px">

<h2>BÀI TẬP 4 – UPLOAD FILE & LƯU VÀO CSDL</h2>

<form method="post" enctype="multipart/form-data">
    <fieldset style="padding:20px;margin:20px 0;background:#f9f9f9">
        <legend><b>1. Upload file QUIZ.TXT (tạo câu hỏi)</b></legend>
        <input type="file" name="file_quiz" accept=".txt" required>
        <button type="submit" style="padding:8px 15px">Import Quiz</button>
    </fieldset>
</form>

<form method="post" enctype="multipart/form-data">
    <fieldset style="padding:20px;margin:20px 0;background:#f9f9f9">
        <legend><b>2. Upload file SINHVIEN.CSV (tạo sinh viên)</b></legend>
        <input type="file" name="file_csv" accept=".csv" required>
        <button type="submit" style="padding:8px 15px">Import Sinh viên</button>
    </fieldset>
</form>

<hr>
<p><b>Kiểm tra dữ liệu đã import:</b></p>
<ul>
    <li><a href="?xem=quiz" target="_blank">Xem tất cả câu hỏi trong CSDL</a></li>
    <li><a href="?xem=sv" target="_blank">Xem tất cả sinh viên trong CSDL</a></li>
</ul>

<?php
// Xem dữ liệu (tùy chọn)
if (isset($_GET['xem'])) {
    echo "<pre style='background:#f0f0f0;padding:15px'>";
    if ($_GET['xem'] == 'quiz') {
        $r = $ketnoi->query("SELECT * FROM cauhoi");
        while($row = $r->fetch_assoc()) print_r($row);
    }
    if ($_GET['xem'] == 'sv') {
        $r = $ketnoi->query("SELECT * FROM sinhvien");
        while($row = $r->fetch_assoc()) print_r($row);
    }
    echo "</pre>";
}
?>

</body>
</html>