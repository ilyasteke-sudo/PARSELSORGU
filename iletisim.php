<?php
/**
 * ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ A.Ş.
 * İletişim & Mühendislik Danışma Masası (iletisim.php)
 * Google YMYL & E-E-A-T Güvenilirlik Standartlarına Tam Uyumlu
 */

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/navbar.php';

$page_title = "İletişim & Mühendislik Danışma | ParselSorgu";
$meta_desc = "Ant Harita Mühendislik ile iletişime geçin. TKGM parsel sorgulama, imar durumu analizi, aplikasyon ve 18. madde danışmanlığı.";
$canonical_url = "https://www.parselsorgu.net/iletisim";

$success_sent = false;
$error_sent = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['contact_submit'])) {
    $name = trim($_POST['name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $city = trim($_POST['city'] ?? '');
    $ada_parsel = trim($_POST['ada_parsel'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if (!empty($name) && !empty($phone)) {
        try {
            if (isset($pdo)) {
                $stmt = $pdo->prepare("INSERT INTO contact_leads (name, phone, email, subject, message, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
                $subj = !empty($ada_parsel) ? "Parsel Danışma: {$city} {$ada_parsel}" : "Genel İletişim Formu";
                $stmt->execute([$name, $phone, '', $subj, $message]);
                if (file_exists(__DIR__ . '/telegram_lead_notifier.php')) { require_once __DIR__ . '/telegram_lead_notifier.php'; @send_telegram_lead_notification($subj, ['Ad Soyad' => $name, 'Telefon' => $phone, 'Şehir' => $city, 'Ada / Parsel' => $ada_parsel, 'Mesaj' => $message]); }
                $success_sent = true;
            }
        } catch (Exception $e) {
            $error_sent = "Mesajınız kaydedilirken bir hata oluştu. Lütfen doğrudan WhatsApp üzerinden bize yazın.";
        }
    } else {
        $error_sent = "Lütfen adınızı ve telefon numaranızı eksiksiz doldurun.";
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($page_title) ?></title>
    <meta name="description" content="<?= htmlspecialchars($meta_desc) ?>">
    <link rel="canonical" href="<?= $canonical_url ?>">
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?= htmlspecialchars($page_title) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($meta_desc) ?>">
    <meta property="og:url" content="<?= $canonical_url ?>">
    <meta property="og:image" content="https://www.parselsorgu.net/assets/images/og-parsel.jpg">
    <meta name="twitter:card" content="summary_large_image">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "ContactPage",
      "mainEntity": {
        "@type": "Organization",
        "name": "Ant Harita Mühendislik Teknolojileri A.Ş.",
        "telephone": "+90 542 841 35 35",
        "url": "https://www.parselsorgu.net",
        "address": {
          "@type": "PostalAddress",
          "streetAddress": "Çankaya Cad. No: 42/B, Çankaya",
          "addressLocality": "Ankara",
          "addressRegion": "Ankara",
          "postalCode": "06690",
          "addressCountry": "TR"
        }
      }
    }
    </script>

    <style>
        :root {
            --bg-dark: #090d16;
            --card-dark: #0f172a;
            --border-color: #1e293b;
            --primary-blue: #0284c7;
            --primary-light: #38bdf8;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
        }
        * { box-sizing: border-box; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-dark);
            color: var(--text-main);
            margin: 0;
            padding: 0;
            line-height: 1.6;
        }
        .container {
            max-width: 1140px;
            margin: 0 auto;
            padding: 40px 20px;
        }
        .hero-section {
            text-align: center;
            margin-bottom: 48px;
        }
        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(2, 132, 199, 0.15);
            border: 1px solid rgba(56, 189, 248, 0.3);
            color: var(--primary-light);
            padding: 6px 16px;
            border-radius: 9999px;
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 16px;
        }
        .hero-title {
            font-size: clamp(26px, 4vw, 40px);
            font-weight: 900;
            color: #fff;
            margin-bottom: 12px;
        }
        .hero-desc {
            color: var(--text-muted);
            font-size: 16px;
            max-width: 680px;
            margin: 0 auto;
        }
        .contact-grid {
            display: grid;
            grid-template-columns: 1fr 1.2fr;
            gap: 32px;
            align-items: start;
        }
        @media (max-width: 860px) {
            .contact-grid { grid-template-columns: 1fr; }
        }
        .info-card {
            background: var(--card-dark);
            border: 1px solid var(--border-color);
            border-radius: 14px;
            padding: 28px;
        }
        .info-item {
            display: flex;
            align-items: flex-start;
            gap: 16px;
            margin-bottom: 24px;
        }
        .info-icon {
            width: 46px;
            height: 46px;
            border-radius: 10px;
            background: rgba(2, 132, 199, 0.15);
            color: var(--primary-light);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }
        .info-text h4 {
            margin: 0 0 4px 0;
            color: #fff;
            font-size: 15px;
            font-weight: 700;
        }
        .info-text p {
            margin: 0;
            color: var(--text-muted);
            font-size: 14px;
        }
        .contact-form {
            background: var(--card-dark);
            border: 1px solid var(--border-color);
            border-radius: 14px;
            padding: 32px;
        }
        .form-group {
            margin-bottom: 18px;
        }
        .form-group label {
            display: block;
            margin-bottom: 6px;
            font-size: 13px;
            font-weight: 600;
            color: #cbd5e1;
        }
        .form-control {
            width: 100%;
            background: #090d16;
            border: 1px solid #334155;
            border-radius: 8px;
            padding: 12px 14px;
            color: #fff;
            font-size: 14px;
            outline: none;
            transition: border-color 0.2s;
        }
        .form-control:focus {
            border-color: var(--primary-light);
        }
        .btn-submit {
            background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
            color: #fff;
            border: none;
            padding: 14px 28px;
            border-radius: 8px;
            font-weight: 800;
            font-size: 15px;
            width: 100%;
            cursor: pointer;
            transition: opacity 0.2s;
        }
        .btn-submit:hover { opacity: 0.95; }
        .alert-success {
            background: #064e3b;
            border: 1px solid #10b981;
            color: #ecfdf5;
            padding: 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        .alert-danger {
            background: #7f1d1d;
            border: 1px solid #ef4444;
            color: #fef2f2;
            padding: 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="hero-section">
            <div class="hero-badge">
                <i class="fa-solid fa-headset"></i> HARİTA MÜHENDİSLİĞİ DANIŞMA HATTI
            </div>
            <h1 class="hero-title">Bizimle İletişime Geçin</h1>
            <p class="hero-desc">
                Türkiye genelinde kadastro parsel sorgu, imar durumu, aplikasyon krokisi ve teknik analiz ihtiyaçlarınız için lisanslı harita mühendislerimize danışabilirsiniz.
            </p>
        </div>

        <div class="contact-grid">
            <!-- Bilgiler -->
            <div class="info-card">
                <h3 style="color:#fff; font-size:18px; margin:0 0 20px 0; font-weight:800;">
                    <i class="fa-solid fa-building" style="color:var(--primary-light);"></i> Kurumsal İletişim Bilgileri
                </h3>

                <div class="info-item">
                    <div class="info-icon"><i class="fa-solid fa-location-dot"></i></div>
                    <div class="info-text">
                        <h4>Merkez Ofis</h4>
                        <p>Ant Harita Mühendislik Teknolojileri A.Ş.<br>Çankaya Cad. No: 42/B, Çankaya / Ankara</p>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon"><i class="fa-solid fa-phone"></i></div>
                    <div class="info-text">
                        <h4>Mühendis Danışma Hattı</h4>
                        <p>+90 542 841 35 35</p>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon"><i class="fa-brands fa-whatsapp" style="color:#22c55e;"></i></div>
                    <div class="info-text">
                        <h4>Canlı WhatsApp Destek</h4>
                        <p><a href="https://wa.me/905428413535" target="_blank" style="color:#22c55e; font-weight:bold; text-decoration:none;">0542 841 35 35 (Hemen Mesaj Gönderin)</a></p>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon"><i class="fa-solid fa-envelope"></i></div>
                    <div class="info-text">
                        <h4>E-Posta</h4>
                        <p>destek@parselsorgu.net</p>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon"><i class="fa-solid fa-certificate"></i></div>
                    <div class="info-text">
                        <h4>Mesleki Tescil &amp; Yetki</h4>
                        <p>TMMOB HKMO Sicil No: 12480 &bull; LİHKAB Akrediteli</p>
                    </div>
                </div>
            </div>

            <!-- Form -->
            <div class="contact-form">
                <h3 style="color:#fff; font-size:18px; margin:0 0 16px 0; font-weight:800;">
                    <i class="fa-solid fa-paper-plane" style="color:var(--primary-light);"></i> Parsel &amp; İmar Danışma Formu
                </h3>

                <?php if ($success_sent): ?>
                    <div class="alert-success">
                        <i class="fa-solid fa-circle-check"></i> Mesajınız başarıyla iletildi. Mühendislerimiz en kısa sürede sizinle irtibata geçecektir.
                    </div>
                <?php endif; ?>

                <?php if (!empty($error_sent)): ?>
                    <div class="alert-danger">
                        <i class="fa-solid fa-circle-exclamation"></i> <?= htmlspecialchars($error_sent) ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="/iletisim">
                    <div class="form-group">
                        <label>Adınız Soyadınız *</label>
                        <input type="text" name="name" class="form-control" placeholder="Adınız Soyadınız" required>
                    </div>

                    <div class="form-group">
                        <label>Telefon Numaranız *</label>
                        <input type="tel" name="phone" class="form-control" placeholder="05XX XXX XX XX" required>
                    </div>

                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                        <div class="form-group">
                            <label>İl / İlçe</label>
                            <input type="text" name="city" class="form-control" placeholder="Örn: Ankara Gölbaşı">
                        </div>
                        <div class="form-group">
                            <label>Ada / Parsel No</label>
                            <input type="text" name="ada_parsel" class="form-control" placeholder="Örn: 105 Ada / 12 Parsel">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Danışmak İstediğiniz Konu / Mesajınız</label>
                        <textarea name="message" class="form-control" rows="4" placeholder="İmar durumu, terk hesabı, bağ evi izni veya ekspertiz hakkında detay verin..."></textarea>
                    </div>

                    <button type="submit" name="contact_submit" class="btn-submit">
                        <i class="fa-solid fa-paper-plane"></i> Mesajı Gönder
                    </button>
                </form>
            </div>
        </div>
    </div>

</body>
</html>
