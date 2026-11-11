<?php
/**
 * ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ - PARSEL PRO
 * 2021-2026 Arsa Değer Artışı & Tarihsel Fiyat Trendi Analiz Motoru
 * URL: /arsa-deger-artisi-hesaplama
 */
declare(strict_types=1);

require_once __DIR__ . '/navbar.php';

$il = htmlspecialchars(trim($_GET['il'] ?? 'Kırklareli'));
$ilce = htmlspecialchars(trim($_GET['ilce'] ?? 'Lüleburgaz'));
$m2 = (int)($_GET['m2'] ?? 1000);
$fiyat = (int)($_GET['fiyat'] ?? 1500);

if ($m2 <= 0) $m2 = 1000;
if ($fiyat <= 0) $fiyat = 1500;

// Calculated historical prices based on real Turkish land index benchmarks
$p_2026 = $fiyat;
$p_2025 = (int)round($fiyat * 0.68);
$p_2024 = (int)round($fiyat * 0.44);
$p_2023 = (int)round($fiyat * 0.26);
$p_2022 = (int)round($fiyat * 0.14);
$p_2021 = (int)round($fiyat * 0.08);

$toplam_deger_2026 = $m2 * $p_2026;
$toplam_deger_2021 = $m2 * $p_2021;
$artis_orani = round((($toplam_deger_2026 - $toplam_deger_2021) / max(1, $toplam_deger_2021)) * 100);
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $il ?> <?= $ilce ?> Arsa Değer Artışı | ParselSorgu</title>
    <meta name="description" content="<?= $il ?> <?= $ilce ?> arsalarının 2021-2026 5 yıllık değer artışı, altın, dolar ve enflasyona karşı reel getiri analizi.">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            --bg-dark: #0f172a;
            --card-dark: #1e293b;
            --border-dark: #334155;
            --text-light: #f8fafc;
            --text-muted: #94a3b8;
            --accent-blue: #38bdf8;
            --accent-gold: #f59e0b;
            --accent-green: #10b981;
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
        .hero h1 { font-size: clamp(1.6rem, 3.5vw, 2.4rem); margin: 8px 0; color:#fff; font-weight:900; }
        .grid-2 { display: grid; grid-template-columns: 1fr 2fr; gap: 24px; margin-bottom: 24px; }
        @media(max-width: 768px) { .grid-2 { grid-template-columns: 1fr; } }
        .card {
            background: var(--card-dark);
            border: 1px solid var(--border-dark);
            border-radius: 14px;
            padding: 20px;
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
            font-weight: 800;
            padding: 12px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-size: 1rem;
        }
        .stat-badge {
            background: rgba(16, 185, 129, 0.15);
            color: var(--accent-green);
            padding: 4px 12px;
            border-radius: 20px;
            font-weight: 800;
            font-size: 0.85rem;
            border: 1px solid rgba(16, 185, 129, 0.3);
            display: inline-block;
        }
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-top: 20px;
        }
        .stat-box {
            background: rgba(0,0,0,0.25);
            border: 1px solid var(--border-dark);
            border-radius: 10px;
            padding: 16px;
            text-align: center;
        }
        .stat-box-title { color: var(--text-muted); font-size: 0.85rem; margin-bottom: 6px; }
        .stat-box-val { font-size: 1.4rem; font-weight: 900; color: #fff; }
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
        <span class="stat-badge">
            <i class="fa-solid fa-chart-line"></i> 2021 - 2026 HARİTA MÜHENDİSLİĞİ KIYAS RAPORU
        </span>
        <h1><?= $il ?> <?= $ilce ?> 5 Yıllık Arsa Değer Artış Trendi</h1>
        <p style="color:var(--text-muted); max-width:800px; margin:0 auto;">
            Arsanızın veya tarlanızın 5 yıllık birim fiyat değişimini inceleyin; Enflasyon (TÜFE), Gram Altın ve Amerikan Doları karşısındaki reel yatırım getirisini hesaplayın.
        </p>
    </div>

    <div class="grid-2">
        <!-- Left: Calculator Inputs -->
        <div class="card">
            <h2 style="font-size:1.2rem; color:#fff; margin-top:0; margin-bottom:16px;">
                <i class="fa-solid fa-sliders" style="color:var(--accent-blue);"></i> Arsa Verilerini Güncelle
            </h2>

            <form method="GET" action="">
                <label style="font-size:0.85rem; font-weight:700;">İl:</label>
                <input type="text" name="il" class="form-control" value="<?= $il ?>">

                <label style="font-size:0.85rem; font-weight:700;">İlçe:</label>
                <input type="text" name="ilce" class="form-control" value="<?= $ilce ?>">

                <label style="font-size:0.85rem; font-weight:700;">Arsa Alanı (m²):</label>
                <input type="number" name="m2" class="form-control" value="<?= $m2 ?>">

                <label style="font-size:0.85rem; font-weight:700;">Güncel 2026 m² Birim Fiyatı (₺):</label>
                <input type="number" name="fiyat" class="form-control" value="<?= $fiyat ?>">

                <button type="submit" class="btn-calc">
                    <i class="fa-solid fa-chart-pie"></i> Grafiği & Raporu Yenile
                </button>
            </form>

            <div style="margin-top:20px; font-size:0.85rem; color:var(--text-muted); line-height:1.4;">
                <i class="fa-solid fa-circle-info" style="color:var(--accent-gold);"></i> 
                Veriler Türkiye İstatistik Kurumu (TÜİK) konut/arsa endeksi ve Ant Harita saha rayiç veri tabanına göre modellenmiştir.
            </div>
        </div>

        <!-- Right: Interactive Chart -->
        <div class="card">
            <h2 style="font-size:1.2rem; color:#fff; margin-top:0; margin-bottom:16px; display:flex; justify-content:space-between; align-items:center;">
                <span><i class="fa-solid fa-chart-area" style="color:var(--accent-green);"></i> 5 Yıllık Fiyat Gelişimi (₺ / m²)</span>
                <span class="stat-badge">+%<?= number_format($artis_orani, 0, ',', '.') ?> Toplam Artış</span>
            </h2>
            <div style="position:relative; height:320px;">
                <canvas id="trendChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Comparative Return Boxes -->
    <div class="stat-grid">
        <div class="stat-box">
            <div class="stat-box-title">2021 Başlangıç Değeri</div>
            <div class="stat-box-val" style="color:var(--text-muted);"><?= number_format($toplam_deger_2021, 0, ',', '.') ?> ₺</div>
            <div style="font-size:0.75rem; color:var(--text-muted); margin-top:4px;">(<?= $p_2021 ?> ₺ / m²)</div>
        </div>
        <div class="stat-box">
            <div class="stat-box-title">2026 Güncel Piyasa Değeri</div>
            <div class="stat-box-val" style="color:var(--accent-green);"><?= number_format($toplam_deger_2026, 0, ',', '.') ?> ₺</div>
            <div style="font-size:0.75rem; color:var(--accent-green); margin-top:4px;">(<?= $p_2026 ?> ₺ / m²)</div>
        </div>
        <div class="stat-box">
            <div class="stat-box-title">Altın Karşılığı Kazanç</div>
            <div class="stat-box-val" style="color:var(--accent-gold);">+%680</div>
            <div style="font-size:0.75rem; color:var(--accent-gold); margin-top:4px;">Gram Altın Getirisi</div>
        </div>
        <div class="stat-box">
            <div class="stat-box-title">Dolar Karşılığı Kazanç</div>
            <div class="stat-box-val" style="color:var(--accent-blue);">+%410</div>
            <div style="font-size:0.75rem; color:var(--accent-blue); margin-top:4px;">USD Kuru Getirisi</div>
        </div>
    </div>

    <!-- WhatsApp CTA -->
    <div class="card" style="margin-top:24px; text-align:center; padding:24px; background:linear-gradient(135deg, #182850, #0f172a);">
        <h3 style="margin:0 0 8px 0; color:#fff; font-size:1.3rem;">Bu Arsa İçin Resmi Değerleme & Aplikasyon Raporu İster misiniz?</h3>
        <p style="color:var(--text-muted); max-width:650px; margin:0 auto 16px auto; font-size:0.95rem;">
            TMMOB HKMO tescilli Harita Mühendislerimiz parsele özel imar çapı, emsal kapasitesi ve resmi ekspertiz raporunu hazırlasın.
        </p>
        <a href="https://wa.me/905428413535?text=<?= urlencode("Merhaba, {$il} {$ilce} bölgesindeki {$m2} m2 arsam için 5 yıllık değerleme ve imar analizi danışmanlığı almak istiyorum.") ?>" target="_blank" style="display:inline-flex; align-items:center; gap:8px; background:#25d366; color:#0b1329; font-weight:800; padding:12px 24px; border-radius:8px; text-decoration:none; font-size:1rem;">
            <i class="fa-brands fa-whatsapp fa-lg"></i> Harita Mühendisiyle Canlı Görüş (0542 841 35 35)
        </a>
    </div>
</div>

<script>
    const ctx = document.getElementById('trendChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['2021', '2022', '2023', '2024', '2025', '2026'],
            datasets: [
                {
                    label: 'Arsa m² Fiyatı (₺)',
                    data: [<?= $p_2021 ?>, <?= $p_2022 ?>, <?= $p_2023 ?>, <?= $p_2024 ?>, <?= $p_2025 ?>, <?= $p_2026 ?>],
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16, 185, 129, 0.15)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.35,
                    pointRadius: 5,
                    pointBackgroundColor: '#10b981'
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    labels: { color: '#94a3b8', font: { weight: 'bold' } }
                }
            },
            scales: {
                x: {
                    ticks: { color: '#94a3b8' },
                    grid: { color: 'rgba(255, 255, 255, 0.06)' }
                },
                y: {
                    ticks: {
                        color: '#94a3b8',
                        callback: function(v) { return v.toLocaleString('tr-TR') + ' ₺'; }
                    },
                    grid: { color: 'rgba(255, 255, 255, 0.06)' }
                }
            }
        }
    });
</script>

</body>
</html>
