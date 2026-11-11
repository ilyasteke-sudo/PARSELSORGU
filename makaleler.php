<?php
// ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ - PARSEL PRO
// 68.150+ MAKALE & İMAR KÜTÜPHANESİ MERKEZİ (makaleler.php)
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/navbar.php';

$page = max(1, intval($_GET['page'] ?? 1));
$limit = 18;
$offset = ($page - 1) * $limit;

$selected_city = trim($_GET['city'] ?? '');
$search_query = trim($_GET['q'] ?? '');
$selected_category = trim($_GET['category'] ?? '');

$where_clauses = [];
$params = [];

if (!empty($selected_city)) {
    $where_clauses[] = "city = ?";
    $params[] = $selected_city;
}

if (!empty($selected_category)) {
    $where_clauses[] = "category = ?";
    $params[] = $selected_category;
}

if (!empty($search_query)) {
    $where_clauses[] = "(title LIKE ? OR summary LIKE ? OR district LIKE ?)";
    $like = '%' . $search_query . '%';
    $params[] = $like;
    $params[] = $like;
    $params[] = $like;
}

$where_sql = !empty($where_clauses) ? "WHERE " . implode(" AND ", $where_clauses) : "";

$total_articles = 0;
$articles = [];
$cities = [];
$categories = [];

if ($pdo) {
    try {
        $cache_file = __DIR__ . '/data/makale_meta_cache.json';
        $cache_data = null;
        if (file_exists($cache_file) && (time() - filemtime($cache_file) < 14400)) {
            $cache_data = @json_decode(file_get_contents($cache_file), true);
        }

        if (empty($where_sql) && !empty($cache_data['total_articles'])) {
            $total_articles = (int)$cache_data['total_articles'];
        } else {
            $count_stmt = $pdo->prepare("SELECT COUNT(*) FROM blog_articles $where_sql");
            $count_stmt->execute($params);
            $total_articles = (int)$count_stmt->fetchColumn();
        }

        // Articles on current page (Fast indexed query via idx_view_count)
        $sql = "SELECT id, title, slug, summary, city, district, category, read_time, view_count, created_at 
                FROM blog_articles $where_sql 
                ORDER BY view_count DESC, id DESC LIMIT $limit OFFSET $offset";
        $art_stmt = $pdo->prepare($sql);
        $art_stmt->execute($params);
        $articles = $art_stmt->fetchAll();

        // Top 81 Cities & Categories (Zero-latency Cache)
        if (!empty($cache_data['cities']) && !empty($cache_data['categories'])) {
            $cities = $cache_data['cities'];
            $categories = $cache_data['categories'];
        } else {
            $cities = $pdo->query("SELECT city, COUNT(*) as cnt FROM blog_articles GROUP BY city ORDER BY cnt DESC, city ASC LIMIT 81")->fetchAll(PDO::FETCH_ASSOC);
            $categories = $pdo->query("SELECT category, COUNT(*) as cnt FROM blog_articles GROUP BY category ORDER BY cnt DESC")->fetchAll(PDO::FETCH_ASSOC);
            @file_put_contents($cache_file, json_encode([
                'total_articles' => $total_articles,
                'cities' => $cities,
                'categories' => $categories,
                'cached_at' => time()
            ]));
        }
    } catch (Exception $e) {}
}

$total_pages = ceil($total_articles / $limit);

// Site Settings
$site_title = "Ant Harita Mühendislik Teknolojileri - Parsel Pro";
$phone = "0542 841 35 35";
$address = "Yeni mah. Ulubatlı Hasan Cad. No:78/A KIRIKKALE / MERKEZ";
$google_analytics_id = "";
$google_site_verification = "";

