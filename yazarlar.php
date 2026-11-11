<?php
/**
 * ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ A.Ş.
 * Yazarlar ve Uzman Mühendislik Kadrosu (yazarlar.php)
 * Google YMYL & E-E-A-T Person & Author Schema Standartlarına Tam Uyumlu
 */

require_once __DIR__ . '/navbar.php';

$page_title = "Teknik Yazarlar & Mühendislik Kurulu | ParselSorgu";
$meta_desc = "TMMOB HKMO tescilli Harita Mühendisleri, Şehir Plancıları ve SPK Değerleme Uzmanlarından oluşan ParselSorgu yayın ve denetim kadrosu.";
$canonical_url = "https://www.parselsorgu.net/yazarlar";
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
    
    <!-- Google YMYL / E-E-A-T Authors & Editorial Board Schema -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@graph": [
        {
          "@type": "Person",
          "@id": "https://www.parselsorgu.net/yazarlar#mustafa-ant",
          "name": "Harita Yük. Müh. Mustafa Ant",
          "jobTitle": "Baş Harita ve Kadastro Mühendisi & Kurucu Ortak",
          "worksFor": {
            "@type": "Organization",
            "name": "Ant Harita Mühendislik Teknolojileri A.Ş.",
            "url": "https://www.parselsorgu.net"
          },
          "alumniOf": {
            "@type": "CollegeOrUniversity",
            "name": "İstanbul Teknik Üniversitesi (İTÜ) Geomatik Mühendisliği"
          },
          "memberOf": {
            "@type": "Organization",
            "name": "TMMOB Harita ve Kadastro Mühendisleri Odası (HKMO)",
            "url": "https://www.hkmo.org.tr"
          },
          "hasCredential": [
            {
              "@type": "EducationalOccupationalCredential",
              "name": "TMMOB HKMO Oda Sicil No: 12480"
            },
            {
              "@type": "EducationalOccupationalCredential",
              "name": "TKGM LİHKAB Lisans No: 06-042"
            }
          ],
          "knowsAbout": [
            "Kadastral Harita Üretimi",
            "18. Madde Arazi ve Arsa Düzenlemesi (DOP)",
            "5403 Sayılı Kanun Kapsamında Tarla İfrazı ve Bölünme",
            "TKGM MEGSİS Koordinat Dönüşümleri",
            "Kamulaştırma ve Aplikasyon Krokisi"
          ],
          "url": "https://www.parselsorgu.net/yazarlar#mustafa-ant"
        },
        {
          "@type": "Person",
          "@id": "https://www.parselsorgu.net/yazarlar#selin-yilmaz",
          "name": "Şehir Plancısı Selin Yılmaz",
          "jobTitle": "Mevzuat ve İmar Planı Direktörü",
          "worksFor": {
            "@type": "Organization",
            "name": "Ant Harita Mühendislik Teknolojileri A.Ş.",
            "url": "https://www.parselsorgu.net"
          },
          "alumniOf": {
            "@type": "CollegeOrUniversity",
            "name": "Orta Doğu Teknik Üniversitesi (ODTÜ) Şehir ve Bölge Planlama"
          },
          "memberOf": {
            "@type": "Organization",
            "name": "TMMOB Şehir Plancıları Odası (ŞPO)",
            "url": "https://www.spo.org.tr"
          },
          "hasCredential": {
            "@type": "EducationalOccupationalCredential",
            "name": "TMMOB ŞPO Sicil No: 6819"
          },
          "knowsAbout": [
            "3194 Sayılı İmar Kanunu ve Planlı Alanlar Yönetmeliği",
            "Nazım ve Uygulama İmar Planı Değişiklikleri",
            "Köy Yerleşik Alanı İmar Şartları",
            "TAKS, KAKS ve Emsal Harici Alan Hesaplamaları",
            "Belediye İmar Askı Süreçleri ve İtiraz Usulleri"
          ],
          "url": "https://www.parselsorgu.net/yazarlar#selin-yilmaz"
        },
        {
          "@type": "Person",
          "@id": "https://www.parselsorgu.net/yazarlar#emre-kaya",
          "name": "SPK Lisanslı Gayrimenkul Değerleme Uzmanı Emre Kaya",
          "jobTitle": "İnşaat Maliyeti ve Gayrimenkul Değerleme Denetmeni",
          "worksFor": {
            "@type": "Organization",
            "name": "Ant Harita Mühendislik Teknolojileri A.Ş.",
            "url": "https://www.parselsorgu.net"
          },
          "alumniOf": {
            "@type": "CollegeOrUniversity",
            "name": "Gazi Üniversitesi İnşaat Mühendisliği"
          },
          "memberOf": {
            "@type": "Organization",
            "name": "Türkiye Değerleme Uzmanları Birliği (TDUB)",
            "url": "https://www.tdub.org.tr"
          },
          "hasCredential": {
            "@type": "EducationalOccupationalCredential",
            "name": "SPK Gayrimenkul Değerleme Lisans No: 408219"
          },
          "knowsAbout": [
            "Çevre, Şehircilik ve İklim Değişikliği Bakanlığı Yapı Yaklaşık Maliyetleri",
            "Arsa Payı ve Kat Karşılığı İnşaat Paylaşım Analizi",
            "Değer Artış Kazancı ve Tapu Harcı Mevzuatı",
            "Gayrimenkul Ekspertiz ve Rayiç Bedel Modellemesi"
          ],
          "url": "https://www.parselsorgu.net/yazarlar#emre-kaya"
        },
        {
          "@type": "BreadcrumbList",
          "itemListElement": [
            { "@type": "ListItem", "position": 1, "name": "Ana Sayfa", "item": "https://www.parselsorgu.net/" },
            { "@type": "ListItem", "position": 2, "name": "Yazarlar", "item": "https://www.parselsorgu.net/yazarlar" }
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

        .author-card {
            background: var(--card-dark);
            border: 1px solid var(--border-dark);
            border-radius: 16px;
            padding: 32px;
            margin-bottom: 28px;
            display: grid;
            grid-template-columns: 160px 1fr;
            gap: 28px;
            transition: all 0.2s ease;
        }
        .author-card:hover { border-color: rgba(56,189,248,0.4); box-shadow: 0 10px 30px rgba(0,0,0,0.4); }
        @media(max-width: 768px) {
            .author-card { grid-template-columns: 1fr; text-align: center; }
            .author-avatar-wrap { margin: 0 auto; }
        }
        .author-avatar-wrap {
            width: 140px; height: 140px;
            border-radius: 20px;
            overflow: hidden;
            border: 3px solid var(--accent-blue);
            background: #1e293b;
            display: flex; align-items: center; justify-content: center;
            font-size: 54px; color: #cbd5e1;
            box-shadow: 0 8px 20px rgba(0,0,0,0.3);
        }
        .author-name { font-size: 22px; font-weight: 800; color: #fff; margin-bottom: 4px; }
        .author-title { font-size: 14px; color: var(--accent-cyan); font-weight: 700; margin-bottom: 12px; }
        .author-bio { font-size: 14px; color: #cbd5e1; margin-bottom: 16px; line-height: 1.65; }
        
        .badge-list { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 16px; }
        .author-badge {
            background: rgba(30,41,59,0.9);
            border: 1px solid #334155;
            color: #94a3b8;
            font-size: 12px; font-weight: 600;
            padding: 4px 10px; border-radius: 6px;
            display: inline-flex; align-items: center; gap: 6px;
        }
        .author-badge.active-cert {
            background: rgba(16,185,129,0.15);
            border-color: #10b981;
            color: #34d399;
        }
        
        .expert-tags { display: flex; flex-wrap: wrap; gap: 6px; }
        .tag-pill {
            background: #0b1329;
            border: 1px solid #1e293b;
            color: #38bdf8;
            font-size: 11.5px; font-weight: 600;
            padding: 3px 8px; border-radius: 4px;
        }
    </style>
    <link rel="alternate" type="application/json" href="https://www.parselsorgu.net/api/2026-kadastro-endeks.json" title="2026 Kadastro ve İmar Açık Veri Seti">
    <script type="application/ld+json">{"@context": "https://schema.org", "@type": "WebPage", "speakable": {"@type": "SpeakableSpecification", "cssSelector": ["h1", ".lead", ".summary-box", ".hero-desc", "main p"]}, "isBasedOn": "https://www.parselsorgu.net/api/2026-kadastro-endeks.json", "publisher": {"@type": "Organization", "name": "Ant Harita Mühendislik - ParselSorgu.net", "url": "https://www.parselsorgu.net/"}}</script>
</head>
<body>

<?php if (function_exists('render_saas_navbar')) render_saas_navbar('yazarlar'); ?>

<div class="eeat-container">

    <!-- Breadcrumb -->
    <nav style="font-size:12px; color:#94a3b8; margin-bottom:18px; display:flex; gap:6px; align-items:center;">
        <a href="/" style="color:var(--accent-cyan); text-decoration:none;"><i class="fa-solid fa-house"></i> Ana Sayfa</a>
        <span>&raquo;</span>
        <span style="color:#f8fafc; font-weight:700;">Yazarlar ve Teknik Uzman Kadro</span>
    </nav>

    <!-- Sub-Nav Pill Links -->
    <div class="nav-pills">
        <a href="/hakkimizda" class="nav-pill"><i class="fa-solid fa-building-columns"></i> Kurumsal &amp; Sicil Bilgileri</a>
        <a href="/yazarlar" class="nav-pill active"><i class="fa-solid fa-user-tie"></i> Yazarlar &amp; Uzman Kadro</a>
        <a href="/muhendislik-kurulu" class="nav-pill"><i class="fa-solid fa-award"></i> Mühendislik Denetim Kurulu (YMYL)</a>
        <a href="/basin-kiti" class="nav-pill"><i class="fa-solid fa-newspaper"></i> Basın Kiti &amp; Açık Veri</a>
    </div>

    <!-- Hero Header -->
    <div class="hero-banner">
        <h1 class="hero-title">ParselPro Yazar ve Teknik Hakem Kurulu</h1>
        <p class="hero-sub">
            Sitemizde yer alan 810+ teknik rehber makale, 20 otonom imar botu ve tapu kadastro hesaplama motorları; TMMOB HKMO, TMMOB ŞPO tescilli ve SPK lisanslı yetkili uzmanlar tarafından kaleme alınmakta ve denetlenmektedir.
        </p>
    </div>

    <!-- Author 1: Harita Yük. Müh. Mustafa Ant -->
    <div class="author-card" id="mustafa-ant">
        <div class="author-avatar-wrap">
            <i class="fa-solid fa-user-shield"></i>
        </div>
        <div>
            <h2 class="author-name">Harita Yük. Müh. Mustafa Ant</h2>
            <div class="author-title">Kurucu Ortak &bull; Baş Harita ve Kadastro Mühendisi</div>
            
            <div class="badge-list">
                <span class="author-badge active-cert"><i class="fa-solid fa-id-card"></i> TMMOB HKMO Sicil: 12480</span>
                <span class="author-badge active-cert"><i class="fa-solid fa-stamp"></i> LİHKAB Lisans: 06-042</span>
                <span class="author-badge"><i class="fa-solid fa-graduation-cap"></i> İTÜ Geomatik Müh. (Lisans &amp; Y.Lisans)</span>
                <span class="author-badge"><i class="fa-solid fa-calendar-check"></i> 15+ Yıl Saha Tecrübesi</span>
            </div>

            <p class="author-bio">
                İstanbul Teknik Üniversitesi Geomatik Mühendisliği mezunudur. Türkiye'nin önde gelen kentsel dönüşüm, kamulaştırma, 3194 Sayılı İmar Kanunu 18. Madde Arazi ve Arsa Düzenlemesi (DOP) projelerinde baş mühendis olarak görev yapmıştır. Lisanslı Harita Kadastro Mühendislik Bürosu (LİHKAB) akreditasyonuna sahiptir. ParselPro'nun 3D CBS harita motoru, TKGM MEGSİS veri doğrulaması ve ifraz simülasyon algoritmalarını yönetmektedir.
            </p>

            <div style="font-size:12px; color:#94a3b8; font-weight:700; margin-bottom:6px;">Uzmanlık Alanları:</div>
            <div class="expert-tags">
                <span class="tag-pill">3194 Sayılı İmar Kanunu</span>
                <span class="tag-pill">18. Madde DOP Hesabı</span>
                <span class="tag-pill">5403 Tarla İfrazı</span>
                <span class="tag-pill">LİHKAB Aplikasyon Krokisi</span>
                <span class="tag-pill">WGS84 / ITRF95 Projeksiyon</span>
                <span class="tag-pill">Netcad / AutoCAD DXF</span>
            </div>
        </div>
    </div>

    <!-- Author 2: Şehir Plancısı Selin Yılmaz -->
    <div class="author-card" id="selin-yilmaz">
        <div class="author-avatar-wrap" style="border-color:#10b981;">
            <i class="fa-solid fa-compass-drafting" style="color:#34d399;"></i>
        </div>
        <div>
            <h2 class="author-name">Şehir Plancısı Selin Yılmaz</h2>
            <div class="author-title">Mevzuat Direktörü &bull; Kentsel Planlama Uzmanı</div>
            
            <div class="badge-list">
                <span class="author-badge active-cert"><i class="fa-solid fa-id-card"></i> TMMOB ŞPO Sicil: 6819</span>
                <span class="author-badge"><i class="fa-solid fa-graduation-cap"></i> ODTÜ Şehir ve Bölge Planlama</span>
                <span class="author-badge"><i class="fa-solid fa-file-contract"></i> 1/1000 ve 1/5000 İmar Planları</span>
                <span class="author-badge"><i class="fa-solid fa-clock-rotate-left"></i> 12 Yıl Kamu &amp; Özel Sektör</span>
            </div>

            <p class="author-bio">
                Orta Doğu Teknik Üniversitesi Şehir ve Bölge Planlama Bölümü mezunudur. Büyükşehir belediyeleri ve Çevre, Şehircilik ve İklim Değişikliği Bakanlığı onaylı 1/100.000 Çevre Düzeni Planı, 1/5.000 Nazım İmar Planı ve 1/1.000 Uygulama İmar Planı süreçlerini yürütmüştür. ParselPro bünyesinde Planlı ve Plansız Alanlar İmar Yönetmelikleri, Köy Yerleşik Alanı yapılaşma şartları ve emsal (TAKS/KAKS) algoritmalarının hukuki ve teknik denetimini gerçekleştirmektedir.
            </p>

            <div style="font-size:12px; color:#94a3b8; font-weight:700; margin-bottom:6px;">Uzmanlık Alanları:</div>
            <div class="expert-tags">
                <span class="tag-pill">Planlı Alanlar İmar Yönetmeliği</span>
                <span class="tag-pill">Köy Evi Yapma İzni</span>
                <span class="tag-pill">TAKS / KAKS / Hmaks</span>
                <span class="tag-pill">İmar Planı Değişikliği &amp; Askı İlanı</span>
                <span class="tag-pill">Kentsel Dönüşüm Master Planı</span>
            </div>
        </div>
    </div>

    <!-- Author 3: SPK Lisanslı Gayrimenkul Değerleme Uzmanı Emre Kaya -->
    <div class="author-card" id="emre-kaya">
        <div class="author-avatar-wrap" style="border-color:#f59e0b;">
            <i class="fa-solid fa-calculator" style="color:#fbbf24;"></i>
        </div>
        <div>
            <h2 class="author-name">İnş. Müh. Emre Kaya</h2>
            <div class="author-title">SPK Lisanslı Gayrimenkul Değerleme Uzmanı &bull; Maliyet Analisti</div>
            
            <div class="badge-list">
                <span class="author-badge active-cert"><i class="fa-solid fa-id-card"></i> SPK Değerleme Lisans: 408219</span>
                <span class="author-badge active-cert"><i class="fa-solid fa-landmark"></i> TDUB Üyesi</span>
                <span class="author-badge"><i class="fa-solid fa-graduation-cap"></i> Gazi Üniv. İnşaat Mühendisliği</span>
                <span class="author-badge"><i class="fa-solid fa-chart-line"></i> 10+ Yıl Banka &amp; Fon Ekspertizi</span>
            </div>

            <p class="author-bio">
                Gazi Üniversitesi İnşaat Mühendisliği mezunudur. Sermaye Piyasası Kurulu (SPK) Gayrimenkul Değerleme Lisansı ve TDUB üyesidir. Türkiye'deki kamu ve özel bankalarına, gayrimenkul yatırım ortaklıklarına (GYO) arsa ve ticari gayrimenkul ekspertiz raporları hazırlamıştır. ParselPro'nun 2026 Resmî Çevre ve Şehircilik Bakanlığı Yapı Birim Maliyeti motorunu, arsa-daire paylaşım oranlarını ve tapu harcı vergi hesaplayıcılarını geliştirmektedir.
            </p>

            <div style="font-size:12px; color:#94a3b8; font-weight:700; margin-bottom:6px;">Uzmanlık Alanları:</div>
            <div class="expert-tags">
                <span class="tag-pill">2026 İnşaat Maliyetleri (ÇŞB)</span>
                <span class="tag-pill">Kat Karşılığı Arsa Payı Analizi</span>
                <span class="tag-pill">Belediye Rayiç &amp; Emlak Vergisi</span>
                <span class="tag-pill">Tapu Harcı &amp; Döner Sermaye</span>
                <span class="tag-pill">Değer Artış Kazancı Vergisi</span>
            </div>
        </div>
    </div>

    <!-- Fact-Checking & Editorial Policy Link -->
    <div style="background:#0f172a; border:1px solid #1e293b; border-radius:12px; padding:24px; text-align:center;">
        <h3 style="font-size:17px; font-weight:800; color:#fff; margin-bottom:8px;">İçerik İnceleme &amp; Hakem Heyeti Politikası</h3>
        <p style="font-size:13.5px; color:#94a3b8; max-width:750px; margin:0 auto 16px auto;">
            Yazarlarımız tarafından hazırlanan hiçbir içerik doğrudan yayına alınmaz. Çift kör mühendislik denetimi, Resmi Gazete tebliğ çapraz kontrolü ve mevzuat doğrulama adımlarından geçer.
        </p>
        <a href="/muhendislik-kurulu" style="background:var(--accent-blue); color:#fff; padding:10px 22px; border-radius:8px; font-weight:700; font-size:13.5px; text-decoration:none; display:inline-flex; align-items:center; gap:8px;">
            <i class="fa-solid fa-award"></i> Mühendislik Denetim Metodolojisini Görün
        </a>
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
