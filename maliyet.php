<?php
/**
 * ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ - PARSEL PRO
 * 2026 T.C. ÇŞİDB RESMİ İNŞAAT MALİYETİ & METRAJ HESAPLAMA MERKEZİ (maliyet.php)
 * URL: https://www.parselsorgu.net/maliyet
 */
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/navbar.php';
require_once __DIR__ . '/SeoManager.php';

// Site Ayarları
$site_title = "2026 İnşaat Maliyeti Hesaplama (ÇŞİDB) | ParselSorgu";
$company_name = "Ant Harita Mühendislik Teknolojileri A.Ş.";
$phone = "0542 841 35 35";
$license_no = "LİHKAB No: 06-042 | TMMOB HKMO Sicil: 12480";
$google_analytics_id = "";
$clarity_id = "";
$google_site_verification = "";

if ($pdo) {
    try {
        $stmt = $pdo->query("SELECT setting_key, setting_value FROM site_settings");
        while ($r = $stmt->fetch()) {
            if ($r['setting_key'] == 'phone') $phone = $r['setting_value'];
            if ($r['setting_key'] == 'company_name') $company_name = $r['setting_value'];
            if ($r['setting_key'] == 'license_no') $license_no = $r['setting_value'];
            if ($r['setting_key'] == 'google_analytics_id') $google_analytics_id = $r['setting_value'];
            if ($r['setting_key'] == 'clarity_id') $clarity_id = $r['setting_value'];
            if ($r['setting_key'] == 'google_site_verification') $google_site_verification = $r['setting_value'];
        }
    } catch (Exception $e) {}
}

// Parsel 360 Entegrasyonu: URL'den gelen taşınmaz verileri
$p_city = trim($_GET['city'] ?? '');
$p_district = trim($_GET['district'] ?? '');
$p_ada = trim($_GET['ada'] ?? '');
$p_parsel = trim($_GET['parsel'] ?? '');
$p_area = floatval($_GET['area'] ?? 0);
$p_insaat = floatval($_GET['insaat_alani'] ?? 0);
$p_kat = intval($_GET['kat'] ?? 4);
$p_daire = intval($_GET['daire'] ?? 8);
$has_parsel_project = (!empty($p_city) && (!empty($p_ada) || !empty($p_parsel)));
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title>2026 İnşaat Maliyeti Hesaplama (ÇŞİDB) | ParselSorgu</title>
    <meta name="description" content="2026 Çevre, Şehircilik ve İklim Değişikliği Bakanlığı resmi birim fiyatlarıyla III-A, III-B, IV-A yapı sınıfları inşaat maliyeti hesaplayın.">
    <meta name="keywords" content="2026 inşaat maliyeti, inşaat maliyeti hesaplama, çevre şehircilik birim fiyatları 2026, metraj hesabı, müstakil ev maliyeti, villa maliyeti hesaplama">
    <link rel="canonical" href="https://www.parselsorgu.net/arsa-insaat-maliyeti">
    <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
    <link rel="icon" href="https://www.parselsorgu.net/favicon.ico">

    <!-- CSS -->
    <link rel="stylesheet" href="/assets/css/main.css?v=2026.2">

    <!-- Open Graph (OG) -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="⚡ 2026 Resmi İnşaat Maliyeti & Metraj Hesaplama | Parsel Pro">
    <meta property="og:description" content="81 il ilçe ÇŞİDB 2026 tebliğ katsayıları ile anlık inşaat maliyeti, demir, beton metrajı ve PDF/Excel keşif dökümü.">
    <meta property="og:url" content="https://www.parselsorgu.net/arsa-insaat-maliyeti">
    <meta property="og:image" content="https://www.parselsorgu.net/assets/images/og-parsel.jpg">

    <!-- Google Analytics GA4 -->
    <?php if (!empty($google_analytics_id)): ?>
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo htmlspecialchars($google_analytics_id); ?>"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', '<?php echo htmlspecialchars($google_analytics_id); ?>');
    </script>
    <?php endif; ?>

    <!-- Microsoft Clarity -->
    <?php if (!empty($clarity_id)): ?>
    <script type="text/javascript">
        (function(c,l,a,r,i,t,y){
            c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};
            t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i;
            y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y);
        })(window, document, "clarity", "script", "<?php echo htmlspecialchars($clarity_id); ?>");
    </script>
    <?php endif; ?>

    <!-- html2pdf & SheetJS for PDF / Excel Export -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js" defer></script>
    <style>
        .tab-section { display: block !important; }
    </style>
