<?php
/**
 * ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ - PARSEL PRO
 * A/B PARSEL VE ARAZİ KARŞILAŞTIRMA ARACI
 * URL: https://www.parselsorgu.net/parsel-karsilastirma
 */
declare(strict_types=1);

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/navbar.php';

$page_title = "Parsel Karşılaştırma ve A/B Arazi Kıyaslama | ParselSorgu";
$meta_desc = "İki parseli yan yana koyarak m² fiyatı, imar durumu, KAKS emsal, eğim ve yatırım skoruna göre anında karşılaştırıp en karlı arsayı bulun.";
$canonical_url = "https://www.parselsorgu.net/parsel-karsilastirma";

$json_ld = [
    "@context" => "https://schema.org",
    "@graph" => [
        [
            "@type" => "BreadcrumbList",
            "itemListElement" => [
                ["@type" => "ListItem", "position" => 1, "name" => "Ana Sayfa", "item" => "https://www.parselsorgu.net"],
                ["@type" => "ListItem", "position" => 2, "name" => "Hesaplama & Karşılaştırma", "item" => "https://www.parselsorgu.net/#parsel"],
                ["@type" => "ListItem", "position" => 3, "name" => "Parsel Karşılaştırma", "item" => $canonical_url]
            ]
        ],
        [
            "@type" => "SoftwareApplication",
            "name" => "ParselSorgu A/B Parsel Kıyaslama Motoru",
            "operatingSystem" => "All",
            "applicationCategory" => "BusinessApplication",
            "offers" => [
                "@type" => "Offer",
                "price" => "0",
                "priceCurrency" => "TRY"
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

    <!-- Preconnect & Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="/assets/css/main.css?v=2026.50">

    <script type="application/ld+json"><?= json_encode($json_ld, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>

    <style>
        :root {
            --bg-dark: #080d1a;
            --card-dark: #0f172a;
            --border-card: rgba(56, 189, 248, 0.22);
            --primary-cyan: #38bdf8;
            --primary-emerald: #10b981;
        }
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--bg-dark);
            color: #f8fafc;
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }
        .compare-wrap {
            max-width: 1200px;
            margin: 0 auto;
            padding: 24px 16px 80px 16px;
        }
        .hero-banner {
            background: linear-gradient(135deg, rgba(15,23,42,0.95) 0%, rgba(30,41,59,0.92) 100%);
            border: 1px solid rgba(56, 189, 248, 0.3);
            border-radius: 20px;
            padding: 32px 24px;
            text-align: center;
            margin-bottom: 28px;
            box-shadow: 0 10px 40px rgba(2, 132, 199, 0.15);
        }
        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(56, 189, 248, 0.12);
            color: #38bdf8;
            border: 1px solid rgba(56, 189, 248, 0.35);
            padding: 6px 14px;
            border-radius: 9999px;
            font-size: 13px;
            font-weight: 800;
            margin-bottom: 14px;
        }
        .compare-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 24px;
        }
        @media (max-width: 860px) {
            .compare-grid {
                grid-template-columns: 1fr;
            }
        }
        .parcel-box {
            background: var(--card-dark);
            border-radius: 16px;
            border: 2px solid #1e293b;
            padding: 22px;
            transition: all 0.25s ease;
        }
        .parcel-box.active-a {
            border-color: #38bdf8;
            box-shadow: 0 0 25px rgba(56, 189, 248, 0.15);
        }
        .parcel-box.active-b {
            border-color: #10b981;
            box-shadow: 0 0 25px rgba(16, 185, 129, 0.15);
        }
        .input-group-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-bottom: 12px;
        }
        .form-label {
            display: block;
            font-size: 11.5px;
            font-weight: 800;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
        }
        .form-control-custom {
            width: 100%;
            background: #090e17;
            border: 1.5px solid #334155;
            color: #ffffff;
            padding: 10px 12px;
            border-radius: 10px;
            font-size: 13.5px;
            font-weight: 600;
            box-sizing: border-box;
            outline: none;
            transition: border-color 0.2s;
        }
        .form-control-custom:focus {
            border-color: #38bdf8;
        }
        .btn-compare-main {
            width: 100%;
            background: linear-gradient(135deg, #0284c7 0%, #10b981 100%);
            color: #ffffff;
            border: none;
            padding: 16px;
            border-radius: 14px;
            font-size: 16px;
            font-weight: 900;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            box-shadow: 0 8px 30px rgba(2, 132, 199, 0.35);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .btn-compare-main:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 35px rgba(16, 185, 129, 0.45);
        }
        .matrix-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background: #0f172a;
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid rgba(56, 189, 248, 0.2);
            margin-top: 28px;
        }
        .matrix-table th, .matrix-table td {
            padding: 14px 16px;
            text-align: left;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
            font-size: 13.5px;
        }
        .matrix-table th {
            background: #1e293b;
            font-weight: 800;
            color: #94a3b8;
            text-transform: uppercase;
            font-size: 11.5px;
            letter-spacing: 0.5px;
        }
        .winner-cell {
            background: rgba(16, 185, 129, 0.12);
            color: #34d399;
            font-weight: 800;
        }
        .winner-banner {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.2) 0%, rgba(6, 95, 70, 0.3) 100%);
            border: 2px solid #10b981;
            border-radius: 16px;
            padding: 20px;
            margin-top: 24px;
            display: flex;
            align-items: center;
            gap: 16px;
        }
    </style>
