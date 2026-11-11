<?php
/**
 * ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ - PARSEL PRO
 * Kamulaştırma (İstimlak), Yol & Yüksek Gerilim (TEİAŞ İrtifak) Bedel Hesaplayıcı (2942 s.K.)
 */
require_once __DIR__ . '/navbar.php';

$page_title = "2026 Kamulaştırma ve İrtifak Bedeli Hesaplama | ParselSorgu";
$page_desc = "2942 sayılı Kamulaştırma Kanunu m.11 ile tarla kamulaştırma bedeli ve TEİAŞ yüksek gerilim irtifak hakkı değer düşüklüğü hesaplayın.";
$canonical_url = "https://www.parselsorgu.net/kamulastirma-bedeli-hesaplama";
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
        :root { --bg:#0a0f1d; --card:#111827; --border:#1f2937; --accent:#f43f5e; --emerald:#10b981; --cyan:#38bdf8; --text:#f3f4f6; --muted:#9ca3af; }
        * { box-sizing:border-box; margin:0; padding:0; }
        body { background:var(--bg); color:var(--text); font-family:'Inter', sans-serif; line-height:1.6; padding-bottom:60px; }
        .container { max-width:1180px; margin:0 auto; padding:24px 16px; }
        .hero { text-align:center; padding:32px 16px 24px; }
        .hero-badge { display:inline-flex; align-items:center; gap:8px; background:rgba(244,63,94,0.15); color:var(--accent); padding:6px 14px; border-radius:9999px; font-size:13px; font-weight:700; margin-bottom:12px; border:1px solid rgba(244,63,94,0.3); }
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
        .banner-val { font-size:36px; font-weight:900; color:var(--emerald); margin:6px 0; }
        .row { display:flex; justify-content:space-between; padding:10px 0; border-bottom:1px solid rgba(255,255,255,0.08); font-size:13.5px; }
    </style>
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "WebApplication",
      "name": "Kamulaştırma & İrtifak Bedeli Hesaplayıcı (2942 s.K.)",
      "url": "https://www.parselsorgu.net/kamulastirma-bedeli-hesaplama",
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
      "name": "Yüksek gerilim hattı (TEİAŞ) geçen tarlada ne kadar tazminat ödenir?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "2942 sayılı Kanun m.11 uyarınca pilon direk yeri tam bedelle kamulaştırılırken, tel altı geçen irtifak koridoru için genellikle arazinin metrekare değerinin %35 ila %50'si oranında değer düşüklüğü tazminatı ödenir."
      }
    },
    {
      "@type": "Question",
      "name": "Kamulaştırmada tarım arazisinin değeri nasıl belirlenir?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Tarım arazilerinde değer, arazinin yıllık net tarımsal gelirinin bölgeye göre %4 ila %6 arasındaki kapitalizasyon faiz oranına bölünmesiyle (R / f formülü) bilirkişilerce hesaplanır."
      }
    }
  ]
}
    </script>
    <script type="application/ld+json">{"@context": "https://schema.org", "@type": "WebPage", "speakable": {"@type": "SpeakableSpecification", "cssSelector": ["h1", ".lead", ".summary-box", ".hero-desc", "main p"]}, "isBasedOn": "https://www.parselsorgu.net/api/2026-kadastro-endeks.json", "publisher": {"@type": "Organization", "name": "Ant Harita Mühendislik - ParselSorgu.net", "url": "https://www.parselsorgu.net/"}}</script>
