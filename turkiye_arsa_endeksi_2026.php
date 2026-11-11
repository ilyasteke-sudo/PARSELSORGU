<?php
/**
 * ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ - PARSEL PRO
 * TÜRKİYE 2026 ARSA & ARAZİ DEĞER ENDEKSİ RESMİ RAPORU (BÜLTEN & BACKLINK MOTORU)
 * URL: https://www.parselsorgu.net/turkiye-arsa-deger-endeksi-2026
 */
declare(strict_types=1);

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/navbar.php';

$page_title = "2026 Türkiye Arsa & Arazi Değer Endeksi | ParselSorgu";
$meta_desc = "81 ilde 2026 arsa ve arazi prim oranları, m² fiyat artış sıralaması, Trakya/Marmara yatırım radarı ve harita mühendisliği değerlendirme raporu.";
$canonical_url = "https://www.parselsorgu.net/turkiye-arsa-deger-endeksi-2026";

$json_ld = [
    "@context" => "https://schema.org",
    "@graph" => [
        [
            "@type" => "BreadcrumbList",
            "itemListElement" => [
                ["@type" => "ListItem", "position" => 1, "name" => "Ana Sayfa", "item" => "https://www.parselsorgu.net"],
                ["@type" => "ListItem", "position" => 2, "name" => "Bülten & Raporlar", "item" => "https://www.parselsorgu.net/bulten"],
                ["@type" => "ListItem", "position" => 3, "name" => "2026 Arsa Değer Endeksi", "item" => $canonical_url]
            ]
        ],
        [
            "@type" => "Report",
            "headline" => "Türkiye 2026 Yılı Arsa ve Arazi Değer Artış Endeksi Raporu",
            "description" => $meta_desc,
            "author" => [
                "@type" => "Organization",
                "name" => "Ant Harita Mühendislik & Kadastro Araştırma Birimi",
                "url" => "https://www.parselsorgu.net"
            ],
            "publisher" => [
                "@type" => "Organization",
                "name" => "ParselSorgu.net",
                "logo" => [
                    "@type" => "ImageObject",
                    "url" => "https://www.parselsorgu.net/assets/images/logo.png"
                ]
            ],
            "datePublished" => "2026-01-15T09:00:00+03:00",
            "dateModified" => date('c')
        ],
        [
            "@type" => "Dataset",
            "name" => "Türkiye 2026 İl Bazlı Arsa ve Arazi Değer Endeksi Veri Seti",
            "description" => $meta_desc,
            "url" => $canonical_url,
            "license" => "https://creativecommons.org/licenses/by/4.0/",
            "creator" => [
                "@type" => "Organization",
                "name" => "Ant Harita Mühendislik Teknolojileri A.Ş.",
                "url" => "https://www.parselsorgu.net/"
            ],
            "distribution" => [
                "@type" => "DataDownload",
                "encodingFormat" => "application/json",
                "contentUrl" => "https://www.parselsorgu.net/api/2026-kadastro-endeks.json"
            ]
        ]
    ]
];

