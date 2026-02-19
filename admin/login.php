<?php 
require_once '../config.php';
session_start();
if(isset($_SESSION['admin_login'])) { header("Location: index.php"); exit(); }

if ($_POST) {
    $user = htmlspecialchars($_POST['username']);
    $pass = md5($_POST['password']);
    $sorgu = $db->prepare("SELECT * FROM admin_hesap WHERE kullanici_adi = ? AND sifre = ?");
    $sorgu->execute([$user, $pass]);
    $admin = $sorgu->fetch(PDO::FETCH_ASSOC);
    if ($admin) {
        $_SESSION['admin_login'] = true;
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_user'] = $admin['kullanici_adi']; 
        header("Location: index.php");
        exit();
    } else { $error = "Erişim Engellendi."; }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Sistem Girişi | TechNode</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;800&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #030712; 
            background-image: linear-gradient(rgba(255,255,255,0.02) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.02) 1px, transparent 1px); 
            background-size: 50px 50px;
        }
        .login-glass { background: rgba(255, 255, 255, 0.02); border: 1px solid rgba(255, 255, 255, 0.05); backdrop-filter: blur(20px); }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-6">
    <div class="login-glass w-full max-w-sm p-12 rounded-[40px] text-center shadow-2xl">
        <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center mx-auto mb-8 shadow-lg shadow-blue-500/30 text-white font-black italic">T</div>
        <h2 class="text-white font-black italic tracking-widest mb-10 uppercase text-xs">Admin Panel</h2>
        <?php if(isset($error)): ?> <p class="text-red-500 text-[10px] mb-6 font-bold uppercase italic"><?php echo $error; ?></p> <?php endif; ?>
        <form method="POST" class="space-y-6 text-left">
            <input type="text" name="username" placeholder="Username" required class="w-full bg-white/5 border border-white/10 p-4 rounded-xl text-white outline-none focus:border-blue-600 text-xs transition">
            <input type="password" name="password" placeholder="Password" required class="w-full bg-white/5 border border-white/10 p-4 rounded-xl text-white outline-none focus:border-blue-600 text-xs transition">
            <button class="w-full bg-blue-600 text-white font-black py-4 rounded-xl uppercase text-[10px] tracking-[0.3em] hover:bg-white hover:text-black transition-all duration-500 shadow-xl shadow-blue-600/20">Giriş Yap</button>
        </form>
    </div>
</body>
</html>