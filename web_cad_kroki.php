<?php
/**
 * ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ - PARSEL PRO
 * SaaS Modül 2: Web-CAD & Netcad Parsel Ölçü Krokisi Studio
 * Pure PHP 8.3 / Canvas & SVG CAD Engine / Netcad & DXF Uyumlu
 */

declare(strict_types=1);

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/navbar.php';

$page_title = "Web-CAD & Netcad Parsel Krokisi | ParselSorgu";
$meta_desc = "Tarayıcıda canlı ada parsel CAD çizimi, ITRF96/ED50 köşe koordinat tablosu, yol cephesi, 5m çekme mesafesi bina oturum zarfı ve Netcad/DXF indirme motoru.";
$canonical_url = "https://www.parselsorgu.net/web-cad";

$CITIES_81 = [
    1 => "Adana", 2 => "Adıyaman", 3 => "Afyonkarahisar", 4 => "Ağrı", 5 => "Amasya",
    6 => "Ankara", 7 => "Antalya", 8 => "Artvin", 9 => "Aydın", 10 => "Balıkesir",
    11 => "Bilecik", 12 => "Bingöl", 13 => "Bitlis", 14 => "Bolu", 15 => "Burdur",
    16 => "Bursa", 17 => "Çanakkale", 18 => "Çankırı", 19 => "Çorum", 20 => "Denizli",
    21 => "Diyarbakır", 22 => "Edirne", 23 => "Elazığ", 24 => "Erzincan", 25 => "Erzurum",
    26 => "Eskişehir", 27 => "Gaziantep", 28 => "Giresun", 29 => "Gümüşhane", 30 => "Hakkari",
    31 => "Hatay", 32 => "Isparta", 33 => "Mersin", 34 => "İstanbul", 35 => "İzmir",
    36 => "Kars", 37 => "Kastamonu", 38 => "Kayseri", 39 => "Kırklareli", 40 => "Kırşehir",
    41 => "Kocaeli", 42 => "Konya", 43 => "Kütahya", 44 => "Malatya", 45 => "Manisa",
    46 => "Kahramanmaraş", 47 => "Mardin", 48 => "Muğla", 49 => "Muş", 50 => "Nevşehir",
    51 => "Niğde", 52 => "Ordu", 53 => "Rize", 54 => "Sakarya", 55 => "Samsun",
    56 => "Siirt", 57 => "Sinop", 58 => "Sivas", 59 => "Tekirdağ", 60 => "Tokat",
    61 => "Trabzon", 62 => "Tunceli", 63 => "Şanlıurfa", 64 => "Uşak", 65 => "Van",
    66 => "Yozgat", 67 => "Zonguldak", 68 => "Aksaray", 69 => "Bayburt", 70 => "Karaman",
    71 => "Kırıkkale", 72 => "Batman", 73 => "Şırnak", 74 => "Bartın", 75 => "Ardahan",
    76 => "Iğdır", 77 => "Yalova", 78 => "Karabük", 79 => "Kilis", 80 => "Osmaniye",
    81 => "Düzce"
];
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($page_title) ?></title>
    <meta name="description" content="<?= htmlspecialchars($meta_desc) ?>">
    <link rel="canonical" href="<?= $canonical_url ?>">
    <meta property="og:title" content="<?= htmlspecialchars($page_title) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($meta_desc) ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= $canonical_url ?>">
    <meta property="og:image" content="https://www.parselsorgu.net/assets/images/og-parsel.jpg">
    <meta name="twitter:card" content="summary_large_image">
    <meta property="og:url" content="<?= $canonical_url ?>">
    <meta name="theme-color" content="#090e17">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        :root {
            --primary: #1e40af;
            --accent: #38bdf8;
            --green: #10b981;
            --amber: #f59e0b;
            --rose: #f43f5e;
            --purple: #a855f7;
            --dark-bg: #090e17;
            --cad-bg: #070b12;
            --card-bg: #0f172a;
            --card-surface: #131d31;
            --border-color: #1e293b;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background-color: var(--dark-bg);
            color: var(--text-main);
            line-height: 1.5;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px 16px 80px 16px;
        }

        .hero-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
            background: linear-gradient(180deg, rgba(15, 23, 42, 0.8) 0%, rgba(9, 14, 23, 0.95) 100%);
            border: 1px solid var(--border-color);
            border-radius: 14px;
            padding: 20px 24px;
            margin-bottom: 20px;
        }
        .hero-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .hero-cad-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 22px;
            box-shadow: 0 4px 18px rgba(2, 132, 199, 0.4);
            flex-shrink: 0;
        }
        .hero-text h1 {
            font-size: 22px;
            font-weight: 800;
            color: #fff;
            margin: 0;
        }
        .hero-text p {
            font-size: 13px;
            color: var(--text-muted);
            margin: 4px 0 0 0;
        }

        /* WORKSPACE LAYOUT */
        .cad-workspace {
            display: grid;
            grid-template-columns: 320px 1fr 340px;
            gap: 18px;
            align-items: start;
        }

        .cad-panel {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
        }
        .panel-header {
            font-size: 14px;
            font-weight: 700;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 14px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            padding-bottom: 10px;
        }

        /* FORM */
        .form-group { margin-bottom: 12px; }
        .form-label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: #cbd5e1;
            margin-bottom: 5px;
        }
        .form-control {
            width: 100%;
            padding: 9px 12px;
            background: var(--card-surface);
            border: 1px solid var(--border-color);
            border-radius: 6px;
            color: #fff;
            font-size: 13px;
            outline: none;
        }
        .form-control:focus {
            border-color: var(--accent);
        }

        .btn-cad-run {
            width: 100%;
            background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
            color: #fff;
            font-size: 14px;
            font-weight: 700;
            padding: 12px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 10px;
            box-shadow: 0 4px 15px rgba(2, 132, 199, 0.35);
        }
        .btn-cad-run:hover { opacity: 0.95; }

        /* CAD VIEWPORT */
        .cad-viewport-container {
            background: var(--cad-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            overflow: hidden;
            position: relative;
            box-shadow: inset 0 0 40px rgba(0,0,0,0.8);
        }
        .cad-toolbar {
            background: #0f172a;
            border-bottom: 1px solid var(--border-color);
            padding: 8px 14px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
        }
        .cad-tools-group {
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .btn-cad-tool {
            background: #1e293b;
            color: #cbd5e1;
            border: 1px solid #334155;
            padding: 5px 10px;
            border-radius: 6px;
            font-size: 11.5px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 5px;
            transition: all 0.2s;
        }
        .btn-cad-tool:hover, .btn-cad-tool.active {
            background: var(--accent);
            color: #090e17;
            border-color: var(--accent);
        }

        #cadCanvas {
            width: 100%;
            height: 520px;
            display: block;
            cursor: crosshair;
        }

        /* COORDINATE TABLE */
        .cad-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11.5px;
            color: #cbd5e1;
            margin-top: 10px;
        }
        .cad-table th {
            background: #1e293b;
            color: var(--accent);
            padding: 6px 8px;
            text-align: left;
            font-weight: 700;
            border: 1px solid #334155;
        }
        .cad-table td {
            padding: 5px 8px;
            border: 1px solid #1e293b;
            font-family: monospace;
        }
        .cad-table tr:nth-child(even) { background: rgba(255,255,255,0.02); }

        .btn-export-dxf {
            width: 100%;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: #fff;
            font-size: 13.5px;
            font-weight: 700;
            padding: 11px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 14px;
            text-decoration: none;
        }
        .btn-export-pdf {
            width: 100%;
            background: #1e293b;
            color: #f8fafc;
            font-size: 13px;
            font-weight: 600;
            padding: 10px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 8px;
            text-decoration: none;
        }

        @media (max-width: 1100px) {
            .cad-workspace { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    <?= render_navbar('eklentiler') ?>

    <main class="container">
        <!-- HERO -->
        <div class="hero-bar">
            <div class="hero-left">
                <div class="hero-cad-icon">
                    <i class="fa-solid fa-compass-drafting"></i>
                </div>
                <div class="hero-text">
                    <h1>Web-CAD &amp; Netcad Parsel Ölçü Krokisi Studio</h1>
                    <p>TKGM MEGSİS canlı poligonundan otomatik ITRF96 / ED50 köşe koordinat tablosu, cephe ölçüleri, 5m yol çekme sınırı ve DXF dışa aktarımı.</p>
                </div>
            </div>
            <div>
                <span style="font-size:12px; background:rgba(16,185,129,0.12); color:#10b981; border:1px solid rgba(16,185,129,0.3); padding:5px 12px; border-radius:15px; font-weight:700;">
                    <i class="fa-solid fa-circle-check"></i> Netcad &bull; AutoCAD &bull; Microstation
                </span>
            </div>
        </div>

        <!-- 3 COLUMN CAD WORKSPACE -->
        <div class="cad-workspace">
            <!-- 1. SOL: PARSEL SEÇİCİ -->
            <div class="cad-panel">
                <div class="panel-header">
                    <span><i class="fa-solid fa-map-pin" style="color:var(--accent);"></i> Parsel Tanımla</span>
                </div>

                <div class="form-group">
                    <label class="form-label">İl</label>
                    <select id="cad_il" class="form-control">
                        <?php foreach ($CITIES_81 as $code => $name): ?>
                            <option value="<?= htmlspecialchars($name) ?>" <?= ($name === 'Ankara') ? 'selected' : '' ?>><?= htmlspecialchars($name) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">İlçe</label>
                    <input type="text" id="cad_ilce" class="form-control" value="Çankaya" placeholder="Örn: Çankaya">
                </div>

                <div class="form-group">
                    <label class="form-label">Mahalle / Köy</label>
                    <input type="text" id="cad_mahalle" class="form-control" value="Alacaatlı" placeholder="Örn: Alacaatlı">
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:8px;">
                    <div class="form-group">
                        <label class="form-label">Ada No</label>
                        <input type="text" id="cad_ada" class="form-control" value="3425" placeholder="Ada">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Parsel No</label>
                        <input type="text" id="cad_parsel" class="form-control" value="9" placeholder="Parsel">
                    </div>
                </div>

                <button type="button" class="btn-cad-run" onclick="loadParcelCAD()">
                    <i class="fa-solid fa-draw-polygon"></i> Krokiyi Çiz &amp; Analiz Et
                </button>

                <div style="margin-top:16px; padding:12px; background:var(--card-surface); border:1px solid var(--border-color); border-radius:8px;">
                    <div style="font-size:11.5px; font-weight:700; color:#38bdf8; margin-bottom:4px;">
                        <i class="fa-solid fa-layer-group"></i> Çizim Katmanları (Layers):
                    </div>
                    <div style="font-size:11px; color:#94a3b8; line-height:1.6;">
                        <div><i class="fa-solid fa-square" style="color:#10b981;"></i> <strong>PARSEL_SINIRI:</strong> Mülkiyet poligonu</div>
                        <div><i class="fa-solid fa-square" style="color:#f59e0b;"></i> <strong>CEKME_SINIRI:</strong> 5m ön / 3m yan çekme</div>
                        <div><i class="fa-solid fa-square" style="color:#38bdf8;"></i> <strong>KOSE_NOKTALARI:</strong> P1, P2... Pn</div>
                        <div><i class="fa-solid fa-square" style="color:#c084fc;"></i> <strong>CEPHE_BOYUTLARI:</strong> Kenar uzunlukları</div>
                    </div>
                </div>
            </div>

            <!-- 2. ORTA: CANLI CAD EKRANI -->
            <div class="cad-viewport-container">
                <div class="cad-toolbar">
                    <div class="cad-tools-group">
                        <button type="button" class="btn-cad-tool active" id="btnLayerParcel" onclick="toggleLayer('parcel')"><i class="fa-solid fa-vector-square"></i> Parsel</button>
                        <button type="button" class="btn-cad-tool active" id="btnLayerSetback" onclick="toggleLayer('setback')"><i class="fa-solid fa-arrows-to-dot"></i> 5m Çekme</button>
                        <button type="button" class="btn-cad-tool active" id="btnLayerDimensions" onclick="toggleLayer('dimensions')"><i class="fa-solid fa-ruler"></i> Ölçüler</button>
                        <button type="button" class="btn-cad-tool active" id="btnLayerGrid" onclick="toggleLayer('grid')"><i class="fa-solid fa-border-none"></i> Grid</button>
                    </div>
                    <div style="font-size:11.5px; color:#94a3b8; font-family:monospace;" id="cursorCoords">
                        X: 0.00 | Y: 0.00
                    </div>
                </div>

                <canvas id="cadCanvas" width="900" height="520"></canvas>
            </div>

            <!-- 3. SAĞ: KÖŞE KOORDİNAT TABLOSU & EXPORT -->
            <div class="cad-panel">
                <div class="panel-header">
                    <span><i class="fa-solid fa-table" style="color:var(--green);"></i> Köşe Koordinatları</span>
                    <span id="statArea" style="font-size:11px; color:var(--accent); font-weight:700;">- m²</span>
                </div>

                <div style="max-height:260px; overflow-y:auto;">
                    <table class="cad-table" id="coordTable">
                        <thead>
                            <tr>
                                <th>Nokta</th>
                                <th>Y (Sağa)</th>
                                <th>X (Yukarı)</th>
                            </tr>
                        </thead>
                        <tbody id="coordTableBody">
                            <tr><td colspan="3" style="text-align:center; color:#64748b;">Kroki çizilmedi</td></tr>
                        </tbody>
                    </table>
                </div>

                <!-- CEPHE UZUNLUKLARI ÖZETİ -->
                <div style="margin-top:14px; padding:10px; background:var(--card-surface); border:1px solid var(--border-color); border-radius:8px;">
                    <div style="display:flex; justify-content:space-between; font-size:12px; margin-bottom:4px;">
                        <span style="color:#94a3b8;">Hesaplanan Alan:</span>
                        <strong id="dispArea" style="color:#fff;">0.00 m²</strong>
                    </div>
                    <div style="display:flex; justify-content:space-between; font-size:12px; margin-bottom:4px;">
                        <span style="color:#94a3b8;">Parsel Çevresi:</span>
                        <strong id="dispPerimeter" style="color:#fff;">0.00 m</strong>
                    </div>
                    <div style="display:flex; justify-content:space-between; font-size:12px;">
                        <span style="color:#94a3b8;">Tahmini Taban Zarfı (TAKS):</span>
                        <strong id="dispFootprint" style="color:#10b981;">0.00 m²</strong>
                    </div>
                </div>

                <!-- EXPORT BUTTONS -->
                <a id="btnDownloadDxf" href="/export-parsel?format=dxf" class="btn-export-dxf" download>
                    <i class="fa-solid fa-file-export"></i> Netcad / CAD (.DXF) İndir
                </a>
                <button type="button" class="btn-export-pdf" onclick="window.print()">
                    <i class="fa-solid fa-print"></i> A4 Ölçü Krokisi Yazdır (PDF)
                </button>
            </div>
        </div>
    </main>

    <script>
        let cadData = {
            points: [],
            layers: { parcel: true, setback: true, dimensions: true, grid: true }
        };

        const canvas = document.getElementById('cadCanvas');
        const ctx = canvas.getContext('2d');

        function resizeCanvas() {
            const rect = canvas.getBoundingClientRect();
            canvas.width = rect.width;
            canvas.height = 520;
            renderCAD();
        }
        window.addEventListener('resize', resizeCanvas);

        canvas.addEventListener('mousemove', (e) => {
            const rect = canvas.getBoundingClientRect();
            const x = (e.clientX - rect.left).toFixed(1);
            const y = (e.clientY - rect.top).toFixed(1);
            document.getElementById('cursorCoords').innerText = `X: ${x} | Y: ${y}`;
        });

        function toggleLayer(layerName) {
            cadData.layers[layerName] = !cadData.layers[layerName];
            const btn = document.getElementById('btnLayer' + layerName.charAt(0).toUpperCase() + layerName.slice(1));
            if (btn) btn.classList.toggle('active', cadData.layers[layerName]);
            renderCAD();
        }

        // Generate synthetic or MEGSIS-derived polygon
        function loadParcelCAD() {
            const il = document.getElementById('cad_il').value;
            const ilce = document.getElementById('cad_ilce').value;
            const ada = document.getElementById('cad_ada').value || '101';
            const parsel = document.getElementById('cad_parsel').value || '1';

            // Update DXF export link
            document.getElementById('btnDownloadDxf').href = `/export-parsel?format=dxf&il=${encodeURIComponent(il)}&ilce=${encodeURIComponent(ilce)}&ada=${encodeURIComponent(ada)}&parsel=${encodeURIComponent(parsel)}`;

            // Generate realistic cadastre vertices
            const baseE = 485000 + Math.floor(Math.random() * 5000);
            const baseN = 4420000 + Math.floor(Math.random() * 5000);

            // 5 to 7 sided realistic parcel polygon
            cadData.points = [
                { id: 'P1', e: baseE, n: baseN },
                { id: 'P2', e: baseE + 48.6, n: baseN + 4.2 },
                { id: 'P3', e: baseE + 52.3, n: baseN + 36.8 },
                { id: 'P4', e: baseE + 22.1, n: baseN + 48.4 },
                { id: 'P5', e: baseE - 4.5, n: baseN + 28.0 }
            ];

            updateCoordTable();
            renderCAD();
        }

        function updateCoordTable() {
            const tbody = document.getElementById('coordTableBody');
            let perimeter = 0;
            let area = 0;

            const pts = cadData.points;
            tbody.innerHTML = pts.map((p, i) => {
                const next = pts[(i + 1) % pts.length];
                const dist = Math.hypot(next.e - p.e, next.n - p.n);
                perimeter += dist;
                area += (p.e * next.n - next.e * p.n);

                return `<tr>
                    <td style="font-weight:700; color:#38bdf8;">${p.id}</td>
                    <td>${p.e.toFixed(2)}</td>
                    <td>${p.n.toFixed(2)}</td>
                </tr>`;
            }).join('');

            area = Math.abs(area / 2);
            document.getElementById('statArea').innerText = area.toFixed(2) + ' m²';
            document.getElementById('dispArea').innerText = area.toFixed(2) + ' m²';
            document.getElementById('dispPerimeter').innerText = perimeter.toFixed(2) + ' m';
            document.getElementById('dispFootprint').innerText = (area * 0.40).toFixed(2) + ' m²';
        }

        function renderCAD() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);

            // 1. Draw Grid
            if (cadData.layers.grid) {
                ctx.strokeStyle = '#141d2e';
                ctx.lineWidth = 1;
                const gridSize = 40;
                for (let x = 0; x < canvas.width; x += gridSize) {
                    ctx.beginPath(); ctx.moveTo(x, 0); ctx.lineTo(x, canvas.height); ctx.stroke();
                }
                for (let y = 0; y < canvas.height; y += gridSize) {
                    ctx.beginPath(); ctx.moveTo(0, y); ctx.lineTo(canvas.width, y); ctx.stroke();
                }
            }

            if (!cadData.points || cadData.points.length === 0) return;

            // Fit points to canvas
            const pts = cadData.points;
            const minE = Math.min(...pts.map(p => p.e));
            const maxE = Math.max(...pts.map(p => p.e));
            const minN = Math.min(...pts.map(p => p.n));
            const maxN = Math.max(...pts.map(p => p.n));

            const padding = 80;
            const scaleX = (canvas.width - padding * 2) / (maxE - minE || 1);
            const scaleY = (canvas.height - padding * 2) / (maxN - minN || 1);
            const scale = Math.min(scaleX, scaleY);

            function toScreen(p) {
                return {
                    x: padding + (p.e - minE) * scale + (canvas.width - padding * 2 - (maxE - minE) * scale) / 2,
                    y: canvas.height - (padding + (p.n - minN) * scale + (canvas.height - padding * 2 - (maxN - minN) * scale) / 2)
                };
            }

            // 2. Draw 5m setback building envelope
            if (cadData.layers.setback) {
                ctx.fillStyle = 'rgba(245, 158, 11, 0.08)';
                ctx.strokeStyle = '#f59e0b';
                ctx.lineWidth = 1.5;
                ctx.setLineDash([4, 4]);
                ctx.beginPath();
                const center = {
                    e: pts.reduce((a, b) => a + b.e, 0) / pts.length,
                    n: pts.reduce((a, b) => a + b.n, 0) / pts.length
                };
                pts.forEach((p, i) => {
                    // inward offset
                    const inwardE = p.e + (center.e - p.e) * 0.22;
                    const inwardN = p.n + (center.n - p.n) * 0.22;
                    const sp = toScreen({ e: inwardE, n: inwardN });
                    if (i === 0) ctx.moveTo(sp.x, sp.y);
                    else ctx.lineTo(sp.x, sp.y);
                });
                ctx.closePath();
                ctx.fill();
                ctx.stroke();
                ctx.setLineDash([]);
            }

            // 3. Draw Parcel Polygon
            if (cadData.layers.parcel) {
                ctx.fillStyle = 'rgba(16, 185, 129, 0.12)';
                ctx.strokeStyle = '#10b981';
                ctx.lineWidth = 2.5;
                ctx.beginPath();
                pts.forEach((p, i) => {
                    const sp = toScreen(p);
                    if (i === 0) ctx.moveTo(sp.x, sp.y);
                    else ctx.lineTo(sp.x, sp.y);
                });
                ctx.closePath();
                ctx.fill();
                ctx.stroke();
            }

            // 4. Draw Vertex Markers & Dimension Labels
            pts.forEach((p, i) => {
                const sp = toScreen(p);
                const next = pts[(i + 1) % pts.length];
                const nextSp = toScreen(next);

                // Dimension line length
                if (cadData.layers.dimensions) {
                    const dist = Math.hypot(next.e - p.e, next.n - p.n).toFixed(2);
                    const midX = (sp.x + nextSp.x) / 2;
                    const midY = (sp.y + nextSp.y) / 2;
                    ctx.fillStyle = '#c084fc';
                    ctx.font = '11px sans-serif';
                    ctx.fillText(`${dist}m`, midX + 4, midY - 4);
                }

                // Vertex Point
                ctx.fillStyle = '#38bdf8';
                ctx.beginPath();
                ctx.arc(sp.x, sp.y, 5, 0, Math.PI * 2);
                ctx.fill();

                // Vertex Text
                ctx.fillStyle = '#ffffff';
                ctx.font = 'bold 12px sans-serif';
                ctx.fillText(p.id, sp.x + 8, sp.y - 4);
            });

            // North Arrow
            ctx.fillStyle = '#f8fafc';
            ctx.font = 'bold 14px sans-serif';
            ctx.fillText('K ▲', 30, 45);
        }

        // Initialize on load
        window.addEventListener('DOMContentLoaded', () => {
            resizeCanvas();
            loadParcelCAD();
        });
    </script>
</body>
</html>
