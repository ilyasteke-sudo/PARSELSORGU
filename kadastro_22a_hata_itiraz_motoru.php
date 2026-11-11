<?php
/**
 * ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ - PARSEL PRO
 * Kadastro Yenileme (22/A) Sınır İtirazı, Tecviz Sınırı & 41. Madde Teknik Hata Motoru
 */
require_once __DIR__ . '/navbar.php';

$page_title = "Kadastro 22/A Yenileme ve 41. Madde İtiraz | ParselSorgu";
$page_desc = "Tapu alanım kadastro yenilemesinde düştü mü? 3402 s.K. 22/a 30 gün askı itirazı ve 41. madde tecviz yanılma sınırı hesaplayıcı.";
$canonical_url = "https://www.parselsorgu.net/kadastro-yenileme-itiraz";
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
        :root { --bg:#0a0f1d; --card:#111827; --border:#1f2937; --accent:#38bdf8; --emerald:#10b981; --danger:#ef4444; --text:#f3f4f6; --muted:#9ca3af; }
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
        .form-group label { display:block; font-size:13px; font-weight:600; margin-bottom:6px; color:var(--text); }
        .form-group input { width:100%; padding:11px 14px; background:#1f2937; border:1px solid #374151; border-radius:10px; color:#fff; font-size:14px; outline:none; }
        .banner { background:#1a2234; border:1px solid #283548; border-radius:14px; padding:20px; text-align:center; margin-bottom:18px; }
        .draft-box { background:#060c18; border:1px solid #374151; border-radius:10px; padding:14px; font-family:monospace; font-size:12px; color:#cbd5e1; white-space:pre-wrap; margin-top:10px; }
        .btn-copy { background:var(--accent); color:#0f172a; border:none; padding:10px 16px; border-radius:8px; font-weight:800; font-size:13px; cursor:pointer; margin-top:10px; display:inline-flex; align-items:center; gap:6px; }
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
      "name": "Kadastro yenilemesinde tarlam küçüldü ne yapmalıyım?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Askı ilanı süresindeki ilk 30 gün içinde Kadastro Mahkemesine dava açabilirsiniz. Askı süresi geçmişse 3402 s.K. 12. Madde gereği 10 yıllık hak düşürücü süre içinde dava açabilir veya teknik tersimat hataları için her zaman 41. Madde düzeltme dilekçesi verebilirsiniz."
      }
    },
    {
      "@type": "Question",
      "name": "Tecviz (yanılma) sınırı aşılırsa ne olur?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Ölçüm farkı yasal tecviz sınırının üzerinde çıkarsa bu fark hesaplama hatası değil, sınır kayması veya komşu tecavüzü anlamına gelir ve 41. Madde ya da tapu düzeltme işlemi gerektirir."
      }
    }
  ]
}
    </script>
    <script type="application/ld+json">{"@context": "https://schema.org", "@type": "WebPage", "speakable": {"@type": "SpeakableSpecification", "cssSelector": ["h1", ".lead", ".summary-box", ".hero-desc", "main p"]}, "isBasedOn": "https://www.parselsorgu.net/api/2026-kadastro-endeks.json", "publisher": {"@type": "Organization", "name": "Ant Harita Mühendislik - ParselSorgu.net", "url": "https://www.parselsorgu.net/"}}</script>
