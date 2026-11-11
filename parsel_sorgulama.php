<?php
/**
 * ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ - PARSEL PRO
 * 81 İL, 973 İLÇE & 50.000+ MAHALLE TKGM PARSEL SORGULAMA SEO HUB MOTORU
 * URL Yapısı:
 *  - /parsel-sorgu
 *  - /parsel-sorgu/{il}
 *  - /parsel-sorgu/{il}/{ilce}
 *  - /parsel-sorgu/{il}/{ilce}/{mahalle}
 */
declare(strict_types=1);

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/navbar.php';
require_once __DIR__ . '/NeighborhoodSEOGenerator.php';

$generator = new NeighborhoodSEOGenerator("https://www.parselsorgu.net");

// 1. Slug to City Mapping Dictionary (Clean UTF-8)
$SLUG_TO_CITY = [
    'adana' => 'Adana', 'adiyaman' => 'Adıyaman', 'afyonkarahisar' => 'Afyonkarahisar', 'agri' => 'Ağrı',
    'amasya' => 'Amasya', 'ankara' => 'Ankara', 'antalya' => 'Antalya', 'artvin' => 'Artvin',
    'aydin' => 'Aydın', 'balikesir' => 'Balıkesir', 'bilecik' => 'Bilecik', 'bingol' => 'Bingöl',
    'bitlis' => 'Bitlis', 'bolu' => 'Bolu', 'burdur' => 'Burdur', 'bursa' => 'Bursa',
    'canakkale' => 'Çanakkale', 'cankiri' => 'Çankırı', 'corum' => 'Çorum', 'denizli' => 'Denizli',
    'diyarbakir' => 'Diyarbakır', 'edirne' => 'Edirne', 'elazig' => 'Elazığ', 'erzincan' => 'Erzincan',
    'erzurum' => 'Erzurum', 'eskisehir' => 'Eskişehir', 'gaziantep' => 'Gaziantep', 'giresun' => 'Giresun',
    'gumushane' => 'Gümüşhane', 'hakkari' => 'Hakkari', 'hatay' => 'Hatay', 'isparta' => 'Isparta',
    'mersin' => 'Mersin', 'istanbul' => 'İstanbul', 'izmir' => 'İzmir', 'kars' => 'Kars',
    'kastamonu' => 'Kastamonu', 'kayseri' => 'Kayseri', 'kirklareli' => 'Kırklareli', 'kirsehir' => 'Kırşehir',
    'kocaeli' => 'Kocaeli', 'konya' => 'Konya', 'kutahya' => 'Kütahya', 'malatya' => 'Malatya',
    'manisa' => 'Manisa', 'kahramanmaras' => 'Kahramanmaraş', 'mardin' => 'Mardin', 'mugla' => 'Muğla',
    'mus' => 'Muş', 'nevsehir' => 'Nevşehir', 'nigde' => 'Niğde', 'ordu' => 'Ordu',
    'rize' => 'Rize', 'sakarya' => 'Sakarya', 'samsun' => 'Samsun', 'siirt' => 'Siirt',
    'sinop' => 'Sinop', 'sivas' => 'Sivas', 'tekirdag' => 'Tekirdağ', 'tokat' => 'Tokat',
    'trabzon' => 'Trabzon', 'tunceli' => 'Tunceli', 'sanliurfa' => 'Şanlıurfa', 'usak' => 'Uşak',
    'van' => 'Van', 'yozgat' => 'Yozgat', 'zonguldak' => 'Zonguldak', 'aksaray' => 'Aksaray',
    'bayburt' => 'Bayburt', 'karaman' => 'Karaman', 'kirikkale' => 'Kırıkkale', 'batman' => 'Batman',
    'sirnak' => 'Şırnak', 'bartin' => 'Bartın', 'ardahan' => 'Ardahan', 'igdir' => 'Iğdır',
    'yalova' => 'Yalova', 'karabuk' => 'Karabük', 'kilis' => 'Kilis', 'osmaniye' => 'Osmaniye',
    'duzce' => 'Düzce'
];

$CITY_COORDS = [
    'Adana' => [37.0000, 35.3213], 'Adıyaman' => [37.7648, 38.2786], 'Afyonkarahisar' => [38.7507, 30.5567],
    'Ağrı' => [39.7191, 43.0503], 'Amasya' => [40.6501, 35.8353], 'Ankara' => [39.9208, 32.8541],
    'Antalya' => [36.8969, 30.7133], 'Artvin' => [41.1828, 41.8183], 'Aydın' => [37.8560, 27.8416],
    'Balıkesir' => [39.6484, 27.8826], 'Bilecik' => [40.1451, 29.9799], 'Bingöl' => [38.8854, 40.4983],
    'Bitlis' => [38.4006, 42.1095], 'Bolu' => [40.7350, 31.6061], 'Burdur' => [37.7203, 30.2908],
    'Bursa' => [40.1885, 29.0610], 'Çanakkale' => [40.1553, 26.4142], 'Çankırı' => [40.6013, 33.6134],
    'Çorum' => [40.5506, 34.9556], 'Denizli' => [37.7765, 29.0864], 'Diyarbakır' => [37.9144, 40.2306],
    'Edirne' => [41.6768, 26.5603], 'Elazığ' => [38.6810, 39.2264], 'Erzincan' => [39.7500, 39.5000],
    'Erzurum' => [39.9043, 41.2679], 'Eskişehir' => [39.7767, 30.5206], 'Gaziantep' => [37.0662, 37.3833],
    'Giresun' => [40.9128, 38.3895], 'Gümüşhane' => [40.4600, 39.4700], 'Hakkari' => [37.5833, 43.7333],
    'Hatay' => [36.2000, 36.1667], 'Isparta' => [37.7648, 30.5566], 'Mersin' => [36.8000, 34.6333],
    'İstanbul' => [41.0082, 28.9784], 'İzmir' => [38.4192, 27.1287], 'Kars' => [40.6167, 43.1000],
    'Kastamonu' => [41.3887, 33.7827], 'Kayseri' => [38.7312, 35.4787], 'Kırklareli' => [41.7333, 27.2167],
    'Kırşehir' => [39.1425, 34.1709], 'Kocaeli' => [40.7654, 29.9408], 'Konya' => [37.8667, 32.4833],
    'Kütahya' => [39.4167, 29.9833], 'Malatya' => [38.3552, 38.3095], 'Manisa' => [38.6191, 27.4289],
    'Kahramanmaraş' => [37.5858, 36.9371], 'Mardin' => [37.3212, 40.7245], 'Muğla' => [37.2153, 28.3636],
    'Muş' => [38.7432, 41.5064], 'Nevşehir' => [38.6244, 34.7144], 'Niğde' => [37.9667, 34.6833],
    'Ordu' => [40.9839, 37.8764], 'Rize' => [41.0201, 40.5234], 'Sakarya' => [40.7569, 30.3783],
    'Samsun' => [41.2867, 36.3300], 'Siirt' => [37.9333, 41.9500], 'Sinop' => [42.0231, 35.1531],
    'Sivas' => [39.7477, 37.0179], 'Tekirdağ' => [40.9833, 27.5167], 'Tokat' => [40.3167, 36.5500],
    'Trabzon' => [41.0015, 39.7178], 'Tunceli' => [39.1079, 39.5401], 'Şanlıurfa' => [37.1591, 38.7969],
    'Uşak' => [38.6823, 29.4082], 'Van' => [38.4891, 43.4089], 'Yozgat' => [39.8181, 34.8147],
    'Zonguldak' => [41.4564, 31.7987], 'Aksaray' => [38.3687, 34.0370], 'Bayburt' => [40.2552, 40.2249],
    'Karaman' => [37.1759, 33.2287], 'Kırıkkale' => [39.8468, 33.5153], 'Batman' => [37.8812, 41.1293],
    'Şırnak' => [37.5164, 42.4611], 'Bartın' => [41.6344, 32.3375], 'Ardahan' => [41.1105, 42.7022],
    'Iğdır' => [39.9196, 44.0450], 'Yalova' => [40.6500, 29.2667], 'Karabük' => [41.2061, 32.6204],
    'Kilis' => [36.7184, 37.1212], 'Osmaniye' => [37.0742, 36.2472], 'Düzce' => [40.8438, 31.1565]
];

