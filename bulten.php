<?php
// ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ - PARSEL PRO
// bulten.php: HKMO Resmî Haber & Mesleki Duyuru Bülteni Portalı & Detay Sayfası
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/hkmo_seo_engine.php';
require_once __DIR__ . '/auto_ping_helper.php';
require_once __DIR__ . '/navbar.php';

$slug = $_GET['slug'] ?? '';
$slug = trim($slug);

// ID veya slug ayrıştırması
$news_id = 0;
if (preg_match('/-(\d+)$/', $slug, $matches)) {
    $news_id = intval($matches[1]);
} elseif (is_numeric($slug)) {
    $news_id = intval($slug);
}

// Tüm haberleri çekme (Önbellekten veya Canlı HKMO API'den)
$cache_file = __DIR__ . '/data/hkmo_news_cache.json';
$all_news = [];
$cache_time = 1800;

if (file_exists($cache_file)) {
    $cached = json_decode(file_get_contents($cache_file), true);
    if (!empty($cached['items'])) {
        $all_news = $cached['items'];
    }
}

if (empty($all_news) || (file_exists($cache_file) && (time() - filemtime($cache_file) > $cache_time))) {
    $apiUrl = "https://api.hkmo.org.tr/web/categories/1?take=50";
    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 8);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36',
        'Origin: https://www.hkmo.org.tr',
        'Referer: https://www.hkmo.org.tr/'
    ]);
    $resp = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($http_code === 200 && !empty($resp)) {
        $parsed = json_decode($resp, true);
        $raw_items = $parsed['data'] ?? [];
        $fresh_items = [];
        foreach ($raw_items as $item) {
            $rawTitle = trim($item['title'] ?? '');
            $cat = $item['category'] ?? 'Gündem & Duyuru';
            $seoTitle = class_exists('HkmoSeoEngine') ? HkmoSeoEngine::createUniqueTitle($rawTitle, $cat) : $rawTitle;
            $itemSlug = class_exists('HkmoSeoEngine') ? HkmoSeoEngine::slugify($rawTitle . '-' . ($item['id'] ?? 0)) : ($item['slug'] ?? '');
            $internalUrl = 'https://www.parselsorgu.net/bulten/' . $itemSlug;

            $fresh_items[] = [
                'id' => $item['id'] ?? 0,
                'title' => $rawTitle,
                'seo_title' => $seoTitle,
                'slug' => $itemSlug,
                'category' => $cat,
                'date' => $item['published_at'] ?? date('d.m.Y'),
                'body_clean' => $item['body_clean'] ?? $item['body'] ?? '',
                'summary' => mb_substr(strip_tags($item['body_clean'] ?? $item['body'] ?? ''), 0, 220) . '...',
                'image' => $item['image'] ?? 'https://api.hkmo.org.tr/media/news/default.jpg',
                'internal_url' => $internalUrl,
                'official_url' => 'https://www.hkmo.org.tr/haberler/detay/' . ($item['id'] ?? '')
            ];
        }
        if (!empty($fresh_items)) {
            $all_news = $fresh_items;
            @file_put_contents($cache_file, json_encode([
                'status' => 'success',
                'source' => 'TMMOB Harita ve Kadastro Mühendisleri Odası Resmî API',
                'count' => count($all_news),
                'updated_at' => date('d.m.Y H:i'),
                'items' => $all_news
            ], JSON_UNESCAPED_UNICODE));
        }
    }
}

