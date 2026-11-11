<?php
/**
 * ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ - PARSEL PRO
 * Tarla, Tiny House & Villa Elektrik Bağlatma + Direk / Trafo Maliyet Motoru
 */
require_once __DIR__ . '/navbar.php';

$page_title = "2026 Tarlaya Elektrik Bağlatma Maliyeti | ParselSorgu";
$page_desc = "Tarlaya veya bağ evine elektrik çekme maliyeti, direk adedi, EDAŞ proje bedeli ve tarımsal sulama abonelik şartlarını hesaplayın.";
$canonical_url = "https://www.parselsorgu.net/tarla-elektrik-baglatma-maliyeti";
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
        :root { --bg:#0a0f1d; --card:#111827; --border:#1f2937; --accent:#facc15; --emerald:#10b981; --cyan:#38bdf8; --text:#f3f4f6; --muted:#9ca3af; }
        * { box-sizing:border-box; margin:0; padding:0; }
        body { background:var(--bg); color:var(--text); font-family:'Inter', sans-serif; line-height:1.6; padding-bottom:60px; }
        .container { max-width:1180px; margin:0 auto; padding:24px 16px; }
        .hero { text-align:center; padding:32px 16px 24px; }
        .hero-badge { display:inline-flex; align-items:center; gap:8px; background:rgba(250,204,21,0.15); color:var(--accent); padding:6px 14px; border-radius:9999px; font-size:13px; font-weight:700; margin-bottom:12px; border:1px solid rgba(250,204,21,0.3); }
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
        .alert-solar { background:rgba(16,185,129,0.12); border-left:4px solid var(--emerald); padding:14px; border-radius:8px; margin-top:16px; font-size:12.5px; color:#6ee7b7; }
    </style>
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "WebApplication",
      "name": "Tarla Elektrik Bağlatma & Direk Maliyeti Motoru",
      "url": "https://www.parselsorgu.net/tarla-elektrik-baglatma-maliyeti",
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
      "name": "Yapı ruhsatı olmayan tarlaya şebeke elektriği bağlanır mı?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Hayır. EDAŞ / TEDAŞ yönetmelikleri gereğince resmi yapı ruhsatı veya DSİ yeraltı suyu kullanma belgesi olmayan ham tarlaya kalıcı elektrik aboneliği verilmez; çözüm olarak Off-Grid güneş enerjisi sistemi kullanılır."
      }
    },
    {
      "@type": "Question",
      "name": "Özel trafo ne zaman gerekir?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "En yakın alçak gerilim hattı çok uzaksa veya tarımsal sulama/tesis ihtiyacı 35-50 kW gücünü aşıyorsa yatırımcının kendi özel trafosunu ve enerji nakil hattını tesis etmesi gerekir."
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
            <div class="hero-badge"><i class="fa-solid fa-bolt"></i> TEDAŞ / EDAŞ 2026 Hat Çekme &amp; Abonelik Hesaplayıcı</div>
            <h1>Tarla Elektrik Bağlatma &amp; <span>Direk Maliyeti</span></h1>
            <p>En yakın elektrik hattından arsanıza veya tarlanıza elektrik çekmek için gereken direk sayısını, EDAŞ proje giderini ve özel trafo maliyetini anında hesaplayın.</p>
        </section>

        <div class="calc-grid">
            <div class="panel">
                <h2 class="panel-title"><i class="fa-solid fa-tower-broadcast" style="color:var(--accent);"></i> Hat &amp; Abonelik Bilgileri</h2>
                <div class="form-group">
                    <label>En Yakın Elektrik Direğine Mesafe (Metre)</label>
                    <input type="number" id="hatMesafe" value="250" min="15" step="10" oninput="calcElec()">
                </div>
                <div class="form-group">
                    <label>Talep Edilen Enerji &amp; Faz Gücü</label>
                    <select id="fazGuc" onchange="calcElec()">
                        <option value="monofaze">Monofaze (Ev / Tiny House / Hobi - 15 kW'a kadar)</option>
                        <option value="trifaze" selected>Trifaze Sanayi/Tarım (Dalgıç Pompa - 35 kW'a kadar)</option>
                        <option value="trafo">Özel Trafo Tesisi (50 kVA / 100 kVA Çiftlik &amp; Tesis)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Direk &amp; Kablo Montaj Türü</label>
                    <select id="direkTur" onchange="calcElec()">
                        <option value="ag_demir">AG Galvaniz / Demir Direk + Alüminyum İletken (40m ara)</option>
                        <option value="beton">AG/OG Beton Direk + Yeraltı/Havai Kablo (50m ara)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Resmi Abonelik Belgesi Durumu</label>
                    <select id="belgeDurum" onchange="calcElec()">
                        <option value="ruhsat_var">Yapı Ruhsatım veya DSİ Kuyu Ruhsatım Var</option>
                        <option value="ruhsat_yok">Henüz Yapı/Kuyu Ruhsatım Yok (Sadece Tarla)</option>
                    </select>
                </div>
            </div>

            <div class="panel">
                <h2 class="panel-title"><i class="fa-solid fa-file-invoice-dollar" style="color:var(--accent);"></i> 2026 Hat &amp; Abonelik Maliyeti</h2>
                <div class="banner">
                    <div style="font-size:12px; color:var(--muted); font-weight:700;">TAHMİNİ ANAHTAR TESLİM ELEKTRİK ÇEKME MALİYETİ</div>
                    <div class="banner-val" id="toplamElec">194.500 TL</div>
                    <div style="font-size:12.5px; color:var(--cyan);">Gereken Direk: <strong id="direkSayi">7 Adet Direk</strong></div>
                </div>

                <div class="row"><span style="color:var(--muted);">Elektrik Direkleri &amp; Dikim İşçiliği:</span><strong id="direkTutar">112.000 TL</strong></div>
                <div class="row"><span style="color:var(--muted);">Enerji Kablosu, Aksesuar &amp; Pano:</span><strong id="kabloTutar">47.500 TL</strong></div>
                <div class="row"><span style="color:var(--muted);">EDAŞ Proje, Harita Güzergah &amp; Mühendislik Onayı:</span><strong id="projeTutar">35.000 TL</strong></div>
                <div class="row"><span style="color:var(--muted);">Özel Trafo Maliyeti (Varsa):</span><strong id="trafoTutar">0 TL (Mevcut Trafo)</strong></div>

                <div id="ruhsatUyari" class="alert-solar">
                    <!-- JS populates -->
                </div>
            </div>
        </div>
    
        <section style="margin-top:36px; background:#111827; border:1px solid #1f2937; border-radius:16px; padding:24px;">
            <h2 style="font-size:19px; font-weight:800; color:#fff; margin-bottom:16px;"><i class="fa-solid fa-book-open" style="color:#10b981;"></i> Sıkça Sorulan Sorular &amp; 2026 Mevzuat Özeti</h2>
            
            <div style="margin-bottom:14px; border-bottom:1px solid #1f2937; padding-bottom:12px;">
                <h4 style="font-size:14.5px; color:#f8fafc; font-weight:700; margin-bottom:5px;"><i class="fa-solid fa-circle-question" style="color:#38bdf8;"></i> Yapı ruhsatı olmayan tarlaya şebeke elektriği bağlanır mı?</h4>
                <p style="font-size:13px; color:#9ca3af; line-height:1.6;">Hayır. EDAŞ / TEDAŞ yönetmelikleri gereğince resmi yapı ruhsatı veya DSİ yeraltı suyu kullanma belgesi olmayan ham tarlaya kalıcı elektrik aboneliği verilmez; çözüm olarak Off-Grid güneş enerjisi sistemi kullanılır.</p>
            </div>
            <div style="margin-bottom:14px; border-bottom:1px solid #1f2937; padding-bottom:12px;">
                <h4 style="font-size:14.5px; color:#f8fafc; font-weight:700; margin-bottom:5px;"><i class="fa-solid fa-circle-question" style="color:#38bdf8;"></i> Özel trafo ne zaman gerekir?</h4>
                <p style="font-size:13px; color:#9ca3af; line-height:1.6;">En yakın alçak gerilim hattı çok uzaksa veya tarımsal sulama/tesis ihtiyacı 35-50 kW gücünü aşıyorsa yatırımcının kendi özel trafosunu ve enerji nakil hattını tesis etmesi gerekir.</p>
            </div>
        </section>
    </main>
    <script>
        function calcElec() {
            const mesafe = parseFloat(document.getElementById('hatMesafe').value) || 0;
            const faz = document.getElementById('fazGuc').value;
            const dir = document.getElementById('direkTur').value;
            const belge = document.getElementById('belgeDurum').value;

            const aralik = dir === 'ag_demir' ? 40 : 50;
            const direkAdet = Math.max(1, Math.ceil(mesafe / aralik));

            const direkBirim = dir === 'ag_demir' ? 16000 : 21000;
            const direkBedel = direkAdet * direkBirim;

            let kabloBirim = faz === 'monofaze' ? 130 : 190;
            if (faz === 'trafo') kabloBirim = 260;
            const kabloBedel = (mesafe * kabloBirim) + 12000;

            const projeBedel = faz === 'trafo' ? 65000 : 35000;
            const trafoBedel = faz === 'trafo' ? 385000 : 0;

            const toplam = direkBedel + kabloBedel + projeBedel + trafoBedel;

            document.getElementById('direkSayi').innerText = direkAdet + ' Adet Direk (' + mesafe + 'm Hat)';
            document.getElementById('direkTutar').innerText = Math.round(direkBedel).toLocaleString('tr-TR') + ' TL';
            document.getElementById('kabloTutar').innerText = Math.round(kabloBedel).toLocaleString('tr-TR') + ' TL';
            document.getElementById('projeTutar').innerText = Math.round(projeBedel).toLocaleString('tr-TR') + ' TL';
            document.getElementById('trafoTutar').innerText = trafoBedel > 0 ? Math.round(trafoBedel).toLocaleString('tr-TR') + ' TL' : '0 TL (Şebeke Trafosu)';
            document.getElementById('toplamElec').innerText = Math.round(toplam).toLocaleString('tr-TR') + ' TL';

            const box = document.getElementById('ruhsatUyari');
            if (belge === 'ruhsat_yok') {
                box.style.background = 'rgba(239,68,68,0.12)';
                box.style.borderLeftColor = '#ef4444';
                box.style.color = '#fca5a5';
                box.innerHTML = '<strong>⚠️ ABONELİK ENGELİ:</strong> Yapı ruhsatı veya DSİ su kullanma ruhsatı olmayan ham tarlaya EDAŞ şebeke elektriği vermez! Ancak <strong>Off-Grid Güneş Enerjisi Sistemi (Akülü Solar Paket)</strong> ile ~95.000 TL bütçeye ruhsatsız elektrik üretebilirsiniz.';
            } else {
                box.style.background = 'rgba(16,185,129,0.12)';
                box.style.borderLeftColor = '#10b981';
                box.style.color = '#6ee7b7';
                box.innerHTML = '<strong>✅ YASAL ABONELİK UYGUN:</strong> Resmi ruhsatınız mevcut olduğu için 100-150m yakında direk varsa standart bağlantı ile, uzaktaysa enerji nakil hattı projesiyle abonelik bağlanabilir.';
            }
        }
        calcElec();
    </script>
</body>
</html>
