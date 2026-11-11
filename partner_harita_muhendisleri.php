<?php
/**
 * ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ - PARSEL PRO
 * 81 İl Yetkili Partner Harita Mühendisi (LİHKAB & SHKMMB) Ağı & Başvuru Portalı
 */
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/navbar.php';

$page_title = "81 İl Partner Harita Mühendisi Ağı (LİHKAB) | ParselSorgu";
$page_desc = "Türkiye geneli 81 ilde lisanslı harita kadastro mühendisleri (LİHKAB) ve serbest harita mühendislik büroları (SHKMMB) partner dizini.";
$canonical_url = "https://www.parselsorgu.net/partner-harita-muhendisleri";

global $pdo;
$submit_msg = '';
$submit_err = '';

if (isset($pdo) && $pdo) {
    try {
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS `harita_partner_muhendisler` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `ad_soyad` VARCHAR(150) NOT NULL,
                `firma_adi` VARCHAR(200) NOT NULL,
                `yetki_turu` VARCHAR(50) NOT NULL,
                `sicil_no` VARCHAR(80) DEFAULT NULL,
                `il` VARCHAR(60) NOT NULL,
                `ilce` VARCHAR(80) DEFAULT NULL,
                `telefon` VARCHAR(40) NOT NULL,
                `email` VARCHAR(120) DEFAULT NULL,
                `uzmanlik` TEXT DEFAULT NULL,
                `durum` VARCHAR(30) DEFAULT 'beklemede',
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ");

        $cnt = (int)$pdo->query("SELECT COUNT(*) FROM `harita_partner_muhendisler`")->fetchColumn();
        if ($cnt === 0) {
            $seed = [
                ['Mustafa Ant', 'Ant Harita Mühendislik Teknolojileri A.Ş.', 'LİHKAB & SHKMMB', 'HKMO 12480 / LİHKAB 06-042', 'Ankara', 'Çankaya (Tüm Türkiye)', '0542 841 35 35', 'iletisim@parselsorgu.net', 'Aplikasyon, Cins Değişikliği, 18. Madde İmar, Plankote, Halihazır', 'onayli'],
                ['Selim Demirtaş', 'Ege Kadastro & Harita Mühendislik', 'SHKMMB', 'HKMO 15842', 'İzmir', 'Urla / Çeşme / Seferihisar', '0532 000 35 00', 'izmir@parselsorgu.net', 'Zeytinlik İfrazı, Tiny House Zemin Aplikasyonu, Halihazır', 'onayli'],
                ['Ahmet Kılıç', 'Marmara LİHKAB & Müşavirlik', 'LİHKAB', 'LİHKAB 34-118', 'İstanbul', 'Silivri / Çatalca / Büyükçekmece', '0533 000 34 00', 'istanbul@parselsorgu.net', 'Cins Değişikliği, Tevhid, İfraz, Sınır Tespiti', 'onayli'],
                ['Kemal Yılmaz', 'Akdeniz Harita & Geomatik Bürosu', 'SHKMMB', 'HKMO 18910', 'Antalya', 'Manavgat / Alanya / Döşemealtı', '0535 000 07 00', 'antalya@parselsorgu.net', 'Arazi GES Plankote, Kıyı Kenar Çizgisi, Kuyu Koordinat Krokisi', 'onayli'],
                ['Hakan Özkan', 'Karadeniz Harita Mühendislik', 'SHKMMB', 'HKMO 14205', 'Trabzon', 'Ortahisar / Akçaabat', '0544 000 61 00', 'trabzon@parselsorgu.net', 'Eğim Analizi, Heyelan/İstinat Plankotesi, 2/B Kadastro', 'onayli']
            ];
            $st_seed = $pdo->prepare("INSERT INTO `harita_partner_muhendisler` (ad_soyad, firma_adi, yetki_turu, sicil_no, il, ilce, telefon, email, uzmanlik, durum) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            foreach ($seed as $row) { $st_seed->execute($row); }
        }
    } catch (Exception $e) {}
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['partner_submit'])) {
    $ad_soyad  = trim($_POST['ad_soyad'] ?? '');
    $firma_adi = trim($_POST['firma_adi'] ?? '');
    $yetki     = trim($_POST['yetki_turu'] ?? 'SHKMMB');
    $sicil     = trim($_POST['sicil_no'] ?? '');
    $il        = trim($_POST['il'] ?? '');
    $ilce      = trim($_POST['ilce'] ?? '');
    $telefon   = trim($_POST['telefon'] ?? '');
    $email     = trim($_POST['email'] ?? '');
    $uzmanlik  = trim($_POST['uzmanlik'] ?? '');

    if ($ad_soyad && $firma_adi && $il && $telefon) {
        try {
            if (isset($pdo) && $pdo) {
                $st = $pdo->prepare("INSERT INTO `harita_partner_muhendisler` (ad_soyad, firma_adi, yetki_turu, sicil_no, il, ilce, telefon, email, uzmanlik, durum) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'beklemede')");
                $st->execute([$ad_soyad, $firma_adi, $yetki, $sicil, $il, $ilce, $telefon, $email, $uzmanlik]);
            }
            if (file_exists(__DIR__ . '/telegram_lead_notifier.php')) {
                require_once __DIR__ . '/telegram_lead_notifier.php';
                @send_telegram_lead_notification('Yeni Partner Harita Mühendisi Başvurusu', [
                    'Mühendis' => $ad_soyad,
                    'Büro Adı' => $firma_adi,
                    'Yetki & Sicil' => "{$yetki} ({$sicil})",
                    'Bölge' => "{$il} / {$ilce}",
                    'Telefon' => $telefon,
                    'Uzmanlık' => $uzmanlik
                ]);
            }
            $submit_msg = "Başvurunuz başarıyla alındı! Ant Harita Partner Koordinasyon Ekibimiz sicil doğrulamasının ardından profilinizi 81 il dizininde aktif edecektir.";
        } catch (Exception $e) {
            $submit_err = "Kayıt sırasında bir hata oluştu.";
        }
    } else {
        $submit_err = "Lütfen ad soyad, büro adı, il ve telefon alanlarını doldurunuz.";
    }
}

