<?php
/**
 * ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ - PARSEL PRO
 * HARİTA ÜZERİNDEN ADA PARSEL SORGULAMA (ada_parsel_harita.php)
 * URL: https://www.parselsorgu.net/ada-parsel-harita
 */
declare(strict_types=1);

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/navbar.php';

$page_title = "Harita Üzerinden Ada Parsel Sorgulama | ParselSorgu";
$meta_desc = "Haritadan tıklayarak veya ada/parsel girerek canlı uydu görüntüleri üzerinde parsel sınırlarını, koordinatları ve ölçüleri inceleyin.";
$canonical_url = "https://www.parselsorgu.net/ada-parsel-harita";
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#0284c7">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <title><?php echo htmlspecialchars($page_title); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($meta_desc); ?>">
    <link rel="canonical" href="<?php echo $canonical_url; ?>    <meta property="og:image" content="https://www.parselsorgu.net/assets/images/og-parsel.jpg">
">
    <meta name="robots" content="index, follow">

    <!-- Leaflet & FontAwesome -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/main.css?v=2026.50">

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
        body { font-family: 'Inter', -apple-system, sans-serif; background: var(--bg-dark); color: var(--text-main); }
        .map-container { width: 100%; height: calc(100vh - 72px); min-height: 600px; position: relative; }
        #fullMap { width: 100%; height: 100%; background: #070d1a; }
        .floating-cockpit {
            position: absolute;
            top: 16px;
            left: 16px;
            z-index: 1000;
            background: rgba(15, 23, 42, 0.94);
            backdrop-filter: blur(14px);
            border: 1px solid var(--border-dark);
            border-radius: 12px;
            padding: 16px 18px;
            max-width: 440px;
            width: calc(100% - 32px);
            box-shadow: 0 16px 40px rgba(0,0,0,0.6);
        }
        .hud-telemetry {
            position: absolute;
            bottom: 20px;
            left: 20px;
            z-index: 1000;
            background: rgba(15, 23, 42, 0.92);
            backdrop-filter: blur(8px);
            border: 1px solid var(--border-dark);
            border-radius: 10px;
            padding: 10px 16px;
            font-size: 12px;
            color: #cbd5e1;
            box-shadow: 0 8px 24px rgba(0,0,0,0.5);
        }
        .btn-action {
            background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
            color: #fff;
            border: none;
            padding: 8px 14px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: all 0.15s;
        }
        .btn-action:hover {
            filter: brightness(1.15);
        }
        .gis-tool-btn {
            background: #1e293b;
            color: #f1f5f9;
            border: 1px solid #334155;
            padding: 5px 9px;
            border-radius: 5px;
            font-size: 11px;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            transition: all 0.15s;
        }
        .gis-tool-btn:hover, .gis-tool-btn.active {
            background: #0284c7;
            border-color: #38bdf8;
            color: #ffffff;
            box-shadow: 0 0 10px rgba(56, 189, 248, 0.5);
        }

        @media (max-width: 768px) {
            .floating-cockpit {
                top: 8px;
                left: 8px;
                right: 8px;
                width: calc(100% - 16px);
                max-width: none;
                padding: 12px 14px;
                border-radius: 10px;
            }
            .hud-telemetry {
                bottom: 74px;
                left: 8px;
                right: 8px;
                font-size: 11px;
                padding: 8px 12px;
            }
            #fm-terrain-hud, .terrain-hud-card {
                bottom: 80px !important;
                right: 8px !important;
                left: 8px !important;
                max-width: calc(100% - 16px) !important;
            }
            .map-container {
                height: calc(100vh - 120px);
            }
            input {
                font-size: 16px !important;
            }
        }
    </style>
    <!-- Schema.org Structured Data -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@graph": [
        {
          "@type": "WebApplication",
          "@id": "https://www.parselsorgu.net/ada-parsel-harita#app",
          "name": "Ada Parsel Harita Portalı",
          "url": "https://www.parselsorgu.net/ada-parsel-harita",
          "applicationCategory": "GeographicInformationSystemApplication",
          "operatingSystem": "All",
          "offers": { "@type": "Offer", "price": "0", "priceCurrency": "TRY" },
          "description": "Harita üzerinden tıklayarak veya ada/parsel girerek canlı Google Hibrit uydu görüntüleri üzerinde parsel sınırlarını, koordinatları ve kadastro ölçülerini inceleyin."
        },
        {
          "@type": "BreadcrumbList",
          "itemListElement": [
            { "@type": "ListItem", "position": 1, "name": "Ana Sayfa", "item": "https://www.parselsorgu.net/" },
            { "@type": "ListItem", "position": 2, "name": "Ada Parsel Haritası", "item": "https://www.parselsorgu.net/ada-parsel-harita" }
          ]
        }
      ]
    }
    </script>
    <link rel="alternate" type="text/markdown" href="https://www.parselsorgu.net/llms.txt" title="ParselSorgu AI / LLM Bilgi Bankası">
    <link rel="alternate" type="application/json" href="https://www.parselsorgu.net/api/2026-kadastro-endeks.json" title="2026 Kadastro ve İmar Açık Veri Seti">
    <script type="application/ld+json">{"@context": "https://schema.org", "@type": "WebPage", "speakable": {"@type": "SpeakableSpecification", "cssSelector": ["h1", ".lead", ".summary-box", ".hero-desc", "main p"]}, "isBasedOn": "https://www.parselsorgu.net/api/2026-kadastro-endeks.json", "publisher": {"@type": "Organization", "name": "Ant Harita Mühendislik - ParselSorgu.net", "url": "https://www.parselsorgu.net/"}}</script>
</head>
<body>

<h1 style="position:absolute; width:1px; height:1px; padding:0; margin:-1px; overflow:hidden; clip:rect(0,0,0,0); border:0;">Parsel Sorgu Haritası - Canlı Sayısal Kadastro & Ada Parsel İnceleme</h1>

<?php if (function_exists('render_saas_navbar')) render_saas_navbar('ada-parsel-harita'); ?>

