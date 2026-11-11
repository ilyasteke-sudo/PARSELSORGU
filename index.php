<?php
/**
 * ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ - PARSEL PRO
 * TKGM MEGSİS CANLI PARSEL SORGULAMA VE CBS HARİTA MERKEZİ (index.php)
 * Pure PHP 8.1+ / Leaflet 1.9.4 / Google Satellite & ESRI & OSM / 37 Otonom Modül
 */
declare(strict_types=1);
ini_set('zlib.output_compression', '0');
ob_start();
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/navbar.php';
$page_title = "Parsel Sorgulama - TKGM Ada Parsel & İmar | ParselSorgu";
$meta_desc = "Türkiye geneli 81 il ve 973 ilçede canlı TKGM ada parsel sorgulama, uydu kadastro haritası ve e-imar analiz araçları. Ada/parsel ile anında inceleyin.";
$canonical_url = "https://www.parselsorgu.net/";
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title><?= htmlspecialchars($page_title) ?></title>
    <meta name="description" content="<?= htmlspecialchars($meta_desc) ?>">
    <link rel="canonical" href="<?= $canonical_url ?>">
<link rel="alternate" type="text/markdown" href="https://www.parselsorgu.net/llms.txt" title="ParselSorgu AI Knowledge Base">
    <link rel="alternate" type="application/json" href="https://www.parselsorgu.net/api/2026-kadastro-endeks.json" title="2026 Türkiye Kadastro ve İnşaat Açık Veri Seti">
    <link rel="alternate" hreflang="tr" href="https://www.parselsorgu.net/" />
    <link rel="alternate" hreflang="x-default" href="https://www.parselsorgu.net/" />
    <meta property="og:title" content="<?= htmlspecialchars($page_title) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($meta_desc) ?>">
    <meta property="og:url" content="<?= $canonical_url ?>">
    <meta property="og:type" content="website">
    <meta property="og:image" content="https://www.parselsorgu.net/assets/images/og-parsel.jpg">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="theme-color" content="#090e17">
    <link rel="manifest" href="/manifest.json">
    <link rel="apple-touch-icon" href="/assets/icon-192.png">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="ParselSorgu">
    <!-- High Speed Preconnects & DNS Prefetch -->
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
    <link rel="dns-prefetch" href="https://cdnjs.cloudflare.com">
    <link rel="preconnect" href="https://mt0.google.com">
    <link rel="dns-prefetch" href="https://mt0.google.com">
    <link rel="preconnect" href="https://mt1.google.com">
    <link rel="dns-prefetch" href="https://mt1.google.com">
    <link rel="preconnect" href="https://api.open-meteo.com" crossorigin>
    <!-- Leaflet 1.9.4 CSS (Non-blocking) -->
    <!-- ZERO RENDER-BLOCKING ASYNC CSS (100% LIGHTHOUSE COMPLIANT) -->
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    </noscript>
    <!-- Schema.org WebApplication -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@graph": [
        {
          "@type": "Organization",
          "@id": "https://www.parselsorgu.net/#organization",
          "name": "Ant Harita Mühendislik Teknolojileri - ParselSorgu.net",
          "url": "https://www.parselsorgu.net/",
          "logo": {
            "@type": "ImageObject",
            "url": "https://www.parselsorgu.net/assets/images/logo.png",
            "width": 512,
            "height": 512
          },
          "image": "https://www.parselsorgu.net/assets/images/og-parsel.jpg",
          "telephone": "+90-542-841-35-35",
          "email": "iletisim@parselsorgu.net",
          "address": {
            "@type": "PostalAddress",
            "streetAddress": "Mustafa Kemal Mah. 2118. Cad. No:4",
            "addressLocality": "Çankaya",
            "addressRegion": "Ankara",
            "addressCountry": "TR"
          },
          "sameAs": [
            "https://www.antharita.com",
            "https://github.com/ilyasteke-sudo/PARSELSORGU",
            "https://www.parselsorgu.net/2026-kadastro-insaat-referans-verileri",
            "https://www.parselsorgu.net/api/2026-kadastro-endeks.json",
            "https://www.parselsorgu.net/telegram-botu",
            "https://www.parselsorgu.net/partner-harita-muhendisleri"
          ],
          "knowsAbout": [
            "TKGM Canlı Parsel Sorgulama",
            "MEGSİS Kadastro Haritası",
            "3194 Sayılı İmar Kanunu",
            "2026 LİHKAB Aplikasyon ve Cins Değişikliği Harçları",
            "2026 İnşaat Maliyeti ve SGK Asgari İşçilik Hesaplama",
            "5403 Sayılı Toprak Koruma Kanunu Tarla İfrazı",
            "Tiny House ve Çekme Karavan İmar Mevzuatı",
            "Miras Paylaşımı, Şufa ve İzale-i Şüyu Hesaplama",
            "2B ve Hazine Arazisi Satın Alma (6292 s.K.)"
          ]
        },
        {
          "@type": "WebApplication",
          "@id": "https://www.parselsorgu.net/#webapp",
          "name": "ParselSorgu.net TKGM Canlı Parsel, Kadastro & İnşaat Analiz Platformu",
          "url": "https://www.parselsorgu.net/",
          "applicationCategory": "GISApplication",
          "sameAs": "https://github.com/ilyasteke-sudo/PARSELSORGU",
          "operatingSystem": "All",
          "provider": { "@id": "https://www.parselsorgu.net/#organization" },
          "offers": {
            "@type": "Offer",
            "price": "0",
            "priceCurrency": "TRY"
          },
          "aggregateRating": {
            "@type": "AggregateRating",
            "ratingValue": "4.9",
            "reviewCount": "14820"
          },
          "hasPart": [
            { "@type": "WebApplication", "name": "2D TAKS/KAKS İmar Çapı Simülatörü", "url": "https://www.parselsorgu.net/taks-kaks-hesaplama" },
            { "@type": "WebApplication", "name": "2026 İnşaat Ruhsatı, SGK & Harç Motoru", "url": "https://www.parselsorgu.net/insaat-ruhsati-harc-hesaplama" },
            { "@type": "WebApplication", "name": "Tarla Tel Çit & Duvar Maliyet Motoru", "url": "https://www.parselsorgu.net/tel-cit-duvar-maliyet" },
            { "@type": "WebApplication", "name": "Tiny House & Karavan Mühür Riski Motoru", "url": "https://www.parselsorgu.net/tiny-house-imar-uygunluk" },
            { "@type": "WebApplication", "name": "2026 LİHKAB & Kadastro Harç Hesaplayıcı", "url": "https://www.parselsorgu.net/lihkab-hesaplama" },
            { "@type": "WebApplication", "name": "Miras Paylaşımı & Veraset İntikal Hesaplayıcı", "url": "https://www.parselsorgu.net/miras-paylasimi-veraset-intikal" },
            { "@type": "WebApplication", "name": "Şufa (Ön Alım) Süre & İhtarname Motoru", "url": "https://www.parselsorgu.net/sufa-on-alim-hakki" },
            { "@type": "WebApplication", "name": "Saha Telegram Botu & Copernicus DEM Eğim", "url": "https://www.parselsorgu.net/telegram-botu" }
          ],
          "speakable": {
            "@type": "SpeakableSpecification",
            "cssSelector": ["h1", ".hero-banner p", "#parcel-smart-funnel"]
          }
        }
      ]
    }
    </script>
    <link rel="stylesheet" href="/assets/css/home_core.css?v=2026.1">
    <script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    {
      "@type": "Question",
      "name": "ParselSorgu.net üzerinden sorgulama yapmak ücretsiz midir?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Evet. 81 il ve 973 ilçede canlı TKGM MEGSİS ada parsel sorgulama, uydu kadastro haritası ve temel mühendislik hesaplayıcıları platformumuzda tamamen ücretsiz ve şifresiz olarak hizmet vermektedir."
      }
    },
    {
      "@type": "Question",
      "name": "Ada ve parsel numaramı bilmiyorsam yerimi nasıl bulabilirim?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Arazinizin üzerindeyken harita panelindeki 'Arazideki Konumumu GPS ile Bul' butonuna tıklayarak doğrudan cihazınızın GPS koordinatlarına yakınlaşabilir veya tapu senedinizin üzerindeki İl, İlçe, Mahalle bilgilerini seçtikten sonra haritayı kaydırarak arsanızı uydu görüntüsünden tespit edebilirsiniz."
      }
    },
    {
      "@type": "Question",
      "name": "TKGM MEGSİS verileri ne kadar günceldir?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Sorgulamalar doğrudan Tapu ve Kadastro Genel Müdürlüğü'nün canlı CBS API servisleri üzerinden anlık olarak gerçekleştirilir. Kadastro müdürlükleri tarafından sisteme tescil edilen ifraz, tevhid, terk veya yola ayrılma işlemleri eşzamanlı olarak haritaya yansır."
      }
    },
    {
      "@type": "Question",
      "name": "Tarlaya ev veya tiny house yapmak için imar şartları nelerdir?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Plansız alanlarda bağ evi veya tarımsal yapı yapılabilmesi için parselin en az 5.000 m² olması, kadastral veya resmi yola en az 25 metre cephesi bulunması şarttır. Toplam yapı alanı 250 m²'yi ve taban alanı katsayısı %5'i geçemez."
      }
    },
    {
      "@type": "Question",
      "name": "TAKS ve KAKS (Emsal) oranları inşaat alanını nasıl belirler?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "TAKS (Taban Alanı Kat Sayısı) binanın zeminde oturabileceği maksimum taban alanını, KAKS (Emsal) ise parselde yapılabilecek toplam net kapalı inşaat alanını belirler."
      }
    },
    {
      "@type": "Question",
      "name": "Hisseli tarlalarda rıza-i taksim sözleşmesi ve şufa (önalım) riski nedir?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Hisseli tapularda rıza-i taksim sözleşmesi hissedarların nereyi kullanacağını yazılı hale getirir. Üçüncü şahsa hisse satışında diğer hissedarların TMK Madde 732 uyarınca 90 günlük Şufa (Önalım) davası açma hakkı bulunur."
      }
    }
  ]
}
    </script>
    <script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "HowTo",
  "name": "Ada Parsel Sorgulama ve İmar Analizi Nasıl Yapılır?",
  "description": "81 il ve 973 ilçede resmi TKGM MEGSİS kadastro haritası üzerinden ada parsel sorgulama, köşe koordinatları ve imar analiz adımları.",
  "step": [
    {
      "@type": "HowToStep",
      "name": "İdari Konum veya GPS Belirleme",
      "text": "81 il, 973 ilçe ve mahalle seçimi yapın veya 'Arazideki Konumumu GPS ile Bul' butonuyla arazinizdeki koordinatınıza anında yakınlaşın."
    },
    {
      "@type": "HowToStep",
      "name": "Canlı Kadastro ve Parsel Köşelerini İnceleme",
      "text": "TKGM MEGSİS veritabanından gelen resmi sınır çizgilerini, köşe kazıklarını (K1, K2, K3...) ve yüzölçümünü canlı uydu haritasında inceleyin."
    },
    {
      "@type": "HowToStep",
      "name": "İmar, Hukuk ve Değerleme Analizini Tamamlama",
      "text": "37 otonom mühendislik modülüyle TAKS/KAKS inşaat alanınızı, yol terklerini, tarla ev uygunluğunu ve rayiç değerini hesaplayın."
    }
  ]
}
    </script>
