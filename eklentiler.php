<?php
/**
 * ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ - PARSEL PRO
 * TÜM HARİTA, KADASTRO & İMAR EKLENTİLERİ / SAAS ARAÇLARI MERKEZİ (eklentiler.php)
 * Pure PHP 8.3 / Responsive Grid / 30+ Mühendislik Modülü
 */

declare(strict_types=1);

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/navbar.php';

$page_title = "Harita, Kadastro ve İmar Araçları (35+) | ParselSorgu";
$meta_desc = "TMMOB HKMO tescilli 5403 tarla ifrazı, arsa değerleme, Web-CAD, LİHKAB harç hesabı ve 35+ ücretsiz harita mühendisliği eklentisi.";
$canonical_url = "https://www.parselsorgu.net/eklentiler";
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($page_title) ?></title>
    <meta name="description" content="<?= htmlspecialchars($meta_desc) ?>">
    <link rel="canonical" href="<?= $canonical_url ?>    <meta property="og:image" content="https://www.parselsorgu.net/assets/images/og-parsel.jpg">
">
    <link rel="alternate" hreflang="tr" href="<?= $canonical_url ?>" />
    <meta property="og:title" content="<?= htmlspecialchars($page_title) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($meta_desc) ?>">
    <meta property="og:url" content="<?= $canonical_url ?>">
    <meta name="theme-color" content="#090e17">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        :root {
            --primary: #1e40af;
            --accent: #38bdf8;
            --green: #10b981;
            --amber: #f59e0b;
            --rose: #f43f5e;
            --purple: #a855f7;
            --dark-bg: #090e17;
            --card-bg: #0f172a;
            --card-surface: #131d31;
            --border-color: #1e293b;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background-color: var(--dark-bg);
            color: var(--text-main);
            line-height: 1.5;
        }

        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 24px 16px 80px 16px;
        }

        .hero-banner {
            text-align: center;
            padding: 40px 16px 32px 16px;
            background: radial-gradient(circle at 50% 20%, rgba(16, 185, 129, 0.12) 0%, transparent 70%);
            border-bottom: 1px solid var(--border-color);
            margin-bottom: 32px;
        }
        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(16, 185, 129, 0.12);
            border: 1px solid rgba(16, 185, 129, 0.35);
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 700;
            color: var(--green);
            margin-bottom: 16px;
        }
        .hero-banner h1 {
            font-size: 32px;
            font-weight: 800;
            color: #fff;
            margin-bottom: 12px;
        }
        .hero-banner h1 span { color: var(--accent); }
        .hero-banner p {
            font-size: 15px;
            color: var(--text-muted);
            max-width: 860px;
            margin: 0 auto 20px auto;
        }

        .section-title {
            font-size: 20px;
            font-weight: 800;
            color: #fff;
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 36px 0 18px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            padding-bottom: 12px;
        }

        .tools-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 18px;
        }

        .tool-card {
            background: linear-gradient(180deg, #131d31 0%, #0c1220 100%);
            border: 1px solid #1e293b;
            border-radius: 14px;
            padding: 22px;
            display: flex;
            flex-direction: column;
            text-decoration: none;
            position: relative;
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.25);
            overflow: hidden;
        }
        .tool-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; height: 3px;
            background: #38bdf8;
            opacity: 0.8;
            transition: height 0.2s;
        }
        .tool-card.tool-green::before { background: linear-gradient(90deg, #10b981, #059669); }
        .tool-card.tool-blue::before { background: linear-gradient(90deg, #38bdf8, #0284c7); }
        .tool-card.tool-purple::before { background: linear-gradient(90deg, #c084fc, #9333ea); }
        .tool-card.tool-rose::before { background: linear-gradient(90deg, #f43f5e, #e11d48); }
        .tool-card.tool-amber::before { background: linear-gradient(90deg, #f59e0b, #d97706); }

        .tool-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.45);
        }
        .tool-card.tool-green:hover { border-color: #10b981; }
        .tool-card.tool-blue:hover { border-color: #38bdf8; }
        .tool-card.tool-purple:hover { border-color: #c084fc; }
        .tool-card.tool-rose:hover { border-color: #f43f5e; }
        .tool-card.tool-amber:hover { border-color: #f59e0b; }

        .tool-card-badge {
            align-self: flex-start;
            font-size: 10.5px;
            font-weight: 700;
            padding: 3px 8px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            margin-bottom: 14px;
        }
        .tool-green .tool-card-badge { color: #10b981; border: 1px solid rgba(16, 185, 129, 0.3); background: rgba(16, 185, 129, 0.1); }
        .tool-blue .tool-card-badge { color: #38bdf8; border: 1px solid rgba(56, 189, 248, 0.3); background: rgba(56, 189, 248, 0.1); }
        .tool-purple .tool-card-badge { color: #c084fc; border: 1px solid rgba(192, 132, 252, 0.3); background: rgba(192, 132, 252, 0.1); }
        .tool-rose .tool-card-badge { color: #f43f5e; border: 1px solid rgba(244, 63, 94, 0.3); background: rgba(244, 63, 94, 0.1); }
        .tool-amber .tool-card-badge { color: #f59e0b; border: 1px solid rgba(245, 158, 11, 0.3); background: rgba(245, 158, 11, 0.1); }

        .tool-card-icon {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            margin-bottom: 14px;
        }
        .tool-green .tool-card-icon { background: rgba(16, 185, 129, 0.15); color: #10b981; }
        .tool-blue .tool-card-icon { background: rgba(56, 189, 248, 0.15); color: #38bdf8; }
        .tool-purple .tool-card-icon { background: rgba(192, 132, 252, 0.15); color: #c084fc; }
        .tool-rose .tool-card-icon { background: rgba(244, 63, 94, 0.15); color: #f43f5e; }
        .tool-amber .tool-card-icon { background: rgba(245, 158, 11, 0.15); color: #f59e0b; }

        .tool-card-title {
            font-size: 16px;
            font-weight: 700;
            color: #f8fafc;
            margin: 0 0 6px 0;
            line-height: 1.35;
        }
        .tool-card-desc {
            font-size: 12.5px;
            line-height: 1.5;
            color: #94a3b8;
            margin: 0 0 18px 0;
            flex-grow: 1;
        }
        .tool-card-btn {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 12px;
            font-weight: 700;
            padding-top: 12px;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            transition: all 0.2s;
        }
        .tool-green .tool-card-btn { color: #10b981; }
        .tool-blue .tool-card-btn { color: #38bdf8; }
        .tool-purple .tool-card-btn { color: #c084fc; }
        .tool-rose .tool-card-btn { color: #f43f5e; }
        .tool-amber .tool-card-btn { color: #f59e0b; }
        .tool-card:hover .tool-card-btn i { transform: translateX(4px); }

        @media (max-width: 768px) {
            .tools-grid { grid-template-columns: 1fr; }
            .hero-banner h1 { font-size: 24px; }
        }
    </style>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@graph": [
    {
      "@type": "WebApplication",
      "@id": "https://www.parselsorgu.net/eklentiler#app",
      "name": "Harita, Kadastro & İmar Eklentileri Kataloğu",
      "url": "https://www.parselsorgu.net/eklentiler",
      "description": "Ant Harita Mühendislik tarafından geliştirilen 25+ yeni nesil harita, kadastro, imar hukuku ve gayrimenkul analiz SaaS aracı.",
      "applicationCategory": "BusinessApplication",
      "operatingSystem": "All",
      "browserRequirements": "Requires JavaScript. Requires HTML5.",
      "offers": {
        "@type": "Offer",
        "price": "0",
        "priceCurrency": "TRY"
      },
      "creator": {
        "@type": "Organization",
        "name": "Ant Harita Mühendislik",
        "url": "https://www.parselsorgu.net",
        "identifier": "TMMOB HKMO Sicil: 12480"
      }
    },
    {
      "@type": "BreadcrumbList",
      "@id": "https://www.parselsorgu.net/eklentiler#breadcrumb",
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
          "name": "Eklentiler & SaaS",
          "item": "https://www.parselsorgu.net/eklentiler"
        },
        {
          "@type": "ListItem",
          "position": 3,
          "name": "Harita, Kadastro & İmar Eklentileri Kataloğu",
          "item": "https://www.parselsorgu.net/eklentiler"
        }
      ]
    },
    {
      "@type": "FAQPage",
      "@id": "https://www.parselsorgu.net/eklentiler#faq",
      "mainEntity": [
        {
          "@type": "Question",
          "name": "ParselSorgu eklentileri ücretsiz midir?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Evet, platformdaki temel eklenti ve hesaplama motorları ücretsiz olarak kullanıma sunulmaktadır."
          }
        },
        {
          "@type": "Question",
          "name": "Eklentileri kendi web siteme nasıl entegre edebilirim?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Sitene Parsel Sorgu Ekle aracımızı kullanarak responsive iframe kodunu alabilir ve sitenize harita sorgulama motoru ekleyebilirsiniz."
          }
        }
      ]
    }
  ]
}
</script>
    <link rel="alternate" type="text/markdown" href="https://www.parselsorgu.net/llms.txt" title="ParselSorgu AI / LLM Bilgi Bankası">
    <link rel="alternate" type="application/json" href="https://www.parselsorgu.net/api/2026-kadastro-endeks.json" title="2026 Kadastro ve İmar Açık Veri Seti">
    <script type="application/ld+json">{"@context": "https://schema.org", "@type": "WebPage", "speakable": {"@type": "SpeakableSpecification", "cssSelector": ["h1", ".lead", ".summary-box", ".hero-desc", "main p"]}, "isBasedOn": "https://www.parselsorgu.net/api/2026-kadastro-endeks.json", "publisher": {"@type": "Organization", "name": "Ant Harita Mühendislik - ParselSorgu.net", "url": "https://www.parselsorgu.net/"}}</script>
</head>
<body>

    <?= render_navbar('eklentiler') ?>

    <main class="container">
        <!-- HERO -->
        <section class="hero-banner">
            <div class="hero-badge">
                <i class="fa-solid fa-puzzle-piece"></i> 2026 SaaS &bull; Mühendislik Çözümleri Havuzu
            </div>
            <h1>Tüm Harita, Kadastro &amp; <span>İmar Eklentileri</span></h1>
            <p>
                TMMOB HKMO tescilli Ant Harita (Sicil: 12480) CBS algoritmalarıyla geliştirilen 30+ otonom hesaplayıcı, canlı takip motoru, Web-CAD ve değerleme modülü.
            </p>
        </section>

        <!-- KATEGORİ 1: AMİRAL GEMİSİ SAAS MODÜLLERİ -->
        <h2 class="section-title"><i class="fa-solid fa-bolt" style="color:var(--accent);"></i> Yeni Nesil SaaS Araçları &amp; Eklentiler</h2>
        <div class="tools-grid">

            <!-- Hafriyat Kübaj & İstinat -->
            <a href="/hafriyat-kubaj-istinat-maliyet" class="tool-card tool-amber">
                <div class="tool-card-badge"><i class="fa-solid fa-truck-moving"></i> KÜBAJ</div>
                <div class="tool-card-icon"><i class="fa-solid fa-mound"></i></div>
                <h3 class="tool-card-title">Hafriyat (Kübaj) &amp; İstinat</h3>
                <p class="tool-card-desc">Kazı m³, kamyon sefer adedi, kırıcı maliyeti, taş/betonarme istinat duvarı ve harita kübaj ölçüm talebi.</p>
                <div class="tool-card-btn"><span>Kübaj Hesapla →</span><i class="fa-solid fa-arrow-right"></i></div>
            </a>

            <!-- Tarla Elektrik Bağlatma -->
            <!-- 0D. 3D Bina & Güneş Gölge Simülatörü -->
            <a href="/3d-gunes-golge-simulasyonu" class="tool-card tool-amber">
                <div class="tool-card-badge"><i class="fa-solid fa-sun"></i> 3D SİMÜLATÖR</div>
                <div class="tool-card-icon"><i class="fa-solid fa-cube"></i></div>
                <h3 class="tool-card-title">3D Bina &amp; Güneş/Gölge Analizi</h3>
                <p class="tool-card-desc">Arsa çekme mesafeli 3D bina kütlesi ve gün boyu güneş/gölge açısı canlı simülasyonu.</p>
                <div class="tool-card-btn"><span>3D Simülasyonu Başlat →</span><i class="fa-solid fa-arrow-right"></i></div>
            </a>

            <a href="/tarla-elektrik-baglatma-maliyeti" class="tool-card tool-amber">
                <div class="tool-card-badge"><i class="fa-solid fa-bolt"></i> EDAŞ</div>
                <div class="tool-card-icon"><i class="fa-solid fa-tower-broadcast"></i></div>
                <h3 class="tool-card-title">Tarla Elektrik &amp; Direk Maliyeti</h3>
                <p class="tool-card-desc">Mesafeye göre direk adedi, kablo metrajı, trafo kurulumu ve yapı/kuyu ruhsatı abonelik analizi.</p>
                <div class="tool-card-btn"><span>Hat Maliyeti Çıkar →</span><i class="fa-solid fa-arrow-right"></i></div>
            </a>

            <!-- Kamulaştırma & İrtifak -->
            <a href="/kamulastirma-bedeli-hesaplama" class="tool-card tool-rose">
                <div class="tool-card-badge"><i class="fa-solid fa-road"></i> 2942 s.K.</div>
                <div class="tool-card-icon"><i class="fa-solid fa-scale-balanced"></i></div>
                <h3 class="tool-card-title">Kamulaştırma &amp; İrtifak Bedeli</h3>
                <p class="tool-card-desc">Yol, otoyol ve TEİAŞ yüksek gerilim hattı geçişlerinde 2942 m.11 kapitalizasyon ve değer kaybı hesabı.</p>
                <div class="tool-card-btn"><span>Tazminat Hesapla →</span><i class="fa-solid fa-arrow-right"></i></div>
            </a>

            <!-- Kadastro 22/A İtiraz & Tecviz -->
            <a href="/kadastro-yenileme-itiraz" class="tool-card tool-blue">
                <div class="tool-card-badge"><i class="fa-solid fa-triangle-exclamation"></i> 3402 s.K.</div>
                <div class="tool-card-icon"><i class="fa-solid fa-ruler"></i></div>
                <h3 class="tool-card-title">Kadastro 22/A &amp; Tecviz İtiraz</h3>
                <p class="tool-card-desc">Ölçüm alan düşüşünde tecviz sınırı testi, 30 gün/10 yıl süre sayacı ve 41. Madde dilekçe taslağı.</p>
                <div class="tool-card-btn"><span>Hatayı Kontrol Et →</span><i class="fa-solid fa-arrow-right"></i></div>
            </a>

            <!-- Yüzme Havuzu & Peyzaj -->
            <a href="/havuz-peyzaj-maliyet-hesaplama" class="tool-card tool-blue">
                <div class="tool-card-badge"><i class="fa-solid fa-water-ladder"></i> VİLLA</div>
                <div class="tool-card-icon"><i class="fa-solid fa-person-swimming"></i></div>
                <h3 class="tool-card-title">Yüzme Havuzu &amp; Peyzaj</h3>
                <p class="tool-card-desc">Betonarme/liner yüzme havuzu maliyeti, otomatik çim sulama bütçesi ve 3194 emsal muafiyeti analizi.</p>
                <div class="tool-card-btn"><span>Havuz Bütçesi Çıkar →</span><i class="fa-solid fa-arrow-right"></i></div>
            </a>

            <!-- Partner Harita Mühendisleri -->
            <a href="/partner-harita-muhendisleri" class="tool-card tool-blue">
                <div class="tool-card-badge"><i class="fa-solid fa-network-wired"></i> 81 İL B2B</div>
                <div class="tool-card-icon"><i class="fa-solid fa-users-gear"></i></div>
                <h3 class="tool-card-title">81 İl Partner Mühendis Ağı</h3>
                <p class="tool-card-desc">Türkiye geneli yetkili LİHKAB &amp; SHKMMB harita mühendisliği büroları dizini ve partner başvuru portalı.</p>
                <div class="tool-card-btn"><span>Dizini İncele / Katıl →</span><i class="fa-solid fa-arrow-right"></i></div>
            </a>

            <!-- Emlakçı White-Label Rapor -->
            <a href="/emlakci-musteri-raporu" class="tool-card tool-green">
                <div class="tool-card-badge"><i class="fa-solid fa-file-pdf"></i> WHITE-LABEL</div>
                <div class="tool-card-icon"><i class="fa-solid fa-building-user"></i></div>
                <h3 class="tool-card-title">Emlakçı Müşteri Raporu</h3>
                <p class="tool-card-desc">Emlak danışmanları için kendi logosu ve ofis adıyla müşteriye özel A4 arsa yatırım sunumu üretici.</p>
                <div class="tool-card-btn"><span>Sunum Hazırla →</span><i class="fa-solid fa-arrow-right"></i></div>
            </a>

            <!-- 0A. Online NCN / DXF / KML Dönüştürücü -->
            <a href="/ncn-dxf-kml-donusturucu" class="tool-card tool-blue">
                <div class="tool-card-badge"><i class="fa-solid fa-arrows-rotate"></i> YENİ CAD</div>
                <div class="tool-card-icon"><i class="fa-solid fa-layer-group"></i></div>
                <h3 class="tool-card-title">NCN / DXF / KML Dönüştürücü</h3>
                <p class="tool-card-desc">Netcad (.NCN), AutoCAD (.DXF) ve Google Earth (.KML) dosyalarını ITRF96/ED50/WGS84 uydu haritasında açın ve çevirin.</p>
                <div class="tool-card-btn"><span>Dosya Dönüştür →</span><i class="fa-solid fa-arrow-right"></i></div>
            </a>

            <!-- 0B. Altyapı Çakışma Risk Radarı -->
            <a href="/altyapi-risk-radari" class="tool-card tool-rose">
                <div class="tool-card-badge"><i class="fa-solid fa-radar"></i> CBS RADAR</div>
                <div class="tool-card-icon"><i class="fa-solid fa-tower-broadcast"></i></div>
                <h3 class="tool-card-title">Altyapı &amp; Çakışma Risk Radarı</h3>
                <p class="tool-card-desc">Parsel çevresindeki TEİAŞ yüksek gerilim hattı, DSİ dere yatağı, otoyol ve demiryolu mesafesini canlı tarayın.</p>
                <div class="tool-card-btn"><span>Risk Taraması Yap →</span><i class="fa-solid fa-arrow-right"></i></div>
            </a>

            <!-- 0C. Otomatik İmar Dilekçesi & Şufa Stüdyosu -->
            <a href="/imar-dilekce-olusturucu" class="tool-card tool-purple">
                <div class="tool-card-badge"><i class="fa-solid fa-file-word"></i> WORD / PDF</div>
                <div class="tool-card-icon"><i class="fa-solid fa-scale-balanced"></i></div>
                <h3 class="tool-card-title">İmar Dilekçesi &amp; Şufa Stüdyosu</h3>
                <p class="tool-card-desc">3194 askı itirazı, imar çapı, LİHKAB aplikasyon ve TMK 732 şufa ihtarnamelerini Word ve PDF olarak indirin.</p>
                <div class="tool-card-btn"><span>Dilekçe Hazırla →</span><i class="fa-solid fa-arrow-right"></i></div>
            </a>

            <!-- 1. 2D TAKS/KAKS Vaziyet Planı -->
            <a href="/taks-kaks-hesaplama" class="tool-card tool-blue">
                <div class="tool-card-badge"><i class="fa-solid fa-compass-drafting"></i> 2D CAD</div>
                <div class="tool-card-icon"><i class="fa-solid fa-vector-square"></i></div>
                <h3 class="tool-card-title">2D İmar Çapı &amp; TAKS/KAKS</h3>
                <p class="tool-card-desc">Çekme mesafeli canlı 2D bina oturumu çizimi, %30 emsal harici bonus ve çıkacak net daire adedi hesabı.</p>
                <div class="tool-card-btn"><span>Planı Çiz &amp; Hesapla →</span><i class="fa-solid fa-arrow-right"></i></div>
            </a>

            <!-- 2. Tel Çit & Duvar Maliyeti -->
            <a href="/tel-cit-duvar-maliyet" class="tool-card tool-green">
                <div class="tool-card-badge"><i class="fa-solid fa-border-all"></i> METRAJ</div>
                <div class="tool-card-icon"><i class="fa-solid fa-bars-staggered"></i></div>
                <h3 class="tool-card-title">Tel Çit &amp; Duvar Maliyeti</h3>
                <p class="tool-card-desc">Tarla ve arsa çevirme direk, kafes/panel tel, perde beton duvar bütçesi ve sınır aplikasyonu uyarısı.</p>
                <div class="tool-card-btn"><span>Çit Maliyeti Çıkar →</span><i class="fa-solid fa-arrow-right"></i></div>
            </a>

            <!-- 3. Şufa (Ön Alım) Süre & İhtarname -->
            <a href="/sufa-on-alim-hakki" class="tool-card tool-purple">
                <div class="tool-card-badge"><i class="fa-solid fa-handshake"></i> TMK 733</div>
                <div class="tool-card-icon"><i class="fa-solid fa-file-signature"></i></div>
                <h3 class="tool-card-title">Şufa (Ön Alım) Risk Motoru</h3>
                <p class="tool-card-desc">Hisseli tapuda 90 günlük/2 yıllık şufa davası süresi hesaplama ve hazır Noter ihtarname taslağı.</p>
                <div class="tool-card-btn"><span>Süreyi Hesapla →</span><i class="fa-solid fa-arrow-right"></i></div>
            </a>

            <!-- 4. İnşaat Ruhsatı & SGK Prim -->
            <a href="/insaat-ruhsati-harc-hesaplama" class="tool-card tool-amber">
                <div class="tool-card-badge"><i class="fa-solid fa-helmet-safety"></i> 2026 SGK</div>
                <div class="tool-card-icon"><i class="fa-solid fa-building-shield"></i></div>
                <h3 class="tool-card-title">İnşaat Ruhsatı, SGK &amp; Harç</h3>
                <p class="tool-card-desc">2026 SGK asgari işçilik primi, yapı denetim bedeli, belediye inşaat harcı ve harita TUS maliyetleri.</p>
                <div class="tool-card-btn"><span>Resmi Harç Hesapla →</span><i class="fa-solid fa-arrow-right"></i></div>
            </a>

            <!-- 5. Kira Artış & Tahliye Taahhüdü -->
            <a href="/kira-artis-tahliye-hesaplama" class="tool-card tool-blue">
                <div class="tool-card-badge"><i class="fa-solid fa-file-contract"></i> TBK 352</div>
                <div class="tool-card-icon"><i class="fa-solid fa-percent"></i></div>
                <h3 class="tool-card-title">Kira Artış &amp; Tahliye Taslağı</h3>
                <p class="tool-card-desc">TÜFE zam hesaplama, 5 yıllık emsal kira tespiti ve Yargıtay uyumlu geçerli Tahliye Taahhütnamesi.</p>
                <div class="tool-card-btn"><span>Kira &amp; Taahhüt Hazırla →</span><i class="fa-solid fa-arrow-right"></i></div>
            </a>

            <!-- 1. Tiny House & Mühür Riski -->
            <a href="/tiny-house-imar-uygunluk" class="tool-card tool-green">
                <div class="tool-card-badge"><i class="fa-solid fa-caravan"></i> YENİ SAAS</div>
                <div class="tool-card-icon"><i class="fa-solid fa-house-chimney-window"></i></div>
                <h3 class="tool-card-title">Tiny House &amp; Mühür Riski</h3>
                <p class="tool-card-desc">Tarlaya tiny house koyma izinleri, O2 tip onay belgesi, 3194 ve 5403 s.K. mühür ve ceza risk analizi motoru.</p>
                <div class="tool-card-btn"><span>Uygunluğu Test Et →</span><i class="fa-solid fa-arrow-right"></i></div>
            </a>

            <!-- 2. Miras Paylaşımı & Veraset İntikal -->
            <a href="/miras-paylasimi-veraset-intikal" class="tool-card tool-purple">
                <div class="tool-card-badge"><i class="fa-solid fa-scroll"></i> TMK &amp; 2026</div>
                <div class="tool-card-icon"><i class="fa-solid fa-people-arrows"></i></div>
                <h3 class="tool-card-title">Miras Paylaşımı &amp; Veraset</h3>
                <p class="tool-card-desc">Vefat eden murisin tarla ve arsalarının mirasçılar arası yasal payları, 2026 vergi istisnası ve tapu devir masrafı.</p>
                <div class="tool-card-btn"><span>Hisseleri Hesapla →</span><i class="fa-solid fa-arrow-right"></i></div>
            </a>

            <!-- 3. İzale-i Şüyu İhale & Dava Simülatörü -->
            <a href="/izalei-suyu-dava-masraf-hesaplama" class="tool-card tool-amber">
                <div class="tool-card-badge"><i class="fa-solid fa-gavel"></i> UYAP E-SATIŞ</div>
                <div class="tool-card-icon"><i class="fa-solid fa-scale-unbalanced"></i></div>
                <h3 class="tool-card-title">İzale-i Şüyu İhale &amp; Dava</h3>
                <p class="tool-card-desc">Ortaklığın giderilmesi davasında %50 taban fiyatı, mahkeme masrafları ve hissedarların eline geçecek net nakit hesabı.</p>
                <div class="tool-card-btn"><span>İhaleyi Simüle Et →</span><i class="fa-solid fa-arrow-right"></i></div>
            </a>

            <!-- 4. Tarımsal Sondaj & DSİ Kuyu Ruhsatı -->
            <a href="/tarimsal-sondaj-kuyu-ruhsati" class="tool-card tool-blue">
                <div class="tool-card-badge"><i class="fa-solid fa-water"></i> 167 s.K.</div>
                <div class="tool-card-icon"><i class="fa-solid fa-faucet-drip"></i></div>
                <h3 class="tool-card-title">Tarımsal Sondaj &amp; Kuyu İzni</h3>
                <p class="tool-card-desc">Yeraltı suyu havza tahsis durumu, delgi, borulama, dalgıç pompa ve DSİ arama/kullanma ruhsat maliyeti.</p>
                <div class="tool-card-btn"><span>Kuyu Maliyeti Çıkar →</span><i class="fa-solid fa-arrow-right"></i></div>
            </a>

            <!-- 5. 2/B & Hazine Arazisi Satın Alma -->
            <a href="/hazine-arazisi-2b-satin-alma" class="tool-card tool-green">
                <div class="tool-card-badge"><i class="fa-solid fa-landmark"></i> 6292 s.K.</div>
                <div class="tool-card-icon"><i class="fa-solid fa-hand-holding-dollar"></i></div>
                <h3 class="tool-card-title">2/B &amp; Hazine Satın Alma</h3>
                <p class="tool-card-desc">Milli Emlak rayiç bedeli üzerinden %50 yasal taban, peşin %20 indirim ve 5 yıl 10 taksit faizsiz ödeme planı.</p>
                <div class="tool-card-btn"><span>Satın Almayı Hesapla →</span><i class="fa-solid fa-arrow-right"></i></div>
            </a>
            <!-- Saha Telegram Botu & PostGIS -->
            <a href="/telegram-botu" class="tool-card tool-blue">
                <div class="tool-card-badge"><i class="fa-brands fa-telegram"></i> CANLI BOT</div>
                <div class="tool-card-icon"><i class="fa-solid fa-location-crosshairs"></i></div>
                <h3 class="tool-card-title">Saha Telegram Botu &amp; Eğim</h3>
                <p class="tool-card-desc">Saha çalışanları ve eksperler için Telegram'dan atılan anlık GPS konumuyla Copernicus DEM eğim analizi, rakım ve uydu haritası.</p>
                <div class="tool-card-btn"><span>Botu Başlat →</span><i class="fa-solid fa-arrow-right"></i></div>
            </a>
            <!-- 1. Akıllı Parsel Alarmı -->
            <a href="/parsel-takip" class="tool-card tool-blue">
                <div class="tool-card-badge"><i class="fa-solid fa-bell"></i> 7/24 NÖBET</div>
                <div class="tool-card-icon"><i class="fa-solid fa-satellite-dish"></i></div>
                <h3 class="tool-card-title">Akıllı Parsel Alarmı</h3>
                <p class="tool-card-desc">Arsanız için canlı nöbetçi kurun; imar planı askıya çıktığında, emsal rayiç değişiminde SMS/WhatsApp bildirimi alın.</p>
                <div class="tool-card-btn"><span>Alarm Kur →</span><i class="fa-solid fa-arrow-right"></i></div>
            </a>

            <!-- 2. Web-CAD & Netcad Krokisi -->
            <a href="/web-cad" class="tool-card tool-green">
                <div class="tool-card-badge"><i class="fa-solid fa-drafting-compass"></i> WEB CAD</div>
                <div class="tool-card-icon"><i class="fa-solid fa-compass-drafting"></i></div>
                <h3 class="tool-card-title">Web-CAD &amp; Netcad Krokisi</h3>
                <p class="tool-card-desc">Tarayıcıda canlı kroki çizimi, ITRF96 köşe koordinat tablosu, 5m çekme mesafesi ve Netcad (.DXF) indirme motoru.</p>
                <div class="tool-card-btn"><span>Kroki Çiz →</span><i class="fa-solid fa-arrow-right"></i></div>
            </a>

            <!-- 3. QR Parsel Doğrulama -->
            <a href="/parsel-dogrulama" class="tool-card tool-amber">
                <div class="tool-card-badge"><i class="fa-solid fa-stamp"></i> GÜVEN MÜHRÜ</div>
                <div class="tool-card-icon"><i class="fa-solid fa-certificate"></i></div>
                <h3 class="tool-card-title">QR Doğrulama Sertifikası</h3>
                <p class="tool-card-desc">Sahibinden ve emlak ilanlarına eklenebilir Ant Harita HKMO tescilli QR kodlu parsel doğrulama sertifikası.</p>
                <div class="tool-card-btn"><span>Sertifika Al →</span><i class="fa-solid fa-arrow-right"></i></div>
            </a>

            <!-- 4. Arsa Payı Cetveli -->
            <a href="/arsa-payi-hesaplama" class="tool-card tool-purple">
                <div class="tool-card-badge"><i class="fa-solid fa-scale-balanced"></i> 634 s.K.</div>
                <div class="tool-card-icon"><i class="fa-solid fa-building-circle-check"></i></div>
                <h3 class="tool-card-title">Arsa Payı Dağıtım Cetveli</h3>
                <p class="tool-card-desc">Kat irtifakı tesisinde m², kat ve cephe şerefiyesine göre yasal 1000/1000 arsa payı hesaplama ve resmi cetvel.</p>
                <div class="tool-card-btn"><span>Cetvel Oluştur →</span><i class="fa-solid fa-arrow-right"></i></div>
            </a>

            <!-- 5. REST API Developer Hub -->
            <a href="/api-docs" class="tool-card tool-rose">
                <div class="tool-card-badge"><i class="fa-solid fa-code"></i> B2B API</div>
                <div class="tool-card-icon"><i class="fa-solid fa-terminal"></i></div>
                <h3 class="tool-card-title">REST API Developer Hub</h3>
                <p class="tool-card-desc">Proptech ve CRM yazılımları için 81 il canlı TKGM MEGSİS kadastro, değerleme ve ifraz REST API dokümantasyonu.</p>
                <div class="tool-card-btn"><span>API'yi İncele →</span><i class="fa-solid fa-arrow-right"></i></div>
            </a>

            <!-- 6. 5403 Tarla İfrazı -->
            <a href="/tarla-ifraz-hesaplama" class="tool-card tool-green">
                <div class="tool-card-badge"><i class="fa-solid fa-wheat-awn"></i> 5403 s.K.</div>
                <div class="tool-card-icon"><i class="fa-solid fa-ruler-combined"></i></div>
                <h3 class="tool-card-title">5403 Tarla İfrazı</h3>
                <p class="tool-card-desc">Tarlam kaç parsele bölünür? Yasal asgari ifraz büyüklüğü ve kadastral yol analiz motoru.</p>
                <div class="tool-card-btn"><span>İfraz Hesapla →</span><i class="fa-solid fa-arrow-right"></i></div>
            </a>

            <!-- 7. Arsa Değerleme -->
            <a href="/arsa-degerleme-hesaplama" class="tool-card tool-blue">
                <div class="tool-card-badge"><i class="fa-solid fa-coins"></i> 2026 RAYİÇ</div>
                <div class="tool-card-icon"><i class="fa-solid fa-chart-line"></i></div>
                <h3 class="tool-card-title">Arsa Değerleme &amp; Rayiç</h3>
                <p class="tool-card-desc">Arsam ne kadar eder? 81 il ve ilçe bazında emsal m² birim fiyatları ve 2026 piyasa değeri.</p>
                <div class="tool-card-btn"><span>Fiyat Hesapla →</span><i class="fa-solid fa-arrow-right"></i></div>
            </a>

            <!-- 8. Toplu Parsel Portföyü -->
            <a href="/toplu-parsel-sorgulama" class="tool-card tool-purple">
                <div class="tool-card-badge"><i class="fa-solid fa-layer-group"></i> PRO ARAÇ</div>
                <div class="tool-card-icon"><i class="fa-solid fa-boxes-stacked"></i></div>
                <h3 class="tool-card-title">Toplu Parsel Portföyü</h3>
                <p class="tool-card-desc">Çoklu ada/parseli kopyalayıp yapıştırın; tapu alanlarını, uydu sınırlarını topluca Excel'e aktarın.</p>
                <div class="tool-card-btn"><span>Toplu Sorgula →</span><i class="fa-solid fa-arrow-right"></i></div>
            </a>

            <!-- 9. Resmi Parsel Raporu -->
            <a href="/parsel-raporu" class="tool-card tool-rose">
                <div class="tool-card-badge"><i class="fa-solid fa-file-pdf"></i> RESMİ PDF</div>
                <div class="tool-card-icon"><i class="fa-solid fa-file-shield"></i></div>
                <h3 class="tool-card-title">Resmi Parsel Raporu</h3>
                <p class="tool-card-desc">Ant Harita HKMO tescilli A4 resmi formatta detaylı imar, kadastro ve mülkiyet ön inceleme belgesi.</p>
                <div class="tool-card-btn"><span>Rapor İndir →</span><i class="fa-solid fa-arrow-right"></i></div>
            </a>

            <!-- 10. KML & CAD Dışa Aktarma -->
            <a href="/export-parsel?format=kml" class="tool-card tool-amber">
                <div class="tool-card-badge"><i class="fa-solid fa-download"></i> NETCAD / CAD</div>
                <div class="tool-card-icon"><i class="fa-solid fa-file-export"></i></div>
                <h3 class="tool-card-title">KML &amp; CAD Aktar</h3>
                <p class="tool-card-desc">Sorgulanan parselin koordinatlarını Google Earth (.kml) ve AutoCAD/Netcad (.dxf) formatında indirin.</p>
                <div class="tool-card-btn"><span>Dosya İndir →</span><i class="fa-solid fa-arrow-right"></i></div>
            </a>
            <!-- 11. Tarla Verimlilik Raporu -->
            <a href="/tarla-verimlilik-raporu" class="tool-card tool-green">
                <div class="tool-card-badge"><i class="fa-solid fa-seedling"></i> AGRITECH</div>
                <div class="tool-card-icon"><i class="fa-solid fa-wheat-awn"></i></div>
                <h3 class="tool-card-title">Tarla Verimlilik &amp; Ürün Raporu</h3>
                <p class="tool-card-desc">İklim, rakım ve eğime göre tarlanıza en uygun meyve/ürün (Ceviz, Badem, Zeytin) ve 5 yıllık ciro fizibilitesi.</p>
                <div class="tool-card-btn"><span>Fizibilite Çıkar →</span><i class="fa-solid fa-arrow-right"></i></div>
            </a>

            <!-- 12. 2026 Emlak Vergisi Hesaplama -->
            <a href="/emlak-vergisi-hesaplama" class="tool-card tool-blue">
                <div class="tool-card-badge"><i class="fa-solid fa-receipt"></i> 1319 s.K.</div>
                <div class="tool-card-icon"><i class="fa-solid fa-coins"></i></div>
                <h3 class="tool-card-title">2026 Emlak Vergisi Motoru</h3>
                <p class="tool-card-desc">Büyükşehir ve ilçe bazında arsa, tarla ve konut 2026 belediye emlak vergisi taksitleri ve %10 kültür payı.</p>
                <div class="tool-card-btn"><span>Vergi Hesapla →</span><i class="fa-solid fa-arrow-right"></i></div>
            </a>

            <!-- 13. Akıllı Arsa Takas (Trampa) -->
            <a href="/arsa-takas-pazari" class="tool-card tool-amber">
                <div class="tool-card-badge"><i class="fa-solid fa-repeat"></i> PROPTECH</div>
                <div class="tool-card-icon"><i class="fa-solid fa-right-left"></i></div>
                <h3 class="tool-card-title">Arsa Takas (Trampa) Pazarı</h3>
                <p class="tool-card-desc">Nakit sıkışıklığı olmadan elinizdeki arsa veya tarlayı Türkiye genelinde değer denkliğine göre takas edin.</p>
                <div class="tool-card-btn"><span>Takas İlanı Ver →</span><i class="fa-solid fa-arrow-right"></i></div>
            </a>

            <!-- 14. Yapı Kayıt Belgesi Risk Sihirbazı -->
            <a href="/yapi-kayit-belgesi-sorgulama" class="tool-card tool-rose">
                <div class="tool-card-badge"><i class="fa-solid fa-triangle-exclamation"></i> İMAR BARIŞI</div>
                <div class="tool-card-icon"><i class="fa-solid fa-house-chimney-crack"></i></div>
                <h3 class="tool-card-title">Yapı Kayıt Belgesi Risk Testi</h3>
                <p class="tool-card-desc">3194 Geçici 16. Madde uyarınca Yapı Kayıt Belgesi iptal riski, Hazine arazisi tapu devri ve güçlendirme analizi.</p>
                <div class="tool-card-btn"><span>Riskini Test Et →</span><i class="fa-solid fa-arrow-right"></i></div>
            </a>

            <!-- 15. Ziraat Tarım Kredisi Hesaplayıcı -->
            <a href="/tarim-kredisi-hesaplama" class="tool-card tool-purple">
                <div class="tool-card-badge"><i class="fa-solid fa-tractor"></i> SÜBVANSİYON</div>
                <div class="tool-card-icon"><i class="fa-solid fa-hand-holding-dollar"></i></div>
                <h3 class="tool-card-title">Sübvansiyonlu Tarım Kredisi</h3>
                <p class="tool-card-desc">Cumhurbaşkanlığı Kararı uyarınca 5403 hisseli arazi birleştirme, genç/kadın çiftçi indirimli faiz ve ödeme tablosu.</p>
                <div class="tool-card-btn"><span>Kredi Hesapla →</span><i class="fa-solid fa-arrow-right"></i></div>
            </a>

        </div>

        <!-- KATEGORİ 2: 20 OTONOM İMAR VE MEVZUAT BOTLARI -->
        <h2 class="section-title"><i class="fa-solid fa-robot" style="color:var(--green);"></i> 20 Otonom İmar &amp; Arazi Botu</h2>
        <div class="tools-grid">

            <a href="/bot/ges-arazi-uygunluk" class="tool-card tool-green">
                <h3 class="tool-card-title">☀️ GES Arazi Uygunluk Botu</h3>
                <p class="tool-card-desc">Güneş enerjisi santrali kuru marjinal tarım arazisi ve trafo mesafesi testi.</p>
                <div class="tool-card-btn"><span>Botu Başlat →</span><i class="fa-solid fa-arrow-right"></i></div>
            </a>
            <a href="/bot/tiny-house-imar" class="tool-card tool-amber">
                <h3 class="tool-card-title">🏡 Tiny House &amp; Prefabrik Botu</h3>
                <p class="tool-card-desc">Tarım arazisinde plakalı ruhsatlı mobil yapı vs sabit subasman yasal izin analizi.</p>
                <div class="tool-card-btn"><span>Botu Başlat →</span><i class="fa-solid fa-arrow-right"></i></div>
            </a>
            <a href="/bot/koy-evi-imar" class="tool-card tool-blue">
                <h3 class="tool-card-title">🏘️ Köy Evi Yapma İzni Botu</h3>
                <p class="tool-card-desc">Plansız alanlar köy yerleşik alanı imar şartları ve kadastral yola cephe hesabı.</p>
                <div class="tool-card-btn"><span>Botu Başlat →</span><i class="fa-solid fa-arrow-right"></i></div>
            </a>
            <a href="/bot/kat-karsiligi-oran" class="tool-card tool-purple">
                <h3 class="tool-card-title">🏗️ Kat Karşılığı Paylaşım Botu</h3>
                <p class="tool-card-desc">Müteahhit paylaşım oranı (%20-%80) ve arsa sahibine düşecek net daire hesabı.</p>
                <div class="tool-card-btn"><span>Botu Başlat →</span><i class="fa-solid fa-arrow-right"></i></div>
            </a>
            <a href="/bot/miras-tarla-5403" class="tool-card tool-amber">
                <h3 class="tool-card-title">⚖️ Miras Kalan Tarla İntikal Botu</h3>
                <p class="tool-card-desc">5403 s.K. 1 yıllık yasal intikal süresi, taksim ve tek mirasçıya devir analizi.</p>
                <div class="tool-card-btn"><span>Botu Başlat →</span><i class="fa-solid fa-arrow-right"></i></div>
            </a>
            <a href="/bot/izale-i-suyu" class="tool-card tool-rose">
                <h3 class="tool-card-title">🔨 İzale-i Şüyu Botu</h3>
                <p class="tool-card-desc">Ortaklığın giderilmesi davası, mahkeme e-Satış açık artırma rayici ve masraf hesabı.</p>
                <div class="tool-card-btn"><span>Botu Başlat →</span><i class="fa-solid fa-arrow-right"></i></div>
            </a>
            <a href="/bot/taks-kaks-emsal" class="tool-card tool-blue">
                <h3 class="tool-card-title">📐 TAKS / KAKS Emsal Hesabı</h3>
                <p class="tool-card-desc">Taban oturumu, toplam kat alanı ve emsal harici alanların net hesabı.</p>
                <div class="tool-card-btn"><span>Botu Başlat →</span><i class="fa-solid fa-arrow-right"></i></div>
            </a>
            <a href="/bot/hisseli-tapu-sufa" class="tool-card tool-purple">
                <h3 class="tool-card-title">🤝 Hisseli Tapu &amp; Şufa Botu</h3>
                <p class="tool-card-desc">TMK 732 ön alım hakkı, noter bildirimi ve hisseli tapu satış risk testi.</p>
                <div class="tool-card-btn"><span>Botu Başlat →</span><i class="fa-solid fa-arrow-right"></i></div>
            </a>
            <a href="/bot/kentsel-donusum-kira" class="tool-card tool-green">
                <h3 class="tool-card-title">🏢 6306 Kentsel Dönüşüm &amp; Kira</h3>
                <p class="tool-card-desc">Riskli yapı tespiti, yıkım ve Çevre Şehircilik Bakanlığı güncel aylık kira desteği.</p>
                <div class="tool-card-btn"><span>Botu Başlat →</span><i class="fa-solid fa-arrow-right"></i></div>
            </a>
            <a href="/bot/madde-18-dop" class="tool-card tool-blue">
                <h3 class="tool-card-title">📏 18. Madde DOP Kesintisi Botu</h3>
                <p class="tool-card-desc">Arazi ve arsa düzenlemesinde azami %45 Düzenleme Ortaklık Payı ve tahsis hesabı.</p>
                <div class="tool-card-btn"><span>Botu Başlat →</span><i class="fa-solid fa-arrow-right"></i></div>
            </a>
            <a href="/bot/sit-alani-imar" class="tool-card tool-amber">
                <h3 class="tool-card-title">🏛️ 2863 Sit Alanı &amp; Trampa Botu</h3>
                <p class="tool-card-desc">1., 2., 3. derece sit kısıtları ve Hazine taşınmazları ile trampa takas hakkı.</p>
                <div class="tool-card-btn"><span>Botu Başlat →</span><i class="fa-solid fa-arrow-right"></i></div>
            </a>
            <a href="/bot/deger-artis-kazanci" class="tool-card tool-purple">
                <h3 class="tool-card-title">📊 Değer Artış Kazancı Vergisi</h3>
                <p class="tool-card-desc">Gayrimenkul 5 yıl içinde satıldığında Yİ-ÜFE endekslemesi ve istisna hesabı.</p>
                <div class="tool-card-btn"><span>Botu Başlat →</span><i class="fa-solid fa-arrow-right"></i></div>
            </a>
        </div>
    </main>

    <!-- ANT HARITA SAAS CROSS-LINKING & INTERNAL DISCOVERY ENGINE -->
    <section class="saas-crosslinks-section" style="max-width:1100px; margin:40px auto 20px; padding:24px 20px; background:linear-gradient(135deg, #0b1329 0%, #0f172a 100%); border:1px solid #1e293b; border-radius:16px;">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px; flex-wrap:wrap; gap:10px;">
            <div>
                <h3 style="color:#fff; font-size:15px; font-weight:800; margin:0 0 4px 0; display:flex; align-items:center; gap:8px;">
                    <i class="fa-solid fa-layer-group" style="color:#38bdf8;"></i> Diğer Popüler Harita, Kadastro &amp; Gayrimenkul SaaS Araçlarımız
                </h3>
                <p style="color:#94a3b8; font-size:12px; margin:0;">Ant Harita Mühendislik altyapısıyla geliştirilen diğer akıllı analiz modüllerini keşfedin.</p>
            </div>
            <a href="/eklentiler" style="background:#10b981; color:#fff; padding:6px 14px; border-radius:8px; font-size:12px; font-weight:700; text-decoration:none; display:inline-flex; align-items:center; gap:6px;">
                <i class="fa-solid fa-grid-round"></i> Tüm Modüller (25+) &rarr;
            </a>
        </div>
        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); gap:12px;">
            <a href="/tarla-verimlilik-raporu" style="display:flex; align-items:center; gap:10px; padding:10px 12px; background:#131d31; border:1px solid #1e293b; border-radius:10px; text-decoration:none; color:#f8fafc;">
                <div style="width:36px; height:36px; border-radius:8px; background:rgba(16,185,129,0.15); color:#10b981; display:flex; align-items:center; justify-content:center; font-size:16px;"><i class="fa-solid fa-seedling"></i></div>
                <div><div style="font-size:12.5px; font-weight:700;">Tarla Verimlilik SaaS</div><div style="font-size:11px; color:#94a3b8;">Ürün fizibilitesi &amp; ciro</div></div>
            </a>
            <a href="/emlak-vergisi-hesaplama" style="display:flex; align-items:center; gap:10px; padding:10px 12px; background:#131d31; border:1px solid #1e293b; border-radius:10px; text-decoration:none; color:#f8fafc;">
                <div style="width:36px; height:36px; border-radius:8px; background:rgba(56,189,248,0.15); color:#38bdf8; display:flex; align-items:center; justify-content:center; font-size:16px;"><i class="fa-solid fa-receipt"></i></div>
                <div><div style="font-size:12.5px; font-weight:700;">2026 Emlak Vergisi</div><div style="font-size:11px; color:#94a3b8;">Arsa, konut &amp; arazi harcı</div></div>
            </a>
            <a href="/arsa-takas-pazari" style="display:flex; align-items:center; gap:10px; padding:10px 12px; background:#131d31; border:1px solid #1e293b; border-radius:10px; text-decoration:none; color:#f8fafc;">
                <div style="width:36px; height:36px; border-radius:8px; background:rgba(245,158,11,0.15); color:#f59e0b; display:flex; align-items:center; justify-content:center; font-size:16px;"><i class="fa-solid fa-arrow-right-arrow-left"></i></div>
                <div><div style="font-size:12.5px; font-weight:700;">Arsa Takas Pazarı</div><div style="font-size:11px; color:#94a3b8;">Canlı trampa havuzu</div></div>
            </a>
            <a href="/yapi-kayit-belgesi-sorgulama" style="display:flex; align-items:center; gap:10px; padding:10px 12px; background:#131d31; border:1px solid #1e293b; border-radius:10px; text-decoration:none; color:#f8fafc;">
                <div style="width:36px; height:36px; border-radius:8px; background:rgba(244,63,94,0.15); color:#f43f5e; display:flex; align-items:center; justify-content:center; font-size:16px;"><i class="fa-solid fa-house-chimney-crack"></i></div>
                <div><div style="font-size:12.5px; font-weight:700;">Yapı Kayıt Risk Analizi</div><div style="font-size:11px; color:#94a3b8;">3194 Geçici 16 imar barışı</div></div>
            </a>
            <a href="/tarim-kredisi-hesaplama" style="display:flex; align-items:center; gap:10px; padding:10px 12px; background:#131d31; border:1px solid #1e293b; border-radius:10px; text-decoration:none; color:#f8fafc;">
                <div style="width:36px; height:36px; border-radius:8px; background:rgba(168,85,247,0.15); color:#a855f7; display:flex; align-items:center; justify-content:center; font-size:16px;"><i class="fa-solid fa-tractor"></i></div>
                <div><div style="font-size:12.5px; font-weight:700;">Ziraat Tarım Kredisi</div><div style="font-size:11px; color:#94a3b8;">Sübvansiyonlu hasat vadeli</div></div>
            </a>
            <a href="/arsa-deger-artisi-hesaplama" style="display:flex; align-items:center; gap:10px; padding:10px 12px; background:#131d31; border:1px solid #1e293b; border-radius:10px; text-decoration:none; color:#f8fafc;">
                <div style="width:36px; height:36px; border-radius:8px; background:rgba(16,185,129,0.15); color:#10b981; display:flex; align-items:center; justify-content:center; font-size:16px;"><i class="fa-solid fa-chart-line"></i></div>
                <div><div style="font-size:12.5px; font-weight:700;">5 Yıllık Değer Artışı</div><div style="font-size:11px; color:#94a3b8;">2021-2026 getiri grafiği</div></div>
            </a>
            <a href="/rizai-taksim-sozlesmesi" style="display:flex; align-items:center; gap:10px; padding:10px 12px; background:#131d31; border:1px solid #1e293b; border-radius:10px; text-decoration:none; color:#f8fafc;">
                <div style="width:36px; height:36px; border-radius:8px; background:rgba(192,132,252,0.15); color:#c084fc; display:flex; align-items:center; justify-content:center; font-size:16px;"><i class="fa-solid fa-file-contract"></i></div>
                <div><div style="font-size:12.5px; font-weight:700;">Rıza-i Taksim Protokolü</div><div style="font-size:11px; color:#94a3b8;">Hisseli tapu paylaşımı</div></div>
            </a>
            <a href="/koy-yerlesik-alani-sorgulama" style="display:flex; align-items:center; gap:10px; padding:10px 12px; background:#131d31; border:1px solid #1e293b; border-radius:10px; text-decoration:none; color:#f8fafc;">
                <div style="width:36px; height:36px; border-radius:8px; background:rgba(245,158,11,0.15); color:#f59e0b; display:flex; align-items:center; justify-content:center; font-size:16px;"><i class="fa-solid fa-house-circle-check"></i></div>
                <div><div style="font-size:12.5px; font-weight:700;">Köy İçi İmar Sınırı (300m)</div><div style="font-size:11px; color:#94a3b8;">Plansız alanlar analizi</div></div>
            </a>
        </div>
    </section>

</body>
</html>