</head>
<body>
    <?= render_saas_navbar('imar') ?>
    <main class="container">
        <section class="hero">
            <div class="hero-badge"><i class="fa-solid fa-road"></i> 2942 Sayılı Kamulaştırma Kanunu Madde 11</div>
            <h1>Kamulaştırma &amp; <span>İrtifak Hakkı Tazminat Motoru</span></h1>
            <p>Tarla veya arsanızdan otoyol, yüksek gerilim hattı (TEİAŞ) veya boru hattı geçtiğinde hak ettiğiniz yasal bedeli ve değer düşüklüğü tazminatını hesaplayın.</p>
        </section>

        <div class="calc-grid">
            <div class="panel">
                <h2 class="panel-title"><i class="fa-solid fa-scale-balanced" style="color:var(--accent);"></i> Taşınmaz &amp; İstimlak Parametreleri</h2>
                <div class="form-group">
                    <label>Kamulaştırma İşlem Türü</label>
                    <select id="kamuTip" onchange="calcKamu()">
                        <option value="tam">Tam Mülkiyet Kamulaştırması (Karayolları / Baraj / Okul)</option>
                        <option value="irtifak">Daimi İrtifak Hakkı (TEİAŞ Yüksek Gerilim / BOTAŞ Boru Hattı)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Parselin Toplam Tapu Alanı (m²)</label>
                    <input type="number" id="toplamAlan" value="10000" step="500" oninput="calcKamu()">
                </div>
                <div class="form-group">
                    <label>Kamulaştırılan / İrtifak Geçen Alan (m²)</label>
                    <input type="number" id="gecenAlan" value="2500" step="100" oninput="calcKamu()">
                </div>
                <div class="form-group">
                    <label>Yıllık Net Tarım Geliri (TL / Dönüm) veya Birim Değer</label>
                    <input type="number" id="netGelirDonum" value="28000" step="1000" oninput="calcKamu()">
                </div>
                <div class="form-group">
                    <label>Kapitalizasyon Faiz Oranı (%4 Sulu - %5 Kuru Tarım)</label>
                    <select id="kapFaiz" onchange="calcKamu()">
                        <option value="0.04">%4 (Verimli Sulu Tarım / Bağ-Bahçe)</option>
                        <option value="0.05" selected>%5 (Kuru Tarım Arazisi)</option>
                        <option value="0.06">%6 (Marjinal / Kıraç Toprak)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Üzerindeki Muhdesat Değeri (Ağaç / Bina / Kuyu TL)</label>
                    <input type="number" id="muhdesat" value="150000" step="10000" oninput="calcKamu()">
                </div>
            </div>

            <div class="panel">
                <h2 class="panel-title"><i class="fa-solid fa-coins" style="color:var(--emerald);"></i> 2942 m.11 Bilirkişi Tazminat Raporu</h2>
                <div class="banner">
                    <div style="font-size:12px; color:var(--muted); font-weight:700;">HAK EDİLEN TAHMİNİ KAMULAŞTIRMA BEDELİ</div>
                    <div class="banner-val" id="toplamKamu">1.550.000 TL</div>
                    <div style="font-size:12.5px; color:var(--cyan);">Bilirkişi m² Değeri: <strong id="m2Bedel">560 TL / m²</strong></div>
                </div>

                <div class="row"><span style="color:var(--muted);">Zemin Tam Mülkiyet / İrtifak Bedeli:</span><strong id="zeminTutar">1.400.000 TL</strong></div>
                <div class="row"><span style="color:var(--muted);">Kalan Parsel Değer Düşüklüğü (İrtifak/Bölünme):</span><strong id="degerKaybi">0 TL</strong></div>
                <div class="row"><span style="color:var(--muted);">Ağaç, Kuyu &amp; Yapı (Muhdesat) Bedeli:</span><strong id="muhdesatTutar">150.000 TL</strong></div>

                <div style="background:rgba(56,189,248,0.1); border-left:4px solid var(--cyan); padding:12px; border-radius:8px; margin-top:16px; font-size:12.5px; color:#bae6fd;">
                    <strong><i class="fa-solid fa-gavel"></i> Yargıtay Emsali:</strong> Yüksek gerilim hattı (TEİAŞ) veya yol nedeniyle arazinin bütünlüğü bozulursa, Yargıtay kalan kısımdaki değer kaybının (%15 - %35) da idare tarafından ödenmesine hükmetmektedir.
                </div>
            </div>
        </div>
    
        <section style="margin-top:36px; background:#111827; border:1px solid #1f2937; border-radius:16px; padding:24px;">
            <h2 style="font-size:19px; font-weight:800; color:#fff; margin-bottom:16px;"><i class="fa-solid fa-book-open" style="color:#10b981;"></i> Sıkça Sorulan Sorular &amp; 2026 Mevzuat Özeti</h2>
            
            <div style="margin-bottom:14px; border-bottom:1px solid #1f2937; padding-bottom:12px;">
                <h4 style="font-size:14.5px; color:#f8fafc; font-weight:700; margin-bottom:5px;"><i class="fa-solid fa-circle-question" style="color:#38bdf8;"></i> Yüksek gerilim hattı (TEİAŞ) geçen tarlada ne kadar tazminat ödenir?</h4>
                <p style="font-size:13px; color:#9ca3af; line-height:1.6;">2942 sayılı Kanun m.11 uyarınca pilon direk yeri tam bedelle kamulaştırılırken, tel altı geçen irtifak koridoru için genellikle arazinin metrekare değerinin %35 ila %50'si oranında değer düşüklüğü tazminatı ödenir.</p>
            </div>
            <div style="margin-bottom:14px; border-bottom:1px solid #1f2937; padding-bottom:12px;">
                <h4 style="font-size:14.5px; color:#f8fafc; font-weight:700; margin-bottom:5px;"><i class="fa-solid fa-circle-question" style="color:#38bdf8;"></i> Kamulaştırmada tarım arazisinin değeri nasıl belirlenir?</h4>
                <p style="font-size:13px; color:#9ca3af; line-height:1.6;">Tarım arazilerinde değer, arazinin yıllık net tarımsal gelirinin bölgeye göre %4 ila %6 arasındaki kapitalizasyon faiz oranına bölünmesiyle (R / f formülü) bilirkişilerce hesaplanır.</p>
            </div>
        </section>
    </main>
    <script>
        function calcKamu() {
            const tip = document.getElementById('kamuTip').value;
            const toplamA = parseFloat(document.getElementById('toplamAlan').value) || 10000;
            const gecenA = parseFloat(document.getElementById('gecenAlan').value) || 2500;
            const netDonum = parseFloat(document.getElementById('netGelirDonum').value) || 28000;
            const faiz = parseFloat(document.getElementById('kapFaiz').value) || 0.05;
            const muhd = parseFloat(document.getElementById('muhdesat').value) || 0;

            const m2Gelir = netDonum / 1000;
            const m2Deger = m2Gelir / faiz; // Kapitalizasyon formülü: R / f

            let zemin = 0;
            let kayip = 0;

            if (tip === 'tam') {
                zemin = gecenA * m2Deger;
            } else {
                // İrtifak: Geçen şerit alanının ortalama %45'i değer kaybı + kalan alanda %5 etki
                zemin = (gecenA * m2Deger) * 0.45;
                kayip = ((toplamA - gecenA) * m2Deger) * 0.05;
            }

            const total = zemin + kayip + muhd;

            document.getElementById('m2Bedel').innerText = Math.round(m2Deger).toLocaleString('tr-TR') + ' TL / m²';
            document.getElementById('zeminTutar').innerText = Math.round(zemin).toLocaleString('tr-TR') + ' TL';
            document.getElementById('degerKaybi').innerText = Math.round(kayip).toLocaleString('tr-TR') + ' TL';
            document.getElementById('muhdesatTutar').innerText = Math.round(muhd).toLocaleString('tr-TR') + ' TL';
            document.getElementById('toplamKamu').innerText = Math.round(total).toLocaleString('tr-TR') + ' TL';
        }
        calcKamu();
    </script>
</body>
</html>
