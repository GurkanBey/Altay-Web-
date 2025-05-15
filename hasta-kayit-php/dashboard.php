<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$mesaj = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ad = $_POST['ad'];
    $soyad = $_POST['soyad'];
    $tc = $_POST['tc'];
    $telefon = $_POST['telefon'];
    $bolum = $_POST['bolum'];
    $sikayet = $_POST['sikayet'];

    // Aynı TC kayıtlı mı kontrol et
    $kontrol = $conn->prepare("SELECT id FROM hastalar WHERE tc_kimlik = ?");
    $kontrol->bind_param("s", $tc);
    $kontrol->execute();
    $kontrol->store_result();

    if ($kontrol->num_rows > 0) {
        $mesaj = "❌ Bu T.C. Kimlik numarasına ait bir kayıt zaten mevcut.";
    } else {
        $stmt = $conn->prepare("INSERT INTO hastalar (ad, soyad, tc_kimlik, telefon, bolum, sikayet) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $ad, $soyad, $tc, $telefon, $bolum, $sikayet);

        if ($stmt->execute()) {
            $mesaj = "✅ Hasta başarıyla kaydedildi.";
        } else {
            $mesaj = "❌ Kayıt sırasında hata oluştu: " . $stmt->error;
        }

        $stmt->close();
    }

    $kontrol->close();
}
?>


<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hasta Kayıt</title>
  <link rel="stylesheet" href="dashboard.css">
</head>
<body>
  <a href="menu2.php" class="geri-btn">⬅️  Geri dön</a>

  <div class="container">
    <div class="login-box">
      <h2>Yeni Hasta Kaydı</h2>

      <?php if (!empty($mesaj)) echo "<p class='mesaj'>$mesaj</p>"; ?>

      <form class="form" method="POST">
        <div class="form-row">
          <label for="ad">Ad:</label>
          <input type="text" id="ad" name="ad" required>
        </div>

        <div class="form-row">
          <label for="soyad">Soyad:</label>
          <input type="text" id="soyad" name="soyad" required>
        </div>

        <div class="form-row">
          <label for="tc">T.C. Kimlik No:</label>
          <input type="text" id="tc" name="tc" maxlength="11" required>
        </div>

        <div class="form-row">
          <label for="telefon">Telefon:</label>
          <input type="text" id="telefon" name="telefon" required>
        </div>

        <div class="form-row">
          <label for="bolum">Bölüm:</label>
          <select id="bolum" name="bolum" required>
            <option value="">-- Bölüm Seçin --</option>
            <option value="Dahiliye">Dahiliye</option>
            <option value="Deri ve Zuhrevi Hastaliklar">Deri ve Zührevi Hastalıklar</option>
            <option value="Kulak Burun Bogaz">Kulak Burun Boğaz</option>
            <option value="Goz Hastaliklari">Göz Hastalıkları</option>
            <option value="Ortopedi">Ortopedi</option>
            <option value="Kardiyoloji">Kardiyoloji</option>
            <option value="Psikiyatri">Psikiyatri</option>
            <option value="Noroloji">Nöroloji</option>
          </select>
        </div>

        <div class="form-row">
          <label for="sikayet">Şikayet:</label>
          <textarea id="sikayet" name="sikayet" rows="5" cloumn="8" required></textarea>
        </div>

        <button type="submit">Kaydet</button>
      </form>
    </div>

    <div class="right-side">
      <div class="logo"></div>
    </div>
  </div>
</body>
</html>
