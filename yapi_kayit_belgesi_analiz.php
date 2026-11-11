<?php
/**
 * ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ - PARSEL PRO
 * SaaS 4: Yapı Kayıt Belgesi (İmar Barışı) Hukuki Risk & Güçlendirme Sihirbazı
 * Pure PHP 8.3 / 3194 Geçici 16. Madde ve Yargıtay Uyumlu Analiz Motoru
 */

declare(strict_types=1);

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/navbar.php';

$page_title = "Yapı Kayıt Belgesi Risk & İmar Barışı Testi | ParselSorgu";
$meta_desc = "3194 Geçici 16. Madde kapsamında Yapı Kayıt Belgesi iptal riski, uydu denetimi, Hazine devri ve güçlendirme ruhsatı testi.";
$canonical_url = "https://www.parselsorgu.net/yapi-kayit-belgesi-sorgulama";
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
            --purple: #a855f7;
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
            background: radial-gradient(circle at 50% 20%, rgba(244, 63, 94, 0.12) 0%, transparent 70%);
            border-bottom: 1px solid var(--border-color);
            margin-bottom: 30px;
        }
        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(244, 63, 94, 0.12);
            border: 1px solid rgba(244, 63, 94, 0.35);
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 700;
            color: var(--rose);
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

        .risk-layout {
            display: grid;
            grid-template-columns: 400px 1fr;
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
        .form-control:focus { border-color: var(--rose); }

        .btn-run-test {
            width: 100%;
            background: linear-gradient(135deg, #f43f5e 0%, #e11d48 100%);
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

        /* SCORE GAUGE */
        .score-box {
            background: linear-gradient(180deg, #131d31 0%, #0d1527 100%);
            border-radius: 12px;
            padding: 24px;
            text-align: center;
            margin-bottom: 20px;
            border: 1px solid var(--border-color);
        }
        .score-number {
            font-size: 42px;
            font-weight: 900;
            line-height: 1;
            margin: 10px 0;
        }
        .score-status {
            font-size: 14px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .checklist-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 12px;
            background: var(--card-surface);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            margin-bottom: 10px;
            font-size: 12.5px;
            line-height: 1.4;
        }
        .checklist-item i { font-size: 16px; margin-top: 2px; }

        @media (max-width: 900px) {
            .risk-layout { grid-template-columns: 1fr; }
            .hero-banner h1 { font-size: 24px; }
        }
    </style>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@graph": [
    {
      "@type": "WebApplication",
      "@id": "https://www.parselsorgu.net/yapi-kayit-belgesi-sorgulama#app",
      "name": "Yapı Kayıt Belgesi Risk ve Güçlendirme Analiz Sihirbazı",
      "url": "https://www.parselsorgu.net/yapi-kayit-belgesi-sorgulama",
      "description": "3194 Sayılı İmar Kanunu Geçici 16. Madde uyarınca Yapı Kayıt Belgesi geçerlilik testi, iptal riskleri, kat mülkiyeti ve güçlendirme danışmanlığı.",
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
      "@id": "https://www.parselsorgu.net/yapi-kayit-belgesi-sorgulama#breadcrumb",
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
          "name": "Yapı Kayıt Belgesi Risk ve Güçlendirme Analiz Sihirbazı",
          "item": "https://www.parselsorgu.net/yapi-kayit-belgesi-sorgulama"
        }
      ]
    },
    {
      "@type": "FAQPage",
      "@id": "https://www.parselsorgu.net/yapi-kayit-belgesi-sorgulama#faq",
      "mainEntity": [
        {
          "@type": "Question",
          "name": "Yapı Kayıt Belgesi olan bir bina kentsel dönüşüme girebilir mi?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Evet, Yapı Kayıt Belgesi binanın yıkılana kadar kullanım hakkını sağlar. Kentsel dönüşümde güncel imar planı hükümleri uygulanır."
          }
        },
        {
          "@type": "Question",
          "name": "Yapı Kayıt Belgesi iptal edilebilir mi?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "31 Aralık 2017 tarihinden sonra yapıldığı tespit edilen, Hazine veya orman arazilerinde kalan yapıların belgeleri iptal edilmektedir."
          }
        },
        {
          "@type": "Question",
          "name": "Yapı Kayıt Belgesi ile kat mülkiyeti kurulabilir mi?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Tüm maliklerin muvafakati, mimari proje ve zemin tespit tutanağı ile tapu müdürlüğüne başvurularak kat mülkiyeti tesis edilebilir."
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
                <i class="fa-solid fa-triangle-exclamation"></i> 3194 s.K. Geçici 16. Madde &bull; Yargıtay Hukuk Denetimi
            </div>
            <h1>Yapı Kayıt Belgesi <span>Hukuki Risk &amp; Güçlendirme Sihirbazı</span></h1>
            <p>
                2018 İmar Barışı ile alınan Yapı Kayıt Belgenizin iptal edilme riskini, uydu görüntüsü denetimini, Hazine arazisi satın alma hakkını ve güçlendirme ruhsatı şartlarını test edin.
            </p>
        </section>

        <div class="risk-layout">
            <!-- SOL FORM -->
            <div class="panel-card">
                <div class="panel-title">
                    <i class="fa-solid fa-list-check" style="color:var(--rose);"></i>
                    <span>Yapı &amp; Belge Parametreleri</span>
                </div>

                <div class="form-group">
                    <label class="form-label">Yapının Gerçek İnşa Tarihi</label>
                    <select id="build_date" class="form-control" onchange="evaluateRisk()">
                        <option value="before_2017" selected>31.12.2017 Tarihinden Önce Tamamlandı</option>
                        <option value="after_2017">31.12.2017 Tarihinden Sonra Yapıldı / Eklendi</option>
                        <option value="partially">Bir Kısmı 2017 Öncesi, Bir Kısmı Sonrası</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Arazi Mülkiyet Durumu</label>
                    <select id="land_ownership" class="form-control" onchange="evaluateRisk()">
                        <option value="private" selected>Şahsıma / Hisseli Özel Mülkiyete Ait Tapu</option>
                        <option value="hazine">Milli Emlak (Hazine) Taşınmazı</option>
                        <option value="belediye">Belediye Mülkiyeti / Kamuya Terkli Alan</option>
                        <option value="orman">Orman Alanı / 2B Sınırı</option>
                        <option value="sit">Sit Alanı (Doğal veya Arkeolojik)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Belgeden Sonra Yapılan İlave Kat / Teras Kapama</label>
                    <select id="modifications" class="form-control" onchange="evaluateRisk()">
                        <option value="none" selected>Hiçbir İlave Yapılmadı (Belgedeki Gibi Duruyor)</option>
                        <option value="roof">Çatı Katı / Teras / Balkon Kapatıldı</option>
                        <option value="floor">Tam Kat veya Yanına Ek Bina Çıkıldı</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Hakkında Yıkım veya TCK 184 Davası Var mı?</label>
                    <select id="legal_case" class="form-control" onchange="evaluateRisk()">
                        <option value="no" selected>Hayır, Açılmış Bir Dava veya Encümen Kararı Yok</option>
                        <option value="yes">Evet, Belediye Encümeni Para Cezası / Yıkım Kararı Aldı</option>
                    </select>
                </div>

                <button type="button" class="btn-run-test" onclick="evaluateRisk()">
                    <i class="fa-solid fa-shield-virus"></i> Risk Skorunu Hesapla
                </button>
            </div>

            <!-- SAĞ SONUÇ -->
            <div class="panel-card">
                <div class="score-box" id="scoreBox">
                    <div style="font-size:12px; color:#94a3b8; font-weight:700; text-transform:uppercase;">Belge İptal &amp; Yıkım Riski:</div>
                    <div class="score-number" id="dispScore">15 / 100</div>
                    <div class="score-status" id="dispStatus" style="color:var(--green);">GÜVENLİ / DÜŞÜK RİSK</div>
                </div>

                <div class="panel-title">
                    <i class="fa-solid fa-gavel" style="color:var(--accent);"></i>
                    <span>Hukuki Değerlendirme &amp; Yol Haritası</span>
                </div>

                <div id="dispChecklist">
                    <!-- Populated via JS -->
                </div>
            </div>
        </div>
    </main>

    <script>
        function evaluateRisk() {
            const date = document.getElementById('build_date').value;
            const ownership = document.getElementById('land_ownership').value;
            const mod = document.getElementById('modifications').value;
            const legal = document.getElementById('legal_case').value;

            let score = 10;
            let checks = [];

            if (date === 'after_2017') {
                score += 55;
                checks.push({ icon: 'fa-triangle-exclamation', color: '#f43f5e', text: '<strong>KRİTİK RİSK (31.12.2017 Sonrası Yapım):</strong> Bakanlık Harita Genel Müdürlüğü uydu fotoğraflarıyla 2017 sonrası inşaatı tespit ederse belge iptal edilir ve TCK 184 imar kirliliği cezası uygulanır.' });
            } else {
                checks.push({ icon: 'fa-circle-check', color: '#10b981', text: '<strong>İnşa Tarihi Miladı Sağlandı:</strong> Yapı 2017 öncesi yapıldığı için resmi uydu kayıtlarıyla uyumludur.' });
            }

            if (ownership === 'hazine') {
                score += 15;
                checks.push({ icon: 'fa-circle-info', color: '#38bdf8', text: '<strong>Hazine Arazisi Satın Alma:</strong> 3194 s.K. uyarınca Milli Emlak müdürlüğüne başvurarak arsayı doğrudan rayiç bedelle satın alma hakkınız devam etmektedir.' });
            } else if (ownership === 'orman' || ownership === 'sit') {
                score += 45;
                checks.push({ icon: 'fa-triangle-exclamation', color: '#f43f5e', text: '<strong>Orman / Sit Alanı Kısıtı:</strong> Orman ve 1. Derece Arkeolojik Sit alanlarındaki Yapı Kayıt Belgeleri mevzuat gereği geçersizdir ve iptal edilir.' });
            }

            if (mod === 'floor') {
                score += 30;
                checks.push({ icon: 'fa-triangle-exclamation', color: '#f59e0b', text: '<strong>Belge Sonrası Kaçak İlave:</strong> Belge alındıktan sonra yapılan eklemeler belge kapsamına girmez; belediye ek kısım için yıkım kararı alabilir.' });
            }

            if (legal === 'yes') {
                score += 25;
                checks.push({ icon: 'fa-gavel', color: '#f43f5e', text: '<strong>Hukuki Süreç Aktif:</strong> İdare Mahkemesinde yürütmeyi durdurma davası açılması ve HKMO tescilli bilirkişi raporu alınması tavsiye edilir.' });
            }

            score = Math.min(100, Math.max(0, score));
            document.getElementById('dispScore').innerText = `${score} / 100`;

            const box = document.getElementById('scoreBox');
            const statusEl = document.getElementById('dispStatus');

            if (score <= 30) {
                statusEl.innerText = 'GÜVENLİ / DÜŞÜK RİSK';
                statusEl.style.color = '#10b981';
                document.getElementById('dispScore').style.color = '#10b981';
                box.style.borderColor = '#10b981';
            } else if (score <= 60) {
                statusEl.innerText = 'ORTA RİSK / TEDBİR GEREKLİ';
                statusEl.style.color = '#f59e0b';
                document.getElementById('dispScore').style.color = '#f59e0b';
                box.style.borderColor = '#f59e0b';
            } else {
                statusEl.innerText = 'YÜKSEK HUKUKİ İPTAL RİSKİ';
                statusEl.style.color = '#f43f5e';
                document.getElementById('dispScore').style.color = '#f43f5e';
                box.style.borderColor = '#f43f5e';
            }

            document.getElementById('dispChecklist').innerHTML = checks.map(c => `
                <div class="checklist-item">
                    <i class="fa-solid ${c.icon}" style="color:${c.color};"></i>
                    <div>${c.text}</div>
                </div>
            `).join('');
        }

        window.addEventListener('DOMContentLoaded', evaluateRisk);
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
