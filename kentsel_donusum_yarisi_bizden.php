<?php
/**
 * ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ - PARSEL PRO
 * SaaS: Kentsel Dönüşüm "Yarısı Bizden" & Şerefiye Hak Sahipliği Motoru
 * Pure PHP 8.3 / Responsive SaaS UI / 6306 sayılı Kanun ve 2026 Yarısı Bizden Şartları
 */

declare(strict_types=1);

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/navbar.php';

$page_title = "Kentsel Dönüşüm Yarısı Bizden Hesaplama 2026 | ParselSorgu";
$meta_desc = "2026 Yarısı Bizden hibe ve kredi desteği, müteahhit paylaşım oranı, kat şerefiyesi ve daire başı borçlanma simülatörü.";
$canonical_url = "https://www.parselsorgu.net/kentsel-donusum-yarisi-bizden";

$CITIES_81 = [
    "İstanbul", "Ankara", "İzmir", "Bursa", "Antalya", "Adana", "Kocaeli", "Sakarya", "Tekirdağ", "Gaziantep",
    "Konya", "Kayseri", "Eskişehir", "Mersin", "Diyarbakır", "Samsun", "Denizli", "Şanlıurfa", "Adapazarı", "Balıkesir",
    "Aydın", "Kahramanmaraş", "Hatay", "Manisa", "Malatya", "Trabzon", "Elazığ", "Erzurum", "Sivas", "Van"
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
          "@id": "https://www.parselsorgu.net/kentsel-donusum-yarisi-bizden#app",
          "name": "Kentsel Dönüşüm Yarısı Bizden ve Şerefiye Hesaplama Motoru",
          "url": "https://www.parselsorgu.net/kentsel-donusum-yarisi-bizden",
          "description": "6306 sayılı Kentsel Dönüşüm Kanunu ve ÇŞİDB Yarısı Bizden kampanyası hibe, faizsiz kredi, tahliye desteği ve kat şerefiyesi hesaplayıcı.",
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
          "@id": "https://www.parselsorgu.net/kentsel-donusum-yarisi-bizden#breadcrumb",
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
              "name": "Kentsel Dönüşüm Yarısı Bizden Motoru",
              "item": "https://www.parselsorgu.net/kentsel-donusum-yarisi-bizden"
            }
          ]
        },
        {
          "@type": "FAQPage",
          "@id": "https://www.parselsorgu.net/kentsel-donusum-yarisi-bizden#faq",
          "mainEntity": [
            {
              "@type": "Question",
              "name": "Yarısı Bizden kampanyası 2026 destek tutarları ne kadardır?",
              "acceptedAnswer": {
                "@type": "Answer",
                "text": "Çevre, Şehircilik ve İklim Değişikliği Bakanlığı tarafından hak sahibi başına 700.000 TL hibe, 700.000 TL uygun faizli/faizsiz kredi ve 100.000 TL tahliye desteği olmak üzere toplam 1.500.000 TL finansman sağlanmaktadır."
              }
            },
            {
              "@type": "Question",
              "name": "Kentsel dönüşümde şerefiye farkı nasıl hesaplanır?",
              "acceptedAnswer": {
                "@type": "Answer",
                "text": "Şerefiye; dairenin bulunduğu kat (zemin, ara kat, üst kat), cephesi (güney, kuzey, cadde, arka bahçe), deniz/manzara durumu ve net kullanım alanına göre gayrimenkul değerleme puanlarıyla belirlenir."
              }
            },
            {
              "@type": "Question",
              "name": "Yarısı Bizden kredisi kaç yıl vadelidir?",
              "acceptedAnswer": {
                "@type": "Answer",
                "text": "Kredi vadesi 10 yıl (120 ay) olup, ilk 2 yıl geri ödemesiz veya inşaat süresince faizsizdir. Geri ödemeler yapı ruhsatı alındıktan 24 ay sonra başlar."
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
            background-color: var(--dark-bg);
            color: var(--text-main);
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            line-height: 1.5;
            padding-bottom: 40px;
        }
        .container { max-width: 1140px; margin: 0 auto; padding: 20px 16px; }
        .hero-banner {
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.12) 0%, rgba(56, 189, 248, 0.08) 100%);
            border: 1px solid rgba(245, 158, 11, 0.3);
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
        .stat-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; margin-bottom: 18px; }
        @media (max-width: 600px) { .stat-grid { grid-template-columns: 1fr; } }
        .stat-card {
            background: var(--card-surface);
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 14px;
            text-align: center;
        }
        .stat-val { font-size: 20px; font-weight: 900; color: #fff; margin-top: 4px; }
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
        .table-custom { width: 100%; border-collapse: collapse; font-size: 12.5px; margin-top: 10px; }
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
                <i class="fa-solid fa-building-shield"></i> 6306 SAYILI KANUN &amp; YARISI BİZDEN 2026
            </div>
            <h1 class="hero-title">Kentsel Dönüşüm "Yarısı Bizden" &amp; Şerefiye Motoru</h1>
            <p class="hero-desc">
                Bakanlık 1.5 Milyon TL'lik (700 Bin Hibe + 700 Bin Kredi + 100 Bin Tahliye) finansman desteği, inşaat maliyeti, müteahhit payı ve kat şerefiyesine göre daire başı net cebinizden çıkacak tutarı ve aylık taksitleri hesaplayın.
            </p>
        </div>

        <div class="grid-layout">
            <!-- Form Bölümü -->
            <div class="saas-card">
                <h2 style="font-size: 16.5px; font-weight: 800; margin-bottom: 16px; color:#fff; display:flex; align-items:center; gap:8px;">
                    <i class="fa-solid fa-sliders text-primary" style="color:#f59e0b;"></i> Bina ve Daire Parametreleri
                </h2>

                <div class="form-group">
                    <label class="form-label">Mevcut Binadaki Toplam Daire Sayısı</label>
                    <input type="number" id="inputApartmentCount" class="form-control" value="10" min="2" max="100" oninput="runSimulation()">
                </div>

                <div class="form-group">
                    <label class="form-label">Yeni Yapılacak Dairenin Brüt Alanı (m²)</label>
                    <input type="number" id="inputUnitM2" class="form-control" value="110" min="50" max="300" oninput="runSimulation()">
                </div>

                <div class="form-group">
                    <label class="form-label">2026 Yaklaşık İnşaat m² Birim Maliyeti (TL)</label>
                    <input type="number" id="inputCostPerM2" class="form-control" value="23000" min="15000" step="500" oninput="runSimulation()">
                    <div class="form-hint">ÇŞİDB 2026 III. Sınıf B grubu lüks konut birim maliyeti ortalaması.</div>
                </div>

                <div class="form-group">
                    <label class="form-label">Müteahhit Kat Karşılığı Payı / Fazla Kat İzni</label>
                    <select id="inputBuilderModel" class="form-select" onchange="runSimulation()">
                        <option value="none">Model 1: Kat Artışı Yok (Malikler İnşaatı Kendi Finanse Eder)</option>
                        <option value="builder_30">Model 2: %30 Emsal Artışı (Müteahhide İlave Daire Verilir)</option>
                        <option value="builder_50">Model 3: %50 Emsal Artışı (Maliyetin Çoğunu Müteahhit Karşılar)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Kendi Dairenizin Şerefiye Konumu (Kat ve Cephe)</label>
                    <select id="inputSerefiye" class="form-select" onchange="runSimulation()">
                        <option value="0">Standart Ara Kat / Orta Cephe (0 TL Fark)</option>
                        <option value="150000">Ön Cephe / Manzaralı / Güneye Bakan (+150.000 TL Şerefiye)</option>
                        <option value="300000">En Üst Kat / Çatı Dubleks / Özel Balkon (+300.000 TL Şerefiye)</option>
                        <option value="-150000">Giriş / Zemin Kat / Arka Cephe (-150.000 TL İndirimli)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">"Yarısı Bizden" Kampanyasından Yararlanıyor musunuz?</label>
                    <select id="inputCampaign" class="form-select" onchange="runSimulation()">
                        <option value="evet">Evet (700.000 TL Hibe + 700.000 TL Kredi Alınacak)</option>
                        <option value="hayir">Hayır (Sadece Kendi Bütçemiz / Standart Kredi)</option>
                    </select>
                </div>

                <button type="button" class="btn-action" onclick="runSimulation()">
                    <i class="fa-solid fa-chart-pie"></i> Şerefiye &amp; Finansmanı Hesapla
                </button>
            </div>

            <!-- Sonuç Tablosu -->
            <div class="saas-card">
                <div class="stat-grid">
                    <div class="stat-card">
                        <div class="stat-title">1 Daire İnşaat Maliyeti</div>
                        <div class="stat-val" id="dispUnitCost" style="color:#38bdf8;">0 TL</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-title">Devlet Hibe Desteği</div>
                        <div class="stat-val" id="dispGrant" style="color:#10b981;">700.000 TL</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-title">Net Cebinizden Çıkacak</div>
                        <div class="stat-val" id="dispNetCash" style="color:#f59e0b;">0 TL</div>
                    </div>
                </div>

                <div style="background:linear-gradient(135deg, rgba(245,158,11,0.12) 0%, rgba(15,23,42,0.9) 100%); border:1px solid rgba(245,158,11,0.35); border-radius:12px; padding:18px; margin-bottom:16px;">
                    <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:8px;">
                        <div>
                            <span style="font-size:11px; font-weight:800; color:#cbd5e1; text-transform:uppercase;">10 Yıl Vadeli Aylık Taksit (Kredi)</span>
                            <div style="font-size:26px; font-weight:900; color:#f59e0b;" id="dispMonthlyPayment">0 TL / ay</div>
                        </div>
                        <div style="text-align:right;">
                            <span style="font-size:11px; color:#94a3b8;">İlk 2 Yıl Geri Ödemesiz</span>
                            <div style="font-size:13px; font-weight:700; color:#10b981;">100.000 TL Taşınma Hibesi Dahil</div>
                        </div>
                    </div>
                </div>

                <h3 style="font-size:14px; font-weight:800; color:#fff; margin-bottom:8px;">
                    <i class="fa-solid fa-list-check" style="color:#38bdf8;"></i> Kat Malikleri Kurulu Şeffaf Bütçe Dökümü
                </h3>

                <table class="table-custom">
                    <thead>
                        <tr>
                            <th>Kalem</th>
                            <th>Açıklama</th>
                            <th style="text-align:right;">Tutar (TL)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Toplam Daire Kaba+İnce Maliyeti</td>
                            <td id="dispM2Desc">110 m² x 23.000 TL</td>
                            <td style="text-align:right;" id="dispRawCost">0 TL</td>
                        </tr>
                        <tr>
                            <td>Müteahhit Kat Artış Sübvansiyonu</td>
                            <td id="dispBuilderDesc">Emsal Artışı Yok</td>
                            <td style="text-align:right; color:#10b981;" id="dispBuilderDiscount">- 0 TL</td>
                        </tr>
                        <tr>
                            <td>Bakanlık "Yarısı Bizden" Hibesi</td>
                            <td>Karşılıksız Doğrudan Destek</td>
                            <td style="text-align:right; color:#10b981;" id="dispGrantRow">- 700.000 TL</td>
                        </tr>
                        <tr>
                            <td>Kat &amp; Cephe Şerefiye Farkı</td>
                            <td id="dispSerefiyeDesc">Standart Daire</td>
                            <td style="text-align:right;" id="dispSerefiyeRow">+ 0 TL</td>
                        </tr>
                        <tr style="background:rgba(245,158,11,0.1); font-weight:800;">
                            <td>Kalan Hak Sahibi Borç Tutarı</td>
                            <td>120 Ay Vadeli Kredi İmkanı</td>
                            <td style="text-align:right; color:#f59e0b; font-size:15px;" id="dispFinalDebt">0 TL</td>
                        </tr>
                    </tbody>
                </table>

                <div style="display:flex; gap:10px; margin-top:16px;">
                    <button type="button" class="btn-action" style="background:#1e293b; color:#cbd5e1; border:1px solid #334155;" onclick="window.print()">
                        <i class="fa-solid fa-print"></i> Karar Raporunu Yazdır
                    </button>
                    <a href="https://wa.me/905428413535?text=Merhaba,%20binamizin%20kentsel%20donusum%20ve%20serefiye%20hesabi%20icin%20harita%20muhendislik%20danismanligi%20almak%20istiyoruz." target="_blank" class="btn-action" style="background:#22c55e; color:#fff;">
                        <i class="fa-brands fa-whatsapp"></i> WhatsApp Destek
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
            <a href="/lihkab-hesaplama" style="display:flex; align-items:center; gap:10px; padding:10px 12px; background:#131d31; border:1px solid #1e293b; border-radius:10px; text-decoration:none; color:#f8fafc;">
                <div style="width:36px; height:36px; border-radius:8px; background:rgba(16,185,129,0.15); color:#10b981; display:flex; align-items:center; justify-content:center; font-size:16px;"><i class="fa-solid fa-stamp"></i></div>
                <div><div style="font-size:12.5px; font-weight:700;">LİHKAB &amp; Kadastro Harcı</div><div style="font-size:11px; color:#94a3b8;">Aplikasyon &amp; cins değişikliği</div></div>
            </a>
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
        </div>
    </section>

    <script>
        function runSimulation() {
            const m2 = Math.max(40, parseFloat(document.getElementById('inputUnitM2').value) || 110);
            const costM2 = Math.max(10000, parseFloat(document.getElementById('inputCostPerM2').value) || 23000);
            const builderModel = document.getElementById('inputBuilderModel').value;
            const serefiye = parseFloat(document.getElementById('inputSerefiye').value) || 0;
            const campaign = document.getElementById('inputCampaign').value;

            const unitRawCost = m2 * costM2;
            let builderDiscount = 0;
            let builderDesc = "Emsal Artışı Yok";

            if (builderModel === 'builder_30') {
                builderDiscount = unitRawCost * 0.35;
                builderDesc = "%30 Kat Karşılığı İndirimi";
            } else if (builderModel === 'builder_50') {
                builderDiscount = unitRawCost * 0.55;
                builderDesc = "%50 Emsal Artışı (Müteahhit Payı)";
            }

            const grant = (campaign === 'evet') ? 700000 : 0;
            const loanLimit = (campaign === 'evet') ? 700000 : 0;

            let netCostAfterDiscount = Math.max(0, unitRawCost - builderDiscount);
            let finalDebt = Math.max(0, netCostAfterDiscount - grant + serefiye);

            // If loan is used, calculate 120 months payment
            let loanUsed = Math.min(loanLimit, finalDebt);
            let outOfPocketCash = Math.max(0, finalDebt - loanUsed);

            // Interest subvention: ~0.69% monthly for 120 months
            let monthlyPayment = (loanUsed > 0) ? (loanUsed / 120) * 1.15 : 0;

            document.getElementById('dispUnitCost').innerText = Math.round(unitRawCost).toLocaleString('tr-TR') + ' TL';
            document.getElementById('dispGrant').innerText = (campaign === 'evet' ? '700.000 TL' : '0 TL');
            document.getElementById('dispNetCash').innerText = Math.round(outOfPocketCash).toLocaleString('tr-TR') + ' TL Peşin';
            document.getElementById('dispMonthlyPayment').innerText = Math.round(monthlyPayment).toLocaleString('tr-TR') + ' TL / ay';

            document.getElementById('dispM2Desc').innerText = `${m2} m² x ${costM2.toLocaleString('tr-TR')} TL`;
            document.getElementById('dispRawCost').innerText = Math.round(unitRawCost).toLocaleString('tr-TR') + ' TL';
            document.getElementById('dispBuilderDesc').innerText = builderDesc;
            document.getElementById('dispBuilderDiscount').innerText = '- ' + Math.round(builderDiscount).toLocaleString('tr-TR') + ' TL';
            document.getElementById('dispGrantRow').innerText = '- ' + Math.round(grant).toLocaleString('tr-TR') + ' TL';
            document.getElementById('dispSerefiyeDesc').innerText = (serefiye > 0 ? '+' : '') + serefiye.toLocaleString('tr-TR') + ' TL Şerefiye';
            document.getElementById('dispSerefiyeRow').innerText = (serefiye >= 0 ? '+' : '') + Math.round(serefiye).toLocaleString('tr-TR') + ' TL';
            document.getElementById('dispFinalDebt').innerText = Math.round(finalDebt).toLocaleString('tr-TR') + ' TL';
        }

        window.addEventListener('DOMContentLoaded', runSimulation);
    </script>
</body>
</html>