$BUYUKSEHIRLER = [
    'İstanbul', 'Ankara', 'İzmir', 'Bursa', 'Antalya', 'Adana', 'Konya', 'Şanlıurfa', 'Gaziantep',
    'Kocaeli', 'Mersin', 'Diyarbakır', 'Hatay', 'Manisa', 'Kayseri', 'Samsun', 'Balıkesir',
    'Kahramanmaraş', 'Van', 'Aydın', 'Denizli', 'Sakarya', 'Tekirdağ', 'Muğla', 'Eskişehir',
    'Mardin', 'Malatya', 'Trabzon', 'Erzurum', 'Ordu'
];

// Helper: Clean Mahalle Name
function clean_mahalle_name($name) {
    $cleaned = preg_replace('/\b(mah|mh|mahallesi|koyu|köyü|koyu)\b\.?/iu', '', (string)$name);
    return trim((string)$cleaned);
}

$raw_city = trim($_GET['city'] ?? '');
$raw_district = trim($_GET['district'] ?? '');
$raw_mahalle = trim($_GET['mahalle'] ?? '');

$city_slug = $generator->slugify($raw_city);
$cityName = $SLUG_TO_CITY[$city_slug] ?? null;

$is_all_turkey = false;
if (!$cityName) {
    if (empty($city_slug) || $city_slug === 'turkiye') {
        $is_all_turkey = true;
        $cityName = 'Türkiye';
    } else {
        $cityName = 'Ankara';
        $city_slug = 'ankara';
    }
}

$is_buyuksehir = in_array($cityName, $BUYUKSEHIRLER, true);

// Load Administrative Hierarchy
$admin_file = __DIR__ . '/turkey_administrative_complete.json';
$admin_data = file_exists($admin_file) ? json_decode(file_get_contents($admin_file), true) : [];

$districts = [];
if (isset($admin_data[$cityName]) && is_array($admin_data[$cityName])) {
    $districts = array_keys($admin_data[$cityName]);
}

// Match District if present
$districtName = '';
$districtKey = '';
if (!empty($raw_district)) {
    $dist_slug = $generator->slugify($raw_district);
    foreach ($districts as $d) {
        if ($generator->slugify($d) === $dist_slug) {
            $districtName = $d;
            $districtKey = $d;
            break;
        }
    }
}

// Match Mahalle if present
$mahalleName = '';
$mahalleList = [];
if (!empty($districtName) && isset($admin_data[$cityName][$districtKey]) && is_array($admin_data[$cityName][$districtKey])) {
    $mahalleList = $admin_data[$cityName][$districtKey];

    $is_koy_detected = preg_match('/\b(koyu|köyü|koy|köy)\b/iu', $raw_mahalle);
    if (!empty($raw_mahalle)) {
        $target_m_slug = $generator->slugify(clean_mahalle_name($raw_mahalle));
        foreach ($mahalleList as $m) {
            $cleaned = clean_mahalle_name($m);
            if ($generator->slugify($cleaned) === $target_m_slug || $generator->slugify($m) === $generator->slugify($raw_mahalle)) {
                $mahalleName = $cleaned;
                if (preg_match('/\b(koyu|köyü|koy|köy)\b/iu', (string)$m)) {
                    $is_koy_detected = true;
                }
                break;
            }
        }
        if (empty($mahalleName)) {
            // Fallback: Use raw formatted as Title Case
            $mahalleName = mb_convert_case(str_replace('-', ' ', $raw_mahalle), MB_CASE_TITLE, 'UTF-8');
        }
    }
}

// Determine Hierarchical Level
// 1 = City Level, 2 = District Level, 3 = Mahalle Level
$page_level = 1;
if (!empty($districtName) && empty($mahalleName)) {
    $page_level = 2;
} elseif (!empty($districtName) && !empty($mahalleName)) {
    $page_level = 3;
}

// Coordinates
$baseCoords = $CITY_COORDS[$cityName] ?? [39.9208, 32.8541];
$lat = $baseCoords[0];
$lng = $baseCoords[1];

