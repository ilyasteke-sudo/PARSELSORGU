<?php
/**
 * ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ - PARSEL PRO
 * Kira Artış (TÜFE), 5 Yıllık Emsal Kira Tespit & Tahliye Taahhütnamesi Motoru
 */
require_once __DIR__ . '/navbar.php';

$page_title = "2026 Kira Artış (TÜFE) & Tahliye Taahhütnamesi | ParselSorgu";
$page_desc = "Konut, işyeri ve tarla kiralarında TÜFE zam oranı, 5 yıl kira tespiti ve Yargıtay uyumlu Tahliye Taahhütnamesi taslağı oluşturun.";
$canonical_url = "https://www.parselsorgu.net/kira-artis-tahliye-hesaplama";
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
        :root { --bg:#0a0f1d; --card:#111827; --border:#1f2937; --accent:#38bdf8; --emerald:#10b981; --purple:#a855f7; --text:#f3f4f6; --muted:#9ca3af; }
        * { box-sizing:border-box; margin:0; padding:0; }
        body { background:var(--bg); color:var(--text); font-family:'Inter', sans-serif; line-height:1.6; padding-bottom:60px; }
        .container { max-width:1180px; margin:0 auto; padding:24px 16px; }
        .hero { text-align:center; padding:32px 16px 24px; }
        .hero-badge { display:inline-flex; align-items:center; gap:8px; background:rgba(56,189,248,0.15); color:var(--accent); padding:6px 14px; border-radius:9999px; font-size:13px; font-weight:700; margin-bottom:12px; border:1px solid rgba(56,189,248,0.3); }
        .hero h1 { font-size:30px; font-weight:800; color:#fff; margin-bottom:10px; }
        .hero h1 span { color:var(--accent); }
        .hero p { font-size:15px; color:var(--muted); max-width:760px; margin:0 auto; }

        .calc-grid { display:grid; grid-template-columns:1fr 1fr; gap:24px; margin-top:24px; }
        @media (max-width: 900px) { .calc-grid { grid-template-columns:1fr; } }
        .panel { background:var(--card); border:1px solid var(--border); border-radius:16px; padding:26px; box-shadow:0 10px 25px rgba(0,0,0,0.45); }
        .panel-title { font-size:18px; font-weight:700; color:#fff; margin-bottom:18px; display:flex; align-items:center; gap:10px; border-bottom:1px solid var(--border); padding-bottom:12px; }
        .form-group { margin-bottom:14px; }
        .form-group label { display:block; font-size:12.5px; font-weight:600; margin-bottom:6px; color:var(--text); }
        .form-group input, .form-group select { width:100%; padding:10px 12px; background:#1f2937; border:1px solid #374151; border-radius:8px; color:#fff; font-size:14px; outline:none; }
        .rent-box { background:#1a2234; border:1px solid #283548; border-radius:12px; padding:20px; text-align:center; margin-bottom:18px; }
        .rent-val { font-size:36px; font-weight:900; color:var(--emerald); margin:6px 0; }
        .draft-box { background:#060c18; border:1px solid #374151; border-radius:10px; padding:16px; font-family:monospace; font-size:12px; color:#cbd5e1; white-space:pre-wrap; line-height:1.5; margin-top:12px; }
        .btn-copy { background:var(--accent); color:#0f172a; border:none; padding:10px 18px; border-radius:8px; font-weight:800; font-size:13px; cursor:pointer; margin-top:10px; display:inline-flex; align-items:center; gap:8px; }
    </style>
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "WebApplication",
      "name": "Kira Artış (TÜFE) & Tahliye Taahhütnamesi Motoru",
      "url": "https://www.parselsorgu.net/kira-artis-tahliye-hesaplama",
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
      "name": "Tahliye taahhütnamesinin geçerli olması için en kritik şart nedir?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Yargıtay yerleşik içtihatlarına göre tahliye taahhütnamesinin düzenleme tarihinin kira sözleşmesinin başlangıç tarihinden mutlaka sonraki bir tarih (örneğin 15-30 gün sonra) olması ve aile konutu ise her iki eşin imzasının bulunması gerekir."
      }
    },
    {
      "@type": "Question",
      "name": "5 yılı dolduran kiracıya ne kadar zam yapılabilir?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Kira süresi 5 yılı doldurduğunda ev sahibi veya arazi sahibi TÜFE tavanına bağlı kalmaksızın Sulh Hukuk Mahkemesinde 'Kira Tespit Davası' açarak rayiç bedel (hakkaniyet indirimiyle) talep edebilir."
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
            <div class="hero-badge"><i class="fa-solid fa-file-contract"></i> TBK Madde 344 - 352 &amp; Yargıtay Geçerlilik Kriterleri</div>
            <h1>2026 Kira Artış &amp; <span>Tahliye Taahhütnamesi</span></h1>
            <p>Konut, işyeri veya tarla kiralarınızda 12 aylık TÜFE zam tutarını hesaplayın ve tarih hatası içermeyen hukuken geçerli Tahliye Taahhütnamesi hazırlayın.</p>
        </section>

        <div class="calc-grid">
            <div class="panel">
                <h2 class="panel-title"><i class="fa-solid fa-calculator" style="color:var(--accent);"></i> Kira &amp; Sözleşme Parametreleri</h2>
                <div class="form-group">
                    <label>Mevcut Aylık Kira Bedeli (TL)</label>
                    <input type="number" id="mevcutKira" value="18000" step="500" oninput="calcRent()">
                </div>
                <div class="form-group">
                    <label>12 Aylık Ortalama TÜFE Oranı (%)</label>
                    <input type="number" id="tufeOran" value="58.51" step="0.1" oninput="calcRent()">
                </div>
                <div class="form-group">
                    <label>Kiracılık Süresi (5 Yılı Doldurdu mu?)</label>
                    <select id="besYil" onchange="calcRent()">
                        <option value="hayir" selected>5 Yıldan Az (Yasal Tavan: TÜFE)</option>
                        <option value="evet">5 Yılı Doldurdu (Emsal Kira Tespit Hakkı Doğdu)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Kiraya Veren / Mal Sahibi Adı</label>
                    <input type="text" id="malSahibi" value="Mehmet Demir" oninput="calcRent()">
                </div>
                <div class="form-group">
                    <label>Kiracı Adı Soyadı &amp; Adres</label>
                    <input type="text" id="kiraciBilgi" value="Ahmet Kaya - Ankara Çankaya ... Mah." oninput="calcRent()">
                </div>
            </div>

            <div class="panel">
                <h2 class="panel-title"><i class="fa-solid fa-scale-balanced" style="color:var(--accent);"></i> Zam Hesabı &amp; Tahliye Taahhütnamesi</h2>
                <div class="rent-box">
                    <div style="font-size:12px; color:var(--muted); font-weight:700;">YENİ DÖNEM YASAL KİRA BEDELİ</div>
                    <div class="rent-val" id="yeniKira">28.532 TL</div>
                    <div style="font-size:12.5px; color:var(--accent);">Artış Miktarı: +<strong id="artisTutar">10.532 TL</strong> / Ay</div>
                </div>

                <div id="besYilNotu" style="display:none; background:rgba(168,85,247,0.12); border-left:4px solid var(--purple); padding:10px 12px; border-radius:6px; font-size:12.5px; color:#d8b4fe; margin-bottom:14px;">
                    <strong>TBK m.344/3 Hakkı:</strong> Kiracınız 5 yılı doldurduğu için TÜFE sınırına bağlı kalmaksızın Sulh Hukuk Mahkemesinde "Kira Tespit Davası" açarak bölge rayicine (%15 hakkaniyet indirimiyle) çıkarabilirsiniz.
                </div>

                <h4 style="font-size:13.5px; color:#fff;">📄 Yargıtay Uyumlu Tahliye Taahhütnamesi Taslağı:</h4>
                <div class="draft-box" id="tahliyeMetni"></div>
                <button type="button" class="btn-copy" onclick="copyTahliye()"><i class="fa-solid fa-copy"></i> Taahhütnameyi Kopyala</button>
            </div>
        </div>
    
        <section style="margin-top:36px; background:#111827; border:1px solid #1f2937; border-radius:16px; padding:24px;">
            <h2 style="font-size:19px; font-weight:800; color:#fff; margin-bottom:16px;"><i class="fa-solid fa-book-open" style="color:#10b981;"></i> Sıkça Sorulan Sorular &amp; 2026 Mevzuat Özeti</h2>
            
            <div style="margin-bottom:14px; border-bottom:1px solid #1f2937; padding-bottom:12px;">
                <h4 style="font-size:14.5px; color:#f8fafc; font-weight:700; margin-bottom:5px;"><i class="fa-solid fa-circle-question" style="color:#38bdf8;"></i> Tahliye taahhütnamesinin geçerli olması için en kritik şart nedir?</h4>
                <p style="font-size:13px; color:#9ca3af; line-height:1.6;">Yargıtay yerleşik içtihatlarına göre tahliye taahhütnamesinin düzenleme tarihinin kira sözleşmesinin başlangıç tarihinden mutlaka sonraki bir tarih (örneğin 15-30 gün sonra) olması ve aile konutu ise her iki eşin imzasının bulunması gerekir.</p>
            </div>
            <div style="margin-bottom:14px; border-bottom:1px solid #1f2937; padding-bottom:12px;">
                <h4 style="font-size:14.5px; color:#f8fafc; font-weight:700; margin-bottom:5px;"><i class="fa-solid fa-circle-question" style="color:#38bdf8;"></i> 5 yılı dolduran kiracıya ne kadar zam yapılabilir?</h4>
                <p style="font-size:13px; color:#9ca3af; line-height:1.6;">Kira süresi 5 yılı doldurduğunda ev sahibi veya arazi sahibi TÜFE tavanına bağlı kalmaksızın Sulh Hukuk Mahkemesinde 'Kira Tespit Davası' açarak rayiç bedel (hakkaniyet indirimiyle) talep edebilir.</p>
            </div>
        </section>
    </main>
    <script>
        function calcRent() {
            const mevcut = parseFloat(document.getElementById('mevcutKira').value) || 0;
            const tufe = parseFloat(document.getElementById('tufeOran').value) || 0;
            const besYil = document.getElementById('besYil').value === 'evet';
            const malSahibi = document.getElementById('malSahibi').value;
            const kiraci = document.getElementById('kiraciBilgi').value;

            const artis = mevcut * (tufe / 100);
            const yeni = mevcut + artis;

            document.getElementById('yeniKira').innerText = Math.round(yeni).toLocaleString('tr-TR') + ' TL';
            document.getElementById('artisTutar').innerText = Math.round(artis).toLocaleString('tr-TR') + ' TL';
            document.getElementById('besYilNotu').style.display = besYil ? 'block' : 'none';

            const dDuzen = new Date();
            dDuzen.setDate(dDuzen.getDate() + 30); // Must be AFTER lease start date
            const dTahliye = new Date();
            dTahliye.setFullYear(dTahliye.getFullYear() + 1);

            document.getElementById('tahliyeMetni').innerText = `TAHLİYE TAAHHÜTNAMESİ (TBK Madde 352)
Kiraya Veren : ${malSahibi}
Kiracı       : ${kiraci}

Halen kiracısı olarak kullanmakta olduğum yukarıda adresi yazılı taşınmazı hiçbir ihtar ve ihbara gerek kalmadan, kayıtsız ve şartsız olarak ${dTahliye.toLocaleDateString('tr-TR')} tarihinde boş ve sağlam olarak tahliye edip kiraya verene teslim edeceğimi; aksi halde icra ve dava masraflarını ödeyeceğimi beyan ve taahhüt ederim.

Düzenleme Tarihi (Sözleşmeden Sonraki Tarih Olmalı): ${dDuzen.toLocaleDateString('tr-TR')}
Kiracı İmza: __________________`;
        }
        function copyTahliye() {
            navigator.clipboard.writeText(document.getElementById('tahliyeMetni').innerText);
            alert('Tahliye Taahhütnamesi metni kopyalandı!');
        }
        calcRent();
    </script>
</body>
</html>
