<?php
// ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ - PARSEL PRO
// Google SEO Index Magnet Article Reader (makale.php)
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/navbar.php';
require_once __DIR__ . '/SeoManager.php';

$slug = $_GET['slug'] ?? '';
$slug = trim($slug);

$article = null;
if ($pdo && $slug) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM blog_articles WHERE slug = ? OR id = ? LIMIT 1");
        $stmt->execute([$slug, $slug]);
        $article = $stmt->fetch();
        if ($article) {
            $pdo->prepare("UPDATE blog_articles SET view_count = view_count + 1 WHERE id = ?")->execute([$article['id']]);
        }
    } catch (Exception $e) {}
}

$related_articles = [];
if ($article && $pdo) {
    try {
        $stmt_rel = $pdo->prepare("SELECT id, title, slug, summary, city, district, category, read_time FROM blog_articles WHERE city = ? AND id != ? ORDER BY id DESC LIMIT 6");
        $stmt_rel->execute([$article['city'], $article['id']]);
        $related_articles = $stmt_rel->fetchAll();
        if (count($related_articles) < 6) {
            $needed = 6 - count($related_articles);
            $stmt_rel2 = $pdo->prepare("SELECT id, title, slug, summary, city, district, category, read_time FROM blog_articles WHERE id != ? ORDER BY id DESC LIMIT " . intval($needed));
            $stmt_rel2->execute([$article['id']]);
            $more = $stmt_rel2->fetchAll();
            $related_articles = array_merge($related_articles, $more);
        }
    } catch (Exception $e) {}
}

$google_analytics_id = '';
$yandex_metrica_id = '';
$google_site_verification = '';
if ($pdo) {
    try {
        $st_set = $pdo->query("SELECT setting_key, setting_value FROM site_settings WHERE setting_key IN ('google_analytics_id', 'yandex_metrica_id', 'google_site_verification')");
        while ($row = $st_set->fetch()) {
            if ($row['setting_key'] === 'google_analytics_id') $google_analytics_id = $row['setting_value'];
            if ($row['setting_key'] === 'yandex_metrica_id') $yandex_metrica_id = $row['setting_value'];
            if ($row['setting_key'] === 'google_site_verification') $google_site_verification = $row['setting_value'];
        }
    } catch (Exception $e) {}
}

