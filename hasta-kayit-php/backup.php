<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$mesaj = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $output = null;
    $result = null;

    exec('bash ./scripts/backup.sh', $output, $result);

    if ($result === 0) {
        $mesaj = "✅ Yedekleme başarılı.";
    } else {
        $mesaj = "❌ Yedekleme sırasında hata oluştu.";
    }
}

$log_icerik = "Log dosyası bulunamadı.";
if (file_exists("/var/log/backup.log")) {
    $log_icerik = file_get_contents("/var/log/backup.log");
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <title>Yedekleme</title>
  <link rel="stylesheet" href="backup.css">
</head>
<body>
  <a href="menu2.php" class="geri-btn">⬅️ Geri Dön</a>

  <div class="logo"></div>

  <div class="container">
    <div class="left-panel">
      <div class="login-box">
        <h1>Veri Tabanı Yedekleme</h1>
        <form method="POST">
          <button type="submit" class="btn">Yedek Al</button>
        </form>
        <?php if (!empty($mesaj)) echo "<p style='color:green; margin-top:15px;'>$mesaj</p>"; ?>
      </div>
    </div>

    <div class="right-panel">
      <h2>Yedekleme Logları</h2>
      <div class="log-container">
        <pre><?php echo htmlspecialchars($log_icerik); ?></pre>
      </div>
    </div>
  </div>
</body>
</html>
