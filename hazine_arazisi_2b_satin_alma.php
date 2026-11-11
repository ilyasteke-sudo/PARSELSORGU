<?php
/**
 * ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ - PARSEL PRO
 * Milli Emlak & 2/B Hazine Arazisi Satın Alma & Rayiç Bedel Hesaplayıcı (6292 s.K.)
 * Pure PHP 8.3 / Responsive / Schema.org WebApplication & FAQPage
 */
require_once __DIR__ . '/navbar.php';

$page_title = "2B Arazi Sorgulama & Hazine Satın Alma | ParselSorgu";
$page_desc = "6292 sayılı Kanun kapsamında 2B arazi sorgulama, rayiç bedeli, peşin %20 indirim, 5 yıl 10 taksit planı ve hak sahipliği hesaplayıcı.";
$canonical_url = "https://www.parselsorgu.net/hazine-arazisi-2b-satin-alma";
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($page_title) ?></title>
    <meta name="description" content="<?= htmlspecialchars($page_desc) ?>">
    <link rel="canonical" href="<?= $canonical_url ?>">
    <meta property="og:image" content="https://www.parselsorgu.net/assets/images/og-parsel.jpg">
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?= htmlspecialchars($page_title) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($page_desc) ?>">
    <meta property="og:url" content="<?= $canonical_url ?>">
    <meta name="twitter:card" content="summary_large_image">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-dark: #0a0f1d;
            --card-bg: #111827;
            --card-border: #1f2937;
            --accent: #10b981;
            --accent-glow: rgba(16, 185, 129, 0.2);
            --amber: #f59e0b;
            --cyan: #38bdf8;
            --purple: #8b5cf6;
            --text-main: #f3f4f6;
            --text-muted: #9ca3af;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            background-color: var(--bg-dark);
            color: var(--text-main);
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            padding-bottom: 60px;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 24px 16px;
        }
        .hero {
            text-align: center;
            padding: 40px 16px 30px;
            background: radial-gradient(circle at center, rgba(16, 185, 129, 0.08) 0%, transparent 70%);
        }
        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(16, 185, 129, 0.15);
            color: var(--accent);
            padding: 6px 14px;
            border-radius: 9999px;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 16px;
            border: 1px solid rgba(16, 185, 129, 0.3);
        }
        .hero h1 {
            font-size: 32px;
            font-weight: 800;
            letter-spacing: -0.02em;
            margin-bottom: 12px;
            color: #fff;
        }
        .hero h1 span { color: var(--accent); }
        .hero p {
            font-size: 16px;
            color: var(--text-muted);
            max-width: 780px;
            margin: 0 auto;
        }

        .calc-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 28px;
            margin-top: 32px;
        }
        @media (max-width: 900px) {
            .calc-grid { grid-template-columns: 1fr; }
        }

        .panel {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 16px;
            padding: 28px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.5);
        }
        .panel-title {
            font-size: 20px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            border-bottom: 1px solid var(--card-border);
            padding-bottom: 14px;
        }
        .panel-title i { color: var(--accent); }

        .form-group { margin-bottom: 18px; }
        .form-group label {
            display: block;
            font-size: 13.5px;
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--text-main);
        }
        .form-group select, .form-group input {
            width: 100%;
            padding: 12px 14px;
            background: #1f2937;
            border: 1px solid #374151;
            border-radius: 10px;
            color: #fff;
            font-size: 14px;
            outline: none;
            transition: border-color 0.2s;
        }
        .form-group select:focus, .form-group input:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 2px var(--accent-glow);
        }

        .btn-calc {
            width: 100%;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: #fff;
            font-size: 16px;
            font-weight: 700;
            padding: 14px 24px;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.2s;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
            margin-top: 10px;
        }
        .btn-calc:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.6);
        }

        .plan-box {
            background: #1a2234;
            border: 1px solid #283548;
            border-radius: 14px;
            padding: 22px;
            margin-bottom: 24px;
            text-align: center;
        }
        .plan-price {
            font-size: 38px;
            font-weight: 900;
            color: var(--accent);
            margin: 6px 0;
        }

        .cost-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            font-size: 13.5px;
        }
        .cost-row:last-child { border-bottom: none; }
        .cost-total {
            font-weight: 700;
            font-size: 16px;
            border-top: 2px solid var(--accent);
            padding-top: 12px;
            margin-top: 8px;
            color: #fff;
        }

        .faq-section {
            margin-top: 48px;
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 16px;
            padding: 28px;
        }
        .faq-title {
            font-size: 22px;
            font-weight: 800;
            color: #fff;
            margin-bottom: 20px;
        }
        .faq-item {
            margin-bottom: 16px;
            border-bottom: 1px solid var(--card-border);
            padding-bottom: 14px;
        }
        .faq-item:last-child { border-bottom: none; }
        .faq-question {
            font-size: 15px;
            font-weight: 700;
            color: #e5e7eb;
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .faq-answer {
            font-size: 13.5px;
            color: var(--text-muted);
            line-height: 1.6;
        }
    </style>

    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@graph": [
        {
          "@type": "WebApplication",
          "name": "Milli Emlak & 2/B Hazine Arazisi Satın Alma Hesaplayıcı",
          "url": "https://www.parselsorgu.net/hazine-arazisi-2b-satin-alma",
          "description": "6292 sayılı Kanun uyarınca 2B arazisi rayiç bedeli, peşin %20 indirim ve faizsiz taksit planı hesaplayıcı.",
          "applicationCategory": "BusinessApplication",
          "operatingSystem": "All",
          "provider": {
            "@type": "Organization",
            "name": "Ant Harita Mühendislik",
            "url": "https://www.antharita.com"
          }
        },
        {
          "@type": "FAQPage",
          "mainEntity": [
            {
              "@type": "Question",
              "name": "2/B arazisi satın alırken ne kadar indirim uygulanır?",
              "acceptedAnswer": {
                "@type": "Answer",
                "text": "6292 sayılı Kanun uyarınca hak sahiplerine satış bedeli, taşınmazın rayiç bedelinin %50'si olarak belirlenir. Bu tutar peşin ödenirse satış bedeli üzerinden ayrıca %20 ilave indirim yapılır; böylece rayiç bedelin %40'ına tapu sahibi olunabilir."
              }
            },
            {
              "@type": "Question",
              "name": "Taksitli ödemede faiz işletilir mi?",
              "acceptedAnswer": {
                "@type": "Answer",
                "text": "Belediye ve mücavir alan sınırları içinde en fazla 3 yıl 6 eşit taksitte; belediye sınırları dışında (köylerde) ise en fazla 5 yıl 10 eşit taksitte faizsiz olarak ödenebilir."
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

    <?= render_saas_navbar('eklentiler') ?>

    <main class="container">
        <section class="hero">
            <div class="hero-badge">
                <i class="fa-solid fa-landmark"></i> 6292 Sayılı Kanun & Milli Emlak Tebliğleri
            </div>
            <h1>2/B & Hazine Arazisi <span>Satın Alma Hesaplayıcı</span></h1>
            <p>
                Milli Emlak'tan 2/B orman vasfını yitirmiş arazi veya Hazine tarım arazisi satın alırken yasal %50 rayiç indirimi, peşin %20 avantajı ve faizsiz taksit planını hesaplayın.
            </p>
        </section>

        <div class="calc-grid">
            <!-- INPUT PANEL -->
            <div class="panel">
                <h2 class="panel-title"><i class="fa-solid fa-calculator"></i> Arazi & Ödeme Tercihi</h2>

                <div class="form-group">
                    <label>Taşınmaz Türü</label>
                    <select id="tasinmazTuru">
                        <option value="2b">2/B Arazisi (Orman Sınırı Dışına Çıkarılan Alan)</option>
                        <option value="tarim_arazisi">Hazineye Ait Tarım Arazisi (Ecrimisil Ödenen)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Konum / Yerleşim Yeri</label>
                    <select id="konumTuru">
                        <option value="koy">Köy / Belediye Sınırı Dışı (5 Yıl 10 Taksit İmkanı)</option>
                        <option value="sehir">Belediye & Mücavir Alan İçi (3 Yıl 6 Taksit İmkanı)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Milli Emlak Tespit Edilen Rayiç Bedeli (TL)</label>
                    <input type="number" id="rayicBedel" min="50000" step="25000" value="1200000">
                </div>

                <div class="form-group">
                    <label>Ödeme Şekli Tercihi</label>
                    <select id="odemeSekli">
                        <option value="pesin">Peşin Ödeme (Ekstra %20 İndirimli)</option>
                        <option value="taksit">Taksitli Ödeme (%50 Peşinat + Faizsiz Taksit)</option>
                    </select>
                </div>

                <button class="btn-calc" onclick="calculateTreasury()">
                    <i class="fa-solid fa-file-signature"></i> Satın Alma Planını Hesapla
                </button>
            </div>

            <!-- RESULT PANEL -->
            <div class="panel">
                <h2 class="panel-title"><i class="fa-solid fa-money-check-dollar"></i> Ödeme & İndirim Raporu</h2>

                <div class="plan-box">
                    <div style="font-size:12px; color:var(--text-muted); font-weight:700;">DEVLETE ÖDENECEK NİHAİ BEDEL</div>
                    <div class="plan-price" id="nihaiBedel">480.000 TL</div>
                    <div style="font-size:12px; color:var(--accent);" id="indirimNotu">Rayiç bedel üzerinden toplam %60 tasarruf</div>
                </div>

                <div class="cost-row">
                    <span style="color:var(--text-muted);">Milli Emlak Rayiç Bedeli:</span>
                    <strong id="ozetRayic">1.200.000 TL</strong>
                </div>
                <div class="cost-row">
                    <span style="color:var(--text-muted);">6292 s.K. Yasal Satış Tabanı (%50):</span>
                    <strong id="yasalTaban">600.000 TL</strong>
                </div>
                <div class="cost-row">
                    <span style="color:var(--text-muted);">Peşin Ödeme İndirimi (%20):</span>
                    <strong id="pesinIndirim" style="color:var(--accent);">-120.000 TL</strong>
                </div>
                <div class="cost-row">
                    <span style="color:var(--text-muted);">Taksit Planı:</span>
                    <strong id="taksitDetay">Tek Seferde Peşin</strong>
                </div>
                <div class="cost-row cost-total">
                    <span>Toplam Tasarruf Miktarınız:</span>
                    <strong id="toplamTasarruf" style="color:var(--accent);">720.000 TL</strong>
                </div>

                <div style="background:rgba(16,185,129,0.1); border-left:4px solid var(--accent); padding:12px; border-radius:8px; margin-top:16px; font-size:12.5px; color:#6ee7b7;">
                    <i class="fa-solid fa-stamp"></i> <strong>Hak Sahipliği Güvencesi:</strong> Güncelleme listelerinde veya kadastro tutanaklarında kullanıcı olarak adınız yer alıyorsa, doğrudan adınıza satış hakkınız kanunen güvence altındadır; ihaleye çıkarılamaz.
                </div>
            </div>
        </div>

        <!-- FAQ SECTION -->
        <section class="faq-section">
            <h2 class="faq-title"><i class="fa-solid fa-circle-question" style="color:var(--accent);"></i> 2/B & Hazine Satın Alma Rehberi</h2>
            <div class="faq-item">
                <div class="faq-question"><i class="fa-solid fa-check text-success"></i> 2/B arazisi tapusu hemen teslim edilir mi?</div>
                <div class="faq-answer">Peşin ödemelerde bedel yatırıldıktan sonra birkaç gün içinde tapu devri yapılır. Taksitli satışlarda ise taşınmaz üzerine Hazine lehine kanuni ipotek konularak tapu yine alıcı adına tescil edilir; taksitler bittiğinde ipotek kaldırılır.</div>
            </div>
        </section>
    </main>

    <script>
        function calculateTreasury() {
            const rayic = parseFloat(document.getElementById('rayicBedel').value) || 0;
            const konum = document.getElementById('konumTuru').value;
            const odeme = document.getElementById('odemeSekli').value;

            const yasalTaban = rayic * 0.50; // Kanun gereği %50

            let nihai = yasalTaban;
            let pesinInd = 0;
            let taksitText = 'Tek Seferde Peşin';

            if (odeme === 'pesin') {
                pesinInd = yasalTaban * 0.20;
                nihai = yasalTaban - pesinInd;
                document.getElementById('indirimNotu').innerText = 'Rayiç bedel üzerinden peşin avantajıyla toplam %60 tasarruf!';
            } else {
                // Taksitli
                const pesinat = yasalTaban * 0.50;
                const kalan = yasalTaban - pesinat;

                if (konum === 'koy') {
                    const taksitBasi = kalan / 10;
                    taksitText = `${Number(Math.round(pesinat)).toLocaleString('tr-TR')} TL Peşin + 5 Yılda 10 Taksit (${Number(Math.round(taksitBasi)).toLocaleString('tr-TR')} TL/Dönem)`;
                } else {
                    const taksitBasi = kalan / 6;
                    taksitText = `${Number(Math.round(pesinat)).toLocaleString('tr-TR')} TL Peşin + 3 Yılda 6 Taksit (${Number(Math.round(taksitBasi)).toLocaleString('tr-TR')} TL/Dönem)`;
                }
                document.getElementById('indirimNotu').innerText = 'Kanuni faizsiz taksitlendirme imkanı';
            }

            const tasarruf = rayic - nihai;

            document.getElementById('nihaiBedel').innerText = Number(Math.round(nihai)).toLocaleString('tr-TR') + ' TL';
            document.getElementById('ozetRayic').innerText = Number(Math.round(rayic)).toLocaleString('tr-TR') + ' TL';
            document.getElementById('yasalTaban').innerText = Number(Math.round(yasalTaban)).toLocaleString('tr-TR') + ' TL';
            document.getElementById('pesinIndirim').innerText = pesinInd > 0 ? '-' + Number(Math.round(pesinInd)).toLocaleString('tr-TR') + ' TL' : '0 TL (Taksitli)';
            document.getElementById('taksitDetay').innerText = taksitText;
            document.getElementById('toplamTasarruf').innerText = Number(Math.round(tasarruf)).toLocaleString('tr-TR') + ' TL';
        }

        calculateTreasury();
    </script>
</body>
</html>