</head>
<body>
<?= render_navbar('parsel') ?>
<?php
// SON DAKIKA: RESMI GAZETE & CSIDB ASKI IMAR TAKIP BOTU CANLI VERI CEKIMI
$rg_ticker_items = [];
$rg_seen_slugs = [];
$rg_last_run_time = date('d.m.Y H:i');
$rg_json_path = __DIR__ . '/data/resmi_gazete_bot_last_run.json';
if (file_exists($rg_json_path)) {
    $rg_json = json_decode(@file_get_contents($rg_json_path), true);
    if (!empty($rg_json['last_run'])) {
        $rg_last_run_time = $rg_json['last_run'];
    }
    if (!empty($rg_json['details']) && is_array($rg_json['details'])) {
        foreach ($rg_json['details'] as $rg_d) {
            $u = $rg_d['url'] ?? '';
            $slug_key = basename(parse_url($u, PHP_URL_PATH) ?: $u);
            if ($u && !isset($rg_seen_slugs[$slug_key])) {
                $rg_seen_slugs[$slug_key] = true;
                $clean_t = trim(str_replace(['🏛️ ', 'Resmi Gazete İlanı: '], '', $rg_d['title'] ?? ''));
                $rg_ticker_items[] = [
                    'city' => $rg_d['city'] ?? 'Türkiye',
                    'district' => $rg_d['district'] ?? '',
                    'title' => $clean_t,
                    'url' => '/imar/' . urlencode($slug_key),
                    'date' => $rg_d['date'] ?? date('d.m.Y'),
                    'status' => '30 Gün Askıda'
                ];
            }
        }
    }
}
// Performans: 15 dakikalık dosya önbelleği (68.800 satırlık FULL TABLE SCAN kaldırıldı!)
$rg_cache_file = __DIR__ . '/data/rg_ticker_cache.json';
if (file_exists($rg_cache_file) && (time() - filemtime($rg_cache_file) < 900)) {
    $cached_rg = json_decode(@file_get_contents($rg_cache_file), true);
    if (is_array($cached_rg)) {
        $rg_ticker_items = array_merge($rg_ticker_items, $cached_rg);
    }
} elseif (isset($pdo) && $pdo) {
    try {
        $fresh_rg = [];
        // Sadece son 400 satır içinde filtrele (Tam tablo taraması yapmaz, 2ms sürer)
        $stmt_rg_live = $pdo->query("SELECT title, slug, city, district, created_at FROM (SELECT id, title, slug, city, district, category, created_at FROM blog_articles ORDER BY id DESC LIMIT 400) AS recent WHERE category LIKE '%Resmi Gazete%' OR category LIKE '%Askı%' LIMIT 8");
        if ($stmt_rg_live) {
            while ($rg_r = $stmt_rg_live->fetch(PDO::FETCH_ASSOC)) {
                $slug_key = $rg_r['slug'];
                if ($slug_key && !isset($rg_seen_slugs[$slug_key])) {
                    $rg_seen_slugs[$slug_key] = true;
                    $clean_t = trim(str_replace(['🏛️ ', 'Resmi Gazete İlanı: '], '', $rg_r['title']));
                    $item = [
                        'city' => !empty($rg_r['city']) ? $rg_r['city'] : 'Türkiye',
                        'district' => $rg_r['district'] ?? '',
                        'title' => mb_substr($clean_t, 0, 95, 'UTF-8'),
                        'url' => '/imar/' . urlencode($slug_key),
                        'date' => !empty($rg_r['created_at']) ? date('d.m.Y', strtotime($rg_r['created_at'])) : date('d.m.Y'),
                        'status' => 'Askıda & İndeksli'
                    ];
                    $fresh_rg[] = $item;
                    $rg_ticker_items[] = $item;
                }
            }
        }
        @file_put_contents($rg_cache_file, json_encode($fresh_rg, JSON_UNESCAPED_UNICODE));
    } catch (Exception $e) {}
}
$rg_ticker_items = array_slice($rg_ticker_items, 0, 4);
if (!empty($rg_ticker_items)):
?>
<section class="rg-sondakika-bar" aria-label="Son Dakika Resmi Gazete ve Askı İmar İlanları">
<div class="rg-sondakika-inner">
<div class="rg-sd-badge-group">
<span class="rg-sd-pill">
<span class="rg-sd-dot" aria-hidden="true"></span>
<span>SON DAKİKA</span>
</span>
<a href="/imar" class="rg-sd-source" title="Resmi Gazete &amp; ÇŞİDB İmar Askı Botu">
<i class="fa-solid fa-landmark"></i>
<span>RESMİ GAZETE &amp; ASKI İMAR</span>
</a>
</div>

<div class="rg-sd-viewport">
<div class="rg-sd-track">
<?php for ($loop_i = 0; $loop_i < 2; $loop_i++): ?>
<?php foreach ($rg_ticker_items as $rg_item): ?>
<a href="<?= htmlspecialchars($rg_item['url']) ?>" class="rg-sd-item"<?= $loop_i === 1 ? ' aria-hidden="true" tabindex="-1"' : '' ?> title="<?= htmlspecialchars($rg_item['title']) ?>">
<span class="rg-sd-city"><?= htmlspecialchars($rg_item['city']) ?><?= !empty($rg_item['district']) ? ' / ' . htmlspecialchars($rg_item['district']) : '' ?></span>
<span class="rg-sd-text"><?= htmlspecialchars($rg_item['title']) ?></span>
<span class="rg-sd-date"><?= htmlspecialchars($rg_item['date']) ?></span>
</a>
<span class="rg-sd-sep" aria-hidden="true">&bull;</span>
<?php endforeach; ?>
<?php endfor; ?>
</div>
</div>

<div class="rg-sd-actions">
<button type="button" class="rg-sd-btn-list" id="rgSdListBtn" onclick="toggleRgSonDakikaDrawer()" aria-expanded="false" aria-controls="rgSdDrawer">
<i class="fa-solid fa-list-ul"></i>
<span>Son İlanlar (<?= count($rg_ticker_items) ?>)</span>
<i class="fa-solid fa-chevron-down" id="rgSdChevron" style="font-size:9px; transition:transform 0.2s;"></i>
</button>
<a href="/imar" class="rg-sd-btn-all" title="81 İl Tüm Resmi Gazete ve Belediye Askı İlanları">
<span>Tümü</span>
<i class="fa-solid fa-arrow-right"></i>
</a>
</div>
</div>

<div class="rg-sd-drawer" id="rgSdDrawer">
<div class="rg-sd-drawer-inner">
<div class="rg-sd-drawer-head">
<div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
<span style="font-size:13px; font-weight:800; color:#fbbf24;">
<i class="fa-solid fa-tower-broadcast" style="color:#ef4444;"></i> Resmi Gazete &amp; ÇŞİDB Canlı Askı İmar Takip Botu
</span>
<span style="font-size:11px; background:rgba(16,185,129,0.16); color:#34d399; border:1px solid rgba(16,185,129,0.3); padding:2px 8px; border-radius:9999px; font-weight:700;">
                        ● Bot Aktif &bull; Son Tarama: <?= htmlspecialchars($rg_last_run_time) ?>
</span>
</div>
<div style="display:flex; align-items:center; gap:10px;">
<a href="/imar" style="font-size:12px; font-weight:800; color:#38bdf8; text-decoration:none;">Tüm Askı Arşivine Git &raquo;</a>
<button type="button" onclick="toggleRgSonDakikaDrawer()" style="background:rgba(255,255,255,0.08); color:#cbd5e1; border:1px solid rgba(255,255,255,0.15); border-radius:5px; padding:3px 9px; font-size:11px; cursor:pointer;">Kapat &times;</button>
</div>
</div>
<div class="rg-sd-drawer-table-wrap">
<table class="rg-sd-table">
<thead>
<tr>
<th>Şehir / İlçe</th>
<th>Resmi Gazete &amp; Askı İlanı Başlığı</th>
<th>Tarih</th>
<th>Durum</th>
<th>İşlem</th>
</tr>
</thead>
<tbody>
<?php foreach ($rg_ticker_items as $rg_row): ?>
<tr>
<td style="white-space:nowrap; font-weight:700; color:#fcd34d;">
<?= htmlspecialchars($rg_row['city']) ?><?= !empty($rg_row['district']) ? ' / ' . htmlspecialchars($rg_row['district']) : '' ?>
</td>
<td>
<a href="<?= htmlspecialchars($rg_row['url']) ?>" style="color:#f8fafc; text-decoration:none; font-weight:600;">
<?= htmlspecialchars($rg_row['title']) ?>
</a>
</td>
<td style="white-space:nowrap; color:#94a3b8;"><?= htmlspecialchars($rg_row['date']) ?></td>
<td style="white-space:nowrap;">
<span style="background:rgba(16,185,129,0.15); color:#34d399; border:1px solid rgba(16,185,129,0.3); padding:2px 8px; border-radius:9999px; font-size:11px; font-weight:700;">
<?= htmlspecialchars($rg_row['status']) ?>
</span>
</td>
<td style="white-space:nowrap;">
<a href="<?= htmlspecialchars($rg_row['url']) ?>" style="color:#38bdf8; font-weight:800; text-decoration:none;">İncele &raquo;</a>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>
</div>
</div>
</section>
<script>
function toggleRgSonDakikaDrawer() {
    var d = document.getElementById('rgSdDrawer');
    var b = document.getElementById('rgSdListBtn');
    var c = document.getElementById('rgSdChevron');
    if (!d) return;
    var isOpen = d.classList.toggle('open');
    if (b) b.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    if (c) c.style.transform = isOpen ? 'rotate(180deg)' : 'rotate(0deg)';
}
</script>
<?php endif; ?>
<main id="main-content" role="main">
<div class="container">
<!-- MAIN SIDE-BY-SIDE CADASTRE WORKSPACE (TOP PRIORITY ABOVE THE FOLD) -->
<div class="cbs-layout">
<!-- SOL KONTROL KARTI -->
<div class="control-card">
<div class="card-header-title">
<i class="fa-solid fa-layer-group" style="color:var(--accent);"></i>
<span>Kadastro Parsel Seçimi</span>
</div>
<!-- İl Seçimi -->
<div class="form-group">
<label for="cbs-il"><i class="fa-solid fa-map"></i> İl Seçiniz</label>
<select id="cbs-il" name="il" aria-label="İl Seçiniz (81 İl)" class="form-control" onchange="loadIlceler()">
<option value="">-- İl Seçiniz (81 İl) --</option>
<?php foreach ($CITIES_81 as $id => $name): ?>
<option value="<?= $id ?>" <?= ($name === 'Ankara') ? 'selected' : '' ?>><?= $name ?></option>
<?php endforeach; ?>
</select>
</div>
<!-- İlçe Seçimi -->
<div class="form-group">
<label for="cbs-ilce"><i class="fa-solid fa-building"></i> İlçe Seçiniz</label>
<select id="cbs-ilce" name="ilce" aria-label="İlçe Seçiniz" class="form-control" onchange="loadMahalleler()">
<option value="">İlçeler Yükleniyor...</option>
</select>
</div>
<!-- Mahalle Seçimi -->
<div class="form-group">
<label for="cbs-mahalle"><i class="fa-solid fa-location-dot"></i> Mahalle / Köy</label>
<select id="cbs-mahalle" name="mahalle" aria-label="Mahalle ve Köy Seçiniz" class="form-control">
<option value="">Önce İlçe Seçin</option>
</select>
</div>
<!-- Ada / Parsel -->
<div class="grid-2">
<div class="form-group">
<label for="cbs-ada"><i class="fa-solid fa-hashtag"></i> Ada No</label>
<input type="text" id="cbs-ada" aria-label="Ada Numarası" name="ada" class="form-control" value="3425" placeholder="Örn: 3425">
</div>
<div class="form-group">
<label for="cbs-parsel"><i class="fa-solid fa-draw-polygon"></i> Parsel No</label>
<input type="text" id="cbs-parsel" aria-label="Parsel Numarası" name="parsel" class="form-control" value="9" placeholder="Örn: 9">
</div>
</div>
<button type="button" id="btn-cbs-query" class="btn-query" onclick="queryParsel()" aria-label="Resmi Kadastro Parselini Canlı Sorgula">
<i class="fa-solid fa-crosshairs"></i> Canlı Parsel Sorgula
</button>
<button type="button" class="btn-gps" onclick="locateUserGPS()" aria-label="Arazideki Konumumu GPS ile Canlı Bul">
<i class="fa-solid fa-location-crosshairs"></i> 📍 Arazideki Konumumu GPS ile Bul
</button>
<!-- HIZLI EKLENTİ VE MÜHENDİSLİK ARAÇLARI KISAYOLLARI -->
<div class="quick-sub-tools">
<div class="quick-sub-title">
<i class="fa-solid fa-puzzle-piece"></i> Hızlı Mühendislik Eklentileri
</div>
<div class="quick-sub-grid">
<a href="/tarla-ifraz-hesaplama" class="btn-sub-tool" title="5403 Tarla İfraz Hesaplayıcı">
<i class="fa-solid fa-ruler-combined" style="color:#10b981;"></i> Tarla İfrazı
</a>
<a href="/arsa-degerleme-hesaplama" class="btn-sub-tool" title="2026 Arsa Değerleme &amp; Rayiç Motoru">
<i class="fa-solid fa-coins" style="color:#38bdf8;"></i> Arsa Değerleme
</a>
<a href="/toplu-parsel-sorgulama" class="btn-sub-tool" title="Toplu Ada/Parsel Portföy Analizi">
<i class="fa-solid fa-layer-group" style="color:#a855f7;"></i> Toplu Parsel
</a>
<a href="/parsel-raporu" class="btn-sub-tool" title="Resmi Parsel &amp; İmar Ön İnceleme Raporu (PDF)">
<i class="fa-solid fa-file-pdf" style="color:#f43f5e;"></i> Resmi Rapor
</a>
</div>
</div>
<div class="info-box">
<strong style="color:#fff; display:block; margin-bottom:4px;">
<i class="fa-solid fa-shield-halved" style="color:var(--green);"></i> Resmi Kadastro Güvencesi:
</strong>
                Sorgulanan parsel sınırları, TKGM MEGSİS koordinat sistemiyle tam oturtulmuş GeoJSON vektör poligonu ile canlı uydu altlığına yerleştirilir.
