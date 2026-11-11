<?php
/**
 * ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ - PARSEL PRO
 * SaaS 4: ARSA ÜSTÜ 3D BİNA YERLEŞİM & GÜNEŞ / GÖLGE SİMÜLATÖRÜ
 * URL: https://www.parselsorgu.net/3d-gunes-golge-simulasyonu
 * Pure PHP 8.3 + Three.js r128 Real-Time Shadow & Sun Azimuth Engine
 */
declare(strict_types=1);

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/navbar.php';

$page_title = "3D Arsa Bina Yerleşim & Gölge Simülatörü | ParselSorgu";
$meta_desc = "Arsa boyutları, TAKS/KAKS emsal ve çekme mesafelerini girerek 3 boyutlu bina kütlesini ve gün boyu güneş-gölge düşümünü simüle edin.";
$canonical_url = "https://www.parselsorgu.net/3d-gunes-golge-simulasyonu";
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title><?= htmlspecialchars($page_title) ?></title>
    <meta name="description" content="<?= htmlspecialchars($meta_desc) ?>">
    <link rel="canonical" href="<?= $canonical_url ?>    <meta property="og:image" content="https://www.parselsorgu.net/assets/images/og-parsel.jpg">
">
    <link rel="manifest" href="/manifest.json">
    <meta property="og:title" content="<?= htmlspecialchars($page_title) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($meta_desc) ?>">
    <meta property="og:url" content="<?= $canonical_url ?>">
    <meta property="og:type" content="website">
    <meta name="theme-color" content="#090e17">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>

    <style>
        :root {
            --bg-dark: #060a12;
            --card-bg: #0f172a;
            --surface: #131d31;
            --amber: #f59e0b;
            --cyan: #38bdf8;
            --emerald: #10b981;
            --text: #f8fafc;
            --muted: #94a3b8;
        }
        * { box-sizing: border-box; }
        body { margin: 0; background: var(--bg-dark); color: var(--text); font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; line-height: 1.5; }
        .sun-container { max-width: 1440px; margin: 0 auto; padding: 20px 16px 70px 16px; }
        .sun-hero {
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.14) 0%, rgba(15, 23, 42, 0.96) 100%);
            border: 1px solid rgba(245, 158, 11, 0.28);
            border-radius: 16px; padding: 20px 24px; margin-bottom: 18px;
            display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 14px;
        }
        .sun-badge {
            display: inline-flex; align-items: center; gap: 6px;
            background: rgba(245, 158, 11, 0.16); border: 1px solid rgba(245, 158, 11, 0.38);
            color: #fbbf24; padding: 4px 12px; border-radius: 9999px; font-size: 11.5px; font-weight: 800; margin-bottom: 8px;
        }
        .sun-hero h1 { margin: 0 0 6px 0; font-size: 1.55rem; font-weight: 900; color: #fff; }
        .sun-hero p { margin: 0; color: var(--muted); font-size: 0.9rem; max-width: 780px; }
        .sun-grid { display: grid; grid-template-columns: 380px 1fr; gap: 18px; align-items: start; }
        @media (max-width: 1024px) { .sun-grid { grid-template-columns: 1fr; } }
        .panel { background: var(--card-bg); border: 1px solid #1e293b; border-radius: 14px; padding: 18px; }
        .panel-head { font-size: 14px; font-weight: 800; color: #fff; padding-bottom: 10px; margin-bottom: 12px; border-bottom: 1px solid #1e293b; display: flex; justify-content: space-between; align-items: center; }
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
        .grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 8px; }
        .field { margin-bottom: 11px; }
        .field label { display: block; font-size: 11px; font-weight: 700; color: var(--muted); text-transform: uppercase; margin-bottom: 4px; }
        .s-input, .s-select { width: 100%; background: var(--surface); border: 1px solid #263449; color: #fff; border-radius: 8px; padding: 8px 10px; font-size: 13px; }
        #viewport3d { width: 100%; height: 470px; border-radius: 12px; border: 1px solid #1e293b; overflow: hidden; position: relative; background: #091220; cursor: grab; }
        #viewport3d:active { cursor: grabbing; }
        .time-control {
            margin-top: 12px; background: var(--surface); border: 1px solid #1e293b;
            border-radius: 12px; padding: 12px 16px; display: flex; align-items: center; gap: 14px; flex-wrap: wrap;
        }
        .time-control input[type="range"] { flex: 1; min-width: 180px; accent-color: #f59e0b; cursor: pointer; }
        .metrics-4 { display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; margin-top: 12px; }
        @media (max-width: 640px) { .metrics-4 { grid-template-columns: repeat(2, 1fr); } }
        .m-box { background: var(--surface); border: 1px solid #1e293b; border-radius: 10px; padding: 10px 12px; }
        .m-lbl { font-size: 10.5px; color: var(--muted); font-weight: 700; text-transform: uppercase; }
        .m-val { font-size: 15px; font-weight: 900; color: #fff; margin-top: 2px; }
        .btn-play { background: linear-gradient(135deg, #f59e0b, #d97706); color: #000; border: none; border-radius: 8px; padding: 8px 14px; font-weight: 900; font-size: 12px; cursor: pointer; }
    </style>
    <script type="application/ld+json">{"@context": "https://schema.org", "@type": "FAQPage", "mainEntity": [{"@type": "Question", "name": "Arsa bina yerleşiminde güneş yönü ve gölge analizi neden önemlidir?", "acceptedAnswer": {"@type": "Answer", "text": "Güney ve güneybatı cepheli yerleşim, kış aylarında doğal ısınma ve enerji verimliliği sağlarken yan parsel yapılarına gölge düşürmeden optimum TAKS oturumu kurmayı mümkün kılar."}}, {"@type": "Question", "name": "Çekme mesafeleri ve TAKS/KAKS 3D kütlede nasıl uygulanır?", "acceptedAnswer": {"@type": "Answer", "text": "Planlı Alanlar İmar Yönetmeliği uyarınca ön bahçeden en az 5 m, yan bahçelerden ise kat adedine bağlı 3 m ve üzeri çekme mesafesi bırakılarak kalan net alanda kat alanı ve emsal sınırı içinde 3 boyutlu kütle oluşturulur."}}]}</script>
    <link rel="alternate" type="text/markdown" href="https://www.parselsorgu.net/llms.txt" title="ParselSorgu AI / LLM Bilgi Bankası">
    <link rel="alternate" type="application/json" href="https://www.parselsorgu.net/api/2026-kadastro-endeks.json" title="2026 Kadastro ve İmar Açık Veri Seti">
    <script type="application/ld+json">{"@context": "https://schema.org", "@type": "WebPage", "speakable": {"@type": "SpeakableSpecification", "cssSelector": ["h1", ".lead", ".summary-box", ".hero-desc", "main p"]}, "isBasedOn": "https://www.parselsorgu.net/api/2026-kadastro-endeks.json", "publisher": {"@type": "Organization", "name": "Ant Harita Mühendislik - ParselSorgu.net", "url": "https://www.parselsorgu.net/"}}</script>
</head>
<body>
<?= render_navbar('eklentiler') ?>

<main class="sun-container">
    <section class="sun-hero">
        <div>
            <span class="sun-badge"><i class="fa-solid fa-sun"></i> 3D MİMARİ KÜTLE &amp; GÜNEŞ GÖLGE MOTORU</span>
            <h1>Arsa Üstü 3D Bina Yerleşim &amp; Güneş / Gölge Simülatörü</h1>
            <p>Arsa en-boyu, çekme mesafeleri (5m ön / 3m yan) ve TAKS-KAKS katsayılarına göre oluşacak 3D bina kütlesini döndürerek inceleyin; saat sürgüsüyle gün boyu cephe güneşlenmesi ve komşu gölgesini görün.</p>
        </div>
        <a href="/taks-kaks-hesaplama" style="background:rgba(56,189,248,0.14); color:#38bdf8; border:1px solid rgba(56,189,248,0.35); padding:9px 14px; border-radius:8px; text-decoration:none; font-size:12px; font-weight:800;">
            <i class="fa-solid fa-vector-square"></i> 2D İmar Çapı Çizimi
        </a>
    </section>

    <div class="sun-grid">
        <div class="panel">
            <div class="panel-head"><span><i class="fa-solid fa-sliders" style="color:var(--amber);"></i> Parsel &amp; Emsal Parametreleri</span></div>

            <div class="grid-2">
                <div class="field">
                    <label>Arsa Cephe Eni (m)</label>
                    <input type="number" id="pW" class="s-input" value="25" min="8" max="200" oninput="rebuildScene()">
                </div>
                <div class="field">
                    <label>Arsa Derinliği (m)</label>
                    <input type="number" id="pD" class="s-input" value="32" min="8" max="200" oninput="rebuildScene()">
                </div>
            </div>

            <div class="grid-3">
                <div class="field">
                    <label>TAKS</label>
                    <input type="number" id="pTaks" class="s-input" value="0.30" step="0.05" min="0.1" max="0.8" oninput="rebuildScene()">
                </div>
                <div class="field">
                    <label>KAKS (Emsal)</label>
                    <input type="number" id="pKaks" class="s-input" value="1.50" step="0.1" min="0.2" max="4.0" oninput="rebuildScene()">
                </div>
                <div class="field">
                    <label>Kat Sayısı</label>
                    <input type="number" id="pFloors" class="s-input" value="5" min="1" max="20" oninput="rebuildScene()">
                </div>
            </div>

            <div class="grid-3">
                <div class="field">
                    <label>Ön Çekme (m)</label>
                    <input type="number" id="sFront" class="s-input" value="5" min="0" max="20" oninput="rebuildScene()">
                </div>
                <div class="field">
                    <label>Yan Çekme (m)</label>
                    <input type="number" id="sSide" class="s-input" value="3" min="0" max="15" oninput="rebuildScene()">
                </div>
                <div class="field">
                    <label>Arka Çekme (m)</label>
                    <input type="number" id="sBack" class="s-input" value="3" min="0" max="15" oninput="rebuildScene()">
                </div>
            </div>

            <div class="grid-2">
                <div class="field">
                    <label>Yol / Ön Cephe Yönü</label>
                    <select id="pFacing" class="s-select" onchange="updateSunPosition()">
                        <option value="S" selected>Güney Cephe (En İyi Güneş)</option>
                        <option value="E">Doğu Cephe (Sabah Güneşi)</option>
                        <option value="W">Batı Cephe (Akşam Güneşi)</option>
                        <option value="N">Kuzey Cephe</option>
                    </select>
                </div>
                <div class="field">
                    <label>Mevsim (Güneş Açısı)</label>
                    <select id="pSeason" class="s-select" onchange="updateSunPosition()">
                        <option value="summer">21 Haziran (Yaz - Yüksek Açı)</option>
                        <option value="equinox" selected>21 Mart / 23 Eylül (Ekinoks)</option>
                        <option value="winter">21 Aralık (Kış - Uzun Gölge)</option>
                    </select>
                </div>
            </div>

            <div id="sunInsightBox" style="background:rgba(245,158,11,0.1); border:1px solid rgba(245,158,11,0.3); border-radius:10px; padding:12px; font-size:12.5px; color:#fde68a; margin-top:6px;">
                <i class="fa-solid fa-sun"></i> Güneş analizi yükleniyor...
            </div>
        </div>

        <div class="panel">
            <div class="panel-head">
                <span><i class="fa-solid fa-cube" style="color:var(--cyan);"></i> İnteraktif 3D Görünüm <small style="color:var(--muted); font-weight:500;">(Fare ile döndürün, tekerlek ile yakınlaştırın)</small></span>
                <span id="camResetLink" onclick="resetCam()" style="font-size:11.5px; color:var(--cyan); cursor:pointer; font-weight:700;">Kamerayı Sıfırla</span>
            </div>

            <div id="viewport3d"></div>

            <div class="time-control">
                <button type="button" class="btn-play" id="btnPlaySun" onclick="toggleSunAnim()"><i class="fa-solid fa-play"></i> Güneşi Oynat</button>
                <span style="font-size:13px; font-weight:800; color:#fbbf24; min-width:86px;" id="timeLabel">Saat: 12:30</span>
                <input type="range" id="sunHour" min="6" max="19.5" step="0.25" value="12.5" oninput="updateSunPosition()">
                <span style="font-size:11.5px; color:var(--muted);" id="sunAltAz">Açı: 50&deg;</span>
            </div>

            <div class="metrics-4">
                <div class="m-box"><div class="m-lbl">Arsa Alanı</div><div class="m-val" id="mArea">800 m&sup2;</div></div>
                <div class="m-box"><div class="m-lbl">Taban Oturumu</div><div class="m-val" id="mFootprint" style="color:var(--emerald);">240 m&sup2;</div></div>
                <div class="m-box"><div class="m-lbl">Toplam İnşaat</div><div class="m-val" id="mTotal" style="color:var(--cyan);">1.200 m&sup2;</div></div>
                <div class="m-box"><div class="m-lbl">Bina Yüksekliği</div><div class="m-val" id="mHeight" style="color:var(--amber);">15.0 m</div></div>
            </div>
        </div>
    </div>
</main>

<script>
const container = document.getElementById('viewport3d');
const scene = new THREE.Scene();
scene.background = new THREE.Color(0x0b1324);

const camera = new THREE.PerspectiveCamera(45, container.clientWidth / container.clientHeight, 0.5, 500);
const renderer = new THREE.WebGLRenderer({ antialias: true });
renderer.setSize(container.clientWidth, container.clientHeight);
renderer.shadowMap.enabled = true;
renderer.shadowMap.type = THREE.PCFSoftShadowMap;
container.appendChild(renderer.domElement);

// Custom Lightweight Orbit Camera
let camTheta = 0.75, camPhi = 0.95, camDist = 62;
let isDrag = false, prevX = 0, prevY = 0;
function updateCam() {
    camera.position.x = camDist * Math.sin(camPhi) * Math.cos(camTheta);
    camera.position.y = Math.max(4, camDist * Math.cos(camPhi));
    camera.position.z = camDist * Math.sin(camPhi) * Math.sin(camTheta);
    camera.lookAt(0, 4, 0);
}
function resetCam() { camTheta = 0.75; camPhi = 0.95; camDist = 62; updateCam(); }
container.addEventListener('mousedown', e => { isDrag = true; prevX = e.clientX; prevY = e.clientY; });
window.addEventListener('mouseup', () => { isDrag = false; });
window.addEventListener('mousemove', e => {
    if (!isDrag) return;
    camTheta += (e.clientX - prevX) * 0.008;
    camPhi = Math.max(0.25, Math.min(1.48, camPhi - (e.clientY - prevY) * 0.008));
    prevX = e.clientX; prevY = e.clientY;
    updateCam();
});
container.addEventListener('wheel', e => {
    e.preventDefault();
    camDist = Math.max(20, Math.min(180, camDist + e.deltaY * 0.05));
    updateCam();
}, { passive: false });
updateCam();

// Lighting
const ambientLight = new THREE.AmbientLight(0x94a3b8, 0.55);
scene.add(ambientLight);

const sunLight = new THREE.DirectionalLight(0xfffbeb, 1.35);
sunLight.castShadow = true;
sunLight.shadow.mapSize.width = 2048;
sunLight.shadow.mapSize.height = 2048;
sunLight.shadow.camera.near = 1;
sunLight.shadow.camera.far = 220;
const d = 55;
sunLight.shadow.camera.left = -d; sunLight.shadow.camera.right = d;
sunLight.shadow.camera.top = d; sunLight.shadow.camera.bottom = -d;
scene.add(sunLight);

const sunSphere = new THREE.Mesh(
    new THREE.SphereGeometry(2.2, 16, 16),
    new THREE.MeshBasicMaterial({ color: 0xfacc15 })
);
scene.add(sunSphere);

// Base Surround Ground (receives shadows)
const worldPlane = new THREE.Mesh(
    new THREE.PlaneGeometry(300, 300),
    new THREE.MeshStandardMaterial({ color: 0x0f172a, roughness: 0.95 })
);
worldPlane.rotation.x = -Math.PI / 2;
worldPlane.receiveShadow = true;
scene.add(worldPlane);
scene.add(new THREE.GridHelper(160, 32, 0x1e293b, 0x131d31));

let parcelGroup = new THREE.Group();
scene.add(parcelGroup);

function rebuildScene() {
    while (parcelGroup.children.length) parcelGroup.remove(parcelGroup.children[0]);

    const W = Math.max(8, parseFloat(document.getElementById('pW').value) || 25);
    const D = Math.max(8, parseFloat(document.getElementById('pD').value) || 32);
    const taks = Math.max(0.05, parseFloat(document.getElementById('pTaks').value) || 0.30);
    const kaks = Math.max(0.1, parseFloat(document.getElementById('pKaks').value) || 1.50);
    const floors = Math.max(1, parseInt(document.getElementById('pFloors').value) || 5);
    const sFront = Math.max(0, parseFloat(document.getElementById('sFront').value) || 0);
    const sSide = Math.max(0, parseFloat(document.getElementById('sSide').value) || 0);
    const sBack = Math.max(0, parseFloat(document.getElementById('sBack').value) || 0);

    const area = W * D;
    const maxW = Math.max(3, W - 2 * sSide);
    const maxD = Math.max(3, D - sFront - sBack);

    // Parcel surface
    const parcelMesh = new THREE.Mesh(
        new THREE.BoxGeometry(W, 0.25, D),
        new THREE.MeshStandardMaterial({ color: 0x14532d, roughness: 0.85 })
    );
    parcelMesh.position.y = 0.12;
    parcelMesh.receiveShadow = true;
    parcelGroup.add(parcelMesh);

    // Road strip on front (Z+)
    const roadMesh = new THREE.Mesh(
        new THREE.BoxGeometry(W + 20, 0.15, 7),
        new THREE.MeshStandardMaterial({ color: 0x334155, roughness: 0.9 })
    );
    roadMesh.position.set(0, 0.08, D / 2 + 3.8);
    roadMesh.receiveShadow = true;
    parcelGroup.add(roadMesh);

    // Neighbor silhouette buildings (left & right for realistic context)
    const nbMat = new THREE.MeshStandardMaterial({ color: 0x1e293b, transparent: true, opacity: 0.55 });
    [-1, 1].forEach(side => {
        const nb = new THREE.Mesh(new THREE.BoxGeometry(W * 0.55, floors * 2.6, D * 0.5), nbMat);
        nb.position.set(side * (W + 4), (floors * 2.6) / 2, -2);
        nb.castShadow = true; nb.receiveShadow = true;
        parcelGroup.add(nb);
    });

    // Building footprint clamped by TAKS and setback zone
    const targetFoot = Math.min(area * taks, maxW * maxD);
    const scaleRatio = Math.sqrt(targetFoot / (maxW * maxD));
    const bW = maxW * Math.min(1, scaleRatio);
    const bD = maxD * Math.min(1, scaleRatio);
    const floorH = 3.0;
    const bH = floors * floorH;
    const offsetZ = (sBack - sFront) / 2;

    // Setback red outline
    const sbEdges = new THREE.EdgesGeometry(new THREE.BoxGeometry(maxW, 0.3, maxD));
    const sbLine = new THREE.LineSegments(sbEdges, new THREE.LineBasicMaterial({ color: 0xef4444 }));
    sbLine.position.set(0, 0.28, offsetZ);
    parcelGroup.add(sbLine);

    // Building mass
    const bldg = new THREE.Mesh(
        new THREE.BoxGeometry(bW, bH, bD),
        new THREE.MeshStandardMaterial({ color: 0xe2e8f0, roughness: 0.55 })
    );
    bldg.position.set(0, bH / 2 + 0.25, offsetZ);
    bldg.castShadow = true;
    bldg.receiveShadow = true;
    parcelGroup.add(bldg);

    // Floor slab rings
    for (let f = 1; f < floors; f++) {
        const slab = new THREE.Mesh(
            new THREE.BoxGeometry(bW + 0.25, 0.22, bD + 0.25),
            new THREE.MeshStandardMaterial({ color: 0x0284c7 })
        );
        slab.position.set(0, f * floorH + 0.25, offsetZ);
        parcelGroup.add(slab);
    }

    const totalConstruct = Math.min(area * kaks, targetFoot * floors);
    document.getElementById('mArea').textContent = Math.round(area).toLocaleString('tr-TR') + ' m²';
    document.getElementById('mFootprint').textContent = Math.round(targetFoot).toLocaleString('tr-TR') + ' m²';
    document.getElementById('mTotal').textContent = Math.round(totalConstruct).toLocaleString('tr-TR') + ' m²';
    document.getElementById('mHeight').textContent = bH.toFixed(1) + ' m';

    updateSunPosition();
}

function updateSunPosition() {
    const hr = parseFloat(document.getElementById('sunHour').value || '12.5');
    const season = document.getElementById('pSeason').value;
    const facing = document.getElementById('pFacing').value;

    const hInt = Math.floor(hr);
    const mins = Math.round((hr - hInt) * 60);
    document.getElementById('timeLabel').textContent = `Saat: ${String(hInt).padStart(2,'0')}:${String(mins).padStart(2,'0')}`;

    const maxElev = season === 'summer' ? 74 : (season === 'winter' ? 27 : 50);
    const dayProg = (hr - 6) / 13.5; // 0..1 sunrise to sunset
    const elevDeg = Math.max(4, Math.sin(dayProg * Math.PI) * maxElev);
    const azimDeg = 90 + dayProg * 180; // East(90) -> South(180) -> West(270)

    const facingOffset = { S: 0, W: 90, N: 180, E: 270 }[facing] || 0;
    const relAzRad = ((azimDeg + facingOffset - 180) * Math.PI) / 180;
    const elevRad = (elevDeg * Math.PI) / 180;

    const dist = 75;
    sunLight.position.set(
        dist * Math.cos(elevRad) * Math.sin(relAzRad),
        dist * Math.sin(elevRad),
        dist * Math.cos(elevRad) * Math.cos(relAzRad)
    );
    sunSphere.position.copy(sunLight.position);
    sunLight.intensity = hr < 7 || hr > 18.5 ? 0.55 : 1.4;

    document.getElementById('sunAltAz').textContent = `Güneş Açısı: ${Math.round(elevDeg)}°`;

    let tip = '';
    if (facing === 'S') tip = 'Güney cephe gün boyu maksimum verimli güneş alır; kışın dahi ısı kazancı yüksektir.';
    else if (facing === 'E') tip = 'Doğu cephe 07:00–12:00 arası doğrudan sabah güneşi alır; öğleden sonra arka bahçe aydınlanır.';
    else if (facing === 'W') tip = 'Batı cephe 13:00–19:00 arası yoğun ikindi ve akşam güneşi alır.';
    else tip = 'Kuzey cephe dolaylı ışık alır; güneydeki arka bahçe tüm gün güneşlenir.';

    if (season === 'winter') tip += ' Kış açısı (27°) nedeniyle komşu parsellere uzun gölge düşer.';
    document.getElementById('sunInsightBox').innerHTML = `<i class="fa-solid fa-sun"></i> <b>Cephe &amp; Gölge Analizi:</b> ${tip}`;
}

let animTimer = null;
function toggleSunAnim() {
    const btn = document.getElementById('btnPlaySun');
    if (animTimer) {
        clearInterval(animTimer); animTimer = null;
        btn.innerHTML = '<i class="fa-solid fa-play"></i> Güneşi Oynat';
        return;
    }
    btn.innerHTML = '<i class="fa-solid fa-pause"></i> Durdur';
    const slider = document.getElementById('sunHour');
    animTimer = setInterval(() => {
        let v = parseFloat(slider.value) + 0.15;
        if (v > 19.5) v = 6.0;
        slider.value = v.toFixed(2);
        updateSunPosition();
    }, 80);
}

window.addEventListener('resize', () => {
    camera.aspect = container.clientWidth / container.clientHeight;
    camera.updateProjectionMatrix();
    renderer.setSize(container.clientWidth, container.clientHeight);
});

function animate() {
    requestAnimationFrame(animate);
    renderer.render(scene, camera);
}
rebuildScene();
animate();
</script>
</body>
</html>
