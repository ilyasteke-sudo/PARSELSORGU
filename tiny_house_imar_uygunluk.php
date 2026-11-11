<?php
/**
 * ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ - PARSEL PRO
 * Tiny House & Taşınabilir Karavan Yasal İmar Uygunluk & Mühür Riski Motoru
 * Pure PHP 8.3 / Responsive / Schema.org WebApplication & FAQPage
 */
require_once __DIR__ . '/navbar.php';

$page_title = "Tiny House & Karavan İmar Mühür Riski Testi | ParselSorgu";
$page_desc = "Tarlaya Tiny House koymak yasal mı? 3194 ve 5403 sayılı kanunlara göre O2 belgeli karavan, mühür ve yıkım riskini ölçün.";
$canonical_url = "https://www.parselsorgu.net/tiny-house-imar-uygunluk";
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
            --accent: #10b981;
            --accent-glow: rgba(16, 185, 129, 0.2);
            --danger: #ef4444;
            --warning: #f59e0b;
            --info: #38bdf8;
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
        .form-hint {
            font-size: 12px;
            color: var(--text-muted);
            margin-top: 5px;
        }

        .radio-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }
        .radio-card {
            background: #1f2937;
            border: 1px solid #374151;
            border-radius: 10px;
            padding: 12px;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }
        .radio-card:hover { border-color: var(--accent); }
        .radio-card.active {
            border-color: var(--accent);
            background: rgba(16, 185, 129, 0.1);
        }
        .radio-card input { display: none; }
        .radio-card-title {
            font-size: 13px;
            font-weight: 700;
            color: #fff;
        }
        .radio-card-desc {
            font-size: 11px;
            color: var(--text-muted);
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

        /* RESULT CARDS */
        .risk-gauge-box {
            text-align: center;
            padding: 24px 16px;
            border-radius: 14px;
            background: #1a2234;
            border: 1px solid #283548;
            margin-bottom: 24px;
        }
        .risk-percent {
            font-size: 48px;
            font-weight: 900;
            letter-spacing: -1px;
            margin: 6px 0;
        }
        .risk-badge {
            display: inline-block;
            padding: 4px 16px;
            border-radius: 9999px;
            font-size: 13px;
            font-weight: 800;
            text-transform: uppercase;
        }
        .risk-low { color: #10b981; }
        .risk-med { color: #f59e0b; }
        .risk-high { color: #ef4444; }

        .result-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 14px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }
        .result-item:last-child { border-bottom: none; }
        .result-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            flex-shrink: 0;
        }
        .result-content h4 {
            font-size: 14px;
            color: #fff;
            margin-bottom: 2px;
        }
        .result-content p {
            font-size: 12.5px;
            color: var(--text-muted);
        }

        .warning-callout {
            background: rgba(239, 68, 68, 0.1);
            border-left: 4px solid var(--danger);
            padding: 14px 16px;
            border-radius: 8px;
            margin-top: 18px;
            font-size: 13px;
            color: #fca5a5;
        }
        .success-callout {
            background: rgba(16, 185, 129, 0.1);
            border-left: 4px solid var(--accent);
            padding: 14px 16px;
            border-radius: 8px;
            margin-top: 18px;
            font-size: 13px;
            color: #6ee7b7;
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

    <!-- Schema.org WebApplication & FAQPage -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@graph": [
        {
          "@type": "WebApplication",
          "name": "Tiny House & Taşınabilir Karavan İmar İzin & Mühür Riski Motoru",
          "url": "https://www.parselsorgu.net/tiny-house-imar-uygunluk",
          "description": "3194 İmar Kanunu ve 5403 Toprak Koruma Kanununa göre tarlaya tiny house koyma izinleri, O2 karavan mühür riski ve ceza hesaplayıcı.",
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
              "name": "Tarlaya Tiny House koymak yasal mıdır?",
              "acceptedAnswer": {
                "@type": "Answer",
                "text": "Tekerlekli ve Karayolları Trafik Yönetmeliği'ne göre tescilli (O2 belgeli, plakalı ve ruhsatlı) araçlar hukuken 'vasıta' sayılır ve tarlada park halinde bulunabilir. Ancak altlarına beton subasman dökülmesi, ahşap veranda/platform eklenmesi veya sabit tesisat bağlanması halinde 3194 sayılı Kanun kapsamında yapı sayılarak mühürlenir ve yıkım kararı verilir."
              }
            },
            {
              "@type": "Question",
              "name": "Belediye plakalı karavana imar para cezası kesebilir mi?",
              "acceptedAnswer": {
                "@type": "Answer",
                "text": "Karavanın tekerlekleri üzerinde olması tek başına yeterli değildir. Sürekli ikamet amacıyla sabitlenmişse, foseptik kuyu ve elektrik şebekesi çekilmişse veya 5403 sayılı Kanun uyarınca tarım arazisinin bütünlüğü bozulmuşsa idari para cezası ve arazinin eski haline getirilmesi kararı çıkmaktadır."
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
                <i class="fa-solid fa-caravan"></i> 2026 Mevzuat & Danıştay Emsal Kararları
            </div>
            <h1>Tiny House & Taşınabilir Yapı <span>Yasal Risk Analizi</span></h1>
            <p>
                Tarlanıza veya arsanıza Tiny House koymadan önce 3194 İmar Kanunu ve 5403 Toprak Koruma Kanunu kapsamında belediye mühür, para cezası ve tahliye riskini saniyeler içinde hesaplayın.
            </p>
        </section>

        <div class="calc-grid">
            <!-- INPUT PANEL -->
            <div class="panel">
                <h2 class="panel-title"><i class="fa-solid fa-sliders"></i> Arazi & Yapı Kriterleri</h2>

                <div class="form-group">
                    <label>Parselin İmar & Kadastral Niteliği</label>
                    <select id="araziNiteliği">
                        <option value="tarla">Tarla / Ham Toprak (5403 s.K.)</option>
                        <option value="zeytinlik">Zeytinlik (3573 s.K. Özel Kısıtlı)</option>
                        <option value="bag">Bağ / Bahçe / Meyvelik</option>
                        <option value="koy_ici">Köy Yerleşik Alanı İçi (Plansız Alanlar)</option>
                        <option value="arsa">İmarlı Arsa (Konut / Villa Lejantı)</option>
                        <option value="sit_orman">Sit Alanı / Orman Bitişiği / Kıyı Kenar</option>
                    </select>
                    <div class="form-hint">Zeytinlik ve sit alanlarında en katı cezai yaptırımlar uygulanmaktadır.</div>
                </div>

                <div class="form-group">
                    <label>Taşınırın Hukuki Vasıf Türü</label>
                    <div class="radio-grid" id="yapiTuruGroup">
                        <div class="radio-card active" onclick="selectCard('yapiTuru', 'o2_plakali', this)">
                            <div class="radio-card-title"><i class="fa-solid fa-id-card"></i> O2 Plakalı Karavan</div>
                            <div class="radio-card-desc">Tekerlekli, plakalı, ruhsatlı ve çekilebilir</div>
                        </div>
                        <div class="radio-card" onclick="selectCard('yapiTuru', 'tekerleksiz_tiny', this)">
                            <div class="radio-card-title"><i class="fa-solid fa-warehouse"></i> Tekerleksiz / Konteyner</div>
                            <div class="radio-card-desc">Tekerleği yok, şasi veya blok üzerine konmuş</div>
                        </div>
                    </div>
                    <input type="hidden" id="yapiTuru" value="o2_plakali">
                </div>

                <div class="form-group">
                    <label>Zemin & Altyapı Durumu (En Kritik Faktör)</label>
                    <select id="zeminAltyapi">
                        <option value="dogal_zemin">Doğal Toprak Üzerinde (Müdahalesiz Park)</option>
                        <option value="micir_cakil">Mıcır / Çakıl Serilmiş Alan</option>
                        <option value="beton_subasman">Beton Subasman / Grobeton Dökülmüş</option>
                        <option value="veranda_platform">Ahşap Veranda / Çelik Platform Eklenmiş</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Elektrik & Su / Atık Su Temini</label>
                    <select id="altyapiTesis">
                        <option value="off_grid">Off-Grid (Güneş Paneli + Portatif Depo)</option>
                        <option value="kuyu_foseptik">Sondaj Kuyusu + Kazılmış Foseptik Çukuru</option>
                        <option value="sebeke_baglanti">Resmi Şebeke Aboneliği Talebi / Kablo Çekimi</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Belediye / Mücavir Alan Sınırı</label>
                    <select id="yonetimBolgesi">
                        <option value="buyuksehir">Büyükşehir Belediyesi Mücavir Alanı</option>
                        <option value="ilce_belediye">İlçe Belediyesi Sınırı</option>
                        <option value="il_ozel_idaresi">İl Özel İdaresi Görev Alanı (Köy Dışı)</option>
                    </select>
                </div>

                <button class="btn-calc" onclick="calculateTinyRisk()">
                    <i class="fa-solid fa-shield-halved"></i> Yasal Risk Raporunu Hesapla
                </button>
            </div>

            <!-- RESULT PANEL -->
            <div class="panel">
                <h2 class="panel-title"><i class="fa-solid fa-chart-pie"></i> Yasal Uygunluk & Risk Skoru</h2>

                <div class="risk-gauge-box">
                    <div style="font-size:13px; color:var(--text-muted); font-weight:700;">HUKUKİ MÜHÜR VE YIKIM RİSKİ</div>
                    <div class="risk-percent risk-low" id="riskPercent">%15</div>
                    <span class="risk-badge" id="riskBadge" style="background:rgba(16,185,129,0.2); color:#10b981;">DÜŞÜK RİSK (YASAL PARK)</span>
                </div>

                <div id="resultDetails">
                    <div class="result-item">
                        <div class="result-icon" style="background:rgba(56,189,248,0.15); color:#38bdf8;">
                            <i class="fa-solid fa-scale-balanced"></i>
                        </div>
                        <div class="result-content">
                            <h4>3194 Sayılı İmar Kanunu Açısından</h4>
                            <p id="imarKanunuYorum">Taşıt niteliğinde olup sabit yapı vasfı taşımamaktadır.</p>
                        </div>
                    </div>

                    <div class="result-item">
                        <div class="result-icon" style="background:rgba(245,158,11,0.15); color:#f59e0b;">
                            <i class="fa-solid fa-seedling"></i>
                        </div>
                        <div class="result-content">
                            <h4>5403 Sayılı Toprak Koruma Kanunu</h4>
                            <p id="toprakKanunuYorum">Tarım arazisinin üst örtüsü bozulmamışsa cezai işlem oluşmaz.</p>
                        </div>
                    </div>

                    <div class="result-item">
                        <div class="result-icon" style="background:rgba(239,68,68,0.15); color:#ef4444;">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                        </div>
                        <div class="result-content">
                            <h4>Belediye & Zabıta Müdahale İhtimali</h4>
                            <p id="belediyeYorum">Şikayet veya CİMER başvurusu halinde zabıta tespiti yapılabilir.</p>
                        </div>
                    </div>

                    <div class="result-item">
                        <div class="result-icon" style="background:rgba(16,185,129,0.15); color:#10b981;">
                            <i class="fa-solid fa-lightbulb"></i>
                        </div>
                        <div class="result-content">
                            <h4>Yasal Korunma & Tavsiye</h4>
                            <p id="tavsiyeYorum">Ruhsat, muayene ve sigortanızı aracın içinde hazır bulundurun.</p>
                        </div>
                    </div>
                </div>

                <div id="calloutBox" class="success-callout">
                    <strong>Hukuki Güvence:</strong> Aracınız Karayolları Trafik Kanunu'na göre motorlu araç / römork sayılmaktadır. Altına beton dökmediğiniz ve veranda yapmadığınız sürece imar cezası uygulanamaz (Danıştay 6. Daire Emsal Kararı).
                </div>
            </div>
        </div>

        <!-- FAQ SECTION -->
        <section class="faq-section">
            <h2 class="faq-title"><i class="fa-solid fa-circle-question" style="color:var(--accent);"></i> Sıkça Sorulan Sorular & Danıştay Kararları</h2>
            
            <div class="faq-item">
                <div class="faq-question"><i class="fa-solid fa-check text-success"></i> Tekerlekli Tiny House için belediyeden yapı ruhsatı almak gerekir mi?</div>
                <div class="faq-answer">Hayır. 3194 sayılı İmar Kanunu yalnızca 'yapı' ve 'bina' tanımına giren unsurları ruhsata bağlar. Karayolları Trafik Yönetmeliği'ne göre tescil edilmiş O2 belgeli çekme karavanlar yapı değil vasıtadır; dolayısıyla belediyeden imar ruhsatı alınamaz ve talep edilemez.</div>
            </div>

            <div class="faq-item">
                <div class="faq-question"><i class="fa-solid fa-check text-success"></i> Belediyeler neden Tiny House'ları mühürlüyor ve yıkım kararı alıyor?</div>
                <div class="faq-answer">Belediyeler doğrudan karavanın kendisine değil; karavanın altına dökülen beton subasmanlara, etrafına inşa edilen ahşap sundurma ve verandalara, kazılan sabit foseptik kuyularına ve çevrilen taş/tel istinat duvarlarına 3194 sayılı Kanunun 32. ve 42. maddeleri uyarınca kaçak yapı muamelesi yapmaktadır.</div>
            </div>

            <div class="faq-item">
                <div class="faq-question"><i class="fa-solid fa-check text-success"></i> Zeytinliğe Tiny House konulabilir mi?</div>
                <div class="faq-answer">3573 sayılı Zeytinciliğin Islahı ve Yabanilerinin Aşılattırılması Hakkında Kanun son derece katıdır. Zeytinlik arazilerinde zeytin ağacına zarar verecek, köklerini sıkıştıracak veya tarımsal vasfını bozacak hiçbir faaliyete izin verilmez. Tarım İl Müdürlüğü denetimlerinde yüksek para cezaları ve tahliye kararları verilmektedir.</div>
            </div>

            <div class="faq-item">
                <div class="faq-question"><i class="fa-solid fa-check text-success"></i> Tiny House için resmi elektrik ve su aboneliği alınabilir mi?</div>
                <div class="faq-answer">Genel kural olarak yapı kullanım izin belgesi (iskan) olmayan yerlere TEDAŞ/belediye su aboneliği vermez. Çözüm olarak arazide tarımsal sulama aboneliği açtırmak veya tamamen şebekeden bağımsız (off-grid) güneş enerjisi ve sızdırmaz taşınabilir su deposu kullanmak zorunludur.</div>
            </div>
        </section>
    </main>

    <script>
        function selectCard(hiddenId, val, elem) {
            document.getElementById(hiddenId).value = val;
            const parent = elem.parentElement;
            parent.querySelectorAll('.radio-card').forEach(c => c.classList.remove('active'));
            elem.classList.add('active');
            calculateTinyRisk();
        }

        function calculateTinyRisk() {
            const nitelik = document.getElementById('araziNiteliği').value;
            const yapi = document.getElementById('yapiTuru').value;
            const zemin = document.getElementById('zeminAltyapi').value;
            const altyapi = document.getElementById('altyapiTesis').value;
            const yonetim = document.getElementById('yonetimBolgesi').value;

            let score = 15; // base low risk

            // 1. Arazi niteliği etkisi
            if (nitelik === 'sit_orman') score += 45;
            else if (nitelik === 'zeytinlik') score += 40;
            else if (nitelik === 'tarla') score += 15;
            else if (nitelik === 'koy_ici') score += 5;
            else if (nitelik === 'arsa') score -= 5;

            // 2. Yapı türü
            if (yapi === 'tekerleksiz_tiny') score += 35;

            // 3. Zemin ve altyapı
            if (zemin === 'beton_subasman') score += 40;
            else if (zemin === 'veranda_platform') score += 25;
            else if (zemin === 'micir_cakil') score += 5;

            // 4. Altyapı
            if (altyapi === 'sebeke_baglanti') score += 20;
            else if (altyapi === 'kuyu_foseptik') score += 15;

            // Clamp 5 - 98
            score = Math.max(5, Math.min(98, score));

            const percentElem = document.getElementById('riskPercent');
            const badgeElem = document.getElementById('riskBadge');
            const calloutBox = document.getElementById('calloutBox');

            percentElem.innerText = '%' + score;

            if (score <= 30) {
                percentElem.className = 'risk-percent risk-low';
                badgeElem.style.background = 'rgba(16, 185, 129, 0.2)';
                badgeElem.style.color = '#10b981';
                badgeElem.innerText = 'DÜŞÜK RİSK (YASAL TAŞINIR PARK)';
                calloutBox.className = 'success-callout';
                calloutBox.innerHTML = '<strong>Hukuki Güvence:</strong> Aracınız tekerlekleri üzerinde ve zeminle sabit bir bağı bulunmadığı için Danıştay 6. Dairesi emsal kararlarına göre yapı değil taşıttır. Belediye 3194 kapsamında mühürleyemez.';
            } else if (score <= 65) {
                percentElem.className = 'risk-percent risk-med';
                badgeElem.style.background = 'rgba(245, 158, 11, 0.2)';
                badgeElem.style.color = '#f59e0b';
                badgeElem.innerText = 'ORTA RİSK (DENETİM VE CEZA İHTİMALİ)';
                calloutBox.className = 'warning-callout';
                calloutBox.innerHTML = '<strong>Dikkat:</strong> Ahşap platform, veranda veya kazılmış foseptik gibi eklentiler belediye encümenince "kalıcı yapı" olarak yorumlanabilir. Eklentileri sökmeniz veya seyyar hale getirmeniz önerilir.';
            } else {
                percentElem.className = 'risk-percent risk-high';
                badgeElem.style.background = 'rgba(239, 68, 68, 0.2)';
                badgeElem.style.color = '#ef4444';
                badgeElem.innerText = 'YÜKSEK RİSK (MÜHÜR VE YIKIM KAÇINILMAZ)';
                calloutBox.className = 'warning-callout';
                calloutBox.innerHTML = '<strong>Yüksek Hukuki Risk:</strong> Beton subasman, tekerleksiz şasi veya zeytinlik/sit alanı kısıtları nedeniyle 3194 s.K. 32. ve 42. maddeleri gereğince yapı tatil zaptı tutulması, ağır idari para cezası ve savcılık suç duyurusu (TCK 184 İmar Kirliliği) riski çok yüksektir!';
            }

            // Text interpretations
            if (zemin === 'beton_subasman') {
                document.getElementById('imarKanunuYorum').innerText = 'Dökülen beton subasman zemine kalıcı bağ oluşturduğu için kesinlikle 3194 kapsamında İMARLI YAPI sayılır!';
            } else {
                document.getElementById('imarKanunuYorum').innerText = 'Zemine kalıcı harç/beton bağı olmadığı sürece taşıt vasfı korunur.';
            }

            if (nitelik === 'zeytinlik') {
                document.getElementById('toprakKanunuYorum').innerText = '3573 s.K. uyarınca zeytinlikte tarım dışı her kullanım suçtur; Tarım İl Müdürlüğü derhal tahliye ister.';
            } else {
                document.getElementById('toprakKanunuYorum').innerText = 'Toprağın üst bitki örtüsünü ve drenajını bozmadığınız sürece 5403 s.K. cezası riski düşüktür.';
            }
        }

        // Trigger on load and change
        document.querySelectorAll('select').forEach(s => s.addEventListener('change', calculateTinyRisk));
    </script>
</body>
</html>
