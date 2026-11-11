<?php
/**
 * ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ - PARSEL PRO
 * MODÜL 1: ARSADAN KAÇ DAİRE ÇIKAR? (MÜTEAHHİT & KAT KARŞILIĞI SİMÜLATÖRÜ)
 * URL: https://www.parselsorgu.net/arsa-daire-hesaplama
 */
declare(strict_types=1);

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/navbar.php';

$page_title = "Arsamdan Kaç Daire Çıkar? Kat Karşılığı 2026 | ParselSorgu";
$meta_desc = "Arsa m², TAKS ve KAKS oranına göre toplam inşaat alanı, çıkabilecek daire sayısı ve müteahhit/arsa sahibi payını anında hesaplayın.";
$canonical_url = "https://www.parselsorgu.net/arsa-daire-hesaplama";

$json_ld = [
    "@context" => "https://schema.org",
    "@graph" => [
        [
            "@type" => "BreadcrumbList",
            "itemListElement" => [
                ["@type" => "ListItem", "position" => 1, "name" => "Ana Sayfa", "item" => "https://www.parselsorgu.net"],
                ["@type" => "ListItem", "position" => 2, "name" => "Hesaplama Araçları", "item" => "https://www.parselsorgu.net/hesaplama"],
                ["@type" => "ListItem", "position" => 3, "name" => "Arsadan Kaç Daire Çıkar?", "item" => $canonical_url]
            ]
        ],
        [
            "@type" => "SoftwareApplication",
            "name" => "Arsa Kat Karşılığı & Daire Simülatörü",
            "operatingSystem" => "All",
            "applicationCategory" => "BusinessApplication",
            "offers" => ["@type" => "Offer", "price" => "0", "priceCurrency" => "TRY"]
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

    <!-- Fonts, Leaflet & Icons -->
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
        .calc-container { max-width: 1100px; margin: 0 auto; padding: 24px 16px 80px 16px; }
        .calc-hero { background: linear-gradient(135deg, rgba(15,23,42,0.98) 0%, rgba(30,41,59,0.95) 100%); border: 2px solid #0284c7; border-radius: 16px; padding: 28px; margin-bottom: 24px; box-shadow: 0 10px 40px rgba(2,132,199,0.18); }
        .calc-grid { display: grid; grid-template-columns: 1.1fr 1fr; gap: 20px; margin-bottom: 30px; }
        .panel-box { background: var(--card-dark); border: 1px solid var(--border-dark); border-radius: 14px; padding: 24px; box-shadow: 0 10px 30px rgba(0,0,0,0.3); }
        .form-group { margin-bottom: 16px; }
        .form-label { display: flex; justify-content: space-between; font-size: 12px; font-weight: 700; color: #94a3b8; margin-bottom: 6px; }
        .form-input, .form-select { width: 100%; background: #070b14; border: 1px solid #334155; border-radius: 8px; padding: 11px 14px; color: #fff; font-size: 13.5px; box-sizing: border-box; font-family: inherit; transition: border-color 0.2s; }
        .form-input:focus, .form-select:focus { outline: none; border-color: #38bdf8; }
        .result-card { background: linear-gradient(135deg, rgba(2,132,199,0.15) 0%, rgba(15,23,42,0.9) 100%); border: 1px solid rgba(56,189,248,0.35); border-radius: 12px; padding: 18px; margin-bottom: 12px; }
        .res-num { font-size: 28px; font-weight: 900; color: #38bdf8; margin: 4px 0; }
        .res-lbl { font-size: 11.5px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px; }
        .split-bar { display: flex; height: 16px; border-radius: 8px; overflow: hidden; margin: 12px 0; }
        .split-owner { background: #22c55e; }
        .split-builder { background: #0284c7; }
        @media (max-width: 860px) {
            .calc-grid { grid-template-columns: 1fr; }
            .calc-hero { padding: 20px 16px; }
        }
    </style>
    <script type="application/ld+json">{"@context": "https://schema.org", "@type": "FAQPage", "mainEntity": [{"@type": "Question", "name": "Kat karşılığı inşaatta arsa sahibine yüzde kaç daire düşer?", "acceptedAnswer": {"@type": "Answer", "text": "Türkiye genelinde arsa payı ve kat karşılığı inşaat sözleşmelerinde arsa sahibine düşen oran bölgenin arsa m² rayicine bağlı olarak ortalama %35 ile %50 arasında belirlenir."}}, {"@type": "Question", "name": "TAKS ve KAKS (Emsal) ile toplam kaç daire çıkacağı nasıl hesaplanır?", "acceptedAnswer": {"@type": "Answer", "text": "Arsa m² alanı ile KAKS (Emsal) çarpılarak toplam inşaat alanı bulunur; ortak alan payı (~%20-%25) düşüldükten sonra brüt daire büyüklüğüne bölünerek toplam daire adedi hesaplanır."}}]}</script>
    <link rel="alternate" type="text/markdown" href="https://www.parselsorgu.net/llms.txt" title="ParselSorgu AI / LLM Bilgi Bankası">
    <link rel="alternate" type="application/json" href="https://www.parselsorgu.net/api/2026-kadastro-endeks.json" title="2026 Kadastro ve İmar Açık Veri Seti">
    <script type="application/ld+json">{"@context": "https://schema.org", "@type": "WebPage", "speakable": {"@type": "SpeakableSpecification", "cssSelector": ["h1", ".lead", ".summary-box", ".hero-desc", "main p"]}, "isBasedOn": "https://www.parselsorgu.net/api/2026-kadastro-endeks.json", "publisher": {"@type": "Organization", "name": "Ant Harita Mühendislik - ParselSorgu.net", "url": "https://www.parselsorgu.net/"}}</script>
</head>
<body>

    <?php render_saas_navbar('hesaplama'); ?>

    <main class="calc-container">
        <!-- Hero Header -->
        <section class="calc-hero">
            <div style="display:inline-flex; align-items:center; gap:8px; margin-bottom:10px;">
                <span style="background:rgba(2,132,199,0.2); border:1px solid #0284c7; color:#38bdf8; font-size:11px; font-weight:800; padding:4px 10px; border-radius:4px;">
                    <i class="fa-solid fa-city"></i> İMAR &amp; MÜTEAHHİT SİMÜLATÖRÜ
                </span>
                <span style="background:rgba(34,197,94,0.2); border:1px solid #22c55e; color:#4ade80; font-size:11px; font-weight:800; padding:4px 10px; border-radius:4px;">
                    2026 ÇŞİDB BİRİM FİYATLARI
                </span>
            </div>
            <h1 style="font-size:clamp(1.4rem, 2.8vw, 2rem); font-weight:900; color:#fff; margin:0 0 10px 0;">
                Arsamdan Kaç Daire Çıkar? Kat Karşılığı Hesaplama
            </h1>
            <p style="font-size:14px; color:#cbd5e1; margin:0; line-height:1.6; max-width:850px;">
                Arsanızın m² büyüklüğü, taban oturumu (TAKS) ve emsal (KAKS) oranını girerek toplam inşaat alanını, kaç daire çıkacağını ve müteahhit ile arsa sahibi arasındaki daire paylaşımını saniyeler içinde hesaplayın.
            </p>
        </section>

        <!-- Calculator Form & Output Grid -->
        <div class="calc-grid">
            <!-- Form Input Panel -->
            <div class="panel-box">
                <h2 style="font-size:16px; font-weight:800; color:#fff; margin:0 0 18px 0; display:flex; align-items:center; gap:8px;">
                    <i class="fa-solid fa-sliders" style="color:#38bdf8;"></i> Arsa &amp; İmar Parametreleri
                </h2>

                <div class="form-group">
                    <div class="form-label">
                        <span>Arsa Büyüklüğü (m²)</span>
                        <span style="color:#38bdf8;" id="lbl-area">800 m²</span>
                    </div>
                    <input type="number" id="inp-area" class="form-input" value="800" min="50" max="100000" step="10" oninput="runDaireCalc()">
                </div>

                <div style="display:grid; grid-template-columns: 1fr 1fr; gap:12px;">
                    <div class="form-group">
                        <div class="form-label">
                            <span>KAKS / Emsal Oranı</span>
                            <span style="color:#38bdf8;" id="lbl-kaks">1.50</span>
                        </div>
                        <input type="number" id="inp-kaks" class="form-input" value="1.50" min="0.20" max="4.00" step="0.05" oninput="runDaireCalc()">
                    </div>
                    <div class="form-group">
                        <div class="form-label">
                            <span>TAKS (Taban Katsayısı)</span>
                            <span style="color:#38bdf8;" id="lbl-taks">0.30</span>
                        </div>
                        <input type="number" id="inp-taks" class="form-input" value="0.30" min="0.10" max="0.60" step="0.05" oninput="runDaireCalc()">
                    </div>
                </div>

                <div style="display:grid; grid-template-columns: 1fr 1fr; gap:12px;">
                    <div class="form-group">
                        <div class="form-label">
                            <span>Ortalama Daire Tipi</span>
                        </div>
                        <select id="inp-apt-type" class="form-select" onchange="runDaireCalc()">
                            <option value="120">3+1 Daire (~120 m² Brüt)</option>
                            <option value="85">2+1 Daire (~85 m² Brüt)</option>
                            <option value="55">1+1 Daire (~55 m² Brüt)</option>
                            <option value="160">4+1 Daire (~160 m² Brüt)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <div class="form-label">
                            <span>Müteahhit Paylaşım Oranı</span>
                            <span style="color:#22c55e;" id="lbl-share">%50 - %50</span>
                        </div>
                        <select id="inp-share" class="form-select" onchange="runDaireCalc()">
                            <option value="0.50">%50 Arsa Sahibi / %50 Müteahhit (Standart)</option>
                            <option value="0.45">%45 Arsa Sahibi / %55 Müteahhit</option>
                            <option value="0.40">%40 Arsa Sahibi / %60 Müteahhit (Yüksek Maliyet)</option>
                            <option value="0.55">%55 Arsa Sahibi / %45 Müteahhit (Değerli Bölge)</option>
                            <option value="0.60">%60 Arsa Sahibi / %40 Müteahhit (Lüks Lokasyon)</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-label">
                        <span>Bölgesel m² Satış Fiyatı (Tahmini Ciro İçin)</span>
                        <span style="color:#facc15;" id="lbl-m2-price">45.000 TL/m²</span>
                    </div>
                    <input type="number" id="inp-m2-price" class="form-input" value="45000" min="10000" max="500000" step="1000" oninput="runDaireCalc()">
                </div>

                <button type="button" onclick="shareSimResultWhatsApp()" style="width:100%; background:linear-gradient(135deg, #25d366 0%, #128c7e 100%); color:#fff; border:none; padding:13px; border-radius:10px; font-size:14px; font-weight:900; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:8px; box-shadow:0 6px 20px rgba(37,211,102,0.35); margin-top:8px;">
                    <i class="fa-brands fa-whatsapp" style="font-size:18px;"></i> Bu Analiz Raporunu WhatsApp'ta Paylaş
                </button>
            </div>

            <!-- Realtime Output Panel -->
            <div class="panel-box" style="border-color:rgba(2,132,199,0.4);">
                <h2 style="font-size:16px; font-weight:800; color:#fff; margin:0 0 16px 0; display:flex; align-items:center; gap:8px;">
                    <i class="fa-solid fa-chart-pie" style="color:#22c55e;"></i> Simülasyon Çıktısı
                </h2>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:12px;">
                    <div class="result-card">
                        <div class="res-lbl">Emsal İnşaat Alanı</div>
                        <div class="res-num" id="out-emsal-area">1.200 m²</div>
                        <div style="font-size:11px; color:#94a3b8;">Arsa x KAKS Hesabı</div>
                    </div>
                    <div class="result-card">
                        <div class="res-lbl">Toplam Brüt İnşaat</div>
                        <div class="res-num" style="color:#4ade80;" id="out-gross-area">1.560 m²</div>
                        <div style="font-size:11px; color:#94a3b8;">Otopark &amp; Ortak Alan Dahil</div>
                    </div>
                </div>

                <div class="result-card" style="background:rgba(15,23,42,0.95); border-color:#0284c7;">
                    <div style="display:flex; justify-content:space-between; align-items:baseline;">
                        <div>
                            <div class="res-lbl">Toplam Bağımsız Bölüm (Daire)</div>
                            <div class="res-num" style="font-size:36px; color:#38bdf8;" id="out-total-apts">10 Daire</div>
                        </div>
                        <div style="text-align:right;">
                            <div class="res-lbl">Taban Oturumu (Zemin)</div>
                            <div style="font-size:18px; font-weight:800; color:#f8fafc;" id="out-taban-area">240 m²</div>
                        </div>
                    </div>

                    <!-- Visual Split Bar -->
                    <div style="margin-top:14px;">
                        <div style="display:flex; justify-content:space-between; font-size:12px; font-weight:800;">
                            <span style="color:#22c55e;"><i class="fa-solid fa-user-check"></i> Arsa Sahibi: <span id="out-owner-apts">5 Daire</span></span>
                            <span style="color:#38bdf8;"><i class="fa-solid fa-helmet-safety"></i> Müteahhit: <span id="out-builder-apts">5 Daire</span></span>
                        </div>
                        <div class="split-bar">
                            <div id="bar-owner" class="split-owner" style="width:50%;"></div>
                            <div id="bar-builder" class="split-builder" style="width:50%;"></div>
                        </div>
                    </div>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-top:12px;">
                    <div style="background:#070b14; border:1px solid #1e293b; border-radius:10px; padding:12px;">
                        <div style="font-size:11px; color:#94a3b8; font-weight:700;">2026 İnşaat Maliyeti (3B Grubu)</div>
                        <div style="font-size:17px; font-weight:800; color:#f87171; margin-top:2px;" id="out-cost">~38.2 Milyon TL</div>
                    </div>
                    <div style="background:#070b14; border:1px solid #1e293b; border-radius:10px; padding:12px;">
                        <div style="font-size:11px; color:#94a3b8; font-weight:700;">Tahmini Proje Toplam Satış Ciro</div>
                        <div style="font-size:17px; font-weight:800; color:#facc15; margin-top:2px;" id="out-revenue">~70.2 Milyon TL</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hukuki ve Teknik Açıklama -->
        <section style="background:#0f172a; border:1px solid #1e293b; border-radius:12px; padding:22px; font-size:13px; color:#cbd5e1; line-height:1.7;">
            <h3 style="font-size:15px; font-weight:800; color:#fff; margin:0 0 8px 0;"><i class="fa-solid fa-circle-info" style="color:#38bdf8;"></i> Kat Karşılığı İnşaat Sözleşmesi Notları</h3>
            <p style="margin:0 0 10px 0;">3194 Sayılı İmar Kanunu ve Planlı Alanlar İmar Yönetmeliği gereğince, emsale dahil olmayan asansör boşluğu, yangın merdiveni, otopark ve sığınak alanları yaklaşık %25-30 ilave brüt inşaat hacmi oluşturur.</p>
            <p style="margin:0;">Müteahhit ile sözleşme imzalamadan önce arsanızın resmi imar durum belgesini belediyeden almanız ve noter onaylı kat karşılığı inşaat vaadi sözleşmesinde cezai şartları ve teslim sürelerini netleştirmeniz tavsiye edilir.</p>
        </section>
    </main>

    <script>
    function runDaireCalc() {
        const area = parseFloat(document.getElementById('inp-area').value) || 0;
        const kaks = parseFloat(document.getElementById('inp-kaks').value) || 0;
        const taks = parseFloat(document.getElementById('inp-taks').value) || 0;
        const aptSize = parseFloat(document.getElementById('inp-apt-type').value) || 120;
        const shareRatio = parseFloat(document.getElementById('inp-share').value) || 0.50;
        const m2Price = parseFloat(document.getElementById('inp-m2-price').value) || 45000;

        document.getElementById('lbl-area').innerText = area.toLocaleString('tr-TR') + ' m²';
        document.getElementById('lbl-kaks').innerText = kaks.toFixed(2);
        document.getElementById('lbl-taks').innerText = taks.toFixed(2);
        document.getElementById('lbl-share').innerText = `%${Math.round(shareRatio*100)} - %${Math.round((1-shareRatio)*100)}`;
        document.getElementById('lbl-m2-price').innerText = m2Price.toLocaleString('tr-TR') + ' TL/m²';

        // Calculations
        const emsalArea = area * kaks;
        const grossArea = emsalArea * 1.30; // +30% for balconies, stairs, elevator, common areas
        const tabanArea = area * taks;
        const totalApts = Math.floor(emsalArea / aptSize) || 1;

        const ownerApts = Math.round(totalApts * shareRatio);
        const builderApts = totalApts - ownerApts;

        // Cost estimation (2026 ÇŞİDB ~24.500 TL/m² average III-B residential group)
        const unitCost = 24500;
        const totalCost = grossArea * unitCost;
        const totalRevenue = grossArea * m2Price;

        // Render Outputs
        document.getElementById('out-emsal-area').innerText = Math.round(emsalArea).toLocaleString('tr-TR') + ' m²';
        document.getElementById('out-gross-area').innerText = Math.round(grossArea).toLocaleString('tr-TR') + ' m²';
        document.getElementById('out-taban-area').innerText = Math.round(tabanArea).toLocaleString('tr-TR') + ' m²';
        document.getElementById('out-total-apts').innerText = totalApts + ' Daire';
        document.getElementById('out-owner-apts').innerText = ownerApts + ' Daire';
        document.getElementById('out-builder-apts').innerText = builderApts + ' Daire';

        document.getElementById('bar-owner').style.width = (shareRatio * 100) + '%';
        document.getElementById('bar-builder').style.width = ((1 - shareRatio) * 100) + '%';

        document.getElementById('out-cost').innerText = '~' + (totalCost / 1000000).toFixed(1) + ' Milyon TL';
        document.getElementById('out-revenue').innerText = '~' + (totalRevenue / 1000000).toFixed(1) + ' Milyon TL';
    }

    function shareSimResultWhatsApp() {
        const area = document.getElementById('inp-area').value;
        const kaks = document.getElementById('inp-kaks').value;
        const total = document.getElementById('out-total-apts').innerText;
        const owner = document.getElementById('out-owner-apts').innerText;
        const builder = document.getElementById('out-builder-apts').innerText;
        const ciro = document.getElementById('out-revenue').innerText;

        const text = `🏗️ *${area} m² Arsa Kat Karşılığı Simülasyon Raporu:*\n📐 Emsal: *${kaks}*\n🏢 Toplam Çıkan Daire: *${total}*\n🤝 Paylaşım: *Arsa Sahibi: ${owner} | Müteahhit: ${builder}*\n💰 Tahmini Proje Cirosu: *${ciro}*\n⚡ Canlı hesaplayıcıyı inceleyin:\n👉 https://www.parselsorgu.net/arsa-daire-hesaplama`;
        window.open('https://api.whatsapp.com/send?text=' + encodeURIComponent(text), '_blank');
    }

    // Run initial on load
    runDaireCalc();
    </script>
    <script src="/analytics.js?v=2026.1" defer></script>
</body>
</html>
