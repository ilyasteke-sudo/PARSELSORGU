<?php
/**
 * ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ - PARSEL PRO
 * Köy Yerleşik Alanı Sınırı & İmar Uygunluk Test Motoru (Plansız Alanlar Madde 43)
 * URL: /koy-yerlesik-alani-sorgulama
 */
declare(strict_types=1);

require_once __DIR__ . '/navbar.php';

$il = htmlspecialchars(trim($_GET['il'] ?? 'Kırklareli'));
$ilce = htmlspecialchars(trim($_GET['ilce'] ?? 'Lüleburgaz'));
$koy = htmlspecialchars(trim($_GET['koy'] ?? 'Hamitabat'));
$mesafe = (int)($_GET['mesafe'] ?? 240); // metre
$alan = (int)($_GET['alan'] ?? 1800); // m²

$is_koy_ici = ($mesafe <= 300);
$is_civar = ($mesafe > 300 && $mesafe <= 500);
$is_koy_disi = ($mesafe > 500);

if ($is_koy_ici) {
    $durum_baslik = "KÖY YERLEŞİK ALANI İÇİNDE (%40 İMARLI)";
    $durum_renk = "#10b981";
    $durum_aciklama = "Parseliniz köy yerleşik alanı sınırı (300 metre bandı) içerisinde kalmaktadır. 5403 sayılı kanundaki 5.000 m² şartına tabi olmadan, %40 taban oturumu ile azami 2 katlı köy evi, villa veya prefabrik konut inşa edebilirsiniz.";
    $taks_m2 = round($alan * 0.40);
    $maks_insaat_m2 = min(250, $taks_m2 * 2);
} elseif ($is_civar) {
    $durum_baslik = "KÖY YERLEŞİK ALANI CİVARI (ÖZEL İNCELEME GEREKLİ)";
    $durum_renk = "#f59e0b";
    $durum_aciklama = "Parseliniz köy sınırının 300 - 500 metre civar bandında yer almaktadır. İl Özel İdaresi imar planı kararına göre köy yerleşik alanına dahil edilmiş olabilir. Resmi kadastro tespiti önerilir.";
    $taks_m2 = round($alan * 0.20);
    $maks_insaat_m2 = 150;
} else {
    $durum_baslik = "KÖY DIŞI SAF TARIM ARAZİSİ (5.000 m² VE YOL KURALI)";
    $durum_renk = "#ef4444";
    $durum_aciklama = "Parseliniz köy yerleşik alanı dışındadır. Plansız alanlar ve 5403 sayılı Kanun gereği konut yapılabilmesi için parselin en az 5.000 m² olması ve resmi kadastral yola en az 25 metre cephesi bulunması zorunludur.";
    $taks_m2 = round($alan * 0.05);
    $maks_insaat_m2 = min(250, round($alan * 0.05));
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $koy ?> Köy Yerleşik Alanı İmar Sorgulama | ParselSorgu</title>
    <meta name="description" content="Tarlanız köy yerleşik alanı içinde mi? Plansız Alanlar İmar Yönetmeliği 300m/500m kuralı ve %40 köy evi yapma izni kontrol motoru.">

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <style>
        :root {
            --bg-dark: #0f172a;
            --card-dark: #1e293b;
            --border-dark: #334155;
            --text-light: #f8fafc;
            --text-muted: #94a3b8;
            --accent-blue: #38bdf8;
            --accent-green: #10b981;
            --accent-gold: #f59e0b;
        }
        body {
            background-color: var(--bg-dark);
            color: var(--text-light);
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            margin:0; padding:0; line-height:1.6;
        }
        .container { max-width: 1150px; margin: 0 auto; padding: 24px 16px; }
        .hero {
            background: linear-gradient(135deg, #1e293b 0%, #0b1329 100%);
            border: 1px solid var(--border-dark);
            border-radius: 16px;
            padding: 30px;
            margin-bottom: 24px;
            text-align: center;
        }
        .hero h1 { font-size: clamp(1.6rem, 3.5vw, 2.3rem); margin: 8px 0; color:#fff; font-weight:900; }
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 24px; }
        @media(max-width: 768px) { .grid-2 { grid-template-columns: 1fr; } }
        .card {
            background: var(--card-dark);
            border: 1px solid var(--border-dark);
            border-radius: 14px;
            padding: 24px;
        }
        .form-control {
            width: 100%;
            padding: 10px 14px;
            background: #0f172a;
            border: 1px solid var(--border-dark);
            border-radius: 8px;
            color: #fff;
            box-sizing: border-box;
            font-size: 0.95rem;
            margin-bottom: 12px;
        }
        .btn-check {
            width: 100%;
            background: var(--accent-green);
            color: #0b1329;
            font-weight: 900;
            padding: 12px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-size: 1rem;
        }
        #map-buffer { width: 100%; height: 360px; border-radius: 10px; border: 1px solid var(--border-dark); }
        .status-box {
            padding: 20px;
            border-radius: 12px;
            border: 2px solid <?= $durum_renk ?>;
            background: rgba(0,0,0,0.3);
            margin-bottom: 20px;
        }
    </style>
    <link rel="alternate" type="text/markdown" href="https://www.parselsorgu.net/llms.txt" title="ParselSorgu AI / LLM Bilgi Bankası">
    <link rel="alternate" type="application/json" href="https://www.parselsorgu.net/api/2026-kadastro-endeks.json" title="2026 Kadastro ve İmar Açık Veri Seti">
    <script type="application/ld+json">{"@context": "https://schema.org", "@type": "WebPage", "speakable": {"@type": "SpeakableSpecification", "cssSelector": ["h1", ".lead", ".summary-box", ".hero-desc", "main p"]}, "isBasedOn": "https://www.parselsorgu.net/api/2026-kadastro-endeks.json", "publisher": {"@type": "Organization", "name": "Ant Harita Mühendislik - ParselSorgu.net", "url": "https://www.parselsorgu.net/"}}</script>
    <meta property="og:image" content="https://www.parselsorgu.net/assets/images/og-parsel.jpg">
</head>
<body>

<?= render_navbar() ?>

<div class="container">
    <div class="hero">
        <span style="background:rgba(56,189,248,0.15); color:var(--accent-blue); padding:4px 14px; border-radius:20px; font-weight:800; font-size:0.85rem; border:1px solid rgba(56,189,248,0.3);">
            <i class="fa-solid fa-tree"></i> PLANSIZ ALANLAR İMAR YÖNETMELİĞİ MADDE 43
        </span>
        <h1><?= $koy ?> Köy Yerleşik Alanı İmar Uygunluk Testi</h1>
        <p style="color:var(--text-muted); max-width:800px; margin:0 auto;">
            Tarlanızın köy yerleşik alanı (300m / 500m) sınırında olup olmadığını harita üzerinden test edin; köy evi yapma izinlerini ve 5403 sayılı Kanun kısıtlarını öğrenin.
        </p>
    </div>

    <!-- Status Box -->
    <div class="status-box">
        <div style="display:flex; align-items:center; gap:12px; margin-bottom:8px;">
            <i class="fa-solid fa-circle-check fa-xl" style="color:<?= $durum_renk ?>;"></i>
            <h2 style="margin:0; font-size:1.3rem; color:<?= $durum_renk ?>; font-weight:900;">
                <?= $durum_baslik ?>
            </h2>
        </div>
        <p style="margin:0; color:var(--text-light); font-size:0.95rem; line-height:1.5;">
            <?= $durum_aciklama ?>
        </p>
    </div>

    <div class="grid-2">
        <!-- Left: Form -->
        <div class="card">
            <h3 style="margin-top:0; color:#fff; font-size:1.15rem;">
                <i class="fa-solid fa-sliders" style="color:var(--accent-blue);"></i> Mesafe ve Parsel Parametreleri
            </h3>

            <form method="GET" action="">
                <label style="font-size:0.85rem; font-weight:700;">İl:</label>
                <input type="text" name="il" class="form-control" value="<?= $il ?>">

                <label style="font-size:0.85rem; font-weight:700;">İlçe:</label>
                <input type="text" name="ilce" class="form-control" value="<?= $ilce ?>">

                <label style="font-size:0.85rem; font-weight:700;">Köy / Mahalle:</label>
                <input type="text" name="koy" class="form-control" value="<?= $koy ?>">

                <label style="font-size:0.85rem; font-weight:700;">Köy Merkezine (Cami/Meydan) Kuş Uçuşu Mesafe (Metre):</label>
                <input type="number" name="mesafe" class="form-control" value="<?= $mesafe ?>" step="10">

                <label style="font-size:0.85rem; font-weight:700;">Tarla / Parsel Alanı (m²):</label>
                <input type="number" name="alan" class="form-control" value="<?= $alan ?>">

                <button type="submit" class="btn-check">
                    <i class="fa-solid fa-magnifying-glass-location"></i> Durumu Yeniden Hesapla
                </button>
            </form>
        </div>

        <!-- Right: Map -->
        <div class="card">
            <h3 style="margin-top:0; color:#fff; font-size:1.15rem; display:flex; justify-content:space-between;">
                <span><i class="fa-solid fa-map" style="color:var(--accent-gold);"></i> 300m / 500m Tampon Haritası</span>
                <span style="font-size:0.8rem; color:var(--text-muted);">Mesafe: <?= $mesafe ?> m</span>
            </h3>
            <div id="map-buffer"></div>
        </div>
    </div>

    <!-- Rights & Constraints Table -->
    <div class="card">
        <h3 style="margin-top:0; color:#fff; font-size:1.15rem;">
            <i class="fa-solid fa-clipboard-check" style="color:var(--accent-green);"></i> İmar ve İnşaat Kapasite Tablosu
        </h3>
        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); gap:16px; margin-top:16px;">
            <div style="background:#0f172a; padding:14px; border-radius:8px; border:1px solid var(--border-dark);">
                <div style="color:var(--text-muted); font-size:0.85rem;">Taban Oturumu İzni</div>
                <div style="font-size:1.3rem; font-weight:800; color:var(--accent-blue);"><?= $is_koy_ici ? '%40 Taban' : '%5 Taban' ?></div>
                <div style="font-size:0.75rem; color:var(--text-muted); margin-top:4px;">Azami: <?= $taks_m2 ?> m²</div>
            </div>
            <div style="background:#0f172a; padding:14px; border-radius:8px; border:1px solid var(--border-dark);">
                <div style="color:var(--text-muted); font-size:0.85rem;">Toplam İnşaat İzni</div>
                <div style="font-size:1.3rem; font-weight:800; color:var(--accent-green);"><?= $maks_insaat_m2 ?> m²</div>
                <div style="font-size:0.75rem; color:var(--text-muted); margin-top:4px;">Azami 2 Kat (h=6.50m)</div>
            </div>
            <div style="background:#0f172a; padding:14px; border-radius:8px; border:1px solid var(--border-dark);">
                <div style="color:var(--text-muted); font-size:0.85rem;">5.000 m² Kuralı</div>
                <div style="font-size:1.3rem; font-weight:800; color:<?= $is_koy_ici ? '#10b981' : '#ef4444' ?>;">
                    <?= $is_koy_ici ? 'Muaf (Gerekmez)' : 'ZORUNLU' ?>
                </div>
                <div style="font-size:0.75rem; color:var(--text-muted); margin-top:4px;"><?= $is_koy_ici ? 'Küçük tarlalara da ev yapılabilir' : '5.000 m² altı konut yapamaz' ?></div>
            </div>
        </div>

        <div style="margin-top:20px; text-align:center;">
            <a href="https://wa.me/905428413535?text=<?= urlencode("Merhaba, {$il} {$ilce} {$koy} bölgesindeki {$alan} m2 arazimin köy yerleşik alanı tespiti ve imar durumu hakkında mühendislik desteği almak istiyorum.") ?>" target="_blank" style="display:inline-flex; align-items:center; gap:8px; background:#25d366; color:#0b1329; font-weight:800; padding:12px 24px; border-radius:8px; text-decoration:none;">
                <i class="fa-brands fa-whatsapp fa-lg"></i> Harita Mühendisine Parselimi Danış (0542 841 35 35)
            </a>
        </div>
    </div>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    const center = [41.7333, 27.2167];
    const map = L.map('map-buffer').setView(center, 15);
    L.tileLayer('https://mt1.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
        maxZoom: 20,
        attribution: '&copy; Ant Harita'
    }).addTo(map);

    // Village center marker
    L.marker(center).addTo(map).bindPopup('<strong>Köy Merkezi (Cami / Meydan)</strong>').openPopup();

    // 300m buffer circle (Köy İçi)
    L.circle(center, {
        radius: 300,
        color: '#10b981',
        fillColor: '#10b981',
        fillOpacity: 0.2,
        weight: 2
    }).addTo(map).bindTooltip('300m Köy Yerleşik Alanı Sınırı (%40 İmar)');

    // 500m buffer circle (Civar)
    L.circle(center, {
        radius: 500,
        color: '#f59e0b',
        fillColor: '#f59e0b',
        fillOpacity: 0.1,
        weight: 1,
        dashArray: '4, 4'
    }).addTo(map).bindTooltip('500m Köy Civarı Bandı');

    // User Parcel point
    const angle = 0.8;
    const distDeg = (<?= $mesafe ?> / 111320);
    const parcelPos = [center[0] + distDeg * Math.cos(angle), center[1] + distDeg * Math.sin(angle)];

    L.circleMarker(parcelPos, {
        radius: 8,
        color: '<?= $durum_renk ?>',
        fillColor: '#fff',
        fillOpacity: 1,
        weight: 3
    }).addTo(map).bindPopup('<strong>Tarlanız / Parseliniz</strong><br>Mesafe: <?= $mesafe ?> m');
</script>

</body>
</html>
