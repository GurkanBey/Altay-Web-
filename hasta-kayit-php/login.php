<?php
session_start();
include 'config.php';

$mesaj = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kullanici = $_POST['username'];
    $sifre = $_POST['password'];

    // Hazırlıklı ifade (prepared statement) kullan
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $kullanici, $sifre);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $_SESSION['user'] = $kullanici;
        header("Location: menu2.php");
        exit();
    } else {
        $mesaj = "Hatalı giriş.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <title>Giriş Yap</title>
  <link rel="stylesheet" href="login.css"> 
</head>
<body>
  <div class="logo"></div>
  <div class="login-box">
    <h1>Giriş</h1>
    <?php if (!empty($mesaj)) echo "<p style='color:red;'>$mesaj</p>"; ?>
    <form method="POST">
      <label for="username">Kullanıcı Adı:</label>
      <input type="text" id="username" name="username" required>

      <label for="password">Şifre:</label>
      <input type="password" id="password" name="password" required>

      <button type="submit" class="btn">Giriş Yap</button>
    </form>
    <p>Hesabınız yok mu? <a href="register.php">Kayıt Olun</a></p>
  </div>
</body>
</html>
