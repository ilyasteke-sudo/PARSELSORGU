<?php
/**
 * ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ - PARSEL PRO
 * 3194 İmar Çapı, Yola & Parka Terk ve Net Parsel Simülatörü (Madde 15-16)
 * URL: /imar-terk-hesaplama
 */
declare(strict_types=1);

require_once __DIR__ . '/navbar.php';

$brut_m2 = (int)($_GET['brut_m2'] ?? 1500);
$cephe_m = (int)($_GET['cephe_m'] ?? 30);
$yola_terk_m = (float)($_GET['yola_terk_m'] ?? 3.5);
$park_orani = (float)($_GET['park_orani'] ?? 5.0);
$kaks = (float)($_GET['kaks'] ?? 1.20);
$taks = (float)($_GET['taks'] ?? 0.30);

if ($brut_m2 <= 0) $brut_m2 = 1500;
if ($cephe_m <= 0) $cephe_m = 30;

$yola_terk_m2 = round($cephe_m * $yola_terk_m);
$kalan_ara = max(0, $brut_m2 - $yola_terk_m2);
$park_terk_m2 = round($kalan_ara * ($park_orani / 100));
$net_parsel_m2 = max(0, $kalan_ara - $park_terk_m2);

$toplam_terk_m2 = $yola_terk_m2 + $park_terk_m2;
$toplam_terk_yuzdesi = round(($toplam_terk_m2 / $brut_m2) * 100, 1);

