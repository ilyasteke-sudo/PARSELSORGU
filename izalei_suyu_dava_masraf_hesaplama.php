<?php
/**
 * ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ - PARSEL PRO
 * İzale-i Şüyu (Ortaklığın Giderilmesi) İhale & Dava Masraf Simülatörü
 * Pure PHP 8.3 / Responsive / Schema.org WebApplication & FAQPage
 */
require_once __DIR__ . '/navbar.php';

$page_title = "İzale-i Şüyu Dava Masraf ve İhale Hesaplama | ParselSorgu";
$page_desc = "Hisseli tarla ve arsa ortaklığın giderilmesi davası maliyeti, UYAP e-Satış %50 ihale tabanı ve tellaliye harcı hesaplayıcı.";
$canonical_url = "https://www.parselsorgu.net/izalei-suyu-dava-masraf-hesaplama";
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($page_title) ?></title>
    <meta name="description" content="<?= htmlspecialchars($page_desc) ?>">
    <link rel="canonical" href="<?= $canonical_url ?>    <meta property="og:image" content="https://www.parselsorgu.net/assets/images/og-parsel.jpg">
">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-dark: #0a0f1d;
            --card-bg: #111827;
            --card-border: #1f2937;
            --accent: #f59e0b;
            --accent-glow: rgba(245, 158, 11, 0.2);
            --danger: #ef4444;
            --emerald: #10b981;
            --cyan: #38bdf8;
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
            background: radial-gradient(circle at center, rgba(245, 158, 11, 0.08) 0%, transparent 70%);
        }
        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(245, 158, 11, 0.15);
            color: var(--accent);
            padding: 6px 14px;
            border-radius: 9999px;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 16px;
            border: 1px solid rgba(245, 158, 11, 0.3);
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
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
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
            box-shadow: 0 4px 15px rgba(245, 158, 11, 0.4);
            margin-top: 10px;
        }
        .btn-calc:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(245, 158, 11, 0.6);
        }

        .auction-box {
            background: #1a2234;
            border: 1px solid #283548;
            border-radius: 14px;
            padding: 22px;
            margin-bottom: 24px;
            text-align: center;
        }
        .auction-price {
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
            font-size: 15px;
            border-top: 1px solid var(--accent);
            padding-top: 12px;
            margin-top: 6px;
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
          "name": "İzale-i Şüyu Dava & İhale Masraf Simülatörü",
          "url": "https://www.parselsorgu.net/izalei-suyu-dava-masraf-hesaplama",
          "description": "Ortaklığın giderilmesi davasında bilirkişi, keşif, tellaliye harcı ve UYAP ihale satış bedeli simülatörü.",
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
              "name": "İzale-i şüyu davasında arsa yüzde kaçtan satışa çıkar?",
              "acceptedAnswer": {
                "@type": "Answer",
                "text": "İcra ve İflas Kanunu'nun 111/a maddesi ve UYAP e-Satış kuralları gereği, taşınmaz bilirkişinin belirlediği muhammen bedelin %50'si üzerinden açık artırmaya çıkar."
              }
            },
            {
              "@type": "Question",
              "name": "Dava masraflarını davayı açan mı öder?",
              "acceptedAnswer": {
                "@type": "Answer",
                "text": "Davayı açan hissedar dava açılış harçlarını ve keşif avansını peşin yatırır. Ancak dava sonuçlandığında ve taşınmaz ihalede satıldığında, yapılan tüm masraflar satış bedelinden öncelikle kesilir ve mirasçılara hisseleri oranında paylaştırılır."
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
                <i class="fa-solid fa-gavel"></i> İİK m.111/a & UYAP e-Satış Algoritması
            </div>
            <h1>İzale-i Şüyu <span>Dava & İhale Simülatörü</span></h1>
            <p>
                Hisseli arsa veya tarlanızı mahkemeye vermeden önce açık artırma başlangıç bedelini (%50), mahkeme masraflarını ve dava açmak yerine anlaşmanın kârını hesaplayın.
            </p>
        </section>

        <div class="calc-grid">
            <!-- INPUT PANEL -->
            <div class="panel">
                <h2 class="panel-title"><i class="fa-solid fa-scale-balanced"></i> Taşınmaz & Dava Bilgileri</h2>

                <div class="form-group">
                    <label>Taşınmazın Piyasa (Muhammen) Değeri (TL)</label>
                    <input type="number" id="muhammenDeger" min="100000" step="50000" value="3000000">
                </div>

                <div class="form-group">
                    <label>Sizin Hisse Payınız (Örn: 1/4 için %25)</label>
                    <input type="number" id="sizinHisseYuzde" min="1" max="100" value="25">
                </div>

                <div class="form-group">
                    <label>Toplam Hissedar Sayısı</label>
                    <input type="number" id="hissedarSayisi" min="2" max="50" value="4">
                </div>

                <div class="form-group">
                    <label>İhale Satış Tahmini Başarısı</label>
                    <select id="ihaleOrani">
                        <option value="0.55">%55 (Düşük Rekabet - Tek Alıcı)</option>
                        <option value="0.70" selected>%70 (Orta Rekabet - Standart İhale)</option>
                        <option value="0.85">%85 (Yüksek Rekabet - Kıymetli Arsa)</option>
                        <option value="1.00">%100 (Tam Muhammen Bedel)</option>
                    </select>
                </div>

                <button class="btn-calc" onclick="calculateAuction()">
                    <i class="fa-solid fa-coins"></i> İhale & Ele Geçecek Net Tutarı Hesapla
                </button>
            </div>

            <!-- RESULT PANEL -->
            <div class="panel">
                <h2 class="panel-title"><i class="fa-solid fa-receipt"></i> İhale Dökümü & Net Nakit</h2>

                <div class="auction-box">
                    <div style="font-size:12px; color:var(--text-muted); font-weight:700;">UYAP e-SATIŞ TABAN FİYATI (%50)</div>
                    <div class="auction-price" id="tabanFiyat">1.500.000 TL</div>
                    <div style="font-size:12px; color:var(--emerald);">İhale bu fiyatın altında başlatılamaz</div>
                </div>

                <div class="cost-row">
                    <span style="color:var(--text-muted);">Tahmini İhale Satış Bedeli:</span>
                    <strong id="tahminiSatis">2.100.000 TL</strong>
                </div>
                <div class="cost-row">
                    <span style="color:var(--text-muted);">Mahkeme, Keşif & Bilirkişi Masrafı:</span>
                    <strong id="mahkemeMasrafi">38.500 TL</strong>
                </div>
                <div class="cost-row">
                    <span style="color:var(--text-muted);">İcra Satış Harcı & Tellaliye (%2 + %0.569):</span>
                    <strong id="tellaliyeHarci">53.949 TL</strong>
                </div>
                <div class="cost-row">
                    <span style="color:var(--text-muted);">Toplam Yasal Kesintiler:</span>
                    <strong id="toplamKesinti" style="color:var(--danger);">92.449 TL</strong>
                </div>
                <div class="cost-row cost-total">
                    <span>Hissedarlara Dağıtılacak Net Para:</span>
                    <strong id="netDagitilacak" style="color:#fff;">2.007.551 TL</strong>
                </div>
                <div class="cost-row cost-total" style="border-top:2px solid var(--accent); color:var(--accent);">
                    <span>Sizin Hissenize Düşen Net Nakit:</span>
                    <strong id="sizinNetPay" style="font-size:18px;">501.887 TL</strong>
                </div>

                <div style="background:rgba(239,68,68,0.1); border-left:4px solid var(--danger); padding:12px; border-radius:8px; margin-top:16px; font-size:12.5px; color:#fca5a5;">
                    <i class="fa-solid fa-hand-holding-dollar"></i> <strong>Mahkemesiz Satış Kazancı:</strong> Taşınmazı mahkemeye vermeyip diğer hissedarlarla anlaşarak piyasa fiyatından satsaydınız hisseniz <strong><span id="anlasmaKazanci">750.000 TL</span></strong> edecekti. Dava nedeniyle tahmini kaybınız: <strong><span id="kayipTutar">248.113 TL</span></strong>!
                </div>
            </div>
        </div>

        <!-- FAQ SECTION -->
        <section class="faq-section">
            <h2 class="faq-title"><i class="fa-solid fa-circle-question" style="color:var(--accent);"></i> İzale-i Şüyu Rehberi</h2>
            <div class="faq-item">
                <div class="faq-question"><i class="fa-solid fa-check text-success"></i> İzale-i şüyu davası ne kadar sürer?</div>
                <div class="faq-answer">Tebligat süreçleri, bilirkişi raporu itirazları ve adli tatil gibi nedenlerle ortalama 1.5 - 2.5 yıl sürmektedir. Bu süre zarfında taşınmaz üzerinde hiçbir hissedar tasarrufta bulunamaz.</div>
            </div>
            <div class="faq-item">
                <div class="faq-question"><i class="fa-solid fa-check text-success"></i> Hissedarlardan biri ihaleye katılıp taşınmazı satın alabilir mi?</div>
                <div class="faq-answer">Evet. Hissedarlar da diğer tüm vatandaşlar gibi UYAP e-Satış portalı üzerinden teminat yatırarak açık artırmaya katılabilir ve en yüksek teklifi vererek taşınmazın tamamının tek sahibi olabilirler.</div>
            </div>
        </section>
    </main>

    <script>
        function calculateAuction() {
            const muhammen = parseFloat(document.getElementById('muhammenDeger').value) || 0;
            const hisseYuzde = parseFloat(document.getElementById('sizinHisseYuzde').value) || 25;
            const ihaleKatsayi = parseFloat(document.getElementById('ihaleOrani').value) || 0.70;

            const taban = muhammen * 0.50;
            const satis = muhammen * ihaleKatsayi;

            // Masraflar
            const mahkeme = 38500;
            const tellaliye = satis * 0.02569;
            const toplamKesinti = mahkeme + tellaliye;

            const netDagitilacak = Math.max(0, satis - toplamKesinti);
            const sizinPay = netDagitilacak * (hisseYuzde / 100);

            const piyasaPay = muhammen * (hisseYuzde / 100);
            const kayip = Math.max(0, piyasaPay - sizinPay);

            document.getElementById('tabanFiyat').innerText = Number(Math.round(taban)).toLocaleString('tr-TR') + ' TL';
            document.getElementById('tahminiSatis').innerText = Number(Math.round(satis)).toLocaleString('tr-TR') + ' TL';
            document.getElementById('mahkemeMasrafi').innerText = Number(Math.round(mahkeme)).toLocaleString('tr-TR') + ' TL';
            document.getElementById('tellaliyeHarci').innerText = Number(Math.round(tellaliye)).toLocaleString('tr-TR') + ' TL';
            document.getElementById('toplamKesinti').innerText = Number(Math.round(toplamKesinti)).toLocaleString('tr-TR') + ' TL';
            document.getElementById('netDagitilacak').innerText = Number(Math.round(netDagitilacak)).toLocaleString('tr-TR') + ' TL';
            document.getElementById('sizinNetPay').innerText = Number(Math.round(sizinPay)).toLocaleString('tr-TR') + ' TL';
            document.getElementById('anlasmaKazanci').innerText = Number(Math.round(piyasaPay)).toLocaleString('tr-TR') + ' TL';
            document.getElementById('kayipTutar').innerText = Number(Math.round(kayip)).toLocaleString('tr-TR') + ' TL';
        }

        calculateAuction();
    </script>
</body>
</html>
