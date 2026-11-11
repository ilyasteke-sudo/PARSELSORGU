<?php
/**
 * ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ - PARSEL PRO
 * İMAR DURUMU SORGULAMA & E-PLAN OTOMASYONU (imar_durumu.php)
 * URL: https://www.parselsorgu.net/imar-durumu-sorgulama
 */
declare(strict_types=1);

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/navbar.php';
require_once __DIR__ . '/SeoManager.php';

$page_title = "İmar Durumu Sorgulama & E-İmar Planı 2026 | ParselSorgu";
$meta_desc = "81 il ve tüm ilçelerde parsel bazında e-imar ve imar durumu sorgulama. TAKS, KAKS emsal, kat adedi ve 1/1000 uygulama imar planı analizi.";
$canonical_url = "https://www.parselsorgu.net/imar-durumu-sorgulama";

// 81 İl Listesi
$cities = [
    'Adana', 'Adıyaman', 'Afyonkarahisar', 'Ağrı', 'Aksaray', 'Amasya', 'Ankara', 'Antalya', 'Ardahan', 'Artvin',
    'Aydın', 'Balıkesir', 'Bartın', 'Batman', 'Bayburt', 'Bilecik', 'Bingöl', 'Bitlis', 'Bolu', 'Burdur',
    'Bursa', 'Çanakkale', 'Çankırı', 'Çorum', 'Denizli', 'Diyarbakır', 'Düzce', 'Edirne', 'Elazığ', 'Erzincan',
    'Erzurum', 'Eskişehir', 'Gaziantep', 'Giresun', 'Gümüşhane', 'Hakkari', 'Hatay', 'Iğdır', 'Isparta', 'İstanbul',
    'İzmir', 'Kahramanmaraş', 'Karabük', 'Karaman', 'Kars', 'Kastamonu', 'Kayseri', 'Kırıkkale', 'Kırklareli', 'Kırşehir',
    'Kilis', 'Kocaeli', 'Konya', 'Kütahya', 'Malatya', 'Manisa', 'Mardin', 'Mersin', 'Muğla', 'Muş',
    'Nevşehir', 'Niğde', 'Ordu', 'Osmaniye', 'Rize', 'Sakarya', 'Samsun', 'Siirt', 'Sinop', 'Sivas',
    'Şanlıurfa', 'Şırnak', 'Tekirdağ', 'Tokat', 'Trabzon', 'Tunceli', 'Uşak', 'Van', 'Yalova', 'Yozgat', 'Zonguldak'
];

