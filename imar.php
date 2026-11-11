<?php
/**
 * ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ - PARSEL PRO
 * CANLI İMAR PLANI DEĞİŞİKLİKLERİ & RESMÎ ASKI İLANLARI PORTALI (imar.php)
 * 
 * Fonksiyonlar:
 * 1. Resmî Gazete & ÇŞİDB Onaylı İmar Değişiklikleri & Google News Canlı Akışı.
 * 2. 3194 Sayılı İmar Kanunu 8/b Maddesi Uyarınca 30 Günlük Yasal Askı ve İtiraz Takvimi Takibi.
 * 3. 81 İl ve İlçe Bazında Filtreleme & Arama Motoru.
 * 4. Google News & Schema.org (NewsArticle, BreadcrumbList, FAQPage) %100 SEO Uyumlu Zengin Yapı.
 * 5. Parsel Sorgu & Harita Kadastro Mühendislik Danışmanlığı Entegrasyonu.
 */

// 1. GZIP SIKIŞTIRMA
if (!headers_sent() && extension_loaded('zlib')) {
    if (!ini_get('zlib.output_compression')) {
        @ini_set('zlib.output_compression', 'On');
        @ini_set('zlib.output_compression_level', '6');
    }
    if (ob_get_level() == 0) {
        @ob_start('ob_gzhandler');
    }
}

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/navbar.php';

if (!function_exists('imar_slugify')) {
    function imar_slugify($str) {
        $map = [
            'ç'=>'c', 'ğ'=>'g', 'ı'=>'i', 'i'=>'i', 'ö'=>'o', 'ş'=>'s', 'ü'=>'u',
            'Ç'=>'c', 'Ğ'=>'g', 'İ'=>'i', 'I'=>'i', 'Ö'=>'o', 'Ş'=>'s', 'Ü'=>'u',
            ' ' => '-'
        ];
        $str = strtr((string)$str, $map);
        $str = preg_replace('/[^a-zA-Z0-9\-]+/', '', strtolower($str));
        return trim($str, '-');
    }
}


// HIZLI VE ANLIK YANIT (<100ms Yüksek Performans - Sayfa Yüklenişini Asla Bekletmez)
if (!empty($_GET['refresh']) && $pdo) {
    if (file_exists(__DIR__ . '/google_news_imar_bot.php')) {
        try {
            require_once __DIR__ . '/google_news_imar_bot.php';
            $gnBot = new GoogleNewsImarBot($pdo);
            $gnBot->runAutoBot(1);
        } catch (Exception $e) {}
    }
}

$slug = trim($_GET['slug'] ?? $_GET['id'] ?? '');
if (empty($slug) && !empty($_SERVER['REQUEST_URI'])) {
    $req_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    if (preg_match('~^/imar/([^/?#]+)~', $req_path, $m)) {
        $slug = trim(urldecode($m[1]));
    }
}
$is_single = !empty($slug);
$article = null;

if ($is_single && $pdo) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM blog_articles WHERE slug = ? OR id = ? LIMIT 1");
        $stmt->execute([$slug, $slug]);
        $article = $stmt->fetch();
        if ($article) {
            $pdo->prepare("UPDATE blog_articles SET view_count = view_count + 1 WHERE id = ?")->execute([$article['id']]);
        } else {
            $is_single = false;
        }
    } catch (Exception $e) {
        $is_single = false;
    }
}

// 81 İL LİSTESİ
$all_cities = [
    'Adana','Adıyaman','Afyonkarahisar','Ağrı','Aksaray','Amasya','Ankara','Antalya','Ardahan','Artvin','Aydın','Balıkesir',
    'Bartın','Batman','Bayburt','Bilecik','Bingöl','Bitlis','Bolu','Burdur','Bursa','Çanakkale','Çankırı','Çorum','Denizli',
    'Diyarbakır','Düzce','Edirne','Elazığ','Erzincan','Erzurum','Eskişehir','Gaziantep','Giresun','Gümüşhane','Hakkari',
    'Hatay','Iğdır','Isparta','İstanbul','İzmir','Kahramanmaraş','Karabük','Karaman','Kars','Kastamonu','Kayseri','Kilis',
    'Kırıkkale','Kırklareli','Kırşehir','Kocaeli','Konya','Kütahya','Malatya','Manisa','Mardin','Mersin','Muğla','Muş',
    'Nevşehir','Niğde','Ordu','Osmaniye','Rize','Sakarya','Samsun','Şanlıurfa','Siirt','Sinop','Şırnak','Sivas','Tekirdağ',
    'Tokat','Trabzon','Tunceli','Uşak','Van','Yalova','Yozgat','Zonguldak'
];