// -------------------------------------------------------------
// SENARYO A: SLUG BOŞSA -> /bulten ANA BÜLTEN LİSTE PORTALI
// -------------------------------------------------------------
if (empty($slug)) {
    $page_title = "HKMO Resmî Haber ve Duyuru Bülteni | ParselSorgu";
    $meta_desc = "TMMOB Harita ve Kadastro Mühendisleri Odası (HKMO) canlı bülteni: mesleki duyurular, mevzuat değişiklikleri ve imar analizleri.";
    $canonical_url = "https://www.parselsorgu.net/bulten";

    // Google & Bing Ping
    @triggerAutoSearchPing($canonical_url, $page_title);
    ?>
    <!DOCTYPE html>
    <html lang="tr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= htmlspecialchars($page_title) ?></title>
        <meta name="description" content="<?= htmlspecialchars($meta_desc) ?>">
        <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
        <link rel="canonical" href="<?= $canonical_url ?>">

        <!-- Open Graph / Facebook -->
        <meta property="og:locale" content="tr_TR">
        <meta property="og:type" content="website">
        <meta property="og:title" content="<?= htmlspecialchars($page_title) ?>">
        <meta property="og:description" content="<?= htmlspecialchars($meta_desc) ?>">
        <meta property="og:url" content="<?= $canonical_url ?>">
        <meta property="og:site_name" content="Parsel Pro - Harita Kadastro Teknolojileri">
        <meta property="og:image" content="https://www.parselsorgu.net/assets/images/og-parsel.jpg">

        <!-- Twitter -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="<?= htmlspecialchars($page_title) ?>">
        <meta name="twitter:description" content="<?= htmlspecialchars($meta_desc) ?>">
        <meta name="twitter:image" content="https://www.parselsorgu.net/assets/images/og-parsel.jpg">

        <!-- Structured Data: CollectionPage & Breadcrumb -->
        <script type="application/ld+json">
        {
          "@context": "https://schema.org",
          "@type": "CollectionPage",
          "name": "TMMOB HKMO Resmî Haber ve Mesleki Duyuru Bülteni",
          "description": <?= json_encode($meta_desc) ?>,
          "url": "https://www.parselsorgu.net/bulten",
          "publisher": {
            "@type": "Organization",
            "name": "Parsel Pro Harita Kadastro Teknolojileri",
            "url": "https://www.parselsorgu.net"
          }
        }
        </script>

        <link rel="stylesheet" href="/assets/css/style.css">
        <style>
            body { background:#090d16; color:#f8fafc; font-family:-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; margin:0; padding:0; }
            .portal-container { max-width:1200px; margin:0 auto; padding:24px 16px 80px 16px; }
            .hero-banner { background:linear-gradient(135deg, rgba(239,68,68,0.18) 0%, rgba(15,23,42,0.95) 100%); border:2px solid #ef4444; border-radius:12px; padding:28px 24px; margin-bottom:30px; box-shadow:0 10px 30px rgba(239,68,68,0.15); }
            .badge-live { background:#ef4444; color:#fff; font-size:11.5px; font-weight:800; padding:4px 10px; border-radius:4px; letter-spacing:0.5px; }
            .news-grid { display:grid; grid-template-columns:repeat(auto-fill, minmax(350px, 1fr)); gap:20px; }
            .news-card { background:#0f172a; border:1px solid #1e293b; border-radius:10px; overflow:hidden; display:flex; flex-direction:column; justify-content:space-between; transition:transform 0.2s, border-color 0.2s, box-shadow 0.2s; }
            .news-card:hover { transform:translateY(-4px); border-color:#38bdf8; box-shadow:0 8px 25px rgba(56,189,248,0.15); }
            .news-img-wrap { position:relative; width:100%; height:190px; background:#090d16; overflow:hidden; }
            .news-img-wrap img { width:100%; height:100%; object-fit:cover; transition:transform 0.3s; }
            .news-card:hover .news-img-wrap img { transform:scale(1.04); }
            .cat-tag { position:absolute; top:10px; left:10px; background:rgba(239,68,68,0.92); color:#fff; font-size:11px; font-weight:800; padding:3px 8px; border-radius:4px; }
            .date-tag { position:absolute; bottom:10px; right:10px; background:rgba(15,23,42,0.88); backdrop-filter:blur(4px); color:#cbd5e1; font-size:10.5px; font-weight:bold; padding:3px 8px; border-radius:4px; }
            .card-body { padding:18px; }
            .card-footer { padding:12px 18px; background:rgba(0,0,0,0.25); border-top:1px solid rgba(255,255,255,0.06); display:flex; justify-content:space-between; align-items:center; }
            .btn-read { background:linear-gradient(135deg, #0284c7, #2563eb); color:#fff; text-decoration:none; font-size:12px; font-weight:bold; padding:7px 14px; border-radius:5px; transition:opacity 0.2s; }
            .btn-read:hover { opacity:0.9; }
            .nav-link-top { color:#cbd5e1; text-decoration:none; font-size:13px; font-weight:600; padding:6px 12px; border-radius:4px; transition:background 0.2s; }
            .nav-link-top:hover { background:#1e293b; color:#fff; }
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

    <link rel="alternate" type="text/markdown" href="https://www.parselsorgu.net/llms.txt" title="ParselSorgu AI / LLM Bilgi Bankası">
    <link rel="alternate" type="application/json" href="https://www.parselsorgu.net/api/2026-kadastro-endeks.json" title="2026 Kadastro ve İmar Açık Veri Seti">
    <script type="application/ld+json">{"@context": "https://schema.org", "@type": "WebPage", "speakable": {"@type": "SpeakableSpecification", "cssSelector": ["h1", ".lead", ".summary-box", ".hero-desc", "main p"]}, "isBasedOn": "https://www.parselsorgu.net/api/2026-kadastro-endeks.json", "publisher": {"@type": "Organization", "name": "Ant Harita Mühendislik - ParselSorgu.net", "url": "https://www.parselsorgu.net/"}}</script>
</head>
    <body>

        <?php render_saas_navbar('bulten'); ?>

        <main class="portal-container">
            <!-- Hero Banner -->
            <section class="hero-banner">
                <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:14px;">
                    <div>
                        <div style="display:flex; align-items:center; gap:10px; margin-bottom:8px;">
                            <span class="badge-live">CANLI ENTEGRASYON</span>
                            <span style="color:#facc15; font-size:13px; font-weight:bold;">TMMOB Harita ve Kadastro Mühendisleri Odası Resmî API</span>
                        </div>
                        <h1 style="font-size:26px; font-weight:900; color:#fff; margin:0 0 8px 0;">
                            HKMO Resmî Haberler &amp; Mesleki Duyurular
                        </h1>
                        <p style="font-size:14px; color:#cbd5e1; margin:0; max-width:850px; line-height:1.5;">
                            TMMOB Harita ve Kadastro Mühendisleri Odası Genel Merkezi ve şubelerinin yayımladığı tüm resmî duyurular, kongre ilanları, mevzuat değişiklikleri ve mesleki gelişmeler anlık olarak burada listelenir.
                        </p>
                    </div>
                    <div style="display:flex; gap:10px; align-items:center;">
                        <a href="https://www.hkmo.org.tr" target="_blank" rel="noopener nofollow" style="background:#1e293b; border:1px solid #334155; color:#cbd5e1; text-decoration:none; font-size:12px; padding:10px 16px; border-radius:6px; font-weight:bold;">
                            🏛️ hkmo.org.tr Resmî Site ↗
                        </a>
                        <a href="/sitemap-bulten.xml" target="_blank" style="background:#0369a1; border:1px solid #0284c7; color:#fff; text-decoration:none; font-size:12px; padding:10px 16px; border-radius:6px; font-weight:bold;">
                            📡 RSS / XML Akışı
                        </a>
                    </div>
                </div>
            </section>

            <!-- News Grid -->
            <section>
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
                    <h2 style="font-size:18px; font-weight:800; color:#f1f5f9; margin:0;">
                        Son Yayınlanan Resmî HKMO Bültenleri (<?= count($all_news) ?> Kayıt)
                    </h2>
                    <span style="font-size:12px; color:#94a3b8;">Otomatik 30 dk aralıklarla güncellenir</span>
                </div>

                <div class="news-grid">
                    <?php if (!empty($all_news)): ?>
                        <?php foreach ($all_news as $item): ?>
                            <?php
                            $imgSrc = !empty($item['image']) && strpos($item['image'], 'http') === 0 ? $item['image'] : 'https://api.hkmo.org.tr/media/news/2026/10/105757/dbf57d632e1c84416d609d55d30c005f.jpg';
                            $articleUrl = !empty($item['internal_url']) ? $item['internal_url'] : ('/bulten/' . ($item['slug'] ?? $item['id']));
                            $displayTitle = !empty($item['seo_title']) ? $item['seo_title'] : $item['title'];
                            ?>
                            <article class="news-card">
                                <div>
                                    <div class="news-img-wrap">
                                        <a href="<?= htmlspecialchars($articleUrl) ?>">
                                            <img src="<?= htmlspecialchars($imgSrc) ?>" alt="<?= htmlspecialchars($displayTitle) ?>" loading="lazy" onerror="this.src='https://api.hkmo.org.tr/assets/favicon-a8ddd60f.ico'; this.style.objectFit='contain';">
                                        </a>
                                        <span class="cat-tag"><?= htmlspecialchars($item['category'] ?? 'HKMO') ?></span>
                                        <span class="date-tag">📅 <?= htmlspecialchars($item['date'] ?? 'Güncel') ?></span>
                                    </div>
                                    <div class="card-body">
                                        <span style="display:inline-block; font-size:10px; color:#38bdf8; font-weight:800; margin-bottom:6px; text-transform:uppercase; letter-spacing:0.5px;">⭐ Özgün Teknik Analiz & Mevzuat</span>
                                        <h3 style="font-size:15px; font-weight:800; color:#f8fafc; line-height:1.4; margin:0 0 10px 0;">
                                            <a href="<?= htmlspecialchars($articleUrl) ?>" style="color:#f8fafc; text-decoration:none;">
                                                <?= htmlspecialchars($displayTitle) ?>
                                            </a>
                                        </h3>
                                        <p style="font-size:12.5px; color:#94a3b8; line-height:1.5; margin:0;">
                                            <?= htmlspecialchars($item['summary']) ?>
                                        </p>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <a href="<?= htmlspecialchars($item['official_url']) ?>" target="_blank" rel="noopener nofollow" style="font-size:11px; color:#94a3b8; text-decoration:underline;">
                                        🏛️ Resmî Kaynak
                                    </a>
                                    <a href="<?= htmlspecialchars($articleUrl) ?>" class="btn-read">
                                        Detaylı Analizi Oku &raquo;
                                    </a>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div style="grid-column:1/-1; padding:40px; text-align:center; color:#94a3b8;">
                            Bülten kayıtları yükleniyor...
                        </div>
                    <?php endif; ?>
                </div>
            </section>

            <!-- Bottom CTA -->
            <section style="background:linear-gradient(135deg, #0284c7 0%, #2563eb 100%); border-radius:12px; padding:32px; color:#fff; margin-top:50px; text-align:center;">
                <h3 style="margin:0 0 10px 0; font-size:22px; font-weight:900;">🌍 3 Boyutlu Kadastro & Parsel Haritasını Deneyin</h3>
                <p style="margin:0 auto; max-width:680px; font-size:14px; opacity:0.95; line-height:1.6;">
                    Türkiye'deki tüm il, ilçe ve mahallelerde resmi ada/parsel koordinatlarını, 4K perspektifli 3B drone uçuş simülasyonunu ve e-plan imar durumunu ücretsiz sorgulayın.
                </p>
                <a href="/" style="display:inline-block; background:#facc15; color:#0f172a; font-weight:900; padding:12px 28px; border-radius:6px; text-decoration:none; margin-top:16px; font-size:15px; box-shadow:0 4px 15px rgba(250,204,21,0.4);">
                    🚀 Canlı 3B Parsel Sorgula
                </a>
            </section>
        </main>

        <footer style="background:#090d16; border-top:1px solid #1e293b; padding:28px 16px; text-align:center; color:#64748b; font-size:12.5px;">
            <p style="margin:0;">© <?= date('Y') ?> Parsel Pro - Harita Kadastro Mühendislik Teknolojileri. Tüm hakları saklıdır.</p>
            <p style="margin:6px 0 0 0;">Kaynak Veri: TMMOB Harita ve Kadastro Mühendisleri Odası Resmî API Entegrasyonu.</p>
        </footer>

        <!-- Real-Time Web Analytics Engine -->
    <script src="/analytics.js" defer></script>
</body>
    </html>
    <?php
    exit;
}

// -------------------------------------------------------------
// SENARYO B: SLUG DOLUYSA -> ÖZGÜN TEKNİK MAKALE DETAY SAYFASI
// -------------------------------------------------------------
$article_raw = null;
if (!empty($all_news)) {
    foreach ($all_news as $it) {
        if ($news_id && ($it['id'] == $news_id)) {
            $article_raw = $it;
            break;
        } elseif (!empty($it['slug']) && (strpos($slug, $it['slug']) !== false || $slug === $it['slug'])) {
            $article_raw = $it;
            break;
        }
    }
}

// Bulunamadıysa varsayılan son haber
if (!$article_raw) {
    $article_raw = [
        'id' => 105757,
        'title' => '2026 UNECE WPLA & FIG Uluslararası Konferans Programı Yayımlandı',
        'slug' => '2026-unece-wpla-fig-uluslararasi-konferans-programi-yayimlandi-105757',
        'category' => 'Uluslararası Etkinlik',
        'date' => '16.10.2026',
        'body_clean' => 'TMMOB Harita ve Kadastro Mühendisleri Odası ev sahipliğinde, FIG ve UNECE iş birliğiyle 2026 yılı uluslararası arazi yönetimi ve kadastro konferansı gerçekleştirilecektir.',
        'image' => 'https://api.hkmo.org.tr/media/news/2026/10/105757/dbf57d632e1c84416d609d55d30c005f.jpg',
        'official_url' => 'https://www.hkmo.org.tr/haberler/detay/105757'
    ];
}

$seoData = HkmoSeoEngine::generateUniqueArticle($article_raw);

$page_title = htmlspecialchars($seoData['seo_title']) . " | Parsel Pro";
$meta_desc = htmlspecialchars($seoData['meta_description']);
$canonical_url = "https://www.parselsorgu.net/bulten/" . HkmoSeoEngine::slugify($article_raw['title'] . '-' . $article_raw['id']);
$cover_image = !empty($article_raw['image']) ? $article_raw['image'] : 'https://www.parselsorgu.net/assets/img/og-preview.jpg';

// Otomatik Google & Bing Arama Motoru Pingi
if (!empty($canonical_url)) {
    @triggerAutoSearchPing($canonical_url, $seoData['seo_title']);
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?></title>
    <meta name="description" content="<?= $meta_desc ?>">
    <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
    <link rel="canonical" href="<?= $canonical_url ?>">

    <!-- Open Graph & Twitter Cards -->
    <meta property="og:locale" content="tr_TR">
    <meta property="og:type" content="article">
    <meta property="og:title" content="<?= $page_title ?>">
    <meta property="og:description" content="<?= $meta_desc ?>">
    <meta property="og:url" content="<?= $canonical_url ?>">
    <meta property="og:site_name" content="Parsel Pro - Harita & Kadastro">
    <meta property="og:image" content="<?= htmlspecialchars($cover_image) ?>">
    <meta property="article:published_time" content="<?= date('c', strtotime($article_raw['date'] ?? 'now')) ?>">
    <meta property="article:section" content="Harita ve Kadastro Mühendisliği">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= $page_title ?>">
    <meta name="twitter:description" content="<?= $meta_desc ?>">
    <meta name="twitter:image" content="<?= htmlspecialchars($cover_image) ?>">

    <!-- Google Structured Data: NewsArticle Schema -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "NewsArticle",
      "headline": <?= json_encode($seoData['seo_title']) ?>,
      "description": <?= json_encode($seoData['meta_description']) ?>,
      "image": [<?= json_encode($cover_image) ?>],
      "datePublished": <?= json_encode(date('c', strtotime($article_raw['date'] ?? 'now'))) ?>,
      "dateModified": <?= json_encode(date('c')) ?>,
      "author": {
        "@type": "Organization",
        "name": "Ant Harita Mühendislik & Kadastro Uzmanları",
        "url": "https://www.parselsorgu.net"
      },
      "publisher": {
        "@type": "Organization",
        "name": "Parsel Pro Harita Kadastro Teknolojileri",
        "logo": {
          "@type": "ImageObject",
          "url": "https://www.parselsorgu.net/assets/img/logo.png"
        }
      },
      "mainEntityOfPage": {
        "@type": "WebPage",
        "@id": <?= json_encode($canonical_url) ?>
      }
    }
    </script>

    <!-- FAQ Page Schema -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "FAQPage",
      "mainEntity": [
        {
          "@type": "Question",
          "name": "Bu HKMO bülteni kimleri doğrudan ilgilendiriyor?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Harita ve Kadastro Mühendisleri, Şehir Plancıları, Gayrimenkul Değerleme Uzmanları ve mülk sahiplerini doğrudan ilgilendirmektedir."
          }
        },
        {
          "@type": "Question",
          "name": "Parsel sorgulama ve tapu işlemlerine etkisi nedir?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "HKMO tarafından alınan kararlar ve yayınlanan kılavuzlar, arazi ölçümlerinin hassasiyetini ve tapu müdürlüklerindeki tescil süreçlerinin güvenilirliğini pekiştirir."
          }
        }
      ]
    }
    </script>

    <link rel="stylesheet" href="/assets/css/style.css">
    <style>
        body { background:#090d16; color:#f8fafc; font-family:-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; margin:0; padding:0; }
        .bulten-container { max-width:980px; margin:0 auto; padding:24px 16px 80px 16px; }
        .bulten-header { margin-bottom:24px; }
        .bulten-card { background:#0f172a; border:1px solid #1e293b; border-radius:12px; padding:28px; box-shadow:0 10px 30px rgba(0,0,0,0.4); }
        .breadcrumb { font-size:12px; color:#94a3b8; margin-bottom:14px; display:flex; gap:6px; align-items:center; flex-wrap:wrap; }
        .breadcrumb a { color:#38bdf8; text-decoration:none; }
        .breadcrumb a:hover { text-decoration:underline; }
        .badge-bulten { background:#ef4444; color:#fff; font-size:11px; font-weight:800; padding:3px 10px; border-radius:4px; text-transform:uppercase; letter-spacing:0.5px; }
        .img-hero-box { width:100%; max-height:420px; overflow:hidden; border-radius:8px; margin-bottom:24px; background:#000; position:relative; }
        .img-hero-box img { width:100%; height:auto; max-height:420px; object-fit:cover; display:block; }
        .nav-back { display:inline-flex; align-items:center; gap:6px; background:#1e293b; color:#cbd5e1; padding:8px 16px; border-radius:6px; text-decoration:none; font-size:13px; font-weight:600; margin-bottom:20px; border:1px solid #334155; }
        .nav-back:hover { background:#334155; color:#fff; }
        .cta-box { background:linear-gradient(135deg, #0284c7 0%, #2563eb 100%); border-radius:10px; padding:24px; color:#fff; margin-top:36px; text-align:center; }
        .cta-btn { display:inline-block; background:#facc15; color:#0f172a; font-weight:800; padding:12px 24px; border-radius:6px; text-decoration:none; margin-top:14px; font-size:14.5px; box-shadow:0 4px 15px rgba(250,204,21,0.4); }
        .cta-btn:hover { background:#fde047; }
    </style>
</head>
<body>

    <?php render_saas_navbar('bulten'); ?>

    <main class="bulten-container">
        <!-- Breadcrumb -->
        <nav class="breadcrumb" aria-label="Breadcrumb">
            <a href="/">Ana Sayfa</a> <span>/</span>
            <a href="/bulten">HKMO Haber Bülteni</a> <span>/</span>
            <span style="color:#cbd5e1;"><?= htmlspecialchars(mb_substr($article_raw['title'], 0, 40)) ?>...</span>
        </nav>

        <a href="/bulten" class="nav-back">← HKMO Bülten Listesine Dön</a>

        <article class="bulten-card">
            <div class="bulten-header">
                <div style="display:flex; gap:10px; align-items:center; margin-bottom:12px; flex-wrap:wrap;">
                    <span class="badge-bulten">Resmî Bülten & Teknik Analiz</span>
                    <span style="background:#0369a1; color:#e0f2fe; font-size:11.5px; padding:2px 8px; border-radius:4px; font-weight:bold;">
                        <?= htmlspecialchars($article_raw['category']) ?>
                    </span>
                    <time datetime="<?= date('Y-m-d', strtotime($article_raw['date'] ?? 'now')) ?>" style="color:#94a3b8; font-size:12.5px;">
                        📅 <?= htmlspecialchars($article_raw['date']) ?>
                    </time>
                </div>

                <h1 style="font-size:25px; font-weight:900; line-height:1.35; color:#fff; margin:0 0 14px 0;">
                    <?= htmlspecialchars($seoData['seo_title']) ?>
                </h1>

                <p style="font-size:15px; color:#94a3b8; line-height:1.6; margin:0;">
                    <?= htmlspecialchars($seoData['meta_description']) ?>
                </p>
            </div>

            <?php if (!empty($cover_image)): ?>
            <div class="img-hero-box">
                <img src="<?= htmlspecialchars($cover_image) ?>" alt="<?= htmlspecialchars($article_raw['title']) ?>" loading="eager">
            </div>
            <?php endif; ?>

            <div class="article-content">
                <?= $seoData['html_content'] ?>
            </div>

            <div class="cta-box">
                <h3 style="margin:0 0 8px 0; font-size:20px; font-weight:800;">🌍 Kendi Parselinizi 3B Drone ve Uydu ile Hemen İnceleyin</h3>
                <p style="margin:0 auto; max-width:620px; font-size:13.5px; opacity:0.95; line-height:1.5;">
                    Türkiye genelindeki 81 il ve 973 ilçede resmi ada/parsel sınırlarını, 4K perspektifli 3 boyutlu drone simülasyonunu ve kadastro uydu haritasını anında ücretsiz görüntüleyin.
                </p>
                <a href="/" class="cta-btn">🚀 Ücretsiz 3D Parsel Sorgula</a>
            </div>
        </article>
    </main>

    <footer style="background:#090d16; border-top:1px solid #1e293b; padding:24px; text-align:center; color:#64748b; font-size:12px;">
        <p style="margin:0;">© <?= date('Y') ?> Parsel Pro - Harita Kadastro Mühendislik Teknolojileri. Tüm hakları saklıdır.</p>
        <p style="margin:6px 0 0 0;">Kaynak Veri: TMMOB Harita ve Kadastro Mühendisleri Odası Resmî API Entegrasyonu.</p>
    </footer>

</body>
</html>
