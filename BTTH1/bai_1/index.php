<?php include 'db.php'; 
$result = $conn->query("SELECT * FROM flowers");
?>
<!DOCTYPE html><html lang="vi"><head><meta charset="UTF-8"><title>Trang chủ</title></head><body>
<h2>DANH SÁCH HOA</h2>
<?php while($row = $result->fetch_assoc()): ?>
<p>
    <img src="img/<?= $row['image'] ?>" width="100"> 
    <b><?= $row['name'] ?></b><br>
    <?= $row['desc'] ?>
</p><hr>
<?php endwhile; ?>
<p><a href="admin.php">Quản trị</a></p>
</body></html>