// TEKİL SAYFA VERİLERİ
if ($is_single && $article) {
    $city = !empty($article['city']) ? htmlspecialchars($article['city']) : 'Türkiye Geneli';
    $district = !empty($article['district']) ? htmlspecialchars($article['district']) : 'Merkez';
    $title = htmlspecialchars($article['title']);
    $summary = htmlspecialchars($article['summary'] ?? '');
    $pub_date = !empty($article['created_at']) ? date('d.m.Y', strtotime($article['created_at'])) : date('d.m.Y');
    $expire_date = !empty($article['created_at']) ? date('d.m.Y', strtotime($article['created_at'] . ' + 30 days')) : date('d.m.Y', strtotime('+ 30 days'));
    
    // Kalan gün hesabı (30 gün üzerinden)
    $created_ts = !empty($article['created_at']) ? strtotime($article['created_at']) : time();
    $days_passed = floor((time() - $created_ts) / 86400);
    $days_left = max(1, 30 - $days_passed);

    // İlgili Diğer Askı İlanları
    $related = [];
    if ($pdo) {
        try {
            $stmt_rel = $pdo->prepare("SELECT id, title, slug, summary, city, district, created_at FROM blog_articles WHERE (category IN ('İmar Planı Değişikliği & Askı İlanı', 'Resmi Gazete & Askı İmar İlanları', 'Resmi Gazete & ÇŞİDB Askı İmar İlanı', '18. Madde İmar Uygulaması & DOP Kesintisi') OR title LIKE '%İmar%' OR title LIKE '%Askı%') AND id != ? ORDER BY id DESC LIMIT 6");
            $stmt_rel->execute([$article['id']]);
            $related = $stmt_rel->fetchAll();
        } catch (Exception $e) {}
    }

    $page_title = "{$title} - 2026 Resmî Askı İmar Planı & İtiraz Takvimi";
    $meta_desc = !empty($summary) ? $summary : "{$city} imar planı değişikliği ve askı ilanı. 3194 Sayılı İmar Kanunu 8/b maddesi uyarınca 30 günlük yasal itiraz takvimi, emsal KAKS/TAKS hakları ve Harita Mühendislik analizi.";
    $canonical_url = "https://www.parselsorgu.net/imar/" . urlencode($article['slug']);
} else {
    // PORTAL HUB LİSTE VERİLERİ
    $filter_city = trim($_GET['city'] ?? '');
    $filter_type = trim($_GET['type'] ?? '');
    $search_q = trim($_GET['q'] ?? '');

    $where_clauses = ["category IN ('İmar Planı Değişikliği & Askı İlanı', 'Resmi Gazete & Askı İmar İlanları', 'Resmi Gazete & ÇŞİDB Askı İmar İlanı', '18. Madde İmar Uygulaması & DOP Kesintisi', '3194 İmar Uygulaması & Parselasyon', 'google-news-imar-aski', 'Askı İlanı')"];
    $params = [];

    if (!empty($filter_city)) {
        $where_clauses[] = "city = ?";
        $params[] = $filter_city;
    }
    if (!empty($filter_type)) {
        if ($filter_type === 'resmi_gazete') {
            $where_clauses[] = "(category LIKE '%Resmi Gazete%' OR title LIKE '%Resmi Gazete%')";
        } elseif ($filter_type === 'madde18') {
            $where_clauses[] = "(category LIKE '%18. Madde%' OR title LIKE '%18. Madde%' OR title LIKE '%Parselasyon%')";
        } elseif ($filter_type === 'google_news') {
            $where_clauses[] = "(category LIKE '%İmar Planı Değişikliği%' OR title LIKE '%Askı%')";
        }
    }
    if (!empty($search_q)) {
        $where_clauses[] = "(title LIKE ? OR summary LIKE ? OR city LIKE ? OR district LIKE ?)";
        $like_q = "%{$search_q}%";
        $params[] = $like_q;
        $params[] = $like_q;
        $params[] = $like_q;
        $params[] = $like_q;
    }

    $where_sql = implode(' AND ', $where_clauses);
    $items = [];
    $total_count = 0;
    if ($pdo) {
        try {
            $count_stmt = $pdo->prepare("SELECT COUNT(*) FROM blog_articles WHERE {$where_sql}");
            $count_stmt->execute($params);
            $total_count = $count_stmt->fetchColumn();

            $stmt_list = $pdo->prepare("SELECT id, title, slug, summary, city, district, category, created_at, view_count FROM blog_articles WHERE {$where_sql} ORDER BY id DESC LIMIT 60");
            $stmt_list->execute($params);
            $items = $stmt_list->fetchAll();
        } catch (Exception $e) {}
    }

    if (empty($items)) {
        $alerts_file = __DIR__ . '/data/latest_zoning_alerts.json';
        if (file_exists($alerts_file)) {
            $raw_alerts = json_decode(file_get_contents($alerts_file), true);
            if (!empty($raw_alerts['alerts'])) {
                foreach ($raw_alerts['alerts'] as $al) {
                    if (!empty($filter_city) && mb_strtolower($al['city'], 'UTF-8') !== mb_strtolower($filter_city, 'UTF-8')) {
                        continue;
                    }
                    $items[] = [
                        'id' => $al['id'],
                        'title' => $al['title'],
                        'slug' => 'imar-aski-' . abs(crc32($al['title'])),
                        'summary' => "{$al['city']} {$al['district']} bölgesinde {$al['law']} kapsamında ilan edilen {$al['type']}. Yasal askı ve itiraz süresi devam etmektedir.",
                        'city' => $al['city'],
                        'district' => $al['district'],
                        'category' => $al['type'],
                        'created_at' => date('Y-m-d H:i:s', strtotime('-' . (30 - ($al['days_left'] ?? 15)) . ' days')),
                        'view_count' => rand(120, 850)
                    ];
                }
                $total_count = count($items);
            }
        }
    }

    $page_title = "2026 İmar Planı Askı İlanları ve İtirazlar | ParselSorgu";
    if (!empty($filter_city)) {
        $page_title = "{$filter_city} İmar Planı Askı İlanları (2026) | ParselSorgu";
    }
    $meta_desc = "81 il belediyesi ve ÇŞİDB onaylı 1/1000 ve 1/5000 imar planı askı ilanları ile 3194 s.K. 8/b kapsamındaki 30 günlük itiraz takvimi.";
    $canonical_url = "https://www.parselsorgu.net/imar" . (!empty($filter_city) ? "?city=" . urlencode($filter_city) : "");
}

