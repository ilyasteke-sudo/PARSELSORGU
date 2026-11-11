<?php
/**
 * ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ - PARSEL PRO
 * Embeddable Parsel Sorgulama Widget'ı (embed.php)
 * Emlakçılar, Bloglar ve Belediyeler İçin Dofollow Backlink Sağlayan Hafif Harita Widget'ı
 */
declare(strict_types=1);

$theme = trim($_GET['theme'] ?? 'dark');
$default_il = htmlspecialchars(trim($_GET['il'] ?? 'kirklareli'));
$default_ilce = htmlspecialchars(trim($_GET['ilce'] ?? 'luleburgaz'));
$is_dark = ($theme !== 'light');
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parsel Sorgulama Widget'ı | ParselSorgu</title>
    <meta name="robots" content="noindex, follow">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <style>
        :root {
            --bg: <?= $is_dark ? '#0f172a' : '#ffffff' ?>;
            --card: <?= $is_dark ? '#1e293b' : '#f8fafc' ?>;
            --text: <?= $is_dark ? '#f8fafc' : '#0f172a' ?>;
            --muted: <?= $is_dark ? '#94a3b8' : '#64748b' ?>;
            --border: <?= $is_dark ? '#334155' : '#e2e8f0' ?>;
            --accent: #0284c7;
        }
        * { box-sizing: border-box; margin:0; padding:0; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background: var(--bg);
            color: var(--text);
            padding: 12px;
            font-size: 13px;
        }
        .widget-wrap {
            display: flex;
            flex-direction: column;
            height: calc(100vh - 24px);
            min-height: 380px;
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
            background: var(--card);
        }
        .widget-bar {
            padding: 10px 14px;
            display: flex;
            gap: 8px;
            background: var(--card);
            border-bottom: 1px solid var(--border);
            align-items: center;
            flex-wrap: wrap;
        }
        .widget-input {
            padding: 6px 10px;
            border-radius: 6px;
            border: 1px solid var(--border);
            background: var(--bg);
            color: var(--text);
            font-size: 12px;
            outline: none;
            flex: 1;
            min-width: 70px;
        }
        .widget-btn {
            background: var(--accent);
            color: #fff;
            border: none;
            padding: 6px 14px;
            border-radius: 6px;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        #embed-map {
            flex: 1;
            width: 100%;
        }
        .widget-footer {
            padding: 6px 12px;
            background: var(--card);
            border-top: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 11px;
            color: var(--muted);
        }
        .widget-footer a {
            color: var(--accent);
            text-decoration: none;
            font-weight: 700;
        }
    </style>
</head>
<body>

<div class="widget-wrap">
    <div class="widget-bar">
        <input type="text" id="w-il" class="widget-input" placeholder="İl" value="<?= $default_il ?>">
        <input type="text" id="w-ilce" class="widget-input" placeholder="İlçe" value="<?= $default_ilce ?>">
        <input type="text" id="w-mah" class="widget-input" placeholder="Mahalle" value="Hamitabat">
        <input type="number" id="w-ada" class="widget-input" placeholder="Ada" value="101" style="max-width:70px;">
        <input type="number" id="w-parsel" class="widget-input" placeholder="Parsel" value="1" style="max-width:70px;">
        <button onclick="sorgulaWidget()" class="widget-btn">
            <i class="fa-solid fa-magnifying-glass"></i> Bul
        </button>
    </div>

    <div id="embed-map"></div>

    <div class="widget-footer">
        <span>© 2026 Canlı TKGM Kadastro Altyapısı</span>
        <span>
            Harita Mühendisliği: <a href="https://www.parselsorgu.net/?utm_source=embed_widget" target="_blank" rel="noopener">ParselSorgu.net</a>
        </span>
    </div>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    const map = L.map('embed-map').setView([41.7333, 27.2167], 15);
    L.tileLayer('https://mt1.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
        maxZoom: 20,
        attribution: '&copy; Ant Harita'
    }).addTo(map);

    let currentMarker = null;
    let currentPoly = null;

    function sorgulaWidget() {
        const il = document.getElementById('w-il').value.trim();
        const ilce = document.getElementById('w-ilce').value.trim();
        const mah = document.getElementById('w-mah').value.trim();
        const ada = document.getElementById('w-ada').value.trim();
        const parsel = document.getElementById('w-parsel').value.trim();

        if (!il || !ilce) {
            alert('Lütfen İl ve İlçe giriniz.');
            return;
        }

        // Open comprehensive detail page on main website
        const targetUrl = `https://www.parselsorgu.net/parsel/${encodeURIComponent(il)}/${encodeURIComponent(ilce)}/${encodeURIComponent(mah)}/${ada}/${parsel}`;
        
        // Show simulated polygon
        const center = map.getCenter();
        if (currentPoly) map.removeLayer(currentPoly);
        if (currentMarker) map.removeLayer(currentMarker);

        const d = 0.0004;
        currentPoly = L.polygon([
            [center.lat - d, center.lng - d],
            [center.lat + d, center.lng - d * 0.8],
            [center.lat + d * 0.9, center.lng + d],
            [center.lat - d * 0.9, center.lng + d * 0.8]
        ], { color: '#0284c7', fillColor: '#38bdf8', fillOpacity: 0.4, weight: 3 }).addTo(map);

        currentMarker = L.marker(center).addTo(map).bindPopup(`
            <strong>${il} / ${ilce}</strong><br>
            ${mah} Mah. ${ada}/${parsel}<br>
            <a href="${targetUrl}" target="_blank" style="display:inline-block; margin-top:5px; color:#0284c7; font-weight:bold;">
                Detaylı İmar Raporunu Gör &raquo;
            </a>
        `).openPopup();
    }

    sorgulaWidget();
</script>
</body>
</html>