$taban_oturumu_m2 = round($net_parsel_m2 * $taks);
$toplam_insaat_m2 = round($net_parsel_m2 * $kaks);
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>3194 Yola ve Parka Terk Hesaplama (2026) | ParselSorgu</title>
    <meta name="description" content="Arsanızdan yola ne kadar terk gidecek? 3194 sayılı İmar Kanunu 15-16. madde yola terk, park terki ve net parsel hesaplama aracı.">

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
            --accent-red: #ef4444;
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
        .btn-calc {
            width: 100%;
            background: var(--accent-blue);
            color: #0b1329;
            font-weight: 900;
            padding: 12px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-size: 1rem;
        }
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 14px;
            margin-top: 16px;
        }
        .stat-box {
            background: #0f172a;
            border: 1px solid var(--border-dark);
            border-radius: 10px;
            padding: 14px;
            text-align: center;
        }
        .svg-container {
            width: 100%;
            background: #0b1329;
            border-radius: 10px;
            border: 1px solid var(--border-dark);
            padding: 20px;
            box-sizing: border-box;
            text-align: center;
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
        <span style="background:rgba(239,68,68,0.15); color:var(--accent-red); padding:4px 14px; border-radius:20px; font-weight:800; font-size:0.85rem; border:1px solid rgba(239,68,68,0.3);">
            <i class="fa-solid fa-road"></i> 3194 İMAR KANUNU MADDE 15 VE 16
        </span>
        <h1>3194 Yola & Parka Terk ve Net Parsel Simülatörü</h1>
        <p style="color:var(--text-muted); max-width:800px; margin:0 auto;">
            Arsanızdan imar planı gereği yola ve yeşil alana ne kadar terk gideceğini, inşaata esas net imar parselinizin ve TAKS/KAKS inşaat alanınızın ne kalacağını anında hesaplayın.
        </p>
    </div>

    <div class="grid-2">
        <!-- Form -->
        <div class="card">
            <h3 style="margin-top:0; color:#fff; font-size:1.15rem;">
                <i class="fa-solid fa-sliders" style="color:var(--accent-blue);"></i> Parsel & Terk Parametreleri
            </h3>

            <form method="GET" action="">
                <label style="font-size:0.85rem; font-weight:700;">Kadastral Brüt Parsel Alanı (m²):</label>
                <input type="number" name="brut_m2" class="form-control" value="<?= $brut_m2 ?>">

                <label style="font-size:0.85rem; font-weight:700;">İmar Yoluna Olan Cephe Genişliği (Metre):</label>
                <input type="number" name="cephe_m" class="form-control" value="<?= $cephe_m ?>">

                <label style="font-size:0.85rem; font-weight:700;">Yol Genişletme / Terk Derinliği (Metre):</label>
                <input type="number" name="yola_terk_m" class="form-control" value="<?= $yola_terk_m ?>" step="0.1">

                <label style="font-size:0.85rem; font-weight:700;">Park & Yeşil Alan Kesintisi (%):</label>
                <input type="number" name="park_orani" class="form-control" value="<?= $park_orani ?>" step="0.5">

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                    <div>
                        <label style="font-size:0.85rem; font-weight:700;">Emsal (KAKS):</label>
                        <input type="number" name="kaks" class="form-control" value="<?= $kaks ?>" step="0.05">
                    </div>
                    <div>
                        <label style="font-size:0.85rem; font-weight:700;">Taban (TAKS):</label>
                        <input type="number" name="taks" class="form-control" value="<?= $taks ?>" step="0.05">
                    </div>
                </div>

                <button type="submit" class="btn-calc">
                    <i class="fa-solid fa-calculator"></i> Terk ve İnşaat Alanını Hesapla
                </button>
            </form>
        </div>

        <!-- Visual Diagram -->
        <div class="card">
            <h3 style="margin-top:0; color:#fff; font-size:1.15rem;">
                <i class="fa-solid fa-draw-polygon" style="color:var(--accent-gold);"></i> Parsel Terk Şeması
            </h3>

            <div class="svg-container">
                <svg viewBox="0 0 400 240" style="max-width:100%; height:auto;">
                    <!-- Outer Road -->
                    <rect x="20" y="10" width="360" height="35" fill="#334155" rx="4" />
                    <text x="200" y="32" fill="#f8fafc" font-size="12" font-weight="bold" text-anchor="middle">İMAR YOLU</text>

                    <!-- Road Widening Terk Strip -->
                    <rect x="40" y="50" width="320" height="30" fill="rgba(239,68,68,0.3)" stroke="#ef4444" stroke-width="2" stroke-dasharray="4,4" />
                    <text x="200" y="70" fill="#ef4444" font-size="11" font-weight="bold" text-anchor="middle">YOLA TERK (<?= $yola_terk_m2 ?> m²)</text>

                    <!-- Net Parcel -->
                    <rect x="40" y="85" width="260" height="135" fill="rgba(2,132,199,0.25)" stroke="#0284c7" stroke-width="2" />
                    <text x="170" y="155" fill="#38bdf8" font-size="14" font-weight="bold" text-anchor="middle">NET İMAR PARSELİ</text>
                    <text x="170" y="175" fill="#fff" font-size="12" text-anchor="middle"><?= number_format($net_parsel_m2, 0, ',', '.') ?> m²</text>

                    <!-- Park Terk -->
                    <rect x="305" y="85" width="55" height="135" fill="rgba(16,185,129,0.3)" stroke="#10b981" stroke-width="2" stroke-dasharray="4,4" />
                    <text x="332" y="155" fill="#10b981" font-size="10" font-weight="bold" text-anchor="middle" transform="rotate(-90 332 155)">PARK TERKİ</text>
                </svg>
            </div>

            <div style="margin-top:14px; font-size:0.85rem; color:var(--text-muted); text-align:center;">
                <span style="color:#ef4444;">■ Yola Terk</span> &bull; 
                <span style="color:#10b981;">■ Park Terki</span> &bull; 
                <span style="color:#38bdf8;">■ Net İnşaat Alanı</span>
            </div>
        </div>
    </div>

    <!-- Results Grid -->
    <div class="card">
        <h3 style="margin-top:0; color:#fff; font-size:1.15rem;">
            <i class="fa-solid fa-table-list" style="color:var(--accent-green);"></i> Terk Sonrası Net Alan ve Kapasite Özeti
        </h3>

        <div class="stat-grid">
            <div class="stat-box">
                <div style="color:var(--text-muted); font-size:0.8rem;">Toplam Terk Edilen Alan</div>
                <div style="font-size:1.3rem; font-weight:800; color:var(--accent-red);"><?= number_format($toplam_terk_m2, 0, ',', '.') ?> m²</div>
                <div style="font-size:0.75rem; color:var(--text-muted);">Terk Oranı: %<?= $toplam_terk_yuzdesi ?></div>
            </div>
            <div class="stat-box">
                <div style="color:var(--text-muted); font-size:0.8rem;">Kalan Net İmar Parseli</div>
                <div style="font-size:1.3rem; font-weight:800; color:var(--accent-blue);"><?= number_format($net_parsel_m2, 0, ',', '.') ?> m²</div>
                <div style="font-size:0.75rem; color:var(--accent-blue);">Yapılaşmaya Esas</div>
            </div>
            <div class="stat-box">
                <div style="color:var(--text-muted); font-size:0.8rem;">Azami Taban Oturumu (TAKS)</div>
                <div style="font-size:1.3rem; font-weight:800; color:var(--accent-gold);"><?= number_format($taban_oturumu_m2, 0, ',', '.') ?> m²</div>
                <div style="font-size:0.75rem; color:var(--text-muted);">Zemin Kat Alanı</div>
            </div>
            <div class="stat-box">
                <div style="color:var(--text-muted); font-size:0.8rem;">Toplam İnşaat Alanı (KAKS)</div>
                <div style="font-size:1.3rem; font-weight:800; color:var(--accent-green);"><?= number_format($toplam_insaat_m2, 0, ',', '.') ?> m²</div>
                <div style="font-size:0.75rem; color:var(--text-muted);">Tüm Katlar Toplamı</div>
            </div>
        </div>

        <div style="margin-top:24px; text-align:center;">
            <a href="https://wa.me/905428413535?text=<?= urlencode("Merhaba, {$brut_m2} m2 arsam için 3194 sayılı İmar Kanunu 15-16 terk dosyası ve aplikasyon krokisi hazırlatmak istiyorum.") ?>" target="_blank" style="display:inline-flex; align-items:center; gap:8px; background:#25d366; color:#0b1329; font-weight:800; padding:12px 24px; border-radius:8px; text-decoration:none;">
                <i class="fa-brands fa-whatsapp fa-lg"></i> Terk Dosyası İçin Harita Mühendisine Bağlan (0542 841 35 35)
            </a>
        </div>
    </div>
</div>

</body>
</html>
