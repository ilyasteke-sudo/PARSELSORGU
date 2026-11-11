<?php
/**
 * ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ - PARSEL PRO
 * SaaS 2: 2026 Otomatik Emlak Vergisi & Belediye Harç Hesaplayıcı
 * Pure PHP 8.3 / 1319 s. Emlak Vergisi Kanunu Uyumlu
 */

declare(strict_types=1);

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/navbar.php';

$page_title = "2026 Emlak Vergisi & Rayiç Bedel Hesaplama | ParselSorgu";
$meta_desc = "1319 Sayılı Kanun uyarınca belediye rayiç bedeli üzerinden 2026 arsa, arazi, konut ve işyeri emlak vergisi tutarlarını hesaplayın.";
$canonical_url = "https://www.parselsorgu.net/emlak-vergisi-hesaplama";

$BUYUKSEHIRLER = [
    "Adana", "Ankara", "Antalya", "Aydın", "Balıkesir", "Bursa", "Denizli", "Diyarbakır", "Erzurum", "Eskişehir",
    "Gaziantep", "Hatay", "İstanbul", "İzmir", "Kahramanmaraş", "Kayseri", "Kocaeli", "Konya", "Malatya", "Manisa",
    "Mardin", "Mersin", "Muğla", "Ordu", "Sakarya", "Samsun", "Şanlıurfa", "Tekirdağ", "Trabzon", "Van"
];

