<?php 
session_start();
require_once '../config.php';

// Güvenlik Kilidi
if(!isset($_SESSION['admin_login'])) { header("Location: login.php"); exit(); }

// Kullanıcı Verilerini Çek
$oturum_id = $_SESSION['admin_id'];
$user = $db->query("SELECT * FROM admin_hesap WHERE id = $oturum_id")->fetch(PDO::FETCH_ASSOC);
$user_role = $user['rol']; // 1: Admin, 0: Mod

$sayfa = isset($_GET['p']) ? $_GET['p'] : 'dashboard';
$bildirim = "";

// --- ORTAK AKSİYONLAR ---
if(isset($_GET['islem']) && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    if($_GET['islem'] == 'sil') { $db->query("DELETE FROM iletisim_formu WHERE id = $id"); }
    if($_GET['islem'] == 'onay') { $db->query("UPDATE iletisim_formu SET durum = 1 WHERE id = $id"); }
    header("Location: index.php?p=mesajlar"); exit();
}

// --- SADECE ADMİN AKSİYONLARI ---
if($user_role == 1) {
    if(isset($_POST['ayarlari_kaydet'])) {
        $db->prepare("UPDATE site_ayarlar SET site_baslik = ?, site_desc = ? WHERE id = 1")
           ->execute([htmlspecialchars($_POST['s_baslik']), htmlspecialchars($_POST['s_desc'])]);
        $bildirim = "Ayarlar güncellendi.";
    }
    if(isset($_POST['mod_ekle'])) {
        $db->prepare("INSERT INTO admin_hesap (kullanici_adi, sifre, rol) VALUES (?, ?, 0)")
           ->execute([htmlspecialchars($_POST['m_kadi']), md5($_POST['m_sifre'])]);
        $bildirim = "Yeni moderatör eklendi.";
    }
    if(isset($_GET['mod_sil'])) {
        $db->query("DELETE FROM admin_hesap WHERE id = ".intval($_GET['mod_sil'])." AND rol = 0");
        header("Location: index.php?p=ekip"); exit();
    }
}

// Profil Güncelle (Herkes)
if(isset($_POST['profil_guncelle'])) {
    $ad = htmlspecialchars($_POST['p_ad']);
    if(!empty($_POST['p_sifre'])) {
        $db->prepare("UPDATE admin_hesap SET ad_soyad = ?, sifre = ? WHERE id = ?")
           ->execute([$ad, md5($_POST['p_sifre']), $oturum_id]);
    } else {
        $db->prepare("UPDATE admin_hesap SET ad_soyad = ? WHERE id = ?")->execute([$ad, $oturum_id]);
    }
    $bildirim = "Profil güncellendi.";
}

