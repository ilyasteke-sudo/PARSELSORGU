<?php
/**
 * ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ - PARSEL PRO
 * Hisseli Tapularda Ön Alım (Şufa) Hakkı Süre, Risk & Noter İhtarname Motoru
 */
require_once __DIR__ . '/navbar.php';

$page_title = "Hisseli Tapuda Şufa Hakkı & Süre Hesaplama | ParselSorgu";
$page_desc = "TMK Madde 733 uyarınca hisseli tapuda şufa hakkı (ön alım) 90 günlük ve 2 yıllık dava süresi hesaplama ve noter ihtarname taslağı.";
$canonical_url = "https://www.parselsorgu.net/sufa-on-alim-hakki";
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($page_title) ?></title>
    <meta name="description" content="<?= htmlspecialchars($page_desc) ?>">
    <link rel="canonical" href="<?= $canonical_url ?>">
    <meta property="og:image" content="https://www.parselsorgu.net/assets/images/og-parsel.jpg">
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?= htmlspecialchars($page_title) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($page_desc) ?>">
    <meta property="og:url" content="<?= $canonical_url ?>">
    <meta name="twitter:card" content="summary_large_image">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root { --bg:#0a0f1d; --card:#111827; --border:#1f2937; --accent:#a855f7; --emerald:#10b981; --danger:#ef4444; --amber:#f59e0b; --text:#f3f4f6; --muted:#9ca3af; }
        * { box-sizing:border-box; margin:0; padding:0; }
        body { background:var(--bg); color:var(--text); font-family:'Inter', sans-serif; line-height:1.6; padding-bottom:60px; }
        .container { max-width:1180px; margin:0 auto; padding:24px 16px; }
        .hero { text-align:center; padding:32px 16px 24px; }
        .hero-badge { display:inline-flex; align-items:center; gap:8px; background:rgba(168,85,247,0.15); color:var(--accent); padding:6px 14px; border-radius:9999px; font-size:13px; font-weight:700; margin-bottom:12px; border:1px solid rgba(168,85,247,0.3); }
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
        .status-card { background:#1a2234; border:1px solid #283548; border-radius:12px; padding:20px; text-align:center; margin-bottom:18px; }
        .days-big { font-size:38px; font-weight:900; margin:6px 0; }
        .draft-box { background:#060c18; border:1px solid #374151; border-radius:10px; padding:16px; font-family:monospace; font-size:12.5px; color:#cbd5e1; white-space:pre-wrap; line-height:1.5; margin-top:12px; }
        .btn-copy { background:var(--accent); color:#fff; border:none; padding:10px 18px; border-radius:8px; font-weight:700; font-size:13px; cursor:pointer; margin-top:10px; display:inline-flex; align-items:center; gap:8px; }
    </style>
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "WebApplication",
      "name": "Hisseli Tapu Şufa (Ön Alım) Süre & İhtarname Motoru",
      "url": "https://www.parselsorgu.net/sufa-on-alim-hakki",
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
      "name": "Hisseli tapuda şufa (ön alım) davası süresi ne kadardır?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Türk Medeni Kanunu Madde 733 uyarınca hisse satışı diğer hissedarlara noter aracılığıyla bildirilirse 3 ay (90 gün), noter bildirimi yapılmazsa satış tarihinden itibaren 2 yıl içinde şufa davası açılabilir."
      }
    },
    {
      "@type": "Question",
      "name": "Tapuda düşük bedel gösterilmesi alıcı için neden tehlikelidir?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Diğer hissedarlar şufa davası açtığında, hisseyi satın alan kişiye yalnızca tapu senedinde resmi olarak yazılı olan satış bedelini ve tapu harçlarını ödeyerek hissenin mülkiyetini devralabilirler."
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
            <div class="hero-badge"><i class="fa-solid fa-handshake"></i> TMK Madde 732 - 733 - 734 &amp; Yargıtay İçtihatları</div>
            <h1>Hisseli Tapu <span>Şufa (Ön Alım) Risk Motoru</span></h1>
            <p>Hisseli tarla veya arsa satın aldığınızda diğer hissedarların hissenizi tapu bedelinden geri alma (Şufa Davası) süresini hesaplayın ve Noter İhtarname taslağı oluşturun.</p>
        </section>

        <div class="calc-grid">
            <div class="panel">
                <h2 class="panel-title"><i class="fa-solid fa-calendar-days" style="color:var(--accent);"></i> Satış &amp; Bildirim Bilgileri</h2>
                <div class="form-group">
                    <label>Tapuda Hisse Satış (Tescil) Tarihi</label>
                    <input type="date" id="satisTarihi" onchange="calcSufa()">
                </div>
                <div class="form-group">
                    <label>Diğer Hissedarlara Noter İhtarnamesi Çekildi mi?</label>
                    <select id="noterDurum" onchange="toggleNoter()">
                        <option value="hayir" selected>Hayır — Noter Bildirimi Yapılmadı (2 Yıl Risk)</option>
                        <option value="evet">Evet — Noter Üzerinden Tebligat Yapıldı (3 Ay)</option>
                    </select>
                </div>
                <div class="form-group" id="tebligBox" style="display:none;">
                    <label>Noter İhtarının Hissedara Tebliğ Tarihi</label>
                    <input type="date" id="tebligTarihi" onchange="calcSufa()">
                </div>
                <div class="form-group">
                    <label>Tapuda Beyan Edilen Satış Bedeli (TL)</label>
                    <input type="number" id="tapuBedeli" value="850000" step="50000" oninput="calcSufa()">
                </div>
                <div class="form-group">
                    <label>Gerçek Piyasa Değeri (TL)</label>
                    <input type="number" id="gercekBedel" value="1800000" step="50000" oninput="calcSufa()">
                </div>
                <div class="form-group">
                    <label>Ada / Parsel ve Alıcı Adı (İhtarname İçin)</label>
                    <input type="text" id="parselBilgi" value="Ankara Çankaya 101 Ada 5 Parsel - Alıcı: Ali Yılmaz" oninput="calcSufa()">
                </div>
            </div>

            <div class="panel">
                <h2 class="panel-title"><i class="fa-solid fa-gavel" style="color:var(--accent);"></i> Hukuki Süre &amp; Noter İhtarnamesi</h2>
                <div class="status-card">
                    <div style="font-size:12px; color:var(--muted); font-weight:700;">ŞUFA DAVASI HAK DÜŞÜRÜCÜ SÜRESİ</div>
                    <div class="days-big" id="kalanGun" style="color:var(--danger);">540 Gün Kaldı</div>
                    <div style="font-size:13px;" id="sonTarihBilgi">Son Dava Açma Tarihi: <strong>...</strong></div>
                </div>

                <div id="zararUyarisi" style="background:rgba(239,68,68,0.1); border-left:4px solid var(--danger); padding:12px; border-radius:8px; font-size:12.5px; color:#fca5a5; margin-bottom:16px;">
                    <!-- JS populates -->
                </div>

                <h4 style="font-size:13.5px; color:#fff;">📄 Hazır TMK m.733 Noter İhtarname Taslağı:</h4>
                <div class="draft-box" id="ihtarMetni"></div>
                <button type="button" class="btn-copy" onclick="copyDraft()"><i class="fa-solid fa-copy"></i> İhtarname Metnini Kopyala</button>
            </div>
        </div>
    
        <section style="margin-top:36px; background:#111827; border:1px solid #1f2937; border-radius:16px; padding:24px;">
            <h2 style="font-size:19px; font-weight:800; color:#fff; margin-bottom:16px;"><i class="fa-solid fa-book-open" style="color:#10b981;"></i> Sıkça Sorulan Sorular &amp; 2026 Mevzuat Özeti</h2>
            
            <div style="margin-bottom:14px; border-bottom:1px solid #1f2937; padding-bottom:12px;">
                <h4 style="font-size:14.5px; color:#f8fafc; font-weight:700; margin-bottom:5px;"><i class="fa-solid fa-circle-question" style="color:#38bdf8;"></i> Hisseli tapuda şufa (ön alım) davası süresi ne kadardır?</h4>
                <p style="font-size:13px; color:#9ca3af; line-height:1.6;">Türk Medeni Kanunu Madde 733 uyarınca hisse satışı diğer hissedarlara noter aracılığıyla bildirilirse 3 ay (90 gün), noter bildirimi yapılmazsa satış tarihinden itibaren 2 yıl içinde şufa davası açılabilir.</p>
            </div>
            <div style="margin-bottom:14px; border-bottom:1px solid #1f2937; padding-bottom:12px;">
                <h4 style="font-size:14.5px; color:#f8fafc; font-weight:700; margin-bottom:5px;"><i class="fa-solid fa-circle-question" style="color:#38bdf8;"></i> Tapuda düşük bedel gösterilmesi alıcı için neden tehlikelidir?</h4>
                <p style="font-size:13px; color:#9ca3af; line-height:1.6;">Diğer hissedarlar şufa davası açtığında, hisseyi satın alan kişiye yalnızca tapu senedinde resmi olarak yazılı olan satış bedelini ve tapu harçlarını ödeyerek hissenin mülkiyetini devralabilirler.</p>
            </div>
        </section>
    </main>
    <script>
        // Default dates
        const today = new Date();
        const past = new Date();
        past.setMonth(past.getMonth() - 3);
        document.getElementById('satisTarihi').value = past.toISOString().split('T')[0];
        document.getElementById('tebligTarihi').value = today.toISOString().split('T')[0];

        function toggleNoter() {
            const v = document.getElementById('noterDurum').value;
            document.getElementById('tebligBox').style.display = v === 'evet' ? 'block' : 'none';
            calcSufa();
        }
        function calcSufa() {
            const satis = new Date(document.getElementById('satisTarihi').value);
            const noter = document.getElementById('noterDurum').value === 'evet';
            const teblig = new Date(document.getElementById('tebligTarihi').value);
            const tapuB = parseFloat(document.getElementById('tapuBedeli').value) || 0;
            const gercekB = parseFloat(document.getElementById('gercekBedel').value) || 0;
            const parsel = document.getElementById('parselBilgi').value;

            let deadline = new Date(satis);
            deadline.setFullYear(deadline.getFullYear() + 2); // 2 year absolute limit

            if (noter && !isNaN(teblig.getTime())) {
                let d3 = new Date(teblig);
                d3.setMonth(d3.getMonth() + 3); // 3 months from notary notification
                if (d3 < deadline) deadline = d3;
            }

            const now = new Date();
            const diffDays = Math.ceil((deadline - now) / (1000 * 60 * 60 * 24));
            const kalanEl = document.getElementById('kalanGun');

            if (diffDays <= 0) {
                kalanEl.innerText = 'SÜRE DOLDU (GÜVENDESİNİZ)';
                kalanEl.style.color = '#10b981';
            } else {
                kalanEl.innerText = diffDays + ' Gün Risk Var';
                kalanEl.style.color = diffDays > 180 ? '#ef4444' : '#f59e0b';
            }
            document.getElementById('sonTarihBilgi').innerHTML = 'Hak Düşürücü Son Tarih: <strong>' + deadline.toLocaleDateString('tr-TR') + '</strong>';

            const fark = Math.max(0, gercekB - tapuB);
            const uyari = document.getElementById('zararUyarisi');
            if (fark > 0) {
                uyari.innerHTML = `<strong>⚠️ BEDEL FARKI RİSKİ:</strong> Diğer hissedarlar dava açarsa taşınmazı sizden <strong>${tapuB.toLocaleString('tr-TR')} TL</strong> (+ harç) ödeyerek alabilir. Potansiyel sermaye kaybınız: <strong>${fark.toLocaleString('tr-TR')} TL</strong>! Derhal Noterden 3 aylık süre başlatan ihtar çekin.`;
            } else {
                uyari.style.background = 'rgba(16,185,129,0.1)';
                uyari.style.borderLeftColor = '#10b981';
                uyari.style.color = '#6ee7b7';
                uyari.innerHTML = `Tapuda gerçek değer beyan edilmiş. Yine de 2 yıl beklememek için Noterden 3 aylık süreyi başlatmanız tavsiye edilir.`;
            }

            document.getElementById('ihtarMetni').innerText = `İHTARNAME (TMK Madde 733 Uyarınca Ön Alım Bildirimi)
Konu: Hisseli Taşınmaz Satışının Bildirilmesi Hakkında.

Sayın Hissedar (Muhatap),
${parsel} nitelikli taşınmazdaki satıcıya ait hisse tarafımdan ${satis.toLocaleDateString('tr-TR')} tarihinde tapuda ${tapuB.toLocaleString('tr-TR')} TL bedel ile satın alınarak tescil edilmiştir.

Türk Medeni Kanunu'nun 733. maddesi gereğince; işbu noter ihtarnamesinin tarafınıza tebliğinden itibaren 3 (üç) ay içinde yasal ön alım (şufa) hakkınızı kullanmadığınız takdirde ön alım hakkınızın düşeceğini ihtaren bildiririm.`;
        }
        function copyDraft() {
            navigator.clipboard.writeText(document.getElementById('ihtarMetni').innerText);
            alert('Noter ihtarname taslağı panoya kopyalandı!');
        }
        calcSufa();
    </script>
</body>
</html>