</div>
</div>
<!-- SAĞ HARİTA ALANI -->
<div class="map-card">
<div class="map-top-bar">
<div style="display:flex; align-items:center; gap:8px;">
<i class="fa-solid fa-map-location-dot" style="color:var(--accent);"></i>
<strong style="font-size:13px; color:#fff;">Canlı Kadastro Uydu Haritası</strong>
</div>
<div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
<button type="button" id="btn-elevation-tool" class="map-action-btn" onclick="window.analyzeParcelElevation()" aria-label="Copernicus DEM Rakım ve Eğim Analizi" title="Seçili parselin deniz seviyesinden yüksekliğini ve ortalama % eğimini ölçün">
<i class="fa-solid fa-mountain"></i> Rakım &amp; Eğim
</button>
<button type="button" id="btn-nav-tool" class="map-action-btn" onclick="window.openParcelNavigation()" aria-label="Google Maps ile Parsel Konumuna Yol Tarifi Al" title="Tarlaya/Arsaya gitmek için navigasyon başlat" style="background:rgba(16,185,129,0.16); border-color:#10b981; color:#34d399;">
<i class="fa-solid fa-diamond-turn-right"></i> Yol Tarifi Al
</button>
<button type="button" id="btn-measure-tool" class="map-action-btn" onclick="window.toggleMeasureTool()" aria-label="Harita Üzerinde Mesafe ve Cephe Ölçüm Aracını Başlat" title="Harita üzerinde iki nokta arası mesafe ve yol cephesini ölçün">
<i class="fa-solid fa-ruler-combined"></i> Mesafe &amp; Cephe Ölç
</button>
<span class="map-badge">
<i class="fa-solid fa-circle" style="font-size:12px;"></i> Canlı CBS Vektör Aktif
</span>
</div>
</div>
<div id="parcel-elevation-banner" style="display:none; background:linear-gradient(90deg, #0f172a 0%, #1e293b 100%); border-bottom:1px solid rgba(56,189,248,0.25); padding:10px 16px; font-size:12.5px; color:#e2e8f0; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px;"></div>
<div id="parsel-map"></div>
</div>
</div>
<!-- PARSEL DETAY VE RESMİ RAPOR KARTI (5 STRATEJİK MÜHENDİSLİK ARACI ENTEGRELİ) -->
    
            
<!-- ÇEVREDEKİ SAHİBİNDEN.COM SATILIK İLANLARI (TKGM CANLI UYDU İLE SENKRON) -->
<div id="surrounding-listings-container" style="display:none; margin-top:20px; margin-bottom:20px; background:#0b1329; border:2px solid #ffe800; border-radius:14px; padding:20px; box-shadow:0 10px 25px rgba(0,0,0,0.6);">
<div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:16px; border-bottom:1px solid rgba(255,255,255,0.08); padding-bottom:12px;">
<div>
<div role="heading" aria-level="2" style="font-size:17px; font-weight:800; color:#ffe800; margin:0 0 4px 0; display:flex; align-items:center; gap:8px;">
<span style="background:#ffe800; color:#111827; border-radius:4px; padding:2px 6px; font-size:12px; font-weight:900;">sahibinden.com</span>
<span>Parsel Çevresindeki Emsal Satılık İlanlar &amp; Piyasa Rayiçleri</span>
</div>
<p style="font-size:13px; color:#94a3b8; margin:0;">
                            Sorguladığınız taşınmazın 500m çevresinde sahibinden.com emsal verileriyle tespit edilen satılık taşınmazlar ve gerçek piyasa değerleri.
</p>
</div>
<a id="btn-all-sahibinden-link" href="https://www.sahibinden.com/satilik-arsa" target="_blank" rel="noopener noreferrer" style="background:#ffe800; color:#111827; font-weight:800; font-size:12px; padding:6px 14px; border-radius:8px; text-decoration:none; display:inline-flex; align-items:center; gap:6px;">
                        Sahibinden.com'da Tüm Bölge İlanları ↗
