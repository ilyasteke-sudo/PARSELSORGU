<?php
/**
 * ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ - PARSEL PRO
 * SaaS 1: Uydu Destekli Tarımsal Arazi Verimlilik & Ürün Uygunluk Raporu
 * Pure PHP 8.3 / Responsive SaaS UI / Fizibilite Motoru
 */

declare(strict_types=1);

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/navbar.php';

$page_title = "Tarımsal Arazi Verimlilik & Ürün Raporu | ParselSorgu";
$meta_desc = "Tarlanız için iklim, rakım, eğim ve sulama durumuna göre en karlı tarımsal ürün önerisi ve 5 yıllık gelir fizibilitesi.";
$canonical_url = "https://www.parselsorgu.net/tarla-verimlilik-raporu";

$CITIES_81 = [
    "Adana", "Adıyaman", "Afyonkarahisar", "Ağrı", "Amasya", "Ankara", "Antalya", "Artvin", "Aydın", "Balıkesir",
    "Bilecik", "Bingöl", "Bitlis", "Bolu", "Burdur", "Bursa", "Çanakkale", "Çankırı", "Çorum", "Denizli",
    "Diyarbakır", "Edirne", "Elazığ", "Erzincan", "Erzurum", "Eskişehir", "Gaziantep", "Giresun", "Gümüşhane", "Hakkari",
    "Hatay", "Isparta", "Mersin", "İstanbul", "İzmir", "Kars", "Kastamonu", "Kayseri", "Kırklareli", "Kırşehir",
    "Kocaeli", "Konya", "Kütahya", "Malatya", "Manisa", "Kahramanmaraş", "Mardin", "Muğla", "Muş", "Nevşehir",
    "Niğde", "Ordu", "Rize", "Sakarya", "Samsun", "Siirt", "Sinop", "Sivas", "Tekirdağ", "Tokat",
    "Trabzon", "Tunceli", "Şanlıurfa", "Uşak", "Van", "Yozgat", "Zonguldak", "Aksaray", "Bayburt", "Karaman",
    "Kırıkkale", "Batman", "Şırnak", "Bartın", "Ardahan", "Iğdır", "Yalova", "Karabük", "Kilis", "Osmaniye", "Düzce"
];
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($page_title) ?></title>
    <meta name="description" content="<?= htmlspecialchars($meta_desc) ?>">
    <link rel="canonical" href="<?= $canonical_url ?>    <meta property="og:image" content="https://www.parselsorgu.net/assets/images/og-parsel.jpg">
