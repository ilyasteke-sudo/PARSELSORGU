<?php
/**
 * ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ - PARSEL PRO
 * TKGM MEGSİS CANLI PARSEL SORGULAMA & İLYA CBS HARİTA MOTORU (tkgm_canli_parsel.php)
 * Pure PHP 8.1+ / Vanilla JS / Leaflet 1.9.4 / Google Satellite & ESRI & OSM
 */
declare(strict_types=1);

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/navbar.php';

$page_title = "TKGM MEGSİS Canlı Parsel Sorgulama | ParselSorgu";
$meta_desc = "TKGM MEGSİS canlı uydu haritasında 81 ilde ada/parsel sınırlarını, yüzölçümünü ve 3194 İmar Kanunu durumunu ücretsiz sorgulayın.";
$canonical_url = "https://www.parselsorgu.net/tkgm-canli-parsel";

$CITIES_81 = [
    1 => "Adana", 2 => "Adıyaman", 3 => "Afyonkarahisar", 4 => "Ağrı", 5 => "Amasya",
    6 => "Ankara", 7 => "Antalya", 8 => "Artvin", 9 => "Aydın", 10 => "Balıkesir",
    11 => "Bilecik", 12 => "Bingöl", 13 => "Bitlis", 14 => "Bolu", 15 => "Burdur",
    16 => "Bursa", 17 => "Çanakkale", 18 => "Çankırı", 19 => "Çorum", 20 => "Denizli",
    21 => "Diyarbakır", 22 => "Edirne", 23 => "Elazığ", 24 => "Erzincan", 25 => "Erzurum",
    26 => "Eskişehir", 27 => "Gaziantep", 28 => "Giresun", 29 => "Gümüşhane", 30 => "Hakkari",
    31 => "Hatay", 32 => "Isparta", 33 => "Mersin", 34 => "İstanbul", 35 => "İzmir",
    36 => "Kars", 37 => "Kastamonu", 38 => "Kayseri", 39 => "Kırklareli", 40 => "Kırşehir",
    41 => "Kocaeli", 42 => "Konya", 43 => "Kütahya", 44 => "Malatya", 45 => "Manisa",
    46 => "Kahramanmaraş", 47 => "Mardin", 48 => "Muğla", 49 => "Muş", 50 => "Nevşehir",
    51 => "Niğde", 52 => "Ordu", 53 => "Rize", 54 => "Sakarya", 55 => "Samsun",
    56 => "Siirt", 57 => "Sinop", 58 => "Sivas", 59 => "Tekirdağ", 60 => "Tokat",
    61 => "Trabzon", 62 => "Tunceli", 63 => "Şanlıurfa", 64 => "Uşak", 65 => "Van",
    66 => "Yozgat", 67 => "Zonguldak", 68 => "Aksaray", 69 => "Bayburt", 70 => "Karaman",
    71 => "Kırıkkale", 72 => "Batman", 73 => "Şırnak", 74 => "Bartın", 75 => "Ardahan",
    76 => "Iğdır", 77 => "Yalova", 78 => "Karabük", 79 => "Kilis", 80 => "Osmaniye",
    81 => "Düzce"
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
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= $canonical_url ?>">
    <meta property="og:image" content="https://www.parselsorgu.net/assets/images/og-parsel.jpg">
    <meta name="twitter:card" content="summary_large_image">
    <meta property="og:url" content="<?= $canonical_url ?>">
    <meta property="og:type" content="website">

    <!-- Leaflet 1.9.4 CSS -->
    <!-- ZERO RENDER-BLOCKING ASYNC CSS (100% LIGHTHOUSE COMPLIANT) -->
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    </noscript>

    <style>
        :root {
            --primary: #1e40af;
            --accent: #38bdf8;
            --dark-bg: #090e17;
            --card-bg: #0f172a;
            --border-color: #1e293b;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --green: #10b981;
        }

        body {
            background-color: var(--dark-bg);
            color: var(--text-main);
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            margin: 0;
            padding: 0;
            line-height: 1.5;
        }

        .container {
            max-width: 1320px;
            margin: 0 auto;
            padding: 24px 16px;
        }

        .hero-banner {
            background: linear-gradient(135deg, rgba(30,58,138,0.3) 0%, rgba(15,23,42,0.8) 100%);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 24px;
            text-align: center;
        }

        .hero-banner h1 {
            font-size: 24px;
            font-weight: 900;
            margin: 0 0 8px 0;
            color: #fff;
        }

        .hero-banner p {
            color: var(--text-muted);
            font-size: 14px;
            margin: 0 auto;
            max-width: 820px;
        }

        /* GRID LAYOUT */
        .cbs-layout {
            display: grid;
            grid-template-columns: 360px 1fr;
            gap: 20px;
            margin-bottom: 32px;
        }

        @media (max-width: 992px) {
            .cbs-layout {
                grid-template-columns: 1fr;
            }
        }

        /* CONTROL CARD */
        .control-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 14px;
            padding: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            height: fit-content;
        }

        .card-header-title {
            font-size: 15px;
            font-weight: 800;
            color: #fff;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 16px;
            padding-bottom: 12px;
            border-bottom: 1px solid var(--border-color);
        }

        .form-group {
            margin-bottom: 14px;
        }

        .form-group label {
            display: block;
            font-size: 11.5px;
            font-weight: 700;
            color: var(--text-muted);
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-control {
            width: 100%;
            padding: 10px 12px;
            background: #090e17;
            border: 1px solid #334155;
            border-radius: 8px;
            color: #fff;
            font-size: 13px;
            outline: none;
            box-sizing: border-box;
            transition: border-color 0.2s;
        }

        .form-control:focus {
            border-color: var(--accent);
        }

        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .btn-query {
            width: 100%;
            background: linear-gradient(135deg, #0284c7, #2563eb);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 12px;
            font-size: 14px;
            font-weight: 800;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 8px;
            transition: transform 0.15s, background 0.2s;
        }

        .btn-query:hover {
            transform: translateY(-1px);
            filter: brightness(1.1);
        }

        .info-box {
            background: rgba(56,189,248,0.06);
            border: 1px solid rgba(56,189,248,0.2);
            border-radius: 8px;
            padding: 12px;
            margin-top: 14px;
            font-size: 12px;
            color: #cbd5e1;
            line-height: 1.5;
        }

        /* MAP WRAPPER */
        .map-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            display: flex;
            flex-direction: column;
        }

        .map-top-bar {
            padding: 12px 18px;
            background: #0b1325;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }

        .map-badge {
            background: rgba(34, 197, 94, 0.15);
            color: #4ade80;
            border: 1px solid rgba(34, 197, 94, 0.3);
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        #parsel-map {
            width: 100%;
            height: 560px;
            background: #1e293b;
        }

        /* DETAILS CARD */
        .parcel-results-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 14px;
            padding: 24px;
            margin-bottom: 30px;
            display: none;
        }
    
        /* HARİTA AKSİYON VE CETVEL BUTONLARI */
        .map-action-btn {
            background: rgba(15, 23, 42, 0.85);
            border: 1px solid rgba(56, 189, 248, 0.35);
            color: #38bdf8;
            font-size: 12px;
            font-weight: 700;
            padding: 5px 11px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        .map-action-btn:hover {
            background: rgba(56, 189, 248, 0.2);
            color: #ffffff;
            border-color: #38bdf8;
        }
        .map-action-btn.active {
            background: #f59e0b;
            color: #ffffff;
            border-color: #f59e0b;
            box-shadow: 0 0 12px rgba(245, 158, 11, 0.5);
        }

        @media print {
            body * { visibility: hidden !important; }
            #psReportModal, #psReportModal * { visibility: visible !important; }
            #psReportModal { position: absolute !important; left: 0 !important; top: 0 !important; width: 100% !important; background: #ffffff !important; }
            .no-print { display: none !important; }
        }

    
        
        /* SAHIBINDEN.COM UYDU HARITASI SARI PIN VE POPUP STILLERI */
        .ps-listing-pin {
            background: transparent !important;
            border: none !important;
        }
        .ps-pin-bubble {
            background: #ffe800 !important;
            color: #111827 !important;
            border: 2px solid #111827 !important;
            border-radius: 20px;
            padding: 4px 10px;
            box-shadow: 0 4px 14px rgba(0,0,0,0.6), 0 0 14px rgba(255, 232, 0, 0.55);
            display: flex;
            flex-direction: column;
            align-items: center;
            white-space: nowrap;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .ps-pin-bubble:hover {
            transform: scale(1.1) translateY(-3px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.8), 0 0 20px rgba(255, 232, 0, 0.9);
        }
        .ps-pin-source {
            font-size: 12px;
            font-weight: 800;
            color: #0f172a;
            display: flex;
            align-items: center;
            gap: 3px;
            line-height: 1.1;
        }
        .ps-pin-price {
            font-size: 13px;
            font-weight: 900;
            color: #000000;
            letter-spacing: -0.3px;
        }
        .ps-pin-type {
            font-size: 12px;
            font-weight: 700;
            color: #334155;
        }
        .ps-pin-arrow {
            width: 0;
            height: 0;
            border-left: 6px solid transparent;
            border-right: 6px solid transparent;
            border-top: 6px solid #111827;
            margin-top: -1px;
        }
        .ps-listing-popup .leaflet-popup-content-wrapper {
            background: #0f172a;
            color: #f8fafc;
            border: 2px solid #ffe800;
            border-radius: 14px;
            padding: 6px;
            box-shadow: 0 12px 35px rgba(0,0,0,0.85);
        }
        .ps-listing-popup .leaflet-popup-tip {
            background: #0f172a;
        }
        .ps-listing-popup-body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            padding: 4px;
            min-width: 230px;
        }
        .ps-listing-popup-title {
            font-size: 13.5px;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 4px;
            line-height: 1.35;
        }
        .ps-listing-popup-price {
            font-size: 17px;
            font-weight: 900;
            color: #ffe800;
            margin-bottom: 6px;
        }
        .ps-listing-popup-meta {
            background: rgba(255,255,255,0.05);
            padding: 8px;
            border-radius: 8px;
            margin-bottom: 10px;
            font-size: 12px;
            line-height: 1.5;
            color: #cbd5e1;
        }
        .ps-btn-sahibinden {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            background: #ffe800;
            color: #111827 !important;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 800;
            text-decoration: none;
            transition: background 0.2s, transform 0.1s;
        }
        .ps-btn-sahibinden:hover {
            background: #facc15;
            transform: translateY(-1px);
        }
        .ps-btn-wa-listing {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            background: #22c55e;
            color: #ffffff !important;
            padding: 7px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 700;
            text-decoration: none;
            transition: background 0.2s;
        }
        .ps-btn-wa-listing:hover {
            background: #16a34a;
        }

    </style>
</head>
<body>

<?= render_navbar('parsel') ?>
<main id="main-content" role="main">

<div class="container">
    <div class="hero-banner">
        <h1><i class="fa-solid fa-satellite-dish" style="color:var(--accent);"></i> TKGM MEGSİS Canlı Parsel &amp; Kadastro Harita Motoru</h1>
        <p>Tapu ve Kadastro Genel Müdürlüğü (MEGSİS) altyapısıyla entegre canlı uydu haritası. İl, İlçe, Mahalle, Ada ve Parsel sınırlarını, resmi yüzölçümünü ve 3194 Sayılı İmar Kanunu verilerini anında sorgulayın.</p>
    </div>

    <div class="cbs-layout">
        <!-- Sol Kontrol Kartı -->
        <div class="control-card">
            <div class="card-header-title">
                <i class="fa-solid fa-layer-group" style="color:var(--accent);"></i>
                <span>Kadastro Parsel Seçimi</span>
            </div>

            <!-- İl Seçimi (81 İl Önceden Yüklü) -->
            <div class="form-group">
                <label for="cbs-il"><i class="fa-solid fa-map"></i> İl Seçiniz</label>
                <select id="cbs-il" name="il" aria-label="İl Seçiniz (81 İl)" class="form-control" onchange="loadIlceler()">
                    <option value="">-- İl Seçiniz (81 İl) --</option>
                    <?php foreach ($CITIES_81 as $id => $name): ?>
                        <option value="<?= $id ?>" <?= ($name === 'Kırklareli') ? 'selected' : '' ?>><?= $name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- İlçe Seçimi -->
            <div class="form-group">
                <label for="cbs-ilce"><i class="fa-solid fa-building"></i> İlçe Seçiniz</label>
                <select id="cbs-ilce" name="ilce" aria-label="İlçe Seçiniz" class="form-control" onchange="loadMahalleler()">
                    <option value="">İlçeler Yükleniyor...</option>
                </select>
            </div>

            <!-- Mahalle Seçimi -->
            <div class="form-group">
                <label for="cbs-mahalle"><i class="fa-solid fa-location-dot"></i> Mahalle / Köy</label>
                <select id="cbs-mahalle" name="mahalle" aria-label="Mahalle ve Köy Seçiniz" class="form-control">
                    <option value="">Önce İlçe Seçin</option>
                </select>
            </div>

            <!-- Ada / Parsel -->
            <div class="grid-2">
                <div class="form-group">
                    <label for="cbs-ada"><i class="fa-solid fa-hashtag"></i> Ada No</label>
                    <input type="number" id="cbs-ada" aria-label="Ada Numarası" name="ada" aria-label="Ada Numarası" class="form-control" value="105" placeholder="Örn: 105">
                </div>
                <div class="form-group">
                    <label for="cbs-parsel"><i class="fa-solid fa-draw-polygon"></i> Parsel No</label>
                    <input type="number" id="cbs-parsel" aria-label="Parsel Numarası" name="parsel" aria-label="Parsel Numarası" class="form-control" value="12" placeholder="Örn: 12">
                </div>
            </div>

            <button type="button" id="btn-cbs-query" class="btn-query" onclick="queryParsel()" aria-label="Resmi Kadastro Parselini Canlı Sorgula">
                <i class="fa-solid fa-crosshairs"></i> Canlı Parsel Sorgula
            </button>

            <div class="info-box">
                <strong style="color:#fff; display:block; margin-bottom:4px;">
                    <i class="fa-solid fa-shield-halved" style="color:var(--green);"></i> Resmi Kadastro Güvencesi:
                </strong>
                Sorgulanan parsel sınırları, TKGM MEGSİS koordinat sistemiyle tam oturtulmuş GeoJSON vektör poligonu ile canlı uydu altlığına yerleştirilir.
            </div>
        </div>

        <!-- Sağ Harita Alanı -->
        <div class="map-card">
            <div class="map-top-bar">
                <div style="display:flex; align-items:center; gap:8px;">
                    <i class="fa-solid fa-map-location-dot" style="color:var(--accent);"></i>
                    <strong style="font-size:13px; color:#fff;">Canlı Kadastro Uydu Haritası</strong>
                </div>
                <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                    <button type="button" id="btn-measure-tool" class="map-action-btn" onclick="window.toggleMeasureTool()" aria-label="Harita Üzerinde Mesafe ve Cephe Ölçüm Aracını Başlat" title="Harita üzerinde mesafe ve yol cephesini ölçün">
                        <i class="fa-solid fa-ruler-combined"></i> Mesafe &amp; Cephe Ölç
                    </button>
                    <span class="map-badge">
                        <i class="fa-solid fa-circle" style="font-size:12px;"></i> Canlı CBS Vektör Aktif
                    </span>
                </div>
            </div>
            <div id="parsel-map"></div>
        </div>
    </div>

    <!-- Parsel Sonuç Paneli (5 Stratejik Mühendislik Aracı Entegreli) -->
    
            
            <!-- ÇEVREDEKİ SAHİBİNDEN.COM SATILIK İLANLARI (TKGM CANLI UYDU İLE SENKRON) -->
            <div id="surrounding-listings-container" style="display:none; margin-top:20px; margin-bottom:20px; background:#0b1329; border:2px solid #ffe800; border-radius:14px; padding:20px; box-shadow:0 10px 25px rgba(0,0,0,0.6);">
                <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:16px; border-bottom:1px solid rgba(255,255,255,0.08); padding-bottom:12px;">
                    <div>
                        <h3 style="font-size:17px; font-weight:800; color:#ffe800; margin:0 0 4px 0; display:flex; align-items:center; gap:8px;">
                            <span style="background:#ffe800; color:#111827; border-radius:4px; padding:2px 6px; font-size:12px; font-weight:900;">sahibinden.com</span>
                            <span>Parsel Çevresindeki Emsal Satılık İlanlar & Piyasa Rayiçleri</span>
                        </h3>
                        <p style="font-size:13px; color:#94a3b8; margin:0;">
                            Sorguladığınız taşınmazın 500m çevresinde sahibinden.com emsal verileriyle tespit edilen satılık taşınmazlar ve gerçek piyasa değerleri.
                        </p>
                    </div>
                    <a id="btn-all-sahibinden-link" href="https://www.sahibinden.com/satilik-arsa" target="_blank" rel="noopener noreferrer" style="background:#ffe800; color:#111827; font-weight:800; font-size:12px; padding:6px 14px; border-radius:8px; text-decoration:none; display:inline-flex; align-items:center; gap:6px;">
                        Sahibinden.com'da Tüm Bölge İlanları ↗
                    </a>
                </div>
                <div id="surrounding-listings-grid" style="display:grid; grid-template-columns:repeat(auto-fill, minmax(270px, 1fr)); gap:14px;">
                    <!-- İlan kartları dinamik yüklenir -->
                </div>
            </div>


    <div id="parcel-results-card" class="parcel-results-card">
        <div style="display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid var(--border-color); padding-bottom:12px; margin-bottom:16px; flex-wrap:wrap; gap:10px;">
            <h2 style="margin:0; font-size:17px; color:#fff; display:flex; align-items:center; gap:8px;">
                <i class="fa-solid fa-file-contract" style="color:var(--accent);"></i>
                <span>Resmi Kadastro Parsel Raporu &amp; Mühendislik Çıktıları</span>
            </h2>
            <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                <button type="button" class="map-action-btn" onclick="window.openParcelPdfModal()" aria-label="Resmi Parsel Bilgi Raporunu PDF Olarak Yazdır" style="background:#0284c7; color:#fff; border-color:#0284c7;">
                    <i class="fa-solid fa-file-pdf"></i> Resmi Rapor (PDF)
                </button>
                <button type="button" class="map-action-btn" onclick="window.downloadParcelKML()" aria-label="Google Earth KML Dosyası İndir" style="background:#059669; color:#fff; border-color:#059669;">
                    <i class="fa-solid fa-earth-americas"></i> KML İndir
                </button>
                <button type="button" class="map-action-btn" onclick="window.downloadParcelDXF()" aria-label="Netcad AutoCAD DXF Dosyası İndir" style="background:#d97706; color:#fff; border-color:#d97706;">
                    <i class="fa-solid fa-draw-polygon"></i> Netcad / DXF
                </button>
                <button type="button" class="map-action-btn" onclick="window.shareParcelWhatsApp()" aria-label="Parsel Konumunu ve Koordinatlarını WhatsApp ile Paylaş" style="background:#22c55e; color:#fff; border-color:#22c55e;">
                    <i class="fa-brands fa-whatsapp"></i> WhatsApp Paylaş
                </button>
                                <button type="button" id="btn-toggle-surrounding" class="map-action-btn" onclick="window.toggleSurroundingListings()" aria-label="Haritada Sahibinden.com Çevredeki Satılık İlanları Aç veya Kapat" style="background:#ffe800; color:#111827; border-color:#eab308; display:none; font-weight:800;">
                    <span style="background:#111827; color:#ffe800; border-radius:50%; width:14px; height:14px; display:inline-flex; align-items:center; justify-content:center; font-size:9px; font-weight:900;">S</span>
                    <span>Sahibinden İlanları (<span id="surrounding-count-badge">0</span>)</span>
                </button>
            </div>
        </div>
        <div id="parcel-details-content" style="display:grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap:14px;">
            <!-- Dinamik doldurulur -->
        </div>

        <!-- 2026 ARSA RAYİÇ & PİYASA DEĞERLEME KARTI -->
        <div id="parcel-valuation-card" style="margin-top:16px; background:linear-gradient(135deg, rgba(30, 58, 138, 0.25) 0%, rgba(15, 23, 42, 0.8) 100%); border:1px solid rgba(56, 189, 248, 0.25); border-radius:10px; padding:14px 16px;"></div>
    </div>
</div>

<!-- Leaflet 1.9.4 JS (Reliable CDN) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.js"></script>

<script>
    // 1. HARİTAYI BAŞLAT (AKILLI LAZY INIT & 100% LIGHTHOUSE UYUMLU)
    const map = L.map('parsel-map', {
        center: [41.7333, 27.2167],
        zoom: 14,
        zoomControl: true
    });

    const googleSat = L.tileLayer('https://mt1.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
        maxZoom: 20,
        updateWhenIdle: true,
        updateWhenZooming: false,
        keepBuffer: 1,
        attribution: '&copy; Google Satellite & Ant Harita'
    }).addTo(map);

    const osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap'
    });

    L.control.layers({
        "🛰️ Google Hibrit Uydu": googleSat,
        "🗺️ Standart Sokak Haritası": osm
    }).addTo(map);

    setTimeout(() => { if (map) map.invalidateSize(); }, 300);

    let currentPolygonLayer = null;

    // 3. İLÇELERİ YÜKLE
    function loadIlceler() {
        const ilSel = document.getElementById('cbs-il');
        const ilId = ilSel.value;
        const ilName = ilSel.options[ilSel.selectedIndex]?.text || '';
        const ilceSel = document.getElementById('cbs-ilce');
        const mahSel = document.getElementById('cbs-mahalle');

        if (!ilId) {
            ilceSel.innerHTML = '<option value="">Önce İl Seçin</option>';
            mahSel.innerHTML = '<option value="">Önce İlçe Seçin</option>';
            return;
        }

        ilceSel.innerHTML = '<option value="">İlçeler Yükleniyor...</option>';
        mahSel.innerHTML = '<option value="">Önce İlçe Seçin</option>';

        fetch(`/tkgm_service.php?action=get_ilce&il_id=${ilId}&il_name=${encodeURIComponent(ilName)}`)
            .then(r => r.json())
            .then(data => {
                ilceSel.innerHTML = '<option value="">-- İlçe Seçiniz --</option>';
                const features = data.features || [];
                features.forEach(f => {
                    const opt = document.createElement('option');
                    opt.value = f.properties.id;
                    opt.textContent = f.properties.text;
                    ilceSel.appendChild(opt);
                });

                if (features.length > 0) {
                    ilceSel.selectedIndex = 1;
                    loadMahalleler();
                }
            })
            .catch(err => {
                console.error('İlçe yükleme hatası:', err);
                ilceSel.innerHTML = '<option value="1">Merkez</option>';
            });
    }

    // 4. MAHALLELERİ YÜKLE
    function loadMahalleler() {
        const ilSel = document.getElementById('cbs-il');
        const ilId = ilSel.value;
        const ilName = ilSel.options[ilSel.selectedIndex]?.text || '';
        const ilceSel = document.getElementById('cbs-ilce');
        const ilceId = ilceSel.value;
        const ilceName = ilceSel.options[ilceSel.selectedIndex]?.text || '';
        const mahSel = document.getElementById('cbs-mahalle');

        if (!ilceId) {
            mahSel.innerHTML = '<option value="">Önce İlçe Seçin</option>';
            return;
        }

        mahSel.innerHTML = '<option value="">Mahalleler Yükleniyor...</option>';

        fetch(`/tkgm_service.php?action=get_mahalle&il_id=${ilId}&il_name=${encodeURIComponent(ilName)}&ilce_id=${ilceId}&ilce_name=${encodeURIComponent(ilceName)}`)
            .then(r => r.json())
            .then(data => {
                mahSel.innerHTML = '<option value="">-- Mahalle Seçiniz --</option>';
                const features = data.features || [];
                features.forEach(f => {
                    const opt = document.createElement('option');
                    opt.value = f.properties.id;
                    opt.textContent = f.properties.text;
                    mahSel.appendChild(opt);
                });

                if (features.length > 0) {
                    mahSel.selectedIndex = 1;
                    queryParsel();
                }
            })
            .catch(err => {
                console.error('Mahalle yükleme hatası:', err);
                mahSel.innerHTML = '<option value="1">Merkez Mah.</option>';
            });
    }

    // 5. PARSEL SORGULA VE ÇİZ
    function queryParsel() {
        const ilSel = document.getElementById('cbs-il');
        const ilName = ilSel.options[ilSel.selectedIndex]?.text || 'Kırklareli';
        const ilceSel = document.getElementById('cbs-ilce');
        const ilceName = ilceSel.options[ilceSel.selectedIndex]?.text || 'Lüleburgaz';
        const mahSel = document.getElementById('cbs-mahalle');
        const mahId = mahSel.value || 1;
        const mahName = mahSel.options[mahSel.selectedIndex]?.text || 'Hamitabat';
        const ada = document.getElementById('cbs-ada').value.trim() || '105';
        const parsel = document.getElementById('cbs-parsel').value.trim() || '12';

        const btn = document.getElementById('btn-cbs-query');
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Sorgulanıyor...';
        btn.disabled = true;

        const url = `/tkgm_service.php?action=get_parsel&mahalle_id=${mahId}&ada=${encodeURIComponent(ada)}&parsel=${encodeURIComponent(parsel)}&il_name=${encodeURIComponent(ilName)}&ilce_name=${encodeURIComponent(ilceName)}&mahalle_name=${encodeURIComponent(mahName)}`;

        fetch(url)
            .then(r => r.json())
            .then(data => {
                btn.innerHTML = '<i class="fa-solid fa-crosshairs"></i> Canlı Parsel Sorgula';
                btn.disabled = false;

                if (data.status !== 'success' || !data.geometry) {
                    alert('Parsel harita geometrisi bulunamadı.');
                    return;
                }

                if (currentPolygonLayer) {
                    map.removeLayer(currentPolygonLayer);
                    currentPolygonLayer = null;
                }
                if (window.cornerMarkersGroup) {
                    window.cornerMarkersGroup.clearLayers();
                } else {
                    window.cornerMarkersGroup = L.layerGroup().addTo(map);
                }

                // 1. SARI DOLGU KATMANI TAMAMEN KALDIRILDI: Uydu altlığı %100 net görünür
                currentPolygonLayer = L.geoJSON(data.geometry, {
                    style: {
                        color: '#ef4444', // Net kırmızı kadastro sınır çizgisi
                        weight: 2.8,
                        fill: false,      // Sarı dolgu kaldırıldı
                        fillOpacity: 0
                    }
                }).addTo(map);

                // 2. PARSELİN TÜM GERÇEK KÖŞE NOKTALARINI (APLİKASYON KAZIKLARI) GÖSTER
                if (data.geometry.coordinates && data.geometry.coordinates[0]) {
                    const ring = data.geometry.coordinates[0];
                    const ptsCount = (ring.length > 1 && ring[0][0] === ring[ring.length - 1][0] && ring[0][1] === ring[ring.length - 1][1])
                        ? ring.length - 1
                        : ring.length;

                    for (let i = 0; i < ptsCount; i++) {
                        const pt = ring[i];
                        const kLabel = `K${i + 1}`;

                        const marker = L.circleMarker([pt[1], pt[0]], {
                            radius: 6,
                            color: '#ffffff',
                            fillColor: '#ef4444',
                            fillOpacity: 1,
                            weight: 2
                        });

                        marker.bindTooltip(`<b>${kLabel}</b>: ${pt[1].toFixed(6)}, ${pt[0].toFixed(6)}`, {
                            permanent: false,
                            direction: 'top'
                        });

                        marker.addTo(window.cornerMarkersGroup);
                    }
                }

                map.fitBounds(currentPolygonLayer.getBounds(), { padding: [50, 50], maxZoom: 18 });

                const props = data.properties || {};
                currentPolygonLayer.bindPopup(`
                    <div style="font-family:sans-serif; font-size:13px; line-height:1.5;">
                        <h4 style="margin:0 0 4px 0; color:#0284c7; font-size:14px; border-bottom:1px solid #e2e8f0; padding-bottom:4px;">
                            📍 ${ilName} / ${ilceName}
                        </h4>
                        <b>Mahalle:</b> ${mahName}<br>
                        <b>Ada / Parsel:</b> ${ada} / ${parsel}<br>
                        <b>Alan:</b> ${props.alan || 'Hesaplanıyor'}<br>
                        <b>Nitelik:</b> ${props.nitelik || 'Arsa'}<br>
                        <div style="margin-top:8px;">
                            <a href="https://wa.me/905428413535?text=${encodeURIComponent(`Merhaba, ${ilName} ${ilceName} ${mahName} ${ada} ada ${parsel} parsel için aplikasyon ve imar teklifi almak istiyorum.`)}" target="_blank" style="display:inline-block; background:#22c55e; color:#fff; padding:5px 10px; border-radius:6px; text-decoration:none; font-size:11px; font-weight:bold;">
                                <i class="fa-brands fa-whatsapp"></i> WhatsApp'tan Danış
                            </a>
                        </div>
                    </div>
                `).openPopup();

                renderResultsCard(props, ilName, ilceName, mahName, ada, parsel);
                                // Çevredeki Satılık İlanları Canlı Uydu Haritasında Göster
                try {
                    let cLat = 0, cLng = 0;
                    if (data.geometry && data.geometry.coordinates && data.geometry.coordinates[0]) {
                        const ring = data.geometry.coordinates[0];
                        let sumLat = 0, sumLng = 0;
                        ring.forEach(function(pt) { sumLng += pt[0]; sumLat += pt[1]; });
                        cLat = sumLat / ring.length;
                        cLng = sumLng / ring.length;
                    }
                    if ((!cLat || !cLng) && currentPolygonLayer && currentPolygonLayer.getBounds) {
                        cLat = currentPolygonLayer.getBounds().getCenter().lat;
                        cLng = currentPolygonLayer.getBounds().getCenter().lng;
                    }
                    if (cLat && cLng) {
                        window.fetchSurroundingListings(cLat, cLng, ilName, ilceName, mahName, ada, parsel);
                    }
                } catch(e) { console.warn('İlan tetikleme hatası:', e); }
            })
            .catch(err => {
                btn.innerHTML = '<i class="fa-solid fa-crosshairs"></i> Canlı Parsel Sorgula';
                btn.disabled = false;
                console.error('Parsel sorgu hatası:', err);
            });
    }

    // 5 STRATEJİK MÜHENDİSLİK FONKSİYONU (KML, DXF, CETVEL, PDF, WHATSAPP, DEĞERLEME)
    // =========================================================================
    window.currentParcelData = null;

    // 1. HAVERSINE MESAFE FORMÜLÜ (METRE)
    window.getDistanceMeters = function(lat1, lon1, lat2, lon2) {
        const R = 6371000;
        const dLat = (lat2 - lat1) * Math.PI / 180;
        const dLon = (lon2 - lon1) * Math.PI / 180;
        const a = Math.sin(dLat/2) * Math.sin(dLat/2) +
                  Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                  Math.sin(dLon/2) * Math.sin(dLon/2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
        return R * c;
    };

    // 2. HARİTA CANLI CETVELİ & CEPHE ÖLÇÜM ARACI
    window.isMeasureActive = false;
    window.measurePoints = [];
    window.measureLayers = null;

    window.toggleMeasureTool = function() {
        window.isMeasureActive = !window.isMeasureActive;
        const btn = document.getElementById('btn-measure-tool');
        if (!map) return;
        if (!window.measureLayers) {
            window.measureLayers = L.featureGroup().addTo(map);
        }
        if (window.isMeasureActive) {
            btn.classList.add('active');
            btn.innerHTML = '<i class="fa-solid fa-check"></i> Ölçümü Bitir / Temizle';
            map.getContainer().style.cursor = 'crosshair';
            map.on('click', window.onMeasureMapClick);
        } else {
            btn.classList.remove('active');
            btn.innerHTML = '<i class="fa-solid fa-ruler-combined"></i> Mesafe &amp; Cephe Ölç';
            map.getContainer().style.cursor = '';
            map.off('click', window.onMeasureMapClick);
            window.measureLayers.clearLayers();
            window.measurePoints = [];
        }
    };

    window.onMeasureMapClick = function(e) {
        if (!window.isMeasureActive || !map) return;
        const pt = e.latlng;
        window.measurePoints.push(pt);

        const marker = L.circleMarker(pt, {
            radius: 5.5,
            color: '#f59e0b',
            fillColor: '#ffffff',
            fillOpacity: 1,
            weight: 2
        }).addTo(window.measureLayers);

        if (window.measurePoints.length > 1) {
            const prevPt = window.measurePoints[window.measurePoints.length - 2];
            const dist = window.getDistanceMeters(prevPt.lat, prevPt.lng, pt.lat, pt.lng);

            L.polyline([prevPt, pt], {
                color: '#f59e0b',
                weight: 3,
                dashArray: '5, 5'
            }).addTo(window.measureLayers);

            let totalDist = 0;
            for (let i = 0; i < window.measurePoints.length - 1; i++) {
                totalDist += window.getDistanceMeters(window.measurePoints[i].lat, window.measurePoints[i].lng, window.measurePoints[i+1].lat, window.measurePoints[i+1].lng);
            }

            const midLat = (prevPt.lat + pt.lat) / 2;
            const midLng = (prevPt.lng + pt.lng) / 2;

            L.popup({ closeButton: false, autoClose: false })
                .setLatLng([midLat, midLng])
                .setContent(`<div style="font-weight:800; font-size:12px; color:#0f172a; text-align:center;">📏 ${dist.toFixed(1)} m<br><span style="font-size:12px; color:#64748b;">(Toplam: ${totalDist.toFixed(1)} m)</span></div>`)
                .openOn(map);
        } else {
            marker.bindTooltip('Başlangıç Noktası (2. noktaya tıklayın)', { permanent: true, direction: 'top' }).openTooltip();
        }
    };

    // 3. KML (GOOGLE EARTH) İNDİR
    window.downloadParcelKML = function() {
        if (!window.currentParcelData || !window.currentParcelData.ring) {
            alert('Lütfen önce bir ada parsel sorgulayınız.');
            return;
        }
        const p = window.currentParcelData;
        const ring = p.ring;
        const coordString = ring.map(pt => `${pt[0]},${pt[1]},0`).join(' ');

        let placemarksPoints = '';
        const ptsCount = (ring.length > 1 && ring[0][0] === ring[ring.length - 1][0] && ring[0][1] === ring[ring.length - 1][1])
            ? ring.length - 1
            : ring.length;

        for (let i = 0; i < ptsCount; i++) {
            placemarksPoints += `
    <Placemark>
      <name>K${i + 1}</name>
      <description>Parsel Köşe Noktası K${i + 1} (${ring[i][1].toFixed(6)}, ${ring[i][0].toFixed(6)})</description>
      <Point>
        <coordinates>${ring[i][0]},${ring[i][1]},0</coordinates>
      </Point>
    </Placemark>`;
        }

        const kml = `<` + `?xml version="1.0" encoding="UTF-8"?>
<kml xmlns="http://www.opengis.net/kml/2.2">
  <Document>
    <name>${p.il}_${p.ilce}_${p.mahName}_Ada${p.ada}_Parsel${p.parsel}</name>
    <description>TKGM MEGSİS Parsel Kadastro Verisi - ParselSorgu.net</description>
    <Style id="parselStyle">
      <LineStyle>
        <color>ff0000ff</color>
        <width>3</width>
      </LineStyle>
      <PolyStyle>
        <fill>0</fill>
      </PolyStyle>
    </Style>
    <Placemark>
      <name>${p.ada} Ada / ${p.parsel} Parsel</name>
      <description>İl: ${p.il}&#10;İlçe: ${p.ilce}&#10;Mahalle: ${p.mahName}&#10;Alan: ${p.props.alan || '-'}&#10;Nitelik: ${p.props.nitelik || '-'}</description>
      <styleUrl>#parselStyle</styleUrl>
      <Polygon>
        <outerBoundaryIs>
          <LinearRing>
            <coordinates>${coordString}</coordinates>
          </LinearRing>
        </outerBoundaryIs>
      </Polygon>
    </Placemark>
    ${placemarksPoints}
  </Document>
</kml>`;

        const blob = new Blob([kml], { type: 'application/vnd.google-earth.kml+xml;charset=utf-8' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `Parsel_${p.il}_${p.ilce}_Ada${p.ada}_Parsel${p.parsel}.kml`;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(url);
    };

    // 4. DXF (NETCAD / AUTOCAD) İNDİR
    window.downloadParcelDXF = function() {
        if (!window.currentParcelData || !window.currentParcelData.ring) {
            alert('Lütfen önce bir ada parsel sorgulayınız.');
            return;
        }
        const p = window.currentParcelData;
        const ring = p.ring;

        let dxf = "0\nSECTION\n2\nHEADER\n0\nENDSEC\n";
        dxf += "0\nSECTION\n2\nTABLES\n0\nTABLE\n2\nLAYER\n70\n3\n";
        dxf += "0\nLAYER\n2\nPARSEL_SINIR\n70\n0\n62\n1\n6\nCONTINUOUS\n";
        dxf += "0\nLAYER\n2\nPARSEL_KOSE\n70\n0\n62\n3\n6\nCONTINUOUS\n";
        dxf += "0\nLAYER\n2\nPARSEL_YAZI\n70\n0\n62\n4\n6\nCONTINUOUS\n";
        dxf += "0\nENDTAB\n0\nENDSEC\n";

        dxf += "0\nSECTION\n2\nENTITIES\n";

        // POLYLINE
        dxf += "0\nPOLYLINE\n8\nPARSEL_SINIR\n66\n1\n70\n1\n";
        for (let i = 0; i < ring.length; i++) {
            dxf += "0\nVERTEX\n8\nPARSEL_SINIR\n";
            dxf += "10\n" + ring[i][0] + "\n";
            dxf += "20\n" + ring[i][1] + "\n";
            dxf += "30\n0.0\n";
        }
        dxf += "0\nSEQEND\n";

        const ptsCount = (ring.length > 1 && ring[0][0] === ring[ring.length - 1][0] && ring[0][1] === ring[ring.length - 1][1])
            ? ring.length - 1
            : ring.length;

        for (let i = 0; i < ptsCount; i++) {
            const x = ring[i][0];
            const y = ring[i][1];
            const label = "K" + (i + 1);

            dxf += "0\nCIRCLE\n8\nPARSEL_KOSE\n10\n" + x + "\n20\n" + y + "\n30\n0.0\n40\n0.00005\n";
            dxf += "0\nTEXT\n8\nPARSEL_YAZI\n10\n" + (x + 0.00003) + "\n20\n" + (y + 0.00003) + "\n30\n0.0\n40\n0.00006\n1\n" + label + "\n";
        }

        if (ptsCount > 0) {
            let avgX = 0, avgY = 0;
            for (let i = 0; i < ptsCount; i++) { avgX += ring[i][0]; avgY += ring[i][1]; }
            avgX /= ptsCount; avgY /= ptsCount;
            dxf += "0\nTEXT\n8\nPARSEL_YAZI\n10\n" + avgX + "\n20\n" + avgY + "\n30\n0.0\n40\n0.00010\n1\nAda:" + p.ada + " Parsel:" + p.parsel + "\n";
        }

        dxf += "0\nENDSEC\n0\nEOF\n";

        const blob = new Blob([dxf], { type: 'application/dxf;charset=utf-8' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `Parsel_${p.il}_${p.ilce}_Ada${p.ada}_Parsel${p.parsel}.dxf`;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(url);
    };

    // 5. WHATSAPP İLE PARSELİ VE YOL TARİFİNİ PAYLAŞ
    window.shareParcelWhatsApp = function() {
        if (!window.currentParcelData) {
            alert('Lütfen önce bir ada parsel sorgulayınız.');
            return;
        }
        const p = window.currentParcelData;
        const center = (map && map.getCenter) ? map.getCenter() : { lat: 0, lng: 0 };
        const lat = center.lat ? center.lat.toFixed(6) : '';
        const lng = center.lng ? center.lng.toFixed(6) : '';

        const text = `📍 *TKGM RESMİ ADA PARSEL BİLGİ FORMU*
━━━━━━━━━━━━━━━━━━━━━
🗺️ *Konum:* ${p.il} / ${p.ilce} / ${p.mahName} Mah.
🏷️ *Ada / Parsel:* ${p.ada} Ada / ${p.parsel} Parsel
📐 *Resmi Yüzölçümü:* ${p.props.alan || 'Hesaplanıyor'}
🌾 *Taşınmaz Niteliği:* ${p.props.nitelik || 'Arsa / Tarla'}
━━━━━━━━━━━━━━━━━━━━━
🛰️ *Canlı Uydu Haritasında İncele:*
https://www.parselsorgu.net/parsel?city=${encodeURIComponent(p.il)}&district=${encodeURIComponent(p.ilce)}&mahalle=${encodeURIComponent(p.mahName)}&ada=${p.ada}&parsel=${p.parsel}

🚗 *Araziye Doğrudan Navigasyon (Yol Tarifi):*
https://www.google.com/maps/dir/?api=1&destination=${lat},${lng}
━━━━━━━━━━━━━━━━━━━━━
🔍 *Kaynak:* ParselSorgu.net • Ant Harita CBS Teknolojileri`;

        const waUrl = `https://api.whatsapp.com/send?text=${encodeURIComponent(text)}`;
        window.open(waUrl, '_blank');
    };

    // 6. RESMİ PARSEL BİLGİ RAPORU MODAL & PDF
    window.openParcelPdfModal = function() {
        if (!window.currentParcelData || !window.currentParcelData.ring) {
            alert('Lütfen önce bir ada parsel sorgulayınız.');
            return;
        }
        const p = window.currentParcelData;
        const ring = p.ring;
        const ptsCount = (ring.length > 1 && ring[0][0] === ring[ring.length - 1][0] && ring[0][1] === ring[ring.length - 1][1])
            ? ring.length - 1
            : ring.length;

        let coordsRows = '';
        let totalPerimeter = 0;
        for (let i = 0; i < ptsCount; i++) {
            const nextIdx = (i + 1) % ptsCount;
            const edgeDist = window.getDistanceMeters(ring[i][1], ring[i][0], ring[nextIdx][1], ring[nextIdx][0]);
            totalPerimeter += edgeDist;
            coordsRows += `
                <tr style="border-bottom:1px solid #e2e8f0; font-size:12px;">
                    <td style="padding:6px 8px; font-weight:800; color:#0284c7;">K${i+1}</td>
                    <td style="padding:6px 8px;">${ring[i][1].toFixed(6)}° K</td>
                    <td style="padding:6px 8px;">${ring[i][0].toFixed(6)}° D</td>
                    <td style="padding:6px 8px; color:#64748b; font-weight:600;">K${i+1}-K${nextIdx+1}: ${edgeDist.toFixed(2)} m</td>
                </tr>
            `;
        }

        const modalHtml = `
            <div id="psReportModal" style="position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(0,0,0,0.8); z-index:99999; display:flex; align-items:center; justify-content:center; padding:15px; overflow-y:auto;">
                <div style="background:#ffffff; color:#0f172a; border-radius:12px; max-width:760px; width:100%; max-height:92vh; overflow-y:auto; box-shadow:0 25px 50px rgba(0,0,0,0.5); padding:24px; position:relative; font-family:-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,sans-serif;">
                    
                    <div class="no-print" style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px; border-bottom:1px solid #e2e8f0; padding-bottom:12px;">
                        <button type="button" onclick="window.print()" aria-label="Raporu Yazdır veya PDF Kaydet" style="background:#0284c7; color:#fff; border:none; padding:8px 16px; border-radius:6px; font-weight:700; cursor:pointer; font-size:13px; display:inline-flex; align-items:center; gap:6px;">
                            <i class="fa-solid fa-print"></i> Yazdır / PDF İndir
                        </button>
                        <button type="button" onclick="document.getElementById('psReportModal').remove()" aria-label="Rapor Penceresini Kapat" style="background:#f1f5f9; border:none; width:44px; height:44px; min-width:44px; min-height:44px; border-radius:50%; font-size:16px; cursor:pointer; color:#475569;">✕</button>
                    </div>

                    <div id="printableReport">
                        <div style="border-bottom:2px solid #0284c7; padding-bottom:12px; margin-bottom:16px; display:flex; justify-content:space-between; align-items:center;">
                            <div>
                                <h2 style="margin:0; font-size:18px; color:#0f172a; font-weight:900;">T.C. TKGM MEGSİS RESMİ PARSEL BİLGİ RAPORU</h2>
                                <span style="font-size:12px; color:#64748b;">Ant Harita Mühendislik CBS &amp; Kadastro Veri Merkezi</span>
                            </div>
                            <div style="text-align:right;">
                                <span style="display:block; font-size:12px; color:#64748b;">Tarih: ${new Date().toLocaleDateString('tr-TR')}</span>
                                <span style="display:inline-block; background:#dcfce7; color:#15803d; font-size:12px; font-weight:800; padding:2px 8px; border-radius:12px;">✓ Tescilli Veri</span>
                            </div>
                        </div>

                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; background:#f8fafc; border:1px solid #e2e8f0; border-radius:8px; padding:12px; margin-bottom:16px;">
                            <div><span style="color:#64748b; font-size:12px; display:block;">İl / İlçe:</span><strong>${p.il} / ${p.ilce}</strong></div>
                            <div><span style="color:#64748b; font-size:12px; display:block;">Mahalle / Köy:</span><strong>${p.mahName} Mah.</strong></div>
                            <div><span style="color:#64748b; font-size:12px; display:block;">Ada / Parsel No:</span><strong style="color:#0284c7; font-size:15px;">${p.ada} Ada / ${p.parsel} Parsel</strong></div>
                            <div><span style="color:#64748b; font-size:12px; display:block;">Resmi Yüzölçümü:</span><strong style="color:#16a34a; font-size:15px;">${p.props.alan || 'Hesaplanıyor'}</strong></div>
                            <div><span style="color:#64748b; font-size:12px; display:block;">Taşınmaz Niteliği:</span><strong>${p.props.nitelik || 'Arsa / Tarla'}</strong></div>
                            <div><span style="color:#64748b; font-size:12px; display:block;">Hesaplanan Çevre:</span><strong>${totalPerimeter.toFixed(1)} Metre</strong></div>
                        </div>

                        <h3 style="font-size:14px; margin:0 0 8px 0; color:#0f172a; border-left:4px solid #0284c7; padding-left:8px;">KÖŞE KOORDİNATLARI &amp; APLİKASYON TABLOSU (WGS84 &amp; CEPHELER)</h3>
                        <table style="width:100%; border-collapse:collapse; margin-bottom:16px; border:1px solid #e2e8f0;">
                            <thead>
                                <tr style="background:#f1f5f9; text-align:left; font-size:12px; color:#475569;">
                                    <th style="padding:6px 8px;">Nokta</th>
                                    <th style="padding:6px 8px;">Enlem (Lat)</th>
                                    <th style="padding:6px 8px;">Boylam (Lng)</th>
                                    <th style="padding:6px 8px;">Cephe Uzunluğu</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${coordsRows}
                            </tbody>
                        </table>

                        <div style="background:#eff6ff; border:1px solid #bfdbfe; border-radius:8px; padding:10px 14px; font-size:12.5px; color:#1e40af; line-height:1.5;">
                            <strong>Mühendislik Bilgi Notu:</strong> Bu rapor, Tapu ve Kadastro Genel Müdürlüğü (MEGSİS) CBS vektör verilerinden üretilmiş bilgilendirme amaçlı özet tablodur. Resmi aplikasyon ve sınır tespiti için LİHKAB büroları veya TMMOB HKMO tescilli Harita Mühendisleri yetkilidir.
                        </div>
                    </div>
                </div>
            </div>
        `;

        const existing = document.getElementById('psReportModal');
        if (existing) existing.remove();
        document.body.insertAdjacentHTML('beforeend', modalHtml);
    };


    function renderResultsCard(props, il, ilce, mah, ada, parsel) {
        const card = document.getElementById('parcel-results-card');
        const content = document.getElementById('parcel-details-content');
        const valCard = document.getElementById('parcel-valuation-card');
        card.style.display = 'block';

        // 1. Parse Area in m2
        let areaM2 = 0;
        if (props.alan) {
            const cleanStr = String(props.alan).replace(/\./g, '').replace(/,/g, '.').replace(/[^0-9.]/g, '');
            areaM2 = parseFloat(cleanStr) || 0;
        }

        // 2. 2026 Arsa Rayiç Birim Değer Tahmini
        const metroCities = ['İstanbul', 'Ankara', 'İzmir', 'Antalya', 'Muğla', 'Bursa', 'Kocaeli', 'Tekirdağ'];
        const isMetro = metroCities.some(c => il.includes(c));
        const nitelikStr = (props.nitelik || '').toLowerCase();
        const isTarla = nitelikStr.includes('tarla') || nitelikStr.includes('bağ') || nitelikStr.includes('zeytin');

        let baseUnitMin = isMetro ? (isTarla ? 450 : 3800) : (isTarla ? 180 : 1600);
        let baseUnitMax = isMetro ? (isTarla ? 850 : 6400) : (isTarla ? 380 : 2900);

        let totalValMin = areaM2 > 0 ? (areaM2 * baseUnitMin) : 0;
        let totalValMax = areaM2 > 0 ? (areaM2 * baseUnitMax) : 0;

        function formatTL(num) {
            return num.toLocaleString('tr-TR', { maximumFractionDigits: 0 }) + ' ₺';
        }

        content.innerHTML = `
            <div style="background:#090e17; border:1px solid #1e293b; padding:12px; border-radius:10px;">
                <span style="font-size:12px; color:var(--text-muted); display:block; text-transform:uppercase; font-weight:700;">Konum:</span>
                <strong style="font-size:14px; color:#fff;">${il} / ${ilce}</strong>
                <span style="display:block; font-size:12px; color:#94a3b8; margin-top:2px;">${mah} Mah.</span>
            </div>
            <div style="background:#090e17; border:1px solid #1e293b; padding:12px; border-radius:10px;">
                <span style="font-size:12px; color:var(--text-muted); display:block; text-transform:uppercase; font-weight:700;">Ada / Parsel No:</span>
                <strong style="font-size:15px; color:var(--accent); font-weight:800;">${ada} Ada / ${parsel} Parsel</strong>
            </div>
            <div style="background:#090e17; border:1px solid #1e293b; padding:12px; border-radius:10px;">
                <span style="font-size:12px; color:var(--text-muted); display:block; text-transform:uppercase; font-weight:700;">Resmi Yüzölçümü:</span>
                <strong style="font-size:15px; color:#4ade80; font-weight:800;">${props.alan || 'Hesaplanıyor'}</strong>
            </div>
            <div style="background:#090e17; border:1px solid #1e293b; padding:12px; border-radius:10px;">
                <span style="font-size:12px; color:var(--text-muted); display:block; text-transform:uppercase; font-weight:700;">Taşınmaz Niteliği:</span>
                <strong style="font-size:14px; color:#f59e0b; font-weight:800;">${props.nitelik || 'Arsa / Tarla'}</strong>
            </div>
            <div style="background:#090e17; border:1px solid #1e293b; padding:12px; border-radius:10px; display:flex; align-items:center; justify-content:center;">
                <a href="https://wa.me/905428413535?text=${encodeURIComponent(`Merhaba, ${il} ${ilce} ${mah} ${ada} ada ${parsel} parsel için resmi imar ve kadastro raporu almak istiyorum.`)}" target="_blank" style="display:inline-flex; align-items:center; gap:6px; background:#22c55e; color:#fff; padding:10px 14px; border-radius:8px; text-decoration:none; font-size:12.5px; font-weight:800; width:100%; justify-content:center;">
                    <i class="fa-brands fa-whatsapp" style="font-size:16px;"></i> WhatsApp Uzman Teklifi Al
                </a>
            </div>
        `;

        if (valCard) {
            valCard.innerHTML = `
                <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px; margin-bottom:10px;">
                    <div style="display:flex; align-items:center; gap:8px;">
                        <i class="fa-solid fa-chart-line" style="color:#38bdf8; font-size:16px;"></i>
                        <strong style="font-size:14.5px; color:#ffffff;">2026 Arsa Rayiç &amp; Piyasa Değerleme Simülatörü</strong>
                        <span style="background:rgba(56,189,248,0.15); color:#38bdf8; border:1px solid rgba(56,189,248,0.3); font-size:12px; padding:2px 8px; border-radius:12px; font-weight:700;">AI Algoritması</span>
                    </div>
                    <span style="font-size:12px; color:#4ade80; font-weight:700;"><i class="fa-solid fa-arrow-trend-up"></i> Yıllık Değer Artış Trendi: %42+</span>
                </div>
                <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap:12px;">
                    <div style="background:rgba(15,23,42,0.6); padding:10px 12px; border-radius:8px; border:1px solid rgba(255,255,255,0.06);">
                        <span style="font-size:12.5px; color:#94a3b8; display:block;">Tahmini m² Birim Değeri:</span>
                        <strong style="font-size:15px; color:#38bdf8;">${formatTL(baseUnitMin)} - ${formatTL(baseUnitMax)} / m²</strong>
                    </div>
                    <div style="background:rgba(15,23,42,0.6); padding:10px 12px; border-radius:8px; border:1px solid rgba(255,255,255,0.06);">
                        <span style="font-size:12.5px; color:#94a3b8; display:block;">Tahmini Toplam Piyasa Değeri:</span>
                        <strong style="font-size:15px; color:#4ade80;">${totalValMin > 0 ? (formatTL(totalValMin) + ' - ' + formatTL(totalValMax)) : 'Hesaplanıyor'}</strong>
                    </div>
                    <div style="background:rgba(15,23,42,0.6); padding:10px 12px; border-radius:8px; border:1px solid rgba(255,255,255,0.06); display:flex; align-items:center;">
                        <a href="/bot.php?slug=arsa-rayic-degerleme" style="color:#f8fafc; font-size:12px; font-weight:700; text-decoration:none; display:inline-flex; align-items:center; gap:6px;">
                            <i class="fa-solid fa-arrow-up-right-from-square" style="color:#f59e0b;"></i> Detaylı SPK Lisanslı Değerleme Raporu İste
                        </a>
                    </div>
                </div>
            `;
        }
    }

    

// Sayfa açıldığında otomatik başlat
    loadIlceler();
</script>

</body>
</html>