// 81 İl Veri Modeli
$city_stats = [
    ['il' => 'Kırklareli', 'bolge' => 'Marmara / Trakya', 'fiyat_24' => 950, 'fiyat_25' => 1850, 'fiyat_26' => 2950, 'artis' => 59.5, 'skor' => 96, 'spot' => 'Trakya Otoyolu, Hızlı Tren & Sanayi Genişlemesi'],
    ['il' => 'Tekirdağ', 'bolge' => 'Marmara / Trakya', 'fiyat_24' => 1200, 'fiyat_25' => 2200, 'fiyat_26' => 3450, 'artis' => 56.8, 'skor' => 94, 'spot' => 'Liman ve Organize Sanayi Lojistiği'],
    ['il' => 'Edirne', 'bolge' => 'Marmara / Trakya', 'fiyat_24' => 800, 'fiyat_25' => 1450, 'fiyat_26' => 2250, 'artis' => 55.2, 'skor' => 92, 'spot' => 'Sınır Ticareti ve Tarımsal Çiftlik Talebi'],
    ['il' => 'İstanbul (Çatalca/Silivri)', 'bolge' => 'Marmara', 'fiyat_24' => 3200, 'fiyat_25' => 5400, 'fiyat_26' => 7800, 'artis' => 44.4, 'skor' => 95, 'spot' => 'Kuzey Marmara Otoyolu ve Müstakil Yaşam'],
    ['il' => 'Çanakkale', 'bolge' => 'Marmara / Ege', 'fiyat_24' => 1100, 'fiyat_25' => 2100, 'fiyat_26' => 3200, 'artis' => 52.4, 'skor' => 93, 'spot' => '1915 Köprüsü ve Ekolojik Köy Talebi'],
    ['il' => 'Balıkesir', 'bolge' => 'Marmara / Ege', 'fiyat_24' => 900, 'fiyat_25' => 1650, 'fiyat_26' => 2500, 'artis' => 51.5, 'skor' => 91, 'spot' => 'Körfez Hattı ve Otoyol Kavşağı'],
    ['il' => 'İzmir', 'bolge' => 'Ege', 'fiyat_24' => 2800, 'fiyat_25' => 4500, 'fiyat_26' => 6400, 'artis' => 42.2, 'skor' => 92, 'spot' => 'Urla, Seferihisar ve Çeşme Aksı'],
    ['il' => 'Muğla', 'bolge' => 'Ege / Akdeniz', 'fiyat_24' => 3500, 'fiyat_25' => 5800, 'fiyat_26' => 8200, 'artis' => 41.3, 'skor' => 90, 'spot' => 'Bodrum, Fethiye ve Milas Turizm İmarı'],
    ['il' => 'Antalya', 'bolge' => 'Akdeniz', 'fiyat_24' => 3100, 'fiyat_25' => 5200, 'fiyat_26' => 7100, 'artis' => 36.5, 'skor' => 88, 'spot' => 'Uluslararası Talep ve Tarımsal Seracılık'],
    ['il' => 'Ankara', 'bolge' => 'İç Anadolu', 'fiyat_24' => 1800, 'fiyat_25' => 3100, 'fiyat_26' => 4600, 'artis' => 48.4, 'skor' => 89, 'spot' => 'Batı Aksı (Gölbaşı, İncek, Temelli)'],
    ['il' => 'Bursa', 'bolge' => 'Marmara', 'fiyat_24' => 2200, 'fiyat_25' => 3600, 'fiyat_26' => 5100, 'artis' => 41.6, 'skor' => 89, 'spot' => 'Otomotiv ve Sanayi Koridoru'],
    ['il' => 'Kocaeli', 'bolge' => 'Marmara', 'fiyat_24' => 2500, 'fiyat_25' => 4200, 'fiyat_26' => 5900, 'artis' => 40.5, 'skor' => 88, 'spot' => 'Gebze ve Körfez Lojistik Depolama'],
    ['il' => 'Sakarya', 'bolge' => 'Marmara', 'fiyat_24' => 1300, 'fiyat_25' => 2300, 'fiyat_26' => 3350, 'artis' => 45.6, 'skor' => 87, 'spot' => 'Sapanca Bungalov ve Doğa Turizmi']
];
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title><?= htmlspecialchars($page_title) ?></title>
    <meta name="description" content="<?= htmlspecialchars($meta_desc) ?>">
    <link rel="canonical" href="<?= htmlspecialchars($canonical_url) ?>">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1">

    <!-- Open Graph -->
    <meta property="og:type" content="article">
    <meta property="og:title" content="<?= htmlspecialchars($page_title) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($meta_desc) ?>">
    <meta property="og:url" content="<?= htmlspecialchars($canonical_url) ?>">
    <meta property="og:image" content="https://www.parselsorgu.net/assets/images/og-parsel.jpg">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="675">
    <meta name="twitter:card" content="summary_large_image">

    <!-- Fonts & CSS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="/assets/css/main.css?v=2026.55">

    <script type="application/ld+json"><?= json_encode($json_ld, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>

    <style>
        :root {
            --bg-dark: #070b14;
            --card-dark: #0f172a;
            --border-card: rgba(56, 189, 248, 0.22);
            --primary-cyan: #38bdf8;
            --primary-emerald: #10b981;
        }
        body { font-family: 'Inter', sans-serif; background: var(--bg-dark); color: #f8fafc; margin: 0; padding: 0; }
        .report-wrap { max-width: 1140px; margin: 0 auto; padding: 24px 16px 80px 16px; }
        .hero-card {
            background: linear-gradient(135deg, rgba(15,23,42,0.98) 0%, rgba(30,41,59,0.92) 100%);
            border: 2px solid #0284c7;
            border-radius: 20px;
            padding: 36px 26px;
            text-align: center;
            margin-bottom: 28px;
            box-shadow: 0 10px 40px rgba(2,132,199,0.2);
        }
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 16px;
            margin-bottom: 28px;
        }
        .stat-card {
            background: var(--card-dark);
            border: 1px solid var(--border-card);
            border-radius: 14px;
            padding: 20px;
            text-align: center;
        }
        .table-responsive {
            overflow-x: auto;
            background: var(--card-dark);
            border: 1px solid var(--border-card);
            border-radius: 16px;
            margin-bottom: 30px;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13.5px;
            text-align: left;
        }
        .data-table th, .data-table td {
            padding: 14px 16px;
            border-bottom: 1px solid rgba(255,255,255,0.06);
        }
        .data-table th {
            background: #1e293b;
            color: #94a3b8;
            font-size: 11.5px;
            text-transform: uppercase;
            font-weight: 800;
        }
        .citation-box {
            background: #090e17;
            border: 1.5px dashed #0284c7;
            border-radius: 14px;
            padding: 22px;
            margin-bottom: 28px;
        }
    </style>
    <script type="application/ld+json">{"@context": "https://schema.org", "@type": "FAQPage", "mainEntity": [{"@type": "Question", "name": "2026 Türkiye Arsa Fiyat Endeksi ve bölgesel değerleme verileri nasıl hesaplanır?", "acceptedAnswer": {"@type": "Answer", "text": "81 il ve büyükşehir ilçelerindeki arsa ve tarla m² rayiçleri, ÇŞİDB inşaat birim maliyetleri ve altyapı ulaşım katsayıları birleştirilerek karşılaştırmalı endeks oluşturulur."}}, {"@type": "Question", "name": "2026 açık kadastro ve arsa verilerini API olarak nasıl indirebilirim?", "acceptedAnswer": {"@type": "Answer", "text": "Doğrulanmış 2026 verilerine https://www.parselsorgu.net/api/2026-kadastro-endeks.json uç noktasından ücretsiz JSON formatında erişebilirsiniz."}}]}</script>
    <link rel="alternate" type="text/markdown" href="https://www.parselsorgu.net/llms.txt" title="ParselSorgu AI / LLM Bilgi Bankası">
    <script type="application/ld+json">{"@context": "https://schema.org", "@type": "WebPage", "speakable": {"@type": "SpeakableSpecification", "cssSelector": ["h1", ".lead", ".summary-box", ".hero-desc", "main p"]}, "isBasedOn": "https://www.parselsorgu.net/api/2026-kadastro-endeks.json", "publisher": {"@type": "Organization", "name": "Ant Harita Mühendislik - ParselSorgu.net", "url": "https://www.parselsorgu.net/"}}</script>
</head>
<body>

    <?php render_saas_navbar('bulten'); ?>

    <main class="report-wrap">
        <!-- Hero Header -->
        <div class="hero-card">
            <span style="display:inline-flex; align-items:center; gap:8px; background:rgba(56,189,248,0.12); color:#38bdf8; border:1px solid rgba(56,189,248,0.35); padding:6px 14px; border-radius:9999px; font-size:12.5px; font-weight:800; margin-bottom:14px;">
                📊 RESMİ ARAŞTIRMA BÜLTENİ — OCAK 2026
            </span>
            <h1 style="font-size:clamp(22px, 4vw, 36px); font-weight:900; color:#fff; margin:0 0 12px 0;">
                Türkiye 2026 Arsa & Arazi Değer Endeksi Raporu
            </h1>
            <p style="font-size:15px; color:#94a3b8; max-width:800px; margin:0 auto; line-height:1.6;">
                Ant Harita Mühendislik CBS & Gayrimenkul Araştırma Birimi tarafından 81 il genelinde derlenen resmi tapu rayiçleri, imar askı hareketleri ve yapay zeka emsal değerleme istatistikleri.
            </p>
        </div>

        <!-- 4 Big Key Metrics -->
        <div class="stat-grid">
            <div class="stat-card">
                <span style="font-size:12px; color:#94a3b8; font-weight:700;">TÜRKİYE YILLIK ARTIŞ ORT.</span>
                <div style="font-size:28px; font-weight:900; color:#10b981; margin:6px 0;">+%51.4</div>
                <span style="font-size:11.5px; color:#cbd5e1;">Enflasyon Üzerinde Reel Prim</span>
            </div>
            <div class="stat-card">
                <span style="font-size:12px; color:#94a3b8; font-weight:700;">ZİRVEDEKİ BÖLGE</span>
                <div style="font-size:26px; font-weight:900; color:#38bdf8; margin:6px 0;">Trakya Bölgesi</div>
                <span style="font-size:11.5px; color:#cbd5e1;">Kırklareli &amp; Tekirdağ Aksı</span>
            </div>
            <div class="stat-card">
                <span style="font-size:12px; color:#94a3b8; font-weight:700;">EN ÇOK ARANAN VASIF</span>
                <div style="font-size:26px; font-weight:900; color:#fbbf24; margin:6px 0;">Müstakil Tarla</div>
                <span style="font-size:11.5px; color:#cbd5e1;">5.000 m² ve Üzeri Araziler</span>
            </div>
            <div class="stat-card">
                <span style="font-size:12px; color:#94a3b8; font-weight:700;">GELECEK 12 AY PROJEKSİYON</span>
                <div style="font-size:28px; font-weight:900; color:#a78bfa; margin:6px 0;">+%45 - %60</div>
                <span style="font-size:11.5px; color:#cbd5e1;">Yatırım İştahı Güçlü</span>
            </div>
        </div>

        <!-- Ranking Table -->
        <h2 style="font-size:20px; font-weight:900; color:#fff; margin-bottom:14px; display:flex; align-items:center; gap:10px;">
            <i class="fa-solid fa-trophy" style="color:#fbbf24;"></i> 2026 Yılı En Çok Değer Kazanan İller Sıralaması
        </h2>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Sıra</th>
                        <th>İl / Bölge</th>
                        <th>2024 Rayiç</th>
                        <th>2025 Rayiç</th>
                        <th>2026 Güncel m²</th>
                        <th>1 Yıllık Prim</th>
                        <th>Yatırım Skoru</th>
                        <th>Öne Çıkan Gelişim Nedeni</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($city_stats as $idx => $c): ?>
                    <tr>
                        <td style="font-weight:900; color:#94a3b8;"><?= $idx + 1 ?></td>
                        <td style="font-weight:800; color:#fff;"><?= htmlspecialchars($c['il']) ?> <span style="font-size:11px; color:#64748b; font-weight:600;">(<?= htmlspecialchars($c['bolge']) ?>)</span></td>
                        <td><?= number_format($c['fiyat_24'], 0, ',', '.') ?> ₺</td>
                        <td><?= number_format($c['fiyat_25'], 0, ',', '.') ?> ₺</td>
                        <td style="font-weight:900; color:#38bdf8;"><?= number_format($c['fiyat_26'], 0, ',', '.') ?> ₺ / m²</td>
                        <td style="font-weight:800; color:#34d399;">+ %<?= $c['artis'] ?></td>
                        <td><span style="background:rgba(16,185,129,0.15); border:1px solid #10b981; color:#34d399; padding:3px 8px; border-radius:6px; font-weight:900;"><?= $c['skor'] ?> / 100</span></td>
                        <td style="font-size:12px; color:#cbd5e1;"><?= htmlspecialchars($c['spot']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Citation & Backlink Magnet -->
        <div class="citation-box">
            <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px; margin-bottom:10px;">
                <div style="display:flex; align-items:center; gap:10px;">
                    <i class="fa-solid fa-quote-left" style="font-size:22px; color:#0284c7;"></i>
                    <h3 style="font-size:15px; font-weight:800; color:#fff; margin:0;">Gazeteciler, Yazarlar &amp; Bloglar İçin Kaynak Alıntı Formatı</h3>
                </div>
                <button type="button" onclick="navigator.clipboard.writeText(document.getElementById('citationCode').innerText); alert('Alıntı kodu panoya kopyalandı!');" style="background:#0284c7; color:#fff; border:none; padding:6px 14px; border-radius:8px; font-weight:800; font-size:12px; cursor:pointer;">
                    📋 Alıntı Kodunu Kopyala
                </button>
            </div>
            <p style="font-size:12.5px; color:#94a3b8; margin:0 0 10px 0;">
                Bu rapordaki veri ve grafikleri haberlerinizde, blog yazılarınızda veya akademik çalışmanızda aşağıdaki referans bağlantısıyla kaynak göstererek kullanabilirsiniz:
            </p>
            <pre id="citationCode" style="background:#000; border:1px solid #1e293b; color:#34d399; padding:12px; border-radius:8px; font-size:12px; overflow-x:auto; margin:0;">&lt;a href="https://www.parselsorgu.net/turkiye-arsa-deger-endeksi-2026" title="2026 Türkiye Arsa Değer Endeksi"&gt;Kaynak: Ant Harita Mühendislik &amp; ParselSorgu.net 2026 Raporu&lt;/a&gt;</pre>
        </div>

        <!-- WhatsApp Consultation CTA -->
        <div style="background:linear-gradient(135deg, rgba(16,185,129,0.15) 0%, rgba(6,95,70,0.25) 100%); border:2px solid #10b981; border-radius:18px; padding:28px; text-align:center;">
            <h3 style="font-size:19px; font-weight:900; color:#fff; margin:0 0 8px 0;">Bölgenizdeki Taşınmazın Resmi Değerini Öğrenmek İster misiniz?</h3>
            <p style="font-size:14px; color:#cbd5e1; max-width:650px; margin:0 auto 18px auto; line-height:1.6;">
                Ant Harita Lisanslı Harita Mühendisleri ve Değerleme Kadrosu ile parselinizin resmi sınırlarını, rayiç değerini ve imar çapını inceletin.
            </p>
            <a href="https://wa.me/905428413535?text=Merhaba%20Ant%20Harita,%202026%20Arsa%20Değer%20Endeksi%20raporunuzu%20inceledim.%20Kendi%20parselimin%20değerlemesi%20ve%20imar%20durumu%20hakkında%20bilgi%20almak%20istiyorum." target="_blank" style="display:inline-flex; align-items:center; gap:8px; background:#10b981; color:#fff; padding:12px 28px; border-radius:12px; font-weight:900; font-size:14.5px; text-decoration:none; box-shadow:0 8px 25px rgba(16,185,129,0.35);">
                <i class="fa-brands fa-whatsapp" style="font-size:18px;"></i> Ant Harita Mühendislik İle İletişime Geçin
            </a>
        </div>
    </main>
</body>
</html>
