<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_TITLE; ?></title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@200;400;600;800&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        :root { --primary: #3b82f6; --secondary: #10b981; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #030712; color: #f8fafc; scroll-behavior: smooth; }
        
        .glass-nav { background: rgba(3, 7, 18, 0.6); backdrop-filter: blur(20px); border-bottom: 1px solid rgba(255,255,255,0.05); }
        
        .hero-gradient {
            background: radial-gradient(circle at 50% 50%, rgba(59, 130, 246, 0.15) 0%, transparent 50%);
        }

        .premium-card {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .premium-card:hover {
            background: rgba(255, 255, 255, 0.05);
            border-color: var(--primary);
            transform: translateY(-10px) scale(1.01);
            box-shadow: 0 20px 40px rgba(0,0,0,0.5);
        }

        .text-glow { text-shadow: 0 0 20px rgba(59, 130, 246, 0.5); }
        .grid-bg { background-image: linear-gradient(rgba(255,255,255,0.02) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.02) 1px, transparent 1px); background-size: 50px 50px; }
    </style>
</head>
<body class="grid-bg">

<nav class="fixed w-full z-[100] glass-nav transition-all duration-500">
    <div class="container mx-auto px-10 py-5 flex justify-between items-center">
        <a href="index.php" class="text-2xl font-black text-white tracking-tighter flex items-center gap-2 group">
            <div class="w-10 h-10 bg-gradient-to-tr from-blue-600 to-emerald-400 rounded-xl flex items-center justify-center group-hover:rotate-12 transition-all">
                <i class="fas fa-terminal text-white text-sm"></i>
            </div>
            TECH<span class="text-blue-500">NODE</span>
        </a>
        <div class="hidden lg:flex space-x-12 text-[11px] font-bold uppercase tracking-[0.3em] items-center">
            <a href="index.php" class="text-white hover:text-blue-400 transition">Ana Sayfa</a>
            <a href="#hizmetler" class="hover:text-blue-400 transition">Uzmanlık</a>
            <a href="#urunler" class="hover:text-blue-400 transition">Ürünler</a>
            
            <div class="flex items-center gap-6 border-l border-white/10 pl-12">
                <a href="https://github.com/eyupbd07" target="_blank" class="text-white/50 hover:text-white transition text-lg">
                    <i class="fab fa-github"></i>
                </a>
                <a href="https://linkedin.com/in/eyyupbademci" target="_blank" class="text-white/50 hover:text-blue-400 transition text-lg">
                    <i class="fab fa-linkedin-in"></i>
                </a>
            </div>

            <a href="iletisim.php" class="bg-blue-600 px-8 py-3 rounded-xl hover:bg-emerald-500 transition-all duration-500 text-white shadow-lg shadow-blue-500/20">Bize Ulaşın</a>
        </div>
    </div>
</nav>
<div class="pt-24">