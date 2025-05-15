# 🏥 Altay Hasta Kayıt Web Uygulaması

Bu proje, hastane personelinin kullanıcı kaydı, hasta girişlerinin takibi ve sistem yedekleme işlemlerini gerçekleştirebildiği bir web uygulamasıdır. Proje Python (Flask), MySQL ve Bash script kullanılarak geliştirilmiştir. Uygulama Dockerize edilmiştir ve `docker-compose` ile tek komutla ayağa kaldırılabilir.

## 📄 İçindekiler

- [Özellikler](#özellikler)
- [Kurulum](#Kurulum)
- [Yedekleme Scripti](#yedekleme-scripti)
- [Veritabanı Yapısı](#veritabanı-yapısı)

---

## Özellikler

### ✅ Özellikler 

- Kullanıcı Kayıt ve Giriş Sistemi (Register & Login)
- Hasta Bilgileri Kayıt Paneli (Dashboard)
- Manuel ve Otomatik Yedekleme (Backup)
- Backup loglarının listelenmesi
- MySQL veritabanı kullanımı
- Docker ve Docker Compose desteği
- Temel güvenlik açıklarını içermeyecek şekilde hazırlanmıştır:
  - SQL Injection (SQLi)
  - IDOR (Insecure Direct Object Reference)
  - LFI (Local File Inclusion)

---

## Kurulum

### 🐳 Kurulum

### 1. Gereksinimler

- Docker
- Docker Compose

### 2. Klonlama

```bash
git clone https://github.com/GurkanBey/Altay-Web-.git
cd Altay-Web-/hasta-kayit-php/
````

### 3. Uygulamanın Başlatılması

```bash
docker-compose up --build
```

* Web uygulamasına [http://localhost:8080/login.php](http://localhost:8080/login.php) adresinden ulaşabilirsiniz.

---

## Yedekleme Scripti

### ⏸ Yedekleme Scripti

### backup.sh

* Proje içinde `backup.sh` adında bir Bash script bulunmaktadır.
* Bu script:

  * Veritabanının yedeğini alır.
  * Yedekleme tarihi, saati, dosya adı ve boyutunu `/var/log/backup.log` dosyasına kaydeder.
  * Yedeklemenin başarılı olup olmadığına göre mesaj döndürür.
  * Ayrıca her pazar saat 3'te crontab ile otomatik yedek alır.

---

## Veritabanı Yapısı

### 🔄 Veritabanı Yapısı

### 🗄️ Veritabanı: `hasta_kayit`

Bu projede kullanılan MySQL veritabanı `hasta_kayit` adını taşır ve iki ana tablodan oluşur: `users` ve `hastalar`.

```
+-----------------------+
| Tables_in_hasta_kayit |
+-----------------------+
| hastalar              |
| users                 |
+-----------------------+
```

### 📁 Tablo: `users`

Hastane personelinin kullanıcı bilgilerini tutar. Giriş (login) işlemleri bu tablo üzerinden yapılır.

```
+-----------+--------------+------+-----+---------+----------------+
| Field     | Type         | Null | Key | Default | Extra          |
+-----------+--------------+------+-----+---------+----------------+
| id        | int          | NO   | PRI | NULL    | auto_increment |
| ad        | varchar(50)  | YES  |     | NULL    |                |
| soyad     | varchar(50)  | YES  |     | NULL    |                |
| tc_kimlik | varchar(11)  | YES  |     | NULL    |                |
| telefon   | varchar(20)  | YES  |     | NULL    |                |
| bolum     | varchar(100) | YES  |     | NULL    |                |
| sikayet   | text         | YES  |     | NULL    |                |
+-----------+--------------+------+-----+---------+----------------+
```

### 📁 Tablo: `hastalar`

Hastaneye gelen hastaların kayıt bilgilerini tutar. Dashboard üzerinden erişilir ve doldurulur.

```
+----------+--------------+------+-----+---------+----------------+
| Field    | Type         | Null | Key | Default | Extra          |
+----------+--------------+------+-----+---------+----------------+
| id       | int          | NO   | PRI | NULL    | auto_increment |
| username | varchar(50)  | NO   |     | NULL    |                |
| password | varchar(255) | NO   |     | NULL    |                |
| photo    | varchar(255) | YES  |     | NULL    |                |
+----------+--------------+------+-----+---------+----------------+
```




