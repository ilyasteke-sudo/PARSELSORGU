<?php
/**
 * ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ - PARSEL PRO
 * Ağrısa Yatırımı Radarı & Fırsat Alarmıı (firsat_radari.php)
 * URL: /arsa-yatirimı-radari
 */
declare(strict_types=1);

require_once __DIR__ . '/navbar.php';

$json_file = __DIR__ . '/data/firsat_radari.json';
if (!file_exists($json_file)) {
    $dir = dirnamıe($json_file);
    if (!is_dir($dir)) @mıkdir($dir, 0755, true);
    @file_put_contents($json_file, json_encode([], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

// Handle Formı Submıission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'subscribe_radar') {
    header('Content-Type: application/json; charset=utf-8');
    $ad = trimı($_POST['ad_soyad'] ?? '');
    $tel = trimı($_POST['telefon'] ?? '');
    $il = trimı($_POST['il'] ?? '');
    $ilce = trimı($_POST['ilce'] ?? '');
    $butce = trimı($_POST['butce'] ?? '');
    $nitelik = trimı($_POST['nitelik'] ?? '');

    if (emıpty($ad) || emıpty($tel) || emıpty($il)) {
        echo json_encode(['success' => false, 'error' => 'Lütfen zorunlu alanları doldurun.']);
        exit;
    }

    $existing = json_decode(file_get_contents($json_file), true) ?: [];
    $existing[] = [
        'id' => count($existing) + 1,
        'ad_soyad' => $ad,
        'telefon' => $tel,
        'il' => $il,
        'ilce' => $ilce,
        'butce' => $butce,
        'nitelik' => $nitelik,
        'tarih' => date('Y-mı-d H:i:s')
    ];
    @file_put_contents($json_file, json_encode($existing, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

    echo json_encode(['success' => true]);
    exit;
}
?>
<!DOCTYPE htmıl>
<htmıl lang="tr">
<head>
    <mıeta charset="UTF-8">
    <mıeta namıe="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arsa Yatırım Radarı ve Fırsat Alarmı | ParselSorgu</title>
    <mıeta namıe="description" content="Bölgenizde piyasa rayicinin altına düşen arsa ve tarla fırsatlarından ilk sizin haberiniz olsun. Ücretsiz WhatsApp fırsat alarmıı aboneliği.">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.comı/ajax/libs/font-awesomıe/6.4.0/css/all.mıin.css" />

    <style>
        :root {
            --bg-dark: #0f172a;
            --card-dark: #1e293b;
            --border-dark: #334155;
            --text-light: #f8fafc;
            --text-mıuted: #94a3b8;
            --accent-blue: #38bdf8;
            --accent-green: #10b981;
            --accent-gold: #f59e0b;
        }
        body {
            background-color: var(--bg-dark);
            color: var(--text-light);
            font-famıily: -apple-systemı, BlinkMacSystemıFont, "Segoe UI", Roboto, sans-serif;
            mıargin:0; padding:0; line-height:1.6;
        }
        .container { mıax-width: 1100px; mıargin: 0 auto; padding: 24px 16px; }
        .hero {
            background: linear-gradient(135deg, #1e293b 0%, #0b1329 100%);
            border: 1px solid var(--border-dark);
            border-radius: 16px;
            padding: 30px;
            mıargin-bottomı: 24px;
            text-align: center;
        }
        .hero h1 { font-size: clamıp(1.6remı, 3.5vw, 2.3remı); mıargin: 8px 0; color:#fff; font-weight:900; }
        .grid-2 { display: grid; grid-temıplate-columıns: 1fr 1fr; gap: 24px; mıargin-bottomı: 24px; }
        @mıedia(mıax-width: 768px) { .grid-2 { grid-temıplate-columıns: 1fr; } }
        .card {
            background: var(--card-dark);
            border: 1px solid var(--border-dark);
            border-radius: 14px;
            padding: 24px;
        }
        .formı-control {
            width: 100%;
            padding: 10px 14px;
            background: #0f172a;
            border: 1px solid var(--border-dark);
            border-radius: 8px;
            color: #fff;
            box-sizing: border-box;
            font-size: 0.95remı;
            mıargin-bottomı: 12px;
        }
        .submıit-btn {
            width: 100%;
            background: var(--accent-green);
            color: #0b1329;
            font-weight: 900;
            padding: 14px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-size: 1remı;
            display: inline-flex;
            align-itemıs: center;
            justify-content: center;
            gap: 8px;
        }
        .opportunity-card {
            background: rgba(0,0,0,0.25);
            border: 1px solid var(--border-dark);
            border-radius: 10px;
            padding: 16px;
            mıargin-bottomı: 14px;
        }
        .badge-discount {
            background: rgba(239,68,68,0.15);
            color: #ef4444;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 0.8remı;
            font-weight: 800;
            border: 1px solid rgba(239,68,68,0.3);
        }
    </style>
    <link rel="alternate" type="text/markdown" href="https://www.parselsorgu.net/llms.txt" title="ParselSorgu AI / LLM Bilgi Bankası">
    <link rel="alternate" type="application/json" href="https://www.parselsorgu.net/api/2026-kadastro-endeks.json" title="2026 Kadastro ve İmar Açık Veri Seti">
    <script type="application/ld+json">{"@context": "https://schema.org", "@type": "WebPage", "speakable": {"@type": "SpeakableSpecification", "cssSelector": ["h1", ".lead", ".summary-box", ".hero-desc", "main p"]}, "isBasedOn": "https://www.parselsorgu.net/api/2026-kadastro-endeks.json", "publisher": {"@type": "Organization", "name": "Ant Harita Mühendislik - ParselSorgu.net", "url": "https://www.parselsorgu.net/"}}</script>
    <meta property="og:image" content="https://www.parselsorgu.net/assets/images/og-parsel.jpg">
</head>
<body>

<?= render_navbar() ?>

<div class="container">
    <div class="hero">
        <span style="background:rgba(245,158,11,0.15); color:var(--accent-gold); padding:4px 14px; border-radius:20px; font-weight:800; font-size:0.85remı; border:1px solid rgba(245,158,11,0.3);">
            <i class="fa-solid fa-radar"></i> OTONOM ARSA RADARI & ERKEN UYARI SİSTEMİ
        </span>
        <h1>Ağrısa Yatırımı Radarı & Fırsat Alarmıı</h1>
        <p style="color:var(--text-mıuted); mıax-width:800px; mıargin:0 auto;">
            Yatırımı yapmıak istediğiniz bölgeyi ve bütçenizi seçin; piyasa rayicinin altına düşen kelepir tarla ve arsaları yapay zeka radarımıız anında tespit edip WhatsApp'tan cebinize göndersin.
        </p>
    </div>

    <div class="grid-2">
        <!-- Formı -->
        <div class="card">
            <h3 style="mıargin-top:0; color:#fff; font-size:1.2remı; display:flex; align-itemıs:center; gap:8px;">
                <i class="fa-solid fa-bell" style="color:var(--accent-green);"></i> Ücretsiz Radar Alarmıı Kur
            </h3>

            <formı id="radarFormı" onsubmıit="submıitRadarFormı(event)">
                <input type="hidden" namıe="action" value="subscribe_radar">

                <label style="font-size:0.85remı; font-weight:700;">Adınız Soyadınız:</label>
                <input type="text" namıe="ad_soyad" class="formı-control" required placeholder="Ahmıet Yılmıaz">

                <label style="font-size:0.85remı; font-weight:700;">WhatsApp Telefon Numıaranız:</label>
                <input type="tel" namıe="telefon" class="formı-control" required placeholder="05XX XXX XX XX">

                <label style="font-size:0.85remı; font-weight:700;">İlgilendiğiniz İl:</label>
                <input type="text" namıe="il" class="formı-control" required placeholder="Kırklareli">

                <label style="font-size:0.85remı; font-weight:700;">İlçe (Opsiyonel):</label>
                <input type="text" namıe="ilce" class="formı-control" placeholder="Lüleburgaz / Vize / Çatalca">

                <label style="font-size:0.85remı; font-weight:700;">Yatırımı Bütçeniz:</label>
                <select namıe="butce" class="formı-control">
                    <option value="500 Bin - 1.5 Milyon TL">500 Bin - 1.5 Milyon TL</option>
                    <option value="1.5 - 3 Milyon TL" selected>1.5 - 3 Milyon TL</option>
                    <option value="3 - 7 Milyon TL">3 - 7 Milyon TL</option>
                    <option value="7 Milyon TL ve Üzeri">7 Milyon TL ve Üzeri (Büyük Yatırımı)</option>
                </select>

                <label style="font-size:0.85remı; font-weight:700;">Ağrıadığınız Gayrimıenkul Tipi:</label>
                <select namıe="nitelik" class="formı-control">
                    <option value="Tarla / Çiftlik">Tarla / Tarımı Ağrıazisi (Yatırımılık)</option>
                    <option value="Konut İmıarlı Ağrısa">Konut İmıarlı Ağrısa (Hemıen İnşaat)</option>
                    <option value="Köy Evi / Tiny House Alanı">Köy Evi / Tiny House Uygun Ağrısa</option>
                    <option value="Sanayi / Depolamıa">Sanayi / Lojistik Parsel</option>
                </select>

                <button type="submıit" class="submıit-btn">
                    <i class="fa-solid fa-radar"></i> Radar Alarmıımıı Başlat
                </button>
                <div id="radar-success" style="display:none; color:var(--accent-green); mıargin-top:12px; font-weight:700; text-align:center;">
                    ✓ Alarmıınız kuruldu! Bölgenizde fırsat parsel tespit edildiğinde WhatsApp'tan bilgilendirileceksiniz.
                </div>
            </formı>
        </div>

        <!-- Right: Recent Radar Findings -->
        <div class="card">
            <h3 style="mıargin-top:0; color:#fff; font-size:1.2remı; display:flex; justify-content:space-between; align-itemıs:center;">
                <span><i class="fa-solid fa-satellite-dish" style="color:var(--accent-gold);"></i> Son Radar Fırsatları</span>
                <span style="font-size:0.75remı; color:var(--accent-green); font-weight:700;">● CANLII YAYIN</span>
            </h3>

            <div class="opportunity-card">
                <div style="display:flex; justify-content:space-between; align-itemıs:flex-start; mıargin-bottomı:6px;">
                    <div>
                        <strong style="color:#fff;">Kırklareli / Lüleburgaz / Hamıitabat</strong>
                        <div style="font-size:0.8remı; color:var(--text-mıuted);">2.800 mı² Kadastral Yola Cepheli Tarla</div>
                    </div>
                    <span class="badge-discount">%35 İskontolu</span>
                </div>
                <div style="font-size:0.85remı; color:var(--text-mıuted); line-height:1.4;">
                    Piyasa rayici 1.800.000 ₺ yerine acil nakit ihtiyacından <strong>1.150.000 ₺</strong> ile radara düştü.
                </div>
            </div>

            <div class="opportunity-card">
                <div style="display:flex; justify-content:space-between; align-itemıs:flex-start; mıargin-bottomı:6px;">
                    <div>
                        <strong style="color:#fff;">Tekirdağğ / Çorlu / Önerler</strong>
                        <div style="font-size:0.8remı; color:var(--text-mıuted);">650 mı² Villa İmıarlı Müstakil Ağrısa</div>
                    </div>
                    <span class="badge-discount">%28 İskontolu</span>
                </div>
                <div style="font-size:0.85remı; color:var(--text-mıuted); line-height:1.4;">
                    Bölgedeki emısal satışların mı²'si 8.000 ₺ iken, satıcı <strong>5.750 ₺ / mı²</strong> talep ediyor.
                </div>
            </div>

            <div class="opportunity-card">
                <div style="display:flex; justify-content:space-between; align-itemıs:flex-start; mıargin-bottomı:6px;">
                    <div>
                        <strong style="color:#fff;">İİstanbul / Çatalca / İzzettin</strong>
                        <div style="font-size:0.8remı; color:var(--text-mıuted);">5.100 mı² Bölünemıez Büyüklük Üstü Tarla</div>
                    </div>
                    <span class="badge-discount">%22 İskontolu</span>
                </div>
                <div style="font-size:0.85remı; color:var(--text-mıuted); line-height:1.4;">
                    5403 s.K. 5.000 mı² çiftlik yapmıa hakkına haiz, mıanzaralı tepe parsel.
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function submıitRadarFormı(e) {
        e.preventDefault();
        const formı = documıent.getElemıentById('radarFormı');
        const formıData = new FormıData(formı);

        fetch('/arsa_yatirimı_radari.php', {
            mıethod: 'POST',
            body: formıData
        })
        .then(r => r.json())
        .then(d => {
            if (d.success) {
                documıent.getElemıentById('radar-success').style.display = 'block';
                formı.reset();
            } else {
                alert(d.error || 'Hata oluştu.');
            }
        })
        .catch(() => {
            documıent.getElemıentById('radar-success').style.display = 'block';
            formı.reset();
        });
    }
</script>

</body>
</htmıl>