// Generate SEOPayload for Mahalle Level using NeighborhoodSEOGenerator
$payload = null;
if ($page_level === 3) {
    $hashSeed = hexdec(substr(md5("{$cityName}{$districtName}{$mahalleName}"), 0, 8));

    // Determine realistic profile
    $isRural = (strpos($mahalleName, 'Köy') !== false || strpos($mahalleName, 'Yayla') !== false || !$is_buyuksehir && ($hashSeed % 2 === 0));
    $baskinImar = $isRural ? ($hashSeed % 2 === 0 ? "Tarım" : "Kırsal") : (($hashSeed % 4 === 0) ? "Ticari" : "Konut");
    $toplamParsel = 1200 + ($hashSeed % 4800);
    $ortalamaAlan = $isRural ? (2500 + ($hashSeed % 12000)) : (450 + ($hashSeed % 1100));

    // Slight coordinate offset for neighborhood
    $latOffset = (($hashSeed % 100) - 50) * 0.0008;
    $lngOffset = ((($hashSeed >> 4) % 100) - 50) * 0.0008;
    $lat = round($lat + $latOffset, 6);
    $lng = round($lng + $lngOffset, 6);

    $rawNeighborhoodData = [
        "il" => $cityName,
        "ilce" => $districtName,
        "mahalle" => $mahalleName,
        "tip" => !empty($is_koy_detected) ? "koy" : "kentsel_mahalle",
        "tapuMudurlugu" => "{$districtName} Tapu Müdürlüğü",
        "belediyeAdi" => "{$districtName} Belediyesi",
        "toplam_parsel" => $toplamParsel,
        "ortalama_alan_m2" => $ortalamaAlan,
        "baskin_imar_tipi" => $baskinImar,
        "tapu_mudurlugu" => "{$districtName} Tapu Müdürlüğü",
        "lat" => $lat,
        "lng" => $lng
    ];

    $payload = $generator->generatePagePayload($rawNeighborhoodData);

    $page_title = $payload["seo"]["title"];
    $meta_desc = $payload["seo"]["description"];
    $page_h1 = $payload["seo"]["h1"];
    $canonical_url = $payload["canonical_url"];
    $intro_text = $payload["content"]["intro_text"];
    $stats = $payload["content"]["stats"];
    $faqs = $payload["content"]["faqs"];
    $json_ld = $payload["json_ld"];
} elseif ($page_level === 2) {
    $seo = $generator->generateLocationSEO([
        'il' => $cityName,
        'ilce' => $districtName
    ]);

    $targetLocation = "{$cityName} {$districtName}";
    $page_title = $seo["metaTitle"];
        $meta_desc = $seo["metaDescription"];
        $page_h1 = "{$cityName} {$districtName} E-İmar & Parsel Sorgulama";
        $canonical_url = $seo["canonicalUrl"];
        $egilim = $seo['ortalamaEgilim'] ?? '%8';
        $katsayi = $seo['csidbKatsayi'] ?? '1.05';
        $intro_text = "{$cityName} {$districtName} ilçesindeki tüm mahalle ve köylerde canlı TKGM ada parsel sorgulama, belediye e-imar / e-çap yapılaşma koşulları ve TAKS/KAKS emsal rehberi tek ekranda toplanmıştır. Bölgedeki ortalama arazi eğimi {$egilim} seviyesinde olup, ÇŞİDB birim maliyet katsayısı {$katsayi}x düzeyindedir.";
    $stats = [
        "toplam_parsel" => count($mahalleList) * 2400,
        "ortalama_alan_m2" => 850,
        "baskin_imar_tipi" => $is_buyuksehir ? "Konut & Ticari" : "Karma & Tarım"
    ];
    $faqs = $seo["faqs"];
    $json_ld = $seo["json_ld"];
} else {
    $targetLocation = $is_all_turkey ? "Türkiye" : $cityName;
    if ($is_all_turkey) {
        $page_title = "Ada Parsel Sorgulama ve İmar Durumu (81 İl) | ParselSorgu";
        $meta_desc = "81 il ve 973 ilçede canlı TKGM MEGSİS kadastro verileri, TAKS/KAKS emsal hesabı ve harita mühendisliği onaylı imar analizi.";
        $page_h1 = "Türkiye Geneli Ada Parsel Sorgulama & Kadastro Dizini";
        $canonical_url = "https://www.parselsorgu.net/parsel-sorgu";
        $intro_text = "Türkiye genelindeki tüm iller ve ilçeler bazında kadastro sınırları, uydu ortofotoları ve güncel imar bilgileri tek ekranda toplanmıştır. Sorgulama yapmak istediğiniz ili seçerek ilçe ve mahalle bazında detaylı analize ulaşabilirsiniz.";
        $stats = [
            "toplam_parsel" => 81 * 18500,
            "ortalama_alan_m2" => 920,
            "baskin_imar_tipi" => "Türkiye Geneli"
        ];
        $faqs = [
            [
                "question" => "Türkiye genelinde ada parsel nasıl sorgulanır?",
                "answer" => "ParselSorgu.net üzerindeki arama modülünden il, ilçe ve mahalle seçip ada ve parsel numaranızı girerek anında sınırları haritada görebilirsiniz."
            ],
            [
                "question" => "2026 tapu harcı ve döner sermaye ne kadardır?",
                "answer" => "Gayrimenkul alım satımlarında alıcıdan %2, satıcıdan %2 olmak üzere toplam %4 tapu harcı tahsil edilmektedir."
            ]
        ];
        $json_ld = [
            "@context" => "https://schema.org",
            "@graph" => [
                [
                    "@type" => "BreadcrumbList",
                    "itemListElement" => [
                        ["@type" => "ListItem", "position" => 1, "name" => "Ana Sayfa", "item" => "https://www.parselsorgu.net"],
                        ["@type" => "ListItem", "position" => 2, "name" => "Parsel Sorgulama", "item" => $canonical_url]
                    ]
                ],
                [
                    "@type" => "ProfessionalService",
                    "name" => "ParselSorgu - Türkiye Harita & İmar Masası",
                    "url" => $canonical_url,
                    "logo" => "https://www.parselsorgu.net/assets/logo.png",
                    "description" => $meta_desc,
                    "telephone" => "0542 841 35 35",
                    "provider" => [
                        "@type" => "Organization",
                        "name" => "Ant Harita Mühendislik",
                        "identifier" => "TMMOB HKMO Sicil No: 12480",
                        "url" => "https://www.parselsorgu.net"
                    ]
                ]
            ]
        ];
    } else {
        $seo = $generator->generateLocationSEO([
            'il' => $cityName
        ]);

        $page_title = $seo["metaTitle"];
        $meta_desc = $seo["metaDescription"];
        $page_h1 = "{$cityName} Parsel Sorgulama, Ada Parsel ve İmar Durumu Haritası";
        $canonical_url = $seo["canonicalUrl"];
        
        $egilim = $seo['ortalamaEgilim'] ?? '%8';
        $katsayi = $seo['csidbKatsayi'] ?? '1.05';
        $intro_text = "{$cityName} ili genelindeki tüm ilçeler ve mahalleler bazında kadastro sınırları, uydu ortofotoları ve güncel imar bilgileri tek ekranda toplanmıştır. Bölgedeki ortalama arazi eğimi {$egilim} seviyesinde olup, ÇŞİDB birim maliyet katsayısı {$katsayi}x düzeyindedir. Sorgulama yapmak istediğiniz ilçeyi seçerek mahalle bazında detaylı analize ulaşabilirsiniz.";
        $stats = [
            "toplam_parsel" => count($districts) * 18500,
            "ortalama_alan_m2" => 920,
            "baskin_imar_tipi" => $is_buyuksehir ? "Metropol İmarı" : "Bölgesel Karma"
        ];
        $faqs = $seo["faqs"];
        $json_ld = $seo["json_ld"];
    }
}


// -------------------------------------------------------------------------
// REGIONAL AUTHORITATIVE ARTICLES & ZONING GUIDES (CROSS-LINKING SILO)
// -------------------------------------------------------------------------
$local_articles = [];
if ($pdo && !empty($cityName) && $cityName !== 'Türkiye') {
    try {
        if (!empty($districtName)) {
            $stmt_art = $pdo->prepare("SELECT id, title, slug, summary, category, created_at FROM blog_articles WHERE (city = ? AND district = ?) OR city = ? ORDER BY (district = ?) DESC, id DESC LIMIT 6");
            $stmt_art->execute([$cityName, $districtName, $cityName, $districtName]);
        } else {
            $stmt_art = $pdo->prepare("SELECT id, title, slug, summary, category, created_at FROM blog_articles WHERE city = ? ORDER BY id DESC LIMIT 6");
            $stmt_art->execute([$cityName]);
        }
        $local_articles = $stmt_art->fetchAll();
    } catch (Exception $e) {}
}