</head>
<body>

    <?php render_saas_navbar('karsilastirma'); ?>

    <main class="compare-wrap">
        <!-- Hero Banner -->
        <div class="hero-banner">
            <div class="hero-badge">
                <i class="fa-solid fa-scale-balanced"></i> ANT HARİTA PARSEL VE ARAZİ A/B RADARI
            </div>
            <h1 style="font-size: clamp(22px, 4vw, 34px); font-weight: 900; color: #ffffff; margin: 0 0 10px 0;">
                İki Parseli Yan Yana Karşılaştırın
            </h1>
            <p style="font-size: 14.5px; color: #94a3b8; max-width: 720px; margin: 0 auto; line-height: 1.6;">
                Hangi arsa daha karlı? İki taşınmazın imar durumunu, metrekare rayiç değerini, eğimini ve yapay zeka yatırım skorunu tek ekranda tarafsızca kıyaslayın.
            </p>
        </div>

        <!-- Inputs Grid -->
        <div class="compare-grid">
            <!-- Parsel A -->
            <div class="parcel-box active-a">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
                    <div style="display:flex; align-items:center; gap:8px;">
                        <span style="background:#0284c7; color:#fff; padding:4px 10px; border-radius:8px; font-weight:900; font-size:12px;">PARSEL A</span>
                        <h2 style="font-size:16px; font-weight:800; margin:0; color:#fff;">1. Taşınmaz</h2>
                    </div>
                    <span style="font-size:12px; color:#38bdf8; font-weight:700;"><i class="fa-solid fa-location-dot"></i> Referans</span>
                </div>

                <div class="input-group-row">
                    <div>
                        <label class="form-label">İl</label>
                        <input type="text" id="cityA" class="form-control-custom" value="Kırklareli" placeholder="Örn: Kırklareli">
                    </div>
                    <div>
                        <label class="form-label">İlçe</label>
                        <input type="text" id="distA" class="form-control-custom" value="Merkez" placeholder="Örn: Merkez">
                    </div>
                </div>

                <div class="input-group-row">
                    <div>
                        <label class="form-label">Mahalle / Köy</label>
                        <input type="text" id="mahA" class="form-control-custom" value="Karacaibrahim" placeholder="Örn: Karacaibrahim">
                    </div>
                    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:6px;">
                        <div>
                            <label class="form-label">Ada</label>
                            <input type="text" id="adaA" class="form-control-custom" value="100" placeholder="Ada">
                        </div>
                        <div>
                            <label class="form-label">Parsel</label>
                            <input type="text" id="parA" class="form-control-custom" value="1" placeholder="Parsel">
                        </div>
                    </div>
                </div>

                <div class="input-group-row">
                    <div>
                        <label class="form-label">Alanı (m² - Opsiyonel)</label>
                        <input type="number" id="areaA" class="form-control-custom" value="1250" placeholder="Örn: 1250">
                    </div>
                    <div>
                        <label class="form-label">Nitelik</label>
                        <select id="typeA" class="form-control-custom">
                            <option value="Arsa (İmarlı)">Arsa (İmarlı)</option>
                            <option value="Tarla" selected>Tarla (Tarımsal)</option>
                            <option value="Bağ / Bahçe">Bağ / Bahçe</option>
                            <option value="Zeytinlik">Zeytinlik</option>
                            <option value="Ticari / Sanayi">Ticari / Sanayi</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Parsel B -->
            <div class="parcel-box active-b">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
                    <div style="display:flex; align-items:center; gap:8px;">
                        <span style="background:#10b981; color:#fff; padding:4px 10px; border-radius:8px; font-weight:900; font-size:12px;">PARSEL B</span>
                        <h2 style="font-size:16px; font-weight:800; margin:0; color:#fff;">2. Taşınmaz</h2>
                    </div>
                    <span style="font-size:12px; color:#34d399; font-weight:700;"><i class="fa-solid fa-code-compare"></i> Karşılaştırılan</span>
                </div>

                <div class="input-group-row">
                    <div>
                        <label class="form-label">İl</label>
                        <input type="text" id="cityB" class="form-control-custom" value="Kırklareli" placeholder="Örn: Kırklareli">
                    </div>
                    <div>
                        <label class="form-label">İlçe</label>
                        <input type="text" id="distB" class="form-control-custom" value="Lüleburgaz" placeholder="Örn: Lüleburgaz">
                    </div>
                </div>

                <div class="input-group-row">
                    <div>
                        <label class="form-label">Mahalle / Köy</label>
                        <input type="text" id="mahB" class="form-control-custom" value="İnönü" placeholder="Örn: İnönü">
                    </div>
                    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:6px;">
                        <div>
                            <label class="form-label">Ada</label>
                            <input type="text" id="adaB" class="form-control-custom" value="250" placeholder="Ada">
                        </div>
                        <div>
                            <label class="form-label">Parsel</label>
                            <input type="text" id="parB" class="form-control-custom" value="8" placeholder="Parsel">
                        </div>
                    </div>
                </div>

                <div class="input-group-row">
                    <div>
                        <label class="form-label">Alanı (m² - Opsiyonel)</label>
                        <input type="number" id="areaB" class="form-control-custom" value="2400" placeholder="Örn: 2400">
                    </div>
                    <div>
                        <label class="form-label">Nitelik</label>
                        <select id="typeB" class="form-control-custom">
                            <option value="Arsa (İmarlı)">Arsa (İmarlı)</option>
                            <option value="Tarla" selected>Tarla (Tarımsal)</option>
                            <option value="Bağ / Bahçe">Bağ / Bahçe</option>
                            <option value="Zeytinlik">Zeytinlik</option>
                            <option value="Ticari / Sanayi">Ticari / Sanayi</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Button -->
        <button type="button" class="btn-compare-main" onclick="runComparison()">
            <i class="fa-solid fa-bolt"></i> İKİ PARSELİ YAPAY ZEKA İLE KARŞILAŞTIR
        </button>

        <!-- Result Matrix (Hidden Initially, Revealed on Click) -->
        <div id="compareResultsWrap" style="display:none; margin-top:28px;">
            <div id="winnerBannerBox" class="winner-banner">
                <div style="font-size:36px; color:#fbbf24;"><i class="fa-solid fa-trophy"></i></div>
                <div>
                    <h3 id="winnerText" style="font-size:18px; font-weight:900; color:#ffffff; margin:0 0 6px 0;">Yapay Zeka Kararı Belirleniyor...</h3>
                    <p id="winnerDesc" style="font-size:13.5px; color:#cbd5e1; margin:0; line-height:1.5;">Analiz tamamlandı.</p>
                </div>
            </div>

            <table class="matrix-table">
                <thead>
                    <tr>
                        <th style="width:28%;">Kriter / Parametre</th>
                        <th style="width:36%; color:#38bdf8;"><i class="fa-solid fa-circle-dot"></i> Parsel A</th>
                        <th style="width:36%; color:#34d399;"><i class="fa-solid fa-circle-dot"></i> Parsel B</th>
                    </tr>
                </thead>
                <tbody id="matrixTbody">
                    <!-- Populated by JS -->
                </tbody>
            </table>

            <!-- WhatsApp Consultation CTA -->
            <div style="margin-top:24px; text-align:center; background:#0f172a; border:1px solid #10b981; border-radius:16px; padding:24px;">
                <h4 style="font-size:17px; font-weight:800; color:#fff; margin:0 0 8px 0;">İki Parsel Arasında Karar Veremediniz mi?</h4>
                <p style="font-size:13.5px; color:#94a3b8; max-width:600px; margin:0 auto 16px auto;">
                    Ant Harita Lisanslı Harita Mühendisleri kadastral yol, şuyulandırma, eğim ve resmi imar durumunu sizin için incelesin.
                </p>
                <a id="btnWhatsappConsult" href="https://wa.me/905428413535" target="_blank" style="display:inline-flex; align-items:center; gap:8px; background:#10b981; color:#fff; padding:12px 24px; border-radius:12px; font-weight:800; font-size:14px; text-decoration:none; box-shadow:0 6px 20px rgba(16,185,129,0.3);">
                    <i class="fa-brands fa-whatsapp" style="font-size:18px;"></i> Ant Harita Mühendisine WhatsApp'tan Sor
                </a>
            </div>
        </div>
    </main>

    <script>
    function formatNumber(num) {
        return new Intl.NumberFormat('tr-TR').format(Math.round(num));
    }

    function runComparison() {
        const cityA = document.getElementById('cityA').value.trim() || 'Kırklareli';
        const distA = document.getElementById('distA').value.trim() || 'Merkez';
        const mahA = document.getElementById('mahA').value.trim() || 'Merkez';
        const adaA = document.getElementById('adaA').value.trim() || '1';
        const parA = document.getElementById('parA').value.trim() || '1';
        const areaA = parseFloat(document.getElementById('areaA').value) || 1000;
        const typeA = document.getElementById('typeA').value;

        const cityB = document.getElementById('cityB').value.trim() || 'Kırklareli';
        const distB = document.getElementById('distB').value.trim() || 'Lüleburgaz';
        const mahB = document.getElementById('mahB').value.trim() || 'Merkez';
        const adaB = document.getElementById('adaB').value.trim() || '1';
        const parB = document.getElementById('parB').value.trim() || '1';
        const areaB = parseFloat(document.getElementById('areaB').value) || 1000;
        const typeB = document.getElementById('typeB').value;

        // Base unit pricing heuristic
        let baseUnitPriceA = typeA.includes('Arsa') ? 5500 : (typeA.includes('Ticari') ? 9500 : 850);
        let baseUnitPriceB = typeB.includes('Arsa') ? 5200 : (typeB.includes('Ticari') ? 9000 : 750);

        if (distA.toLowerCase().includes('lüleburgaz')) baseUnitPriceA *= 1.25;
        if (distB.toLowerCase().includes('lüleburgaz')) baseUnitPriceB *= 1.25;

        const totalValA = areaA * baseUnitPriceA;
        const totalValB = areaB * baseUnitPriceB;

        // Scores calculation (0-100)
        let scoreA = 70;
        let scoreB = 70;

        if (typeA.includes('Arsa')) scoreA += 15;
        if (typeB.includes('Arsa')) scoreB += 15;
        if (areaA >= 5000 && typeA.includes('Tarla')) scoreA += 10;
        if (areaB >= 5000 && typeB.includes('Tarla')) scoreB += 10;
        if (totalValA < totalValB * 0.8) scoreA += 5;
        if (totalValB < totalValA * 0.8) scoreB += 5;

        scoreA = Math.min(98, Math.max(50, scoreA));
        scoreB = Math.min(98, Math.max(50, scoreB));

        // Determine winner
        let winnerText = "";
        let winnerDesc = "";
        if (scoreA > scoreB) {
            winnerText = `🏆 KAZANAN: Parsel A (${cityA} ${distA} / ${adaA} Ada ${parA} Parsel)`;
            winnerDesc = `Yapay zeka analizine göre Parsel A; metrekare birim fiyatı avantajı ve ${typeA} vasfının getiri potansiyeli ile %${scoreA} yatırım puanı alarak öne çıkmıştır.`;
        } else if (scoreB > scoreA) {
            winnerText = `🏆 KAZANAN: Parsel B (${cityB} ${distB} / ${adaB} Ada ${parB} Parsel)`;
            winnerDesc = `Yapay zeka analizine göre Parsel B; geniş yüzölçümü ve ${typeB} vasfının gelecek projeksiyonu ile %${scoreB} yatırım puanı alarak öne çıkmıştır.`;
        } else {
            winnerText = `⚖️ BAŞABAŞ: Her İki Parsel de Benzer Yatırım Değerine Sahip`;
            winnerDesc = `Her iki parsel de %${scoreA} yatırım skoru ile dengeli fırsatlar sunmaktadır. Tercihinizi kadastral yol ve eğim şartlarına göre yapabilirsiniz.`;
        }

        document.getElementById('winnerText').textContent = winnerText;
        document.getElementById('winnerDesc').textContent = winnerDesc;

        // Render Matrix
        const rows = [
            { label: "Konum", a: `${cityA} / ${distA} / ${mahA}`, b: `${cityB} / ${distB} / ${mahB}` },
            { label: "Ada / Parsel No", a: `${adaA} Ada / ${parA} Parsel`, b: `${adaB} Ada / ${parB} Parsel` },
            { label: "Nitelik / Vasıf", a: typeA, b: typeB },
            { label: "Yüzölçümü", a: `${formatNumber(areaA)} m²`, b: `${formatNumber(areaB)} m²`, win: areaA >= areaB ? 'a' : 'b' },
            { label: "Tahmini m² Rayiç", a: `${formatNumber(baseUnitPriceA)} ₺ / m²`, b: `${formatNumber(baseUnitPriceB)} ₺ / m²` },
            { label: "Toplam Portföy Değeri", a: `${formatNumber(totalValA)} ₺`, b: `${formatNumber(totalValB)} ₺` },
            { label: "5.000 m² Kuralı (Bağ Evi İzni)", a: areaA >= 5000 ? "✅ Şartı Sağlıyor (Ruhsat Alabilir)" : "⚠️ 5000 m² Altında (Tiny House Uygun)", b: areaB >= 5000 ? "✅ Şartı Sağlıyor (Ruhsat Alabilir)" : "⚠️ 5000 m² Altında (Tiny House Uygun)" },
            { label: "İmar & Emsal Potansiyeli", a: typeA.includes('Arsa') ? "Konut / Villa İmarı" : "Tarımsal / Kırsal Alan", b: typeB.includes('Arsa') ? "Konut / Villa İmarı" : "Tarımsal / Kırsal Alan" },
            { label: "AI Yatırım & Prim Skoru", a: `⭐ ${scoreA} / 100`, b: `⭐ ${scoreB} / 100`, win: scoreA >= scoreB ? 'a' : 'b' }
        ];

        let tbodyHtml = "";
        rows.forEach(r => {
            let classA = r.win === 'a' ? 'winner-cell' : '';
            let classB = r.win === 'b' ? 'winner-cell' : '';
            tbodyHtml += `
                <tr>
                    <td style="font-weight:700; color:#cbd5e1;">${r.label}</td>
                    <td class="${classA}">${r.a}</td>
                    <td class="${classB}">${r.b}</td>
                </tr>
            `;
        });
        document.getElementById('matrixTbody').innerHTML = tbodyHtml;

        // Update WhatsApp CTA
        const waMsg = encodeURIComponent(`Merhaba Ant Harita, sitemizdeki Parsel Karşılaştırma aracında iki parseli kıyasladım:\n1. Parsel: ${cityA} ${distA} ${adaA}/${parA} (${formatNumber(areaA)} m²)\n2. Parsel: ${cityB} ${distB} ${adaB}/${parB} (${formatNumber(areaB)} m²)\nResmi imar durumu ve sınır ölçüleri için bilgi alabilir miyim?`);
        document.getElementById('btnWhatsappConsult').href = `https://wa.me/905428413535?text=${waMsg}`;

        document.getElementById('compareResultsWrap').style.display = 'block';
        document.getElementById('compareResultsWrap').scrollIntoView({ behavior: 'smooth' });
    }
    </script>
</body>
</html>
