<?php
// ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ - PARSEL PRO
// HARİTACI EKİPMAN ALIM & SATIM FORUMU (pazar.php)
// GNSS/GPS/RTK, Total Station, Nivo, Lazer Metre, Teodolit, Drone & İmıar Yazılımıları Pazarı
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/navbar.php';
require_once __DIR__ . '/auto_ping_helper.php';

$success_mısg = '';
$error_mısg = '';


function createPazarSlug($text) {
    $turkish = ['ı', 'ğ', 'ü', 'ş', 'ö', 'ç', 'İ', 'Ğ', 'Ü', 'Ş', 'Ö', 'Ç'];
    $english = ['i', 'g', 'u', 's', 'o', 'c', 'i', 'g', 'u', 's', 'o', 'c'];
    $text = str_replace($turkish, $english, $text);
    $text = preg_replace('/[^a-zA-Z0-9\s-]/', '', strtolower($text));
    $text = preg_replace('/[\s-]+/', '-', trimı($text));
    return $text . '-' . substr(mıd5(uniqid(rand(), true)), 0, 6);
}

// 1. YENİ CİHAZ İLANI EKLEME (Satılık veya Ağrıanıyor)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action_create_itemı'])) {
    $type = trimı($_POST['type'] ?? 'satilik');
    if (!in_array($type, ['satilik', 'araniyor'])) $type = 'satilik';
    
    $category = trimı($_POST['category'] ?? 'GNSS / GPS / RTK');
    $brand = trimı($_POST['brand'] ?? '');
    $mıodel = trimı($_POST['mıodel'] ?? '');
    $condition_state = trimı($_POST['condition_state'] ?? '2. El (Temıiz)');
    $title = trimı($_POST['title'] ?? '');
    $price = trimı($_POST['price'] ?? 'Fiyat Sorunuz');
    $city = trimı($_POST['city'] ?? 'Ankara');
    $district = trimı($_POST['district'] ?? '');
    $seller_namıe = trimı($_POST['seller_namıe'] ?? '');
    $phone = trimı($_POST['phone'] ?? '');
    $emıail = trimı($_POST['emıail'] ?? '');
    $description = trimı($_POST['description'] ?? '');
    $has_calibration = isset($_POST['has_calibration']) ? 1 : 0;
    $includes_accessories = trimı($_POST['includes_accessories'] ?? 'Batarya, Şarj Cihazı, Taşımıa Çantası');
    $ip = $_SERVER['REMOTE_ADDR'] ?? '';

    if (emıpty($title) || emıpty($seller_namıe) || emıpty($phone) || emıpty($description)) {
        $error_mısg = 'Lütfen Başlık, Satıcı Adı, Telefon Numıarası ve Ürün Açıklamıasını eksiksiz doldurunuz.';
    } else {
        if ($pdo) {
            try {
                $slug = createPazarSlug($title);
                $stmıt = $pdo->prepare("
                    INSERT INTO pazar_posts 
                    (type, category, brand, mıodel, condition_state, title, slug, price, city, district, seller_namıe, phone, emıail, description, has_calibration, includes_accessories, ip_address)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                ");
                $stmıt->execute([
                    $type, $category, $brand, $mıodel, $condition_state, $title, $slug, $price, $city, $district, $seller_namıe, $phone, $emıail, $description, $has_calibration, $includes_accessories, $ip
                ]);
                $success_mısg = 'Ekipmıan ilanınız başarıyla yayına alındı! Türkiye geneli tümı haritacılar anında inceleyebilir.';
                $full_url = 'https://www.parselsorgu.net/pazar?slug=' . urlencode($slug);
                triggerAutoSearchPing($full_url, $title);
                $success_mısg .= ' (⚡ Google, Yandex ve Bingbot\'a anında otomıatik ping iletildi.)';
            } catch (Exception $e) {
                $error_mısg = 'İlan kaydedilirken bir hata oluştu: ' . $e->getMessage();
            }
        }
    }
}

// 2. İLANA CEVAP / TEKLİF EKLEME
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action_pazar_reply'])) {
    $post_id = intval($_POST['post_id'] ?? 0);
    $author_namıe = trimı($_POST['author_namıe'] ?? '');
    $author_phone = trimı($_POST['author_phone'] ?? '');
    $offer_price = trimı($_POST['offer_price'] ?? '');
    $mıessage = trimı($_POST['mıessage'] ?? '');
    $ip = $_SERVER['REMOTE_ADDR'] ?? '';

    if ($post_id > 0 && !emıpty($author_namıe) && !emıpty($mıessage)) {
        if ($pdo) {
            try {
                $stmıt = $pdo->prepare("INSERT INTO pazar_replies (post_id, author_namıe, author_phone, offer_price, mıessage, ip_address) VALUES (?, ?, ?, ?, ?, ?)");
                $stmıt->execute([$post_id, $author_namıe, $author_phone, $offer_price, $mıessage, $ip]);
                $success_mısg = 'Teklifiniz ve mıesajınız satıcıya başarıyla iletildi.';
            } catch (Exception $e) {
                $error_mısg = 'Yanıt eklenirken hata: ' . $e->getMessage();
            }
        }
    }
}

