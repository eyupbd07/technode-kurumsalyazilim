<?php 
session_start();
if(!isset($_SESSION['admin_login'])) { header("Location: login.php"); exit(); }
require_once '../config.php';

// Başarı Mesajı Kontrolü
$mesaj = "";

// Site Ayarlarını Güncelle
if(isset($_POST['ayarlari_kaydet'])) {
    $baslik = htmlspecialchars($_POST['site_baslik']);
    $desc = htmlspecialchars($_POST['site_desc']);
    $guncelle = $db->prepare("UPDATE site_ayarlar SET site_baslik = ?, site_desc = ? WHERE id = 1");
    $guncelle->execute([$baslik, $desc]);
    $mesaj = "Site ayarları güncellendi!";
}

// Yeni Moderatör Ekle (Sadece Admin yetkisi olanlar yapabilir)
if(isset($_POST['mod_ekle'])) {
    $kadi = htmlspecialchars($_POST['mod_kadi']);
    $sifre = htmlspecialchars($_POST['mod_sifre']);
    $ekle = $db->prepare("INSERT INTO admin_hesap (kullanici_adi, sifre, rol) VALUES (?, ?, 0)");
    $ekle->execute([$kadi, $sifre]);
    $mesaj = "Yeni moderatör eklendi!";
}

// Verileri Çek
$ayarlar = $db->query("SELECT * FROM site_ayarlar WHERE id = 1")->fetch(PDO::FETCH_ASSOC);
$moderatorler = $db->query("SELECT * FROM admin_hesap")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Ayarlar | TechNode Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #020617; color: #fff; }
        .glass-card { background: rgba(255, 255, 255, 0.02); border: 1px solid rgba(255, 255, 255, 0.05); }
    </style>
</head>
<body class="flex">

    <?php include 'sidebar.php'; // Sidebar'ı ayrı dosyaya almanı öneririm ?>

    <main class="flex-1 p-12">
        <h1 class="text-3xl font-black italic mb-10 uppercase tracking-tighter text-blue-500">Sistem Ayarları</h1>

        <?php if($mesaj): ?>
            <div class="bg-emerald-500/10 border border-emerald-500/50 text-emerald-500 p-4 rounded-2xl mb-8 text-xs font-bold uppercase tracking-widest text-center">
                <?php echo $mesaj; ?>
            </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 xl:grid-cols-2 gap-10">
            
            <div class="glass-card p-10 rounded-[40px]">
                <h3 class="text-lg font-bold mb-8 uppercase tracking-widest text-slate-400 italic">Genel Bilgiler</h3>
                <form method="POST" class="space-y-6">
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 uppercase mb-2 tracking-widest">Site Başlığı</label>
                        <input type="text" name="site_baslik" value="<?php echo $ayarlar['site_baslik']; ?>" class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 outline-none focus:border-blue-500 transition">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 uppercase mb-2 tracking-widest">Açıklama (SEO)</label>
                        <textarea name="site_desc" class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 h-32 outline-none focus:border-blue-500 transition"><?php echo $ayarlar['site_desc']; ?></textarea>
                    </div>
                    <button name="ayarlari_kaydet" class="bg-blue-600 hover:bg-blue-700 px-8 py-4 rounded-2xl font-bold uppercase text-[10px] tracking-widest transition">Güncelle</button>
                </form>
            </div>

            <div class="glass-card p-10 rounded-[40px]">
                <h3 class="text-lg font-bold mb-8 uppercase tracking-widest text-slate-400 italic">Moderatör Yönetimi</h3>
                <form method="POST" class="space-y-6 mb-10">
                    <div class="grid grid-cols-2 gap-4">
                        <input type="text" name="mod_kadi" placeholder="Kullanıcı Adı" class="bg-white/5 border border-white/10 rounded-2xl px-6 py-4 outline-none focus:border-blue-500 transition">
                        <input type="password" name="mod_sifre" placeholder="Şifre" class="bg-white/5 border border-white/10 rounded-2xl px-6 py-4 outline-none focus:border-blue-500 transition">
                    </div>
                    <button name="mod_ekle" class="w-full bg-white text-black hover:bg-blue-600 hover:text-white px-8 py-4 rounded-2xl font-bold uppercase text-[10px] tracking-widest transition">Yeni Ekip Üyesi Ekle</button>
                </form>

                <div class="space-y-4">
                    <p class="text-[10px] font-bold text-slate-600 uppercase tracking-widest mb-4">Mevcut Ekip</p>
                    <?php foreach($moderatorler as $mod): ?>
                        <div class="flex justify-between items-center p-4 bg-white/5 rounded-2xl border border-white/5">
                            <span class="text-sm font-bold uppercase italic"><?php echo $mod['kullanici_adi']; ?></span>
                            <span class="text-[8px] font-black px-3 py-1 bg-slate-800 rounded-full text-slate-400 uppercase tracking-widest">
                                <?php echo $mod['rol'] == 1 ? 'Yönetici' : 'Moderatör'; ?>
                            </span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

        </div>
    </main>
</body>
</html>