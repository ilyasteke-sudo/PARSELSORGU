<?php
/**
 * ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ - PARSEL PRO
 * SaaS 2: ALTYAPI & ÇAKIŞMA RİSK RADARI (Yüksek Gerilim, Dere Taşkın, Otoyol, Demiryolu Analizi)
 * URL: https://www.parselsorgu.net/altyapi-risk-radari
 * Pure PHP 8.3 + TKGM MEGSİS + Canlı OpenStreetMap Overpass CBS Vektör Tarama
 */
declare(strict_types=1);

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/navbar.php';

$page_title = "Parsel Altyapı Risk Radarı (TEİAŞ, Dere, Yol) | ParselSorgu";
$meta_desc = "Arsa veya tarlanızın yakınından yüksek gerilim hattı (TEİAŞ), dere taşkın yatağı (DSİ) veya otoyol geçip geçmediğini canlı haritada tarayın.";
$canonical_url = "https://www.parselsorgu.net/altyapi-risk-radari";
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title><?= htmlspecialchars($page_title) ?></title>
    <meta name="description" content="<?= htmlspecialchars($meta_desc) ?>">
    <link rel="canonical" href="<?= $canonical_url ?>    <meta property="og:image" content="https://www.parselsorgu.net/assets/images/og-parsel.jpg">
