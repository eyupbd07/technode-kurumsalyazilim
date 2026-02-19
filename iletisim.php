<?php include 'includes/header.php'; ?>

<section class="relative min-h-[60vh] flex items-center justify-center text-center overflow-hidden">
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-full z-0">
        <div class="absolute top-[20%] left-[10%] w-[400px] h-[400px] bg-blue-600/10 rounded-full blur-[100px]"></div>
    </div>

    <div class="container mx-auto px-6 relative z-10" data-aos="fade-down">
        <h1 class="text-6xl md:text-9xl font-black tracking-tighter text-white mb-6 italic uppercase">
            BİZE <br> <span class="text-gradient">ULAŞIN.</span>
        </h1>
        <p class="text-slate-500 text-lg md:text-xl max-w-2xl mx-auto font-light tracking-widest uppercase">
            Batman'dan dünyaya açılan projeler için ilk adımı atın.
        </p>
    </div>
</section>

<section class="pb-32 relative z-10">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-1 space-y-6" data-aos="fade-right">
                <div class="bento-card p-10 rounded-[40px]">
                    <h4 class="text-blue-500 font-bold text-[10px] tracking-[0.4em] uppercase mb-4">E-POSTA</h4>
                    <p class="text-white text-xl font-light">hello@technode.com</p>
                </div>
                <div class="bento-card p-10 rounded-[40px]">
                    <h4 class="text-emerald-500 font-bold text-[10px] tracking-[0.4em] uppercase mb-4">LOKASYON</h4>
                    <p class="text-white text-xl font-light italic">Batman / Türkiye</p>
                </div>
                <div class="bento-card p-10 rounded-[40px] flex justify-between items-center">
                    <span class="text-[10px] font-bold tracking-[0.4em] uppercase">Sosyal</span>
                    <div class="flex gap-4">
                        <a href="#" class="text-slate-400 hover:text-white transition"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" class="text-slate-400 hover:text-white transition"><i class="fab fa-github"></i></a>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2 bento-card p-12 md:p-16 rounded-[50px] relative overflow-hidden" data-aos="fade-left">
                <div class="relative z-10">
                    <h3 class="text-4xl font-black text-white mb-10 italic tracking-tighter">BİR PROJE BAŞLATIN</h3>
                    
                    <?php 
                    if ($_POST) {
                        $ad_soyad = htmlspecialchars($_POST['ad_soyad']);
                        $email = htmlspecialchars($_POST['email']);
                        $mesaj = htmlspecialchars($_POST['mesaj']);

                        if (!empty($ad_soyad) && !empty($email) && !empty($mesaj)) {
                            $sorgu = $db->prepare("INSERT INTO iletisim_formu (ad_soyad, email, mesaj) VALUES (?, ?, ?)");
                            $ekle = $sorgu->execute([$ad_soyad, $email, $mesaj]);

                            if ($ekle) {
                                echo '<div class="bg-blue-600/20 text-blue-400 p-6 rounded-3xl mb-8 border border-blue-500/30 font-bold text-sm tracking-widest uppercase italic animate-pulse text-center">✔ Mesajınız Işık Hızıyla İletildi!</div>';
                            }
                        }
                    }
                    ?>

                    <form action="" method="POST" class="space-y-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-2">
                                <label class="text-[10px] font-bold tracking-[0.3em] uppercase opacity-40 ml-2">Ad Soyad</label>
                                <input type="text" name="ad_soyad" required class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 focus:border-blue-500 transition outline-none text-white font-light">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-bold tracking-[0.3em] uppercase opacity-40 ml-2">E-Posta</label>
                                <input type="email" name="email" required class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 focus:border-blue-500 transition outline-none text-white font-light">
                            </div>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold tracking-[0.3em] uppercase opacity-40 ml-2">Mesajınız</label>
                            <textarea name="mesaj" rows="6" required class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 focus:border-blue-500 transition outline-none text-white font-light resize-none"></textarea>
                        </div>
                        <button type="submit" class="w-full group relative py-6 bg-white text-black rounded-3xl font-black italic tracking-[0.2em] overflow-hidden transition-all duration-500 hover:bg-blue-600 hover:text-white uppercase">
                            <span class="relative z-10">Gönderimi Başlat</span>
                            <div class="absolute inset-0 bg-blue-600 translate-y-full group-hover:translate-y-0 transition-transform duration-500"></div>
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>