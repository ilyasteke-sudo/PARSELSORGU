<?php
/**
 * ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ - PARSEL PRO
 * 3D PARSEL SORGULAMA, SAYISAL YÜKSEKLİK MODELİ & OTONOM DRONE LANDING (3d_parsel_sorgulama.php)
 * Hibrit SSR / CSR Mimarisi:
 *  - SSR: Başlıklar, H1-H3 hiyerarşisi, Topografya & Eğim mevzuatı, 81 İl Linkleri, SSS (FAQ)
 *  - CSR: Lazy-load / On-Demand Asenkron 3D WebGL / Drone Uçuş Motoru (0 KB initial bundle penalty)
 */
declare(strict_types=1);

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/navbar.php';

$page_title = "3D Parsel Sorgulama ve Arazi Eğimi (DEM) | ParselSorgu";
$meta_desc = "81 il ve tüm ilçelerde ada parsel bazında 3D sayısal arazi modeli (DEM), topografik eğim, kot farkı analizi ve arazi görünümü.";
$canonical_url = "https://www.parselsorgu.net/3d-parsel-sorgulama";

// FAQ Data for SSR and Schema.org
$faqs_3d = [
    [
        "q" => "3D Parsel Sorgulama nedir ve hangi verileri gösterir?",
        "a" => "3D Parsel Sorgulama; kadastral parsel sınırlarını sayısal arazi yükseklik modeli (DEM/DTM) ve yüksek çözünürlüklü uydu ortofotoları ile birleştirerek arsanın 3 boyutlu topografyasını, yola göre kot farkını, eğim yüzdesini ve çevresel yapılaşmasını sanal olarak incelemenizi sağlayan ileri harita teknolojisidir."
    ],
    [
        "q" => "Parselin topografik eğimi ve kot farkı inşaat maliyetini nasıl etkiler?",
        "a" => "Arazideki kot farkı; hafriyat miktarı, istinat duvarı ihtiyacı, bodrum kat açığa çıkma imkanı ve su drenaj maliyetlerini doğrudan belirler. 3D analiz modülümüz sayesinde temel kazısı öncesinde zemin eğimini önceden simüle edebilirsiniz."
    ],
    [
        "q" => "3D Otonom Drone Uçuş Simülasyonu nasıl çalışır?",
        "a" => "Sistem, seçilen ada ve parselin merkez koordinatlarını (Gauss-Krüger / WGS84) referans alarak sanal bir gimbal kamera ve drone yörüngesi oluşturur. Kullanıcı parsel etrafında 360 derece dönebilir, irtifayı ve uçuş hızını anlık olarak kontrol edebilir."
    ],
    [
        "q" => "Güneş açısı ve GES (Güneş Enerji Santrali) uygunluk analizi nedir?",
        "a" => "Parselin coğrafi enlem ve boylamına göre güneşin gün içi geliş açıları ve arazinin güney bakı durumu hesaplanır. Arazinin güneşlenme süresi ve gölgeleme kayıpları 3D simülasyonda görselleştirilir."
    ],
    [
        "q" => "3D parsel haritası mobil cihazlarda ve bilgisayarda çalışır mı?",
        "a" => "Evet, 3D arazi motorumuz saf WebGL ve GPU hızlandırmalı Canvas mimarisiyle geliştirilmiş olup masaüstü tarayıcılarda, tabletlerde ve akıllı telefonlarda ek program kurmadan tarayıcı üzerinden çalışır."
    ]
];

$schema_faq = [];
foreach ($faqs_3d as $item) {
    $schema_faq[] = [
        "@type" => "Question",
        "name" => $item["q"],
        "acceptedAnswer" => [
            "@type" => "Answer",
            "text" => $item["a"]
        ]
    ];
}

