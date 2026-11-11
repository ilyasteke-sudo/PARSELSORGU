<?php
/**
 * ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ - PARSEL PRO
 * Tarımsal Sondaj & DSİ Kuyu Açma Ruhsatı / Su İzni Maliyet Motoru (167 s.K.)
 * Pure PHP 8.3 / Responsive / Schema.org WebApplication & FAQPage
 */
require_once __DIR__ . '/navbar.php';

$page_title = "Tarımsal Sondaj & DSİ Kuyu Ruhsatı Maliyeti | ParselSorgu";
$page_desc = "Tarlaya kuyu açtırma ruhsatı, 167 sayılı Kanun DSİ yeraltı suyu izin belgesi, metre başı delgi, pompa ve sondaj maliyeti hesaplayıcı.";
$canonical_url = "https://www.parselsorgu.net/tarimsal-sondaj-kuyu-ruhsati";
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
            --accent: #0284c7;
            --accent-glow: rgba(2, 132, 199, 0.2);
            --cyan: #38bdf8;
            --emerald: #10b981;
            --amber: #f59e0b;
            --danger: #ef4444;
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
            background: radial-gradient(circle at center, rgba(2, 132, 199, 0.08) 0%, transparent 70%);
        }
        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(2, 132, 199, 0.15);
            color: var(--cyan);
            padding: 6px 14px;
            border-radius: 9999px;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 16px;
            border: 1px solid rgba(2, 132, 199, 0.3);
        }
        .hero h1 {
            font-size: 32px;
            font-weight: 800;
            letter-spacing: -0.02em;
            margin-bottom: 12px;
            color: #fff;
        }
        .hero h1 span { color: var(--cyan); }
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
        .panel-title i { color: var(--cyan); }

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
            border-color: var(--cyan);
            box-shadow: 0 0 0 2px var(--accent-glow);
        }

        .btn-calc {
            width: 100%;
            background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
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
            box-shadow: 0 4px 15px rgba(2, 132, 199, 0.4);
            margin-top: 10px;
        }
        .btn-calc:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(2, 132, 199, 0.6);
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
            border-top: 2px solid var(--cyan);
            padding-top: 12px;
            margin-top: 8px;
            color: var(--cyan);
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
          "name": "Tarımsal Sondaj & DSİ Kuyu Ruhsatı Maliyet Motoru",
          "url": "https://www.parselsorgu.net/tarimsal-sondaj-kuyu-ruhsati",
          "description": "167 Sayılı Yeraltı Suları Kanununa göre sondaj arama ruhsatı, metre başı delgi ve kuyu maliyeti hesaplayıcı.",
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
              "name": "Ruhsatsız kuyu açmanın cezası nedir?",
              "acceptedAnswer": {
                "@type": "Answer",
                "text": "167 sayılı Kanun uyarınca DSİ'den izin almadan açılan kaçak sondaj kuyuları zabıta ve DSİ ekiplerince mühürlenerek kapatılır, kuyu açtıran ve sondajı yapan firmaya 50.000 TL ile 350.000 TL arasında idari para cezası uygulanır."
              }
            },
            {
              "@type": "Question",
              "name": "Kuyu açmak için harita mühendisi gerekir mi?",
              "acceptedAnswer": {
                "@type": "Answer",
                "text": "Evet. DSİ Arama Ruhsatı dosyasında kuyu noktasının ITRF96 / ED50 köşe koordinatlarını gösteren harita mühendisliği onaylı Kuyu Koordinat Krokisi zorunludur."
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
                <i class="fa-solid fa-water"></i> 167 Sayılı Kanun & DSİ Yeraltı Suları Mevzuatı
            </div>
            <h1>Tarımsal Sondaj & <span>DSİ Kuyu İzin Motoru</span></h1>
            <p>
                Tarlanıza veya bahçenize su kuyusu açtırmadan önce havza tahsis durumunu, ITRF96 harita krokisi, ruhsat harçları ve anahtar teslim sondaj maliyetini hesaplayın.
            </p>
        </section>

        <div class="calc-grid">
            <!-- INPUT PANEL -->
            <div class="panel">
                <h2 class="panel-title"><i class="fa-solid fa-bore-hole"></i> Sondaj Parametreleri</h2>

                <div class="form-group">
                    <label>Yeraltı Su Havzası Durumu (DSİ Statüsü)</label>
                    <select id="havzaDurumu">
                        <option value="acik">Tahsis Açık Havza (Standart Ruhsat Verilebilir)</option>
                        <option value="kisitli">Tahsis Kısıtlı / Kritik Seviye (Özel İzin Gerekir)</option>
                        <option value="kapali">Kapalı Havza (Konya vb. Yeni Kuyu Yasak)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Tahmini Sondaj Derinliği (Metre)</label>
                    <select id="derinlik">
                        <option value="50">50 Metre (Sığ Yeraltı Suyu)</option>
                        <option value="80" selected>80 Metre (Orta Derinlik)</option>
                        <option value="120">120 Metre (Standart Tarımsal Kuyu)</option>
                        <option value="160">160 Metre (Derin Kuyu)</option>
                        <option value="220">220 Metre (Ağır Jeolojik Formasyon)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Zemin Jeolojisi</label>
                    <select id="zeminTuru">
                        <option value="toprak_kil">Toprak / Alüvyon / Kil (Normal Delgi)</option>
                        <option value="kalker_kaya">Kalker / Kireçtaşı (Hafif Sert)</option>
                        <option value="bazalt_volkanik">Bazalt / Granit / Sert Kaya (Hava Kompresörlü)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Pompa & Enerji Sistemi</label>
                    <select id="pompaEnerji">
                        <option value="sebeke">Dalgıç Pompa + Tarımsal Elektrik Panosu</option>
                        <option value="gunes">Dalgıç Pompa + Solar Güneş Paneli Sistemi</option>
                        <option value="jenerator">Dalgıç Pompa + Dizel Jeneratör</option>
                    </select>
                </div>

                <button class="btn-calc" onclick="calculateWellCost()">
                    <i class="fa-solid fa-faucet-drip"></i> Kuyu ve Ruhsat Maliyetini Çıkar
                </button>
            </div>

            <!-- RESULT PANEL -->
            <div class="panel">
                <h2 class="panel-title"><i class="fa-solid fa-file-invoice-dollar"></i> Maliyet & Ruhsat Dökümü</h2>

                <div class="cost-row">
                    <span style="color:var(--text-muted);">Sondaj Delgi & İşçilik:</span>
                    <strong id="delgiUcreti">96.000 TL</strong>
                </div>
                <div class="cost-row">
                    <span style="color:var(--text-muted);">Sondaj Borusu (PVC Filtreli):</span>
                    <strong id="boruUcreti">48.000 TL</strong>
                </div>
                <div class="cost-row">
                    <span style="color:var(--text-muted);">Çakıllama, İnkişaf & Kompresör:</span>
                    <strong id="cakilUcreti">18.000 TL</strong>
                </div>
                <div class="cost-row">
                    <span style="color:var(--text-muted);">Dalgıç Pompa, Motor & Kolon Borusu:</span>
                    <strong id="pompaUcreti">65.000 TL</strong>
                </div>
                <div class="cost-row">
                    <span style="color:var(--text-muted);">Enerji & Pano (Elektrik/Solar):</span>
                    <strong id="enerjiUcreti">35.000 TL</strong>
                </div>
                <div class="cost-row">
                    <span style="color:var(--text-muted);">DSİ Arama & Kullanma Ruhsatı + Harita Krokisi:</span>
                    <strong id="ruhsatUcreti">28.500 TL</strong>
                </div>
                <div class="cost-row cost-total">
                    <span>Toplam Anahtar Teslim Kuyu Yatırımı:</span>
                    <strong id="toplamKuyuMaliyeti">290.500 TL</strong>
                </div>

                <div id="havzaUyariBox" style="background:rgba(56,189,248,0.1); border-left:4px solid var(--cyan); padding:12px; border-radius:8px; margin-top:16px; font-size:12.5px; color:#bae6fd;">
                    <i class="fa-solid fa-circle-check"></i> <strong>Ruhsat Süreci:</strong> Jeoloji ve Harita Mühendisleri tarafından hazırlanan dosya ile DSİ Bölge Müdürlüğü'ne <em>Arama Ruhsatı</em> başvurusu yapılır. Su bulunduktan sonra sayaç takılarak <em>Kullanma Belgesi</em> alınır.
                </div>
            </div>
        </div>

        <!-- FAQ SECTION -->
        <section class="faq-section">
            <h2 class="faq-title"><i class="fa-solid fa-circle-question" style="color:var(--cyan);"></i> Sıkça Sorulan Sorular</h2>
            <div class="faq-item">
                <div class="faq-question"><i class="fa-solid fa-check text-success"></i> 10 metreye kadar açılan keson kuyular için de izin gerekir mi?</div>
                <div class="faq-answer">167 sayılı Kanun gereği genişliği ve derinliği sınırlı el ile kazılan veya kepçeyle açılan keson kuyular motorlu pompa ile derin çekim yapılmadığı sürece belirli şartlarda muaf tutulabilmektedir. Ancak yine de DSİ'ye bildirim yapılması cezai yaptırımlardan korur.</div>
            </div>
        </section>
    </main>

    <script>
        function calculateWellCost() {
            const havza = document.getElementById('havzaDurumu').value;
            const derinlik = parseInt(document.getElementById('derinlik').value) || 80;
            const zemin = document.getElementById('zeminTuru').value;
            const enerji = document.getElementById('pompaEnerji').value;

            // Metre başı delgi
            let metreFiyati = 1200;
            if (zemin === 'kalker_kaya') metreFiyati = 1500;
            if (zemin === 'bazalt_volkanik') metreFiyati = 1900;

            const delgi = derinlik * metreFiyati;
            const boru = derinlik * 600;
            const cakil = 18000 + (derinlik * 50);

            // Pompa
            let pompa = 45000 + (derinlik * 250);

            // Enerji
            let enerjiTutar = 35000;
            if (enerji === 'gunes') enerjiTutar = 110000; // Solar panels & inverter
            if (enerji === 'jenerator') enerjiTutar = 75000;

            // Ruhsat & Harita
            let ruhsat = 28500;

            const box = document.getElementById('havzaUyariBox');
            if (havza === 'kapali') {
                box.style.background = 'rgba(239,68,68,0.15)';
                box.style.borderLeftColor = '#ef4444';
                box.style.color = '#fca5a5';
                box.innerHTML = '<i class="fa-solid fa-ban"></i> <strong>DİKKAT KAPALI HAVZA:</strong> Seçilen bölge yeraltı su seviyesi kritik oranda düştüğü için DSİ tarafından kuyu tahsisine tamamen kapatılmıştır. Açılacak kuyulara af uygulanmaz ve derhal mühürlenir!';
            } else {
                box.style.background = 'rgba(56,189,248,0.1)';
                box.style.borderLeftColor = 'var(--cyan)';
                box.style.color = '#bae6fd';
                box.innerHTML = '<i class="fa-solid fa-circle-check"></i> <strong>Ruhsat Süreci:</strong> Jeoloji ve Harita Mühendisleri tarafından hazırlanan dosya ile DSİ Bölge Müdürlüğü'ne Arama Ruhsatı başvurusu yapılır. Su bulunduktan sonra sayaç takılarak Kullanma Belgesi alınır.';
            }

            const toplam = delgi + boru + cakil + pompa + enerjiTutar + ruhsat;

            document.getElementById('delgiUcreti').innerText = Number(Math.round(delgi)).toLocaleString('tr-TR') + ' TL';
            document.getElementById('boruUcreti').innerText = Number(Math.round(boru)).toLocaleString('tr-TR') + ' TL';
            document.getElementById('cakilUcreti').innerText = Number(Math.round(cakil)).toLocaleString('tr-TR') + ' TL';
            document.getElementById('pompaUcreti').innerText = Number(Math.round(pompa)).toLocaleString('tr-TR') + ' TL';
            document.getElementById('enerjiUcreti').innerText = Number(Math.round(enerjiTutar)).toLocaleString('tr-TR') + ' TL';
            document.getElementById('ruhsatUcreti').innerText = Number(Math.round(ruhsat)).toLocaleString('tr-TR') + ' TL';
            document.getElementById('toplamKuyuMaliyeti').innerText = Number(Math.round(toplam)).toLocaleString('tr-TR') + ' TL';
        }

        calculateWellCost();
    </script>
</body>
</html>
