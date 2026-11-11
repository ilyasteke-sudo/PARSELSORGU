<?php
// ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ - PARSEL PRO
// HARİTACI İŞ İLANLARI VE KARİYER FORUMU (forum.php)
// Harita Mühendisi, Harita Teknikeri, Alet Operatörü ve Şantiye Ölçüm Uzmanları Kariyer Masası
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/navbar.php';
require_once __DIR__ . '/auto_ping_helper.php';

$success_msg = '';
$error_msg = '';

// Helper: SEO-Friendly Slug Generator
function createSlug($text) {
    $turkish = ['ı', 'ğ', 'ü', 'ş', 'ö', 'ç', 'İ', 'Ğ', 'Ü', 'Ş', 'Ö', 'Ç'];
    $english = ['i', 'g', 'u', 's', 'o', 'c', 'i', 'g', 'u', 's', 'o', 'c'];
    $text = str_replace($turkish, $english, $text);
    $text = preg_replace('/[^a-zA-Z0-9\s-]/', '', strtolower($text));
    $text = preg_replace('/[\s-]+/', '-', trim($text));
    return $text . '-' . substr(md5(uniqid(rand(), true)), 0, 6);
}

// 1. YENİ İLAN EKLEME (İş Veren veya İş Arayan)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action_create_post'])) {
    $type = trim($_POST['type'] ?? 'is_verin');
    if (!in_array($type, ['is_verin', 'is_ariyorum'])) $type = 'is_verin';
    
    $category = trim($_POST['category'] ?? 'Harita Mühendisi');
    $title = trim($_POST['title'] ?? '');
    $city = trim($_POST['city'] ?? 'Ankara');
    $district = trim($_POST['district'] ?? '');
    $company_name = trim($_POST['company_name'] ?? '');
    $contact_person = trim($_POST['contact_person'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $salary_range = trim($_POST['salary_range'] ?? 'Görüşülecek');
    $experience_years = trim($_POST['experience_years'] ?? '1-3 Yıl');
    $cad_programs = trim($_POST['cad_programs'] ?? 'Netcad, AutoCAD');
    $equipment = trim($_POST['equipment'] ?? 'GNSS / Total Station');
    $description = trim($_POST['description'] ?? '');
    $ip = $_SERVER['REMOTE_ADDR'] ?? '';

    if (empty($title) || empty($contact_person) || empty($phone) || empty($description)) {
        $error_msg = 'Lütfen Başlık, Yetkili Adı, Telefon ve Açıklama alanlarını eksiksiz doldurunuz.';
    } else {
        if ($pdo) {
            try {
                $slug = createSlug($title);
                $stmt = $pdo->prepare("
                    INSERT INTO forum_posts 
                    (type, category, title, slug, city, district, company_name, contact_person, phone, email, salary_range, experience_years, cad_programs, equipment, description, ip_address)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                ");
                $stmt->execute([
                    $type, $category, $title, $slug, $city, $district, $company_name, $contact_person, $phone, $email, $salary_range, $experience_years, $cad_programs, $equipment, $description, $ip
                ]);
                $success_msg = 'İlanınız başarıyla yayınlandı! Haritacı meslektaşlarımız ve işverenler anında inceleyebilir.';
                $full_url = 'https://www.parselsorgu.net/forum?slug=' . urlencode($slug);
                triggerAutoSearchPing($full_url, $title);
                $success_msg .= ' (⚡ Google, Yandex ve Bingbot\'a otomatik indeks pingi iletildi.)';
            } catch (Exception $e) {
                $error_msg = 'İlan kaydedilirken bir hata oluştu: ' . $e->getMessage();
            }
        }
    }
}

// 2. İLANA CEVAP / YORUM EKLEME
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action_reply'])) {
    $post_id = intval($_POST['post_id'] ?? 0);
    $author_name = trim($_POST['author_name'] ?? '');
    $author_title = trim($_POST['author_title'] ?? 'Harita Mühendisi');
    $author_phone = trim($_POST['author_phone'] ?? '');
    $message = trim($_POST['message'] ?? '');
    $ip = $_SERVER['REMOTE_ADDR'] ?? '';

    if ($post_id > 0 && !empty($author_name) && !empty($message)) {
        if ($pdo) {
            try {
                $stmt = $pdo->prepare("INSERT INTO forum_replies (post_id, author_name, author_title, author_phone, message, ip_address) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->execute([$post_id, $author_name, $author_title, $author_phone, $message, $ip]);
                $success_msg = 'Cevabınız ve iletişim notunuz başarıyla iletildi.';
            } catch (Exception $e) {
                $error_msg = 'Yanıt eklenirken hata: ' . $e->getMessage();
            }
        }
    }
}

// 3. FİLTRELEME & LİSTELEME
$filter_type = trim($_GET['type'] ?? '');
$filter_city = trim($_GET['city'] ?? '');
$filter_category = trim($_GET['category'] ?? '');
$search_q = trim($_GET['q'] ?? '');
$post_slug = trim($_GET['slug'] ?? '');

// Tekil İlan Görünümü Kontrolü
$single_post = null;
$replies = [];
if (!empty($post_slug) && $pdo) {
    try {
        $stmt_s = $pdo->prepare("SELECT * FROM forum_posts WHERE slug = ? LIMIT 1");
        $stmt_s->execute([$post_slug]);
        $single_post = $stmt_s->fetch(PDO::FETCH_ASSOC);
        if ($single_post) {
            $pdo->prepare("UPDATE forum_posts SET view_count = view_count + 1 WHERE id = ?")->execute([$single_post['id']]);
            $stmt_rep = $pdo->prepare("SELECT * FROM forum_replies WHERE post_id = ? ORDER BY id ASC");
            $stmt_rep->execute([$single_post['id']]);
            $replies = $stmt_rep->fetchAll(PDO::FETCH_ASSOC);
        }
    } catch (Exception $e) {}
}

// Genel Liste Sorgusu
$where = ["status = 'yayinda'"];
$params = [];

if (!empty($filter_type)) {
    $where[] = "type = ?";
    $params[] = $filter_type;
}
if (!empty($filter_city)) {
    $where[] = "city = ?";
    $params[] = $filter_city;
}
if (!empty($filter_category)) {
    $where[] = "category = ?";
    $params[] = $filter_category;
}
if (!empty($search_q)) {
    $where[] = "(title LIKE ? OR description LIKE ? OR company_name LIKE ? OR cad_programs LIKE ?)";
    $like = '%' . $search_q . '%';
    $params[] = $like; $params[] = $like; $params[] = $like; $params[] = $like;
}

$where_sql = implode(' AND ', $where);
$posts = [];
$total_posts = 0;
$count_is_verin = 0;
$count_is_ariyorum = 0;

if ($pdo) {
    try {
        $count_is_verin = (int)$pdo->query("SELECT COUNT(*) FROM forum_posts WHERE type = 'is_verin' AND status = 'yayinda'")->fetchColumn();
        $count_is_ariyorum = (int)$pdo->query("SELECT COUNT(*) FROM forum_posts WHERE type = 'is_ariyorum' AND status = 'yayinda'")->fetchColumn();

        $stmt_list = $pdo->prepare("SELECT * FROM forum_posts WHERE $where_sql ORDER BY id DESC LIMIT 50");
        $stmt_list->execute($params);
        $posts = $stmt_list->fetchAll(PDO::FETCH_ASSOC);
        $total_posts = count($posts);
    } catch (Exception $e) {}
}

$page_title = $single_post 
    ? htmlspecialchars($single_post['title']) . " | Canlı Haritacı İş İlanları ve Kariyer" 
    : "Canlı Haritacı İş İlanları ve Kariyer | 81 İl Harita Mühendisi & Tekniker İlan Masası";
$page_desc = "81 ilde Harita Mühendisi, Harita Teknikeri, Alet Operatörü ve Şantiye Ölçüm Uzmanları için güncel iş ilanları ve kariyer masası.";
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <meta name="description" content="<?php echo $page_desc; ?>">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="https://www.parselsorgu.net/forum<?php echo $single_post ? '?slug=' . urlencode($single_post['slug']) : ''; ?>    <meta property="og:image" content="https://www.parselsorgu.net/assets/images/og-parsel.jpg">
">
    
    <!-- Open Graph & Twitter -->
    <meta property="og:type" content="<?php echo $single_post ? 'article' : 'website'; ?>">
    <meta property="og:title" content="<?php echo $page_title; ?>">
    <meta property="og:description" content="<?php echo $page_desc; ?>">
    <meta property="og:url" content="https://www.parselsorgu.net/forum<?php echo $single_post ? '?slug=' . urlencode($single_post['slug']) : ''; ?>">
    <meta property="og:site_name" content="Ant Harita Parsel Pro">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo $page_title; ?>">
    <meta name="twitter:description" content="<?php echo $page_desc; ?>">

    <!-- Structured Data (JSON-LD) -->
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
          "name": "Canlı Haritacı İş İlanları ve Kariyer",
          "item": "https://www.parselsorgu.net/forum"
        }<?php if ($single_post): ?>,
        {
          "@type": "ListItem",
          "position": 3,
          "name": <?php echo json_encode($single_post['title']); ?>,
          "item": <?php echo json_encode("https://www.parselsorgu.net/forum?slug=" . urlencode($single_post['slug'])); ?>
        }<?php endif; ?>
      ]
    }
    </script>