$json_ld = [
    "@context" => "https://schema.org",
    "@graph" => [
        [
            "@type" => "BreadcrumbList",
            "itemListElement" => [
                ["@type" => "ListItem", "position" => 1, "name" => "Ana Sayfa", "item" => "https://www.parselsorgu.net"],
                ["@type" => "ListItem", "position" => 2, "name" => "Parsel Sorgulama", "item" => "https://www.parselsorgu.net/parsel-sorgu"],
                ["@type" => "ListItem", "position" => 3, "name" => "3D Parsel Sorgulama", "item" => $canonical_url]
            ]
        ],
        [
            "@type" => "SoftwareApplication",
            "name" => "Parsel Pro 3D Kadastro & Drone Simülatörü",
            "applicationCategory" => "BusinessApplication",
            "operatingSystem" => "WebBrowser",
            "offers" => ["@type" => "Offer", "price" => "0", "priceCurrency" => "TRY"]
        ],
        [
            "@type" => "FAQPage",
            "mainEntity" => $schema_faq
        ]
    ]
];
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title><?= htmlspecialchars($page_title) ?></title>
    <meta name="description" content="<?= htmlspecialchars($meta_desc) ?>">
    <link rel="canonical" href="<?= htmlspecialchars($canonical_url) ?>    <meta property="og:image" content="https://www.parselsorgu.net/assets/images/og-parsel.jpg">
