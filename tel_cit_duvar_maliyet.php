<?php
/**
 * ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ - PARSEL PRO
 * Tarla & Arsa Çevirme: Tel Çit, Beton Direk & İstinat Duvarı Maliyet Motoru
 */
require_once __DIR__ . '/navbar.php';

$page_title = "Tarla Tel Çit & Bahçe Duvarı Maliyeti 2026 | ParselSorgu";
$page_desc = "Tarla tel çit maliyeti, beton direk adedi, panel çit ve perde beton duvar metrekare fiyatı ile sınır aplikasyonu uyarı motoru.";
$canonical_url = "https://www.parselsorgu.net/tel-cit-duvar-maliyet";
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
        :root { --bg:#0a0f1d; --card:#111827; --border:#1f2937; --accent:#10b981; --amber:#f59e0b; --cyan:#38bdf8; --danger:#ef4444; --text:#f3f4f6; --muted:#9ca3af; }
        * { box-sizing:border-box; margin:0; padding:0; }
        body { background:var(--bg); color:var(--text); font-family:'Inter', sans-serif; line-height:1.6; padding-bottom:60px; }
        .container { max-width:1180px; margin:0 auto; padding:24px 16px; }
        .hero { text-align:center; padding:32px 16px 24px; }
        .hero-badge { display:inline-flex; align-items:center; gap:8px; background:rgba(16,185,129,0.15); color:var(--accent); padding:6px 14px; border-radius:9999px; font-size:13px; font-weight:700; margin-bottom:12px; border:1px solid rgba(16,185,129,0.3); }
        .hero h1 { font-size:30px; font-weight:800; color:#fff; margin-bottom:10px; }
        .hero h1 span { color:var(--accent); }
        .hero p { font-size:15px; color:var(--muted); max-width:760px; margin:0 auto; }

        .calc-grid { display:grid; grid-template-columns:1fr 1fr; gap:24px; margin-top:24px; }
        @media (max-width: 900px) { .calc-grid { grid-template-columns:1fr; } }
        .panel { background:var(--card); border:1px solid var(--border); border-radius:16px; padding:26px; box-shadow:0 10px 25px rgba(0,0,0,0.45); }
        .panel-title { font-size:18px; font-weight:700; color:#fff; margin-bottom:18px; display:flex; align-items:center; gap:10px; border-bottom:1px solid var(--border); padding-bottom:12px; }
        .form-group { margin-bottom:16px; }
        .form-group label { display:block; font-size:13px; font-weight:600; margin-bottom:6px; color:var(--text); }
        .form-group input, .form-group select { width:100%; padding:11px 14px; background:#1f2937; border:1px solid #374151; border-radius:10px; color:#fff; font-size:14px; outline:none; }
        .price-banner { background:#1a2234; border:1px solid #283548; border-radius:14px; padding:20px; text-align:center; margin-bottom:20px; }
        .price-val { font-size:36px; font-weight:900; color:var(--accent); margin:6px 0; }
        .row { display:flex; justify-content:space-between; padding:10px 0; border-bottom:1px solid rgba(255,255,255,0.08); font-size:13.5px; }
        .warn-box { background:rgba(239,68,68,0.1); border-left:4px solid var(--danger); padding:14px; border-radius:8px; margin-top:16px; font-size:13px; color:#fca5a5; }
        .btn-lead { display:inline-flex; align-items:center; justify-content:center; gap:8px; width:100%; background:linear-gradient(135deg, #10b981 0%, #059669 100%); color:#fff; padding:12px 18px; border-radius:10px; font-weight:800; font-size:14px; text-decoration:none; margin-top:14px; }
    </style>
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "WebApplication",
      "name": "Tarla & Arsa Tel Çit ve Duvar Maliyet Motoru",
      "url": "https://www.parselsorgu.net/tel-cit-duvar-maliyet",
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
      "name": "Tarlaya tel çit çekmeden önce sınır ölçümü yaptırmak zorunlu mudur?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Resmi tapu aplikasyonu (yer gösterme) yaptırılmadan örülen çitlerde komşu parsele taşma riski çok yüksektir. 10-20 cm bile taşma halinde mahkeme kararıyla çitin yıkılmasına ve tazminata hükmedilir."
      }
    },
    {
      "@type": "Question",
      "name": "Tel çit direkleri kaç metre arayla dikilmelidir?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Standart 150 cm kafes tel ve dikenli tel uygulamalarında beton veya galvaniz direkler ortalama 3 metre arayla, köşelerde ise çift payanda destekli olarak dikilir."
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
            <div class="hero-badge"><i class="fa-solid fa-border-all"></i> 2026 Güncel Malzeme + İşçilik Birim Fiyatları</div>
            <h1>Tarla Tel Çit &amp; <span>Bahçe Duvarı Maliyeti</span></h1>
            <p>Tarla veya arsanızın etrafını çevirmeden önce gereken direk adedini, rulo tel miktarını ve 2026 anahtar teslim bütçesini kuruşu kuruşuna hesaplayın.</p>
        </section>

        <div class="calc-grid">
            <div class="panel">
                <h2 class="panel-title"><i class="fa-solid fa-ruler-combined" style="color:var(--accent);"></i> Arazi &amp; Çit Özellikleri</h2>
                <div class="form-group">
                    <label>Giriş Yöntemi</label>
                    <select id="girisTipi" onchange="toggleGiris()">
                        <option value="alan">Tapu Alanına Göre Otomatik Çevre Hesapla (m²)</option>
                        <option value="cevre">Doğrudan Çevre Uzunluğu Gir (Metre)</option>
                    </select>
                </div>
                <div class="form-group" id="boxAlan">
                    <label>Parsel Alanı (m²) — (1 Dönüm = 1.000 m²)</label>
                    <input type="number" id="parselAlan" value="5000" min="100" step="100" oninput="calcFence()">
                </div>
                <div class="form-group" id="boxCevre" style="display:none;">
                    <label>Toplam Çevre Uzunluğu (Metre)</label>
                    <input type="number" id="parselCevre" value="285" min="10" step="5" oninput="calcFence()">
                </div>
                <div class="form-group">
                    <label>Çevirme Sistemi Türü</label>
                    <select id="citTuru" onchange="calcFence()">
                        <option value="kafes_beton">Beton Direk + Galvaniz Örgü Kafes Tel (150 cm)</option>
                        <option value="dikenli">Beton Direk + 4 Sıra Dikenli Tel (Ekonomik)</option>
                        <option value="panel_cit">Dekoratif Yeşil Panel Çit + Çelik Dübelli Montaj</option>
                        <option value="perde_duvar">1m Perde Beton Duvar + Üstü 1m Panel Çit</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Direk Aralığı (Metre)</label>
                    <select id="direkAralik" onchange="calcFence()">
                        <option value="3" selected>3 Metre Ara ile (Standart)</option>
                        <option value="2.5">2.5 Metre Ara ile (Sık Sağlam)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Arazi Kapısı (Sürgülü / Kanatlı)</label>
                    <select id="kapiSecim" onchange="calcFence()">
                        <option value="1" selected>1 Adet 4m Demir Kapı Ekle (+16.500 TL)</option>
                        <option value="0">Kapı Hariç</option>
                    </select>
                </div>
            </div>

            <div class="panel">
                <h2 class="panel-title"><i class="fa-solid fa-coins" style="color:var(--accent);"></i> 2026 Metraj &amp; Maliyet Raporu</h2>
                <div class="price-banner">
                    <div style="font-size:12px; color:var(--muted); font-weight:700;">ANAHTAR TESLİM TAHMİNİ MALİYET</div>
                    <div class="price-val" id="toplamMaliyet">118.400 TL</div>
                    <div style="font-size:12px; color:var(--cyan);">Çevrilecek Hat Uzunluğu: <strong id="hatMetre">283 Metre</strong></div>
                </div>

                <div class="row"><span style="color:var(--muted);">Gereken Beton / Demir Direk:</span><strong id="direkAdet">98 Adet</strong></div>
                <div class="row"><span style="color:var(--muted);">Payanda (Köşe Destek) Direği:</span><strong id="payandaAdet">10 Adet</strong></div>
                <div class="row"><span style="color:var(--muted);">Tel / Panel / Harç Malzeme:</span><strong id="malzemeBedel">68.500 TL</strong></div>
                <div class="row"><span style="color:var(--muted);">Kazı, Dikim &amp; Gerdirme İşçiliği:</span><strong id="iscilikBedel">33.400 TL</strong></div>
                <div class="row"><span style="color:var(--muted);">Arazi Kapısı Bedeli:</span><strong id="kapiBedel">16.500 TL</strong></div>

                <div class="warn-box">
                    <strong><i class="fa-solid fa-triangle-exclamation"></i> KRİTİK MÜHENDİSLİK UYARISI:</strong><br>
                    Tapu sınırınızı LİHKAB veya Harita Mühendisine ölçtürmeden (<strong>Aplikasyon Krokisi</strong> almadan) tel çekerseniz, komşuya 20 cm bile taşmanız halinde mahkeme kararıyla tüm çitiniz yıktırılır ve dava masraflarını ödersiniz!
                </div>
                <a href="/harita-muhendislik-fiyat-teklifi" class="btn-lead"><i class="fa-solid fa-crosshairs"></i> Tel Çekmeden Önce Sınır Aplikasyonu Teklifi Al</a>
            </div>
        </div>
    
        <section style="margin-top:36px; background:#111827; border:1px solid #1f2937; border-radius:16px; padding:24px;">
            <h2 style="font-size:19px; font-weight:800; color:#fff; margin-bottom:16px;"><i class="fa-solid fa-book-open" style="color:#10b981;"></i> Sıkça Sorulan Sorular &amp; 2026 Mevzuat Özeti</h2>
            
            <div style="margin-bottom:14px; border-bottom:1px solid #1f2937; padding-bottom:12px;">
                <h4 style="font-size:14.5px; color:#f8fafc; font-weight:700; margin-bottom:5px;"><i class="fa-solid fa-circle-question" style="color:#38bdf8;"></i> Tarlaya tel çit çekmeden önce sınır ölçümü yaptırmak zorunlu mudur?</h4>
                <p style="font-size:13px; color:#9ca3af; line-height:1.6;">Resmi tapu aplikasyonu (yer gösterme) yaptırılmadan örülen çitlerde komşu parsele taşma riski çok yüksektir. 10-20 cm bile taşma halinde mahkeme kararıyla çitin yıkılmasına ve tazminata hükmedilir.</p>
            </div>
            <div style="margin-bottom:14px; border-bottom:1px solid #1f2937; padding-bottom:12px;">
                <h4 style="font-size:14.5px; color:#f8fafc; font-weight:700; margin-bottom:5px;"><i class="fa-solid fa-circle-question" style="color:#38bdf8;"></i> Tel çit direkleri kaç metre arayla dikilmelidir?</h4>
                <p style="font-size:13px; color:#9ca3af; line-height:1.6;">Standart 150 cm kafes tel ve dikenli tel uygulamalarında beton veya galvaniz direkler ortalama 3 metre arayla, köşelerde ise çift payanda destekli olarak dikilir.</p>
            </div>
        </section>
    </main>
    <script>
        function toggleGiris() {
            const v = document.getElementById('girisTipi').value;
            document.getElementById('boxAlan').style.display = v === 'alan' ? 'block' : 'none';
            document.getElementById('boxCevre').style.display = v === 'cevre' ? 'block' : 'none';
            calcFence();
        }
        function calcFence() {
            const mode = document.getElementById('girisTipi').value;
            let cevre = 283;
            if (mode === 'alan') {
                const alan = parseFloat(document.getElementById('parselAlan').value) || 5000;
                cevre = Math.round(4 * Math.sqrt(alan) * 1.05); // Slight rectangular margin
            } else {
                cevre = parseFloat(document.getElementById('parselCevre').value) || 283;
            }
            const tur = document.getElementById('citTuru').value;
            const aralik = parseFloat(document.getElementById('direkAralik').value) || 3;
            const hasKapi = document.getElementById('kapiSecim').value === '1';

            const direk = Math.ceil(cevre / aralik) + 1;
            const payanda = Math.max(8, Math.floor(direk / 10) * 2);

            let birimMalzeme = 240;
            let birimIscilik = 120;
            if (tur === 'dikenli') { birimMalzeme = 135; birimIscilik = 85; }
            else if (tur === 'panel_cit') { birimMalzeme = 480; birimIscilik = 190; }
            else if (tur === 'perde_duvar') { birimMalzeme = 1650; birimIscilik = 850; }

            const malzeme = cevre * birimMalzeme;
            const iscilik = cevre * birimIscilik;
            const kapi = hasKapi ? 16500 : 0;
            const toplam = malzeme + iscilik + kapi;

            document.getElementById('hatMetre').innerText = cevre.toLocaleString('tr-TR') + ' Metre';
            document.getElementById('direkAdet').innerText = direk + ' Adet';
            document.getElementById('payandaAdet').innerText = payanda + ' Adet';
            document.getElementById('malzemeBedel').innerText = Math.round(malzeme).toLocaleString('tr-TR') + ' TL';
            document.getElementById('iscilikBedel').innerText = Math.round(iscilik).toLocaleString('tr-TR') + ' TL';
            document.getElementById('kapiBedel').innerText = Math.round(kapi).toLocaleString('tr-TR') + ' TL';
            document.getElementById('toplamMaliyet').innerText = Math.round(toplam).toLocaleString('tr-TR') + ' TL';
        }
        calcFence();
    </script>
</body>
</html>