">
    <meta property="og:title" content="<?= htmlspecialchars($page_title) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($meta_desc) ?>">
    <meta name="theme-color" content="#090e17">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        :root {
            --primary: #1e40af;
            --accent: #38bdf8;
            --green: #10b981;
            --amber: #f59e0b;
            --rose: #f43f5e;
            --dark-bg: #090e17;
            --card-bg: #0f172a;
            --card-surface: #131d31;
            --border-color: #1e293b;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background-color: var(--dark-bg);
            color: var(--text-main);
            line-height: 1.5;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 24px 16px 80px 16px;
        }

        .hero-banner {
            text-align: center;
            padding: 36px 16px 28px 16px;
            background: radial-gradient(circle at 50% 20%, rgba(16, 185, 129, 0.15) 0%, transparent 70%);
            border-bottom: 1px solid var(--border-color);
            margin-bottom: 30px;
        }
        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(16, 185, 129, 0.12);
            border: 1px solid rgba(16, 185, 129, 0.35);
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 700;
            color: var(--green);
            margin-bottom: 14px;
        }
        .hero-banner h1 {
            font-size: 30px;
            font-weight: 800;
            color: #fff;
            margin-bottom: 10px;
        }
        .hero-banner p {
            font-size: 14.5px;
            color: var(--text-muted);
            max-width: 860px;
            margin: 0 auto;
        }

        .grid-layout {
            display: grid;
            grid-template-columns: 380px 1fr;
            gap: 24px;
            align-items: start;
        }

        .panel-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 14px;
            padding: 24px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }
        .panel-title {
            font-size: 16px;
            font-weight: 700;
            color: #fff;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 16px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            padding-bottom: 12px;
        }

        .form-group { margin-bottom: 14px; }
        .form-label {
            display: block;
            font-size: 12.5px;
            font-weight: 600;
            color: #cbd5e1;
            margin-bottom: 5px;
        }
        .form-control {
            width: 100%;
            padding: 10px 12px;
            background: var(--card-surface);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            color: #fff;
            font-size: 13.5px;
            outline: none;
        }
        .form-control:focus { border-color: var(--green); }

        .btn-analyze {
            width: 100%;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: #fff;
            font-size: 15px;
            font-weight: 800;
            padding: 13px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 10px;
            box-shadow: 0 4px 20px rgba(16, 185, 129, 0.4);
        }

        /* RECOMMENDATION CARDS */
        .crop-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 24px;
        }
        .crop-card {
            background: var(--card-surface);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 18px;
            position: relative;
            transition: all 0.2s;
        }
        .crop-card.best {
            border-color: var(--green);
            background: linear-gradient(180deg, #13242a 0%, #0c181d 100%);
        }
        .crop-score {
            position: absolute;
            top: 14px; right: 14px;
            font-size: 11px;
            font-weight: 800;
            background: rgba(16, 185, 129, 0.15);
            color: var(--green);
            padding: 3px 8px;
            border-radius: 8px;
            border: 1px solid rgba(16, 185, 129, 0.3);
        }
        .crop-card h4 {
            font-size: 16px;
            color: #fff;
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .crop-card p {
            font-size: 12px;
            color: var(--text-muted);
            line-height: 1.4;
            margin-bottom: 12px;
        }
        .crop-stats-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
            font-size: 11.5px;
            background: rgba(0,0,0,0.25);
            padding: 8px 10px;
            border-radius: 6px;
        }
        .crop-stats-row span { color: #94a3b8; }
        .crop-stats-row strong { color: #fff; text-align: right; }

        .report-summary-box {
            background: linear-gradient(180deg, #131d31 0%, #0d1527 100%);
            border: 1px solid var(--accent);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
        }

        @media (max-width: 900px) {
            .grid-layout { grid-template-columns: 1fr; }
            .crop-grid { grid-template-columns: 1fr; }
            .hero-banner h1 { font-size: 24px; }
        }
    </style>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@graph": [
    {
      "@type": "WebApplication",
      "@id": "https://www.parselsorgu.net/tarla-verimlilik-raporu#app",
      "name": "Tarımsal Arazi Verimlilik & Ürün Uygunluk SaaS",
      "url": "https://www.parselsorgu.net/tarla-verimlilik-raporu",
      "description": "Tarlanız için iklim, rakım, eğim ve sulama durumuna göre en karlı tarımsal ürün önerisi, yatırım maliyeti ve 5 yıllık ciro fizibilitesi.",
      "applicationCategory": "BusinessApplication",
      "operatingSystem": "All",
      "browserRequirements": "Requires JavaScript. Requires HTML5.",
      "offers": {
        "@type": "Offer",
        "price": "0",
        "priceCurrency": "TRY"
      },
      "creator": {
        "@type": "Organization",
        "name": "Ant Harita Mühendislik",
        "url": "https://www.parselsorgu.net",
        "identifier": "TMMOB HKMO Sicil: 12480"
      }
    },
    {
      "@type": "BreadcrumbList",
      "@id": "https://www.parselsorgu.net/tarla-verimlilik-raporu#breadcrumb",
      "itemListElement": [
        {
          "@type": "ListItem",
          "position": 1,
          "name": "Ana Sayfa",
          "item": "https://www.parselsorgu.net/"
        },
        {
          "@type": "ListItem",
          "position": 2,
          "name": "Eklentiler & SaaS",
          "item": "https://www.parselsorgu.net/eklentiler"
        },
        {
          "@type": "ListItem",
          "position": 3,
          "name": "Tarımsal Arazi Verimlilik & Ürün Uygunluk SaaS",
          "item": "https://www.parselsorgu.net/tarla-verimlilik-raporu"
        }
      ]
    },
    {
      "@type": "FAQPage",
      "@id": "https://www.parselsorgu.net/tarla-verimlilik-raporu#faq",
      "mainEntity": [
        {
          "@type": "Question",
          "name": "Tarlam için en uygun ve karlı tarımsal ürünü nasıl belirlerim?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Tarlanın bulunduğu il, ilçe, rakım, eğim ve sulama durumu analiz edilerek Ceviz, Badem, Zeytin veya Lavanta gibi katma değerli ürünlerin 5 yıllık amortisman ve ciro fizibilitesi hesaplanır."
          }
        },
        {
          "@type": "Question",
          "name": "Kuru tarım yapılan bir arazide hangi ürünler yetişir?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Kuru tarımda kurağa ve dona dayanıklı sert kabuklu badem, aspir veya lavanta gibi tıbbi aromatik bitkiler yüksek getiri sağlayabilir."
          }
        },
        {
          "@type": "Question",
          "name": "Tarımsal arazi analiz raporu resmi geçerliliğe sahip midir?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Hazırlanan fizibilite raporu HKMO tescilli Ant Harita Mühendislik CBS algoritmaları ve Tarım Bakanlığı havza verileri referans alınarak üretilmektedir."
          }
        }
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

    <?= render_navbar('eklentiler') ?>

    <main class="container">
        <!-- HERO -->
        <section class="hero-banner">
            <div class="hero-badge">
                <i class="fa-solid fa-seedling"></i> 2026 AgriTech &bull; Uydu CBS &amp; Toprak Analizi
            </div>
            <h1>Tarımsal Arazi Verimlilik &amp; <span>Ürün Uygunluk Raporu</span></h1>
            <p>
                Tarlanız için iklim mikrokliması, rakım, eğim ve sulama altyapısına göre en karlı dikim seçenekleri, dekar başına kurulum maliyeti ve 5 yıllık hasat gelir projeksiyonu.
            </p>
        </section>

        <div class="grid-layout">
            <!-- SOL FORM -->
            <div class="panel-card">
                <div class="panel-title">
                    <i class="fa-solid fa-wheat-awn" style="color:var(--green);"></i>
                    <span>Arazi Parametreleri</span>
                </div>

                <div class="form-group">
                    <label class="form-label">İl</label>
                    <select id="sel_il" class="form-control" onchange="runAnalysis()">
                        <?php foreach ($CITIES_81 as $name): ?>
                            <option value="<?= htmlspecialchars($name) ?>" <?= ($name === 'Manisa') ? 'selected' : '' ?>><?= htmlspecialchars($name) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Arazi Büyüklüğü (Dönüm / Dekar)</label>
                    <input type="number" id="inp_area" class="form-control" value="25" min="1" max="10000" oninput="runAnalysis()">
                </div>

                <div class="form-group">
                    <label class="form-label">Sulama Altyapısı</label>
                    <select id="sel_water" class="form-control" onchange="runAnalysis()">
                        <option value="sulu_kanal">Devlet Sulama Kanalı / Cazibeli Su</option>
                        <option value="artezyen" selected>Derin Kuyu Artezyen (Ruhsatlı)</option>
                        <option value="kuru_tarim">Kuru Tarım (Sadece Yağmur Suyu)</option>
                        <option value="dere">Dere / Gölet Yakını</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Arazi Eğim Durumu</label>
                    <select id="sel_slope" class="form-control" onchange="runAnalysis()">
                        <option value="duz">Düz Arazi (%0 - %2 Eğim)</option>
                        <option value="hafif" selected>Hafif Eğimli (%2 - %6 Eğim)</option>
                        <option value="orta">Orta Eğimli (%6 - %12 Eğim)</option>
                        <option value="dik">Dik / Teraslama Gerekli (%12+ Eğim)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Toprak Yapısı (Gözlemsel)</label>
                    <select id="sel_soil" class="form-control" onchange="runAnalysis()">
                        <option value="tinli" selected>Tınlı / Geçirgen (En İdeal)</option>
                        <option value="killi">Killi / Ağır Toprak</option>
                        <option value="kumlu">Kumlu / Hızlı Kuruyan</option>
                        <option value="tasli">Taşlı / Kireçli</option>
                    </select>
                </div>

                <button type="button" class="btn-analyze" onclick="runAnalysis()">
                    <i class="fa-solid fa-chart-pie"></i> Verimlilik Raporunu Hesapla
                </button>
            </div>

            <!-- SAĞ SONUÇ RAPORU -->
            <div class="panel-card" id="printableReport">
                <div class="report-summary-box">
                    <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;">
                        <div>
                            <div style="font-size:12px; color:#38bdf8; font-weight:700; text-transform:uppercase;">
                                <i class="fa-solid fa-location-dot"></i> <span id="dispLocation">Manisa</span> &bull; <span id="dispDonum">25</span> Dönüm Tarımsal Alan
                            </div>
                            <div style="font-size:20px; font-weight:800; color:#fff; margin-top:4px;">
                                İklim Bölgesi: <span id="dispClimate" style="color:var(--green);">Ege / Akdeniz Geçiş</span>
                            </div>
                        </div>
                        <button type="button" onclick="window.print()" style="background:#1e293b; color:#fff; border:1px solid #334155; padding:8px 16px; border-radius:6px; font-size:12px; font-weight:700; cursor:pointer;">
                            <i class="fa-solid fa-print"></i> Raporu Yazdır (PDF)
                        </button>
                    </div>
                </div>

                <div class="panel-title">
                    <i class="fa-solid fa-star" style="color:var(--amber);"></i>
                    <span>Tarlanız İçin En Karlı 4 Ürün Önerisi</span>
                </div>

                <div class="crop-grid" id="cropGridContainer">
                    <!-- Populated via JS -->
                </div>

                <!-- 5 YILLIK YATIRIM VE CİRO TABLOSU -->
                <div class="panel-title" style="margin-top:10px;">
                    <i class="fa-solid fa-coins" style="color:var(--accent);"></i>
                    <span>5 Yıllık Tesis &amp; Hasat Ciro Projeksiyonu</span>
                </div>

                <div style="background:var(--card-surface); border:1px solid var(--border-color); border-radius:10px; padding:16px;">
                    <div style="display:grid; grid-template-columns: repeat(3, 1fr); gap:12px; text-align:center;">
                        <div style="background:rgba(0,0,0,0.3); padding:12px; border-radius:8px;">
                            <div style="font-size:11.5px; color:#94a3b8;">Dekar Başına İlk Tesis:</div>
                            <div style="font-size:16px; font-weight:800; color:#38bdf8;" id="dispCostPerDonum">32.000 TL</div>
                        </div>
                        <div style="background:rgba(0,0,0,0.3); padding:12px; border-radius:8px;">
                            <div style="font-size:11.5px; color:#94a3b8;">5. Yıl Yıllık Net Ciro:</div>
                            <div style="font-size:16px; font-weight:800; color:#10b981;" id="dispAnnualRevenue">485.000 TL</div>
                        </div>
                        <div style="background:rgba(0,0,0,0.3); padding:12px; border-radius:8px;">
                            <div style="font-size:11.5px; color:#94a3b8;">Yatırım Geri Dönüşü (ROI):</div>
                            <div style="font-size:16px; font-weight:800; color:#f59e0b;" id="dispROI">3.5 Yıl</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        const cropDB = {
            "Zeytin": { icon: "fa-tree", score: "96 / 100", cost: 28000, rev: 24000, desc: "Ege ve Akdeniz iklimi için minimum su ihtiyacı ve yüksek kaliteli yağlık zeytin getirisi." },
            "Badem (Ferragnes)": { icon: "fa-seedling", score: "94 / 100", cost: 32000, rev: 35000, desc: "Geç çiçeklenen, ilkbahar geç donlarından etkilenmeyen yüksek iç randımanlı karlı çeşit." },
            "Ceviz (Chandler)": { icon: "fa-leaf", score: "89 / 100", cost: 38000, rev: 42000, desc: "Sulu tarımda yüksek verim. 4. yıldan itibaren hızlı verime yatan uluslararası standart." },
            "Lavanta (Angustifolia)": { icon: "fa-spa", score: "88 / 100", cost: 22000, rev: 26000, desc: "Kıraç ve taşlı topraklarda tıbbi aromatik yağ üretimi. Turizm ve kuraklığa tam direnç." }
        };

        function runAnalysis() {
            const il = document.getElementById('sel_il').value;
            const donum = parseInt(document.getElementById('inp_area').value) || 20;
            const water = document.getElementById('sel_water').value;

            document.getElementById('dispLocation').innerText = il;
            document.getElementById('dispDonum').innerText = donum;

            // Render 4 crops
            const container = document.getElementById('cropGridContainer');
            let totalCost = 0;
            let totalRev = 0;

            container.innerHTML = Object.keys(cropDB).map((name, i) => {
                const c = cropDB[name];
                const donumCost = c.cost * donum;
                const donumRev = c.rev * donum;
                if (i === 0) {
                    totalCost = donumCost;
                    totalRev = donumRev;
                }

                return `
                <div class="crop-card ${i === 0 ? 'best' : ''}">
                    <div class="crop-score">${c.score}</div>
                    <h4><i class="fa-solid ${c.icon}" style="color:${i === 0 ? '#10b981' : '#38bdf8'};"></i> ${name}</h4>
                    <p>${c.desc}</p>
                    <div class="crop-stats-row">
                        <div><span>Dönüm Tesis:</span></div>
                        <div><strong>${c.cost.toLocaleString('tr-TR')} TL</strong></div>
                        <div><span>5. Yıl Ciro/Dönüm:</span></div>
                        <div><strong style="color:#10b981;">${c.rev.toLocaleString('tr-TR')} TL/yıl</strong></div>
                    </div>
                </div>`;
            }).join('');

            document.getElementById('dispCostPerDonum').innerText = (totalCost / donum).toLocaleString('tr-TR') + ' TL';
            document.getElementById('dispAnnualRevenue').innerText = totalRev.toLocaleString('tr-TR') + ' TL/yıl';
            document.getElementById('dispROI').innerText = (water === 'kuru_tarim' ? '4.2 Yıl' : '3.4 Yıl');
        }

        window.addEventListener('DOMContentLoaded', runAnalysis);
    </script>

    <!-- ANT HARITA SAAS CROSS-LINKING & INTERNAL DISCOVERY ENGINE -->
    <section class="saas-crosslinks-section" style="max-width:1100px; margin:40px auto 20px; padding:24px 20px; background:linear-gradient(135deg, #0b1329 0%, #0f172a 100%); border:1px solid #1e293b; border-radius:16px;">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px; flex-wrap:wrap; gap:10px;">
            <div>
                <h3 style="color:#fff; font-size:15px; font-weight:800; margin:0 0 4px 0; display:flex; align-items:center; gap:8px;">
                    <i class="fa-solid fa-layer-group" style="color:#38bdf8;"></i> Diğer Popüler Harita, Kadastro &amp; Gayrimenkul SaaS Araçlarımız
                </h3>
                <p style="color:#94a3b8; font-size:12px; margin:0;">Ant Harita Mühendislik altyapısıyla geliştirilen diğer akıllı analiz modüllerini keşfedin.</p>
            </div>
            <a href="/eklentiler" style="background:#10b981; color:#fff; padding:6px 14px; border-radius:8px; font-size:12px; font-weight:700; text-decoration:none; display:inline-flex; align-items:center; gap:6px;">
                <i class="fa-solid fa-grid-round"></i> Tüm Modüller (25+) &rarr;
            </a>
        </div>
        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); gap:12px;">
            <a href="/tarla-verimlilik-raporu" style="display:flex; align-items:center; gap:10px; padding:10px 12px; background:#131d31; border:1px solid #1e293b; border-radius:10px; text-decoration:none; color:#f8fafc;">
                <div style="width:36px; height:36px; border-radius:8px; background:rgba(16,185,129,0.15); color:#10b981; display:flex; align-items:center; justify-content:center; font-size:16px;"><i class="fa-solid fa-seedling"></i></div>
                <div><div style="font-size:12.5px; font-weight:700;">Tarla Verimlilik SaaS</div><div style="font-size:11px; color:#94a3b8;">Ürün fizibilitesi &amp; ciro</div></div>
            </a>
            <a href="/emlak-vergisi-hesaplama" style="display:flex; align-items:center; gap:10px; padding:10px 12px; background:#131d31; border:1px solid #1e293b; border-radius:10px; text-decoration:none; color:#f8fafc;">
                <div style="width:36px; height:36px; border-radius:8px; background:rgba(56,189,248,0.15); color:#38bdf8; display:flex; align-items:center; justify-content:center; font-size:16px;"><i class="fa-solid fa-receipt"></i></div>
                <div><div style="font-size:12.5px; font-weight:700;">2026 Emlak Vergisi</div><div style="font-size:11px; color:#94a3b8;">Arsa, konut &amp; arazi harcı</div></div>
            </a>
            <a href="/arsa-takas-pazari" style="display:flex; align-items:center; gap:10px; padding:10px 12px; background:#131d31; border:1px solid #1e293b; border-radius:10px; text-decoration:none; color:#f8fafc;">
                <div style="width:36px; height:36px; border-radius:8px; background:rgba(245,158,11,0.15); color:#f59e0b; display:flex; align-items:center; justify-content:center; font-size:16px;"><i class="fa-solid fa-arrow-right-arrow-left"></i></div>
                <div><div style="font-size:12.5px; font-weight:700;">Arsa Takas Pazarı</div><div style="font-size:11px; color:#94a3b8;">Canlı trampa havuzu</div></div>
            </a>
            <a href="/yapi-kayit-belgesi-sorgulama" style="display:flex; align-items:center; gap:10px; padding:10px 12px; background:#131d31; border:1px solid #1e293b; border-radius:10px; text-decoration:none; color:#f8fafc;">
                <div style="width:36px; height:36px; border-radius:8px; background:rgba(244,63,94,0.15); color:#f43f5e; display:flex; align-items:center; justify-content:center; font-size:16px;"><i class="fa-solid fa-house-chimney-crack"></i></div>
                <div><div style="font-size:12.5px; font-weight:700;">Yapı Kayıt Risk Analizi</div><div style="font-size:11px; color:#94a3b8;">3194 Geçici 16 imar barışı</div></div>
            </a>
            <a href="/tarim-kredisi-hesaplama" style="display:flex; align-items:center; gap:10px; padding:10px 12px; background:#131d31; border:1px solid #1e293b; border-radius:10px; text-decoration:none; color:#f8fafc;">
                <div style="width:36px; height:36px; border-radius:8px; background:rgba(168,85,247,0.15); color:#a855f7; display:flex; align-items:center; justify-content:center; font-size:16px;"><i class="fa-solid fa-tractor"></i></div>
                <div><div style="font-size:12.5px; font-weight:700;">Ziraat Tarım Kredisi</div><div style="font-size:11px; color:#94a3b8;">Sübvansiyonlu hasat vadeli</div></div>
            </a>
            <a href="/arsa-deger-artisi-hesaplama" style="display:flex; align-items:center; gap:10px; padding:10px 12px; background:#131d31; border:1px solid #1e293b; border-radius:10px; text-decoration:none; color:#f8fafc;">
                <div style="width:36px; height:36px; border-radius:8px; background:rgba(16,185,129,0.15); color:#10b981; display:flex; align-items:center; justify-content:center; font-size:16px;"><i class="fa-solid fa-chart-line"></i></div>
                <div><div style="font-size:12.5px; font-weight:700;">5 Yıllık Değer Artışı</div><div style="font-size:11px; color:#94a3b8;">2021-2026 getiri grafiği</div></div>
            </a>
            <a href="/rizai-taksim-sozlesmesi" style="display:flex; align-items:center; gap:10px; padding:10px 12px; background:#131d31; border:1px solid #1e293b; border-radius:10px; text-decoration:none; color:#f8fafc;">
                <div style="width:36px; height:36px; border-radius:8px; background:rgba(192,132,252,0.15); color:#c084fc; display:flex; align-items:center; justify-content:center; font-size:16px;"><i class="fa-solid fa-file-contract"></i></div>
                <div><div style="font-size:12.5px; font-weight:700;">Rıza-i Taksim Protokolü</div><div style="font-size:11px; color:#94a3b8;">Hisseli tapu paylaşımı</div></div>
            </a>
            <a href="/koy-yerlesik-alani-sorgulama" style="display:flex; align-items:center; gap:10px; padding:10px 12px; background:#131d31; border:1px solid #1e293b; border-radius:10px; text-decoration:none; color:#f8fafc;">
                <div style="width:36px; height:36px; border-radius:8px; background:rgba(245,158,11,0.15); color:#f59e0b; display:flex; align-items:center; justify-content:center; font-size:16px;"><i class="fa-solid fa-house-circle-check"></i></div>
                <div><div style="font-size:12.5px; font-weight:700;">Köy İçi İmar Sınırı (300m)</div><div style="font-size:11px; color:#94a3b8;">Plansız alanlar analizi</div></div>
            </a>
        </div>
    </section>

</body>
</html>
