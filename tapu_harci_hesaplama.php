<?php
/**
 * 2026 Tapu Harcı, Döner Sermaye & Masraf Hesaplama Robotu
 * ParselSorgu.net
 */
require_once __DIR__ . '/seo_helper.php';
require_once __DIR__ . '/navbar.php';

$page_title = "2026 Tapu Harcı Hesaplama & Döner Sermaye | ParselSorgu";
$page_desc  = "2026 güncel mevzuatına uygun tapu harcı hesaplama (%2 alıcı + %2 satıcı), TKGM döner sermaye yöresel katsayıları ve masraf dökümü.";
$canonical_url = "https://www.parselsorgu.net/tapu-harci-hesaplama";
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($page_title) ?></title>
    <meta name="description" content="<?= htmlspecialchars($page_desc) ?>">
    <link rel="canonical" href="<?= $canonical_url ?>">
    <meta property="og:image" content="https://www.parselsorgu.net/assets/images/og-parsel.jpg">
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?= htmlspecialchars($page_title) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($page_desc) ?>">
    <meta property="og:url" content="<?= $canonical_url ?>">
    <meta name="twitter:card" content="summary_large_image">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="/assets/css/main.css?v=20261102">
    <style>
        :root {
            --bg-dark: #070b14;
            --card-bg: #0f172a;
            --border-col: #1e293b;
            --primary: #38bdf8;
            --primary-dark: #0284c7;
            --success: #22c55e;
            --warning: #f59e0b;
            --danger: #ef4444;
            --text-muted: #94a3b8;
        }
        body {
            background: var(--bg-dark);
            color: #f8fafc;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            margin: 0;
            padding: 0;
            line-height: 1.6;
        }
        .container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 24px 16px;
        }
        .hero-section {
            text-align: center;
            padding: 36px 16px 20px;
        }
        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(56, 189, 248, 0.12);
            color: var(--primary);
            border: 1px solid rgba(56, 189, 248, 0.3);
            border-radius: 999px;
            padding: 6px 16px;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 16px;
        }
        .hero-title {
            font-size: clamp(26px, 4vw, 38px);
            font-weight: 800;
            margin: 0 0 12px;
            background: linear-gradient(135deg, #ffffff 40%, #38bdf8 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .hero-subtitle {
            font-size: 15px;
            color: var(--text-muted);
            max-width: 760px;
            margin: 0 auto;
        }
        .grid-layout {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
            margin-top: 28px;
        }
        @media (max-width: 900px) {
            .grid-layout {
                grid-template-columns: 1fr;
            }
        }
        .card {
            background: var(--card-bg);
            border: 1px solid var(--border-col);
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3);
        }
        .card-header {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 18px;
            font-weight: 700;
            color: #f1f5f9;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 1px solid var(--border-col);
        }
        .card-header i {
            color: var(--primary);
        }
        .form-group {
            margin-bottom: 18px;
        }
        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #cbd5e1;
            margin-bottom: 8px;
        }
        .form-control, .form-select {
            width: 100%;
            padding: 12px 14px;
            background: #090e1a;
            border: 1px solid #1e293b;
            border-radius: 10px;
            color: #fff;
            font-size: 15px;
            box-sizing: border-box;
            transition: all 0.2s ease;
        }
        .form-control:focus, .form-select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.2);
        }
        .btn-calc {
            width: 100%;
            background: linear-gradient(135deg, #0284c7 0%, #38bdf8 100%);
            color: #030712;
            font-weight: 700;
            font-size: 16px;
            padding: 14px;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: transform 0.15s, box-shadow 0.15s;
        }
        .btn-calc:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px -4px rgba(56, 189, 248, 0.4);
        }
        .result-box {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
        }
        @media (max-width: 600px) {
            .stat-grid {
                grid-template-columns: 1fr;
            }
        }
        .stat-card {
            background: #090e1a;
            border: 1px solid #1e293b;
            border-radius: 12px;
            padding: 14px;
            text-align: center;
        }
        .stat-card.primary {
            border-color: rgba(56, 189, 248, 0.4);
            background: rgba(56, 189, 248, 0.05);
        }
        .stat-card.seller {
            border-color: rgba(245, 158, 11, 0.4);
            background: rgba(245, 158, 11, 0.05);
        }
        .stat-card.total {
            border-color: rgba(34, 197, 94, 0.4);
            background: rgba(34, 197, 94, 0.05);
        }
        .stat-card .label {
            font-size: 12px;
            color: var(--text-muted);
            margin-bottom: 6px;
            font-weight: 600;
        }
        .stat-card .val {
            font-size: 20px;
            font-weight: 800;
            color: #fff;
        }
        .table-responsive {
            overflow-x: auto;
        }
        .cost-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13.5px;
            margin-top: 10px;
        }
        .cost-table th, .cost-table td {
            padding: 10px 12px;
            text-align: left;
            border-bottom: 1px solid #1e293b;
        }
        .cost-table th {
            color: var(--text-muted);
            font-weight: 600;
            background: #090e1a;
        }
        .cost-table td.amount {
            text-align: right;
            font-weight: 700;
            color: #e2e8f0;
        }
        .cost-table tr.total-row {
            background: rgba(56, 189, 248, 0.08);
            font-weight: 800;
        }
        .cost-table tr.total-row td {
            border-top: 2px solid #38bdf8;
            border-bottom: none;
            color: #38bdf8;
        }
        .share-actions {
            display: flex;
            gap: 12px;
            margin-top: 16px;
        }
        .btn-action {
            flex: 1;
            padding: 12px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
            border: 1px solid #1e293b;
            transition: all 0.2s ease;
        }
        .btn-whatsapp {
            background: #15803d;
            color: #fff;
            border-color: #22c55e;
        }
        .btn-whatsapp:hover {
            background: #16a34a;
        }
        .btn-print {
            background: #1e293b;
            color: #f1f5f9;
        }
        .btn-print:hover {
            background: #334155;
        }
        .info-box {
            background: rgba(245, 158, 11, 0.08);
            border: 1px solid rgba(245, 158, 11, 0.25);
            border-radius: 12px;
            padding: 16px;
            font-size: 13px;
            color: #fde68a;
            margin-top: 24px;
            line-height: 1.6;
        }
        .info-box strong {
            color: #f59e0b;
        }
        .faq-section {
            margin-top: 48px;
        }
        .faq-item {
            background: var(--card-bg);
            border: 1px solid var(--border-col);
            border-radius: 12px;
            padding: 16px 20px;
            margin-bottom: 12px;
        }
        .faq-item h3 {
            font-size: 16px;
            margin: 0 0 8px;
            color: #f1f5f9;
        }
        .faq-item p {
            margin: 0;
            font-size: 14px;
            color: var(--text-muted);
        }
        @media print {
            .navbar, .hero-section, .share-actions, .info-box, .faq-section, .btn-calc {
                display: none !important;
            }
            body {
                background: #fff !important;
                color: #000 !important;
            }
            .card {
                box-shadow: none !important;
                border: 1px solid #ccc !important;
                background: #fff !important;
                color: #000 !important;
            }
            .cost-table th, .cost-table td {
                color: #000 !important;
                border-bottom: 1px solid #ccc !important;
            }
            .stat-card {
                background: #f8fafc !important;
                border: 1px solid #ccc !important;
            }
            .stat-card .val {
                color: #000 !important;
            }
        }
    </style>