if ($pdo) {
    try {
        $st_set = $pdo->query("SELECT setting_key, setting_value FROM site_settings WHERE setting_key IN ('site_title', 'phone', 'address', 'google_analytics_id', 'google_site_verification')");
        while ($r = $st_set->fetch()) {
            if ($r['setting_key'] === 'site_title') $site_title = $r['setting_value'];
            if ($r['setting_key'] === 'phone') $phone = $r['setting_value'];
            if ($r['setting_key'] === 'address') $address = $r['setting_value'];
            if ($r['setting_key'] === 'google_analytics_id') $google_analytics_id = $r['setting_value'];
            if ($r['setting_key'] === 'google_site_verification') $google_site_verification = $r['setting_value'];
        }
    } catch (Exception $e) {}
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title>İmar &amp; Kadastro Makaleleri 2026 | ParselSorgu</title>
    <meta name="description" content="81 il, 973 ilçe için hazırlanmış 68.000+ güncel imar parselasyonu, 18. madde uygulaması ve 2026 resmi ÇŞİDB inşaat maliyeti rehberi.">
    <?php if (!empty($google_site_verification)): ?>
        <meta name="google-site-verification" content="<?php echo htmlspecialchars($google_site_verification); ?>" />
    <?php endif; ?>
    <?php if (!empty($google_analytics_id)): ?>
        <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo htmlspecialchars($google_analytics_id); ?>"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '<?php echo htmlspecialchars($google_analytics_id); ?>');
        </script>
    <?php endif; ?>
    
    <!-- Search Engine Indexing & Canonical Link -->
    <?php
    $has_filters = !empty($selected_city) || !empty($selected_category) || !empty($search_query);
    $is_paginated = $page > 1;
    ?>
    <?php if ($has_filters || $is_paginated): ?>
    <link rel="canonical" href="https://www.parselsorgu.net/makaleler" />
        <meta property="og:image" content="https://www.parselsorgu.net/assets/images/og-parsel.jpg">
<meta name="robots" content="noindex, follow, max-snippet:-1, max-image-preview:large" />
    <meta name="googlebot" content="noindex, follow, max-snippet:-1, max-image-preview:large" />
    <?php else: ?>
    <link rel="canonical" href="https://www.parselsorgu.net/makaleler" />
    <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1" />
    <meta name="googlebot" content="index, follow, max-snippet:-1, max-image-preview:large" />
    <?php endif; ?>
    <meta name="author" content="Ant Harita Mühendislik" />

    <!-- Open Graph (OG) -->
    <meta property="og:type" content="website" />
    <meta property="og:title" content="📚 81 İl ve İlçe İmar, Parselasyon & 2026 İnşaat Maliyeti Kütüphanesi (68.150+ Makale)" />
    <meta property="og:description" content="Türkiye geneli 81 il ve 973 ilçe için 68.150+ adet güncel imar parselasyonu, 18. madde uygulaması ve 2026 ÇŞİDB inşaat maliyeti rehberi." />
    <meta property="og:url" content="https://www.parselsorgu.net/makaleler" />
    <meta property="og:image" content="https://www.parselsorgu.net/assets/images/og-parsel.jpg" />
    <meta property="og:site_name" content="Ant Harita Parsel Pro" />

    <!-- Schema.org CollectionPage & ItemList Structured Data -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "CollectionPage",
      "name": "İmar, Kadastro & Parselasyon Teknik Rehberler Kütüphanesi",
      "description": "Türkiye geneli harita mühendisliği, kadastro ve güncel imar mevzuatı teknik rehberleri.",
      "url": "https://www.parselsorgu.net/makaleler",
      "mainEntity": {
        "@type": "ItemList",
        "numberOfItems": <?php echo count($articles); ?>,
        "itemListElement": [
          <?php foreach ($articles as $idx => $art): ?>
          {
            "@type": "ListItem",
            "position": <?php echo $idx + 1; ?>,
            "name": <?php echo json_encode($art['title']); ?>,
            "url": "https://www.parselsorgu.net/makale/<?php echo urlencode($art['slug']); ?>"
          }<?php echo $idx < count($articles) - 1 ? ',' : ''; ?>
          <?php endforeach; ?>
        ]
      }
    }
    </script>

    <link rel="stylesheet" href="/assets/css/makaleler.css?v=2026.1">
    <!-- Microsoft Clarity -->
    <script type="text/javascript">
        (function(c,l,a,r,i,t,y){
            c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};
            t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i;
            y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y);
        })(window, document, "clarity", "script", "z46tj7yr8r");
    </script>

    <link rel="alternate" type="text/markdown" href="https://www.parselsorgu.net/llms.txt" title="ParselSorgu AI / LLM Bilgi Bankası">
    <link rel="alternate" type="application/json" href="https://www.parselsorgu.net/api/2026-kadastro-endeks.json" title="2026 Kadastro ve İmar Açık Veri Seti">
    <script type="application/ld+json">{"@context": "https://schema.org", "@type": "WebPage", "speakable": {"@type": "SpeakableSpecification", "cssSelector": ["h1", ".lead", ".summary-box", ".hero-desc", "main p"]}, "isBasedOn": "https://www.parselsorgu.net/api/2026-kadastro-endeks.json", "publisher": {"@type": "Organization", "name": "Ant Harita Mühendislik - ParselSorgu.net", "url": "https://www.parselsorgu.net/"}}</script>
