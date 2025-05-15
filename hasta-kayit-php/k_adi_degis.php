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

// Fotoğrafı al
$stmt = $conn->prepare("SELECT photo FROM users WHERE username = ?");
$stmt->bind_param("s", $kullanici);
$stmt->execute();
$result = $stmt->get_result();
if ($row = $result->fetch_assoc()) {
  $photo = $row['photo'];
}
$stmt->close();

// Kullanıcı adı değiştirme
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $mevcut = $_POST['mevcut'];
  $yeni = $_POST['yeni'];

  if ($mevcut === $kullanici) {
    // Yeni kullanıcı adı zaten var mı kontrol et
    $kontrol = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $kontrol->bind_param("s", $yeni);
    $kontrol->execute();
    $kontrol->store_result();

    if ($kontrol->num_rows > 0) {
      $mesaj = "❌ Bu kullanıcı adı zaten kullanılıyor.";
    } else {
      $stmt2 = $conn->prepare("UPDATE users SET username = ? WHERE username = ?");
      $stmt2->bind_param("ss", $yeni, $mevcut);
      $stmt2->execute();
      $_SESSION['user'] = $yeni;
      $mesaj = "✅ Kullanıcı adı başarıyla değiştirildi.";
    }

    $kontrol->close();
  } else {
    $mesaj = "❌ Mevcut kullanıcı adı hatalı.";
  }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <title>Kullanıcı Adı Değiştir</title>
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

<form method="post">
  <label>Mevcut Kullanıcı Adı:</label>
  <input type="text" name="mevcut" required>

  <label>Yeni Kullanıcı Adı:</label>
  <input type="text" name="yeni" required>

  <button type="submit" class="btn">Kaydet</button>
</form>
<p><?= $mesaj ?></p>
</body>
</html>