</head>
<body>
    <?= render_saas_navbar('parsel') ?>
    <main class="container">
        <section class="hero">
            <div class="hero-badge"><i class="fa-solid fa-triangle-exclamation"></i> 3402 Sayılı Kadastro Kanunu 22/A, 12. &amp; 41. Maddeler</div>
            <h1>Kadastro Sınır Hatası &amp; <span>22/A İtiraz Motoru</span></h1>
            <p>Tapu yüzölçümünüz kadastro yenilemesinde değiştiyse yasal tecviz (yanılma) sınırını aşıp aşmadığını kontrol edin ve 41. Madde Teknik Hata İtiraz Dilekçesi hazırlayın.</p>
        </section>

        <div class="calc-grid">
            <div class="panel">
                <h2 class="panel-title"><i class="fa-solid fa-ruler" style="color:var(--accent);"></i> Tapu &amp; Ölçüm Verileri</h2>
                <div class="form-group">
                    <label>Eski Tapuda Yazan Alan (m²)</label>
                    <input type="number" id="eskiAlan" value="10000" oninput="calcTecviz()">
                </div>
                <div class="form-group">
                    <label>Yeni Ölçüm / 22/A Askı İlanı Alanı (m²)</label>
                    <input type="number" id="yeniAlan" value="9150" oninput="calcTecviz()">
                </div>
                <div class="form-group">
                    <label>Kadastro Kesinleşme / Askı Tarihi</label>
                    <input type="date" id="askiTarihi" onchange="calcTecviz()">
                </div>
                <div class="form-group">
                    <label>İl / İlçe / Ada / Parsel</label>
                    <input type="text" id="parselAd" value="Ankara Gölbaşı 120 Ada 4 Parsel" oninput="calcTecviz()">
                </div>
            </div>

            <div class="panel">
                <h2 class="panel-title"><i class="fa-solid fa-magnifying-glass-chart" style="color:var(--accent);"></i> Tecviz Analizi &amp; İtiraz Dilekçesi</h2>
                <div class="banner">
                    <div style="font-size:12px; color:var(--muted); font-weight:700;">ALAN FARKI &amp; YASAL TECVİZ SINIRI</div>
                    <div style="font-size:32px; font-weight:900; margin:6px 0;" id="farkYazi">-850 m² (TECVİZ DIŞI!)</div>
                    <div style="font-size:12.5px;" id="tecvizDetay">İzin Verilen Yasal Yanılma Payı: ±42 m²</div>
                </div>

                <div id="sureKutusu" style="background:rgba(56,189,248,0.1); border-left:4px solid var(--accent); padding:12px; border-radius:8px; font-size:12.5px; color:#bae6fd; margin-bottom:14px;"></div>

                <h4 style="font-size:13.5px; color:#fff;">📄 41. Madde Teknik Hata Düzeltme Dilekçesi Taslağı:</h4>
                <div class="draft-box" id="dilekceMetni"></div>
                <button type="button" class="btn-copy" onclick="navigator.clipboard.writeText(document.getElementById('dilekceMetni').innerText); alert('Dilekçe panoya kopyalandı!');"><i class="fa-solid fa-copy"></i> Dilekçeyi Kopyala</button>
            </div>
        </div>
    
        <section style="margin-top:36px; background:#111827; border:1px solid #1f2937; border-radius:16px; padding:24px;">
            <h2 style="font-size:19px; font-weight:800; color:#fff; margin-bottom:16px;"><i class="fa-solid fa-book-open" style="color:#10b981;"></i> Sıkça Sorulan Sorular &amp; 2026 Mevzuat Özeti</h2>
            
            <div style="margin-bottom:14px; border-bottom:1px solid #1f2937; padding-bottom:12px;">
                <h4 style="font-size:14.5px; color:#f8fafc; font-weight:700; margin-bottom:5px;"><i class="fa-solid fa-circle-question" style="color:#38bdf8;"></i> Kadastro yenilemesinde tarlam küçüldü ne yapmalıyım?</h4>
                <p style="font-size:13px; color:#9ca3af; line-height:1.6;">Askı ilanı süresindeki ilk 30 gün içinde Kadastro Mahkemesine dava açabilirsiniz. Askı süresi geçmişse 3402 s.K. 12. Madde gereği 10 yıllık hak düşürücü süre içinde dava açabilir veya teknik tersimat hataları için her zaman 41. Madde düzeltme dilekçesi verebilirsiniz.</p>
            </div>
            <div style="margin-bottom:14px; border-bottom:1px solid #1f2937; padding-bottom:12px;">
                <h4 style="font-size:14.5px; color:#f8fafc; font-weight:700; margin-bottom:5px;"><i class="fa-solid fa-circle-question" style="color:#38bdf8;"></i> Tecviz (yanılma) sınırı aşılırsa ne olur?</h4>
                <p style="font-size:13px; color:#9ca3af; line-height:1.6;">Ölçüm farkı yasal tecviz sınırının üzerinde çıkarsa bu fark hesaplama hatası değil, sınır kayması veya komşu tecavüzü anlamına gelir ve 41. Madde ya da tapu düzeltme işlemi gerektirir.</p>
            </div>
        </section>
    </main>
    <script>
        const dInit = new Date(); dInit.setDate(dInit.getDate() - 10);
        document.getElementById('askiTarihi').value = dInit.toISOString().split('T')[0];

        function calcTecviz() {
            const eski = parseFloat(document.getElementById('eskiAlan').value) || 0;
            const yeni = parseFloat(document.getElementById('yeniAlan').value) || 0;
            const fark = yeni - eski;
            const absFark = Math.abs(fark);

            // Standard BÖHHBÜY tolerance approximation
            const tecviz = Math.round(0.0004 * eski + 0.35 * Math.sqrt(eski));

            const farkEl = document.getElementById('farkYazi');
            if (absFark > tecviz) {
                farkEl.style.color = '#ef4444';
                farkEl.innerText = `${fark > 0 ? '+' : ''}${Math.round(fark)} m² (TECVİZ DIŞI HATA!)`;
            } else {
                farkEl.style.color = '#10b981';
                farkEl.innerText = `${fark > 0 ? '+' : ''}${Math.round(fark)} m² (Tecviz İçi Normal Fark)`;
            }
            document.getElementById('tecvizDetay').innerText = `Yasal Azami Yanılma Sınırı (Tecviz): ±${tecviz} m²`;

            const aski = new Date(document.getElementById('askiTarihi').value);
            const aski30 = new Date(aski); aski30.setDate(aski30.getDate() + 30);
            const hak10 = new Date(aski); hak10.setFullYear(hak10.getFullYear() + 10);
            const now = new Date();
            const gun30 = Math.ceil((aski30 - now) / (1000*60*60*24));

            document.getElementById('sureKutusu').innerHTML = gun30 > 0
                ? `<strong>⏰ 30 Günlük Askı İtiraz Süresi Açık!</strong> Kadastro Mahkemesine veya Komisyona itiraz için son <strong>${gun30} gün</strong> (${aski30.toLocaleDateString('tr-TR')}).`
                : `Askı süresi dolmuş; ancak 3402 m.12 gereği <strong>${hak10.toLocaleDateString('tr-TR')}</strong> tarihine kadar Asliye Hukuk'ta dava ve her zaman <strong>41. Madde İdari Başvuru</strong> hakkınız saklıdır.`;

            const pAd = document.getElementById('parselAd').value;
            document.getElementById('dilekceMetni').innerText = `T.C. KADASTRO MÜDÜRLÜĞÜNE

Konu: ${pAd} sayılı taşınmazda 3402 s.K. 41. Madde uyarınca yüzölçümü / sınır teknik hatasının düzeltilmesi talebi.

Maliki bulunduğum ${pAd} parselinin önceki tapu yüzölçümü ${eski} m² iken yapılan ölçüm/yenileme sonucunda ${yeni} m² olarak (${Math.round(absFark)} m² tecviz dışı farkla) tespit edildiği görülmüştür. Zemindeki fiili sınırlarım sabit olup ölçüm/tersimat hatasının 3402 sayılı Kanunun 41. maddesi gereğince incelenerek düzeltilmesini arz ederim.`;
        }
        calcTecviz();
    </script>
</body>
</html>