$og_image = "https://www.parselsorgu.net/assets/images/og-parsel.jpg";
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <meta name="description" content="<?php echo $meta_desc; ?>">
    <link rel="canonical" href="<?php echo $canonical_url; ?>">
    <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
    <meta name="author" content="Ant Harita Mühendislik Teknolojileri">
    <link rel="icon" href="https://www.parselsorgu.net/favicon.ico">

    <!-- Open Graph & Twitter -->
    <meta property="og:type" content="<?php echo $is_single ? 'article' : 'website'; ?>">
    <meta property="og:title" content="<?php echo $page_title; ?>">
    <meta property="og:description" content="<?php echo $meta_desc; ?>">
    <meta property="og:url" content="<?php echo $canonical_url; ?>">
    <meta property="og:site_name" content="ParselSorgu.net - Ant Harita">
    <meta property="og:image" content="<?php echo $og_image; ?>">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo $page_title; ?>">
    <meta name="twitter:description" content="<?php echo $meta_desc; ?>">
    <meta name="twitter:image" content="<?php echo $og_image; ?>">

    <!-- Schema.org JSON-LD -->
    <?php if ($is_single && $article): ?>
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "NewsArticle",
        "headline": "<?php echo addslashes($article['title']); ?>",
        "description": "<?php echo addslashes($summary); ?>",
        "datePublished": "<?php echo date('c', strtotime($article['created_at'])); ?>",
        "dateModified": "<?php echo date('c', strtotime($article['created_at'])); ?>",
        "author": {
            "@type": "Organization",
            "name": "Ant Harita İmar & Askı Masası",
            "url": "https://www.parselsorgu.net"
        },
        "publisher": {
            "@type": "Organization",
            "name": "Ant Harita Mühendislik Teknolojileri",
            "logo": {
                "@type": "ImageObject",
                "url": "https://www.parselsorgu.net/favicon.ico"
            }
        },
        "mainEntityOfPage": {
            "@type": "WebPage",
            "@id": "<?php echo $canonical_url; ?>"
        }
    }
    </script>
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "BreadcrumbList",
        "itemListElement": [
            { "@type": "ListItem", "position": 1, "name": "Anasayfa", "item": "https://www.parselsorgu.net/" },
            { "@type": "ListItem", "position": 2, "name": "Canlı İmar & Askı Portalı", "item": "https://www.parselsorgu.net/imar" },
            { "@type": "ListItem", "position": 3, "name": "<?php echo addslashes($city); ?>", "item": "https://www.parselsorgu.net/imar?city=<?php echo urlencode($city); ?>" },
            { "@type": "ListItem", "position": 4, "name": "<?php echo addslashes($title); ?>", "item": "<?php echo $canonical_url; ?>" }
        ]
    }
    </script>
    <?php else: ?>
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "CollectionPage",
        "name": "Türkiye Canlı İmar Planı Askı İlanları ve 30 Günlük İtiraz Takvimi",
        "description": "81 İl belediyesi ve T.C. ÇŞİDB onaylı imar planı değişiklikleri, 18. madde parselasyon askı ilanları ve harita mühendisliği değerlendirmeleri.",
        "url": "https://www.parselsorgu.net/imar",
        "provider": {
            "@type": "Organization",
            "name": "Ant Harita Mühendislik Teknolojileri",
            "url": "https://www.parselsorgu.net"
        }
    }
    </script>
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "FAQPage",
        "mainEntity": [
            {
                "@type": "Question",
                "name": "İmar planı askı süresi kaç gündür?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "3194 Sayılı İmar Kanunu'nun 8. Maddesi (b) fıkrası uyarınca onaylanan 1/1000 ölçekli Uygulama İmar Planları ve 1/5000 ölçekli Nazım İmar Planları, ilan tahtalarında ve elektronik ortamda 30 (otuz) takvim günü süreyle askıda kalır."
                }
            },
            {
                "@type": "Question",
                "name": "Askıdaki imar planına itiraz nasıl yapılır?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "30 günlük askı süresi içerisinde taşınmaz sahipleri veya menfaati etkilenen vatandaşlar, ilgili belediye meclisine veya planı onaylayan idareye (Bakanlık/Valilik) itiraz dilekçesi ile başvurabilirler. Dilekçeye tapu kaydı, imar çapı ve gerekçeli mühendislik raporu eklenmelidir."
                }
            },
            {
                "@type": "Question",
                "name": "18. Madde parselasyonunda DOP kesintisi en fazla ne kadar olabilir?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "3194 Sayılı İmar Kanunu'nun 18. Maddesi uyarınca Düzenleme Ortaklık Payı (DOP) kesintisi oranı en fazla %45 olabilir. Bu oranın üzerindeki kesintiler kamulaştırma bedeline tabidir."
                }
            }
        ]
    }
    </script>
    <?php endif; ?>

    <style>
        :root {
            --bg-dark: #080d16;
            --bg-card: #0f172a;
            --bg-card-hover: #1e293b;
            --border-color: #1e293b;
            --border-highlight: #0284c7;
            --primary: #0284c7;
            --primary-light: #38bdf8;
            --accent-yellow: #facc15;
            --accent-green: #22c55e;
            --accent-red: #ef4444;
            --text-main: #f8fafc;
            --text-sub: #94a3b8;
            --font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }

        * { box-sizing: border-box; }
        body {
            background-color: var(--bg-dark);
            color: var(--text-main);
            font-family: var(--font-family);
            margin: 0;
            padding: 0;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        a { color: var(--primary-light); text-decoration: none; transition: all 0.2s; }
        a:hover { color: #fff; text-decoration: underline; }

        /* HEADER */
        .site-header {
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border-color);
            position: sticky;
            top: 0;
            z-index: 1000;
            padding: 12px 20px;
        }
        .header-inner {
            max-width: 1280px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
        }
        .header-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }
        .logo-badge {
            background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
            color: #fff;
            padding: 6px 12px;
            border-radius: 8px;
            font-weight: 900;
            font-size: 14px;
            letter-spacing: 0.5px;
            border: 1px solid #38bdf8;
            box-shadow: 0 0 15px rgba(2, 132, 199, 0.4);
        }
        .header-nav {
            display: flex;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
        }
        .nav-btn {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-sub);
            padding: 6px 12px;
            border-radius: 6px;
            border: 1px solid transparent;
            transition: all 0.2s;
        }
        .nav-btn:hover {
            color: #fff;
            border-color: #334155;
            background: rgba(255,255,255,0.05);
            text-decoration: none;
        }
        .nav-btn.active {
            color: #facc15;
            background: rgba(250, 204, 21, 0.1);
            border-color: rgba(250, 204, 21, 0.35);
        }
        .btn-wa-header {
            background: linear-gradient(135deg, #16a34a 0%, #15803d 100%);
            color: #fff !important;
            padding: 7px 14px;
            border-radius: 6px;
            font-weight: bold;
            font-size: 12px;
            border: 1px solid #22c55e;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none !important;
        }

        /* CONTAINER */
        .main-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 24px 20px 60px 20px;
        }

        /* BREADCRUMB */
        .breadcrumb-nav {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            color: var(--text-sub);
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        .breadcrumb-nav a { color: var(--text-sub); }
        .breadcrumb-nav a:hover { color: var(--primary-light); }
        .breadcrumb-separator { color: #475569; }

        /* HERO BANNER */
        .portal-hero {
            background: radial-gradient(circle at top right, rgba(2, 132, 199, 0.22) 0%, rgba(15, 23, 42, 0.98) 70%);
            border: 1px solid #0284c7;
            border-radius: 14px;
            padding: 32px 28px;
            margin-bottom: 28px;
            box-shadow: 0 0 35px rgba(2, 132, 199, 0.2);
            position: relative;
            overflow: hidden;
        }
        .hero-pulse-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(239, 68, 68, 0.15);
            border: 1px solid #ef4444;
            color: #fca5a5;
            font-size: 11px;
            font-weight: 800;
            padding: 4px 12px;
            border-radius: 20px;
            margin-bottom: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .pulse-dot {
            width: 8px;
            height: 8px;
            background-color: #ef4444;
            border-radius: 50%;
            box-shadow: 0 0 8px #ef4444;
            animation: pulse-glow 1.5s infinite;
        }
        @keyframes pulse-glow {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7); }
            70% { transform: scale(1.1); box-shadow: 0 0 0 8px rgba(239, 68, 68, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); }
        }
        .portal-hero h1 {
            font-size: 28px;
            font-weight: 900;
            color: #fff;
            margin: 0 0 10px 0;
            line-height: 1.3;
        }
        .portal-hero p {
            color: #cbd5e1;
            font-size: 14px;
            margin: 0 0 20px 0;
            max-width: 950px;
        }

        /* TELEMETRY STATS */
        .telemetry-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
            gap: 12px;
            margin-top: 20px;
        }
        .telemetry-card {
            background: rgba(15, 23, 42, 0.8);
            border: 1px solid #334155;
            border-radius: 8px;
            padding: 12px 16px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .telemetry-icon {
            font-size: 22px;
            background: rgba(2, 132, 199, 0.15);
            width: 42px;
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            border: 1px solid rgba(2, 132, 199, 0.3);
        }
        .telemetry-val { font-size: 15px; font-weight: bold; color: #fff; }
        .telemetry-lbl { font-size: 11px; color: var(--text-sub); }

        /* FILTER & SEARCH BAR */
        .filter-section {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 18px 20px;
            margin-bottom: 24px;
        }
        .filter-form {
            display: grid;
            grid-template-columns: 2fr 1.5fr 2fr auto;
            gap: 12px;
            align-items: center;
        }
        @media (max-width: 900px) {
            .filter-form { grid-template-columns: 1fr; }
        }
        .filter-select, .filter-input {
            background: #090e17;
            border: 1px solid #334155;
            color: #fff;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 13px;
            width: 100%;
            outline: none;
            transition: border-color 0.2s;
        }
        .filter-select:focus, .filter-input:focus { border-color: var(--primary-light); }
        .filter-btn {
            background: var(--primary);
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: bold;
            font-size: 13px;
            cursor: pointer;
            transition: background 0.2s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }
        .filter-btn:hover { background: #0284c7; }

        /* CARDS GRID */
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(360px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }
        @media (max-width: 640px) {
            .cards-grid { grid-template-columns: 1fr; }
        }
        .aski-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: transform 0.2s, border-color 0.2s, box-shadow 0.2s;
            text-decoration: none !important;
            color: inherit;
        }
        .aski-card:hover {
            transform: translateY(-3px);
            border-color: var(--primary-light);
            box-shadow: 0 8px 24px rgba(2, 132, 199, 0.2);
            background: var(--bg-card-hover);
        }
        .card-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 6px;
            margin-bottom: 12px;
        }
        .badge-city {
            background: rgba(2, 132, 199, 0.18);
            border: 1px solid #0284c7;
            color: #38bdf8;
            font-size: 11px;
            font-weight: 800;
            padding: 3px 8px;
            border-radius: 6px;
        }
        .badge-timer {
            background: rgba(234, 179, 8, 0.15);
            border: 1px solid #eab308;
            color: #facc15;
            font-size: 11px;
            font-weight: bold;
            padding: 3px 8px;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }
        .card-title {
            font-size: 16px;
            font-weight: 800;
            color: #f1f5f9;
            margin: 0 0 10px 0;
            line-height: 1.4;
        }
        .card-summary {
            font-size: 13px;
            color: var(--text-sub);
            margin: 0 0 16px 0;
            line-height: 1.5;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .card-footer {
            border-top: 1px solid #1e293b;
            padding-top: 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 12px;
            color: #64748b;
        }
        .card-link-cta {
            color: var(--primary-light);
            font-weight: bold;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        /* SINGLE DETAIL VIEW STYLES */
        .single-layout {
            display: grid;
            grid-template-columns: 2.4fr 1fr;
            gap: 28px;
        }
        @media (max-width: 960px) {
            .single-layout { grid-template-columns: 1fr; }
        }
        .single-main {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 14px;
            padding: 32px 30px;
        }
        .single-header-box {
            background: linear-gradient(135deg, rgba(2, 132, 199, 0.18) 0%, rgba(15, 23, 42, 0.98) 100%);
            border-left: 5px solid #0284c7;
            padding: 20px 24px;
            border-radius: 8px;
            margin-bottom: 24px;
        }
        .single-meta-strip {
            display: flex;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
            font-size: 12px;
            color: #cbd5e1;
            margin-top: 12px;
            padding-top: 12px;
            border-top: 1px solid rgba(255,255,255,0.1);
        }
        .single-content {
            font-size: 15px;
            color: #e2e8f0;
            line-height: 1.7;
        }
        .single-content h2 {
            color: #38bdf8;
            font-size: 20px;
            margin-top: 32px;
            margin-bottom: 12px;
            border-bottom: 1px solid #1e293b;
            padding-bottom: 8px;
        }
        .single-content h3 { color: #facc15; font-size: 17px; margin-top: 24px; }
        .single-content p { margin-bottom: 16px; }

        .cta-banner-box {
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%);
            border: 1.5px solid #38bdf8;
            border-radius: 10px;
            padding: 20px 24px;
            margin: 32px 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
            box-shadow: 0 0 20px rgba(56, 189, 248, 0.2);
        }

        .action-bar-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px;
            border-radius: 8px;
            font-weight: bold;
            font-size: 13px;
            cursor: pointer;
            text-decoration: none !important;
            transition: all 0.2s;
        }
        .btn-wa-cta {
            background: #22c55e;
            color: #000 !important;
        }
        .btn-wa-cta:hover { background: #16a34a; color: #fff !important; }
        .btn-parsel-cta {
            background: #0284c7;
            color: #fff !important;
            border: 1px solid #38bdf8;
        }
        .btn-parsel-cta:hover { background: #0369a1; }

        /* SIDEBAR */
        .single-sidebar {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        .sidebar-widget {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 20px;
        }
        .sidebar-widget h3 {
            font-size: 15px;
            font-weight: bold;
            color: #fff;
            margin: 0 0 14px 0;
            display: flex;
            align-items: center;
            gap: 8px;
            border-bottom: 1px solid #1e293b;
            padding-bottom: 10px;
        }

        /* SEO GUIDE SECTION */
        .seo-guide-section {
            background: var(--bg-card);
            border: 1px solid #334155;
            border-radius: 14px;
            padding: 32px 28px;
            margin-top: 40px;
        }
        .seo-guide-section h2 {
            color: #38bdf8;
            font-size: 22px;
            margin-top: 0;
            margin-bottom: 12px;
        }
        .faq-item {
            border-bottom: 1px solid #1e293b;
            padding: 16px 0;
        }
        .faq-question {
            font-size: 16px;
            font-weight: bold;
            color: #facc15;
            margin-bottom: 8px;
        }
        .faq-answer {
            font-size: 14px;
            color: #cbd5e1;
            line-height: 1.6;
        }

        /* FOOTER */
        .site-footer {
            background: #050810;
            border-top: 1px solid var(--border-color);
            padding: 30px 20px;
            text-align: center;
            font-size: 13px;
            color: #64748b;
            margin-top: 60px;
        }
    </style>
    <!-- Google Analytics GA4 -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-B6774G0NZZ"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', 'G-B6774G0NZZ');
    </script>

    <!-- Microsoft Clarity -->
    <script type="text/javascript">
        (function(c,l,a,r,i,t,y){
            c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};
            t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i;
            y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y);
        })(window, document, "clarity", "script", "z46tj7yr8r");
    </script>


    <!-- BreadcrumbList Schema -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "BreadcrumbList",
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
          "name": "İmar Askı İlanları",
          "item": "https://www.parselsorgu.net/imar-aski-ilanlari"
        }<?php if (!empty($is_single) && !empty($article)): ?>,
        {
          "@type": "ListItem",
          "position": 3,
          "name": <?php echo json_encode($article['title'] ?? '', JSON_UNESCAPED_UNICODE); ?>,
          "item": <?php echo json_encode($canonical_url, JSON_UNESCAPED_UNICODE); ?>
        }<?php endif; ?>
      ]
    }
    </script>
    <link rel="alternate" type="text/markdown" href="https://www.parselsorgu.net/llms.txt" title="ParselSorgu AI / LLM Bilgi Bankası">
    <link rel="alternate" type="application/json" href="https://www.parselsorgu.net/api/2026-kadastro-endeks.json" title="2026 Kadastro ve İmar Açık Veri Seti">
    <script type="application/ld+json">{"@context": "https://schema.org", "@type": "WebPage", "speakable": {"@type": "SpeakableSpecification", "cssSelector": ["h1", ".lead", ".summary-box", ".hero-desc", "main p"]}, "isBasedOn": "https://www.parselsorgu.net/api/2026-kadastro-endeks.json", "publisher": {"@type": "Organization", "name": "Ant Harita Mühendislik - ParselSorgu.net", "url": "https://www.parselsorgu.net/"}}</script>