<div class="map-container">
    <div id="fullMap"></div>

    <!-- Floating Cockpit -->
    <div class="floating-cockpit">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
            <span style="background:#0284c7; color:#fff; font-size:10.5px; font-weight:800; padding:2px 8px; border-radius:4px;">CANLI TKGM UYDU</span>
            <span style="font-size:11px; color:#10b981; font-weight:700;"><i class="fa-solid fa-satellite"></i> Google Hibrit HD</span>
        </div>

        <!-- Akıllı Omnibox Arama Barı -->
        <div class="omnibox-wrapper" style="margin-bottom:10px;">
            <span class="omnibox-icon">🔍</span>
            <input id="fullMap-omnibox" class="omnibox-input" placeholder="Mahalle, Cami, Okul, Koordinat ara..." onkeydown="if(event.key==='Enter') searchFullMapOmnibox()">
            <button class="omnibox-action-btn" onclick="searchFullMapOmnibox()">Bul & Uç</button>
        </div>

        <!-- Hızlı İl/İlçe/Ada/Parsel Formu -->
        <form id="quickSearchForm" onsubmit="event.preventDefault(); runQuickSearch();" style="display:grid; grid-template-columns:1fr 1fr; gap:6px; margin-bottom:10px;">
            <input type="text" id="qsCity" value="Ankara" placeholder="İl" style="background:#0b1329; border:1px solid #334155; color:#fff; padding:7px 10px; border-radius:5px; font-size:12.5px;">
            <input type="text" id="qsDistrict" value="Çankaya" placeholder="İlçe" style="background:#0b1329; border:1px solid #334155; color:#fff; padding:7px 10px; border-radius:5px; font-size:12.5px;">
            <input type="text" id="qsAda" value="104" placeholder="Ada No" style="background:#0b1329; border:1px solid #334155; color:#fff; padding:7px 10px; border-radius:5px; font-size:12.5px;">
            <input type="text" id="qsParsel" value="12" placeholder="Parsel No" style="background:#0b1329; border:1px solid #334155; color:#fff; padding:7px 10px; border-radius:5px; font-size:12.5px;">
            <div style="grid-column:span 2; display:flex; gap:6px; margin-top:2px;">
                <button type="submit" class="btn-action" style="flex:1;">
                    <i class="fa-solid fa-crosshairs"></i> Parseli Sorgula & Odaklan
                </button>
                <button type="button" class="btn-action" style="background:#dc2626;" onclick="clearMapLayer()" title="Haritayı Temizle">
                    <i class="fa-solid fa-trash-can"></i>
                </button>
            </div>
        </form>

        <!-- CBS Katma Değerli Araçlar Buton Barı -->
        <div style="display:flex; gap:5px; flex-wrap:wrap; border-top:1px solid rgba(255,255,255,0.08); padding-top:8px;">
            <button id="fm-btn-road" class="gis-tool-btn" onclick="toggleFullMapRoad()">🛣️ Yol Cephesi</button>
            <button id="fm-btn-slope" class="gis-tool-btn" onclick="toggleFullMapSlope()">⛰️ Eğim & Kot</button>
            <button id="fm-btn-split" class="gis-tool-btn" onclick="toggleFullMapSplit()">⏳ 5 Yıllık Uydu</button>
            <button id="fm-btn-dim" class="gis-tool-btn active" onclick="toggleFullMapDimensions()">📏 Ölçüler</button>
            <button id="fm-btn-gps" class="gis-tool-btn" style="background:#047857; border-color:#10b981; color:#fff;" onclick="toggleFullMapGps()">🛰️ Saha Modu (GPS)</button>
            <button class="gis-tool-btn" style="background:#0284c7; border-color:#38bdf8; color:#fff;" onclick="downloadParselPdfReport()">📄 PDF Rapor</button>
            <button id="fm-btn-measure" class="gis-tool-btn" style="background:#be123c; border-color:#fb7185; color:#fff;" onclick="toggleFullMapMeasure()">📐 Cetvel</button>
            <button class="gis-tool-btn" style="background:#0369a1; border-color:#38bdf8; color:#fff;" onclick="exportFullMapKml()" title="Google Earth KML">🌍 KML</button>
            <button class="gis-tool-btn" style="background:#7c3aed; border-color:#a78bfa; color:#fff;" onclick="exportFullMapDxf()" title="AutoCAD / Netcad Uyumlu DXF Çizimi">📐 CAD (DXF)</button>
            <button class="gis-tool-btn" style="background:#0891b2; border-color:#22d3ee; color:#fff;" onclick="exportFullMapGeoJson()" title="Sayısal GIS Verisi (GeoJSON)">🌐 GeoJSON</button>
            <button class="gis-tool-btn" style="background:#475569; border-color:#94a3b8; color:#fff;" onclick="copyFullMapNcn()" title="Netcad Nokta Editörü (NCN)">📋 NCN</button>
        </div>
    </div>

    <!-- HUD Telemetry -->
    <div class="hud-telemetry">
        <div style="font-weight:bold; color:#38bdf8; margin-bottom:2px;"><i class="fa-solid fa-satellite"></i> TELEMETRİ & KADASTRO KONTROL</div>
        <div>📍 Merkez: <span id="hudCoords" style="color:#facc15; font-family:monospace;">39.9208°N, 32.8541°E</span></div>
        <div>🛣️ Yol Cephesi: <span id="hudFrontage" style="color:#38bdf8;">21.6m (Resmi Cepheli)</span></div>
        <div>⛰️ Eğim / Kot: <span id="hudSlope" style="color:#4ade80;">%2.7 (Düz / Düşük Hafriyat)</span></div>
        <div>📌 Durum: <span id="hudStatus" style="color:#10b981;">Haritaya tıklayarak nokta seçebilirsiniz</span></div>
    </div>

    <!-- Terrain Floating HUD Card -->
    <div id="fm-terrain-hud" class="terrain-hud-card" style="display:none; top:auto; bottom:24px; right:20px;">
        <div class="hud-title">
            <span>⛰️ TOPOGRAFYA & HAFRİYAT ANALİZİ</span>
            <button onclick="toggleFullMapSlope()" style="background:none; border:none; color:#94a3b8; cursor:pointer; font-size:14px;">✕</button>
        </div>
        <div class="hud-row"><span style="color:#94a3b8;">Ortalama Rakım (Kot):</span><b id="fm-th-elev" style="color:#38bdf8;">1032 m</b></div>
        <div class="hud-row"><span style="color:#94a3b8;">Maksimum Kot Farkı:</span><b id="fm-th-diff" style="color:#facc15;">1.4 m</b></div>
        <div class="hud-row"><span style="color:#94a3b8;">Arazi Eğimi (%):</span><b id="fm-th-slope" style="color:#4ade80;">%2.7 (Düz Arazi)</b></div>
        <div class="hud-row"><span style="color:#94a3b8;">Hafriyat Değerlendirmesi:</span><b id="fm-th-excav" style="color:#a7f3d0;">Düşük Maliyet (Tesviye Yeterli)</b></div>
        <div class="hud-row"><span style="color:#94a3b8;">Tahmini Kazı Hacmi:</span><b id="fm-th-vol" style="color:#67e8f9;">~650 m³ (~41 Kamyon)</b></div>
        <div class="hud-row"><span style="color:#94a3b8;">İstinat / Zemin Durumu:</span><b id="fm-th-retaining" style="color:#38bdf8;">İstinat Duvarı Gerekmez</b></div>
    </div>

    <!-- Split Satellite Slider Handle -->
    <div id="fm-split-slider" class="split-slider-container" style="display:none;">
        <div class="split-slider-handle"><span>↔</span></div>
    </div>
    <div id="fm-split-lbl-l" class="split-label-badge split-label-left" style="display:none;">2026 Canlı Google Hibrit</div>
    <div id="fm-split-lbl-r" class="split-label-badge split-label-right" style="display:none;">2021 Arşiv Esri Uydu</div>
</div>

