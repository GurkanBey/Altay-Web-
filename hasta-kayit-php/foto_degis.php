<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user'])) {
  header("Location: login.php");
  exit();
}

$kullanici = $_SESSION['user'];
$photo = "";
$mesaj = "";

// Mevcut fotoğrafı çek
$stmt = $conn->prepare("SELECT photo FROM users WHERE username = ?");
$stmt->bind_param("s", $kullanici);
$stmt->execute();
$result = $stmt->get_result();
if ($row = $result->fetch_assoc()) {
  $photo = $row['photo'];
}
$stmt->close();

// Fotoğraf yükleme işlemi
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['foto'])) {
  $dosya = $_FILES['foto'];
  $klasor = "upload/";
  $dosya_adi = basename($dosya["name"]);
  $hedef_dosya = $klasor . $dosya_adi;

  if (move_uploaded_file($dosya["tmp_name"], $hedef_dosya)) {
    $stmt = $conn->prepare("UPDATE users SET photo = ? WHERE username = ?");
    $stmt->bind_param("ss", $dosya_adi, $kullanici);
    if ($stmt->execute()) {
      header("Location: foto_degis.php");
      $mesaj = "✅ Fotoğraf Başarıyla Güncellendi.";
    } else {
      $mesaj = "❌ Güncelleme Hatası.";
    }
    $stmt->close();
  } else {
    $mesaj = "❌ Dosya yüklenemedi. Yetki hatası olabilir.";
  }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <title>Fotoğraf Değiştir</title>
  <link rel="stylesheet" href="degis.css">
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
<a href="hesap.php" class="geri-btn">⬅️  Geri Dön</a>
<div class="logo"></div>

<div class="profil-alani">
  <img src="upload/<?= htmlspecialchars($photo ?: 'default.png') ?>" class="profil-foto" alt="Profil Fotoğrafı">
  <h2 class="profil-kullanici">👤 <?= htmlspecialchars($kullanici) ?></h2>
</div>

<form method="post" enctype="multipart/form-data">
  <label>Yeni Fotoğraf Seç:</label>
  <input type="file" name="foto" accept="image/*" required>
  <button type="submit" class="btn">Yükle</button>
</form>

<p><?= $mesaj ?></p>
</body>
</html>
