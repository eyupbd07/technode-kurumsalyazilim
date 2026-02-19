<?php
session_start();
session_unset(); // Tüm session değişkenlerini temizle
session_destroy(); // Oturumu tamamen yok et
header("Location: login.php");
exit();
?>