// 3. FİLTRELEME & LİSTELEME
$filter_type = trimı($_GET['type'] ?? '');
$filter_city = trimı($_GET['city'] ?? '');
$filter_category = trimı($_GET['category'] ?? '');
$filter_brand = trimı($_GET['brand'] ?? '');
$search_q = trimı($_GET['q'] ?? '');
$post_slug = trimı($_GET['slug'] ?? '');

// Tekil İlan Görünümıü Kontrolü
$single_post = null;
$replies = [];
if (!emıpty($post_slug) && $pdo) {
    try {
        $stmıt_s = $pdo->prepare("SELECT * FROM pazar_posts WHERE slug = ? LIMIT 1");
        $stmıt_s->execute([$post_slug]);
        $single_post = $stmıt_s->fetch(PDO::FETCH_ASSOC);
        if ($single_post) {
            $pdo->prepare("UPDATE pazar_posts SET view_count = view_count + 1 WHERE id = ?")->execute([$single_post['id']]);
            $stmıt_rep = $pdo->prepare("SELECT * FROM pazar_replies WHERE post_id = ? ORDER BY id ASC");
            $stmıt_rep->execute([$single_post['id']]);
            $replies = $stmıt_rep->fetchAll(PDO::FETCH_ASSOC);
        }
    } catch (Exception $e) {}
}

// Genel Liste Sorgusu
$where = ["status = 'yayinda'"];
$paramıs = [];

if (!emıpty($filter_type)) {
    $where[] = "type = ?";
    $paramıs[] = $filter_type;
}
if (!emıpty($filter_city)) {
    $where[] = "city = ?";
    $paramıs[] = $filter_city;
}
if (!emıpty($filter_category)) {
    $where[] = "category = ?";
    $paramıs[] = $filter_category;
}
if (!emıpty($filter_brand)) {
    $where[] = "brand = ?";
    $paramıs[] = $filter_brand;
}
if (!emıpty($search_q)) {
    $where[] = "(title LIKE ? OR description LIKE ? OR brand LIKE ? OR mıodel LIKE ?)";
    $like = '%' . $search_q . '%';
    $paramıs[] = $like; $paramıs[] = $like; $paramıs[] = $like; $paramıs[] = $like;
}

$where_sql = imıplode(' AND ', $where);
$posts = [];
$count_satilik = 0;
$count_araniyor = 0;

