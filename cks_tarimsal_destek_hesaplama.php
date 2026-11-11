<?php
/**
 * ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ - PARSEL PRO
 * SaaS: 2026 ÇKS (Çiftçi Kayıt Sistemi) Mazot, Gübre & Temel Destek Hibe Hesaplayıcı
 * Pure PHP 8.3 / Responsive UI / Tarım ve Orman Bakanlığı 2026-2028 Yeni Destekleme Modeli
 */

declare(strict_types=1);

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/navbar.php';

$page_title = "2026 ÇKS Mazot, Gübre & Destek Hesaplama | ParselSorgu";
$meta_desc = "Tarım Bakanlığı 2026 tarımsal destekleme modeliyle dekar başına temel destek, mazot-gübre, planlı üretim ve genç çiftçi hibesini hesaplayın.";
$canonical_url = "https://www.parselsorgu.net/cks-destegi-hesaplama";

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

$CROPS = [
    'bugday_arpa' => ['name' => 'Buğday, Arpa, Çavdar, Yulaf', 'base' => 244, 'plan' => 244, 'water_restricted' => true],
    'dane_misir' => ['name' => 'Dane Mısır (Sulu Tarım)', 'base' => 244, 'plan' => 180, 'water_restricted' => false],
    'aycicegi' => ['name' => 'Yağlık Ayçiçeği & Kolza', 'base' => 244, 'plan' => 244, 'water_restricted' => true],
    'pamuk' => ['name' => 'Kütlü Pamuk (Lifli & Yağlı)', 'base' => 244, 'plan' => 320, 'water_restricted' => false],
    'soya' => ['name' => 'Soya Fasulyesi', 'base' => 244, 'plan' => 280, 'water_restricted' => true],
    'nohut_mercimek' => ['name' => 'Nohut, Kuru Fasulye, Mercimek', 'base' => 244, 'plan' => 244, 'water_restricted' => true],
    'yem_bitkileri' => ['name' => 'Yem Bitkileri (Yonca, Korunga, Silaj)', 'base' => 244, 'plan' => 200, 'water_restricted' => true],
    'zeytin' => ['name' => 'Zeytin (Dane & Yağlık)', 'base' => 244, 'plan' => 150, 'water_restricted' => false],
    'findik_cay' => ['name' => 'Fındık & Çay (Havza Bazlı)', 'base' => 244, 'plan' => 220, 'water_restricted' => false],
    'patates_sogan' => ['name' => 'Patates & Kuru Soğan', 'base' => 244, 'plan' => 140, 'water_restricted' => false]
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
    <meta property="og:url" content="<?= $canonical_url ?>">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="ParselSorgu.net - Ant Harita Mühendislik">
    <meta property="og:image" content="https://www.parselsorgu.net/assets/images/og-parsel.jpg">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="theme-color" content="#090e17">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@graph": [
        {
          "@type": "WebApplication",
          "@id": "https://www.parselsorgu.net/cks-destegi-hesaplama#app",
          "name": "2026 ÇKS Tarımsal Destek ve Mazot Gübre Hesaplayıcı",
          "url": "https://www.parselsorgu.net/cks-destegi-hesaplama",
          "description": "Tarım ve Orman Bakanlığı 2026 yeni destekleme modeli uyarınca temel destek, mazot ve gübre maliyet karşılığı, planlı üretim primi ve genç çiftçi ilave hibe hesaplama aracı.",
          "applicationCategory": "BusinessApplication",
          "operatingSystem": "All",
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
          "@id": "https://www.parselsorgu.net/cks-destegi-hesaplama#breadcrumb",
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
              "name": "ÇKS Mazot Gübre Destek Hesaplama",
              "item": "https://www.parselsorgu.net/cks-destegi-hesaplama"
            }
          ]
        },
        {
          "@type": "FAQPage",
          "@id": "https://www.parselsorgu.net/cks-destegi-hesaplama#faq",
          "mainEntity": [
            {
              "@type": "Question",
              "name": "2026 ÇKS destekleme modeli nasıl değişti?",
              "acceptedAnswer": {
                "@type": "Answer",
                "text": "2026 yılından itibaren Tarım ve Orman Bakanlığı katsayı sistemine geçmiştir. Mazotun %50'si ve gübrenin %25'i ayni veya nakdi temel destek olarak dekar başına garanti altına alınmış, planlı üretim yapan havzalara ilave %100 prim tanımlanmıştır."
              }
            },
            {
              "@type": "Question",
              "name": "Genç ve kadın çiftçilere ek destek ne kadardır?",
              "acceptedAnswer": {
                "@type": "Answer",
                "text": "40 yaş altı genç çiftçiler ile kadın üreticilere temel destek tutarı üzerinden ilave %20 ile %30 arasında ek teşvik katsayısı uygulanır."
              }
            },
            {
              "@type": "Question",
              "name": "Tarımsal destekleme ödemeleri ne zaman yatar?",
              "acceptedAnswer": {
                "@type": "Answer",
                "text": "Tarımsal destekler yılda 2 ana dönemde (ilkbahar ekim öncesi ve sonbahar hasat sonrası) Ziraat Bankası Çiftçi Başak Kart hesaplarına T.C. kimlik numarasının son hanesine göre aktarılır."
              }
            }
          ]
        }
      ]
    }
    </script>

    <style>
        :root {
            --primary: #10b981;
            --accent: #38bdf8;
            --amber: #f59e0b;
            --dark-bg: #090e17;
            --card-bg: #0f172a;
            --card-surface: #131d31;
            --border-color: #1e293b;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            background-color: var(--dark-bg);
            color: var(--text-main);
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            line-height: 1.5;
            padding-bottom: 40px;
        }
        .container { max-width: 1140px; margin: 0 auto; padding: 20px 16px; }
        .hero-banner {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.12) 0%, rgba(56, 189, 248, 0.08) 100%);
            border: 1px solid rgba(16, 185, 129, 0.3);
            border-radius: 16px;
            padding: 28px 24px;
            margin-bottom: 24px;
        }
        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(16, 185, 129, 0.2);
            color: #10b981;
            font-size: 12px;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 20px;
            margin-bottom: 12px;
            border: 1px solid rgba(16, 185, 129, 0.4);
        }
        .hero-title { font-size: 26px; font-weight: 900; color: #fff; margin-bottom: 8px; }
        .hero-desc { color: var(--text-muted); font-size: 14px; max-width: 820px; }

        .grid-layout { display: grid; grid-template-columns: 1fr 1.3fr; gap: 24px; }
        @media (max-width: 860px) { .grid-layout { grid-template-columns: 1fr; } }

        .saas-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 14px;
            padding: 22px;
        }
        .form-group { margin-bottom: 15px; }
        .form-label { display: block; font-size: 12.5px; font-weight: 700; margin-bottom: 6px; color: #cbd5e1; }
        .form-control, .form-select {
            width: 100%;
            background: var(--card-surface);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 10px 14px;
            color: #fff;
            font-size: 13.5px;
            outline: none;
            transition: border-color 0.2s;
        }
        .form-control:focus, .form-select:focus { border-color: var(--primary); }
        .form-hint { font-size: 11px; color: var(--text-muted); margin-top: 4px; }

        .stat-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; margin-bottom: 18px; }
        @media (max-width: 600px) { .stat-grid { grid-template-columns: 1fr; } }
        .stat-card {
            background: var(--card-surface);
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 14px;
            text-align: center;
        }
        .stat-val { font-size: 22px; font-weight: 900; color: #fff; margin-top: 4px; }
        .stat-title { font-size: 11px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; }

        .btn-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            background: var(--primary);
            color: #000;
            padding: 12px 18px;
            border-radius: 8px;
            font-weight: 800;
            font-size: 14px;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            margin-top: 10px;
        }
        .btn-action:hover { opacity: 0.9; transform: translateY(-1px); }

        .table-custom { width: 100%; border-collapse: collapse; font-size: 13px; margin-top: 10px; }
        .table-custom th { text-align: left; padding: 8px 10px; background: var(--card-surface); color: var(--text-muted); border-bottom: 1px solid var(--border-color); }
        .table-custom td { padding: 8px 10px; border-bottom: 1px solid #1e293b; color: #e2e8f0; }
    </style>
    <link rel="alternate" type="text/markdown" href="https://www.parselsorgu.net/llms.txt" title="ParselSorgu AI / LLM Bilgi Bankası">
    <link rel="alternate" type="application/json" href="https://www.parselsorgu.net/api/2026-kadastro-endeks.json" title="2026 Kadastro ve İmar Açık Veri Seti">
    <script type="application/ld+json">{"@context": "https://schema.org", "@type": "WebPage", "speakable": {"@type": "SpeakableSpecification", "cssSelector": ["h1", ".lead", ".summary-box", ".hero-desc", "main p"]}, "isBasedOn": "https://www.parselsorgu.net/api/2026-kadastro-endeks.json", "publisher": {"@type": "Organization", "name": "Ant Harita Mühendislik - ParselSorgu.net", "url": "https://www.parselsorgu.net/"}}</script>
</head>
<body>
    <?php render_navbar('eklentiler'); ?>

    <div class="container">
        <div class="hero-banner">
            <div class="hero-badge">
                <i class="fa-solid fa-seedling"></i> 2026-2028 YENİ TARIMSAL DESTEKLEME MODELİ
            </div>
            <h1 class="hero-title">2026 ÇKS Mazot, Gübre &amp; Tarımsal Destek Hesaplayıcı</h1>
            <p class="hero-desc">
                Tarlanızın büyüklüğüne (dönüm), iline ve ekeceğiniz ürüne göre dekar başına temel destek, mazot ve gübre maliyet karşılığı, planlı üretim primi ve genç/kadın çiftçi ilave hibelerini anında hesaplayın.
            </p>
        </div>

        <div class="grid-layout">
            <!-- Girdi Formu -->
            <div class="saas-card">
                <h2 style="font-size: 16.5px; font-weight: 800; margin-bottom: 16px; color:#fff; display:flex; align-items:center; gap:8px;">
                    <i class="fa-solid fa-wheat-awn text-primary" style="color:#10b981;"></i> Üretim ve Arazi Bilgileri
                </h2>

                <div class="form-group">
                    <label class="form-label">Ekilecek Tarımsal Ürün</label>
                    <select id="inputCrop" class="form-select" onchange="calcCksSupport()">
                        <?php foreach ($CROPS as $k => $c): ?>
                            <option value="<?= htmlspecialchars($k) ?>" <?= ($k === 'bugday_arpa') ? 'selected' : '' ?>>
                                <?= htmlspecialchars($c['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Tarlanın Bulunduğu İl</label>
                    <select id="inputCity" class="form-select" onchange="calcCksSupport()">
                        <?php foreach ($CITIES_81 as $c): ?>
                            <option value="<?= htmlspecialchars($c) ?>" <?= ($c === 'Konya' || $c === 'Adana') ? 'selected' : '' ?>>
                                <?= htmlspecialchars($c) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Arazi Büyüklüğü (Dekar / Dönüm)</label>
                    <input type="number" id="inputDekar" class="form-control" value="50" min="1" step="5" oninput="calcCksSupport()">
                    <div class="form-hint">1 Dönüm = 1.000 m² (ÇKS kayıtlı net ekili alan).</div>
                </div>

                <div class="form-group">
                    <label class="form-label">Tarım Bakanlığı Planlı Üretim Havzasında mı?</label>
                    <select id="inputPlanned" class="form-select" onchange="calcCksSupport()">
                        <option value="evet" selected>Evet (Bakanlıkça Belirlenen Öncelikli Havzada)</option>
                        <option value="hayir">Hayır (Havza Dışı Serbest Ekim)</option>
                    </select>
                </div>

                <div style="display:grid; grid-template-columns: 1fr 1fr; gap:12px;">
                    <div class="form-group">
                        <label class="form-label">Genç / Kadın Çiftçi mi?</label>
                        <select id="inputYouth" class="form-select" onchange="calcCksSupport()">
                            <option value="hayir">Standart Çiftçi</option>
                            <option value="genc">Genç Çiftçi (&lt;40 Yaş, +%20)</option>
                            <option value="kadin">Kadın Üretici (+%25)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Sertifikalı Tohum?</label>
                        <select id="inputCertifiedSeed" class="form-select" onchange="calcCksSupport()">
                            <option value="evet" selected>Evet (Sertifikalı Tohum Kullanıldı)</option>
                            <option value="hayir">Hayır (Kendi Tohumu / Standart)</option>
                        </select>
                    </div>
                </div>

                <button type="button" class="btn-action" onclick="calcCksSupport()">
                    <i class="fa-solid fa-calculator"></i> ÇKS Destek Tutarını Hesapla
                </button>
            </div>

            <!-- Sonuç Tablosu -->
            <div class="saas-card">
                <div class="stat-grid">
                    <div class="stat-card">
                        <div class="stat-title">Dekar Başı Toplam</div>
                        <div class="stat-val" id="dispPerDekar" style="color:#38bdf8;">0 TL</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-title">Mazot &amp; Gübre Payı</div>
                        <div class="stat-val" id="dispDieselFertilizer" style="color:#f59e0b;">0 TL</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-title">Yıllık Net Devlet Hibesi</div>
                        <div class="stat-val" id="dispGrandTotal" style="color:#10b981;">0 TL</div>
                    </div>
                </div>

                <div style="background:linear-gradient(135deg, rgba(16,185,129,0.12) 0%, rgba(15,23,42,0.9) 100%); border:1px solid rgba(16,185,129,0.35); border-radius:12px; padding:18px; margin-bottom:16px;">
                    <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:8px;">
                        <div>
                            <span style="font-size:11px; font-weight:800; color:#cbd5e1; text-transform:uppercase;">Tahmini ÇKS Yıllık Karşılıksız Destek</span>
                            <div style="font-size:26px; font-weight:900; color:#10b981;" id="dispTotalGrant">0 TL</div>
                        </div>
                        <div style="text-align:right;">
                            <span style="font-size:11px; color:#94a3b8;">Ziraat Başak Kart / Nakit</span>
                            <div style="font-size:13px; font-weight:700; color:#38bdf8;">2 Taksitte Ödenir</div>
                        </div>
                    </div>
                </div>

                <h3 style="font-size:14px; font-weight:800; color:#fff; margin-bottom:8px;">
                    <i class="fa-solid fa-list-ol" style="color:#38bdf8;"></i> Kalem Kalem Destekleme Pusulası
                </h3>

                <table class="table-custom">
                    <thead>
                        <tr>
                            <th>Destek Kalemi</th>
                            <th>Açıklama</th>
                            <th style="text-align:right;">Tutar (TL)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Temel Destek (Mazot/Gübre)</td>
                            <td id="dispBaseDesc">Dekar başına yasal taban katsayı</td>
                            <td style="text-align:right;" id="dispBaseTotal">0 TL</td>
                        </tr>
                        <tr>
                            <td>Planlı Üretim Primi</td>
                            <td id="dispPlannedDesc">Öncelikli havza ilave katsayısı</td>
                            <td style="text-align:right; color:#10b981;" id="dispPlanTotal">+ 0 TL</td>
                        </tr>
                        <tr>
                            <td>Sertifikalı Tohum Kullanım Primi</td>
                            <td>Tescilli tohum ilave teşviki</td>
                            <td style="text-align:right; color:#38bdf8;" id="dispSeedTotal">+ 0 TL</td>
                        </tr>
                        <tr>
                            <td>Genç / Kadın Çiftçi Ek Katsayısı</td>
                            <td id="dispYouthDesc">Pozitif ayrımcılık teşviki</td>
                            <td style="text-align:right; color:#f59e0b;" id="dispYouthTotal">+ 0 TL</td>
                        </tr>
                        <tr style="background:rgba(16,185,129,0.1); font-weight:800;">
                            <td>TOPLAM DEVLET DESTEĞİ</td>
                            <td id="dispSummaryDekar">50 Dekar Toplamı</td>
                            <td style="text-align:right; color:#10b981; font-size:15px;" id="dispFinalTotal">0 TL</td>
                        </tr>
                    </tbody>
                </table>

                <div style="display:flex; gap:10px; margin-top:16px;">
                    <button type="button" class="btn-action" style="background:#1e293b; color:#cbd5e1; border:1px solid #334155;" onclick="window.print()">
                        <i class="fa-solid fa-print"></i> ÇKS Pusulasını Yazdır
                    </button>
                    <a href="https://wa.me/905428413535?text=Merhaba,%20arazimin%20tarimsal%20destekleri%20ve%20harita%20parsel%20bilgileri%20icin%20danismanlik%20almak%20istiyorum." target="_blank" class="btn-action" style="background:#22c55e; color:#fff;">
                        <i class="fa-brands fa-whatsapp"></i> Danışma Hattı
                    </a>
                </div>
            </div>
        </div>
    </div>

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
            <a href="/prefabrik-ev-maliyeti-hesaplama" style="display:flex; align-items:center; gap:10px; padding:10px 12px; background:#131d31; border:1px solid #1e293b; border-radius:10px; text-decoration:none; color:#f8fafc;">
                <div style="width:36px; height:36px; border-radius:8px; background:rgba(245,158,11,0.15); color:#f59e0b; display:flex; align-items:center; justify-content:center; font-size:16px;"><i class="fa-solid fa-house-laptop"></i></div>
                <div><div style="font-size:12.5px; font-weight:700;">Prefabrik &amp; Çelik Ev</div><div style="font-size:11px; color:#94a3b8;">Maliyet &amp; ruhsat analizi</div></div>
            </a>
            <a href="/tarla-verimlilik-raporu" style="display:flex; align-items:center; gap:10px; padding:10px 12px; background:#131d31; border:1px solid #1e293b; border-radius:10px; text-decoration:none; color:#f8fafc;">
                <div style="width:36px; height:36px; border-radius:8px; background:rgba(16,185,129,0.15); color:#10b981; display:flex; align-items:center; justify-content:center; font-size:16px;"><i class="fa-solid fa-seedling"></i></div>
                <div><div style="font-size:12.5px; font-weight:700;">Tarla Verimlilik SaaS</div><div style="font-size:11px; color:#94a3b8;">Ürün fizibilitesi &amp; ciro</div></div>
            </a>
            <a href="/tarim-kredisi-hesaplama" style="display:flex; align-items:center; gap:10px; padding:10px 12px; background:#131d31; border:1px solid #1e293b; border-radius:10px; text-decoration:none; color:#f8fafc;">
                <div style="width:36px; height:36px; border-radius:8px; background:rgba(168,85,247,0.15); color:#a855f7; display:flex; align-items:center; justify-content:center; font-size:16px;"><i class="fa-solid fa-tractor"></i></div>
                <div><div style="font-size:12.5px; font-weight:700;">Ziraat Tarım Kredisi</div><div style="font-size:11px; color:#94a3b8;">Sübvansiyonlu hasat vadeli</div></div>
            </a>
            <a href="/lihkab-hesaplama" style="display:flex; align-items:center; gap:10px; padding:10px 12px; background:#131d31; border:1px solid #1e293b; border-radius:10px; text-decoration:none; color:#f8fafc;">
                <div style="width:36px; height:36px; border-radius:8px; background:rgba(16,185,129,0.15); color:#10b981; display:flex; align-items:center; justify-content:center; font-size:16px;"><i class="fa-solid fa-stamp"></i></div>
                <div><div style="font-size:12.5px; font-weight:700;">LİHKAB &amp; Kadastro Harcı</div><div style="font-size:11px; color:#94a3b8;">Aplikasyon &amp; cins değişikliği</div></div>
            </a>
            <a href="/kentsel-donusum-yarisi-bizden" style="display:flex; align-items:center; gap:10px; padding:10px 12px; background:#131d31; border:1px solid #1e293b; border-radius:10px; text-decoration:none; color:#f8fafc;">
                <div style="width:36px; height:36px; border-radius:8px; background:rgba(245,158,11,0.15); color:#f59e0b; display:flex; align-items:center; justify-content:center; font-size:16px;"><i class="fa-solid fa-building-shield"></i></div>
                <div><div style="font-size:12.5px; font-weight:700;">Yarısı Bizden &amp; Şerefiye</div><div style="font-size:11px; color:#94a3b8;">Kentsel dönüşüm hibe/kredi</div></div>
            </a>
            <a href="/ecrimisil-hesaplama" style="display:flex; align-items:center; gap:10px; padding:10px 12px; background:#131d31; border:1px solid #1e293b; border-radius:10px; text-decoration:none; color:#f8fafc;">
                <div style="width:36px; height:36px; border-radius:8px; background:rgba(192,132,252,0.15); color:#c084fc; display:flex; align-items:center; justify-content:center; font-size:16px;"><i class="fa-solid fa-scale-balanced"></i></div>
                <div><div style="font-size:12.5px; font-weight:700;">Hisseli Tapu Ecrimisil</div><div style="font-size:11px; color:#94a3b8;">5 yıllık kira tazminatı</div></div>
            </a>
        </div>
    </section>

    <script>
        const CROP_DATA = <?= json_encode($CROPS, JSON_UNESCAPED_UNICODE) ?>;

        function calcCksSupport() {
            const cropKey = document.getElementById('inputCrop').value;
            const dekar = Math.max(1, parseFloat(document.getElementById('inputDekar').value) || 50);
            const planned = (document.getElementById('inputPlanned').value === 'evet');
            const youth = document.getElementById('inputYouth').value;
            const seed = (document.getElementById('inputCertifiedSeed').value === 'evet');

            const crop = CROP_DATA[cropKey] || {base: 244, plan: 244};

            const basePerDekar = crop.base; // Temel Destek katsayısı
            const planPerDekar = planned ? crop.plan : 0;
            const seedPerDekar = seed ? 85 : 0;

            let youthMult = 0;
            let youthDesc = "Uygulanmadı";
            if (youth === 'genc') {
                youthMult = 0.20;
                youthDesc = "Genç Çiftçi (+%20 Temel Destek)";
            } else if (youth === 'kadin') {
                youthMult = 0.25;
                youthDesc = "Kadın Çiftçi (+%25 Temel Destek)";
            }

            const youthPerDekar = basePerDekar * youthMult;
            const totalPerDekar = basePerDekar + planPerDekar + seedPerDekar + youthPerDekar;

            const baseTotal = basePerDekar * dekar;
            const planTotal = planPerDekar * dekar;
            const seedTotal = seedPerDekar * dekar;
            const youthTotal = youthPerDekar * dekar;
            const grandTotal = totalPerDekar * dekar;

            document.getElementById('dispPerDekar').innerText = Math.round(totalPerDekar).toLocaleString('tr-TR') + ' TL / da';
            document.getElementById('dispDieselFertilizer').innerText = Math.round(baseTotal).toLocaleString('tr-TR') + ' TL';
            document.getElementById('dispGrandTotal').innerText = Math.round(grandTotal).toLocaleString('tr-TR') + ' TL';
            document.getElementById('dispTotalGrant').innerText = Math.round(grandTotal).toLocaleString('tr-TR') + ' TL';

            document.getElementById('dispBaseTotal').innerText = Math.round(baseTotal).toLocaleString('tr-TR') + ' TL';
            document.getElementById('dispPlanTotal').innerText = '+ ' + Math.round(planTotal).toLocaleString('tr-TR') + ' TL';
            document.getElementById('dispSeedTotal').innerText = '+ ' + Math.round(seedTotal).toLocaleString('tr-TR') + ' TL';
            document.getElementById('dispYouthTotal').innerText = '+ ' + Math.round(youthTotal).toLocaleString('tr-TR') + ' TL';
            document.getElementById('dispYouthDesc').innerText = youthDesc;
            document.getElementById('dispSummaryDekar').innerText = `${dekar} Dekar Ekili Alan`;
            document.getElementById('dispFinalTotal').innerText = Math.round(grandTotal).toLocaleString('tr-TR') + ' TL';
        }

        window.addEventListener('DOMContentLoaded', calcCksSupport);
    </script>
</body>
</html>
