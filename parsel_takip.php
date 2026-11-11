<?php
/**
 * ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ - PARSEL PRO
 * SaaS Modül 1: Akıllı Parsel Takip & İmar Değişikliği Alarm Servisi
 * Pure PHP 8.3 / MySQL / Responsive SaaS UI
 */

declare(strict_types=1);

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/navbar.php';

// AJAX ENDPOINTS HANDLER
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    header('Content-Type: application/json; charset=utf-8');
    global $pdo;

    $action = trim($_POST['action']);

    if ($action === 'create_alarm') {
        $fullName = trim($_POST['full_name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $il = trim($_POST['il'] ?? '');
        $ilce = trim($_POST['ilce'] ?? '');
        $mahalle = trim($_POST['mahalle'] ?? '');
        $ada = trim($_POST['ada'] ?? '');
        $parsel = trim($_POST['parsel'] ?? '');
        $channel = trim($_POST['channel'] ?? 'email');
        $alarmTypes = $_POST['alarm_types'] ?? [];

        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['success' => false, 'message' => 'Lütfen geçerli bir e-posta adresi giriniz.']);
            exit;
        }

        if (empty($il) || empty($ilce) || empty($ada) || empty($parsel)) {
            echo json_encode(['success' => false, 'message' => 'Lütfen il, ilçe, ada ve parsel bilgilerini eksiksiz giriniz.']);
            exit;
        }

        if (empty($alarmTypes)) {
            $alarmTypes = ['imar_degisikligi', 'fiyat_degisimi'];
        }

        try {
            // Check if already tracking
            $checkStmt = $pdo->prepare("SELECT id FROM parsel_alarms WHERE email = ? AND il_adi = ? AND ilce_adi = ? AND ada_no = ? AND parsel_no = ? AND status = 'active' LIMIT 1");
            $checkStmt->execute([$email, $il, $ilce, $ada, $parsel]);
            if ($checkStmt->fetch()) {
                echo json_encode(['success' => false, 'message' => 'Bu parsel zaten aktif takip listenizde bulunuyor.']);
                exit;
            }

            $stmt = $pdo->prepare("INSERT INTO parsel_alarms (full_name, email, phone, il_adi, ilce_adi, mahalle_adi, ada_no, parsel_no, alarm_types, channel, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'active')");
            $stmt->execute([
                $fullName,
                $email,
                $phone,
                $il,
                $ilce,
                $mahalle,
                $ada,
                $parsel,
                json_encode($alarmTypes, JSON_UNESCAPED_UNICODE),
                $channel
            ]);

            echo json_encode([
                'success' => true,
                'message' => 'Parsel canlı takip nöbetine başarıyla eklendi! İmar veya emsal değişikliklerinde anında bilgilendirileceksiniz.',
                'alarm_id' => $pdo->lastInsertId()
            ]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Kayıt sırasında bir hata oluştu: ' . $e->getMessage()]);
        }
        exit;
    }

    if ($action === 'get_my_alarms') {
        $identifier = trim($_POST['identifier'] ?? '');
        if (empty($identifier)) {
            echo json_encode(['success' => false, 'message' => 'E-posta veya telefon numarası giriniz.']);
            exit;
        }

        try {
            $stmt = $pdo->prepare("SELECT id, il_adi, ilce_adi, mahalle_adi, ada_no, parsel_no, alarm_types, channel, status, created_at FROM parsel_alarms WHERE (email = ? OR phone = ?) ORDER BY id DESC LIMIT 50");
            $stmt->execute([$identifier, $identifier]);
            $alarms = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode(['success' => true, 'alarms' => $alarms]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Kayıtlar sorgulanamadı: ' . $e->getMessage()]);
        }
        exit;
    }

    if ($action === 'delete_alarm') {
        $alarmId = (int)($_POST['alarm_id'] ?? 0);
        $email = trim($_POST['email'] ?? '');

        try {
            $stmt = $pdo->prepare("DELETE FROM parsel_alarms WHERE id = ? AND email = ?");
            $stmt->execute([$alarmId, $email]);
            echo json_encode(['success' => true, 'message' => 'Takip alarmı başarıyla kaldırıldı.']);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'İşlem başarısız: ' . $e->getMessage()]);
        }
        exit;
    }

    echo json_encode(['success' => false, 'message' => 'Geçersiz istek.']);
    exit;
}