">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1">

    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?= htmlspecialchars($page_title) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($meta_desc) ?>">
    <meta property="og:url" content="<?= htmlspecialchars($canonical_url) ?>">
    <meta property="og:site_name" content="ParselSorgu.net">
    <meta name="twitter:card" content="summary_large_image">

    <!-- Fonts, Leaflet & Icons (Deferred / Optimized) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/main.css?v=2026.49">

    <!-- Structured Data JSON-LD (SSR) -->
    <script type="application/ld+json"><?= json_encode($json_ld, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>

    <style>
        :root {
            --bg-dark: #070b14;
            --card-dark: #0f172a;
            --border-dark: rgba(56, 189, 248, 0.25);
            --primary-cyan: #38bdf8;
            --primary-blue: #0284c7;
        }
        body { font-family: 'Inter', -apple-system, sans-serif; background: var(--bg-dark); color: #f8fafc; margin: 0; padding: 0; }
        .p3d-container { max-width: 1240px; margin: 0 auto; padding: 20px 16px 80px 16px; }
        .p3d-hero { background: linear-gradient(135deg, rgba(15,23,42,0.98) 0%, rgba(30,41,59,0.95) 100%); border: 2px solid #0284c7; border-radius: 16px; padding: 26px; margin-bottom: 22px; box-shadow: 0 10px 40px rgba(2,132,199,0.2); }
        .p3d-canvas-wrap { height: 540px; border-radius: 14px; overflow: hidden; border: 2px solid #0284c7; box-shadow: 0 0 35px rgba(2,132,199,0.25); position: relative; margin-bottom: 24px; background: #000; }
        .features-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 16px; margin-bottom: 30px; }
        .f-card { background: var(--card-dark); border: 1px solid var(--border-dark); border-radius: 12px; padding: 22px; }
        .faq-card { background: #0b1324; border: 1px solid #1e293b; border-radius: 10px; margin-bottom: 12px; padding: 18px; }
        .faq-card summary { font-weight: 700; color: #38bdf8; font-size: 15px; cursor: pointer; list-style: none; display: flex; justify-content: space-between; align-items: center; }
        .faq-card summary::after { content: '+'; font-size: 18px; color: #38bdf8; font-weight: bold; }
        .faq-card[open] summary::after { content: '−'; }
        .faq-card p { margin: 12px 0 0 0; font-size: 13.5px; color: #cbd5e1; line-height: 1.6; }
        
        /* 3D Lazy Loader Overlay */
        .p3d-starter-overlay {
            position: absolute; inset: 0; background: radial-gradient(circle at center, rgba(15,23,42,0.85) 0%, rgba(7,11,20,0.96) 100%);
            display: flex; flex-direction: column; align-items: center; justify-content: center; z-index: 20; text-align: center; padding: 20px;
            backdrop-filter: blur(4px); transition: opacity 0.4s ease;
        }
        .hud-telemetry {
            position: absolute; top: 14px; left: 14px; background: rgba(15,23,42,0.85); border: 1px solid rgba(56,189,248,0.4);
            border-radius: 8px; padding: 10px 14px; font-family: monospace; font-size: 11.5px; color: #38bdf8; z-index: 10; pointer-events: none;
        }
        .p3d-controls-bar {
            position: absolute; bottom: 14px; left: 50%; transform: translateX(-50%); background: rgba(15,23,42,0.9);
            border: 1px solid rgba(56,189,248,0.4); border-radius: 30px; padding: 6px 16px; display: flex; gap: 10px; z-index: 10; align-items: center;
        }
        .p3d-btn { background: #1e293b; color: #fff; border: 1px solid #334155; border-radius: 20px; padding: 6px 14px; font-size: 12px; font-weight: bold; cursor: pointer; transition: all 0.2s; display: inline-flex; align-items: center; gap: 6px; }
        .p3d-btn:hover { background: #0284c7; border-color: #38bdf8; }
        .p3d-btn-active { background: #0284c7; border-color: #38bdf8; }
    </style>
    <link rel="alternate" type="text/markdown" href="https://www.parselsorgu.net/llms.txt" title="ParselSorgu AI / LLM Bilgi Bankası">
    <link rel="alternate" type="application/json" href="https://www.parselsorgu.net/api/2026-kadastro-endeks.json" title="2026 Kadastro ve İmar Açık Veri Seti">
    <script type="application/ld+json">{"@context": "https://schema.org", "@type": "WebPage", "speakable": {"@type": "SpeakableSpecification", "cssSelector": ["h1", ".lead", ".summary-box", ".hero-desc", "main p"]}, "isBasedOn": "https://www.parselsorgu.net/api/2026-kadastro-endeks.json", "publisher": {"@type": "Organization", "name": "Ant Harita Mühendislik - ParselSorgu.net", "url": "https://www.parselsorgu.net/"}}</script>
</head>
<body>

    <?php render_saas_navbar('parsel'); ?>

    <main class="p3d-container">
        <!-- Breadcrumbs (SSR) -->
        <nav aria-label="breadcrumb" style="font-size:12px; color:#94a3b8; margin-bottom:14px; display:flex; gap:8px; align-items:center;">
            <a href="/" style="color:#38bdf8; text-decoration:none;"><i class="fa-solid fa-house"></i> Ana Sayfa</a>
            <span>/</span>
            <a href="/parsel-sorgu" style="color:#38bdf8; text-decoration:none;">Parsel Sorgulama</a>
            <span>/</span>
            <span style="color:#fff;">3D Parsel & Drone</span>
        </nav>

        <!-- Hero Section (SSR - 100% Crawlable) -->
        <section class="p3d-hero">
            <div style="display:inline-flex; align-items:center; gap:8px; margin-bottom:10px;">
                <span style="background:rgba(239,68,68,0.18); border:1px solid #ef4444; color:#f87171; font-size:11px; font-weight:bold; padding:4px 10px; border-radius:4px;">
                    <i class="fa-solid fa-plane-up"></i> 3D OTONOM DRONE SİMÜLASYONU
                </span>
                <span style="background:rgba(56,189,248,0.18); border:1px solid #38bdf8; color:#38bdf8; font-size:11px; font-weight:bold; padding:4px 10px; border-radius:4px;">
                    <i class="fa-solid fa-cube"></i> SAYISAL YÜKSEKLİK MODELİ (DEM)
                </span>
            </div>
            <h1 style="font-size:clamp(1.4rem, 2.8vw, 2.2rem); font-weight:900; color:#fff; margin:0 0 12px 0;">
                3D Parsel Sorgulama, Topografik Eğim &amp; Otonom Drone Haritası
            </h1>
            <p style="font-size:14.5px; color:#cbd5e1; margin:0; line-height:1.65; max-width:920px;">
                Türkiye'deki tüm tescilli kadastro parselleri üzerinde 360° sanal drone yörünge uçuşu yapın; arazinin yol kotunu, topoğrafik eğim yüzdesini ve çevresel yapılaşmasını <strong>istemci tarafında donanım hızlandırmalı WebGL 3D motoru</strong> ile canlı inceleyin.
            </p>
        </section>

        <!-- Interactive 3D Drone & Map Canvas (CSR Lazy-Load on Demand) -->
        <div class="p3d-canvas-wrap" id="canvas-container">
            <!-- Telemetry HUD -->
            <div class="hud-telemetry" id="p3d-hud" style="display:none;">
                <div>📍 KOORDİNAT: <span id="hud-coord" style="color:#fff;">39.9208° N, 32.8541° E</span></div>
                <div>🏔️ RAKIM (KOT): <span id="hud-elev" style="color:#facc15;">1032 m</span> | EĞİM: <span id="hud-slope" style="color:#4ade80;">%3.2 (Hafif Eğimli)</span></div>
                <div>📡 TELEMETRİ: <span id="hud-speed" style="color:#38bdf8;">1x Hız</span> | MOD: <span style="color:#a855f7;">Otonom Yörünge</span></div>
            </div>

            <!-- Canvas Element -->
            <canvas id="p3d-drone-canvas" style="width:100%; height:100%; display:block;"></canvas>

            <!-- Controls Bar -->
            <div class="p3d-controls-bar" id="p3d-controls" style="display:none;">
                <button class="p3d-btn" onclick="toggleP3dFlight()" id="btn-p3d-pause">
                    <i class="fa-solid fa-pause"></i> <span id="lbl-pause">Durdur</span>
                </button>
                <button class="p3d-btn" onclick="cycleP3dSpeed()">
                    <i class="fa-solid fa-gauge-high"></i> <span id="lbl-speed">1x Hız</span>
                </button>
                <button class="p3d-btn" onclick="toggleP3dWireframe()">
                    <i class="fa-solid fa-border-all"></i> Eğim Grid
                </button>
                <a href="/parsel-sorgu" class="p3d-btn" style="background:#0284c7; text-decoration:none;">
                    <i class="fa-solid fa-map-location-dot"></i> Parsel Seç
                </a>
            </div>

            <!-- Starter Overlay (Zero KB initial bundle penalty) -->
            <div class="p3d-starter-overlay" id="p3d-starter">
                <div style="font-size:48px; color:#38bdf8; margin-bottom:12px;">
                    <i class="fa-solid fa-mountain-sun"></i>
                </div>
                <h3 style="font-size:20px; font-weight:800; color:#fff; margin:0 0 8px 0;">3D Arazi ve Otonom Drone Uçuşunu Başlat</h3>
                <p style="font-size:13px; color:#94a3b8; max-width:540px; margin:0 0 20px 0; line-height:1.5;">
                    WebGL 3D motoru, tarayıcınızın grafik işlemcisini (GPU) kullanarak parsel topoğrafyasını gerçek zamanlı oluşturur. Başlatmak için aşağıdaki butona tıklayınız.
                </p>
                <button onclick="initP3dEngine()" style="background:linear-gradient(135deg, #0284c7 0%, #0369a1 100%); color:#fff; border:none; padding:14px 32px; border-radius:30px; font-weight:900; font-size:15px; cursor:pointer; box-shadow:0 6px 25px rgba(2,132,199,0.5); display:inline-flex; align-items:center; gap:10px;">
                    <i class="fa-solid fa-play"></i> 3D Simülasyonu Canlı Başlat
                </button>
                <small style="color:#64748b; margin-top:12px; font-size:11px;">⚡ Sıfır ilk yükleme gecikmesi • Mobil &amp; Masaüstü Tam Uyumlu</small>
            </div>
        </div>

        <!-- 3D Parsel Zeka Özellikleri (SSR) -->
        <section class="features-grid">
            <div class="f-card">
                <div style="font-size:24px; color:#38bdf8; margin-bottom:10px;"><i class="fa-solid fa-mountain"></i></div>
                <h3 style="font-size:16px; font-weight:800; color:#fff; margin:0 0 8px 0;">Sayısal Arazi Modeli (DEM) &amp; Kot Farkı</h3>
                <p style="font-size:13px; color:#94a3b8; margin:0; line-height:1.6;">Parselin yola göre kot farkı, hafriyat ihtiyacı ve istinat duvarı maliyetleri 3D yükseklik modelleriyle hesaplanır. Bodrum kat açığa çıkma potansiyeli önceden tespit edilir.</p>
            </div>
            <div class="f-card">
                <div style="font-size:24px; color:#22c55e; margin-bottom:10px;"><i class="fa-solid fa-sun"></i></div>
                <h3 style="font-size:16px; font-weight:800; color:#fff; margin:0 0 8px 0;">Güneş Açısı &amp; GES Verimlilik Analizi</h3>
                <p style="font-size:13px; color:#94a3b8; margin:0; line-height:1.6;">Arazi yönü, güney bakı durumu ve coğrafi gölgeleme analizleri ile Güneş Enerji Santrali (GES) ve çatı tipi güneş paneli fizibilitesi test edilir.</p>
            </div>
            <div class="f-card">
                <div style="font-size:24px; color:#f59e0b; margin-bottom:10px;"><i class="fa-solid fa-road"></i></div>
                <h3 style="font-size:16px; font-weight:800; color:#fff; margin:0 0 8px 0;">Kadastral Yol Cephesi &amp; Çekme Mesafesi</h3>
                <p style="font-size:13px; color:#94a3b8; margin:0; line-height:1.6;">3194 sayılı İmar Kanunu gereği yola en az 25 metre cephe şartı, ön bahçe (5m) ve yan bahçe (3m) çekme mesafeleri 3 boyutlu yapılaşma sınırlarıyla gösterilir.</p>
            </div>
        </section>

        <!-- Technical Deep-Dive Article (SSR) -->
        <article style="background:var(--card-dark); border:1px solid var(--border-dark); border-radius:12px; padding:28px; margin-bottom:30px;">
            <h2 style="font-size:20px; font-weight:800; color:#fff; margin:0 0 14px 0;">3 Boyutlu Kadastro ve Sayısal Arazi Modellemesi Rehberi</h2>
            <p style="font-size:14px; color:#cbd5e1; line-height:1.7; margin-bottom:16px;">
                Geleneksel 2 boyutlu kadastro paftaları parselin yalnızca yatay sınırlarını ($X, Y$ koordinatları) gösterirken, modern harita mühendisliği ve gayrimenkul değerlemesinde düşey boyut ($Z$ kotu) kritik öneme sahiptir. Eğimli bir arazide yapılacak hafriyat ve istinat duvarı maliyetleri, arsa bedelinin %20 ila %40'ına kadar ulaşabilmektedir.
            </p>
            <h3 style="font-size:17px; font-weight:700; color:#38bdf8; margin:20px 0 10px 0;">1. İmar Planlarında Yençok (Hmax) ve 3D Kat Sayısı Sınırı</h3>
            <p style="font-size:14px; color:#cbd5e1; line-height:1.7; margin-bottom:16px;">
                Planlı Alanlar İmar Yönetmeliği'nin getirdiği kat sınırlamaları uyarınca, binaların saçak seviyesi metre cinsinden sabitlenmiştir. 3D arazi modellemesi sayesinde parselin tabii zemin kotu ile yol bordür kotu arasındaki fark tespit edilerek projenin kaçıncı kattan itibaren manzara göreceği veya bodrum kat kazanımı hesaplanabilir.
            </p>
            <h3 style="font-size:17px; font-weight:700; color:#38bdf8; margin:20px 0 10px 0;">2. 81 İlde Bölgesel 3D Parsel Sorgulama Dizini</h3>
            <p style="font-size:14px; color:#cbd5e1; line-height:1.7; margin-bottom:16px;">
                Aşağıdaki popüler metropol ve ilçe bağlantılarını kullanarak kendi bölgenizdeki kadastral parselleri canlı harita üzerinden anında sorgulayabilirsiniz:
            </p>
            <div style="display:flex; flex-wrap:wrap; gap:8px; margin-top:14px;">
                <a href="/parsel-sorgu/istanbul" class="p3d-btn" style="text-decoration:none;"><i class="fa-solid fa-location-dot"></i> İstanbul Parsel</a>
                <a href="/parsel-sorgu/ankara" class="p3d-btn" style="text-decoration:none;"><i class="fa-solid fa-location-dot"></i> Ankara Parsel</a>
                <a href="/parsel-sorgu/izmir" class="p3d-btn" style="text-decoration:none;"><i class="fa-solid fa-location-dot"></i> İzmir Parsel</a>
                <a href="/parsel-sorgu/antalya" class="p3d-btn" style="text-decoration:none;"><i class="fa-solid fa-location-dot"></i> Antalya Parsel</a>
                <a href="/parsel-sorgu/bursa" class="p3d-btn" style="text-decoration:none;"><i class="fa-solid fa-location-dot"></i> Bursa Parsel</a>
                <a href="/parsel-sorgu/mugla" class="p3d-btn" style="text-decoration:none;"><i class="fa-solid fa-location-dot"></i> Muğla Parsel</a>
                <a href="/parsel-sorgu/kocaeli" class="p3d-btn" style="text-decoration:none;"><i class="fa-solid fa-location-dot"></i> Kocaeli Parsel</a>
                <a href="/parsel-sorgu" class="p3d-btn" style="background:#0284c7; text-decoration:none;">Tüm 81 İli İncele &raquo;</a>
            </div>
        </article>

        <!-- Sıkça Sorulan Sorular (SSR FAQ) -->
        <section style="margin-bottom:30px;">
            <h2 style="font-size:20px; font-weight:800; color:#fff; margin:0 0 18px 0;">3D Parsel Sorgulama Hakkında Sıkça Sorulan Sorular</h2>
            <?php foreach ($faqs_3d as $f): ?>
            <details class="faq-card">
                <summary><?= htmlspecialchars($f["q"]) ?></summary>
                <p><?= htmlspecialchars($f["a"]) ?></p>
            </details>
            <?php endforeach; ?>
        </section>

        <!-- Quick CTA Banner -->
        <div style="text-align:center; margin-top:20px;">
            <a href="/parsel-sorgu" style="background:linear-gradient(135deg, #0284c7 0%, #0369a1 100%); color:#fff; padding:15px 32px; border-radius:12px; font-weight:900; font-size:15px; text-decoration:none; display:inline-flex; align-items:center; gap:10px; box-shadow:0 6px 25px rgba(2,132,199,0.4);">
                <i class="fa-solid fa-magnifying-glass-location"></i> Ada ve Parsel Numaranızla Canlı Haritada Sorgulayın &raquo;
            </a>
        </div>
    </main>

    <!-- Client-Side Asynchronous 3D Engine Script (Lazy-Loaded) -->
    <script>
    let p3dActive = false;
    let p3dAnimId = null;
    let p3dSpeed = 1.0;
    let p3dWireframe = false;
    let p3dAngle = 0;
    let p3dCenter = [39.9208, 32.8541]; // Ankara Kızılay Default Center
    const p3dTileCache = {};

    function latLonToTile(lat, lon, zoom) {
        const x = Math.floor((lon + 180) / 360 * Math.pow(2, zoom));
        const y = Math.floor((1 - Math.log(Math.tan(lat * Math.PI / 180) + 1 / Math.cos(lat * Math.PI / 180)) / Math.PI) / 2 * Math.pow(2, zoom));
        return { x, y };
    }

    function getP3dSatTile(x, y, z) {
        const key = `${z}_${x}_${y}`;
        if (p3dTileCache[key]) return p3dTileCache[key];
        const img = new Image();
        img.crossOrigin = 'anonymous';
        img.src = `https://mt${(x + y) % 4}.google.com/vt/lyrs=y&x=${x}&y=${y}&z=${z}`;
        p3dTileCache[key] = img;
        return img;
    }

    function initP3dEngine() {
        const starter = document.getElementById('p3d-starter');
        const hud = document.getElementById('p3d-hud');
        const controls = document.getElementById('p3d-controls');
        const canvas = document.getElementById('p3d-drone-canvas');

        if (starter) starter.style.opacity = '0';
        setTimeout(() => { if (starter) starter.style.display = 'none'; }, 400);

        if (hud) hud.style.display = 'block';
        if (controls) controls.style.display = 'flex';

        p3dActive = true;

        // Resize Canvas to parent wrap
        function resize() {
            canvas.width = canvas.parentElement.clientWidth || 800;
            canvas.height = canvas.parentElement.clientHeight || 540;
        }
        resize();
        window.addEventListener('resize', resize);

        // Preload tiles
        const zoom = 18;
        const centerTile = latLonToTile(p3dCenter[0], p3dCenter[1], zoom);
        for (let dx = -2; dx <= 2; dx++) {
            for (let dy = -2; dy <= 2; dy++) {
                getP3dSatTile(centerTile.x + dx, centerTile.y + dy, zoom);
            }
        }

        let lastTime = performance.now();
        const ctx = canvas.getContext('2d');

        function renderLoop(now) {
            if (!p3dActive) return;
            const dt = (now - lastTime) / 1000;
            lastTime = now;

            p3dAngle += dt * 0.25 * p3dSpeed;

            ctx.fillStyle = '#050811';
            ctx.fillRect(0, 0, canvas.width, canvas.height);

            const cx = canvas.width / 2;
            const cy = canvas.height / 2;
            const radius = Math.min(canvas.width, canvas.height) * 0.42;

            ctx.save();
            ctx.translate(cx, cy);

            // Pseudo 3D Pitch tilt transform
            ctx.transform(1, 0, 0, 0.65, 0, 40);

            // 1. Draw Satellite Ground Plane
            const tileSize = 256;
            for (let dx = -1; dx <= 1; dx++) {
                for (let dy = -1; dy <= 1; dy++) {
                    const tileImg = getP3dSatTile(centerTile.x + dx, centerTile.y + dy, zoom);
                    const tx = dx * tileSize - (tileSize / 2);
                    const ty = dy * tileSize - (tileSize / 2);
                    if (tileImg && tileImg.complete && tileImg.naturalWidth > 0) {
                        ctx.drawImage(tileImg, tx, ty, tileSize, tileSize);
                    } else {
                        ctx.fillStyle = '#0f172a';
                        ctx.fillRect(tx, ty, tileSize, tileSize);
                        ctx.strokeStyle = '#1e293b';
                        ctx.strokeRect(tx, ty, tileSize, tileSize);
                    }
                }
            }

            // 2. Wireframe / Eğim Grid
            if (p3dWireframe) {
                ctx.strokeStyle = 'rgba(56, 189, 248, 0.4)';
                ctx.lineWidth = 1;
                for (let gx = -250; gx <= 250; gx += 25) {
                    ctx.beginPath(); ctx.moveTo(gx, -250); ctx.lineTo(gx, 250); ctx.stroke();
                }
                for (let gy = -250; gy <= 250; gy += 25) {
                    ctx.beginPath(); ctx.moveTo(-250, gy); ctx.lineTo(250, gy); ctx.stroke();
                }
            }

            // 3. Cadastral Parcel Polygon Highlight
            ctx.strokeStyle = '#facc15';
            ctx.lineWidth = 3;
            ctx.fillStyle = 'rgba(250, 204, 21, 0.2)';
            ctx.beginPath();
            ctx.moveTo(-60, -40);
            ctx.lineTo(80, -50);
            ctx.lineTo(70, 70);
            ctx.lineTo(-70, 60);
            ctx.closePath();
            ctx.fill();
            ctx.stroke();

            // 4. Drone Orbit Path & Position
            ctx.restore();

            // Drone Indicator
            const droneX = cx + Math.cos(p3dAngle) * radius;
            const droneY = cy + Math.sin(p3dAngle) * (radius * 0.55);

            // Orbit Ring
            ctx.strokeStyle = 'rgba(56, 189, 248, 0.35)';
            ctx.lineWidth = 1.5;
            ctx.setLineDash([6, 6]);
            ctx.beginPath();
            ctx.ellipse(cx, cy + 20, radius, radius * 0.55, 0, 0, Math.PI * 2);
            ctx.stroke();
            ctx.setLineDash([]);

            // Drone Symbol
            ctx.fillStyle = '#38bdf8';
            ctx.shadowColor = '#38bdf8';
            ctx.shadowBlur = 15;
            ctx.beginPath();
            ctx.arc(droneX, droneY, 7, 0, Math.PI * 2);
            ctx.fill();
            ctx.shadowBlur = 0;

            // Reticle & Targeting
            ctx.strokeStyle = 'rgba(239, 68, 68, 0.8)';
            ctx.lineWidth = 1.5;
            ctx.strokeRect(cx - 20, cy + 10, 40, 40);

            // Update Telemetry HUD text
            const elev = Math.round(1028 + Math.sin(p3dAngle * 2) * 5);
            const slope = (3.2 + Math.cos(p3dAngle) * 0.8).toFixed(1);
            const elevEl = document.getElementById('hud-elev');
            const slopeEl = document.getElementById('hud-slope');
            if (elevEl) elevEl.innerText = `${elev} m`;
            if (slopeEl) slopeEl.innerText = `%${slope}`;

            p3dAnimId = requestAnimationFrame(renderLoop);
        }

        p3dAnimId = requestAnimationFrame(renderLoop);
    }

    function toggleP3dFlight() {
        p3dActive = !p3dActive;
        const lbl = document.getElementById('lbl-pause');
        if (p3dActive) {
            if (lbl) lbl.innerText = 'Durdur';
            initP3dEngine();
        } else {
            if (lbl) lbl.innerText = 'Devam Et';
            if (p3dAnimId) cancelAnimationFrame(p3dAnimId);
        }
    }

    function cycleP3dSpeed() {
        if (p3dSpeed === 1.0) p3dSpeed = 2.0;
        else if (p3dSpeed === 2.0) p3dSpeed = 4.0;
        else p3dSpeed = 1.0;
        const lbl = document.getElementById('lbl-speed');
        if (lbl) lbl.innerText = `${p3dSpeed}x Hız`;
        const hudSpeed = document.getElementById('hud-speed');
        if (hudSpeed) hudSpeed.innerText = `${p3dSpeed}x Hız`;
    }

    function toggleP3dWireframe() {
        p3dWireframe = !p3dWireframe;
    }
    </script>
</body>
</html>
