<?php
// ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ - PARSEL PRO
// Google Trends & Canlı Türkiye Gündemi Portalı (gundem.php)
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/trends_bot_engine.php';
require_once __DIR__ . '/navbar.php';

// OTOMATİK HER SAAT YENİ TRENDLERİ ÇEK & YAYINLA
if ($pdo) {
    check_and_run_hourly_trends($pdo);
}

$slug = trim($_GET['slug'] ?? '');
$is_single = !empty($slug);
$article = null;

if ($is_single && $pdo) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM gundem_articles WHERE slug = ? OR id = ? LIMIT 1");
        $stmt->execute([$slug, $slug]);
        $article = $stmt->fetch();
        if ($article) {
            $pdo->prepare("UPDATE gundem_articles SET view_count = view_count + 1 WHERE id = ?")->execute([$article['id']]);
        }
    } catch (Exception $e) {}
}

// Fetch list of trends
$articles_list = [];
if ($pdo) {
    try {
        $stmt_list = $pdo->query("SELECT id, trend_keyword, slug, title, summary, approx_traffic, view_count, date_published FROM gundem_articles ORDER BY id DESC LIMIT 30");
        $articles_list = $stmt_list->fetchAll();
    } catch (Exception $e) {}
}

$page_title = $is_single && $article ? htmlspecialchars($article['title']) . " | ParselSorgu Gündem" : "Türkiye Canlı Gündem ve Trend Analizleri | ParselSorgu";
$meta_desc = $is_single && $article ? htmlspecialchars($article['summary']) : "Google Trends Türkiye'de en çok aratılan yükselişteki konular, canlı analizler, son dakika gelişmeleri ve yapay zeka gündem raporları.";
$og_url = $is_single && $article ? "https://www.parselsorgu.net/gundem/" . htmlspecialchars($article['slug']) : "https://www.parselsorgu.net/gundem";
$og_image = $is_single && $article && !empty($article['image_url']) ? $article['image_url'] : "https://www.parselsorgu.net/assets/images/og-parsel.jpg";
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <meta name="description" content="<?php echo $meta_desc; ?>">
    <link rel="canonical" href="<?php echo $og_url; ?>">
    <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large">
    <link rel="icon" href="https://www.parselsorgu.net/favicon.ico">
    <meta property="og:title" content="<?php echo $page_title; ?>">
    <meta property="og:description" content="<?php echo $meta_desc; ?>">
    <meta property="og:url" content="<?php echo $og_url; ?>">
    <meta property="og:image" content="<?php echo $og_image; ?>">
    <meta name="twitter:card" content="summary_large_image">
    <link rel="stylesheet" href="/assets/css/main.css?v=2026.1">
    <style>
        body { background:#090e17; color:#f8fafc; font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,sans-serif; margin:0; padding:0; }
        .gundem-container { max-width:1150px; margin:0 auto; padding:20px; }
        .gundem-header { background:linear-gradient(135deg, #1e1b4b 0%, #0f172a 100%); border:1px solid #3b82f6; border-radius:12px; padding:30px 24px; margin-bottom:30px; text-align:center; box-shadow:0 0 30px rgba(59,130,246,0.25); }
        .gundem-grid { display:grid; grid-template-columns:repeat(auto-fit, minmax(320px, 1fr)); gap:20px; }
        .gundem-card { background:#0f172a; border:1px solid #1e293b; border-radius:10px; padding:20px; transition:all 0.25s ease; display:flex; flex-direction:column; justify-content:space-between; }
        .gundem-card:hover { transform:translateY(-4px); border-color:#38bdf8; box-shadow:0 12px 25px rgba(0,0,0,0.5); }
        .gundem-badge { background:#dc2626; color:#fff; font-size:11px; font-weight:bold; padding:3px 8px; border-radius:4px; }
        .gundem-traffic { background:#0284c7; color:#fff; font-size:11px; font-weight:800; padding:3px 8px; border-radius:4px; }
        .article-rich-content { background:#0f172a; border:1px solid #1e293b; border-radius:12px; padding:30px; line-height:1.8; font-size:15px; color:#cbd5e1; }
        .article-rich-content h2 { color:#38bdf8; font-size:20px; margin-top:30px; border-bottom:1px solid #334155; padding-bottom:8px; }
        .nav-back-btn { background:#1e293b; color:#fff; padding:8px 16px; border-radius:6px; text-decoration:none; font-size:13px; font-weight:bold; display:inline-flex; align-items:center; gap:6px; margin-bottom:20px; }
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

    <!-- Schema.org Structured Data -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@graph": [
        {
          "@type": "CollectionPage",
          "@id": "https://www.parselsorgu.net/gundem#webpage",
          "name": "Türkiye Google Trends & Canlı İmar Gündemi",
          "url": "https://www.parselsorgu.net/gundem",
          "description": "Google Trends Türkiye'de en çok aratılan gayrimenkul, tapu, kadastro ve imar gündemi son dakika gelişmeleri."
        },
        {
          "@type": "BreadcrumbList",
          "itemListElement": [
            { "@type": "ListItem", "position": 1, "name": "Ana Sayfa", "item": "https://www.parselsorgu.net/" },
            { "@type": "ListItem", "position": 2, "name": "Gündem", "item": "https://www.parselsorgu.net/gundem" }
          ]
        }
      ]
    }
    </script>
</head>
<body>

    <?php render_saas_navbar('gundem'); ?>

    <div class="gundem-container">

        <?php if ($is_single && $article): ?>
            <!-- TEKİL MAKALE GÖRÜNÜMÜ -->
            <a href="/gundem" class="nav-back-btn">&larr; Tüm Gündem Haberlerine Dön</a>
            
            <div style="margin-bottom:24px;">
                <div style="display:flex; gap:8px; align-items:center; margin-bottom:10px;">
                    <span class="gundem-badge">🔥 GOOGLE TRENDS</span>
                    <span class="gundem-traffic">📈 <?php echo htmlspecialchars($article['approx_traffic'] ?? '1000+'); ?> Arama</span>
                    <span style="color:#94a3b8; font-size:12px;"><?php echo htmlspecialchars($article['date_published'] ?? date('Y-m-d')); ?></span>
                </div>
                <h1 style="color:#fff; font-size:28px; font-weight:900; line-height:1.3; margin:0 0 14px 0;"><?php echo htmlspecialchars($article['title']); ?></h1>
            </div>

            <?php echo $article['content']; ?>

        <?php else: ?>
            <!-- GÜNDEM ANASAYFA / LİSTELEME -->
            <div class="gundem-header">
                <div style="display:inline-flex; align-items:center; gap:8px; background:rgba(220,38,38,0.2); border:1px solid #dc2626; color:#f87171; font-size:12px; font-weight:bold; padding:4px 12px; border-radius:20px; margin-bottom:12px;">
                    <span style="display:inline-block; width:8px; height:8px; background:#ef4444; border-radius:50%; box-shadow:0 0 8px #ef4444;"></span>
                    CANLI GOOGLE TRENDS TR ENTEGRASYONU
                </div>
                <h1 style="color:#fff; font-size:30px; font-weight:900; margin:0 0 10px 0;">Türkiye Gündemi &amp; Yükselen Trendler</h1>
                <p style="color:#94a3b8; font-size:14px; max-width:750px; margin:0 auto;">
                    Google Trends Türkiye'de en çok aratılan konular yapay zeka analiz motorumuz tarafından anlık taranarak özel teknik özetler ve görsellerle yayına alınır.
                </p>
            </div>

            <div class="gundem-grid">
                <?php if (empty($articles_list)): ?>
                    <div style="grid-column:1/-1; text-align:center; padding:40px; background:#0f172a; border-radius:8px; color:#94a3b8;">
                        Henüz yayınlanmış gündem maddesi bulunmuyor. Admin panelinden <b>Google Trends Botu</b>'nu çalıştırabilirsiniz.
                    </div>
                <?php else: ?>
                    <?php foreach ($articles_list as $item): ?>
                        <div class="gundem-card">
                            <div>
                                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
                                    <span class="gundem-traffic">🔥 <?php echo htmlspecialchars($item['approx_traffic']); ?> Arama</span>
                                    <span style="color:#64748b; font-size:11.5px;"><?php echo htmlspecialchars($item['date_published']); ?></span>
                                </div>
                                <h3 style="color:#fff; font-size:16px; font-weight:800; line-height:1.4; margin:0 0 10px 0;">
                                    <a href="/gundem/<?php echo htmlspecialchars($item['slug']); ?>" style="color:#fff; text-decoration:none;"><?php echo htmlspecialchars($item['title']); ?></a>
                                </h3>
                                <p style="color:#94a3b8; font-size:13px; line-height:1.5; margin:0 0 14px 0;">
                                    <?php echo htmlspecialchars(mb_substr($item['summary'], 0, 140)) . '...'; ?>
                                </p>
                            </div>
                            <div>
                                <a href="/gundem/<?php echo htmlspecialchars($item['slug']); ?>" style="display:block; text-align:center; background:#1e293b; color:#38bdf8; font-weight:bold; font-size:12.5px; padding:9px 12px; border-radius:6px; text-decoration:none; border:1px solid #334155;">
                                    Yapay Zeka Analizini Oku &rarr;
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>

    </div>

    <!-- FOOTER -->
    <footer style="background:#050914; border-top:1px solid #1e293b; padding:24px 20px; text-align:center; margin-top:50px; font-size:12.5px; color:#64748b;">
        <p style="margin:0 0 6px 0;">&copy; 2026 ParselSorgu.net &bull; Google Trends AI Robotu ile Güçlendirilmiştir.</p>
        <p style="margin:0;"><a href="https://www.parselsorgu.net/" style="color:#38bdf8; text-decoration:none;">Ana Sayfa</a> &bull; <a href="/bulten" style="color:#38bdf8; text-decoration:none;">HKMO Bülten</a> &bull; <a href="/makaleler" style="color:#38bdf8; text-decoration:none;">İmar Rehberi</a></p>
    </footer>

    <!-- Real-Time Web Analytics Engine -->
    <script src="/analytics.js" defer></script>
</body>
</html>
