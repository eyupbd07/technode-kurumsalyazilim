# TechNode - Kurumsal Yazılım Yönetim Paneli

TechNode, kurumsal web siteleri için geliştirilmiş, PHP ve MySQL tabanlı, sade ve güvenli bir yönetim paneli (CMS) altyapısıdır.

## ✨ Özellikler

* **Dinamik Yönetim:** Dashboard üzerinden mesajların, site ayarlarının ve profil bilgilerinin kontrolü.
* **Rol Bazlı Yetkilendirme:** * **Admin:** Tüm sisteme ve ekip yönetimine tam erişim.
    * **Moderator:** Sadece mesaj onaylama ve silme yetkisi.
* **Güvenlik:** PDO altyapısı ile SQL Injection koruması ve MD5 şifreleme.
* **Modern Arayüz:** Tailwind CSS ile hazırlanmış karanlık mod uyumlu tasarım.

## 🛠️ Teknolojiler

* **Backend:** PHP 8.x
* **Veritabanı:** MySQL (PDO)
* **Frontend:** Tailwind CSS, FontAwesome

## 📥 Kurulum

1. Depoyu klonlayın: `git clone https://github.com/eyupbd07/technode-kurumsalyazilim.git`
2. `kurumsal_db.sql` dosyasını veritabanınıza (phpMyAdmin vb.) içe aktarın.
3. `config.php` dosyasındaki veritabanı bağlantı bilgilerini güncelleyin.
4. `/admin/login.php` üzerinden giriş yapın. (Varsayılan: admin / 123456)

## 📜 Lisans

Bu proje MIT Lisansı altında lisanslanmıştır.

---
**Geliştirici:** [Eyyüp Bademci](https://github.com/eyupbd07)
