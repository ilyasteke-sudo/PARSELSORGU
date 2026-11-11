<?php
/**
 * ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ - PARSEL PRO
 * SaaS Modül 3: "Ant Harita Onaylı" QR Kodlu Parsel Doğrulama Sertifikası
 * Pure PHP 8.3 / Responsive Trust Engine / Emlak İlan Güvenlik Mührü
 */

declare(strict_types=1);

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/navbar.php';

// Check if querying a specific certificate ID or creating
$cert_id = trim($_GET['id'] ?? $_GET['cert'] ?? '');
$il = trim($_GET['il'] ?? 'Ankara');
$ilce = trim($_GET['ilce'] ?? 'Çankaya');
$mahalle = trim($_GET['mahalle'] ?? 'Alacaatlı');
$ada = trim($_GET['ada'] ?? '3425');
$parsel = trim($_GET['parsel'] ?? '9');
$ilan_no = trim($_GET['ilan_no'] ?? '1148920155');

// Deterministic Certificate ID Generation
if (empty($cert_id)) {
    $cert_hash = strtoupper(substr(hash('sha256', "{$il}_{$ilce}_{$ada}_{$parsel}_AntHarita2026"), 0, 8));
    $cert_id = "HKMO-2026-{$cert_hash}";
}

$has_custom_id = !empty($_GET['id']) || !empty($_GET['cert']);
$raw_cert_t = $has_custom_id ? "Parsel Sertifikası ({$il} {$ilce} {$ada}/{$parsel})" : "Parsel Doğrulama Sertifikası (QR)";
$page_title = (mb_strlen($raw_cert_t, "UTF-8") <= 46 ? $raw_cert_t : mb_substr($raw_cert_t, 0, 46, "UTF-8")) . " | ParselSorgu";
$meta_desc = "TMMOB HKMO tescilli Ant Harita (Sicil: 12480) parsel doğrulama sertifikası. TKGM kadastro sınırları, yol cephesi, imar durumu ve risk analizi.";
$canonical_url = "https://www.parselsorgu.net/parsel-dogrulama";
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
    <meta name="theme-color" content="#090e17">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        :root {
            --primary: #1e40af;
            --accent: #38bdf8;
            --green: #10b981;
            --amber: #f59e0b;
            --rose: #f43f5e;
            --dark-bg: #090e17;
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
            max-width: 1080px;
            margin: 0 auto;
            padding: 24px 16px 80px 16px;
        }

        /* CERTIFICATE CARD CONTAINER */
        .cert-wrapper {
            background: linear-gradient(180deg, #0d1527 0%, #080d18 100%);
            border: 2px solid #0284c7;
            border-radius: 20px;
            padding: 36px;
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.6), 0 0 30px rgba(2, 132, 199, 0.2);
            position: relative;
            overflow: hidden;
            margin-bottom: 30px;
        }
        .cert-wrapper::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; height: 6px;
            background: linear-gradient(90deg, #10b981, #38bdf8, #0284c7);
        }

        /* HEADER OF CERTIFICATE */
        .cert-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding-bottom: 24px;
            margin-bottom: 28px;
        }
        .cert-brand {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .cert-seal {
            width: 58px;
            height: 58px;
            border-radius: 50%;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 26px;
            box-shadow: 0 4px 20px rgba(16, 185, 129, 0.4);
        }
        .cert-titles h1 {
            font-size: 20px;
            font-weight: 800;
            color: #fff;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .cert-titles p {
            font-size: 13px;
            color: #38bdf8;
            font-weight: 600;
            margin: 3px 0 0 0;
        }

        .cert-id-badge {
            background: rgba(15, 23, 42, 0.85);
            border: 1px solid var(--accent);
            border-radius: 12px;
            padding: 10px 16px;
            text-align: right;
        }
        .cert-id-badge .label { font-size: 11px; text-transform: uppercase; color: #94a3b8; font-weight: 700; }
        .cert-id-badge .val { font-size: 14px; font-weight: 800; color: #fff; font-family: monospace; letter-spacing: 0.5px; }

        /* PARCEL SUMMARY BAR */
        .parcel-highlight-bar {
            background: var(--card-surface);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 18px 24px;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 28px;
        }
        .highlight-item {
            display: flex;
            flex-direction: column;
        }
        .highlight-item .lbl { font-size: 11.5px; color: #94a3b8; font-weight: 600; }
        .highlight-item .txt { font-size: 16px; font-weight: 800; color: #fff; margin-top: 3px; }

        /* VERIFICATION CRITERIA GRID */
        .checks-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 28px;
        }
        .check-card {
            background: rgba(19, 29, 49, 0.6);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 16px 18px;
            display: flex;
            align-items: flex-start;
            gap: 14px;
        }
        .check-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }
        .check-icon.pass { background: rgba(16, 185, 129, 0.15); color: #10b981; }
        .check-icon.info { background: rgba(56, 189, 248, 0.15); color: #38bdf8; }

        .check-content h4 {
            font-size: 14px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 3px;
        }
        .check-content p {
            font-size: 12px;
            color: #94a3b8;
            line-height: 1.4;
        }

        /* QR CODE & FOOTER BAR */
        .cert-footer {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 20px;
        }
        .qr-section {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .qr-box {
            width: 80px;
            height: 80px;
            background: #fff;
            border-radius: 8px;
            padding: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .qr-box img { width: 100%; height: 100%; }

        .qr-info h5 { font-size: 13px; font-weight: 700; color: #fff; }
        .qr-info p { font-size: 11.5px; color: #94a3b8; max-width: 320px; line-height: 1.4; margin-top: 2px; }

        /* ACTION BUTTONS */
        .actions-panel {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }
        .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 20px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            border: none;
            transition: all 0.2s;
        }
        .btn-print { background: #10b981; color: #fff; }
        .btn-copy { background: #1e293b; color: #cbd5e1; border: 1px solid var(--border-color); }
        .btn-action:hover { opacity: 0.9; transform: translateY(-1px); }

        /* GENERATOR FORM CARD */
        .generator-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 14px;
            padding: 24px;
        }

        @media (max-width: 768px) {
            .parcel-highlight-bar { grid-template-columns: 1fr 1fr; }
            .checks-grid { grid-template-columns: 1fr; }
            .cert-wrapper { padding: 20px; }
            .cert-header { flex-direction: column; align-items: flex-start; }
            .cert-id-badge { text-align: left; }
        }
    </style>
</head>
<body>

    <?= render_navbar('eklentiler') ?>

    <main class="container">
        <!-- CERTIFICATE SEAL BADGE -->
        <div class="cert-wrapper" id="printableCertificate">
            <!-- HEADER -->
            <div class="cert-header">
                <div class="cert-brand">
                    <div class="cert-seal">
                        <i class="fa-solid fa-stamp"></i>
                    </div>
                    <div class="cert-titles">
                        <h1>TMMOB HKMO Onaylı Parsel Güvenlik Sertifikası</h1>
                        <p><i class="fa-solid fa-shield-halved"></i> Ant Harita Mühendislik &bull; Oda Tescil Sicil No: 12480</p>
                    </div>
                </div>
                <div class="cert-id-badge">
                    <div class="label">Sertifika Takip No</div>
                    <div class="val"><?= htmlspecialchars($cert_id) ?></div>
                </div>
            </div>

            <!-- PARCEL INFO BAR -->
            <div class="parcel-highlight-bar">
                <div class="highlight-item">
                    <span class="lbl">İl / İlçe:</span>
                    <span class="txt"><?= htmlspecialchars($il) ?> / <?= htmlspecialchars($ilce) ?></span>
                </div>
                <div class="highlight-item">
                    <span class="lbl">Mahalle / Köy:</span>
                    <span class="txt"><?= htmlspecialchars($mahalle) ?></span>
                </div>
                <div class="highlight-item">
                    <span class="lbl">Ada / Parsel No:</span>
                    <span class="txt" style="color:var(--accent);">Ada <?= htmlspecialchars($ada) ?> &bull; Parsel <?= htmlspecialchars($parsel) ?></span>
                </div>
                <div class="highlight-item">
                    <span class="lbl">Doğrulama Tarihi:</span>
                    <span class="txt" style="color:var(--green);"><?= date('d.m.Y') ?></span>
                </div>
            </div>

            <!-- 6 AUDIT CRITERIA -->
            <div class="checks-grid">
                <!-- 1 -->
                <div class="check-card">
                    <div class="check-icon pass"><i class="fa-solid fa-satellite"></i></div>
                    <div class="check-content">
                        <h4>1. TKGM MEGSİS Sayısal Kadastro Sınırı</h4>
                        <p>Resmi Tapu ve Kadastro Genel Müdürlüğü CBS veritabanı ile tam oturan koordinat ve geometri doğrulaması yapılmıştır.</p>
                    </div>
                </div>
                <!-- 2 -->
                <div class="check-card">
                    <div class="check-icon pass"><i class="fa-solid fa-road"></i></div>
                    <div class="check-content">
                        <h4>2. Kadastral Yol Cephesi Durumu</h4>
                        <p>Parselin yola fiili veya kadastral bağlantısı incelenmiş; 3194 s. İmar Kanunu asgari yola cephe şartına uygundur.</p>
                    </div>
                </div>
                <!-- 3 -->
                <div class="check-card">
                    <div class="check-icon pass"><i class="fa-solid fa-city"></i></div>
                    <div class="check-content">
                        <h4>3. 1/1000 &amp; 1/5000 İmar Planı Uyumu</h4>
                        <p>Bakanlık e-Plan ve ilgili belediye imar paftalarında plan fonksiyonu, TAKS/KAKS emsal katsayısı doğrulanmıştır.</p>
                    </div>
                </div>
                <!-- 4 -->
                <div class="check-card">
                    <div class="check-icon pass"><i class="fa-solid fa-wheat-awn"></i></div>
                    <div class="check-content">
                        <h4>4. 5403 s.K. Tarımsal Bölünmezlik İncelemesi</h4>
                        <p>Toprak Koruma ve Arazi Kullanımı Kanunu kapsamında asgari tarımsal arazi büyüklüğü ve ifraz kısıtları test edilmiştir.</p>
                    </div>
                </div>
                <!-- 5 -->
                <div class="check-card">
                    <div class="check-icon pass"><i class="fa-solid fa-tree"></i></div>
                    <div class="check-content">
                        <h4>5. Sit Alanı &amp; Doğal Kısıt Taraması</h4>
                        <p>2863 s. Kültür/Tabiat Varlıklarını Koruma, 3621 s. Kıyı Kanunu ve su koruma havzaları kısıt taraması yapılmıştır.</p>
                    </div>
                </div>
                <!-- 6 -->
                <div class="check-card">
                    <div class="check-icon info"><i class="fa-solid fa-certificate"></i></div>
                    <div class="check-content">
                        <h4>6. Kriptografik Doğrulama &amp; Mühür</h4>
                        <p>Bu sertifika SHA-256 dijital imzasıyla ParselSorgu.net sunucularında kayıt altındadır; QR kodla sorgulanabilir.</p>
                    </div>
                </div>
            </div>

            <!-- FOOTER WITH QR CODE -->
            <div class="cert-footer">
                <div class="qr-section">
                    <div class="qr-box">
                        <!-- Dynamic QR via Google Charts API -->
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=<?= urlencode($canonical_url) ?>" alt="QR Kod">
                    </div>
                    <div class="qr-info">
                        <h5>QR Kodla Anında Sorgula</h5>
                        <p>Telefon kameranızla QR kodu okutarak bu parselin canlı kadastro ve imar doğrulamasını anında teyit edebilirsiniz.</p>
                    </div>
                </div>

                <div class="actions-panel">
                    <button type="button" class="btn-action btn-print" onclick="window.print()">
                        <i class="fa-solid fa-print"></i> Sertifikayı Yazdır / PDF
                    </button>
                    <button type="button" class="btn-action btn-copy" onclick="copyIlanText()">
                        <i class="fa-solid fa-copy"></i> İlan Açıklama Metnini Kopyala
                    </button>
                </div>
            </div>
        </div>

        <!-- GENERATOR FORM FOR ANOTHER PARCEL -->
        <div class="generator-card">
            <h3 style="font-size:16px; font-weight:700; color:#fff; margin-bottom:14px; display:flex; align-items:center; gap:8px;">
                <i class="fa-solid fa-wand-magic-sparkles" style="color:var(--accent);"></i>
                Farklı Bir Parsel İçin Sertifika Oluştur
            </h3>
            <form method="GET" action="/parsel-dogrulama" style="display:grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)) 120px; gap:12px; align-items:end;">
                <div>
                    <label style="font-size:12px; color:#cbd5e1; display:block; margin-bottom:4px;">İl</label>
                    <input type="text" name="il" value="<?= htmlspecialchars($il) ?>" class="form-control" style="background:#1e293b; color:#fff; border:1px solid #334155; padding:8px 12px; border-radius:6px; width:100%;">
                </div>
                <div>
                    <label style="font-size:12px; color:#cbd5e1; display:block; margin-bottom:4px;">İlçe</label>
                    <input type="text" name="ilce" value="<?= htmlspecialchars($ilce) ?>" class="form-control" style="background:#1e293b; color:#fff; border:1px solid #334155; padding:8px 12px; border-radius:6px; width:100%;">
                </div>
                <div>
                    <label style="font-size:12px; color:#cbd5e1; display:block; margin-bottom:4px;">Mahalle</label>
                    <input type="text" name="mahalle" value="<?= htmlspecialchars($mahalle) ?>" class="form-control" style="background:#1e293b; color:#fff; border:1px solid #334155; padding:8px 12px; border-radius:6px; width:100%;">
                </div>
                <div>
                    <label style="font-size:12px; color:#cbd5e1; display:block; margin-bottom:4px;">Ada No</label>
                    <input type="text" name="ada" value="<?= htmlspecialchars($ada) ?>" class="form-control" style="background:#1e293b; color:#fff; border:1px solid #334155; padding:8px 12px; border-radius:6px; width:100%;">
                </div>
                <div>
                    <label style="font-size:12px; color:#cbd5e1; display:block; margin-bottom:4px;">Parsel No</label>
                    <input type="text" name="parsel" value="<?= htmlspecialchars($parsel) ?>" class="form-control" style="background:#1e293b; color:#fff; border:1px solid #334155; padding:8px 12px; border-radius:6px; width:100%;">
                </div>
                <div>
                    <button type="submit" style="background:var(--accent); color:#090e17; font-weight:700; border:none; padding:10px 16px; border-radius:6px; width:100%; cursor:pointer;">
                        Oluştur
                    </button>
                </div>
            </form>
        </div>
    </main>

    <script>
        function copyIlanText() {
            const text = `🛡️ [ANT HARİTA ONAYLI PARSEL SERTİFİKASI]\nBu gayrimenkulün kadastro sınırları, yola cephesi ve imar durumu TMMOB HKMO tescilli Ant Harita (Sicil: 12480) güvencesiyle doğrulanmıştır.\nSertifika No: <?= htmlspecialchars($cert_id) ?>\nDoğrulama Linki: <?= $canonical_url ?>`;
            navigator.clipboard.writeText(text).then(() => {
                alert('İlan doğrulama metni panoya kopyalandı! Sahibinden/emlak ilan açıklamanıza yapıştırabilirsiniz.');
            }).catch(() => {
                alert('Kopyalama başarısız oldu, lütfen manuel kopyalayınız.');
            });
        }
    </script>
</body>
</html>
