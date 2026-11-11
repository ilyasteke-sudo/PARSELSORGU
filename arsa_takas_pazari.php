<?php
/**
 * ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ - PARSEL PRO
 * SaaS 3: Akıllı Arsa Takas (Trampa) & Portföy Eşleştirme Motoru
 * Pure PHP 8.3 / PropTech Marketplace / WhatsApp P2P Entegrasyonlu
 */

declare(strict_types=1);

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/navbar.php';

// Handle Add Listing
$message = '';
$message_type = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_takas') {
    global $pdo;
    $userName = trim($_POST['user_name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $curCity = trim($_POST['current_city'] ?? '');
    $curDist = trim($_POST['current_district'] ?? '');
    $curType = trim($_POST['current_type'] ?? '');
    $curArea = (int)($_POST['current_area'] ?? 0);
    $estVal = (float)($_POST['estimated_value'] ?? 0);
    $tarCity = trim($_POST['target_city'] ?? '');
    $tarType = trim($_POST['target_type'] ?? '');
    $note = trim($_POST['note'] ?? '');

    if (!empty($userName) && !empty($phone) && !empty($curCity) && !empty($tarCity) && $curArea > 0 && $estVal > 0) {
        try {
            $stmt = $pdo->prepare("INSERT INTO `arsa_takas_ilanlari` (user_name, phone, current_city, current_district, current_type, current_area, estimated_value, target_city, target_type, note) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$userName, $phone, $curCity, $curDist, $curType, $curArea, $estVal, $tarCity, $tarType, $note]);
            $message = 'Takas ilanınız başarıyla yayınlandı! Eşleşen kullanıcılar sizinle WhatsApp üzerinden iletişime geçebilecek.';
            $message_type = 'success';
        } catch (Exception $e) {
            $message = 'Kayıt sırasında hata oluştu: ' . $e->getMessage();
            $message_type = 'error';
        }
    } else {
        $message = 'Lütfen zorunlu alanları eksiksiz doldurunuz.';
        $message_type = 'error';
    }
}

// Fetch Listings with Filter
global $pdo;
$filterCurCity = trim($_GET['city'] ?? '');
$filterTarCity = trim($_GET['target'] ?? '');

$sql = "SELECT * FROM `arsa_takas_ilanlari` WHERE status = 'active'";
$params = [];

if (!empty($filterCurCity)) {
    $sql .= " AND current_city = ?";
    $params[] = $filterCurCity;
}
if (!empty($filterTarCity)) {
    $sql .= " AND target_city = ?";
    $params[] = $filterTarCity;
}
$sql .= " ORDER BY id DESC LIMIT 50";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$listings = $stmt->fetchAll(PDO::FETCH_ASSOC);

$page_title = "Akıllı Arsa Takas (Trampa) Pazarı ve Harcı | ParselSorgu";
$meta_desc = "Arsanızı veya tarlanızı Türkiye genelinde değer ve lokasyon denkliğine göre takas edin; 492 s.K. tapu takas harcını hesaplayın.";
$canonical_url = "https://www.parselsorgu.net/arsa-takas-pazari";

$CITIES_81 = [
    "Adana", "Adıyaman", "Afyonkarahisar", "Ağrı", "Amasya", "Ankara", "Antalya", "Artvin", "Aydın", "Balıkesir",
    "Bilecik", "Bingöl", "Bitlis", "Bolu", "Burdur", "Bursa", "Çanakkale", "Çankırı", "Çorum", "Denizli",
    "Diyarbakır", "Edirne", "Elazığ", "Erzincan", "Erzurum", "Eskişehir", "Gaziantep", "Giresun", "Gümüşhane", "Hakkari",
    "Hatay", "Isparta", "Mersin", "İstanbul", "İzmir", "Kars", "Kastamonu", "Kayseri", "Kırklareli", "Kırşehir",
    "Kocaeli", "Konya", "Kütahya", "Malatya", "Manisa", "Kahramanmaraş", "Mardin", "Muğla", "Muş", "Nevşehir",
    "Niğde", "Ordu", "Rize", "Sakarya", "Samsun", "Siirt", "Sinop", "Sivas", "Tekirdağ", "Tokat",
    "Trabzon", "Tunceli", "Şanlıurfa", "Uşak", "Van", "Yozgat", "Zonguldak", "Aksaray", "Bayburt", "Karaman",
    "Kırıkkale", "Batman", "Şırnak", "Bartın", "Ardahan", "Iğdır", "Yalova", "Karabük", "Kilis", "Osmaniye", "Düzce"
];
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($page_title) ?></title>
    <meta name="description" content="<?= htmlspecialchars($meta_desc) ?>">
    <link rel="canonical" href="<?= $canonical_url ?>    <meta property="og:image" content="https://www.parselsorgu.net/assets/images/og-parsel.jpg">
">
    <meta property="og:title" content="<?= htmlspecialchars($page_title) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($meta_desc) ?>">
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
            line-height: 1.5;
        }

        .container {
            max-width: 1240px;
            margin: 0 auto;
            padding: 24px 16px 80px 16px;
        }

        .hero-banner {
            text-align: center;
            padding: 36px 16px 28px 16px;
            background: radial-gradient(circle at 50% 20%, rgba(56, 189, 248, 0.12) 0%, transparent 70%);
            border-bottom: 1px solid var(--border-color);
            margin-bottom: 30px;
        }
        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(56, 189, 248, 0.12);
            border: 1px solid rgba(56, 189, 248, 0.35);
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 700;
            color: var(--accent);
            margin-bottom: 14px;
        }
        .hero-banner h1 {
            font-size: 30px;
            font-weight: 800;
            color: #fff;
            margin-bottom: 10px;
        }
        .hero-banner p {
            font-size: 14.5px;
            color: var(--text-muted);
            max-width: 860px;
            margin: 0 auto;
        }

        /* ACTIONS BAR */
        .actions-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 14px;
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 16px 20px;
            margin-bottom: 24px;
        }

        .btn-new-takas {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: #fff;
            font-size: 14px;
            font-weight: 700;
            padding: 10px 20px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        /* LISTINGS GRID */
        .takas-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(360px, 1fr));
            gap: 20px;
        }
        .takas-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 14px;
            padding: 22px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.25);
            display: flex;
            flex-direction: column;
            position: relative;
            transition: all 0.2s;
        }
        .takas-card:hover {
            border-color: var(--accent);
            transform: translateY(-2px);
        }

        .takas-flow-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: var(--card-surface);
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 14px;
            margin-bottom: 14px;
        }
        .flow-col {
            display: flex;
            flex-direction: column;
        }
        .flow-col .lbl { font-size: 11px; text-transform: uppercase; color: #94a3b8; font-weight: 700; }
        .flow-col .val { font-size: 15px; font-weight: 800; color: #fff; }

        .takas-note {
            font-size: 12.5px;
            color: #cbd5e1;
            line-height: 1.5;
            margin-bottom: 16px;
            flex-grow: 1;
        }

        .takas-footer {
            border-top: 1px solid rgba(255,255,255,0.08);
            padding-top: 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .btn-wa-contact {
            background: #25D366;
            color: #fff;
            padding: 7px 14px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        /* MODAL */
        #modalTakas {
            display: none;
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.75);
            z-index: 9999;
            align-items: center;
            justify-content: center;
            padding: 16px;
        }
        .modal-body {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 14px;
            padding: 24px;
            max-width: 560px;
            width: 100%;
            max-height: 90vh;
            overflow-y: auto;
        }
        .form-control {
            width: 100%;
            padding: 9px 12px;
            background: var(--card-surface);
            border: 1px solid var(--border-color);
            border-radius: 6px;
            color: #fff;
            font-size: 13px;
            margin-bottom: 10px;
            outline: none;
        }

        @media (max-width: 768px) {
            .takas-grid { grid-template-columns: 1fr; }
            .hero-banner h1 { font-size: 22px; }
        }
    </style>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@graph": [
    {
      "@type": "WebApplication",
      "@id": "https://www.parselsorgu.net/arsa-takas-pazari#app",
      "name": "Akıllı Arsa Takas (Trampa) Pazarı",
      "url": "https://www.parselsorgu.net/arsa-takas-pazari",
      "description": "Türkiye geneli arsa, tarla ve kat karşılığı gayrimenkul takas pazarı. Değer aralığına ve ile göre eşleşme ve WhatsApp ile teklif verme.",
      "applicationCategory": "BusinessApplication",
      "operatingSystem": "All",
      "browserRequirements": "Requires JavaScript. Requires HTML5.",
      "offers": {
        "@type": "Offer",
        "price": "0",
        "priceCurrency": "TRY"
      },
      "creator": {
        "@type": "Organization",
        "name": "Ant Harita Mühendislik",
        "url": "https://www.parselsorgu.net",
        "identifier": "TMMOB HKMO Sicil: 12480"
      }
    },
    {
      "@type": "BreadcrumbList",
      "@id": "https://www.parselsorgu.net/arsa-takas-pazari#breadcrumb",
      "itemListElement": [
        {
          "@type": "ListItem",
          "position": 1,
          "name": "Ana Sayfa",
          "item": "https://www.parselsorgu.net/"
        },
        {
          "@type": "ListItem",
          "position": 2,
          "name": "Eklentiler & SaaS",
          "item": "https://www.parselsorgu.net/eklentiler"
        },
        {
          "@type": "ListItem",
          "position": 3,
          "name": "Akıllı Arsa Takas (Trampa) Pazarı",
          "item": "https://www.parselsorgu.net/arsa-takas-pazari"
        }
      ]
    },
    {
      "@type": "FAQPage",
      "@id": "https://www.parselsorgu.net/arsa-takas-pazari#faq",
      "mainEntity": [
        {
          "@type": "Question",
          "name": "Arsa takası (trampa) nasıl yapılır?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "İki taşınmaz maliki karşılıklı anlaşarak tapu müdürlüğünde trampa işlemi gerçekleştirir. Değer farkı varsa fark bedeli resmi senette belirtilir."
          }
        },
        {
          "@type": "Question",
          "name": "Tapuda arsa trampası (takas) harcı ne kadardır?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Trampa işleminde emlak beyan değerinden yüksek olan taşınmazın değeri üzerinden hem alıcı hem satıcı için binde 20 (toplam %4) tapu harcı tahakkuk ettirilir."
          }
        },
        {
          "@type": "Question",
          "name": "Platform üzerinden takas teklifi nasıl verilir?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "İlan havuzundaki ilanlar üzerinden Takas Teklifi Ver butonuna tıklayarak kendi arsanızın bilgilerini doğrudan arsa sahibine WhatsApp üzerinden iletebilirsiniz."
          }
        }
      ]
    }
  ]
}
</script>
    <link rel="alternate" type="text/markdown" href="https://www.parselsorgu.net/llms.txt" title="ParselSorgu AI / LLM Bilgi Bankası">
    <link rel="alternate" type="application/json" href="https://www.parselsorgu.net/api/2026-kadastro-endeks.json" title="2026 Kadastro ve İmar Açık Veri Seti">
    <script type="application/ld+json">{"@context": "https://schema.org", "@type": "WebPage", "speakable": {"@type": "SpeakableSpecification", "cssSelector": ["h1", ".lead", ".summary-box", ".hero-desc", "main p"]}, "isBasedOn": "https://www.parselsorgu.net/api/2026-kadastro-endeks.json", "publisher": {"@type": "Organization", "name": "Ant Harita Mühendislik - ParselSorgu.net", "url": "https://www.parselsorgu.net/"}}</script>
