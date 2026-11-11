<?php
/**
 * ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ - PARSEL PRO
 * Emlakçılar İçin "Sitene Parsel Sorgu Ekle" Oluşturucu (embed_olusturucu.php)
 * URL: /sitene-parsel-sorgu-ekle
 */
declare(strict_types=1);

require_once __DIR__ . '/navbar.php';
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sitene Ücretsiz Parsel Sorgu Widget Ekle | ParselSorgu</title>
    <meta name="description" content="Emlak sitenize, blogunuza veya portalınıza 1 satır kodla ücretsiz canlı TKGM parsel sorgulama harita widget'ı ekleyin.">
    <link rel="canonical" href="https://www.parselsorgu.net/sitene-parsel-sorgu-ekle">
    <meta property="og:type" content="website">
    <meta property="og:title" content="Sitene Ücretsiz Parsel Sorgu Widget Ekle | ParselSorgu">
    <meta property="og:description" content="Emlak sitenize 1 satır kodla ücretsiz canlı TKGM parsel sorgulama haritası ekleyin.">
    <meta property="og:url" content="https://www.parselsorgu.net/sitene-parsel-sorgu-ekle">
    <meta property="og:image" content="https://www.parselsorgu.net/assets/images/og-parsel.jpg">
    <meta name="twitter:card" content="summary_large_image">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <style>
        :root {
            --bg-dark: #0f172a;
            --card-dark: #1e293b;
            --border-dark: #334155;
            --text-light: #f8fafc;
            --text-muted: #94a3b8;
            --accent-blue: #38bdf8;
            --accent-green: #10b981;
        }
        body {
            background-color: var(--bg-dark);
            color: var(--text-light);
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            margin:0; padding:0;
            line-height: 1.6;
        }
        .container { max-width: 1100px; margin: 0 auto; padding: 32px 16px; }
        .hero {
            text-align: center;
            padding: 30px 20px;
            background: linear-gradient(135deg, #1e293b, #0f172a);
            border-radius: 16px;
            border: 1px solid var(--border-dark);
            margin-bottom: 30px;
        }
        .hero h1 { font-size: clamp(1.8rem, 3.5vw, 2.5rem); margin: 0 0 12px 0; font-weight: 900; color: #fff; }
        .hero p { color: var(--text-muted); font-size: 1.1rem; max-width: 750px; margin: 0 auto; }
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; }
        @media(max-width: 768px) { .grid-2 { grid-template-columns: 1fr; } }
        .card {
            background: var(--card-dark);
            border: 1px solid var(--border-dark);
            border-radius: 14px;
            padding: 24px;
        }
        .form-group { margin-bottom: 16px; }
        .form-group label { display: block; font-weight: 700; margin-bottom: 6px; font-size: 0.9rem; }
        .form-control {
            width: 100%;
            padding: 10px 14px;
            background: #0f172a;
            border: 1px solid var(--border-dark);
            border-radius: 8px;
            color: #fff;
            box-sizing: border-box;
            font-size: 0.95rem;
        }
        .code-box {
            background: #090d16;
            border: 1px solid var(--border-dark);
            border-radius: 8px;
            padding: 16px;
            font-family: monospace;
            font-size: 0.85rem;
            color: #38bdf8;
            white-space: pre-wrap;
            word-break: break-all;
            position: relative;
        }
        .copy-btn {
            background: var(--accent-green);
            color: #0b1329;
            font-weight: 800;
            padding: 10px 20px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-top: 12px;
            transition: 0.2s;
        }
        .copy-btn:hover { filter: brightness(1.1); transform: translateY(-1px); }
        iframe { border: none; border-radius: 10px; width: 100%; }
    </style>
</head>
<body>

<?= render_navbar() ?>

<div class="container">
    <div class="hero">
        <span style="background:rgba(56,189,248,0.15); color:var(--accent-blue); padding:4px 14px; border-radius:20px; font-weight:700; font-size:0.85rem; border:1px solid rgba(56,189,248,0.3);">
            <i class="fa-solid fa-code"></i> EMLAKÇILAR & WEB YÖNETİCİLERİ İÇİN ÜCRETSİZ
        </span>
        <h1>Web Sitenize Canlı Parsel Sorgulama Ekleyin</h1>
        <p>Emlak sitenize veya blogunuza tek satır kod ekleyerek ziyaretçilerinizin sitenizden ayrılmadan Türkiye geneli canlı ada/parsel sorgulaması yapmasını sağlayın.</p>
    </div>

    <div class="grid-2">
        <!-- Settings Form -->
        <div class="card">
            <h2 style="font-size:1.3rem; margin:0 0 20px 0; color:#fff; display:flex; align-items:center; gap:8px;">
                <i class="fa-solid fa-sliders" style="color:var(--accent-blue);"></i> Widget Özelleştirici
            </h2>

            <div class="form-group">
                <label>Varsayılan İl:</label>
                <input type="text" id="cfg-il" class="form-control" value="Kırklareli" oninput="updateWidget()">
            </div>

            <div class="form-group">
                <label>Varsayılan İlçe:</label>
                <input type="text" id="cfg-ilce" class="form-control" value="Lüleburgaz" oninput="updateWidget()">
            </div>

            <div class="form-group">
                <label>Tema Seçimi:</label>
                <select id="cfg-theme" class="form-control" onchange="updateWidget()">
                    <option value="dark" selected>Karanlık Tema (Modern Dark)</option>
                    <option value="light">Aydınlık Tema (Clean White)</option>
                </select>
            </div>

            <div class="form-group">
                <label>Yükseklik (px):</label>
                <input type="number" id="cfg-height" class="form-control" value="480" oninput="updateWidget()">
            </div>

            <div style="margin-top:24px;">
                <label style="font-weight:700; font-size:0.9rem; margin-bottom:8px; display:block;">Web Sitenize Yapıştıracağınız Kod:</label>
                <div id="embed-code" class="code-box"></div>
                <button onclick="copyEmbedCode()" class="copy-btn">
                    <i class="fa-solid fa-copy"></i> Kodu Kopyala
                </button>
                <span id="copy-msg" style="display:none; color:var(--accent-green); margin-left:10px; font-weight:700; font-size:0.9rem;">
                    ✓ Kopyalandı!
                </span>
            </div>
        </div>

        <!-- Live Preview -->
        <div class="card">
            <h2 style="font-size:1.3rem; margin:0 0 20px 0; color:#fff; display:flex; align-items:center; gap:8px;">
                <i class="fa-solid fa-eye" style="color:var(--accent-green);"></i> Canlı Önizleme
            </h2>
            <div id="preview-container">
                <iframe id="preview-frame" src="/embed?il=kirklareli&ilce=luleburgaz&theme=dark" height="480"></iframe>
            </div>
        </div>
    </div>
</div>

<script>
    function updateWidget() {
        const il = encodeURIComponent(document.getElementById('cfg-il').value.trim() || 'kirklareli');
        const ilce = encodeURIComponent(document.getElementById('cfg-ilce').value.trim() || 'luleburgaz');
        const theme = document.getElementById('cfg-theme').value;
        const height = document.getElementById('cfg-height').value || '480';

        const src = `https://www.parselsorgu.net/embed?il=${il}&ilce=${ilce}&theme=${theme}`;
        const code = `<iframe src="${src}" width="100%" height="${height}" frameborder="0" style="border:1px solid #334155; border-radius:12px; overflow:hidden;" allowfullscreen loading="lazy"></iframe>\n<p style="font-size:11px; color:#64748b; margin-top:4px;">Canlı TKGM Altyapısı: <a href="https://www.parselsorgu.net/" target="_blank" rel="noopener" style="color:#0284c7; text-decoration:none;">Parsel Sorgulama - ParselSorgu.net</a></p>`;

        document.getElementById('embed-code').innerText = code;
        document.getElementById('preview-frame').src = `/embed?il=${il}&ilce=${ilce}&theme=${theme}`;
        document.getElementById('preview-frame').style.height = height + 'px';
    }

    function copyEmbedCode() {
        const code = document.getElementById('embed-code').innerText;
        navigator.clipboard.writeText(code).then(() => {
            const msg = document.getElementById('copy-msg');
            msg.style.display = 'inline';
            setTimeout(() => { msg.style.display = 'none'; }, 3000);
        });
    }

    updateWidget();
</script>
</body>
</html>