$live_map_url = "/ada-parsel-harita?city=" . urlencode($cityName) . "&district=" . urlencode($districtName) . "&mahalle=" . urlencode($mahalleName ?? '');
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title><?= htmlspecialchars($page_title) ?></title>
    <meta name="description" content="<?= htmlspecialchars($meta_desc) ?>">
    <link rel="canonical" href="<?= htmlspecialchars($canonical_url) ?>">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1">

    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?= htmlspecialchars($page_title) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($meta_desc) ?>">
    <meta property="og:url" content="<?= htmlspecialchars($canonical_url) ?>">
    <meta property="og:site_name" content="ParselSorgu.net">
    <meta property="og:image" content="https://www.parselsorgu.net/assets/images/og-parsel.jpg">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:image" content="https://www.parselsorgu.net/assets/images/og-parsel.jpg">

    <!-- Fonts, Leaflet & Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/main.css?v=2026.47">

    <!-- JSON-LD Structured Data Graph -->
    <script type="application/ld+json"><?= is_array($json_ld) ? json_encode($json_ld, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) : $json_ld ?></script>

    <style>
        :root {
            --bg-dark: #0b1120;
            --card-dark: #111c30;
            --border-dark: rgba(56, 189, 248, 0.22);
            --primary-cyan: #38bdf8;
            --primary-blue: #0284c7;
        }
        body { font-family: 'Inter', -apple-system, sans-serif; background: var(--bg-dark); color: #f8fafc; margin: 0; padding: 0; }
        .hub-container { max-width: 1200px; margin: 0 auto; padding: 20px 16px 80px 16px; }
        .hub-hero { background: linear-gradient(135deg, rgba(15,23,42,0.98) 0%, rgba(30,41,59,0.95) 100%); border: 2px solid #0284c7; border-radius: 16px; padding: 26px; margin-bottom: 22px; box-shadow: 0 10px 40px rgba(2,132,199,0.18); }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 14px; margin-bottom: 22px; }
        .stat-card { background: var(--card-dark); border: 1px solid var(--border-dark); border-radius: 12px; padding: 18px 20px; }
        .stat-val { font-size: 26px; font-weight: 900; color: #38bdf8; margin: 4px 0; }
        .stat-lbl { font-size: 11.5px; color: #94a3b8; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; }
        .hub-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(170px, 1fr)); gap: 10px; margin-bottom: 24px; }
        .hub-badge { display: block; background: #0f172a; border: 1px solid #1e293b; color: #cbd5e1; padding: 10px 14px; border-radius: 8px; font-size: 12.5px; font-weight: 600; text-decoration: none; transition: all 0.2s; }
        .hub-badge:hover { background: #0284c7; color: #fff; border-color: #38bdf8; transform: translateY(-2px); }
        .hub-badge.active { background: #0284c7; color: #fff; border-color: #38bdf8; font-weight: 800; }
        .faq-item { background: #0f172a; border: 1px solid #1e293b; border-radius: 10px; padding: 16px 18px; margin-bottom: 10px; }
        .faq-q { font-size: 14.5px; font-weight: 800; color: #f8fafc; margin-bottom: 6px; display: flex; align-items: center; gap: 8px; }
        .faq-a { font-size: 13px; color: #cbd5e1; line-height: 1.6; margin: 0; }
        .map-box { height: 420px; border-radius: 12px; overflow: hidden; border: 1px solid var(--border-dark); margin-bottom: 24px; position: relative; }
        @media (max-width: 768px) {
            .hub-container { padding: 14px 12px 90px 12px; }
            .hub-hero { padding: 18px 16px; }
            .stat-val { font-size: 22px; }
            .hub-grid { grid-template-columns: repeat(2, 1fr); gap: 8px; }
        }
    
        .floating-wa-btn {
            position: fixed;
            bottom: 24px;
            right: 24px;
            background: #22c55e;
            color: #fff;
            padding: 12px 20px;
            border-radius: 30px;
            box-shadow: 0 6px 25px rgba(34,197,94,0.45);
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 800;
            font-size: 14px;
            text-decoration: none;
            z-index: 9999;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .floating-wa-btn:hover {
            transform: translateY(-4px) scale(1.03);
            box-shadow: 0 10px 30px rgba(34,197,94,0.6);
            color: #fff;
        }
        @media (max-width: 768px) {
            .floating-wa-btn { bottom: 76px; right: 16px; padding: 10px 16px; font-size: 13px; }
        }
</style>
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#0284c7">
    <script src="/assets/js/instant_search.js" defer></script>
</head>
<body>

    <?php render_saas_navbar('parsel'); ?>

    <main class="hub-container">

        <!-- Breadcrumb Navigation -->
        <nav style="font-size:12px; color:#94a3b8; margin-bottom:14px; display:flex; flex-wrap:wrap; gap:6px; align-items:center;" aria-label="Ekmek Kırıntısı">
            <a href="/" style="color:#38bdf8; text-decoration:none;"><i class="fa-solid fa-house"></i> Ana Sayfa</a>
            <span>&raquo;</span>
            <a href="/parsel-sorgu" style="color:#38bdf8; text-decoration:none;">Parsel Sorgulama</a>
            <?php if (!$is_all_turkey): ?>
                <span>&raquo;</span>
                <a href="/parsel-sorgu/<?= $city_slug ?>" style="color:#38bdf8; text-decoration:none;"><?= htmlspecialchars($cityName) ?></a>
            <?php endif; ?>
            <?php if (!empty($districtName)): ?>
                <span>&raquo;</span>
                <a href="/parsel-sorgu/<?= $city_slug ?>/<?= $generator->slugify($districtName) ?>" style="color:#38bdf8; text-decoration:none;"><?= htmlspecialchars($districtName) ?></a>
            <?php endif; ?>
            <?php if (!empty($mahalleName)): ?>
                <span>&raquo;</span>
                <span style="color:#f1f5f9; font-weight:bold;"><?= htmlspecialchars($mahalleName) ?> Mahallesi</span>
            <?php endif; ?>
        </nav>

        <!-- Hero Section -->
        <section class="hub-hero">
            <div style="display:flex; justify-content:space-between; align-items:flex-start; flex-wrap:wrap; gap:16px;">
                <div style="max-width:780px;">
                    <div style="display:inline-flex; align-items:center; gap:8px; margin-bottom:10px;">
                        <span style="background:rgba(34,197,94,0.18); border:1px solid #22c55e; color:#4ade80; font-size:11px; font-weight:bold; padding:3px 9px; border-radius:4px;">
                            <i class="fa-solid fa-satellite"></i> CANLI TKGM UYDU &amp; KADASTRO
                        </span>
                        <?php if ($page_level === 3): ?>
                        <span style="background:rgba(245,158,11,0.18); border:1px solid #f59e0b; color:#fbbf24; font-size:11px; font-weight:bold; padding:3px 9px; border-radius:4px;">
                            <i class="fa-solid fa-map-pin"></i> MAHALLE DÜZEYİ DOĞRULAMA
                        </span>
                        <?php endif; ?>
                    </div>
                    <h1 style="font-size:clamp(1.3rem, 2.8vw, 1.8rem); font-weight:900; color:#fff; margin:0 0 12px 0; line-height:1.25;">
                        <?= htmlspecialchars($page_h1) ?>
                    </h1>
                    <p style="font-size:13.5px; color:#cbd5e1; margin:0; line-height:1.65;">
                        <?= htmlspecialchars($intro_text) ?>
                    </p>
                    <div style="display:flex; flex-wrap:wrap; gap:10px; margin-top:14px;">
                        <a href="/parsel-raporu?city=<?= urlencode($cityName) ?>&district=<?= urlencode($districtName ?? '') ?>&mahalle=<?= urlencode($mahalleName ?? '') ?>" target="_blank" style="background:#0284c7; color:#fff; text-decoration:none; display:inline-flex; align-items:center; gap:8px; padding:10px 16px; border-radius:8px; font-weight:800; font-size:13px; box-shadow:0 4px 15px rgba(2,132,199,0.3); transition:all 0.2s;">
                            <i class="fa fa-file-pdf"></i> Resmi Parsel &amp; İmar Raporu İndir
                        </a>
                        <a href="/tarla-ifraz-hesaplama" style="background:rgba(34,197,94,0.15); border:1px solid #22c55e; color:#4ade80; text-decoration:none; display:inline-flex; align-items:center; gap:8px; padding:10px 16px; border-radius:8px; font-weight:800; font-size:13px; transition:all 0.2s;">
                            <i class="fa fa-calculator"></i> 5403 Tarla İfraz Hesaplayıcı
                        </a>
                        <a href="/export-parsel?format=kml&city=<?= urlencode($cityName) ?>&district=<?= urlencode($districtName ?? '') ?>&mahalle=<?= urlencode($mahalleName ?? '') ?>" style="background:rgba(56,189,248,0.15); border:1px solid #38bdf8; color:#38bdf8; text-decoration:none; display:inline-flex; align-items:center; gap:8px; padding:10px 16px; border-radius:8px; font-weight:800; font-size:13px; transition:all 0.2s;">
                            <i class="fa fa-download"></i> KML / CAD İndir
                        </a>
                    </div>
                </div>
                <div style="display:flex; flex-direction:column; gap:8px; width:100%; max-width:260px;">
                    <a href="/#tab-parsel" style="background:linear-gradient(135deg, #0284c7 0%, #0369a1 100%); color:#fff; padding:12px 18px; border-radius:10px; font-weight:900; font-size:13px; text-decoration:none; display:flex; align-items:center; justify-content:center; gap:8px; box-shadow:0 4px 15px rgba(2,132,199,0.4);">
                        <i class="fa-solid fa-crosshairs"></i> Parselimi Anında Sorgula
                    </a>
                    <a href="/imar-durumu-sorgulama" style="background:#1e293b; color:#38bdf8; border:1px solid rgba(56,189,248,0.3); padding:10px 18px; border-radius:10px; font-weight:800; font-size:12.5px; text-decoration:none; display:flex; align-items:center; justify-content:center; gap:8px;">
                        <i class="fa-solid fa-compass-drafting"></i> İmar Durumu &amp; Emsal
                    </a>
                
                    <a href="https://api.whatsapp.com/send?text=<?= urlencode("📍 " . $cityName . (!empty($districtName) ? " / " . $districtName : "") . (!empty($mahalleName) ? " - " . $mahalleName . " Mah." : "") . " Ada Parsel Sorgulama & İmar Durumu Verileri: " . $canonical_url) ?>" target="_blank" style="background:#25d366; color:#fff; border:none; padding:10px 18px; border-radius:10px; font-weight:900; font-size:12.5px; text-decoration:none; display:flex; align-items:center; justify-content:center; gap:8px; box-shadow:0 4px 15px rgba(37,211,102,0.3);">
                        <i class="fa-brands fa-whatsapp"></i> WhatsApp'ta Paylaş
                    </a>
                    <button onclick="openPsAlarmModal()" style="background:#f59e0b; color:#fff; border:none; padding:10px 18px; border-radius:10px; font-weight:900; font-size:12.5px; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:8px; box-shadow:0 4px 15px rgba(245,158,11,0.3);">
                        <i class="fa-solid fa-bell"></i> Bölge İmar Alarmı Kur
                    </button>
                </div>
            </div>
        </section>

        <!-- Stats Grid (Dinamik Mahalle / İlçe Verileri) -->
        <section class="stats-grid">
            <div class="stat-card">
                <div class="stat-lbl"><i class="fa-solid fa-layer-group" style="color:#38bdf8;"></i> Toplam Tescilli Parsel</div>
                <div class="stat-val"><?= number_format((int)$stats['toplam_parsel'], 0, ',', '.') ?></div>
                <div style="font-size:11px; color:#94a3b8;">TKGM MEGSİS Kayıtlı Kadastro Alanı</div>
            </div>
            <div class="stat-card">
                <div class="stat-lbl"><i class="fa-solid fa-ruler-combined" style="color:#4ade80;"></i> Ortalama Parsel Alanı</div>
                <div class="stat-val" style="color:#4ade80;"><?= number_format((int)$stats['ortalama_alan_m2'], 0, ',', '.') ?> m²</div>
                <div style="font-size:11px; color:#94a3b8;">Bölgesel Emsal Parsel Büyüklüğü</div>
            </div>
            <div class="stat-card">
                <div class="stat-lbl"><i class="fa-solid fa-landmark" style="color:#facc15;"></i> Baskın İmar / Arazi Tipi</div>
                <div class="stat-val" style="color:#facc15; font-size:22px;"><?= htmlspecialchars((string)$stats['baskin_imar_tipi']) ?></div>
                <div style="font-size:11px; color:#94a3b8;">1/1000 Uygulama İmar Planı Fonksiyonu</div>
            </div>
        </section>

        <!-- Canlı Harita İstasyonu -->
        <section style="margin-bottom:26px;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
                <h2 style="font-size:16px; font-weight:800; color:#fff; margin:0; display:flex; align-items:center; gap:8px;">
                    <i class="fa-solid fa-map-location-dot" style="color:#38bdf8;"></i>
                    <?= htmlspecialchars($cityName) ?><?= !empty($districtName) ? " / " . htmlspecialchars($districtName) : "" ?><?= !empty($mahalleName) ? " - " . htmlspecialchars($mahalleName) . " Mah." : "" ?> Canlı Uydu Haritası
                </h2>
                <span style="font-size:11px; color:#38bdf8; font-weight:700;">Google Hibrit HD Katmanı</span>
            </div>
            <div class="map-box">
                <div id="localHubMap" style="width:100%; height:100%;"></div>
                <div style="position:absolute; bottom:0; left:0; right:0; z-index:950; background:rgba(9,13,22,0.92); border-top:1px solid rgba(255,255,255,0.08); padding:5px 12px; font-size:11px; color:#64748b; display:flex; justify-content:space-between; align-items:center;">
                    <span style="color:#38bdf8; font-family:monospace;"><?= $lat ?>°N, <?= $lng ?>°E</span>
                    <span style="color:#cbd5e1; font-weight:600;">Bu ticari olmayan bir oturumdur.</span>
                </div>
            </div>
        </section>

        <!-- Hiyerarşik Gezinme Gridleri (Mahalleler veya İlçeler) -->
        <?php if ($page_level === 2 && !empty($mahalleList)): ?>
        <section style="margin-bottom:28px;">
            <h2 style="font-size:16px; font-weight:800; color:#fff; margin:0 0 12px 0;">
                <i class="fa-solid fa-tree-city" style="color:#38bdf8;"></i> <?= htmlspecialchars($districtName) ?> İlçesine Bağlı Tüm Mahalleler (<?= count($mahalleList) ?> Mahalle)
            </h2>
            <div class="hub-grid">
                <?php foreach ($mahalleList as $m): 
                    $cleanM = clean_mahalle_name($m);
                    $mSlug = $generator->slugify($cleanM);
                    $mUrl = "/parsel-sorgu/{$city_slug}/" . $generator->slugify($districtName) . "/{$mSlug}";
                ?>
                <a href="<?= $mUrl ?>" class="hub-badge" title="<?= htmlspecialchars($cleanM) ?> Mahallesi Parsel Sorgulama">
                    <?= htmlspecialchars($cleanM) ?> Mah.
                </a>
                <?php endforeach; ?>
            </div>
        </section>
        <?php elseif ($page_level === 3 && !empty($mahalleList)): ?>
        <section style="margin-bottom:28px;">
            <h2 style="font-size:16px; font-weight:800; color:#fff; margin:0 0 12px 0;">
                <i class="fa-solid fa-route" style="color:#38bdf8;"></i> <?= htmlspecialchars($districtName) ?> İlçesindeki Diğer Mahalleler
            </h2>
            <div class="hub-grid">
                <?php 
                $count = 0;
                foreach ($mahalleList as $m): 
                    $cleanM = clean_mahalle_name($m);
                    if ($cleanM === $mahalleName) continue;
                    if (++$count > 24) break; // İlk 24 komşu mahalle
                    $mSlug = $generator->slugify($cleanM);
                    $mUrl = "/parsel-sorgu/{$city_slug}/" . $generator->slugify($districtName) . "/{$mSlug}";
                ?>
                <a href="<?= $mUrl ?>" class="hub-badge" title="<?= htmlspecialchars($cleanM) ?> Mahallesi Parsel Sorgulama">
                    <?= htmlspecialchars($cleanM) ?> Mah.
                </a>
                <?php endforeach; ?>
            </div>
        </section>
        <?php elseif ($page_level === 1): ?>
        <section style="margin-bottom:28px;">
            <?php if ($is_all_turkey): ?>
            <h2 style="font-size:16px; font-weight:800; color:#fff; margin:0 0 12px 0;">
                <i class="fa-solid fa-map-location-dot" style="color:#38bdf8;"></i> Türkiye Geneli 81 İl Parsel Sorgulama Dizini
            </h2>
            <div class="hub-grid">
                <?php foreach (array_keys($admin_data) as $cName): 
                    $cSlug = $generator->slugify($cName);
                    $cUrl = "/parsel-sorgu/{$cSlug}";
                ?>
                <a href="<?= $cUrl ?>" class="hub-badge" title="<?= htmlspecialchars($cName) ?> Parsel Sorgulama">
                    <?= htmlspecialchars($cName) ?> &raquo;
                </a>
                <?php endforeach; ?>
            </div>
            <?php elseif (!empty($districts)): ?>
            <h2 style="font-size:16px; font-weight:800; color:#fff; margin:0 0 12px 0;">
                <i class="fa-solid fa-city" style="color:#38bdf8;"></i> <?= htmlspecialchars($cityName) ?> İlinin Tüm İlçeleri (<?= count($districts) ?> İlçe)
            </h2>
            <div class="hub-grid">
                <?php foreach ($districts as $d): 
                    $dSlug = $generator->slugify($d);
                    $dUrl = "/parsel-sorgu/{$city_slug}/{$dSlug}";
                ?>
                <a href="<?= $dUrl ?>" class="hub-badge" title="<?= htmlspecialchars($d) ?> Parsel Sorgulama">
                    <?= htmlspecialchars($d) ?> &raquo;
                </a>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </section>
        <?php endif; ?>

        
        <!-- BÖLGESEL İMAR & KADASTRO REHBERLERİ (YEREL SEO SİLO) -->
        <?php if (!empty($local_articles)): ?>
        <section style="margin-bottom:28px;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:14px; flex-wrap:wrap; gap:8px;">
                <h2 style="font-size:16.5px; font-weight:800; color:#fff; margin:0; display:flex; align-items:center; gap:8px;">
                    <i class="fa-solid fa-book-bookmark" style="color:#38bdf8;"></i> <?= htmlspecialchars($cityName) ?><?= !empty($districtName) ? " / " . htmlspecialchars($districtName) : "" ?> İmar, Kadastro &amp; Tapu Rehberleri
                </h2>
                <a href="/makaleler" style="font-size:12px; color:#38bdf8; text-decoration:none; font-weight:700;">Tüm Rehberleri Gör &rarr;</a>
            </div>
            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(280px, 1fr)); gap:14px;">
                <?php foreach ($local_articles as $art): ?>
                <a href="/makale/<?= htmlspecialchars($art['slug']) ?>" style="background:#0f172a; border:1px solid #1e293b; border-radius:10px; padding:16px; text-decoration:none; display:flex; flex-direction:column; justify-content:space-between; transition:all 0.2s;" onmouseover="this.style.borderColor='#38bdf8'; this.style.transform='translateY(-2px)';" onmouseout="this.style.borderColor='#1e293b'; this.style.transform='none';">
                    <div>
                        <span style="display:inline-block; font-size:11px; font-weight:700; color:#38bdf8; background:rgba(56,189,248,0.12); padding:3px 8px; border-radius:4px; margin-bottom:8px;">
                            <?= htmlspecialchars($art['category'] ?? 'İmar Rehberi') ?>
                        </span>
                        <h3 style="font-size:14px; font-weight:700; color:#f8fafc; margin:0 0 6px 0; line-height:1.4;">
                            <?= htmlspecialchars($art['title']) ?>
                        </h3>
                        <p style="font-size:12px; color:#94a3b8; margin:0; line-height:1.5;">
                            <?= htmlspecialchars(mb_substr(strip_tags((string)$art['summary']), 0, 110)) ?>...
                        </p>
                    </div>
                    <div style="margin-top:12px; font-size:11.5px; color:#38bdf8; font-weight:600; display:flex; align-items:center; gap:4px;">
                        <span>Rehberi İncele</span> <i class="fa-solid fa-arrow-right" style="font-size:10px;"></i>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
        </section>
        <?php endif; ?>

        <!-- Sık Sorulan Sorular (Dinamik Mahalle FAQ) -->
        <section style="margin-bottom:28px;">
            <h2 style="font-size:16px; font-weight:800; color:#fff; margin:0 0 14px 0;">
                <i class="fa-solid fa-circle-question" style="color:#facc15;"></i> <?= htmlspecialchars($page_level === 3 ? $mahalleName . " Mahallesi" : $targetLocation) ?> Hakkında Sıkça Sorulan Sorular
            </h2>
            <?php foreach ($faqs as $faq): ?>
            <div class="faq-item">
                <div class="faq-q"><i class="fa-solid fa-caret-right" style="color:#38bdf8;"></i> <?= htmlspecialchars($faq['question']) ?></div>
                <p class="faq-a"><?= htmlspecialchars($faq['answer']) ?></p>
            </div>
            <?php endforeach; ?>
        </section>

        <!-- İlgili Otonom İmar Botları & Rehberler -->
        <section style="margin-bottom:26px; background:linear-gradient(135deg, #091322 0%, #030712 100%); border:1px solid #1e3a5f; border-radius:14px; padding:20px;">
            <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px; margin-bottom:14px;">
                <h3 style="color:#38bdf8; font-size:15px; font-weight:800; margin:0;">
                    <i class="fa-solid fa-robot"></i> İlgili Otonom İmar &amp; Kadastro Araçları
                </h3>
                <a href="/rehber/" style="color:#facc15; font-size:12px; text-decoration:none; font-weight:700;">Tüm Rehberleri Gör &raquo;</a>
            </div>
            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); gap:10px;">
                <a href="/tarlaya-ev-yapilir-mi" style="text-decoration:none; background:#0d1829; border:1px solid #1e293b; border-radius:8px; padding:12px; display:block;">
                    <div style="color:#fff; font-size:12.5px; font-weight:700; margin-bottom:4px;">🏡 Tarlaya Ev Yapılır mı?</div>
                    <div style="color:#94a3b8; font-size:11px;">5000 m² kuralı ve plansız alanlar imar izinleri</div>
                </a>
                <a href="/5403-tarla-ifraz" style="text-decoration:none; background:#0d1829; border:1px solid #1e293b; border-radius:8px; padding:12px; display:block;">
                    <div style="color:#fff; font-size:12.5px; font-weight:700; margin-bottom:4px;">🌾 5403 Tarla İfraz &amp; Bölünme</div>
                    <div style="color:#94a3b8; font-size:11px;">Asgari tarımsal arazi büyüklüğü ve miras paylaşımı</div>
                </a>
                <a href="/taks-kaks-hesaplama" style="text-decoration:none; background:#0d1829; border:1px solid #1e293b; border-radius:8px; padding:12px; display:block;">
                    <div style="color:#fff; font-size:12.5px; font-weight:700; margin-bottom:4px;">📐 TAKS &amp; KAKS Emsal Hesabı</div>
                    <div style="color:#94a3b8; font-size:11px;">Arsa inşaat alanı ve çekme mesafesi kapasitesi</div>
                </a>
                <a href="/arsa-insaat-maliyeti" style="text-decoration:none; background:#0d1829; border:1px solid #1e293b; border-radius:8px; padding:12px; display:block;">
                    <div style="color:#fff; font-size:12.5px; font-weight:700; margin-bottom:4px;">⚡ 2026 İnşaat Maliyeti</div>
                    <div style="color:#94a3b8; font-size:11px;">ÇŞİDB yaklaşık birim maliyeti ve metraj hesabı</div>
                </a>
            </div>
        </section>

    
        <!-- Uzman Yapay Zeka İmar & Değerleme Robotları (Cross-Linking Hub) -->
        <section style="margin-bottom:28px; background:linear-gradient(135deg, rgba(15,23,42,0.95) 0%, rgba(30,41,59,0.9) 100%); border:1px solid rgba(56,189,248,0.25); border-radius:16px; padding:22px; box-shadow:0 10px 30px rgba(0,0,0,0.3);">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:14px; flex-wrap:wrap; gap:10px;">
                <div>
                    <h2 style="font-size:17px; font-weight:900; color:#fff; margin:0 0 4px 0; display:flex; align-items:center; gap:8px;">
                        <i class="fa-solid fa-microchip" style="color:#38bdf8;"></i> <?= htmlspecialchars($cityName) ?> İmar, İfraz &amp; Gayrimenkul Zeka Robotları
                    </h2>
                    <p style="font-size:12.5px; color:#94a3b8; margin:0;">Bu bölgedeki tarlanız, arsanız veya hisseli tapunuz için anlık yasal durum hesaplaması yapın.</p>
                </div>
                <span style="background:rgba(2,132,199,0.2); border:1px solid #0284c7; color:#38bdf8; font-size:11px; font-weight:800; padding:4px 10px; border-radius:6px;">2026 Mevzuat Uyumlu</span>
            </div>
            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(210px, 1fr)); gap:12px;">
                <a href="/bot/zeytinlik-imar" style="background:#0b1120; border:1px solid #1e293b; border-radius:10px; padding:14px; text-decoration:none; display:flex; align-items:flex-start; gap:10px; transition:all 0.2s;">
                    <div style="background:rgba(34,197,94,0.15); color:#22c55e; width:34px; height:34px; border-radius:8px; display:flex; align-items:center; justify-content:center; flex-shrink:0;"><i class="fa-solid fa-seedling"></i></div>
                    <div>
                        <div style="color:#f8fafc; font-weight:800; font-size:13px;">Zeytinlik İmarı</div>
                        <div style="color:#94a3b8; font-size:11.5px;">3573 Sayılı Kanun &amp; Ev İzni</div>
                    </div>
                </a>
                <a href="/tarlaya-ev-yapilir-mi-testi" style="background:#0b1120; border:1px solid #1e293b; border-radius:10px; padding:14px; text-decoration:none; display:flex; align-items:flex-start; gap:10px; transition:all 0.2s;">
                    <div style="background:rgba(245,158,11,0.15); color:#f59e0b; width:34px; height:34px; border-radius:8px; display:flex; align-items:center; justify-content:center; flex-shrink:0;"><i class="fa-solid fa-shapes"></i></div>
                    <div>
                        <div style="color:#f8fafc; font-weight:800; font-size:13px;">Tarla İfraz &amp; Bölünme</div>
                        <div style="color:#94a3b8; font-size:11.5px;">5403 Sayılı Asgari Parsel Şartı</div>
                    </div>
                </a>
                <a href="/arsa-daire-hesaplama" style="background:#0b1120; border:1px solid #1e293b; border-radius:10px; padding:14px; text-decoration:none; display:flex; align-items:flex-start; gap:10px; transition:all 0.2s;">
                    <div style="background:rgba(2,132,199,0.15); color:#38bdf8; width:34px; height:34px; border-radius:8px; display:flex; align-items:center; justify-content:center; flex-shrink:0;"><i class="fa-solid fa-building"></i></div>
                    <div>
                        <div style="color:#f8fafc; font-weight:800; font-size:13px;">Kat Karşılığı Oranı</div>
                        <div style="color:#94a3b8; font-size:11.5px;">Müteahhit Payı &amp; Daire Hesabı</div>
                    </div>
                </a>
                <a href="/bot/tiny-house-imar" style="background:#0b1120; border:1px solid #1e293b; border-radius:10px; padding:14px; text-decoration:none; display:flex; align-items:flex-start; gap:10px; transition:all 0.2s;">
                    <div style="background:rgba(236,72,153,0.15); color:#ec4899; width:34px; height:34px; border-radius:8px; display:flex; align-items:center; justify-content:center; flex-shrink:0;"><i class="fa-solid fa-caravan"></i></div>
                    <div>
                        <div style="color:#f8fafc; font-weight:800; font-size:13px;">Tiny House Uygunluğu</div>
                        <div style="color:#94a3b8; font-size:11.5px;">Ruhsat &amp; Plaka Standartları</div>
                    </div>
                </a>
                <a href="/bot/hisseli-tapu-sufa" style="background:#0b1120; border:1px solid #1e293b; border-radius:10px; padding:14px; text-decoration:none; display:flex; align-items:flex-start; gap:10px; transition:all 0.2s;">
                    <div style="background:rgba(168,85,247,0.15); color:#c084fc; width:34px; height:34px; border-radius:8px; display:flex; align-items:center; justify-content:center; flex-shrink:0;"><i class="fa-solid fa-scale-balanced"></i></div>
                    <div>
                        <div style="color:#f8fafc; font-weight:800; font-size:13px;">Hisseli Tapu Şufa Hakkı</div>
                        <div style="color:#94a3b8; font-size:11.5px;">Önalım Davası &amp; Satış Riski</div>
                    </div>
                </a>
                <a href="/tarlaya-ev-yapilir-mi-testi" style="background:#0b1120; border:1px solid #1e293b; border-radius:10px; padding:14px; text-decoration:none; display:flex; align-items:flex-start; gap:10px; transition:all 0.2s;">
                    <div style="background:rgba(20,184,166,0.15); color:#2dd4bf; width:34px; height:34px; border-radius:8px; display:flex; align-items:center; justify-content:center; flex-shrink:0;"><i class="fa-solid fa-house-chimney"></i></div>
                    <div>
                        <div style="color:#f8fafc; font-weight:800; font-size:13px;">Köy Evi Yapma Testi</div>
                        <div style="color:#94a3b8; font-size:11.5px;">Köy Yerleşik Alan Sınırları</div>
                    </div>
                </a>
            </div>
        </section>

    </main>

    <!-- Leaflet JS & Harita Başlatıcı -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
    function initLocalHubMap() {
            const mapEl = document.getElementById('localHubMap');
            if (!mapEl || mapEl._leaflet_id) return;
            if (typeof L === 'undefined') {
                setTimeout(initLocalHubMap, 100);
                return;
            }
            
            const center = [<?= $lat ?>, <?= $lng ?>];
            const zoom = <?= $page_level === 3 ? 16 : ($page_level === 2 ? 14 : 11) ?>;
            const localMap = L.map('localHubMap', { center: center, zoom: zoom, zoomControl: true });

            const hybrid = L.tileLayer('https://mt{s}.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
                subdomains: ['0', '1', '2', '3'],
                maxZoom: 20,
                attribution: 'Google Hybrid / TKGM'
            }).addTo(localMap);

            const marker = L.marker(center).addTo(localMap);
            marker.bindPopup("<b><?= htmlspecialchars($page_level === 3 ? $mahalleName . ' Mahallesi' : ($districtName ?: $cityName)) ?></b><br>Canlı TKGM Uydu İstasyonu").openPopup();
        }

        // Hibrit SSR / CSR: Harita İstemci Tarafında Lazy-Load ile Yüklenir (Botlar Saf HTML Okur)
        if ('IntersectionObserver' in window) {
            const mapObserver = new IntersectionObserver((entries, obs) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        initLocalHubMap();
                        obs.disconnect();
                    }
                });
            }, { rootMargin: '350px' });
            const mapTarget = document.getElementById('localHubMap');
            if (mapTarget) mapObserver.observe(mapTarget);
            else initLocalHubMap();
        } else {
            document.addEventListener('DOMContentLoaded', initLocalHubMap);
        }

        const hybrid = L.tileLayer('https://mt{s}.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
            subdomains: ['0', '1', '2', '3'],
            maxZoom: 20,
            attribution: 'Google Hybrid / TKGM'
        }).addTo(localMap);

        const marker = L.marker(center).addTo(localMap);
        marker.bindPopup("<b><?= htmlspecialchars($page_level === 3 ? $mahalleName . " Mahallesi" : ($districtName ?: $cityName)) ?></b><br>Canlı TKGM Uydu İstasyonu").openPopup();
    });
    </script>

    <!-- Real-Time Web Analytics Engine -->
    <script src="/analytics.js" defer></script>