</head>
<body>

    <?= render_navbar('eklentiler') ?>

    <main class="container">
        <!-- HERO -->
        <section class="hero-banner">
            <div class="hero-badge">
                <i class="fa-solid fa-repeat"></i> 2026 PropTech &bull; Karşılıklı Gayrimenkul Takası (Trampa)
            </div>
            <h1>Akıllı Arsa Takas (Trampa) <span>Pazarı &amp; Eşleştirme</span></h1>
            <p>
                Nakit sıkışıklığı yaşamadan elinizdeki arsa, tarla veya konutu Türkiye genelinde değer ve lokasyon denkliğine göre takas edin.
            </p>
        </section>

        <?php if (!empty($message)): ?>
            <div style="padding:14px; border-radius:8px; margin-bottom:20px; font-size:13px; <?= ($message_type === 'success') ? 'background:rgba(16,185,129,0.15); border:1px solid #10b981; color:#a7f3d0;' : 'background:rgba(244,63,94,0.15); border:1px solid #f43f5e; color:#fecdd3;' ?>">
                <i class="fa-solid <?= ($message_type === 'success') ? 'fa-circle-check' : 'fa-triangle-exclamation' ?>"></i> <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <!-- ACTIONS & FILTER BAR -->
        <div class="actions-bar">
            <form method="GET" action="/arsa-takas-pazari" style="display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
                <select name="city" class="form-control" style="width:auto; margin-bottom:0;">
                    <option value="">-- Tüm Mevcut İller --</option>
                    <?php foreach ($CITIES_81 as $c): ?>
                        <option value="<?= htmlspecialchars($c) ?>" <?= ($filterCurCity === $c) ? 'selected' : '' ?>><?= htmlspecialchars($c) ?></option>
                    <?php endforeach; ?>
                </select>
                <select name="target" class="form-control" style="width:auto; margin-bottom:0;">
                    <option value="">-- Hedef Takas İli --</option>
                    <?php foreach ($CITIES_81 as $c): ?>
                        <option value="<?= htmlspecialchars($c) ?>" <?= ($filterTarCity === $c) ? 'selected' : '' ?>><?= htmlspecialchars($c) ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" style="background:#1e293b; color:#fff; border:1px solid var(--border-color); padding:8px 16px; border-radius:6px; cursor:pointer;">
                    <i class="fa-solid fa-filter"></i> Filtrele
                </button>
            </form>

            <button type="button" class="btn-new-takas" onclick="document.getElementById('modalTakas').style.display='flex'">
                <i class="fa-solid fa-plus-circle"></i> Ücretsiz Takas İlanı Ver
            </button>
        </div>

        <!-- LISTINGS -->
        <div class="takas-grid">
            <?php foreach ($listings as $item): ?>
                <div class="takas-card">
                    <div class="takas-flow-row">
                        <div class="flow-col">
                            <span class="lbl"><i class="fa-solid fa-arrow-up-from-bracket" style="color:var(--accent);"></i> Eldeki Taşınmaz:</span>
                            <span class="val"><?= htmlspecialchars($item['current_city']) ?> / <?= htmlspecialchars($item['current_district']) ?></span>
                            <span style="font-size:11.5px; color:#94a3b8;"><?= htmlspecialchars($item['current_type']) ?> &bull; <?= number_format((float)$item['current_area']) ?> m²</span>
                        </div>
                        <div style="font-size:20px; color:var(--green);"><i class="fa-solid fa-right-left"></i></div>
                        <div class="flow-col" style="text-align:right;">
                            <span class="lbl"><i class="fa-solid fa-bullseye" style="color:var(--amber);"></i> Aranan Takas:</span>
                            <span class="val" style="color:var(--amber);"><?= htmlspecialchars($item['target_city']) ?></span>
                            <span style="font-size:11.5px; color:#94a3b8;"><?= htmlspecialchars($item['target_type']) ?></span>
                        </div>
                    </div>

                    <div style="font-size:13px; font-weight:700; color:var(--green); margin-bottom:8px;">
                        <i class="fa-solid fa-tag"></i> Tahmini Değer: <?= number_format((float)$item['estimated_value']) ?> TL
                    </div>

                    <div class="takas-note">
                        "<?= htmlspecialchars($item['note'] ?? '') ?>"
                    </div>

                    <div class="takas-footer">
                        <span style="font-size:11.5px; color:#94a3b8;"><i class="fa-solid fa-user"></i> <?= htmlspecialchars($item['user_name']) ?></span>
                        <a href="https://wa.me/90<?= preg_replace('/[^0-9]/', '', $item['phone']) ?>?text=<?= urlencode("Merhaba {$item['user_name']}, ParselSorgu.net üzerinden verdiğiniz {$item['current_city']} - {$item['target_city']} takas ilanınız için yazıyorum.") ?>" target="_blank" rel="noopener" class="btn-wa-contact">
                            <i class="fa-brands fa-whatsapp"></i> WhatsApp'tan Yaz
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <!-- NEW LISTING MODAL -->
    <div id="modalTakas">
        <div class="modal-body">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:14px; border-bottom:1px solid rgba(255,255,255,0.08); padding-bottom:10px;">
                <h3 style="font-size:16px; color:#fff;"><i class="fa-solid fa-plus-circle" style="color:var(--green);"></i> Yeni Arsa Takas İlanı</h3>
                <button type="button" onclick="document.getElementById('modalTakas').style.display='none'" style="background:none; border:none; color:#94a3b8; font-size:16px; cursor:pointer;">&times;</button>
            </div>

            <form method="POST" action="/arsa-takas-pazari">
                <input type="hidden" name="action" value="add_takas">

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:8px;">
                    <div>
                        <label style="font-size:11.5px; color:#cbd5e1;">Adınız Soyadınız *</label>
                        <input type="text" name="user_name" class="form-control" required placeholder="Ad Soyad">
                    </div>
                    <div>
                        <label style="font-size:11.5px; color:#cbd5e1;">Telefon / WhatsApp *</label>
                        <input type="tel" name="phone" class="form-control" required placeholder="05XXXXXXXXX">
                    </div>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:8px;">
                    <div>
                        <label style="font-size:11.5px; color:#cbd5e1;">Elinizdeki Taşınmaz İli *</label>
                        <select name="current_city" class="form-control" required>
                            <?php foreach ($CITIES_81 as $c): ?>
                                <option value="<?= htmlspecialchars($c) ?>"><?= htmlspecialchars($c) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label style="font-size:11.5px; color:#cbd5e1;">İlçesi</label>
                        <input type="text" name="current_district" class="form-control" required placeholder="İlçe">
                    </div>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:8px;">
                    <div>
                        <label style="font-size:11.5px; color:#cbd5e1;">Nitelik *</label>
                        <select name="current_type" class="form-control">
                            <option value="İmarlı Arsa">İmarlı Arsa</option>
                            <option value="Müstakil Tarla">Müstakil Tarla</option>
                            <option value="Hisseli Tarla">Hisseli Tarla</option>
                            <option value="Zeytinlik">Zeytinlik</option>
                            <option value="Daire / Konut">Daire / Konut</option>
                            <option value="Villa">Villa</option>
                        </select>
                    </div>
                    <div>
                        <label style="font-size:11.5px; color:#cbd5e1;">Alanı (m²) *</label>
                        <input type="number" name="current_area" class="form-control" required placeholder="m²">
                    </div>
                </div>

                <div>
                    <label style="font-size:11.5px; color:#cbd5e1;">Tahmini Değer (TL) *</label>
                    <input type="number" name="estimated_value" class="form-control" required placeholder="Örn: 3500000">
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:8px;">
                    <div>
                        <label style="font-size:11.5px; color:#cbd5e1;">Takas İstediğiniz İl *</label>
                        <select name="target_city" class="form-control" required>
                            <?php foreach ($CITIES_81 as $c): ?>
                                <option value="<?= htmlspecialchars($c) ?>"><?= htmlspecialchars($c) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label style="font-size:11.5px; color:#cbd5e1;">İstenen Taşınmaz Türü</label>
                        <input type="text" name="target_type" class="form-control" placeholder="Örn: Zeytinlik, Arsa, Daire">
                    </div>
                </div>

                <div>
                    <label style="font-size:11.5px; color:#cbd5e1;">Açıklama / Şartlarınız</label>
                    <textarea name="note" class="form-control" rows="2" placeholder="Takas için şartlarınız, yol durumu, emsal katsayısı vb."></textarea>
                </div>

                <button type="submit" class="btn-new-takas" style="width:100%; justify-content:center; margin-top:8px;">
                    <i class="fa-solid fa-check"></i> İlanı Yayına Al
                </button>
            </form>
        </div>
    </div>

    <!-- ANT HARITA SAAS CROSS-LINKING & INTERNAL DISCOVERY ENGINE -->
    <section class="saas-crosslinks-section" style="max-width:1100px; margin:40px auto 20px; padding:24px 20px; background:linear-gradient(135deg, #0b1329 0%, #0f172a 100%); border:1px solid #1e293b; border-radius:16px;">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px; flex-wrap:wrap; gap:10px;">
            <div>
                <h3 style="color:#fff; font-size:15px; font-weight:800; margin:0 0 4px 0; display:flex; align-items:center; gap:8px;">
                    <i class="fa-solid fa-layer-group" style="color:#38bdf8;"></i> Diğer Popüler Harita, Kadastro &amp; Gayrimenkul SaaS Araçlarımız
                </h3>
                <p style="color:#94a3b8; font-size:12px; margin:0;">Ant Harita Mühendislik altyapısıyla geliştirilen diğer akıllı analiz modüllerini keşfedin.</p>
            </div>
            <a href="/eklentiler" style="background:#10b981; color:#fff; padding:6px 14px; border-radius:8px; font-size:12px; font-weight:700; text-decoration:none; display:inline-flex; align-items:center; gap:6px;">
                <i class="fa-solid fa-grid-round"></i> Tüm Modüller (25+) &rarr;
            </a>
        </div>
        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); gap:12px;">
            <a href="/tarla-verimlilik-raporu" style="display:flex; align-items:center; gap:10px; padding:10px 12px; background:#131d31; border:1px solid #1e293b; border-radius:10px; text-decoration:none; color:#f8fafc;">
                <div style="width:36px; height:36px; border-radius:8px; background:rgba(16,185,129,0.15); color:#10b981; display:flex; align-items:center; justify-content:center; font-size:16px;"><i class="fa-solid fa-seedling"></i></div>
                <div><div style="font-size:12.5px; font-weight:700;">Tarla Verimlilik SaaS</div><div style="font-size:11px; color:#94a3b8;">Ürün fizibilitesi &amp; ciro</div></div>
            </a>
            <a href="/emlak-vergisi-hesaplama" style="display:flex; align-items:center; gap:10px; padding:10px 12px; background:#131d31; border:1px solid #1e293b; border-radius:10px; text-decoration:none; color:#f8fafc;">
                <div style="width:36px; height:36px; border-radius:8px; background:rgba(56,189,248,0.15); color:#38bdf8; display:flex; align-items:center; justify-content:center; font-size:16px;"><i class="fa-solid fa-receipt"></i></div>
                <div><div style="font-size:12.5px; font-weight:700;">2026 Emlak Vergisi</div><div style="font-size:11px; color:#94a3b8;">Arsa, konut &amp; arazi harcı</div></div>
            </a>
            <a href="/arsa-takas-pazari" style="display:flex; align-items:center; gap:10px; padding:10px 12px; background:#131d31; border:1px solid #1e293b; border-radius:10px; text-decoration:none; color:#f8fafc;">
                <div style="width:36px; height:36px; border-radius:8px; background:rgba(245,158,11,0.15); color:#f59e0b; display:flex; align-items:center; justify-content:center; font-size:16px;"><i class="fa-solid fa-arrow-right-arrow-left"></i></div>
                <div><div style="font-size:12.5px; font-weight:700;">Arsa Takas Pazarı</div><div style="font-size:11px; color:#94a3b8;">Canlı trampa havuzu</div></div>
            </a>
            <a href="/yapi-kayit-belgesi-sorgulama" style="display:flex; align-items:center; gap:10px; padding:10px 12px; background:#131d31; border:1px solid #1e293b; border-radius:10px; text-decoration:none; color:#f8fafc;">
                <div style="width:36px; height:36px; border-radius:8px; background:rgba(244,63,94,0.15); color:#f43f5e; display:flex; align-items:center; justify-content:center; font-size:16px;"><i class="fa-solid fa-house-chimney-crack"></i></div>
                <div><div style="font-size:12.5px; font-weight:700;">Yapı Kayıt Risk Analizi</div><div style="font-size:11px; color:#94a3b8;">3194 Geçici 16 imar barışı</div></div>
            </a>
            <a href="/tarim-kredisi-hesaplama" style="display:flex; align-items:center; gap:10px; padding:10px 12px; background:#131d31; border:1px solid #1e293b; border-radius:10px; text-decoration:none; color:#f8fafc;">
                <div style="width:36px; height:36px; border-radius:8px; background:rgba(168,85,247,0.15); color:#a855f7; display:flex; align-items:center; justify-content:center; font-size:16px;"><i class="fa-solid fa-tractor"></i></div>
                <div><div style="font-size:12.5px; font-weight:700;">Ziraat Tarım Kredisi</div><div style="font-size:11px; color:#94a3b8;">Sübvansiyonlu hasat vadeli</div></div>
            </a>
            <a href="/arsa-deger-artisi-hesaplama" style="display:flex; align-items:center; gap:10px; padding:10px 12px; background:#131d31; border:1px solid #1e293b; border-radius:10px; text-decoration:none; color:#f8fafc;">
                <div style="width:36px; height:36px; border-radius:8px; background:rgba(16,185,129,0.15); color:#10b981; display:flex; align-items:center; justify-content:center; font-size:16px;"><i class="fa-solid fa-chart-line"></i></div>
                <div><div style="font-size:12.5px; font-weight:700;">5 Yıllık Değer Artışı</div><div style="font-size:11px; color:#94a3b8;">2021-2026 getiri grafiği</div></div>
            </a>
            <a href="/rizai-taksim-sozlesmesi" style="display:flex; align-items:center; gap:10px; padding:10px 12px; background:#131d31; border:1px solid #1e293b; border-radius:10px; text-decoration:none; color:#f8fafc;">
                <div style="width:36px; height:36px; border-radius:8px; background:rgba(192,132,252,0.15); color:#c084fc; display:flex; align-items:center; justify-content:center; font-size:16px;"><i class="fa-solid fa-file-contract"></i></div>
                <div><div style="font-size:12.5px; font-weight:700;">Rıza-i Taksim Protokolü</div><div style="font-size:11px; color:#94a3b8;">Hisseli tapu paylaşımı</div></div>
            </a>
            <a href="/koy-yerlesik-alani-sorgulama" style="display:flex; align-items:center; gap:10px; padding:10px 12px; background:#131d31; border:1px solid #1e293b; border-radius:10px; text-decoration:none; color:#f8fafc;">
                <div style="width:36px; height:36px; border-radius:8px; background:rgba(245,158,11,0.15); color:#f59e0b; display:flex; align-items:center; justify-content:center; font-size:16px;"><i class="fa-solid fa-house-circle-check"></i></div>
                <div><div style="font-size:12.5px; font-weight:700;">Köy İçi İmar Sınırı (300m)</div><div style="font-size:11px; color:#94a3b8;">Plansız alanlar analizi</div></div>
            </a>
        </div>
    </section>

</body>
</html>
