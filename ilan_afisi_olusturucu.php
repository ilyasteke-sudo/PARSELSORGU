<?php
/**
 * ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ - PARSEL PRO
 * MODÜL 4: EMLAKÇILAR İÇİN SOSYAL MEDYA İLAN AFİŞ & HİKAYE OLUŞTURUCU
 * URL: https://www.parselsorgu.net/ilan-afisi-olusturucu
 */
declare(strict_types=1);

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/navbar.php';

$page_title = "Emlakçı Arsa İlan Afişi Oluşturucu | ParselSorgu";
$meta_desc = "Arsa ve tarla ilanlarınız için tek tıkla Instagram, Story ve WhatsApp formatında karekodlu profesyonel harita afişi üretin.";
$canonical_url = "https://www.parselsorgu.net/ilan-afisi-olusturucu";
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title><?= htmlspecialchars($page_title) ?></title>
    <meta name="description" content="<?= htmlspecialchars($meta_desc) ?>">
    <link rel="canonical" href="<?= htmlspecialchars($canonical_url) ?>">
    <meta name="robots" content="index, follow">

    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?= htmlspecialchars($page_title) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($meta_desc) ?>">
    <meta property="og:url" content="<?= htmlspecialchars($canonical_url) ?>">
    <meta property="og:image" content="https://www.parselsorgu.net/assets/images/og-parsel.jpg">

    <!-- Fonts & Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/main.css?v=2026.49">

    <style>
        :root {
            --bg-dark: #070b14;
            --card-dark: #0f172a;
            --border-dark: rgba(56, 189, 248, 0.22);
            --primary-cyan: #38bdf8;
            --primary-blue: #0284c7;
        }
        body { font-family: 'Inter', -apple-system, sans-serif; background: var(--bg-dark); color: #f8fafc; margin: 0; padding: 0; }
        .afis-container { max-width: 1100px; margin: 0 auto; padding: 24px 16px 80px 16px; }
        .afis-hero { background: linear-gradient(135deg, rgba(15,23,42,0.98) 0%, rgba(30,41,59,0.95) 100%); border: 2px solid #0284c7; border-radius: 16px; padding: 28px; margin-bottom: 24px; box-shadow: 0 10px 40px rgba(2,132,199,0.18); }
        .afis-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; align-items: start; }
        .card-panel { background: var(--card-dark); border: 1px solid var(--border-dark); border-radius: 14px; padding: 24px; box-shadow: 0 10px 30px rgba(0,0,0,0.3); }
        .fg { margin-bottom: 14px; }
        .fl { font-size: 11.5px; font-weight: 700; color: #94a3b8; margin-bottom: 5px; display: block; }
        .fi { width: 100%; background: #070b14; border: 1px solid #334155; border-radius: 8px; padding: 9px 12px; color: #fff; font-size: 13px; box-sizing: border-box; }
        
        /* Canvas Preview Container */
        .canvas-wrap { background: #000; border-radius: 12px; overflow: hidden; border: 2px solid #38bdf8; box-shadow: 0 10px 35px rgba(0,0,0,0.6); display: flex; justify-content: center; align-items: center; padding: 10px; }
        #afisCanvas { max-width: 100%; height: auto; border-radius: 8px; display: block; }
        @media (max-width: 860px) {
            .afis-grid { grid-template-columns: 1fr; }
        }
    </style>
    <link rel="alternate" type="text/markdown" href="https://www.parselsorgu.net/llms.txt" title="ParselSorgu AI / LLM Bilgi Bankası">
    <link rel="alternate" type="application/json" href="https://www.parselsorgu.net/api/2026-kadastro-endeks.json" title="2026 Kadastro ve İmar Açık Veri Seti">
    <script type="application/ld+json">{"@context": "https://schema.org", "@type": "WebPage", "speakable": {"@type": "SpeakableSpecification", "cssSelector": ["h1", ".lead", ".summary-box", ".hero-desc", "main p"]}, "isBasedOn": "https://www.parselsorgu.net/api/2026-kadastro-endeks.json", "publisher": {"@type": "Organization", "name": "Ant Harita Mühendislik - ParselSorgu.net", "url": "https://www.parselsorgu.net/"}}</script>
</head>
<body>

    <?php render_saas_navbar('hesaplama'); ?>

    <main class="afis-container">
        <!-- Hero Section -->
        <section class="afis-hero">
            <div style="display:inline-flex; align-items:center; gap:8px; margin-bottom:10px;">
                <span style="background:rgba(2,132,199,0.2); border:1px solid #0284c7; color:#38bdf8; font-size:11px; font-weight:800; padding:4px 10px; border-radius:4px;">
                    <i class="fa-solid fa-bullhorn"></i> EMLAK &amp; DANIŞMANLIK ARACI
                </span>
                <span style="background:rgba(34,197,94,0.2); border:1px solid #22c55e; color:#4ade80; font-size:11px; font-weight:800; padding:4px 10px; border-radius:4px;">
                    INSTAGRAM &amp; WHATSAPP UYUMLU
                </span>
            </div>
            <h1 style="font-size:clamp(1.4rem, 2.8vw, 2rem); font-weight:900; color:#fff; margin:0 0 10px 0;">
                Arsa İlan Afişi &amp; Sosyal Medya Kartı Oluşturucu
            </h1>
            <p style="font-size:14px; color:#cbd5e1; margin:0; line-height:1.6; max-width:850px;">
                Portföyünüzdeki arsa ve tarlalar için tek tıkla profesyonel, doğrulanmış imar karekodlu afiş hazırlayın. WhatsApp durumlarında ve Instagram'da paylaşarak arsa satışlarınızı hızlandırın.
            </p>
        </section>

        <!-- Grid Layout -->
        <div class="afis-grid">
            <!-- Form Inputs -->
            <div class="card-panel">
                <h2 style="font-size:16px; font-weight:800; color:#fff; margin:0 0 16px 0; display:flex; align-items:center; gap:8px;">
                    <i class="fa-solid fa-pen-to-square" style="color:#38bdf8;"></i> İlan &amp; Parsel Detayları
                </h2>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                    <div class="fg">
                        <label class="fl">İl / Şehir *</label>
                        <input type="text" id="afis-city" class="fi" value="Ankara" oninput="renderPoster()">
                    </div>
                    <div class="fg">
                        <label class="fl">İlçe *</label>
                        <input type="text" id="afis-dist" class="fi" value="Gölbaşı" oninput="renderPoster()">
                    </div>
                </div>

                <div style="display:grid; grid-template-columns:1.2fr 1fr 1fr; gap:10px;">
                    <div class="fg">
                        <label class="fl">Mahalle</label>
                        <input type="text" id="afis-mah" class="fi" value="İncek" oninput="renderPoster()">
                    </div>
                    <div class="fg">
                        <label class="fl">Ada</label>
                        <input type="text" id="afis-ada" class="fi" value="124" oninput="renderPoster()">
                    </div>
                    <div class="fg">
                        <label class="fl">Parsel</label>
                        <input type="text" id="afis-parsel" class="fi" value="5" oninput="renderPoster()">
                    </div>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                    <div class="fg">
                        <label class="fl">Arsa Alanı (m²)</label>
                        <input type="text" id="afis-area" class="fi" value="750 m²" oninput="renderPoster()">
                    </div>
                    <div class="fg">
                        <label class="fl">Satış Fiyatı</label>
                        <input type="text" id="afis-price" class="fi" value="6.500.000 TL" oninput="renderPoster()">
                    </div>
                </div>

                <div class="fg">
                    <label class="fl">İmar Durumu / Başlık</label>
                    <input type="text" id="afis-imar" class="fi" value="2 Kat Villa İmarlı (KAKS 0.60 - Taban %30)" oninput="renderPoster()">
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                    <div class="fg">
                        <label class="fl">Emlak Ofisi / Danışman</label>
                        <input type="text" id="afis-broker" class="fi" value="Ant Gayrimenkul & Harita" oninput="renderPoster()">
                    </div>
                    <div class="fg">
                        <label class="fl">İletişim Telefonu</label>
                        <input type="text" id="afis-phone" class="fi" value="0532 000 00 00" oninput="renderPoster()">
                    </div>
                </div>

                <div style="display:flex; gap:10px; margin-top:14px;">
                    <button type="button" onclick="downloadPoster()" style="flex:1; background:linear-gradient(135deg, #0284c7 0%, #0369a1 100%); color:#fff; border:none; padding:12px; border-radius:10px; font-size:13.5px; font-weight:900; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:8px;">
                        <i class="fa-solid fa-download"></i> Afişi İndir (PNG)
                    </button>
                    <button type="button" onclick="shareAfisWhatsApp()" style="flex:1; background:linear-gradient(135deg, #25d366 0%, #128c7e 100%); color:#fff; border:none; padding:12px; border-radius:10px; font-size:13.5px; font-weight:900; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:8px;">
                        <i class="fa-brands fa-whatsapp"></i> WhatsApp'ta Paylaş
                    </button>
                </div>
            </div>

            <!-- Canvas Live Preview -->
            <div>
                <div class="canvas-wrap">
                    <canvas id="afisCanvas" width="800" height="800"></canvas>
                </div>
                <div style="font-size:11.5px; color:#94a3b8; text-align:center; margin-top:10px;">
                    ⚡ 800x800 Yüksek Çözünürlüklü Instagram Post ve WhatsApp Durum Formatı
                </div>
            </div>
        </div>
    </main>

    <script>
    function renderPoster() {
        const canvas = document.getElementById('afisCanvas');
        const ctx = canvas.getContext('2d');

        const city = document.getElementById('afis-city').value || 'Ankara';
        const dist = document.getElementById('afis-dist').value || 'Gölbaşı';
        const mah = document.getElementById('afis-mah').value || 'İncek';
        const ada = document.getElementById('afis-ada').value || '124';
        const parsel = document.getElementById('afis-parsel').value || '5';
        const area = document.getElementById('afis-area').value || '750 m²';
        const price = document.getElementById('afis-price').value || '6.500.000 TL';
        const imar = document.getElementById('afis-imar').value || 'Villa İmarlı';
        const broker = document.getElementById('afis-broker').value || 'Ant Gayrimenkul';
        const phone = document.getElementById('afis-phone').value || '0532 000 00 00';

        // 1. Dark Gradient Background
        const grad = ctx.createLinearGradient(0, 0, 800, 800);
        grad.addColorStop(0, '#0a1120');
        grad.addColorStop(1, '#020617');
        ctx.fillStyle = grad;
        ctx.fillRect(0, 0, 800, 800);

        // Grid lines overlay
        ctx.strokeStyle = 'rgba(56, 189, 248, 0.08)';
        ctx.lineWidth = 1;
        for (let x = 0; x < 800; x += 40) {
            ctx.beginPath(); ctx.moveTo(x, 0); ctx.lineTo(x, 800); ctx.stroke();
        }
        for (let y = 0; y < 800; y += 40) {
            ctx.beginPath(); ctx.moveTo(0, y); ctx.lineTo(800, y); ctx.stroke();
        }

        // 2. Top Header Bar
        ctx.fillStyle = '#0284c7';
        ctx.fillRect(40, 40, 720, 60);

        ctx.fillStyle = '#ffffff';
        ctx.font = 'bold 24px Inter, sans-serif';
        ctx.fillText('⚡ SATILIK ARSA & İMAR FIRSATI', 60, 78);

        ctx.fillStyle = '#38bdf8';
        ctx.font = 'bold 16px Inter, sans-serif';
        ctx.textAlign = 'right';
        ctx.fillText('TKGM MEGSİS DOĞRULANDI', 740, 78);
        ctx.textAlign = 'left';

        // 3. Location Badge
        ctx.fillStyle = '#ffffff';
        ctx.font = 'bold 36px Inter, sans-serif';
        ctx.fillText(`${city.toUpperCase()} / ${dist.toUpperCase()}`, 40, 160);

        ctx.fillStyle = '#94a3b8';
        ctx.font = 'bold 22px Inter, sans-serif';
        ctx.fillText(`${mah} Mahallesi`, 40, 195);

        // 4. Cadastral Box (Ada / Parsel / Alan)
        ctx.fillStyle = '#0f172a';
        ctx.strokeStyle = '#38bdf8';
        ctx.lineWidth = 2;
        ctx.beginPath();
        ctx.roundRect(40, 230, 720, 150, 12);
        ctx.fill();
        ctx.stroke();

        ctx.fillStyle = '#38bdf8';
        ctx.font = 'bold 14px Inter, sans-serif';
        ctx.fillText('KADASTRAL ADA / PARSEL', 65, 265);
        ctx.fillText('TOPLAM YÜZÖLÇÜMÜ', 305, 265);
        ctx.fillText('SATIŞ FİYATI', 535, 265);

        ctx.fillStyle = '#ffffff';
        ctx.font = 'bold 34px Inter, sans-serif';
        ctx.fillText(`Ada ${ada} / P.${parsel}`, 65, 325);
        ctx.fillText(area, 305, 325);

        ctx.fillStyle = '#4ade80';
        ctx.fillText(price, 535, 325);

        // 5. Zoning Details Card
        ctx.fillStyle = '#1e293b';
        ctx.strokeStyle = 'rgba(255,255,255,0.1)';
        ctx.lineWidth = 1;
        ctx.beginPath();
        ctx.roundRect(40, 410, 720, 120, 12);
        ctx.fill();
        ctx.stroke();

        ctx.fillStyle = '#facc15';
        ctx.font = 'bold 15px Inter, sans-serif';
        ctx.fillText('🏛️ RESMİ İMAR & YAPILAŞMA DURUMU', 65, 445);

        ctx.fillStyle = '#f8fafc';
        ctx.font = 'bold 22px Inter, sans-serif';
        ctx.fillText(imar, 65, 490);

        // 6. Drone / Satellite Badge
        ctx.fillStyle = 'rgba(2, 132, 199, 0.2)';
        ctx.strokeStyle = '#0284c7';
        ctx.lineWidth = 1.5;
        ctx.beginPath();
        ctx.roundRect(40, 560, 720, 90, 12);
        ctx.fill();
        ctx.stroke();

        ctx.fillStyle = '#38bdf8';
        ctx.font = 'bold 16px Inter, sans-serif';
        ctx.fillText('📍 Parsel Pro Dijital Ekspertiz Raporu', 65, 595);

        ctx.fillStyle = '#cbd5e1';
        ctx.font = '14px Inter, sans-serif';
        ctx.fillText('Kadastral yol cephesi, topoğrafik eğim ve 3D otonom drone uçuşu onaylanmıştır.', 65, 625);

        // 7. Footer Contact Bar
        ctx.fillStyle = '#0f172a';
        ctx.fillRect(0, 680, 800, 120);

        ctx.fillStyle = '#ffffff';
        ctx.font = 'bold 22px Inter, sans-serif';
        ctx.fillText(broker, 40, 730);

        ctx.fillStyle = '#22c55e';
        ctx.font = 'bold 26px Inter, sans-serif';
        ctx.fillText('📞 ' + phone, 40, 770);

        // Logo text right
        ctx.fillStyle = '#94a3b8';
        ctx.font = '13px Inter, sans-serif';
        ctx.textAlign = 'right';
        ctx.fillText('Doğrulanmış Harita Zekası:', 760, 735);
        ctx.fillStyle = '#38bdf8';
        ctx.font = 'bold 18px Inter, sans-serif';
        ctx.fillText('www.parselsorgu.net', 760, 765);
        ctx.textAlign = 'left';
    }

    function downloadPoster() {
        const canvas = document.getElementById('afisCanvas');
        const link = document.createElement('a');
        link.download = 'arsa-ilan-afisi.png';
        link.href = canvas.toDataURL('image/png');
        link.click();
    }

    function shareAfisWhatsApp() {
        const city = document.getElementById('afis-city').value;
        const dist = document.getElementById('afis-dist').value;
        const ada = document.getElementById('afis-ada').value;
        const parsel = document.getElementById('afis-parsel').value;
        const price = document.getElementById('afis-price').value;

        const text = `📢 *SATILIK ARSA FIRSATI:*\n📍 ${city} / ${dist} - Ada: ${ada} Parsel: ${parsel}\n💰 Fiyat: ${price}\n⚡ Doğrulanmış imar ve kadastro harita detaylarını inceleyin:\n👉 https://www.parselsorgu.net/?il=${encodeURIComponent(city)}&ilce=${encodeURIComponent(dist)}&ada=${encodeURIComponent(ada)}&parsel=${encodeURIComponent(parsel)}`;
        window.open('https://api.whatsapp.com/send?text=' + encodeURIComponent(text), '_blank');
    }

    renderPoster();
    </script>
    <script src="/analytics.js?v=2026.1" defer></script>
</body>
</html>