if (!$article) {
    header("HTTP/1.0 404 Not Found");
    $page_title = "Makale Bulunamadı - Ant Harita Parsel Pro";
    $meta_desc = "Aradığınız imar ve parselasyon makalesi bulunamadı.";
} else {
    // 301 loop prevention disabled for LiteSpeed

    $raw_title = trim((string)($article['title'] ?? ''));
    if (mb_strlen($raw_title, 'UTF-8') <= 46) {
        $opt_title = $raw_title . ' | ParselSorgu';
    } elseif (mb_strlen($raw_title, 'UTF-8') <= 60) {
        $opt_title = $raw_title;
    } else {
        $cut_t = preg_replace('/\s+\S*$/u', '', mb_substr($raw_title, 0, 57, 'UTF-8'));
        $opt_title = ($cut_t !== '' ? $cut_t : mb_substr($raw_title, 0, 57, 'UTF-8')) . '...';
    }
    $page_title = htmlspecialchars($opt_title);
    $raw_sum = trim(strip_tags((string)($article['summary'] ?? '')));
    if (mb_strlen($raw_sum, 'UTF-8') > 155) {
        $cut_d = preg_replace('/\s+\S*$/u', '', mb_substr($raw_sum, 0, 152, 'UTF-8'));
        $raw_sum = ($cut_d !== '' ? $cut_d : mb_substr($raw_sum, 0, 152, 'UTF-8')) . '...';
    }
    $meta_desc = htmlspecialchars($raw_sum);
    $meta_keywords = htmlspecialchars($article['seo_keywords'] ?? 'parsel sorgulama, 18. madde imar, dop hesabı');
    $canonical_url = "https://www.parselsorgu.net/makale/" . urlencode($article['slug']);
    
    // 100% Dynamic High-Resolution Google Discover WebP Hero Image (1200x675 - 16:9)
    $article_image_url = "https://www.parselsorgu.net/makale-gorsel.php?" . http_build_query([
        'format'   => 'webp',
        'title'    => $article['title'] ?? '',
        'city'     => $article['city'] ?? 'Türkiye',
        'district' => $article['district'] ?? '',
        'category' => $article['category'] ?? 'İmar Uygulaması ve Harita Kadastro'
    ]);
    $image_alt_text = htmlspecialchars(($article['city'] ?? 'Türkiye') . ' ' . ($article['district'] ?? '') . ' ' . ($article['title'] ?? '') . ' - TKGM Harita Kadastro ve İmar Parselasyon Rehberi');
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <base href="https://www.parselsorgu.net/">
    <meta charset="utf-8">
    <?php if (!empty($google_site_verification)): ?><meta name="google-site-verification" content="<?php echo htmlspecialchars($google_site_verification); ?>" /><?php endif; ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title><?php echo $page_title; ?></title>
    <meta name="description" content="<?php echo $meta_desc; ?>" />
    
    <!-- Multi-Browser & PWA Optimization (Apple Safari, Google Chrome, Opera, MS Edge) -->
    <link rel="manifest" href="manifest.json" />
    <meta name="theme-color" content="#0284c7" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
    <meta name="apple-mobile-web-app-title" content="ParselSorgu" />
    <link rel="apple-touch-icon" href="https://www.parselsorgu.net/assets/icon-192.png" />
    <link rel="icon" href="https://www.parselsorgu.net/favicon.ico" />
    
    <!-- Search Engine Indexing (Google HCU & Scaled Content Protection Shield) -->
<?php
$is_valuable_indexed = false;
if (!empty($article)) {
    $art_cat   = trim($article['category'] ?? '');
    $art_dist  = trim($article['district'] ?? '');
    $art_views = (int)($article['view_count'] ?? 0);
    $art_title = $article['title'] ?? '';

    // 1. Özgün Editöryal Kategoriler
    $editorial_categories = [
        'Tiny House & Prefabrik', 'Kat Karşılığı & İnşaat', 'Köy İmarı & Kırsal Alan',
        'Tarla & Arazi İmarı', 'Tapu & Mülkiyet Hukuku', 'Mevzuat & Hukuk',
        'Haberler', 'Gündem', 'Bülten', 'Teknik Rehber', 'Rehber',
        '🌾 Kırsal & Villa İmarlı Parseller', '🏗️ İmar Uygulaması (18. Madde & Parselasyon)',
        '🏗️ Kentsel Dönüşüm & Tevhid', '🗺️ Harita İşleri (Kadastro, LİHKAB, Aplikasyon)',
        '📐 İmar Planı (1/1000 & 1/5000 Nazım)', '⚡ Zemin & Deprem Analizi',
        '💰 Arsa Değerleme & Yatırım', '📐 İmar Mevzuatı & Parselasyon'
    ];

    // 2. 81 İl Kılavuzu & Genel Rehberler
    $is_provincial_or_general = empty($art_dist) || in_array(mb_strtolower($art_dist, 'UTF-8'), ['genel', 'türkiye geneli']);

    // 3. Tekrarlayan 68.000 Şablon Köy/Mahalle Kontrolü
    $is_repetitive_village = (bool)preg_match('/(mahallesi|köyü|koyu)/iu', $art_title);

    // 4. Karar: Yalnızca Özgün Teknik Rehberler ve 81 İl Kılavuzları İndekslenir
    if (!$is_repetitive_village && ($is_provincial_or_general || in_array($art_cat, $editorial_categories) || $art_views >= 1000)) {
        $is_valuable_indexed = true;
    }
}
?>
<?php if ($is_valuable_indexed): ?>
    <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1" />
    <meta name="googlebot" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1" />
    <meta name="googlebot-news" content="index, follow" />
    <meta name="yandex" content="index, follow" />
    <meta name="bingbot" content="index, follow" />
<?php else: ?>
    <!-- Otomatik Mahalle/Köy Şablon Karantinası: Crawl Bütçesini & Alan Adı Otoritesini Korur -->
    <meta name="robots" content="noindex, follow" />
    <meta name="googlebot" content="noindex, follow" />
    <meta name="yandex" content="noindex, follow" />
    <meta name="bingbot" content="noindex, follow" />
<?php endif; ?>
    <meta name="geo.region" content="TR" />
    <meta name="geo.placename" content="<?php echo $article ? htmlspecialchars($article['city']) : 'Türkiye'; ?>" />
    <link rel="help" type="text/markdown" href="https://www.parselsorgu.net/llms.txt" title="LLM Documentation" />
    <link rel="alternate" type="text/markdown" href="https://www.parselsorgu.net/llms.txt" title="ParselSorgu AI Bilgi Bankası" />
    <link rel="alternate" type="application/json" href="https://www.parselsorgu.net/api/2026-kadastro-endeks.json" title="2026 Kadastro ve İmar Açık Veri Seti" />

    <?php if (!empty($google_analytics_id)): ?>
    <!-- Google Analytics GA4 -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo htmlspecialchars($google_analytics_id); ?>"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', '<?php echo htmlspecialchars($google_analytics_id); ?>');
    </script>
    <?php endif; ?>

    <?php if (!empty($yandex_metrica_id)): ?>
    <!-- Yandex Metrika -->
    <script type="text/javascript">
       (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
       m[i].l=1*new Date();
       for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}
       k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
       (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");
       ym(<?php echo htmlspecialchars($yandex_metrica_id); ?>, "init", { clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true });
    </script>
    <?php endif; ?>
    <?php if ($article): ?>
    <meta name="keywords" content="<?php echo $meta_keywords; ?>" />
    <meta name="author" content="<?php echo htmlspecialchars($article['author'] ?? 'Ant Harita'); ?>" />
    <link rel="canonical" href="<?php echo $canonical_url; ?>" />
    <link rel="sitemap" type="application/xml" title="Sitemap" href="https://www.parselsorgu.net/sitemap.xml" />
    <link rel="alternate" type="application/rss+xml" title="Ant Harita RSS Feed" href="https://www.parselsorgu.net/rss.xml" />
    
    <!-- Open Graph (OG) / Social Media & Google Discover Meta (1200x675) -->
    <meta property="og:type" content="article" />
    <meta property="og:title" content="<?php echo htmlspecialchars($article['title']); ?>" />
    <meta property="og:description" content="<?php echo $meta_desc; ?>" />
    <meta property="og:url" content="<?php echo $canonical_url; ?>" />
    <meta property="og:site_name" content="Ant Harita Parsel Pro" />
    <meta property="article:published_time" content="<?php echo date('c', strtotime($article['date_published'] ?? '2026-10-20')); ?>" />
    <meta property="article:modified_time" content="<?php echo date('c', strtotime($article['date_published'] ?? '2026-10-30')); ?>" />
    <meta property="article:section" content="<?php echo htmlspecialchars($article['category'] ?? '18. Madde İmar Uygulaması'); ?>" />
    <meta property="og:image" content="<?php echo htmlspecialchars($article_image_url); ?>" />
    <meta property="og:image:secure_url" content="<?php echo htmlspecialchars($article_image_url); ?>" />
    <meta property="og:image:type" content="image/webp" />
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="675" />
    <meta property="og:image:alt" content="<?php echo $image_alt_text; ?>" />

    <!-- Twitter Card (Large Summary for Discover & X) -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="<?php echo htmlspecialchars($article['title']); ?>" />
    <meta name="twitter:description" content="<?php echo $meta_desc; ?>" />
    <meta name="twitter:image" content="<?php echo htmlspecialchars($article_image_url); ?>" />
    <meta name="twitter:image:alt" content="<?php echo $image_alt_text; ?>" />

    <!-- Schema.org JSON-LD Structured Data for Google Discover & NewsArticle -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "NewsArticle",
      "speakable": {
        "@type": "SpeakableSpecification",
        "cssSelector": ["h1", ".article-summary", ".lead", "article h2", "article p"]
      },
      "citation": "https://www.parselsorgu.net/api/2026-kadastro-endeks.json",
      "isBasedOn": "https://www.parselsorgu.net/2026-kadastro-insaat-referans-verileri",
      "mainEntityOfPage": {
        "@type": "WebPage",
        "@id": "<?php echo $canonical_url; ?>"
      },
      "headline": <?php echo json_encode(mb_substr($article['title'], 0, 110)); ?>,
      "description": <?php echo json_encode($article['summary']); ?>,
      "image": [
        "<?php echo $article_image_url; ?>"
      ],
      "datePublished": "<?php echo date('c', strtotime($article['date_published'] ?? '2026-10-20')); ?>",
      "dateModified": "<?php echo date('c', strtotime($article['date_published'] ?? '2026-10-30')); ?>",
      "author": {
        "@type": "Person",
        "name": "Harita Yük. Müh. Mustafa Ant",
        "jobTitle": "Baş Harita ve Kadastro Mühendisi",
        "url": "https://www.parselsorgu.net/yazarlar#mustafa-ant",
        "sameAs": "https://www.parselsorgu.net/yazarlar",
        "worksFor": {
          "@type": "Organization",
          "name": "Ant Harita Mühendislik Teknolojileri A.Ş.",
          "url": "https://www.parselsorgu.net/hakkimizda"
        }
      },
      "reviewedBy": {
        "@type": "Organization",
        "name": "ParselPro Mühendislik ve Mevzuat Denetim Kurulu",
        "url": "https://www.parselsorgu.net/muhendislik-kurulu"
      },
      "publisher": {
        "@type": "Organization",
        "name": "Ant Harita Parsel Pro",
        "logo": {
          "@type": "ImageObject",
          "url": "https://www.parselsorgu.net/assets/images/logo.png"
        }
      }
    }
    </script>
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "BreadcrumbList",
      "itemListElement": [
        {
          "@type": "ListItem",
          "position": 1,
          "name": "Ana Sayfa",
          "item": "https://www.parselsorgu.net"
        },
        {
          "@type": "ListItem",
          "position": 2,
          "name": "18. Madde İmar Rehberi",
          "item": "https://www.parselsorgu.net/makaleler"
        },
        {
          "@type": "ListItem",
          "position": 3,
          "name": <?php echo json_encode($article['city'] . " İmar"); ?>,
          "item": "<?php echo $canonical_url; ?>"
        }
      ]
    }
    </script>
    <?php endif; ?>

    <link rel="stylesheet" href="/assets/css/makale.css?v=2026.1">

    <?php
    $city_name = htmlspecialchars($article['city'] ?? 'Türkiye');
    $dist_name = htmlspecialchars($article['district'] ?? '');
    $loc_title = $dist_name ? "$city_name $dist_name" : $city_name;
    
    $faq_q1 = "$loc_title bölgesinde 3194 Sayılı Kanun 18. Madde imar uygulaması nasıl yapılır?";
    $faq_a1 = "$loc_title genelinde 18. Madde imar parselasyonu; yetkili serbest harita kadastro mühendislik büroları (SHKMMB) tarafından düzenleme sınırının tespiti, halihazır harita ve Netcad parselasyon çizimi, belediye encümeni onayı, 30 günlük askı ilanı, kadastro müdürlüğü kontrolü ve tapu müdürlüğünde müstakil imar parseli tescili adımlarıyla yürütülür.";
    
    $faq_q2 = "$loc_title için Düzenleme Ortaklık Payı (DOP) kesintisi en fazla ne kadardır?";
    $faq_a2 = "3194 Sayılı İmar Kanunu 18. Maddesi uyarınca DOP kesinti oranı yasal olarak en fazla %45 olabilir. Bu kesinti kamuya bedelsiz devredilen yol, çocuk bahçesi, yeşil alan, park, meydan ve kamu hizmet alanlarının oluşturulmasında kullanılır.";

    $faq_q3 = "$city_name genelinde 2026 yılı 1 m² bina ve konut inşaat yaklaşık maliyeti ne kadar?";
    $faq_a3 = "2026 Çevre, Şehircilik ve İklim Değişikliği Bakanlığı (ÇŞİDB) mahalli birim fiyatlarına göre $city_name ilinde 1. sınıf betonarme konut inşaat maliyeti ortalama 18.500 TL ile 24.500 TL/m² arasında; lüks müstakil villalarda ise 28.000 TL ile 38.000 TL/m² arasındadır. Parsel Pro hesaplayıcımız ile anlık metraj çıkartabilirsiniz.";

    $faq_q4 = "$loc_title ada parsel sorgulama ve aplikasyon krokisi nereden alınır?";
    $faq_a4 = "$loc_title ada ve parsel verilerini sitemiz üzerinden TKGM MEGSİS canlı uydu haritası ile anında ücretsiz sorgulayabilirsiniz. Aplikasyon krokisi ve yerinde sınır tespiti için Lisanslı Harita Kadastro Bürosu (LİHKAB) veya Ant Harita Mühendislik teknik destek ekibimiz ile 0542 841 35 35 üzerinden iletişime geçebilirsiniz.";
    ?>

    <!-- Google Rich Snippet FAQPage Schema.org -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "FAQPage",
      "mainEntity": [
        {
          "@type": "Question",
          "name": <?php echo json_encode($faq_q1); ?>,
          "acceptedAnswer": {
            "@type": "Answer",
            "text": <?php echo json_encode($faq_a1); ?>
          }
        },
        {
          "@type": "Question",
          "name": <?php echo json_encode($faq_q2); ?>,
          "acceptedAnswer": {
            "@type": "Answer",
            "text": <?php echo json_encode($faq_a2); ?>
          }
        },
        {
          "@type": "Question",
          "name": <?php echo json_encode($faq_q3); ?>,
          "acceptedAnswer": {
            "@type": "Answer",
            "text": <?php echo json_encode($faq_a3); ?>
          }
        },
        {
          "@type": "Question",
          "name": <?php echo json_encode($faq_q4); ?>,
          "acceptedAnswer": {
            "@type": "Answer",
            "text": <?php echo json_encode($faq_a4); ?>
          }
        }
      ]
    }
    </script>

    <!-- Microsoft Clarity -->
    <script type="text/javascript">
        (function(c,l,a,r,i,t,y){
            c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};
            t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i;
            y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y);
        })(window, document, "clarity", "script", "z46tj7yr8r");
    </script>

