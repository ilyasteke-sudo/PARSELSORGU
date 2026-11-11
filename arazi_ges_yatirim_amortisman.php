<?php
/**
 * ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ - PARSEL PRO
 * SaaS: Arazi Güneş Enerjisi Santrali (GES) Yatırım & Amortisman Simülatörü
 * Pure PHP 8.3 / Responsive UI / EPDK Lisanssız Elektrik (5.1.h) & GEPA Radyasyon Veritabanı
 */

declare(strict_types=1);

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/navbar.php';

$page_title = "Arazi GES Kurulum Maliyeti & Amortisman 2026 | ParselSorgu";
$meta_desc = "Tarlaya GES kurmak karlı mı? 2026 1 MW arazi güneş enerjisi santrali maliyeti, EPDK elektrik geliri ve amortisman süresi hesaplayın.";
$canonical_url = "https://www.parselsorgu.net/arazi-ges-amortisman-hesaplama";

$SOLAR_REGIONS = [
    'Güneydoğu Anadolu (Şanlıurfa, Mardin, Diyarbakır)' => ['radiation' => 1750, 'efficiency' => 1.55],
    'Akdeniz Bölgesi (Antalya, Mersin, Adana, Burdur)' => ['radiation' => 1700, 'efficiency' => 1.50],
    'İç Anadolu (Konya, Karaman, Aksaray, Kayseri, Ankara)' => ['radiation' => 1620, 'efficiency' => 1.45],
    'Ege Bölgesi (İzmir, Aydın, Denizli, Manisa, Muğla)' => ['radiation' => 1600, 'efficiency' => 1.42],
    'Doğu Anadolu (Malatya, Elazığ, Erzurum, Van)' => ['radiation' => 1550, 'efficiency' => 1.38],
    'Marmara Bölgesi (Balıkesir, Çanakkale, Bursa, Tekirdağ)' => ['radiation' => 1400, 'efficiency' => 1.25],
    'Karadeniz Bölgesi (Samsun, Trabzon, Ordu)' => ['radiation' => 1250, 'efficiency' => 1.10]
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
          "@id": "https://www.parselsorgu.net/arazi-ges-amortisman-hesaplama#app",
          "name": "Arazi GES Yatırım ve Amortisman Simülatörü",
          "url": "https://www.parselsorgu.net/arazi-ges-amortisman-hesaplama",
          "description": "Tarlaya güneş enerjisi santrali kurulum maliyeti, MW kurulu güç, yıllık elektrik üretim geliri ve net amortisman süresi hesaplama aracı.",
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
          "@id": "https://www.parselsorgu.net/arazi-ges-amortisman-hesaplama#breadcrumb",
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
              "name": "Arazi GES Amortisman Hesaplama",
              "item": "https://www.parselsorgu.net/arazi-ges-amortisman-hesaplama"
            }
          ]
        },
        {
          "@type": "FAQPage",
          "@id": "https://www.parselsorgu.net/arazi-ges-amortisman-hesaplama#faq",
          "mainEntity": [
            {
              "@type": "Question",
              "name": "1 MW Arazi GES için kaç dönüm tarla gerekir?",
              "acceptedAnswer": {
                "@type": "Answer",
                "text": "1 MW kurulu gücünde arazi tipi güneş enerji santrali için paneller arasındaki gölgelenme mesafeleri, trafo köşkü, invertörler ve güvenlik koridoru dahil ortalama 12 ile 15 dönüm (12.000 - 15.000 m²) arazi gereklidir."
              }
            },
            {
              "@type": "Question",
              "name": "Arazi GES ortalama kaç yılda kendini amorti eder?",
              "acceptedAnswer": {
                "@type": "Answer",
                "text": "Türkiye'nin güneşlenme radyasyonuna bağlı olarak bir arazi GES yatırımı ortalama 3.2 ile 4.5 yıl arasında kendini amorti etmekte, panellerin 25-30 yıllık ömrü boyunca kalan süre tamamen net kar bırakmaktadır."
              }
            },
            {
              "@type": "Question",
              "name": "Hangi tarlalara GES kurulabilir?",
              "acceptedAnswer": {
                "@type": "Answer",
                "text": "Tarım ve Orman İl Müdürlüğü'nden 'Marjinal Tarım Arazisi' (kuru tarım, taşlık, kıraç) yazısı alınabilen ve TEİAŞ / TEDAŞ trafo merkezine bağlantı kapasitesi bulunan arazilere lisanssız elektrik üretimi (Madde 5.1.h) kapsamında GES kurulabilir."
              }
            }
          ]
        }
      ]
    }
    </script>

    <style>
        :root {
            --primary: #f59e0b;
            --accent: #38bdf8;
            --green: #10b981;
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
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.15) 0%, rgba(16, 185, 129, 0.08) 100%);
            border: 1px solid rgba(245, 158, 11, 0.35);
            border-radius: 16px;
            padding: 28px 24px;
            margin-bottom: 24px;
        }
        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(245, 158, 11, 0.2);
            color: #f59e0b;
            font-size: 12px;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 20px;
            margin-bottom: 12px;
            border: 1px solid rgba(245, 158, 11, 0.4);
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
                <i class="fa-solid fa-solar-panel"></i> EPDK 5.1.h &amp; 2026 GEPA RADYASYON SİMÜLASYONU
            </div>
            <h1 class="hero-title">Arazi Güneş Enerjisi (GES) Yatırım &amp; Amortisman Motoru</h1>
            <p class="hero-desc">
                Tarlanızın dönüm büyüklüğüne ve bulunduğu bölgenin güneş radyasyon verilerine göre kurulabilecek azami MWp gücü, anahtar teslim kurulum maliyetini ($/TL), yıllık elektrik gelirini ve net amortisman süresini hesaplayın.
            </p>
        </div>

        <div class="grid-layout">
            <!-- Girdi Formu -->
            <div class="saas-card">
                <h2 style="font-size: 16.5px; font-weight: 800; margin-bottom: 16px; color:#fff; display:flex; align-items:center; gap:8px;">
                    <i class="fa-solid fa-sun text-primary" style="color:#f59e0b;"></i> Santral ve Arazi Parametreleri
                </h2>

                <div class="form-group">
                    <label class="form-label">Tarlanın Bulunduğu Güneş Bölgesi</label>
                    <select id="inputRegion" class="form-select" onchange="calcGes()">
                        <?php foreach ($SOLAR_REGIONS as $reg => $d): ?>
                            <option value="<?= htmlspecialchars($reg) ?>" <?= (strpos($reg, 'Güneydoğu') !== false || strpos($reg, 'İç Anadolu') !== false) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($reg) ?> (<?= $d['radiation'] ?> kWh/m²)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Arazi Büyüklüğü (Dönüm / Dekar)</label>
                    <input type="number" id="inputLandSize" class="form-control" value="15" min="2" step="1" oninput="calcGes()">
                    <div class="form-hint">Standart 1 MW GES için ortalama 12-15 dönüm arazi gerekir.</div>
                </div>

                <div class="form-group">
                    <label class="form-label">Panel Teknolojisi</label>
                    <select id="inputPanelType" class="form-select" onchange="calcGes()">
                        <option value="topcon_550">550W - 580W N-Type TOPCon Panel (Yüksek Verim %22.5)</option>
                        <option value="perc_500">500W - 540W Mono PERC Panel (Standart Endüstriyel)</option>
                    </select>
                </div>

                <div style="display:grid; grid-template-columns: 1fr 1fr; gap:12px;">
                    <div class="form-group">
                        <label class="form-label">Trafo Mesafesi (km)</label>
                        <input type="number" id="inputGridDist" class="form-control" value="2.5" min="0.1" step="0.5" oninput="calcGes()">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Arazi Zemin Türü</label>
                        <select id="inputSoil" class="form-select" onchange="calcGes()">
                            <option value="toprak">Toprak / Killi Zemin (Çakma Çelik Kazık)</option>
                            <option value="kayalik">Kayalık Zemin (Beton Kitle Ayaklı)</option>
                        </select>
                    </div>
                </div>

                <button type="button" class="btn-action" onclick="calcGes()">
                    <i class="fa-solid fa-calculator"></i> GES Fizibilitesini Hesapla
                </button>
            </div>

            <!-- Sonuç Tablosu -->
            <div class="saas-card">
                <div class="stat-grid">
                    <div class="stat-card">
                        <div class="stat-title">Kurulu Güç (Kapasite)</div>
                        <div class="stat-val" id="dispCapacity" style="color:#f59e0b;">0 kWp</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-title">Yıllık Elektrik Geliri</div>
                        <div class="stat-val" id="dispAnnualRevenue" style="color:#10b981;">0 $</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-title">Amortisman Süresi</div>
                        <div class="stat-val" id="dispRoiYears" style="color:#38bdf8;">0 Yıl</div>
                    </div>
                </div>

                <div style="background:linear-gradient(135deg, rgba(245,158,11,0.12) 0%, rgba(15,23,42,0.9) 100%); border:1px solid rgba(245,158,11,0.35); border-radius:12px; padding:18px; margin-bottom:16px;">
                    <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:8px;">
                        <div>
                            <span style="font-size:11px; font-weight:800; color:#cbd5e1; text-transform:uppercase;">Tahmini Anahtar Teslim EPC Maliyeti</span>
                            <div style="font-size:26px; font-weight:900; color:#f59e0b;" id="dispTotalCapex">$ 0</div>
                        </div>
                        <div style="text-align:right;">
                            <span style="font-size:11px; color:#94a3b8;">Tier-1 Ekipman &amp; ENH Hattı Dahil</span>
                            <div style="font-size:13px; font-weight:700; color:#10b981;" id="dispCapexTl">0 TL</div>
                        </div>
                    </div>
                </div>

                <h3 style="font-size:14px; font-weight:800; color:#fff; margin-bottom:8px;">
                    <i class="fa-solid fa-chart-column" style="color:#38bdf8;"></i> Teknik ve Mali Fizibilite Göstergeleri
                </h3>

                <table class="table-custom">
                    <thead>
                        <tr>
                            <th>Parametre</th>
                            <th>Fizibilite Değeri</th>
                            <th style="text-align:right;">Açıklama</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Tahmini Panel Adedi</td>
                            <td id="dispPanelCount" style="font-weight:700; color:#fff;">0 Adet</td>
                            <td style="text-align:right;">550W Tier-1 Panel</td>
                        </tr>
                        <tr>
                            <td>Yıllık Elektrik Üretimi</td>
                            <td id="dispProductionMwh" style="font-weight:700; color:#38bdf8;">0 MWh / yıl</td>
                            <td style="text-align:right;">GEPA Radyasyon Atlası</td>
                        </tr>
                        <tr>
                            <td>Trafo &amp; Enerji Nakil Hattı (ENH)</td>
                            <td id="dispGridCost">$ 0</td>
                            <td style="text-align:right;" id="dispGridKm">2.5 km Hat Masrafı</td>
                        </tr>
                        <tr>
                            <td>Aylık Ortalama Net Getiri</td>
                            <td id="dispMonthlyRevenue" style="font-weight:700; color:#10b981;">$ 0 / ay</td>
                            <td style="text-align:right;">EPDK Mahsuplaşma</td>
                        </tr>
                        <tr style="background:rgba(245,158,11,0.1); font-weight:800;">
                            <td>25 YILLIK KÜMÜLATİF KAZANÇ</td>
                            <td id="disp25YearCash" style="color:#f59e0b; font-size:15px;">$ 0</td>
                            <td style="text-align:right; color:#10b981;">Panel Ömrü Boyunca</td>
                        </tr>
                    </tbody>
                </table>

                <div style="display:flex; gap:10px; margin-top:16px;">
                    <button type="button" class="btn-action" style="background:#1e293b; color:#cbd5e1; border:1px solid #334155;" onclick="window.print()">
                        <i class="fa-solid fa-print"></i> Fizibilite Raporunu Yazdır
                    </button>
                    <a href="https://wa.me/905428413535?text=Merhaba,%20tarlamda%20arazi%20GES%20kurulumu%20ve%20harita%20cagri%20mektubu%20dosyasi%20icin%20muhendislik%20danismanligi%20istiyorum." target="_blank" class="btn-action" style="background:#22c55e; color:#fff;">
                        <i class="fa-brands fa-whatsapp"></i> GES Mühendisine Danış
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
            <a href="/cks-destegi-hesaplama" style="display:flex; align-items:center; gap:10px; padding:10px 12px; background:#131d31; border:1px solid #1e293b; border-radius:10px; text-decoration:none; color:#f8fafc;">
                <div style="width:36px; height:36px; border-radius:8px; background:rgba(16,185,129,0.15); color:#10b981; display:flex; align-items:center; justify-content:center; font-size:16px;"><i class="fa-solid fa-wheat-awn"></i></div>
                <div><div style="font-size:12.5px; font-weight:700;">2026 ÇKS Destekleri</div><div style="font-size:11px; color:#94a3b8;">Mazot &amp; gübre hibesi</div></div>
            </a>
            <a href="/tarla-verimlilik-raporu" style="display:flex; align-items:center; gap:10px; padding:10px 12px; background:#131d31; border:1px solid #1e293b; border-radius:10px; text-decoration:none; color:#f8fafc;">
                <div style="width:36px; height:36px; border-radius:8px; background:rgba(16,185,129,0.15); color:#10b981; display:flex; align-items:center; justify-content:center; font-size:16px;"><i class="fa-solid fa-seedling"></i></div>
                <div><div style="font-size:12.5px; font-weight:700;">Tarla Verimlilik SaaS</div><div style="font-size:11px; color:#94a3b8;">Ürün fizibilitesi &amp; ciro</div></div>
            </a>
            <a href="/lihkab-hesaplama" style="display:flex; align-items:center; gap:10px; padding:10px 12px; background:#131d31; border:1px solid #1e293b; border-radius:10px; text-decoration:none; color:#f8fafc;">
                <div style="width:36px; height:36px; border-radius:8px; background:rgba(16,185,129,0.15); color:#10b981; display:flex; align-items:center; justify-content:center; font-size:16px;"><i class="fa-solid fa-stamp"></i></div>
                <div><div style="font-size:12.5px; font-weight:700;">LİHKAB &amp; Kadastro Harcı</div><div style="font-size:11px; color:#94a3b8;">Aplikasyon &amp; cins değişikliği</div></div>
            </a>
            <a href="/harita-muhendislik-fiyat-teklifi" style="display:flex; align-items:center; gap:10px; padding:10px 12px; background:#131d31; border:1px solid #1e293b; border-radius:10px; text-decoration:none; color:#f8fafc;">
                <div style="width:36px; height:36px; border-radius:8px; background:rgba(56,189,248,0.15); color:#38bdf8; display:flex; align-items:center; justify-content:center; font-size:16px;"><i class="fa-solid fa-compass-drafting"></i></div>
                <div><div style="font-size:12.5px; font-weight:700;">Mühendislik Teklif Motoru</div><div style="font-size:11px; color:#94a3b8;">HKMO 2026 asgari tarife</div></div>
            </a>
            <a href="/kentsel-donusum-yarisi-bizden" style="display:flex; align-items:center; gap:10px; padding:10px 12px; background:#131d31; border:1px solid #1e293b; border-radius:10px; text-decoration:none; color:#f8fafc;">
                <div style="width:36px; height:36px; border-radius:8px; background:rgba(245,158,11,0.15); color:#f59e0b; display:flex; align-items:center; justify-content:center; font-size:16px;"><i class="fa-solid fa-building-shield"></i></div>
                <div><div style="font-size:12.5px; font-weight:700;">Yarısı Bizden &amp; Şerefiye</div><div style="font-size:11px; color:#94a3b8;">Kentsel dönüşüm hibe/kredi</div></div>
            </a>
        </div>
    </section>

    <script>
        const REGIONS = <?= json_encode($SOLAR_REGIONS, JSON_UNESCAPED_UNICODE) ?>;
        const USD_RATE = 38.5; // Benchmark USD/TL rate

        function calcGes() {
            const regKey = document.getElementById('inputRegion').value;
            const landDonum = Math.max(1, parseFloat(document.getElementById('inputLandSize').value) || 15);
            const gridKm = Math.max(0.1, parseFloat(document.getElementById('inputGridDist').value) || 2.5);
            const soil = document.getElementById('inputSoil').value;

            const regData = REGIONS[regKey] || {radiation: 1600, efficiency: 1.45};

            // 1 Dönüm can hold roughly 75 kWp DC capacity
            const kwpCapacity = Math.round(landDonum * 75);
            const panelCount = Math.round((kwpCapacity * 1000) / 550);

            // Annual production: Capacity (kWp) * Regional Efficiency Factor
            const annualProductionKwh = kwpCapacity * regData.efficiency * 1000;
            const annualProductionMwh = Math.round(annualProductionKwh / 1000);

            // Cost calculation ($0.65 - $0.72 per Watt for EPC)
            const unitWattPrice = (soil === 'kayalik') ? 0.72 : 0.65;
            const epcBaseCostUsd = kwpCapacity * 1000 * unitWattPrice;
            const enhCostUsd = gridKm * 18000; // ~$18k per km of medium voltage line
            const totalCapexUsd = Math.round(epcBaseCostUsd + enhCostUsd);
            const totalCapexTl = Math.round(totalCapexUsd * USD_RATE);

            // Revenue calculation ($0.095 per kWh under EPDK / YEKDEM tariff)
            const electricityPriceUsd = 0.095;
            const annualRevenueUsd = Math.round(annualProductionKwh * electricityPriceUsd);
            const monthlyRevenueUsd = Math.round(annualRevenueUsd / 12);

            // ROI (Years)
            const roiYears = (annualRevenueUsd > 0) ? (totalCapexUsd / annualRevenueUsd).toFixed(1) : 4.0;
            const net25YearUsd = Math.round((annualRevenueUsd * 25) - totalCapexUsd - (totalCapexUsd * 0.15));

            document.getElementById('dispCapacity').innerText = (kwpCapacity >= 1000) ? (kwpCapacity / 1000).toFixed(2) + ' MWp' : kwpCapacity + ' kWp';
            document.getElementById('dispAnnualRevenue').innerText = '$ ' + annualRevenueUsd.toLocaleString('en-US');
            document.getElementById('dispRoiYears').innerText = roiYears + ' Yıl';

            document.getElementById('dispTotalCapex').innerText = '$ ' + totalCapexUsd.toLocaleString('en-US');
            document.getElementById('dispCapexTl').innerText = totalCapexTl.toLocaleString('tr-TR') + ' TL';

            document.getElementById('dispPanelCount').innerText = panelCount.toLocaleString('tr-TR') + ' Adet (550W)';
            document.getElementById('dispProductionMwh').innerText = annualProductionMwh.toLocaleString('tr-TR') + ' MWh / yıl';
            document.getElementById('dispGridCost').innerText = '$ ' + Math.round(enhCostUsd).toLocaleString('en-US');
            document.getElementById('dispGridKm').innerText = `${gridKm} km ENH Hattı`;
            document.getElementById('dispMonthlyRevenue').innerText = '$ ' + monthlyRevenueUsd.toLocaleString('en-US') + ' / ay';
            document.getElementById('disp25YearCash').innerText = '$ ' + net25YearUsd.toLocaleString('en-US');
        }

        window.addEventListener('DOMContentLoaded', calcGes);
    </script>
</body>
</html>