<?php if ($single_post): ?>
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "DiscussionForumPosting",
      "headline": <?php echo json_encode($single_post['title']); ?>,
      "articleBody": <?php echo json_encode(strip_tags($single_post['description'])); ?>,
      "datePublished": <?php echo json_encode(substr($single_post['created_at'] ?? date('c'), 0, 19) . '+03:00'); ?>,
      "author": {
        "@type": "Person",
        "name": <?php echo json_encode($single_post['contact_person'] ?? 'Harita Uzmanı'); ?>
      },
      "publisher": {
        "@type": "Organization",
        "name": "Ant Harita Mühendislik",
        "url": "https://www.parselsorgu.net"
      },
      "url": <?php echo json_encode("https://www.parselsorgu.net/forum?slug=" . urlencode($single_post['slug'])); ?>
    }
    </script>
<?php endif; ?>
    
    <link rel="icon" href="/favicon.ico">
    <link rel="stylesheet" href="/assets/css/forum.css?v=2026.1">
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

    <!-- Header -->
    <?php render_saas_navbar('forum'); ?>

    <div class="container">
        
        <!-- Alerts -->
        <?php if (!empty($success_msg)): ?>
            <div class="alert-success">✓ <?php echo htmlspecialchars($success_msg); ?></div>
        <?php endif; ?>
        <?php if (!empty($error_msg)): ?>
            <div class="alert-error">✗ <?php echo htmlspecialchars($error_msg); ?></div>
        <?php endif; ?>

        <?php if ($single_post): ?>
            <!-- ========================================== -->
            <!-- SINGLE POST VIEW                           -->
            <!-- ========================================== -->
            <div style="margin-bottom:16px;">
                <a href="/forum" style="font-size:13px; font-weight:bold;">&larr; Tüm Haritacı İlanlarına Dön</a>
            </div>

            <article class="single-post-view">
                <div class="post-header">
                    <span class="type-badge <?php echo $single_post['type'] === 'is_verin' ? 'badge-is-verin' : 'badge-is-ariyorum'; ?>">
                        <?php echo $single_post['type'] === 'is_verin' ? '🏢 HARİTACI ARANIYOR (İŞ İLANI)' : '👤 İŞ ARIYORUM (HARİTACI)'; ?>
                    </span>
                    <span style="font-size:12px; color:var(--text-muted);">📅 <?php echo date('d.m.Y H:i', strtotime($single_post['created_at'])); ?> &bull; 👁️ <?php echo intval($single_post['view_count']); ?> Görüntülenme</span>
                </div>

                <h1 style="font-size:24px; font-weight:900; color:#fff; margin-bottom:12px;"><?php echo htmlspecialchars($single_post['title']); ?></h1>

                <div class="post-meta">
                    <span>📍 <strong><?php echo htmlspecialchars($single_post['city']); ?><?php echo !empty($single_post['district']) ? ' / ' . htmlspecialchars($single_post['district']) : ''; ?></strong></span>
                    <span>🎓 Pozisyon: <strong><?php echo htmlspecialchars($single_post['category']); ?></strong></span>
                    <?php if (!empty($single_post['company_name'])): ?>
                        <span>🏢 Firma/Büro: <strong><?php echo htmlspecialchars($single_post['company_name']); ?></strong></span>
                    <?php endif; ?>
                    <span>💰 Maaş/Ücret: <strong style="color:#4ade80;"><?php echo htmlspecialchars($single_post['salary_range']); ?></strong></span>
                    <span>⏳ Deneyim: <strong><?php echo htmlspecialchars($single_post['experience_years']); ?></strong></span>
                </div>

                <div class="post-tags">
                    <span class="ptag">💻 CAD: <?php echo htmlspecialchars($single_post['cad_programs']); ?></span>
                    <span class="ptag">🛰️ Cihaz/Donanım: <?php echo htmlspecialchars($single_post['equipment']); ?></span>
                </div>

                <!-- Detaylı Açıklama -->
                <div class="single-desc">
                    <?php echo nl2br(htmlspecialchars($single_post['description'])); ?>
                </div>

                <!-- İletişim Kutusu -->
                <div class="contact-box">
                    <div>
                        <div style="font-size:13px; color:#94a3b8;">İletişim Kurulacak Kişi / Yetkili:</div>
                        <div style="font-size:16px; font-weight:900; color:#fff;"><?php echo htmlspecialchars($single_post['contact_person']); ?></div>
                        <?php if (!empty($single_post['email'])): ?>
                            <div style="font-size:12px; color:#38bdf8;"><?php echo htmlspecialchars($single_post['email']); ?></div>
                        <?php endif; ?>
                    </div>
                    <div style="display:flex; gap:10px; flex-wrap:wrap;">
                        <a href="tel:<?php echo htmlspecialchars($single_post['phone']); ?>" style="background:#0284c7; color:#fff; font-weight:bold; padding:10px 18px; border-radius:6px; font-size:13px; text-decoration:none;">
                            📞 Hemen Ara: <?php echo htmlspecialchars($single_post['phone']); ?>
                        </a>
                        <a href="https://wa.me/90<?php echo preg_replace('/[^0-9]/', '', $single_post['phone']); ?>?text=Merhaba%2C%20Parsel%20Pro%20Haritac%C4%B1%20Forumundaki%20%22<?php echo urlencode($single_post['title']); ?>%22%20ilan%C4%B1n%C4%B1z%20i%C3%A7in%20yaz%C4%B1yorum." target="_blank" style="background:#16a34a; color:#fff; font-weight:bold; padding:10px 18px; border-radius:6px; font-size:13px; text-decoration:none;">
                            💬 WhatsApp'tan Yaz
                        </a>
                    </div>
                </div>

                <!-- Yorumlar & Cevaplar -->
                <div style="margin-top:36px;">
                    <h3 style="font-size:18px; font-weight:800; color:#fff; margin-bottom:16px;">💬 Meslektaş Yanıtları ve Başvurular (<?php echo count($replies); ?>)</h3>
                    
                    <?php if (empty($replies)): ?>
                        <div style="padding:16px; background:#090e17; border-radius:6px; color:#94a3b8; font-size:13px;">Bu ilana henüz bir yanıt yazılmadı. İlk yanıtı veya iletişim notunu siz bırakabilirsiniz.</div>
                    <?php else: ?>
                        <?php foreach ($replies as $rep): ?>
                            <div class="reply-item">
                                <div style="display:flex; justify-content:space-between; margin-bottom:6px; font-size:12px;">
                                    <strong style="color:var(--accent-cyan);"><?php echo htmlspecialchars($rep['author_name']); ?> (<?php echo htmlspecialchars($rep['author_title']); ?>)</strong>
                                    <span style="color:#64748b;"><?php echo date('d.m.Y H:i', strtotime($rep['created_at'])); ?></span>
                                </div>
                                <div style="font-size:13.5px; color:#e2e8f0;"><?php echo nl2br(htmlspecialchars($rep['message'])); ?></div>
                                <?php if (!empty($rep['author_phone'])): ?>
                                    <div style="margin-top:6px; font-size:11.5px; color:#34d399;">📞 İletişim: <?php echo htmlspecialchars($rep['author_phone']); ?></div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>

                    <!-- Yanıt Ekleme Formu -->
                    <div style="background:#090e17; border:1px solid #1e293b; border-radius:8px; padding:20px; margin-top:20px;">
                        <h4 style="font-size:14px; color:#fff; margin-bottom:12px;">✍️ İlana Not / Başvuru Bırak</h4>
                        <form method="POST">
                            <input type="hidden" name="action_reply" value="1">
                            <input type="hidden" name="post_id" value="<?php echo $single_post['id']; ?>">
                            <div class="form-grid-2">
                                <div class="form-row">
                                    <label class="form-label">Adınız Soyadınız *</label>
                                    <input type="text" name="author_name" required class="form-input" placeholder="Örn: Ahmet Yılmaz">
                                </div>
                                <div class="form-row">
                                    <label class="form-label">Unvanınız / Mesleğiniz</label>
                                    <input type="text" name="author_title" class="form-input" placeholder="Örn: Harita Mühendisi / Tekniker">
                                </div>
                            </div>
                            <div class="form-row">
                                <label class="form-label">Telefon Numaranız (Opsiyonel)</label>
                                <input type="text" name="author_phone" class="form-input" placeholder="05XX XXX XX XX">
                            </div>
                            <div class="form-row">
                                <label class="form-label">Mesajınız / Başvuru Notunuz *</label>
                                <textarea name="message" rows="3" required class="form-textarea" placeholder="İlanla ilgileniyorum, tecrübelerim..."></textarea>
                            </div>
                            <button type="submit" class="btn-top" style="cursor:pointer; border:none; padding:10px 20px;">Cevabı Gönder &raquo;</button>
                        </form>
                    </div>
                </div>
            </article>

        <?php else: ?>
            <!-- ========================================== -->
            <!-- MAIN FORUM LIST & DIRECTORY                -->
            <!-- ========================================== -->

            <!-- Hero Section -->
            <section class="forum-hero">
                <h1>Harita Kadastro İş İlanları &amp; Mühendis Kariyer</h1>
                <p>
                    Türkiye'nin 81 ilinde Harita ve Kadastro Mühendisleri, Harita Teknikerleri, Alet Operatörleri, Şantiye Ölçüm Uzmanları ve CBS Uzmanları için oluşturulmuş resmî kariyer ve iş birliği platformu.
                </p>
                <div class="hero-stats">
                    <span class="stat-badge">🏢 <strong><?php echo $count_is_verin; ?></strong> Açık İş İlanı</span>
                    <span class="stat-badge">👤 <strong><?php echo $count_is_ariyorum; ?></strong> İş Arayan Meslektaş</span>
                    <span class="stat-badge">📍 <strong>81 İl</strong> Aktif Kapsama</span>
                    <span class="stat-badge">⚡ <strong>Ücretsiz</strong> Anında İlan</span>
                </div>
            </section>

            <!-- Action & Filter Bar -->
            <div class="action-bar">
                <div class="filter-group">
                    <a href="/forum" class="filter-btn <?php echo empty($filter_type) ? 'active' : ''; ?>">Tüm İlanlar</a>
                    <a href="/forum?type=is_verin" class="filter-btn <?php echo $filter_type === 'is_verin' ? 'active' : ''; ?>">🏢 Haritacı Arayanlar (İş Veren)</a>
                    <a href="/forum?type=is_ariyorum" class="filter-btn <?php echo $filter_type === 'is_ariyorum' ? 'active' : ''; ?>">👤 İş Arayan Haritacılar</a>
                </div>
                <button onclick="openModal()" class="btn-post-ad">
                    <span>➕</span> Ücretsiz İlan Yayınla
                </button>
            </div>

            <!-- Main Layout -->
            <div class="forum-layout">
                
                <!-- Posts Feed -->
                <main>
                    <?php if (empty($posts)): ?>
                        <div style="background:var(--card-bg); border:1px solid var(--border); border-radius:10px; padding:48px 24px; text-align:center; color:var(--text-muted);">
                            <div style="font-size:42px; margin-bottom:12px;">📐</div>
                            <h3 style="font-size:18px; color:#fff; margin-bottom:6px;">Aradığınız kriterlere uygun ilan bulunamadı</h3>
                            <p style="font-size:13px; margin-bottom:16px;">İlk ilanı siz vererek binlerce harita mühendisi ve firmaya hemen ulaşabilirsiniz.</p>
                            <button onclick="openModal()" class="btn-post-ad">İlan Yayınla &raquo;</button>
                        </div>
                    <?php else: ?>
                        <?php foreach ($posts as $p): ?>
                            <article class="post-card">
                                <div class="post-header">
                                    <span class="type-badge <?php echo $p['type'] === 'is_verin' ? 'badge-is-verin' : 'badge-is-ariyorum'; ?>">
                                        <?php echo $p['type'] === 'is_verin' ? '🏢 HARİTACI ARANIYOR' : '👤 İŞ ARIYORUM'; ?>
                                    </span>
                                    <span style="font-size:12px; color:var(--text-muted);">
                                        📍 <?php echo htmlspecialchars($p['city']); ?><?php echo !empty($p['district']) ? ' / ' . htmlspecialchars($p['district']) : ''; ?> &bull; 
                                        📅 <?php echo date('d.m.Y', strtotime($p['created_at'])); ?>
                                    </span>
                                </div>

                                <h2 class="post-title">
                                    <a href="/forum?slug=<?php echo urlencode($p['slug']); ?>"><?php echo htmlspecialchars($p['title']); ?></a>
                                </h2>

                                <div class="post-meta">
                                    <span>🎓 <strong><?php echo htmlspecialchars($p['category']); ?></strong></span>
                                    <?php if (!empty($p['company_name'])): ?>
                                        <span>🏢 <?php echo htmlspecialchars($p['company_name']); ?></span>
                                    <?php endif; ?>
                                    <span>💰 <strong style="color:#4ade80;"><?php echo htmlspecialchars($p['salary_range']); ?></strong></span>
                                    <span>⏳ <?php echo htmlspecialchars($p['experience_years']); ?></span>
                                </div>

                                <div class="post-tags">
                                    <span class="ptag">💻 <?php echo htmlspecialchars($p['cad_programs']); ?></span>
                                    <span class="ptag">🛰️ <?php echo htmlspecialchars($p['equipment']); ?></span>
                                </div>

                                <p class="post-desc-snippet"><?php echo htmlspecialchars($p['description']); ?></p>

                                <div class="post-footer">
                                    <span style="color:#94a3b8; font-size:12px;">👤 Yetkili: <strong><?php echo htmlspecialchars($p['contact_person']); ?></strong></span>
                                    <a href="/forum?slug=<?php echo urlencode($p['slug']); ?>" style="color:var(--accent-cyan); font-weight:bold;">
                                        İlanı İncele &amp; Başvur &rarr;
                                    </a>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </main>

                <!-- Sidebar -->
                <aside>
                    <!-- Fast Search Box -->
                    <div class="widget-box">
                        <div class="widget-title">🔍 İlanlarda Ara</div>
                        <form method="GET" action="/forum">
                            <?php if ($filter_type): ?>
                                <input type="hidden" name="type" value="<?php echo htmlspecialchars($filter_type); ?>">
                            <?php endif; ?>
                            <div class="form-row">
                                <input type="text" name="q" value="<?php echo htmlspecialchars($search_q); ?>" placeholder="Şehir, yazılım veya anahtar kelime..." class="form-input">
                            </div>
                            <div class="form-row">
                                <select name="category" class="form-select">
                                    <option value="">Tüm Uzmanlıklar</option>
                                    <option value="Harita Mühendisi" <?php echo $filter_category === 'Harita Mühendisi' ? 'selected' : ''; ?>>Harita Mühendisi</option>
                                    <option value="Harita Teknikeri" <?php echo $filter_category === 'Harita Teknikeri' ? 'selected' : ''; ?>>Harita Teknikeri</option>
                                    <option value="Alet Operatörü / Ölçümcü" <?php echo $filter_category === 'Alet Operatörü / Ölçümcü' ? 'selected' : ''; ?>>Alet Operatörü / Ölçümcü</option>
                                    <option value="Netcad & İmar Uzmanı" <?php echo $filter_category === 'Netcad & İmar Uzmanı' ? 'selected' : ''; ?>>Netcad & İmar Uzmanı</option>
                                    <option value="CBS / GIS Uzmanı" <?php echo $filter_category === 'CBS / GIS Uzmanı' ? 'selected' : ''; ?>>CBS / GIS Uzmanı</option>
                                    <option value="Drone & Lidar Operatörü" <?php echo $filter_category === 'Drone & Lidar Operatörü' ? 'selected' : ''; ?>>Drone & Lidar Operatörü</option>
                                    <option value="Stajyer Harita Öğrencisi" <?php echo $filter_category === 'Stajyer Harita Öğrencisi' ? 'selected' : ''; ?>>Stajyer Harita Öğrencisi</option>
                                </select>
                            </div>
                            <button type="submit" class="btn-top" style="width:100%; border:none; cursor:pointer; padding:9px;">Filtrele</button>
                        </form>
                    </div>

                    <!-- Category List -->
                    <div class="widget-box">
                        <div class="widget-title">📌 Popüler Meslek Alanları</div>
                        <ul style="list-style:none; font-size:13px; line-height:2.2;">
                            <li><a href="/forum?category=Harita+Mühendisi">📐 Harita Mühendisleri</a></li>
                            <li><a href="/forum?category=Harita+Teknikeri">🛰️ Harita Teknikerleri</a></li>
                            <li><a href="/forum?category=Alet+Operatörü+%2F+Ölçümcü">🔭 GNSS & Total Station Operatörleri</a></li>
                            <li><a href="/forum?category=Netcad+%26+İmar+Uzmanı">💻 Netcad 18. Madde & İfraz Büroları</a></li>
                            <li><a href="/forum?category=Drone+%26+Lidar+Operatörü">🛸 İHA Drone Harita Pilotları</a></li>
                        </ul>
                    </div>

                    <!-- Safety & Rules -->
                    <div class="widget-box" style="border-color:rgba(250,204,21,0.3);">
                        <div class="widget-title" style="color:#facc15;">⚠️ İlan Kuralları &amp; Güvenlik</div>
                        <p style="font-size:12px; color:#cbd5e1; line-height:1.6;">
                            Parsel Pro Haritacı Forumu, mühendislik meslek etiğine ve TMMOB Harita ve Kadastro Mühendisleri Odası ilkelerine saygılı bir platformdur. Asılsız ilanlar ve yetkisiz aracılık girişimleri anında sistemden kaldırılır.
                        </p>
                    </div>
                </aside>

            </div>

        <?php endif; ?>

    </div>

    <!-- ========================================== -->
    <!-- MODAL: YENİ İLAN YAYINLAMA FORMU           -->
    <!-- ========================================== -->
    <div id="postModal" class="modal-overlay" onclick="closeModalOnBg(event)">
        <div class="modal-card">
            <div class="modal-header">
                <h3 style="font-size:18px; font-weight:900; color:#fff;">➕ Yeni Haritacı İlanı Oluştur</h3>
                <button onclick="closeModal()" class="modal-close">&times;</button>
            </div>

            <form method="POST">
                <input type="hidden" name="action_create_post" value="1">

                <div class="form-row">
                    <label class="form-label">İlan Türü *</label>
                    <select name="type" required class="form-select" onchange="toggleFormType(this.value)">
                        <option value="is_verin">🏢 Şirket/Büroyum: Haritacı Arıyorum (İş İlanı)</option>
                        <option value="is_ariyorum">👤 Haritacıyım: İş Arıyorum (Özgeçmiş / İlan)</option>
                    </select>
                </div>

                <div class="form-grid-2">
                    <div class="form-row">
                        <label class="form-label">Uzmanlık Pozisyonu *</label>
                        <select name="category" required class="form-select">
                            <option value="Harita Mühendisi">Harita Mühendisi (Lisans)</option>
                            <option value="Harita Teknikeri">Harita Teknikeri (Ön Lisans)</option>
                            <option value="Alet Operatörü / Ölçümcü">Alet Operatörü (Total Station / GNSS)</option>
                            <option value="Netcad & İmar Uzmanı">Netcad 18. Madde & İmar Uzmanı</option>
                            <option value="CBS / GIS Uzmanı">CBS / GIS / Python Uzmanı</option>
                            <option value="Drone & Lidar Operatörü">Drone & Fotogrametri Pilotu</option>
                            <option value="Stajyer Harita Öğrencisi">Stajyer Harita Öğrencisi</option>
                        </select>
                    </div>
                    <div class="form-row">
                        <label class="form-label">İl / Şehir *</label>
                        <input type="text" name="city" required class="form-input" placeholder="Örn: Ankara, İstanbul, Antalya">
                    </div>
                </div>

                <div class="form-grid-2">
                    <div class="form-row">
                        <label class="form-label">İlçe / Bölge</label>
                        <input type="text" name="district" class="form-input" placeholder="Örn: Çankaya, Kadıköy">
                    </div>
                    <div class="form-row" id="companyRow">
                        <label class="form-label">Firma / Mühendislik Bürosu Adı</label>
                        <input type="text" name="company_name" class="form-input" placeholder="Örn: Ant Harita Ltd. Şti.">
                    </div>
                </div>

                <div class="form-row">
                    <label class="form-label">İlan Başlığı *</label>
                    <input type="text" name="title" required class="form-input" placeholder="Örn: Şantiyemizde Çalışacak GNSS Bilen Harita Mühendisi Aranıyor">
                </div>

                <div class="form-grid-2">
                    <div class="form-row">
                        <label class="form-label">İletişim Kurulacak Yetkili *</label>
                        <input type="text" name="contact_person" required class="form-input" placeholder="Adınız Soyadınız">
                    </div>
                    <div class="form-row">
                        <label class="form-label">Telefon Numarası * (Aramalar İçin)</label>
                        <input type="text" name="phone" required class="form-input" placeholder="0542 XXX XX XX">
                    </div>
                </div>

                <div class="form-grid-2">
                    <div class="form-row">
                        <label class="form-label">E-Posta Adresi (Opsiyonel)</label>
                        <input type="email" name="email" class="form-input" placeholder="ik@firma.com">
                    </div>
                    <div class="form-row">
                        <label class="form-label">Maaş / Ücret Skalası</label>
                        <input type="text" name="salary_range" class="form-input" placeholder="Örn: 45.000 - 65.000 TL veya Görüşülecek">
                    </div>
                </div>

                <div class="form-grid-2">
                    <div class="form-row">
                        <label class="form-label">Deneyim Süresi</label>
                        <select name="experience_years" class="form-select">
                            <option value="Yeni Mezun / Deneyimsiz">Yeni Mezun / Deneyimsiz</option>
                            <option value="1-3 Yıl Deneyimli" selected>1-3 Yıl Deneyimli</option>
                            <option value="3-5 Yıl Deneyimli">3-5 Yıl Deneyimli</option>
                            <option value="5-10 Yıl Kıdemli">5-10 Yıl Kıdemli</option>
                            <option value="10+ Yıl Uzman">10+ Yıl Uzman / Şef</option>
                        </select>
                    </div>
                    <div class="form-row">
                        <label class="form-label">Bilinmesi Gereken CAD/CBS Yazılımları</label>
                        <input type="text" name="cad_programs" class="form-input" value="Netcad, AutoCAD" placeholder="Netcad, AutoCAD, Civil 3D, ArcGIS...">
                    </div>
                </div>

                <div class="form-row">
                    <label class="form-label">Kullanılan Cihazlar / Donanımlar</label>
                    <input type="text" name="equipment" class="form-input" value="GNSS / RTK, Total Station" placeholder="Leica, Trimble, CHCNAV, Nivo, Drone...">
                </div>

                <div class="form-row">
                    <label class="form-label">İlan Detayları ve Açıklaması *</label>
                    <textarea name="description" rows="5" required class="form-textarea" placeholder="İş tanımı, aranan nitelikler, çalışma koşulları, yemek/servis/konaklama imkanları veya mesleki geçmişiniz hakkında detaylı bilgi yazınız..."></textarea>
                </div>

                <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:16px;">
                    <button type="button" onclick="closeModal()" style="background:#1e293b; color:#cbd5e1; border:none; padding:10px 18px; border-radius:6px; cursor:pointer;">Vazgeç</button>
                    <button type="submit" class="btn-post-ad" style="font-size:14px; padding:10px 24px;">✓ İlanı Yayınla</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Master Footer -->
    <footer style="background:#060a14; border-top:1px solid #1e293b; padding:28px 24px; text-align:center; font-size:12px; color:var(--text-muted); margin-top:60px;">
        <div style="margin-bottom:8px;">
            <strong>ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ</strong> &bull; Haritacı Kariyer &amp; İş Platformu
        </div>
        <div>
            0542 841 35 35 &bull; <a href="https://www.parselsorgu.net" style="color:var(--accent-cyan);">www.parselsorgu.net</a> &bull; &copy; 2026 Tüm Hakları Saklıdır.
        </div>
    </footer>

    <!-- Scripts -->
    <script src="/assets/js/forum.js?v=2026.1"></script>
    <!-- Real-Time Web Analytics Engine -->
    <script src="/analytics.js" defer></script>
</body>
</html>
