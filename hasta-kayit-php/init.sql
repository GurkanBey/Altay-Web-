CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    photo VARCHAR(255) DEFAULT NULL
);

INSERT INTO users (username, password, photo)
VALUES ('admin', 'admin123', 'kedi1.jpeg');

CREATE TABLE IF NOT EXISTS hastalar (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ad VARCHAR(50),
    soyad VARCHAR(50),
    tc_kimlik VARCHAR(11),
    telefon VARCHAR(20),
    bolum VARCHAR(100),
    sikayet TEXT
);

INSERT INTO hastalar (ad, soyad, tc_kimlik, telefon, bolum, sikayet)
VALUES ('hasta', 'bayahasta', '123', '123', 'dahiliye', 'hasta');
