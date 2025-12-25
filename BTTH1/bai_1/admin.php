<?php
include 'db.php';

// ================== THÊM 4 LOÀI HOA MẪU (CHỈ BẤM 1 LẦN) ==================
if (isset($_GET['seed'])) {
    $flowers = [
        ["name" => "Hoa Đỗ Quyên",   "desc" => "Hoa Đỗ Quyên mang màu sắc rực rỡ và nồng nàn.",      "image" => "doquyen.jpg"],
        ["name" => "Hoa Hải Đường",  "desc" => "Hải Đường tượng trưng cho vẻ đẹp phú quý và sang trọng.", "image" => "haiduong.jpg"],
        ["name" => "Hoa Mai",        "desc" => "Hoa Mai biểu tượng cho mùa xuân và sự may mắn.",      "image" => "mai.jpg"],
        ["name" => "Hoa Tường Vy",   "desc" => "Hoa Tường Vy nhỏ nhắn, dịu dàng nhưng đầy sức sống.", "image" => "tuongvy.jpg"]
    ];

    foreach ($flowers as $f) {
        $n = $conn->real_escape_string($f['name']);
        $d = $conn->real_escape_string($f['desc']);
        $i = $conn->real_escape_string($f['image']);
        $check = $conn->query("SELECT id FROM flowers WHERE name='$n'");
        if ($check->num_rows == 0) {
            $conn->query("INSERT INTO flowers(name,`desc`,image) VALUES('$n','$d','$i')");
        }
    }
    header("Location: admin.php");
    exit;
}
// =====================================================================

$result = $conn->query("SELECT * FROM flowers ORDER BY id");
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Admin - Quản lý Hoa</title>
   
</head>
<body>

<h2>QUẢN LÝ HOA</h2>

<a href="add.php" class="add">+ Thêm hoa mới</a> | 
<a href="index.php">Xem trang khách</a>

<hr>

<?php if ($result->num_rows == 0): ?>
    <p class="seed">
        Chưa có dữ liệu! 
        <a href="?seed=1" style="color:white;">Click đây thêm 4 hoa mẫu</a>
    </p>
<?php endif; ?>

<table>
    <tr>
        <th>ID</th>
        <th>Tên hoa</th>
        <th>Ảnh minh họa</th>
        <th>Mô tả</th>
        <th>Chức năng</th>
    </tr>
    <?php while($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><b><?= htmlspecialchars($row['name']) ?></b></td>
        <td><img src="img/<?= $row['image'] ?>" alt="<?= $row['name'] ?>"></td>
        <td style="text-align:left"><?= htmlspecialchars($row['desc']) ?></td>
        <td>
            <a href="edit.php?id=<?= $row['id'] ?>">Sửa</a> |
            <a href="delete.php?id=<?= $row['id'] ?>" 
               onclick="return confirm('Xóa thật nhé?')">Xóa</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

</body>
</html>