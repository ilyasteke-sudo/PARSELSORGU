<?php
/**
 * ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ - PARSEL PRO
 * Müteahhit & Arsa Sahibi Eşleştirme Masası (arsa_pazari.php)
 * Kat Karşılığı & Satılık Arsa Portalı
 * URL: /arsa-pazari & /kat-karsiligi-arsa-pazari
 */
declare(strict_types=1);

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/navbar.php';

$json_file = __DIR__ . '/data/arsa_pazari.json';
if (!file_exists($json_file)) {
    $initial_data = [
        [
            'id' => 1,
            'il' => 'Kırklareli',
            'ilce' => 'Lüleburgaz',
            'mahalle' => 'Hamitabat',
            'ada' => '105',
            'parsel' => '12',
            'alan_m2' => 2450,
            'imar' => 'Konut İmarlı (Ayrık Nizam)',
            'oran' => '%45 Kat Karşılığı',
            'skor' => 94,
            'tarih' => '2026-11-04',
            'aciklama' => 'Yola 32m cepheli, altyapısı hazır, 3 kata imarlı, ruhsat aşamasına uygun.'
        ],
        [
            'id' => 2,
            'il' => 'Tekirdağ',
            'ilce' => 'Çorlu',
            'mahalle' => 'Önerler',
            'ada' => '214',
            'parsel' => '6',
            'alan_m2' => 3800,
            'imar' => 'Villa İmarlı (E: 0.30)',
            'oran' => '%50 Kat Karşılığı',
            'skor' => 91,
            'tarih' => '2026-11-03',
            'aciklama' => 'Lüks villa projesine uygun, köşe parsel, elektrik-su-doğalgaz mevcut.'
        ],
        [
            'id' => 3,
            'il' => 'İstanbul',
            'ilce' => 'Çatalca',
            'mahalle' => 'İzzettin',
            'ada' => '132',
            'parsel' => '4',
            'alan_m2' => 5200,
            'imar' => 'Kırsal Eko-Turizm & Konut',
            'oran' => '%40 Kat Karşılığı',
            'skor' => 88,
            'tarih' => '2026-11-02',
            'aciklama' => 'Tiny House / Doğa projesi veya çiftlik evi projesine hazır 5403 uyumlu arazi.'
        ]
    ];
    $data_dir = dirname($json_file);
    if (!is_dir($data_dir)) @mkdir($data_dir, 0755, true);
    @file_put_contents($json_file, json_encode($initial_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

$listings = json_decode(file_get_contents($json_file), true) ?: [];

// Handle Ajax Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_lead') {
    header('Content-Type: application/json; charset=utf-8');
    $ad = trim($_POST['ad_soyad'] ?? '');
    $tel = trim($_POST['telefon'] ?? '');
    $il = trim($_POST['il'] ?? '');
    $ilce = trim($_POST['ilce'] ?? '');
    $mah = trim($_POST['mahalle'] ?? '');
    $ada = trim($_POST['ada'] ?? '');
    $parsel = trim($_POST['parsel'] ?? '');
    $alan = (int)($_POST['alan_m2'] ?? 0);
    $oran = trim($_POST['oran'] ?? '%45 Kat Karşılığı');
    $not = trim($_POST['notlar'] ?? '');

    if (empty($ad) || empty($tel) || empty($il) || empty($ilce)) {
        echo json_encode(['success' => false, 'error' => 'Lütfen zorunlu alanları doldurun.']);
        exit;
    }

    $new_entry = [
        'id' => count($listings) + 1,
        'il' => $il,
        'ilce' => $ilce,
        'mahalle' => $mah,
        'ada' => $ada,
        'parsel' => $parsel,
        'alan_m2' => $alan,
        'imar' => 'Müteahhit Değerlendirmesinde',
        'oran' => $oran,
        'skor' => 85,
        'tarih' => date('Y-m-d'),
        'aciklama' => $not,
        'sahip_ad' => $ad,
        'sahip_tel' => $tel
    ];

    $listings[] = $new_entry;
    @file_put_contents($json_file, json_encode($listings, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

    echo json_encode(['success' => true]);
    exit;
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kat Karşılığı Arsa Pazarı (2026) | ParselSorgu</title>
    <meta name="description" content="Arsanızı güvenle kat karşılığı müteahhite verin veya onaylı yatırımlık arsaları harita üzerinden inceleyin.">
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
            --accent-gold: #f59e0b;
        }
        body {
            background-color: var(--bg-dark);
            color: var(--text-light);
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            margin:0; padding:0; line-height: 1.6;
        }
        .container { max-width: 1200px; margin: 0 auto; padding: 24px 16px; }
        .hero {
            background: linear-gradient(135deg, #1e293b 0%, #0b1329 100%);
            border: 1px solid var(--border-dark);
            border-radius: 16px;
            padding: 30px;
            margin-bottom: 30px;
            text-align: center;
        }
        .hero h1 { font-size: clamp(1.6rem, 3.5vw, 2.4rem); font-weight: 900; color: #fff; margin: 10px 0; }
        .hero p { color: var(--text-muted); font-size: 1.05rem; max-width: 800px; margin: 0 auto; }
        .grid-3 {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .card {
            background: var(--card-dark);
            border: 1px solid var(--border-dark);
            border-radius: 14px;
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .card:hover { border-color: rgba(56, 189, 248, 0.4); }
        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 12px;
        }
        .badge-oran {
            background: rgba(245, 158, 11, 0.15);
            color: var(--accent-gold);
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 800;
            border: 1px solid rgba(245, 158, 11, 0.3);
        }
        .badge-skor {
            background: rgba(16, 185, 129, 0.15);
            color: var(--accent-green);
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 800;
            border: 1px solid rgba(16, 185, 129, 0.3);
        }
        .btn-wa {
            background: #25d366;
            color: #0b1329;
            font-weight: 800;
            padding: 10px 16px;
            border-radius: 8px;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 14px;
            transition: 0.2s;
        }
        .btn-wa:hover { filter: brightness(1.1); transform: translateY(-1px); }
        .form-section {
            background: var(--card-dark);
            border: 1px solid var(--border-dark);
            border-radius: 16px;
            padding: 28px;
            margin-top: 40px;
        }
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 16px;
            margin-top: 16px;
        }
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
        .submit-btn {
            background: var(--accent-blue);
            color: #0b1329;
            font-weight: 900;
            padding: 14px 28px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-size: 1rem;
            margin-top: 20px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
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
        <span style="background:rgba(245,158,11,0.15); color:var(--accent-gold); padding:4px 14px; border-radius:20px; font-weight:700; font-size:0.85rem; border:1px solid rgba(245,158,11,0.3);">
            <i class="fa-solid fa-handshake"></i> ARSA SAHİBİ & MÜTEAHHİT BULUŞMA MASASI
        </span>
        <h1>Kat Karşılığı & Yatırımlık Arsa Pazarı 2026</h1>
        <p>Arsanızı kurumsal müteahhitlere kat karşılığı verin ya da bölgenizde aplikasyonu yapılmış, imar durumu netleşmiş yüksek getirili arsaları doğrudan harita mühendisliği güvencesiyle inceleyin.</p>
    </div>

    <!-- Active Listings -->
    <h2 style="font-size:1.4rem; color:#fff; margin-bottom:16px; display:flex; align-items:center; gap:8px;">
        <i class="fa-solid fa-layer-group" style="color:var(--accent-blue);"></i> Güncel Kat Karşılığı & Yatırımlık Parseller
    </h2>

    <div class="grid-3">
        <?php foreach ($listings as $l): ?>
        <div class="card">
            <div>
                <div class="card-header">
                    <div>
                        <h3 style="margin:0 0 4px 0; font-size:1.15rem; color:#fff;">
                            <?= htmlspecialchars($l['il']) ?> / <?= htmlspecialchars($l['ilce']) ?>
                        </h3>
                        <span style="color:var(--text-muted); font-size:0.85rem;">
                            <?= htmlspecialchars($l['mahalle']) ?> Mah. (<?= $l['ada'] ?> Ada / <?= $l['parsel'] ?> Parsel)
                        </span>
                    </div>
                    <span class="badge-oran"><?= htmlspecialchars($l['oran']) ?></span>
                </div>

                <div style="margin:12px 0; font-size:0.9rem;">
                    <div style="display:flex; justify-content:space-between; margin-bottom:4px;">
                        <span style="color:var(--text-muted);">Alan:</span>
                        <strong style="color:var(--accent-blue);"><?= number_format($l['alan_m2'], 0, ',', '.') ?> m²</strong>
                    </div>
                    <div style="display:flex; justify-content:space-between; margin-bottom:4px;">
                        <span style="color:var(--text-muted);">İmar Durumu:</span>
                        <strong><?= htmlspecialchars($l['imar']) ?></strong>
                    </div>
                    <div style="display:flex; justify-content:space-between;">
                        <span style="color:var(--text-muted);">Güvenlik Skoru:</span>
                        <span class="badge-skor"><?= $l['skor'] ?> / 100</span>
                    </div>
                </div>

                <p style="color:var(--text-muted); font-size:0.85rem; line-height:1.4; margin:8px 0;">
                    <?= htmlspecialchars($l['aciklama']) ?>
                </p>
            </div>

            <a href="https://wa.me/905428413535?text=<?= urlencode("Merhaba, {$l['il']} {$l['ilce']} {$l['mahalle']} {$l['ada']} ada {$l['parsel']} parsel kat karşılığı arsa ilanı hakkında detaylı bilgi ve imar raporu almak istiyorum.") ?>" target="_blank" class="btn-wa">
                <i class="fa-brands fa-whatsapp fa-lg"></i> Detaylı Raporu İste & İletişime Geç
            </a>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Submission Form -->
    <div class="form-section">
        <h2 style="font-size:1.4rem; color:#fff; margin:0 0 8px 0; display:flex; align-items:center; gap:8px;">
            <i class="fa-solid fa-file-pen" style="color:var(--accent-gold);"></i> Arsamı Müteahhite Vermek İstiyorum
        </h2>
        <p style="color:var(--text-muted); font-size:0.95rem; margin:0 0 20px 0;">
            Arsanızın bilgilerini bırakın; Ant Harita Mühendisliği ekiplerimiz imar, TAKS/KAKS ve aplikasyon analizini yapsın, bölgenizdeki en güvenilir müteahhitlerle sizi buluştursun.
        </p>

        <form id="arsaForm" onsubmit="submitArsaForm(event)">
            <input type="hidden" name="action" value="add_lead">
            <div class="form-grid">
                <div>
                    <label style="font-size:0.85rem; font-weight:700;">Adınız Soyadınız:</label>
                    <input type="text" name="ad_soyad" class="form-control" required placeholder="Örn: Ahmet Yılmaz">
                </div>
                <div>
                    <label style="font-size:0.85rem; font-weight:700;">Telefon Numaranız:</label>
                    <input type="tel" name="telefon" class="form-control" required placeholder="05XX XXX XX XX">
                </div>
                <div>
                    <label style="font-size:0.85rem; font-weight:700;">İl:</label>
                    <input type="text" name="il" class="form-control" required placeholder="Kırklareli">
                </div>
                <div>
                    <label style="font-size:0.85rem; font-weight:700;">İlçe:</label>
                    <input type="text" name="ilce" class="form-control" required placeholder="Lüleburgaz">
                </div>
                <div>
                    <label style="font-size:0.85rem; font-weight:700;">Mahalle / Köy:</label>
                    <input type="text" name="mahalle" class="form-control" required placeholder="Hamitabat">
                </div>
                <div>
                    <label style="font-size:0.85rem; font-weight:700;">Ada / Parsel No:</label>
                    <input type="text" name="ada" class="form-control" placeholder="105 Ada / 12 Parsel">
                </div>
                <div>
                    <label style="font-size:0.85rem; font-weight:700;">Arsa Alanı (m²):</label>
                    <input type="number" name="alan_m2" class="form-control" placeholder="2500">
                </div>
                <div>
                    <label style="font-size:0.85rem; font-weight:700;">İstenen Kat Karşılığı Payı:</label>
                    <select name="oran" class="form-control">
                        <option value="%40 Kat Karşılığı">%40 Kat Karşılığı</option>
                        <option value="%45 Kat Karşılığı" selected>%45 Kat Karşılığı</option>
                        <option value="%50 Kat Karşılığı">%50 Kat Karşılığı</option>
                        <option value="Satılık / Nakit">Doğrudan Satılık</option>
                    </select>
                </div>
            </div>

            <div style="margin-top:16px;">
                <label style="font-size:0.85rem; font-weight:700;">Özel Notlarınız (Yol cephesi, kot durumu vb.):</label>
                <textarea name="notlar" class="form-control" rows="3" placeholder="Arsam köşe parseldir, 3 kat konut imarlıdır..."></textarea>
            </div>

            <button type="submit" class="submit-btn">
                <i class="fa-solid fa-paper-plane"></i> Arsa Başvurusunu Gönder
            </button>
            <span id="form-result" style="display:none; margin-left:14px; font-weight:700; color:var(--accent-green);"></span>
        </form>
    </div>
</div>

<script>
    function submitArsaForm(e) {
        e.preventDefault();
        const form = document.getElementById('arsaForm');
        const formData = new FormData(form);
        const resSpan = document.getElementById('form-result');

        fetch('/arsa_pazari.php', {
            method: 'POST',
            body: formData
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                resSpan.innerText = '✓ Başvurunuz alındı! Harita mühendisimiz en kısa sürede sizinle iletişime geçecektir.';
                resSpan.style.display = 'inline';
                form.reset();
            } else {
                alert(data.error || 'Bir hata oluştu.');
            }
        })
        .catch(err => {
            alert('Bağlantı hatası.');
        });
    }
</script>

</body>
</html>