$pre_city = trim($_GET['city'] ?? 'Ankara');
$pre_district = trim($_GET['district'] ?? 'Çankaya');
$pre_ada = trim($_GET['ada'] ?? '101');
$pre_parsel = trim($_GET['parsel'] ?? '5');
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($meta_desc); ?>">
    <link rel="canonical" href="<?php echo $canonical_url; ?>">
    <meta property="og:image" content="https://www.parselsorgu.net/assets/images/og-parsel.jpg">
    <meta name="robots" content="index, follow">

    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?php echo htmlspecialchars($page_title); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($meta_desc); ?>">
    <meta property="og:url" content="<?php echo $canonical_url; ?>">

    <!-- Leaflet & FontAwesome -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-dark: #090d16;
            --card-dark: #0f172a;
            --border-dark: rgba(56, 189, 248, 0.22);
            --primary-cyan: #38bdf8;
            --primary-blue: #0284c7;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
        }
        * { box-sizing: border-box; margin:0; padding:0; }
        body {
            font-family: 'Inter', -apple-system, sans-serif;
            background: var(--bg-dark);
            color: var(--text-main);
            line-height: 1.6;
        }
        .container { max-width: 1240px; margin: 0 auto; padding: 24px 20px; }
        .hero-banner {
            text-align: center;
            padding: 32px 20px 24px 20px;
            max-width: 900px;
            margin: 0 auto;
        }
        .hero-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(2, 132, 199, 0.15);
            border: 1px solid rgba(56, 189, 248, 0.35);
            padding: 6px 16px;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: 800;
            color: var(--primary-cyan);
            margin-bottom: 12px;
        }
        .hero-title {
            font-size: clamp(1.8rem, 3.5vw, 2.6rem);
            font-weight: 900;
            line-height: 1.25;
            margin-bottom: 12px;
            letter-spacing: -0.02em;
        }
        .hero-title span {
            background: linear-gradient(135deg, #38bdf8 0%, #0284c7 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .hero-desc {
            font-size: 15px;
            color: var(--text-muted);
            max-width: 720px;
            margin: 0 auto 24px auto;
        }
        .card {
            background: var(--card-dark);
            border: 1px solid var(--border-dark);
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 24px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.4);
        }
        .grid-fields {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(170px, 1fr));
            gap: 14px;
        }
        .form-group label {
            display: block;
            font-size: 11.5px;
            font-weight: 700;
            color: var(--primary-cyan);
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .form-group input, .form-group select {
            width: 100%;
            background: #0b1329;
            border: 1px solid #334155;
            color: #fff;
            padding: 11px 14px;
            border-radius: 10px;
            font-size: 13.5px;
            font-weight: 600;
            outline: none;
            transition: border-color 0.2s;
        }
        .form-group input:focus, .form-group select:focus {
            border-color: var(--primary-cyan);
        }
        .btn-primary {
            background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
            color: #fff;
            border: none;
            padding: 12px 24px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 800;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 15px rgba(2, 132, 199, 0.4);
            transition: transform 0.15s ease;
        }
        .btn-primary:hover { transform: translateY(-2px); }
        .map-wrap {
            position: relative;
            width: 100%;
            height: 520px;
            border-radius: 14px;
            overflow: hidden;
            border: 1px solid var(--border-dark);
            margin-top: 18px;
        }
        #imarMap { width: 100%; height: 100%; background: #070d1a; }
        .hud-badge {
            position: absolute;
            top: 14px;
            left: 14px;
            z-index: 1000;
            background: rgba(15, 23, 42, 0.88);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(56, 189, 248, 0.3);
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 12px;
            color: #e2e8f0;
        }
        .calc-box {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 14px;
            background: rgba(2, 132, 199, 0.08);
            border: 1px solid rgba(56, 189, 248, 0.2);
            border-radius: 12px;
            padding: 18px;
            margin-top: 18px;
        }
        .calc-item {
            text-align: center;
            padding: 10px;
            background: rgba(15, 23, 42, 0.6);
            border-radius: 8px;
        }
        .calc-item .val { font-size: 20px; font-weight: 900; color: #38bdf8; }
        .calc-item .lbl { font-size: 11px; color: #94a3b8; text-transform: uppercase; margin-top: 4px; }
        .faq-item {
            border-bottom: 1px solid rgba(255,255,255,0.08);
            padding: 16px 0;
        }
        .faq-q { font-weight: 800; font-size: 15px; color: #fff; margin-bottom: 6px; }
        .faq-a { font-size: 13.5px; color: #cbd5e1; line-height: 1.6; }

        @media (max-width: 768px) {
            .container { padding: 12px !important; }
            .grid-cols-2 { grid-template-columns: 1fr !important; }
            .grid-cols-3 { grid-template-columns: 1fr !important; }
            .grid-cols-4 { grid-template-columns: 1fr 1fr !important; }
            input, select { font-size: 16px !important; min-height: 44px; }
            .table-wrap { overflow-x: auto; -webkit-overflow-scrolling: touch; }
        }
    </style>
    <link rel="stylesheet" href="/assets/css/main.css?v=2026.46">
<?php echo SeoManager::renderBreadcrumbJson(['Ana Sayfa' => 'https://www.parselsorgu.net/', 'İmar Durumu Sorgulama' => 'https://www.parselsorgu.net/imar-durumu-sorgulama']); ?>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@graph": [
    {
      "@type": "WebApplication",
      "name": "İmar Durumu Sorgulama & E-İmar Plan Analizi",
      "url": "https://www.parselsorgu.net/imar-durumu-sorgulama",
      "applicationCategory": "BusinessApplication",
      "operatingSystem": "All",
      "offers": { "@type": "Offer", "price": "0", "priceCurrency": "TRY" },
      "provider": { "@type": "Organization", "name": "Ant Harita Mühendislik", "url": "https://www.parselsorgu.net" }
    },
    {
      "@type": "FAQPage",
      "mainEntity": [
        {
          "@type": "Question",
          "name": "İmar durumu ve e-imar sorgulaması nereden yapılır?",
          "acceptedAnswer": { "@type": "Answer", "text": "İmar durumu sorgulaması, taşınmazın bağlı olduğu ilçe belediyesinin İmar ve Şehircilik Müdürlüğü'nden, belediyelerin online e-imar ve e-çap portallarından veya ParselSorgu.net üzerinden ada/parsel girilerek yapılabilir." }
        },
        {
          "@type": "Question",
          "name": "İmar çapı belgesinin geçerlilik süresi ne kadardır?",
          "acceptedAnswer": { "@type": "Answer", "text": "İmar durum belgesi, düzenlendiği tarihten itibaren plan değişikliği olmaması şartıyla genellikle 1 yıl geçerlidir. İlgili bölgede plan revizyonu yapılması halinde güncel imar durumunun yeniden alınması gerekir." }
        },
        {
          "@type": "Question",
          "name": "TAKS ve KAKS (Emsal) ne anlama gelir?",
          "acceptedAnswer": { "@type": "Answer", "text": "TAKS Taban Alanı Kat Sayısıdır; binanın zemin katta arsa üzerinde oturabileceği azami alanı belirler. KAKS (Emsal) Kat Alanı Kat Sayısıdır; arsanın üzerine inşa edilebilecek toplam net inşaat alanını belirler." }
        }
      ]
    }
  ]
}
</script>
</head>
<body>

<?php if (function_exists('render_saas_navbar')) render_saas_navbar('imar-durumu-sorgulama'); ?>

<div class="container">
    <!-- Breadcrumb -->
    <div style="font-size:12px; color:#94a3b8; margin-bottom:12px; display:flex; align-items:center; gap:8px;">
        <a href="/" style="color:#38bdf8; text-decoration:none;">Ana Sayfa</a>
        <span>&rsaquo;</span>
        <span style="color:#fff;">İmar Durumu Sorgulama</span>
    </div>

    <!-- Hero Header -->
    <div class="hero-banner">
        <div class="hero-pill">
            <i class="fa-solid fa-compass-drafting"></i>
            <span>3194 İMAR KANUNU &bull; E-PLAN SİSTEMİ</span>
        </div>
        <h1 class="hero-title">İmar Durumu &amp; <span>E-İmar Plan Sorgulama</span></h1>
        <p class="hero-desc">
            81 il ve tüm ilçeler bazında ada/parsel imar fonksiyonu, TAKS/KAKS emsal inşaat hakkı, kat adedi ve çekme mesafelerini canlı uydu haritasında inceleyin.
        </p>
    </div>

    <!-- Cockpit Card -->
    <div class="card">
        <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px; margin-bottom:16px;">
            <div style="display:flex; align-items:center; gap:8px;">
                <span style="background:#0284c7; color:#fff; font-size:11px; font-weight:800; padding:4px 10px; border-radius:4px;">CANLI E-PLAN</span>
                <span style="font-size:14px; font-weight:800; color:#f8fafc;">İmar Durumu &amp; İnşaat Kapasite Formu</span>
            </div>
            <div style="font-size:12px; color:#10b981; font-weight:700;">
                <i class="fa-solid fa-circle-check"></i> Google Hibrit Canlı Uydu Aktif
            </div>
        </div>

        <form id="imarForm" onsubmit="event.preventDefault(); runImarSorgu();">
            <div class="grid-fields">
                <div class="form-group">
                    <label>1. İl</label>
                    <select id="imCity" onchange="updateDistricts()">
                        <?php foreach ($cities as $c): ?>
                            <option value="<?php echo htmlspecialchars($c); ?>" <?php if ($c === $pre_city) echo 'selected'; ?>><?php echo htmlspecialchars($c); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>2. İlçe</label>
                    <input type="text" id="imDistrict" value="<?php echo htmlspecialchars($pre_district); ?>" placeholder="Örn: Çankaya, Merkez">
                </div>
                <div class="form-group">
                    <label>3. Mahalle</label>
                    <input type="text" id="imNeighborhood" value="Kocatepe" placeholder="Örn: Kocatepe">
                </div>
                <div class="form-group">
                    <label>4. Ada No</label>
                    <input type="text" id="imAda" value="<?php echo htmlspecialchars($pre_ada); ?>" placeholder="Örn: 101">
                </div>
                <div class="form-group">
                    <label>5. Parsel No</label>
                    <input type="text" id="imParsel" value="<?php echo htmlspecialchars($pre_parsel); ?>" placeholder="Örn: 5">
                </div>
                <div class="form-group">
                    <label>6. Arsa Alanı (m²)</label>
                    <input type="number" id="imArea" value="850" min="50" step="10">
                </div>
            </div>

            <!-- Parameters -->
            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(180px, 1fr)); gap:14px; margin-top:14px;">
                <div class="form-group">
                    <label>Plan Fonksiyonu</label>
                    <select id="imPlanType" onchange="recalculateCapacity()">
                        <option value="konut_ayrik" selected>Konut (Ayrık Nizam)</option>
                        <option value="konut_bitisik">Konut (Bitişik Nizam)</option>
                        <option value="ticari">Ticaret + Konut (Karma)</option>
                        <option value="sanayi">Küçük Sanayi / Depolama</option>
                        <option value="tarim">Tarımsal Alan / Tarla</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>TAKS (Taban Oturumu)</label>
                    <input type="number" id="imTaks" value="0.30" step="0.05" min="0.10" max="0.80" onchange="recalculateCapacity()">
                </div>
                <div class="form-group">
                    <label>KAKS / Emsal</label>
                    <input type="number" id="imKaks" value="1.50" step="0.10" min="0.20" max="4.00" onchange="recalculateCapacity()">
                </div>
                <div class="form-group">
                    <label>Kat Adedi (Hmax)</label>
                    <select id="imKat" onchange="recalculateCapacity()">
                        <option value="2">2 Kat (H: 6.50 m)</option>
                        <option value="3">3 Kat (H: 9.50 m)</option>
                        <option value="4">4 Kat (H: 12.50 m)</option>
                        <option value="5" selected>5 Kat (H: 15.50 m)</option>
                        <option value="8">8 Kat (H: 24.50 m)</option>
                    </select>
                </div>
            </div>

            <div style="display:flex; gap:10px; margin-top:16px; flex-wrap:wrap; align-items:center;">
                <button type="submit" class="btn-primary">
                    <i class="fa-solid fa-magnifying-glass-chart"></i>
                    <span>İmar Durumunu &amp; Haritayı Sorgula</span>
                </button>
                <a href="/taks-kaks-hesaplama" class="btn-primary" style="background:#1e293b; border:1px solid #475569;">
                    <i class="fa-solid fa-calculator"></i>
                    <span>Detaylı TAKS/KAKS Robotu</span>
                </a>
                <a href="https://parselsorgu.tkgm.gov.tr" target="_blank" rel="noopener" style="color:#94a3b8; font-size:12px; margin-left:auto; text-decoration:none;">
                    Resmî TKGM Portal Doğrulama <i class="fa-solid fa-arrow-up-right-from-square"></i>
                </a>
            </div>
        </form>

        <!-- Calculated Summary -->
        <div class="calc-box">
            <div class="calc-item">
                <div class="val" id="calcTaban">255 m²</div>
                <div class="lbl">Taban Oturum Alanı (TAKS)</div>
            </div>
            <div class="calc-item">
                <div class="val" id="calcToplam">1.275 m²</div>
                <div class="lbl">Toplam İnşaat Alanı (KAKS)</div>
            </div>
            <div class="calc-item">
                <div class="val" id="calcDaire">10 Daire</div>
                <div class="lbl">Tahmini 3+1 Daire Kapasitesi</div>
            </div>
            <div class="calc-item">
                <div class="val" id="calcBahce">595 m²</div>
                <div class="lbl">Açık Bahçe &amp; Otopark Alanı</div>
            </div>
        </div>

        <!-- Live Satellite Map -->
        <div class="map-wrap">
            <div id="imarMap"></div>
            <div class="hud-badge">
                <div style="font-weight:bold; color:#38bdf8; margin-bottom:2px;"><i class="fa-solid fa-satellite"></i> CANLI UYDU HARİTASI</div>
                <div>Konum: <span id="hudLoc" style="color:#facc15;">Ankara / Çankaya</span></div>
                <div>Katman: <span style="color:#10b981;">Google Hibrit HD</span></div>
            </div>
        </div>
        <!-- Action Buttons -->
        <div style="margin-top:14px; display:flex; gap:10px; flex-wrap:wrap; justify-content:space-between; align-items:center;">
            <a id="btnDeepMap" href="/ada-parsel-harita?il=<?php echo urlencode($pre_city); ?>&ilce=<?php echo urlencode($pre_district); ?>&ada=<?php echo urlencode($pre_ada); ?>&parsel=<?php echo urlencode($pre_parsel); ?>" target="_blank" style="padding:11px 20px; background:linear-gradient(135deg, #0284c7, #2563eb); color:#fff; font-weight:800; font-size:13px; border-radius:10px; text-decoration:none; display:inline-flex; align-items:center; gap:8px; box-shadow:0 4px 14px rgba(2,132,199,0.35);">
                <i class="fa-solid fa-map-location-dot"></i> 🗺️ 360° Gelişmiş Haritada İncele (Yol Cephesi & Eğim)
            </a>
            <a id="btnWaImar" href="https://wa.me/905428413535" target="_blank" style="padding:11px 20px; background:rgba(34,197,94,0.15); border:1px solid #22c55e; color:#22c55e; font-weight:800; font-size:13px; border-radius:10px; text-decoration:none; display:inline-flex; align-items:center; gap:8px;">
                <i class="fa-brands fa-whatsapp"></i> İmar Mühendisine Danış
            </a>
        </div>
    </div>

    <!-- Popüler Belediye E-İmar & E-Çap Erişim Merkezi -->
    <div class="card">
        <h2 style="font-size:19px; font-weight:900; color:#fff; margin-bottom:8px;">Büyükşehir &amp; İlçe Belediye E-İmar / E-Çap Dizini</h2>
        <p style="font-size:13.5px; color:#94a3b8; margin-bottom:14px;">
            İlçe bazlı imar planı notları, e-çap yapılaşma koşulları ve canlı ada/parsel haritası için aşağıdaki ilçe merkezlerine geçebilirsiniz:
        </p>
        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); gap:10px;">
            <a href="/parsel-sorgu/antalya/kepez" style="background:#0b1329; border:1px solid #1e293b; border-radius:8px; padding:10px 12px; color:#e2e8f0; text-decoration:none; font-size:13px; font-weight:700;">Antalya Kepez E-İmar &rarr;</a>
            <a href="/parsel-sorgu/ankara/cankaya" style="background:#0b1329; border:1px solid #1e293b; border-radius:8px; padding:10px 12px; color:#e2e8f0; text-decoration:none; font-size:13px; font-weight:700;">Ankara Çankaya E-İmar &rarr;</a>
            <a href="/parsel-sorgu/antalya/muratpasa" style="background:#0b1329; border:1px solid #1e293b; border-radius:8px; padding:10px 12px; color:#e2e8f0; text-decoration:none; font-size:13px; font-weight:700;">Antalya Muratpaşa E-İmar &rarr;</a>
            <a href="/parsel-sorgu/ankara/golbasi" style="background:#0b1329; border:1px solid #1e293b; border-radius:8px; padding:10px 12px; color:#e2e8f0; text-decoration:none; font-size:13px; font-weight:700;">Ankara Gölbaşı E-İmar &rarr;</a>
            <a href="/parsel-sorgu/antalya/manavgat" style="background:#0b1329; border:1px solid #1e293b; border-radius:8px; padding:10px 12px; color:#e2e8f0; text-decoration:none; font-size:13px; font-weight:700;">Manavgat E-Çap &amp; İmar &rarr;</a>
            <a href="/parsel-sorgu/istanbul/kadikoy" style="background:#0b1329; border:1px solid #1e293b; border-radius:8px; padding:10px 12px; color:#e2e8f0; text-decoration:none; font-size:13px; font-weight:700;">İstanbul Kadıköy E-İmar &rarr;</a>
            <a href="/parsel-sorgu/antalya/aksu" style="background:#0b1329; border:1px solid #1e293b; border-radius:8px; padding:10px 12px; color:#e2e8f0; text-decoration:none; font-size:13px; font-weight:700;">Antalya Aksu E-İmar &rarr;</a>
            <a href="/parsel-sorgu/mugla/bodrum" style="background:#0b1329; border:1px solid #1e293b; border-radius:8px; padding:10px 12px; color:#e2e8f0; text-decoration:none; font-size:13px; font-weight:700;">Muğla Bodrum E-İmar &rarr;</a>
            <a href="/parsel-sorgu/aydin/efeler" style="background:#0b1329; border:1px solid #1e293b; border-radius:8px; padding:10px 12px; color:#e2e8f0; text-decoration:none; font-size:13px; font-weight:700;">Aydın Efeler İmar &amp; Parsel &rarr;</a>
            <a href="/parsel-sorgu/tekirdag/cerkezkoy" style="background:#0b1329; border:1px solid #1e293b; border-radius:8px; padding:10px 12px; color:#e2e8f0; text-decoration:none; font-size:13px; font-weight:700;">Çerkezköy E-İmar &rarr;</a>
            <a href="/parsel-sorgu/kocaeli/gebze" style="background:#0b1329; border:1px solid #1e293b; border-radius:8px; padding:10px 12px; color:#e2e8f0; text-decoration:none; font-size:13px; font-weight:700;">Kocaeli Gebze E-İmar &rarr;</a>
            <a href="/parsel-sorgu/bursa/nilufer" style="background:#0b1329; border:1px solid #1e293b; border-radius:8px; padding:10px 12px; color:#e2e8f0; text-decoration:none; font-size:13px; font-weight:700;">Bursa Nilüfer E-İmar &rarr;</a>
        </div>
    </div>

    <!-- Educational Content & FAQs -->
    <div class="card">
        <h2 style="font-size:20px; font-weight:900; color:#fff; margin-bottom:12px;">İmar Durumu Belgesi (İmar Çapı) Nedir?</h2>
        <p style="font-size:14px; color:#cbd5e1; line-height:1.7; margin-bottom:16px;">
            <b>İmar Durum Belgesi (İmar Çapı)</b>, bir taşınmazın 3194 Sayılı İmar Kanunu ve yürürlükteki 1/1000 ölçekli Uygulama İmar Planı çerçevesinde nasıl yapılaşabileceğini resmî olarak gösteren belgedir. Bu belgede parselin taban alanı katsayısı (TAKS), kat alanı katsayısı (KAKS/Emsal), ön-yan-arka çekme mesafeleri, maksimum bina yüksekliği (Hmax) ve parselin kullanım fonksiyonu (konut, ticaret, sanayi) yer alır.
        </p>

        <h3 style="font-size:17px; font-weight:800; color:#38bdf8; margin:20px 0 10px 0;">Sıkça Sorulan Sorular</h3>
        
        <div class="faq-item">
            <div class="faq-q">İmar durumu sorgulaması nereden yapılır?</div>
            <div class="faq-a">İmar durumu sorgulaması, taşınmazın bağlı olduğu ilçe belediyesinin İmar ve Şehircilik Müdürlüğü'nden, belediyelerin online e-imar portallarından veya ParselSorgu.net üzerinden ada/parsel girilerek yapılabilir.</div>
        </div>

        <div class="faq-item">
            <div class="faq-q">İmar çapı belgesinin geçerlilik süresi ne kadardır?</div>
            <div class="faq-a">İmar durum belgesi, düzenlendiği tarihten itibaren plan değişikliği olmaması şartıyla genellikle <b>1 yıl</b> geçerlidir. İlgili bölgede plan revizyonu yapılması halinde güncel imar durumunun yeniden alınması gerekir.</div>
        </div>

        <div class="faq-item">
            <div class="faq-q">TAKS ve KAKS ne anlama gelir?</div>
            <div class="faq-a"><b>TAKS:</b> Taban Alanı Kat Sayısıdır; binanın zemin katta arsa üzerinde oturabileceği azami alanı belirler. <b>KAKS (Emsal):</b> Kat Alanı Kat Sayısıdır; arsanın üzerine inşa edilebilecek toplam net inşaat alanını belirler.</div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
let imMap = null;
let imSelectedLayer = null;

function initImarMap() {
    const googleHybrid = L.tileLayer('https://mt{s}.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
        subdomains: ['0', '1', '2', '3'],
        maxZoom: 22,
        attribution: '&copy; Google Hibrit &bull; TKGM Kadastro'
    });
    const esriSat = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
        maxZoom: 19,
        attribution: '&copy; Esri World Imagery'
    });

    imMap = L.map('imarMap', {
        preferCanvas: true,
        layers: [googleHybrid]
    }).setView([39.9208, 32.8541], 15);

    L.control.layers({
        "Google Hibrit (HD Uydu)": googleHybrid,
        "Esri Satellite (Ortofoto)": esriSat
    }, null, { position: 'topright' }).addTo(imMap);

    runImarSorgu();
}