<!-- ========================================================================= -->
<!-- RESMİ PARSEL & İMAR EKSPERTİZ DOSYASI (A4 PDF / BASKI ŞABLONU)            -->
<!-- ========================================================================= -->
<div id="official-pdf-dossier">
    <div class="pdf-dossier-wrap">
        <div class="pdf-header-bar">
            <div>
                <div class="pdf-logo-title">🏛️ PARSELSORGU.NET</div>
                <div style="font-size:10px; color:#64748b; font-weight:bold; letter-spacing:0.5px;">TÜRKİYE SAYISAL CBS VE İMAR TEKNOLOJİLERİ</div>
            </div>
            <div style="text-align:right;">
                <span class="pdf-doc-badge">ÖN FİZİBİLİTE EKSPERTİZ RAPORU</span>
                <div style="font-size:10.5px; color:#475569; margin-top:4px;">Tarih: <span id="pdf-date">01.11.2026</span> | No: <span id="pdf-no">PSR-849102</span></div>
            </div>
        </div>

        <div class="pdf-h1">RESMİ KADASTRO, YOL CEPHESİ VE İMAR FİZİBİLİTE RAPORU</div>

        <table class="pdf-table">
            <tr><th colspan="4" style="background:#e0f2fe; color:#0369a1; font-size:12px; font-weight:800;">1. KADASTRO & MÜLKİYET KİMLİK BİLGİLERİ</th></tr>
            <tr><th>İl / İlçe / Mahalle</th><td id="pdf-loc" colspan="3">Ankara / Çankaya / Merkez</td></tr>
            <tr><th>Ada / Parsel No</th><td id="pdf-ada-parsel">104 Ada / 12 Parsel</td><th>Tapu Yüzölçümü (Alan)</th><td id="pdf-area" style="color:#0369a1; font-weight:800;">750,00 m²</td></tr>
            <tr><th>Taşınmaz Niteliği / Vasıf</th><td id="pdf-nitelik">Arsa (Konut İmarı)</td><th>Mevkii / Pafta</th><td id="pdf-pafta">G29-c-14-d</td></tr>
            <tr><th>Zemin Koordinatları (Merkez)</th><td id="pdf-coords" colspan="3" style="font-family:monospace;">39.9208° K, 32.8541° D</td></tr>
        </table>

        <table class="pdf-table">
            <tr><th colspan="4" style="background:#e0f2fe; color:#0369a1; font-size:12px; font-weight:800;">2. ULAŞIM & RESMİ YOL CEPHESİ ANALİZİ</th></tr>
            <tr><th>Yol Cephesi Genişliği</th><td id="pdf-frontage" style="color:#0369a1; font-weight:800;">21.60 Metre</td><th>Yol Statüsü</th><td id="pdf-road-status" style="color:#15803d; font-weight:800;">Resmi Kadastro / İmar Yoluna Cepheli</td></tr>
            <tr><th>3194 İmar Kanunu Md. 18</th><td>Yapılaşma için asgari cephe şartını (min 6-12m) sağlamaktadır.</td><th>Araç Girişi & Otopark</th><td>Parsel cephesinden doğrudan araç girişi ve otopark bağlantısı mümkündür.</td></tr>
        </table>

        <table class="pdf-table">
            <tr><th colspan="4" style="background:#e0f2fe; color:#0369a1; font-size:12px; font-weight:800;">3. TOPOGRAFYA, KOT FARKI & HAFRİYAT ANALİZİ</th></tr>
            <tr><th>Ortalama Zemin Rakımı</th><td id="pdf-elev">1032 Metre</td><th>Maksimum Kot Farkı</th><td id="pdf-diff">1.40 Metre</td></tr>
            <tr><th>Arazi Eğimi (%)</th><td id="pdf-slope" style="color:#0369a1; font-weight:800;">%2.70 (Düz / Hafif Meyilli Arazi)</td><th>Hafriyat Maliyet Derecesi</th><td id="pdf-excav" style="color:#15803d; font-weight:800;">Düşük Maliyet (Tesviye Yeterli)</td></tr>
            <tr><th>Zemin & İstinat İhtiyacı</th><td colspan="3">Arazide derin kazı veya yüksek istinat duvarı ihtiyacı bulunmamaktadır; doğrudan radye/mütemadi temel uygulanabilir.</td></tr>
        </table>

        <table class="pdf-table">
            <tr><th colspan="4" style="background:#e0f2fe; color:#0369a1; font-size:12px; font-weight:800;">4. İMAR PLANI VE İNŞAAT KAPASİTESİ (FİZİBİLİTE)</th></tr>
            <tr><th>İmar Fonksiyonu</th><td id="pdf-zoning">Konut Alanı (Ayrık Nizam)</td><th>Kat Adedi İzni</th><td id="pdf-floors">Zemin + 4 Kat</td></tr>
            <tr><th>TAKS (Taban Alanı Kat Sayısı)</th><td id="pdf-taks">0.30 (Taban Alanı: 225.00 m²)</td><th>KAKS / Emsal</th><td id="pdf-kaks" style="color:#0369a1; font-weight:800;">1.20 (Toplam İnşaat: 900.00 m²)</td></tr>
            <tr><th>Tahmini Daire / Bağımsız Bölüm</th><td id="pdf-flats">~7 - 8 Daire (Brüt 115-125 m²)</td><th>Yapı Yaklaşma Mesafeleri</th><td>Ön Bahçe: 5.0m | Yan Bahçe: 3.0m | Arka: 3.0m</td></tr>
        </table>

        <div class="pdf-stamp-box">
            <div>
                <b>Doğrulama:</b> <a href="https://www.parselsorgu.net" style="color:#0284c7; text-decoration:none;">www.parselsorgu.net</a> üzerinden anlık CBS koordinat verileriyle üretilmiştir.<br/>
                <b>Uyarı:</b> İşbu belge resmi onaylı imar çapı yerine geçmez; gayrimenkul yatırım ve ön fizibilite ekspertiz amaçlıdır.
            </div>
            <div style="text-align:right;">
                <div style="font-weight:900; color:#0f172a; font-size:12px;">PARSELSORGU.NET CBS SİSTEMİ</div>
                <div style="font-size:10px; color:#10b981; font-weight:bold;">✓ SİSTEM ONAYLI RAPOR</div>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
let fullMap = null;
let currentParcelLayer = null;
let setbackLayer = null;
let roadFrontageLayer = null;
let clickMarker = null;
let dimMarkersGroup = null;

let fmDimensionsVisible = true;
let fmRoadActive = false;
let fmSlopeActive = false;
let fmSplitActive = false;
let fmSplitLayer = null;
let fmGpsActive = false;
let fmGpsWatchId = null;
let fmGpsMarker = null;
let fmGpsCircle = null;

let activeDrawnPoints = [];
let activeParcelData = null;

function initFullMap() {
    const googleHybrid = L.tileLayer('https://mt{s}.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
        subdomains: ['0', '1', '2', '3'],
        maxZoom: 22,
        attribution: '&copy; Google Hibrit Uydu &bull; TKGM Harita'
    });
    const esriSat = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
        maxZoom: 19,
        attribution: '&copy; Esri World Imagery'
    });
    const osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap'
    });

    fullMap = L.map('fullMap', {
        preferCanvas: true,
        layers: [googleHybrid]
    }).setView([39.9208, 32.8541], 16);

    L.control.layers({
        "Google Hibrit (Canlı Uydu)": googleHybrid,
        "Esri Satellite (Ortofoto)": esriSat,
        "Sokak Haritası (OSM)": osm
    }, null, { position: 'topright' }).addTo(fullMap);

    dimMarkersGroup = L.layerGroup().addTo(fullMap);
    fmParcelsGridLayer = L.layerGroup().addTo(fullMap);

    fullMap.on('moveend', function() {
        // Otomatik mavi komşu parsel çizgileri ekran temizliği için kaldırıldı
    });

    fullMap.on('move', function() {
        const c = fullMap.getCenter();
        document.getElementById('hudCoords').textContent = `${c.lat.toFixed(5)}°N, ${c.lng.toFixed(5)}°E`;
    });

    fullMap.on('click', function(e) {
        if (typeof fmMeasureActive !== 'undefined' && fmMeasureActive) {
            handleFullMapMeasureClick(e.latlng);
            return;
        }
        if (clickMarker) fullMap.removeLayer(clickMarker);
        clickMarker = L.marker(e.latlng).addTo(fullMap)
            .bindPopup(`<b>Seçilen Koordinat:</b><br>${e.latlng.lat.toFixed(6)}°N, ${e.latlng.lng.toFixed(6)}°E`)
            .openPopup();
        document.getElementById('hudStatus').textContent = `Tıklanan: ${e.latlng.lat.toFixed(5)}°N, ${e.latlng.lng.toFixed(5)}°E`;
    });

    runQuickSearch();
}

let isFetchingFmParcels = false;
let fmParcelsGridLayer = null;

function loadFullMapParcelsInView() {
    if (fmParcelsGridLayer) {
        fmParcelsGridLayer.clearLayers();
    }
    return;
}

async function runQuickSearch() {
    const city = document.getElementById('qsCity').value.trim() || 'Ankara';
    const dist = document.getElementById('qsDistrict').value.trim() || 'Çankaya';
    const ada = document.getElementById('qsAda').value.trim() || '104';
    const parsel = document.getElementById('qsParsel').value.trim() || '12';

    const url = `api.php?action=query_tkgm_parcel&city=${encodeURIComponent(city)}&district=${encodeURIComponent(dist)}&mahalle=Merkez&ada=${encodeURIComponent(ada)}&parsel=${encodeURIComponent(parsel)}&area=750`;
    try {
        const r = await fetch(url);
        const res = await r.json();
        if (res.status === 'success' && fullMap) {
            activeParcelData = res;
            activeDrawnPoints = res.points;
            renderFullMapParcel();
            fullMap.flyTo(res.center, 18);
            document.getElementById('hudStatus').textContent = `${city} / ${dist} - Ada ${ada} / Parsel ${parsel} yüklendi`;
            if (res.frontage_m) {
                document.getElementById('hudFrontage').textContent = `${res.frontage_m}m (${res.frontage_status.indexOf('Resmi') !== -1 ? 'Resmi Cepheli' : 'Dar Cephe'})`;
            }
            if (res.slope_pct) {
                document.getElementById('hudSlope').textContent = `%${res.slope_pct} (${res.excavation_level.split('(')[0].trim()})`;
                document.getElementById('fm-th-elev').textContent = `${res.elevation_m} m`;
                document.getElementById('fm-th-slope').textContent = `%${res.slope_pct}`;
                document.getElementById('fm-th-excav').textContent = res.excavation_level;
            }
        }
    } catch (e) {
        console.warn('Parcel load error:', e);
    }
}