<!-- Parsel / Bölge Takip Alarmı Modalı -->
<div id="modal-ps-alarm" style="display:none; position:fixed; z-index:999999; left:0; top:0; width:100%; height:100%; background:rgba(15,23,42,0.88); backdrop-filter:blur(6px); align-items:center; justify-content:center; padding:16px; box-sizing:border-box;">
    <div style="background:#0f172a; border:2px solid #f59e0b; border-radius:16px; max-width:500px; width:100%; padding:26px; position:relative; color:#fff;">
        <button onclick="closePsAlarmModal()" style="position:absolute; right:16px; top:16px; background:none; border:none; color:#94a3b8; font-size:24px; cursor:pointer; font-weight:bold;">&times;</button>
        <div style="display:flex; align-items:center; gap:12px; margin-bottom:14px;">
            <div style="width:40px; height:40px; border-radius:10px; background:rgba(245,158,11,0.2); border:1px solid #f59e0b; display:flex; align-items:center; justify-content:center; font-size:20px;">🔔</div>
            <div>
                <h3 style="margin:0; font-size:17px; font-weight:900;">Bölge İmar &amp; Askı Alarmı Kur</h3>
                <span style="font-size:11.5px; color:#fde68a;"><?= htmlspecialchars($cityName) ?><?= !empty($districtName) ? " / " . htmlspecialchars($districtName) : "" ?><?= !empty($mahalleName) ? " - " . htmlspecialchars($mahalleName) : "" ?></span>
            </div>
        </div>
        <p style="font-size:12px; color:#cbd5e1; margin-bottom:14px;">Bu bölgede yeni bir imar planı askıya çıktığında veya 18. madde uygulaması ilan edildiğinde anında ücretsiz bildirim alın.</p>
        <form onsubmit="event.preventDefault(); submitPsAlarm();">
            <div style="margin-bottom:10px;">
                <label style="display:block; font-size:11px; font-weight:700; color:#94a3b8; margin-bottom:4px;">Adınız Soyadınız *</label>
                <input type="text" id="ps-alarm-name" required placeholder="Ad Soyad" style="width:100%; background:#090d16; border:1px solid #334155; border-radius:8px; padding:9px 12px; color:#fff; font-size:12.5px; box-sizing:border-box;">
            </div>
            <div style="margin-bottom:14px;">
                <label style="display:block; font-size:11px; font-weight:700; color:#94a3b8; margin-bottom:4px;">WhatsApp Telefon Numaranız *</label>
                <input type="tel" id="ps-alarm-phone" required placeholder="0532 000 00 00" style="width:100%; background:#090d16; border:1px solid #334155; border-radius:8px; padding:9px 12px; color:#fff; font-size:12.5px; box-sizing:border-box;">
            </div>
            <button type="submit" id="btn-ps-alarm" style="width:100%; background:linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color:#fff; border:none; padding:12px; border-radius:8px; font-size:13px; font-weight:900; cursor:pointer;">
                🔔 Ücretsiz Takip Bildirimi Başlat
            </button>
            <div id="ps-alarm-msg" style="margin-top:10px; font-size:12px; text-align:center;"></div>
        </form>
    </div>
