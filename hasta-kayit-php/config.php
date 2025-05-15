<?php
$host = "db";
$port = 3306;
$user = "deneme2";       // Veritabanı kullanıcı adın
$pass = "1234";          // Veritabanı şifren
$db   = "hasta_kayit";   // Daha önce oluşturduğumuz veritabanı

$conn = new mysqli($host, $user, $pass, $db, $port);

// Bağlantı kontrolü
if ($conn->connect_error) {
    die("Veritabanı bağlantısı başarısız: " . $conn->connect_error);
}
?>