<?php echo SeoManager::renderBreadcrumbJson(['Ana Sayfa' => 'https://www.parselsorgu.net/', 'İnşaat Maliyeti' => 'https://www.parselsorgu.net/arsa-insaat-maliyeti']); ?>
<?php
$maliyet_faq_items = [
    [
        "@type" => "Question",
        "name" => "2026 yılında 1 m² daire ve bina inşaat maliyeti ne kadardır?",
        "acceptedAnswer" => [
            "@type" => "Answer",
            "text" => "Çevre, Şehircilik ve İklim Değişikliği Bakanlığı 2026 yılı Yapı Yaklaşık Birim Maliyetleri tebliğine göre III. Sınıf B Grubu standart konut binalarında anahtar teslim metrekare maliyeti ortalama 18.000 TL ile 24.500 TL arasında değişmektedir."
        ]
    ],
    [
        "@type" => "Question",
        "name" => "Kaba inşaat maliyeti toplam inşaat bütçesinin yüzde kaçıdır?",
        "acceptedAnswer" => [
            "@type" => "Answer",
            "text" => "Betonarme karkas taşıyıcı sistem, nervürlü inşaat demiri, hazır beton, kalıp işçiliği ve dış tuğla duvarları kapsayan kaba inşaat giderleri, toplam anahtar teslim inşaat maliyetinin yaklaşık %38 ila %42'sini oluşturur."
        ]
    ],
    [
        "@type" => "Question",
        "name" => "Arsa payı ve kat karşılığı müteahhitlik oranı nasıl hesaplanır?",
        "acceptedAnswer" => [
            "@type" => "Answer",
            "text" => "Kat karşılığı inşaat sözleşmelerinde bölgenin arsa değerine göre arsa sahibi ile müteahhit arasında paylaşım oranı belirlenir (genelde %40 - %50). Kalan dairelerden elde edilen gelir müteahhit inşaat maliyetini ve %25-35 kâr marjını karşılar."
        ]
    ],
    [
        "@type" => "Question",
        "name" => "Belediye inşaat ruhsatı, proje ve yapı denetim masrafları ne kadardır?",
        "acceptedAnswer" => [
            "@type" => "Answer",
            "text" => "Mimari, statik, mekanik ve elektrik tesisat proje çizimleri, şantiye şefliği sözleşmesi, yapı denetim bedeli ve belediye ruhsat harçları toplam inşaat bedelinin yaklaşık %6 ila %9'una tekabül eder."
        ]
    ]
];

$maliyet_app_schema = [
    "@context" => "https://schema.org",
    "@type" => "WebApplication",
    "name" => "2026 Arsa İnşaat Maliyeti & Metraj Hesaplama Motoru",
    "applicationCategory" => "FinanceApplication",
    "operatingSystem" => "All",
    "url" => "https://www.parselsorgu.net/arsa-insaat-maliyeti",
    "description" => "Çevre, Şehircilik ve İklim Değişikliği Bakanlığı 2026 resmi birim fiyatlarıyla kaba inşaat, ince inşaat, demir-beton metrajı ve anahtar teslim daire maliyeti hesaplama aracı.",
    "offers" => [
        "@type" => "Offer",
        "price" => "0",
        "priceCurrency" => "TRY"
    ],
    "provider" => [
        "@type" => "Organization",
        "name" => "Ant Harita Mühendislik",
        "url" => "https://www.parselsorgu.net"
    ]
];

