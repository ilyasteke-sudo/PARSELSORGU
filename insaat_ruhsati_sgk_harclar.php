<?php
/**
 * ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ - PARSEL PRO
 * 2026 İnşaat Ruhsatı, Belediye Harçları, SGK Asgari İşçilik & Yapı Denetim Motoru
 */
require_once __DIR__ . '/navbar.php';

$page_title = "2026 İnşaat Ruhsatı, SGK ve Harç Hesaplama | ParselSorgu";
$page_desc = "Bina veya müstakil ev yaptırırken belediye ruhsat harcı, SGK asgari işçilik primi, yapı denetim ve otopark harçlarını tek tıkla hesaplayın.";
$canonical_url = "https://www.parselsorgu.net/insaat-ruhsati-harc-hesaplama";
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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root { --bg:#0a0f1d; --card:#111827; --border:#1f2937; --accent:#f59e0b; --emerald:#10b981; --cyan:#38bdf8; --text:#f3f4f6; --muted:#9ca3af; }
        * { box-sizing:border-box; margin:0; padding:0; }
        body { background:var(--bg); color:var(--text); font-family:'Inter', sans-serif; line-height:1.6; padding-bottom:60px; }
        .container { max-width:1180px; margin:0 auto; padding:24px 16px; }
        .hero { text-align:center; padding:32px 16px 24px; }
        .hero-badge { display:inline-flex; align-items:center; gap:8px; background:rgba(245,158,11,0.15); color:var(--accent); padding:6px 14px; border-radius:9999px; font-size:13px; font-weight:700; margin-bottom:12px; border:1px solid rgba(245,158,11,0.3); }
        .hero h1 { font-size:30px; font-weight:800; color:#fff; margin-bottom:10px; }
        .hero h1 span { color:var(--accent); }
        .hero p { font-size:15px; color:var(--muted); max-width:760px; margin:0 auto; }

        .calc-grid { display:grid; grid-template-columns:1fr 1fr; gap:24px; margin-top:24px; }
        @media (max-width: 900px) { .calc-grid { grid-template-columns:1fr; } }
        .panel { background:var(--card); border:1px solid var(--border); border-radius:16px; padding:26px; box-shadow:0 10px 25px rgba(0,0,0,0.45); }
        .panel-title { font-size:18px; font-weight:700; color:#fff; margin-bottom:18px; display:flex; align-items:center; gap:10px; border-bottom:1px solid var(--border); padding-bottom:12px; }
        .form-group { margin-bottom:15px; }
        .form-group label { display:block; font-size:13px; font-weight:600; margin-bottom:6px; color:var(--text); }
        .form-group input, .form-group select { width:100%; padding:11px 14px; background:#1f2937; border:1px solid #374151; border-radius:10px; color:#fff; font-size:14px; outline:none; }
        .total-banner { background:#1a2234; border:1px solid #283548; border-radius:14px; padding:20px; text-align:center; margin-bottom:20px; }
        .total-val { font-size:36px; font-weight:900; color:var(--accent); margin:6px 0; }
        .row { display:flex; justify-content:space-between; padding:10px 0; border-bottom:1px solid rgba(255,255,255,0.08); font-size:13.5px; }
    </style>
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "WebApplication",
      "name": "2026 İnşaat Ruhsatı, SGK İşçilik & Yapı Denetim Hesaplama",
      "url": "https://www.parselsorgu.net/insaat-ruhsati-harc-hesaplama",
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
      "name": "2026 yılında inşaat ruhsatı SGK asgari işçilik primi nasıl hesaplanır?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "ÇŞİDB yaklaşık yapı maliyet bedeli üzerinden %6.75 asgari işçilik oranı uygulanır (%25 peşin/uzlaşma indirimi sonrası %5.0625 matrah). Bu tutar üzerinden ~%37.5 SGK prim oranı hesaplandığında yaklaşık inşaat bedelinin ortalama %2.53'ü kadar SGK primi doğar."
      }
    },
    {
      "@type": "Question",
      "name": "Yapı denetim ücreti hangi binalarda zorunludur?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "200 m² toplam inşaat alanını aşan tüm yapılarda Yapı Denetim firmasıyla sözleşme imzalanması yasal olarak zorunludur; hizmet bedeli yaklaşık yapı maliyetinin ~%1.75'i düzeyindedir."
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
            <div class="hero-badge"><i class="fa-solid fa-helmet-safety"></i> 2026 ÇŞİDB Birim Fiyatları &amp; SGK İşçilik Mevzuatı</div>
            <h1>2026 İnşaat Ruhsatı, <span>SGK &amp; Harç Motoru</span></h1>
            <p>Kaba inşaat maliyetinin dışında belediye ruhsat harcı, SGK asgari işçilik primi, yapı denetim ve harita TUS masraflarını önceden hesaplayın.</p>
        </section>

        <div class="calc-grid">
            <div class="panel">
                <h2 class="panel-title"><i class="fa-solid fa-building" style="color:var(--accent);"></i> Yapı &amp; Ruhsat Bilgileri</h2>
                <div class="form-group">
                    <label>Toplam Ruhsat İnşaat Alanı (m²)</label>
                    <input type="number" id="insaatM2" value="250" min="30" step="10" oninput="calcPermit()">
                </div>
                <div class="form-group">
                    <label>ÇŞİDB 2026 Yapı Sınıfı</label>
                    <select id="yapiSinifi" onchange="calcPermit()">
                        <option value="14500">3. Sınıf A Grubu (Müstakil Ev / Villa - 14.500 TL/m²)</option>
                        <option value="17800" selected>3. Sınıf B Grubu (Apartman Konut - 17.800 TL/m²)</option>
                        <option value="22400">4. Sınıf A Grubu (Lüks Konut / Ticari - 22.400 TL/m²)</option>
                        <option value="9800">2. Sınıf C Grubu (Depo / Prefabrik - 9.800 TL/m²)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Bağımsız Bölüm (Daire / Dükkan) Sayısı</label>
                    <input type="number" id="daireSayi" value="2" min="1" max="100" oninput="calcPermit()">
                </div>
                <div class="form-group">
                    <label>Yapı Denetim Tabi Durumu (> 200 m² Zorunlu)</label>
                    <select id="yapiDenetim" onchange="calcPermit()">
                        <option value="evet" selected>Yapı Denetim Var (%1.75 Bedel)</option>
                        <option value="hayir">200 m² Altı Müstakil (Fenni Mesuliyet)</option>
                    </select>
                </div>
            </div>

            <div class="panel">
                <h2 class="panel-title"><i class="fa-solid fa-file-invoice-dollar" style="color:var(--accent);"></i> Resmi Kurum &amp; Harç Giderleri</h2>
                <div class="total-banner">
                    <div style="font-size:12px; color:var(--muted); font-weight:700;">KAZMA VURMADAN ÖDENECEK RESMİ HARÇ &amp; PRİM</div>
                    <div class="total-val" id="resmiToplam">312.500 TL</div>
                    <div style="font-size:12px; color:var(--cyan);">ÇŞİDB Yaklaşık Yapı Bedeli: <strong id="yaklasikBedel">4.450.000 TL</strong></div>
                </div>

                <div class="row"><span style="color:var(--muted);">SGK Asgari İşçilik Primi (%6.75 × %37.5):</span><strong id="sgkPrim">112.640 TL</strong></div>
                <div class="row"><span style="color:var(--muted);">Yapı Denetim Hizmet Bedeli:</span><strong id="denetimBedel">77.875 TL</strong></div>
                <div class="row"><span style="color:var(--muted);">Belediye Bina İnşaat &amp; İmar Harcı:</span><strong id="belediyeHarc">34.500 TL</strong></div>
                <div class="row"><span style="color:var(--muted);">Proje Çizimi (Mimari/Statik/Mekanik/Elektrik):</span><strong id="projeBedel">68.000 TL</strong></div>
                <div class="row"><span style="color:var(--muted);">Harita Mühendisliği (Aplikasyon + TUS + Plankote):</span><strong id="haritaTus">19.500 TL</strong></div>
            </div>
        </div>
    
        <section style="margin-top:36px; background:#111827; border:1px solid #1f2937; border-radius:16px; padding:24px;">
            <h2 style="font-size:19px; font-weight:800; color:#fff; margin-bottom:16px;"><i class="fa-solid fa-book-open" style="color:#10b981;"></i> Sıkça Sorulan Sorular &amp; 2026 Mevzuat Özeti</h2>
            
            <div style="margin-bottom:14px; border-bottom:1px solid #1f2937; padding-bottom:12px;">
                <h4 style="font-size:14.5px; color:#f8fafc; font-weight:700; margin-bottom:5px;"><i class="fa-solid fa-circle-question" style="color:#38bdf8;"></i> 2026 yılında inşaat ruhsatı SGK asgari işçilik primi nasıl hesaplanır?</h4>
                <p style="font-size:13px; color:#9ca3af; line-height:1.6;">ÇŞİDB yaklaşık yapı maliyet bedeli üzerinden %6.75 asgari işçilik oranı uygulanır (%25 peşin/uzlaşma indirimi sonrası %5.0625 matrah). Bu tutar üzerinden ~%37.5 SGK prim oranı hesaplandığında yaklaşık inşaat bedelinin ortalama %2.53'ü kadar SGK primi doğar.</p>
            </div>
            <div style="margin-bottom:14px; border-bottom:1px solid #1f2937; padding-bottom:12px;">
                <h4 style="font-size:14.5px; color:#f8fafc; font-weight:700; margin-bottom:5px;"><i class="fa-solid fa-circle-question" style="color:#38bdf8;"></i> Yapı denetim ücreti hangi binalarda zorunludur?</h4>
                <p style="font-size:13px; color:#9ca3af; line-height:1.6;">200 m² toplam inşaat alanını aşan tüm yapılarda Yapı Denetim firmasıyla sözleşme imzalanması yasal olarak zorunludur; hizmet bedeli yaklaşık yapı maliyetinin ~%1.75'i düzeyindedir.</p>
            </div>
        </section>
    </main>
    <script>
        function calcPermit() {
            const m2 = parseFloat(document.getElementById('insaatM2').value) || 250;
            const birim = parseFloat(document.getElementById('yapiSinifi').value) || 17800;
            const daire = parseInt(document.getElementById('daireSayi').value) || 2;
            const denetim = document.getElementById('yapiDenetim').value === 'evet';

            const yaklasik = m2 * birim;
            // SGK minimum labor: %6.75 * 0.75 (25% reduction) * ~37.5% premium rate -> ~2.53% of total construction cost
            const sgk = yaklasik * 0.02531;
            const denetimTutar = denetim ? (yaklasik * 0.0175) : 0;
            const belediye = (m2 * 95) + (daire * 5400);
            const proje = 35000 + (m2 * 130);
            const harita = 16500 + (m2 * 12);
            const toplam = sgk + denetimTutar + belediye + proje + harita;

            document.getElementById('yaklasikBedel').innerText = Math.round(yaklasik).toLocaleString('tr-TR') + ' TL';
            document.getElementById('sgkPrim').innerText = Math.round(sgk).toLocaleString('tr-TR') + ' TL';
            document.getElementById('denetimBedel').innerText = denetim ? Math.round(denetimTutar).toLocaleString('tr-TR') + ' TL' : 'Muaf (Fenni Mesul)';
            document.getElementById('belediyeHarc').innerText = Math.round(belediye).toLocaleString('tr-TR') + ' TL';
            document.getElementById('projeBedel').innerText = Math.round(proje).toLocaleString('tr-TR') + ' TL';
            document.getElementById('haritaTus').innerText = Math.round(harita).toLocaleString('tr-TR') + ' TL';
            document.getElementById('resmiToplam').innerText = Math.round(toplam).toLocaleString('tr-TR') + ' TL';
        }
        calcPermit();
    </script>
</body>
</html>
