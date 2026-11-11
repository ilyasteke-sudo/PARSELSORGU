<?php
/**
 * ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ A.Ş.
 * Basın Kiti, Açık Veri & Sektörel Backlink Dağıtım Portalı (basin_kiti.php)
 * Yerel Haber Siteleri, Emlak Portalları ve Bloglar İçin Ücretsiz Widget & Alıntı Standartları
 */

require_once __DIR__ . '/navbar.php';

$page_title = "Basın Kiti & Açık Veri Portalı | ParselSorgu";
$meta_desc = "Haber siteleri, emlak portalları ve bloglar için ücretsiz canlı ada parsel widget'ları, 2026 inşaat maliyeti ve açık kadastro verileri.";
$canonical_url = "https://www.parselsorgu.net/basin-kiti";
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($page_title) ?></title>
    <meta name="description" content="<?= htmlspecialchars($meta_desc) ?>">
    <link rel="canonical" href="<?= $canonical_url ?>">
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?= htmlspecialchars($page_title) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($meta_desc) ?>">
    <meta property="og:url" content="<?= $canonical_url ?>">
    <meta property="og:image" content="https://www.parselsorgu.net/assets/images/og-parsel.jpg">
    <meta name="twitter:card" content="summary_large_image">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Schema.org DataCatalog & PressKit Schema -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@graph": [
        {
          "@type": "DataCatalog",
          "@id": "https://www.parselsorgu.net/basin-kiti#catalog",
          "name": "ParselPro Türkiye Kadastro & İmar Açık Veri Kataloğu",
          "description": "81 il ve 973 ilçede kadastro parsel sorgulama, inşaat maliyetleri ve belediye askı ilanları açık veri havuzu.",
          "publisher": {
            "@type": "Organization",
            "name": "Ant Harita Mühendislik Teknolojileri A.Ş.",
            "url": "https://www.parselsorgu.net"
          },
          "dataset": [
            {
              "@type": "Dataset",
              "name": "2026 Türkiye İl Bazlı İnşaat Yaklaşık Birim Maliyetleri",
              "description": "Çevre, Şehircilik ve İklim Değişikliği Bakanlığı tebliğlerine göre güncellenen 3A, 3B, 4A, 4B, 5A yapı sınıfları metrekare birim fiyatları.",
              "license": "https://creativecommons.org/licenses/by/4.0/",
              "url": "https://www.parselsorgu.net/arsa-insaat-maliyeti"
            },
            {
              "@type": "Dataset",
              "name": "Belediye İmar Planı Askı İlanları Veritabanı",
              "description": "Büyükşehir ve ilçe belediyelerinin 30 günlük askı süresindeki 1/1000 ve 1/5000 ölçekli imar planı değişiklikleri.",
              "license": "https://creativecommons.org/licenses/by/4.0/",
              "url": "https://www.parselsorgu.net/imar"
            }
          ]
        },
        {
          "@type": "BreadcrumbList",
          "itemListElement": [
            { "@type": "ListItem", "position": 1, "name": "Ana Sayfa", "item": "https://www.parselsorgu.net/" },
            { "@type": "ListItem", "position": 2, "name": "Basın Kiti & Veri", "item": "https://www.parselsorgu.net/basin-kiti" }
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
            background: linear-gradient(135deg, rgba(15,23,42,0.98) 0%, rgba(2,132,199,0.2) 100%);
            border: 1px solid rgba(56,189,248,0.3);
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

        .widget-box {
            background: var(--card-dark);
            border: 1px solid var(--border-dark);
            border-radius: 14px;
            padding: 26px;
            margin-bottom: 24px;
        }
        .widget-box h3 { font-size: 18px; font-weight: 800; color: #fff; margin-bottom: 8px; display: flex; align-items: center; gap: 10px; }
        .widget-box p { font-size: 13.5px; color: #94a3b8; margin-bottom: 14px; }
        
        .code-wrap {
            position: relative;
            background: #030712;
            border: 1px solid #1e293b;
            border-radius: 8px;
            padding: 14px 16px;
            font-family: 'Courier New', monospace;
            font-size: 12.5px;
            color: #38bdf8;
            overflow-x: auto;
        }
        .copy-btn {
            position: absolute;
            top: 10px; right: 10px;
            background: var(--accent-blue);
            color: #fff; border: none;
            padding: 5px 12px; border-radius: 6px;
            font-size: 11.5px; font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
        }
        .copy-btn:hover { background: #0369a1; }
    </style>
    <link rel="alternate" type="application/json" href="https://www.parselsorgu.net/api/2026-kadastro-endeks.json" title="2026 Kadastro ve İmar Açık Veri Seti">
    <script type="application/ld+json">{"@context": "https://schema.org", "@type": "WebPage", "speakable": {"@type": "SpeakableSpecification", "cssSelector": ["h1", ".lead", ".summary-box", ".hero-desc", "main p"]}, "isBasedOn": "https://www.parselsorgu.net/api/2026-kadastro-endeks.json", "publisher": {"@type": "Organization", "name": "Ant Harita Mühendislik - ParselSorgu.net", "url": "https://www.parselsorgu.net/"}}</script>
</head>
<body>

<?php if (function_exists('render_saas_navbar')) render_saas_navbar('basin-kiti'); ?>

<div class="eeat-container">

    <!-- Breadcrumb -->
    <nav style="font-size:12px; color:#94a3b8; margin-bottom:18px; display:flex; gap:6px; align-items:center;">
        <a href="/" style="color:var(--accent-cyan); text-decoration:none;"><i class="fa-solid fa-house"></i> Ana Sayfa</a>
        <span>&raquo;</span>
        <span style="color:#f8fafc; font-weight:700;">Basın Kiti &amp; Açık Veri Portalı</span>
    </nav>

    <!-- Sub-Nav Pill Links -->
    <div class="nav-pills">
        <a href="/hakkimizda" class="nav-pill"><i class="fa-solid fa-building-columns"></i> Kurumsal &amp; Sicil Bilgileri</a>
        <a href="/yazarlar" class="nav-pill"><i class="fa-solid fa-user-tie"></i> Yazarlar &amp; Uzman Kadro</a>
        <a href="/muhendislik-kurulu" class="nav-pill"><i class="fa-solid fa-award"></i> Mühendislik Denetim Kurulu (YMYL)</a>
        <a href="/basin-kiti" class="nav-pill active"><i class="fa-solid fa-newspaper"></i> Basın Kiti &amp; Açık Veri</a>
    </div>

    <!-- Hero Header -->
    <div class="hero-banner">
        <div style="display:inline-flex; align-items:center; gap:8px; background:rgba(56,189,248,0.2); border:1px solid #38bdf8; color:#38bdf8; padding:4px 12px; border-radius:999px; font-size:11.5px; font-weight:800; text-transform:uppercase; margin-bottom:14px;">
            <i class="fa-solid fa-share-nodes"></i> Açık Kaynak Mühendislik ve Veri Paylaşımı
        </div>
        <h1 class="hero-title">Yerel Medya, Emlak Portalları &amp; Bloglar İçin Veri &amp; Embed Servisi</h1>
        <p class="hero-sub">
            ParselPro; yerel gazeteler, haber siteleri, emlak danışmanları ve akademik araştırmacılar için Türkiye genelindeki kadastro, imar ve inşaat maliyeti verilerini ücretsiz olarak paylaşıma sunar. Aşağıdaki widget kodlarını sitenize ekleyerek okuyucularınıza canlı sorgulama araçları sunabilirsiniz.
        </p>
    </div>

    <!-- Citation Rules (Backlink Guidelines) -->
    <div style="background:linear-gradient(135deg, rgba(16,185,129,0.1) 0%, rgba(15,23,42,0.95) 100%); border:1px solid rgba(16,185,129,0.3); border-radius:14px; padding:24px 28px; margin-bottom:32px;">
        <h2 style="font-size:19px; font-weight:800; color:#34d399; margin-bottom:10px;">
            <i class="fa-solid fa-link"></i> Kaynak Gösterme &amp; Alıntı Yapma Kuralları
        </h2>
        <p style="font-size:14px; color:#cbd5e1; margin-bottom:12px;">
            Haber bültenlerinizde, köşe yazılarınızda, sektörel blog yazılarınızda veya akademik raporlarınızda ParselPro verilerini kaynak göstererek serbestçe kullanabilirsiniz.
        </p>
        <div style="background:#070d1a; border-radius:8px; padding:12px 16px; font-size:13px; color:#94a3b8;">
            <strong style="color:#fff;">Zorunlu Alıntı Formatı:</strong><br>
            Haber veya makale metninizde <em>"Veriler, TMMOB tescilli <a href="https://www.parselsorgu.net" target="_blank" style="color:#38bdf8; font-weight:700;">ParselSorgu.net</a> mühendislik veritabanından derlenmiştir."</em> şeklinde aktif ve takip edilebilir bir bağlantı (do-follow backlink) verilmesi şarttır.
        </div>
    </div>

    <!-- Embed Widget 1: Parsel Sorgu -->
    <div class="widget-box">
        <h3><i class="fa-solid fa-map-location-dot" style="color:var(--accent-cyan);"></i> 1. Canlı Parsel Sorgulama Embed Kartı</h3>
        <p>Haber sitenize veya emlak portalınıza ekleyeceğiniz bu hafif widget ile okuyucularınız il, ilçe, ada ve parsel girerek canlı haritayı doğrudan sitenizde inceleyebilir. (<a href="/sitene-parsel-sorgu-ekle" style="color:#38bdf8;">İl/İlçe Özelleştirici &rarr;</a>)</p>
        <div class="code-wrap">
            <button class="copy-btn" onclick="copyWidgetCode('w1')">Kodu Kopyala</button>
            <code id="w1">&lt;iframe src="https://www.parselsorgu.net/embed?il=ankara&amp;ilce=cankaya&amp;theme=dark" width="100%" height="480" frameborder="0" style="border:1px solid #1e293b; border-radius:12px;" loading="lazy"&gt;&lt;/iframe&gt;
&lt;div style="font-size:11px; text-align:right; margin-top:4px;"&gt;
  &lt;a href="https://www.parselsorgu.net/" target="_blank" rel="noopener" style="color:#0284c7; text-decoration:none;"&gt;Canlı TKGM Parsel Sorgulama: ParselSorgu.net&lt;/a&gt;
&lt;/div&gt;</code>
        </div>
    </div>

    <!-- Embed Widget 2: 2026 İnşaat Maliyeti Bilgi & Referans Kartı -->
    <div class="widget-box">
        <h3><i class="fa-solid fa-calculator" style="color:#34d399;"></i> 2. 2026 İnşaat Maliyeti &amp; Tapu Harcı Referans Kartı</h3>
        <p>Ekonomi, gayrimenkul ve müteahhitlik haberleriniz için ÇŞİDB resmî birim maliyetleri ve %4 tapu harcı hesaplama araçlarına doğrudan referans kartı:</p>
        <div class="code-wrap">
            <button class="copy-btn" onclick="copyWidgetCode('w2')">Kodu Kopyala</button>
            <code id="w2">&lt;div style="border:1px solid #1e293b; background:#0f172a; color:#f8fafc; padding:16px; border-radius:12px; font-family:sans-serif;"&gt;
  &lt;strong style="display:block; margin-bottom:6px;"&gt;2026 Güncel İnşaat Maliyeti ve Tapu Harcı Hesaplama&lt;/strong&gt;
  &lt;p style="font-size:13px; color:#94a3b8; margin:0 0 10px 0;"&gt;ÇŞİDB 2026 yapı sınıfları birim fiyatları ve TKGM döner sermaye katsayılarıyla anlık hesaplama yapın.&lt;/p&gt;
  &lt;a href="https://www.parselsorgu.net/arsa-insaat-maliyeti" target="_blank" rel="noopener" style="color:#38bdf8; font-weight:700; text-decoration:none; margin-right:14px;"&gt;İnşaat Maliyeti Hesaplama &amp;rarr;&lt;/a&gt;
  &lt;a href="https://www.parselsorgu.net/tapu-harci-hesaplama" target="_blank" rel="noopener" style="color:#34d399; font-weight:700; text-decoration:none;"&gt;Tapu Harcı Hesaplama &amp;rarr;&lt;/a&gt;
&lt;/div&gt;</code>
        </div>
    </div>

    <!-- Embed Widget 3: E-İmar & 2026 Arsa Endeksi Kaynak Kartı -->
    <div class="widget-box">
        <h3><i class="fa-solid fa-bullhorn" style="color:var(--accent-amber);"></i> 3. E-İmar Durumu &amp; 2026 Arsa Endeksi Referans Kartı</h3>
        <p>İmar planı değişikliği, emsal (TAKS/KAKS) ve il bazlı arsa değer artışı haberlerinizde kullanabileceğiniz doğrulanmış referans bloğu:</p>
        <div class="code-wrap">
            <button class="copy-btn" onclick="copyWidgetCode('w3')">Kodu Kopyala</button>
            <code id="w3">&lt;div style="border:1px solid #1e293b; background:#0f172a; color:#f8fafc; padding:16px; border-radius:12px; font-family:sans-serif;"&gt;
  &lt;strong style="display:block; margin-bottom:6px;"&gt;81 İl E-İmar Durumu &amp; 2026 Arsa Değer Endeksi&lt;/strong&gt;
  &lt;p style="font-size:13px; color:#94a3b8; margin:0 0 10px 0;"&gt;İlçe bazlı imar durumu sorgulama, e-çap verileri ve yıllık bölgesel arsa prim sıralaması.&lt;/p&gt;
  &lt;a href="https://www.parselsorgu.net/imar-durumu-sorgulama" target="_blank" rel="noopener" style="color:#38bdf8; font-weight:700; text-decoration:none; margin-right:14px;"&gt;E-İmar &amp; İmar Durumu Sorgula &amp;rarr;&lt;/a&gt;
  &lt;a href="https://www.parselsorgu.net/turkiye-arsa-deger-endeksi-2026" target="_blank" rel="noopener" style="color:#fbbf24; font-weight:700; text-decoration:none;"&gt;2026 Arsa Değer Endeksi &amp;rarr;&lt;/a&gt;
&lt;/div&gt;</code>
        </div>
    </div>

    <!-- Press Contact & Media Assets -->
    <div style="background:#0f172a; border:1px solid #1e293b; border-radius:14px; padding:28px; display:grid; grid-template-columns:repeat(auto-fit, minmax(280px, 1fr)); gap:24px;">
        <div>
            <h3 style="font-size:17px; font-weight:800; color:#fff; margin-bottom:8px;">Basın &amp; Röportaj Talepleri</h3>
            <p style="font-size:13px; color:#94a3b8; margin-bottom:12px;">
                İmar affı, 18. Madde uygulamaları, kentsel dönüşüm kira yardımları ve arsa değerleme konularında uzman harita mühendislerimizden görüş almak veya basın bülteni talep etmek için:
            </p>
            <div style="font-size:13px; color:#cbd5e1;">
                <strong>E-Posta:</strong> <a href="mailto:basin@parselsorgu.net" style="color:#38bdf8;">basin@parselsorgu.net</a><br>
                <strong>Kurumsal Santral:</strong> +90 (312) 800 00 00
            </div>
        </div>
        <div>
            <h3 style="font-size:17px; font-weight:800; color:#fff; margin-bottom:8px;">RSS &amp; Otomatik Haber Beslemeleri</h3>
            <p style="font-size:13px; color:#94a3b8; margin-bottom:12px;">Haber aggregator siteleri ve RSS okuyucular için güncel teknik makale ve imar bülteni yayın akışlarımız:</p>
            <div style="display:flex; flex-direction:column; gap:6px;">
                <a href="/rss.xml" target="_blank" style="color:#38bdf8; font-size:13px; text-decoration:none;"><i class="fa-solid fa-rss"></i> Genel İmar &amp; Kadastro RSS Akışı (/rss.xml)</a>
                <a href="/sitemap.xml" target="_blank" style="color:#38bdf8; font-size:13px; text-decoration:none;"><i class="fa-solid fa-sitemap"></i> Resmî XML Sitemap Dizini (/sitemap.xml)</a>
            </div>
        </div>
    </div>

</div>

<script>
function copyWidgetCode(id) {
    const el = document.getElementById(id);
    if (!el) return;
    navigator.clipboard.writeText(el.innerText).then(() => {
        alert('Widget kodu panoya kopyalandı! Kendi sitenizin HTML koduna yapıştırabilirsiniz.');
    });
}
</script>

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
