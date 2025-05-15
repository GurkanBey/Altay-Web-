<?php
include 'config.php';

$mesaj = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kullanici = $_POST['username'];
    $sifre = $_POST['password'];

    // Kullanıcı adı zaten var mı kontrol et
    $kontrol = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $kontrol->bind_param("s", $kullanici);
    $kontrol->execute();
    $kontrol->store_result();

    if ($kontrol->num_rows > 0) {
        $mesaj = "❌ Bu kullanıcı adı zaten kullanılıyor.";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (username, password, photo) VALUES (?, ?, 'default.png')");
        $stmt->bind_param("ss", $kullanici, $sifre);

        if ($stmt->execute()) {
            $mesaj = "✅ Kayıt Başarılı.";
        } else {
            $mesaj = "❌ Kayıt başarısız: " . $stmt->error;
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
  <title>Kayıt Ol</title>
  <link rel="stylesheet" href="register.css">
</head>
<body>
  <div class="logo"></div>
  <div class="login-box">
    <h1>Kayıt Ol</h1>
    <?php if (!empty($mesaj)) echo "<p style='color:green;'>$mesaj</p>"; ?>
    <form method="POST">
      <label for="username">Kullanıcı Adı:</label>
      <input type="text" id="username" name="username" required>

      <label for="password">Şifre:</label>
      <input type="password" id="password" name="password" required>

      <button type="submit" class="btn">Kayıt Ol</button>
    </form>
    <p>Zaten hesabınız var mı? <a href="login.php">Giriş yap</a></p>
  </div>
</body>
</html>