<?php
$tapu_faq_items = [
    [
        "@type" => "Question",
        "name" => "2026 tapu harcı oranı yüzde kaçtır ve kim öder?",
        "acceptedAnswer" => [
            "@type" => "Answer",
            "text" => "492 sayılı Harçlar Kanunu uyarınca gayrimenkul devir ve iktisaplarında tapu harcı oranı toplam %4'tür. Kanunen alıcıdan %2 ve satıcıdan %2 olmak üzere tahsil edilir. Ancak taraflar kendi aralarında anlaşarak harcın tamamını bir tarafa yükleyebilir."
        ]
    ],
    [
        "@type" => "Question",
        "name" => "2026 yılı TKGM döner sermaye bedeli ne kadardır?",
        "acceptedAnswer" => [
            "@type" => "Answer",
            "text" => "Tapu ve Kadastro Genel Müdürlüğü (TKGM) döner sermaye ücreti yöresel katsayılara göre hesaplanır. 2026 yılında maktu harç bedeli ortalama 1.250 TL ile 3.850 TL arasında değişmektedir."
        ]
    ],
    [
        "@type" => "Question",
        "name" => "Tapuda satış bedelini rayiç bedelden düşük göstermenin cezası nedir?",
        "acceptedAnswer" => [
            "@type" => "Answer",
            "text" => "Eksik beyan edilen tapu harcı tutarı vergi dairesince %25 vergi ziyaı cezası ve gecikme faizi ile birlikte alıcı ve satıcıdan müştereken ve müteselsilen tahsil edilir."
        ]
    ]
];

