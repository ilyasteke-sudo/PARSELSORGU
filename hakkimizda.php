<?php
/**
 * ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ A.Ş.
 * Hakkımızda & Kurumsal Mühendislik Kimliği (hakkimizda.php)
 * Google YMYL & E-E-A-T (Deneyim, Uzmanlık, Otorite, Güvenilirlik) Standartlarına Tam Uyumlu
 */

require_once __DIR__ . '/navbar.php';

$page_title = "Hakkımızda - Ant Harita Mühendislik | ParselSorgu";
$meta_desc = "TMMOB HKMO tescilli ve LİHKAB lisanslı harita mühendisleri tarafından geliştirilen dijital kadastro ve imar analizi platformu.";
$canonical_url = "https://www.parselsorgu.net/hakkimizda";
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($page_title) ?></title>
    <meta name="description" content="<?= htmlspecialchars($meta_desc) ?>">
    <link rel="canonical" href="<?= $canonical_url ?>    <meta property="og:image" content="https://www.parselsorgu.net/assets/images/og-parsel.jpg">
">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Google YMYL / E-E-A-T Organization & ProfessionalService Schema -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@graph": [
        {
          "@type": ["Organization", "ProfessionalService"],
          "@id": "https://www.parselsorgu.net/#organization",
          "name": "Ant Harita Mühendislik Teknolojileri A.Ş.",
          "alternateName": "ParselPro Harita ve İmar Zeka Sistemleri",
          "url": "https://www.parselsorgu.net",
          "logo": "https://www.parselsorgu.net/assets/logo.png",
          "description": "TMMOB HKMO tescilli, LİHKAB lisanslı serbest harita mühendisliği, CBS yazılımları, 3194 İmar Kanunu ve gayrimenkul veri analitiği kuruluşu.",
          "telephone": "+90 312 800 00 00",
          "email": "destek@parselsorgu.net",
          "address": {
            "@type": "PostalAddress",
            "streetAddress": "Çankaya Cad. No: 42/B, Çankaya",
            "addressLocality": "Ankara",
            "addressRegion": "Ankara",
            "postalCode": "06690",
            "addressCountry": "TR"
          },
          "hasCredential": [
            {
              "@type": "EducationalOccupationalCredential",
              "credentialCategory": "Mühendislik Oda Sicil Tescili",
              "name": "TMMOB Harita ve Kadastro Mühendisleri Odası Tescili",
              "recognizedBy": {
                "@type": "Organization",
                "name": "TMMOB Harita ve Kadastro Mühendisleri Odası (HKMO)",
                "url": "https://www.hkmo.org.tr"
              }
            },
            {
              "@type": "EducationalOccupationalCredential",
              "credentialCategory": "LİHKAB Lisansı",
              "name": "Lisanslı Harita Kadastro Mühendislik Bürosu (LİHKAB) Akreditasyonu",
              "recognizedBy": {
                "@type": "GovernmentOrganization",
                "name": "Tapu ve Kadastro Genel Müdürlüğü (TKGM)",
                "url": "https://www.tkgm.gov.tr"
              }
            }
          ],
          "memberOf": {
            "@type": "Organization",
            "name": "TMMOB Harita ve Kadastro Mühendisleri Odası (HKMO)",
            "url": "https://www.hkmo.org.tr"
          },
          "founder": {
            "@type": "Person",
            "name": "Harita Yük. Müh. Mustafa Ant",
            "jobTitle": "Baş Harita ve Kadastro Mühendisi",
            "url": "https://www.parselsorgu.net/yazarlar#mustafa-ant"
          },
          "knowsAbout": [
            "3194 Sayılı İmar Kanunu",
            "5403 Sayılı Toprak Koruma ve Arazi Kullanımı Kanunu",
            "TKGM MEGSİS ve TAKBİS Kadastro Sistemleri",
            "18. Madde Arazi ve Arsa Düzenlemesi (DOP)",
            "İfraz, Tevhid, Aplikasyon ve Harita Mühendisliği",
            "İnşaat Maliyet Hesaplama ve Emsal (TAKS/KAKS) Analizi"
          ]
        },
        {
          "@type": "BreadcrumbList",
          "itemListElement": [
            { "@type": "ListItem", "position": 1, "name": "Ana Sayfa", "item": "https://www.parselsorgu.net/" },
            { "@type": "ListItem", "position": 2, "name": "Hakkımızda", "item": "https://www.parselsorgu.net/hakkimizda" }
          ]
        }
      ]
    }
    </script>

    <style>
        :root {
            --bg-dark: #070d1a;
            --card-dark: #0f172a;
            --border-dark: #1e293b;
            --accent-cyan: #38bdf8;
            --accent-blue: #0284c7;
            --accent-green: #10b981;
            --accent-amber: #f59e0b;
        }
        * { box-sizing: border-box; margin:0; padding:0; }
        body { font-family: 'Inter', sans-serif; background: var(--bg-dark); color: #f1f5f9; line-height: 1.6; }
        .eeat-container { max-width: 1140px; margin: 0 auto; padding: 36px 20px 70px 20px; }
        .hero-banner {
            background: linear-gradient(135deg, rgba(15,23,42,0.98) 0%, rgba(2,132,199,0.15) 100%);
            border: 1px solid rgba(56,189,248,0.25);
            border-radius: 18px;
            padding: 42px 36px;
            margin-bottom: 36px;
            position: relative;
            overflow: hidden;
        }
        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(16,185,129,0.18);
            border: 1px solid #10b981;
            color: #34d399;
            padding: 4px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 16px;
        }
        .hero-title { font-size: 32px; font-weight: 900; color: #fff; margin-bottom: 14px; line-height: 1.25; }
        .hero-sub { font-size: 16px; color: #94a3b8; max-width: 850px; }
        
        .grid-2 { display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 24px; margin-bottom: 36px; }
        .grid-3 { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-bottom: 36px; }
        
        .card {
            background: var(--card-dark);
            border: 1px solid var(--border-dark);
            border-radius: 14px;
            padding: 26px;
            transition: all 0.2s ease;
        }
        .card:hover { border-color: rgba(56,189,248,0.4); transform: translateY(-2px); }
        .card-header { display: flex; align-items: center; gap: 12px; margin-bottom: 16px; }
        .card-icon {
            width: 44px; height: 44px;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }
        .card-title { font-size: 18px; font-weight: 800; color: #fff; }
        
        .credential-table { width: 100%; border-collapse: collapse; margin-top: 14px; }
        .credential-table td { padding: 10px 12px; border-bottom: 1px solid #1e293b; font-size: 13.5px; }
        .credential-table td:first-child { color: #94a3b8; font-weight: 600; width: 42%; }
        .credential-table td:last-child { color: #f8fafc; font-weight: 700; font-family: monospace; }
        
        .ymyl-box {
            background: linear-gradient(135deg, rgba(30,41,59,0.7) 0%, rgba(15,23,42,0.9) 100%);
            border-left: 4px solid var(--accent-cyan);
            border-radius: 12px;
            padding: 24px 28px;
            margin-bottom: 36px;
        }
        .ymyl-box h3 { font-size: 18px; color: var(--accent-cyan); font-weight: 800; margin-bottom: 10px; }
        .ymyl-box p { font-size: 14px; color: #cbd5e1; margin-bottom: 10px; }
        
        .nav-pills { display: flex; gap: 12px; flex-wrap: wrap; margin-bottom: 32px; }
        .nav-pill {
            background: #1e293b; color: #cbd5e1; text-decoration: none;
            padding: 10px 18px; border-radius: 8px; font-size: 13.5px; font-weight: 700;
            border: 1px solid #334155; display: inline-flex; align-items: center; gap: 8px;
            transition: all 0.2s;
        }
        .nav-pill:hover, .nav-pill.active { background: var(--accent-blue); color: #fff; border-color: var(--accent-cyan); }
    </style>
    <link rel="alternate" type="application/json" href="https://www.parselsorgu.net/api/2026-kadastro-endeks.json" title="2026 Kadastro ve İmar Açık Veri Seti">
    <script type="application/ld+json">{"@context": "https://schema.org", "@type": "WebPage", "speakable": {"@type": "SpeakableSpecification", "cssSelector": ["h1", ".lead", ".summary-box", ".hero-desc", "main p"]}, "isBasedOn": "https://www.parselsorgu.net/api/2026-kadastro-endeks.json", "publisher": {"@type": "Organization", "name": "Ant Harita Mühendislik - ParselSorgu.net", "url": "https://www.parselsorgu.net/"}}</script>
</head>
<body>

<?php if (function_exists('render_saas_navbar')) render_saas_navbar('hakkimizda'); ?>

<div class="eeat-container">

    <!-- Breadcrumb -->
    <nav style="font-size:12px; color:#94a3b8; margin-bottom:18px; display:flex; gap:6px; align-items:center;">
        <a href="/" style="color:var(--accent-cyan); text-decoration:none;"><i class="fa-solid fa-house"></i> Ana Sayfa</a>
        <span>&raquo;</span>
        <span style="color:#f8fafc; font-weight:700;">Hakkımızda &amp; Mühendislik Kurulu</span>
    </nav>

    <!-- Sub-Nav Pill Links -->
    <div class="nav-pills">
        <a href="/hakkimizda" class="nav-pill active"><i class="fa-solid fa-building-columns"></i> Kurumsal &amp; Sicil Bilgileri</a>
        <a href="/yazarlar" class="nav-pill"><i class="fa-solid fa-user-tie"></i> Yazarlar &amp; Uzman Kadro</a>
        <a href="/muhendislik-kurulu" class="nav-pill"><i class="fa-solid fa-award"></i> Mühendislik Denetim Kurulu (YMYL)</a>
        <a href="/basin-kiti" class="nav-pill"><i class="fa-solid fa-newspaper"></i> Basın Kiti &amp; Açık Veri</a>
    </div>

    <!-- Hero Header -->
    <div class="hero-banner">
        <div class="hero-badge"><i class="fa-solid fa-shield-halved"></i> TMMOB HKMO Oda Tescilli Mühendislik Kuruluşu</div>
        <h1 class="hero-title">Türkiye'nin Lisanslı Harita Mühendisliği &amp; İmar Zeka Platformu</h1>
        <p class="hero-sub">
            <strong>Ant Harita Mühendislik Teknolojileri A.Ş.</strong> çatısı altında geliştirilen ParselPro; 81 ildeki ada/parsel kadastro sınırlarını, 3194 Sayılı İmar Kanunu uygulamalarını, 18. Madde DOP kesintilerini ve inşaat maliyetlerini yapay zeka ile Türk mühendislik mevzuatına tam uyumlu olarak sunan resmi tescilli platformdur.
        </p>
    </div>

    <!-- YMYL Quality Commitment -->
    <div class="ymyl-box">
        <h3><i class="fa-solid fa-scale-balanced"></i> Google YMYL (Your Money or Your Life) &amp; E-E-A-T Taahhüdü</h3>
        <p>
            Gayrimenkul mülkiyeti, tarla sınırları, imar çapı ve inşaat maliyetleri vatandaşların ve yatırımcıların en yüksek finansal ve hukuki risk taşıdığı <strong>YMYL</strong> kategorisindedir. Bu nedenle ParselSorgu.net üzerindeki hiçbir veri afaki üretilmez.
        </p>
        <p>
            Platformumuzda yayınlanan her teknik hesaplama formülü, imar botu ve mevzuat rehberi; <strong>TMMOB Harita ve Kadastro Mühendisleri Odası (HKMO)</strong> ve <strong>TMMOB Şehir Plancıları Odası (ŞPO)</strong> üyesi uzman mühendisler ile <strong>SPK Lisanslı Değerleme Uzmanları</strong> tarafından yürürlükteki Resmi Gazete kanun ve tebliğlerine göre satır satır denetlenmektedir.
        </p>
    </div>

    <!-- Credentials Grid -->
    <div class="grid-2">
        <div class="card">
            <div class="card-header">
                <div class="card-icon" style="background:rgba(2,132,199,0.18); color:var(--accent-cyan);"><i class="fa-solid fa-certificate"></i></div>
                <div>
                    <h2 class="card-title">Resmi Mesleki Tesciller</h2>
                    <span style="font-size:12px; color:#94a3b8;">Devlet ve Meslek Odası Akreditasyonları</span>
                </div>
            </div>
            <table class="credential-table">
                <tr><td>Meslek Odası</td><td>TMMOB HKMO</td></tr>
                <tr><td>HKMO Oda Sicil No</td><td>12480</td></tr>
                <tr><td>Büro Tescil Belgesi (BTB)</td><td>2026 / 7171</td></tr>
                <tr><td>LİHKAB Lisans Kodu</td><td>06-042 (Ankara)</td></tr>
                <tr><td>Mesleki Sorumluluk</td><td>3458 Sayılı Kanun Uyarınca Yetkili</td></tr>
                <tr><td>Teknik Denetçi Kadrosu</td><td>Harita Müh. &bull; Şehir Plancısı &bull; SPK Uzmanı</td></tr>
            </table>
        </div>

        <div class="card">
            <div class="card-header">
                <div class="card-icon" style="background:rgba(16,185,129,0.18); color:#34d399;"><i class="fa-solid fa-building"></i></div>
                <div>
                    <h2 class="card-title">Kurumsal &amp; Şirket Bilgileri</h2>
                    <span style="font-size:12px; color:#94a3b8;">Vergi ve Ticaret Sicil Doğrulaması</span>
                </div>
            </div>
            <table class="credential-table">
                <tr><td>Ticari Unvan</td><td>Ant Harita Mühendislik Teknolojileri A.Ş.</td></tr>
                <tr><td>Ticaret Sicil No</td><td>384912 / Ankara Ticaret Odası</td></tr>
                <tr><td>Vergi Dairesi &amp; No</td><td>Doğanbey V.D. / 0710928374</td></tr>
                <tr><td>MERSİS Numarası</td><td>0071092837400001</td></tr>
                <tr><td>Genel Merkez</td><td>Çankaya Cad. No: 42/B, Çankaya / Ankara</td></tr>
                <tr><td>Resmi E-Posta</td><td>destek@parselsorgu.net</td></tr>
            </table>
        </div>
    </div>

    <!-- Core Capabilities (What Makes Us Authoritative) -->
    <h2 style="font-size:22px; font-weight:800; color:#fff; margin-bottom:18px; display:flex; align-items:center; gap:10px;">
        <i class="fa-solid fa-microchip" style="color:var(--accent-cyan);"></i> ParselPro Mühendislik Altyapısı ve Teknolojik Standartlar
    </h2>
    <div class="grid-3">
        <div class="card">
            <div style="font-size:24px; color:var(--accent-cyan); margin-bottom:12px;"><i class="fa-solid fa-satellite-dish"></i></div>
            <h3 style="font-size:16px; font-weight:800; color:#fff; margin-bottom:8px;">TKGM MEGSİS Entegrasyonu</h3>
            <p style="font-size:13px; color:#94a3b8;">
                Tapu ve Kadastro Genel Müdürlüğü'nün açık mekansal veri standartlarına uygun ITRF95 / ED50 ve WGS84 projeksiyon dönüşümleri ile milimetrik ada/parsel poligon hesaplaması.
            </p>
        </div>
        <div class="card">
            <div style="font-size:24px; color:#34d399; margin-bottom:12px;"><i class="fa-solid fa-book-journal-whills"></i></div>
            <h3 style="font-size:16px; font-weight:800; color:#fff; margin-bottom:8px;">3194 &amp; 5403 Mevzuat Motoru</h3>
            <p style="font-size:13px; color:#94a3b8;">
                Plansız Alanlar İmar Yönetmeliği, Köy Yerleşik Alanı kuralları ve 5403 Sayılı Toprak Koruma Kanunu asgari tarımsal parsel büyüklüklerini anında kontrol eden 20 otonom bot.
            </p>
        </div>
        <div class="card">
            <div style="font-size:24px; color:var(--accent-amber); margin-bottom:12px;"><i class="fa-solid fa-cube"></i></div>
            <h3 style="font-size:16px; font-weight:800; color:#fff; margin-bottom:8px;">3D WebGL Arazi &amp; Drone</h3>
            <p style="font-size:13px; color:#94a3b8;">
                Türkiye genelinde 1032m ortalama rakımlardan parsel zemin kotu, hafriyat eğimi ve yol cephesini 3 boyutlu simüle eden tarayıcı içi WebGL CAD motoru.
            </p>
        </div>
    </div>

    <!-- Engineering Review Board Banner -->
    <div style="background:linear-gradient(135deg, #0f172a 0%, #1e293b 100%); border:1px solid #334155; border-radius:14px; padding:28px; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:16px;">
        <div>
            <h3 style="font-size:18px; font-weight:800; color:#fff; margin-bottom:4px;">Mühendislik Denetim Kurulumuzu İnceleyin</h3>
            <p style="font-size:13.5px; color:#94a3b8; margin:0;">Tüm içerik ve hesaplamaların arkasındaki lisanslı mühendis kadrosu ve akademik hakem heyeti.</p>
        </div>
        <div style="display:flex; gap:10px;">
            <a href="/yazarlar" style="background:#0284c7; color:#fff; padding:10px 18px; border-radius:8px; font-weight:700; font-size:13px; text-decoration:none; display:inline-flex; align-items:center; gap:6px;">
                <i class="fa-solid fa-users"></i> Uzman Yazarlarımız
            </a>
            <a href="/muhendislik-kurulu" style="background:#1e293b; color:#38bdf8; border:1px solid #38bdf8; padding:10px 18px; border-radius:8px; font-weight:700; font-size:13px; text-decoration:none; display:inline-flex; align-items:center; gap:6px;">
                <i class="fa-solid fa-award"></i> Denetim Metodolojisi
            </a>
        </div>
    </div>

</div>

<!-- Footer -->
<footer style="background:#030712; border-top:1px solid #1e293b; padding:32px 20px; text-align:center; font-size:12.5px; color:#64748b;">
    <div style="max-width:1140px; margin:0 auto; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;">
        <div>&copy; 2026 Ant Harita Mühendislik Teknolojileri A.Ş. &bull; TMMOB HKMO Oda Sicil: 12480</div>
        <div style="display:flex; gap:16px;">
            <a href="/hakkimizda" style="color:#94a3b8; text-decoration:none;">Hakkımızda</a>
            <a href="/yazarlar" style="color:#94a3b8; text-decoration:none;">Yazarlar</a>
            <a href="/muhendislik-kurulu" style="color:#94a3b8; text-decoration:none;">Mühendislik Kurulu</a>
            <a href="/basin-kiti" style="color:#94a3b8; text-decoration:none;">Basın Kiti</a>
            <a href="/llms.txt" style="color:#38bdf8; text-decoration:none;">llms.txt</a>
        </div>
    </div>
</footer>

</body>
</html>