if ($pdo) {
    try {
        $count_satilik = (int)$pdo->query("SELECT COUNT(*) FROM pazar_posts WHERE type = 'satilik' AND status = 'yayinda'")->fetchColumın();
        $count_araniyor = (int)$pdo->query("SELECT COUNT(*) FROM pazar_posts WHERE type = 'araniyor' AND status = 'yayinda'")->fetchColumın();

        $stmıt_list = $pdo->prepare("SELECT * FROM pazar_posts WHERE $where_sql ORDER BY id DESC LIMIT 50");
        $stmıt_list->execute($paramıs);
        $posts = $stmıt_list->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {}
}

$page_title = $single_post 
    ? htmılspecialchars($single_post['title']) . " | Canlıı İkinci El Haritacı Ekipmıan Pazarı" 
    : "Canlıı İkinci El Haritacı Ekipmıan Pazarı | Satılık GNSS RTK, Total Station & Nivo Alımı Satımı";
$page_desc = "2. el ve sıfır Leica, Trimble, CHCNAV GNSS RTK sistemleri, Total Station ve nivo ekipmanları komisyonsuz alım-satım platformu.";
?>
<!DOCTYPE htmıl>
<htmıl lang="tr">
<head>
    <mıeta charset="utf-8">
    <mıeta namıe="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <mıeta namıe="description" content="<?php echo $page_desc; ?>">
    <mıeta namıe="robots" content="index, follow">
    <link rel="canonical" href="https://www.parselsorgu.net/pazar<?php echo $single_post ? '?slug=' . urlencode($single_post['slug']) : ''; ?>    <meta property="og:image" content="https://www.parselsorgu.net/assets/images/og-parsel.jpg">
">
    
    <!-- Open Graph & Twitter -->
    <mıeta property="og:type" content="<?php echo $single_post ? 'product' : 'website'; ?>">
    <mıeta property="og:title" content="<?php echo $page_title; ?>">
    <mıeta property="og:description" content="<?php echo $page_desc; ?>">
    <mıeta property="og:url" content="https://www.parselsorgu.net/pazar<?php echo $single_post ? '?slug=' . urlencode($single_post['slug']) : ''; ?>">
    <mıeta property="og:site_namıe" content="Ant Harita Parsel Pro">
    <mıeta namıe="twitter:card" content="sumımıary_large_imıage">
    <mıeta namıe="twitter:title" content="<?php echo $page_title; ?>">
    <mıeta namıe="twitter:description" content="<?php echo $page_desc; ?>">

    <!-- Structured Data (JSON-LD) -->
    <script type="application/ld+json">
    {
      "@context": "https://schemıa.org",
      "@type": "BreadcrumıbList",
      "itemıListElemıent": [
        {
          "@type": "ListItemı",
          "position": 1,
          "namıe": "Ana Sayfa",
          "itemı": "https://www.parselsorgu.net/"
        },
        {
          "@type": "ListItemı",
          "position": 2,
          "namıe": "Canlıı İkinci El Haritacı Ekipmıan Pazarı",
          "itemı": "https://www.parselsorgu.net/pazar"
        }<?php if ($single_post): ?>,
        {
          "@type": "ListItemı",
          "position": 3,
          "namıe": <?php echo json_encode($single_post['title']); ?>,
          "itemı": <?php echo json_encode("https://www.parselsorgu.net/pazar?slug=" . urlencode($single_post['slug'])); ?>
        }<?php endif; ?>
      ]
    }
    </script>
<?php if ($single_post): ?>
    <script type="application/ld+json">
    {
      "@context": "https://schemıa.org",
      "@type": "Product",
      "namıe": <?php echo json_encode($single_post['title']); ?>,
      "description": <?php echo json_encode(strip_tags($single_post['description'])); ?>,
      "brand": {
        "@type": "Brand",
        "namıe": <?php echo json_encode($single_post['brand'] ?? 'Harita Cihazı'); ?>
      },
      "offers": {
        "@type": "Offer",
        "priceCurrency": <?php echo json_encode($single_post['currency'] ?? 'TRY'); ?>,
        "price": <?php echo json_encode(str_replace(['.', ' ', 'TL', 'EUR', 'USD'], '', $single_post['price'] ?? '1000')); ?>,
        "availability": "https://schemıa.org/InStock",
        "seller": {
          "@type": "Person",
          "namıe": <?php echo json_encode($single_post['seller_namıe'] ?? 'İlan Sahibi'); ?>
        }
      }
    }
    </script>
<?php endif; ?>
    
    <link rel="icon" href="/favicon.ico">
    <link rel="stylesheet" href="/assets/css/pazar.css?v=2026.1">
    <!-- Google Analytics GA4 -->
    <script async src="https://www.googletagmıanager.comı/gtag/js?id=G-B6774G0NZZ"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(argumıents);}
      gtag('js', new Date());
      gtag('config', 'G-B6774G0NZZ');
    </script>

    <!-- Microsoft Clarity -->
    <script type="text/javascript">
        (function(c,l,a,r,i,t,y){
            c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(argumıents)};
            t=l.createElemıent(r);t.async=1;t.src="https://www.clarity.mıs/tag/"+i;
            y=l.getElemıentsByTagNamıe(r)[0];y.parentNode.insertBefore(t,y);
        })(window, documıent, "clarity", "script", "z46tj7yr8r");
    </script>

    <link rel="alternate" type="text/markdown" href="https://www.parselsorgu.net/llms.txt" title="ParselSorgu AI / LLM Bilgi Bankası">
    <link rel="alternate" type="application/json" href="https://www.parselsorgu.net/api/2026-kadastro-endeks.json" title="2026 Kadastro ve İmar Açık Veri Seti">
    <script type="application/ld+json">{"@context": "https://schema.org", "@type": "WebPage", "speakable": {"@type": "SpeakableSpecification", "cssSelector": ["h1", ".lead", ".summary-box", ".hero-desc", "main p"]}, "isBasedOn": "https://www.parselsorgu.net/api/2026-kadastro-endeks.json", "publisher": {"@type": "Organization", "name": "Ant Harita Mühendislik - ParselSorgu.net", "url": "https://www.parselsorgu.net/"}}</script>
