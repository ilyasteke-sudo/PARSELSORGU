<?php
/**
 * ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ - PARSEL PRO
 * SaaS 1: ONLİNE NETCAD (.NCN) / AUTOCAD (.DXF) / GOOGLE EARTH (.KML) / GEOJSON DÖNÜŞTÜRÜCÜ & CBS GÖRÜNTÜLEYİCİ
 * URL: https://www.parselsorgu.net/ncn-dxf-kml-donusturucu
 * Pure PHP 8.3 + Vanilla JS Gauss-Krüger (ITRF96 / ED50 / WGS84) + Leaflet Satellite Viewer
 */
declare(strict_types=1);

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/navbar.php';

$page_title = "Online NCN, DXF, KML ve ITRF96 Çevirici | ParselSorgu";
$meta_desc = "Netcad (.NCN), AutoCAD (.DXF) ve KML dosyalarını tarayıcıda ücretsiz açın; ITRF96, ED50 ve WGS84 koordinat dönüşümü yapın.";
$canonical_url = "https://www.parselsorgu.net/ncn-dxf-kml-donusturucu";
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
      "@graph": [
        {
          "@type": "WebApplication",
          "name": "Online NCN, DXF, KML Harita & Koordinat Dönüştürücü",
          "url": "https://www.parselsorgu.net/ncn-dxf-kml-donusturucu",
          "description": "Netcad NCN, AutoCAD DXF, Google Earth KML ve GeoJSON dosyalarını ITRF96, ED50 ve WGS84 datumları arasında dönüştüren ücretsiz web CBS aracı.",
          "applicationCategory": "GISApplication",
          "operatingSystem": "All",
          "offers": { "@type": "Offer", "price": "0", "priceCurrency": "TRY" },
          "creator": { "@type": "Organization", "name": "Ant Harita Mühendislik", "identifier": "TMMOB HKMO Sicil: 12480" }
        },
        {
          "@type": "FAQPage",
          "mainEntity": [
            {
              "@type": "Question",
              "name": "Netcad .NCN dosyası Google Earth (.KML) formatına nasıl çevrilir?",
              "acceptedAnswer": { "@type": "Answer", "text": "NCN dosyanızı bu sayfaya sürükleyip bırakın, proje dilim orta meridyenini (örneğin DOM 30, 33, 36) ve datumu (ITRF96 veya ED50) seçin. Sistem otomatik olarak WGS84 uydu haritasına oturtur ve KML olarak indirmenizi sağlar." }
            },
            {
              "@type": "Question",
              "name": "ITRF96 3 derece ile ED50 arasındaki fark nedir?",
              "acceptedAnswer": { "@type": "Answer", "text": "ITRF96 güncel GRS80 elipsoidini kullanır ve Türkiye ulusal kadastro standardıdır. ED50 ise eski Hayford elipsoidine dayanır ve aralarında yaklaşık 120-180 metrelik datum kayması bulunur." }
            }
          ]
        }
      ]
    }
    </script>

    <style>
        :root {
            --bg-dark: #060a12;
            --card-bg: #0f172a;
            --surface: #131d31;
            --border: rgba(56, 189, 248, 0.22);
            --cyan: #38bdf8;
            --emerald: #10b981;
            --amber: #f59e0b;
            --purple: #c084fc;
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
        .cad-container {
            max-width: 1440px;
            margin: 0 auto;
            padding: 20px 16px 70px 16px;
        }
        .cad-hero {
            background: linear-gradient(135deg, rgba(14, 165, 233, 0.14) 0%, rgba(15, 23, 42, 0.96) 100%);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 24px 26px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
        }
        .cad-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(56, 189, 248, 0.14);
            border: 1px solid rgba(56, 189, 248, 0.35);
            color: var(--cyan);
            padding: 4px 12px;
            border-radius: 9999px;
            font-size: 11.5px;
            font-weight: 800;
            margin-bottom: 8px;
        }
        .cad-hero h1 {
            margin: 0 0 6px 0;
            font-size: 1.65rem;
            font-weight: 900;
            color: #fff;
        }
        .cad-hero p {
            margin: 0;
            color: var(--muted);
            font-size: 0.92rem;
            max-width: 780px;
        }
        .cad-grid {
            display: grid;
            grid-template-columns: 440px 1fr;
            gap: 18px;
            align-items: start;
        }
        @media (max-width: 1024px) {
            .cad-grid { grid-template-columns: 1fr; }
        }
        .cad-panel {
            background: var(--card-bg);
            border: 1px solid #1e293b;
            border-radius: 14px;
            padding: 18px;
        }
        .panel-title {
            font-size: 14px;
            font-weight: 800;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 14px;
            padding-bottom: 10px;
            border-bottom: 1px solid #1e293b;
        }
        .drop-zone {
            border: 2px dashed rgba(56, 189, 248, 0.4);
            background: rgba(56, 189, 248, 0.05);
            border-radius: 12px;
            padding: 20px 14px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
            margin-bottom: 14px;
        }
        .drop-zone:hover, .drop-zone.dragover {
            background: rgba(56, 189, 248, 0.12);
            border-color: var(--cyan);
        }
        .drop-zone i { font-size: 26px; color: var(--cyan); margin-bottom: 8px; }
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-bottom: 12px;
        }
        .field label {
            display: block;
            font-size: 11px;
            font-weight: 700;
            color: var(--muted);
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        .cad-input, .cad-select, .cad-textarea {
            width: 100%;
            background: var(--surface);
            border: 1px solid #263449;
            color: #fff;
            border-radius: 8px;
            padding: 9px 11px;
            font-size: 13px;
            font-family: inherit;
        }
        .cad-textarea {
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
            font-size: 12px;
            min-height: 150px;
            resize: vertical;
        }
        .btn-primary {
            width: 100%;
            background: linear-gradient(135deg, #0284c7, #38bdf8);
            color: #02131d;
            border: none;
            border-radius: 9px;
            padding: 11px 16px;
            font-size: 13.5px;
            font-weight: 900;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 8px;
        }
        .btn-primary:hover { filter: brightness(1.08); }
        .btn-ghost {
            background: rgba(255,255,255,0.06);
            color: #cbd5e1;
            border: 1px solid #263449;
            border-radius: 7px;
            padding: 6px 10px;
            font-size: 11.5px;
            font-weight: 700;
            cursor: pointer;
        }
        .btn-ghost:hover { background: rgba(56, 189, 248, 0.14); color: #fff; }
        .export-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 8px;
            margin-top: 14px;
        }
        .btn-export {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            padding: 10px 10px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 800;
            cursor: pointer;
            border: 1px solid transparent;
            transition: transform 0.15s;
        }
        .btn-export:hover { transform: translateY(-1px); }
        .exp-kml { background: rgba(16, 185, 129, 0.14); color: #34d399; border-color: rgba(16, 185, 129, 0.35); }
        .exp-dxf { background: rgba(245, 158, 11, 0.14); color: #fbbf24; border-color: rgba(245, 158, 11, 0.35); }
        .exp-ncn { background: rgba(56, 189, 248, 0.14); color: #38bdf8; border-color: rgba(56, 189, 248, 0.35); }
        .exp-json { background: rgba(192, 132, 252, 0.14); color: #d8b4fe; border-color: rgba(192, 132, 252, 0.35); }

        #cadMap {
            width: 100%;
            height: 460px;
            border-radius: 12px;
            border: 1px solid #1e293b;
            background: #080d1a;
        }
        .stats-bar {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin-top: 14px;
        }
        @media (max-width: 640px) { .stats-bar { grid-template-columns: repeat(2, 1fr); } }
        .stat-box {
            background: var(--surface);
            border: 1px solid #1e293b;
            border-radius: 10px;
            padding: 10px 12px;
        }
        .stat-lbl { font-size: 10.5px; color: var(--muted); font-weight: 700; text-transform: uppercase; }
        .stat-val { font-size: 15px; font-weight: 900; color: #fff; margin-top: 2px; }
        .coord-table-wrap {
            margin-top: 14px;
            max-height: 260px;
            overflow-y: auto;
            border: 1px solid #1e293b;
            border-radius: 10px;
        }
        .coord-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }
        .coord-table th {
            position: sticky;
            top: 0;
            background: #131d31;
            color: var(--cyan);
            text-align: left;
            padding: 8px 10px;
            border-bottom: 1px solid #263449;
        }
        .coord-table td {
            padding: 7px 10px;
            border-bottom: 1px solid rgba(255,255,255,0.04);
            color: #cbd5e1;
            font-family: ui-monospace, monospace;
        }
        .checkbox-row {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            color: #cbd5e1;
            margin: 6px 0;
            cursor: pointer;
        }
    </style>
    <link rel="alternate" type="text/markdown" href="https://www.parselsorgu.net/llms.txt" title="ParselSorgu AI / LLM Bilgi Bankası">
    <link rel="alternate" type="application/json" href="https://www.parselsorgu.net/api/2026-kadastro-endeks.json" title="2026 Kadastro ve İmar Açık Veri Seti">
    <script type="application/ld+json">{"@context": "https://schema.org", "@type": "WebPage", "speakable": {"@type": "SpeakableSpecification", "cssSelector": ["h1", ".lead", ".summary-box", ".hero-desc", "main p"]}, "isBasedOn": "https://www.parselsorgu.net/api/2026-kadastro-endeks.json", "publisher": {"@type": "Organization", "name": "Ant Harita Mühendislik - ParselSorgu.net", "url": "https://www.parselsorgu.net/"}}</script>
</head>
<body>
<?= render_navbar('eklentiler') ?>

<main class="cad-container">
    <section class="cad-hero">
        <div>
            <span class="cad-badge"><i class="fa-solid fa-compass-drafting"></i> MÜHENDİSLİK CBS ARAÇLARI &bull; SIFIR SUNUCU BEKLEMESİ</span>
            <h1>Online Netcad (.NCN) &harr; AutoCAD (.DXF) &harr; Google Earth (.KML) Dönüştürücü</h1>
            <p>NCN, DXF, KML, GeoJSON ve XYZ/CSV koordinat dosyalarınızı tarayıcınızda saniyeler içinde açın; ITRF96 (3&deg;), ED50 ve WGS84 (Enlem/Boylam) arasında tam dönüşüm yapıp uydu haritasında inceleyin.</p>
        </div>
        <div style="display:flex; gap:8px; flex-wrap:wrap;">
            <button type="button" class="btn-ghost" onclick="loadSampleAnkara()"><i class="fa-solid fa-wand-magic-sparkles"></i> Örnek Ankara NCN Yükle</button>
            <a href="/" class="btn-ghost" style="text-decoration:none;"><i class="fa-solid fa-map-location-dot"></i> Canlı Parsel Sorgu</a>
        </div>
    </section>

    <div class="cad-grid">
        <!-- SOL PANEL: DOSYA / KOORDİNAT GİRİŞİ VE AYARLAR -->
        <div class="cad-panel">
            <div class="panel-title">
                <span><i class="fa-solid fa-file-import" style="color:var(--cyan);"></i> 1. Veri Girişi &amp; Projeksiyon</span>
                <span id="detectedFormatBadge" style="font-size:11px; color:var(--emerald); font-weight:800;">Hazır</span>
            </div>

            <div class="drop-zone" id="cadDropZone" onclick="document.getElementById('cadFileInput').click()">
                <i class="fa-solid fa-cloud-arrow-up"></i>
                <div style="font-weight:800; font-size:13px; color:#fff;">.NCN, .DXF, .KML, .GeoJSON veya .TXT Sürükleyin</div>
                <div style="font-size:11.5px; color:var(--muted); margin-top:3px;">veya dosya seçmek için tıklayın (Verileriniz cihazınızdan çıkmaz)</div>
                <input type="file" id="cadFileInput" accept=".ncn,.dxf,.kml,.geojson,.json,.txt,.csv,.xyz" style="display:none;">
            </div>

            <div class="form-row">
                <div class="field">
                    <label>Kaynak Koordinat Sistemi</label>
                    <select id="srcCrs" class="cad-select" onchange="processInputData()">
                        <option value="ITRF96_TM3">ITRF96 / TM 3&deg; (Resmi Kadastro)</option>
                        <option value="ED50_TM3">ED50 / TM 3&deg; (Eski Kadastro)</option>
                        <option value="WGS84_UTM6">WGS84 / UTM 6&deg;</option>
                        <option value="WGS84_GEO">WGS84 Enlem/Boylam (Google Earth)</option>
                    </select>
                </div>
                <div class="field">
                    <label>Dilim Orta Meridyeni (DOM)</label>
                    <select id="domMeridian" class="cad-select" onchange="processInputData()">
                        <option value="27">27&deg; (İzmir, Çanakkale, Muğla, Bursa)</option>
                        <option value="30">30&deg; (İstanbul Batı, Antalya, Eskişehir)</option>
                        <option value="33" selected>33&deg; (Ankara, Konya, Mersin, İstanbul Doğu)</option>
                        <option value="36">36&deg; (Kayseri, Samsun, Adana, Gaziantep)</option>
                        <option value="39">39&deg; (Trabzon, Sivas, Malatya, Diyarbakır)</option>
                        <option value="42">42&deg; (Erzurum, Van, Ağrı)</option>
                        <option value="45">45&deg; (Kars, Iğdır, Hakkari)</option>
                    </select>
                </div>
            </div>

            <label class="checkbox-row">
                <input type="checkbox" id="swapXY" onchange="processInputData()">
                <span>Y (Sağa/Easting) &harr; X (Yukarı/Northing) eksenlerini yer değiştir</span>
            </label>
            <label class="checkbox-row">
                <input type="checkbox" id="closePolygon" checked onchange="processInputData()">
                <span>Noktaları kapalı parsel poligonu olarak birleştir (Alan/Çevre hesapla)</span>
            </label>

            <div class="field" style="margin-top:10px;">
                <label>Ham Koordinat / Dosya İçeriği (Yapıştırıp Düzenleyebilirsiniz)</label>
                <textarea id="rawDataInput" class="cad-textarea" placeholder="Örnek NCN formatı:
P1  492150.250  4418240.120  890.50
P2  492215.840  4418252.400  891.10
P3  492228.110  4418195.600  890.80
P4  492160.450  4418185.200  890.10"></textarea>
            </div>

            <button type="button" class="btn-primary" onclick="processInputData()">
                <i class="fa-solid fa-arrows-rotate"></i> Koordinatları Dönüştür &amp; Haritada Çiz
            </button>

            <div style="margin-top:14px; font-size:11.5px; font-weight:800; color:var(--muted); text-transform:uppercase;">
                2. Dönüştürülmüş Dosyayı İndir
            </div>
            <div class="export-grid">
                <button type="button" class="btn-export exp-kml" onclick="exportFile('kml')"><i class="fa-solid fa-earth-europe"></i> Google Earth (.KML)</button>
                <button type="button" class="btn-export exp-dxf" onclick="exportFile('dxf')"><i class="fa-solid fa-drafting-compass"></i> AutoCAD (.DXF)</button>
                <button type="button" class="btn-export exp-ncn" onclick="exportFile('ncn')"><i class="fa-solid fa-layer-group"></i> Netcad (.NCN)</button>
                <button type="button" class="btn-export exp-json" onclick="exportFile('geojson')"><i class="fa-solid fa-code"></i> GeoJSON / Harita</button>
            </div>
        </div>

        <!-- SAĞ PANEL: UYDU HARİTASI + HESAP + KOORDİNAT TABLOSU -->
        <div class="cad-panel">
            <div class="panel-title">
                <span><i class="fa-solid fa-satellite" style="color:var(--emerald);"></i> Canlı Uydu Önizleme &amp; Dönüşüm Tablosu</span>
                <span style="font-size:11px; color:var(--muted);">GRS80 &amp; WGS84 Hassas Projeksiyon</span>
            </div>

            <div id="cadMap"></div>

            <div class="stats-bar">
                <div class="stat-box">
                    <div class="stat-lbl">Nokta Sayısı</div>
                    <div class="stat-val" id="statPoints">0</div>
                </div>
                <div class="stat-box">
                    <div class="stat-lbl">Hesaplanan Alan</div>
                    <div class="stat-val" id="statArea" style="color:var(--emerald);">0 m&sup2;</div>
                </div>
                <div class="stat-box">
                    <div class="stat-lbl">Çevre Uzunluğu</div>
                    <div class="stat-val" id="statPerim" style="color:var(--cyan);">0 m</div>
                </div>
                <div class="stat-box">
                    <div class="stat-lbl">Merkez (DOM)</div>
                    <div class="stat-val" id="statDom">33&deg;</div>
                </div>
            </div>

            <div class="coord-table-wrap">
                <table class="coord-table">
                    <thead>
                        <tr>
                            <th>Nokta</th>
                            <th>ITRF96 Y (Sağa)</th>
                            <th>ITRF96 X (Yukarı)</th>
                            <th>Enlem (Lat)</th>
                            <th>Boylam (Lon)</th>
                            <th>Kot (Z)</th>
                        </tr>
                    </thead>
                    <tbody id="coordTableBody">
                        <tr><td colspan="6" style="text-align:center; color:#64748b; padding:18px;">Dosya yükleyin veya "Örnek Ankara NCN Yükle" butonuna tıklayın.</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<script>
// === GAUSS-KRUGER (TM3 / UTM6) <-> WGS84 GEOGRAPHIC MATH ENGINE ===
const ELLIPSOIDS = {
    GRS80: { a: 6378137.0, invF: 298.257222101 },
    WGS84: { a: 6378137.0, invF: 298.257223563 },
    ED50:  { a: 6378388.0, invF: 297.0 }
};

function tmToLatLon(easting, northing, domDeg, ellipsoidKey = 'GRS80', k0 = 1.0) {
    const el = ELLIPSOIDS[ellipsoidKey] || ELLIPSOIDS.GRS80;
    const a = el.a;
    const f = 1.0 / el.invF;
    const e2 = 2 * f - f * f;
    const ep2 = e2 / (1 - e2);

    const x = easting - 500000.0;
    const y = northing;
    const M = y / k0;
    const mu = M / (a * (1 - e2 / 4 - 3 * e2 * e2 / 64 - 5 * Math.pow(e2, 3) / 256));

    const e1 = (1 - Math.sqrt(1 - e2)) / (1 + Math.sqrt(1 - e2));
    const J1 = (3 * e1 / 2 - 27 * Math.pow(e1, 3) / 32);
    const J2 = (21 * e1 * e1 / 16 - 55 * Math.pow(e1, 4) / 32);
    const J3 = (151 * Math.pow(e1, 3) / 96);
    const J4 = (1097 * Math.pow(e1, 4) / 512);

    const fp = mu + J1 * Math.sin(2 * mu) + J2 * Math.sin(4 * mu) + J3 * Math.sin(6 * mu) + J4 * Math.sin(8 * mu);
    const sinFp = Math.sin(fp), cosFp = Math.cos(fp), tanFp = Math.tan(fp);
    const C1 = ep2 * cosFp * cosFp;
    const T1 = tanFp * tanFp;
    const R1 = a * (1 - e2) / Math.pow(1 - e2 * sinFp * sinFp, 1.5);
    const N1 = a / Math.sqrt(1 - e2 * sinFp * sinFp);
    const D = x / (N1 * k0);

    const Q1 = N1 * tanFp / R1;
    const Q2 = (D * D / 2);
    const Q3 = (5 + 3 * T1 + 10 * C1 - 4 * C1 * C1 - 9 * ep2) * Math.pow(D, 4) / 24;
    const Q4 = (61 + 90 * T1 + 298 * C1 + 45 * T1 * T1 - 3 * C1 * C1 - 252 * ep2) * Math.pow(D, 6) / 720;
    let lat = fp - Q1 * (Q2 - Q3 + Q4);

    const Q5 = D;
    const Q6 = (1 + 2 * T1 + C1) * Math.pow(D, 3) / 6;
    const Q7 = (5 - 2 * C1 + 28 * T1 - 3 * C1 * C1 + 8 * ep2 + 24 * T1 * T1) * Math.pow(D, 5) / 120;
    let lon = (domDeg * Math.PI / 180) + (Q5 - Q6 + Q7) / cosFp;

    let latDeg = lat * 180 / Math.PI;
    let lonDeg = lon * 180 / Math.PI;

    // ED50 -> WGS84 Turkiye ortalama Molodensky yaklasimi (~130m kayma telafisi)
    if (ellipsoidKey === 'ED50') {
        latDeg -= 0.00097;
        lonDeg -= 0.00038;
    }
    return [latDeg, lonDeg];
}

function latLonToTm(latDeg, lonDeg, domDeg, ellipsoidKey = 'GRS80', k0 = 1.0) {
    let adjLat = latDeg, adjLon = lonDeg;
    if (ellipsoidKey === 'ED50') {
        adjLat += 0.00097;
        adjLon += 0.00038;
    }
    const el = ELLIPSOIDS[ellipsoidKey] || ELLIPSOIDS.GRS80;
    const a = el.a;
    const f = 1.0 / el.invF;
    const e2 = 2 * f - f * f;
    const ep2 = e2 / (1 - e2);

    const lat = adjLat * Math.PI / 180;
    const lon = adjLon * Math.PI / 180;
    const lon0 = domDeg * Math.PI / 180;

    const N = a / Math.sqrt(1 - e2 * Math.sin(lat) * Math.sin(lat));
    const T = Math.tan(lat) * Math.tan(lat);
    const C = ep2 * Math.cos(lat) * Math.cos(lat);
    const A = (lon - lon0) * Math.cos(lat);

    const M = a * (
        (1 - e2 / 4 - 3 * e2 * e2 / 64 - 5 * Math.pow(e2, 3) / 256) * lat
        - (3 * e2 / 8 + 3 * e2 * e2 / 32 + 45 * Math.pow(e2, 3) / 1024) * Math.sin(2 * lat)
        + (15 * e2 * e2 / 256 + 45 * Math.pow(e2, 3) / 1024) * Math.sin(4 * lat)
        - (35 * Math.pow(e2, 3) / 3072) * Math.sin(6 * lat)
    );

    const easting = 500000.0 + k0 * N * (
        A + (1 - T + C) * Math.pow(A, 3) / 6
        + (5 - 18 * T + T * T + 72 * C - 58 * ep2) * Math.pow(A, 5) / 120
    );
    const northing = k0 * (
        M + N * Math.tan(lat) * (
            A * A / 2
            + (5 - T + 9 * C + 4 * C * C) * Math.pow(A, 4) / 24
            + (61 - 58 * T + T * T + 600 * C - 330 * ep2) * Math.pow(A, 6) / 720
        )
    );
    return [easting, northing];
}

// === LEAFLET INIT ===
let cadMap = L.map('cadMap').setView([39.92, 32.85], 6);
L.tileLayer('https://mt1.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
    maxZoom: 21,
    attribution: 'Google Hybrid Satellite'
}).addTo(cadMap);
let cadLayerGroup = L.layerGroup().addTo(cadMap);
let convertedPoints = [];

// === DRAG & DROP / FILE UPLOAD ===
const dz = document.getElementById('cadDropZone');
const fi = document.getElementById('cadFileInput');
['dragenter', 'dragover'].forEach(ev => dz.addEventListener(ev, e => { e.preventDefault(); dz.classList.add('dragover'); }));
['dragleave', 'drop'].forEach(ev => dz.addEventListener(ev, e => { e.preventDefault(); dz.classList.remove('dragover'); }));
dz.addEventListener('drop', e => { if (e.dataTransfer.files[0]) readUploadedFile(e.dataTransfer.files[0]); });
fi.addEventListener('change', e => { if (e.target.files[0]) readUploadedFile(e.target.files[0]); });

function readUploadedFile(file) {
    const reader = new FileReader();
    reader.onload = ev => {
        const text = ev.target.result;
        document.getElementById('rawDataInput').value = text;
        const ext = file.name.split('.').pop().toLowerCase();
        if (ext === 'kml' || ext === 'geojson' || ext === 'json') {
            document.getElementById('srcCrs').value = 'WGS84_GEO';
        }
        processInputData(ext);
    };
    reader.readAsText(file, 'utf-8');
}

function parseRawText(raw) {
    const trimmed = raw.trim();
    const pts = [];
    if (!trimmed) return { format: 'Boş', points: [] };

    // 1. GeoJSON
    if (trimmed.startsWith('{')) {
        try {
            const gj = JSON.parse(trimmed);
            const feats = gj.type === 'FeatureCollection' ? gj.features : [gj];
            let idx = 1;
            feats.forEach(f => {
                const g = f.geometry;
                if (!g) return;
                if (g.type === 'Point') pts.push({ name: f.properties?.name || ('P' + idx++), x: g.coordinates[0], y: g.coordinates[1], z: g.coordinates[2] || 0, isGeo: true });
                else if (g.type === 'Polygon') g.coordinates[0].forEach(c => pts.push({ name: 'K' + idx++, x: c[0], y: c[1], z: c[2] || 0, isGeo: true }));
                else if (g.type === 'LineString') g.coordinates.forEach(c => pts.push({ name: 'L' + idx++, x: c[0], y: c[1], z: c[2] || 0, isGeo: true }));
            });
            return { format: 'GeoJSON', points: pts };
        } catch (e) {}
    }

    // 2. KML
    if (trimmed.includes('<kml') || trimmed.includes('<coordinates>')) {
        const matches = [...trimmed.matchAll(/<coordinates[^>]*>([\s\S]*?)<\/coordinates>/gi)];
        let idx = 1;
        matches.forEach(m => {
            m[1].trim().split(/\s+/).forEach(pair => {
                const parts = pair.split(',');
                if (parts.length >= 2) {
                    const lon = parseFloat(parts[0]), lat = parseFloat(parts[1]), z = parseFloat(parts[2] || 0);
                    if (!isNaN(lon) && !isNaN(lat)) pts.push({ name: 'K' + idx++, x: lon, y: lat, z, isGeo: true });
                }
            });
        });
        return { format: 'Google Earth KML', points: pts };
    }

    // 3. AutoCAD DXF (Simple ASCII VERTEX / LWPOLYLINE / POINT parser)
    if (trimmed.includes('SECTION') && trimmed.includes('ENTITIES')) {
        const lines = trimmed.split(/\r?\n/).map(s => s.trim());
        let idx = 1, curEntity = '', curX = null, curY = null, curZ = 0;
        for (let i = 0; i < lines.length - 1; i++) {
            const code = lines[i], val = lines[i + 1];
            if (code === '0') {
                if (curX !== null && curY !== null) {
                    pts.push({ name: 'D' + idx++, x: curX, y: curY, z: curZ, isGeo: false });
                    curX = null; curY = null; curZ = 0;
                }
                curEntity = val;
                i++;
                continue;
            }
            if (curEntity === 'POINT' || curEntity === 'VERTEX' || curEntity === 'LWPOLYLINE') {
                if (code === '10') {
                    if (curEntity === 'LWPOLYLINE' && curX !== null && curY !== null) {
                        pts.push({ name: 'D' + idx++, x: curX, y: curY, z: 0, isGeo: false });
                        curY = null;
                    }
                    curX = parseFloat(val);
                    i++;
                } else if (code === '20') { curY = parseFloat(val); i++; }
                else if (code === '30') { curZ = parseFloat(val) || 0; i++; }
            }
        }
        if (curX !== null && curY !== null) pts.push({ name: 'D' + idx++, x: curX, y: curY, z: curZ, isGeo: false });
        return { format: 'AutoCAD DXF', points: pts };
    }

    // 4. Netcad NCN / XYZ / CSV
    const rows = trimmed.split(/\r?\n/);
    let idx = 1;
    rows.forEach(line => {
        const l = line.trim();
        if (!l || l.startsWith('#') || l.startsWith('//')) return;
        const parts = l.split(/[\s,;]+/);
        if (parts.length >= 3 && isNaN(parseFloat(parts[0]))) {
            const pName = parts[0];
            const c1 = parseFloat(parts[1]), c2 = parseFloat(parts[2]), c3 = parseFloat(parts[3] || 0);
            if (!isNaN(c1) && !isNaN(c2)) pts.push({ name: pName, x: c1, y: c2, z: isNaN(c3) ? 0 : c3, isGeo: (Math.abs(c1) <= 180 && Math.abs(c2) <= 90) });
        } else if (parts.length >= 2) {
            const c1 = parseFloat(parts[0]), c2 = parseFloat(parts[1]), c3 = parseFloat(parts[2] || 0);
            if (!isNaN(c1) && !isNaN(c2)) pts.push({ name: 'P' + idx++, x: c1, y: c2, z: isNaN(c3) ? 0 : c3, isGeo: (Math.abs(c1) <= 180 && Math.abs(c2) <= 90) });
        }
    });
    return { format: 'Netcad NCN / XYZ', points: pts };
}

function processInputData() {
    const raw = document.getElementById('rawDataInput').value;
    const parsed = parseRawText(raw);
    document.getElementById('detectedFormatBadge').textContent = `${parsed.format} (${parsed.points.length} Nokta)`;

    const srcCrs = document.getElementById('srcCrs').value;
    const dom = parseFloat(document.getElementById('domMeridian').value);
    const swap = document.getElementById('swapXY').checked;
    const closePoly = document.getElementById('closePolygon').checked;
    document.getElementById('statDom').textContent = dom + '°';

    convertedPoints = [];
    cadLayerGroup.clearLayers();
    const tbody = document.getElementById('coordTableBody');
    tbody.innerHTML = '';

    if (parsed.points.length === 0) {
        document.getElementById('statPoints').textContent = '0';
        document.getElementById('statArea').textContent = '0 m²';
        document.getElementById('statPerim').textContent = '0 m';
        tbody.innerHTML = '<tr><td colspan="6" style="text-align:center; color:#64748b; padding:18px;">Geçerli koordinat tespit edilemedi.</td></tr>';
        return;
    }

    parsed.points.forEach(p => {
        let east = swap ? p.y : p.x;
        let north = swap ? p.x : p.y;
        let lat, lon, itrfY, itrfX;

        if (srcCrs === 'WGS84_GEO' || p.isGeo) {
            // In GeoJSON/KML x=lon, y=lat
            lon = swap ? north : east;
            lat = swap ? east : north;
            if (lat < 20 && lon > 30) { const tmp = lat; lat = lon; lon = tmp; } // Safety Turkiye lat(36-42) lon(26-45)
            [itrfY, itrfX] = latLonToTm(lat, lon, dom, 'GRS80', 1.0);
        } else {
            // Auto detect swapped E/N in Turkey (E ~ 300k-750k, N ~ 3.9M-4.7M)
            if (east > 2000000 && north < 1000000) {
                const tmp = east; east = north; north = tmp;
            }
            const ell = (srcCrs === 'ED50_TM3') ? 'ED50' : 'GRS80';
            const k0 = (srcCrs === 'WGS84_UTM6') ? 0.9996 : 1.0;
            [lat, lon] = tmToLatLon(east, north, dom, ell, k0);
            [itrfY, itrfX] = (srcCrs === 'ITRF96_TM3') ? [east, north] : latLonToTm(lat, lon, dom, 'GRS80', 1.0);
        }

        if (!isNaN(lat) && !isNaN(lon)) {
            convertedPoints.push({ name: p.name, y: itrfY, x: itrfX, z: p.z, lat, lon });
        }
    });

    // Draw on Leaflet Map
    const latLngs = convertedPoints.map(pt => [pt.lat, pt.lon]);
    convertedPoints.forEach(pt => {
        L.circleMarker([pt.lat, pt.lon], {
            radius: 5, color: '#fbbf24', fillColor: '#0284c7', fillOpacity: 0.95, weight: 2
        }).bindTooltip(`<b>${pt.name}</b><br>Y: ${pt.y.toFixed(2)}<br>X: ${pt.x.toFixed(2)}`, { direction: 'top' }).addTo(cadLayerGroup);

        const tr = document.createElement('tr');
        tr.innerHTML = `<td style="color:#fbbf24; font-weight:700;">${pt.name}</td><td>${pt.y.toFixed(3)}</td><td>${pt.x.toFixed(3)}</td><td>${pt.lat.toFixed(6)}</td><td>${pt.lon.toFixed(6)}</td><td>${pt.z.toFixed(2)}</td>`;
        tbody.appendChild(tr);
    });

    let areaM2 = 0, perimM = 0;
    if (latLngs.length >= 3 && closePoly) {
        L.polygon(latLngs, { color: '#38bdf8', weight: 2.5, fillColor: '#38bdf8', fillOpacity: 0.18 }).addTo(cadLayerGroup);
        // Planar Shoelace Area & Perimeter in TM (100% accurate m2)
        for (let i = 0; i < convertedPoints.length; i++) {
            const p1 = convertedPoints[i];
            const p2 = convertedPoints[(i + 1) % convertedPoints.length];
            areaM2 += (p1.y * p2.x - p2.y * p1.x);
            perimM += Math.hypot(p2.y - p1.y, p2.x - p1.x);
        }
        areaM2 = Math.abs(areaM2) / 2;
    } else if (latLngs.length >= 2) {
        L.polyline(latLngs, { color: '#10b981', weight: 3 }).addTo(cadLayerGroup);
        for (let i = 0; i < convertedPoints.length - 1; i++) {
            perimM += Math.hypot(convertedPoints[i+1].y - convertedPoints[i].y, convertedPoints[i+1].x - convertedPoints[i].x);
        }
    }

    document.getElementById('statPoints').textContent = convertedPoints.length;
    document.getElementById('statArea').textContent = areaM2.toLocaleString('tr-TR', { maximumFractionDigits: 2 }) + ' m²';
    document.getElementById('statPerim').textContent = perimM.toLocaleString('tr-TR', { maximumFractionDigits: 2 }) + ' m';

    if (latLngs.length > 0) {
        cadMap.fitBounds(L.latLngBounds(latLngs), { padding: [40, 40], maxZoom: 19 });
    }
}

function exportFile(fmt) {
    if (convertedPoints.length === 0) {
        alert('Önce geçerli koordinat verisi yükleyin veya dönüştürün.');
        return;
    }
    let content = '', mime = 'text/plain;charset=utf-8', filename = 'parselsorgu_donusum.' + fmt;
    const closePoly = document.getElementById('closePolygon').checked;

    if (fmt === 'ncn') {
        content = convertedPoints.map(p => `${p.name} ${p.y.toFixed(3)} ${p.x.toFixed(3)} ${p.z.toFixed(3)}`).join('\r\n');
    } else if (fmt === 'kml') {
        mime = 'application/vnd.google-earth.kml+xml;charset=utf-8';
        const coordsStr = convertedPoints.map(p => `${p.lon.toFixed(7)},${p.lat.toFixed(7)},${p.z}`).concat(closePoly && convertedPoints.length > 2 ? [`${convertedPoints[0].lon.toFixed(7)},${convertedPoints[0].lat.toFixed(7)},${convertedPoints[0].z}`] : []).join(' ');
        const placemarks = convertedPoints.map(p => `<Placemark><name>${p.name}</name><Point><coordinates>${p.lon.toFixed(7)},${p.lat.toFixed(7)},${p.z}</coordinates></Point></Placemark>`).join('\n');
        const polyXml = convertedPoints.length >= 3 ? `<Placemark><name>Parsel Sınırı (ParselSorgu.net)</name><Style><LineStyle><color>ff00ffff</color><width>3</width></LineStyle><PolyStyle><color>4d00ffff</color></PolyStyle></Style><Polygon><outerBoundaryIs><LinearRing><coordinates>${coordsStr}</coordinates></LinearRing></outerBoundaryIs></Polygon></Placemark>` : '';
        content = '<' + '?xml version="1.0" encoding="UTF-8"?' + `>\n<kml xmlns="http://www.opengis.net/kml/2.2"><Document><name>ParselSorgu CAD Dönüşümü</name>\n${polyXml}\n${placemarks}\n</Document></kml>`;
    } else if (fmt === 'dxf') {
        let ent = '';
        convertedPoints.forEach(p => {
            ent += `0\r\nPOINT\r\n8\r\nNOKTALAR\r\n10\r\n${p.y.toFixed(3)}\r\n20\r\n${p.x.toFixed(3)}\r\n30\r\n${p.z.toFixed(3)}\r\n`;
            ent += `0\r\nTEXT\r\n8\r\nNOKTA_ADLARI\r\n10\r\n${(p.y + 0.5).toFixed(3)}\r\n20\r\n${(p.x + 0.5).toFixed(3)}\r\n40\r\n1.5\r\n1\r\n${p.name}\r\n`;
        });
        if (convertedPoints.length >= 2) {
            ent += `0\r\nLWPOLYLINE\r\n8\r\nPARSEL_SINIRI\r\n90\r\n${convertedPoints.length}\r\n70\r\n${closePoly ? 1 : 0}\r\n`;
            convertedPoints.forEach(p => { ent += `10\r\n${p.y.toFixed(3)}\r\n20\r\n${p.x.toFixed(3)}\r\n`; });
        }
        content = `0\r\nSECTION\r\n2\r\nENTITIES\r\n${ent}0\r\nENDSEC\r\n0\r\nEOF\r\n`;
    } else if (fmt === 'geojson') {
        mime = 'application/geo+json;charset=utf-8';
        const ring = convertedPoints.map(p => [p.lon, p.lat]);
        if (closePoly && ring.length > 2) ring.push(ring[0]);
        const gj = {
            type: 'FeatureCollection',
            features: convertedPoints.length >= 3 && closePoly
                ? [{ type: 'Feature', properties: { source: 'ParselSorgu.net' }, geometry: { type: 'Polygon', coordinates: [ring] } }]
                : convertedPoints.map(p => ({ type: 'Feature', properties: { name: p.name }, geometry: { type: 'Point', coordinates: [p.lon, p.lat] } }))
        };
        content = JSON.stringify(gj, null, 2);
    }

    const blob = new Blob([content], { type: mime });
    const a = document.createElement('a');
    a.href = URL.createObjectURL(blob);
    a.download = filename;
    a.click();
}

function loadSampleAnkara() {
    document.getElementById('srcCrs').value = 'ITRF96_TM3';
    document.getElementById('domMeridian').value = '33';
    document.getElementById('swapXY').checked = false;
    document.getElementById('rawDataInput').value =
`P1  486920.150  4416450.300  872.10
P2  486972.420  4416461.850  873.05
P3  486985.600  4416408.120  872.40
P4  486931.800  4416397.500  871.85`;
    processInputData();
}

// Auto-load sample on first visit so map is alive immediately
loadSampleAnkara();
</script>
</body>
</html>
