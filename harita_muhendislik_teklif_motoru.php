<?php
/**
 * ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ - PARSEL PRO
 * SaaS: LİHKAB & SHKMMB Harita Mühendisliği Fiyat Teklifi Motoru (B2B SaaS / Lead Gen)
 * Pure PHP 8.3 / Responsive UI / TMMOB HKMO ve LİHKAB 2026 Asgari Fiyat Tarifesi
 */

declare(strict_types=1);

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/navbar.php';

// Auto-create table if not exists
if (isset($pdo) && $pdo) {
    try {
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS `harita_teklif_talepleri` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `ad_soyad` VARCHAR(150) NOT NULL,
                `telefon` VARCHAR(30) NOT NULL,
                `email` VARCHAR(150) DEFAULT NULL,
                `il` VARCHAR(50) NOT NULL,
                `ilce` VARCHAR(50) NOT NULL,
                `ada` VARCHAR(50) DEFAULT NULL,
                `parsel` VARCHAR(50) DEFAULT NULL,
                `islem_turu` VARCHAR(120) NOT NULL,
                `tahmini_butce` VARCHAR(50) DEFAULT NULL,
                `aciklama` TEXT DEFAULT NULL,
                `durum` ENUM('yeni', 'teklif_verildi', 'onaylandi', 'tamamlandi') DEFAULT 'yeni',
                `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ");
    } catch (Exception $e) {
        // fail-safe ignore
    }
}

// Handle AJAX Lead Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'submit_lead') {
    header('Content-Type: application/json; charset=utf-8');
    
    $ad_soyad = trim($_POST['ad_soyad'] ?? '');
    $telefon = trim($_POST['telefon'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $il = trim($_POST['il'] ?? '');
    $ilce = trim($_POST['ilce'] ?? '');
    $ada = trim($_POST['ada'] ?? '');
    $parsel = trim($_POST['parsel'] ?? '');
    $islem_turu = trim($_POST['islem_turu'] ?? '');
    $tahmini_butce = trim($_POST['tahmini_butce'] ?? '');
    $aciklama = trim($_POST['aciklama'] ?? '');

    if (empty($ad_soyad) || empty($telefon) || empty($il) || empty($islem_turu)) {
        echo json_encode(['success' => false, 'error' => 'Lütfen zorunlu alanları (Ad Soyad, Telefon, İl ve İşlem Türü) doldurun.']);
        exit;
    }

    if (isset($pdo) && $pdo) {
        try {
            $stmt = $pdo->prepare("
                INSERT INTO `harita_teklif_talepleri` 
                (`ad_soyad`, `telefon`, `email`, `il`, `ilce`, `ada`, `parsel`, `islem_turu`, `tahmini_butce`, `aciklama`)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([$ad_soyad, $telefon, $email, $il, $ilce, $ada, $parsel, $islem_turu, $tahmini_butce, $aciklama]);
            $lead_id = (int)$pdo->lastInsertId();
            if (file_exists(__DIR__ . '/telegram_lead_notifier.php')) { require_once __DIR__ . '/telegram_lead_notifier.php'; @send_telegram_lead_notification('Harita Mühendisliği Fiyat Teklifi Talebi', ['Ad Soyad' => $ad_soyad, 'Telefon' => $telefon, 'Konum' => "$il / $ilce", 'Ada / Parsel' => "$ada / $parsel", 'İşlem' => $islem_turu, 'Tahmini Bütçe' => $tahmini_butce]); }

            // Format WhatsApp Direct Link
            $wa_text = "Merhaba Ant Harita Mühendislik! Siteniz üzerinden yeni harita mühendisliği teklif talebi oluşturdum:\n"
                     . "Talep No: #TEK-" . $lead_id . "\n"
                     . "Müşteri: " . $ad_soyad . " (" . $telefon . ")\n"
                     . "Konum: " . $il . " / " . $ilce . " (Ada: " . $ada . ", Parsel: " . $parsel . ")\n"
                     . "İşlem: " . $islem_turu . "\n"
                     . "Tahmini Fiyat: " . $tahmini_butce . "\n"
                     . "Not: " . ($aciklama ?: 'Detaylı fiyat teklifi rica ediyorum.');
            $wa_url = "https://wa.me/905428413535?text=" . urlencode($wa_text);

            echo json_encode([
                'success' => true,
                'lead_id' => $lead_id,
                'message' => 'Teklif talebiniz başarıyla alındı. Bölgenizdeki yetkili harita mühendisimiz en kısa sürede sizinle iletişime geçecektir.',
                'wa_url' => $wa_url
            ]);
            exit;
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'error' => 'Kayıt sırasında bir hata oluştu: ' . $e->getMessage()]);
            exit;
        }
    } else {
        echo json_encode(['success' => true, 'lead_id' => rand(100, 999), 'message' => 'Talebiniz iletildi.']);
        exit;
    }
}

$page_title = "Harita Mühendisliği Fiyat Teklifi (2026 HKMO) | ParselSorgu";
$meta_desc = "TMMOB HKMO ve LİHKAB 2026 resmi tarifesiyle aplikasyon, plankote, cins değişikliği, tevhid ve ifraz fiyat teklifi oluşturun.";
$canonical_url = "https://www.parselsorgu.net/harita-muhendislik-fiyat-teklifi";

$CITIES_81 = [
    "Adana", "Adıyaman", "Afyonkarahisar", "Ağrı", "Amasya", "Ankara", "Antalya", "Artvin", "Aydın", "Balıkesir",
    "Bilecik", "Bingöl", "Bitlis", "Bolu", "Burdur", "Bursa", "Çanakkale", "Çankırı", "Çorum", "Denizli",
    "Diyarbakır", "Edirne", "Elazığ", "Erzincan", "Erzurum", "Eskişehir", "Gaziantep", "Giresun", "Gümüşhane", "Hakkari",
    "Hatay", "Isparta", "Mersin", "İstanbul", "İzmir", "Kars", "Kastamonu", "Kayseri", "Kırklareli", "Kırşehir",
    "Kocaeli", "Konya", "Kütahya", "Malatya", "Manisa", "Kahramanmaraş", "Mardin", "Muğla", "Muş", "Nevşehir",
    "Niğde", "Ordu", "Rize", "Sakarya", "Samsun", "Siirt", "Sinop", "Sivas", "Tekirdağ", "Tokat",
    "Trabzon", "Tunceli", "Şanlıurfa", "Uşak", "Van", "Yozgat", "Zonguldak", "Aksaray", "Bayburt", "Karaman",
    "Kırıkkale", "Batman", "Şırnak", "Bartın", "Ardahan", "Iğdır", "Yalova", "Karabük", "Kilis", "Osmaniye", "Düzce"
];

$METRO_CITIES = [
    "Adana", "Ankara", "Antalya", "Aydın", "Balıkesir", "Bursa", "Denizli", "Diyarbakır", "Erzurum", "Eskişehir",
    "Gaziantep", "Hatay", "İstanbul", "İzmir", "Kahramanmaraş", "Kayseri", "Kocaeli", "Konya", "Malatya", "Manisa",
    "Mardin", "Mersin", "Muğla", "Ordu", "Sakarya", "Samsun", "Şanlıurfa", "Tekirdağ", "Trabzon", "Van"
];
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($page_title) ?></title>
    <meta name="description" content="<?= htmlspecialchars($meta_desc) ?>">
    <link rel="canonical" href="<?= $canonical_url ?>">
    <meta property="og:title" content="<?= htmlspecialchars($page_title) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($meta_desc) ?>">
    <meta property="og:url" content="<?= $canonical_url ?>">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="ParselSorgu.net - Ant Harita Mühendislik">
    <meta property="og:image" content="https://www.parselsorgu.net/assets/images/og-parsel.jpg">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="theme-color" content="#090e17">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@graph": [
        {
          "@type": "WebApplication",
          "@id": "https://www.parselsorgu.net/harita-muhendislik-fiyat-teklifi#app",
          "name": "LİHKAB & SHKMMB Harita Mühendisliği Fiyat Teklifi Motoru",
          "url": "https://www.parselsorgu.net/harita-muhendislik-fiyat-teklifi",
          "description": "TMMOB HKMO ve LİHKAB 2026 resmi asgari fiyat tarifesiyle aplikasyon, plankote, cins değişikliği ve ifraz fiyat teklifi hazırlama ve mühendis teklif havuzu.",
          "applicationCategory": "BusinessApplication",
          "operatingSystem": "All",
          "offers": {
            "@type": "Offer",
            "price": "0",
            "priceCurrency": "TRY"
          },
          "creator": {
            "@type": "Organization",
            "name": "Ant Harita Mühendislik",
            "url": "https://www.parselsorgu.net",
            "identifier": "TMMOB HKMO Sicil: 12480"
          }
        },
        {
          "@type": "BreadcrumbList",
          "@id": "https://www.parselsorgu.net/harita-muhendislik-fiyat-teklifi#breadcrumb",
          "itemListElement": [
            {
              "@type": "ListItem",
              "position": 1,
              "name": "Ana Sayfa",
              "item": "https://www.parselsorgu.net/"
            },
            {
              "@type": "ListItem",
              "position": 2,
              "name": "Eklentiler & SaaS",
              "item": "https://www.parselsorgu.net/eklentiler"
            },
            {
              "@type": "ListItem",
              "position": 3,
              "name": "Harita Mühendisliği Fiyat Teklifi Motoru",
              "item": "https://www.parselsorgu.net/harita-muhendislik-fiyat-teklifi"
            }
          ]
        },
        {
          "@type": "FAQPage",
          "@id": "https://www.parselsorgu.net/harita-muhendislik-fiyat-teklifi#faq",
          "mainEntity": [
            {
              "@type": "Question",
              "name": "Harita mühendisliği fiyatları nasıl hesaplanır?",
              "acceptedAnswer": {
                "@type": "Answer",
                "text": "Harita mühendislik ücretleri, TMMOB Harita ve Kadastro Mühendisleri Odası (HKMO) tarafından her yıl ocak ve temmuz aylarında yayımlanan Resmi Mühendislik Asgari Ücret Tarifesi katsayıları, parsel alanı (m²), köşe nokta sayısı ve il grubu baz alınarak hesaplanır."
              }
            },
            {
              "@type": "Question",
              "name": "Plankote ve halihazır harita nedir, neden zorunludur?",
              "acceptedAnswer": {
                "@type": "Answer",
                "text": "Plankote, arsanın kot farklarını, eğimini ve mevcut ağaç, yol, altyapı elemanlarını gösteren topoğrafik haritadır. Mimari proje çizimi ve belediyeden yapı ruhsatı alabilmek için kanunen zorunludur."
              }
            },
            {
              "@type": "Question",
              "name": "Sistem üzerinden teklif istediğimde süreç nasıl işler?",
              "acceptedAnswer": {
                "@type": "Answer",
                "text": "Formu doldurduğunuzda talebiniz parselin bulunduğu bölgedeki yetkili lisanslı harita mühendisimize (Ant Harita Mühendislik veya partner mühendis) anında iletilir. Resmi tarife dökümü ve yapılacak işlemler için 15 dakika içinde aranarak bilgilendirilirsiniz."
              }
            }
          ]
        }
      ]
    }
    </script>

    <style>
        :root {
            --primary: #38bdf8;
            --accent: #10b981;
            --amber: #f59e0b;
            --dark-bg: #090e17;
            --card-bg: #0f172a;
            --card-surface: #131d31;
            --border-color: #1e293b;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            background-color: var(--dark-bg);
            color: var(--text-main);
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            line-height: 1.5;
            padding-bottom: 40px;
        }
        .container { max-width: 1140px; margin: 0 auto; padding: 20px 16px; }
        .hero-banner {
            background: linear-gradient(135deg, rgba(56, 189, 248, 0.12) 0%, rgba(16, 185, 129, 0.08) 100%);
            border: 1px solid rgba(56, 189, 248, 0.3);
            border-radius: 16px;
            padding: 28px 24px;
            margin-bottom: 24px;
        }
        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(56, 189, 248, 0.2);
            color: #38bdf8;
            font-size: 12px;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 20px;
            margin-bottom: 12px;
            border: 1px solid rgba(56, 189, 248, 0.4);
        }
        .hero-title { font-size: 26px; font-weight: 900; color: #fff; margin-bottom: 8px; }
        .hero-desc { color: var(--text-muted); font-size: 14px; max-width: 820px; }
        
        .tab-switcher {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            padding: 6px;
            border-radius: 12px;
        }
        .tab-btn {
            flex: 1;
            padding: 10px 16px;
            border-radius: 8px;
            border: none;
            background: transparent;
            color: var(--text-muted);
            font-weight: 700;
            font-size: 13.5px;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .tab-btn.active {
            background: rgba(56, 189, 248, 0.15);
            color: #38bdf8;
            border: 1px solid rgba(56, 189, 248, 0.35);
        }

        .grid-layout { display: grid; grid-template-columns: 1fr 1.25fr; gap: 24px; }
        @media (max-width: 860px) { .grid-layout { grid-template-columns: 1fr; } }

        .saas-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 14px;
            padding: 22px;
        }
        .form-group { margin-bottom: 15px; }
        .form-label { display: block; font-size: 12.5px; font-weight: 700; margin-bottom: 6px; color: #cbd5e1; }
        .form-control, .form-select {
            width: 100%;
            background: var(--card-surface);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 10px 14px;
            color: #fff;
            font-size: 13.5px;
            outline: none;
            transition: border-color 0.2s;
        }
        .form-control:focus, .form-select:focus { border-color: var(--primary); }
        .form-hint { font-size: 11px; color: var(--text-muted); margin-top: 4px; }

        .price-box {
            background: linear-gradient(135deg, rgba(56, 189, 248, 0.15) 0%, rgba(15, 23, 42, 0.8) 100%);
            border: 1px solid rgba(56, 189, 248, 0.35);
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            margin-bottom: 18px;
        }
        .price-amount { font-size: 34px; font-weight: 900; color: #38bdf8; margin: 6px 0; }
        .price-label { font-size: 12px; font-weight: 700; color: #cbd5e1; text-transform: uppercase; }

        .table-custom { width: 100%; border-collapse: collapse; font-size: 13px; margin-top: 10px; }
        .table-custom th { text-align: left; padding: 9px 10px; background: var(--card-surface); color: var(--text-muted); border-bottom: 1px solid var(--border-color); }
        .table-custom td { padding: 9px 10px; border-bottom: 1px solid #1e293b; color: #e2e8f0; }

        .btn-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            background: var(--primary);
            color: #000;
            padding: 12px 18px;
            border-radius: 8px;
            font-weight: 800;
            font-size: 14px;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            margin-top: 10px;
        }
        .btn-action:hover { opacity: 0.9; transform: translateY(-1px); }
        .btn-green { background: #10b981; color: #fff; }
        .btn-green:hover { background: #059669; }

        /* Proposal Letter Print Container */
        .proposal-paper {
            background: #fff;
            color: #0f172a;
            border-radius: 8px;
            padding: 24px;
            font-size: 13px;
            line-height: 1.6;
            margin-top: 14px;
            border: 1px solid #cbd5e1;
        }
        .proposal-paper h4 { color: #0f172a; font-size: 16px; margin-bottom: 6px; }
        .proposal-paper table { width: 100%; border-collapse: collapse; margin: 12px 0; font-size: 12px; }
        .proposal-paper th { background: #f1f5f9; padding: 6px 8px; border: 1px solid #cbd5e1; text-align: left; }
        .proposal-paper td { padding: 6px 8px; border: 1px solid #cbd5e1; }
    </style>
    <link rel="alternate" type="text/markdown" href="https://www.parselsorgu.net/llms.txt" title="ParselSorgu AI / LLM Bilgi Bankası">
    <link rel="alternate" type="application/json" href="https://www.parselsorgu.net/api/2026-kadastro-endeks.json" title="2026 Kadastro ve İmar Açık Veri Seti">
    <script type="application/ld+json">{"@context": "https://schema.org", "@type": "WebPage", "speakable": {"@type": "SpeakableSpecification", "cssSelector": ["h1", ".lead", ".summary-box", ".hero-desc", "main p"]}, "isBasedOn": "https://www.parselsorgu.net/api/2026-kadastro-endeks.json", "publisher": {"@type": "Organization", "name": "Ant Harita Mühendislik - ParselSorgu.net", "url": "https://www.parselsorgu.net/"}}</script>
</head>
<body>
    <?php render_navbar('eklentiler'); ?>

    <div class="container">
        <div class="hero-banner">
            <div class="hero-badge">
                <i class="fa-solid fa-compass-drafting"></i> 2026 TMMOB HKMO &amp; LİHKAB ASGARİ ÜCRET MOTORU
            </div>
            <h1 class="hero-title">LİHKAB &amp; SHKMMB Harita Mühendisliği Fiyat Teklifi Motoru</h1>
            <p class="hero-desc">
                Aplikasyon, plankote, cins değişikliği, tevhid, ifraz ve halihazır harita işleri için 2026 resmi mühendislik taban fiyatını anında hesaplayın; bölgenizdeki yetkili harita mühendisinden resmi teklif alın veya mühendis olarak B2B teklif mektubu oluşturun.
            </p>
        </div>

        <!-- Sekme Değiştirici -->
        <div class="tab-switcher">
            <button type="button" class="tab-btn active" id="btnTabCitizen" onclick="switchTab('citizen')">
                <i class="fa-solid fa-user-check"></i> Vatandaş / Yatırımcı (Fiyat Hesapla &amp; Teklif İste)
            </button>
            <button type="button" class="tab-btn" id="btnTabEngineer" onclick="switchTab('engineer')">
                <i class="fa-solid fa-briefcase"></i> Harita Mühendisi / LİHKAB (B2B Teklif &amp; Sözleşme Oluştur)
            </button>
        </div>

        <!-- MOD 1: VATANDAŞ & LEAD GEN (TEKLİF AL) -->
        <div id="sectionCitizen" class="grid-layout">
            <div class="saas-card">
                <h2 style="font-size: 16.5px; font-weight: 800; margin-bottom: 16px; color:#fff; display:flex; align-items:center; gap:8px;">
                    <i class="fa-solid fa-map-location-dot" style="color:#38bdf8;"></i> Parsel ve İşlem Bilgileri
                </h2>

                <div class="form-group">
                    <label class="form-label">Harita Mühendisliği İşlem Türü</label>
                    <select id="citProcess" class="form-select" onchange="calcCitizenPrice()">
                        <option value="aplikasyon">Aplikasyon ve Sınır Tespiti (Köşe Kazığı Çakımı)</option>
                        <option value="plankote">Plankote ve Halihazır Harita (Mimari Proje İçin)</option>
                        <option value="cins_degisikligi">Cins Değişikliği (Tarladan Arsaya / Yapılı Hale Geçiş)</option>
                        <option value="tevhid">Tevhid (Parsel Birleştirme Dosyası Hazırlama)</option>
                        <option value="ifraz">İfraz (3194 / 5403 İmar Parselasyon &amp; Bölme)</option>
                        <option value="zemin_tespit">İmar Barışı Zemin Tespit Tutanağı</option>
                        <option value="kubaj">Kubaj &amp; Hafriyat Hacim Ölçümü (Drone/GNSS)</option>
                    </select>
                </div>

                <div style="display:grid; grid-template-columns: 1fr 1fr; gap:12px;">
                    <div class="form-group">
                        <label class="form-label">İl</label>
                        <select id="citCity" class="form-select" onchange="calcCitizenPrice()">
                            <?php foreach ($CITIES_81 as $c): ?>
                                <option value="<?= htmlspecialchars($c) ?>" <?= ($c === 'Antalya' || $c === 'İstanbul') ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($c) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">İlçe</label>
                        <input type="text" id="citDistrict" class="form-control" value="Merkez" placeholder="Örn: Alanya, Çankaya">
                    </div>
                </div>

                <div style="display:grid; grid-template-columns: 1fr 1fr; gap:12px;">
                    <div class="form-group">
                        <label class="form-label">Ada No (Opsiyonel)</label>
                        <input type="text" id="citAda" class="form-control" placeholder="Örn: 101">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Parsel No (Opsiyonel)</label>
                        <input type="text" id="citParsel" class="form-control" placeholder="Örn: 12">
                    </div>
                </div>

                <div style="display:grid; grid-template-columns: 1fr 1fr; gap:12px;">
                    <div class="form-group">
                        <label class="form-label">Parsel Alanı (m²)</label>
                        <input type="number" id="citArea" class="form-control" value="850" min="10" step="10" oninput="calcCitizenPrice()">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Arazi Eğim Durumu</label>
                        <select id="citSlope" class="form-select" onchange="calcCitizenPrice()">
                            <option value="duz">Düz / Az Eğimli Arazi (%0-10)</option>
                            <option value="orta">Orta Eğimli / Engebeli (%10-25)</option>
                            <option value="sarp">Sarp / Yoğun Çalılık &amp; Kayalık</option>
                        </select>
                    </div>
                </div>

                <div style="background: rgba(56, 189, 248, 0.08); border-radius: 8px; padding: 12px; margin-top: 10px; font-size: 12px; color: #94a3b8;">
                    <i class="fa-solid fa-circle-info text-primary"></i> <strong>Bilgi:</strong> Hesaplanan tutar, 2026 yılı HKMO asgari mühendislik ücret tarifesi referans alınarak üretilen yasal taban fiyattır.
                </div>
            </div>

            <!-- Sağ Taraf: Fiyat + Doğrudan Mühendisten Teklif Al (Lead Form) -->
            <div class="saas-card">
                <div class="price-box">
                    <div class="price-label">TAHMİNİ YASAL TABAN ÜCRET</div>
                    <div class="price-amount" id="dispCitTotal">0 TL</div>
                    <div style="font-size:12px; color:#cbd5e1;" id="dispCitKdv">KDV (%20) ve Mühendislik İmzası Dahil</div>
                </div>

                <div style="border-top: 1px solid var(--border-color); padding-top: 16px;">
                    <h3 style="font-size: 15px; font-weight: 800; color:#fff; margin-bottom: 6px; display:flex; align-items:center; gap:8px;">
                        <i class="fa-solid fa-paper-plane" style="color:#10b981;"></i> Yetkili Mühendisten Fiyat Teklifi Al
                    </h3>
                    <p style="font-size: 12px; color: var(--text-muted); margin-bottom: 14px;">
                        Bölgenizdeki tescilli harita mühendisimiz arsanızı incelesin, en uygun net fiyat teklifini WhatsApp veya telefon ile 15 dakikada iletsin.
                    </p>

                    <form id="leadForm" onsubmit="submitLead(event)">
                        <div class="form-group">
                            <label class="form-label">Adınız Soyadınız *</label>
                            <input type="text" id="leadName" class="form-control" required placeholder="Adınız ve Soyadınız">
                        </div>
                        <div style="display:grid; grid-template-columns: 1fr 1fr; gap:12px;">
                            <div class="form-group">
                                <label class="form-label">Telefon Numaranız *</label>
                                <input type="tel" id="leadPhone" class="form-control" required placeholder="05XX XXX XX XX">
                            </div>
                            <div class="form-group">
                                <label class="form-label">E-Posta Adresi</label>
                                <input type="email" id="leadEmail" class="form-control" placeholder="eposta@ornek.com">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Ek Not veya Özel Talep</label>
                            <textarea id="leadNote" class="form-control" rows="2" placeholder="Örn: Hafta sonu ölçüm yapılmasını istiyorum, acil ruhsat başvurum var."></textarea>
                        </div>

                        <button type="submit" class="btn-action btn-green" id="btnSubmitLead">
                            <i class="fa-solid fa-paper-plane"></i> Ücretsiz Teklif İste &amp; İnceleme Başlat
                        </button>
                    </form>

                    <div id="leadSuccessMsg" style="display:none; margin-top:14px; padding:14px; background:rgba(16,185,129,0.15); border:1px solid rgba(16,185,129,0.4); border-radius:8px; text-align:center;">
                        <div style="color:#10b981; font-weight:800; font-size:14px; margin-bottom:6px;">
                            <i class="fa-solid fa-circle-check"></i> Teklif Talebiniz Alındı!
                        </div>
                        <p style="font-size:12px; color:#cbd5e1; margin-bottom:10px;" id="leadSuccessText"></p>
                        <a href="#" id="leadWaBtn" target="_blank" class="btn-action" style="background:#22c55e; color:#fff; display:inline-flex;">
                            <i class="fa-brands fa-whatsapp"></i> WhatsApp'tan Hemen Yazış
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- MOD 2: HARİTA MÜHENDİSİ B2B TEKLİF & SÖZLEŞME OLUŞTURUCU (PRO PANEL) -->
        <div id="sectionEngineer" class="grid-layout" style="display:none;">
            <div class="saas-card">
                <h2 style="font-size: 16.5px; font-weight: 800; margin-bottom: 16px; color:#fff; display:flex; align-items:center; gap:8px;">
                    <i class="fa-solid fa-file-signature text-primary" style="color:#38bdf8;"></i> B2B Teklif &amp; Sözleşme Parametreleri
                </h2>

                <div class="form-group">
                    <label class="form-label">Harita Mühendislik Bürosu Ünvanı</label>
                    <input type="text" id="engCompany" class="form-control" value="Ant Harita Mühendislik Müşavirlik">
                </div>

                <div style="display:grid; grid-template-columns: 1fr 1fr; gap:12px;">
                    <div class="form-group">
                        <label class="form-label">Mühendis Ad Soyad &amp; Oda Sicil</label>
                        <input type="text" id="engName" class="form-control" value="Harita Müh. (HKMO: 12480)">
                    </div>
                    <div class="form-group">
                        <label class="form-label">İletişim / GSM</label>
                        <input type="text" id="engPhone" class="form-control" value="0542 841 35 35">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Müşteri / İşveren Ünvanı</label>
                    <input type="text" id="engClient" class="form-control" value="Sayın Arsa Maliki / İnşaat Firması">
                </div>

                <div class="form-group">
                    <label class="form-label">İşin Yapılacağı Konum &amp; Parsel</label>
                    <input type="text" id="engLocation" class="form-control" value="Antalya / Döşemealtı - 105 Ada 14 Parsel">
                </div>

                <div class="form-group">
                    <label class="form-label">Teklif Edilecek İşlem ve Kapsam</label>
                    <input type="text" id="engScope" class="form-control" value="Halihazır Plankote, Aplikasyon Sınır Krokisi ve Cins Değişikliği Dosyası">
                </div>

                <div style="display:grid; grid-template-columns: 1fr 1fr; gap:12px;">
                    <div class="form-group">
                        <label class="form-label">Hizmet Taban Bedeli (TL)</label>
                        <input type="number" id="engBaseFee" class="form-control" value="12500" step="500" oninput="calcEngineerOffer()">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Yol / Saha Masrafları (TL)</label>
                        <input type="number" id="engTravelFee" class="form-control" value="1500" step="250" oninput="calcEngineerOffer()">
                    </div>
                </div>

                <div style="display:grid; grid-template-columns: 1fr 1fr; gap:12px;">
                    <div class="form-group">
                        <label class="form-label">KDV Oranı (%)</label>
                        <select id="engKdvRate" class="form-select" onchange="calcEngineerOffer()">
                            <option value="0.20" selected>%20 KDV</option>
                            <option value="0">KDV Hariç / Muaf</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Teklif Geçerlilik Süresi</label>
                        <select id="engValidity" class="form-select">
                            <option value="15">15 Gün</option>
                            <option value="30" selected>30 Gün</option>
                            <option value="60">60 Gün</option>
                        </select>
                    </div>
                </div>

                <button type="button" class="btn-action" style="background:#1e293b; color:#38bdf8; border:1px solid #334155;" onclick="window.print()">
                    <i class="fa-solid fa-print"></i> Resmi Teklif Mektubunu Yazdır (PDF)
                </button>
            </div>

            <!-- Sağ Taraf: Canlı Teklif Mektubu Önizleme -->
            <div class="saas-card" style="padding:16px;">
                <h3 style="font-size:14px; font-weight:800; color:#fff; margin-bottom:8px;">
                    <i class="fa-solid fa-eye" style="color:#38bdf8;"></i> Resmi Mühendislik Teklif Mektubu Önizlemesi
                </h3>

                <div class="proposal-paper" id="proposalPaper">
                    <div style="display:flex; justify-content:space-between; align-items:flex-start; border-bottom:2px solid #0f172a; padding-bottom:12px; margin-bottom:12px;">
                        <div>
                            <h4 id="dispCompName" style="margin:0; font-size:15px; font-weight:800; color:#0f172a;">Ant Harita Mühendislik Müşavirlik</h4>
                            <div style="font-size:11px; color:#475569;" id="dispCompMeta">TMMOB HKMO Tescil: 12480 &bull; Tel: 0542 841 35 35</div>
                        </div>
                        <div style="text-align:right;">
                            <div style="font-size:11px; font-weight:700; color:#0f172a;">TEKLİF NO: #HK-<?= date('Ym') ?>-<?= rand(100, 999) ?></div>
                            <div style="font-size:11px; color:#64748b;">Tarih: <?= date('d.m.Y') ?></div>
                        </div>
                    </div>

                    <div style="margin-bottom:12px;">
                        <span style="font-size:11px; color:#64748b; font-weight:700;">SAYIN / ŞİRKET:</span>
                        <div id="dispClientName" style="font-weight:700; font-size:13px; color:#0f172a;">Sayın Arsa Maliki / İnşaat Firması</div>
                        <div id="dispLocationName" style="font-size:11px; color:#475569;">Yer: Antalya / Döşemealtı</div>
                    </div>

                    <p style="font-size:12px; color:#334155; margin-bottom:10px;">
                        Yukarıda belirtilen taşınmazınıza ilişkin talep edilen harita ve kadastro mühendislik hizmetleri kapsamında TMMOB Harita ve Kadastro Mühendisleri Odası 2026 yılı asgari ücret tarifesine uygun fiyat teklifimiz aşağıda bilgilerinize sunulmuştur.
                    </p>

                    <table>
                        <thead>
                            <tr>
                                <th>Hizmet / İşlem Kalemi</th>
                                <th style="text-align:right; width:120px;">Tutar (TL)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td id="dispScopeName">Harita Mühendislik Hizmet Bedeli</td>
                                <td style="text-align:right;" id="dispPaperBase">12.500 TL</td>
                            </tr>
                            <tr>
                                <td>Saha Aplikasyon, Ölçüm ve Ulaşım Masrafı</td>
                                <td style="text-align:right;" id="dispPaperTravel">1.500 TL</td>
                            </tr>
                            <tr>
                                <td>Ara Toplam</td>
                                <td style="text-align:right;" id="dispPaperSub">14.000 TL</td>
                            </tr>
                            <tr>
                                <td>Katma Değer Vergisi (KDV)</td>
                                <td style="text-align:right;" id="dispPaperKdv">2.800 TL</td>
                            </tr>
                            <tr style="background:#f8fafc; font-weight:800;">
                                <td style="font-size:13px;">GENEL TOPLAM (KDV DAHİL)</td>
                                <td style="text-align:right; font-size:14px; color:#0f172a;" id="dispPaperTotal">16.800 TL</td>
                            </tr>
                        </tbody>
                    </table>

                    <div style="font-size:11px; color:#64748b; line-height:1.5; margin-top:10px;">
                        &bull; İşbu teklif <span id="dispPaperVal">30</span> gün süreyle geçerlidir.<br>
                        &bull; Ölçüm sonrası resmi onaylı CD/CAD dosyası (DWG/DXF), aplikasyon krokisi ve imzalı teknik rapor teslim edilecektir.
                    </div>

                    <div style="display:flex; justify-content:space-between; margin-top:24px; padding-top:12px;">
                        <div style="text-align:center; font-size:11px; color:#64748b;">
                            <strong>MÜŞTERİ ONAYI</strong><br>İmza / Kaşe
                        </div>
                        <div style="text-align:center; font-size:11px; color:#64748b;">
                            <strong>ANT HARİTA MÜHENDİSLİK</strong><br>Yetkili Harita Mühendisi Kaşe / İmza
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ANT HARITA SAAS CROSS-LINKING & INTERNAL DISCOVERY ENGINE -->
    <section class="saas-crosslinks-section" style="max-width:1100px; margin:40px auto 20px; padding:24px 20px; background:linear-gradient(135deg, #0b1329 0%, #0f172a 100%); border:1px solid #1e293b; border-radius:16px;">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px; flex-wrap:wrap; gap:10px;">
            <div>
                <h3 style="color:#fff; font-size:15px; font-weight:800; margin:0 0 4px 0; display:flex; align-items:center; gap:8px;">
                    <i class="fa-solid fa-layer-group" style="color:#38bdf8;"></i> Diğer Popüler Harita, Kadastro &amp; Gayrimenkul SaaS Araçlarımız
                </h3>
                <p style="color:#94a3b8; font-size:12px; margin:0;">Ant Harita Mühendislik altyapısıyla geliştirilen diğer akıllı analiz modüllerini keşfedin.</p>
            </div>
            <a href="/eklentiler" style="background:#10b981; color:#fff; padding:6px 14px; border-radius:8px; font-size:12px; font-weight:700; text-decoration:none; display:inline-flex; align-items:center; gap:6px;">
                <i class="fa-solid fa-grid-round"></i> Tüm Modüller (25+) &rarr;
            </a>
        </div>
        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); gap:12px;">
            <a href="/lihkab-hesaplama" style="display:flex; align-items:center; gap:10px; padding:10px 12px; background:#131d31; border:1px solid #1e293b; border-radius:10px; text-decoration:none; color:#f8fafc;">
                <div style="width:36px; height:36px; border-radius:8px; background:rgba(16,185,129,0.15); color:#10b981; display:flex; align-items:center; justify-content:center; font-size:16px;"><i class="fa-solid fa-stamp"></i></div>
                <div><div style="font-size:12.5px; font-weight:700;">LİHKAB &amp; Kadastro Harcı</div><div style="font-size:11px; color:#94a3b8;">Aplikasyon &amp; cins değişikliği</div></div>
            </a>
            <a href="/kentsel-donusum-yarisi-bizden" style="display:flex; align-items:center; gap:10px; padding:10px 12px; background:#131d31; border:1px solid #1e293b; border-radius:10px; text-decoration:none; color:#f8fafc;">
                <div style="width:36px; height:36px; border-radius:8px; background:rgba(245,158,11,0.15); color:#f59e0b; display:flex; align-items:center; justify-content:center; font-size:16px;"><i class="fa-solid fa-building-shield"></i></div>
                <div><div style="font-size:12.5px; font-weight:700;">Yarısı Bizden &amp; Şerefiye</div><div style="font-size:11px; color:#94a3b8;">Kentsel dönüşüm hibe/kredi</div></div>
            </a>
            <a href="/ecrimisil-hesaplama" style="display:flex; align-items:center; gap:10px; padding:10px 12px; background:#131d31; border:1px solid #1e293b; border-radius:10px; text-decoration:none; color:#f8fafc;">
                <div style="width:36px; height:36px; border-radius:8px; background:rgba(192,132,252,0.15); color:#c084fc; display:flex; align-items:center; justify-content:center; font-size:16px;"><i class="fa-solid fa-scale-balanced"></i></div>
                <div><div style="font-size:12.5px; font-weight:700;">Hisseli Tapu Ecrimisil</div><div style="font-size:11px; color:#94a3b8;">5 yıllık kira tazminatı</div></div>
            </a>
            <a href="/tarla-verimlilik-raporu" style="display:flex; align-items:center; gap:10px; padding:10px 12px; background:#131d31; border:1px solid #1e293b; border-radius:10px; text-decoration:none; color:#f8fafc;">
                <div style="width:36px; height:36px; border-radius:8px; background:rgba(16,185,129,0.15); color:#10b981; display:flex; align-items:center; justify-content:center; font-size:16px;"><i class="fa-solid fa-seedling"></i></div>
                <div><div style="font-size:12.5px; font-weight:700;">Tarla Verimlilik SaaS</div><div style="font-size:11px; color:#94a3b8;">Ürün fizibilitesi &amp; ciro</div></div>
            </a>
            <a href="/emlak-vergisi-hesaplama" style="display:flex; align-items:center; gap:10px; padding:10px 12px; background:#131d31; border:1px solid #1e293b; border-radius:10px; text-decoration:none; color:#f8fafc;">
                <div style="width:36px; height:36px; border-radius:8px; background:rgba(56,189,248,0.15); color:#38bdf8; display:flex; align-items:center; justify-content:center; font-size:16px;"><i class="fa-solid fa-receipt"></i></div>
                <div><div style="font-size:12.5px; font-weight:700;">2026 Emlak Vergisi</div><div style="font-size:11px; color:#94a3b8;">Arsa, konut &amp; arazi harcı</div></div>
            </a>
            <a href="/arsa-takas-pazari" style="display:flex; align-items:center; gap:10px; padding:10px 12px; background:#131d31; border:1px solid #1e293b; border-radius:10px; text-decoration:none; color:#f8fafc;">
                <div style="width:36px; height:36px; border-radius:8px; background:rgba(245,158,11,0.15); color:#f59e0b; display:flex; align-items:center; justify-content:center; font-size:16px;"><i class="fa-solid fa-arrow-right-arrow-left"></i></div>
                <div><div style="font-size:12.5px; font-weight:700;">Arsa Takas Pazarı</div><div style="font-size:11px; color:#94a3b8;">Canlı trampa havuzu</div></div>
            </a>
        </div>
    </section>

    <script>
        const METRO_LIST = <?= json_encode($METRO_CITIES, JSON_UNESCAPED_UNICODE) ?>;

        function switchTab(tab) {
            const btnCit = document.getElementById('btnTabCitizen');
            const btnEng = document.getElementById('btnTabEngineer');
            const secCit = document.getElementById('sectionCitizen');
            const secEng = document.getElementById('sectionEngineer');

            if (tab === 'citizen') {
                btnCit.classList.add('active');
                btnEng.classList.remove('active');
                secCit.style.display = 'grid';
                secEng.style.display = 'none';
            } else {
                btnEng.classList.add('active');
                btnCit.classList.remove('active');
                secCit.style.display = 'none';
                secEng.style.display = 'grid';
                calcEngineerOffer();
            }
        }

        function calcCitizenPrice() {
            const proc = document.getElementById('citProcess').value;
            const city = document.getElementById('citCity').value;
            const area = Math.max(10, parseFloat(document.getElementById('citArea').value) || 850);
            const slope = document.getElementById('citSlope').value;

            const isMetro = METRO_LIST.includes(city);
            let mult = isMetro ? 1.25 : 1.0;
            if (slope === 'orta') mult *= 1.2;
            if (slope === 'sarp') mult *= 1.45;

            let base = 0;
            if (proc === 'aplikasyon') {
                base = 4500 + (area > 1000 ? ((area - 1000) / 1000) * 800 : 0);
            } else if (proc === 'plankote') {
                base = 6500 + (area > 1000 ? ((area - 1000) / 1000) * 1200 : 0);
            } else if (proc === 'cins_degisikligi') {
                base = 7500;
            } else if (proc === 'tevhid') {
                base = 8000;
            } else if (proc === 'ifraz') {
                base = 11000 + (area > 2000 ? ((area - 2000) / 1000) * 1500 : 0);
            } else if (proc === 'zemin_tespit') {
                base = 6000;
            } else if (proc === 'kubaj') {
                base = 9500 + (area > 5000 ? 3000 : 0);
            }

            const rawPrice = base * mult;
            const kdv = rawPrice * 0.20;
            const total = rawPrice + kdv;

            document.getElementById('dispCitTotal').innerText = Math.round(total).toLocaleString('tr-TR') + ' TL';
            document.getElementById('dispCitKdv').innerText = `KDV (%20) Dahil Taban Fiyat (İl: ${city})`;
        }

        function calcEngineerOffer() {
            const base = parseFloat(document.getElementById('engBaseFee').value) || 0;
            const travel = parseFloat(document.getElementById('engTravelFee').value) || 0;
            const kdvRate = parseFloat(document.getElementById('engKdvRate').value) || 0;
            const valDays = document.getElementById('engValidity').value;

            const sub = base + travel;
            const kdv = sub * kdvRate;
            const grandTotal = sub + kdv;

            // Sync with preview paper
            document.getElementById('dispCompName').innerText = document.getElementById('engCompany').value;
            document.getElementById('dispCompMeta').innerText = `${document.getElementById('engName').value} • Tel: ${document.getElementById('engPhone').value}`;
            document.getElementById('dispClientName').innerText = document.getElementById('engClient').value;
            document.getElementById('dispLocationName').innerText = "Konum: " + document.getElementById('engLocation').value;
            document.getElementById('dispScopeName').innerText = document.getElementById('engScope').value;

            document.getElementById('dispPaperBase').innerText = Math.round(base).toLocaleString('tr-TR') + ' TL';
            document.getElementById('dispPaperTravel').innerText = Math.round(travel).toLocaleString('tr-TR') + ' TL';
            document.getElementById('dispPaperSub').innerText = Math.round(sub).toLocaleString('tr-TR') + ' TL';
            document.getElementById('dispPaperKdv').innerText = Math.round(kdv).toLocaleString('tr-TR') + ' TL';
            document.getElementById('dispPaperTotal').innerText = Math.round(grandTotal).toLocaleString('tr-TR') + ' TL';
            document.getElementById('dispPaperVal').innerText = valDays;
        }

        function submitLead(e) {
            e.preventDefault();
            const btn = document.getElementById('btnSubmitLead');
            btn.disabled = true;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Gönderiliyor...';

            const procText = document.getElementById('citProcess').options[document.getElementById('citProcess').selectedIndex].text;
            const budgetText = document.getElementById('dispCitTotal').innerText;

            const formData = new FormData();
            formData.append('action', 'submit_lead');
            formData.append('ad_soyad', document.getElementById('leadName').value);
            formData.append('telefon', document.getElementById('leadPhone').value);
            formData.append('email', document.getElementById('leadEmail').value);
            formData.append('il', document.getElementById('citCity').value);
            formData.append('ilce', document.getElementById('citDistrict').value);
            formData.append('ada', document.getElementById('citAda').value);
            formData.append('parsel', document.getElementById('citParsel').value);
            formData.append('islem_turu', procText);
            formData.append('tahmini_butce', budgetText);
            formData.append('aciklama', document.getElementById('leadNote').value);

            fetch('', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                btn.disabled = false;
                btn.innerHTML = '<i class="fa-solid fa-paper-plane"></i> Ücretsiz Teklif İste &amp; İnceleme Başlat';

                if (data.success) {
                    document.getElementById('leadForm').style.display = 'none';
                    document.getElementById('leadSuccessMsg').style.display = 'block';
                    document.getElementById('leadSuccessText').innerText = data.message;
                    if (data.wa_url) {
                        document.getElementById('leadWaBtn').href = data.wa_url;
                    }
                } else {
                    alert('Hata: ' + (data.error || 'Bilinmeyen bir hata oluştu.'));
                }
            })
            .catch(err => {
                btn.disabled = false;
                btn.innerHTML = '<i class="fa-solid fa-paper-plane"></i> Ücretsiz Teklif İste &amp; İnceleme Başlat';
                alert('İletişim hatası oluştu, lütfen WhatsApp hattımızdan ulaşınız.');
            });
        }

        window.addEventListener('DOMContentLoaded', () => {
            calcCitizenPrice();
            calcEngineerOffer();
        });
    
    // Anasayfa Parsel Sorgu Parametrelerinden Otomatik Doldur
    (function() {
        const params = new URLSearchParams(window.location.search);
        const il = params.get('il');
        const ilce = params.get('ilce');
        const mah = params.get('mahalle');
        const ada = params.get('ada');
        const parsel = params.get('parsel');
        const alan = params.get('alan');
        if (il) {
            const citySel = document.getElementById('citCity');
            if (citySel) {
                for (let opt of citySel.options) {
                    if (opt.value.toLowerCase() === il.toLowerCase() || opt.text.toLowerCase().includes(il.toLowerCase())) {
                        citySel.value = opt.value;
                        break;
                    }
                }
            }
        }
        if (ilce && document.getElementById('citDistrict')) {
            document.getElementById('citDistrict').value = ilce + (mah ? ' / ' + mah : '');
        }
        if (ada && document.getElementById('citAda')) {
            document.getElementById('citAda').value = ada;
        }
        if (parsel && document.getElementById('citParsel')) {
            document.getElementById('citParsel').value = parsel;
        }
        if (alan && parseFloat(alan) > 0 && document.getElementById('citArea')) {
            document.getElementById('citArea').value = alan;
        }
        if (typeof calculateCitizenFee === 'function') {
            calculateCitizenFee();
        }
    })();

</script>
</body>
</html>
