<?php
/**
 * ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ - PARSEL PRO
 * Yüzme Havuzu, Su Deposu & Peyzaj Maliyeti + 3194 İmar Ruhsatı Motoru
 */
require_once __DIR__ . '/navbar.php';

$page_title = "2026 Yüzme Havuzu ve Peyzaj Maliyeti | ParselSorgu";
$page_desc = "Betonarme veya prefabrik yüzme havuzu maliyeti 2026, bahçe peyzaj bütçesi ve Planlı Alanlar İmar Yönetmeliği ruhsat/TAKS muafiyeti analizi.";
$canonical_url = "https://www.parselsorgu.net/havuz-peyzaj-maliyet-hesaplama";
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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root { --bg:#0a0f1d; --card:#111827; --border:#1f2937; --accent:#06b6d4; --emerald:#10b981; --text:#f3f4f6; --muted:#9ca3af; }
        * { box-sizing:border-box; margin:0; padding:0; }
        body { background:var(--bg); color:var(--text); font-family:'Inter', sans-serif; line-height:1.6; padding-bottom:60px; }
        .container { max-width:1180px; margin:0 auto; padding:24px 16px; }
        .hero { text-align:center; padding:32px 16px 24px; }
        .hero-badge { display:inline-flex; align-items:center; gap:8px; background:rgba(6,182,212,0.15); color:var(--accent); padding:6px 14px; border-radius:9999px; font-size:13px; font-weight:700; margin-bottom:12px; border:1px solid rgba(6,182,212,0.3); }
        .hero h1 { font-size:30px; font-weight:800; color:#fff; margin-bottom:10px; }
        .hero h1 span { color:var(--accent); }
        .hero p { font-size:15px; color:var(--muted); max-width:760px; margin:0 auto; }
        .calc-grid { display:grid; grid-template-columns:1fr 1fr; gap:24px; margin-top:24px; }
        @media (max-width: 900px) { .calc-grid { grid-template-columns:1fr; } }
        .panel { background:var(--card); border:1px solid var(--border); border-radius:16px; padding:26px; box-shadow:0 10px 25px rgba(0,0,0,0.45); }
        .panel-title { font-size:18px; font-weight:700; color:#fff; margin-bottom:18px; display:flex; align-items:center; gap:10px; border-bottom:1px solid var(--border); padding-bottom:12px; }
        .form-group { margin-bottom:14px; }
        .form-group label { display:block; font-size:13px; font-weight:600; margin-bottom:6px; color:var(--text); }
        .form-group input, .form-group select { width:100%; padding:11px 14px; background:#1f2937; border:1px solid #374151; border-radius:10px; color:#fff; font-size:14px; outline:none; }
        .banner { background:#1a2234; border:1px solid #283548; border-radius:14px; padding:20px; text-align:center; margin-bottom:18px; }
        .banner-val { font-size:36px; font-weight:900; color:var(--accent); margin:6px 0; }
        .row { display:flex; justify-content:space-between; padding:10px 0; border-bottom:1px solid rgba(255,255,255,0.08); font-size:13.5px; }
    </style>
    <link rel="alternate" type="text/markdown" href="https://www.parselsorgu.net/llms.txt" title="ParselSorgu AI Knowledge Base">
    <link rel="alternate" type="application/json" href="https://www.parselsorgu.net/api/2026-kadastro-endeks.json" title="2026 Türkiye Kadastro ve İnşaat Açık Veri Seti">

    <script type="application/ld+json">
    {
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    {
      "@type": "Question",
      "name": "Bahçeye yüzme havuzu yapmak TAKS/KAKS emsal alanını doldurur mu?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Planlı Alanlar İmar Yönetmeliği Madde 22 uyarınca süs ve yüzme havuzları yapı inşaat alanı (emsal/KAKS) ve taban alanı (TAKS) hesabına dahil edilmez."
      }
    },
    {
      "@type": "Question",
      "name": "Havuz yapımında komşu sınıra çekme mesafesi var mıdır?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Evet, su yalıtımı ve komşu güvenliği açısından havuzların parsel sınırlarına ve bina temeline en az 2 metre çekilerek inşa edilmesi istenmektedir."
      }
    }
  ]
}
    </script>
    <script type="application/ld+json">{"@context": "https://schema.org", "@type": "WebPage", "speakable": {"@type": "SpeakableSpecification", "cssSelector": ["h1", ".lead", ".summary-box", ".hero-desc", "main p"]}, "isBasedOn": "https://www.parselsorgu.net/api/2026-kadastro-endeks.json", "publisher": {"@type": "Organization", "name": "Ant Harita Mühendislik - ParselSorgu.net", "url": "https://www.parselsorgu.net/"}}</script>
</head>
<body>
    <?= render_saas_navbar('maliyet') ?>
    <main class="container">
        <section class="hero">
            <div class="hero-badge"><i class="fa-solid fa-water-ladder"></i> 2026 Villa Havuzu &amp; Planlı Alanlar İmar Mevzuatı</div>
            <h1>Yüzme Havuzu &amp; <span>Peyzaj Maliyet Motoru</span></h1>
            <p>Betonarme veya prefabrik yüzme havuzu, otomatik bahçe sulama ve çim peyzaj bütçesini 3194 sayılı İmar Kanunu kurallarıyla birlikte hesaplayın.</p>
        </section>

        <div class="calc-grid">
            <div class="panel">
                <h2 class="panel-title"><i class="fa-solid fa-sliders" style="color:var(--accent);"></i> Havuz &amp; Bahçe Ölçüleri</h2>
                <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:10px;">
                    <div class="form-group"><label>En (m)</label><input type="number" id="hEn" value="4" min="2" step="0.5" oninput="calcPool()"></div>
                    <div class="form-group"><label>Boy (m)</label><input type="number" id="hBoy" value="8" min="3" step="0.5" oninput="calcPool()"></div>
                    <div class="form-group"><label>Derinlik (m)</label><input type="number" id="hDerin" value="1.5" min="1" step="0.1" oninput="calcPool()"></div>
                </div>
                <div class="form-group">
                    <label>Havuz Yapım Teknolojisi</label>
                    <select id="hTip" onchange="calcPool()">
                        <option value="skimmer" selected>Betonarme Skimmer Sistem (Cam Mozaik / Seramik)</option>
                        <option value="tasmali">Betonarme Taşmalı (Sonsuzluk + Denge Tankı)</option>
                        <option value="liner">Prefabrik Çelik Panel + Liner Kaplama</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Bahçe Peyzaj, Rulo Çim &amp; Otomatik Sulama Alanı (m²)</label>
                    <input type="number" id="peyzajM2" value="250" min="0" step="25" oninput="calcPool()">
                </div>
            </div>

            <div class="panel">
                <h2 class="panel-title"><i class="fa-solid fa-coins" style="color:var(--accent);"></i> 2026 Maliyet &amp; Ruhsat Analizi</h2>
                <div class="banner">
                    <div style="font-size:12px; color:var(--muted); font-weight:700;">ANAHTAR TESLİM HAVUZ + PEYZAJ BÜTÇESİ</div>
                    <div class="banner-val" id="toplamHavuz">598.500 TL</div>
                    <div style="font-size:12.5px; color:var(--emerald);">Havuz Alanı: <strong id="havuzOzet">32 m² (48 m³ Su Hacmi)</strong></div>
                </div>

                <div class="row"><span style="color:var(--muted);">Kazı, Demir-Beton &amp; İzolasyon:</span><strong id="kabaHavuz">272.000 TL</strong></div>
                <div class="row"><span style="color:var(--muted);">Filtrasyon, Pompa, Aydınlatma &amp; Kaplama:</span><strong id="mekanikHavuz">192.000 TL</strong></div>
                <div class="row"><span style="color:var(--muted);">Rulo Çim, Bitkilendirme &amp; Sulama:</span><strong id="peyzajBedel">134.500 TL</strong></div>

                <div style="background:rgba(16,185,129,0.1); border-left:4px solid var(--emerald); padding:12px; border-radius:8px; margin-top:16px; font-size:12.5px; color:#6ee7b7;">
                    <strong><i class="fa-solid fa-scale-balanced"></i> 3194 İmar Muafiyeti:</strong> Planlı Alanlar İmar Yönetmeliği m.22 uyarınca süs ve yüzme havuzları <strong>TAKS ve KAKS emsal hesabına DAHİL EDİLMEZ</strong>; ancak parsel sınırına en az 2m çekme şartı aranır.
                </div>
            </div>
        </div>
    
        <section style="margin-top:36px; background:#111827; border:1px solid #1f2937; border-radius:16px; padding:24px;">
            <h2 style="font-size:19px; font-weight:800; color:#fff; margin-bottom:16px;"><i class="fa-solid fa-book-open" style="color:#10b981;"></i> Sıkça Sorulan Sorular &amp; 2026 Mevzuat Özeti</h2>
            
            <div style="margin-bottom:14px; border-bottom:1px solid #1f2937; padding-bottom:12px;">
                <h4 style="font-size:14.5px; color:#f8fafc; font-weight:700; margin-bottom:5px;"><i class="fa-solid fa-circle-question" style="color:#38bdf8;"></i> Bahçeye yüzme havuzu yapmak TAKS/KAKS emsal alanını doldurur mu?</h4>
                <p style="font-size:13px; color:#9ca3af; line-height:1.6;">Planlı Alanlar İmar Yönetmeliği Madde 22 uyarınca süs ve yüzme havuzları yapı inşaat alanı (emsal/KAKS) ve taban alanı (TAKS) hesabına dahil edilmez.</p>
            </div>
            <div style="margin-bottom:14px; border-bottom:1px solid #1f2937; padding-bottom:12px;">
                <h4 style="font-size:14.5px; color:#f8fafc; font-weight:700; margin-bottom:5px;"><i class="fa-solid fa-circle-question" style="color:#38bdf8;"></i> Havuz yapımında komşu sınıra çekme mesafesi var mıdır?</h4>
                <p style="font-size:13px; color:#9ca3af; line-height:1.6;">Evet, su yalıtımı ve komşu güvenliği açısından havuzların parsel sınırlarına ve bina temeline en az 2 metre çekilerek inşa edilmesi istenmektedir.</p>
            </div>
        </section>
    </main>
    <script>
        function calcPool() {
            const en = parseFloat(document.getElementById('hEn').value) || 4;
            const boy = parseFloat(document.getElementById('hBoy').value) || 8;
            const der = parseFloat(document.getElementById('hDerin').value) || 1.5;
            const tip = document.getElementById('hTip').value;
            const peyzaj = parseFloat(document.getElementById('peyzajM2').value) || 0;

            const alan = en * boy;
            const hacim = alan * der;

            let kabaBirim = 8500;
            let mekBirim = 6000;
            if (tip === 'tasmali') { kabaBirim = 10500; mekBirim = 7800; }
            else if (tip === 'liner') { kabaBirim = 5500; mekBirim = 4800; }

            const kaba = alan * kabaBirim;
            const mek = alan * mekBirim;
            const peyz = peyzaj * 538;
            const total = kaba + mek + peyz;

            document.getElementById('havuzOzet').innerText = `${alan.toFixed(1)} m² (${hacim.toFixed(1)} m³ Su Hacmi)`;
            document.getElementById('kabaHavuz').innerText = Math.round(kaba).toLocaleString('tr-TR') + ' TL';
            document.getElementById('mekanikHavuz').innerText = Math.round(mek).toLocaleString('tr-TR') + ' TL';
            document.getElementById('peyzajBedel').innerText = Math.round(peyz).toLocaleString('tr-TR') + ' TL';
            document.getElementById('toplamHavuz').innerText = Math.round(total).toLocaleString('tr-TR') + ' TL';
        }
        calcPool();
    </script>
</body>
</html>