</a>
</div>
<div id="surrounding-listings-grid" style="display:grid; grid-template-columns:repeat(auto-fill, minmax(270px, 1fr)); gap:14px;">
<!-- İlan kartları dinamik yüklenir -->
</div>
</div>
<div id="parcel-results-card" class="parcel-results-card">
<div style="display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid var(--border-color); padding-bottom:12px; margin-bottom:16px; flex-wrap:wrap; gap:10px;">
<div role="heading" aria-level="2" style="margin:0; font-size:16.5px; font-weight:700; color:#fff; display:flex; align-items:center; gap:8px;">
<i class="fa-solid fa-file-contract" style="color:var(--accent);"></i>
<span>Resmi Kadastro Parsel Raporu &amp; Mühendislik Çıktıları</span>
</div>
<div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
<button type="button" class="map-action-btn" onclick="window.openParcelPdfModal()" aria-label="Resmi Parsel Bilgi Raporunu PDF Olarak Yazdır" style="background:#0284c7; color:#fff; border-color:#0284c7;">
<i class="fa-solid fa-file-pdf"></i> Resmi Rapor (PDF)
</button>
<button type="button" class="map-action-btn" onclick="window.downloadParcelKML()" aria-label="Google Earth KML Dosyası İndir" style="background:#059669; color:#fff; border-color:#059669;">
<i class="fa-solid fa-earth-americas"></i> KML İndir
</button>
<button type="button" class="map-action-btn" onclick="window.downloadParcelDXF()" aria-label="Netcad AutoCAD DXF Dosyası İndir" style="background:#d97706; color:#fff; border-color:#d97706;">
<i class="fa-solid fa-draw-polygon"></i> Netcad / DXF
</button>
<button type="button" class="map-action-btn" onclick="window.shareParcelWhatsApp()" aria-label="Parsel Konumunu ve Koordinatlarını WhatsApp ile Paylaş" style="background:#22c55e; color:#fff; border-color:#22c55e;">
<i class="fa-brands fa-whatsapp"></i> WhatsApp Paylaş
</button>
<button type="button" id="btn-toggle-surrounding" class="map-action-btn" onclick="window.toggleSurroundingListings()" aria-label="Haritada Sahibinden.com Çevredeki Satılık İlanları Aç veya Kapat" style="background:#ffe800; color:#111827; border-color:#eab308; display:none; font-weight:800;">
<span style="background:#111827; color:#ffe800; border-radius:50%; width:14px; height:14px; display:inline-flex; align-items:center; justify-content:center; font-size:9px; font-weight:900;">S</span>
<span>Sahibinden İlanları (<span id="surrounding-count-badge">0</span>)</span>
</button>
</div>
</div>
<div id="parcel-details-content" style="display:grid; grid-template-columns: repeat(auto-fit, minmax(210px, 1fr)); gap:12px;">
<!-- Dinamik doldurulur -->
</div>
<!-- 2026 ARSA RAYİÇ & PİYASA DEĞERLEME KARTI -->
<div id="parcel-valuation-card" style="margin-top:16px; background:linear-gradient(135deg, rgba(30, 58, 138, 0.25) 0%, rgba(15, 23, 42, 0.8) 100%); border:1px solid rgba(56, 189, 248, 0.25); border-radius:10px; padding:14px 16px;">
<!-- Dinamik değerleme doldurulur -->
</div>
<!-- AKILLI SAAS & MÜHENDİSLİK TEKLİF HUNİSİ (STEP 1) -->
<div id="parcel-smart-funnel" style="margin-top:16px;"></div>
</div>
    
    
<!-- CANLI KADASTRO & MEVZUAT GÜNDEM ŞERİDİ (SOCIAL PROOF & ENGAGEMENT) -->
<div id="ps-live-ticker" style="background:linear-gradient(90deg, rgba(15,23,42,0.95) 0%, rgba(30,41,59,0.85) 100%); border:1px solid rgba(56,189,248,0.28); border-radius:10px; padding:8px 14px; margin:0 0 18px 0; display:flex; align-items:center; gap:12px; overflow:hidden; box-shadow:0 4px 12px rgba(0,0,0,0.25);">
<span style="background:rgba(239,68,68,0.18); border:1px solid rgba(239,68,68,0.45); color:#f87171; font-size:11px; font-weight:800; padding:3px 9px; border-radius:6px; white-space:nowrap; flex-shrink:0; display:inline-flex; align-items:center; gap:5px;">
<span style="width:7px; height:7px; background:#ef4444; border-radius:50%; display:inline-block;"></span> CANLI GÜNDEM
</span>
<div style="overflow:hidden; white-space:nowrap; width:100%;">
<div class="ps-ticker-track" style="display:inline-flex; gap:36px; animation: psTickerScroll 38s linear infinite; font-size:12.5px; color:#cbd5e1;">
<a href="/taks-kaks-hesaplama" style="color:#38bdf8; text-decoration:none; font-weight:600;"><i class="fa-solid fa-compass-drafting"></i> YENİ: 2D İmar Çapı &amp; TAKS/KAKS Çekme Mesafesi Çizim Motoru Yayında →</a>
<a href="/insaat-ruhsati-harc-hesaplama" style="color:#fbbf24; text-decoration:none; font-weight:600;"><i class="fa-solid fa-helmet-safety"></i> 2026 İnşaat Ruhsatı, SGK Asgari İşçilik (%2.53) &amp; Belediye Harçlarını Hesaplayın →</a>
<a href="/tel-cit-duvar-maliyet" style="color:#34d399; text-decoration:none; font-weight:600;"><i class="fa-solid fa-border-all"></i> Tarla Tel Çit Çekmeden Önce Aplikasyon Yaptırın: 2026 Metraj &amp; Maliyet →</a>
<a href="/tiny-house-imar-uygunluk" style="color:#34d399; text-decoration:none; font-weight:600;"><i class="fa-solid fa-caravan"></i> Tarlaya Tiny House &amp; Karavan Koymanın 3194 İmar Mühür Riskini Ölçün →</a>
<a href="/emlakci-musteri-raporu" style="color:#c084fc; text-decoration:none; font-weight:600;"><i class="fa-solid fa-file-pdf"></i> Emlakçılar İçin Kendi Logolu White-Label Müşteri Sunum Raporu Oluştur →</a>
<a href="/partner-harita-muhendisleri" style="color:#38bdf8; text-decoration:none; font-weight:600;"><i class="fa-solid fa-network-wired"></i> 81 İl Yetkili Partner Harita Mühendisi Ağına Başvurun →</a>
</div>
</div>
</div>
<style>
        @keyframes psTickerScroll {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        #ps-live-ticker:hover .ps-ticker-track { animation-play-state: paused; }
</style>

<!-- HERO TITLE & PRIMARY VALUE PROPOSITION -->
<div class="hero-banner">
<div style="display:inline-flex; align-items:center; gap:8px; background:rgba(56,189,248,0.12); border:1px solid rgba(56,189,248,0.3); padding:4px 14px; border-radius:20px; font-size:12.5px; color:#38bdf8; font-weight:700; margin-bottom:10px;">
<i class="fa-solid fa-shield-halved"></i> TMMOB HKMO Tescilli Mühendislik Altyapısı (Sicil: 12480) &bull; 81 İl, 973 İlçe Canlı
</div>
<h1><i class="fa-solid fa-satellite-dish" style="color:var(--accent);"></i> Türkiye Geneli Ada Parsel Sorgulama ve Canlı Harita</h1>
<p style="max-width:880px; margin:0 auto; font-size:13.5px; line-height:1.6; color:#94a3b8;">
            ParselSorgu.net; 81 il ve 973 ilçede resmi Tapu ve Kadastro Genel Müdürlüğü (MEGSİS) CBS verileriyle canlı ada parsel sorgulama, uydu kadastro haritası, 3194 Sayılı İmar Kanunu emsal/terk hesaplamaları ve 37 harita mühendisliği analizini tek ekranda sunan bağımsız dijital kadastro merkezidir.
</p>
<!-- E-E-A-T OFFICIAL ENGINEERING & CADASTRE DISCLAIMER -->
<div style="display:inline-flex; align-items:center; gap:8px; margin:14px auto 0 auto; padding:8px 18px; background:rgba(15,23,42,0.85); border:1px solid rgba(56,189,248,0.3); border-radius:30px; font-size:12px; color:#cbd5e1; max-width:860px; line-height:1.5; text-align:left; box-shadow:0 4px 15px rgba(0,0,0,0.2);">
<i class="fa-solid fa-shield-halved" style="color:#38bdf8; font-size:15px; flex-shrink:0;"></i>
<span><strong>Mühendislik &amp; Resmi Veri Güvencesi:</strong> ParselSorgu.net bağımsız bir harita mühendisliği ve CBS platformudur (Ant Harita Tescil No: 12480). Kadastro sınırları TKGM/MEGSİS açık coğrafi veri servislerinden canlı işlenmekte olup bilgilendirme amaçlıdır; resmi tapu tescil işlemlerinin yerine geçmez.</span>
</div>
</div>
    
<!-- ================================================================= -->
<!-- ⚡ 2026 YENİ NESİL MÜHENDİSLİK EKLENTİLERİ & ARAÇLAR SHOWCASE ⚡ -->
<!-- ================================================================= -->
<section id="eklentiler" class="tools-showcase-section">
<div class="tools-header-row">
<div class="tools-title-group">
<div class="tools-title-icon">
<i class="fa-solid fa-puzzle-piece"></i>
</div>
<div class="tools-title-text">
<h2>
                        Yeni Nesil Harita &amp; İmar Eklentileri
<span style="font-size:11px; background:#10b981; color:#fff; padding:3px 9px; border-radius:12px; font-weight:700; text-transform:uppercase; letter-spacing:0.5px;">2026 Güncel</span>
</h2>
<p>
                        TMMOB HKMO tescilli algoritmalarla geliştirilen otonom tarla ifrazı, arsa değerleme, toplu sorgu ve resmi raporlama modülleri.
</p>
</div>
</div>
<div style="display:flex; align-items:center; gap:12px;">
<span style="font-size:12px; color:#10b981; font-weight:700; background:rgba(16,185,129,0.12); border:1px solid rgba(16,185,129,0.3); padding:5px 12px; border-radius:20px;">
<i class="fa-solid fa-circle-check"></i> %100 Ücretsiz &bull; Canlı Veri
</span>
</div>
</div>
<div class="tools-grid">
<!-- 1. 5403 Tarla İfraz Hesaplayıcı -->
<a href="/tarla-ifraz-hesaplama" class="tool-card tool-green">
<div class="tool-card-badge"><i class="fa-solid fa-wheat-awn"></i> 5403 s.K.</div>
<div class="tool-card-icon"><i class="fa-solid fa-ruler-combined"></i></div>
<h3 class="tool-card-title">5403 Tarla İfrazı</h3>
<p class="tool-card-desc">Tarlam kaç parsele bölünür? Yasal asgari ifraz büyüklüğü ve kadastral yol analiz motoru.</p>
<div class="tool-card-btn">
<span>Hemen İfrazı Hesapla</span>
<i class="fa-solid fa-arrow-right"></i>
</div>
</a>
<!-- 2. 2026 Arsa Değerleme & Rayiç Motoru -->
<a href="/arsa-degerleme-hesaplama" class="tool-card tool-blue">
<div class="tool-card-badge"><i class="fa-solid fa-chart-line"></i> 2026 RAYİÇ</div>
<div class="tool-card-icon"><i class="fa-solid fa-coins"></i></div>
<h3 class="tool-card-title">Arsa Değerleme</h3>
<p class="tool-card-desc">Arsam ne kadar eder? 81 il ve ilçe bazında emsal m² birim fiyatları ve 2026 piyasa değeri.</p>
<div class="tool-card-btn">
<span>Piyasa Fiyatı Hesapla</span>
<i class="fa-solid fa-arrow-right"></i>
</div>
</a>
<!-- 3. Toplu Parsel Portföy Analizi -->
<a href="/toplu-parsel-sorgulama" class="tool-card tool-purple">
<div class="tool-card-badge"><i class="fa-solid fa-bolt"></i> PRO ARAÇ</div>
<div class="tool-card-icon"><i class="fa-solid fa-layer-group"></i></div>
<h3 class="tool-card-title">Toplu Parsel Portföyü</h3>
<p class="tool-card-desc">Çoklu ada/parseli kopyalayıp yapıştırın; tapu alanlarını, uydu sınırlarını topluca Excel'e aktarın.</p>
<div class="tool-card-btn">
<span>Toplu Sorgula</span>
<i class="fa-solid fa-arrow-right"></i>
</div>
</a>
<!-- 4. Resmi Parsel & İmar Ön İnceleme Raporu -->
<a href="/parsel-raporu" class="tool-card tool-rose">
<div class="tool-card-badge"><i class="fa-solid fa-file-pdf"></i> RESMİ PDF</div>
<div class="tool-card-icon"><i class="fa-solid fa-file-shield"></i></div>
<h3 class="tool-card-title">Resmi Parsel Raporu</h3>
<p class="tool-card-desc">Ant Harita HKMO tescilli A4 resmi formatta detaylı imar, kadastro ve mülkiyet ön inceleme belgesi.</p>
<div class="tool-card-btn">
<span>Resmi Rapor İndir</span>
<i class="fa-solid fa-arrow-right"></i>
</div>
</a>
<!-- 5. KML & CAD (DXF) Dışa Aktarma -->
<a href="/export-parsel?format=kml" class="tool-card tool-amber">
<div class="tool-card-badge"><i class="fa-solid fa-download"></i> NETCAD / CAD</div>
<div class="tool-card-icon"><i class="fa-solid fa-file-export"></i></div>
<h3 class="tool-card-title">KML &amp; CAD Aktar</h3>
<p class="tool-card-desc">Sorgulanan parselin koordinatlarını Google Earth (.kml) ve AutoCAD/Netcad (.dxf) formatında indirin.</p>
<div class="tool-card-btn">
<span>KML / DXF İndir</span>
<i class="fa-solid fa-arrow-right"></i>
</div>
</a>
</div>
<!-- İKİNCİ SAAS SATIRI: YENİ KURULAN 5 STRATEJİK SAAS MODÜLÜ -->
<div class="tools-grid" style="margin-top:16px;">
<!-- SaaS 1: Akıllı Parsel Alarmı -->
<a href="/parsel-takip" class="tool-card tool-blue">
<div class="tool-card-badge"><i class="fa-solid fa-bell"></i> 7/24 NÖBET</div>
<div class="tool-card-icon"><i class="fa-solid fa-satellite-dish"></i></div>
<h3 class="tool-card-title">Akıllı Parsel Alarmı</h3>
<p class="tool-card-desc">Arsanız için canlı nöbetçi kurun; imar planı askıya çıktığında, emsal rayiç değişiminde SMS/WhatsApp bildirimi alın.</p>
<div class="tool-card-btn">
<span>Alarm Kur (Ücretsiz)</span>
<i class="fa-solid fa-arrow-right"></i>
</div>
</a>
<!-- SaaS 2: Web-CAD & Netcad Krokisi -->
<a href="/web-cad" class="tool-card tool-green">
<div class="tool-card-badge"><i class="fa-solid fa-drafting-compass"></i> WEB CAD</div>
<div class="tool-card-icon"><i class="fa-solid fa-compass-drafting"></i></div>
<h3 class="tool-card-title">Web-CAD &amp; Netcad Krokisi</h3>
<p class="tool-card-desc">Tarayıcıda canlı kroki çizimi, ITRF96 köşe koordinat tablosu, 5m çekme mesafesi ve Netcad (.DXF) indirme motoru.</p>
<div class="tool-card-btn">
<span>CAD Krokisi Çiz</span>
<i class="fa-solid fa-arrow-right"></i>
</div>
</a>
<!-- SaaS 3: QR Parsel Doğrulama Sertifikası -->
<a href="/parsel-dogrulama" class="tool-card tool-amber">
<div class="tool-card-badge"><i class="fa-solid fa-stamp"></i> GÜVEN MÜHRÜ</div>
<div class="tool-card-icon"><i class="fa-solid fa-certificate"></i></div>
<h3 class="tool-card-title">QR Doğrulama Sertifikası</h3>
<p class="tool-card-desc">Sahibinden ve emlak ilanlarına eklenebilir Ant Harita HKMO tescilli QR kodlu parsel doğrulama sertifikası.</p>
<div class="tool-card-btn">
<span>Sertifika Oluştur</span>
<i class="fa-solid fa-arrow-right"></i>
</div>
</a>
<!-- SaaS 4: 634 s. Arsa Payı Cetveli -->
<a href="/arsa-payi-hesaplama" class="tool-card tool-purple">
<div class="tool-card-badge"><i class="fa-solid fa-scale-balanced"></i> 634 s.K.</div>
<div class="tool-card-icon"><i class="fa-solid fa-building-circle-check"></i></div>
<h3 class="tool-card-title">Arsa Payı Dağıtım Cetveli</h3>
<p class="tool-card-desc">Kat irtifakı tesisinde m², kat ve cephe şerefiyesine göre yasal 1000/1000 arsa payı hesaplama ve resmi cetvel.</p>
<div class="tool-card-btn">
<span>Arsa Payı Hesapla</span>
<i class="fa-solid fa-arrow-right"></i>
</div>
</a>
<!-- SaaS 5: REST API Developer Hub -->
<a href="/api-docs" class="tool-card tool-rose">
<div class="tool-card-badge"><i class="fa-solid fa-code"></i> B2B API</div>
<div class="tool-card-icon"><i class="fa-solid fa-terminal"></i></div>
<h3 class="tool-card-title">REST API Developer Hub</h3>
<p class="tool-card-desc">Proptech ve CRM yazılımları için 81 il canlı TKGM MEGSİS kadastro, değerleme ve ifraz REST API dokümantasyonu.</p>
<div class="tool-card-btn">
<span>API'yi İncele</span>
<i class="fa-solid fa-arrow-right"></i>
</div>
</a>
</div>
</section>
<!-- 3 ADIMDA PARSEL SORGULAMA VE İMAR ANALİZİ REHBERİ -->
<section class="ps-guide-steps" style="margin-bottom: 24px;">
<div style="background: linear-gradient(135deg, rgba(15, 23, 42, 0.8) 0%, rgba(30, 41, 59, 0.4) 100%); border: 1px solid rgba(56, 189, 248, 0.2); border-radius: 14px; padding: 20px 18px; box-shadow: 0 10px 30px rgba(0,0,0,0.35);">
<div style="text-align:center; max-width: 760px; margin: 0 auto 18px auto;">
<span style="display:inline-block; font-size:12px; font-weight:800; color:#38bdf8; text-transform:uppercase; letter-spacing:0.06em; background:rgba(56,189,248,0.12); border:1px solid rgba(56,189,248,0.3); padding:3px 10px; border-radius:20px; margin-bottom:6px;">
<i class="fa-solid fa-circle-check"></i> 3 Adımda Otonom Kadastro ve İmar Çözümü
</span>
<h2 style="font-size: 20px; font-weight: 800; color: #ffffff; margin: 0 0 6px 0; letter-spacing: -0.02em;">
                    Ada Parsel Sorgulama ve Arazi Analizi Nasıl Yapılır?
</h2>
<p style="font-size: 13px; color: #94a3b8; margin: 0; line-height: 1.55;">
                    ParselSorgu.net; karmaşık kadastro ve belediye süreçlerini tek ekranda toplayan harita mühendisliği altyapısıdır. Üç basit adımda resmi taşınmaz analiz raporunuzu oluşturun:
</p>
</div>
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 14px;">
<!-- Adım 1 -->
<div style="background: rgba(9, 14, 23, 0.85); border: 1px solid rgba(255,255,255,0.07); border-radius: 12px; padding: 16px; position: relative;">
<div style="display:flex; align-items:center; gap:10px; margin-bottom:8px;">
<span style="width:28px; height:28px; border-radius:8px; background:linear-gradient(135deg, #0284c7, #38bdf8); color:#fff; display:flex; align-items:center; justify-content:center; font-weight:900; font-size:13px;">1</span>
<h3 style="margin:0; font-size:14.5px; font-weight:800; color:#f8fafc;">İdari Konum veya GPS</h3>
</div>
<p style="margin:0; font-size:12.5px; color:#94a3b8; line-height:1.55;">
                        81 il, 973 ilçe ve 50.799 mahalle/köy arasından tapu bilgilerinizi seçin veya arazideyseniz <strong style="color:#38bdf8;">"📍 Konumdan Bul"</strong> butonuyla tek tıkla GPS koordinatınızdan parselinize ulaşın.
</p>
</div>
<!-- Adım 2 -->
<div style="background: rgba(9, 14, 23, 0.85); border: 1px solid rgba(255,255,255,0.07); border-radius: 12px; padding: 16px; position: relative;">
<div style="display:flex; align-items:center; gap:10px; margin-bottom:8px;">
<span style="width:28px; height:28px; border-radius:8px; background:linear-gradient(135deg, #10b981, #34d399); color:#fff; display:flex; align-items:center; justify-content:center; font-weight:900; font-size:13px;">2</span>
<h3 style="margin:0; font-size:14.5px; font-weight:800; color:#f8fafc;">Canlı Kadastro &amp; Köşeler</h3>
</div>
<p style="margin:0; font-size:12.5px; color:#94a3b8; line-height:1.55;">
                        Resmi TKGM MEGSİS veritabanına anında bağlanarak parselinizin tescilli köşe kazıklarını (K1, K2, K3...), resmi yüzölçümünü ($m^2$) ve paftasını Google Hibrit &amp; Esri uydu görüntüsü üzerinde şeffafça inceleyin.
</p>
</div>
<!-- Adım 3 -->
<div style="background: rgba(9, 14, 23, 0.85); border: 1px solid rgba(255,255,255,0.07); border-radius: 12px; padding: 16px; position: relative;">
<div style="display:flex; align-items:center; gap:10px; margin-bottom:8px;">
<span style="width:28px; height:28px; border-radius:8px; background:linear-gradient(135deg, #f59e0b, #fbbf24); color:#fff; display:flex; align-items:center; justify-content:center; font-weight:900; font-size:13px;">3</span>
<h3 style="margin:0; font-size:14.5px; font-weight:800; color:#f8fafc;">İmar, Hukuk ve Değerleme</h3>
</div>
<p style="margin:0; font-size:12.5px; color:#94a3b8; line-height:1.55;">
                        Aşağıdaki 37 otonom mühendislik modülüyle; TAKS/KAKS inşaat alanınızı, yol terklerini, 5403 sayılı kanun tarla ev yapılabilirlik durumunu ve 2026 arsa rayiç piyasa değerini hesaplayın.
</p>
</div>
</div>
</div>
</section>
<!-- 37 OTONOM MODÜL KÜÇÜK KUTUCUKLAR (COMPACT HUB) -->
<section class="ps-quick-hub" id="moduller">
<div style="display:flex; flex-wrap:wrap; align-items:center; justify-content:space-between; gap:10px; margin-bottom:14px; border-bottom:1px solid rgba(255,255,255,0.08); padding-bottom:12px;">
<div>
<h2 style="font-size:16.5px; font-weight:900; color:#ffffff; margin:0 0 2px 0; letter-spacing:-0.02em; display:flex; align-items:center; gap:8px;">
<i class="fa-solid fa-cubes-stacked" style="color:#38bdf8;"></i>
<span>Taşınmaz Analizinde 4 Temel Mühendislik Çözümü (37 Otonom Sistem)</span>
</h2>
<span style="font-size:12.5px; color:#94a3b8;">Kadastro, İmar Mevzuatı, Arazi Hukuku ve Gayrimenkul Değerleme robotlarına tek tıkla doğrudan erişin</span>
</div>
<div style="position:relative; width:100%; max-width:260px;">
<label for="psHubSearch" class="visually-hidden">Modül veya bot arama motoru</label>
<i class="fa-solid fa-magnifying-glass" style="position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:13px;"></i>
<input type="text" id="psHubSearch" aria-label="Modül ve bot arama motoru" placeholder="Modül veya bot ara..." style="width:100%; background:rgba(15,23,42,0.8); border:1px solid rgba(56,189,248,0.3); border-radius:20px; padding:8px 12px 8px 32px; font-size:13px; color:#f8fafc; outline:none;" oninput="window.psFilterTools()">
</div>
</div>
<!-- KATEGORİ SEKMELERİ -->
<div class="ps-tabs-wrapper">
<button type="button" class="ps-quick-tab active" data-filter="sorgulama" aria-label="Parsel Sorgulama Modüllerini Filtrele" onclick="window.psSwitchTab(this, 'sorgulama')">
<i class="fa-solid fa-crosshairs"></i> 1. Parsel Sorgulama <span style="font-size:12px; opacity:0.85;">(5)</span>
</button>
<button type="button" class="ps-quick-tab" data-filter="harita" aria-label="Harita ve Kadastro Modüllerini Filtrele" onclick="window.psSwitchTab(this, 'harita')">
<i class="fa-solid fa-map-location-dot"></i> 2. Harita ve Kadastro <span style="font-size:12px; opacity:0.85;">(6)</span>
</button>
<button type="button" class="ps-quick-tab" data-filter="imar" aria-label="İmar ve Mevzuat Modüllerini Filtrele" onclick="window.psSwitchTab(this, 'imar')">
<i class="fa-solid fa-building-wheat"></i> 3. İmar ve Mevzuat <span style="font-size:12px; opacity:0.85;">(11)</span>
</button>
<button type="button" class="ps-quick-tab" data-filter="degerleme" aria-label="Arsa Değerleme Modüllerini Filtrele" onclick="window.psSwitchTab(this, 'degerleme')">
<i class="fa-solid fa-chart-line"></i> 4. Arsa Değerleme &amp; Yatırım <span style="font-size:12px; opacity:0.85;">(10)</span>
</button>
<button type="button" class="ps-quick-tab" data-filter="rehber" aria-label="Teknik Rehber Modüllerini Filtrele" onclick="window.psSwitchTab(this, 'rehber')">
<i class="fa-solid fa-book-bookmark"></i> 5. Teknik Rehberler <span style="font-size:12px; opacity:0.85;">(4)</span>
</button>
<button type="button" class="ps-quick-tab" data-filter="all" aria-label="Tüm Modülleri Göster" onclick="window.psSwitchTab(this, 'all')">
<i class="fa-solid fa-layer-group"></i> Tümü <span style="font-size:12px; opacity:0.85;">(36)</span>
</button>
</div>
<!-- 37 MODÜLÜL KÜÇÜK KUTUCUKLARI -->
<div class="ps-tools-grid" id="psToolsGrid">
<a href="/tkgm-canli-parsel" class="ps-quick-card" data-cat="sorgulama" data-title="tkgm canlı parsel" data-desc="81 il 973 ilçe canlı uydu haritası üzerinde anlık ada parsel sınırları sorgulama." title="TKGM Canlı Parsel - 81 il 973 ilçe canlı uydu haritası üzerinde anlık ada parsel sınırları sorgulama.">
<div class="ps-card-top">
<div class="ps-card-icon-wrap">
<i class="fa-solid fa-satellite"></i>
</div>
<span class="ps-card-badge" style="background:rgba(16,185,129,0.15); color:#34d399; border-color:rgba(16,185,129,0.3);">MEGSİS CANLI</span>
</div>
<h3 class="ps-card-title">TKGM Canlı Parsel</h3>
<span class="ps-seo-desc">81 il 973 ilçe canlı uydu haritası üzerinde anlık ada parsel sınırları sorgulama.</span>
</a>
<a href="/parsel/kirklareli/luleburgaz/hamitabat/105/12" class="ps-quick-card" data-cat="sorgulama" data-title="parsel güvenlik skoru" data-desc="ada parsel güvenlik skoru (0-100), 5 yıllık değer trendi ve tapu analizi." title="Parsel Güvenlik Skoru - Ada parsel güvenlik skoru (0-100), 5 yıllık değer trendi ve tapu analizi.">
<div class="ps-card-top">
<div class="ps-card-icon-wrap">
<i class="fa-solid fa-shield-halved"></i>
</div>
<span class="ps-card-badge" style="background:rgba(245,158,11,0.15); color:#fbbf24; border-color:rgba(245,158,11,0.3);">GÜVENLİK SKORU</span>
</div>
<h3 class="ps-card-title">Parsel Güvenlik Skoru</h3>
<span class="ps-seo-desc">Ada parsel güvenlik skoru (0-100), 5 yıllık değer trendi ve tapu analizi.</span>
</a>
<a href="/parsel-karsilastirma" class="ps-quick-card" data-cat="sorgulama" data-title="çift parsel kıyaslama" data-desc="i̇ki farklı ada ve parseli imar durumu, topoğrafya ve prim potansiyeline göre kıyaslayın." title="Çift Parsel Kıyaslama - İki farklı ada ve parseli imar durumu, topoğrafya ve prim potansiyeline göre kıyaslayın.">
<div class="ps-card-top">
<div class="ps-card-icon-wrap">
<i class="fa-solid fa-code-compare"></i>
</div>
<span class="ps-card-badge" style="background:rgba(56,189,248,0.15); color:#38bdf8; border-color:rgba(56,189,248,0.3);">A/B KIYAS</span>
</div>
<h3 class="ps-card-title">Çift Parsel Kıyaslama</h3>
<span class="ps-seo-desc">İki farklı ada ve parseli imar durumu, topoğrafya ve prim potansiyeline göre kıyaslayın.</span>
</a>
<a href="/3d-parsel-sorgulama" class="ps-quick-card" data-cat="sorgulama" data-title="3d parsel & arazi" data-desc="parselin eğim, topoğrafya ve gabari sınırlarını 3d interaktif modelle inceleyin." title="3D Parsel & Arazi - Parselin eğim, topoğrafya ve gabari sınırlarını 3D interaktif modelle inceleyin.">
<div class="ps-card-top">
<div class="ps-card-icon-wrap">
<i class="fa-solid fa-cube"></i>
</div>
<span class="ps-card-badge" style="background:rgba(168,85,247,0.15); color:#c084fc; border-color:rgba(168,85,247,0.3);">3D TOPOĞRAFYA</span>
</div>
<h3 class="ps-card-title">3D Parsel & Arazi</h3>
<span class="ps-seo-desc">Parselin eğim, topoğrafya ve gabari sınırlarını 3D interaktif modelle inceleyin.</span>
</a>
<a href="/turkiye-arsa-deger-endeksi-2026" class="ps-quick-card" data-cat="degerleme" data-title="2026 arsa değer endeksi" data-desc="81 ilin ortalama m² birim arsa değerleri, yıllık getiri ve prim ligi verileri." title="2026 Arsa Değer Endeksi - 81 ilin ortalama m² birim arsa değerleri, yıllık getiri ve prim ligi verileri.">
<div class="ps-card-top">
<div class="ps-card-icon-wrap">
<i class="fa-solid fa-chart-line"></i>
</div>
<span class="ps-card-badge" style="background:rgba(16,185,129,0.15); color:#34d399; border-color:rgba(16,185,129,0.3);">81 İL ENDEKSİ</span>
</div>
<h3 class="ps-card-title">2026 Arsa Değer Endeksi</h3>
<span class="ps-seo-desc">81 ilin ortalama m² birim arsa değerleri, yıllık getiri ve prim ligi verileri.</span>
</a>
<a href="/sitene-parsel-sorgu-ekle" class="ps-quick-card" data-cat="sorgulama" data-title="sitene parsel sorgu ekle" data-desc="kendi emlak veya inşaat sitenize 1 satır iframe koduyla canlı parsel sorgulama entegre edin." title="Sitene Parsel Sorgu Ekle - Kendi emlak veya inşaat sitenize 1 satır iframe koduyla canlı parsel sorgulama entegre edin.">
<div class="ps-card-top">
<div class="ps-card-icon-wrap">
<i class="fa-solid fa-code"></i>
</div>
<span class="ps-card-badge" style="background:rgba(6,182,212,0.15); color:#22d3ee; border-color:rgba(6,182,212,0.3);">WIDGET</span>
</div>
<h3 class="ps-card-title">Sitene Parsel Sorgu Ekle</h3>
<span class="ps-seo-desc">Kendi emlak veya inşaat sitenize 1 satır iframe koduyla canlı parsel sorgulama entegre edin.</span>
</a>
<a href="/parsel_koordinat.php" class="ps-quick-card" data-cat="harita" data-title="koordinat dönüştürücü" data-desc="kadastral köşe koordinatlarını itrf96, ed50 ve google maps wgs84 formatlarına dönüştürün." title="Koordinat Dönüştürücü - Kadastral köşe koordinatlarını ITRF96, ED50 ve Google Maps WGS84 formatlarına dönüştürün.">
<div class="ps-card-top">
<div class="ps-card-icon-wrap">
<i class="fa-solid fa-location-crosshairs"></i>
</div>
<span class="ps-card-badge" style="background:rgba(59,130,246,0.15); color:#60a5fa; border-color:rgba(59,130,246,0.3);">GPS DÖNÜŞTÜRÜCÜ</span>
</div>
<h3 class="ps-card-title">Koordinat Dönüştürücü</h3>
<span class="ps-seo-desc">Kadastral köşe koordinatlarını ITRF96, ED50 ve Google Maps WGS84 formatlarına dönüştürün.</span>
</a>
<a href="/arsa-pazari" class="ps-quick-card" data-cat="degerleme" data-title="kat karşılığı arsa pazarı" data-desc="müteahhit arayan arsa sahipleri ve arsa arayan inşaat şirketleri için doğrudan pazar yeri." title="Kat Karşılığı Arsa Pazarı - Müteahhit arayan arsa sahipleri ve arsa arayan inşaat şirketleri için doğrudan pazar yeri.">
<div class="ps-card-top">
<div class="ps-card-icon-wrap">
<i class="fa-solid fa-handshake"></i>
</div>
<span class="ps-card-badge" style="background:rgba(245,158,11,0.15); color:#fbbf24; border-color:rgba(245,158,11,0.3);">KAT KARŞILIĞI</span>
</div>
<h3 class="ps-card-title">Kat Karşılığı Arsa Pazarı</h3>
<span class="ps-seo-desc">Müteahhit arayan arsa sahipleri ve arsa arayan inşaat şirketleri için doğrudan pazar yeri.</span>
</a>
<a href="/arsa-deger-artisi-hesaplama" class="ps-quick-card" data-cat="degerleme" data-title="5 yıllık değer artışı" data-desc="enflasyon, döviz ve bölgesel değerleme katsayılarıyla arsanızın 2030 değerini simüle edin." title="5 Yıllık Değer Artışı - Enflasyon, döviz ve bölgesel değerleme katsayılarıyla arsanızın 2030 değerini simüle edin.">
<div class="ps-card-top">
<div class="ps-card-icon-wrap">
<i class="fa-solid fa-arrow-trend-up"></i>
</div>
<span class="ps-card-badge" style="background:rgba(16,185,129,0.15); color:#34d399; border-color:rgba(16,185,129,0.3);">2030 TRENDİ</span>
</div>
<h3 class="ps-card-title">5 Yıllık Değer Artışı</h3>
<span class="ps-seo-desc">Enflasyon, döviz ve bölgesel değerleme katsayılarıyla arsanızın 2030 değerini simüle edin.</span>
</a>
<a href="/koy-yerlesik-alani-sorgulama" class="ps-quick-card" data-cat="imar" data-title="köy yerleşik alanı sorgu" data-desc="köy içi yerleşik alan sınırında mısınız? %40 taban alanı ile ev yapabilme uygunluk testi." title="Köy Yerleşik Alanı Sorgu - Köy içi yerleşik alan sınırında mısınız? %40 taban alanı ile ev yapabilme uygunluk testi.">
<div class="ps-card-top">
<div class="ps-card-icon-wrap">
<i class="fa-solid fa-house-chimney-window"></i>
</div>
<span class="ps-card-badge" style="background:rgba(20,184,166,0.15); color:#2dd4bf; border-color:rgba(20,184,166,0.3);">%40 KÖY İMARI</span>
</div>
<h3 class="ps-card-title">Köy Yerleşik Alanı Sorgu</h3>
<span class="ps-seo-desc">Köy içi yerleşik alan sınırında mısınız? %40 taban alanı ile ev yapabilme uygunluk testi.</span>
</a>
<a href="/imar-terk-hesaplama" class="ps-quick-card" data-cat="harita" data-title="yola / parka terk hesabı" data-desc="yola, yeşil alana ve parka gidecek m² terk miktarını ve net inşaat tabanını anında hesaplayın." title="Yola / Parka Terk Hesabı - Yola, yeşil alana ve parka gidecek m² terk miktarını ve net inşaat tabanını anında hesaplayın.">
<div class="ps-card-top">
<div class="ps-card-icon-wrap">
<i class="fa-solid fa-scissors"></i>
</div>
<span class="ps-card-badge" style="background:rgba(244,63,94,0.15); color:#fb7185; border-color:rgba(244,63,94,0.3);">MADDE 15-16</span>
</div>
<h3 class="ps-card-title">Yola / Parka Terk Hesabı</h3>
<span class="ps-seo-desc">Yola, yeşil alana ve parka gidecek m² terk miktarını ve net inşaat tabanını anında hesaplayın.</span>
</a>
<a href="/arsa-yatirim-radari" class="ps-quick-card" data-cat="degerleme" data-title="arsa yatırım radarı" data-desc="bölgenizdeki kelepir, rayicin %40 altına düşen ve prim potansiyeli yüksek arsaları yakalayın." title="Arsa Yatırım Radarı - Bölgenizdeki kelepir, rayicin %40 altına düşen ve prim potansiyeli yüksek arsaları yakalayın.">
<div class="ps-card-top">
<div class="ps-card-icon-wrap">
<i class="fa-solid fa-radar"></i>
</div>
<span class="ps-card-badge" style="background:rgba(168,85,247,0.15); color:#c084fc; border-color:rgba(168,85,247,0.3);">FIRSAT ALARMI</span>
</div>
<h3 class="ps-card-title">Arsa Yatırım Radarı</h3>
<span class="ps-seo-desc">Bölgenizdeki kelepir, rayicin %40 altına düşen ve prim potansiyeli yüksek arsaları yakalayın.</span>
</a>
<a href="/arsa-insaat-maliyeti" class="ps-quick-card" data-cat="degerleme" data-title="2026 i̇nşaat maliyeti" data-desc="çevre ve şehircilik bakanlığı 2026 birim fiyatlarıyla villa ve bina kaba/ince maliyet hesabı." title="2026 İnşaat Maliyeti - Çevre ve Şehircilik Bakanlığı 2026 birim fiyatlarıyla villa ve bina kaba/ince maliyet hesabı.">
<div class="ps-card-top">
<div class="ps-card-icon-wrap">
<i class="fa-solid fa-calculator"></i>
</div>
<span class="ps-card-badge" style="background:rgba(99,102,241,0.15); color:#818cf8; border-color:rgba(99,102,241,0.3);">2026 ÇŞİDB</span>
</div>
<h3 class="ps-card-title">2026 İnşaat Maliyeti</h3>
<span class="ps-seo-desc">Çevre ve Şehircilik Bakanlığı 2026 birim fiyatlarıyla villa ve bina kaba/ince maliyet hesabı.</span>
</a>
<a href="/ilan-afisi-olusturucu" class="ps-quick-card" data-cat="degerleme" data-title="i̇lan afişi oluşturucu" data-desc="parselinizin imar, ada ve m² bilgilerini saniyeler içinde şık sosyal medya afişine dönüştürün." title="İlan Afişi Oluşturucu - Parselinizin imar, ada ve m² bilgilerini saniyeler içinde şık sosyal medya afişine dönüştürün.">
<div class="ps-card-top">
<div class="ps-card-icon-wrap">
<i class="fa-solid fa-bullhorn"></i>
</div>
<span class="ps-card-badge" style="background:rgba(236,72,153,0.15); color:#f472b6; border-color:rgba(236,72,153,0.3);">SOSYAL MEDYA</span>
</div>
<h3 class="ps-card-title">İlan Afişi Oluşturucu</h3>
<span class="ps-seo-desc">Parselinizin imar, ada ve m² bilgilerini saniyeler içinde şık sosyal medya afişine dönüştürün.</span>
</a>
<a href="/rizai-taksim-sozlesmesi" class="ps-quick-card" data-cat="imar" data-title="rıza-i taksim sözleşmesi" data-desc="hissedarlar arası kullanım hakkı ve yer taksimi sözleşmesini resmi formata uygun oluşturun." title="Rıza-i Taksim Sözleşmesi - Hissedarlar arası kullanım hakkı ve yer taksimi sözleşmesini resmi formata uygun oluşturun.">
<div class="ps-card-top">
<div class="ps-card-icon-wrap">
<i class="fa-solid fa-file-signature"></i>
</div>
<span class="ps-card-badge" style="background:rgba(139,92,246,0.15); color:#a78bfa; border-color:rgba(139,92,246,0.3);">TMK 676</span>
</div>
<h3 class="ps-card-title">Rıza-i Taksim Sözleşmesi</h3>
<span class="ps-seo-desc">Hissedarlar arası kullanım hakkı ve yer taksimi sözleşmesini resmi formata uygun oluşturun.</span>
</a>
<a href="/tarlaya-ev-yapilir-mi-testi" class="ps-quick-card" data-cat="imar" data-title="tarlaya ev yapılır mı?" data-desc="kadastral yol cephesi, tarım arazisi sınıfı ve 5403 sayılı kanuna göre anında uygunluk testi." title="Tarlaya Ev Yapılır mı? - Kadastral yol cephesi, tarım arazisi sınıfı ve 5403 sayılı kanuna göre anında uygunluk testi.">
<div class="ps-card-top">
<div class="ps-card-icon-wrap">
<i class="fa-solid fa-tractor"></i>
</div>
<span class="ps-card-badge" style="background:rgba(16,185,129,0.15); color:#34d399; border-color:rgba(16,185,129,0.3);">5403 TESTİ</span>
</div>
<h3 class="ps-card-title">Tarlaya Ev Yapılır mı?</h3>
<span class="ps-seo-desc">Kadastral yol cephesi, tarım arazisi sınıfı ve 5403 sayılı kanuna göre anında uygunluk testi.</span>
</a>
<a href="/miras-tarla-paylasim-hesaplama" class="ps-quick-card" data-cat="imar" data-title="miras tarla paylaşımı" data-desc="mirasçılar arasında tarımsal arazi bölünemez büyüklük ve intikal pay hesabı motoru." title="Miras Tarla Paylaşımı - Mirasçılar arasında tarımsal arazi bölünemez büyüklük ve intikal pay hesabı motoru.">
<div class="ps-card-top">
<div class="ps-card-icon-wrap">
<i class="fa-solid fa-people-roof"></i>
</div>
<span class="ps-card-badge" style="background:rgba(245,158,11,0.15); color:#fbbf24; border-color:rgba(245,158,11,0.3);">MİRAS PAYI</span>
</div>
<h3 class="ps-card-title">Miras Tarla Paylaşımı</h3>
<span class="ps-seo-desc">Mirasçılar arasında tarımsal arazi bölünemez büyüklük ve intikal pay hesabı motoru.</span>
</a>
<a href="/tapu-harci-hesaplama" class="ps-quick-card" data-cat="degerleme" data-title="2026 tapu harcı hesabı" data-desc="satış bedeli üzerinden alıcı, satıcı tapu harcı ve ilçe döner sermaye bedeli dökümü." title="2026 Tapu Harcı Hesabı - Satış bedeli üzerinden alıcı, satıcı tapu harcı ve ilçe döner sermaye bedeli dökümü.">
<div class="ps-card-top">
<div class="ps-card-icon-wrap">
<i class="fa-solid fa-receipt"></i>
</div>
<span class="ps-card-badge" style="background:rgba(56,189,248,0.15); color:#38bdf8; border-color:rgba(56,189,248,0.3);">TAPU HARCI</span>
</div>
<h3 class="ps-card-title">2026 Tapu Harcı Hesabı</h3>
<span class="ps-seo-desc">Satış bedeli üzerinden alıcı, satıcı tapu harcı ve ilçe döner sermaye bedeli dökümü.</span>
</a>
<a href="/arsa-daire-hesaplama" class="ps-quick-card" data-cat="degerleme" data-title="kat karşılığı paylaşım" data-desc="arsa sahibi ve müteahhit arasında daire, dükkan paylaşım oranları ve fizibilite hesabı." title="Kat Karşılığı Paylaşım - Arsa sahibi ve müteahhit arasında daire, dükkan paylaşım oranları ve fizibilite hesabı.">
<div class="ps-card-top">
<div class="ps-card-icon-wrap">
<i class="fa-solid fa-building-wheat"></i>
</div>
<span class="ps-card-badge" style="background:rgba(6,182,212,0.15); color:#22d3ee; border-color:rgba(6,182,212,0.3);">PAYLAŞIM</span>
</div>
<h3 class="ps-card-title">Kat Karşılığı Paylaşım</h3>
<span class="ps-seo-desc">Arsa sahibi ve müteahhit arasında daire, dükkan paylaşım oranları ve fizibilite hesabı.</span>
</a>
<a href="/bot/taks-kaks-emsal" class="ps-quick-card" data-cat="imar" data-title="taks / kaks emsal hesabı" data-desc="emsal katsayısına göre parsel üzerinde inşa edilebilecek toplam brüt ve net metrekare." title="TAKS / KAKS Emsal Hesabı - Emsal katsayısına göre parsel üzerinde inşa edilebilecek toplam brüt ve net metrekare.">
<div class="ps-card-top">
<div class="ps-card-icon-wrap">
<i class="fa-solid fa-ruler-combined"></i>
</div>
<span class="ps-card-badge" style="background:rgba(59,130,246,0.15); color:#60a5fa; border-color:rgba(59,130,246,0.3);">EMSAL ALANI</span>
</div>
<h3 class="ps-card-title">TAKS / KAKS Emsal Hesabı</h3>
<span class="ps-seo-desc">Emsal katsayısına göre parsel üzerinde inşa edilebilecek toplam brüt ve net metrekare.</span>
</a>
<a href="/bot/tarla-ifraz-bolunme" class="ps-quick-card" data-cat="imar" data-title="tarla i̇fraz & bölünme" data-desc="mutlak tarım arazisi (20 dönüm), dikili (5 dönüm) ve marjinal tarım parsel bölme şartları." title="Tarla İfraz & Bölünme - Mutlak tarım arazisi (20 dönüm), dikili (5 dönüm) ve marjinal tarım parsel bölme şartları.">
<div class="ps-card-top">
<div class="ps-card-icon-wrap">
<i class="fa-solid fa-border-none"></i>
</div>
<span class="ps-card-badge" style="background:rgba(16,185,129,0.15); color:#34d399; border-color:rgba(16,185,129,0.3);">5403 s.K.</span>
</div>
<h3 class="ps-card-title">Tarla İfraz & Bölünme</h3>
<span class="ps-seo-desc">Mutlak tarım arazisi (20 dönüm), dikili (5 dönüm) ve marjinal tarım parsel bölme şartları.</span>
</a>
<a href="/bot/prefabrik-ev-izni" class="ps-quick-card" data-cat="imar" data-title="prefabrik & tiny house i̇zni" data-desc="tekerlekli karayolları mevzuatı ile sabit temel prefabrik yapı imar ruhsatı farkları." title="Prefabrik & Tiny House İzni - Tekerlekli Karayolları mevzuatı ile sabit temel prefabrik yapı imar ruhsatı farkları.">
<div class="ps-card-top">
<div class="ps-card-icon-wrap">
<i class="fa-solid fa-caravan"></i>
</div>
<span class="ps-card-badge" style="background:rgba(20,184,166,0.15); color:#2dd4bf; border-color:rgba(20,184,166,0.3);">TINY HOUSE</span>
</div>
<h3 class="ps-card-title">Prefabrik & Tiny House İzni</h3>
<span class="ps-seo-desc">Tekerlekli Karayolları mevzuatı ile sabit temel prefabrik yapı imar ruhsatı farkları.</span>
</a>
<a href="/bot/izale-i-suyu" class="ps-quick-card" data-cat="imar" data-title="i̇zale-i şüyu satış botu" data-desc="ortaklığın giderilmesi davası, e-satış açık artırma süreci ve hissedar hakları simülatörü." title="İzale-i Şüyu Satış Botu - Ortaklığın giderilmesi davası, e-Satış açık artırma süreci ve hissedar hakları simülatörü.">
<div class="ps-card-top">
<div class="ps-card-icon-wrap">
<i class="fa-solid fa-gavel"></i>
</div>
<span class="ps-card-badge" style="background:rgba(244,63,94,0.15); color:#fb7185; border-color:rgba(244,63,94,0.3);">HİSSELİ SATIŞ</span>
</div>
<h3 class="ps-card-title">İzale-i Şüyu Satış Botu</h3>
<span class="ps-seo-desc">Ortaklığın giderilmesi davası, e-Satış açık artırma süreci ve hissedar hakları simülatörü.</span>
</a>
<a href="/bot/sufa-hakki" class="ps-quick-card" data-cat="imar" data-title="hisseli tarla ön alım" data-desc="hissedarların 3. kişilere satışta yasal ön alım hakkı kullanım süresi ve noter ihtarname botu." title="Hisseli Tarla Ön Alım - Hissedarların 3. kişilere satışta yasal ön alım hakkı kullanım süresi ve noter ihtarname botu.">
<div class="ps-card-top">
<div class="ps-card-icon-wrap">
<i class="fa-solid fa-scale-balanced"></i>
</div>
<span class="ps-card-badge" style="background:rgba(168,85,247,0.15); color:#c084fc; border-color:rgba(168,85,247,0.3);">ŞUFA HAKKI</span>
</div>
<h3 class="ps-card-title">Hisseli Tarla Ön Alım</h3>
<span class="ps-seo-desc">Hissedarların 3. kişilere satışta yasal ön alım hakkı kullanım süresi ve noter ihtarname botu.</span>
</a>
<a href="/bot/imar-barisi-2b" class="ps-quick-card" data-cat="imar" data-title="2b arazi satın alma" data-desc="orman vasfını yitirmiş 2b arazileri doğrudan satın alma rayiç bedeli ve taksitlendirme şartları." title="2B Arazi Satın Alma - Orman vasfını yitirmiş 2B arazileri doğrudan satın alma rayiç bedeli ve taksitlendirme şartları.">
<div class="ps-card-top">
<div class="ps-card-icon-wrap">
<i class="fa-solid fa-tree"></i>
</div>
<span class="ps-card-badge" style="background:rgba(16,185,129,0.15); color:#34d399; border-color:rgba(16,185,129,0.3);">6292 SAYILI</span>
</div>
<h3 class="ps-card-title">2B Arazi Satın Alma</h3>
<span class="ps-seo-desc">Orman vasfını yitirmiş 2B arazileri doğrudan satın alma rayiç bedeli ve taksitlendirme şartları.</span>
</a>
<a href="/bot/parsel-tevhid-birlestirme" class="ps-quick-card" data-cat="harita" data-title="parsel tevhid & birleştirme" data-desc="yan yana parselleri birleştirerek imar planında emsal ve kat artışı alma avantaj analizi." title="Parsel Tevhid & Birleştirme - Yan yana parselleri birleştirerek imar planında emsal ve kat artışı alma avantaj analizi.">
<div class="ps-card-top">
<div class="ps-card-icon-wrap">
<i class="fa-solid fa-object-group"></i>
</div>
<span class="ps-card-badge" style="background:rgba(56,189,248,0.15); color:#38bdf8; border-color:rgba(56,189,248,0.3);">+%20 EMSAL</span>
</div>
<h3 class="ps-card-title">Parsel Tevhid & Birleştirme</h3>
<span class="ps-seo-desc">Yan yana parselleri birleştirerek imar planında emsal ve kat artışı alma avantaj analizi.</span>
</a>
<a href="/bot/ges-arazi-uygunluk" class="ps-quick-card" data-cat="degerleme" data-title="ges güneş enerjisi uygunluk" data-desc="trafo kapasitesi, güney eğim açısı ve marjinal tarım raporu ile ges santrali uygunluğu." title="GES Güneş Enerjisi Uygunluk - Trafo kapasitesi, güney eğim açısı ve marjinal tarım raporu ile GES santrali uygunluğu.">
<div class="ps-card-top">
<div class="ps-card-icon-wrap">
<i class="fa-solid fa-solar-panel"></i>
</div>
<span class="ps-card-badge" style="background:rgba(245,158,11,0.15); color:#fbbf24; border-color:rgba(245,158,11,0.3);">GÜNEŞ GES</span>
</div>
<h3 class="ps-card-title">GES Güneş Enerjisi Uygunluk</h3>
<span class="ps-seo-desc">Trafo kapasitesi, güney eğim açısı ve marjinal tarım raporu ile GES santrali uygunluğu.</span>
</a>
<a href="/bot/arsa-degerleme-ai" class="ps-quick-card" data-cat="degerleme" data-title="arsa değerleme ai" data-desc="çevredeki emsal satışlar, cephe genişliği ve imar katsayısıyla arsanın piyasa değerini hesaplar." title="Arsa Değerleme AI - Çevredeki emsal satışlar, cephe genişliği ve imar katsayısıyla arsanın piyasa değerini hesaplar.">
<div class="ps-card-top">
<div class="ps-card-icon-wrap">
<i class="fa-solid fa-brain"></i>
</div>
<span class="ps-card-badge" style="background:rgba(99,102,241,0.15); color:#818cf8; border-color:rgba(99,102,241,0.3);">AI EKSPERTİZ</span>
</div>
<h3 class="ps-card-title">Arsa Değerleme AI</h3>
<span class="ps-seo-desc">Çevredeki emsal satışlar, cephe genişliği ve imar katsayısıyla arsanın piyasa değerini hesaplar.</span>
</a>
<a href="/bot/imar-itiraz-dilekcesi" class="ps-quick-card" data-cat="imar" data-title="i̇mar i̇tiraz dilekçesi" data-desc="belediye askı ilanında mağduriyet yaşayan hak sahipleri için resmi itiraz dilekçesi robotu." title="İmar İtiraz Dilekçesi - Belediye askı ilanında mağduriyet yaşayan hak sahipleri için resmi itiraz dilekçesi robotu.">
<div class="ps-card-top">
<div class="ps-card-icon-wrap">
<i class="fa-solid fa-pen-nib"></i>
</div>
<span class="ps-card-badge" style="background:rgba(236,72,153,0.15); color:#f472b6; border-color:rgba(236,72,153,0.3);">30 GÜNLÜK ASKI</span>
</div>
<h3 class="ps-card-title">İmar İtiraz Dilekçesi</h3>
<span class="ps-seo-desc">Belediye askı ilanında mağduriyet yaşayan hak sahipleri için resmi itiraz dilekçesi robotu.</span>
</a>
<a href="/bot/kamulastirma-davasi" class="ps-quick-card" data-cat="harita" data-title="kamulaştırma bedeli botu" data-desc="karayolu, demiryolu veya baraj geçen parselinizin gerçek piyasa tazminat bedeli analizi." title="Kamulaştırma Bedeli Botu - Karayolu, demiryolu veya baraj geçen parselinizin gerçek piyasa tazminat bedeli analizi.">
<div class="ps-card-top">
<div class="ps-card-icon-wrap">
<i class="fa-solid fa-road"></i>
</div>
<span class="ps-card-badge" style="background:rgba(244,63,94,0.15); color:#fb7185; border-color:rgba(244,63,94,0.3);">BEDEL ARTIRIMI</span>
</div>
<h3 class="ps-card-title">Kamulaştırma Bedeli Botu</h3>
<span class="ps-seo-desc">Karayolu, demiryolu veya baraj geçen parselinizin gerçek piyasa tazminat bedeli analizi.</span>
</a>
<a href="/bot/kiyi-kenar-cizgisi" class="ps-quick-card" data-cat="harita" data-title="kıyı kenar çizgisi i̇zni" data-desc="deniz ve göl kenarındaki ilk 50m ve 100m sahil şeridinde imar ve yapılaşma yasakları." title="Kıyı Kenar Çizgisi İzni - Deniz ve göl kenarındaki ilk 50m ve 100m sahil şeridinde imar ve yapılaşma yasakları.">
<div class="ps-card-top">
<div class="ps-card-icon-wrap">
<i class="fa-solid fa-water"></i>
</div>
<span class="ps-card-badge" style="background:rgba(6,182,212,0.15); color:#22d3ee; border-color:rgba(6,182,212,0.3);">3621 s.K.</span>
</div>
<h3 class="ps-card-title">Kıyı Kenar Çizgisi İzni</h3>
<span class="ps-seo-desc">Deniz ve göl kenarındaki ilk 50m ve 100m sahil şeridinde imar ve yapılaşma yasakları.</span>
</a>
<a href="/forum" class="ps-quick-card" data-cat="rehber" data-title="mühendislik forumu" data-desc="tapu, hisseli parsel, 18. madde ve imar sorularınızı harita mühendislerimize ücretsiz sorun." title="Mühendislik Forumu - Tapu, hisseli parsel, 18. madde ve imar sorularınızı harita mühendislerimize ücretsiz sorun.">
<div class="ps-card-top">
<div class="ps-card-icon-wrap">
<i class="fa-solid fa-comments"></i>
</div>
<span class="ps-card-badge" style="background:rgba(16,185,129,0.15); color:#34d399; border-color:rgba(16,185,129,0.3);">SORU & CEVAP</span>
</div>
<h3 class="ps-card-title">Mühendislik Forumu</h3>
<span class="ps-seo-desc">Tapu, hisseli parsel, 18. madde ve imar sorularınızı harita mühendislerimize ücretsiz sorun.</span>
</a>
<a href="/market" class="ps-quick-card" data-cat="harita" data-title="2. el ekipman pazarı" data-desc="total station, rtk gnss gps, nivo ve dron haritalama ekipmanları alım/satım pazarı." title="2. El Ekipman Pazarı - Total Station, RTK GNSS GPS, Nivo ve dron haritalama ekipmanları alım/satım pazarı.">
<div class="ps-card-top">
<div class="ps-card-icon-wrap">
<i class="fa-solid fa-store"></i>
</div>
<span class="ps-card-badge" style="background:rgba(245,158,11,0.15); color:#fbbf24; border-color:rgba(245,158,11,0.3);">2. EL CİHAZ</span>
</div>
<h3 class="ps-card-title">2. El Ekipman Pazarı</h3>
<span class="ps-seo-desc">Total Station, RTK GNSS GPS, Nivo ve dron haritalama ekipmanları alım/satım pazarı.</span>
</a>
<a href="/haberler" class="ps-quick-card" data-cat="rehber" data-title="güncel i̇mar haberleri" data-desc="resmi gazete tapu kararları, 3194 sayılı kanun değişiklikleri ve kentsel dönüşüm haberleri." title="Güncel İmar Haberleri - Resmi Gazete tapu kararları, 3194 sayılı kanun değişiklikleri ve kentsel dönüşüm haberleri.">
<div class="ps-card-top">
<div class="ps-card-icon-wrap">
<i class="fa-solid fa-newspaper"></i>
</div>
<span class="ps-card-badge" style="background:rgba(56,189,248,0.15); color:#38bdf8; border-color:rgba(56,189,248,0.3);">RESMİ GAZETE</span>
</div>
<h3 class="ps-card-title">Güncel İmar Haberleri</h3>
<span class="ps-seo-desc">Resmi Gazete tapu kararları, 3194 sayılı kanun değişiklikleri ve kentsel dönüşüm haberleri.</span>
</a>
<a href="/makaleler" class="ps-quick-card" data-cat="rehber" data-title="teknik i̇mar rehberi" data-desc="tarlaya ev yapma, ifraz, tevhid, cins değişikliği ve aplikasyon hakkında güncel mevzuat ve harita mühendisliği rehberi." title="Teknik İmar Rehberi - Tarlaya ev yapma, ifraz, tevhid, cins değişikliği ve aplikasyon hakkında güncel mevzuat ve harita mühendisliği rehberi.">
<div class="ps-card-top">
<div class="ps-card-icon-wrap">
<i class="fa-solid fa-book-open"></i>
</div>
<span class="ps-card-badge" style="background:rgba(168,85,247,0.15); color:#c084fc; border-color:rgba(168,85,247,0.3);">TEKNİK REHBER</span>
</div>
<h3 class="ps-card-title">Teknik İmar Rehberi</h3>
<span class="ps-seo-desc">Tarlaya ev yapma, ifraz, tevhid, cins değişikliği ve aplikasyon hakkında güncel mevzuat ve harita mühendisliği rehberi.</span>
</a>
<a href="https://wa.me/905428413535?text=Merhaba,%20parsel%20ve%20imar%20danışmanlığı%20almak%20istiyorum." class="ps-quick-card" data-cat="rehber" data-title="whatsapp mühendis hattı" data-desc="ant harita lisanslı harita mühendislerinden anında aplikasyon, imar ve değerleme teklifi alın." title="WhatsApp Mühendis Hattı - Ant Harita lisanslı harita mühendislerinden anında aplikasyon, imar ve değerleme teklifi alın.">
<div class="ps-card-top">
<div class="ps-card-icon-wrap">
<i class="fa-brands fa-whatsapp"></i>
</div>
<span class="ps-card-badge" style="background:rgba(16,185,129,0.15); color:#34d399; border-color:rgba(16,185,129,0.3);">CANLI DESTEK</span>
</div>
<h3 class="ps-card-title">WhatsApp Mühendis Hattı</h3>
<span class="ps-seo-desc">Ant Harita lisanslı harita mühendislerinden anında aplikasyon, imar ve değerleme teklifi alın.</span>
</a>
</div>
<div id="psHubNoResults" style="display:none; text-align:center; padding:24px 10px; color:#94a3b8; font-size:12.5px;">
<i class="fa-solid fa-circle-exclamation" style="font-size:22px; color:#f59e0b; margin-bottom:6px; display:block;"></i>
            Aramanızla eşleşen modül bulunamadı.
</div>
</section>
<!-- ========================================================================= -->
<!-- SEMANTİK REHBER & OTORİTE İÇERİK BLOĞU (GOOGLE SEO & KULLANICI BİLGİLENDİRME) -->
<!-- ========================================================================= -->
<section class="ps-authority-guide" style="margin-bottom: 28px;">
<div style="background: linear-gradient(180deg, rgba(15, 23, 42, 0.94) 0%, rgba(10, 15, 30, 0.98) 100%); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 14px; padding: 24px 20px; box-shadow: 0 16px 36px rgba(0,0,0,0.5);">
<div style="margin-bottom: 20px;">
<span style="display:inline-block; font-size:12px; font-weight:800; color:#38bdf8; text-transform:uppercase; letter-spacing:0.06em; background:rgba(56,189,248,0.1); border:1px solid rgba(56,189,248,0.25); padding:3px 10px; border-radius:20px; margin-bottom:6px;">
<i class="fa-solid fa-book-open"></i> Harita Mühendisliği &amp; İmar Kılavuzu
</span>
<h2 style="font-size: 21px; font-weight: 800; color: #ffffff; margin: 0 0 6px 0; letter-spacing: -0.02em;">
                    Türkiye Geneli Ada Parsel Sorgulama ve İmar Mevzuatı Rehberi
</h2>
<p style="font-size: 13px; color: #94a3b8; margin: 0; line-height: 1.55;">
                    Arsa, tarla ve gayrimenkul yatırımlarınızda doğru kararlar alabilmeniz için resmi mevzuat, kadastro terimleri ve belediye imar süreçleri hakkında bilmeniz gereken temel başlıklar:
</p>
</div>
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 16px; margin-bottom: 24px;">
<!-- Kılavuz 1 -->
<div style="background: rgba(9, 14, 23, 0.7); border: 1px solid rgba(255,255,255,0.06); border-radius: 10px; padding: 16px;">
<h3 style="font-size: 14.5px; font-weight: 800; color: #38bdf8; margin: 0 0 8px 0; display:flex; align-items:center; gap:6px;">
<i class="fa-solid fa-draw-polygon"></i> Ada ve Parsel Nedir? Farkı Nelerdir?
</h3>
<p style="font-size: 12.5px; color: #94a3b8; line-height: 1.55; margin: 0;">
<strong>Ada:</strong> Çevresi cadde, sokak, meydan, demiryolu veya akarsu gibi doğal ya da yapay sınırlarla çevrili kadastro parsel topluluğudur.<br>
<strong>Parsel:</strong> İmar veya kadastro kanunlarına göre sınırları belirlenmiş, tek bir mülkiyete konu olabilen en küçük bağımsız arazi parçasıdır. Parsel sorgulama işlemi bu iki numarayla arazinin yeryüzündeki kesin koordinatlarını belirler.
</p>
</div>
<!-- Kılavuz 2 -->
<div style="background: rgba(9, 14, 23, 0.7); border: 1px solid rgba(255,255,255,0.06); border-radius: 10px; padding: 16px;">
<h3 style="font-size: 14.5px; font-weight: 800; color: #10b981; margin: 0 0 8px 0; display:flex; align-items:center; gap:6px;">
<i class="fa-solid fa-satellite"></i> TKGM MEGSİS Altyapısı ve Doğruluk
</h3>
<p style="font-size: 12.5px; color: #94a3b8; line-height: 1.55; margin: 0;">
                        Tapu ve Kadastro Genel Müdürlüğü Mekansal Gayrimenkul Sistemi (MEGSİS), Türkiye'deki 81 ilin tescilli kadastro paftalarını ITRF96 ve WGS84 coğrafi koordinat sisteminde sayısal olarak sunar. ParselSorgu.net haritası, bu resmi CBS katmanlarını yüksek çözünürlüklü uydu altlıkları ile eşleştirerek sınır sapmalarını engeller.
</p>
</div>
<!-- Kılavuz 3 -->
<div style="background: rgba(9, 14, 23, 0.7); border: 1px solid rgba(255,255,255,0.06); border-radius: 10px; padding: 16px;">
<h3 style="font-size: 14.5px; font-weight: 800; color: #f59e0b; margin: 0 0 8px 0; display:flex; align-items:center; gap:6px;">
<i class="fa-solid fa-building-wheat"></i> 5403 Sayılı Kanun ve Tarlaya Ev Şartları
</h3>
<p style="font-size: 12.5px; color: #94a3b8; line-height: 1.55; margin: 0;">
                        Plansız alanlarda (tarla, bağ, bahçe) bağ evi veya tarımsal yapı yapılabilmesi için parselin en az <strong>5.000 m²</strong> olması, kadastral veya resmi yola en az <strong>25 metre cephesi</strong> bulunması şarttır. Toplam yapı alanı 250 m²'yi ve taban alanı katsayısı %5'i geçemez.
</p>
</div>
<!-- Kılavuz 4 -->
<div style="background: rgba(9, 14, 23, 0.7); border: 1px solid rgba(255,255,255,0.06); border-radius: 10px; padding: 16px;">
<h3 style="font-size: 14.5px; font-weight: 800; color: #a855f7; margin: 0 0 8px 0; display:flex; align-items:center; gap:6px;">
<i class="fa-solid fa-calculator"></i> TAKS ve KAKS (Emsal) İnşaat Alanı Hesabı
</h3>
<p style="font-size: 12.5px; color: #94a3b8; line-height: 1.55; margin: 0;">
<strong>TAKS (Taban Alanı Kat Sayısı):</strong> Binanın zeminde oturabileceği maksimum alandır (Örn: 1.000 m² arsada TAKS 0.30 ise taban 300 m²).<br>
<strong>KAKS (Emsal):</strong> Parselde yapılabilecek toplam net inşaat alanıdır (Örn: KAKS 1.50 ise toplam 1.500 m² inşaat yapılabilir).
</p>
</div>
</div>
<!-- SIKÇA SORULAN SORULAR (FAQ ACCORDION) -->
<div style="border-top: 1px solid rgba(255,255,255,0.08); padding-top: 20px;">
<div style="margin-bottom: 14px;">
<h2 style="font-size: 18px; font-weight: 800; color: #ffffff; margin: 0 0 4px 0; letter-spacing: -0.02em;">
<i class="fa-solid fa-circle-question" style="color:#38bdf8;"></i> Sıkça Sorulan Sorular (SSS)
</h2>
<span style="font-size: 12px; color: #94a3b8;">Ada parsel sorgulama, tapu sınırları ve imar analizleri hakkında merak edilenler:</span>
</div>
<div class="ps-faq-list" style="display:flex; flex-direction:column; gap:8px;">
<!-- Soru 1 -->
<details style="background:rgba(9, 14, 23, 0.6); border:1px solid rgba(255,255,255,0.07); border-radius:8px; padding:12px 14px; cursor:pointer;" open>
<summary style="font-size:13.5px; font-weight:700; color:#f8fafc; outline:none;">
                            ParselSorgu.net üzerinden sorgulama yapmak ücretsiz midir?
</summary>
<p style="margin:8px 0 0 0; font-size:12.5px; color:#94a3b8; line-height:1.55;">
                            Evet. 81 il ve 973 ilçede canlı TKGM MEGSİS ada parsel sorgulama, uydu kadastro haritası ve temel mühendislik hesaplayıcıları platformumuzda tamamen ücretsiz ve şifresiz olarak hizmet vermektedir.
</p>
</details>
<!-- Soru 2 -->
<details style="background:rgba(9, 14, 23, 0.6); border:1px solid rgba(255,255,255,0.07); border-radius:8px; padding:12px 14px; cursor:pointer;">
<summary style="font-size:13.5px; font-weight:700; color:#f8fafc; outline:none;">
                            Ada ve parsel numaramı bilmiyorsam yerimi nasıl bulabilirim?
</summary>
<p style="margin:8px 0 0 0; font-size:12.5px; color:#94a3b8; line-height:1.55;">
                            Arazinizin üzerindeyken harita panelindeki <strong>"📍 Arazideki Konumumu GPS ile Bul"</strong> butonuna tıklayarak doğrudan cihazınızın GPS koordinatlarına yakınlaşabilir; veya tapu senedinizin üzerinde yer alan İl, İlçe, Mahalle bilgilerini seçtikten sonra haritayı kaydırarak arsanızı uydu görüntüsünden tespit edebilirsiniz.
</p>
</details>
<!-- Soru 3 -->
<details style="background:rgba(9, 14, 23, 0.6); border:1px solid rgba(255,255,255,0.07); border-radius:8px; padding:12px 14px; cursor:pointer;">
<summary style="font-size:13.5px; font-weight:700; color:#f8fafc; outline:none;">
                            TKGM MEGSİS verileri ne kadar günceldir?
</summary>
<p style="margin:8px 0 0 0; font-size:12.5px; color:#94a3b8; line-height:1.55;">
                            Sorgulamalar doğrudan Tapu ve Kadastro Genel Müdürlüğü'nün canlı CBS API servisleri üzerinden anlık olarak gerçekleştirilir. Kadastro müdürlükleri tarafından sisteme tescil edilen ifraz, tevhid, terk veya yola ayrılma işlemleri eşzamanlı olarak haritaya yansır.
</p>
</details>
<!-- Soru 4 -->
<details style="background:rgba(9, 14, 23, 0.6); border:1px solid rgba(255,255,255,0.07); border-radius:8px; padding:12px 14px; cursor:pointer;">
<summary style="font-size:13.5px; font-weight:700; color:#f8fafc; outline:none;">
                            Hisseli tarlalarda rıza-i taksim sözleşmesi ve şufa (önalım) riski nedir?
</summary>
<p style="margin:8px 0 0 0; font-size:12.5px; color:#94a3b8; line-height:1.55;">
                            Hisseli tapularda her ortak arazinin her metrekaresinde hak sahibidir. Rıza-i taksim sözleşmesi, tüm hissedarların imzasıyla hangi ortağın nereyi kullanacağını yazılı hale getirir. Üçüncü şahsa hisse satışında diğer hissedarların TMK Madde 732 uyarınca <strong>Şufa (Önalım) Hakkı</strong> dava açma süresi 90 gün (ve her halükarda 2 yıl) bulunmaktadır. Platformumuzdaki <em>Rıza-i Taksim</em> ve <em>Hisseli Ön Alım</em> botları bu hukuki riskleri analiz eder.
</p>
</details>
<!-- Soru 5 -->
<details style="background:rgba(9, 14, 23, 0.6); border:1px solid rgba(255,255,255,0.07); border-radius:8px; padding:12px 14px; cursor:pointer;">
<summary style="font-size:13.5px; font-weight:700; color:#f8fafc; outline:none;">
                            Parselin haritadaki köşe noktaları (K1, K2, K3...) ne anlama gelir?
</summary>
<p style="margin:8px 0 0 0; font-size:12.5px; color:#94a3b8; line-height:1.55;">
                            Haritada kırmızı sınır çizgisi üzerinde işaretlenen köşe noktaları, kadastro paftasındaki resmi poligon köşe koordinatlarıdır (aplikasyon noktaları). Bu koordinatlar arazide demir boru, kazık veya beton sınır taşları ile zemin tesisinin yapıldığı yasal mülkiyet sınırlarını gösterir.
</p>
</details>
</div>
</div>
<!-- E-E-A-T MÜHENDİSLİK GÜVENCESİ VE KURUMSAL KİMLİK -->
<div style="margin-top:20px; padding:14px; background:rgba(56,189,248,0.05); border:1px solid rgba(56,189,248,0.2); border-radius:10px; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px;">
<div style="display:flex; align-items:center; gap:12px;">
<div style="width:38px; height:38px; border-radius:50%; background:linear-gradient(135deg, #0284c7, #38bdf8); display:flex; align-items:center; justify-content:center; color:#fff; font-size:16px;">
<i class="fa-solid fa-certificate"></i>
</div>
<div>
<strong style="color:#ffffff; font-size:13px; display:block;">TMMOB HKMO Tescilli Harita Mühendisliği Altyapısı</strong>
<span style="font-size:12.5px; color:#94a3b8;">Ant Harita Mühendislik Teknolojileri &bull; HKMO Büro Tescil Sicil No: 12480 &bull; Lisanslı CBS &amp; Kadastro Motoru</span>
</div>
</div>
<div style="display:flex; align-items:center; gap:8px;">
<a href="https://wa.me/905428413535" target="_blank" style="background:#22c55e; color:#fff; font-size:12px; font-weight:700; padding:6px 14px; border-radius:6px; text-decoration:none; display:inline-flex; align-items:center; gap:6px;">
<i class="fa-brands fa-whatsapp"></i> Uzman Mühendise Danış
</a>
</div>
</div>
</div>
</section>
</div>
<!-- FOOTER -->
</main>
<footer class="site-footer">
<div class="footer-grid">
<div>
<h3 style="color:#fff; font-size:14.5px; margin:0 0 8px 0; font-weight:800;">
<i class="fa-solid fa-map-marked-alt" style="color:#38bdf8;"></i> ParselSorgu.net - Ant Harita Mühendislik
</h3>
<p style="margin:0 0 10px 0; line-height:1.55; font-size:12.5px;">
                TMMOB Harita ve Kadastro Mühendisleri Odası (HKMO) Tescilli Serbest Harita Mühendislik Müşavirlik Bürosu (Sicil No: 12480). Türkiye geneli kadastro, parsel sorgulama, imar planı ve aplikasyon çözümleri.
</p>
<div style="font-size:12.5px; color:#94a3b8;">
                © 2026 ParselSorgu.net &bull; Tüm Hakları Saklıdır &bull; Lisanslı CBS Altyapısı
</div>
</div>
<div>
<h3 style="color:#fff; font-size:13px; margin:0 0 8px 0; font-weight:700;">Hızlı Bağlantılar</h3>
<ul style="list-style:none; padding:0; margin:0; line-height:1.85; font-size:12px;">
<li><a href="/tkgm-canli-parsel" style="color:#94a3b8; text-decoration:none;">TKGM Canlı Parsel</a></li>
<li><a href="/arsa-pazari" style="color:#94a3b8; text-decoration:none;">Kat Karşılığı Arsa</a></li>
<li><a href="/arsa-insaat-maliyeti" style="color:#94a3b8; text-decoration:none;">2026 İnşaat Maliyeti</a></li>
<li><a href="/iskan-sorgulama" style="color:#94a3b8; text-decoration:none;">İskan Sorgulama</a></li>
<li><a href="/numarataj-sorgulama" style="color:#94a3b8; text-decoration:none;">Numarataj Sorgulama</a></li>
<li><a href="/forum" style="color:#94a3b8; text-decoration:none;">Mühendislik Forumu</a></li>
<li><a href="/market" style="color:#94a3b8; text-decoration:none;">2. El Ekipman Pazarı</a></li>
</ul>
</div>
<div>
<h3 style="color:#fff; font-size:13px; margin:0 0 8px 0; font-weight:700;">Doğrudan İletişim</h3>
<p style="margin:0 0 8px 0; line-height:1.55; font-size:12px;">
                Tapu, kadastro ve imar danışmanlığı için lisanslı harita mühendisimize WhatsApp üzerinden danışabilirsiniz.
</p>
<a href="https://wa.me/905428413535?text=Merhaba,%20parsel%20ve%20imar%20bilgisi%20almak%20istiyorum." target="_blank" style="display:inline-flex; align-items:center; gap:8px; background:#22c55e; color:#fff; padding:8px 12px; border-radius:8px; text-decoration:none; font-size:12px; font-weight:800;">
<i class="fa-brands fa-whatsapp" style="font-size:15px;"></i> WhatsApp Danışma Hattı
</a>
</div>
</div>
</footer>
<!-- iLya AI Mühendis Widget -->
<!-- ilya-chat.js loaded via navbar -->
<!-- Leaflet 1.9.4 JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.js" defer></script>
<script src="/assets/js/home_core.js?v=2026.1" defer></script>
<script src="/assets/js/instant_search.js" defer></script>
</body>
</html>
<?php
$__raw_html = ob_get_clean();
$__raw_html = preg_replace('/>\s+</', '><', $__raw_html);
echo $__raw_html;
?>