$tapu_app_schema = [
    "@context" => "https://schema.org",
    "@type" => "WebApplication",
    "name" => "2026 Tapu Harcı & Döner Sermaye Hesaplama Robotu",
    "applicationCategory" => "FinanceApplication",
    "operatingSystem" => "All",
    "url" => "https://www.parselsorgu.net/tapu-harci-hesaplama",
    "description" => "2026 güncel mevzuatına uygun alıcı ve satıcı tapu harcı (%2 + %2), TKGM döner sermaye ve emlak masraf hesaplama simülatörü.",
    "offers" => ["@type" => "Offer", "price" => "0", "priceCurrency" => "TRY"],
    "provider" => ["@type" => "Organization", "name" => "Ant Harita Mühendislik", "url" => "https://www.parselsorgu.net"]
];

$tapu_faq_schema = [
    "@context" => "https://schema.org",
    "@type" => "FAQPage",
    "mainEntity" => $tapu_faq_items
];

$tapu_breadcrumb_schema = [
    "@context" => "https://schema.org",
    "@type" => "BreadcrumbList",
    "itemListElement" => [
        ["@type" => "ListItem", "position" => 1, "name" => "Ana Sayfa", "item" => "https://www.parselsorgu.net/"],
        ["@type" => "ListItem", "position" => 2, "name" => "Tapu Harcı Hesaplama", "item" => "https://www.parselsorgu.net/tapu-harci-hesaplama"]
    ]
];
?>
    <!-- Schema.org JSON-LD -->
    <script type="application/ld+json"><?= json_encode($tapu_app_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>
    <script type="application/ld+json"><?= json_encode($tapu_faq_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>
    <script type="application/ld+json"><?= json_encode($tapu_breadcrumb_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>

    <link rel="alternate" type="text/markdown" href="https://www.parselsorgu.net/llms.txt" title="ParselSorgu AI / LLM Bilgi Bankası">
    <link rel="alternate" type="application/json" href="https://www.parselsorgu.net/api/2026-kadastro-endeks.json" title="2026 Kadastro ve İmar Açık Veri Seti">
    <script type="application/ld+json">{"@context": "https://schema.org", "@type": "WebPage", "speakable": {"@type": "SpeakableSpecification", "cssSelector": ["h1", ".lead", ".summary-box", ".hero-desc", "main p"]}, "isBasedOn": "https://www.parselsorgu.net/api/2026-kadastro-endeks.json", "publisher": {"@type": "Organization", "name": "Ant Harita Mühendislik - ParselSorgu.net", "url": "https://www.parselsorgu.net/"}}</script>
</head>
<body>
    <?php render_saas_navbar(); ?>

    <div class="container">
        <div class="hero-section">
            <div class="hero-badge">
                <i class="fa-solid fa-calculator"></i> 2026 Güncel Tapu Mevzuatı & Katsayıları
            </div>
            <h1 class="hero-title">2026 Tapu Harcı Hesaplama &amp; Döner Sermaye Robotu</h1>
            <p class="hero-subtitle">
                Gayrimenkul alım-satımında ödeyeceğiniz alıcı ve satıcı tapu harcı (%2 + %2), TKGM döner sermaye bedeli ve emlakçı komisyonunu saniyeler içinde kuruşu kuruşuna hesaplayın.
            </p>
        </div>

        <div class="grid-layout">
            <!-- Sol Form -->
            <div class="card">
                <div class="card-header">
                    <i class="fa-solid fa-sliders"></i> Taşınmaz & Satış Parametreleri
                </div>

                <div class="form-group">
                    <label class="form-label" for="priceInput">Gerçek Satış / Beyan Bedeli (TL)</label>
                    <div style="position: relative;">
                        <input type="text" id="priceInput" class="form-control" placeholder="Örn: 3.500.000" value="3.500.000" style="padding-left: 36px; font-weight: 700;">
                        <span style="position: absolute; left: 14px; top: 12px; color: var(--primary); font-weight: 700;">₺</span>
                    </div>
                    <small style="color: var(--text-muted); font-size: 11.5px; display: block; margin-top: 4px;">
                        *Belediye rayiç bedelinin altında beyan edilemez.
                    </small>
                </div>

                <div class="form-group">
                    <label class="form-label" for="propertyType">Taşınmaz Türü</label>
                    <select id="propertyType" class="form-select">
                        <option value="konut" selected>Konut / Daire</option>
                        <option value="arsa">Arsa / Arazi / Tarla</option>
                        <option value="isyeri">İşyeri / Ofis / Dükkan</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="cityGroup">İl / Döner Sermaye Bölgesi (2026 Katsayısı)</label>
                    <select id="cityGroup" class="form-select">
                        <option value="istanbul" selected>İstanbul (3x Katsayı - ~2.180 TL)</option>
                        <option value="buyuk_2">Ankara, İzmir, Bursa, Antalya, Kocaeli (2x - ~1.450 TL)</option>
                        <option value="buyuk_15">Diğer Büyükşehirler (1.5x - ~1.090 TL)</option>
                        <option value="diger">Diğer İller (1x - ~725 TL)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="paySplit">Tapu Harcını Kim Ödeyecek?</label>
                    <select id="paySplit" class="form-select">
                        <option value="legal" selected>Yasal Paylaşım (%2 Alıcı + %2 Satıcı)</option>
                        <option value="buyer">Tamamını Alıcı Öder (%4 Alıcı)</option>
                        <option value="seller">Tamamını Satıcı Öder (%4 Satıcı)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="realtorFee">Emlakçı Hizmet Bedeli</label>
                    <select id="realtorFee" class="form-select">
                        <option value="legal" selected>Yasal Oran (%2 Alıcı + %2 Satıcı + %20 KDV)</option>
                        <option value="buyer_only">Sadece Alıcı (%2 + KDV)</option>
                        <option value="none">Emlakçı Yok / Sahibinden (0 TL)</option>
                    </select>
                </div>

                <button type="button" class="btn-calc" onclick="calculateTapu()">
                    <i class="fa-solid fa-arrows-rotate"></i> Hesapla & Dökümü Güncelle
                </button>
            </div>

            <!-- Sağ Sonuç -->
            <div class="card result-box">
                <div class="card-header">
                    <i class="fa-solid fa-receipt"></i> 2026 Masraf Dökümü
                </div>

                <div class="stat-grid">
                    <div class="stat-card primary">
                        <div class="label">Alıcı Masrafı</div>
                        <div class="val" id="dispBuyerTotal">0 ₺</div>
                    </div>
                    <div class="stat-card seller">
                        <div class="label">Satıcı Masrafı</div>
                        <div class="val" id="dispSellerTotal">0 ₺</div>
                    </div>
                    <div class="stat-card total">
                        <div class="label">Toplam Masraf</div>
                        <div class="val" id="dispGrandTotal">0 ₺</div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="cost-table">
                        <thead>
                            <tr>
                                <th>Kalem Açıklaması</th>
                                <th style="text-align: right;">Alıcı Payı</th>
                                <th style="text-align: right;">Satıcı Payı</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Tapu Harcı (%2 / %2)</td>
                                <td class="amount" id="rowBuyerHarcli">0 ₺</td>
                                <td class="amount" id="rowSellerHarcli">0 ₺</td>
                            </tr>
                            <tr>
                                <td>TKGM Döner Sermaye Bedeli</td>
                                <td class="amount" id="rowBuyerDoner">0 ₺</td>
                                <td class="amount" id="rowSellerDoner">0 ₺</td>
                            </tr>
                            <tr>
                                <td>Emlakçı Komisyonu (Net)</td>
                                <td class="amount" id="rowBuyerRealtor">0 ₺</td>
                                <td class="amount" id="rowSellerRealtor">0 ₺</td>
                            </tr>
                            <tr>
                                <td>Emlakçı KDV (%20)</td>
                                <td class="amount" id="rowBuyerKdv">0 ₺</td>
                                <td class="amount" id="rowSellerKdv">0 ₺</td>
                            </tr>
                            <tr class="total-row">
                                <td>NET GENEL TOPLAM</td>
                                <td class="amount" id="rowSubBuyerTotal">0 ₺</td>
                                <td class="amount" id="rowSubSellerTotal">0 ₺</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="share-actions">
                    <button class="btn-action btn-whatsapp" onclick="shareWhatsApp()">
                        <i class="fa-brands fa-whatsapp"></i> WhatsApp ile Gönder
                    </button>
                    <button class="btn-action btn-print" onclick="window.print()">
                        <i class="fa-solid fa-print"></i> Yazdır / PDF
                    </button>
                </div>
            </div>
        </div>

        <div class="info-box">
            <strong><i class="fa-solid fa-triangle-exclamation"></i> 2026 Gelir İdaresi (GİB) Önemli Uyarısı:</strong><br>
            Tapu satış bedelinin gerçekte ödenen tutardan daha düşük gösterilmesi (harçtan kaçınma) durumunda, hem alıcıya hem satıcıya aradaki fark üzerinden %25 vergi ziyaı cezası ve gecikme faizi uygulanır. Banka havalesi ve konut kredisi tutarlarının tapu beyan bedeliyle birebir uyumlu olması zorunludur.
        </div>

        <!-- SSS -->
        <div class="faq-section">
            <h2 style="font-size: 22px; font-weight: 700; margin-bottom: 18px; color: #f8fafc;">
                <i class="fa-solid fa-circle-question" style="color: var(--primary);"></i> Sıkça Sorulan Sorular
            </h2>

            <div class="faq-item">
                <h3>Tapu harcını kim öder? Yasal kural nedir?</h3>
                <p>492 Sayılı Harçlar Kanunu'na göre aksi kararlaştırılmadıkça tapu harcı alıcı ve satıcı tarafından eşit olarak (%2 alıcı, %2 satıcı) ödenir. Ancak piyasa teamüllerinde taraflar anlaşarak harcın tamamını alıcıya devredebilir.</p>
            </div>

            <div class="faq-item">
                <h3>TKGM Döner Sermaye bedeli 2026'da ne kadar?</h3>
                <p>Döner sermaye bedeli her yıl yeniden değerleme oranında güncellenir. 2026 yılı için baz tarife yaklaşık 725 TL olup il katsayılarına göre İstanbul'da 3 katı (~2.180 TL), Ankara/İzmir gibi illerde 2 katı (~1.450 TL) olarak uygulanır. Teamülen alıcı tarafından ödenir.</p>
            </div>

            <div class="faq-item">
                <h3>Yasal emlakçı komisyonu üst sınırı nedir?</h3>
                <p>Taşınmaz Ticareti Hakkında Yönetmelik gereğince yetki belgeli emlak işletmeleri, satış bedelinin %2'si + %20 KDV alıcıdan, %2'si + %20 KDV satıcıdan olmak üzere toplamda en fazla %4 + KDV komisyon talep edebilir.</p>
            </div>
        </div>
    </div>

    <script>
        const donerRates = {
            'istanbul': 2180,
            'buyuk_2': 1450,
            'buyuk_15': 1090,
            'diger': 725
        };

        function formatNumber(num) {
            return Math.round(num).toLocaleString('tr-TR');
        }

        function parsePrice(val) {
            return parseFloat(val.replace(/\./g, '').replace(/,/g, '.')) || 0;
        }

        const priceInput = document.getElementById('priceInput');
        priceInput.addEventListener('input', function(e) {
            let val = this.value.replace(/\D/g, '');
            if (val) {
                this.value = parseInt(val, 10).toLocaleString('tr-TR');
            }
            calculateTapu();
        });

        function calculateTapu() {
            const price = parsePrice(priceInput.value);
            const cityGroup = document.getElementById('cityGroup').value;
            const paySplit = document.getElementById('paySplit').value;
            const realtorFee = document.getElementById('realtorFee').value;

            // Harç
            let buyerHarcli = 0;
            let sellerHarcli = 0;
            if (paySplit === 'legal') {
                buyerHarcli = price * 0.02;
                sellerHarcli = price * 0.02;
            } else if (paySplit === 'buyer') {
                buyerHarcli = price * 0.04;
                sellerHarcli = 0;
            } else if (paySplit === 'seller') {
                buyerHarcli = 0;
                sellerHarcli = price * 0.04;
            }

            // Döner Sermaye (Teamülen Alıcı öder)
            const donerBase = donerRates[cityGroup] || 1450;
            const buyerDoner = donerBase;
            const sellerDoner = 0;

            // Emlakçı
            let buyerRealtor = 0;
            let sellerRealtor = 0;
            let buyerKdv = 0;
            let sellerKdv = 0;

            if (realtorFee === 'legal') {
                buyerRealtor = price * 0.02;
                sellerRealtor = price * 0.02;
                buyerKdv = buyerRealtor * 0.20;
                sellerKdv = sellerRealtor * 0.20;
            } else if (realtorFee === 'buyer_only') {
                buyerRealtor = price * 0.02;
                sellerRealtor = 0;
                buyerKdv = buyerRealtor * 0.20;
                sellerKdv = 0;
            }

            const buyerTotal = buyerHarcli + buyerDoner + buyerRealtor + buyerKdv;
            const sellerTotal = sellerHarcli + sellerDoner + sellerRealtor + sellerKdv;
            const grandTotal = buyerTotal + sellerTotal;

            // Render kartlar
            document.getElementById('dispBuyerTotal').innerText = formatNumber(buyerTotal) + ' ₺';
            document.getElementById('dispSellerTotal').innerText = formatNumber(sellerTotal) + ' ₺';
            document.getElementById('dispGrandTotal').innerText = formatNumber(grandTotal) + ' ₺';

            // Render tablo
            document.getElementById('rowBuyerHarcli').innerText = formatNumber(buyerHarcli) + ' ₺';
            document.getElementById('rowSellerHarcli').innerText = formatNumber(sellerHarcli) + ' ₺';
            document.getElementById('rowBuyerDoner').innerText = formatNumber(buyerDoner) + ' ₺';
            document.getElementById('rowSellerDoner').innerText = formatNumber(sellerDoner) + ' ₺';
            document.getElementById('rowBuyerRealtor').innerText = formatNumber(buyerRealtor) + ' ₺';
            document.getElementById('rowSellerRealtor').innerText = formatNumber(sellerRealtor) + ' ₺';
            document.getElementById('rowBuyerKdv').innerText = formatNumber(buyerKdv) + ' ₺';
            document.getElementById('rowSellerKdv').innerText = formatNumber(sellerKdv) + ' ₺';
            document.getElementById('rowSubBuyerTotal').innerText = formatNumber(buyerTotal) + ' ₺';
            document.getElementById('rowSubSellerTotal').innerText = formatNumber(sellerTotal) + ' ₺';
        }

        function shareWhatsApp() {
            const price = priceInput.value;
            const buyer = document.getElementById('dispBuyerTotal').innerText;
            const seller = document.getElementById('dispSellerTotal').innerText;
            const total = document.getElementById('dispGrandTotal').innerText;

            const text = `🏡 *2026 Tapu Harcı & Masraf Hesaplama Özeti*\n` +
                         `━━━━━━━━━━━━━━━━━━━━━━\n` +
                         `💰 *Satış Bedeli:* ${price} ₺\n` +
                         `👤 *Alıcı Masrafı:* ${buyer}\n` +
                         `💼 *Satıcı Masrafı:* ${seller}\n` +
                         `📑 *Genel Toplam Masraf:* ${total}\n` +
                         `━━━━━━━━━━━━━━━━━━━━━━\n` +
                         `Detaylı döküm ve döner sermaye hesabı için:\n` +
                         `https://www.parselsorgu.net/tapu-harci-hesaplama`;

            window.open('https://api.whatsapp.com/send?text=' + encodeURIComponent(text), '_blank');
        }

        // İlk hesaplama
        window.addEventListener('DOMContentLoaded', calculateTapu);
    </script>
</body>
</html>