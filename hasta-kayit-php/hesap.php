<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user'])) {
  header("Location: login.php");
  exit();
}

$kullanici = $_SESSION['user'];
$photo = "";

// Fotoğrafı al
$stmt = $conn->prepare("SELECT photo FROM users WHERE username = ?");
$stmt->bind_param("s", $kullanici);
$stmt->execute();
$result = $stmt->get_result();
if ($row = $result->fetch_assoc()) {
  $photo = $row['photo'];
}
$stmt->close();
?>
<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <title>Hesap Bilgileri</title>
  <link rel="stylesheet" href="hesap.css">
  <style>
    .profil-alani {
      margin-top: 200px;
      text-align: center;
    }
    .profil-foto {
      width: 150px;
      height: 150px;
      border-radius: 50%;
      object-fit: cover;
      box-shadow: 0 0 8px rgba(255,255,255,0.4);
      margin-bottom: 10px;
    }
    h2.profil-kullanici {
      margin-top: 0;
    }
  </style>
</head>
<body>

<a href="menu2.php" class="geri-btn">⬅️  Geri Dön</a>
<div class="logo"></div>

<div class="profil-alani">
  <img src="upload/<?= htmlspecialchars($photo ?: 'default.png') ?>" class="profil-foto" alt="Profil Fotoğrafı">
  <h2 class="profil-kullanici">👤 <?= htmlspecialchars($kullanici) ?></h2>
</div>

<div class="buttons">
  <a href="sifre_degis.php" class="btn">Şifre Değiştir</a>
  <a href="k_adi_degis.php" class="btn">Kullanıcı Adı Değiştir</a>
  <a href="foto_degis.php" class="btn">Fotoğraf Değiştir</a>
</div>
</body>
</html>