</head>
<body>

    <?php render_saas_navbar('makaleler'); ?>

    <div class="container">
        <?php if ($article): ?>
        <div class="article-card">
            <div class="breadcrumbs">
                <a href="https://www.parselsorgu.net">Ana Sayfa</a> &raquo;
                <a href="https://www.parselsorgu.net/makaleler">18. Madde İmar Rehberi</a> &raquo;
                <span><?php echo htmlspecialchars($article['city']); ?></span>
            </div>

            <h1><?php echo htmlspecialchars($article['title']); ?></h1>

            <div class="meta-bar">
                <span class="meta-badge">📍 <?php echo htmlspecialchars($article['city']); ?> / <?php echo htmlspecialchars($article['district']); ?></span>
                <span>📅 <?php echo htmlspecialchars($article['date_published'] ?? '2026-10-20'); ?></span>
                <span>⏱️ Okuma Süresi: <?php echo htmlspecialchars($article['read_time'] ?? '6 dk'); ?></span>
                <span>👁️ <?php echo intval($article['view_count']); ?> Görüntülenme</span>
                <span>✍️ <?php echo htmlspecialchars($article['author'] ?? 'Ant Harita'); ?></span>
            </div>

            <!-- SEO-Optimized Authoritative Featured Image -->
            <figure class="featured-image-container" style="margin: 22px 0 28px 0; border-radius: 10px; overflow: hidden; border: 1px solid var(--border); box-shadow: 0 10px 25px rgba(0,0,0,0.5); background:#050a15;">
                <img src="<?php echo htmlspecialchars($article_image_url); ?>" 
                     alt="<?php echo $image_alt_text; ?>" 
                     title="<?php echo htmlspecialchars($article['title']); ?>"
                     width="1200" height="630"
                     loading="eager" fetchpriority="high" decoding="async"
                     style="width: 100%; height: auto; display: block; object-fit: cover;" />
                <figcaption style="padding: 10px 14px; background: #080f1e; border-top: 1px solid #1e293b; color: #94a3b8; font-size: 12px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 8px;">
                    <span>📍 <strong><?php echo htmlspecialchars($article['city']); ?> / <?php echo htmlspecialchars($article['district']); ?></strong> - Sayısal İmar &amp; Harita Kadastro Mühendislik Paftası</span>
                    <span style="color: #38bdf8; font-weight: 600;">TKGM MEGSİS / ITRF96 Uyumlu</span>
                </figcaption>
            </figure>
            <!-- EDİTORYAL MÜHENDİSLİK & MEVZUAT DOĞRULAMA KÜNYESİ -->
            <div style="background:rgba(2, 132, 199, 0.08); border:1px solid rgba(56, 189, 248, 0.25); border-left:4px solid #0284c7; border-radius:10px; padding:12px 18px; margin:16px 0 24px 0; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px; font-size:12px;">
                <div style="display:flex; align-items:center; gap:10px; color:#e2e8f0;">
                    <i class="fa-solid fa-user-check" style="color:#10b981; font-size:18px;"></i>
                    <div>
                        <span style="font-weight:800; color:#ffffff;">Teknik &amp; Hukuki Doğrulama:</span>
                        <a href="/yazarlar#mustafa-ant" style="color:#38bdf8; text-decoration:none; font-weight:700;">Harita Yük. Müh. Mustafa Ant (HKMO Sicil: 12480)</a>
                        <span style="color:#64748b;"> &bull; </span>
                        <a href="/muhendislik-kurulu" style="color:#a78bfa; text-decoration:none; font-weight:700;">Mühendislik Kurulu Onaylı</a>
                    </div>
                </div>
                <div style="display:flex; align-items:center; gap:14px; font-size:11px; color:#94a3b8;">
                    <span><i class="fa-solid fa-scale-balanced" style="color:#f59e0b;"></i> 3194 / 5403 s.K. Uyumlu</span>
                    <span><i class="fa-solid fa-shield-halved" style="color:#38bdf8;"></i> 2026 Mevzuatı Güncel</span>
                </div>
            </div>


            <div class="article-body">
                <?php echo $article['content']; ?>

            <!-- 🔗 81 İL PARSEL SORGULAMA & CAD ENTEGRASYON KÖPRÜSÜ (PageRank Silo) -->
            <?php
            $art_city = !empty($article['city']) ? $article['city'] : 'Türkiye';
            $art_dist = !empty($article['district']) ? $article['district'] : '';
            $city_slug = function_exists('city_slugify') ? city_slugify($art_city) : strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', $art_city));
            $dist_slug = !empty($art_dist) ? (function_exists('city_slugify') ? city_slugify($art_dist) : strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', $art_dist))) : '';
            $hub_url = !empty($dist_slug) ? "/sehir/{$city_slug}/{$dist_slug}" : "/sehir/{$city_slug}";
            ?>
            <div style="background:linear-gradient(135deg, rgba(2,132,199,0.08) 0%, rgba(15,23,42,0.95) 100%); border:2px solid #0284c7; border-radius:12px; padding:20px; margin:28px 0; box-shadow:0 6px 25px rgba(2,132,199,0.15);">
                <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;">
                    <div>
                        <div style="display:flex; align-items:center; gap:8px; margin-bottom:4px;">
                            <span style="background:#0284c7; color:#fff; font-size:10px; font-weight:bold; padding:2px 7px; border-radius:4px;">CANLI KADASTRO HARİTASI</span>
                            <span style="color:#38bdf8; font-size:11px; font-weight:bold;">TKGM MEGSİS Sayısal Doğrulama</span>
                        
            <!-- 🌟 PARSEL 360° CANLI SORGULAMA KOKPİT ÇAĞRISI (YÜKSEK DÖNÜŞÜM) -->
            <div style="background:linear-gradient(135deg, #091322 0%, #0f2744 100%); border:2px solid #0284c7; border-radius:16px; padding:24px 28px; margin:32px 0; color:#ffffff; box-shadow:0 10px 30px rgba(2, 132, 199, 0.25);">
                <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:16px;">
                    <div>
                        <span style="background:#0284c7; color:#fff; font-size:11px; font-weight:900; padding:3px 10px; border-radius:6px; letter-spacing:0.5px;">
                            <i class="fa-solid fa-compass-drafting"></i> PARSEL 360° CANLI ANALİZ
                        </span>
                        <h3 style="font-size:18px; font-weight:900; color:#ffffff; margin:8px 0 4px 0;">
                            Sizin de Bu Konuda Bir Arsanız veya Parseliniz mi Var?
                        </h3>
                        <p style="font-size:13px; color:#94a3b8; margin:0; line-height:1.5; max-width:620px;">
                            Bu rehberde anlatılan imar kısıtlarını, yapılaşma kapasitesini ve yaklaşık inşaat maliyetini kendi parselinizin koordinatlarıyla anında ücretsiz simüle edin.
                        </p>
                    </div>
                    <div>
                        <a href="/parsel" style="background:linear-gradient(135deg, #0284c7 0%, #0369a1 100%); color:#ffffff; font-weight:800; font-size:13.5px; padding:12px 24px; border-radius:10px; text-decoration:none; display:inline-flex; align-items:center; gap:8px; box-shadow:0 4px 15px rgba(2, 132, 199, 0.4); white-space:nowrap;">
                            <i class="fa-solid fa-map-location-dot"></i>
                            <span>Parseli 360° Haritada İncele</span>
                        </a>
                    </div>
                </div>
            </div>
</div>
                        <h4 style="margin:0; font-size:16px; font-weight:800; color:#fff;">
                            📍 <?php echo htmlspecialchars($art_city . (!empty($art_dist) ? " / {$art_dist}" : "")); ?> Canlı Parsel &amp; İmar Sorgulama
                        </h4>
                        <p style="margin:6px 0 0 0; font-size:12.5px; color:#cbd5e1; line-height:1.5;">
                            Bu inceleme konusu bölgedeki tüm ada/parsel sınırlarını, 3D uydu haritasını ve 2026 ÇŞİDB yapılaşma koşullarını canlı haritada sorgulayın.
                        </p>
                    </div>
                    <div>
                        <a href="<?php echo $hub_url; ?>" style="background:linear-gradient(135deg, #0284c7 0%, #2563eb 100%); color:#fff; font-weight:bold; font-size:13px; padding:10px 18px; border-radius:6px; text-decoration:none; display:inline-flex; align-items:center; gap:6px; box-shadow:0 4px 12px rgba(2,132,199,0.35);">
                            <i class="fa-solid fa-map-location-dot"></i> Parseli Canlı Haritada Aç &raquo;
                        </a>
                    </div>
                </div>
            </div>


            </div>

            <!-- Share Buttons -->
            
            <!-- ⚖️ RESMÎ MÜHENDİSLİK ÖN BİLGİLENDİRME VE YASAL UYARI KÜNYESİ -->
            <div style="background:rgba(239,68,68,0.06); border:1px dashed rgba(239,68,68,0.35); border-left:4px solid #ef4444; border-radius:10px; padding:14px 18px; margin:24px 0; font-size:12px; color:#cbd5e1; line-height:1.6;">
                <div style="display:flex; align-items:center; gap:8px; margin-bottom:6px; color:#ef4444; font-weight:800; font-size:13px;">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <span>TMMOB HKMO MÜHENDİSLİK ÖN BİLGİLENDİRME UYARISI</span>
                </div>
                Bu teknik rehber ve makalede yer alan mevzuat analizleri, TAKS/KAKS, ifraz, 18. madde DOP, tapu harcı ve maliyet hesapları 3194 Sayılı İmar Kanunu ve ilgili yönetmelikler çerçevesinde genel ön bilgilendirme amacıyla hazırlanmıştır. Her arsa ve parselin zemin yapısı, çekme mesafesi, belediye imar plan notları ve kadastral sınırları farklılık gösterir. Taşınmaz alım-satımı, yapı ruhsatı veya ifraz öncesinde yetkili belediye imar müdürlüğü ile <strong>TMMOB Harita ve Kadastro Mühendisleri Odası (HKMO) tescilli lisanslı serbest harita mühendisinden</strong> yerinde resmi aplikasyon ve imar durumu alınması yasal zorunluluktur.
            </div>

            <div class="share-box">
                <span style="font-size:12px; font-weight:bold; color:#cbd5e1;">Bu Makaleyi Paylaş:</span>
                <a href="https://api.whatsapp.com/send?text=<?php echo urlencode($article['title'] . ' ' . $canonical_url); ?>" target="_blank" class="share-btn wa-btn">🟢 WhatsApp</a>
                <a href="https://t.me/share/url?url=<?php echo urlencode($canonical_url); ?>&text=<?php echo urlencode($article['title']); ?>" target="_blank" class="share-btn tg-btn">🔵 Telegram</a>
                <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode($canonical_url); ?>&text=<?php echo urlencode($article['title']); ?>&hashtags=parselsorgu,imar,18madde" target="_blank" class="share-btn x-btn">🐦 X (Twitter)</a>
                <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo urlencode($canonical_url); ?>" target="_blank" class="share-btn in-btn">💼 LinkedIn</a>
            </div>

            <!-- Citation & Organic Backlink Generator -->
            <div style="background:#0a1220; border:1px solid #1e3a5f; border-radius:8px; padding:16px; margin-top:20px;">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px; flex-wrap:wrap; gap:8px;">
                    <div style="font-size:12.5px; font-weight:bold; color:var(--accent-cyan); display:flex; align-items:center; gap:6px;">
                        <span>📚 Bu Makaleyi Sitenizde veya Raporunuzda Kaynak Gösterin:</span>
                    </div>
                    <button onclick="copyCitationCode()" id="btn-cite" style="background:#0284c7; color:#fff; border:none; padding:5px 12px; border-radius:4px; font-size:11px; font-weight:bold; cursor:pointer;">📋 Alıntı / Backlink Kodunu Kopyala</button>
                </div>
                <p style="font-size:11.5px; color:#94a3b8; margin-bottom:8px; line-height:1.4;">
                    Emlak ilanınızda, kurumsal blogunuzda veya sektör raporunuzda bu teknik makaleden alıntı yaparken aşağıdaki HTML kodunu sitenize doğrudan ekleyebilirsiniz:
                </p>
                <textarea id="citation-code" readonly style="width:100%; height:52px; background:#040812; border:1px solid #334155; color:#4ade80; font-family:monospace; font-size:11px; padding:8px; border-radius:4px; resize:none;"><p>Kaynak: <a href="<?php echo $canonical_url; ?>" target="_blank" rel="follow">Ant Harita Parsel Pro - <?php echo htmlspecialchars($article['title']); ?></a></p></textarea>
            </div>

            
            <!-- 🤖 AKILLI OTONOM İMAR & HUKUK BOTLARI ENTEGRASYONU (65.000 MAKALE İÇ SEO SİLOSU) -->
            <?php
            $art_text_lower = mb_strtolower(($article['title'] ?? '') . ' ' . ($article['summary'] ?? '') . ' ' . ($article['category'] ?? ''));

            $matched_bots = [];
            if (strpos($art_text_lower, 'köy') !== false || strpos($art_text_lower, 'plansız') !== false) {
                $matched_bots[] = ['slug' => 'koy-evi-imar', 'title' => 'Köyde Ev Yapma İzni & 5.000 m² Testi', 'icon' => '🏡', 'badge' => 'Plansız Alanlar', 'desc' => '5.000 m² kuralı ve kadastro yolu zorunluluğu testi'];
            }
            if (strpos($art_text_lower, 'miras') !== false || strpos($art_text_lower, 'intikal') !== false || strpos($art_text_lower, '5403') !== false) {
                $matched_bots[] = ['slug' => 'miras-tarla-5403', 'title' => '5403 Miras Kalan Tarla İntikal & Paylaşım', 'icon' => '🌾', 'badge' => 'Ehil Mirasçı', 'desc' => 'Asgari tarımsal arazi büyüklüğü ve tek mülkiyet çözümü'];
            }
            if (strpos($art_text_lower, 'kat karşılığı') !== false || strpos($art_text_lower, 'müteahhit') !== false || strpos($art_text_lower, 'inşaat') !== false) {
                $matched_bots[] = ['slug' => 'kat-karsiligi-oran', 'title' => 'Kat Karşılığı İnşaat Oranı & Daire Paylaşımı', 'icon' => '🏢', 'badge' => '% Oran Hesabı', 'desc' => 'Arsa sahibi ve müteahhit adil daire paylaşım oranı'];
            }
            if (strpos($art_text_lower, '18') !== false || strpos($art_text_lower, 'dop') !== false || strpos($art_text_lower, 'parselasyon') !== false) {
                $matched_bots[] = ['slug' => 'madde-18-dop', 'title' => '3194 s.K. 18. Madde DOP Kesintisi Botu', 'icon' => '📐', 'badge' => 'Maks %45', 'desc' => 'Parselasyon yol ve donatı terk oranı simülasyonu'];
            }
            if (strpos($art_text_lower, 'ifraz') !== false || strpos($art_text_lower, 'bölünme') !== false || strpos($art_text_lower, 'tarla') !== false) {
                $matched_bots[] = ['slug' => 'tarla-ifraz-bolunme', 'title' => 'Otomatik Tarla İfraz & Bölünme Şartları', 'icon' => '🚜', 'badge' => 'İfraz Şartı', 'desc' => 'Tarım arazisi bölünebilir mi? İl bazlı asgari büyüklükler'];
            }
            if (strpos($art_text_lower, 'tiny') !== false || strpos($art_text_lower, 'prefabrik') !== false) {
                $matched_bots[] = ['slug' => 'tiny-house-imar', 'title' => 'Tiny House & Prefabrik İmar Riski Testi', 'icon' => '🏠', 'badge' => 'Yıkım Riski', 'desc' => 'Plaka, ruhsat ve 3194 s.K. para cezası risk analizi'];
            }

            // Standart en popüler botlar
            $default_bots = [
                ['slug' => 'google-news-imar-aski', 'title' => 'Google News Canlı İmar & Askı İlanı Botu', 'icon' => '📰', 'badge' => '30 Gün İtiraz', 'desc' => 'Belediyelerin 1/1000 ve 1/5000 askı ilanları ve meclis kararları'],
                ['slug' => 'koy-evi-imar', 'title' => 'Köyde Ev Yapma İzni & Plansız Alanlar Botu', 'icon' => '🏡', 'badge' => 'Köy İçi / Dışı', 'desc' => '5.000 m² ve kadastro yolu şartı taban oturumu hesabı'],
                ['slug' => 'tapu-harci-hesaplama', 'title' => '2026 Tapu Harcı (%4) & Döner Sermaye', 'icon' => '📑', 'badge' => 'Net Masraf', 'desc' => 'Alıcı/Satıcı tapu masrafları ve 2026 döner sermaye bedeli'],
                ['slug' => 'belediye-rayic-bedel', 'title' => '2026 Belediye Rayiç Bedel & Emlak Vergisi', 'icon' => '🏛️', 'badge' => 'Rayiç Bedel', 'desc' => 'Cadde/Sokak asgari metrekare rayiç ve 1.-2. taksit hesabı'],
                ['slug' => 'kat-karsiligi-oran', 'title' => 'Kat Karşılığı İnşaat Oranı & Paylaşım', 'icon' => '🏢', 'badge' => 'Müteahhit Payı', 'desc' => 'Bölgeye göre arsa sahibi ve müteahhit yüzde dağılımı'],
                ['slug' => 'izale-i-suyu', 'title' => 'İzale-i Şüyu (Ortaklığın Giderilmesi) Botu', 'icon' => '⚖️', 'badge' => 'İhale Risk', 'desc' => 'Hisseli arsanın icra yoluyla e-satış risk ve masraf hesabı']
            ];

            $recommended_bots = [];
            $seen_slugs = [];
            foreach (array_merge($matched_bots, $default_bots) as $b_item) {
                if (!isset($seen_slugs[$b_item['slug']])) {
                    $seen_slugs[$b_item['slug']] = true;
                    $recommended_bots[] = $b_item;
                }
                if (count($recommended_bots) >= 6) break;
            }
            ?>
            <div class="bots-interlink-box" style="margin:28px 0; background:linear-gradient(135deg, #091322 0%, #030712 100%); border:1px solid #1e3a5f; border-radius:14px; padding:22px; box-shadow:0 10px 30px rgba(0,0,0,0.6);">
                <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px; margin-bottom:16px;">
                    <div style="display:flex; align-items:center; gap:8px;">
                        <span style="font-size:22px;">🤖</span>
                        <div>
                            <h3 style="color:#38bdf8; font-size:17px; font-weight:800; margin:0;">
                                Otonom İmar & Gayrimenkul Hukuku Botları
                            </h3>
                            <p style="color:#94a3b8; font-size:12px; margin:2px 0 0 0;">
                                <?php echo htmlspecialchars($article['city']); ?> bölgesindeki taşınmazınız için anında canlı test yapın
                            </p>
                        </div>
                    </div>
                    <a href="https://www.parselsorgu.net" target="_blank" style="color:#facc15; font-size:12px; text-decoration:none; font-weight:700;">
                        Tüm 20 Botu İncele &rarr;
                    </a>
                </div>

                <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(280px, 1fr)); gap:12px;">
                    <?php foreach ($recommended_bots as $r_bot): ?>
                    <a href="https://www.parselsorgu.net/bot/<?php echo $r_bot['slug']; ?>" target="_blank" 
                       style="text-decoration:none; background:#0d1829; border:1px solid #1e293b; border-radius:10px; padding:14px; display:flex; flex-direction:column; justify-content:space-between; transition:all 0.2s ease;"
                       onmouseover="this.style.borderColor='#38bdf8'; this.style.transform='translateY(-2px)';" 
                       onmouseout="this.style.borderColor='#1e293b'; this.style.transform='none';">
                        <div>
                            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
                                <span style="font-size:20px;"><?php echo $r_bot['icon']; ?></span>
                                <span style="font-size:10.5px; background:rgba(56,189,248,0.15); color:#38bdf8; padding:2px 7px; border-radius:4px; font-weight:700;">
                                    <?php echo $r_bot['badge']; ?>
                                </span>
                            </div>
                            <h4 style="color:#f8fafc; font-size:13px; font-weight:700; margin:0 0 4px 0; line-height:1.4;">
                                <?php echo $r_bot['title']; ?>
                            </h4>
                            <p style="color:#94a3b8; font-size:11.5px; margin:0; line-height:1.4;">
                                <?php echo $r_bot['desc']; ?>
                            </p>
                        </div>
                        <div style="margin-top:10px; padding-top:8px; border-top:1px dashed #1e293b; display:flex; justify-content:space-between; align-items:center;">
                            <span style="color:#38bdf8; font-size:11.5px; font-weight:700;">Anında Hesapla &rarr;</span>
                            <span style="color:#4ade80; font-size:10.5px; font-weight:600;">⚡ Canlı Otonom</span>
                        </div>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- 💬 RESMİ HARİTA MÜHENDİSİ WHATSAPP DANIŞMA & TEKLİF HATTI (HOT LEAD MAGNET) -->
            <?php
            $wa_msg = urlencode("Merhaba Ant Harita Mühendislik, " . ($article['city'] ?? '') . " " . ($article['district'] ?? '') . " bölgesindeki taşınmazım için resmi harita, imar ve aplikasyon danışmanlığı almak istiyorum: " . $canonical_url);
            ?>
            <div class="wa-consult-card" style="margin:26px 0; background:linear-gradient(135deg, rgba(34,197,94,0.15) 0%, rgba(15,23,42,0.98) 100%); border:2px solid #22c55e; border-radius:14px; padding:20px 24px; box-shadow:0 10px 30px rgba(34,197,94,0.22);">
                <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:16px;">
                    <div style="max-width:560px;">
                        <div style="display:inline-flex; align-items:center; gap:6px; background:rgba(34,197,94,0.2); color:#4ade80; font-size:11px; font-weight:800; padding:4px 10px; border-radius:20px; margin-bottom:8px;">
                            <span style="display:inline-block; width:8px; height:8px; border-radius:50%; background:#22c55e; box-shadow:0 0 10px #22c55e;"></span>
                            <span>ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ &bull; RESMİ DESTEK</span>
                        </div>
                        <h3 style="color:#ffffff; font-size:18px; font-weight:800; margin:0 0 6px 0;">
                            Bu Parsel İçin Resmi Harita Kadastro Raporu ve Teklif Alın
                        </h3>
                        <p style="color:#cbd5e1; font-size:13px; margin:0; line-height:1.5;">
                            <?php echo htmlspecialchars(($article['city'] ?? '') . ' / ' . ($article['district'] ?? '')); ?> bölgesindeki arsanız için <strong>aplikasyon krokisi, sınır tespiti, kazık çakımı, cins değişikliği</strong> ve imar durumu danışmanlığı almak için harita mühendisimizle hemen görüşün.
                        </p>
                    </div>
                    <div>
                        <a href="https://wa.me/905428413535?text=<?php echo $wa_msg; ?>" 
                           target="_blank" rel="noopener noreferrer"
                           style="display:inline-flex; align-items:center; gap:10px; background:#22c55e; color:#000; font-weight:800; font-size:13.5px; padding:13px 22px; border-radius:12px; text-decoration:none; box-shadow:0 6px 20px rgba(34,197,94,0.4); transition:all 0.2s;"
                           onmouseover="this.style.background='#16a34a'; this.style.transform='scale(1.03)';" 
                           onmouseout="this.style.background='#22c55e'; this.style.transform='none';">
                            <span style="font-size:20px;">💬</span>
                            <span>WhatsApp ile Mühendise Danış</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Call to Action -->
            <div class="cta-box">
                <h3 style="color:#facc15; font-size:18px; margin-bottom:8px;">Arsanızın İmar Durumunu ve Canlı Uydu Sınırlarını İnceleyin</h3>
                <p style="font-size:13px; color:#cbd5e1;">81 ilde TKGM MEGSİS uyumlu canlı uydu haritası, köşe noktası koordinat düzenleme ve 360° sanal drone çekimi için:</p>
                <a href="https://www.parselsorgu.net" class="cta-btn">🚀 Canlı Parsel Sorgulamayı Başlat (Ücretsiz)</a>
            </div>

            
            <!-- FAQ Accordion Section (Google Rich Snippet Boost) -->
            <div class="faq-container-box" style="margin-top:32px; background:#0a1220; border:1px solid #1e3a5f; border-radius:10px; padding:20px;">
                <div style="display:flex; align-items:center; gap:8px; margin-bottom:14px;">
                    <span style="font-size:20px;">❓</span>
                    <h3 style="color:#facc15; font-size:17px; margin:0; font-weight:800;">
                        <?php echo $loc_title; ?> İmar, Kadastro ve İnşaat Sıkça Sorulan Sorular (SSS)
                    </h3>
                </div>
                
                <details style="background:#0e1a2f; border:1px solid #1e293b; border-radius:6px; margin-bottom:10px; padding:12px 16px;">
                    <summary style="color:#38bdf8; font-weight:700; font-size:13.5px; cursor:pointer;">
                        1. <?php echo $faq_q1; ?>
                    </summary>
                    <p class="faq-answer" style="color:#cbd5e1; font-size:12.5px; margin-top:10px; line-height:1.6;">
                        <?php echo $faq_a1; ?>
                    </p>
                </details>

                <details style="background:#0e1a2f; border:1px solid #1e293b; border-radius:6px; margin-bottom:10px; padding:12px 16px;">
                    <summary style="color:#38bdf8; font-weight:700; font-size:13.5px; cursor:pointer;">
                        2. <?php echo $faq_q2; ?>
                    </summary>
                    <p class="faq-answer" style="color:#cbd5e1; font-size:12.5px; margin-top:10px; line-height:1.6;">
                        <?php echo $faq_a2; ?>
                    </p>
                </details>

                <details style="background:#0e1a2f; border:1px solid #1e293b; border-radius:6px; margin-bottom:10px; padding:12px 16px;">
                    <summary style="color:#38bdf8; font-weight:700; font-size:13.5px; cursor:pointer;">
                        3. <?php echo $faq_q3; ?>
                    </summary>
                    <p class="faq-answer" style="color:#cbd5e1; font-size:12.5px; margin-top:10px; line-height:1.6;">
                        <?php echo $faq_a3; ?>
                    </p>
                </details>

                <details style="background:#0e1a2f; border:1px solid #1e293b; border-radius:6px; margin-bottom:10px; padding:12px 16px;">
                    <summary style="color:#38bdf8; font-weight:700; font-size:13.5px; cursor:pointer;">
                        4. <?php echo $faq_q4; ?>
                    </summary>
                    <p class="faq-answer" style="color:#cbd5e1; font-size:12.5px; margin-top:10px; line-height:1.6;">
                        <?php echo $faq_a4; ?>
                    </p>
                </details>
            </div>

            <!-- SEO SILO INTERNAL LINKING & COMMUNITY HUBS -->
            <?php
            $tr_slug_map = ['Ç'=>'c','ç'=>'c','Ğ'=>'g','ğ'=>'g','İ'=>'i','I'=>'i','ı'=>'i','i'=>'i','Ö'=>'o','ö'=>'o','Ş'=>'s','ş'=>'s','Ü'=>'u','ü'=>'u'];
            $art_city_slug = trim(preg_replace('/[^a-z0-9\-]+/', '-', mb_strtolower(strtr((string)($article['city'] ?? ''), $tr_slug_map), 'UTF-8')), '-');
            $art_dist_slug = trim(preg_replace('/[^a-z0-9\-]+/', '-', mb_strtolower(strtr((string)($article['district'] ?? ''), $tr_slug_map), 'UTF-8')), '-');
            $silo_hub_url = 'https://www.parselsorgu.net/parsel-sorgu'
                . ($art_city_slug ? '/' . $art_city_slug : '')
                . (($art_city_slug && $art_dist_slug && $art_dist_slug !== 'merkez-ilce') ? '/' . $art_dist_slug : '');
            $silo_hub_label = trim(($article['city'] ?? '') . (!empty($article['district']) ? ' ' . $article['district'] : '')) . ' Parsel Sorgulama';
            ?>
            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); gap:12px; margin-top:20px;">
                <a href="<?php echo htmlspecialchars($silo_hub_url); ?>" style="background:#08211d; border:1px solid #14b8a6; color:#2dd4bf; padding:12px 14px; border-radius:8px; font-size:12.5px; font-weight:bold; display:flex; align-items:center; gap:8px; text-decoration:none;">
                    <span>🗺️</span> <span><?php echo htmlspecialchars($silo_hub_label); ?></span>
                </a>
                <a href="https://www.parselsorgu.net/imar-durumu-sorgulama" style="background:#0c1e35; border:1px solid #0284c7; color:#38bdf8; padding:12px 14px; border-radius:8px; font-size:12.5px; font-weight:bold; display:flex; align-items:center; gap:8px; text-decoration:none;">
                    <span>📐</span> <span>E-İmar &amp; İmar Durumu Sorgula</span>
                </a>
                <a href="https://www.parselsorgu.net/tapu-harci-hesaplama" style="background:#1e1b4b; border:1px solid #6366f1; color:#a5b4fc; padding:12px 14px; border-radius:8px; font-size:12.5px; font-weight:bold; display:flex; align-items:center; gap:8px; text-decoration:none;">
                    <span>🏛️</span> <span>2026 Tapu Harcı Hesaplama</span>
                </a>
                <a href="https://www.parselsorgu.net/arsa-insaat-maliyeti" style="background:#261d07; border:1px solid #ca8a04; color:#facc15; padding:12px 14px; border-radius:8px; font-size:12.5px; font-weight:bold; display:flex; align-items:center; gap:8px; text-decoration:none;">
                    <span>⚡</span> <span>2026 İnşaat Maliyeti Hesapla</span>
                </a>
            </div>

            <!-- RESMİ OTORİTE KAYNAK DOĞRULAMASI (E-E-A-T TRUST SIGNALS) -->
            <div style="margin-top:16px; background:#080d1a; border:1px dashed #1e3a5f; border-radius:8px; padding:12px 16px; display:flex; flex-wrap:wrap; align-items:center; justify-content:space-between; gap:10px; font-size:12px; color:#94a3b8;">
                <div style="display:flex; align-items:center; gap:6px;">
                    <span>🏛️</span>
                    <span>Resmi Mevzuat ve Kadastro Doğrulama Kaynakları:</span>
                </div>
                <div style="display:flex; gap:12px; flex-wrap:wrap;">
                    <a href="https://www.tkgm.gov.tr/" target="_blank" rel="noopener noreferrer" style="color:#38bdf8; text-decoration:none;">Tapu ve Kadastro (TKGM)</a>
                    <a href="https://www.csb.gov.tr/" target="_blank" rel="noopener noreferrer" style="color:#38bdf8; text-decoration:none;">Çevre, Şehircilik ve İklim Bakanlığı</a>
                    <a href="https://www.mevzuat.gov.tr/mevzuat?MevzuatNo=3194&MevzuatTur=1&MevzuatTertip=5" target="_blank" rel="noopener noreferrer" style="color:#38bdf8; text-decoration:none;">3194 Sayılı İmar Kanunu</a>
                    <a href="https://www.hkmo.org.tr/" target="_blank" rel="noopener noreferrer" style="color:#38bdf8; text-decoration:none;">TMMOB HKMO</a>
                </div>
            </div>

                        <!-- YMYL & E-E-A-T Author Card -->
            <div style="background:linear-gradient(135deg, #0b1329 0%, #070d1a 100%); border:1px solid #1e293b; border-radius:14px; padding:24px; margin:32px 0; display:flex; gap:20px; align-items:center; flex-wrap:wrap;">
                <div style="width:68px; height:68px; border-radius:14px; background:rgba(2,132,199,0.18); border:2px solid #0284c7; display:flex; align-items:center; justify-content:center; font-size:28px; color:#38bdf8; flex-shrink:0;">
                    <i class="fa-solid fa-user-check"></i>
                </div>
                <div style="flex:1; min-width:260px;">
                    <div style="font-size:12px; color:#10b981; font-weight:800; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:4px;">
                        <i class="fa-solid fa-stamp"></i> TMMOB HKMO Tescilli İçerik Sahibi &amp; Baş Mühendis
                    </div>
                    <h3 style="font-size:17px; font-weight:800; color:#fff; margin-bottom:4px;">
                        <a href="/yazarlar#mustafa-ant" style="color:#fff; text-decoration:none;">Harita Yük. Müh. Mustafa Ant</a>
                    </h3>
                    <p style="font-size:13px; color:#cbd5e1; line-height:1.55; margin-bottom:10px;">
                        İTÜ Geomatik Mühendisliği mezunudur. TMMOB HKMO (Sicil: 12480) ve LİHKAB (Lisans: 06-042) akreditasyonuna sahiptir. Bu teknik rehber, 3194 Sayılı İmar Kanunu ve 2026 Resmî Gazete tebliğleri doğrultusunda incelenip onaylanmıştır.
                    </p>
                    <div style="display:flex; gap:14px; font-size:12.5px; flex-wrap:wrap;">
                        <a href="/yazarlar" style="color:#38bdf8; text-decoration:none; font-weight:700;"><i class="fa-solid fa-users"></i> Tüm Yazarlarımız</a>
                        <a href="/muhendislik-kurulu" style="color:#a78bfa; text-decoration:none; font-weight:700;"><i class="fa-solid fa-award"></i> Mühendislik Denetim Protokolü</a>
                        <a href="/hakkimizda" style="color:#34d399; text-decoration:none; font-weight:700;"><i class="fa-solid fa-building-columns"></i> Kurumsal &amp; Sicil</a>
                    </div>
                </div>
            </div>

            <?php if (!empty($related_articles)): ?>
            <!-- Google & Yandex Deep Internal Linking Mesh -->
            <div class="related-section" style="margin-top: 36px; padding-top: 24px; border-top: 1px solid var(--border);">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px; flex-wrap:wrap; gap:8px;">
                    <h3 style="color: var(--accent-cyan); font-size: 18px; margin:0;">
                        🔍 İlgili <?php echo htmlspecialchars($article['city']); ?> İmar & Kadastro Rehberleri
                    </h3>
                    <a href="https://www.parselsorgu.net/makaleler" style="color:var(--accent-yellow); font-size:12px; text-decoration:none; font-weight:bold;">Tüm 81 İl Rehberleri &rarr;</a>
                </div>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 14px;">
                    <?php foreach ($related_articles as $rel): ?>
                    <a href="makale/<?php echo urlencode($rel['slug']); ?>" style="text-decoration:none; background:#0c1322; border:1px solid #1e293b; border-radius:8px; padding:14px; display:flex; flex-direction:column; justify-content:space-between; transition: all 0.2s ease;">
                        <div>
                            <div style="display:flex; justify-content:space-between; margin-bottom:6px;">
                                <span style="font-size:10px; background:rgba(56,189,248,0.15); color:#38bdf8; padding:2px 6px; border-radius:4px; font-weight:700;">
                                    <?php echo htmlspecialchars($rel['category'] ?: 'İmar Rehberi'); ?>
                                </span>
                                <span style="font-size:10px; color:#94a3b8;">📍 <?php echo htmlspecialchars($rel['district'] ?? $rel['city']); ?></span>
                            </div>
                            <h4 style="color:#f8fafc; font-size:13.5px; margin:4px 0 6px; line-height:1.4; font-weight:700;">
                                <?php echo htmlspecialchars($rel['title']); ?>
                            </h4>
                            <p style="color:#94a3b8; font-size:11.5px; line-height:1.4; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;">
                                <?php echo htmlspecialchars($rel['summary']); ?>
                            </p>
                        </div>
                        <div style="margin-top:10px; font-size:11px; color:#38bdf8; font-weight:600; display:flex; justify-content:space-between; border-top:1px dashed #1e293b; padding-top:6px;">
                            <span>Rehberi Oku &rarr;</span>
                            <span style="color:#64748b;">⏱️ <?php echo htmlspecialchars($rel['read_time'] ?: '5 dk'); ?></span>
                        </div>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <?php else: ?>
        <div class="article-card" style="text-align:center; padding:60px 20px;">
            <h1 style="color:#ef4444;">404 - Makale Bulunamadı</h1>
            <p style="color:#94a3b8; margin:16px 0;">Aradığınız makale yayından kaldırılmış veya bağlantı adresi değişmiş olabilir.</p>
            <a href="https://www.parselsorgu.net" class="cta-btn">Ana Sayfaya Dön</a>
        </div>
        <?php endif; ?>
    </div>

    <footer style="background:#030712; border-top:1px solid #1e293b; padding:28px 20px; text-align:center; font-size:12.5px; color:#64748b;">
        <div style="max-width:1140px; margin:0 auto; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;">
            <div>&copy; 2026 Ant Harita Mühendislik Teknolojileri A.Ş. &bull; TMMOB HKMO Oda Sicil: 12480 &bull; ParselPro İmar &amp; Kadastro Rehberi</div>
            <div style="display:flex; gap:14px; flex-wrap:wrap;">
                <a href="/hakkimizda" style="color:#94a3b8; text-decoration:none;">Hakkımızda</a>
                <a href="/yazarlar" style="color:#94a3b8; text-decoration:none;">Yazarlar</a>
                <a href="/muhendislik-kurulu" style="color:#94a3b8; text-decoration:none;">Mühendislik Kurulu</a>
                <a href="/basin-kiti" style="color:#94a3b8; text-decoration:none;">Basın Kiti</a>
                <a href="/llms.txt" style="color:#38bdf8; text-decoration:none;">llms.txt</a>
            </div>
        </div>
    </footer>

    <script>
        function copyCitationCode() {
            var ta = document.getElementById('citation-code');
            if (ta) {
                ta.select();
                document.execCommand('copy');
                var btn = document.getElementById('btn-cite');
                if (btn) {
                    btn.innerText = '✅ Kopyalandı!';
                    setTimeout(function() { btn.innerText = '📋 Alıntı / Backlink Kodunu Kopyala'; }, 2500);
                }
            }
        }
    </script>
    <!-- Real-Time Web Analytics Engine -->
    <script src="analytics.js" defer></script>
</body>
</html>
