<?php
/**
 * ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ - PARSEL PRO
 * SaaS: Prefabrik, Çelik Ev & Tiny House Maliyet / Ruhsat Analizörü
 * Pure PHP 8.3 / Responsive UI / 2026 İnşaat & Kırsal İmar Mevzuatı
 */

declare(strict_types=1);

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/navbar.php';

$page_title = "Prefabrik, Çelik Ev & Tiny House Maliyeti 2026 | ParselSorgu";
$meta_desc = "Tarlaya prefabrik ev yapılır mı? 2026 anahtar teslim prefabrik, hafif çelik ve betonarme ev maliyet kıyaslaması ve ruhsat rehberi.";
$canonical_url = "https://www.parselsorgu.net/prefabrik-ev-maliyeti-hesaplama";
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
          "@id": "https://www.parselsorgu.net/prefabrik-ev-maliyeti-hesaplama#app",
          "name": "Prefabrik, Çelik Ev ve Tiny House Maliyet ve Ruhsat Analizörü",
          "url": "https://www.parselsorgu.net/prefabrik-ev-maliyeti-hesaplama",
          "description": "Tarlaya ve arsaya prefabrik, hafif çelik ev veya tiny house yapım maliyeti, subasman betonu, altyapı ve imar ruhsat izin şartları hesaplama motoru.",
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
          "@id": "https://www.parselsorgu.net/prefabrik-ev-maliyeti-hesaplama#breadcrumb",
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
              "name": "Prefabrik ve Çelik Ev Maliyet Hesaplama",
              "item": "https://www.parselsorgu.net/prefabrik-ev-maliyeti-hesaplama"
            }
          ]
        },
        {
          "@type": "FAQPage",
          "@id": "https://www.parselsorgu.net/prefabrik-ev-maliyeti-hesaplama#faq",
          "mainEntity": [
            {
              "@type": "Question",
              "name": "Tarlaya prefabrik ev yapmak için ruhsat gerekir mi?",
              "acceptedAnswer": {
                "@type": "Answer",
                "text": "Evet. 3194 sayılı İmar Kanunu'na göre temele oturan (subasman betonu olan) her türlü prefabrik, çelik veya betonarme yapı için ilgili belediyeden veya il özel idaresinden yapı ruhsatı alınması kanunen zorunludur."
              }
            },
            {
              "@type": "Question",
              "name": "İmarsız tarlaya ev yapabilmek için gereken asgari şartlar nelerdir?",
              "acceptedAnswer": {
                "@type": "Answer",
                "text": "Tarlanın kadastral bir yola en az 25 metre cephesi bulunması, parsel büyüklüğünün asgari 5.000 m² olması gerekir. İnşaat alanı parselin en fazla %5'i kadar (azami 250 m²) olabilir."
              }
            },
            {
              "@type": "Question",
              "name": "Tiny House (Tekerlekli Mobil Ev) için imar izni gerekir mi?",
              "acceptedAnswer": {
                "@type": "Answer",
                "text": "Karayolları Trafik Yönetmeliği'ne uygun tip onay belgesi (O2 belgeli), plakalı ve ruhsatlı tekerlekli mobil evler yapı değil 'araç' statüsündedir. Sabit beton zemin yapılmadığı sürece imar ruhsatı aranmaz; ancak doğal sit veya koruma alanlarında çevre düzeni kısıtları uygulanabilir."
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

        .tech-selector { display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px; margin-bottom: 15px; }
        .tech-opt {
            background: var(--card-surface);
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 12px;
            cursor: pointer;
            transition: all 0.2s;
            text-align: center;
        }
        .tech-opt.active {
            border-color: #f59e0b;
            background: rgba(245, 158, 11, 0.12);
        }
        .tech-title { font-size: 13px; font-weight: 800; color: #fff; }
        .tech-sub { font-size: 11px; color: var(--text-muted); margin-top: 2px; }

        .cost-hero {
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.15) 0%, rgba(15, 23, 42, 0.8) 100%);
            border: 1px solid rgba(245, 158, 11, 0.35);
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            margin-bottom: 18px;
        }
        .cost-amount { font-size: 34px; font-weight: 900; color: #f59e0b; margin: 6px 0; }
        .cost-label { font-size: 12px; font-weight: 700; color: #cbd5e1; text-transform: uppercase; }

        .breakdown-table { width: 100%; border-collapse: collapse; font-size: 12.5px; margin-top: 10px; }
        .breakdown-table th { text-align: left; padding: 8px 10px; background: var(--card-surface); color: var(--text-muted); border-bottom: 1px solid var(--border-color); }
        .breakdown-table td { padding: 8px 10px; border-bottom: 1px solid #1e293b; color: #e2e8f0; }

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

        .legal-box {
            padding: 14px;
            border-radius: 10px;
            margin-top: 16px;
            font-size: 12.5px;
            line-height: 1.55;
        }
        .legal-ok { background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.3); color: #86efac; }
        .legal-warn { background: rgba(245, 158, 11, 0.1); border: 1px solid rgba(245, 158, 11, 0.3); color: #fde047; }
        .legal-danger { background: rgba(244, 63, 94, 0.1); border: 1px solid rgba(244, 63, 94, 0.3); color: #fca5a5; }
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
                <i class="fa-solid fa-house-laptop"></i> 2026 İNŞAAT &amp; KIRSAL İMAR MOTORU
            </div>
            <h1 class="hero-title">Prefabrik, Çelik Ev &amp; Tiny House Maliyet Analizörü</h1>
            <p class="hero-desc">
                Tarlanıza veya arsanıza ev yaptırmadan önce metrekareye göre Prefabrik, Hafif Çelik, Betonarme ve Tiny House maliyetlerini kıyaslayın; subasman betonu, foseptik, nakliye ve belediye ruhsat şartlarını tek ekranda inceleyin.
            </p>
        </div>

        <div class="grid-layout">
            <!-- Form Bölümü -->
            <div class="saas-card">
                <h2 style="font-size: 16.5px; font-weight: 800; margin-bottom: 16px; color:#fff; display:flex; align-items:center; gap:8px;">
                    <i class="fa-solid fa-hammer" style="color:#f59e0b;"></i> Ev ve Arazi Özellikleri
                </h2>

                <div class="form-group">
                    <label class="form-label">Yapı Teknolojisi Seçimi</label>
                    <div class="tech-selector">
                        <div class="tech-opt active" id="opt_prefabrik" onclick="setTech('prefabrik')">
                            <div class="tech-title"><i class="fa-solid fa-house"></i> Prefabrik Ev</div>
                            <div class="tech-sub">Ekonomik &amp; Hızlı Kurulum</div>
                        </div>
                        <div class="tech-opt" id="opt_celik" onclick="setTech('celik')">
                            <div class="tech-title"><i class="fa-solid fa-shield-halved"></i> Hafif Çelik Ev</div>
                            <div class="tech-sub">Depreme En Dayanıklı</div>
                        </div>
                        <div class="tech-opt" id="opt_tinyhouse" onclick="setTech('tinyhouse')">
                            <div class="tech-title"><i class="fa-solid fa-caravan"></i> Tiny House (Mobil)</div>
                            <div class="tech-sub">Plakalı &amp; Ruhsat Muaf</div>
                        </div>
                        <div class="tech-opt" id="opt_betonarme" onclick="setTech('betonarme')">
                            <div class="tech-title"><i class="fa-solid fa-trowel-bricks"></i> Betonarme Karkas</div>
                            <div class="tech-sub">Geleneksel Ağır Yapı</div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Planlanan Ev Büyüklüğü (Net / Brüt m²)</label>
                    <select id="inputM2" class="form-select" onchange="calcCost()">
                        <option value="40">40 m² (1+1 Kompakt Kır Evi)</option>
                        <option value="60">60 m² (2+1 Standart Bağ Evi)</option>
                        <option value="85" selected>85 m² (2+1 Geniş Müstakil Ev)</option>
                        <option value="110">110 m² (3+1 Aile Evi)</option>
                        <option value="140">140 m² (3+1 Dubleks Villa)</option>
                        <option value="180">180 m² (4+1 Lüks Dubleks Villa)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Arazinin İmar ve Tapu Durumu</label>
                    <select id="inputZoning" class="form-select" onchange="calcCost()">
                        <option value="tarla_kadastral_yol">Tarla (5000 m² Üstü + Kadastral Yola Cepheli)</option>
                        <option value="tarla_yolsuz">Tarla (Yolu Olmayan / Çıkmaz / 5000 m² Altı)</option>
                        <option value="koy_yerlesik">Köy İçi / Köy Yerleşik Alanı Sınırında</option>
                        <option value="imarli_arsa">İmarlı Arsa (Konut / Villa Lejantlı)</option>
                        <option value="sit_alani">Sit Alanı / Orman Bitişiği / Kıyı Kenar Bandı</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Altyapı Durumu (Elektrik &amp; Su Hattı)</label>
                    <select id="inputInfra" class="form-select" onchange="calcCost()">
                        <option value="mevcut">Şebeke Elektrik ve Şebeke Suyu Yakında Var</option>
                        <option value="yok_gunes">Şebeke Yok (Güneş Enerjisi + Su Deposu Kurulacak)</option>
                    </select>
                </div>

                <button type="button" class="btn-action" onclick="calcCost()">
                    <i class="fa-solid fa-calculator"></i> Maliyet ve Ruhsat Analizini Güncelle
                </button>
            </div>

            <!-- Sonuç ve Döküm Bölümü -->
            <div class="saas-card">
                <div class="cost-hero">
                    <div class="cost-label">TAHMİNİ ANAHTAR TESLİM TOPLAM MALİYET</div>
                    <div class="cost-amount" id="dispTotalCost">0 TL</div>
                    <div style="font-size:12px; color:#cbd5e1;" id="dispCostNote">Subasman, Montaj, Altyapı ve KDV Dahil</div>
                </div>

                <h3 style="font-size:14.5px; font-weight:800; color:#fff; margin-bottom:8px;">
                    <i class="fa-solid fa-list-check" style="color:#38bdf8;"></i> Kalem Kalem Gider Dökümü
                </h3>

                <table class="breakdown-table">
                    <thead>
                        <tr>
                            <th>İnşaat / İmalat Kalemi</th>
                            <th style="text-align:right;">Tutar (TL)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td id="dispKitName">Prefabrik Üst Yapı Kiti (İmalat &amp; Montaj)</td>
                            <td style="text-align:right;" id="dispKitCost">0 TL</td>
                        </tr>
                        <tr>
                            <td>Subasman Betonu, Demir &amp; Temel Dolgusu</td>
                            <td style="text-align:right;" id="dispSubasman">0 TL</td>
                        </tr>
                        <tr>
                            <td>Foseptik Çukuru, Tesisat &amp; Altyapı Bağlantısı</td>
                            <td style="text-align:right;" id="dispPlumbing">0 TL</td>
                        </tr>
                        <tr>
                            <td>Nakliye, Vinç &amp; Şantiye İşçilik Giderleri</td>
                            <td style="text-align:right;" id="dispShipping">0 TL</td>
                        </tr>
                        <tr>
                            <td>Mimari, Statik Ruhsat Projeleri &amp; Zemin Etüdü</td>
                            <td style="text-align:right;" id="dispProject">0 TL</td>
                        </tr>
                        <tr style="background:rgba(245,158,11,0.1); font-weight:800;">
                            <td>GENEL TOPLAM MALİYET (ANAHTAR TESLİM)</td>
                            <td style="text-align:right; color:#f59e0b; font-size:15px;" id="dispGrandTotal">0 TL</td>
                        </tr>
                    </tbody>
                </table>

                <!-- Hukuki ve İmar Durum Uyarısı -->
                <div id="dispLegalBox" class="legal-box legal-ok">
                    <!-- JS injects legal assessment -->
                </div>

                <div style="display:flex; gap:10px; margin-top:16px;">
                    <button type="button" class="btn-action" style="background:#1e293b; color:#cbd5e1; border:1px solid #334155;" onclick="window.print()">
                        <i class="fa-solid fa-print"></i> Raporu Yazdır
                    </button>
                    <a href="https://wa.me/905428413535?text=Merhaba,%20tarlama%20ev%20yaptirmak%20istiyorum.%20Harita%20muhendislik%20ruhsat%20ve%20proje%20danismanligi%20almak%20istiyorum." target="_blank" class="btn-action" style="background:#22c55e; color:#fff;">
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
            <a href="/ecrimisil-hesaplama" style="display:flex; align-items:center; gap:10px; padding:10px 12px; background:#131d31; border:1px solid #1e293b; border-radius:10px; text-decoration:none; color:#f8fafc;">
                <div style="width:36px; height:36px; border-radius:8px; background:rgba(192,132,252,0.15); color:#c084fc; display:flex; align-items:center; justify-content:center; font-size:16px;"><i class="fa-solid fa-scale-balanced"></i></div>
                <div><div style="font-size:12.5px; font-weight:700;">Hisseli Tapu Ecrimisil</div><div style="font-size:11px; color:#94a3b8;">5 yıllık kira tazminatı</div></div>
            </a>
            <a href="/tarla-verimlilik-raporu" style="display:flex; align-items:center; gap:10px; padding:10px 12px; background:#131d31; border:1px solid #1e293b; border-radius:10px; text-decoration:none; color:#f8fafc;">
                <div style="width:36px; height:36px; border-radius:8px; background:rgba(16,185,129,0.15); color:#10b981; display:flex; align-items:center; justify-content:center; font-size:16px;"><i class="fa-solid fa-seedling"></i></div>
                <div><div style="font-size:12.5px; font-weight:700;">Tarla Verimlilik SaaS</div><div style="font-size:11px; color:#94a3b8;">Ürün fizibilitesi &amp; ciro</div></div>
            </a>
            <a href="/emlak-vergisi-hesaplama" style="display:flex; align-items:center; gap:10px; padding:10px 12px; background:#131d31; border:1px solid #1e293b; border-radius:10px; text-decoration:none; color:#f8fafc;">
                <div style="width:36px; height:36px; border-radius:8px; background:rgba(56,189,248,0.15); color:#38bdf8; display:flex; align-items:center; justify-content:center; font-size:16px;"><i class="fa-solid fa-receipt"></i></div>
                <div><div style="font-size:12.5px; font-weight:700;">2026 Emlak Vergisi</div><div style="font-size:11px; color:#94a3b8;">Arsa, konut &amp; arazi harcı</div></div>
            </a>
        </div>
    </section>

    <script>
        let currentTech = 'prefabrik';

        function setTech(tech) {
            currentTech = tech;
            document.querySelectorAll('.tech-opt').forEach(el => el.classList.remove('active'));
            document.getElementById('opt_' + tech).classList.add('active');
            calcCost();
        }

        function calcCost() {
            const m2 = parseFloat(document.getElementById('inputM2').value) || 85;
            const zoning = document.getElementById('inputZoning').value;
            const infra = document.getElementById('inputInfra').value;

            // Unit base cost per m2 (2026 market benchmarks)
            let unitKitCost = 0;
            let kitTitle = "";
            let hasSubasman = true;
            let hasProject = true;

            if (currentTech === 'prefabrik') {
                unitKitCost = 9500;
                kitTitle = "Prefabrik Üst Yapı Kiti (Duvar Panelleri, Çatı, Kapı/Pencere)";
            } else if (currentTech === 'celik') {
                unitKitCost = 14500;
                kitTitle = "Hafif Çelik Karkas, Yalıtım & Dış Cephe Kaplama";
            } else if (currentTech === 'tinyhouse') {
                unitKitCost = 17000;
                kitTitle = "Plakalı & Ruhsatlı O2 Belgeli Tiny House Karavan Kiti";
                hasSubasman = false; // no permanent foundation
                hasProject = false;  // vehicular status
            } else if (currentTech === 'betonarme') {
                unitKitCost = 19500;
                kitTitle = "Betonarme Karkas, Tuğla, Sıva, Şap & Çatı İmalatı";
            }

            const kitTotal = m2 * unitKitCost;
            const subasmanTotal = hasSubasman ? (m2 * 2800) : 0;
            const plumbingTotal = (infra === 'yok_gunes') ? 140000 : 45000;
            const shippingTotal = (currentTech === 'tinyhouse') ? 25000 : 55000;
            const projectTotal = hasProject ? (zoning === 'koy_yerlesik' ? 55000 : 75000) : 0;

            const grandTotal = kitTotal + subasmanTotal + plumbingTotal + shippingTotal + projectTotal;

            document.getElementById('dispKitName').innerText = kitTitle;
            document.getElementById('dispKitCost').innerText = Math.round(kitTotal).toLocaleString('tr-TR') + ' TL';
            document.getElementById('dispSubasman').innerText = Math.round(subasmanTotal).toLocaleString('tr-TR') + ' TL';
            document.getElementById('dispPlumbing').innerText = Math.round(plumbingTotal).toLocaleString('tr-TR') + ' TL';
            document.getElementById('dispShipping').innerText = Math.round(shippingTotal).toLocaleString('tr-TR') + ' TL';
            document.getElementById('dispProject').innerText = Math.round(projectTotal).toLocaleString('tr-TR') + ' TL';
            document.getElementById('dispGrandTotal').innerText = Math.round(grandTotal).toLocaleString('tr-TR') + ' TL';
            document.getElementById('dispTotalCost').innerText = Math.round(grandTotal).toLocaleString('tr-TR') + ' TL';

            // Legal Assessment Text
            const legalEl = document.getElementById('dispLegalBox');
            if (currentTech === 'tinyhouse') {
                legalEl.className = 'legal-box legal-ok';
                legalEl.innerHTML = `<i class="fa-solid fa-circle-check"></i> <strong>Ruhsat Muafiyeti:</strong> O2 Belgeli ve plakalı Tiny House araç statüsünde olduğundan temel betonu atılmadığı sürece yapı ruhsatı gerektirmez. Tarlanıza hemen çekebilirsiniz.`;
            } else if (zoning === 'tarla_kadastral_yol') {
                legalEl.className = 'legal-box legal-ok';
                legalEl.innerHTML = `<i class="fa-solid fa-circle-check"></i> <strong>Yasal Yapılaşma Uygun:</strong> 5403 s.K. ve Plansız Alanlar İmar Yönetmeliği gereğince kadastral yola 25m cephesi olan 5 dönüm üzeri tarlaya %5 taban alanı (azami 250 m²) ev yapılabilir. İl Özel İdaresi / Belediyeden ruhsat alınmalıdır.`;
            } else if (zoning === 'tarla_yolsuz') {
                legalEl.className = 'legal-box legal-danger';
                legalEl.innerHTML = `<i class="fa-solid fa-triangle-exclamation"></i> <strong>Hukuki Risk / Ruhsat Verilmez:</strong> Kadastral yola resmi cephesi olmayan veya 5.000 m² altında kalan tarlalara sabit prefabrik/betonarme yapı ruhsatı verilmez! Kaçak yapı durumunda yıkım ve 3194 m. 42 para cezası riski vardır. Sadece tekerlekli mobil Tiny House kullanmanız önerilir.`;
            } else if (zoning === 'koy_yerlesik') {
                legalEl.className = 'legal-box legal-ok';
                legalEl.innerHTML = `<i class="fa-solid fa-circle-check"></i> <strong>Köy İçi %40 İmarlı:</strong> Parseliniz köy yerleşik alanı sınırları içindeyse 5000 m² şartı aranmaz. Taban alanı %40'a kadar ruhsatlı müstakil kır evi inşa edebilirsiniz.`;
            } else if (zoning === 'sit_alani') {
                legalEl.className = 'legal-box legal-danger';
                legalEl.innerHTML = `<i class="fa-solid fa-ban"></i> <strong>Kesin Yapı Yasağı:</strong> Sit alanları ve kıyı kenar çizgisi içinde her türlü sabit yapılaşma kanunen yasaktır. 2863 sayılı kanun uyarınca adli işlem uygulanır.`;
            } else {
                legalEl.className = 'legal-box legal-ok';
                legalEl.innerHTML = `<i class="fa-solid fa-circle-check"></i> <strong>İmarlı Arsa:</strong> Parselinizin imar çapına göre belediyeden onaylı mimari proje ile doğrudan ruhsat alınabilir.`;
            }
        }

        window.addEventListener('DOMContentLoaded', calcCost);
    </script>
</body>
</html>