">
    <meta property="og:title" content="<?= htmlspecialchars($page_title) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($meta_desc) ?>">
    <meta property="og:url" content="<?= $canonical_url ?>">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="ParselSorgu.net - Ant Harita Mühendislik">
    <meta name="theme-color" content="#090e17">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.js"></script>

    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "WebApplication",
      "name": "Parsel Altyapı & Çakışma Risk Radarı",
      "url": "https://www.parselsorgu.net/altyapi-risk-radari",
      "description": "TKGM ada/parsel veya harita konumu çevresindeki yüksek gerilim hatları, dere yatakları, otoyollar ve demiryollarını anlık tarayan CBS analiz aracı.",
      "applicationCategory": "GISApplication",
      "operatingSystem": "All",
      "offers": { "@type": "Offer", "price": "0", "priceCurrency": "TRY" },
      "creator": { "@type": "Organization", "name": "Ant Harita Mühendislik", "identifier": "TMMOB HKMO Sicil: 12480" }
    }
    </script>

    <style>
        :root {
            --bg-dark: #060a12;
            --card-bg: #0f172a;
            --surface: #131d31;
            --border: rgba(244, 63, 94, 0.25);
            --cyan: #38bdf8;
            --emerald: #10b981;
            --amber: #f59e0b;
            --rose: #f43f5e;
            --text: #f8fafc;
            --muted: #94a3b8;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            background: var(--bg-dark);
            color: var(--text);
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            line-height: 1.5;
        }
        .risk-container { max-width: 1440px; margin: 0 auto; padding: 20px 16px 70px 16px; }
        .risk-hero {
            background: linear-gradient(135deg, rgba(244, 63, 94, 0.14) 0%, rgba(15, 23, 42, 0.96) 100%);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 22px 26px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 14px;
        }
        .risk-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(244, 63, 94, 0.15);
            border: 1px solid rgba(244, 63, 94, 0.4);
            color: #fb7185;
            padding: 4px 12px;
            border-radius: 9999px;
            font-size: 11.5px;
            font-weight: 800;
            margin-bottom: 8px;
        }
        .risk-hero h1 { margin: 0 0 6px 0; font-size: 1.6rem; font-weight: 900; color: #fff; }
        .risk-hero p { margin: 0; color: var(--muted); font-size: 0.92rem; max-width: 800px; }
        .risk-grid { display: grid; grid-template-columns: 400px 1fr; gap: 18px; align-items: start; }
        @media (max-width: 1024px) { .risk-grid { grid-template-columns: 1fr; } }
        .panel { background: var(--card-bg); border: 1px solid #1e293b; border-radius: 14px; padding: 18px; }
        .panel-head { font-size: 14px; font-weight: 800; color: #fff; padding-bottom: 10px; margin-bottom: 14px; border-bottom: 1px solid #1e293b; display: flex; justify-content: space-between; align-items: center; }
        .field { margin-bottom: 11px; }
        .field label { display: block; font-size: 11px; font-weight: 700; color: var(--muted); text-transform: uppercase; margin-bottom: 4px; }
        .r-input, .r-select {
            width: 100%; background: var(--surface); border: 1px solid #263449;
            color: #fff; border-radius: 8px; padding: 9px 11px; font-size: 13px;
        }
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
        .btn-scan {
            width: 100%; background: linear-gradient(135deg, #e11d48, #f43f5e);
            color: #fff; border: none; border-radius: 9px; padding: 12px;
            font-size: 13.5px; font-weight: 900; cursor: pointer;
            display: flex; align-items: center; justify-content: center; gap: 8px;
            margin-top: 8px; box-shadow: 0 4px 16px rgba(244, 63, 94, 0.35);
        }
        .btn-scan:hover { filter: brightness(1.08); }
        .btn-gps {
            width: 100%; background: rgba(56, 189, 248, 0.12); color: var(--cyan);
            border: 1px solid rgba(56, 189, 248, 0.35); border-radius: 9px; padding: 10px;
            font-size: 12.5px; font-weight: 800; cursor: pointer; margin-top: 8px;
        }
        #riskMap { width: 100%; height: 430px; border-radius: 12px; border: 1px solid #1e293b; background: #080d1a; }
        .score-card {
            margin-top: 14px; background: var(--surface); border: 1px solid #1e293b;
            border-radius: 12px; padding: 16px; display: flex; justify-content: space-between; align-items: center; gap: 16px; flex-wrap: wrap;
        }
        .score-ring {
            width: 72px; height: 72px; border-radius: 50%; display: flex; flex-direction: column;
            align-items: center; justify-content: center; font-weight: 900; border: 4px solid var(--emerald);
        }
        .risk-cards { display: grid; grid-template-columns: repeat(auto-fit, minmax(210px, 1fr)); gap: 10px; margin-top: 14px; }
        .r-card {
            background: var(--surface); border: 1px solid #1e293b; border-radius: 10px; padding: 12px;
        }
        .r-card-top { display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px; font-size: 12.5px; font-weight: 800; }
        .badge-ok { background: rgba(16,185,129,0.15); color: #34d399; padding: 2px 7px; border-radius: 9999px; font-size: 10.5px; }
        .badge-warn { background: rgba(245,158,11,0.15); color: #fbbf24; padding: 2px 7px; border-radius: 9999px; font-size: 10.5px; }
        .badge-danger { background: rgba(244,63,94,0.18); color: #fb7185; padding: 2px 7px; border-radius: 9999px; font-size: 10.5px; }
    </style>
    <script type="application/ld+json">{"@context": "https://schema.org", "@type": "FAQPage", "mainEntity": [{"@type": "Question", "name": "Arsa yakınından yüksek gerilim hattı (TEİAŞ) geçmesi yapılaşmayı engeller mi?", "acceptedAnswer": {"@type": "Answer", "text": "Evet, TEİAŞ enerji nakil hatlarının altındaki pilon ve irtifak koridorunda kalan bölümlere yapı yasağı veya yükseklik kısıtı (ekstrem irtifak) konur; parselsorgu.net Altyapı Risk Radarı mesafe taramasını anında yapar."}}, {"@type": "Question", "name": "DSİ dere taşkın sahası ve karayolu kamulaştırma kuşağı tapuda görünür mü?", "acceptedAnswer": {"@type": "Answer", "text": "Bazı şerhler beyanlar hanesinde yer alsa da dere koruma bandı veya otoyol yaklaşma sınırı canlı CBS vektör taraması ile satın alma öncesi mutlaka kontrol edilmelidir."}}]}</script>
    <link rel="alternate" type="text/markdown" href="https://www.parselsorgu.net/llms.txt" title="ParselSorgu AI / LLM Bilgi Bankası">
    <link rel="alternate" type="application/json" href="https://www.parselsorgu.net/api/2026-kadastro-endeks.json" title="2026 Kadastro ve İmar Açık Veri Seti">
    <script type="application/ld+json">{"@context": "https://schema.org", "@type": "WebPage", "speakable": {"@type": "SpeakableSpecification", "cssSelector": ["h1", ".lead", ".summary-box", ".hero-desc", "main p"]}, "isBasedOn": "https://www.parselsorgu.net/api/2026-kadastro-endeks.json", "publisher": {"@type": "Organization", "name": "Ant Harita Mühendislik - ParselSorgu.net", "url": "https://www.parselsorgu.net/"}}</script>
</head>
<body>
<?= render_navbar('eklentiler') ?>

<main class="risk-container">
    <section class="risk-hero">
        <div>
            <span class="risk-badge"><i class="fa-solid fa-radar"></i> CANLI CBS ÇAKIŞMA ANALİZİ &bull; 1000m TARAMA ÇAPI</span>
            <h1>Altyapı &amp; Çakışma Risk Radarı (Yüksek Gerilim, Dere Taşkın, Otoyol)</h1>
            <p>Satın alacağınız veya proje geliştireceğiniz parselin çevresindeki TEİAŞ enerji nakil hatlarını, DSİ dere yataklarını, otoyol kamulaştırma kuşaklarını ve demiryolu hatlarını canlı vektör verisiyle tarayın.</p>
        </div>
        <a href="https://wa.me/905428413535?text=Altyapı%20risk%20radarı%20üzerinden%20parsel%20incelemesi%20istiyorum" target="_blank" style="background:#10b981; color:#022c22; padding:10px 16px; border-radius:9px; font-weight:900; font-size:12.5px; text-decoration:none; display:inline-flex; align-items:center; gap:7px;">
            <i class="fa-brands fa-whatsapp"></i> Mühendis Raporu Talep Et
        </a>
    </section>

    <div class="risk-grid">
        <div class="panel">
            <div class="panel-head">
                <span><i class="fa-solid fa-crosshairs" style="color:var(--rose);"></i> Konum veya Parsel Seçin</span>
                <span style="font-size:11px; color:var(--muted);">Haritaya da tıklayabilirsiniz</span>
            </div>

            <div class="field">
                <label>İl Seçiniz</label>
                <select id="rIl" class="r-select" onchange="loadRiskDistricts()"><option value="">Yükleniyor...</option></select>
            </div>
            <div class="field">
                <label>İlçe Seçiniz</label>
                <select id="rIlce" class="r-select" onchange="loadRiskMahalles()"><option value="">Önce İl Seçin</option></select>
            </div>
            <div class="field">
                <label>Mahalle / Köy</label>
                <select id="rMahalle" class="r-select"><option value="">Önce İlçe Seçin</option></select>
            </div>
            <div class="grid-2">
                <div class="field">
                    <label>Ada No</label>
                    <input type="text" id="rAda" class="r-input" value="3425" placeholder="Ada">
                </div>
                <div class="field">
                    <label>Parsel No</label>
                    <input type="text" id="rParsel" class="r-input" value="9" placeholder="Parsel">
                </div>
            </div>
            <div class="field">
                <label>Tarama Yarıçapı</label>
                <select id="rRadius" class="r-select">
                    <option value="300">300 Metre (Yakın Çevre İrtifakı)</option>
                    <option value="600" selected>600 Metre (Standart Radar)</option>
                    <option value="1200">1200 Metre (Geniş Bölge Taraması)</option>
                </select>
            </div>

            <button type="button" class="btn-scan" onclick="scanParcelFromTkgm()">
                <i class="fa-solid fa-satellite-dish"></i> Parseli Bul &amp; Risk Taraması Başlat
            </button>
            <button type="button" class="btn-gps" onclick="scanCurrentGPS()">
                <i class="fa-solid fa-location-crosshairs"></i> Arazideyim: GPS Konumumu Tara
            </button>

            <div id="scanStatusMsg" style="margin-top:12px; font-size:12px; color:var(--cyan); background:rgba(56,189,248,0.08); border:1px solid rgba(56,189,248,0.2); padding:9px 11px; border-radius:8px;">
                <i class="fa-solid fa-circle-info"></i> Harita üzerinde herhangi bir yere tıklayarak veya ada/parsel seçerek taramayı başlatabilirsiniz.
            </div>
        </div>

        <div class="panel">
            <div class="panel-head">
                <span><i class="fa-solid fa-layer-group" style="color:var(--cyan);"></i> Uydu Radar Haritası &amp; Çakışma Vektörleri</span>
                <span id="radarCoordsText" style="font-size:11px; color:var(--muted);">39.9200, 32.8500</span>
            </div>

            <div id="riskMap"></div>

            <div class="score-card" id="scoreSummaryBox">
                <div style="display:flex; align-items:center; gap:14px;">
                    <div class="score-ring" id="safetyScoreRing">
                        <span id="safetyScoreVal" style="font-size:20px; color:#fff;">--</span>
                        <span style="font-size:9px; color:var(--muted);">PUAN</span>
                    </div>
                    <div>
                        <div style="font-size:15px; font-weight:900; color:#fff;" id="safetyHeadline">Tarama Bekleniyor</div>
                        <div style="font-size:12px; color:var(--muted); max-width:520px;" id="safetySubtext">Parsel seçin veya haritada incelemek istediğiniz arsaya tıklayın.</div>
                    </div>
                </div>
                <button type="button" onclick="window.print()" style="background:rgba(255,255,255,0.08); color:#fff; border:1px solid #334155; padding:8px 14px; border-radius:8px; font-size:12px; font-weight:700; cursor:pointer;">
                    <i class="fa-solid fa-print"></i> Risk Raporunu Yazdır
                </button>
            </div>

            <div class="risk-cards" id="riskCardsGrid">
                <div class="r-card">
                    <div class="r-card-top"><span>⚡ Yüksek Gerilim (TEİAŞ)</span><span class="badge-ok" id="bPower">Hazır</span></div>
                    <div style="font-size:12px; color:var(--muted);" id="dPower">Enerji nakil hatları ve pilon mesafesi taranır.</div>
                </div>
                <div class="r-card">
                    <div class="r-card-top"><span>🌊 Dere &amp; Taşkın (DSİ)</span><span class="badge-ok" id="bWater">Hazır</span></div>
                    <div style="font-size:12px; color:var(--muted);" id="dWater">Akarsu, dere ve sulama kanalı koruma bandı taranır.</div>
                </div>
                <div class="r-card">
                    <div class="r-card-top"><span>🛣️ Otoyol &amp; Devlet Yolu</span><span class="badge-ok" id="bRoad">Hazır</span></div>
                    <div style="font-size:12px; color:var(--muted);" id="dRoad">2918 s.K. karayolu çekme ve kamulaştırma mesafesi.</div>
                </div>
                <div class="r-card">
                    <div class="r-card-top"><span>🚆 Demiryolu &amp; Sanayi</span><span class="badge-ok" id="bRail">Hazır</span></div>
                    <div style="font-size:12px; color:var(--muted);" id="dRail">TCDD demiryolu ve OSB/sanayi alanı yakınlığı.</div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
let adminData = null;
let riskMap = L.map('riskMap').setView([39.9207, 32.8541], 6);
L.tileLayer('https://mt1.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', { maxZoom: 21, attribution: 'Google Hybrid Satellite' }).addTo(riskMap);
let riskOverlayGroup = L.layerGroup().addTo(riskMap);
let currentPolygonCoords = [];

// Load 81 Cities JSON
fetch('/data/turkey_administrative_complete.json')
    .then(r => r.json())
    .then(data => {
        adminData = data;
        const ilSel = document.getElementById('rIl');
        ilSel.innerHTML = '<option value="">-- İl Seçiniz --</option>';
        Object.keys(data).sort((a,b) => a.localeCompare(b, 'tr')).forEach(city => {
            const opt = new Option(city, city, city === 'Ankara', city === 'Ankara');
            ilSel.add(opt);
        });
        loadRiskDistricts();
    }).catch(() => {});

function loadRiskDistricts() {
    const city = document.getElementById('rIl').value;
    const ilceSel = document.getElementById('rIlce');
    ilceSel.innerHTML = '<option value="">-- İlçe Seçiniz --</option>';
    if (!adminData || !adminData[city]) return;
    Object.keys(adminData[city]).sort((a,b) => a.localeCompare(b, 'tr')).forEach(d => {
        const opt = new Option(d, d, (city === 'Ankara' && d === 'Çankaya'), (city === 'Ankara' && d === 'Çankaya'));
        ilceSel.add(opt);
    });
    loadRiskMahalles();
}

function loadRiskMahalles() {
    const city = document.getElementById('rIl').value;
    const dist = document.getElementById('rIlce').value;
    const mSel = document.getElementById('rMahalle');
    mSel.innerHTML = '<option value="">-- Mahalle Seçiniz --</option>';
    if (!adminData || !adminData[city] || !adminData[city][dist]) return;
    const list = adminData[city][dist];
    list.forEach(m => {
        const name = m.name || m.text || m;
        const id = m.id || name;
        mSel.add(new Option(name, id));
    });
}

function haversineMeters(lat1, lon1, lat2, lon2) {
    const R = 6371000;
    const dLat = (lat2 - lat1) * Math.PI / 180;
    const dLon = (lon2 - lon1) * Math.PI / 180;
    const a = Math.sin(dLat/2)**2 + Math.cos(lat1*Math.PI/180)*Math.cos(lat2*Math.PI/180)*Math.sin(dLon/2)**2;
    return R * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
}

function minDistanceToTarget(lat, lon) {
    if (currentPolygonCoords.length === 0) return null;
    let minD = Infinity;
    currentPolygonCoords.forEach(pt => {
        const d = haversineMeters(lat, lon, pt[0], pt[1]);
        if (d < minD) minD = d;
    });
    return minD;
}

async function scanParcelFromTkgm() {
    const mahalleId = document.getElementById('rMahalle').value;
    const ada = document.getElementById('rAda').value.trim();
    const parsel = document.getElementById('rParsel').value.trim();
    const st = document.getElementById('scanStatusMsg');

    if (!mahalleId || isNaN(Number(mahalleId))) {
        st.innerHTML = '<i class="fa-solid fa-triangle-exclamation"></i> Mahalle ID seçili değil; doğrudan haritadan seçtiğiniz konumu taramak için haritaya tıklayın.';
        return;
    }
    st.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> TKGM MEGSİS üzerinden parsel sınırı alınıyor...';
    try {
        const resp = await fetch(`/tkgm_service.php?action=get_parsel&mahalle_id=${encodeURIComponent(mahalleId)}&ada=${encodeURIComponent(ada)}&parsel=${encodeURIComponent(parsel)}`);
        const data = await resp.json();
        if (data.status === 'success' && data.geometry && data.geometry.coordinates) {
            const ring = data.geometry.coordinates[0].map(c => [c[1], c[0]]);
            currentPolygonCoords = ring;
            const bounds = L.latLngBounds(ring);
            const center = bounds.getCenter();
            runOverpassRiskScan(center.lat, center.lng, ring);
        } else {
            st.innerHTML = '<i class="fa-solid fa-circle-xmark"></i> Parsel bulunamadı: ' + (data.message || 'Bilgileri kontrol edin.');
        }
    } catch (e) {
        st.innerHTML = '<i class="fa-solid fa-circle-xmark"></i> TKGM bağlantısı kurulamadı. Harita üzerinden bir noktaya tıklayarak risk taraması yapabilirsiniz.';
    }
}

function scanCurrentGPS() {
    if (!navigator.geolocation) {
        alert('Tarayıcınız GPS konum desteği vermiyor.');
        return;
    }
    document.getElementById('scanStatusMsg').innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> GPS konumu alınıyor...';
    navigator.geolocation.getCurrentPosition(pos => {
        currentPolygonCoords = [[pos.coords.latitude, pos.coords.longitude]];
        runOverpassRiskScan(pos.coords.latitude, pos.coords.longitude, null);
    }, () => {
        document.getElementById('scanStatusMsg').innerHTML = 'GPS izni verilmedi. Harita üzerinde herhangi bir noktaya tıklayın.';
    });
}

riskMap.on('click', function(e) {
    currentPolygonCoords = [[e.latlng.lat, e.latlng.lng]];
    runOverpassRiskScan(e.latlng.lat, e.latlng.lng, null);
});

async function runOverpassRiskScan(lat, lng, polygonRing) {
    const radius = parseInt(document.getElementById('rRadius').value || '600', 10);
    const st = document.getElementById('scanStatusMsg');
    document.getElementById('radarCoordsText').textContent = `${lat.toFixed(5)}, ${lng.toFixed(5)}`;
    st.innerHTML = `<i class="fa-solid fa-radar fa-spin"></i> ${radius}m yarıçapta TEİAŞ, DSİ dere, otoyol ve demiryolu vektörleri taranıyor...`;

    riskOverlayGroup.clearLayers();
    L.circle([lat, lng], { radius, color: '#f43f5e', weight: 1.5, dashArray: '6,6', fillColor: '#f43f5e', fillOpacity: 0.05 }).addTo(riskOverlayGroup);
    if (polygonRing) {
        L.polygon(polygonRing, { color: '#38bdf8', weight: 3, fillColor: '#38bdf8', fillOpacity: 0.28 }).addTo(riskOverlayGroup);
        riskMap.fitBounds(L.latLngBounds(polygonRing), { maxZoom: 17, padding: [50, 50] });
    } else {
        L.circleMarker([lat, lng], { radius: 8, color: '#fff', fillColor: '#38bdf8', fillOpacity: 1, weight: 2 }).addTo(riskOverlayGroup);
        riskMap.setView([lat, lng], 16);
    }

    const q = `[out:json][timeout:18];(
      way["power"~"line|minor_line"](around:${radius},${lat},${lng});
      node["power"="tower"](around:${radius},${lat},${lng});
      way["waterway"~"river|stream|canal"](around:${radius},${lat},${lng});
      way["highway"~"motorway|trunk|primary"](around:${radius},${lat},${lng});
      way["railway"="rail"](around:${radius},${lat},${lng});
      way["landuse"="industrial"](around:${radius},${lat},${lng});
    );out geom;`;

    try {
        const res = await fetch('https://overpass-api.de/api/interpreter', {
            method: 'POST',
            body: 'data=' + encodeURIComponent(q)
        });
        const osm = await res.json();
        evaluateHazards(osm.elements || [], lat, lng, radius);
    } catch (err) {
        st.innerHTML = '<i class="fa-solid fa-triangle-exclamation"></i> Canlı harita vektör sunucusu geçici olarak meşgul, lütfen 5 saniye sonra tekrar deneyin.';
    }
}

function evaluateHazards(elements, lat, lng, radius) {
    let minPower = Infinity, minWater = Infinity, minRoad = Infinity, minRail = Infinity, hasIndustrial = false;
    let powerCount = 0, waterCount = 0, roadCount = 0, railCount = 0;

    elements.forEach(el => {
        const tags = el.tags || {};
        const pts = el.geometry ? el.geometry.map(g => [g.lat, g.lon]) : (el.lat ? [[el.lat, el.lon]] : []);
        if (pts.length === 0) return;

        let closest = Infinity;
        pts.forEach(p => {
            const d = minDistanceToTarget(p[0], p[1]) ?? haversineMeters(lat, lng, p[0], p[1]);
            if (d < closest) closest = d;
        });

        if (tags.power) {
            powerCount++;
            if (closest < minPower) minPower = closest;
            if (pts.length > 1) L.polyline(pts, { color: '#facc15', weight: 3.5 }).bindPopup('⚡ Enerji Nakil Hattı').addTo(riskOverlayGroup);
        } else if (tags.waterway) {
            waterCount++;
            if (closest < minWater) minWater = closest;
            if (pts.length > 1) L.polyline(pts, { color: '#38bdf8', weight: 3.5 }).bindPopup('🌊 Dere / Akarsu: ' + (tags.name || tags.waterway)).addTo(riskOverlayGroup);
        } else if (tags.highway) {
            roadCount++;
            if (closest < minRoad) minRoad = closest;
            if (pts.length > 1) L.polyline(pts, { color: '#f97316', weight: 3.5 }).bindPopup('🛣️ Karayolu / Otoyol: ' + (tags.name || tags.highway)).addTo(riskOverlayGroup);
        } else if (tags.railway) {
            railCount++;
            if (closest < minRail) minRail = closest;
            if (pts.length > 1) L.polyline(pts, { color: '#c084fc', weight: 3.5 }).bindPopup('🚆 Demiryolu Hattı').addTo(riskOverlayGroup);
        } else if (tags.landuse === 'industrial') {
            hasIndustrial = true;
            if (pts.length > 2) L.polygon(pts, { color: '#94a3b8', weight: 1.5, fillOpacity: 0.15 }).bindPopup('🏭 Sanayi / Tesis Alanı').addTo(riskOverlayGroup);
        }
    });

    let score = 100;
    const setCard = (bId, dId, minD, count, dangerLim, warnLim, okText, warnText, dangerText) => {
        const b = document.getElementById(bId), d = document.getElementById(dId);
        if (count === 0 || minD === Infinity) {
            b.className = 'badge-ok'; b.textContent = 'Temiz';
            d.textContent = `${radius}m yarıçapta ${okText}`;
            return;
        }
        const mStr = Math.round(minD) + ' metre';
        if (minD <= dangerLim) {
            score -= 28;
            b.className = 'badge-danger'; b.textContent = 'Yüksek Risk (' + mStr + ')';
            d.textContent = dangerText.replace('{m}', mStr);
        } else if (minD <= warnLim) {
            score -= 12;
            b.className = 'badge-warn'; b.textContent = 'Dikkat (' + mStr + ')';
            d.textContent = warnText.replace('{m}', mStr);
        } else {
            b.className = 'badge-ok'; b.textContent = 'Güvenli (' + mStr + ')';
            d.textContent = `En yakın hat ${mStr} mesafede (emniyet sınırı dışında).`;
        }
    };

    setCard('bPower', 'dPower', minPower, powerCount, 45, 120,
        'enerji nakil hattı tespit edilmedi.',
        'Yaklaşık {m} mesafede enerji hattı var; TEİAŞ gabari onayı önerilir.',
        'Kritik yakınlık ({m}): Yüksek gerilim irtifak hakkı ve yapı yasağı riski!');

    setCard('bWater', 'dWater', minWater, waterCount, 50, 150,
        'dere yatağı veya taşkın kanalı tespit edilmedi.',
        'Yaklaşık {m} mesafede dere/su kanalı var; DSİ taşkın görüşü kontrol edilmeli.',
        'Dere koruma bandı riski ({m}): DSİ taşkın sahası kısıtlaması olabilir!');

    setCard('bRoad', 'dRoad', minRoad, roadCount, 35, 90,
        'otoyol veya ana devlet yolu saptanmadı.',
        'Ana yola {m} mesafede; ticari/lojistik avantajlı fakat 25m çekme kontrolü önerilir.',
        'Ana yol kamulaştırma kuşağı yakınlığı ({m}): Karayolları 25-50m yapı yaklaşma bandı!');

    const rB = document.getElementById('bRail'), rD = document.getElementById('dRail');
    if (railCount > 0 && minRail < 100) {
        score -= 15; rB.className = 'badge-warn'; rB.textContent = 'Demiryolu (' + Math.round(minRail) + 'm)';
        rD.textContent = `TCDD hattına ${Math.round(minRail)}m mesafede; kamulaştırma/gürültü kuşağı kontrol edilmeli.`;
    } else if (hasIndustrial) {
        score -= 5; rB.className = 'badge-warn'; rB.textContent = 'Sanayi Yakını';
        rD.textContent = `${radius}m çevrede sanayi kullanım alanı mevcut.`;
    } else {
        rB.className = 'badge-ok'; rB.textContent = 'Temiz';
        rD.textContent = `${radius}m çevrede demiryolu veya ağır sanayi çakışması bulunmadı.`;
    }

    score = Math.max(10, score);
    const ring = document.getElementById('safetyScoreRing');
    document.getElementById('safetyScoreVal').textContent = score;
    ring.style.borderColor = score >= 80 ? '#10b981' : (score >= 55 ? '#f59e0b' : '#f43f5e');
    document.getElementById('safetyHeadline').textContent = score >= 80 ? 'Altyapı & Çakışma Riski Düşük (Güvenli Bölge)' : (score >= 55 ? 'Orta Düzey Yakınlık Tespiti (Kontrol Önerilir)' : 'Yüksek Altyapı / İrtifak Riski Tespit Edildi!');
    document.getElementById('safetySubtext').textContent = `Toplam ${elements.length} adet canlı harita nesnesi tarandı. Kesin kamulaştırma ve imar şerhi için LİHKAB / Belediye incelemesi tavsiye edilir.`;
    document.getElementById('scanStatusMsg').innerHTML = `<i class="fa-solid fa-check-circle" style="color:#10b981;"></i> Tarama tamamlandı (${elements.length} altyapı vektörü analiz edildi).`;
}

// Initial scan of Ankara central sample
runOverpassRiskScan(39.9207, 32.8541, null);
</script>
</body>
</html>