</head>
<body>

    <!-- SITE HEADER -->
    <?php render_saas_navbar('makaleler'); ?>

    <!-- HERO SECTION -->
    <section class="lib-hero">
        <div class="container">
            <span class="lib-badge">📚 HARİTA MÜHENDİSLİĞİ & İMAR MEVZUATI REHBERLERİ</span>
            <h1 class="lib-title">Teknik İmar, Kadastro &amp; Parselasyon Kütüphanesi</h1>
            <p class="lib-desc">
                Resmi TKGM ada/parsel sorgulama teknikleri, 3194 Sayılı Kanun 18. Madde İmar Uygulaması, DOP kesintisi, 
                zemin etütleri ve 2026 yılı Çevre, Şehircilik ve İklim Değişikliği Bakanlığı inşaat birim maliyet analizleri.
            </p>

            <!-- SEARCH FORM -->
            <form method="GET" action="/makaleler" class="search-box">
                <input type="text" name="q" value="<?php echo htmlspecialchars($search_query); ?>" placeholder="İl, ilçe veya konu arayın (örn: Çankaya imar durumu, C30 beton fiyatı)..." class="search-input">
                <?php if ($selected_city): ?>
                    <input type="hidden" name="city" value="<?php echo htmlspecialchars($selected_city); ?>">
                <?php endif; ?>
                <button type="submit" class="search-btn">🔍 Ara</button>
            </form>
        </div>
    </section>

    <!-- CONTENT WRAPPER -->
    <div class="container">
        <!-- 81 CITIES FILTER PILLS -->
        <div class="pills-bar">
            <a href="/makaleler" class="pill <?php echo empty($selected_city) ? 'active' : ''; ?>">Tüm Türkiye (81 İl)</a>
            <?php foreach ($cities as $c): ?>
                <a href="/makaleler?city=<?php echo urlencode($c['city']); ?>" class="pill <?php echo $selected_city === $c['city'] ? 'active' : ''; ?>">
                    <?php echo htmlspecialchars($c['city']); ?> (<?php echo number_format($c['cnt']); ?>)
                </a>
            <?php endforeach; ?>
        </div>

        <!-- SEARCH STATUS -->
        <div style="display:flex; justify-content:space-between; align-items:center; margin-top:14px; font-size:13px; color:var(--text-muted);">
            <div>
                <?php if ($search_query || $selected_city): ?>
                    Filtrelenen: <strong style="color:#fff;"><?php echo htmlspecialchars($selected_city ?: $search_query); ?></strong> &bull; 
                <?php endif; ?>
                Kütüphanede <strong style="color:var(--accent-cyan); font-size:15px;">Seçkin Teknik Rehberler</strong> ve Mevzuat Kılavuzları listeleniyor
            </div>
            <div>Sayfa <?php echo $page; ?></div>
        </div>

        <!-- ARTICLES GRID -->
        <div class="articles-grid">
            <?php if (empty($articles)): ?>
                <div style="grid-column: 1 / -1; text-align:center; padding:60px 20px; color:var(--text-muted);">
                    <div style="font-size:48px; margin-bottom:12px;">🔍</div>
                    <h3 style="font-size:18px; color:#fff; margin-bottom:8px;">Aradığınız kriterlere uygun makale bulunamadı</h3>
                    <p style="font-size:13px;">Farklı bir arama terimi deneyebilir veya tüm makaleleri listeleyebilirsiniz.</p>
                    <a href="/makaleler" class="search-btn" style="display:inline-block; margin-top:16px;">Tüm Makaleleri Göster</a>
                </div>
            <?php else: ?>
                <?php foreach ($articles as $a): ?>
                <article class="article-card" style="padding:0; overflow:hidden;">
                    <?php
                    $thumb_img = "/makale-gorsel.php?" . http_build_query([
                        'title' => $a['title'],
                        'city' => $a['city'],
                        'district' => $a['district'] ?? '',
                        'category' => $a['category'] ?? 'İmar Uygulaması'
                    ]);
                    $thumb_alt = htmlspecialchars($a['city'] . ' ' . ($a['district'] ?? '') . ' ' . $a['title'] . ' Harita Kadastro ve İmar Rehberi');
                    ?>
                    <a href="/makale/<?php echo htmlspecialchars($a['slug']); ?>" style="display:block; position:relative; overflow:hidden; aspect-ratio:1200/630; background:#070d19;">
                        <img src="<?php echo htmlspecialchars($thumb_img); ?>" 
                             alt="<?php echo $thumb_alt; ?>" 
                             loading="lazy" decoding="async"
                             style="width:100%; height:100%; object-fit:cover; transition:transform 0.3s ease;" 
                             onmouseover="this.style.transform='scale(1.04)'" 
                             onmouseout="this.style.transform='scale(1)'" />
                    </a>
                    <div style="padding:18px 20px 20px 20px; display:flex; flex-direction:column; flex:1; justify-content:space-between;">
                    <div>
                        <div class="card-meta">
                            <span class="city-tag">📍 <?php echo htmlspecialchars($a['city']); ?><?php echo !empty($a['district']) ? ' / ' . htmlspecialchars($a['district']) : ''; ?></span>
                            <span style="color:var(--text-muted);">⏱️ <?php echo htmlspecialchars($a['read_time'] ?: '5 dk'); ?></span>
                        </div>
                        <h2 class="card-title">
                            <a href="/makale/<?php echo htmlspecialchars($a['slug']); ?>"><?php echo htmlspecialchars($a['title']); ?></a>
                        </h2>
                        <p class="card-summary"><?php echo htmlspecialchars($a['summary']); ?></p>
                    </div>
                    <div class="card-footer">
                        <span style="color:#64748b; font-size:11px;">👁️ <?php echo number_format($a['view_count'] ?: 250); ?> inceleme</span>
                        <a href="/makale/<?php echo htmlspecialchars($a['slug']); ?>" class="read-btn">
                            İncele & Okumaya Başla &rarr;
                        </a>
                    </div>
                    </div>
                </article>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- PAGINATION -->
        <?php if ($total_pages > 1): ?>
        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="/makaleler?page=<?php echo ($page - 1); ?><?php echo $selected_city ? '&city=' . urlencode($selected_city) : ''; ?><?php echo $search_query ? '&q=' . urlencode($search_query) : ''; ?>" class="page-link">&laquo; Önceki</a>
            <?php endif; ?>

            <?php
            $start_p = max(1, $page - 3);
            $end_p = min($total_pages, $page + 3);
            for ($p = $start_p; $p <= $end_p; $p++):
            ?>
                <a href="/makaleler?page=<?php echo $p; ?><?php echo $selected_city ? '&city=' . urlencode($selected_city) : ''; ?><?php echo $search_query ? '&q=' . urlencode($search_query) : ''; ?>" class="page-link <?php echo $p === $page ? 'active' : ''; ?>">
                    <?php echo $p; ?>
                </a>
            <?php endfor; ?>

            <?php if ($page < $total_pages): ?>
                <a href="/makaleler?page=<?php echo ($page + 1); ?><?php echo $selected_city ? '&city=' . urlencode($selected_city) : ''; ?><?php echo $search_query ? '&q=' . urlencode($search_query) : ''; ?>" class="page-link">Sonraki &raquo;</a>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>

    <!-- SITE FOOTER -->
    <footer class="site-footer">
        <div class="container">
            <p><strong>Ant Harita Mühendislik Teknolojileri A.Ş.</strong> &bull; LİHKAB No: 06-042 | TMMOB HKMO Sicil: 12480</p>
            <p style="margin-top:6px;"><?php echo htmlspecialchars($address); ?> &bull; Tel: <?php echo htmlspecialchars($phone); ?></p>
            <p style="margin-top:10px; color:#475569;">&copy; 2026 ParselSorgu.net &bull; Tüm Hakları Saklıdır.</p>
        </div>
    </footer>
    <script src="/analytics.js" defer></script>
</body>
</html>