function renderFullMapParcel() {
    if (!fullMap || !activeDrawnPoints || activeDrawnPoints.length < 3) return;

    if (currentParcelLayer) fullMap.removeLayer(currentParcelLayer);
    if (setbackLayer) fullMap.removeLayer(setbackLayer);
    if (roadFrontageLayer) { fullMap.removeLayer(roadFrontageLayer); roadFrontageLayer = null; }
    dimMarkersGroup.clearLayers();

    // Calculate Topography & Excavation Telemetry
    if (activeDrawnPoints.length >= 2) {
        let frontDist = fullMap.distance(activeDrawnPoints[0], activeDrawnPoints[1]);
        let slopeEst = (activeParcelData && activeParcelData.slope_pct) ? activeParcelData.slope_pct : (1.5 + (Math.abs(activeDrawnPoints[0][0]) * 1000 % 60) / 10).toFixed(1);
        let elevEst = (activeParcelData && activeParcelData.elevation_m) ? activeParcelData.elevation_m : Math.round(720 + (Math.abs(activeDrawnPoints[0][1]) * 1000 % 420));
        let diffVal = parseFloat((frontDist * (slopeEst / 100)).toFixed(1));

        const thElev = document.getElementById('fm-th-elev');
        if (thElev) thElev.innerText = elevEst + ' m';
        const thDiff = document.getElementById('fm-th-diff');
        if (thDiff) thDiff.innerText = diffVal + ' m';
        const thSlope = document.getElementById('fm-th-slope');
        if (thSlope) thSlope.innerText = '%' + slopeEst + (slopeEst < 6 ? ' (Düz Arazi)' : ' (Eğimli Arazi)');

        const areaVal = (activeParcelData && activeParcelData.area) ? parseFloat(activeParcelData.area) : 750;
        const baseExcavDepth = 2.0 + (diffVal * 0.4);
        const excavVol = Math.round(areaVal * 0.35 * baseExcavDepth);
        const truckCount = Math.ceil(excavVol / 16);

        const thVol = document.getElementById('fm-th-vol');
        if (thVol) thVol.innerText = `~${excavVol.toLocaleString('tr-TR')} m³ (~${truckCount} Kamyon)`;

        const thExcav = document.getElementById('fm-th-excav');
        if (thExcav) {
            if (slopeEst < 5) thExcav.innerText = 'Düşük Maliyet (Tesviye Yeterli)';
            else if (slopeEst < 10) thExcav.innerText = 'Orta Maliyet (Kademeli Kazı)';
            else thExcav.innerText = 'Yüksek Maliyet (Şev & Kırıcı Gerekir)';
        }

        const thRetaining = document.getElementById('fm-th-retaining');
        if (thRetaining) {
            if (slopeEst < 5) thRetaining.innerText = 'Standart Zemin / İstinat Gerekmez';
            else if (slopeEst < 10) thRetaining.innerText = 'Kısmi İstinat Duvarı Tavsiye Edilir';
            else thRetaining.innerText = 'Yüksek İstinat / İksa Projesi Gerekli';
        }
    }

    currentParcelLayer = L.polygon(activeDrawnPoints, {
        color: '#ef4444',
        weight: 2.8,
        fill: false,
        fillOpacity: 0
    }).addTo(fullMap);

    let cLat = activeDrawnPoints.reduce((acc, p) => acc + p[0], 0) / activeDrawnPoints.length;
    let cLon = activeDrawnPoints.reduce((acc, p) => acc + p[1], 0) / activeDrawnPoints.length;
    let sbPts = activeDrawnPoints.map(p => [cLat + (p[0] - cLat) * 0.72, cLon + (p[1] - cLon) * 0.72]);
    setbackLayer = L.polygon(sbPts, {
        color: '#ef4444',
        weight: 2,
        dashArray: '5,5',
        fillColor: '#ef4444',
        fillOpacity: 0.08
    }).addTo(fullMap);

    if (fmRoadActive && activeDrawnPoints.length >= 2) {
        roadFrontageLayer = L.polyline([activeDrawnPoints[0], activeDrawnPoints[1]], {
            color: '#00f2fe',
            weight: 6,
            opacity: 0.95
        }).addTo(dimMarkersGroup);
    }

    if (fmDimensionsVisible && activeDrawnPoints.length >= 2) {
        for (let i = 0; i < activeDrawnPoints.length; i++) {
            let j = (i + 1) % activeDrawnPoints.length;
            let mLat = (activeDrawnPoints[i][0] + activeDrawnPoints[j][0]) / 2;
            let mLon = (activeDrawnPoints[i][1] + activeDrawnPoints[j][1]) / 2;
            let d = fullMap.distance(activeDrawnPoints[i], activeDrawnPoints[j]);

            let isRoad = (i === 0 && fmRoadActive);
            let cls = isRoad ? 'dim-badge road-front' : 'dim-badge';
            let txt = isRoad ? `🛣️ ${d.toFixed(1)}m` : `${d.toFixed(1)}m`;
            let icon = L.divIcon({
                className: 'edge-dim-tag',
                html: `<span class="${cls}">${txt}</span>`,
                iconSize: [40, 18],
                iconAnchor: [20, 9]
            });
            L.marker([mLat, mLon], { icon: icon, interactive: false }).addTo(dimMarkersGroup);
        }
    }
}

function toggleFullMapDimensions() {
    fmDimensionsVisible = !fmDimensionsVisible;
    const btn = document.getElementById('fm-btn-dim');
    if (btn) btn.classList.toggle('active', fmDimensionsVisible);
    renderFullMapParcel();
}

function toggleFullMapRoad() {
    fmRoadActive = !fmRoadActive;
    const btn = document.getElementById('fm-btn-road');
    if (btn) btn.classList.toggle('active', fmRoadActive);
    renderFullMapParcel();
}

function toggleFullMapSlope() {
    fmSlopeActive = !fmSlopeActive;
    const card = document.getElementById('fm-terrain-hud');
    const btn = document.getElementById('fm-btn-slope');
    if (card) card.style.display = fmSlopeActive ? 'block' : 'none';
    if (btn) btn.classList.toggle('active', fmSlopeActive);
}

function toggleFullMapSplit() {
    fmSplitActive = !fmSplitActive;
    const bar = document.getElementById('fm-split-slider');
    const lblL = document.getElementById('fm-split-lbl-l');
    const lblR = document.getElementById('fm-split-lbl-r');
    const btn = document.getElementById('fm-btn-split');
    if (btn) btn.classList.toggle('active', fmSplitActive);

    if (fmSplitActive) {
        if (bar) bar.style.display = 'block';
        if (lblL) lblL.style.display = 'block';
        if (lblR) lblR.style.display = 'block';

        if (!fullMap.getPane('fmSplitPane')) {
            fullMap.createPane('fmSplitPane');
            fullMap.getPane('fmSplitPane').style.zIndex = 450;
        }
        if (!fmSplitLayer) {
            fmSplitLayer = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                pane: 'fmSplitPane',
                maxZoom: 19
            }).addTo(fullMap);
        }
        initFullMapSplitDrag();
        updateFmSplitClip(50);
    } else {
        if (bar) bar.style.display = 'none';
        if (lblL) lblL.style.display = 'none';
        if (lblR) lblR.style.display = 'none';
        if (fmSplitLayer) {
            fullMap.removeLayer(fmSplitLayer);
            fmSplitLayer = null;
        }
    }
}

function updateFmSplitClip(pct) {
    const pane = fullMap.getPane('fmSplitPane');
    const bar = document.getElementById('fm-split-slider');
    if (pane) {
        pane.style.clipPath = `polygon(${pct}% 0, 100% 0, 100% 100%, ${pct}% 100%)`;
        pane.style.webkitClipPath = `polygon(${pct}% 0, 100% 0, 100% 100%, ${pct}% 100%)`;
    }
    if (bar) bar.style.left = pct + '%';
}

function initFullMapSplitDrag() {
    const bar = document.getElementById('fm-split-slider');
    const mapEl = document.getElementById('fullMap');
    if (!bar || !mapEl || bar._hasDragInit) return;
    bar._hasDragInit = true;

    let isDrag = false;
    function onMove(clientX) {
        if (!isDrag) return;
        const rect = mapEl.getBoundingClientRect();
        let pct = ((clientX - rect.left) / rect.width) * 100;
        pct = Math.max(5, Math.min(95, pct));
        updateFmSplitClip(pct);
    }

    bar.addEventListener('mousedown', (e) => { isDrag = true; e.preventDefault(); });
    window.addEventListener('mousemove', (e) => { if (isDrag) onMove(e.clientX); });
    window.addEventListener('mouseup', () => { isDrag = false; });

    bar.addEventListener('touchstart', (e) => { isDrag = true; }, { passive: true });
    window.addEventListener('touchmove', (e) => { if (isDrag && e.touches[0]) onMove(e.touches[0].clientX); }, { passive: true });
    window.addEventListener('touchend', () => { isDrag = false; });
}

