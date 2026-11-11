<?php
/**
 * ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ - PARSEL PRO
 * TKGM PARSEL SORGULAMA & CANLI MEGSİS PORTALI (tkgm_parsel_sorgulama.php)
 * URL: https://www.parselsorgu.net/tkgm-parsel-sorgulama
 */
declare(strict_types=1);

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/navbar.php';
require_once __DIR__ . '/SeoManager.php';

$page_title = "TKGM Parsel Sorgu (MEGSİS) & Ada Haritası | ParselSorgu";
$meta_desc = "Tapu ve Kadastro Genel Müdürlüğü (TKGM) MEGSİS verileriyle 81 ilde canlı TKGM parsel sorgu, ada/parsel sınırları ve pafta inceleme.";
$canonical_url = "https://www.parselsorgu.net/tkgm-parsel-sorgulama";

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
        body { font-family: 'Inter', -apple-system, sans-serif; background: var(--bg-dark); color: var(--text-main); line-height: 1.6; }
        .container { max-width: 1240px; margin: 0 auto; padding: 24px 20px; }
        .hero-banner { text-align: center; padding: 32px 20px 24px 20px; max-width: 900px; margin: 0 auto; }
        .hero-pill { display: inline-flex; align-items: center; gap: 8px; background: rgba(2, 132, 199, 0.15); border: 1px solid rgba(56, 189, 248, 0.35); padding: 6px 16px; border-radius: 9999px; font-size: 12px; font-weight: 800; color: var(--primary-cyan); margin-bottom: 12px; }
        .hero-title { font-size: clamp(1.8rem, 3.5vw, 2.6rem); font-weight: 900; line-height: 1.25; margin-bottom: 12px; letter-spacing: -0.02em; }
        .hero-title span { background: linear-gradient(135deg, #38bdf8 0%, #0284c7 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .hero-desc { font-size: 15px; color: var(--text-muted); max-width: 720px; margin: 0 auto 24px auto; }
        .card { background: var(--card-dark); border: 1px solid var(--border-dark); border-radius: 16px; padding: 24px; margin-bottom: 24px; box-shadow: 0 10px 30px rgba(0,0,0,0.4); }
        .grid-fields { display: grid; grid-template-columns: repeat(auto-fit, minmax(170px, 1fr)); gap: 14px; }
        .form-group label { display: block; font-size: 11.5px; font-weight: 700; color: var(--primary-cyan); margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px; }
        .form-group input, .form-group select { width: 100%; background: #0b1329; border: 1px solid #334155; color: #fff; padding: 11px 14px; border-radius: 10px; font-size: 13.5px; font-weight: 600; outline: none; }
        .btn-primary { background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%); color: #fff; border: none; padding: 12px 24px; border-radius: 10px; font-size: 14px; font-weight: 800; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 15px rgba(2, 132, 199, 0.4); }
        .map-wrap { position: relative; width: 100%; height: 560px; border-radius: 14px; overflow: hidden; border: 1px solid var(--border-dark); margin-top: 18px; }
        #tkgmMap { width: 100%; height: 100%; background: #070d1a; }
        .hud-badge { position: absolute; top: 14px; left: 14px; z-index: 1000; background: rgba(15, 23, 42, 0.88); backdrop-filter: blur(8px); border: 1px solid rgba(56, 189, 248, 0.3); border-radius: 10px; padding: 10px 14px; font-size: 12px; color: #e2e8f0; }
        .faq-item { border-bottom: 1px solid rgba(255,255,255,0.08); padding: 16px 0; }
        .faq-q { font-weight: 800; font-size: 15px; color: #fff; margin-bottom: 6px; }
        .faq-a { font-size: 13.5px; color: #cbd5e1; line-height: 1.6; }

        @media (max-width: 768px) {
            .container { padding: 12px !important; }
            .grid-cols-2, .grid-cols-3 { grid-template-columns: 1fr !important; }
            .grid-cols-4 { grid-template-columns: 1fr 1fr !important; }
            input, select { font-size: 16px !important; min-height: 44px; }
            .table-wrap { overflow-x: auto; -webkit-overflow-scrolling: touch; }
        }
    </style>
    <link rel="stylesheet" href="/assets/css/main.css?v=2026.46">
<?php echo SeoManager::renderBreadcrumbJson(['Ana Sayfa' => 'https://www.parselsorgu.net/', 'TKGM Parsel Sorgulama' => 'https://www.parselsorgu.net/tkgm-parsel-sorgulama']); ?>
    <link rel="alternate" type="text/markdown" href="https://www.parselsorgu.net/llms.txt" title="ParselSorgu AI / LLM Bilgi Bankası">
    <link rel="alternate" type="application/json" href="https://www.parselsorgu.net/api/2026-kadastro-endeks.json" title="2026 Kadastro ve İmar Açık Veri Seti">
    <script type="application/ld+json">{"@context": "https://schema.org", "@type": "WebPage", "speakable": {"@type": "SpeakableSpecification", "cssSelector": ["h1", ".lead", ".summary-box", ".hero-desc", "main p"]}, "isBasedOn": "https://www.parselsorgu.net/api/2026-kadastro-endeks.json", "publisher": {"@type": "Organization", "name": "Ant Harita Mühendislik - ParselSorgu.net", "url": "https://www.parselsorgu.net/"}}</script>
</head>
<body>

<?php if (function_exists('render_saas_navbar')) render_saas_navbar('tkgm-parsel-sorgulama'); ?>

<div class="container">
    <!-- Breadcrumb -->
    <div style="font-size:12px; color:#94a3b8; margin-bottom:12px; display:flex; align-items:center; gap:8px;">
        <a href="/" style="color:#38bdf8; text-decoration:none;">Ana Sayfa</a>
        <span>&rsaquo;</span>
        <span style="color:#fff;">TKGM Parsel Sorgulama (MEGSİS)</span>
    </div>

    <!-- Hero Header -->
    <div class="hero-banner">
        <div class="hero-pill">
            <i class="fa-solid fa-map-location-dot"></i>
            <span>T.C. ÇŞİDB &bull; TAPU VE KADASTRO GENEL MÜDÜRLÜĞÜ</span>
        </div>
        <h1 class="hero-title">TKGM <span>Parsel Sorgulama</span> Portalı</h1>
        <p class="hero-desc">
            81 ilde Mekânsal Gayrimenkul Sistemi (MEGSİS) standartlarında canlı uydu kadastro haritası, ada parsel sınırları, alan tespiti ve koordinat sorgulama.
        </p>
    </div>

    <!-- Query Card -->
    <div class="card">
        <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px; margin-bottom:16px;">
            <div style="display:flex; align-items:center; gap:8px;">
                <span style="background:#0284c7; color:#fff; font-size:11px; font-weight:800; padding:4px 10px; border-radius:4px;">TKGM MEGSİS</span>
                <span style="font-size:14px; font-weight:800; color:#f8fafc;">Canlı Kadastro &amp; Uydu Arama Formu</span>
            </div>
            <div style="font-size:12px; color:#10b981; font-weight:700;">
                <i class="fa-solid fa-satellite"></i> Google Hibrit Canlı Uydu Aktif
            </div>
        </div>

        <form id="tkgmForm" onsubmit="event.preventDefault(); runTkgmSearch();">
            <div class="grid-fields">
                <div class="form-group">
                    <label>1. İl (81 İl)</label>
                    <select id="tkCity">
                        <?php foreach ($cities as $c): ?>
                            <option value="<?php echo htmlspecialchars($c); ?>" <?php if ($c === $pre_city) echo 'selected'; ?>><?php echo htmlspecialchars($c); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>2. İlçe</label>
                    <input type="text" id="tkDistrict" value="<?php echo htmlspecialchars($pre_district); ?>" placeholder="Örn: Çankaya, Merkez">
                </div>
                <div class="form-group">
                    <label>3. Mahalle / Köy</label>
                    <input type="text" id="tkNeighborhood" value="Kocatepe" placeholder="Örn: Kocatepe">
                </div>
                <div class="form-group">
                    <label>4. Ada No</label>
                    <input type="text" id="tkAda" value="<?php echo htmlspecialchars($pre_ada); ?>" placeholder="Örn: 101">
                </div>
                <div class="form-group">
                    <label>5. Parsel No</label>
                    <input type="text" id="tkParsel" value="<?php echo htmlspecialchars($pre_parsel); ?>" placeholder="Örn: 5">
                </div>
            </div>

            <div style="display:flex; gap:10px; margin-top:16px; flex-wrap:wrap; align-items:center;">
                <button type="submit" class="btn-primary">
                    <i class="fa-solid fa-magnifying-glass-location"></i>
                    <span>TKGM Parselini Canlı Haritada Bul</span>
                </button>
                <a href="https://parselsorgu.tkgm.gov.tr" target="_blank" rel="noopener" class="btn-primary" style="background:#1e293b; border:1px solid #475569;">
                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                    <span>Resmî TKGM Portalında Doğrula</span>
                </a>
                <a href="/ada-parsel-harita" class="btn-primary" style="background:#0f172a; border:1px solid #38bdf8; color:#38bdf8;">
                    <i class="fa-solid fa-map"></i>
                    <span>Harita Üzerinden Seçim Modu</span>
                </a>
            </div>
        </form>

        <!-- Live Satellite Map -->
        <div class="map-wrap">
            <div id="tkgmMap"></div>
            <div class="hud-badge">
                <div style="font-weight:bold; color:#38bdf8; margin-bottom:2px;"><i class="fa-solid fa-satellite"></i> TKGM KADASTRO UYDU</div>
                <div>Konum: <span id="tkgmHudLoc" style="color:#facc15;">Ankara / Çankaya - Ada 101 / Parsel 5</span></div>
                <div>Durum: <span style="color:#10b981;">● Google Hybrid Canlı Aktif</span></div>
            </div>
        </div>
    </div>

    <!-- Educational & Technical Guide -->
    <div class="card">
        <h2 style="font-size:20px; font-weight:900; color:#fff; margin-bottom:12px;">TKGM Parsel Sorgulama (MEGSİS) Nasıl Yapılır?</h2>
        <p style="font-size:14px; color:#cbd5e1; line-height:1.7; margin-bottom:16px;">
            <b>Mekânsal Gayrimenkul Sistemi (MEGSİS)</b>, kadastro haritaları ve tapu kayıtlarının dijital ortamda birleştirilerek kamuoyunun incelemesine sunulduğu resmî bilgi sistemidir. ParselSorgu.net üzerinden sorgulama yaparak taşınmazın güncel paftasını, köşe koordinatlarını, sınır kırık noktalarını ve uydu görüntüsü üzerindeki zemin kullanımını anında görüntüleyebilirsiniz.
        </p>

        <h3 style="font-size:17px; font-weight:800; color:#38bdf8; margin:20px 0 10px 0;">Sıkça Sorulan Sorular</h3>
        
        <div class="faq-item">
            <div class="faq-q">TKGM parsel sorgulama ücretsiz midir?</div>
            <div class="faq-a">Evet, TKGM parsel sorgulama sistemi ve platformumuz üzerinden yapılan ada/parsel uydu sorgulamaları tamamen ücretsizdir.</div>
        </div>

        <div class="faq-item">
            <div class="faq-q">Tapu alanı ile kadastro harita alanı neden farklı çıkar?</div>
            <div class="faq-a">Eski tarihli kadastro paftalarında yapılan sayıllaştırma hataları, projeksiyon farkları (ED50 / ITRF95) veya 3402 sayılı Kanunun 41. maddesi kapsamındaki düzeltmeler nedeniyle tapu senedindeki alan ile harita alanı arasında küçük yanılma sınırları oluşabilir.</div>
        </div>

        <div class="faq-item">
            <div class="faq-q">TKGM parsel sorgu ekranında hisse oranları ve sahip isimleri görünür mü?</div>
            <div class="faq-a">Hayır, 6698 sayılı Kişisel Verilerin Korunması Kanunu (KVKK) uyarınca mülkiyet sahiplerinin isimleri ve hisse oranları halka açık sistemlerde gösterilmez; yalnızca geometri ve tapu vasfı listelenir.</div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
let tkMap = null;
let tkSelectedLayer = null;

function initTkgmMap() {
    const googleHybrid = L.tileLayer('https://mt{s}.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
        subdomains: ['0', '1', '2', '3'],
        maxZoom: 22,
        attribution: '&copy; Google Hibrit &bull; TKGM MEGSİS'
    });
    const esriSat = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
        maxZoom: 19,
        attribution: '&copy; Esri World Imagery'
    });

    tkMap = L.map('tkgmMap', {
        preferCanvas: true,
        layers: [googleHybrid]
    }).setView([39.9208, 32.8541], 15);

    L.control.layers({
        "Google Hibrit (HD Uydu)": googleHybrid,
        "Esri Satellite (Ortofoto)": esriSat
    }, null, { position: 'topright' }).addTo(tkMap);

    runTkgmSearch();
}

async function runTkgmSearch() {
    const city = document.getElementById('tkCity').value.trim();
    const dist = document.getElementById('tkDistrict').value.trim();
    const neigh = document.getElementById('tkNeighborhood').value.trim();
    const ada = document.getElementById('tkAda').value.trim();
    const parsel = document.getElementById('tkParsel').value.trim();

    document.getElementById('tkgmHudLoc').textContent = `${city} / ${dist} - Ada ${ada} / Parsel ${parsel}`;

    const deepMapBtn = document.getElementById('btnTkgmDeepMap');
    if (deepMapBtn) {
        let deepUrl = `/ada-parsel-harita?il=${encodeURIComponent(city)}&ilce=${encodeURIComponent(dist)}`;
        if (neigh) deepUrl += `&mahalle=${encodeURIComponent(neigh)}`;
        if (ada) deepUrl += `&ada=${encodeURIComponent(ada)}`;
        if (parsel) deepUrl += `&parsel=${encodeURIComponent(parsel)}`;
        deepMapBtn.href = deepUrl;
    }
    const waBtn = document.getElementById('btnTkgmWa');
    if (waBtn) {
        const waText = `Merhaba, ${city} ${dist} Ada ${ada} / Parsel ${parsel} için MEGSİS kadastro sınırları ve tapu sorgulama danışmanlığı talep ediyorum.`;
        waBtn.href = `https://wa.me/905428413535?text=${encodeURIComponent(waText)}`;
    }

    const params = new URLSearchParams({ province: city, district: dist, neighborhood: neigh, ada, parsel });
    try {
        const res = await fetch(`/parsel/api/parcel.php?${params.toString()}`);
        const data = await res.json();
        if (data && data.parcel && data.parcel.geometry && tkMap) {
            if (tkSelectedLayer) tkMap.removeLayer(tkSelectedLayer);
            tkSelectedLayer = L.geoJSON(data.parcel.geometry, {
                style: { color: '#ef4444', weight: 3.5, fillColor: '#f59e0b', fillOpacity: 0.35 }
            }).addTo(tkMap);
            tkMap.fitBounds(tkSelectedLayer.getBounds(), { padding: [40, 40], maxZoom: 18 });
        }
    } catch (e) {
        console.log(e);
    }
}

document.addEventListener('DOMContentLoaded', initTkgmMap);
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
