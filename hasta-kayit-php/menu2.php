<?php
session_start();
include 'config.php';

$kullanici = $_SESSION['user'] ?? null;
$photo = "";

// Kullanıcı giriş yaptıysa fotoğrafı çek
if ($kullanici) {
    $stmt = $conn->prepare("SELECT photo FROM users WHERE username = ?");
    $stmt->bind_param("s", $kullanici);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $photo = $row['photo'];
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <title>Hasta Kayıt Sistemi</title>
  <link rel="stylesheet" href="menu2.css">
</head>
<body>
  <a href="logout.php" class="geri-btn">⬅️  ÇIKIŞ</a>

  <div class="hesap-container">
    <img src="upload/<?= htmlspecialchars($photo ?: 'default.png') ?>" class="profil-icon" alt="Profil Foto">
  </div>
  <a href="hesap.php" class="hesap-btn">👤 HESAP AYARLARI</a>

  <div class="logo"></div>

  <div class="buttons">
    <a href="dashboard.php" class="btn">Hasta Kayıt</a>
    <a href="backup.php" class="btn">Yedekleme</a>
  </div>
</body>
</html>
