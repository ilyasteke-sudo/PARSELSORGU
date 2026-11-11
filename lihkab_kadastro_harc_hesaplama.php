<?php
/**
 * ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ - PARSEL PRO
 * SaaS: 2026 Resmi Kadastro & LİHKAB Harç/Masraf Hesaplayıcı
 * Pure PHP 8.3 / Responsive SaaS UI / 2026 TKGM & LİHKAB Resmi Fiyat Tarifesi
 */

declare(strict_types=1);

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/navbar.php';

$page_title = "2026 LİHKAB Ücretleri & Aplikasyon Krokisi | ParselSorgu";
$meta_desc = "2026 resmi LİHKAB ücretleri, aplikasyon krokisi, sınır tespiti, cins değişikliği ve tevhid harçlarını ilçe bazlı kuruşu kuruşuna hesaplayın.";
$canonical_url = "https://www.parselsorgu.net/lihkab-hesaplama";

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

$METROPOLITAN_CITIES = [
    "Adana", "Ankara", "Antalya", "Aydın", "Balıkesir", "Bursa", "Denizli", "Diyarbakır", "Erzurum", "Eskişehir",
    "Gaziantep", "Hatay", "İstanbul", "İzmir", "Kahramanmaraş", "Kayseri", "Kocaeli", "Konya", "Malatya", "Manisa",
    "Mardin", "Mersin", "Muğla", "Ordu", "Sakarya", "Samsun", "Şanlıurfa", "Tekirdağ", "Trabzon", "Van"
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
    <meta name="twitter:title" content="<?= htmlspecialchars($page_title) ?>">
    <meta name="twitter:description" content="<?= htmlspecialchars($meta_desc) ?>">
    <meta name="theme-color" content="#090e17">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@graph": [
        {
          "@type": "WebApplication",
          "@id": "https://www.parselsorgu.net/lihkab-hesaplama#app",
          "name": "2026 Resmi Kadastro & LİHKAB Harç Hesaplama Motoru",
          "url": "https://www.parselsorgu.net/lihkab-hesaplama",
          "description": "2026 TKGM ve LİHKAB resmi tarife katsayılarına göre aplikasyon krokisi, sınır tespiti, cins değişikliği ve tevhid işlem masrafları hesaplama aracı.",
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
          "@id": "https://www.parselsorgu.net/lihkab-hesaplama#breadcrumb",
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
              "name": "LİHKAB ve Kadastro Harç Hesaplama",
              "item": "https://www.parselsorgu.net/lihkab-hesaplama"
            }
          ]
        },
        {
          "@type": "FAQPage",
          "@id": "https://www.parselsorgu.net/lihkab-hesaplama#faq",
          "mainEntity": [
            {
              "@type": "Question",
              "name": "Aplikasyon krokisi ücreti neye göre belirlenir?",
              "acceptedAnswer": {
                "@type": "Answer",
                "text": "Aplikasyon krokisi ve sınır tespiti ücreti; parselin yüzölçümüne (m²), köşe nokta sayısına, bulunduğu ilin büyükşehir katsayısına ve TKGM döner sermaye birim fiyatına göre belirlenir."
              }
            },
            {
              "@type": "Question",
              "name": "Cins değişikliği işlemini kim yapar ve masrafı nedir?",
              "acceptedAnswer": {
                "@type": "Answer",
                "text": "LİHKAB büroları (bulunmayan yerlerde Kadastro Müdürlükleri) yerinde kontrol yaparak tescil bildirimi hazırlar. Yapılı veya yapısız olma durumuna göre maktu LİHKAB ücreti, döner sermaye bedeli ve harç tahsil edilir."
              }
            },
            {
              "@type": "Question",
              "name": "LİHKAB ücretleri pazarlığa tabi midir?",
              "acceptedAnswer": {
                "@type": "Answer",
                "text": "Hayır, LİHKAB ücretleri 5368 sayılı Lisanslı Harita Kadastro Mühendisleri ve Büroları Kanunu uyarınca her yıl TKGM tarafından resmi olarak yayımlanan zorunlu asgari ücret tarifesidir."
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
            position: relative;
            overflow: hidden;
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
        .grid-layout { display: grid; grid-template-columns: 1fr 1.25fr; gap: 24px; }
        @media (max-width: 860px) { .grid-layout { grid-template-columns: 1fr; } }
        .saas-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 14px;
            padding: 22px;
        }
        .form-group { margin-bottom: 16px; }
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
        .cost-summary-box {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.15) 0%, rgba(15, 23, 42, 0.8) 100%);
            border: 1px solid rgba(16, 185, 129, 0.35);
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            margin-bottom: 20px;
        }
        .cost-total-amount { font-size: 34px; font-weight: 900; color: #10b981; margin: 6px 0; }
        .cost-total-label { font-size: 12px; font-weight: 700; color: #cbd5e1; text-transform: uppercase; letter-spacing: 0.5px; }
        .fee-table { width: 100%; border-collapse: collapse; margin-top: 14px; font-size: 13px; }
        .fee-table th { text-align: left; padding: 10px 12px; background: var(--card-surface); color: var(--text-muted); font-size: 12px; border-bottom: 1px solid var(--border-color); }
        .fee-table td { padding: 10px 12px; border-bottom: 1px solid #1e293b; color: #e2e8f0; }
        .fee-table tr:last-child td { border-bottom: none; font-weight: 800; color: #fff; }
        .btn-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            background: var(--primary);
            color: #fff;
            padding: 12px 18px;
            border-radius: 8px;
            font-weight: 800;
            font-size: 14px;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            margin-top: 12px;
        }
        .btn-action:hover { opacity: 0.9; transform: translateY(-1px); }
        .btn-print { background: #1e293b; color: #cbd5e1; border: 1px solid #334155; }
        .btn-print:hover { background: #334155; color: #fff; }
        .tag-pill { display: inline-block; padding: 2px 8px; border-radius: 12px; font-size: 11px; font-weight: 700; }
        .tag-green { background: rgba(16, 185, 129, 0.2); color: #10b981; }
        .tag-blue { background: rgba(56, 189, 248, 0.2); color: #38bdf8; }
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
                <i class="fa-solid fa-stamp"></i> 2026 TKGM &amp; LİHKAB RESMİ TARİFESİ
            </div>
            <h1 class="hero-title">2026 LİHKAB Ücretleri &amp; Aplikasyon Krokisi Hesaplama</h1>
            <p class="hero-desc">
                Parselinizin il, büyüklük (m²), köşe nokta adedi ve işlem türüne (Aplikasyon, Cins Değişikliği, Tevhid, İrtifak) göre resmi LİHKAB ücreti, döner sermaye ve KDV dahil toplam resmi giderlerini kuruşu kuruşuna öğrenin.
            </p>
        </div>

        <div class="grid-layout">
            <!-- Girdi Formu -->
            <div class="saas-card">
                <h2 style="font-size: 17px; font-weight: 800; margin-bottom: 16px; color:#fff; display:flex; align-items:center; gap:8px;">
                    <i class="fa-solid fa-calculator text-primary" style="color:#10b981;"></i> İşlem Kriterleri
                </h2>

                <div class="form-group">
                    <label class="form-label">Kadastro / LİHKAB İşlemi Türü</label>
                    <select id="inputProcessType" class="form-select" onchange="calculateFees()">
                        <option value="aplikasyon">Aplikasyon (Sınır Tespiti / Kazık Çakımı)</option>
                        <option value="cins_degisikligi_yapili">Cins Değişikliği (Tarladan/Arsadan Binaya)</option>
                        <option value="cins_degisikligi_yapısız">Cins Değişikliği (Bağ, Bahçe, Tarla Dönüşümü)</option>
                        <option value="tevhid">Tevhid (Parsel Birleştirme Kontrolü)</option>
                        <option value="irtifak">İrtifak Hakkı Tesisi / Terkini</option>
                        <option value="bagimsiz_yer_gosterme">Bağımsız Bölüm (Daire/Dükkan) Yer Gösterme</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Taşınmazın Bulunduğu İl</label>
                    <select id="inputCity" class="form-select" onchange="calculateFees()">
                        <?php foreach ($CITIES_81 as $c): ?>
                            <option value="<?= htmlspecialchars($c) ?>" <?= ($c === 'Antalya' || $c === 'İstanbul') ? 'selected' : '' ?>>
                                <?= htmlspecialchars($c) ?> <?= in_array($c, $METROPOLITAN_CITIES) ? '(Büyükşehir)' : '' ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Parsel Yüzölçümü (m²)</label>
                    <input type="number" id="inputArea" class="form-control" value="1000" min="1" step="10" oninput="calculateFees()">
                    <div class="form-hint">Kadastral yüzölçümü m² cinsinden giriniz.</div>
                </div>

                <div class="form-group" id="cornerPointsGroup">
                    <label class="form-label">Parsel Köşe Noktası Sayısı</label>
                    <input type="number" id="inputCorners" class="form-control" value="4" min="3" max="50" oninput="calculateFees()">
                    <div class="form-hint">Standart parsellerde 4 köşedir; girintili parsellerde köşe sayısı artar.</div>
                </div>

                <div class="form-group">
                    <label class="form-label">Fiziksel Çelik Kazık Çakımı İstiyor musunuz?</label>
                    <select id="inputStakes" class="form-select" onchange="calculateFees()">
                        <option value="evet">Evet (Haritacı Mühendis Çelik Kazık Çakımı Yapar)</option>
                        <option value="hayir">Hayır (Sadece Koordinat &amp; Kroki Verilir)</option>
                    </select>
                </div>

                <button type="button" class="btn-action" onclick="calculateFees()">
                    <i class="fa-solid fa-arrows-rotate"></i> Yeniden Hesapla
                </button>
            </div>

            <!-- Sonuç ve Fatura Pusulası -->
            <div class="saas-card" id="printSection">
                <div class="cost-summary-box">
                    <div class="cost-total-label">TOPLAM TAHMİNİ LİHKAB &amp; RESMİ MASRAF</div>
                    <div class="cost-total-amount" id="dispTotalFee">0 TL</div>
                    <div style="font-size: 12px; color:#cbd5e1;">KDV (%20) ve TKGM Döner Sermaye Dahildir</div>
                </div>

                <h3 style="font-size: 15px; font-weight: 800; color:#fff; margin-bottom: 10px;">
                    <i class="fa-solid fa-receipt text-accent" style="color:#38bdf8;"></i> Resmi Masraf Pusulası Dökümü
                </h3>

                <table class="fee-table">
                    <thead>
                        <tr>
                            <th>Kalem</th>
                            <th>Yasal Referans</th>
                            <th style="text-align:right;">Tutar (TL)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td id="dispItemName">LİHKAB Hizmet Bedeli</td>
                            <td>5368 s.K. 2026 Tarifesi</td>
                            <td style="text-align:right;" id="dispBaseFee">0 TL</td>
                        </tr>
                        <tr>
                            <td>Köşe Noktası &amp; Alan Farkı</td>
                            <td>Kadastro Ek Puanı</td>
                            <td style="text-align:right;" id="dispAreaFee">0 TL</td>
                        </tr>
                        <tr>
                            <td>TKGM Döner Sermaye Bedeli</td>
                            <td>Döner Sermaye İşletmesi</td>
                            <td style="text-align:right;" id="dispDonerFee">0 TL</td>
                        </tr>
                        <tr>
                            <td>Kazık Çakım &amp; Saha Malzeme</td>
                            <td>Arazide Sınır İşaretleme</td>
                            <td style="text-align:right;" id="dispStakeFee">0 TL</td>
                        </tr>
                        <tr>
                            <td>Katma Değer Vergisi (%20 KDV)</td>
                            <td>3065 s.K.</td>
                            <td style="text-align:right;" id="dispKdv">0 TL</td>
                        </tr>
                        <tr style="background: rgba(16, 185, 129, 0.1);">
                            <td>GENEL TOPLAM</td>
                            <td><span class="tag-pill tag-green" id="dispCityPill">Büyükşehir</span></td>
                            <td style="text-align:right; font-size:16px; color:#10b981;" id="dispGrandTotal">0 TL</td>
                        </tr>
                    </tbody>
                </table>

                <div style="margin-top: 18px; padding: 12px; background: rgba(56, 189, 248, 0.08); border-radius: 8px; border: 1px dashed rgba(56, 189, 248, 0.3); font-size: 12px; color: #94a3b8; line-height: 1.5;">
                    <i class="fa-solid fa-circle-info" style="color: #38bdf8;"></i> <strong>Not:</strong> Bu hesaplama, TMMOB Harita ve Kadastro Mühendisleri Odası (HKMO) ve Tapu ve Kadastro Genel Müdürlüğü (TKGM) 2026 yılı asgari ücret tarifeleri esas alınarak üretilmiştir.
                </div>

                <div style="display:flex; gap:10px; margin-top:14px;">
                    <button type="button" class="btn-action btn-print" onclick="window.print()">
                        <i class="fa-solid fa-print"></i> Masraf Pusulasını Yazdır
                    </button>
                    <a href="https://wa.me/905428413535?text=Merhaba,%20parselimin%20kadastro%20aplikasyon%20ve%20sinir%20tespiti%20icin%20harita%20muhendislik%20hizmeti%20almak%20istiyorum." target="_blank" class="btn-action" style="background:#22c55e;">
                        <i class="fa-brands fa-whatsapp"></i> Mühendise Danış
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
        </div>
    </section>

    <script>
        const METRO_CITIES = <?= json_encode($METROPOLITAN_CITIES, JSON_UNESCAPED_UNICODE) ?>;

        function calculateFees() {
            const proc = document.getElementById('inputProcessType').value;
            const city = document.getElementById('inputCity').value;
            const area = Math.max(1, parseFloat(document.getElementById('inputArea').value) || 1000);
            const corners = Math.max(3, parseInt(document.getElementById('inputCorners').value) || 4);
            const stakes = document.getElementById('inputStakes').value;

            const isMetro = METRO_CITIES.includes(city);
            const cityMult = isMetro ? 1.25 : 1.0;

            let baseFee = 0;
            let areaFee = 0;
            let donerFee = isMetro ? 1850 : 1250;
            let stakeFee = (stakes === 'evet') ? (corners * 350) : 0;
            let procLabel = "LİHKAB Hizmet Bedeli";

            if (proc === 'aplikasyon') {
                procLabel = "Aplikasyon ve Sınır Tespiti";
                baseFee = 3200 * cityMult;
                if (area > 1000) {
                    areaFee = Math.min(6000, ((area - 1000) / 1000) * 450 * cityMult);
                }
                if (corners > 4) {
                    areaFee += (corners - 4) * 200;
                }
            } else if (proc === 'cins_degisikligi_yapili') {
                procLabel = "Cins Değişikliği (Yapılı Hal)";
                baseFee = 4500 * cityMult;
                donerFee = isMetro ? 3400 : 2600;
                areaFee = (area > 2000) ? Math.min(4000, ((area - 2000) / 1000) * 300) : 0;
            } else if (proc === 'cins_degisikligi_yapısız') {
                procLabel = "Cins Değişikliği (Tarla/Bağ)";
                baseFee = 2800 * cityMult;
                donerFee = isMetro ? 2200 : 1600;
                areaFee = 0;
            } else if (proc === 'tevhid') {
                procLabel = "Tevhid (Birleştirme Kontrolü)";
                baseFee = 3800 * cityMult;
                donerFee = isMetro ? 2800 : 2100;
                areaFee = (area > 5000) ? 1200 : 0;
            } else if (proc === 'irtifak') {
                procLabel = "İrtifak Hakkı Tesisi / Terkini";
                baseFee = 3100 * cityMult;
                donerFee = isMetro ? 1900 : 1400;
                areaFee = 0;
            } else if (proc === 'bagimsiz_yer_gosterme') {
                procLabel = "Bağımsız Bölüm Yer Gösterme";
                baseFee = 2400 * cityMult;
                donerFee = isMetro ? 1400 : 1100;
                areaFee = 0;
                stakeFee = 0;
            }

            const subTotal = baseFee + areaFee + stakeFee;
            const kdv = subTotal * 0.20;
            const grandTotal = subTotal + kdv + donerFee;

            document.getElementById('dispItemName').innerText = procLabel;
            document.getElementById('dispBaseFee').innerText = Math.round(baseFee).toLocaleString('tr-TR') + ' TL';
            document.getElementById('dispAreaFee').innerText = Math.round(areaFee).toLocaleString('tr-TR') + ' TL';
            document.getElementById('dispDonerFee').innerText = Math.round(donerFee).toLocaleString('tr-TR') + ' TL';
            document.getElementById('dispStakeFee').innerText = Math.round(stakeFee).toLocaleString('tr-TR') + ' TL';
            document.getElementById('dispKdv').innerText = Math.round(kdv).toLocaleString('tr-TR') + ' TL';
            document.getElementById('dispGrandTotal').innerText = Math.round(grandTotal).toLocaleString('tr-TR') + ' TL';
            document.getElementById('dispTotalFee').innerText = Math.round(grandTotal).toLocaleString('tr-TR') + ' TL';
            document.getElementById('dispCityPill').innerText = isMetro ? 'Büyükşehir (%25 Ek Tarife)' : 'Standart İl Tarifesi';
        }

        window.addEventListener('DOMContentLoaded', calculateFees);
    </script>
</body>
</html>