$ALL_CITIES = [
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
    <link rel="canonical" href="<?= $canonical_url ?>">
    <meta property="og:image" content="https://www.parselsorgu.net/assets/images/og-parsel.jpg">
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
            max-width: 1180px;
            margin: 0 auto;
            padding: 24px 16px 80px 16px;
        }

        .hero-banner {
            text-align: center;
            padding: 36px 16px 28px 16px;
            background: radial-gradient(circle at 50% 20%, rgba(56, 189, 248, 0.12) 0%, transparent 70%);
            border-bottom: 1px solid var(--border-color);
            margin-bottom: 30px;
        }
        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(56, 189, 248, 0.12);
            border: 1px solid rgba(56, 189, 248, 0.35);
            padding: 5px 14px;
            border-radius: 20px;
            font-size: 12.5px;
            font-weight: 700;
            color: var(--accent);
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

        .calc-grid {
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
            margin-bottom: 18px;
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
        .form-control:focus { border-color: var(--accent); }

        .btn-calc {
            width: 100%;
            background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
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
        }

        /* RESULT SUMMARY */
        .tax-summary-box {
            background: linear-gradient(180deg, #131d31 0%, #0d1527 100%);
            border: 1px solid var(--accent);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 14px;
        }
        .tax-total {
            font-size: 26px;
            font-weight: 900;
            color: #10b981;
        }

        .tax-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
            margin-top: 14px;
        }
        .tax-table td {
            padding: 10px 12px;
            border-bottom: 1px solid rgba(255,255,255,0.06);
            color: #cbd5e1;
        }
        .tax-table tr:last-child td { border-bottom: none; }
        .tax-table td:last-child {
            text-align: right;
            font-weight: 700;
            color: #fff;
        }

        .exempt-box {
            background: rgba(16, 185, 129, 0.08);
            border: 1px solid rgba(16, 185, 129, 0.25);
            border-radius: 10px;
            padding: 14px;
            margin-top: 18px;
            font-size: 12px;
            color: #a7f3d0;
            line-height: 1.5;
        }

        @media (max-width: 900px) {
            .calc-grid { grid-template-columns: 1fr; }
            .hero-banner h1 { font-size: 24px; }
        }
    </style>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@graph": [
    {
      "@type": "WebApplication",
      "@id": "https://www.parselsorgu.net/emlak-vergisi-hesaplama#app",
      "name": "2026 Otomatik Emlak Vergisi ve Belediye Harç Motoru",
      "url": "https://www.parselsorgu.net/emlak-vergisi-hesaplama",
      "description": "Arsa, arazi, konut ve işyeri için 2026 güncel büyükşehir ve diğer iller emlak vergisi, kültür payı ve 1./2. taksit hesaplama aracı.",
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
      "@id": "https://www.parselsorgu.net/emlak-vergisi-hesaplama#breadcrumb",
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
          "name": "2026 Otomatik Emlak Vergisi ve Belediye Harç Motoru",
          "item": "https://www.parselsorgu.net/emlak-vergisi-hesaplama"
        }
      ]
    },
    {
      "@type": "FAQPage",
      "@id": "https://www.parselsorgu.net/emlak-vergisi-hesaplama#faq",
      "mainEntity": [
        {
          "@type": "Question",
          "name": "2026 yılı emlak vergisi oranları ne kadardır?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Büyükşehir belediyesi sınırları içinde konutlarda binde 2, işyerlerinde binde 4, arsalarda binde 6, arazilerde binde 2 uygulanır. Diğer illerde bu oranlar yarı yarıya hesaplanır."
          }
        },
        {
          "@type": "Question",
          "name": "2026 emlak vergisi ne zaman ve kaç taksitte ödenir?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Emlak vergisi yılda 2 eşit taksitte ödenir. 1. taksit Mart-Mayıs ayları arasında, 2. taksit ise Kasım ayı sonuna kadar ilgili ilçe belediyesine ödenir."
          }
        },
        {
          "@type": "Question",
          "name": "Kimler emlak vergisinden muaftır?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Tek meskene sahip geliri olmayanlar, emekliler, gaziler ve engelliler 200 m²'yi geçmeyen tek konutları için sıfır oranlı emlak vergisinden yararlanabilir."
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
                <i class="fa-solid fa-receipt"></i> 1319 Sayılı Emlak Vergisi Kanunu &bull; 2026 Parametreleri
            </div>
            <h1>2026 Emlak Vergisi &amp; <span>Rayiç Bedel Hesaplama</span></h1>
            <p>
                Büyükşehir ve ilçe bazında arsa, tarla, konut ve işyeri için yıllık toplam vergi, 1. ve 2. taksit tutarları ile %10 Taşınmaz Kültür Varlıkları Payı hesaplayıcı.
            </p>
        </section>

        <div class="calc-grid">
            <!-- SOL FORM -->
            <div class="panel-card">
                <div class="panel-title">
                    <i class="fa-solid fa-sliders" style="color:var(--accent);"></i>
                    <span>Taşınmaz Bilgileri</span>
                </div>

                <div class="form-group">
                    <label class="form-label">Taşınmaz Türü</label>
                    <select id="prop_type" class="form-control" onchange="calculateTax()">
                        <option value="arsa" selected>Arsa (İmarlı)</option>
                        <option value="arazi">Arazi / Tarla (İmarsız)</option>
                        <option value="mesken">Mesken (Konut / Daire)</option>
                        <option value="isyeri">İşyeri / Dükkan / Fabrika</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">İl Seçiniz</label>
                    <select id="city_name" class="form-control" onchange="calculateTax()">
                        <?php foreach ($ALL_CITIES as $city): ?>
                            <option value="<?= htmlspecialchars($city) ?>" <?= ($city === 'Ankara') ? 'selected' : '' ?>><?= htmlspecialchars($city) ?> <?= in_array($city, $BUYUKSEHIRLER) ? '(Büyükşehir)' : '' ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Belediye Asgari Rayiç Değeri (TL)</label>
                    <input type="number" id="tax_value" class="form-control" value="1500000" step="10000" oninput="calculateTax()">
                    <span style="font-size:11px; color:#94a3b8; margin-top:3px; display:block;">E-Devlet veya belediye rayiç bedeli toplamı.</span>
                </div>

                <div class="form-group">
                    <label class="form-label">Muafiyet Durumu</label>
                    <select id="exemption" class="form-control" onchange="calculateTax()">
                        <option value="none" selected>Muafiyet Yok (Standart Mükellef)</option>
                        <option value="emekli">Emekli (Tek Konut, &lt;200m²)</option>
                        <option value="engelli">Engelli Vatandaş (Tek Konut)</option>
                        <option value="sehit_gazi">Şehit Yakını / Gazi (Tek Konut)</option>
                        <option value="gelirsiz">Hiçbir Geliri Olmayan (Ev Hanımı/İşsiz)</option>
                    </select>
                </div>

                <button type="button" class="btn-calc" onclick="calculateTax()">
                    <i class="fa-solid fa-calculator"></i> Vergiyi Hesapla
                </button>
            </div>

            <!-- SAĞ SONUÇ -->
            <div class="panel-card">
                <div class="tax-summary-box">
                    <div>
                        <div style="font-size:12px; color:#94a3b8; font-weight:700; text-transform:uppercase;">Yıllık Toplam Emlak Vergisi:</div>
                        <div class="tax-total" id="dispTotalTax">9.900 TL</div>
                    </div>
                    <div>
                        <span id="dispRateBadge" style="background:rgba(56,189,248,0.15); color:var(--accent); font-weight:800; font-size:12px; padding:6px 12px; border-radius:8px; border:1px solid rgba(56,189,248,0.3);">
                            Binde 6 (%0.6) Oran
                        </span>
                    </div>
                </div>

                <div class="panel-title">
                    <i class="fa-solid fa-receipt" style="color:var(--green);"></i>
                    <span>2026 Taksit ve Harç Dökümü</span>
                </div>

                <table class="tax-table">
                    <tbody>
                        <tr>
                            <td>Belediye Emlak Vergisi Asıl Tutarı:</td>
                            <td id="dispBaseTax">9.000 TL</td>
                        </tr>
                        <tr>
                            <td>Kültür Varlıkları Katkı Payı (%10):</td>
                            <td id="dispCultureTax">900 TL</td>
                        </tr>
                        <tr style="background:rgba(56,189,248,0.05);">
                            <td><strong style="color:#38bdf8;">1. Taksit (Mart - Mayıs 2026):</strong></td>
                            <td id="dispInstallment1" style="color:#38bdf8;">4.950 TL</td>
                        </tr>
                        <tr style="background:rgba(56,189,248,0.05);">
                            <td><strong style="color:#38bdf8;">2. Taksit (Kasım 2026):</strong></td>
                            <td id="dispInstallment2" style="color:#38bdf8;">4.950 TL</td>
                        </tr>
                    </tbody>
                </table>

                <div class="exempt-box" id="dispExemptNote" style="display:none;">
                    <i class="fa-solid fa-circle-check"></i> <strong>Sıfır Oranlı Emlak Vergisi Muafiyeti:</strong> Seçtiğiniz muafiyet şartı gereği 200 m² altındaki tek meskeniniz için 2026 yılında emlak vergisi ödemezsiniz (0 TL).
                </div>
            </div>
        </div>
    </main>

    <script>
        const buyuksehirler = <?= json_encode($BUYUKSEHIRLER) ?>;

        function calculateTax() {
            const propType = document.getElementById('prop_type').value;
            const city = document.getElementById('city_name').value;
            const value = parseFloat(document.getElementById('tax_value').value) || 0;
            const exemption = document.getElementById('exemption').value;

            const isBig = buyuksehirler.includes(city);

            // Determine tax rate
            let rate = 0;
            if (propType === 'arsa') rate = isBig ? 0.006 : 0.003;
            else if (propType === 'arazi') rate = isBig ? 0.002 : 0.001;
            else if (propType === 'mesken') rate = isBig ? 0.002 : 0.001;
            else if (propType === 'isyeri') rate = isBig ? 0.004 : 0.002;

            const exemptApplicable = (exemption !== 'none' && propType === 'mesken');
            document.getElementById('dispExemptNote').style.display = exemptApplicable ? 'block' : 'none';

            let baseTax = exemptApplicable ? 0 : (value * rate);
            let cultureTax = baseTax * 0.10;
            let totalTax = baseTax + cultureTax;

            document.getElementById('dispBaseTax').innerText = baseTax.toLocaleString('tr-TR') + ' TL';
            document.getElementById('dispCultureTax').innerText = cultureTax.toLocaleString('tr-TR') + ' TL';
            document.getElementById('dispTotalTax').innerText = totalTax.toLocaleString('tr-TR') + ' TL';
            document.getElementById('dispInstallment1').innerText = (totalTax / 2).toLocaleString('tr-TR') + ' TL';
            document.getElementById('dispInstallment2').innerText = (totalTax / 2).toLocaleString('tr-TR') + ' TL';

            document.getElementById('dispRateBadge').innerText = isBig 
                ? `Büyükşehir Oranı: Binde ${(rate * 1000)}` 
                : `Normal İlçe Oranı: Binde ${(rate * 1000)}`;
        }

        window.addEventListener('DOMContentLoaded', calculateTax);
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