</head>
<body>

    <!-- TOP HEADER -->
    <?php render_saas_navbar('imar'); ?>

    <main class="main-container">

        <!-- BREADCRUMB -->
        <nav class="breadcrumb-nav" aria-label="Breadcrumb">
            <a href="https://www.parselsorgu.net/">Anasayfa</a>
            <span class="breadcrumb-separator">&gt;</span>
            <a href="https://www.parselsorgu.net/imar">Canlı İmar &amp; Askı Portalı</a>
            <?php if ($is_single && $article): ?>
                <span class="breadcrumb-separator">&gt;</span>
                <a href="https://www.parselsorgu.net/imar?city=<?php echo urlencode($city); ?>"><?php echo $city; ?></a>
                <span class="breadcrumb-separator">&gt;</span>
                <span style="color:#f8fafc;"><?php echo mb_substr($title, 0, 45, 'UTF-8') . '...'; ?></span>
            <?php endif; ?>
        </nav>

        <?php if ($is_single && $article): ?>
            <!-- ========================================== -->
            <!-- 1. DETAYLI İMAR PLANI & ASKI İLANI GÖRÜNÜMÜ -->
            <!-- ========================================== -->
            <div class="single-layout">
                <article class="single-main">
                    <div class="single-header-box">
                        <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:8px; margin-bottom:12px;">
                            <span class="badge-city">📍 <?php echo $city . ' &bull; ' . $district; ?></span>
                            <span class="badge-timer">⏱️ 30 Günlük Askı Süresi: <strong><?php echo $days_left; ?> Gün Kaldı</strong></span>
                        </div>
                        <h1 style="color:#fff; font-size:24px; font-weight:900; margin:0 0 10px 0; line-height:1.3;">
                            <?php echo $title; ?>
                        </h1>
                        <p style="color:#cbd5e1; font-size:14px; margin:0; line-height:1.5;">
                            <?php echo $summary; ?>
                        </p>

                        <div class="single-meta-strip">
                            <span>🏛️ <strong>Onaylayan Kurum:</strong> T.C. ÇŞİDB &amp; İlgili Belediye</span>
                            <span>⚖️ <strong>Mevzuat:</strong> 3194 s.K. 8/b &amp; 18. Madde</span>
                            <span>📅 <strong>İlan Tarihi:</strong> <?php echo $pub_date; ?></span>
                            <span>⏰ <strong>Askı Bitiş:</strong> <?php echo $expire_date; ?></span>
                            <span>👁️ <strong>Görüntülenme:</strong> <?php echo number_format($article['view_count'] ?? 1); ?></span>
                        </div>
                    </div>

                    <!-- İÇERİK GÖVDESİ -->
                    <div class="single-content">

                    <!-- PERMANENT INTERNAL LINK TO DISTRICT PARCEL INQUIRY (PILLAR-CLUSTER) -->
                    <?php
                        $art_city_slug = imar_slugify($article['city'] ?? 'turkiye');
                        $art_dist_slug = imar_slugify($article['district'] ?? '');
                        $art_parsel_url = "/parsel-sorgu/" . $art_city_slug . (!empty($art_dist_slug) ? "/" . $art_dist_slug : "");
                        $art_dist_label = htmlspecialchars($article['district'] ?: ($article['city'] ?: 'Bölge'));
                    ?>
                    <div style="background: linear-gradient(135deg, rgba(2,132,199,0.18) 0%, rgba(15,23,42,0.92) 100%); border: 2px solid #0284c7; border-radius: 14px; padding: 22px 26px; margin: 26px 0; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px; box-shadow: 0 6px 30px rgba(2,132,199,0.2);">
                        <div style="max-width: 680px;">
                            <div style="display:inline-flex; align-items:center; gap:8px; margin-bottom:6px;">
                                <span style="background: rgba(56,189,248,0.22); border: 1px solid #38bdf8; color: #38bdf8; font-size: 11px; font-weight: 800; padding: 3px 9px; border-radius: 4px; text-transform: uppercase;">
                                    📍 Canlı Kadastro &amp; Parsel Entegrasyonu
                                </span>
                                <span style="color: #94a3b8; font-size: 12px; font-weight: 600;">Harita İmar Çapı Bağlantısı</span>
                            </div>
                            <h3 style="color: #fff; font-size: 18px; font-weight: 900; margin: 4px 0 6px 0; line-height: 1.35;">
                                <?= $art_dist_label ?> Bölgesindeki Ada ve Parselleri Canlı Haritada Sorgulayın
                            </h3>
                            <p style="color: #cbd5e1; font-size: 13px; margin: 0; line-height: 1.6;">
                                Bu imar planı askı ilanının kapsadığı taşınmazların parsel sınırlarını, TAKS/KAKS haklarını ve terk durumlarını Parsel Pro canlı uydu haritasında anında sorgulayabilirsiniz.
                            </p>
                        </div>
                        <a href="<?= $art_parsel_url ?>" style="background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%); color: #fff; padding: 13px 26px; border-radius: 10px; font-weight: 900; font-size: 14px; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 20px rgba(2,132,199,0.45); white-space: nowrap; transition: transform 0.2s;">
                            <i class="fa-solid fa-map-location-dot"></i> <?= $art_dist_label ?> Parsel Sorgula &raquo;
                        </a>
                    </div>

                        <?php echo $article['content']; ?>
                    </div>

                    <!-- PARSEL SORGU & DANIŞMANLIK HIZLI ÇAĞRI KUTUSU -->
                    <div class="cta-banner-box">
                        <div>
                            <div style="font-weight:900; color:#fff; font-size:16px;">🔍 Bu Bölgedeki Parselinizin Durumunu Biliyor Musunuz?</div>
                            <div style="color:#cbd5e1; font-size:13px; margin-top:4px;">
                                İmar planı değişikliğinin parselinizdeki TAKS, KAKS ve terklere etkisini TKGM haritasında anında inceleyin.
                            </div>
                        </div>
                        <div style="display:flex; gap:10px; flex-wrap:wrap;">
                            <a href="/parsel<?php echo !empty($city) ? '?city=' . urlencode($city) : ''; ?>" target="_blank" class="action-bar-btn btn-parsel-cta">
                                🗺️ Parselimi Canlı Sorgula
                            </a>
                            <a href="https://wa.me/905428413535?text=Merhaba,%20<?php echo urlencode($city . ' ' . $title); ?>%20imar%20plani%20ve%20parselim%20icin%20danismanlik%20almak%20istiyorum." target="_blank" class="action-bar-btn btn-wa-cta">
                                🟢 Mühendise Danış &amp; İtiraz
                            </a>
                        </div>
                    </div>

                    <!-- PAYLAŞ & YAZDIR -->
                    <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px; border-top:1px solid #1e293b; padding-top:20px; margin-top:30px;">
                        <div style="display:flex; align-items:center; gap:8px;">
                            <span style="font-size:13px; color:#94a3b8; font-weight:bold;">İlanı Paylaş:</span>
                            <a href="https://api.whatsapp.com/send?text=<?php echo urlencode($title . ' ' . $canonical_url); ?>" target="_blank" style="background:#22c55e; color:#000; padding:6px 10px; border-radius:6px; font-size:12px; font-weight:bold;">WhatsApp</a>
                            <a href="https://twitter.com/intent/tweet?text=<?php echo urlencode($title); ?>&url=<?php echo urlencode($canonical_url); ?>" target="_blank" style="background:#0284c7; color:#fff; padding:6px 10px; border-radius:6px; font-size:12px; font-weight:bold;">X (Twitter)</a>
                            <button onclick="navigator.clipboard.writeText('<?php echo $canonical_url; ?>'); alert('İlan bağlantısı kopyalandı!');" style="background:#334155; color:#fff; border:none; padding:6px 10px; border-radius:6px; font-size:12px; cursor:pointer;">🔗 Kopyala</button>
                        </div>
                        <button onclick="window.print();" style="background:transparent; border:1px solid #475569; color:#cbd5e1; padding:6px 14px; border-radius:6px; font-size:12px; cursor:pointer;">
                            🖨️ Sayfayı Yazdır / PDF
                        </button>
                    </div>
                </article>

                <!-- DETAY YAN PANELİ -->
                <aside class="single-sidebar">
                    <div class="sidebar-widget">
                        <h3>🏛️ 30 Günlük Yasal Askı Bilgisi</h3>
                        <p style="font-size:13px; color:#cbd5e1; margin:0 0 12px 0;">
                            3194 Sayılı Kanun 8/b maddesi gereğince bu ilan <strong>30 gün</strong> boyunca askıdadır. Kalan süre içinde itiraz edilmeyen planlar kesinleşir.
                        </p>
                        <div style="background:rgba(234,179,8,0.1); border:1px solid #eab308; border-radius:6px; padding:10px; font-size:12px; color:#facc15;">
                            ⏱️ <strong>Kalan Süre:</strong> <?php echo $days_left; ?> Gün<br>
                            📅 <strong>Son İtiraz Tarihi:</strong> <?php echo $expire_date; ?>
                        </div>
                    </div>

                    <?php if (!empty($related)): ?>
                    <div class="sidebar-widget">
                        <h3>📢 Diğer Güncel Askı İlanları</h3>
                        <div style="display:flex; flex-direction:column; gap:12px;">
                            <?php foreach ($related as $rel): ?>
                                <a href="https://www.parselsorgu.net/imar/<?php echo urlencode($rel['slug']); ?>" style="text-decoration:none; padding-bottom:10px; border-bottom:1px solid #1e293b;">
                                    <div style="font-size:11px; color:#38bdf8; font-weight:bold; margin-bottom:2px;">📍 <?php echo htmlspecialchars($rel['city']); ?></div>
                                    <div style="font-size:13px; color:#f1f5f9; line-height:1.4;"><?php echo htmlspecialchars($rel['title']); ?></div>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="sidebar-widget" style="background:linear-gradient(135deg, rgba(2,132,199,0.15) 0%, rgba(15,23,42,0.95) 100%); border-color:#0284c7;">
                        <h3>🗺️ TKGM Canlı Parsel Sorgulama</h3>
                        <p style="font-size:12px; color:#cbd5e1; margin-bottom:14px;">
                            İmar planı askıya çıkan ada ve parselinizi Türkiye'nin 1 numaralı mühendislik platformunda sorgulayın.
                        </p>
                        <a href="/parsel<?php echo !empty($city) ? '?city=' . urlencode($city) : ''; ?>" target="_blank" style="display:block; text-align:center; background:#0284c7; color:#fff; font-weight:bold; padding:10px; border-radius:6px; font-size:13px;">
                            Canlı Parsel Sorgula ➔
                        </a>
                    </div>
                </aside>
            </div>

        <?php else: ?>
            <!-- ========================================== -->
            <!-- 2. ANA PORTAL HUB GÖRÜNÜMÜ (/imar)          -->
            <!-- ========================================== -->
            <section class="portal-hero">
                <div class="hero-pulse-badge">
                    <span class="pulse-dot"></span>
                    <span>CANLI RESMÎ ASKI &amp; GOOGLE NEWS İMAR DEĞİŞİKLİKLERİ AKIŞI</span>
                </div>
                <h1>
                    Türkiye Güncel İmar Planı Askı İlanları &amp; İtiraz Rehberi (2026)
                </h1>
                <p>
                    T.C. Çevre, Şehircilik ve İklim Değişikliği Bakanlığı ve 81 İl Belediye Meclisi kararıyla askıya çıkarılan güncel 1/1000 Uygulama ve 1/5000 Nazım İmar Planları, 18. Madde parselasyon askı cetvelleri ve mülk sahipleri için 30 günlük yasal itiraz takvimi.
                </p>

                <!-- TELEMETRY GÖSTERGELERİ -->
                <div class="telemetry-grid">
                    <div class="telemetry-card">
                        <div class="telemetry-icon">📡</div>
                        <div>
                            <div class="telemetry-val">81 İl / 973 İlçe</div>
                            <div class="telemetry-lbl">Otonom Belediye &amp; Bakanlık Taraması</div>
                        </div>
                    </div>
                    <div class="telemetry-card">
                        <div class="telemetry-icon">⚖️</div>
                        <div>
                            <div class="telemetry-val">3194 s.K. 8/b &amp; 18</div>
                            <div class="telemetry-lbl">Resmî Hukuki Dayanak</div>
                        </div>
                    </div>
                    <div class="telemetry-card">
                        <div class="telemetry-icon">⏱️</div>
                        <div>
                            <div class="telemetry-val">30 Günlük Askı</div>
                            <div class="telemetry-lbl">Yasal İtiraz ve Dava Süresi</div>
                        </div>
                    </div>
                    <div class="telemetry-card">
                        <div class="telemetry-icon">📰</div>
                        <div>
                            <div class="telemetry-val">Google News &amp; Resmî Gazete</div>
                            <div class="telemetry-lbl">Canlı RSS ve Günlük Bülten</div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- ARAMA & FİLTRELEME ÇUBUĞU -->
            <section class="filter-section">
                <form method="GET" action="https://www.parselsorgu.net/imar" class="filter-form">
                    <div>
                        <select name="city" class="filter-select">
                            <option value="">🗺️ Tüm İller (81 İl)</option>
                            <?php foreach ($all_cities as $c): ?>
                                <option value="<?php echo $c; ?>" <?php echo ($filter_city === $c) ? 'selected' : ''; ?>>
                                    <?php echo $c; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <select name="type" class="filter-select">
                            <option value="">📂 Tüm Plan Türleri</option>
                            <option value="resmi_gazete" <?php echo ($filter_type === 'resmi_gazete') ? 'selected' : ''; ?>>🏛️ Resmî Gazete İlanları</option>
                            <option value="google_news" <?php echo ($filter_type === 'google_news') ? 'selected' : ''; ?>>📰 Google News Askı Haberleri</option>
                            <option value="madde18" <?php echo ($filter_type === 'madde18') ? 'selected' : ''; ?>>📐 18. Madde &amp; Parselasyon</option>
                        </select>
                    </div>
                    <div>
                        <input type="text" name="q" value="<?php echo htmlspecialchars($search_q); ?>" placeholder="İlçe, mahalle veya ada-parsel ara..." class="filter-input">
                    </div>
                    <div>
                        <button type="submit" class="filter-btn">
                            🔍 Filtrele &amp; Listele
                        </button>
                    </div>
                </form>
            </section>

            <!-- ASKI İLANLARI KART IZGARASI -->
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
                <div style="font-weight:bold; font-size:16px; color:#fff;">
                    📢 Güncel Askıdaki İmar Planları (<?php echo count($items); ?> İlan Listeleniyor)
                </div>
                <?php if (!empty($filter_city) || !empty($filter_type) || !empty($search_q)): ?>
                    <a href="https://www.parselsorgu.net/imar" style="font-size:12px; color:#facc15;">✖ Filtreleri Temizle</a>
                <?php endif; ?>
            </div>

            <div class="cards-grid">
                <?php if (!empty($items)): ?>
                    <?php foreach ($items as $item): ?>
                        <?php 
                            $c_city = !empty($item['city']) ? htmlspecialchars($item['city']) : 'Türkiye Geneli';
                            $c_created = !empty($item['created_at']) ? strtotime($item['created_at']) : time();
                            $c_days_passed = floor((time() - $c_created) / 86400);
                            $c_days_left = max(1, 30 - $c_days_passed);
                        ?>
                        <a href="https://www.parselsorgu.net/imar/<?php echo urlencode($item['slug']); ?>" class="aski-card">
                            <div>
                                <div class="card-top">
                                    <span class="badge-city">📍 <?php echo $c_city; ?></span>
                                    <span class="badge-timer">⏱️ <?php echo $c_days_left; ?> Gün Kaldı</span>
                                </div>
                                <h2 class="card-title"><?php echo htmlspecialchars($item['title']); ?></h2>
                                <p class="card-summary"><?php echo htmlspecialchars($item['summary']); ?></p>
                            </div>
                            <div class="card-footer">
                                <span>📅 <?php echo date('d.m.Y', $c_created); ?></span>
                                <span class="card-link-cta">İncele &amp; İtiraz Rehberi ➔</span>
                                <?php if (!empty($item['city'])): ?>
                                <a href="/parsel-sorgu/<?php echo imar_slugify($item['city'] ?? 'turkiye') . (!empty($item['district']) ? '/' . imar_slugify($item['district']) : ''); ?>" style="background:rgba(2,132,199,0.25); border:1px solid #0284c7; color:#38bdf8; font-size:11px; padding:3px 10px; border-radius:6px; font-weight:800; text-decoration:none; display:inline-flex; align-items:center; gap:5px;" onclick="event.stopPropagation();" title="<?php echo htmlspecialchars($item['district'] ?: $c_city); ?> Parsel Sorgula">
                                    <i class="fa-solid fa-map-location-dot"></i> <?php echo htmlspecialchars($item['district'] ?: $c_city); ?> Parsel Sorgu &raquo;
                                </a>
                                <?php endif; ?>
                            </div>
                        </a>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div style="grid-column:1/-1; background:#0f172a; border:1px solid #334155; border-radius:12px; padding:40px; text-align:center;">
                        <div style="font-size:36px; margin-bottom:12px;">🏛️</div>
                        <h3 style="color:#fff; margin:0 0 8px 0;">Seçilen Kriterlere Uygun Askı İlanı Bulunamadı</h3>
                        <p style="color:#94a3b8; font-size:14px; margin:0 0 20px 0;">Farklı bir il seçebilir veya tüm illerin askıdaki planlarını listelemek için filtreyi temizleyebilirsiniz.</p>
                        <a href="https://www.parselsorgu.net/imar" style="background:#0284c7; color:#fff; font-weight:bold; padding:10px 20px; border-radius:8px; display:inline-block;">Tüm İlanları Göster</a>
                    </div>
                <?php endif; ?>
            </div>

            <!-- SEO REHBERİ & SSS (ORGANİK TRAFİK MIKNATISI) -->
            <section class="seo-guide-section">
                <h2>📚 3194 Sayılı İmar Kanunu Kapsamında İmar Planı Askı Süreci ve Hak Sahipleri Kılavuzu</h2>
                <p style="color:#cbd5e1; font-size:14px;">
                    İmar planları; kentlerin gelecekteki yerleşim düzenini, parsel fonksiyonlarını, yapılaşma şartlarını (TAKS/KAKS) ve donatı alanlarını (yol, yeşil alan, okul, otopark) belirleyen en üst düzey hukuki ve teknik metinlerdir. Bir bölgede yapılan imar planı revizyonu taşınmazınızın değerini ve kullanım hakkını doğrudan etkiler.
                </p>

                <div class="faq-item">
                    <div class="faq-question">1. İmar planı askı süresi ne kadardır ve ne zaman başlar?</div>
                    <div class="faq-answer">
                        3194 Sayılı İmar Kanunu'nun 8. Maddesi (b) bendi gereğince, belediye meclisi veya ÇŞİDB tarafından onaylanan 1/1000 ölçekli Uygulama İmar Planı ve 1/5000 ölçekli Nazım İmar Planları, ilan edildikleri tarihten itibaren <strong>tam 30 (otuz) takvim günü</strong> boyunca ilan panolarında ve e-plan otomasyonunda askıda kalır.
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">2. Askı süresi içinde itiraz edilmezse ne olur?</div>
                    <div class="faq-answer">
                        30 günlük askı süresi içinde yazılı itirazda bulunulmayan imar planları kesinleşir. Kesinleşen planlar sonrasında parselinizden yapılan DOP kesintisi veya emsal düşüşlerine karşı doğrudan belediye nezdinde itiraz hakkı düşer; hak arayışı yalnızca İdare Mahkemesinde 60 günlük dava açma süresiyle sınırlandırılır.
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">3. İmar planı değişikliğine itiraz dilekçesi nereye ve nasıl verilir?</div>
                    <div class="faq-answer">
                        İtiraz dilekçesi, planı onaylayan kuruma (Büyükşehir Belediyesi, İlçe Belediyesi veya ÇŞİDB İl Müdürlüğü) verilir. Dilekçeye güncel tapu fotokopisi, imar çapı, ada-parsel numarası ve teknik gerekçeleri açıklayan Harita Mühendisliği raporu eklenmesi itirazın kabul edilme şansını ciddi oranda artırır.
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">4. 18. Madde Arazi ve Arsa Düzenlemesinde haklarım nelerdir?</div>
                    <div class="faq-answer">
                        İmar Kanununun 18. Maddesi uyarınca yapılan parselasyon işlemlerinde en fazla %45 oranında Düzenleme Ortaklık Payı (DOP) kesilebilir. DOP haricinde kamu ortaklık payı (KOP) veya hisselendirme uyuşmazlıklarında LİHKAB ve Harita Kadastro Mühendisleri aracılığıyla krokisel kontrol yaptırılmalıdır.
                    </div>
                </div>
            </section>
        <?php endif; ?>

    </main>

    <!-- FOOTER -->
    <footer class="site-footer">
        <div style="max-width:1280px; margin:0 auto; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:16px;">
            <div>
                <strong>Ant Harita Mühendislik Teknolojileri</strong> &bull; Resmî Lisanslı Parsel Pro Platformu
            </div>
            <div>
                <a href="/parsel<?php echo !empty($city) ? '?city=' . urlencode($city) : ''; ?>" style="color:#94a3b8; margin:0 8px;">Parsel Sorgu</a>
                <a href="https://www.parselsorgu.net/imar" style="color:#facc15; margin:0 8px;">İmar &amp; Askı</a>
                <a href="https://www.parselsorgu.net/maliyet" style="color:#94a3b8; margin:0 8px;">İnşaat Maliyeti</a>
                <a href="https://www.parselsorgu.net/forum" style="color:#94a3b8; margin:0 8px;">Kariyer &amp; Forum</a>
            </div>
        </div>
        <div style="margin-top:14px; font-size:11px; color:#475569;">
            © <?php echo date('Y'); ?> parselsorgu.net. T.C. ÇŞİDB, TKGM ve Belediye Meclisi Resmî Duyuruları Bilgilendirme Amaçlı Derlenmektedir.
        </div>
    </footer>

</body>
</html>
