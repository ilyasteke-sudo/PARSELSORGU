<?php
/**
 * ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ - PARSEL PRO
 * 2D İmar Çapı, TAKS / KAKS & Çekme Mesafesi Görsel Bina Oturumu Simülatörü
 * Pure PHP 8.3 / SVG Vaziyet Planı / Schema.org
 */
require_once __DIR__ . '/navbar.php';

$page_title = "TAKS KAKS & Emsal Hesaplama (2D İmar Çapı) | ParselSorgu";
$page_desc = "TAKS, KAKS ve emsal hesaplama ile canlı 2D vaziyet planı çizimi, çekme mesafesi, %30 emsal harici alan ve daire adedini anında hesaplayın.";
$canonical_url = "https://www.parselsorgu.net/taks-kaks-hesaplama";
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($page_title) ?></title>
    <meta name="description" content="<?= htmlspecialchars($page_desc) ?>">
    <link rel="canonical" href="<?= $canonical_url ?>">
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?= htmlspecialchars($page_title) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($page_desc) ?>">
    <meta property="og:url" content="<?= $canonical_url ?>">
    <meta property="og:image" content="https://www.parselsorgu.net/assets/images/og-parsel.jpg">
    <meta name="twitter:card" content="summary_large_image">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root { --bg:#0a0f1d; --card:#111827; --border:#1f2937; --accent:#38bdf8; --emerald:#10b981; --amber:#f59e0b; --text:#f3f4f6; --muted:#9ca3af; }
        * { box-sizing:border-box; margin:0; padding:0; }
        body { background:var(--bg); color:var(--text); font-family:'Inter', sans-serif; line-height:1.6; padding-bottom:60px; }
        .container { max-width:1240px; margin:0 auto; padding:24px 16px; }
        .hero { text-align:center; padding:32px 16px 24px; }
        .hero-badge { display:inline-flex; align-items:center; gap:8px; background:rgba(56,189,248,0.15); color:var(--accent); padding:6px 14px; border-radius:9999px; font-size:13px; font-weight:700; margin-bottom:12px; border:1px solid rgba(56,189,248,0.3); }
        .hero h1 { font-size:30px; font-weight:800; color:#fff; margin-bottom:10px; }
        .hero h1 span { color:var(--accent); }
        .hero p { font-size:15px; color:var(--muted); max-width:780px; margin:0 auto; }

        .calc-grid { display:grid; grid-template-columns: 400px 1fr; gap:24px; margin-top:24px; }
        @media (max-width: 960px) { .calc-grid { grid-template-columns: 1fr; } }
        .panel { background:var(--card); border:1px solid var(--border); border-radius:16px; padding:24px; box-shadow:0 10px 25px rgba(0,0,0,0.45); }
        .panel-title { font-size:18px; font-weight:700; color:#fff; margin-bottom:18px; display:flex; align-items:center; gap:10px; border-bottom:1px solid var(--border); padding-bottom:12px; }
        .panel-title i { color:var(--accent); }
        .grid-2 { display:grid; grid-template-columns:1fr 1fr; gap:12px; }
        .form-group { margin-bottom:14px; }
        .form-group label { display:block; font-size:12.5px; font-weight:600; margin-bottom:6px; color:var(--text); }
        .form-group input, .form-group select { width:100%; padding:10px 12px; background:#1f2937; border:1px solid #374151; border-radius:8px; color:#fff; font-size:14px; outline:none; }
        .form-group input:focus { border-color:var(--accent); }

        .svg-wrapper { background:#060c18; border:1px solid #1e293b; border-radius:12px; padding:16px; margin-bottom:20px; position:relative; text-align:center; }
        .stats-row { display:grid; grid-template-columns:repeat(auto-fit, minmax(170px, 1fr)); gap:12px; margin-bottom:18px; }
        .stat-box { background:#1a2234; border:1px solid #283548; border-radius:10px; padding:14px; }
        .stat-box span { display:block; font-size:11.5px; color:var(--muted); font-weight:600; text-transform:uppercase; }
        .stat-box strong { display:block; font-size:20px; color:#fff; font-weight:800; margin-top:4px; }
        .cta-box { background:linear-gradient(135deg, rgba(16,185,129,0.12) 0%, rgba(15,23,42,0.9) 100%); border:1px solid var(--emerald); border-radius:12px; padding:16px; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; }
        .btn-cta { background:var(--emerald); color:#fff; padding:10px 18px; border-radius:8px; text-decoration:none; font-weight:800; font-size:13px; display:inline-flex; align-items:center; gap:8px; }
    </style>
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "WebApplication",
      "name": "2D İmar Çapı, TAKS / KAKS & Çekme Mesafesi Simülatörü",
      "url": "https://www.parselsorgu.net/taks-kaks-hesaplama",
      "applicationCategory": "BusinessApplication",
      "provider": { "@type": "Organization", "name": "Ant Harita Mühendislik" }
    }
    </script>
    <link rel="alternate" type="text/markdown" href="https://www.parselsorgu.net/llms.txt" title="ParselSorgu AI Knowledge Base">
    <link rel="alternate" type="application/json" href="https://www.parselsorgu.net/api/2026-kadastro-endeks.json" title="2026 Türkiye Kadastro ve İnşaat Açık Veri Seti">

    <script type="application/ld+json">
    {
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    {
      "@type": "Question",
      "name": "TAKS ve KAKS (Emsal) hesaplamasında %30 emsal harici alan nedir?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Planlı Alanlar İmar Yönetmeliği uyarınca balkonlar, yangın merdivenleri, asansör boşlukları ve ortak sığınak gibi alanlar toplam emsal inşaat alanının %30'unu aşmamak üzere KAKS hesabının dışında tutulabilir."
      }
    },
    {
      "@type": "Question",
      "name": "Çekme mesafeleri bina oturumunu nasıl etkiler?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Belediye imar çapında belirtilen ön bahçe (genellikle 5m) ve yan/arka bahçe (genellikle 3m) çekme mesafeleri düşüldükten sonra kalan net alan içine bina oturabilir; bina oturumu hem TAKS sınırını hem de çekme içi alanı aşamaz."
      }
    }
  ]
}
    </script>
    <script type="application/ld+json">{"@context": "https://schema.org", "@type": "WebPage", "speakable": {"@type": "SpeakableSpecification", "cssSelector": ["h1", ".lead", ".summary-box", ".hero-desc", "main p"]}, "isBasedOn": "https://www.parselsorgu.net/api/2026-kadastro-endeks.json", "publisher": {"@type": "Organization", "name": "Ant Harita Mühendislik - ParselSorgu.net", "url": "https://www.parselsorgu.net/"}}</script>
</head>
<body>
    <?= render_saas_navbar('eklentiler') ?>
    <main class="container">
        <section class="hero">
            <div class="hero-badge"><i class="fa-solid fa-compass-drafting"></i> 2D CAD Vaziyet Planı &amp; Planlı Alanlar İmar Yönetmeliği</div>
            <h1>TAKS KAKS &amp; <span>Emsal Hesaplama (2D İmar Çapı)</span></h1>
            <p>Arsanızın cephesi, derinliği ve çekme mesafelerini girerek zemin oturumunu canlı 2D CAD planında görün; toplam emsal ve %30 emsal harici bonus alanıyla çıkacak daire sayısını hesaplayın.</p>
        </section>

        <div class="calc-grid">
            <div class="panel">
                <h2 class="panel-title"><i class="fa-solid fa-sliders"></i> Arsa &amp; İmar Parametreleri</h2>
                <div class="grid-2">
                    <div class="form-group">
                        <label>Arsa Ön Cephe (En - m)</label>
                        <input type="number" id="arsEn" value="25" min="6" step="0.5" oninput="drawVaziyet()">
                    </div>
                    <div class="form-group">
                        <label>Arsa Derinlik (Boy - m)</label>
                        <input type="number" id="arsBoy" value="32" min="8" step="0.5" oninput="drawVaziyet()">
                    </div>
                </div>
                <div class="grid-2">
                    <div class="form-group">
                        <label>Ön Bahçe Çekme (m)</label>
                        <input type="number" id="cekmeOn" value="5" min="0" step="0.5" oninput="drawVaziyet()">
                    </div>
                    <div class="form-group">
                        <label>Yan &amp; Arka Çekme (m)</label>
                        <input type="number" id="cekmeYan" value="3" min="0" step="0.5" oninput="drawVaziyet()">
                    </div>
                </div>
                <div class="grid-2">
                    <div class="form-group">
                        <label>TAKS (Taban Katsayısı)</label>
                        <input type="number" id="taksVal" value="0.30" min="0.05" max="1" step="0.05" oninput="drawVaziyet()">
                    </div>
                    <div class="form-group">
                        <label>KAKS (Emsal)</label>
                        <input type="number" id="kaksVal" value="1.20" min="0.1" max="5" step="0.05" oninput="drawVaziyet()">
                    </div>
                </div>
                <div class="grid-2">
                    <div class="form-group">
                        <label>İzinli Kat Adedi</label>
                        <input type="number" id="katAdedi" value="4" min="1" max="30" oninput="drawVaziyet()">
                    </div>
                    <div class="form-group">
                        <label>%30 Emsal Harici Alan</label>
                        <select id="bonus30" onchange="drawVaziyet()">
                            <option value="1" selected>Dahil Et (+%30 Balkon/Ortak)</option>
                            <option value="0">Sadece Net Emsal (Hariç)</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label>Ortalama 1 Daire Büyüklüğü (m² Brüt)</label>
                    <input type="number" id="daireM2" value="115" min="40" max="400" oninput="drawVaziyet()">
                </div>
            </div>

            <div class="panel">
                <h2 class="panel-title"><i class="fa-solid fa-vector-square"></i> Canlı 2D Vaziyet Planı &amp; Oturum Analizi</h2>

                <div class="svg-wrapper">
                    <svg id="cadSvg" viewBox="0 0 600 340" style="width:100%; max-height:340px; height:auto;"></svg>
                    <div style="display:flex; justify-content:center; gap:18px; margin-top:8px; font-size:11.5px; color:var(--muted); flex-wrap:wrap;">
                        <span><span style="color:#38bdf8;">■</span> Parsel Sınırı</span>
                        <span><span style="color:#ef4444;">---</span> Çekme Mesafesi</span>
                        <span><span style="color:#10b981;">■</span> Bina Zemin Oturumu (TAKS)</span>
                    </div>
                </div>

                <div class="stats-row">
                    <div class="stat-box">
                        <span>Parsel Toplam Alanı</span>
                        <strong id="outArsaAlan" style="color:var(--accent);">800 m²</strong>
                    </div>
                    <div class="stat-box">
                        <span>Bina Zemin Oturumu</span>
                        <strong id="outTabanAlan" style="color:var(--emerald);">240 m²</strong>
                    </div>
                    <div class="stat-box">
                        <span>Toplam İnşaat (Bonuslu)</span>
                        <strong id="outToplamInsaat" style="color:#fff;">1.248 m²</strong>
                    </div>
                    <div class="stat-box">
                        <span>Tahmini Daire Adedi</span>
                        <strong id="outDaireSayisi" style="color:var(--amber);">10 Daire</strong>
                    </div>
                </div>

                <div class="cta-box">
                    <div>
                        <strong style="color:#fff; font-size:14px; display:block;">Bu Arsa İçin Resmi Plankote &amp; Aplikasyon Krokisi Gerekli mi?</strong>
                        <span style="font-size:12px; color:var(--muted);">Belediyeye mimari proje vermeden önce köşe koordinatları ve kotları Ant Harita ekibine ölçtürün.</span>
                    </div>
                    <a href="/harita-muhendislik-fiyat-teklifi" class="btn-cta"><i class="fa-solid fa-file-signature"></i> Teklif Al</a>
                </div>
            </div>
        </div>
    
        <section style="margin-top:36px; background:#111827; border:1px solid #1f2937; border-radius:16px; padding:24px;">
            <h2 style="font-size:19px; font-weight:800; color:#fff; margin-bottom:16px;"><i class="fa-solid fa-book-open" style="color:#10b981;"></i> Sıkça Sorulan Sorular &amp; 2026 Mevzuat Özeti</h2>
            
            <div style="margin-bottom:14px; border-bottom:1px solid #1f2937; padding-bottom:12px;">
                <h4 style="font-size:14.5px; color:#f8fafc; font-weight:700; margin-bottom:5px;"><i class="fa-solid fa-circle-question" style="color:#38bdf8;"></i> TAKS ve KAKS (Emsal) hesaplamasında %30 emsal harici alan nedir?</h4>
                <p style="font-size:13px; color:#9ca3af; line-height:1.6;">Planlı Alanlar İmar Yönetmeliği uyarınca balkonlar, yangın merdivenleri, asansör boşlukları ve ortak sığınak gibi alanlar toplam emsal inşaat alanının %30'unu aşmamak üzere KAKS hesabının dışında tutulabilir.</p>
            </div>
            <div style="margin-bottom:14px; border-bottom:1px solid #1f2937; padding-bottom:12px;">
                <h4 style="font-size:14.5px; color:#f8fafc; font-weight:700; margin-bottom:5px;"><i class="fa-solid fa-circle-question" style="color:#38bdf8;"></i> Çekme mesafeleri bina oturumunu nasıl etkiler?</h4>
                <p style="font-size:13px; color:#9ca3af; line-height:1.6;">Belediye imar çapında belirtilen ön bahçe (genellikle 5m) ve yan/arka bahçe (genellikle 3m) çekme mesafeleri düşüldükten sonra kalan net alan içine bina oturabilir; bina oturumu hem TAKS sınırını hem de çekme içi alanı aşamaz.</p>
            </div>
        </section>
    </main>

    <script>
        function drawVaziyet() {
            const en = parseFloat(document.getElementById('arsEn').value) || 25;
            const boy = parseFloat(document.getElementById('arsBoy').value) || 32;
            const on = parseFloat(document.getElementById('cekmeOn').value) || 5;
            const yan = parseFloat(document.getElementById('cekmeYan').value) || 3;
            const taks = parseFloat(document.getElementById('taksVal').value) || 0.30;
            const kaks = parseFloat(document.getElementById('kaksVal').value) || 1.20;
            const kat = parseInt(document.getElementById('katAdedi').value) || 4;
            const hasBonus = document.getElementById('bonus30').value === '1';
            const daireM2 = parseFloat(document.getElementById('daireM2').value) || 115;

            const arsaAlan = en * boy;
            const maxTaksAlan = arsaAlan * taks;

            // Net setback box
            const netEn = Math.max(0, en - (2 * yan));
            const netBoy = Math.max(0, boy - on - yan);
            const cekmeIciAlan = netEn * netBoy;

            // Real footprint limited by both TAKS and setback geometry
            const gercekTaban = Math.min(maxTaksAlan, cekmeIciAlan);

            const netEmsalAlan = arsaAlan * kaks;
            const toplamBonuslu = hasBonus ? netEmsalAlan * 1.30 : netEmsalAlan;
            const tahminiDaire = Math.max(1, Math.floor(toplamBonuslu / daireM2));

            document.getElementById('outArsaAlan').innerText = Math.round(arsaAlan).toLocaleString('tr-TR') + ' m²';
            document.getElementById('outTabanAlan').innerText = Math.round(gercekTaban).toLocaleString('tr-TR') + ' m²';
            document.getElementById('outToplamInsaat').innerText = Math.round(toplamBonuslu).toLocaleString('tr-TR') + ' m²';
            document.getElementById('outDaireSayisi').innerText = tahminiDaire + ' Daire (' + kat + ' Kat)';

            // Render SVG
            const svg = document.getElementById('cadSvg');
            const pad = 40;
            const maxW = 600 - (pad * 2);
            const maxH = 340 - (pad * 2);
            const scale = Math.min(maxW / en, maxH / boy);

            const pW = en * scale;
            const pH = boy * scale;
            const startX = (600 - pW) / 2;
            const startY = (340 - pH) / 2;

            // Setback rect (Top is Back, Bottom is Front/Road)
            const sX = startX + (yan * scale);
            const sY = startY + (yan * scale);
            const sW = Math.max(0, netEn * scale);
            const sH = Math.max(0, netBoy * scale);

            // Building footprint inside setback box (scaled by ratio)
            const ratio = cekmeIciAlan > 0 ? Math.sqrt(gercekTaban / cekmeIciAlan) : 0;
            const bW = sW * Math.min(1, ratio);
            const bH = sH * Math.min(1, ratio);
            const bX = sX + (sW - bW) / 2;
            const bY = sY + (sH - bH) / 2;

            const realBWidth = (netEn * Math.min(1, ratio)).toFixed(1);
            const realBDepth = (netBoy * Math.min(1, ratio)).toFixed(1);

            svg.innerHTML = `
                <!-- Yol Cephesi Alt -->
                <rect x="${startX}" y="${startY + pH + 6}" width="${pW}" height="18" fill="#1e293b" rx="3" />
                <text x="300" y="${startY + pH + 19}" fill="#94a3b8" font-size="11" text-anchor="middle" font-weight="bold">KADASTRO / İMAR YOLU (${en}m CEPHE)</text>

                <!-- Parsel Sınırı -->
                <rect x="${startX}" y="${startY}" width="${pW}" height="${pH}" fill="rgba(56,189,248,0.06)" stroke="#38bdf8" stroke-width="2.5" />
                <text x="${startX - 8}" y="${startY + pH/2}" fill="#38bdf8" font-size="11" text-anchor="end" font-weight="bold">${boy}m</text>

                <!-- Çekme Mesafesi Çizgisi -->
                <rect x="${sX}" y="${sY}" width="${sW}" height="${sH}" fill="none" stroke="#ef4444" stroke-width="1.5" stroke-dasharray="6,4" />

                <!-- Bina Oturumu -->
                <rect x="${bX}" y="${bY}" width="${bW}" height="${bH}" fill="rgba(16,185,129,0.28)" stroke="#10b981" stroke-width="2" rx="3" />
                <text x="${bX + bW/2}" y="${bY + bH/2 - 6}" fill="#fff" font-size="12" text-anchor="middle" font-weight="bold">BİNA OTURUMU</text>
                <text x="${bX + bW/2}" y="${bY + bH/2 + 12}" fill="#6ee7b7" font-size="11" text-anchor="middle" font-weight="bold">${realBWidth}m × ${realBDepth}m (${Math.round(gercekTaban)} m²)</text>
            `;
        }
        drawVaziyet();
    </script>
</body>
</html>
