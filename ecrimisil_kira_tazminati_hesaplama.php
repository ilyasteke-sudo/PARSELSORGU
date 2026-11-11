<?php
/**
 * ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ - PARSEL PRO
 * SaaS: Hisseli Taşınmaz Ecrimisil (Geriye Dönük Kira Tazminatı) Hesaplayıcı
 * Pure PHP 8.3 / Responsive SaaS UI / TMK 995 ve Yargıtay Hukuk Genel Kurulu Esasları
 */

declare(strict_types=1);

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/navbar.php';

$page_title = "Hisseli Taşınmaz Ecrimisil Hesaplama (2026) | ParselSorgu";
$meta_desc = "Miras kalan tarla veya arsada haksız kullanıma karşı 5 yıllık Ecrimisil kira tazminatı, yasal faiz ve intifadan men ihtarnamesi.";
$canonical_url = "https://www.parselsorgu.net/ecrimisil-hesaplama";
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
          "@id": "https://www.parselsorgu.net/ecrimisil-hesaplama#app",
          "name": "Hisseli Taşınmaz Ecrimisil ve Haksız İşgal Tazminatı Motoru",
          "url": "https://www.parselsorgu.net/ecrimisil-hesaplama",
          "description": "TMK 995 ve Yargıtay kararlarına göre 5 yıllık geriye dönük hisseli tarla ve konut ecrimisil bedeli ve noter ihtarnamesi hazırlayıcı.",
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
          "@id": "https://www.parselsorgu.net/ecrimisil-hesaplama#breadcrumb",
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
              "name": "Hisseli Tapu Ecrimisil Hesaplama",
              "item": "https://www.parselsorgu.net/ecrimisil-hesaplama"
            }
          ]
        },
        {
          "@type": "FAQPage",
          "@id": "https://www.parselsorgu.net/ecrimisil-hesaplama#faq",
          "mainEntity": [
            {
              "@type": "Question",
              "name": "Ecrimisil davası geriye dönük kaç yıl için açılabilir?",
              "acceptedAnswer": {
                "@type": "Answer",
                "text": "Ecrimisil (haksız işgal tazminatı) davalarında zamanaşımı süresi Türk Borçlar Kanunu ve Medeni Kanun uyarınca dava tarihinden geriye doğru 5 yıldır."
              }
            },
            {
              "@type": "Question",
              "name": "Hissedarlar arasında intifadan men koşulu nedir?",
              "acceptedAnswer": {
                "@type": "Answer",
                "text": "Paydaşlar arasında ecrimisil istenebilmesi için kural olarak hak sahibinin diğer paydaşa taşınmazdan yararlanma arzusunu noter ihtarnamesi veya yazılı belgeyle bildirmiş (intifadan men etmiş) olması gerekir. Ancak tarla gibi doğal ürün veren veya kiraya verilerek gelir getiren taşınmazlarda intifadan men şartı aranmaz."
              }
            },
            {
              "@type": "Question",
              "name": "Ecrimisile yasal faiz işletilir mi?",
              "acceptedAnswer": {
                "@type": "Answer",
                "text": "Evet, ecrimisil alacaklarında her dönemin (yılın) bitiminden itibaren yasal faiz (%9 - %24) işletilerek tahsil edilir."
              }
            }
          ]
        }
      ]
    }
    </script>

    <style>
        :root {
            --primary: #c084fc;
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
            background-color: var(--dark-bg);
            color: var(--text-main);
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            line-height: 1.5;
            padding-bottom: 40px;
        }
        .container { max-width: 1140px; margin: 0 auto; padding: 20px 16px; }
        .hero-banner {
            background: linear-gradient(135deg, rgba(192, 132, 252, 0.12) 0%, rgba(56, 189, 248, 0.08) 100%);
            border: 1px solid rgba(192, 132, 252, 0.3);
            border-radius: 16px;
            padding: 28px 24px;
            margin-bottom: 24px;
        }
        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(192, 132, 252, 0.2);
            color: #c084fc;
            font-size: 12px;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 20px;
            margin-bottom: 12px;
            border: 1px solid rgba(192, 132, 252, 0.4);
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
        .summary-box {
            background: linear-gradient(135deg, rgba(192, 132, 252, 0.15) 0%, rgba(15, 23, 42, 0.8) 100%);
            border: 1px solid rgba(192, 132, 252, 0.35);
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            margin-bottom: 20px;
        }
        .total-amount { font-size: 34px; font-weight: 900; color: #c084fc; margin: 6px 0; }
        .total-label { font-size: 12px; font-weight: 700; color: #cbd5e1; text-transform: uppercase; }
        .table-custom { width: 100%; border-collapse: collapse; font-size: 12.5px; margin-top: 10px; }
        .table-custom th { text-align: left; padding: 9px 10px; background: var(--card-surface); color: var(--text-muted); border-bottom: 1px solid var(--border-color); }
        .table-custom td { padding: 9px 10px; border-bottom: 1px solid #1e293b; color: #e2e8f0; }
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
        .ihtarname-box {
            background: #090e17;
            border: 1px solid #334155;
            border-radius: 10px;
            padding: 16px;
            font-family: monospace;
            font-size: 11.5px;
            color: #cbd5e1;
            max-height: 200px;
            overflow-y: auto;
            white-space: pre-wrap;
            margin-top: 12px;
        }
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
                <i class="fa-solid fa-scale-balanced"></i> TMK 995 &amp; YARGITAY HUKUK GENEL KURULU
            </div>
            <h1 class="hero-title">Hisseli Taşınmaz Ecrimisil (Kira Tazminatı) Hesaplayıcı</h1>
            <p class="hero-desc">
                Miras kalan tarla, arsa veya konutunuzu sizden izinsiz kullanan, eken ya da kiraya veren diğer hissedarlardan geriye dönük 5 yıllık ecrimisil bedeli ve yasal faizini hesaplayın; noter ihtarname taslağını oluşturun.
            </p>
        </div>

        <div class="grid-layout">
            <!-- Girdi Formu -->
            <div class="saas-card">
                <h2 style="font-size: 16.5px; font-weight: 800; margin-bottom: 16px; color:#fff; display:flex; align-items:center; gap:8px;">
                    <i class="fa-solid fa-gavel text-primary" style="color:#c084fc;"></i> Taşınmaz ve Paylaşım Kriterleri
                </h2>

                <div class="form-group">
                    <label class="form-label">Taşınmaz Türü</label>
                    <select id="inputType" class="form-select" onchange="calcEcrimisil()">
                        <option value="konut">Konut (Daire, Müstakil Ev, Yazlık)</option>
                        <option value="tarla">Tarla / Tarımsal Arazi (Ekilen / Mahsul Alınan)</option>
                        <option value="dukkan">Ticari İşyeri / Dükkan / Depo</option>
                        <option value="arsa">Boş Arsa (Otopark, Depolama Alanı vb.)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Güncel Aylık / Yıllık Emsal Kira Rayici (TL)</label>
                    <input type="number" id="inputCurrentRent" class="form-control" value="20000" min="500" step="500" oninput="calcEcrimisil()">
                    <div class="form-hint" id="hintRent">Konut için aylık tahmini kira bedelini giriniz.</div>
                </div>

                <div class="form-group">
                    <label class="form-label">Tapudaki Miras / Mülkiyet Hisse Oranınız</label>
                    <select id="inputShare" class="form-select" onchange="calcEcrimisil()">
                        <option value="0.50">1/2 (%50 Pay)</option>
                        <option value="0.25" selected>1/4 (%25 Pay)</option>
                        <option value="0.125">1/8 (%12.5 Pay)</option>
                        <option value="0.333">1/3 (%33.3 Pay)</option>
                        <option value="0.166">1/6 (%16.6 Pay)</option>
                        <option value="0.0625">1/16 (%6.25 Pay)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Geriye Dönük Talep Edilen Süre</label>
                    <select id="inputYears" class="form-select" onchange="calcEcrimisil()">
                        <option value="5" selected>Son 5 Yıl (Yasal Azami Zamanaşımı Sınırı)</option>
                        <option value="4">Son 4 Yıl</option>
                        <option value="3">Son 3 Yıl</option>
                        <option value="2">Son 2 Yıl</option>
                        <option value="1">Son 1 Yıl</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Yasal Faiz Talep Edilsin mi?</label>
                    <select id="inputInterest" class="form-select" onchange="calcEcrimisil()">
                        <option value="evet">Evet (Yıllık Kademeli Yasal Faiz İşletilsin)</option>
                        <option value="hayir">Hayır (Sadece Ana Para Kira Farkı)</option>
                    </select>
                </div>

                <button type="button" class="btn-action" onclick="calcEcrimisil()">
                    <i class="fa-solid fa-calculator"></i> Ecrimisil Tutarını Hesapla
                </button>
            </div>

            <!-- Sonuç ve İhtarname -->
            <div class="saas-card">
                <div class="summary-box">
                    <div class="total-label">TOPLAM HAK EDİLEN ECRİMİSİL ALACAĞI</div>
                    <div class="total-amount" id="dispTotalEcrimisil">0 TL</div>
                    <div style="font-size:12px; color:#cbd5e1;" id="dispInterestNote">Ana Para ve Yasal Faiz Dahildir</div>
                </div>

                <h3 style="font-size:14.5px; font-weight:800; color:#fff; margin-bottom:8px;">
                    <i class="fa-solid fa-calendar-days text-accent" style="color:#38bdf8;"></i> 5 Yıllık Geriye Dönük Yıllık Döküm
                </h3>

                <table class="table-custom">
                    <thead>
                        <tr>
                            <th>Yıl / Dönem</th>
                            <th>Emsal Yıllık Rayiç</th>
                            <th>Hissenize Düşen</th>
                            <th style="text-align:right;">Faizli Tutar</th>
                        </tr>
                    </thead>
                    <tbody id="dispTableBody">
                        <!-- JS injects rows -->
                    </tbody>
                </table>

                <div style="margin-top:20px;">
                    <div style="display:flex; justify-content:space-between; align-items:center;">
                        <h4 style="font-size:13.5px; font-weight:800; color:#fff;">
                            <i class="fa-solid fa-scroll text-primary" style="color:#c084fc;"></i> Noter "İntifadan Men" İhtarname Taslağı
                        </h4>
                        <button type="button" onclick="copyIhtarname()" style="background:#1e293b; color:#38bdf8; border:1px solid #334155; padding:4px 10px; border-radius:6px; font-size:11px; cursor:pointer;">
                            <i class="fa-solid fa-copy"></i> Metni Kopyala
                        </button>
                    </div>
                    <div class="ihtarname-box" id="ihtarnameContent">
İHTARNAME
KEŞİDECİ (HAK SAHİBİ): [Adınız Soyadınız] - T.C. Kimlik No: [...]
MUHATAP (KULLANAN PAYDAŞ): [Hissedarın Adı Soyadı]
KONU: TMK m. 995 Uyarınca İntifadan Men ve 5 Yıllık Ecrimisil (Haksız İşgal Tazminatı) Talebidir.

AÇIKLAMALAR:
1- Müşterek mülkiyetimizde bulunan taşınmaz, tarafımın rızası ve onayı bulunmaksızın tek başınıza tasarrufunuzda tutulmakta, kiraya verilmekte veya bizzat kullanılmaktadır.
2- İşbu ihtarnamenin tebliğinden itibaren taşınmazdaki haksız işgalinize son vermenizi (İntifadan Men),
3- Geriye dönük yasal 5 yıllık ecrimisil alacağım olan toplam tutarın yasal faizi ile birlikte 7 gün içinde tarafıma ait IBAN numarasına ödenmesini,
4- Aksi takdirde Sulh Hukuk / Asliye Hukuk Mahkemelerinde Ecrimisil ve İzale-i Şüyu (Ortaklığın Giderilmesi) davası açılacağını, yargılama ve vekalet ücretlerinin tarafınıza yükleneceğini ihtaren bildiririm.
                    </div>
                </div>

                <div style="display:flex; gap:10px; margin-top:14px;">
                    <button type="button" class="btn-action" style="background:#1e293b; color:#cbd5e1; border:1px solid #334155;" onclick="window.print()">
                        <i class="fa-solid fa-print"></i> Raporu Yazdır
                    </button>
                    <a href="https://wa.me/905428413535?text=Merhaba,%20hisseli%20tasinmazimda%20ecrimisil%20ve%20hisse%20paylasimi%20icin%20harita%20muhendislik%20danismanligi%20almak%20istiyorum." target="_blank" class="btn-action" style="background:#22c55e; color:#fff;">
                        <i class="fa-brands fa-whatsapp"></i> Hukuki / Mühendislik Danışma
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
            <a href="/kentsel-donusum-yarisi-bizden" style="display:flex; align-items:center; gap:10px; padding:10px 12px; background:#131d31; border:1px solid #1e293b; border-radius:10px; text-decoration:none; color:#f8fafc;">
                <div style="width:36px; height:36px; border-radius:8px; background:rgba(245,158,11,0.15); color:#f59e0b; display:flex; align-items:center; justify-content:center; font-size:16px;"><i class="fa-solid fa-building-shield"></i></div>
                <div><div style="font-size:12.5px; font-weight:700;">Yarısı Bizden &amp; Şerefiye</div><div style="font-size:11px; color:#94a3b8;">Kentsel dönüşüm hibe/kredi</div></div>
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
            <a href="/rizai-taksim-sozlesmesi" style="display:flex; align-items:center; gap:10px; padding:10px 12px; background:#131d31; border:1px solid #1e293b; border-radius:10px; text-decoration:none; color:#f8fafc;">
                <div style="width:36px; height:36px; border-radius:8px; background:rgba(192,132,252,0.15); color:#c084fc; display:flex; align-items:center; justify-content:center; font-size:16px;"><i class="fa-solid fa-file-contract"></i></div>
                <div><div style="font-size:12.5px; font-weight:700;">Rıza-i Taksim Protokolü</div><div style="font-size:11px; color:#94a3b8;">Hisseli tapu paylaşımı</div></div>
            </a>
        </div>
    </section>

    <script>
        function calcEcrimisil() {
            const propType = document.getElementById('inputType').value;
            let rentInput = Math.max(100, parseFloat(document.getElementById('inputCurrentRent').value) || 20000);
            const share = parseFloat(document.getElementById('inputShare').value) || 0.25;
            const years = parseInt(document.getElementById('inputYears').value) || 5;
            const withInterest = (document.getElementById('inputInterest').value === 'evet');

            // Update hint
            if (propType === 'tarla') {
                document.getElementById('hintRent').innerText = "Tarlanın yıllık toplam hasılat veya icar kirası tutarını giriniz.";
            } else {
                document.getElementById('hintRent').innerText = "Taşınmazın aylık güncel emsal kira değerini giriniz.";
            }

            // Annual base calculation
            const annualCurrentTotal = (propType === 'tarla') ? rentInput : (rentInput * 12);

            // Historical deflation index ratios (2026 -> 2025 -> 2024 -> 2023 -> 2022)
            const deflationFactors = [1.0, 0.65, 0.42, 0.25, 0.15];
            const interestRates = [0.09, 0.18, 0.27, 0.36, 0.45]; // accumulated statutory interest

            let tableHtml = '';
            let grandTotal = 0;

            const currentYear = 2026;
            for (let i = 0; i < years; i++) {
                const yr = currentYear - i;
                const factor = deflationFactors[i] || 0.12;
                const yearTotalRent = annualCurrentTotal * factor;
                const shareRent = yearTotalRent * share;
                const interestAmt = withInterest ? (shareRent * interestRates[i]) : 0;
                const periodTotal = shareRent + interestAmt;
                grandTotal += periodTotal;

                tableHtml += `<tr>
                    <td><strong>${yr} Yılı</strong></td>
                    <td>${Math.round(yearTotalRent).toLocaleString('tr-TR')} TL</td>
                    <td style="color:#38bdf8;">${Math.round(shareRent).toLocaleString('tr-TR')} TL</td>
                    <td style="text-align:right; color:#c084fc; font-weight:700;">${Math.round(periodTotal).toLocaleString('tr-TR')} TL</td>
                </tr>`;
            }

            document.getElementById('dispTableBody').innerHTML = tableHtml;
            document.getElementById('dispTotalEcrimisil').innerText = Math.round(grandTotal).toLocaleString('tr-TR') + ' TL';
            document.getElementById('dispInterestNote').innerText = withInterest ? "5 Yıllık Yasal Faiz Hesaba Dahil Edilmiştir" : "Yasal Faizsiz Salt Ana Para Alacağı";
        }

        function copyIhtarname() {
            const txt = document.getElementById('ihtarnameContent').innerText;
            navigator.clipboard.writeText(txt).then(() => {
                alert('İhtarname metni panoya kopyalandı! Word veya resmi evrakta kullanabilirsiniz.');
            });
        }

        window.addEventListener('DOMContentLoaded', calcEcrimisil);
    </script>
</body>
</html>
