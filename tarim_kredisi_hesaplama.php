<?php
/**
 * ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ - PARSEL PRO
 * SaaS 5: Ziraat Bankası Sübvansiyonlu Arazi & Tarım Kredisi Hesaplayıcı
 * Pure PHP 8.3 / FinTech SaaS / Cumhurbaşkanlığı Kararı Faiz İndirimi Motoru
 */

declare(strict_types=1);

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/navbar.php';

$page_title = "Sübvansiyonlu Tarım & Arazi Kredisi Hesaplama | ParselSorgu";
$meta_desc = "5403 hisseli arazi birleştirme ve genç/kadın çiftçi faiz indirimli tarım kredisi yıllık hasat vadeli ödeme planı hesaplayıcı.";
$canonical_url = "https://www.parselsorgu.net/tarim-kredisi-hesaplama";
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
            background: radial-gradient(circle at 50% 20%, rgba(16, 185, 129, 0.12) 0%, transparent 70%);
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

        .credit-grid {
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
        .form-control:focus { border-color: var(--green); }

        .btn-calc {
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
        }

        /* RESULT SUMMARY */
        .credit-summary-box {
            background: linear-gradient(180deg, #131d31 0%, #0d1527 100%);
            border: 1px solid var(--green);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            text-align: center;
        }
        .sub-box {
            background: rgba(0,0,0,0.3);
            padding: 12px;
            border-radius: 8px;
        }

        .plan-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
            color: #cbd5e1;
            margin-top: 14px;
        }
        .plan-table th {
            background: #17233d;
            color: var(--accent);
            padding: 9px 10px;
            text-align: left;
            font-weight: 700;
            border: 1px solid var(--border-color);
        }
        .plan-table td {
            padding: 8px 10px;
            border: 1px solid var(--border-color);
            background: rgba(19, 29, 49, 0.4);
        }

        @media (max-width: 900px) {
            .credit-grid { grid-template-columns: 1fr; }
            .credit-summary-box { grid-template-columns: 1fr; }
            .hero-banner h1 { font-size: 24px; }
        }
    </style>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@graph": [
    {
      "@type": "WebApplication",
      "@id": "https://www.parselsorgu.net/tarim-kredisi-hesaplama#app",
      "name": "Ziraat Bankası Sübvansiyonlu Tarım Kredisi Hesaplayıcı",
      "url": "https://www.parselsorgu.net/tarim-kredisi-hesaplama",
      "description": "Cumhurbaşkanlığı sübvansiyon kararnamesi kapsamında genç ve kadın çiftçi indirimli, hasat sonu yılda 1 ödemeli tarım ve arazi kredisi hesaplama aracı.",
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
      "@id": "https://www.parselsorgu.net/tarim-kredisi-hesaplama#breadcrumb",
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
          "name": "Ziraat Bankası Sübvansiyonlu Tarım Kredisi Hesaplayıcı",
          "item": "https://www.parselsorgu.net/tarim-kredisi-hesaplama"
        }
      ]
    },
    {
      "@type": "FAQPage",
      "@id": "https://www.parselsorgu.net/tarim-kredisi-hesaplama#faq",
      "mainEntity": [
        {
          "@type": "Question",
          "name": "Cumhurbaşkanlığı sübvansiyonlu tarım kredisi faiz indirimi ne kadardır?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Tarımsal arazi alımı ve modern sulama kredilerinde %25 ile %100 arasında faiz sübvansiyonu sağlanmaktadır."
          }
        },
        {
          "@type": "Question",
          "name": "Genç ve kadın çiftçi ek indirimleri nelerdir?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "40 yaş altı genç çiftçilere ve kadın üreticilere tarımsal kredilerde ilave %10-%15 puan faiz indirimi tanınmaktadır."
          }
        },
        {
          "@type": "Question",
          "name": "Tarım kredisi geri ödemeleri nasıl yapılır?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Üreticinin hasat dönemine bağlı olarak yılda 1 defa veya 6 ayda bir taksit seçenekleriyle 84 aya kadar vadeli ödeme planı düzenlenebilir."
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
                <i class="fa-solid fa-tractor"></i> 2026 Sübvansiyonlu Tarım Kredisi &bull; Cumhurbaşkanlığı Kararı
            </div>
            <h1>Ziraat Bankası &amp; Tarım Kredi <span>Sübvansiyonlu Kredi Motoru</span></h1>
            <p>
                5403 s.K. hisseli tarla birleştirme, genç ve kadın çiftçi faiz indirimleri, %100 faizsiz sulama desteği ve yıllık hasat vadeli taksit hesaplayıcı.
            </p>
        </section>

        <div class="credit-grid">
            <!-- SOL FORM -->
            <div class="panel-card">
                <div class="panel-title">
                    <i class="fa-solid fa-hand-holding-dollar" style="color:var(--green);"></i>
                    <span>Kredi Parametreleri</span>
                </div>

                <div class="form-group">
                    <label class="form-label">Kredi Konusu / Amacı</label>
                    <select id="credit_type" class="form-control" onchange="calculateCredit()">
                        <option value="hisse_birlestirme" selected>5403 s.K. Hisseli Tarla Alımı (Hisse Birleştirme)</option>
                        <option value="arazi_alim">Müstakil Tarımsal Arazi Alımı</option>
                        <option value="basincli_sulama">Basınçlı Damla / Yağmurlama Sulama Sistemi</option>
                        <option value="bahce_tesis">Modern Meyve Bahçesi Tesisi</option>
                        <option value="traktor">Traktör &amp; Tarım Makineleri</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Kredi Tutarı (TL)</label>
                    <input type="number" id="credit_amount" class="form-control" value="1000000" step="50000" oninput="calculateCredit()">
                </div>

                <div class="form-group">
                    <label class="form-label">Geri Ödeme Vadesi</label>
                    <select id="credit_term" class="form-control" onchange="calculateCredit()">
                        <option value="1">1 Yıl (12 Ay)</option>
                        <option value="2">2 Yıl (24 Ay)</option>
                        <option value="3">3 Yıl (36 Ay)</option>
                        <option value="4">4 Yıl (48 Ay)</option>
                        <option value="5" selected>5 Yıl (60 Ay)</option>
                        <option value="7">7 Yıl (84 Ay)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Ödeme Sıklığı</label>
                    <select id="payment_frequency" class="form-control" onchange="calculateCredit()">
                        <option value="annual" selected>Yılda 1 Kez (Hasat Sonu)</option>
                        <option value="semi_annual">6 Ayda Bir</option>
                        <option value="monthly">Aylık Taksitli</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Ek Sübvansiyon İndirimleri</label>
                    <div style="font-size:12px; color:#cbd5e1; background:var(--card-surface); padding:10px; border-radius:8px; border:1px solid var(--border-color);">
                        <label style="display:flex; align-items:center; gap:8px; margin-bottom:6px; cursor:pointer;">
                            <input type="checkbox" id="chk_young" onchange="calculateCredit()"> Genç Çiftçi (&lt;41 Yaş) [+%15 İndirim]
                        </label>
                        <label style="display:flex; align-items:center; gap:8px; cursor:pointer;">
                            <input type="checkbox" id="chk_woman" onchange="calculateCredit()"> Kadın Girişimci Çiftçi [+%15 İndirim]
                        </label>
                    </div>
                </div>

                <button type="button" class="btn-calc" onclick="calculateCredit()">
                    <i class="fa-solid fa-calculator"></i> Ödeme Planını Hesapla
                </button>
            </div>

            <!-- SAĞ SONUÇ -->
            <div class="panel-card">
                <div class="credit-summary-box">
                    <div class="sub-box">
                        <div style="font-size:11.5px; color:#94a3b8;">Uygulanan Faiz Oranı:</div>
                        <div style="font-size:18px; font-weight:800; color:#38bdf8;" id="dispInterestRate">%14.5 / yıl</div>
                        <div style="font-size:10px; color:#10b981;" id="dispSubsidizedDiscount">(%65 Sübvansiyon)</div>
                    </div>
                    <div class="sub-box">
                        <div style="font-size:11.5px; color:#94a3b8;">Yıllık Taksit Tutarı:</div>
                        <div style="font-size:18px; font-weight:800; color:#10b981;" id="dispInstallment">295.000 TL</div>
                        <div style="font-size:10px; color:#cbd5e1;">Hasat Vadeli</div>
                    </div>
                    <div class="sub-box">
                        <div style="font-size:11.5px; color:#94a3b8;">Devlet Faiz Katkısı:</div>
                        <div style="font-size:18px; font-weight:800; color:#f59e0b;" id="dispGovernmentSubsidy">420.000 TL</div>
                        <div style="font-size:10px; color:#94a3b8;">Cebinizde Kalan</div>
                    </div>
                </div>

                <div class="panel-title">
                    <i class="fa-solid fa-calendar-check" style="color:var(--accent);"></i>
                    <span>Hasat Vadeli Geri Ödeme Planı</span>
                </div>

                <div style="overflow-x:auto;">
                    <table class="plan-table">
                        <thead>
                            <tr>
                                <th>Taksit No</th>
                                <th>Vade Tarihi</th>
                                <th>Anapara</th>
                                <th>İndirimli Faiz</th>
                                <th>Toplam Taksit</th>
                                <th>Kalan Borç</th>
                            </tr>
                        </thead>
                        <tbody id="dispPlanTable">
                            <!-- Populated via JS -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <script>
        function calculateCredit() {
            const type = document.getElementById('credit_type').value;
            const amount = parseFloat(document.getElementById('credit_amount').value) || 100000;
            const term = parseInt(document.getElementById('credit_term').value) || 5;
            const isYoung = document.getElementById('chk_young').checked;
            const isWoman = document.getElementById('chk_woman').checked;

            // Base market rate ~42%
            let baseRate = 0.42;
            let subsidyPercent = 0.50; // default 50% discount

            if (type === 'basincli_sulama') subsidyPercent = 1.00; // 0 interest
            else if (type === 'hisse_birlestirme') subsidyPercent = 0.65;
            else if (type === 'bahce_tesis') subsidyPercent = 0.55;
            else if (type === 'traktor') subsidyPercent = 0.40;

            if (isYoung) subsidyPercent += 0.15;
            if (isWoman) subsidyPercent += 0.15;
            subsidyPercent = Math.min(1.00, subsidyPercent);

            let effectiveRate = baseRate * (1 - subsidyPercent);

            document.getElementById('dispInterestRate').innerText = `%${(effectiveRate * 100).toFixed(1)} / yıl`;
            document.getElementById('dispSubsidizedDiscount').innerText = `(%${(subsidyPercent * 100).toFixed(0)} Sübvansiyon)`;

            // Compute equal principal installments
            const principalPerYear = amount / term;
            let remaining = amount;
            let totalGovSubsidy = 0;

            const tbody = document.getElementById('dispPlanTable');
            let planRows = [];
            const currentYear = 2026;

            for (let i = 1; i <= term; i++) {
                let interestThisYear = remaining * effectiveRate;
                let marketInterestThisYear = remaining * baseRate;
                totalGovSubsidy += (marketInterestThisYear - interestThisYear);

                let totalPayment = principalPerYear + interestThisYear;
                remaining -= principalPerYear;
                if (remaining < 0.1) remaining = 0;

                planRows.push(`
                    <tr>
                        <td><strong>${i}. Hasat Taksiti</strong></td>
                        <td>Kasım ${currentYear + i}</td>
                        <td>${principalPerYear.toLocaleString('tr-TR', {maximumFractionDigits:0})} TL</td>
                        <td>${interestThisYear.toLocaleString('tr-TR', {maximumFractionDigits:0})} TL</td>
                        <td style="color:#10b981; font-weight:700;">${totalPayment.toLocaleString('tr-TR', {maximumFractionDigits:0})} TL</td>
                        <td>${remaining.toLocaleString('tr-TR', {maximumFractionDigits:0})} TL</td>
                    </tr>
                `);
            }

            tbody.innerHTML = planRows.join('');
            document.getElementById('dispInstallment').innerText = `${((amount / term) + (amount * effectiveRate)).toLocaleString('tr-TR', {maximumFractionDigits:0})} TL`;
            document.getElementById('dispGovernmentSubsidy').innerText = `${totalGovSubsidy.toLocaleString('tr-TR', {maximumFractionDigits:0})} TL`;
        }

        window.addEventListener('DOMContentLoaded', calculateCredit);
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
