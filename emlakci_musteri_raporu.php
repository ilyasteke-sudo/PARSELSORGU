<?php
/**
 * ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ - PARSEL PRO
 * Emlak Danışmanları İçin Kendi Ofis İsimli (White-Label) Müşteri Parsel Sunum Dosyası
 */
require_once __DIR__ . '/navbar.php';

$page_title = "Emlakçı Logolu Arsa Müşteri Sunum Raporu | ParselSorgu";
$page_desc = "Emlak danışmanları için antetli, QR kod doğrulamalı ve m² fiyat analizli A4 arsa yatırım sunum raporu hazırlama motoru.";
$canonical_url = "https://www.parselsorgu.net/emlakci-musteri-raporu";
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
        :root { --bg:#0a0f1d; --card:#111827; --border:#1f2937; --accent:#10b981; --cyan:#38bdf8; --text:#f3f4f6; --muted:#9ca3af; }
        * { box-sizing:border-box; margin:0; padding:0; }
        body { background:var(--bg); color:var(--text); font-family:'Inter', sans-serif; line-height:1.5; padding-bottom:60px; }
        .container { max-width:1280px; margin:0 auto; padding:24px 16px; }
        .hero { text-align:center; padding:24px 16px 20px; }
        .hero h1 { font-size:28px; font-weight:800; color:#fff; margin-bottom:8px; }
        .hero h1 span { color:var(--accent); }
        .hero p { font-size:14.5px; color:var(--muted); max-width:740px; margin:0 auto; }

        .split-grid { display:grid; grid-template-columns: 390px 1fr; gap:24px; margin-top:20px; align-items:start; }
        @media (max-width: 980px) { .split-grid { grid-template-columns: 1fr; } }
        .form-panel { background:var(--card); border:1px solid var(--border); border-radius:16px; padding:22px; }
        .form-group { margin-bottom:12px; }
        .form-group label { display:block; font-size:12px; font-weight:600; margin-bottom:5px; color:var(--text); }
        .form-group input, .form-group select, .form-group textarea { width:100%; padding:9px 11px; background:#1f2937; border:1px solid #374151; border-radius:8px; color:#fff; font-size:13.5px; outline:none; }
        .btn-print { width:100%; background:linear-gradient(135deg, #10b981 0%, #059669 100%); color:#fff; border:none; padding:12px; border-radius:10px; font-weight:800; font-size:14.5px; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:8px; margin-top:10px; }

        /* A4 WHITE-LABEL SHEET */
        .a4-sheet { background:#ffffff; color:#0f172a; border-radius:8px; padding:36px 40px; box-shadow:0 20px 50px rgba(0,0,0,0.6); min-height:760px; display:flex; flex-direction:column; justify-content:space-between; }
        .a4-header { display:flex; justify-content:space-between; align-items:center; border-bottom:3px solid #0f172a; padding-bottom:16px; margin-bottom:24px; }
        .a4-brand h2 { font-size:22px; font-weight:900; color:#0f172a; margin:0; text-transform:uppercase; letter-spacing:-0.02em; }
        .a4-brand span { font-size:13px; color:#475569; font-weight:600; }
        .a4-meta-grid { display:grid; grid-template-columns:repeat(3, 1fr); gap:14px; margin-bottom:22px; }
        .a4-box { background:#f8fafc; border:1px solid #cbd5e1; border-radius:8px; padding:12px 14px; }
        .a4-box small { display:block; font-size:11px; color:#64748b; font-weight:700; text-transform:uppercase; }
        .a4-box strong { display:block; font-size:16px; color:#0f172a; font-weight:800; margin-top:2px; }
        .a4-notes { background:#f1f5f9; border-left:4px solid #0284c7; padding:16px; border-radius:6px; font-size:13.5px; color:#1e293b; margin-bottom:24px; line-height:1.65; }
        .a4-footer { border-top:1px solid #cbd5e1; padding-top:14px; display:flex; justify-content:space-between; align-items:center; font-size:11.5px; color:#64748b; }

        @media print {
            body { background:#fff !important; padding:0 !important; }
            header, .saas-2026-header, .saas-mobile-bottom-bar, .hero, .form-panel { display:none !important; }
            .container, .split-grid { display:block !important; max-width:100% !important; margin:0 !important; padding:0 !important; }
            .a4-sheet { box-shadow:none !important; border:none !important; padding:15mm !important; min-height:auto !important; }
        }
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
      "name": "White-Label emlakçı raporu ücretsiz midir?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Evet. Tüm emlak ofisleri ve arsa danışmanları kendi marka adını, logosunu ve iletişim bilgilerini girerek sınırsız sayıda müşteriye özel A4 PDF sunum dosyası hazırlayabilir."
      }
    },
    {
      "@type": "Question",
      "name": "Hazırlanan sunum dosyasındaki QR kod ne işe yarar?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Rapordaki QR kod, müşterinin akıllı telefonuyla ParselSorgu.net üzerindeki güncel kadastro doğrulama ve uydu haritası altyapısına doğrudan erişmesini sağlar."
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
            <h1>Emlak Ofisleri İçin <span>White-Label Parsel Sunum Dosyası</span></h1>
            <p>Kendi ofis adınızı, logonuzu ve satış fiyatınızı girerek müşterilerinize WhatsApp veya elden verebileceğiniz profesyonel A4 Arsa Sunum Raporu (PDF) hazırlayın.</p>
        </section>

        <div class="split-grid">
            <!-- FORM -->
            <div class="form-panel">
                <div class="form-group">
                    <label>Emlak Ofisi / Marka Adınız</label>
                    <input type="text" id="inOfis" value="ANADOLU ARSA &amp; YATIRIM A.Ş." oninput="updateSheet()">
                </div>
                <div class="form-group">
                    <label>Danışman Adı &amp; Telefonu</label>
                    <input type="text" id="inDanisman" value="Murat Kaya | 0532 111 22 33" oninput="updateSheet()">
                </div>
                <div class="form-group">
                    <label>Kurumsal Renk Teması</label>
                    <select id="inRenk" onchange="updateSheet()">
                        <option value="#0f172a">Kurumsal Lacivert</option>
                        <option value="#065f46">Zümrüt Yeşili</option>
                        <option value="#1e3a8a">Kraliyet Mavisi</option>
                        <option value="#7c2d12">Toprak &amp; Bronz</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Ofis Logosu Yükle (İsteğe Bağlı PNG/JPG)</label>
                    <input type="file" id="inLogo" accept="image/*" onchange="loadLogo(this)">
                </div>
                <hr style="border:0; border-top:1px solid #1f2937; margin:14px 0;">
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                    <div class="form-group">
                        <label>İl / İlçe</label>
                        <input type="text" id="inKonum" value="Ankara / Akyurt" oninput="updateSheet()">
                    </div>
                    <div class="form-group">
                        <label>Mahalle / Köy</label>
                        <input type="text" id="inMahalle" value="Ahmet Adil Mah." oninput="updateSheet()">
                    </div>
                </div>
                <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:8px;">
                    <div class="form-group"><label>Ada</label><input type="text" id="inAda" value="3425" oninput="updateSheet()"></div>
                    <div class="form-group"><label>Parsel</label><input type="text" id="inParsel" value="9" oninput="updateSheet()"></div>
                    <div class="form-group"><label>Alan (m²)</label><input type="number" id="inAlan" value="6850" oninput="updateSheet()"></div>
                </div>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                    <div class="form-group"><label>Tapu Niteliği</label><input type="text" id="inNitelik" value="Tarla (Müstakil)" oninput="updateSheet()"></div>
                    <div class="form-group"><label>Satış Fiyatı (TL)</label><input type="number" id="inFiyat" value="8500000" step="50000" oninput="updateSheet()"></div>
                </div>
                <div class="form-group">
                    <label>Yatırım &amp; İmar Notları</label>
                    <textarea id="inNotlar" rows="3" oninput="updateSheet()">Resmi kadastro yoluna cephelidir. 5.000 m² üzeri olduğu için Plansız Alanlar İmar Yönetmeliği kapsamında tarımsal yapı ve çiftlik evi şartlarına uygundur. Sanayi ve lojistik aksına 1.2 km mesafededir.</textarea>
                </div>
                <button type="button" class="btn-print" onclick="window.print()"><i class="fa-solid fa-file-pdf"></i> A4 PDF Olarak Kaydet / Yazdır</button>
            </div>

            <!-- A4 PREVIEW -->
            <div class="a4-sheet" id="a4Preview">
                <div>
                    <div class="a4-header" id="a4HeaderLine">
                        <div style="display:flex; align-items:center; gap:14px;">
                            <img id="a4LogoImg" src="" style="display:none; max-height:55px; max-width:140px; object-fit:contain;">
                            <div class="a4-brand">
                                <h2 id="outOfis">ANADOLU ARSA &amp; YATIRIM A.Ş.</h2>
                                <span id="outDanisman">Murat Kaya | 0532 111 22 33</span>
                            </div>
                        </div>
                        <div style="text-align:right;">
                            <div style="font-size:11px; font-weight:800; color:#64748b;">TAŞINMAZ YATIRIM SUNUMU</div>
                            <div style="font-size:13px; font-weight:700; color:#0f172a;"><?= date('d.m.Y') ?></div>
                        </div>
                    </div>

                    <div class="a4-meta-grid">
                        <div class="a4-box"><small>Konum</small><strong id="outKonum">Ankara / Akyurt</strong></div>
                        <div class="a4-box"><small>Mahalle / Köy</small><strong id="outMahalle">Ahmet Adil Mah.</strong></div>
                        <div class="a4-box"><small>Ada / Parsel</small><strong id="outAdaParsel">3425 / 9</strong></div>
                        <div class="a4-box"><small>Yüzölçümü</small><strong id="outAlan">6.850 m²</strong></div>
                        <div class="a4-box"><small>Tapu Niteliği</small><strong id="outNitelik">Tarla (Müstakil)</strong></div>
                        <div class="a4-box" style="background:#ecfdf5; border-color:#10b981;"><small style="color:#047857;">Satış Fiyatı</small><strong id="outFiyat" style="color:#065f46;">8.500.000 TL</strong></div>
                    </div>

                    <div style="background:#f8fafc; border:1px solid #cbd5e1; border-radius:8px; padding:12px 16px; margin-bottom:20px; display:flex; justify-content:space-between; align-items:center;">
                        <span style="font-size:13.5px; font-weight:700; color:#334155;">Birim Metrekare Maliyeti:</span>
                        <strong id="outM2Fiyat" style="font-size:16px; color:#0284c7;">1.241 TL / m²</strong>
                    </div>

                    <h3 style="font-size:14px; font-weight:800; color:#0f172a; margin-bottom:8px; text-transform:uppercase;">📌 Danışman Değerlendirmesi &amp; İmar Analizi</h3>
                    <div class="a4-notes" id="outNotlar"></div>
                </div>

                <div class="a4-footer">
                    <div>
                        <strong>Kadastro Sınır &amp; Harita Doğrulama Altyapısı:</strong><br>
                        ParselSorgu.net (TKGM MEGSİS Uydu &amp; CBS Platformu)
                    </div>
                    <img id="qrCodeImg" src="https://api.qrserver.com/v1/create-qr-code/?size=75x75&data=https://www.parselsorgu.net/" alt="QR Doğrulama" style="width:65px; height:65px; border:1px solid #cbd5e1; padding:2px; border-radius:4px;">
                </div>
            </div>
        </div>
    
        <section style="margin-top:36px; background:#111827; border:1px solid #1f2937; border-radius:16px; padding:24px;">
            <h2 style="font-size:19px; font-weight:800; color:#fff; margin-bottom:16px;"><i class="fa-solid fa-book-open" style="color:#10b981;"></i> Sıkça Sorulan Sorular &amp; 2026 Mevzuat Özeti</h2>
            
            <div style="margin-bottom:14px; border-bottom:1px solid #1f2937; padding-bottom:12px;">
                <h4 style="font-size:14.5px; color:#f8fafc; font-weight:700; margin-bottom:5px;"><i class="fa-solid fa-circle-question" style="color:#38bdf8;"></i> White-Label emlakçı raporu ücretsiz midir?</h4>
                <p style="font-size:13px; color:#9ca3af; line-height:1.6;">Evet. Tüm emlak ofisleri ve arsa danışmanları kendi marka adını, logosunu ve iletişim bilgilerini girerek sınırsız sayıda müşteriye özel A4 PDF sunum dosyası hazırlayabilir.</p>
            </div>
            <div style="margin-bottom:14px; border-bottom:1px solid #1f2937; padding-bottom:12px;">
                <h4 style="font-size:14.5px; color:#f8fafc; font-weight:700; margin-bottom:5px;"><i class="fa-solid fa-circle-question" style="color:#38bdf8;"></i> Hazırlanan sunum dosyasındaki QR kod ne işe yarar?</h4>
                <p style="font-size:13px; color:#9ca3af; line-height:1.6;">Rapordaki QR kod, müşterinin akıllı telefonuyla ParselSorgu.net üzerindeki güncel kadastro doğrulama ve uydu haritası altyapısına doğrudan erişmesini sağlar.</p>
            </div>
        </section>
    </main>
    <script>
        function loadLogo(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.getElementById('a4LogoImg');
                    img.src = e.target.result;
                    img.style.display = 'block';
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
        function updateSheet() {
            const renk = document.getElementById('inRenk').value;
            document.getElementById('a4HeaderLine').style.borderBottomColor = renk;
            document.getElementById('outOfis').style.color = renk;

            document.getElementById('outOfis').innerText = document.getElementById('inOfis').value;
            document.getElementById('outDanisman').innerText = document.getElementById('inDanisman').value;
            document.getElementById('outKonum').innerText = document.getElementById('inKonum').value;
            document.getElementById('outMahalle').innerText = document.getElementById('inMahalle').value;

            const ada = document.getElementById('inAda').value;
            const parsel = document.getElementById('inParsel').value;
            document.getElementById('outAdaParsel').innerText = ada + ' / ' + parsel;

            const alan = parseFloat(document.getElementById('inAlan').value) || 1;
            const fiyat = parseFloat(document.getElementById('inFiyat').value) || 0;
            const birim = fiyat / alan;

            document.getElementById('outAlan').innerText = alan.toLocaleString('tr-TR') + ' m²';
            document.getElementById('outNitelik').innerText = document.getElementById('inNitelik').value;
            document.getElementById('outFiyat').innerText = fiyat.toLocaleString('tr-TR') + ' TL';
            document.getElementById('outM2Fiyat').innerText = Math.round(birim).toLocaleString('tr-TR') + ' TL / m²';
            document.getElementById('outNotlar').innerText = document.getElementById('inNotlar').value;
        }
        updateSheet();
    </script>
</body>
</html>