$maliyet_faq_schema = [
    "@context" => "https://schema.org",
    "@type" => "FAQPage",
    "mainEntity" => $maliyet_faq_items
];
?>
    <!-- Rich Snippets: WebApplication & FAQPage JSON-LD -->
    <script type="application/ld+json"><?= json_encode($maliyet_app_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>
    <script type="application/ld+json"><?= json_encode($maliyet_faq_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>
    <link rel="alternate" type="text/markdown" href="https://www.parselsorgu.net/llms.txt" title="ParselSorgu AI / LLM Bilgi Bankası">
    <link rel="alternate" type="application/json" href="https://www.parselsorgu.net/api/2026-kadastro-endeks.json" title="2026 Kadastro ve İmar Açık Veri Seti">
    <script type="application/ld+json">{"@context": "https://schema.org", "@type": "WebPage", "speakable": {"@type": "SpeakableSpecification", "cssSelector": ["h1", ".lead", ".summary-box", ".hero-desc", "main p"]}, "isBasedOn": "https://www.parselsorgu.net/api/2026-kadastro-endeks.json", "publisher": {"@type": "Organization", "name": "Ant Harita Mühendislik - ParselSorgu.net", "url": "https://www.parselsorgu.net/"}}</script>

</head>

<body>
    <h1 style="position:absolute; width:1px; height:1px; padding:0; margin:-1px; overflow:hidden; clip:rect(0,0,0,0); border:0;">2026 İnşaat Maliyeti Hesaplama &amp; ÇŞİDB Birim Fiyatları</h1>
    <!-- Top Header -->
    <?php render_saas_navbar('maliyet'); ?>

    <!-- Top Quick Pills Bar -->
    <div id="top-quick-bar" style="padding:10px 18px; background:#0c121e; border-bottom:1px solid #1e293b; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;">
        <div class="top-quick-pills" style="display:flex; gap:8px; overflow-x:auto;">
            <a href="/" class="nav-btn" style="text-decoration:none; padding:7px 14px; font-size:12px; border-radius:20px;">🗺️ Parsel Sorgu</a>
            <a href="/arsa-insaat-maliyeti" class="nav-btn active" style="text-decoration:none; padding:7px 14px; font-size:12px; border-radius:20px; background:#22c55e; color:#022c22; font-weight:900;">⚡ 2026 İnşaat Maliyeti</a>
            <a href="/rehber" class="nav-btn" style="text-decoration:none; padding:7px 14px; font-size:12px; border-radius:20px;">📚 68.150+ İmar &amp; Kadastro Rehberi</a>
            <a href="/gundem" class="nav-btn" style="text-decoration:none; padding:7px 14px; font-size:12px; border-radius:20px;">🔥 Gündem</a>
            <a href="/forum" class="nav-btn" style="text-decoration:none; padding:7px 14px; font-size:12px; border-radius:20px;">💼 İş İlanları</a>
        </div>
        <div style="font-size:12px; color:#94a3b8;">
            Resmi Dayanak: <b>T.C. Çevre, Şehircilik ve İklim Değişikliği Bakanlığı 2026 Tebliği</b>
        </div>
    </div>

    <!-- Main Container -->
    <main class="container" style="max-width:1400px; margin:20px auto; padding:0 16px;">

        <?php if ($has_parsel_project): ?>
        <div style="background: linear-gradient(135deg, rgba(15, 23, 42, 0.98) 0%, rgba(30, 41, 59, 0.95) 100%); border: 1.5px solid #38bdf8; border-radius: 12px; padding: 18px 24px; margin-bottom: 24px; box-shadow: 0 0 25px rgba(56, 189, 248, 0.2); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
            <div>
                <div style="display:flex; align-items:center; gap:8px; margin-bottom:6px;">
                    <span style="display:inline-block; width:10px; height:10px; border-radius:50%; background:#22c55e; box-shadow:0 0 8px #22c55e;"></span>
                    <span style="color:#38bdf8; font-size:11px; font-weight:900; letter-spacing:0.5px; text-transform:uppercase;">PARSEL 360 ENTEGRE PROJE ÇALIŞMA ALANI</span>
                </div>
                <div style="font-size:20px; font-weight:900; color:#fff;">
                    📍 <?php echo htmlspecialchars($p_city); ?><?php echo !empty($p_district) ? ' / ' . htmlspecialchars($p_district) : ''; ?> — Ada: <span style="color:#facc15;"><?php echo htmlspecialchars($p_ada); ?></span> / Parsel: <span style="color:#facc15;"><?php echo htmlspecialchars($p_parsel); ?></span>
                </div>
                <div style="font-size:13px; color:#cbd5e1; margin-top:6px; display:flex; gap:16px; flex-wrap:wrap;">
                    <?php if ($p_area > 0): ?>
                    <span>Parsel Alanı: <b style="color:#fff;"><?php echo number_format($p_area, 0, ',', '.'); ?> m²</b></span>
                    <?php endif; ?>
                    <?php if ($p_insaat > 0): ?>
                    <span>Hesaba Esas Emsal İnşaat Alanı: <b style="color:#22c55e;"><?php echo number_format($p_insaat, 0, ',', '.'); ?> m²</b></span>
                    <?php endif; ?>
                    <span>Tahmini Kat: <b style="color:#38bdf8;"><?php echo $p_kat; ?> Kat</b></span>
                    <span>Bağımsız Bölüm: <b style="color:#facc15;"><?php echo $p_daire; ?> Daire</b></span>
                </div>
            </div>
            <div style="display:flex; gap:10px; align-items:center;">
                <a href="/ada-parsel-harita?il=<?php echo urlencode($p_city); ?>&ilce=<?php echo urlencode($p_district); ?>&ada=<?php echo urlencode($p_ada); ?>&parsel=<?php echo urlencode($p_parsel); ?>" style="background:#0284c7; color:#fff; font-weight:bold; padding:10px 18px; border-radius:8px; font-size:13px; text-decoration:none; display:inline-flex; align-items:center; gap:8px; transition:0.2s;" onmouseover="this.style.background='#0369a1'" onmouseout="this.style.background='#0284c7'">
                    🗺️ Parsel 360 Haritasına Dön
                </a>
            </div>
        </div>
        <?php endif; ?>

        
        <!-- İnşaat Maliyeti Bölümü -->
        <?php
        $sec_file = __DIR__ . '/maliyet_section.html';
        if (file_exists($sec_file)) {
            include $sec_file;
        } else {
            echo '<div class="card"><p>Maliyet hesaplama modülü yükleniyor...</p></div>';
        }
        ?>

    </main>

    <!-- Mobil Bottom Bar -->
    <div class="mobile-bottom-app-bar">
        <a href="/" class="mobile-app-btn">
            <span class="app-icon">🗺️</span>
            <span>Parsel</span>
        </a>
        <a href="/arsa-insaat-maliyeti" class="mobile-app-btn active">
            <span class="app-icon">⚡</span>
            <span>Maliyet</span>
        </a>
        <a href="/makaleler" class="mobile-app-btn">
            <span class="app-icon">📚</span>
            <span>Makale</span>
        </a>
        <a href="/gundem" class="mobile-app-btn">
            <span class="app-icon">🔥</span>
            <span>Gündem</span>
        </a>
        <a href="https://wa.me/905428413535" target="_blank" class="mobile-app-btn" style="color:#22c55e;">
            <span class="app-icon">💬</span>
            <span>WhatsApp</span>
        </a>
    </div>

    <!-- Scripts -->
    <script src="/project-blueprint-generator.js?v=2026.1"></script>
    <script src="/insaat-maliyet-engine.js?v=2026.8"></script>
        <script>
        document.addEventListener('DOMContentLoaded', () => {
            <?php if ($has_parsel_project): ?>
            setTimeout(() => {
                const citySelect = document.getElementById('inp-sehir');
                const m2Input = document.getElementById('inp-m2');
                const katInput = document.getElementById('inp-kat');
                const daireInput = document.getElementById('inp-daire');

                if (citySelect) {
                    const searchCity = "<?php echo addslashes(mb_strtolower($p_city, 'UTF-8')); ?>";
                    for (let i = 0; i < citySelect.options.length; i++) {
                        if (citySelect.options[i].text.toLowerCase().includes(searchCity) || citySelect.options[i].value.toLowerCase().includes(searchCity)) {
                            citySelect.selectedIndex = i;
                            break;
                        }
                    }
                }
                const calcM2 = <?php echo ($p_insaat > 0) ? round($p_insaat) : (($p_area > 0) ? round($p_area) : 0); ?>;
                if (m2Input && calcM2 > 0) {
                    m2Input.value = calcM2;
                }
                if (katInput && <?php echo $p_kat; ?> > 0) katInput.value = <?php echo $p_kat; ?>;
                if (daireInput && <?php echo $p_daire; ?> > 0) daireInput.value = <?php echo $p_daire; ?>;

                if (typeof runCustomCalculation === 'function') {
                    runCustomCalculation();
                } else if (typeof renderCostDashboard === 'function') {
                    renderCostDashboard();
                }
            }, 300);
            <?php else: ?>
            if (typeof renderCostDashboard === 'function') {
                renderCostDashboard();
            }
            <?php endif; ?>
        });

        function calcCost() {
            if (typeof runCustomCalculation === 'function') {
                runCustomCalculation();
            } else if (typeof renderCostDashboard === 'function') {
                renderCostDashboard();
            }
        }
    </script>
    <!-- Real-Time Web Analytics Engine -->
    <script src="/analytics.js" defer></script>
</body>
</html>