$filter_il = trim($_GET['il'] ?? '');
$partners = [];
if (isset($pdo) && $pdo) {
    if ($filter_il !== '') {
        $st_p = $pdo->prepare("SELECT * FROM `harita_partner_muhendisler` WHERE `durum`='onayli' AND `il`=? ORDER BY `id` ASC");
        $st_p->execute([$filter_il]);
        $partners = $st_p->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $partners = $pdo->query("SELECT * FROM `harita_partner_muhendisler` WHERE `durum`='onayli' ORDER BY `id` ASC")->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($page_title) ?></title>
    <meta name="description" content="<?= htmlspecialchars($page_desc) ?>">
    <link rel="canonical" href="<?= $canonical_url ?>    <meta property="og:image" content="https://www.parselsorgu.net/assets/images/og-parsel.jpg">
">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root { --bg:#0a0f1d; --card:#111827; --border:#1f2937; --accent:#38bdf8; --emerald:#10b981; --amber:#f59e0b; --text:#f3f4f6; --muted:#9ca3af; }
        * { box-sizing:border-box; margin:0; padding:0; }
        body { background:var(--bg); color:var(--text); font-family:'Inter', sans-serif; line-height:1.6; padding-bottom:60px; }
        .container { max-width:1220px; margin:0 auto; padding:24px 16px; }
        .hero { text-align:center; padding:32px 16px 24px; }
        .hero-badge { display:inline-flex; align-items:center; gap:8px; background:rgba(56,189,248,0.15); color:var(--accent); padding:6px 14px; border-radius:9999px; font-size:13px; font-weight:700; margin-bottom:12px; border:1px solid rgba(56,189,248,0.3); }
        .hero h1 { font-size:30px; font-weight:800; color:#fff; margin-bottom:10px; }
        .hero h1 span { color:var(--accent); }
        .hero p { font-size:15px; color:var(--muted); max-width:780px; margin:0 auto; }

        .layout-grid { display:grid; grid-template-columns: 1fr 420px; gap:24px; margin-top:24px; }
        @media (max-width: 960px) { .layout-grid { grid-template-columns: 1fr; } }
        .panel { background:var(--card); border:1px solid var(--border); border-radius:16px; padding:24px; box-shadow:0 10px 25px rgba(0,0,0,0.45); }
        .panel-title { font-size:18px; font-weight:700; color:#fff; margin-bottom:18px; display:flex; align-items:center; gap:10px; border-bottom:1px solid var(--border); padding-bottom:12px; }
        .partner-card { background:#1a2234; border:1px solid #283548; border-radius:12px; padding:18px; margin-bottom:14px; transition:border-color 0.2s; }
        .partner-card:hover { border-color:var(--accent); }
        .badge-auth { background:rgba(16,185,129,0.15); color:var(--emerald); padding:3px 10px; border-radius:9999px; font-size:11px; font-weight:800; }
        .form-group { margin-bottom:12px; }
        .form-group label { display:block; font-size:12.5px; font-weight:600; margin-bottom:5px; color:var(--text); }
        .form-group input, .form-group select, .form-group textarea { width:100%; padding:10px 12px; background:#1f2937; border:1px solid #374151; border-radius:8px; color:#fff; font-size:13.5px; outline:none; }
        .btn-submit { width:100%; background:linear-gradient(135deg, #10b981 0%, #059669 100%); color:#fff; border:none; padding:12px; border-radius:10px; font-weight:800; font-size:14.5px; cursor:pointer; margin-top:6px; }
    </style>
    <link rel="alternate" type="text/markdown" href="https://www.parselsorgu.net/llms.txt" title="ParselSorgu AI Knowledge Base">
    <link rel="alternate" type="application/json" href="https://www.parselsorgu.net/api/2026-kadastro-endeks.json" title="2026 Türkiye Kadastro ve İnşaat Açık Veri Seti">

    <script type="application/ld+json">
    {
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    {
      "@type": "Question",
      "name": "ParselSorgu Partner Harita Mühendisi Ağına kimler katılabilir?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Türkiye'nin 81 ilinde aktif faaliyet gösteren LİHKAB (Lisanslı Harita Kadastro Mühendislik Büroları) ve TMMOB HKMO tescilli Serbest Harita Mühendislik Müşavirlik Büroları (SHKMMB) başvuru yapabilir."
      }
    },
    {
      "@type": "Question",
      "name": "Partner bürolara iş yönlendirmesi nasıl yapılır?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Anasayfa veya teklif motoru üzerinden gelen vatandaş talepleri, seçilen il ve ilçedeki onaylı çözüm ortağı harita mühendisliği bürolarına iletilir."
      }
    }
  ]
}
    </script>
    <script type="application/ld+json">{"@context": "https://schema.org", "@type": "WebPage", "speakable": {"@type": "SpeakableSpecification", "cssSelector": ["h1", ".lead", ".summary-box", ".hero-desc", "main p"]}, "isBasedOn": "https://www.parselsorgu.net/api/2026-kadastro-endeks.json", "publisher": {"@type": "Organization", "name": "Ant Harita Mühendislik - ParselSorgu.net", "url": "https://www.parselsorgu.net/"}}</script>
</head>
<body>
    <?= render_saas_navbar('eklentiler') ?>
    <main class="container">
        <section class="hero">
            <div class="hero-badge"><i class="fa-solid fa-network-wired"></i> Türkiye Geneli B2B Harita Mühendisliği İş Ağı</div>
            <h1>81 İl Yetkili <span>Partner Harita Mühendisleri</span></h1>
            <p>ParselSorgu.net üzerinden gelen aplikasyon, plankote, cins değişikliği ve imar uygulama talepleri için bölgenizdeki yetkili LİHKAB / SHKMMB bürolarıyla çalışın veya iş ağımıza katılın.</p>
        </section>

        <?php if ($submit_msg): ?>
            <div style="background:rgba(16,185,129,0.15); border:1px solid #10b981; color:#6ee7b7; padding:14px 18px; border-radius:10px; margin-bottom:20px; font-weight:600;">
                <i class="fa-solid fa-circle-check"></i> <?= htmlspecialchars($submit_msg) ?>
            </div>
        <?php endif; ?>
        <?php if ($submit_err): ?>
            <div style="background:rgba(239,68,68,0.15); border:1px solid #ef4444; color:#fca5a5; padding:14px 18px; border-radius:10px; margin-bottom:20px; font-weight:600;">
                <i class="fa-solid fa-triangle-exclamation"></i> <?= htmlspecialchars($submit_err) ?>
            </div>
        <?php endif; ?>

        <div class="layout-grid">
            <!-- PARTNER DIRECTORY -->
            <div class="panel">
                <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px; margin-bottom:18px; border-bottom:1px solid var(--border); padding-bottom:12px;">
                    <h2 style="font-size:18px; color:#fff; margin:0;"><i class="fa-solid fa-map-pin" style="color:var(--accent);"></i> Onaylı Çözüm Ortağı Bürolar</h2>
                    <form method="GET" style="display:flex; gap:8px;">
                        <select name="il" onchange="this.form.submit()" style="background:#1f2937; border:1px solid #374151; color:#fff; padding:6px 12px; border-radius:8px; font-size:13px;">
                            <option value="">Tüm Türkiye (Filtrele)</option>
                            <option value="Ankara" <?= $filter_il==='Ankara'?'selected':'' ?>>Ankara</option>
                            <option value="İstanbul" <?= $filter_il==='İstanbul'?'selected':'' ?>>İstanbul</option>
                            <option value="İzmir" <?= $filter_il==='İzmir'?'selected':'' ?>>İzmir</option>
                            <option value="Antalya" <?= $filter_il==='Antalya'?'selected':'' ?>>Antalya</option>
                            <option value="Trabzon" <?= $filter_il==='Trabzon'?'selected':'' ?>>Trabzon</option>
                        </select>
                    </form>
                </div>

                <?php if (empty($partners)): ?>
                    <p style="color:var(--muted); padding:20px 0;">Seçili ilde henüz aktif partner görünmüyor. İlk partner büro olmak için sağdaki formu doldurun!</p>
                <?php else: ?>
                    <?php foreach ($partners as $p): ?>
                        <div class="partner-card">
                            <div style="display:flex; justify-content:space-between; align-items:flex-start; gap:10px; flex-wrap:wrap;">
                                <div>
                                    <h3 style="font-size:16px; color:#fff; font-weight:800;"><?= htmlspecialchars($p['firma_adi']) ?></h3>
                                    <div style="font-size:12.5px; color:var(--accent); font-weight:600; margin-top:2px;">
                                        <i class="fa-solid fa-user-tie"></i> <?= htmlspecialchars($p['ad_soyad']) ?> &bull; <?= htmlspecialchars($p['sicil_no']) ?>
                                    </div>
                                </div>
                                <span class="badge-auth"><?= htmlspecialchars($p['yetki_turu']) ?></span>
                            </div>
                            <div style="font-size:12.5px; color:var(--muted); margin:10px 0;">
                                <strong><i class="fa-solid fa-location-dot" style="color:#f59e0b;"></i> Hizmet Bölgesi:</strong> <?= htmlspecialchars($p['il']) ?> / <?= htmlspecialchars($p['ilce']) ?><br>
                                <strong><i class="fa-solid fa-briefcase" style="color:#10b981;"></i> Uzmanlık:</strong> <?= htmlspecialchars($p['uzmanlik']) ?>
                            </div>
                            <div style="display:flex; gap:10px; flex-wrap:wrap; margin-top:12px;">
                                <a href="/harita-muhendislik-fiyat-teklifi?il=<?= urlencode($p['il']) ?>" style="background:rgba(56,189,248,0.15); color:#38bdf8; border:1px solid rgba(56,189,248,0.35); padding:6px 14px; border-radius:8px; font-size:12px; font-weight:700; text-decoration:none;">
                                    <i class="fa-solid fa-file-signature"></i> Fiyat Teklifi İste
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- PARTNER APPLICATION FORM -->
            <div class="panel">
                <h2 class="panel-title"><i class="fa-solid fa-user-plus" style="color:var(--emerald);"></i> B2B Partner Başvurusu</h2>
                <p style="font-size:12.5px; color:var(--muted); margin-bottom:14px;">LİHKAB veya SHKMMB büronuzu 81 il iş ağımıza ekleyin; ilinizden gelen parsel aplikasyon ve mühendislik talepleri size yönlendirilsin.</p>
                <form method="POST">
                    <input type="hidden" name="partner_submit" value="1">
                    <div class="form-group">
                        <label>Harita Mühendisi Adı Soyadı *</label>
                        <input type="text" name="ad_soyad" required placeholder="Örn: Müh. Kemal Kaya">
                    </div>
                    <div class="form-group">
                        <label>Büro / Firma Ünvanı *</label>
                        <input type="text" name="firma_adi" required placeholder="Örn: Kaya Harita Mühendislik Ltd.">
                    </div>
                    <div class="form-group">
                        <label>Büro Yetki Türü &amp; HKMO/LİHKAB Sicil No</label>
                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:8px;">
                            <select name="yetki_turu">
                                <option value="SHKMMB">SHKMMB (Serbest)</option>
                                <option value="LİHKAB">LİHKAB (Lisanslı)</option>
                                <option value="LİHKAB & SHKMMB">Her İkisi</option>
                            </select>
                            <input type="text" name="sicil_no" placeholder="Sicil: 12345">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Hizmet Verdiğiniz İl &amp; İlçeler *</label>
                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:8px;">
                            <input type="text" name="il" required placeholder="İl (Örn: Muğla)">
                            <input type="text" name="ilce" placeholder="İlçeler (Örn: Bodrum, Milas)">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Cep Telefonu (WhatsApp) *</label>
                        <input type="tel" name="telefon" required placeholder="05XX XXX XX XX">
                    </div>
                    <div class="form-group">
                        <label>E-Posta Adresi</label>
                        <input type="email" name="email" placeholder="ornek@haritaburosu.com">
                    </div>
                    <div class="form-group">
                        <label>Uzmanlık Alanları</label>
                        <textarea name="uzmanlik" rows="2" placeholder="Aplikasyon, Plankote, Halihazır, 18. Madde, GES..."></textarea>
                    </div>
                    <button type="submit" class="btn-submit"><i class="fa-solid fa-paper-plane"></i> Partner Başvurusu Gönder</button>
                </form>
            </div>
        </div>
    
        <section style="margin-top:36px; background:#111827; border:1px solid #1f2937; border-radius:16px; padding:24px;">
            <h2 style="font-size:19px; font-weight:800; color:#fff; margin-bottom:16px;"><i class="fa-solid fa-book-open" style="color:#10b981;"></i> Sıkça Sorulan Sorular &amp; 2026 Mevzuat Özeti</h2>
            
            <div style="margin-bottom:14px; border-bottom:1px solid #1f2937; padding-bottom:12px;">
                <h4 style="font-size:14.5px; color:#f8fafc; font-weight:700; margin-bottom:5px;"><i class="fa-solid fa-circle-question" style="color:#38bdf8;"></i> ParselSorgu Partner Harita Mühendisi Ağına kimler katılabilir?</h4>
                <p style="font-size:13px; color:#9ca3af; line-height:1.6;">Türkiye'nin 81 ilinde aktif faaliyet gösteren LİHKAB (Lisanslı Harita Kadastro Mühendislik Büroları) ve TMMOB HKMO tescilli Serbest Harita Mühendislik Müşavirlik Büroları (SHKMMB) başvuru yapabilir.</p>
            </div>
            <div style="margin-bottom:14px; border-bottom:1px solid #1f2937; padding-bottom:12px;">
                <h4 style="font-size:14.5px; color:#f8fafc; font-weight:700; margin-bottom:5px;"><i class="fa-solid fa-circle-question" style="color:#38bdf8;"></i> Partner bürolara iş yönlendirmesi nasıl yapılır?</h4>
                <p style="font-size:13px; color:#9ca3af; line-height:1.6;">Anasayfa veya teklif motoru üzerinden gelen vatandaş talepleri, seçilen il ve ilçedeki onaylı çözüm ortağı harita mühendisliği bürolarına iletilir.</p>
            </div>
        </section>
    </main>
</body>
</html>
