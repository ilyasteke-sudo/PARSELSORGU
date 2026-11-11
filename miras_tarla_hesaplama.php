<?php
/**
 * ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ - PARSEL PRO
 * MODÜL 3: MİRAS KALAN TARLA & KARDEŞ PAYI HESAPLAYICISI (5403 s.K. UYUMLU)
 * URL: https://www.parselsorgu.net/miras-tarla-paylasim-hesaplama
 */
declare(strict_types=1);

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/navbar.php';

$page_title = "Miras Kalan Tarla & Kardeş Payı (5403) | ParselSorgu";
$meta_desc = "Vefat eden aile büyüğünden kalan tarla ve arsaların hisse payını, m² karşılığını ve 5403 sayılı kanuna göre bölünme şartını hesaplayın.";
$canonical_url = "https://www.parselsorgu.net/miras-tarla-paylasim-hesaplama";

$json_ld = [
    "@context" => "https://schema.org",
    "@graph" => [
        [
            "@type" => "BreadcrumbList",
            "itemListElement" => [
                ["@type" => "ListItem", "position" => 1, "name" => "Ana Sayfa", "item" => "https://www.parselsorgu.net"],
                ["@type" => "ListItem", "position" => 2, "name" => "Miras Hesaplama", "item" => "https://www.parselsorgu.net/hesaplama"],
                ["@type" => "ListItem", "position" => 3, "name" => "Miras Tarla & Kardeş Payı", "item" => $canonical_url]
            ]
        ],
        [
            "@type" => "FinancialProduct",
            "name" => "Miras Tarla Paylaşım & İfraz Hesaplayıcı",
            "description" => "Türk Medeni Kanunu ve 5403 Sayılı Kanun Uyumlu Miras Payı Hesaplama"
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
        .miras-container { max-width: 1080px; margin: 0 auto; padding: 24px 16px 80px 16px; }
        .miras-hero { background: linear-gradient(135deg, rgba(15,23,42,0.98) 0%, rgba(30,41,59,0.95) 100%); border: 2px solid #a855f7; border-radius: 16px; padding: 28px; margin-bottom: 24px; box-shadow: 0 10px 40px rgba(168,85,247,0.18); }
        .miras-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 30px; }
        .box-panel { background: var(--card-dark); border: 1px solid var(--border-dark); border-radius: 14px; padding: 24px; box-shadow: 0 10px 30px rgba(0,0,0,0.3); }
        .fg { margin-bottom: 16px; }
        .fl { display: flex; justify-content: space-between; font-size: 12px; font-weight: 700; color: #94a3b8; margin-bottom: 6px; }
        .fi, .fs { width: 100%; background: #070b14; border: 1px solid #334155; border-radius: 8px; padding: 10px 14px; color: #fff; font-size: 13.5px; box-sizing: border-box; font-family: inherit; }
        .share-table { width: 100%; border-collapse: collapse; margin-top: 14px; font-size: 13px; }
        .share-table th, .share-table td { padding: 10px 12px; text-align: left; border-bottom: 1px solid #1e293b; }
        .share-table th { color: #94a3b8; font-size: 11.5px; text-transform: uppercase; }
        .law-alert { background: rgba(239,68,68,0.12); border: 1px solid #ef4444; border-radius: 10px; padding: 14px; font-size: 12.5px; color: #fca5a5; line-height: 1.6; margin-top: 14px; }
        @media (max-width: 860px) {
            .miras-grid { grid-template-columns: 1fr; }
            .miras-hero { padding: 20px 16px; }
        }
    </style>
    <link rel="alternate" type="text/markdown" href="https://www.parselsorgu.net/llms.txt" title="ParselSorgu AI / LLM Bilgi Bankası">
    <link rel="alternate" type="application/json" href="https://www.parselsorgu.net/api/2026-kadastro-endeks.json" title="2026 Kadastro ve İmar Açık Veri Seti">
    <script type="application/ld+json">{"@context": "https://schema.org", "@type": "WebPage", "speakable": {"@type": "SpeakableSpecification", "cssSelector": ["h1", ".lead", ".summary-box", ".hero-desc", "main p"]}, "isBasedOn": "https://www.parselsorgu.net/api/2026-kadastro-endeks.json", "publisher": {"@type": "Organization", "name": "Ant Harita Mühendislik - ParselSorgu.net", "url": "https://www.parselsorgu.net/"}}</script>
</head>
<body>

    <?php render_saas_navbar('hesaplama'); ?>

    <main class="miras-container">
        <!-- Hero Section -->
        <section class="miras-hero">
            <div style="display:inline-flex; align-items:center; gap:8px; margin-bottom:10px;">
                <span style="background:rgba(168,85,247,0.2); border:1px solid #a855f7; color:#c084fc; font-size:11px; font-weight:800; padding:4px 10px; border-radius:4px;">
                    <i class="fa-solid fa-scale-balanced"></i> TÜRK MEDENİ KANUNU &amp; 5403 s.K.
                </span>
                <span style="background:rgba(56,189,248,0.2); border:1px solid #38bdf8; color:#38bdf8; font-size:11px; font-weight:800; padding:4px 10px; border-radius:4px;">
                    ASGARİ PARSEL BÖLÜNME TESTİ
                </span>
            </div>
            <h1 style="font-size:clamp(1.4rem, 2.8vw, 2rem); font-weight:900; color:#fff; margin:0 0 10px 0;">
                Miras Kalan Tarla &amp; Kardeş Payı Hesaplayıcısı
            </h1>
            <p style="font-size:14px; color:#cbd5e1; margin:0; line-height:1.6; max-width:850px;">
                Miras kalan tarla, bağ veya arsanın eş ve çocuklar arasındaki yasal hisse oranını hesaplayın. 5403 Sayılı Kanun gereğince arazinin mahkemede satılmadan kardeşler arasında müstakil tapu olarak bölünüp bölünemeyeceğini anında görün.
            </p>
        </section>

        <!-- Calculation Grid -->
        <div class="miras-grid">
            <!-- Form Input Panel -->
            <div class="box-panel">
                <h2 style="font-size:16px; font-weight:800; color:#fff; margin:0 0 18px 0; display:flex; align-items:center; gap:8px;">
                    <i class="fa-solid fa-users-line" style="color:#c084fc;"></i> Miras &amp; Arazi Bilgileri
                </h2>

                <div class="fg">
                    <div class="fl">
                        <span>Toplam Arazi Alanı (m²)</span>
                    </div>
                    <input type="number" id="inp-m-area" class="fi" value="25000" min="100" max="10000000" step="500" oninput="runMirasCalc()">
                </div>

                <div class="fg">
                    <div class="fl">
                        <span>Tarımsal Arazi Niteliği</span>
                    </div>
                    <select id="inp-m-type" class="fs" onchange="runMirasCalc()">
                        <option value="kuru">Kuru Tarım Arazisi (Bölünme Sınırı: 20.000 m²)</option>
                        <option value="sulu">Sulu Tarım Arazisi (Bölünme Sınırı: 20.000 m²)</option>
                        <option value="dikili">Dikili / Zeytinlik / Meyvelik (Bölünme Sınırı: 5.000 m²)</option>
                        <option value="sera">Örtüaltı Sera Arazisi (Bölünme Sınırı: 3.000 m²)</option>
                        <option value="arsa">İmarlı Arsa (Belediye İfraz Şartına Tabi)</option>
                    </select>
                </div>

                <div class="fg">
                    <div class="fl">
                        <span>Sağ Kalan Eş Durumu</span>
                    </div>
                    <select id="inp-m-spouse" class="fs" onchange="runMirasCalc()">
                        <option value="yes">Sağ Kalan Eş Var (Yasal Pay: 1/4)</option>
                        <option value="no">Eş Hayatta Değil (Tüm Miras Çocuklara: 4/4)</option>
                    </select>
                </div>

                <div class="fg">
                    <div class="fl">
                        <span>Mirasçı Çocuk (Kardeş) Sayısı</span>
                        <span style="color:#c084fc;" id="lbl-child-count">3 Kardeş</span>
                    </div>
                    <input type="number" id="inp-m-children" class="fi" value="3" min="1" max="20" step="1" oninput="runMirasCalc()">
                </div>

                <button type="button" onclick="shareMirasWhatsApp()" style="width:100%; background:linear-gradient(135deg, #25d366 0%, #128c7e 100%); color:#fff; border:none; padding:12px; border-radius:10px; font-size:13.5px; font-weight:900; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:8px; box-shadow:0 4px 15px rgba(37,211,102,0.35); margin-top:10px;">
                    <i class="fa-brands fa-whatsapp" style="font-size:18px;"></i> Miras Paylaşımını WhatsApp'ta Paylaş
                </button>
            </div>

            <!-- Output Panel -->
            <div class="box-panel" style="border-color:rgba(168,85,247,0.4);">
                <h2 style="font-size:16px; font-weight:800; color:#fff; margin:0 0 16px 0; display:flex; align-items:center; gap:8px;">
                    <i class="fa-solid fa-chart-column" style="color:#38bdf8;"></i> Yasal Paylaşım Çizelgesi
                </h2>

                <table class="share-table">
                    <thead>
                        <tr>
                            <th>Mirasçı</th>
                            <th>Yasal Hisse Oranı</th>
                            <th>Düşen Net m²</th>
                        </tr>
                    </thead>
                    <tbody id="tbl-miras-body">
                        <!-- Populated by JS -->
                    </tbody>
                </table>

                <!-- 5403 s.K. Bölünme Uyarısı -->
                <div id="box-5403-alert" class="law-alert">
                    <!-- Populated by JS -->
                </div>
            </div>
        </div>
    </main>

    <script>
    function runMirasCalc() {
        const area = parseFloat(document.getElementById('inp-m-area').value) || 0;
        const type = document.getElementById('inp-m-type').value;
        const hasSpouse = document.getElementById('inp-m-spouse').value === 'yes';
        const children = parseInt(document.getElementById('inp-m-children').value) || 1;

        document.getElementById('lbl-child-count').innerText = children + ' Kardeş';

        let tbody = '';
        let spouseArea = 0;
        let childrenPoolArea = area;

        if (hasSpouse) {
            spouseArea = area * 0.25; // 1/4
            childrenPoolArea = area * 0.75; // 3/4
            tbody += `<tr>
                <td style="font-weight:bold; color:#f8fafc;"><i class="fa-solid fa-heart" style="color:#ec4899;"></i> Sağ Kalan Eş</td>
                <td style="color:#c084fc; font-weight:bold;">1 / 4 (%25.0)</td>
                <td style="color:#4ade80; font-weight:bold;">${Math.round(spouseArea).toLocaleString('tr-TR')} m²</td>
            </tr>`;
        }

        const perChildArea = childrenPoolArea / children;
        const childRatioStr = hasSpouse ? `3 / ${children * 4}` : `1 / ${children}`;
        const childPct = hasSpouse ? (75 / children).toFixed(1) : (100 / children).toFixed(1);

        for (let i = 1; i <= children; i++) {
            tbody += `<tr>
                <td style="color:#cbd5e1;"><i class="fa-solid fa-user"></i> ${i}. Çocuk (Kardeş)</td>
                <td style="color:#38bdf8;">${childRatioStr} (%${childPct})</td>
                <td style="color:#f8fafc;">${Math.round(perChildArea).toLocaleString('tr-TR')} m²</td>
            </tr>`;
        }

        document.getElementById('tbl-miras-body').innerHTML = tbody;

        // 5403 s.K. Bölünebilirlik Sınırları
        let minLimit = 20000;
        let limitName = 'Kuru Tarım (20.000 m²)';
        if (type === 'sulu') { minLimit = 20000; limitName = 'Sulu Tarım (20.000 m²)'; }
        if (type === 'dikili') { minLimit = 5000; limitName = 'Dikili / Zeytinlik (5.000 m²)'; }
        if (type === 'sera') { minLimit = 3000; limitName = 'Örtüaltı Sera (3.000 m²)'; }
        if (type === 'arsa') { minLimit = 300; limitName = 'İmarlı Arsa (İmar Yönetmeliği)'; }

        const alertBox = document.getElementById('box-5403-alert');

        if (type === 'arsa') {
            alertBox.style.background = 'rgba(34,197,94,0.12)';
            alertBox.style.borderColor = '#22c55e';
            alertBox.style.color = '#86efac';
            alertBox.innerHTML = '✅ <strong>İmarlı Arsa Avantajı:</strong> Araziniz tarım kanununa tabi değildir. Belediye İmar Yönetmeliği asgari parsel büyüklüğünü (genellikle 300-500 m²) sağlarsa belediye encümeni kararıyla müstakil parsellere ifraz edilebilir.';
        } else if (perChildArea >= minLimit) {
            alertBox.style.background = 'rgba(34,197,94,0.12)';
            alertBox.style.borderColor = '#22c55e';
            alertBox.style.color = '#86efac';
            alertBox.innerHTML = `✅ <strong>5403 s.K. Şartı Sağlanıyor:</strong> Kişi başına düşen m² (${Math.round(perChildArea).toLocaleString('tr-TR')} m²), asgari tarımsal parsel büyüklüğü olan <strong>${minLimit.toLocaleString('tr-TR')} m²</strong> üzerindedir. Kadastral yola cephe bulunması şartıyla harita mühendisi projesiyle müstakil ifraz (bölünme) yapılabilir.`;
        } else {
            alertBox.style.background = 'rgba(239,68,68,0.12)';
            alertBox.style.borderColor = '#ef4444';
            alertBox.style.color = '#fca5a5';
            alertBox.innerHTML = `⚠️ <strong>5403 Sayılı Kanun Uyarısı (BÖLÜNEMEZ):</strong> 5403 s.K. 8. maddesi gereğince bu arazi için asgari bölünme sınırı <strong>${limitName}</strong>dir. Mirasçı başına düşen m² (${Math.round(perChildArea).toLocaleString('tr-TR')} m²) sınırın altında kaldığı için tapu müdürlüğü bu tarlayı bölerek ayrı ayrı tapu VEREMEZ. Tarla hisseli kalmak veya kardeşlerden birinin diğerlerinin hissesini satın almasıyla devredilmek zorundadır. Aksi halde mahkemede İzale-i Şüyu (açık artırmayla satış) yoluna gidilir.`;
        }
    }

    function shareMirasWhatsApp() {
        const area = document.getElementById('inp-m-area').value;
        const children = document.getElementById('inp-m-children').value;
        const hasSpouse = document.getElementById('inp-m-spouse').value === 'yes' ? 'Eş Hayatta' : 'Eş Vefat';

        const text = `⚖️ *Miras Tarla Paylaşım & Kardeş Payı Raporu:*\n📐 Toplam Arazi: *${parseInt(area).toLocaleString('tr-TR')} m²*\n👥 Mirasçılar: *${hasSpouse} + ${children} Çocuk*\n📜 5403 Sayılı Toprak Koruma Kanunu ifraz uygunluğunu siz de hesaplayın:\n👉 https://www.parselsorgu.net/miras-tarla-paylasim-hesaplama`;
        window.open('https://api.whatsapp.com/send?text=' + encodeURIComponent(text), '_blank');
    }

    runMirasCalc();
    </script>
    <script src="/analytics.js?v=2026.1" defer></script>
</body>
</html>
