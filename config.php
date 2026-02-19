<?php
// Site Temel Ayarları
// Senin belirttiğin localhost/dashboard/kurumsal-yazilim yapısına göre ayarlandı
define('SITE_URL', 'http://localhost/dashboard/kurumsal-yazilim');
define('SITE_TITLE', 'TechNode | Kurumsal Yazılım Çözümleri');

// Veritabanı Bilgileri (Bir sonraki adımda oluşturacağız)
$host     = "localhost";
$user     = "root";
$pass     = ""; 
$dbname   = "kurumsal_db";

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Eğer veritabanını henüz oluşturmadıysan burada hata verebilir, normaldir.
    $db_status = "Bağlantı Bekleniyor...";
}
?>