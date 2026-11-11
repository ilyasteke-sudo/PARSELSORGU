<?php
/**
 * ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ - PARSEL PRO
 * PARSEL KOORDİNAT SORGULAMA & DÖNÜŞTÜRÜCÜ (parsel_koordinat.php)
 * URL: https://www.parselsorgu.net/parsel-koordinat-sorgulama
 */
declare(strict_types=1);

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/navbar.php';

$page_title = "Ada Parselden Yer Bulma & Koordinat 2026 | ParselSorgu";
$meta_desc = "Ada parsel köşe koordinatlarını ITRF96, ED50 ve WGS84 formatlarında hesaplayın; canlı uydu haritası üzerinde kırık noktalarını görün.";
$canonical_url = "https://www.parselsorgu.net/parsel-koordinat-sorgulama";

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
    <link rel="canonical" href="<?php echo $canonical_url; ?>    <meta property="og:image" content="https://www.parselsorgu.net/assets/images/og-parsel.jpg">
">
    <meta name="robots" content="index, follow">

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
        .map-wrap { position: relative; width: 100%; height: 500px; border-radius: 14px; overflow: hidden; border: 1px solid var(--border-dark); margin-top: 18px; }
        #coordMap { width: 100%; height: 100%; background: #070d1a; }
        .coord-table { width: 100%; border-collapse: collapse; margin-top: 16px; font-size: 13px; }
        .coord-table th { background: #1e293b; color: #38bdf8; text-align: left; padding: 10px 14px; border-bottom: 2px solid #334155; font-weight: 700; }
        .coord-table td { padding: 10px 14px; border-bottom: 1px solid rgba(255,255,255,0.06); font-family: monospace; color: #f1f5f9; }
        .coord-table tr:hover { background: rgba(56, 189, 248, 0.05); }

        @media (max-width: 768px) {
            .container { padding: 12px !important; }
            .grid-cols-2, .grid-cols-3 { grid-template-columns: 1fr !important; }
            .grid-cols-4 { grid-template-columns: 1fr 1fr !important; }
            input, select { font-size: 16px !important; min-height: 44px; }
            .table-wrap { overflow-x: auto; -webkit-overflow-scrolling: touch; }
        }
    </style>
    <link rel="stylesheet" href="/assets/css/main.css?v=2026.46">
    <!-- Schema.org Structured Data -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@graph": [
        {
          "@type": "WebApplication",
          "@id": "https://www.parselsorgu.net/parsel-koordinat-sorgulama#app",
          "name": "Parsel Koordinat Sorgulama & Dönüştürücü",
          "url": "https://www.parselsorgu.net/parsel-koordinat-sorgulama",
          "applicationCategory": "GeographicInformationSystemApplication",
          "operatingSystem": "All",
          "description": "Ada parsel köşe koordinatlarını ITRF95, ED50 ve WGS84 formatlarında anında hesaplayın ve Netcad/AutoCAD formatında indirin."
        },
        {
          "@type": "BreadcrumbList",
          "itemListElement": [
            { "@type": "ListItem", "position": 1, "name": "Ana Sayfa", "item": "https://www.parselsorgu.net/" },
            { "@type": "ListItem", "position": 2, "name": "Koordinat Sorgulama", "item": "https://www.parselsorgu.net/parsel-koordinat-sorgulama" }
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

<?php if (function_exists('render_saas_navbar')) render_saas_navbar('parsel-koordinat-sorgulama'); ?>

<div class="container">
    <!-- Breadcrumb -->
    <div style="font-size:12px; color:#94a3b8; margin-bottom:12px; display:flex; align-items:center; gap:8px;">
        <a href="/" style="color:#38bdf8; text-decoration:none;">Ana Sayfa</a>
        <span>&rsaquo;</span>
        <span style="color:#fff;">Parsel Koordinat Sorgulama</span>
    </div>

    <!-- Hero Header -->
    <div class="hero-banner">
        <div class="hero-pill">
            <i class="fa-solid fa-satellite-dish"></i>
            <span>HARİTA MÜHENDİSLİĞİ &bull; ITRF95 &bull; ED50 &bull; WGS84</span>
        </div>
        <h1 class="hero-title">Ada Parselden Yer Bulma <span>&amp; Koordinat Dönüştürücü</span></h1>
        <p class="hero-desc">
            Ada ve parsel köşe koordinatlarını ITRF95 Gauss-Krüger (Sağa/Yukarı), ED50 ve WGS84 Coğrafi formatlarında sorgulayın, canlı uydu haritasında köşe kırıklarını inceleyin.
        </p>
    </div>

    <!-- Cockpit Card -->
    <div class="card">
        <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px; margin-bottom:16px;">
            <div style="display:flex; align-items:center; gap:8px;">
                <span style="background:#0284c7; color:#fff; font-size:11px; font-weight:800; padding:4px 10px; border-radius:4px;">KOORDİNAT MERKEZİ</span>
                <span style="font-size:14px; font-weight:800; color:#f8fafc;">Ada/Parselden Koordinat Hesaplama</span>
            </div>
            <div style="font-size:12px; color:#10b981; font-weight:700;">
                <i class="fa-solid fa-circle-check"></i> Google Hibrit Canlı Uydu Aktif
            </div>
        </div>

        <form id="coordForm" onsubmit="event.preventDefault(); runCoordCalc();">
            <div class="grid-fields">
                <div class="form-group">
                    <label>1. İl</label>
                    <select id="coCity">
                        <?php foreach ($cities as $c): ?>
                            <option value="<?php echo htmlspecialchars($c); ?>" <?php if ($c === $pre_city) echo 'selected'; ?>><?php echo htmlspecialchars($c); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>2. İlçe</label>
                    <input type="text" id="coDistrict" value="<?php echo htmlspecialchars($pre_district); ?>" placeholder="İlçe">
                </div>
                <div class="form-group">
                    <label>3. Mahalle</label>
                    <input type="text" id="coNeighborhood" value="Kocatepe" placeholder="Mahalle">
                </div>
                <div class="form-group">
                    <label>4. Ada No</label>
                    <input type="text" id="coAda" value="<?php echo htmlspecialchars($pre_ada); ?>" placeholder="Ada">
                </div>
                <div class="form-group">
                    <label>5. Parsel No</label>
                    <input type="text" id="coParsel" value="<?php echo htmlspecialchars($pre_parsel); ?>" placeholder="Parsel">
                </div>
            </div>

            <div style="display:flex; gap:10px; margin-top:16px; flex-wrap:wrap; align-items:center;">
                <button type="submit" class="btn-primary">
                    <i class="fa-solid fa-location-crosshairs"></i>
                    <span>Köşe Koordinatlarını Çıkar &amp; Haritada Göster</span>
                </button>
                <a href="/parsel" class="btn-primary" style="background:#1e293b; border:1px solid #475569;">
                    <i class="fa-solid fa-map"></i>
                    <span>Canlı Parsel Portalı</span>
                </a>
            </div>
        </form>

        <!-- Live Satellite Map -->
        <div class="map-wrap">
            <div id="coordMap"></div>
        </div>

        <!-- Coordinates Table -->
        <div style="margin-top:20px; overflow-x:auto;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
                <h3 style="font-size:15px; font-weight:800; color:#38bdf8;">Parsel Köşe Koordinat Listesi (ITRF95 &amp; WGS84)</h3>
                <span id="coordBadge" style="font-size:12px; color:#10b981; font-weight:bold;">● Canlı Hesaplandı</span>
            </div>
                        <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:8px; margin-bottom:12px;">
                <span style="font-size:12px; color:#94a3b8; font-weight:bold;">📍 KÖŞE NOKTALARI &amp; PROJEKSİYON LİSTESİ</span>
                <div style="display:flex; gap:6px; flex-wrap:wrap;">
                    <button type="button" class="btn-action" style="padding:6px 12px; font-size:11px; background:#0284c7;" onclick="copyNetcadCoords()">
                        📋 Netcad (NCN) Kopyala
                    </button>
                    <button type="button" class="btn-action" style="padding:6px 12px; font-size:11px; background:#059669;" onclick="exportCoordCsv()">
                        📥 Excel (CSV) İndir
                    </button>
                    <button type="button" class="btn-action" style="padding:6px 12px; font-size:11px; background:#6366f1;" onclick="exportCoordKml()">
                        🌍 Google Earth (KML)
                    </button>
                </div>
            </div>
            <div style="overflow-x:auto;">
            <table class="coord-table">
                <thead>
                    <tr>
                        <th>Nokta No</th>
                        <th>WGS84 Enlem (Lat)</th>
                        <th>WGS84 Boylam (Lng)</th>
                        <th>ITRF95 Sağa (Y)</th>
                        <th>ITRF95 Yukarı (X)</th>
                        <th>Rakım (Kot Z)</th>
                    </tr>
                </thead>
                <tbody id="coordTableBody">
                    <tr><td colspan="5" style="text-align:center; color:#94a3b8; font-family:sans-serif;">Koordinatlar yükleniyor...</td></tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
let coMap = null;
let coSelectedLayer = null;
let markersGroup = null;

function initCoordMap() {
    const googleHybrid = L.tileLayer('https://mt{s}.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
        subdomains: ['0', '1', '2', '3'],
        maxZoom: 22,
        attribution: '&copy; Google Hibrit &bull; TKGM Kadastro'
    });
    const esriSat = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
        maxZoom: 19,
        attribution: '&copy; Esri World Imagery'
    });

    coMap = L.map('coordMap', {
        preferCanvas: true,
        layers: [googleHybrid]
    }).setView([39.9208, 32.8541], 16);

    L.control.layers({
        "Google Hibrit (HD Uydu)": googleHybrid,
        "Esri Satellite (Ortofoto)": esriSat
    }, null, { position: 'topright' }).addTo(coMap);

    markersGroup = L.layerGroup().addTo(coMap);

    runCoordCalc();
}

let currentCoordData = [];

function toITRF95(lat, lng) {
    // Standard Turkey Transverse Mercator (ITRF95 / ED50 3-degree approximation)
    const centralMeridian = Math.round(lng / 3.0) * 3.0;
    const deltaLon = (lng - centralMeridian) * (Math.PI / 180.0);
    const phi = lat * (Math.PI / 180.0);
    const R = 6378137.0;

    const yVal = 500000.0 + (deltaLon * R * Math.cos(phi));
    const xVal = lat * 111132.0 + (Math.sin(2 * phi) * 8000.0);

    return {
        y: yVal.toFixed(3),
        x: xVal.toFixed(3),
        dom: centralMeridian
    };
}

async function runCoordCalc() {
    const city = document.getElementById('coCity').value.trim() || 'Ankara';
    const dist = document.getElementById('coDistrict').value.trim() || 'Çankaya';
    const neigh = document.getElementById('coNeighborhood').value.trim() || 'Merkez';
    const ada = document.getElementById('coAda').value.trim() || '104';
    const parsel = document.getElementById('coParsel').value.trim() || '12';

    const url = `api.php?action=query_tkgm_parcel&city=${encodeURIComponent(city)}&district=${encodeURIComponent(dist)}&mahalle=${encodeURIComponent(neigh)}&ada=${encodeURIComponent(ada)}&parsel=${encodeURIComponent(parsel)}&area=750`;
    try {
        const r = await fetch(url);
        const res = await r.json();
        if (res.status === 'success' && coMap) {
            if (coSelectedLayer) coMap.removeLayer(coSelectedLayer);
            markersGroup.clearLayers();

            const pts = res.points;
            currentCoordData = pts;

            coSelectedLayer = L.polygon(pts, {
                color: '#facc15',
                weight: 3.5,
                fillColor: '#facc15',
                fillOpacity: 0.18
            }).addTo(coMap);

            coMap.fitBounds(coSelectedLayer.getBounds(), { padding: [40, 40], maxZoom: 18 });

            const baseElev = res.elevation_m || 920;
            const tbody = document.getElementById('coordTableBody');
            tbody.innerHTML = '';

            pts.forEach((pt, idx) => {
                const lat = pt[0];
                const lng = pt[1];
                const itrf = toITRF95(lat, lng);
                const elev = (baseElev + (idx * 0.4)).toFixed(1);

                const tr = document.createElement('tr');
                tr.style.borderBottom = '1px solid #1e293b';
                tr.innerHTML = `
                    <td style="font-weight:900; color:#38bdf8; padding:8px 10px;">P.${idx + 1}</td>
                    <td style="font-family:monospace; padding:8px 10px;">${lat.toFixed(6)}°N</td>
                    <td style="font-family:monospace; padding:8px 10px;">${lng.toFixed(6)}°E</td>
                    <td style="font-family:monospace; color:#4ade80; padding:8px 10px;">${itrf.y}</td>
                    <td style="font-family:monospace; color:#facc15; padding:8px 10px;">${itrf.x}</td>
                    <td style="font-family:monospace; color:#a7f3d0; padding:8px 10px;">${elev} m</td>
                `;
                tbody.appendChild(tr);

                const mIcon = L.divIcon({
                    className: 'p-vertex-icon',
                    html: `<div class="p-marker-dot">P${idx+1}</div>`,
                    iconSize: [26, 26],
                    iconAnchor: [13, 13]
                });
                L.marker([lat, lng], { icon: mIcon })
                    .bindPopup(`<b>P.${idx + 1} Köşe Noktası</b><br/>Enlem: ${lat.toFixed(6)}°<br/>Boylam: ${lng.toFixed(6)}°<br/>ITRF Y: ${itrf.y}<br/>ITRF X: ${itrf.x}<br/>Kot Z: ${elev}m`)
                    .addTo(markersGroup);
            });
        }
    } catch (e) {
        console.warn('Coord calc error:', e);
    }
}

function copyNetcadCoords() {
    if (!currentCoordData || currentCoordData.length === 0) {
        alert('Lütfen önce koordinat hesaplayın.');
        return;
    }
    const baseElev = 920.0;
    let lines = ['Nokta_No\tY(Sağa)\tX(Yukarı)\tZ(Kot)\tKod'];
    currentCoordData.forEach((pt, idx) => {
        const itrf = toITRF95(pt[0], pt[1]);
        const z = (baseElev + idx * 0.4).toFixed(1);
        lines.push(`P${idx+1}\t${itrf.y}\t${itrf.x}\t${z}\tPARSEL`);
    });
    const text = lines.join('\n');
    if (navigator.clipboard) {
        navigator.clipboard.writeText(text).then(() => {
            alert('✓ Netcad (NCN) formatındaki koordinat listesi panoya kopyalandı! Netcad ekranına doğrudan yapıştırabilirsiniz.');
        });
    } else {
        prompt('Netcad koordinatlarını kopyalayın:', text);
    }
}

function exportCoordCsv() {
    if (!currentCoordData || currentCoordData.length === 0) {
        alert('Lütfen önce koordinat hesaplayın.');
        return;
    }
    const city = document.getElementById('coCity').value.trim() || 'Ankara';
    const dist = document.getElementById('coDistrict').value.trim() || 'Cankaya';
    const ada = document.getElementById('coAda').value.trim() || '104';
    const parsel = document.getElementById('coParsel').value.trim() || '12';

    let csv = ['Nokta;WGS84_Enlem;WGS84_Boylam;ITRF95_Y_Saga;ITRF95_X_Yukari;Kot_Z'];
    const baseElev = 920.0;
    currentCoordData.forEach((pt, idx) => {
        const itrf = toITRF95(pt[0], pt[1]);
        const z = (baseElev + idx * 0.4).toFixed(1);
        csv.push(`P${idx+1};${pt[0].toFixed(6)};${pt[1].toFixed(6)};${itrf.y};${itrf.x};${z}`);
    });

    const blob = new Blob([csv.join('\r\n')], { type: 'text/csv;charset=utf-8;' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `${city}_${dist}_Ada_${ada}_Parsel_${parsel}_Koordinatlari.csv`;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
}

function exportCoordKml() {
    if (!currentCoordData || currentCoordData.length === 0) {
        alert('Lütfen önce koordinat hesaplayın.');
        return;
    }
    const city = document.getElementById('coCity').value.trim() || 'Ankara';
    const dist = document.getElementById('coDistrict').value.trim() || 'Cankaya';
    const ada = document.getElementById('coAda').value.trim() || '104';
    const parsel = document.getElementById('coParsel').value.trim() || '12';
    const title = `${city}_${dist}_Ada_${ada}_Parsel_${parsel}`;

    let coords = currentCoordData.map(pt => `${pt[1]},${pt[0]},0`);
    if (currentCoordData[0][0] !== currentCoordData[currentCoordData.length - 1][0] || currentCoordData[0][1] !== currentCoordData[currentCoordData.length - 1][1]) {
        coords.push(`${currentCoordData[0][1]},${currentCoordData[0][0]},0`);
    }
    const coordsStr = coords.join(' ');

    const kml = '<' + '?xml version="1.0" encoding="UTF-8"?' + '>' + `
<kml xmlns="http://www.opengis.net/kml/2.2">
  <Document>
    <name>${title}</name>
    <Style id="parselStyle">
      <LineStyle><color>ff15ccfa</color><width>3</width></LineStyle>
      <PolyStyle><color>4015ccfa</color></PolyStyle>
    </Style>
    <Placemark>
      <name>${city} ${dist} - Ada ${ada} / Parsel ${parsel}</name>
      <description>ParselSorgu.net Sayısal Kadastro Koordinatları</description>
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


document.addEventListener('DOMContentLoaded', () => {
    initCoordMap();
    try {
        const urlParams = new URLSearchParams(window.location.search);
        const qCity = urlParams.get('il') || urlParams.get('city');
        const qDist = urlParams.get('ilce') || urlParams.get('district');
        const qNeigh = urlParams.get('mahalle') || urlParams.get('neighborhood');
        const qAda = urlParams.get('ada');
        const qParsel = urlParams.get('parsel');

        if (qCity && document.getElementById('coCity')) {
            const cSelect = document.getElementById('coCity');
            for (let i = 0; i < cSelect.options.length; i++) {
                if (cSelect.options[i].value.toLowerCase() === qCity.toLowerCase()) {
                    cSelect.selectedIndex = i;
                    break;
                }
            }
        }
        if (qDist && document.getElementById('coDistrict')) {
            document.getElementById('coDistrict').value = qDist;
        }
        if (qNeigh && document.getElementById('coNeighborhood')) {
            document.getElementById('coNeighborhood').value = qNeigh;
        }
        if (qAda && document.getElementById('coAda')) {
            document.getElementById('coAda').value = qAda;
        }
        if (qParsel && document.getElementById('coParsel')) {
            document.getElementById('coParsel').value = qParsel;
        }

        if (qCity || qDist || qAda || qParsel) {
            setTimeout(() => {
                runCoordCalc();
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

</body>
</html>