function recalculateCapacity() {
    const area = parseFloat(document.getElementById('imArea').value) || 0;
    const taks = parseFloat(document.getElementById('imTaks').value) || 0;
    const kaks = parseFloat(document.getElementById('imKaks').value) || 0;

    const taban = Math.round(area * taks);
    const toplam = Math.round(area * kaks);
    const daire = Math.floor(toplam / 125);
    const bahce = Math.max(0, area - taban);

    document.getElementById('calcTaban').textContent = taban.toLocaleString('tr-TR') + ' m²';
    document.getElementById('calcToplam').textContent = toplam.toLocaleString('tr-TR') + ' m²';
    document.getElementById('calcDaire').textContent = daire + ' Daire (~125m²)';
    document.getElementById('calcBahce').textContent = bahce.toLocaleString('tr-TR') + ' m²';
}

async function runImarSorgu() {
    recalculateCapacity();
    const city = document.getElementById('imCity').value.trim();
    const dist = document.getElementById('imDistrict').value.trim();
    const neigh = document.getElementById('imNeighborhood').value.trim();
    const ada = document.getElementById('imAda').value.trim();
    const parsel = document.getElementById('imParsel').value.trim();

    document.getElementById('hudLoc').textContent = `${city} / ${dist} - Ada ${ada} / Parsel ${parsel}`;

    const deepMapBtn = document.getElementById('btnDeepMap');
    if (deepMapBtn) {
        let deepUrl = `/ada-parsel-harita?il=${encodeURIComponent(city)}&ilce=${encodeURIComponent(dist)}`;
        if (neigh) deepUrl += `&mahalle=${encodeURIComponent(neigh)}`;
        if (ada) deepUrl += `&ada=${encodeURIComponent(ada)}`;
        if (parsel) deepUrl += `&parsel=${encodeURIComponent(parsel)}`;
        deepMapBtn.href = deepUrl;
    }
    const waBtn = document.getElementById('btnWaImar');
    if (waBtn) {
        const waText = `Merhaba, ${city} ${dist} Ada ${ada} / Parsel ${parsel} için resmi imar durumu ve emsal danışmanlığı almak istiyorum.`;
        waBtn.href = `https://wa.me/905428413535?text=${encodeURIComponent(waText)}`;
    }

    const params = new URLSearchParams({ province: city, district: dist, neighborhood: neigh, ada, parsel });
    try {
        const res = await fetch(`/parsel/api/parcel.php?${params.toString()}`);
        const data = await res.json();
        if (data && data.parcel && data.parcel.geometry && imMap) {
            if (imSelectedLayer) imMap.removeLayer(imSelectedLayer);
            imSelectedLayer = L.geoJSON(data.parcel.geometry, {
                style: { color: '#38bdf8', weight: 3.5, fillColor: '#0284c7', fillOpacity: 0.4 }
            }).addTo(imMap);
            imMap.fitBounds(imSelectedLayer.getBounds(), { padding: [40, 40], maxZoom: 18 });
        }
    } catch (e) {
        console.log(e);
    }
}