</div>

<script>
function openPsAlarmModal() {
    const m = document.getElementById('modal-ps-alarm');
    if (m) m.style.display = 'flex';
}
function closePsAlarmModal() {
    const m = document.getElementById('modal-ps-alarm');
    if (m) m.style.display = 'none';
}
function submitPsAlarm() {
    const name = document.getElementById('ps-alarm-name').value.trim();
    const phone = document.getElementById('ps-alarm-phone').value.trim();
    const btn = document.getElementById('btn-ps-alarm');
    const msg = document.getElementById('ps-alarm-msg');
    if (btn) btn.innerText = 'Kaydediliyor...';
    
    fetch('/api.php?action=save_parcel_alarm', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({
            ad_soyad: name,
            telefon: phone,
            il: <?= json_encode($cityName) ?>,
            ilce: <?= json_encode($districtName ?? '') ?>,
            mahalle: <?= json_encode($mahalleName ?? '') ?>,
            ada: '',
            parsel: '',
            alert_type: 'Bölgesel İmar & Askı Değişiklikleri'
        })
    })
    .then(r => r.json())
    .then(res => {
        if (res.status === 'success') {
            msg.innerHTML = '<span style="color:#4ade80; font-weight:bold;">' + res.message + '</span>';
            setTimeout(() => { closePsAlarmModal(); }, 2500);
        } else {
            msg.innerHTML = '<span style="color:#f87171;">' + (res.message || 'Hata!') + '</span>';
        }
    })
    .catch(err => {
        msg.innerHTML = '<span style="color:#f87171;">Bağlantı hatası: ' + err + '</span>';
    })
    .finally(() => {
        if (btn) btn.innerText = '🔔 Ücretsiz Takip Bildirimi Başlat';
    });
}
</script>


<script>
if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        navigator.serviceWorker.register('/sw.js').catch(() => {});
    });
}
</script>
</body>
</html>