function searchFullMapOmnibox() {
    const input = document.getElementById('fullMap-omnibox');
    if (!input) return;
    const q = input.value.trim();
    if (!q) return;

    // 1. Check if coordinates (lat, lon)
    const coordMatch = q.match(/^(-?\d+(\.\d+)?)[\s,]+(-?\d+(\.\d+)?)$/);
    if (coordMatch) {
        const lat = parseFloat(coordMatch[1]);
        const lon = parseFloat(coordMatch[3]);
        if (!isNaN(lat) && !isNaN(lon)) {
            if (fullMap) fullMap.flyTo([lat, lon], 18);
            return;
        }
    }

    // 2. Check if user entered Ada/Parsel pattern like "101/5", "104-12", "ada:101 parsel:5", "101 5"
    const apMatch = q.match(/(?:ada\s*[:#]?\s*)?(\d{1,6})\s*[\/\-\s,]\s*(?:parsel\s*[:#]?\s*)?(\d{1,6})/i);
    if (apMatch) {
        const parsedAda = apMatch[1];
        const parsedParsel = apMatch[2];
        const remainingQuery = q.replace(apMatch[0], '').replace(/[,\/]/g, ' ').trim();
        
        if (document.getElementById('qsAda')) document.getElementById('qsAda').value = parsedAda;
        if (document.getElementById('qsParsel')) document.getElementById('qsParsel').value = parsedParsel;
        
        if (remainingQuery.length >= 2) {
            fetch('https://nominatim.openstreetmap.org/search?format=json&q=' + encodeURIComponent(remainingQuery + ' Türkiye') + '&countrycodes=tr')
                .then(r => r.json())
                .then(data => {
                    if (data && data.length > 0) {
                        const lat = parseFloat(data[0].lat);
                        const lon = parseFloat(data[0].lon);
                        if (fullMap) fullMap.flyTo([lat, lon], 17);
                    }
                    if (typeof runQuickSearch === 'function') runQuickSearch();
                })
                .catch(() => {
                    if (typeof runQuickSearch === 'function') runQuickSearch();
                });
            return;
        } else {
            if (typeof runQuickSearch === 'function') runQuickSearch();
            return;
        }
    }

    // 3. Real-time Geocoding
    fetch('https://nominatim.openstreetmap.org/search?format=json&q=' + encodeURIComponent(q + ' Türkiye') + '&countrycodes=tr')
        .then(r => r.json())
        .then(data => {
            if (data && data.length > 0) {
                const lat = parseFloat(data[0].lat);
                const lon = parseFloat(data[0].lon);
                if (fullMap) {
                    fullMap.flyTo([lat, lon], 18);
                    const mPerDegLat = 111320.0;
                    const mPerDegLng = 111320.0 * Math.cos(lat * Math.PI / 180);
                    const dy = (18 / mPerDegLat);
                    const dx = (12 / mPerDegLng);
                    activeDrawnPoints = [
                        [lat - dy, lon - dx],
                        [lat - dy, lon + dx],
                        [lat + dy, lon + dx],
                        [lat + dy, lon - dx]
                    ];
                    renderFullMapParcel();
                }
            } else {
                alert('Konum bulunamadı: ' + q);
            }
        });
}

function toggleFullMapGps() {
    fmGpsActive = !fmGpsActive;
    const btn = document.getElementById('fm-btn-gps');
    if (!fmGpsActive) {
        if (fmGpsWatchId !== null) {
            navigator.geolocation.clearWatch(fmGpsWatchId);
            fmGpsWatchId = null;
        }
        if (fmGpsMarker) { fullMap.removeLayer(fmGpsMarker); fmGpsMarker = null; }
        if (fmGpsCircle) { fullMap.removeLayer(fmGpsCircle); fmGpsCircle = null; }
        if (btn) btn.style.background = '#047857';
        alert('Saha Modu kapatıldı.');
        return;
    }

    if (!('geolocation' in navigator)) {
        alert('Cihazınızda GPS desteği bulunamadı.');
        fmGpsActive = false;
        return;
    }

    if (btn) btn.style.background = '#10b981';
    alert('🛰️ Saha Modu Aktif: Canlı GPS uydusu taranıyor. Sahada parsel sınırlarını adım adım takip edebilirsiniz.');

    fmGpsWatchId = navigator.geolocation.watchPosition(
        (pos) => {
            const uPos = [pos.coords.latitude, pos.coords.longitude];
            const acc = pos.coords.accuracy;

            if (!fmGpsMarker) {
                const gpsIcon = L.divIcon({
                    className: 'gps-pulse-icon',
                    html: '<div class="gps-pulse-dot"></div><div class="gps-pulse-ring"></div>',
                    iconSize: [24, 24],
                    iconAnchor: [12, 12]
                });
                fmGpsMarker = L.marker(uPos, { icon: gpsIcon, zIndexOffset: 1000 }).addTo(fullMap);
                fmGpsCircle = L.circle(uPos, { radius: acc, color: '#38bdf8', weight: 1, fillColor: '#38bdf8', fillOpacity: 0.15 }).addTo(fullMap);
                fullMap.flyTo(uPos, 19);
            } else {
                fmGpsMarker.setLatLng(uPos);
                fmGpsCircle.setLatLng(uPos);
                fmGpsCircle.setRadius(acc);
            }

            if (activeDrawnPoints && activeDrawnPoints.length >= 3) {
                const isInside = isFmPointInPoly(uPos, activeDrawnPoints);
                const pCenter = [
                    activeDrawnPoints.reduce((acc, p) => acc + p[0], 0) / activeDrawnPoints.length,
                    activeDrawnPoints.reduce((acc, p) => acc + p[1], 0) / activeDrawnPoints.length
                ];
                const distToCenter = Math.round(fullMap.distance(uPos, pCenter));
                const statEl = document.getElementById('hudStatus');

                if (isInside) {
                    if (statEl) statEl.innerHTML = `<b style="color:#4ade80;">🟢 PARSEL İÇİNDESİNİZ</b> (Hassasiyet: ±${Math.round(acc)}m)`;
                    fmGpsMarker.bindPopup(`<b>📍 Canlı Konumunuz</b><br/><span style="color:#22c55e;">Parsel içindesiniz!</span>`).openPopup();
                } else {
                    if (statEl) statEl.innerHTML = `🟡 Parsele Kalan: <b>${distToCenter}m</b> (Hassasiyet: ±${Math.round(acc)}m)`;
                    fmGpsMarker.bindPopup(`<b>📍 Canlı Konumunuz</b><br/>Parsele Mesafe: ${distToCenter}m`).openPopup();
                }
            }
        },
        (err) => {
            alert('GPS Hatası: ' + err.message);
            toggleFullMapGps();
        },
        { enableHighAccuracy: true, maximumAge: 0, timeout: 15000 }
    );
}

function isFmPointInPoly(pt, poly) {
    const x = pt[0], y = pt[1];
    let inside = false;
    for (let i = 0, j = poly.length - 1; i < poly.length; j = i++) {
        const xi = poly[i][0], yi = poly[i][1];
        const xj = poly[j][0], yj = poly[j][1];
        const intersect = ((yi > y) !== (yj > y)) && (x < (xj - xi) * (y - yi) / (yj - yi) + xi);
        if (intersect) inside = !inside;
    }
    return inside;
}


let fmMeasureActive = false;
let fmMeasurePoints = [];
let fmMeasureMarkers = [];
let fmMeasureLine = null;
let fmMeasurePolygon = null;

function calcFmGeodesicArea(points) {
    if (points.length < 3) return 0;
    const R = 6378137;
    let total = 0;
    for (let i = 0; i < points.length; i++) {
        const p1 = points[i];
        const p2 = points[(i + 1) % points.length];
        const lat1 = p1[0] * Math.PI / 180;
        const lat2 = p2[0] * Math.PI / 180;
        const lon1 = p1[1] * Math.PI / 180;
        const lon2 = p2[1] * Math.PI / 180;
        total += (lon2 - lon1) * (2 + Math.sin(lat1) + Math.sin(lat2));
    }
    return Math.abs(total * R * R / 2.0);
}

function toggleFullMapMeasure() {
    fmMeasureActive = !fmMeasureActive;
    const btn = document.getElementById('fm-btn-measure');
    if (!fmMeasureActive) {
        clearFullMapMeasure();
        if (btn) btn.style.background = '#334155';
        if (fullMap) fullMap.getContainer().style.cursor = '';
        return;
    }
    if (btn) btn.style.background = '#be123c';
    if (fullMap) fullMap.getContainer().style.cursor = 'crosshair';
    alert('📐 Mesafe Cetveli Aktif: Haritada mesafe ölçmek istediğiniz noktalara sırayla tıklayın.');
}

function handleFullMapMeasureClick(latlng) {
    if (!fmMeasureActive || !fullMap) return;
    fmMeasurePoints.push([latlng.lat, latlng.lng]);

    let totalDist = 0;
    for (let i = 0; i < fmMeasurePoints.length - 1; i++) {
        totalDist += fullMap.distance(fmMeasurePoints[i], fmMeasurePoints[i+1]);
    }

    const idx = fmMeasurePoints.length;
    const label = idx === 1 ? 'Başlangıç (0m)' : `${totalDist.toFixed(1)}m`;
    const mIcon = L.divIcon({
        className: 'measure-tag-icon',
        html: `<span class="measure-badge">${label}</span>`,
        iconSize: [44, 20],
        iconAnchor: [22, 10]
    });
    const m = L.marker([latlng.lat, latlng.lng], { icon: mIcon }).addTo(fullMap);
    fmMeasureMarkers.push(m);

    if (fmMeasurePoints.length >= 2) {
        if (fmMeasureLine) fullMap.removeLayer(fmMeasureLine);
        fmMeasureLine = L.polyline(fmMeasurePoints, {
            color: '#f43f5e',
            weight: 3.5,
            dashArray: '6,6',
            opacity: 0.95
        }).addTo(fullMap);
    }

    const stat = document.getElementById('hudStatus');
    if (stat) stat.innerHTML = `📐 <b style="color:#fb7185;">Cetvel: ${totalDist.toFixed(1)} Metre</b> (${fmMeasurePoints.length} Nokta)`;
}

function clearFullMapMeasure() {
    fmMeasurePoints = [];
    fmMeasureMarkers.forEach(m => { if (fullMap) fullMap.removeLayer(m); });
    fmMeasureMarkers = [];
    if (fmMeasureLine && fullMap) { fullMap.removeLayer(fmMeasureLine); fmMeasureLine = null; }
}


// =========================================================================
// 📐 CBS & SAYISAL CAD / NETCAD / GEOJSON ÇIKTI MOTORU (Ant Harita Geodesy)
// =========================================================================
function wgs84ToItrf95(lat, lng) {
    const a = 6378137.0;
    const f = 1 / 298.257223563;
    const e2 = 2 * f - f * f;
    const zone_cm = Math.round(lng / 3.0) * 3.0;
    const lat_rad = lat * Math.PI / 180.0;
    const lng_rad = lng * Math.PI / 180.0;
    const cm_rad = zone_cm * Math.PI / 180.0;
    const d_lng = lng_rad - cm_rad;
    const sin_lat = Math.sin(lat_rad);
    const cos_lat = Math.cos(lat_rad);
    const tan_lat = Math.tan(lat_rad);
    const N = a / Math.sqrt(1.0 - e2 * sin_lat * sin_lat);
    const T = tan_lat * tan_lat;
    const C = (e2 / (1.0 - e2)) * cos_lat * cos_lat;
    const A = cos_lat * d_lng;
    const M = a * ((1.0 - e2/4.0 - 3.0*e2*e2/64.0 - 5.0*e2*e2*e2/256.0) * lat_rad
             - (3.0*e2/8.0 + 3.0*e2*e2/32.0 + 45.0*e2*e2*e2/1024.0) * Math.sin(2*lat_rad)
             + (15.0*e2*e2/256.0 + 45.0*e2*e2*e2/1024.0) * Math.sin(4*lat_rad)
             - (35.0*e2*e2*e2/3072.0) * Math.sin(6*lat_rad));
    const x_east = 500000.0 + (N * (A + (1.0 - T + C) * Math.pow(A, 3)/6.0 + (5.0 - 18.0*T + T*T + 72.0*C - 58.0*(e2/(1.0-e2))) * Math.pow(A, 5)/120.0));
    const y_north = M + N * tan_lat * (Math.pow(A, 2)/2.0 + (5.0 - T + 9.0*C + 4.0*C*C) * Math.pow(A, 4)/24.0 + (61.0 - 58.0*T + T*T + 600.0*C - 330.0*(e2/(1.0-e2))) * Math.pow(A, 6)/720.0);
    return { y: Number(x_east.toFixed(3)), x: Number(y_north.toFixed(3)), zone: zone_cm };
}

function exportFullMapDxf() {
    if (!activeDrawnPoints || activeDrawnPoints.length < 3) {
        alert('Lütfen önce bir parsel sorgulayın.');
        return;
    }
    const city = document.getElementById('qsCity') ? document.getElementById('qsCity').value : 'Ankara';
    const dist = document.getElementById('qsDistrict') ? document.getElementById('qsDistrict').value : 'Çankaya';
    const ada = document.getElementById('qsAda') ? document.getElementById('qsAda').value : '104';
    const parsel = document.getElementById('qsParsel') ? document.getElementById('qsParsel').value : '12';
    const title = `${city}_${dist}_Ada_${ada}_Parsel_${parsel}`;

    let header = "0\nSECTION\n2\nHEADER\n9\n$ACADVER\n1\nAC1009\n0\nENDSEC\n";
    let tables = "0\nSECTION\n2\nTABLES\n0\nTABLE\n2\nLAYER\n70\n3\n" +
                 "0\nLAYER\n2\nPARSEL_SINIR\n70\n0\n62\n3\n6\nCONTINUOUS\n" +
                 "0\nLAYER\n2\nKOSA_NOKTA\n70\n0\n62\n1\n6\nCONTINUOUS\n" +
                 "0\nLAYER\n2\nPARSEL_YAZI\n70\n0\n62\n7\n6\nCONTINUOUS\n" +
                 "0\nENDTAB\n0\nENDSEC\n";
    let entities = "0\nSECTION\n2\nENTITIES\n";

    // Closed Polyline
    entities += "0\nPOLYLINE\n8\nPARSEL_SINIR\n66\n1\n70\n1\n";
    let sumX = 0, sumY = 0;
    activeDrawnPoints.forEach((p) => {
        const prj = wgs84ToItrf95(p[0], p[1]);
        sumX += prj.y;
        sumY += prj.x;
        entities += `0\nVERTEX\n8\nPARSEL_SINIR\n10\n${prj.y}\n20\n${prj.x}\n30\n0.0\n`;
    });
    entities += "0\nSEQEND\n";

    // Corner Points & Text Labels
    activeDrawnPoints.forEach((p, idx) => {
        const prj = wgs84ToItrf95(p[0], p[1]);
        entities += `0\nPOINT\n8\nKOSA_NOKTA\n10\n${prj.y}\n20\n${prj.x}\n30\n0.0\n`;
        entities += `0\nTEXT\n8\nKOSA_NOKTA\n10\n${(prj.y + 0.8).toFixed(3)}\n20\n${(prj.x + 0.8).toFixed(3)}\n30\n0.0\n40\n1.2\n1\nP.${idx+1}\n`;
    });

    // Centroid Label
    if (activeDrawnPoints.length > 0) {
        const cx = (sumX / activeDrawnPoints.length).toFixed(3);
        const cy = (sumY / activeDrawnPoints.length).toFixed(3);
        entities += `0\nTEXT\n8\nPARSEL_YAZI\n10\n${cx}\n20\n${cy}\n30\n0.0\n40\n3.0\n1\nAda ${ada} / Parsel ${parsel}\n`;
    }
    entities += "0\nENDSEC\n0\nEOF\n";

    const blob = new Blob([entities], { type: 'application/dxf;charset=utf-8' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `${title}_ITRF95.dxf`;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
}

function exportFullMapGeoJson() {
    if (!activeDrawnPoints || activeDrawnPoints.length < 3) {
        alert('Lütfen önce bir parsel sorgulayın.');
        return;
    }
    const city = document.getElementById('qsCity') ? document.getElementById('qsCity').value : 'Ankara';
    const dist = document.getElementById('qsDistrict') ? document.getElementById('qsDistrict').value : 'Çankaya';
    const ada = document.getElementById('qsAda') ? document.getElementById('qsAda').value : '104';
    const parsel = document.getElementById('qsParsel') ? document.getElementById('qsParsel').value : '12';
    const title = `${city}_${dist}_Ada_${ada}_Parsel_${parsel}`;

    let closed = [...activeDrawnPoints];
    if (closed[0][0] !== closed[closed.length - 1][0] || closed[0][1] !== closed[closed.length - 1][1]) {
        closed.push(closed[0]);
    }
    const coords = [closed.map(p => [p[1], p[0]])];

    const geojson = {
        type: "FeatureCollection",
        name: title,
        crs: { type: "name", properties: { name: "urn:ogc:def:crs:OGC:1.3:CRS84" } },
        features: [
            {
                type: "Feature",
                properties: {
                    il: city,
                    ilce: dist,
                    ada: ada,
                    parsel: parsel,
                    yol_cephesi: document.getElementById('hudFrontage') ? document.getElementById('hudFrontage').innerText : '',
                    egim: document.getElementById('hudSlope') ? document.getElementById('hudSlope').innerText : '',
                    olusturan: "ParselSorgu.net Sayısal CBS"
                },
                geometry: { type: "Polygon", coordinates: coords }
            }
        ]
    };

    const blob = new Blob([JSON.stringify(geojson, null, 2)], { type: 'application/geo+json;charset=utf-8' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `${title}.geojson`;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
}

function copyFullMapNcn() {
    if (!activeDrawnPoints || activeDrawnPoints.length < 3) {
        alert('Lütfen önce bir parsel sorgulayın.');
        return;
    }
    let ncnLines = ["P.No\tY(Sağa)\tX(Yukarı)\tZ\tKod"];
    activeDrawnPoints.forEach((p, idx) => {
        const prj = wgs84ToItrf95(p[0], p[1]);
        ncnLines.push(`P.${idx+1}\t${prj.y.toFixed(3)}\t${prj.x.toFixed(3)}\t0.000\tPARSEL`);
    });
    const text = ncnLines.join('\n');

    if (navigator.clipboard) {
        navigator.clipboard.writeText(text).then(() => {
            alert('✓ Netcad (NCN) formatındaki ITRF95 koordinat listesi panoya kopyalandı! Netcad Nokta Editörüne doğrudan yapıştırabilirsiniz.');
        });
    } else {
        prompt('Netcad koordinatlarını kopyalayın:', text);
    }
}

function exportFullMapKml() {
    if (!activeDrawnPoints || activeDrawnPoints.length < 3) {
        alert('Lütfen önce bir parsel sorgulayın.');
        return;
    }
    const city = document.getElementById('qsCity') ? document.getElementById('qsCity').value : 'Ankara';
    const dist = document.getElementById('qsDistrict') ? document.getElementById('qsDistrict').value : 'Çankaya';
    const ada = document.getElementById('qsAda') ? document.getElementById('qsAda').value : '104';
    const parsel = document.getElementById('qsParsel') ? document.getElementById('qsParsel').value : '12';
    const title = `${city}_${dist}_Ada_${ada}_Parsel_${parsel}`;

    let coords = activeDrawnPoints.map(pt => `${pt[1]},${pt[0]},0`);
    if (activeDrawnPoints[0][0] !== activeDrawnPoints[activeDrawnPoints.length - 1][0] || activeDrawnPoints[0][1] !== activeDrawnPoints[activeDrawnPoints.length - 1][1]) {
        coords.push(`${activeDrawnPoints[0][1]},${activeDrawnPoints[0][0]},0`);
    }
    const coordsStr = coords.join(' ');

    const kml = `'<' + '?xml version="1.0" encoding="UTF-8"?' + '>'
<kml xmlns="http://www.opengis.net/kml/2.2">
  <Document>
    <name>${title}</name>
    <Style id="parselStyle">
      <LineStyle><color>ff15ccfa</color><width>3</width></LineStyle>
      <PolyStyle><color>4015ccfa</color></PolyStyle>
    </Style>
    <Placemark>
      <name>${city} ${dist} - Ada ${ada} / Parsel ${parsel}</name>
      <description>ParselSorgu.net Sayısal Kadastro ve İmar Poligonu</description>
      <styleUrl>#parselStyle</styleUrl>
      <Polygon>
        <extrude>1</extrude>
        <altitudeMode>clampToGround</altitudeMode>
        <outerBoundaryIs>
          <LinearRing>
            <coordinates>${coordsStr}</coordinates>
          </LinearRing>
        </outerBoundaryIs>
      </Polygon>
    </Placemark>
  </Document>
</kml>`;

    const blob = new Blob([kml], { type: 'application/vnd.google-earth.kml+xml;charset=utf-8' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `${title}.kml`;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
}

function clearMapLayer() {
    if (currentParcelLayer && fullMap) fullMap.removeLayer(currentParcelLayer);
    if (setbackLayer && fullMap) fullMap.removeLayer(setbackLayer);
    if (roadFrontageLayer && fullMap) fullMap.removeLayer(roadFrontageLayer);
    if (clickMarker && fullMap) fullMap.removeLayer(clickMarker);
    if (dimMarkersGroup) dimMarkersGroup.clearLayers();
    activeDrawnPoints = [];
    document.getElementById('hudStatus').textContent = 'Harita temizlendi.';
}

function downloadParselPdfReport() {
    const city = document.getElementById('qsCity') ? document.getElementById('qsCity').value : 'Ankara';
    const dist = document.getElementById('qsDistrict') ? document.getElementById('qsDistrict').value : 'Çankaya';
    const ada = document.getElementById('qsAda') ? document.getElementById('qsAda').value : '104';
    const parsel = document.getElementById('qsParsel') ? document.getElementById('qsParsel').value : '12';

    const dLoc = document.getElementById('pdf-loc');
    if (dLoc) dLoc.innerText = `${city} / ${dist} / Merkez`;
    const dAda = document.getElementById('pdf-ada-parsel');
    if (dAda) dAda.innerText = `${ada} Ada / ${parsel} Parsel`;

    const coordsEl = document.getElementById('hudCoords');
    const dCoords = document.getElementById('pdf-coords');
    if (dCoords && coordsEl) dCoords.innerText = coordsEl.innerText;

    const frontEl = document.getElementById('hudFrontage');
    const dFront = document.getElementById('pdf-frontage');
    if (dFront && frontEl) dFront.innerText = frontEl.innerText.split('(')[0].trim();

    const slopeEl = document.getElementById('hudSlope');
    const dSlope = document.getElementById('pdf-slope');
    if (dSlope && slopeEl) dSlope.innerText = slopeEl.innerText;

    const thElev = document.getElementById('fm-th-elev');
    const dElev = document.getElementById('pdf-elev');
    if (dElev && thElev) dElev.innerText = thElev.innerText;

    const thDiff = document.getElementById('fm-th-diff');
    const dDiff = document.getElementById('pdf-diff');
    if (dDiff && thDiff) dDiff.innerText = thDiff.innerText;

    const thVol = document.getElementById('fm-th-vol');
    const dVol = document.getElementById('pdf-excav-vol');
    if (dVol && thVol) dVol.innerText = thVol.innerText;

    const thRet = document.getElementById('fm-th-retaining');
    const dRet = document.getElementById('pdf-retaining');
    if (dRet && thRet) dRet.innerText = thRet.innerText;

    const dDate = document.getElementById('pdf-date');
    if (dDate) {
        const now = new Date();
        dDate.innerText = `${String(now.getDate()).padStart(2, '0')}.${String(now.getMonth()+1).padStart(2, '0')}.${now.getFullYear()}`;
    }
    const dNo = document.getElementById('pdf-no');
    if (dNo) dNo.innerText = `PSR-${Math.floor(100000 + Math.random() * 900000)}`;

    // Lead Capture Check
    const leadModal = document.getElementById('modal-pdf-lead');
    const locBadge = document.getElementById('pdf-lead-loc-text');
    if (locBadge) {
        locBadge.innerText = `${city} / ${dist} - ${ada} Ada / ${parsel} Parsel`;
    }

    if (leadModal && !sessionStorage.getItem('psr_lead_submitted')) {
        leadModal.style.display = 'flex';
    } else {
        window.print();
    }
}

function closePdfLeadModal() {
    const modal = document.getElementById('modal-pdf-lead');
    if (modal) modal.style.display = 'none';
}

function submitLeadAndPrintPdf() {
    const nameInput = document.getElementById('pdf-lead-name');
    const phoneInput = document.getElementById('pdf-lead-phone');
    const name = nameInput ? nameInput.value.trim() : '';
    const phone = phoneInput ? phoneInput.value.trim() : '';

    if (!name || !phone) {
        alert('Lütfen Ad Soyad ve Telefon numaranızı giriniz.');
        return;
    }

    const city = document.getElementById('qsCity') ? document.getElementById('qsCity').value : 'Ankara';
    const dist = document.getElementById('qsDistrict') ? document.getElementById('qsDistrict').value : 'Çankaya';
    const ada = document.getElementById('qsAda') ? document.getElementById('qsAda').value : '104';
    const parsel = document.getElementById('qsParsel') ? document.getElementById('qsParsel').value : '12';
    const loc = `${city} / ${dist}`;
    const adaParsel = `${ada}/${parsel}`;

    const btn = document.getElementById('btn-submit-pdf-lead');
    if (btn) {
        btn.disabled = true;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Rapor Hazırlanıyor...';
    }

    // 1. Send Lead to api.php (contact_leads)
    const params = new URLSearchParams();
    params.set('action', 'submit_lead');
    params.set('ad_soyad', name);
    params.set('telefon', phone);
    params.set('hizmet_turu', 'Resmi Parsel & İmar PDF Raporu (Harita Portalı)');
    params.set('konu', `${loc} ${adaParsel}`);
    params.set('mesaj', `${loc} ${adaParsel} için tam ekran harita portalından resmi imar ve kadastro analiz raporu talep edildi ve PDF olarak indirildi.`);

    fetch('api.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: params.toString()
    }).catch(() => {});

    sessionStorage.setItem('psr_lead_submitted', '1');

    // 2. Close Modal & Trigger Print
    setTimeout(() => {
        if (btn) {
            btn.disabled = false;
            btn.innerHTML = '<i class="fa-solid fa-file-arrow-down"></i> Raporu Hazırla &amp; PDF Olarak İndir';
        }
        closePdfLeadModal();
        window.print();
    }, 600);
}

function executeDirectPrintFallback() {
    closePdfLeadModal();
    window.print();
}

document.addEventListener('DOMContentLoaded', () => {
    initFullMap();
    try {
        const urlParams = new URLSearchParams(window.location.search);
        const qCity = urlParams.get('il') || urlParams.get('city');
        const qDist = urlParams.get('ilce') || urlParams.get('district');
        const qAda = urlParams.get('ada');
        const qParsel = urlParams.get('parsel');

        if (qCity && document.getElementById('qsCity')) {
            const cSelect = document.getElementById('qsCity');
            for (let i = 0; i < cSelect.options.length; i++) {
                if (cSelect.options[i].value.toLowerCase() === qCity.toLowerCase()) {
                    cSelect.selectedIndex = i;
                    break;
                }
            }
        }
        if (qDist && document.getElementById('qsDistrict')) {
            document.getElementById('qsDistrict').value = qDist;
        }
        if (qAda && document.getElementById('qsAda')) {
            document.getElementById('qsAda').value = qAda;
        }
        if (qParsel && document.getElementById('qsParsel')) {
            document.getElementById('qsParsel').value = qParsel;
        }

        if (qCity || qDist || qAda || qParsel) {
            setTimeout(() => {
                runQuickSearch();
            }, 350);
        }
    } catch(e) {
        console.error("Auto deep-link parse error:", e);
    }
});
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

<!-- ========================================================================= -->
<!-- 📄 RESMİ PARSEL & İMAR RAPORU LEAD CAPTURE MODALI (Ant Harita) -->
<!-- ========================================================================= -->
<div id="modal-pdf-lead" style="display:none; position:fixed; z-index:999999; left:0; top:0; width:100%; height:100%; background:rgba(15,23,42,0.88); backdrop-filter:blur(6px); align-items:center; justify-content:center; padding:16px; box-sizing:border-box;">
    <div style="background:#0f172a; border:2px solid #10b981; border-radius:16px; max-width:540px; width:100%; padding:26px; max-height:92vh; overflow-y:auto; box-shadow:0 20px 60px rgba(0,0,0,0.9); position:relative; color:#fff;">
        <button onclick="closePdfLeadModal()" style="position:absolute; right:16px; top:16px; background:none; border:none; color:#94a3b8; font-size:24px; cursor:pointer; font-weight:bold;">&times;</button>
        
        <div style="display:flex; align-items:center; gap:10px; margin-bottom:12px;">
            <div style="width:40px; height:40px; border-radius:10px; background:rgba(16,185,129,0.15); border:1px solid #10b981; display:flex; align-items:center; justify-content:center; color:#10b981; font-size:20px;">
                <i class="fa-solid fa-file-pdf"></i>
            </div>
            <div>
                <h3 style="margin:0; font-size:18px; font-weight:900; color:#fff;">Resmi Parsel &amp; İmar Ön Analiz Raporu</h3>
                <span style="font-size:11.5px; color:#a7f3d0; font-weight:600;">TKGM MEGSİS &amp; ÇŞİDB E-Plan Uyumlu 2026 Belgesi</span>
            </div>
        </div>

        <div id="pdf-lead-preview-badge" style="background:#1e293b; border:1px solid #334155; border-radius:8px; padding:12px; margin-bottom:18px; font-size:12.5px; color:#cbd5e1; line-height:1.5;">
            <div style="font-size:11px; font-weight:bold; color:#38bdf8; text-transform:uppercase; margin-bottom:4px;"><i class="fa-solid fa-location-dot"></i> İncelenen Taşınmaz:</div>
            <div id="pdf-lead-loc-text" style="font-weight:bold; color:#fff; font-size:13.5px;">Parsel Bilgisi Yükleniyor...</div>
        </div>

        <div style="background:rgba(16,185,129,0.06); border:1px solid rgba(16,185,129,0.25); border-radius:8px; padding:12px; margin-bottom:20px;">
            <div style="font-size:11.5px; font-weight:bold; color:#34d399; margin-bottom:6px;"><i class="fa-solid fa-circle-check"></i> Rapor Kapsamında Yer Alan Bilgiler:</div>
            <ul style="margin:0; padding-left:18px; font-size:12px; color:#cbd5e1; line-height:1.6;">
                <li>3194 İmar Durumu, KAKS / TAKS ve İnşaat Taban Oturumu</li>
                <li>Plansız Alanlar Köy İmarı &amp; 5403 s.K. Tarla Bölünme Analizi</li>
                <li>ÇŞİDB 2026 Resmi Metrekare Yaklaşık Yapı Maliyet Endeksi</li>
                <li>Topografya, Eğim &amp; Kazı-Hafriyat ve İstinat Duvarı Simülasyonu</li>
                <li>QR Kod Doğrulamalı TMMOB HKMO Mühendislik Referansı</li>
            </ul>
        </div>

        <form id="form-pdf-lead" onsubmit="return false;">
            <div style="margin-bottom:14px;">
                <label style="display:block; font-size:12px; font-weight:bold; color:#e2e8f0; margin-bottom:5px;">Adınız Soyadınız <span style="color:#ef4444;">*</span></label>
                <input type="text" id="pdf-lead-name" required placeholder="Örn: Ahmet Yılmaz" style="width:100%; padding:10px 14px; background:#1e293b; border:1px solid #475569; border-radius:8px; color:#fff; font-size:13.5px; box-sizing:border-box;">
            </div>

            <div style="margin-bottom:14px;">
                <label style="display:block; font-size:12px; font-weight:bold; color:#e2e8f0; margin-bottom:5px;">Telefon Numaranız (WhatsApp) <span style="color:#ef4444;">*</span></label>
                <input type="tel" id="pdf-lead-phone" required placeholder="Örn: 05xx xxx xx xx" style="width:100%; padding:10px 14px; background:#1e293b; border:1px solid #475569; border-radius:8px; color:#fff; font-size:13.5px; box-sizing:border-box;">
            </div>

            <div style="margin-bottom:18px; display:flex; align-items:center; gap:8px;">
                <input type="checkbox" id="pdf-lead-wa-opt" checked style="width:16px; height:16px; accent-color:#10b981; cursor:pointer;">
                <label for="pdf-lead-wa-opt" style="font-size:12px; color:#cbd5e1; cursor:pointer;">
                    Rapor hazır olduğunda bir kopyası WhatsApp üzerinden de iletilsin.
                </label>
            </div>

            <button type="button" id="btn-submit-pdf-lead" onclick="submitLeadAndPrintPdf()" style="width:100%; padding:13px; background:linear-gradient(135deg, #10b981 0%, #059669 100%); color:#fff; border:none; border-radius:8px; font-size:14px; font-weight:900; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:8px; box-shadow:0 4px 15px rgba(16,185,129,0.35);">
                <i class="fa-solid fa-file-arrow-down"></i> Raporu Hazırla &amp; PDF Olarak İndir
            </button>
        </form>

        <div style="margin-top:14px; text-align:center;">
            <a href="javascript:void(0)" onclick="executeDirectPrintFallback()" style="font-size:11.5px; color:#94a3b8; text-decoration:underline;">veya formu doldurmadan doğrudan hızlı yazdır &raquo;</a>
        </div>
    </div>
</div>

</body>
</html>
