<?php
/**
 * ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ A.Ş.
 * Mühendislik Denetim Kurulu & YMYL Hakem Heyeti (muhendislik-kurulu.php)
 * Google Search Quality Rater Guidelines (SQRG) ve E-E-A-T Standartlarına Tam Uyumlu
 */

require_once __DIR__ . '/navbar.php';

$page_title = "Mühendislik Denetim Kurulu (TMMOB HKMO) | ParselSorgu";
$meta_desc = "ParselSorgu platformundaki tüm parsel sorgulama algoritmaları, 3194 İmar Kanunu araçları ve maliyet modellerinin mühendislik denetimi.";
$canonical_url = "https://www.parselsorgu.net/muhendislik-kurulu";
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
    
    <!-- Schema.org WebPage with Editorial & Peer-Review Protocols -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@graph": [
        {
          "@type": "WebPage",
          "@id": "https://www.parselsorgu.net/muhendislik-kurulu#webpage",
          "url": "https://www.parselsorgu.net/muhendislik-kurulu",
          "name": "ParselPro Mühendislik Denetim Kurulu ve Doğruluk Protokolü",
          "description": "TMMOB HKMO ve ŞPO tescilli mühendisler tarafından yürütülen 4 aşamalı teknik hakemlik ve mevzuat doğrulama süreci.",
          "publisher": {
            "@type": "Organization",
            "name": "Ant Harita Mühendislik Teknolojileri A.Ş.",
            "url": "https://www.parselsorgu.net"
          },
          "reviewedBy": {
            "@type": "Organization",
            "name": "ParselPro Mühendislik ve Mevzuat Denetim Kurulu",
            "member": [
              {
                "@type": "Person",
                "name": "Harita Yük. Müh. Mustafa Ant",
                "jobTitle": "TMMOB HKMO Oda Sicil: 12480"
              },
              {
                "@type": "Person",
                "name": "Şehir Plancısı Selin Yılmaz",
                "jobTitle": "TMMOB ŞPO Sicil: 6819"
              },
              {
                "@type": "Person",
                "name": "SPK Lisanslı Değerleme Uzmanı Emre Kaya",
                "jobTitle": "SPK Lisans: 408219"
              }
            ]
          }
        },
        {
          "@type": "BreadcrumbList",
          "itemListElement": [
            { "@type": "ListItem", "position": 1, "name": "Ana Sayfa", "item": "https://www.parselsorgu.net/" },
            { "@type": "ListItem", "position": 2, "name": "Mühendislik Kurulu", "item": "https://www.parselsorgu.net/muhendislik-kurulu" }
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
            background: linear-gradient(135deg, rgba(15,23,42,0.98) 0%, rgba(16,185,129,0.15) 100%);
            border: 1px solid rgba(16,185,129,0.3);
            border-radius: 18px;
            padding: 38px 36px;
            margin-bottom: 36px;
        }
        .hero-title { font-size: 30px; font-weight: 900; color: #fff; margin-bottom: 12px; }
        .hero-sub { font-size: 15.5px; color: #94a3b8; max-width: 820px; }
        
        .nav-pills { display: flex; gap: 12px; flex-wrap: wrap; margin-bottom: 32px; }
        .nav-pill {
            background: #1e293b; color: #cbd5e1; text-decoration: none;
            padding: 10px 18px; border-radius: 8px; font-size: 13.5px; font-weight: 700;
            border: 1px solid #334155; display: inline-flex; align-items: center; gap: 8px;
            transition: all 0.2s;
        }
        .nav-pill:hover, .nav-pill.active { background: var(--accent-blue); color: #fff; border-color: var(--accent-cyan); }

        .step-card {
            background: var(--card-dark);
            border: 1px solid var(--border-dark);
            border-radius: 14px;
            padding: 28px;
            margin-bottom: 22px;
            display: grid;
            grid-template-columns: 80px 1fr;
            gap: 22px;
            position: relative;
        }
        @media(max-width: 640px) {
            .step-card { grid-template-columns: 1fr; }
        }
        .step-num {
            width: 64px; height: 64px;
            border-radius: 14px;
            background: rgba(2,132,199,0.18);
            border: 2px solid var(--accent-blue);
            color: var(--accent-cyan);
            display: flex; align-items: center; justify-content: center;
            font-size: 24px; font-weight: 900;
            font-family: monospace;
        }
        .step-title { font-size: 19px; font-weight: 800; color: #fff; margin-bottom: 8px; }
        .step-desc { font-size: 14px; color: #cbd5e1; line-height: 1.65; }

        .law-box {
            background: #0b1329;
            border: 1px solid #1e293b;
            border-radius: 8px;
            padding: 12px 16px;
            margin-top: 12px;
            font-size: 12.5px;
            color: #94a3b8;
            display: flex; align-items: center; gap: 10px;
        }
    </style>
    <link rel="alternate" type="application/json" href="https://www.parselsorgu.net/api/2026-kadastro-endeks.json" title="2026 Kadastro ve İmar Açık Veri Seti">
    <script type="application/ld+json">{"@context": "https://schema.org", "@type": "WebPage", "speakable": {"@type": "SpeakableSpecification", "cssSelector": ["h1", ".lead", ".summary-box", ".hero-desc", "main p"]}, "isBasedOn": "https://www.parselsorgu.net/api/2026-kadastro-endeks.json", "publisher": {"@type": "Organization", "name": "Ant Harita Mühendislik - ParselSorgu.net", "url": "https://www.parselsorgu.net/"}}</script>
</head>
<body>

<?php if (function_exists('render_saas_navbar')) render_saas_navbar('muhendislik-kurulu'); ?>

<div class="eeat-container">

    <!-- Breadcrumb -->
    <nav style="font-size:12px; color:#94a3b8; margin-bottom:18px; display:flex; gap:6px; align-items:center;">
        <a href="/" style="color:var(--accent-cyan); text-decoration:none;"><i class="fa-solid fa-house"></i> Ana Sayfa</a>
        <span>&raquo;</span>
        <span style="color:#f8fafc; font-weight:700;">Mühendislik Denetim Kurulu</span>
    </nav>

    <!-- Sub-Nav Pill Links -->
    <div class="nav-pills">
        <a href="/hakkimizda" class="nav-pill"><i class="fa-solid fa-building-columns"></i> Kurumsal &amp; Sicil Bilgileri</a>
        <a href="/yazarlar" class="nav-pill"><i class="fa-solid fa-user-tie"></i> Yazarlar &amp; Uzman Kadro</a>
        <a href="/muhendislik-kurulu" class="nav-pill active"><i class="fa-solid fa-award"></i> Mühendislik Denetim Kurulu (YMYL)</a>
        <a href="/basin-kiti" class="nav-pill"><i class="fa-solid fa-newspaper"></i> Basın Kiti &amp; Açık Veri</a>
    </div>

    <!-- Hero Header -->
    <div class="hero-banner">
        <div style="display:inline-flex; align-items:center; gap:8px; background:rgba(16,185,129,0.2); border:1px solid #10b981; color:#34d399; padding:4px 12px; border-radius:999px; font-size:11.5px; font-weight:800; text-transform:uppercase; margin-bottom:14px;">
            <i class="fa-solid fa-stamp"></i> Çift Kör Mühendislik &amp; Hakem Heyeti Denetimi
        </div>
        <h1 class="hero-title">ParselPro 4 Aşamalı Doğruluk &amp; Kalibrasyon Protokolü</h1>
        <p class="hero-sub">
            Google'ın YMYL (Paranız veya Hayatınız) içerik kriterleri ve TMMOB mesleki etik standartları uyarınca; platformumuzdaki her bir algoritma ve mevzuat rehberi aşağıdaki 4 filtreli denetim sürecinden geçerek onaylanmaktadır.
        </p>
    </div>

    <!-- Step 1 -->
    <div class="step-card">
        <div class="step-num">01</div>
        <div>
            <h2 class="step-title">Resmî Gazete &amp; Mevzuat Webhook Takibi</h2>
            <p class="step-desc">
                Çevre, Şehircilik ve İklim Değişikliği Bakanlığı ile Tarım ve Orman Bakanlığı tarafından yayınlanan tüm yönetmelik değişiklikleri (Planlı Alanlar, Plansız Alanlar, Otopark Yönetmeliği, 5403 s.K. Tarımsal Arazi Sınırları) Resmî Gazete yayınlandığı gün taranır ve mevzuat veritabanımız anında revize edilir.
            </p>
            <div class="law-box">
                <i class="fa-solid fa-scroll" style="color:var(--accent-cyan); font-size:16px;"></i>
                <span>Referans Kaynak: T.C. Resmî Gazete &bull; Mevzuat Bilgi Sistemi (mevzuat.gov.tr)</span>
            </div>
        </div>
    </div>

    <!-- Step 2 -->
    <div class="step-card">
        <div class="step-num" style="background:rgba(16,185,129,0.18); border-color:#10b981; color:#34d399;">02</div>
        <div>
            <h2 class="step-title">Lisanslı Mühendis Tarafından Çapraz Formül Doğrulaması</h2>
            <p class="step-desc">
                Geliştirilen bot hesaplama motorları (Örn: Köy Evi TAKS %40 kuralı, 18. Madde DOP maksimum %45 kesintisi, ifraz terk payı hesapları) TMMOB HKMO tescilli harita mühendislerimiz ve şehir plancılarımız tarafından örnekleme parseller üzerinde elle ve Netcad/AutoCAD ortamında çapraz kontrolden geçirilir.
            </p>
            <div class="law-box">
                <i class="fa-solid fa-pen-ruler" style="color:#34d399; font-size:16px;"></i>
                <span>Denetçi: TMMOB HKMO Sicil 12480 &bull; TMMOB ŞPO Sicil 6819</span>
            </div>
        </div>
    </div>

    <!-- Step 3 -->
    <div class="step-card">
        <div class="step-num" style="background:rgba(245,158,11,0.18); border-color:#f59e0b; color:#fbbf24;">03</div>
        <div>
            <h2 class="step-title">TKGM MEGSİS ve Coğrafi Bilgi Sistemleri (CBS) Kalibrasyonu</h2>
            <p class="step-desc">
                Harita üzerindeki WGS84 koordinatlarının ITRF95 (3 derecelik dilim) projeksiyonuna dönüşümü milimetrik hassasiyetle test edilir. TKGM MEGSİS açık servisleriyle ada/parsel poligon geometrisi, köşe koordinatları ve parsel yol cepheleri gerçek zemin topoğrafyasıyla eşleştirilir.
            </p>
            <div class="law-box">
                <i class="fa-solid fa-satellite" style="color:#fbbf24; font-size:16px;"></i>
                <span>Standart: BÖHYY (Büyük Ölçekli Harita ve Harita Bilgileri Üretim Yönetmeliği)</span>
            </div>
        </div>
    </div>

    <!-- Step 4 -->
    <div class="step-card">
        <div class="step-num" style="background:rgba(192,132,252,0.18); border-color:#c084fc; color:#e879f9;">04</div>
        <div>
            <h2 class="step-title">Yıllık Revizyon &amp; Birim Fiyat Güncellemesi</h2>
            <p class="step-desc">
                Her yılın Şubat ayında Çevre ve Şehircilik Bakanlığı'nca Resmi Gazete'de ilan edilen "Mimarlık ve Mühendislik Hizmet Bedellerinin Hesabında Kullanılacak Yapı Yaklaşık Birim Maliyetleri" ile Gelir İdaresi Başkanlığı'nın Tapu Harcı Döner Sermaye katsayıları sisteme işlenerek tüm geçmiş raporların geçerliliği yenilenir.
            </p>
            <div class="law-box">
                <i class="fa-solid fa-calculator" style="color:#e879f9; font-size:16px;"></i>
                <span>Aktif Sürüm: 2026 ÇŞB Resmî Tebliği &bull; 2026 GİB Emlak Vergisi ve Harç Oranları</span>
            </div>
        </div>
    </div>

    <!-- Editorial Disclaimer Box -->
    <div style="background:linear-gradient(135deg, rgba(30,41,59,0.8) 0%, rgba(15,23,42,0.95) 100%); border:1px solid #334155; border-radius:14px; padding:28px; margin-top:36px;">
        <h3 style="font-size:17px; font-weight:800; color:#fff; margin-bottom:10px;">
            <i class="fa-solid fa-triangle-exclamation" style="color:var(--accent-amber);"></i> Yasal Uyarı ve Sorumluluk Sınırı
        </h3>
        <p style="font-size:13.5px; color:#94a3b8; line-height:1.65; margin:0;">
            ParselPro'da yer alan tüm analizler, hesaplama botları ve mevzuat özetleri vatandaşların ve profesyonellerin ön fizibilite süreçlerini hızlandırmak amacıyla hazırlanmıştır. Parsel üzerindeki fiili tasarruf, yapı ruhsatı ve tapu tescil işlemlerinde yetkili belediye imar müdürlüğü ve Lisanslı Harita Kadastro Mühendislik Bürosu'ndan (LİHKAB) yerinde aplikasyon ve resmi imar durum belgesi alınması kanunen zorunludur.
        </p>
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
