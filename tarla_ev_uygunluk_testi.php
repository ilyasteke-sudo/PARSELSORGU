<?php
/**
 * ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ - PARSEL PRO
 * MODÜL 2: TARLAYA EV YAPILABİLİR Mİ? (0 - 100 RUHSAT & UYGUNLUK RADARI)
 * URL: https://www.parselsorgu.net/tarlaya-ev-yapilir-mi-testi
 */
declare(strict_types=1);

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/navbar.php';

$page_title = "Tarlaya Ev Yapılır mı? (2026 İmar Testi) | ParselSorgu";
$meta_desc = "Tarlanıza prefabrik, bungalov, tiny house veya betonarme ev yapıp yapamayacağınızı 5403 ve 3194 sayılı kanunlara göre anında test edin.";
$canonical_url = "https://www.parselsorgu.net/tarlaya-ev-yapilir-mi-testi";

$json_ld = [
    "@context" => "https://schema.org",
    "@graph" => [
        [
            "@type" => "BreadcrumbList",
            "itemListElement" => [
                ["@type" => "ListItem", "position" => 1, "name" => "Ana Sayfa", "item" => "https://www.parselsorgu.net"],
                ["@type" => "ListItem", "position" => 2, "name" => "İmar Rehberi", "item" => "https://www.parselsorgu.net/rehber"],
                ["@type" => "ListItem", "position" => 3, "name" => "Tarlaya Ev Yapma Testi", "item" => $canonical_url]
            ]
        ],
        [
            "@type" => "FAQPage",
            "mainEntity" => [
                [
                    "@type" => "Question",
                    "name" => "5000 m² altındaki tarlaya ev yapılır mı?",
                    "acceptedAnswer" => ["@type" => "Answer", "text" => "5403 sayılı Toprak Koruma Kanunu gereğince, köy yerleşik alan sınırı dışındaki mutlak tarım arazilerinde 5.000 m² altında olan ve kadastral yola 25 metre cephesi bulunmayan parsellere konut ruhsatı verilmez."]
                ],
                [
                    "@type" => "Question",
                    "name" => "Tarlaya prefabrik ev koymak için ruhsat gerekir mi?",
                    "acceptedAnswer" => ["@type" => "Answer", "text" => "Evet. İmar Kanunu 20. maddesi uyarınca toprağa bağlı, elektrik-su bağlanan tüm prefabrik ve çelik yapılar ruhsata tabidir."]
                ]
            ]
        ]
    ]
];
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title><?= htmlspecialchars($page_title) ?></title>
    <meta name="description" content="<?= htmlspecialchars($meta_desc) ?>">
    <link rel="canonical" href="<?= htmlspecialchars($canonical_url) ?>">
    <meta name="robots" content="index, follow">

    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?= htmlspecialchars($page_title) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($meta_desc) ?>">
    <meta property="og:url" content="<?= htmlspecialchars($canonical_url) ?>">
    <meta property="og:image" content="https://www.parselsorgu.net/assets/images/og-parsel.jpg">
    <meta name="twitter:card" content="summary_large_image">

    <!-- Fonts & Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/main.css?v=2026.49">

    <script type="application/ld+json"><?= json_encode($json_ld, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>

    <style>
        :root {
            --bg-dark: #070b14;
            --card-dark: #0f172a;
            --border-dark: rgba(56, 189, 248, 0.22);
            --primary-cyan: #38bdf8;
            --primary-blue: #0284c7;
        }
        body { font-family: 'Inter', -apple-system, sans-serif; background: var(--bg-dark); color: #f8fafc; margin: 0; padding: 0; }
        .radar-container { max-width: 1040px; margin: 0 auto; padding: 24px 16px 80px 16px; }
        .radar-hero { background: linear-gradient(135deg, rgba(15,23,42,0.98) 0%, rgba(30,41,59,0.95) 100%); border: 2px solid #22c55e; border-radius: 16px; padding: 28px; margin-bottom: 24px; box-shadow: 0 10px 40px rgba(34,197,94,0.18); }
        .radar-grid { display: grid; grid-template-columns: 1.15fr 0.85fr; gap: 20px; margin-bottom: 30px; }
        .card-box { background: var(--card-dark); border: 1px solid var(--border-dark); border-radius: 14px; padding: 24px; box-shadow: 0 10px 30px rgba(0,0,0,0.3); }
        .q-item { margin-bottom: 18px; padding-bottom: 14px; border-bottom: 1px solid rgba(255,255,255,0.06); }
        .q-title { font-size: 13.5px; font-weight: 800; color: #fff; margin-bottom: 8px; display: flex; align-items: center; gap: 8px; }
        .opt-btn-group { display: flex; gap: 8px; flex-wrap: wrap; }
        .opt-btn { background: #070b14; border: 1.5px solid #334155; color: #cbd5e1; padding: 8px 14px; border-radius: 8px; font-size: 12.5px; font-weight: 700; cursor: pointer; transition: all 0.2s; font-family: inherit; }
        .opt-btn.active { background: #0284c7; border-color: #38bdf8; color: #fff; box-shadow: 0 0 15px rgba(2,132,199,0.4); }
        .score-circle { width: 140px; height: 140px; border-radius: 50%; display: flex; flex-direction: column; align-items: center; justify-content: center; margin: 0 auto 16px auto; border: 4px solid #22c55e; box-shadow: 0 0 30px rgba(34,197,94,0.3); }
        @media (max-width: 860px) {
            .radar-grid { grid-template-columns: 1fr; }
            .radar-hero { padding: 20px 16px; }
        }
    </style>
    <link rel="alternate" type="text/markdown" href="https://www.parselsorgu.net/llms.txt" title="ParselSorgu AI / LLM Bilgi Bankası">
    <link rel="alternate" type="application/json" href="https://www.parselsorgu.net/api/2026-kadastro-endeks.json" title="2026 Kadastro ve İmar Açık Veri Seti">
    <script type="application/ld+json">{"@context": "https://schema.org", "@type": "WebPage", "speakable": {"@type": "SpeakableSpecification", "cssSelector": ["h1", ".lead", ".summary-box", ".hero-desc", "main p"]}, "isBasedOn": "https://www.parselsorgu.net/api/2026-kadastro-endeks.json", "publisher": {"@type": "Organization", "name": "Ant Harita Mühendislik - ParselSorgu.net", "url": "https://www.parselsorgu.net/"}}</script>
</head>
<body>

    <?php render_saas_navbar('hesaplama'); ?>

    <main class="radar-container">
        <!-- Hero Section -->
        <section class="radar-hero">
            <div style="display:inline-flex; align-items:center; gap:8px; margin-bottom:10px;">
                <span style="background:rgba(34,197,94,0.2); border:1px solid #22c55e; color:#4ade80; font-size:11px; font-weight:800; padding:4px 10px; border-radius:4px;">
                    <i class="fa-solid fa-house-shield"></i> 5403 &amp; 3194 MEVZUAT UYUMLU
                </span>
                <span style="background:rgba(56,189,248,0.2); border:1px solid #38bdf8; color:#38bdf8; font-size:11px; font-weight:800; padding:4px 10px; border-radius:4px;">
                    RUHSAT &amp; CEZA RİSK RADARI
                </span>
            </div>
            <h1 style="font-size:clamp(1.4rem, 2.8vw, 2rem); font-weight:900; color:#fff; margin:0 0 10px 0;">
                Tarlaya Ev Yapılabilir mi? Uygunluk &amp; Ruhsat Testi
            </h1>
            <p style="font-size:14px; color:#cbd5e1; margin:0; line-height:1.6; max-width:850px;">
                Tarlanızı satın almadan veya yapılaşmaya başlamadan önce yasal durumunu 5 parametrede test edin. Yıkım cezası ve ruhsatsız yapı riskine girmeden ne kadar inşaat yapabileceğinizi öğrenin.
            </p>
        </section>

        <!-- Interactive Question & Result Grid -->
        <div class="radar-grid">
            <!-- Questions Panel -->
            <div class="card-box">
                <h2 style="font-size:16px; font-weight:800; color:#fff; margin:0 0 18px 0; display:flex; align-items:center; gap:8px;">
                    <i class="fa-solid fa-list-check" style="color:#38bdf8;"></i> 5 Kritik Arazi Parametresi
                </h2>

                <!-- Soru 1: Yol -->
                <div class="q-item">
                    <div class="q-title"><i class="fa-solid fa-road" style="color:#f59e0b;"></i> 1. Kadastral Resmi Yola Cephe Durumu:</div>
                    <div class="opt-btn-group" id="grp-road">
                        <button class="opt-btn active" data-score="30" onclick="setOpt('grp-road', this)">Resmi Yola 25m+ Cephesi Var (+30 Puan)</button>
                        <button class="opt-btn" data-score="10" onclick="setOpt('grp-road', this)">Yola Cephesi 25m Altında (+10 Puan)</button>
                        <button class="opt-btn" data-score="-50" onclick="setOpt('grp-road', this)">Resmi Yol Yok / Patika (-50 Puan)</button>
                    </div>
                </div>

                <!-- Soru 2: Köy Yerleşik Alan -->
                <div class="q-item">
                    <div class="q-title"><i class="fa-solid fa-mountain-city" style="color:#38bdf8;"></i> 2. Köy Yerleşik Alan Sınırı:</div>
                    <div class="opt-btn-group" id="grp-village">
                        <button class="opt-btn active" data-score="35" onclick="setOpt('grp-village', this)">Köy Yerleşik Alanı İçinde (+35 Puan)</button>
                        <button class="opt-btn" data-score="15" onclick="setOpt('grp-village', this)">Köy Sınırı Dışında (Tarım Alanı) (+15 Puan)</button>
                        <button class="opt-btn" data-score="-40" onclick="setOpt('grp-village', this)">Sit Alanı / Orman Bitişiği (-40 Puan)</button>
                    </div>
                </div>

                <!-- Soru 3: Büyüklük -->
                <div class="q-item">
                    <div class="q-title"><i class="fa-solid fa-ruler-combined" style="color:#22c55e;"></i> 3. Arazi Büyüklüğü:</div>
                    <div class="opt-btn-group" id="grp-size">
                        <button class="opt-btn active" data-score="25" onclick="setOpt('grp-size', this)">5.000 m² ve Üzeri (+25 Puan)</button>
                        <button class="opt-btn" data-score="0" onclick="setOpt('grp-size', this)">5.000 m² Altında (0 Puan)</button>
                    </div>
                </div>

                <!-- Soru 4: Tapu Niteliği -->
                <div class="q-item">
                    <div class="q-title"><i class="fa-solid fa-file-contract" style="color:#c084fc;"></i> 4. Tapudaki Cins / Nitelik:</div>
                    <div class="opt-btn-group" id="grp-type">
                        <button class="opt-btn active" data-score="10" onclick="setOpt('grp-type', this)">Tarla / Müstakil Parsel (+10 Puan)</button>
                        <button class="opt-btn" data-score="-20" onclick="setOpt('grp-type', this)">Zeytinlik (3573 s.K. Kısıtlı) (-20 Puan)</button>
                        <button class="opt-btn" data-score="-15" onclick="setOpt('grp-type', this)">Hisseli Tapu (Diğer Hissedar Var) (-15 Puan)</button>
                    </div>
                </div>

                <!-- Soru 5: Yapı Tipi -->
                <div class="q-item" style="border-bottom:none;">
                    <div class="q-title"><i class="fa-solid fa-house" style="color:#f87171;"></i> 5. Yapmak İstediğiniz Yapı:</div>
                    <div class="opt-btn-group" id="grp-build">
                        <button class="opt-btn active" data-type="prefabrik" onclick="setOpt('grp-build', this)">Prefabrik / Çelik Ev</button>
                        <button class="opt-btn" data-type="betonarme" onclick="setOpt('grp-build', this)">Betonarme Bağ Evi</button>
                        <button class="opt-btn" data-type="tinyhouse" onclick="setOpt('grp-build', this)">Tekerlekli Tiny House (Plakalı)</button>
                    </div>
                </div>
            </div>

            <!-- Score Result Panel -->
            <div class="card-box" style="text-align:center;">
                <h2 style="font-size:16px; font-weight:800; color:#fff; margin:0 0 16px 0;">
                    Uygunluk Skoru &amp; Karar
                </h2>

                <div class="score-circle" id="circle-score" style="border-color:#22c55e;">
                    <div style="font-size:38px; font-weight:900; color:#fff;" id="num-score">100</div>
                    <div style="font-size:11px; font-weight:800; color:#94a3b8; text-transform:uppercase;">/ 100 Puan</div>
                </div>

                <div style="font-size:18px; font-weight:900; color:#4ade80; margin-bottom:10px;" id="lbl-status">
                    ✅ %100 YASAL RUHSAT ALINABİLİR
                </div>

                <div style="background:#070b14; border:1px solid #1e293b; border-radius:10px; padding:14px; text-align:left; font-size:12.5px; color:#cbd5e1; line-height:1.6; margin-bottom:16px;" id="box-explanation">
                    Tarlanız kadastral yola cepheli ve köy yerleşik alan şartlarını taşıdığı için İl Özel İdaresi veya Belediye onaylı resmi inşaat ruhsatı alarak taban alanı maksimum <strong>150 m²</strong> olan 2 katlı bağ evi yapabilirsiniz.
                </div>

                <button type="button" onclick="shareRadarWhatsApp()" style="width:100%; background:linear-gradient(135deg, #25d366 0%, #128c7e 100%); color:#fff; border:none; padding:12px; border-radius:10px; font-size:13.5px; font-weight:900; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:8px; box-shadow:0 4px 15px rgba(37,211,102,0.35);">
                    <i class="fa-brands fa-whatsapp" style="font-size:18px;"></i> Bu Uygunluk Raporunu WhatsApp'ta Paylaş
                </button>
            </div>
        </div>
    </main>

    <script>
    function setOpt(groupId, el) {
        document.querySelectorAll('#' + groupId + ' .opt-btn').forEach(b => b.classList.remove('active'));
        el.classList.add('active');
        calculateRadar();
    }

    function calculateRadar() {
        let score = 0;
        let noRoad = false;
        let isZeytin = false;
        let isHisseli = false;
        let isSit = false;
        let isSmall = false;

        document.querySelectorAll('.opt-btn.active').forEach(b => {
            const sc = parseInt(b.getAttribute('data-score')) || 0;
            score += sc;
            if (sc === -50) noRoad = true;
            if (sc === -20) isZeytin = true;
            if (sc === -15) isHisseli = true;
            if (sc === -40) isSit = true;
            if (b.innerText.includes('5.000 m² Altında')) isSmall = true;
        });

        score = Math.max(0, Math.min(100, score));

        const circle = document.getElementById('circle-score');
        const num = document.getElementById('num-score');
        const status = document.getElementById('lbl-status');
        const exp = document.getElementById('box-explanation');

        num.innerText = score;

        if (noRoad) {
            circle.style.borderColor = '#ef4444';
            status.style.color = '#f87171';
            status.innerHTML = '🚫 %0 İNŞAAT İZNİ YOK (YOLSUZ PARSEL)';
            exp.innerHTML = '⚠️ <strong>Kadastral Resmi Yol Yok:</strong> 3194 Sayılı İmar Kanunu 18. ve 27. maddeleri gereğince, tapuda tescilli resmi yola cephesi olmayan hiçbir parsele elektrik-su bağlanamaz ve ev ruhsatı VERİLEMEZ. Komşulardan geçit hakkı alınmadan yapı yapılamaz.';
        } else if (isZeytin) {
            circle.style.borderColor = '#f59e0b';
            status.style.color = '#fbbf24';
            status.innerHTML = '⚠️ ZEYTİNLİK KISITI (3573 s.K.)';
            exp.innerHTML = '🌿 <strong>Zeytin Sahası Uyarısı:</strong> 3573 sayılı Zeytinciliğin Islahı Kanunu gereğince, zeytinlik arazilerde konut amacıyla yapılaşma kesin olarak kısıtlanmıştır. İl Tarım Müdürlüğü izni olmadan konulan prefabrikler dahi idari para cezası ve yıkımla karşılaşır.';
        } else if (score >= 70) {
            circle.style.borderColor = '#22c55e';
            status.style.color = '#4ade80';
            status.innerHTML = '✅ %' + score + ' YASAL RUHSAT ALINABİLİR';
            exp.innerHTML = '🏡 <strong>Tebrikler:</strong> Araziniz yol ve büyüklük kriterlerini sağlamaktadır. İl Özel İdaresi veya Belediye Fen İşleri müdürlüğünden onaylı mimari proje ile <strong>150 m²</strong> tabanlı bağ evi/çelik konstrüksiyon ruhsatı alabilirsiniz.';
        } else {
            circle.style.borderColor = '#f59e0b';
            status.style.color = '#fbbf24';
            status.innerHTML = '⚠️ %' + score + ' KISITLI / ŞARTLI UYGUNLUK';
            exp.innerHTML = '📋 <strong>Ön İzin Gerekir:</strong> Araziniz köy yerleşik alanı dışında ve 5.000 m² altında olduğu için yalnızca tarımsal amaçlı bağ evi izni İl Tarım Müdürlüğü komisyon kararına bağlıdır. Satın almadan önce mutlaka Harita Mühendisi kontrolü yaptırınız.';
        }
    }

    function shareRadarWhatsApp() {
        const score = document.getElementById('num-score').innerText;
        const status = document.getElementById('lbl-status').innerText;

        const text = `🚦 *Tarlaya Ev Yapılabilir mi? Uygunluk Test Sonucu:*\n📊 Skor: *${score} / 100*\n📢 Durum: *${status}*\n⚖️ 5403 ve 3194 Sayılı Kanun kapsamındaki testi siz de yapın:\n👉 https://www.parselsorgu.net/tarlaya-ev-yapilir-mi-testi`;
        window.open('https://api.whatsapp.com/send?text=' + encodeURIComponent(text), '_blank');
    }

    calculateRadar();
    </script>
    <script src="/analytics.js?v=2026.1" defer></script>
</body>
</html>