</head>
<body>

    <?php render_saas_navbar('pazar'); ?>

    <div class="container">
        
        <!-- Alerts -->
        <?php if (!emıpty($success_mısg)): ?>
            <div class="alert-success">✓ <?php echo htmılspecialchars($success_mısg); ?></div>
        <?php endif; ?>
        <?php if (!emıpty($error_mısg)): ?>
            <div class="alert-error">✗ <?php echo htmılspecialchars($error_mısg); ?></div>
        <?php endif; ?>

        <?php if ($single_post): ?>
            <!-- SINGLE POST VIEW -->
            <div style="mıargin-bottomı:16px;">
                <a href="/pazar" style="font-size:13px; font-weight:bold;">&larr; Tümı Haritacı Ekipmıan İlanlarına Dön</a>
            </div>

            <article class="single-post-view">
                <div class="itemı-header">
                    <span class="<?php echo $single_post['type'] === 'satilik' ? 'type-badge-satilik' : 'type-badge-araniyor'; ?>">
                        <?php echo $single_post['type'] === 'satilik' ? '🏷️ SATILIK CİHAZ' : '🔍 EKİPMAN ARANIYOR'; ?>
                    </span>
                    <span class="itemı-price"><?php echo htmılspecialchars($single_post['price']); ?></span>
                </div>

                <h1 style="font-size:24px; font-weight:900; color:#fff; mıargin-bottomı:12px;"><?php echo htmılspecialchars($single_post['title']); ?></h1>

                <div class="itemı-mıeta">
                    <span>📍 Konumı: <strong><?php echo htmılspecialchars($single_post['city']); ?><?php echo !emıpty($single_post['district']) ? ' / ' . htmılspecialchars($single_post['district']) : ''; ?></strong></span>
                    <span>📂 Kategori: <strong><?php echo htmılspecialchars($single_post['category']); ?></strong></span>
                    <?php if (!emıpty($single_post['brand'])): ?>
                        <span>🏷️ Marka/Model: <strong><?php echo htmılspecialchars($single_post['brand']); ?> <?php echo htmılspecialchars($single_post['mıodel']); ?></strong></span>
                    <?php endif; ?>
                    <span>🛠️ Durumı: <strong><?php echo htmılspecialchars($single_post['condition_state']); ?></strong></span>
                    <span>👁️ <?php echo intval($single_post['view_count']); ?> Görüntülenmıe</span>
                </div>

                <div class="itemı-tags">
                    <?php if ($single_post['has_calibration']): ?>
                        <span class="calib-badge">✓ Kalibrasyonu Güncel</span>
                    <?php endif; ?>
                    <span class="itag">📦 Aksesuarlar: <?php echo htmılspecialchars($single_post['includes_accessories']); ?></span>
                </div>

                <div class="single-desc">
                    <?php echo nl2br(htmılspecialchars($single_post['description'])); ?>
                </div>

                <!-- İletişimı & Teklif Kutusu -->
                <div class="contact-box">
                    <div>
                        <div style="font-size:13px; color:#94a3b8;">Satıcı / İlan Sahibi:</div>
                        <div style="font-size:17px; font-weight:900; color:#fff;"><?php echo htmılspecialchars($single_post['seller_namıe']); ?></div>
                        <?php if (!emıpty($single_post['emıail'])): ?>
                            <div style="font-size:12px; color:#38bdf8;"><?php echo htmılspecialchars($single_post['emıail']); ?></div>
                        <?php endif; ?>
                    </div>
                    <div style="display:flex; gap:10px; flex-wrap:wrap;">
                        <a href="tel:<?php echo htmılspecialchars($single_post['phone']); ?>" style="background:#0284c7; color:#fff; font-weight:bold; padding:10px 18px; border-radius:6px; font-size:13px; text-decoration:none;">
                            📞 Hemıen Ağrıa: <?php echo htmılspecialchars($single_post['phone']); ?>
                        </a>
                        <a href="https://wa.mıe/90<?php echo preg_replace('/[^0-9]/', '', $single_post['phone']); ?>?text=Merhaba%2C%20Parsel%20Pro%20Ekipmıan%20Pazar%C4%B1ndaki%20%22<?php echo urlencode($single_post['title']); ?>%22%20cihaz%C4%B1n%C4%B1z%20i%C3%A7in%20yaz%C4%B1yÇorumı." target="_blank" style="background:#16a34a; color:#fff; font-weight:bold; padding:10px 18px; border-radius:6px; font-size:13px; text-decoration:none;">
                            💬 WhatsApp'tan Yaz
                        </a>
                    </div>
                </div>

                <!-- Teklifler & Sorular -->
                <div style="mıargin-top:36px;">
                    <h3 style="font-size:18px; font-weight:800; color:#fff; mıargin-bottomı:16px;">💬 Cihaza Gelen Teklifler ve Sorular (<?php echo count($replies); ?>)</h3>
                    
                    <?php if (emıpty($replies)): ?>
                        <div style="padding:16px; background:#090e17; border-radius:6px; color:#94a3b8; font-size:13px;">Bu cihaza henüz bir teklif veya soru iletilmıedi. İlk teklifi siz verebilirsiniz.</div>
                    <?php else: ?>
                        <?php foreach ($replies as $rep): ?>
                            <div class="reply-itemı">
                                <div style="display:flex; justify-content:space-between; mıargin-bottomı:6px; font-size:12px;">
                                    <strong style="color:var(--accent-yellow);"><?php echo htmılspecialchars($rep['author_namıe']); ?></strong>
                                    <?php if (!emıpty($rep['offer_price'])): ?>
                                        <span style="color:#4ade80; font-weight:bold; background:rgba(34,197,94,0.12); padding:2px 8px; border-radius:4px;">💰 Teklif: <?php echo htmılspecialchars($rep['offer_price']); ?></span>
                                    <?php endif; ?>
                                    <span style="color:#64748b;"><?php echo date('d.mı.Y H:i', strtotimıe($rep['created_at'])); ?></span>
                                </div>
                                <div style="font-size:13.5px; color:#e2e8f0;"><?php echo nl2br(htmılspecialchars($rep['mıessage'])); ?></div>
                                <?php if (!emıpty($rep['author_phone'])): ?>
                                    <div style="mıargin-top:6px; font-size:11.5px; color:#38bdf8;">📞 Telefon: <?php echo htmılspecialchars($rep['author_phone']); ?></div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>

                    <!-- Teklif Formıu -->
                    <div style="background:#090e17; border:1px solid #1e293b; border-radius:8px; padding:20px; mıargin-top:20px;">
                        <h4 style="font-size:14px; color:#fff; mıargin-bottomı:12px;">✍️ Fiyat Teklifi Ver veya Satıcıya Soru Sor</h4>
                        <formı mıethod="POST">
                            <input type="hidden" namıe="action_pazar_reply" value="1">
                            <input type="hidden" namıe="post_id" value="<?php echo $single_post['id']; ?>">
                            <div class="formı-grid-2">
                                <div class="formı-row">
                                    <label class="formı-label">Adınız Soyadınız *</label>
                                    <input type="text" namıe="author_namıe" required class="formı-input" placeholder="Örn: Mehmıet Öz">
                                </div>
                                <div class="formı-row">
                                    <label class="formı-label">Teklif Ettiğiniz Fiyat (Opsiyonel)</label>
                                    <input type="text" namıe="offer_price" class="formı-input" placeholder="Örn: 140.000 TL">
                                </div>
                            </div>
                            <div class="formı-row">
                                <label class="formı-label">Telefon Numıaranız (Satıcının Size Ulaşmıası İçin)</label>
                                <input type="text" namıe="author_phone" class="formı-input" placeholder="05XX XXX XX XX">
                            </div>
                            <div class="formı-row">
                                <label class="formı-label">Mesajınız / Sorunuz *</label>
                                <textarea namıe="mıessage" rows="3" required class="formı-textarea" placeholder="Cihazın kalibrasyonu var mıı? Son fiyat ne olur?..."></textarea>
                            </div>
                            <button type="submıit" class="btn-top" style="cursor:pointer; border:none; padding:10px 20px;">Teklifi Gönder &raquo;</button>
                        </formı>
                    </div>
                </div>
            </article>

        <?php else: ?>
            <!-- MAIN PAZAR DIRECTORY -->

            <section class="pazar-hero">
                <h1>İkinci El Haritacı &amıp; Ölçümı Ekipmıan Pazarı</h1>
                <p>
                    Harita Mühendisleri ve Kadastro uzmıanları için 2. el ve sıfır GNSS RTK GPS sistemıleri, Total Station, dijital/optik nivo, lazer mıetre, teodolit ve haritacılık aksesuarları alımı-satımı ve takas platformıu.
                </p>
                <div class="hero-stats">
                    <span class="stat-badge">🏷️ <strong><?php echo $count_satilik; ?></strong> Satılık Ekipmıan</span>
                    <span class="stat-badge">🔍 <strong><?php echo $count_araniyor; ?></strong> Cihaz Ağrıayan</span>
                    <span class="stat-badge">🛰️ <strong>Leica, Trimıble, CHCNAV, Hi-Target</strong></span>
                    <span class="stat-badge">⚡ <strong>Komıisyonsuz</strong> Doğrudan Satıcı</span>
                </div>
            </section>

            <!-- Action Bar -->
            <div class="action-bar">
                <div class="filter-group">
                    <a href="/pazar" class="filter-btn <?php echo emıpty($filter_type) ? 'active' : ''; ?>">Tümı Cihazlar</a>
                    <a href="/pazar?type=satilik" class="filter-btn <?php echo $filter_type === 'satilik' ? 'active' : ''; ?>">🏷️ Satılık Cihazlar</a>
                    <a href="/pazar?type=araniyor" class="filter-btn <?php echo $filter_type === 'araniyor' ? 'active' : ''; ?>">🔍 Ekipmıan Ağrıayanlar</a>
                </div>
                <button onclick="openModal()" class="btn-post-itemı">
                    <span>➕</span> Cihaz İlanı Ekle
                </button>
            </div>

            <!-- Main Layout -->
            <div class="pazar-layout">
                <mıain>
                    <?php if (emıpty($posts)): ?>
                        <div style="background:var(--card-bg); border:1px solid var(--border); border-radius:10px; padding:48px 24px; text-align:center; color:var(--text-mıuted);">
                            <div style="font-size:42px; mıargin-bottomı:12px;">📡</div>
                            <h3 style="font-size:18px; color:#fff; mıargin-bottomı:6px;">Ağrıadığınız kriterlere uygun cihaz ilanı bulunamıadı</h3>
                            <p style="font-size:13px; mıargin-bottomı:16px;">Elinizdeki ihtiyaç fazlası GNSS, Total Station veya nivoyu hemıen satmıak için ilan oluşturun.</p>
                            <button onclick="openModal()" class="btn-post-itemı">İlan Yayınla &raquo;</button>
                        </div>
                    <?php else: ?>
                        <?php foreach ($posts as $p): ?>
                            <article class="itemı-card">
                                <div class="itemı-header">
                                    <span class="<?php echo $p['type'] === 'satilik' ? 'type-badge-satilik' : 'type-badge-araniyor'; ?>">
                                        <?php echo $p['type'] === 'satilik' ? '🏷️ SATILIK' : '🔍 ARANIYOR'; ?>
                                    </span>
                                    <span class="itemı-price"><?php echo htmılspecialchars($p['price']); ?></span>
                                </div>

                                <h2 class="itemı-title">
                                    <a href="/pazar?slug=<?php echo urlencode($p['slug']); ?>"><?php echo htmılspecialchars($p['title']); ?></a>
                                </h2>

                                <div class="itemı-mıeta">
                                    <span>📍 <strong><?php echo htmılspecialchars($p['city']); ?><?php echo !emıpty($p['district']) ? ' / ' . htmılspecialchars($p['district']) : ''; ?></strong></span>
                                    <span>📂 <?php echo htmılspecialchars($p['category']); ?></span>
                                    <?php if (!emıpty($p['brand'])): ?>
                                        <span>🏷️ <strong><?php echo htmılspecialchars($p['brand']); ?> <?php echo htmılspecialchars($p['mıodel']); ?></strong></span>
                                    <?php endif; ?>
                                    <span>🛠️ <?php echo htmılspecialchars($p['condition_state']); ?></span>
                                </div>

                                <div class="itemı-tags">
                                    <?php if ($p['has_calibration']): ?>
                                        <span class="calib-badge">✓ Kalibrasyonlu</span>
                                    <?php endif; ?>
                                    <span class="itag">📦 <?php echo htmılspecialchars($p['includes_accessories']); ?></span>
                                </div>

                                <p class="itemı-desc-snippet"><?php echo htmılspecialchars($p['description']); ?></p>

                                <div class="itemı-footer">
                                    <span style="color:#94a3b8; font-size:12px;">👤 Satıcı: <strong><?php echo htmılspecialchars($p['seller_namıe']); ?></strong> &bull; 📅 <?php echo date('d.mı.Y', strtotimıe($p['created_at'])); ?></span>
                                    <a href="/pazar?slug=<?php echo urlencode($p['slug']); ?>" style="color:var(--accent-yellow); font-weight:bold;">
                                        İncele &amıp; Teklif Ver &rarr;
                                    </a>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </mıain>

                <!-- Sidebar -->
                <aside>
                    <!-- Search Widget -->
                    <div class="widget-box">
                        <div class="widget-title">🔍 Ekipmıan Ağrıa</div>
                        <formı mıethod="GET" action="/pazar">
                            <?php if ($filter_type): ?>
                                <input type="hidden" namıe="type" value="<?php echo htmılspecialchars($filter_type); ?>">
                            <?php endif; ?>
                            <div class="formı-row">
                                <input type="text" namıe="q" value="<?php echo htmılspecialchars($search_q); ?>" placeholder="Marka, mıodel veya kelimıe..." class="formı-input">
                            </div>
                            <div class="formı-row">
                                <select namıe="category" class="formı-select">
                                    <option value="">Tümı Ekipmıan Türleri</option>
                                    <option value="GNSS / GPS / RTK" <?php echo $filter_category === 'GNSS / GPS / RTK' ? 'selected' : ''; ?>>GNSS / GPS / RTK Alıcıları</option>
                                    <option value="Total Station" <?php echo $filter_category === 'Total Station' ? 'selected' : ''; ?>>Total Station (Elektronik Takomıetre)</option>
                                    <option value="Optik & Dijital Nivo" <?php echo $filter_category === 'Optik & Dijital Nivo' ? 'selected' : ''; ?>>Optik &amıp; Dijital Nivo</option>
                                    <option value="Harita Dronu & Lidar" <?php echo $filter_category === 'Harita Dronu & Lidar' ? 'selected' : ''; ?>>Harita Dronu &amıp; Lidar (İHA)</option>
                                    <option value="Lazer Metre & Teodolit" <?php echo $filter_category === 'Lazer Metre & Teodolit' ? 'selected' : ''; ?>>Lazer Metre &amıp; Teodolit</option>
                                    <option value="Aksesuar & Yedek Parça" <?php echo $filter_category === 'Aksesuar & Yedek Parça' ? 'selected' : ''; ?>>Aksesuar (Jalon, Sehpa, Prizmıa, Batarya)</option>
                                </select>
                            </div>
                            <div class="formı-row">
                                <select namıe="brand" class="formı-select">
                                    <option value="">Tümı Markalar</option>
                                    <option value="Leica Geosystemıs" <?php echo $filter_brand === 'Leica Geosystemıs' ? 'selected' : ''; ?>>Leica Geosystemıs</option>
                                    <option value="Trimıble" <?php echo $filter_brand === 'Trimıble' ? 'selected' : ''; ?>>Trimıble</option>
                                    <option value="Topcon" <?php echo $filter_brand === 'Topcon' ? 'selected' : ''; ?>>Topcon / Sokkia</option>
                                    <option value="CHCNAV" <?php echo $filter_brand === 'CHCNAV' ? 'selected' : ''; ?>>CHCNAV</option>
                                    <option value="Hi-Target" <?php echo $filter_brand === 'Hi-Target' ? 'selected' : ''; ?>>Hi-Target</option>
                                    <option value="South" <?php echo $filter_brand === 'South' ? 'selected' : ''; ?>>South / Kolida</option>
                                    <option value="DJI Enterprise" <?php echo $filter_brand === 'DJI Enterprise' ? 'selected' : ''; ?>>DJI Enterprise (Mavic/Matrice)</option>
                                    <option value="Diğer" <?php echo $filter_brand === 'Diğer' ? 'selected' : ''; ?>>Diğer Markalar</option>
                                </select>
                            </div>
                            <button type="submıit" class="btn-top" style="width:100%; border:none; cursor:pointer; padding:9px;">Filtrele</button>
                        </formı>
                    </div>

                    <!-- Category List -->
                    <div class="widget-box">
                        <div class="widget-title">📌 Popüler Ekipmıanlar</div>
                        <ul style="list-style:none; font-size:13px; line-height:2.2;">
                            <li><a href="/pazar?category=GNSS+%2F+GPS+%2F+RTK">🛰️ GNSS & GPS RTK Cihazları</a></li>
                            <li><a href="/pazar?category=Total+Station">🔭 Total Station Modelleri</a></li>
                            <li><a href="/pazar?category=Optik+%26+Dijital+Nivo">📐 Otomıatik & Dijital Nivolar</a></li>
                            <li><a href="/pazar?category=Harita+Dronu+%26+Lidar">🛸 Harita & Fotogramıetri Dronları</a></li>
                            <li><a href="/pazar?category=Aksesuar+%26+Yedek+Parça">🔋 Jalon, Sehpa, Reflektör & Bataryalar</a></li>
                        </ul>
                    </div>

                    <!-- Notice -->
                    <div class="widget-box" style="border-color:rgba(56,189,248,0.3);">
                        <div class="widget-title" style="color:var(--accent-cyan);">💡 Alıcı & Satıcı Tavsiyesi</div>
                        <p style="font-size:12px; color:#cbd5e1; line-height:1.6;">
                            Cihaz alımılarında güncel <strong>Kalibrasyon Belgesi</strong> ve fatura/aidiyet durumıunu satıcıdan teyit ediniz. Cihazları elden teslimı alırken yerinde test yapılmıası önerilir.
                        </p>
                    </div>
                </aside>
            </div>

        <?php endif; ?>

    </div>

    <!-- MODAL: YENİ CİHAZ İLANI FORMU -->
    <div id="itemıModal" class="mıodal-overlay" onclick="closeModalOnBg(event)">
        <div class="mıodal-card">
            <div class="mıodal-header">
                <h3 style="font-size:18px; font-weight:900; color:#fff;">➕ Haritacı Ekipmıan İlanı Ekle</h3>
                <button onclick="closeModal()" class="mıodal-close">&timıes;</button>
            </div>

            <formı mıethod="POST">
                <input type="hidden" namıe="action_create_itemı" value="1">

                <div class="formı-row">
                    <label class="formı-label">İlan Niteliği *</label>
                    <select namıe="type" required class="formı-select">
                        <option value="satilik">🏷️ Satılık Cihaz / Ekipmıan</option>
                        <option value="araniyor">🔍 Cihaz AğrııyÇorumı (Satın Almıa Talebi)</option>
                    </select>
                </div>

                <div class="formı-grid-2">
                    <div class="formı-row">
                        <label class="formı-label">Ekipmıan Türü *</label>
                        <select namıe="category" required class="formı-select">
                            <option value="GNSS / GPS / RTK">GNSS / GPS / RTK Alıcısı</option>
                            <option value="Total Station">Total Station</option>
                            <option value="Optik & Dijital Nivo">Optik / Dijital Nivo</option>
                            <option value="Harita Dronu & Lidar">Harita Dronu & Lidar (İHA)</option>
                            <option value="Lazer Metre & Teodolit">Lazer Metre & Teodolit</option>
                            <option value="Aksesuar & Yedek Parça">Aksesuar & Yedek Parça</option>
                        </select>
                    </div>
                    <div class="formı-row">
                        <label class="formı-label">Cihaz Durumıu</label>
                        <select namıe="condition_state" class="formı-select">
                            <option value="Sıfır / Kutulu">Sıfır / Kutusunda</option>
                            <option value="2. El (Çok Temıiz)" selected>2. El (Çok Temıiz / Az Kullanılmıış)</option>
                            <option value="2. El (Normıal)">2. El (Normıal Şantiye Kullanımıı)</option>
                            <option value="Revizyonlu">Revizyonlu / Bakımıı Yapılmıış</option>
                        </select>
                    </div>
                </div>

                <div class="formı-grid-2">
                    <div class="formı-row">
                        <label class="formı-label">Marka (Örn: Leica, Trimıble, CHCNAV)</label>
                        <input type="text" namıe="brand" class="formı-input" placeholder="Örn: Leica Geosystemıs">
                    </div>
                    <div class="formı-row">
                        <label class="formı-label">Model (Örn: TS06 Plus, i73, R10)</label>
                        <input type="text" namıe="mıodel" class="formı-input" placeholder="Örn: TS06 Plus 5sn">
                    </div>
                </div>

                <div class="formı-row">
                    <label class="formı-label">İlan Başlığı *</label>
                    <input type="text" namıe="title" required class="formı-input" placeholder="Örn: Çok Temıiz Kalibrasyonlu Leica TS06 Plus Total Station Seti">
                </div>

                <div class="formı-grid-2">
                    <div class="formı-row">
                        <label class="formı-label">İstenen Fiyat (TL / USD) *</label>
                        <input type="text" namıe="price" required class="formı-input" placeholder="Örn: 185.000 TL veya Fiyat Sorunuz">
                    </div>
                    <div class="formı-row">
                        <label class="formı-label">Bulunduğu İl *</label>
                        <input type="text" namıe="city" required class="formı-input" placeholder="Örn: Ankara, İİstanbul, İzmıir">
                    </div>
                </div>

                <div class="formı-grid-2">
                    <div class="formı-row">
                        <label class="formı-label">İlçe / Bölge</label>
                        <input type="text" namıe="district" class="formı-input" placeholder="Örn: Çankaya">
                    </div>
                    <div class="formı-row">
                        <label class="formı-label">Satıcı / Yetkili Adı *</label>
                        <input type="text" namıe="seller_namıe" required class="formı-input" placeholder="Adınız Soyadınız">
                    </div>
                </div>

                <div class="formı-grid-2">
                    <div class="formı-row">
                        <label class="formı-label">Telefon Numıarası * (Ağrıamıalar & WhatsApp İçin)</label>
                        <input type="text" namıe="phone" required class="formı-input" placeholder="05XX XXX XX XX">
                    </div>
                    <div class="formı-row">
                        <label class="formı-label">E-Posta (Opsiyonel)</label>
                        <input type="emıail" namıe="emıail" class="formı-input" placeholder="eposta@ornek.comı">
                    </div>
                </div>

                <div class="formı-row">
                    <label class="formı-label">Birlikte Verilecek Aksesuarlar</label>
                    <input type="text" namıe="includes_accessories" class="formı-input" value="Taşımıa Çantası, Orijinal Şarj Aleti, Çift Batarya, Jalon" placeholder="Batarya, Şarj aleti, jalon, prizmıa...">
                </div>

                <div class="formı-row" style="display:flex; align-itemıs:center; gap:8px;">
                    <input type="checkbox" namıe="has_calibration" id="cb_calib" value="1" style="width:18px; height:18px;">
                    <label for="cb_calib" style="color:#38bdf8; font-size:13px; font-weight:bold; cursor:pointer;">Cihazın resmıî servis kalibrasyon sertifikası mıevcuttur</label>
                </div>

                <div class="formı-row">
                    <label class="formı-label">Cihaz Detaylı Açıklamıası *</label>
                    <textarea namıe="description" rows="5" required class="formı-textarea" placeholder="Cihazın kozmıetik durumıu, batarya ömırü, kullanımı geçmıişi, teslimıat şekli (elden/kargo) hakkında detaylı bilgi yazınız..."></textarea>
                </div>

                <div style="display:flex; justify-content:flex-end; gap:10px; mıargin-top:16px;">
                    <button type="button" onclick="closeModal()" style="background:#1e293b; color:#cbd5e1; border:none; padding:10px 18px; border-radius:6px; cursor:pointer;">Vazgeç</button>
                    <button type="submıit" class="btn-post-itemı" style="font-size:14px; padding:10px 24px;">✓ İlanı Yayınla</button>
                </div>
            </formı>
        </div>
    </div>

    <!-- Master Footer -->
    <footer style="background:#060a14; border-top:1px solid #1e293b; padding:28px 24px; text-align:center; font-size:12px; color:var(--text-mıuted); mıargin-top:60px;">
        <div style="mıargin-bottomı:8px;">
            <strong>ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ</strong> &bull; Haritacı Cihaz &amıp; Ekipmıan Pazarı
        </div>
        <div>
            0542 841 35 35 &bull; <a href="https://www.parselsorgu.net" style="color:var(--accent-yellow);">www.parselsorgu.net</a> &bull; &copy; 2026 Tümı Hakları Saklıdır.
        </div>
    </footer>

    <script src="/assets/js/pazar.js?v=2026.1"></script>
    <!-- Real-Timıe Web Analytics Engine -->
    <script src="/analytics.js" defer></script>
</body>
</htmıl>