$page_title = "Akıllı Parsel Takip & İmar Alarmı | ParselSorgu";
$meta_desc = "Arsanızı veya yatırım parselinizi 7/24 canlı takibe alın. Askı imar planı değişiklikleri ve rayiç değişimleri anında cebinize gelsin.";
$canonical_url = "https://www.parselsorgu.net/parsel-takip";

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
    <link rel="alternate" hreflang="tr" href="<?= $canonical_url ?>" />
    <meta property="og:title" content="<?= htmlspecialchars($page_title) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($meta_desc) ?>">
    <meta property="og:url" content="<?= $canonical_url ?>">
    <meta property="og:type" content="website">
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
            --purple: #a855f7;
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
            line-height: 1.6;
            min-height: 100vh;
        }

        .container {
            max-width: 1180px;
            margin: 0 auto;
            padding: 24px 16px 80px 16px;
        }

        /* HERO HEADER */
        .hero-section {
            text-align: center;
            padding: 36px 16px 28px 16px;
            background: radial-gradient(circle at 50% 20%, rgba(56, 189, 248, 0.12) 0%, transparent 70%);
            border-bottom: 1px solid var(--border-color);
            margin-bottom: 32px;
        }
        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(16, 185, 129, 0.12);
            border: 1px solid rgba(16, 185, 129, 0.35);
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 700;
            color: var(--green);
            margin-bottom: 16px;
        }
        .hero-title {
            font-size: 32px;
            font-weight: 800;
            color: #fff;
            margin-bottom: 12px;
            letter-spacing: -0.5px;
        }
        .hero-title span { color: var(--accent); }
        .hero-subtitle {
            font-size: 15px;
            color: var(--text-muted);
            max-width: 820px;
            margin: 0 auto 20px auto;
        }

        .hero-stats {
            display: flex;
            justify-content: center;
            gap: 24px;
            flex-wrap: wrap;
            margin-top: 20px;
        }
        .stat-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: #cbd5e1;
            background: rgba(15, 23, 42, 0.8);
            border: 1px solid var(--border-color);
            padding: 6px 14px;
            border-radius: 20px;
        }
        .stat-item i { color: var(--accent); }

        /* MAIN GRID */
        .saas-grid {
            display: grid;
            grid-template-columns: 1.4fr 1fr;
            gap: 28px;
            align-items: start;
        }

        /* CARD STYLES */
        .saas-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 28px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.35);
        }
        .card-header-title {
            font-size: 18px;
            font-weight: 700;
            color: #fff;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 18px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            padding-bottom: 12px;
        }

        /* FORM ELEMENTS */
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
            margin-bottom: 14px;
        }
        .form-group {
            margin-bottom: 16px;
        }
        .form-label {
            display: block;
            font-size: 12.5px;
            font-weight: 600;
            color: #cbd5e1;
            margin-bottom: 6px;
        }
        .form-control {
            width: 100%;
            padding: 12px 14px;
            background: var(--card-surface);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            color: #fff;
            font-size: 14px;
            outline: none;
            transition: all 0.2s;
        }
        .form-control:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.2);
        }

        /* ALARM TYPE CHECKBOXES */
        .alarm-option {
            background: var(--card-surface);
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 14px;
            margin-bottom: 10px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            cursor: pointer;
            transition: all 0.2s;
        }
        .alarm-option:hover {
            border-color: rgba(56, 189, 248, 0.5);
            background: #17233d;
        }
        .alarm-option input[type="checkbox"] {
            margin-top: 3px;
            width: 18px;
            height: 18px;
            accent-color: var(--accent);
            cursor: pointer;
        }
        .alarm-info h4 {
            font-size: 14px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 2px;
        }
        .alarm-info p {
            font-size: 12px;
            color: var(--text-muted);
            line-height: 1.4;
        }

        /* CHANNEL BUTTONS */
        .channel-selector {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 10px;
            margin-bottom: 20px;
        }
        .channel-btn {
            background: var(--card-surface);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 10px;
            text-align: center;
            font-size: 13px;
            font-weight: 600;
            color: #cbd5e1;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            transition: all 0.2s;
        }
        .channel-btn.active {
            background: rgba(56, 189, 248, 0.15);
            border-color: var(--accent);
            color: var(--accent);
        }

        .btn-submit-alarm {
            width: 100%;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: #fff;
            font-size: 16px;
            font-weight: 800;
            padding: 15px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            box-shadow: 0 4px 20px rgba(16, 185, 129, 0.35);
            transition: all 0.25s;
        }
        .btn-submit-alarm:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 25px rgba(16, 185, 129, 0.5);
        }

        /* RIGHT COLUMN: BENEFITS & MY ALARMS */
        .benefit-box {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 16px;
            background: var(--card-surface);
            border: 1px solid var(--border-color);
            padding: 14px;
            border-radius: 10px;
        }
        .benefit-icon {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background: rgba(56, 189, 248, 0.15);
            color: var(--accent);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }
        .benefit-text h5 {
            font-size: 13.5px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 2px;
        }
        .benefit-text p {
            font-size: 12px;
            color: var(--text-muted);
            line-height: 1.4;
        }

        /* ALARM LIST ITEM */
        .alarm-item {
            background: var(--card-surface);
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 14px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }
        .alarm-item-title {
            font-size: 13px;
            font-weight: 700;
            color: #fff;
        }
        .alarm-item-sub {
            font-size: 11.5px;
            color: var(--text-muted);
        }
        .alarm-badge-active {
            font-size: 10.5px;
            background: rgba(16, 185, 129, 0.15);
            color: var(--green);
            padding: 3px 8px;
            border-radius: 10px;
            border: 1px solid rgba(16, 185, 129, 0.3);
            font-weight: 700;
        }
        .btn-delete-alarm {
            background: rgba(244, 63, 94, 0.15);
            color: var(--rose);
            border: 1px solid rgba(244, 63, 94, 0.3);
            border-radius: 6px;
            padding: 5px 10px;
            font-size: 11.5px;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-delete-alarm:hover {
            background: var(--rose);
            color: #fff;
        }

        .alert-box {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 16px;
            font-size: 13px;
            display: none;
        }
        .alert-success { background: rgba(16, 185, 129, 0.15); border: 1px solid var(--green); color: #a7f3d0; }
        .alert-error { background: rgba(244, 63, 94, 0.15); border: 1px solid var(--rose); color: #fecdd3; }

        @media (max-width: 868px) {
            .saas-grid { grid-template-columns: 1fr; }
            .hero-title { font-size: 24px; }
            .form-row { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    <?= render_navbar('eklentiler') ?>

    <main class="container">
        <!-- HERO -->
        <section class="hero-section">
            <div class="hero-badge">
                <i class="fa-solid fa-bell-concierge"></i> 2026 SaaS • Canlı Parsel Nöbetçisi
            </div>
            <h1 class="hero-title">Akıllı Parsel Takip &amp; <span>İmar Değişikliği Alarmı</span></h1>
            <p class="hero-subtitle">
                Arsanız veya portföyünüz için 7/24 otonom kadastro nöbeti başlatın. Belediye askı imar planı değişiklikleri, 3194 s.K. 8/b ilanları, emsal rayiç değişimleri ve çevredeki yeni ilanlar anında cebinize gelsin.
            </p>
            <div class="hero-stats">
                <div class="stat-item"><i class="fa-solid fa-shield-halved"></i> TMMOB HKMO Sicil: 12480</div>
                <div class="stat-item"><i class="fa-solid fa-satellite-dish"></i> 81 İl, 973 İlçe Canlı Nöbet</div>
                <div class="stat-item"><i class="fa-solid fa-bolt"></i> %100 Ücretsiz Başlangıç</div>
            </div>
        </section>

        <!-- MAIN LAYOUT -->
        <div class="saas-grid">
            <!-- LEFT: FORM -->
            <div class="saas-card">
                <div class="card-header-title">
                    <i class="fa-solid fa-plus-circle" style="color:var(--green);"></i>
                    <span>Yeni Parsel Takip Alarmı Kur</span>
                </div>

                <div id="formAlert" class="alert-box"></div>

                <form id="alarmForm">
                    <!-- AD SOYAD & İLETİŞİM -->
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="full_name"><i class="fa-solid fa-user"></i> Adınız Soyadınız</label>
                            <input type="text" id="full_name" name="full_name" class="form-control" placeholder="Örn: Ahmet Yılmaz" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="email"><i class="fa-solid fa-envelope"></i> E-Posta Adresiniz (Zorunlu)</label>
                            <input type="email" id="email" name="email" class="form-control" placeholder="ornek@alanadi.com" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="phone"><i class="fa-brands fa-whatsapp"></i> WhatsApp / Telefon No (İsteğe Bağlı)</label>
                        <input type="tel" id="phone" name="phone" class="form-control" placeholder="05XXXXXXXXX">
                    </div>

                    <!-- PARSEL SEÇİMİ -->
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="il"><i class="fa-solid fa-map"></i> İl Seçiniz</label>
                            <select id="il" name="il" class="form-control" onchange="loadDistricts(this.value)" required>
                                <option value="">-- İl Seçin --</option>
                                <?php foreach ($CITIES_81 as $code => $name): ?>
                                    <option value="<?= htmlspecialchars($name) ?>"><?= htmlspecialchars($name) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="ilce"><i class="fa-solid fa-building"></i> İlçe</label>
                            <input type="text" id="ilce" name="ilce" class="form-control" placeholder="Örn: Çankaya, Bodrum..." required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="mahalle"><i class="fa-solid fa-location-dot"></i> Mahalle / Köy</label>
                            <input type="text" id="mahalle" name="mahalle" class="form-control" placeholder="Örn: Alacaatlı Mahallesi">
                        </div>
                        <div class="form-row" style="margin-bottom:0;">
                            <div class="form-group">
                                <label class="form-label" for="ada"><i class="fa-solid fa-hashtag"></i> Ada No</label>
                                <input type="text" id="ada" name="ada" class="form-control" placeholder="Örn: 101" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="parsel"><i class="fa-solid fa-draw-polygon"></i> Parsel No</label>
                                <input type="text" id="parsel" name="parsel" class="form-control" placeholder="Örn: 5" required>
                            </div>
                        </div>
                    </div>

                    <!-- ALARM TÜRLERİ -->
                    <div class="form-group" style="margin-top:10px;">
                        <label class="form-label"><i class="fa-solid fa-sliders"></i> Takip Edilecek Alarm Türleri</label>

                        <label class="alarm-option">
                            <input type="checkbox" name="alarm_types[]" value="imar_degisikligi" checked>
                            <div class="alarm-info">
                                <h4><i class="fa-solid fa-bullhorn" style="color:var(--amber);"></i> Belediye Askı İmar Planı Değişikliği</h4>
                                <p>3194 s.K. 8/b gereğince belediyede 30 günlük askı süreci başladığında anında uyarı.</p>
                            </div>
                        </label>

                        <label class="alarm-option">
                            <input type="checkbox" name="alarm_types[]" value="fiyat_degisimi" checked>
                            <div class="alarm-info">
                                <h4><i class="fa-solid fa-chart-line" style="color:var(--accent);"></i> Bölgesel Emsal m² Fiyat Dalgalanması</h4>
                                <p>Mahalledeki arsa rayicinde %10 ve üzeri fiyat artışı veya düşüşü olduğunda bildirim.</p>
                            </div>
                        </label>

                        <label class="alarm-option">
                            <input type="checkbox" name="alarm_types[]" value="yeni_ilan" checked>
                            <div class="alarm-info">
                                <h4><i class="fa-solid fa-house-chimney-window" style="color:var(--green);"></i> 500m Çevrede Yeni Satılık İlanı</h4>
                                <p>Parselinizin yakın çevresinde yeni bir arsa satışa çıktığında piyasa analizi.</p>
                            </div>
                        </label>

                        <label class="alarm-option">
                            <input type="checkbox" name="alarm_types[]" value="kamulastirma_hukuk">
                            <div class="alarm-info">
                                <h4><i class="fa-solid fa-scale-balanced" style="color:var(--purple);"></i> Kamulaştırma &amp; İzale-i Şüyu Duyurusu</h4>
                                <p>Hisseli ortaklığın giderilmesi davası veya kamu terk kararlarında erken ikaz.</p>
                            </div>
                        </label>
                    </div>

                    <!-- BİLDİRİM KANALI -->
                    <div class="form-group">
                        <label class="form-label"><i class="fa-solid fa-paper-plane"></i> Tercih Edilen Bildirim Kanalı</label>
                        <div class="channel-selector">
                            <div class="channel-btn active" data-channel="email" onclick="selectChannel('email')">
                                <i class="fa-solid fa-envelope"></i> E-Posta
                            </div>
                            <div class="channel-btn" data-channel="whatsapp" onclick="selectChannel('whatsapp')">
                                <i class="fa-brands fa-whatsapp"></i> WhatsApp
                            </div>
                            <div class="channel-btn" data-channel="sms" onclick="selectChannel('sms')">
                                <i class="fa-solid fa-message"></i> SMS
                            </div>
                        </div>
                        <input type="hidden" id="channel" name="channel" value="email">
                    </div>

                    <button type="submit" class="btn-submit-alarm">
                        <i class="fa-solid fa-bell"></i> Parseli Canlı Takibe Al (Ücretsiz)
                    </button>
                </form>
            </div>

            <!-- RIGHT: BENEFITS & MY ALARMS PANEL -->
            <div>
                <!-- MY ALARMS LOOKUP -->
                <div class="saas-card" style="margin-bottom:24px;">
                    <div class="card-header-title">
                        <i class="fa-solid fa-list-check" style="color:var(--accent);"></i>
                        <span>Takip Ettiğim Parseller</span>
                    </div>
                    <p style="font-size:12.5px; color:var(--text-muted); margin-bottom:14px;">
                        Daha önce kurduğunuz alarmları görmek veya yönetmek için e-posta adresinizi giriniz:
                    </p>
                    <div style="display:flex; gap:8px; margin-bottom:16px;">
                        <input type="email" id="lookup_email" class="form-control" placeholder="E-posta adresiniz...">
                        <button type="button" onclick="loadMyAlarms()" style="background:var(--accent); color:#090e17; font-weight:700; border:none; border-radius:8px; padding:0 18px; cursor:pointer; flex-shrink:0;">
                            Sorgula
                        </button>
                    </div>
                    <div id="myAlarmsList" style="max-height:260px; overflow-y:auto;">
                        <div style="font-size:12px; color:#64748b; text-align:center; padding:20px 0;">
                            Henüz sorgulama yapılmadı.
                        </div>
                    </div>
                </div>

                <!-- VALUE PROPOSITIONS -->
                <div class="saas-card">
                    <div class="card-header-title">
                        <i class="fa-solid fa-award" style="color:var(--amber);"></i>
                        <span>Neden Parsel Alarmı Kurmalısınız?</span>
                    </div>

                    <div class="benefit-box">
                        <div class="benefit-icon"><i class="fa-solid fa-clock-rotate-left"></i></div>
                        <div class="benefit-text">
                            <h5>30 Günlük Yasal Askı Süresini Kaçırmayın</h5>
                            <p>3194 Sayılı İmar Kanunu gereği plan değişikliklerine 30 gün içinde itiraz edilmezse plan kesinleşir ve dava hakkı zorlaşır.</p>
                        </div>
                    </div>

                    <div class="benefit-box">
                        <div class="benefit-icon" style="background:rgba(16,185,129,0.15); color:var(--green);"><i class="fa-solid fa-coins"></i></div>
                        <div class="benefit-text">
                            <h5>Değer Kaybını &amp; Fırsatları Önceden Görün</h5>
                            <p>Bölgenizdeki emsal fiyat hareketlerinden haberdar olarak arsanızı ucuza satmaktan korunun veya kelepir fırsatları yakalayın.</p>
                        </div>
                    </div>

                    <div class="benefit-box">
                        <div class="benefit-icon" style="background:rgba(244,63,94,0.15); color:var(--rose);"><i class="fa-solid fa-shield-halved"></i></div>
                        <div class="benefit-text">
                            <h5>TMMOB HKMO Tescilli Mühendislik Güvencesi</h5>
                            <p>Ant Harita (Sicil: 12480) CBS algoritmaları resmi MEGSİS ve belediye açık veri servisleriyle senkron çalışır.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        function selectChannel(channel) {
            document.querySelectorAll('.channel-btn').forEach(btn => btn.classList.remove('active'));
            const target = document.querySelector(`.channel-btn[data-channel="${channel}"]`);
            if (target) target.classList.add('active');
            document.getElementById('channel').value = channel;
        }

        // Handle alarm form submission
        document.getElementById('alarmForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            const alertBox = document.getElementById('formAlert');
            alertBox.style.display = 'none';

            const formData = new FormData(this);
            formData.append('action', 'create_alarm');

            try {
                const response = await fetch('/parsel-takip', {
                    method: 'POST',
                    body: formData
                });
                const res = await response.json();

                alertBox.style.display = 'block';
                if (res.success) {
                    alertBox.className = 'alert-box alert-success';
                    alertBox.innerHTML = '<i class="fa-solid fa-circle-check"></i> ' + res.message;
                    // Auto load alarms for this email
                    document.getElementById('lookup_email').value = document.getElementById('email').value;
                    loadMyAlarms();
                } else {
                    alertBox.className = 'alert-box alert-error';
                    alertBox.innerHTML = '<i class="fa-solid fa-triangle-exclamation"></i> ' + res.message;
                }
            } catch (err) {
                alertBox.style.display = 'block';
                alertBox.className = 'alert-box alert-error';
                alertBox.innerHTML = '<i class="fa-solid fa-circle-xmark"></i> Bir bağlantı hatası oluştu, lütfen tekrar deneyiniz.';
            }
        });

        // Load user alarms
        async function loadMyAlarms() {
            const email = document.getElementById('lookup_email').value.trim();
            const listEl = document.getElementById('myAlarmsList');
            if (!email) {
                alert('Lütfen e-posta adresinizi giriniz.');
                return;
            }

            listEl.innerHTML = '<div style="text-align:center; padding:15px; color:#94a3b8;"><i class="fa-solid fa-spinner fa-spin"></i> Sorgulanıyor...</div>';

            const formData = new FormData();
            formData.append('action', 'get_my_alarms');
            formData.append('identifier', email);

            try {
                const response = await fetch('/parsel-takip', {
                    method: 'POST',
                    body: formData
                });
                const res = await response.json();

                if (res.success && res.alarms.length > 0) {
                    listEl.innerHTML = res.alarms.map(item => `
                        <div class="alarm-item" id="alarm-${item.id}">
                            <div>
                                <div class="alarm-item-title">
                                    <i class="fa-solid fa-location-dot" style="color:var(--accent);"></i>
                                    ${item.il_adi} / ${item.ilce_adi} &bull; Ada ${item.ada_no}, Parsel ${item.parsel_no}
                                </div>
                                <div class="alarm-item-sub">
                                    ${item.mahalle_adi ? item.mahalle_adi + ' &bull; ' : ''} Kanal: ${item.channel.toUpperCase()} &bull; ${item.created_at.substring(0, 10)}
                                </div>
                            </div>
                            <div style="display:flex; align-items:center; gap:8px;">
                                <span class="alarm-badge-active"><i class="fa-solid fa-circle" style="font-size:7px;"></i> Nöbette</span>
                                <button type="button" class="btn-delete-alarm" onclick="deleteAlarm(${item.id}, '${email}')" title="Takibi Kaldır">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    `).join('');
                } else {
                    listEl.innerHTML = '<div style="font-size:12px; color:#94a3b8; text-align:center; padding:20px 0;">Bu adrese ait aktif takip kaydı bulunamadı.</div>';
                }
            } catch (err) {
                listEl.innerHTML = '<div style="color:#f43f5e; text-align:center; padding:15px;">Sorgulama hatası oluştu.</div>';
            }
        }

        async function deleteAlarm(alarmId, email) {
            if (!confirm('Bu parselin takip alarmını iptal etmek istediğinize emin misiniz?')) return;

            const formData = new FormData();
            formData.append('action', 'delete_alarm');
            formData.append('alarm_id', alarmId);
            formData.append('email', email);

            try {
                const response = await fetch('/parsel-takip', {
                    method: 'POST',
                    body: formData
                });
                const res = await response.json();
                if (res.success) {
                    const row = document.getElementById('alarm-' + alarmId);
                    if (row) row.remove();
                } else {
                    alert(res.message);
                }
            } catch (err) {
                alert('Silme işlemi sırasında hata oluştu.');
            }
        }
    </script>
</body>
</html>
