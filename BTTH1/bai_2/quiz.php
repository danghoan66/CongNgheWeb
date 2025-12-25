<?php
// Đọc file quiz.txt và hiển thị câu hỏi + đáp án đúng
$lines = file('Quiz.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

echo "<h2 style='text-align:center'>NỘI DUNG BÀI THI TRẮC NGHIỆM</h2>";
echo "<div style='font-family:Arial; margin:40px; line-height:1.8'>";

$stt = 1;
$question = "";
$options = [];

foreach ($lines as $line) {
    $line = trim($line);
    if ($line === "") continue;

    // Nếu gặp đáp án đúng → in câu hỏi + đáp án
    if (strpos($line, 'ANSWER:') === 0) {
        $dap_an = trim(substr($line, 7));

        echo "<p><b>Câu $stt:</b> $question</p>";
        foreach ($options as $opt) {
            $danh_dau = (strpos($opt, $dap_an . '.') === 0) ? " → <span style='color:green;font-weight:bold'>ĐÁP ÁN ĐÚNG</span>" : "";
            echo "<p style='margin-left:30px'>$opt$danh_dau</p>";
        }
        echo "<hr>";
        
        $stt++;
        $question = "";
        $options = [];
    }
    // Lưu câu hỏi
    elseif (empty($options) && empty($question)) {
        $question = $line;
    }
    // Lưu các lựa chọn
    elseif (preg_match('/^[A-D]\.\s*/', $line)) {
        $options[] = $line;
    }
}

echo "</div>";
?>