// Veriler
$ayarlar = $db->query("SELECT * FROM site_ayarlar WHERE id = 1")->fetch(PDO::FETCH_ASSOC);
$mesajlar = $db->query("SELECT * FROM iletisim_formu ORDER BY tarih DESC")->fetchAll(PDO::FETCH_ASSOC);
$ekip = $db->query("SELECT * FROM admin_hesap ORDER BY rol DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Enterprise Panel | TechNode</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;500;800&display=swap" rel="stylesheet">
    <style>
        /* Ana Sayfa Uyumlu Renk Paleti ve Grid Yapısı */
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #030712; 
            background-image: linear-gradient(rgba(255,255,255,0.02) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.02) 1px, transparent 1px); 
            background-size: 50px 50px;
            color: #f8fafc; 
            overflow: hidden; 
        }
        
        .sidebar { background: rgba(3, 7, 18, 0.6); backdrop-filter: blur(20px); border-right: 1px solid rgba(255, 255, 255, 0.05); }
        
        .nav-link { transition: 0.3s; color: #475569; font-size: 11px; font-weight: 800; letter-spacing: 0.2em; text-transform: uppercase; }
        .nav-link:hover, .nav-link.active { color: #fff; background: rgba(59, 130, 246, 0.1); border-right: 3px solid #3b82f6; }
        
        .bento { 
            background: rgba(255, 255, 255, 0.02); 
            border: 1px solid rgba(255, 255, 255, 0.05); 
            border-radius: 24px; 
            backdrop-filter: blur(10px);
            transition: 0.4s cubic-bezier(0.4, 0, 0.2, 1); 
        }
        .bento:hover { border-color: #3b82f6; box-shadow: 0 0 30px rgba(59, 130, 246, 0.1); }
        
        .input-dark { background: rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.08); padding: 16px; border-radius: 12px; width: 100%; outline: none; font-size: 13px; color: white; }
        .input-dark:focus { border-color: #3b82f6; background: rgba(59, 130, 246, 0.02); }
        
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-thumb { background: #1a1b26; border-radius: 10px; }
    </style>
</head>
<body class="flex h-screen w-full">

    <aside class="w-80 sidebar flex flex-col p-8 h-full shrink-0">
        <div class="mb-16 flex items-center gap-4">
            <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center font-black italic shadow-lg shadow-blue-500/20 text-white">T</div>
            <h2 class="text-xl font-black tracking-tighter uppercase italic text-white">Control<span class="text-blue-500 font-light">Center</span></h2>
        </div>
        
        <nav class="flex-1 space-y-2">
            <a href="?p=dashboard" class="nav-link <?php echo $sayfa == 'dashboard' ? 'active' : ''; ?> flex items-center gap-4 p-4 rounded-xl">
                <i class="fas fa-grid-2 text-lg"></i> Dashboard
            </a>
            <a href="?p=mesajlar" class="nav-link <?php echo $sayfa == 'mesajlar' ? 'active' : ''; ?> flex items-center gap-4 p-4 rounded-xl">
                <i class="fas fa-envelope text-lg"></i> Mesajlar
            </a>
            
            <?php if($user_role == 1): ?>
                <div class="pt-10 mb-2 opacity-20 text-[9px] font-bold tracking-[0.4em] uppercase text-white">Sistem</div>
                <a href="?p=ayarlar" class="nav-link <?php echo $sayfa == 'ayarlar' ? 'active' : ''; ?> flex items-center gap-4 p-4 rounded-xl">
                    <i class="fas fa-cog text-lg"></i> Ayarlar
                </a>
                <a href="?p=ekip" class="nav-link <?php echo $sayfa == 'ekip' ? 'active' : ''; ?> flex items-center gap-4 p-4 rounded-xl">
                    <i class="fas fa-users-gear text-lg"></i> Ekip Yönetimi
                </a>
            <?php endif; ?>

            <div class="pt-10 mb-2 opacity-20 text-[9px] font-bold tracking-[0.4em] uppercase text-white">Hesap</div>
            <a href="?p=profil" class="nav-link <?php echo $sayfa == 'profil' ? 'active' : ''; ?> flex items-center gap-4 p-4 rounded-xl">
                <i class="fas fa-user-astronaut text-lg"></i> Profilim
            </a>
        </nav>

        <a href="logout.php" class="nav-link flex items-center gap-4 p-4 rounded-xl text-red-900 hover:text-red-500 mt-auto">
            <i class="fas fa-power-off text-lg"></i> Çıkış Yap
        </a>
    </aside>

    <main class="flex-1 overflow-y-auto p-12">
        <header class="flex justify-between items-center mb-16 border-b border-white/5 pb-10">
            <div>
                <h1 class="text-5xl font-black italic tracking-tighter uppercase leading-none text-white"><?php echo strtoupper($sayfa); ?></h1>
                <p class="text-slate-500 text-[10px] font-bold tracking-[0.5em] mt-3 uppercase italic">Node: <?php echo $user_role == 1 ? 'Administrator' : 'Moderator'; ?></p>
            </div>
            <?php if($bildirim): ?>
                <div class="bg-blue-600/10 text-blue-500 border border-blue-600/20 px-6 py-2 rounded-full text-[10px] font-bold uppercase tracking-widest"><?php echo $bildirim; ?></div>
            <?php endif; ?>
        </header>

        <?php if($sayfa == 'dashboard'): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bento p-12 flex flex-col justify-between h-56 relative overflow-hidden">
                    <span class="text-slate-500 text-[10px] font-bold uppercase tracking-widest italic italic">Sistem Verisi</span>
                    <h3 class="text-5xl font-black tracking-tighter italic italic text-white"><?php echo count($mesajlar); ?> Mesaj</h3>
                    <i class="fas fa-chart-line absolute -right-4 -bottom-4 text-white/5 text-8xl"></i>
                </div>
                <div class="bento p-12 flex flex-col justify-between h-56">
                    <span class="text-emerald-500 text-[10px] font-bold uppercase tracking-widest italic italic">Güvenlik Durumu</span>
                    <h3 class="text-4xl font-black uppercase italic leading-none text-white">MD5 Aktif</h3>
                </div>
            </div>

        <?php elseif($sayfa == 'mesajlar'): ?>
            <div class="bento overflow-hidden divide-y divide-white/5">
                <?php foreach($mesajlar as $m): ?>
                <div class="p-10 group hover:bg-white/[0.01] transition-all flex justify-between items-center">
                    <div>
                        <div class="flex items-center gap-4 mb-3">
                            <div class="w-2 h-2 rounded-full <?php echo $m['durum'] == 0 ? 'bg-blue-600 animate-pulse shadow-[0_0_15px_#3b82f6]' : 'bg-slate-800'; ?>"></div>
                            <h4 class="text-2xl font-bold italic text-white uppercase"><?php echo htmlspecialchars($m['ad_soyad']); ?></h4>
                        </div>
                        <p class="text-slate-500 italic text-lg leading-relaxed">"<?php echo htmlspecialchars($m['mesaj']); ?>"</p>
                    </div>
                    <div class="flex gap-3">
                        <?php if($m['durum'] == 0): ?>
                            <a href="?islem=onay&id=<?php echo $m['id']; ?>" class="w-12 h-12 bg-emerald-500/10 text-emerald-500 rounded-xl flex items-center justify-center hover:bg-emerald-500 hover:text-white transition"><i class="fas fa-check"></i></a>
                        <?php endif; ?>
                        <a href="?islem=sil&id=<?php echo $m['id']; ?>" onclick="return confirm('Silinsin mi?')" class="w-12 h-12 bg-red-500/10 text-red-500 rounded-xl flex items-center justify-center hover:bg-red-500 hover:text-white transition"><i class="fas fa-trash-alt"></i></a>
                        <a href="mailto:<?php echo $m['email']; ?>" class="w-12 h-12 bg-white text-black rounded-xl flex items-center justify-center hover:bg-blue-600 hover:text-white transition"><i class="fas fa-reply"></i></a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

        <?php elseif($sayfa == 'ayarlar' && $user_role == 1): ?>
            <div class="max-w-2xl bento p-12">
                <form method="POST" class="space-y-8">
                    <input type="text" name="s_baslik" value="<?php echo htmlspecialchars($ayarlar['site_baslik']); ?>" class="input-dark">
                    <textarea name="s_desc" class="input-dark h-40 italic"><?php echo htmlspecialchars($ayarlar['site_desc']); ?></textarea>
                    <button name="ayarlari_kaydet" class="w-full bg-blue-600 text-white font-black py-5 rounded-2xl uppercase text-[10px] tracking-widest hover:bg-blue-700 transition">Güncelle</button>
                </form>
            </div>

        <?php elseif($sayfa == 'ekip' && $user_role == 1): ?>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                <div class="bento p-12">
                    <h3 class="text-[10px] font-bold uppercase tracking-widest text-emerald-500 mb-8 italic italic">Moderatör Ekle</h3>
                    <form method="POST" class="space-y-6">
                        <input type="text" name="m_kadi" placeholder="Kullanıcı Adı" required class="input-dark">
                        <input type="password" name="m_sifre" placeholder="Şifre" required class="input-dark">
                        <button name="mod_ekle" class="w-full bg-white text-black font-black py-5 rounded-2xl uppercase text-[10px] tracking-widest hover:bg-emerald-600 hover:text-white transition">Kaydet</button>
                    </form>
                </div>
                <div class="bento p-12 overflow-hidden">
                    <h3 class="text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-8 italic italic text-white">Ekip Listesi</h3>
                    <div class="space-y-4">
                        <?php foreach($ekip as $e): ?>
                            <div class="flex justify-between items-center p-5 bg-white/[0.02] border border-white/5 rounded-2xl">
                                <span class="text-xs font-bold uppercase italic text-white"><?php echo $e['kullanici_adi']; ?></span>
                                <div class="flex items-center gap-4">
                                    <span class="<?php echo $e['rol'] == 1 ? 'text-blue-500' : 'text-slate-700'; ?> text-[9px] font-black uppercase"><?php echo $e['rol'] == 1 ? 'ADMIN' : 'MOD'; ?></span>
                                    <?php if($e['rol'] == 0): ?>
                                        <a href="?p=ekip&mod_sil=<?php echo $e['id']; ?>" class="text-red-900 hover:text-red-500"><i class="fas fa-times"></i></a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

        <?php elseif($sayfa == 'profil'): ?>
            <div class="max-w-xl bento p-12">
                <form method="POST" class="space-y-8">
                    <input type="text" name="p_ad" value="<?php echo htmlspecialchars($user['ad_soyad']); ?>" placeholder="Ad Soyad" class="input-dark">
                    <input type="password" name="p_sifre" placeholder="Şifre (Değiştirmek istemiyorsanız boş bırakın)" class="input-dark">
                    <button name="profil_guncelle" class="w-full bg-blue-600 text-white font-black py-5 rounded-2xl uppercase text-[10px] tracking-widest hover:bg-blue-700 transition">Profil Kaydet</button>
                </form>
            </div>
        <?php endif; ?>
    </main>

</body>
</html>