document.addEventListener('DOMContentLoaded', initImarMap);
</script>

    <!-- ========================================================================= -->
    <!-- 📱 MOBİL UYGULAMA SABİT ALT MENÜSÜ (NATIVE APP BOTTOM BAR) -->
    <!-- ========================================================================= -->
    <nav class="mobile-bottom-app-bar" role="navigation" aria-label="Mobil Hızlı Menü">
        <a href="/" class="mobile-app-btn" id="mob-btn-parsel" title="Canlı Parsel Sorgulama">
            <span class="app-icon">🗺️</span>
            <span>Parsel</span>
        </a>
        <a href="/imar-durumu-sorgulama" class="mobile-app-btn" id="mob-btn-imar" title="İmar Durumu Öğren">
            <span class="app-icon">📐</span>
            <span>İmar</span>
        </a>
        <a href="/arsa-insaat-maliyeti" class="mobile-app-btn" id="mob-btn-maliyet" title="2026 İnşaat Maliyeti">
            <span class="app-icon">⚡</span>
            <span>Maliyet</span>
        </a>
        <a href="/5403-tarla-ifraz" class="mobile-app-btn" id="mob-btn-tarla" title="5403 Tarla İfrazı">
            <span class="app-icon">🌾</span>
            <span>Tarla</span>
        </a>
        <a href="/rehber/" class="mobile-app-btn" id="mob-btn-rehber" title="Teknik ve Hukuki Rehber">
            <span class="app-icon">📚</span>
            <span>Rehber</span>
        </a>
        <a href="/" class="mobile-app-btn" title="Ana Sayfa & Menü">
            <span class="app-icon">☰</span>
            <span>Menü</span>
        </a>
    </nav>

</body>
</html>
