<?php
/**
 * ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ - PARSEL PRO
 * Hafriyat (Kübaj), Taş İstinat Duvarı & Arazi Tesviye Maliyet Motoru
 */
require_once __DIR__ . '/navbar.php';

$page_title = "2026 Hafriyat Kübaj ve İstinat Duvarı Maliyeti | ParselSorgu";
$page_desc = "Eğimli arsa veya tarlada kazı metreküpü (m³), kabarma paylı kamyon seferi ve taş/betonarme istinat duvarı maliyetini hesaplayın.";
$canonical_url = "https://www.parselsorgu.net/hafriyat-kubaj-istinat-maliyet";
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
        .form-group { margin-bottom:14px; }
        .form-group label { display:block; font-size:13px; font-weight:600; margin-bottom:6px; color:var(--text); }
        .form-group input, .form-group select { width:100%; padding:11px 14px; background:#1f2937; border:1px solid #374151; border-radius:10px; color:#fff; font-size:14px; outline:none; }
        .banner { background:#1a2234; border:1px solid #283548; border-radius:14px; padding:20px; text-align:center; margin-bottom:18px; }
        .banner-val { font-size:36px; font-weight:900; color:var(--accent); margin:6px 0; }
        .row { display:flex; justify-content:space-between; padding:10px 0; border-bottom:1px solid rgba(255,255,255,0.08); font-size:13.5px; }
        .cta-box { background:rgba(16,185,129,0.1); border-left:4px solid var(--emerald); padding:14px; border-radius:8px; margin-top:16px; font-size:12.5px; color:#6ee7b7; }
        .btn-cta { display:inline-flex; align-items:center; justify-content:center; gap:8px; width:100%; background:linear-gradient(135deg, #10b981 0%, #059669 100%); color:#fff; padding:12px; border-radius:10px; font-weight:800; font-size:14px; text-decoration:none; margin-top:12px; }
    </style>
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "WebApplication",
      "name": "2026 Hafriyat Kübaj & İstinat Duvarı Maliyet Hesaplama",
      "url": "https://www.parselsorgu.net/hafriyat-kubaj-istinat-maliyet",
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
      "name": "Hafriyat kübaj hesabı neden kazı öncesi ve sonrası yapılmalıdır?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Toprak ve kaya zeminin kazıldıktan sonra hacmi %20 ile %40 arasında kabarır. Harita mühendisi tarafından Nivo/GNSS ile kazı öncesi ve sonrası alınan kübaj ölçümü kamyon sayısındaki suistimalleri %30'a kadar önler."
      }
    },
    {
      "@type": "Question",
      "name": "İstinat duvarı ne zaman zorunlu olur?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Komşu parsel veya yolla arasında kot farkı oluşan ve şev açısı güvenliğini aşan eğimli arazilerde can ve mal güvenliği için taş veya betonarme istinat duvarı inşa edilmesi belediyelerce zorunlu tutulur."
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
            <div class="hero-badge"><i class="fa-solid fa-truck-moving"></i> 2026 Kübaj Metrajı, Kabarma Payı &amp; İstinat Hesabı</div>
            <h1>Hafriyat (Kübaj) &amp; <span>İstinat Duvarı Maliyeti</span></h1>
            <p>Kazı alanı ve eğim derinliğine göre çıkacak net metreküp (m³), kamyon sefer sayısı, kırıcı maliyetini ve taş/betonarme istinat duvarı bütçesini hesaplayın.</p>
        </section>

        <div class="calc-grid">
            <div class="panel">
                <h2 class="panel-title"><i class="fa-solid fa-mound" style="color:var(--accent);"></i> Kazı &amp; İstinat Ölçüleri</h2>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                    <div class="form-group">
                        <label>Kazı / Tesviye Alanı (m²)</label>
                        <input type="number" id="kaziAlan" value="350" min="20" step="10" oninput="calcKubaj()">
                    </div>
                    <div class="form-group">
                        <label>Ortalama Kazı Derinliği (m)</label>
                        <input type="number" id="kaziDerinlik" value="2.2" min="0.3" step="0.1" oninput="calcKubaj()">
                    </div>
                </div>
                <div class="form-group">
                    <label>Zemin Formasyonu &amp; Kabarma Oranı</label>
                    <select id="zeminTip" onchange="calcKubaj()">
                        <option value="1.20|180">Normal Toprak / Kil (Kabarma %20 - Standart Kova)</option>
                        <option value="1.30|320">Yumuşak Kaya / Kırmataş (Kabarma %30)</option>
                        <option value="1.40|540">Sert Kaya / Bazalt (Kabarma %40 - Hidrolik Kırıcı)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>İstinat Duvarı Türü</label>
                    <select id="duvarTip" onchange="calcKubaj()">
                        <option value="tas">Doğal Taş İstinat Duvarı (Ekonomik &amp; Drenajlı)</option>
                        <option value="betonarme">Betonarme Perde İstinat Duvarı (Yüksek Dayanım)</option>
                        <option value="yok">İstinat Duvarı Yok (Sadece Hafriyat)</option>
                    </select>
                </div>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;" id="duvarOlculeri">
                    <div class="form-group">
                        <label>Duvar Uzunluğu (Metre)</label>
                        <input type="number" id="duvarBoy" value="30" min="0" oninput="calcKubaj()">
                    </div>
                    <div class="form-group">
                        <label>Duvar Yüksekliği (Metre)</label>
                        <input type="number" id="duvarYuk" value="2.5" min="0.5" step="0.5" oninput="calcKubaj()">
                    </div>
                </div>
            </div>

            <div class="panel">
                <h2 class="panel-title"><i class="fa-solid fa-calculator" style="color:var(--accent);"></i> 2026 Kübaj &amp; Bütçe Dökümü</h2>
                <div class="banner">
                    <div style="font-size:12px; color:var(--muted); font-weight:700;">TOPLAM HAFRİYAT + İSTİNAT BÜTÇESİ</div>
                    <div class="banner-val" id="toplamButce">414.120 TL</div>
                    <div style="font-size:12.5px; color:var(--cyan);">Çıkacak Hacim: <strong id="hacimOzet">770 m³ Yerinde / 924 m³ Kamyon (52 Sefer)</strong></div>
                </div>

                <div class="row"><span style="color:var(--muted);">Kazı &amp; Kırıcı Kepçe İşçiliği:</span><strong id="kaziBedel">138.600 TL</strong></div>
                <div class="row"><span style="color:var(--muted);">Kamyon Nakliye &amp; Resmi Döküm Harcı:</span><strong id="nakliyeBedel">140.520 TL</strong></div>
                <div class="row"><span style="color:var(--muted);">İstinat Duvarı Alanı &amp; Maliyeti:</span><strong id="duvarBedel">135.000 TL (75 m²)</strong></div>

                <div class="cta-box">
                    <strong><i class="fa-solid fa-compass-drafting"></i> MÜHENDİSLİK TAVSİYESİ:</strong><br>
                    Hafriyatçıya kamyon sayısına göre fazla ödeme yapmamak için kazı öncesi ve sonrası arazinizi <strong>Harita Mühendisine Kübaj &amp; Plankote</strong> ölçümüyle hesaplattırın (%25-%35 tasarruf sağlar).
                </div>
                <a href="/harita-muhendislik-fiyat-teklifi" class="btn-cta"><i class="fa-solid fa-file-signature"></i> Kübaj &amp; Plankote Ölçümü Teklifi Al</a>
            </div>
        </div>
    
        <section style="margin-top:36px; background:#111827; border:1px solid #1f2937; border-radius:16px; padding:24px;">
            <h2 style="font-size:19px; font-weight:800; color:#fff; margin-bottom:16px;"><i class="fa-solid fa-book-open" style="color:#10b981;"></i> Sıkça Sorulan Sorular &amp; 2026 Mevzuat Özeti</h2>
            
            <div style="margin-bottom:14px; border-bottom:1px solid #1f2937; padding-bottom:12px;">
                <h4 style="font-size:14.5px; color:#f8fafc; font-weight:700; margin-bottom:5px;"><i class="fa-solid fa-circle-question" style="color:#38bdf8;"></i> Hafriyat kübaj hesabı neden kazı öncesi ve sonrası yapılmalıdır?</h4>
                <p style="font-size:13px; color:#9ca3af; line-height:1.6;">Toprak ve kaya zeminin kazıldıktan sonra hacmi %20 ile %40 arasında kabarır. Harita mühendisi tarafından Nivo/GNSS ile kazı öncesi ve sonrası alınan kübaj ölçümü kamyon sayısındaki suistimalleri %30'a kadar önler.</p>
            </div>
            <div style="margin-bottom:14px; border-bottom:1px solid #1f2937; padding-bottom:12px;">
                <h4 style="font-size:14.5px; color:#f8fafc; font-weight:700; margin-bottom:5px;"><i class="fa-solid fa-circle-question" style="color:#38bdf8;"></i> İstinat duvarı ne zaman zorunlu olur?</h4>
                <p style="font-size:13px; color:#9ca3af; line-height:1.6;">Komşu parsel veya yolla arasında kot farkı oluşan ve şev açısı güvenliğini aşan eğimli arazilerde can ve mal güvenliği için taş veya betonarme istinat duvarı inşa edilmesi belediyelerce zorunlu tutulur.</p>
            </div>
        </section>
    </main>
    <script>
        function calcKubaj() {
            const alan = parseFloat(document.getElementById('kaziAlan').value) || 0;
            const derin = parseFloat(document.getElementById('kaziDerinlik').value) || 0;
            const [kabarmaStr, birimStr] = document.getElementById('zeminTip').value.split('|');
            const kabarma = parseFloat(kabarmaStr);
            const kaziBirim = parseFloat(birimStr);

            const yerindeM3 = alan * derin;
            const kamyonM3 = yerindeM3 * kabarma;
            const kamyonSefer = Math.ceil(kamyonM3 / 18); // 18 m3 damperli

            const kaziTutar = yerindeM3 * kaziBirim;
            const nakliyeTutar = kamyonSefer * 2700; // Nakliye + döküm fişi

            const dTip = document.getElementById('duvarTip').value;
            document.getElementById('duvarOlculeri').style.display = dTip === 'yok' ? 'none' : 'grid';

            let duvarAlan = 0;
            let duvarTutar = 0;
            if (dTip !== 'yok') {
                const dBoy = parseFloat(document.getElementById('duvarBoy').value) || 0;
                const dYuk = parseFloat(document.getElementById('duvarYuk').value) || 0;
                duvarAlan = dBoy * dYuk;
                duvarTutar = duvarAlan * (dTip === 'tas' ? 1800 : 3400);
            }

            const toplam = kaziTutar + nakliyeTutar + duvarTutar;

            document.getElementById('hacimOzet').innerText = `${Math.round(yerindeM3).toLocaleString('tr-TR')} m³ Yerinde / ${Math.round(kamyonM3).toLocaleString('tr-TR')} m³ Kabarmış (${kamyonSefer} Kamyon)`;
            document.getElementById('kaziBedel').innerText = Math.round(kaziTutar).toLocaleString('tr-TR') + ' TL';
            document.getElementById('nakliyeBedel').innerText = Math.round(nakliyeTutar).toLocaleString('tr-TR') + ' TL';
            document.getElementById('duvarBedel').innerText = dTip === 'yok' ? '0 TL (Seçilmedi)' : `${Math.round(duvarTutar).toLocaleString('tr-TR')} TL (${Math.round(duvarAlan)} m²)`;
            document.getElementById('toplamButce').innerText = Math.round(toplam).toLocaleString('tr-TR') + ' TL';
        }
        calcKubaj();
    </script>
</body>
</html>
