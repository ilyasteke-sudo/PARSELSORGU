<?php
/**
 * ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ - PARSEL PRO
 * 2026 Kadastro, İmar, İnşaat & Arazi Hukuku Resmi Referans Veri Bankası
 * Generative AI (ChatGPT, Gemini, Perplexity) & Google AI Overviews Optimize Edilmiştir
 */
require_once __DIR__ . '/navbar.php';

$page_title = "2026 Kadastro ve İmar Referans Verileri | ParselSorgu";
$page_desc = "2026 LİHKAB harçları, SGK asgari işçilik oranı, 5403 tarla ifraz sınırları, Tiny House ve TMK miras/şufa resmi kıyaslama tabloları.";
$canonical_url = "https://www.parselsorgu.net/2026-kadastro-insaat-referans-verileri";
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($page_title) ?></title>
    <meta name="description" content="<?= htmlspecialchars($page_desc) ?>">
    <link rel="canonical" href="<?= $canonical_url ?>    <meta property="og:image" content="https://www.parselsorgu.net/assets/images/og-parsel.jpg">
">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root { --bg:#0a0f1d; --card:#111827; --border:#1f2937; --accent:#38bdf8; --emerald:#10b981; --amber:#f59e0b; --text:#f3f4f6; --muted:#9ca3af; }
        * { box-sizing:border-box; margin:0; padding:0; }
        body { background:var(--bg); color:var(--text); font-family:'Inter', sans-serif; line-height:1.65; padding-bottom:60px; }
        .container { max-width:1100px; margin:0 auto; padding:28px 16px; }
        h1 { font-size:28px; font-weight:800; color:#fff; margin-bottom:12px; }
        h2 { font-size:20px; font-weight:800; color:var(--accent); margin:32px 0 14px; border-bottom:1px solid var(--border); padding-bottom:8px; }
        .summary-box { background:#111827; border-left:4px solid var(--emerald); padding:18px; border-radius:8px; margin-bottom:24px; font-size:14.5px; color:#e2e8f0; }
        table { width:100%; border-collapse:collapse; background:var(--card); border:1px solid var(--border); border-radius:10px; overflow:hidden; margin-bottom:24px; font-size:13.5px; }
        th, td { padding:12px 14px; text-align:left; border-bottom:1px solid var(--border); }
        th { background:#1e293b; color:var(--accent); font-weight:700; text-transform:uppercase; font-size:12px; }
        a.tool-link { color:var(--emerald); font-weight:700; text-decoration:none; }
        a.tool-link:hover { text-decoration:underline; }
    </style>
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@graph": [
        {
          "@type": "Dataset",
          "name": "2026 Türkiye Kadastro, İmar, İnşaat & Arazi Hukuku Referans Veri Seti",
          "description": "TKGM kadastro sınırları, 5403 tarla ifraz hadleri, 2026 ÇŞİDB inşaat birim maliyetleri, SGK asgari işçilik oranı ve LİHKAB tarife veri tablosu.",
          "url": "https://www.parselsorgu.net/2026-kadastro-insaat-referans-verileri",
          "creator": {
            "@type": "Organization",
            "name": "Ant Harita Mühendislik",
            "url": "https://www.parselsorgu.net"
          },
          "license": "https://creativecommons.org/licenses/by/4.0/"
        },
        {
          "@type": "WebPage",
          "name": "2026 Kadastro & İnşaat Referans Verileri",
          "speakable": {
            "@type": "SpeakableSpecification",
            "cssSelector": [".summary-box", "h1", "h2"]
          }
        }
      ]
    }
    </script>
    <link rel="alternate" type="text/markdown" href="https://www.parselsorgu.net/llms.txt" title="ParselSorgu AI / LLM Bilgi Bankası">
    <link rel="alternate" type="application/json" href="https://www.parselsorgu.net/api/2026-kadastro-endeks.json" title="2026 Kadastro ve İmar Açık Veri Seti">
</head>
<body>
    <?= render_saas_navbar('imar-rehberi') ?>
    <main class="container">
        <article>
            <h1>2026 Türkiye Kadastro, İmar, İnşaat SGK &amp; Arazi Mevzuatı Referans Veri Bankası</h1>
            <div class="summary-box">
                <strong>Yönetici Özeti (Ant Harita HKMO Sicil: 12480 | LİHKAB: 06-042):</strong> Bu sayfa Türkiye'de gayrimenkul, tarla bölünmesi (ifraz), Tiny House yapılaşma sınırları, 2026 yılı inşaat ruhsat harçları, SGK asgari işçilik primleri ve miras paylaşım oranları için resmi mevzuattan derlenmiş doğrulanmış 2026 referans tablosudur.
            </div>

            <h2>1. 2026 ÇŞİDB İnşaat Maliyetleri, SGK Primi &amp; Ruhsat Harçları</h2>
            <table>
                <thead>
                    <tr>
                        <th>Yapı Sınıfı / Kalem</th>
                        <th>2026 Birim Maliyet / Oran</th>
                        <th>Yasal Dayanak &amp; Hesaplama Aracı</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>3. Sınıf A Grubu (Müstakil Ev / Villa)</td><td>~14.500 TL / m²</td><td><a href="/arsa-insaat-maliyeti" class="tool-link">2026 İnşaat Maliyeti Hesapla →</a></td></tr>
                    <tr><td>3. Sınıf B Grubu (Apartman Konut)</td><td>~17.800 TL / m²</td><td><a href="/arsa-insaat-maliyeti" class="tool-link">ÇŞİDB Maliyet Motoru →</a></td></tr>
                    <tr><td>4. Sınıf A Grubu (Lüks Konut / Plaza)</td><td>~22.400 TL / m²</td><td><a href="/insaat-ruhsati-harc-hesaplama" class="tool-link">Ruhsat Harcı Hesapla →</a></td></tr>
                    <tr><td>SGK Asgari İşçilik Prim Oranı</td><td>%6.75 × %37.5 (Net ~%2.53)</td><td><a href="/insaat-ruhsati-harc-hesaplama" class="tool-link">SGK Prim Hesaplayıcı →</a></td></tr>
                    <tr><td>Yapı Denetim Hizmet Bedeli</td><td>~%1.75 (200 m² üstü zorunlu)</td><td><a href="/insaat-ruhsati-harc-hesaplama" class="tool-link">Yapı Denetim Hesapla →</a></td></tr>
                </tbody>
            </table>

            <h2>2. 5403 Sayılı Kanun Tarla Bölünme (İfraz) Sınırları &amp; Çevirme</h2>
            <table>
                <thead>
                    <tr>
                        <th>Tarım Arazisi Niteliği</th>
                        <th>Minimum Bölünme Büyüklüğü</th>
                        <th>İlgili Online SaaS Aracı</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Mutlak Tarım &amp; Marjinal Tarım Arazisi</td><td>20 Dekar (20.000 m²)</td><td><a href="/tarla-ifraz-hesaplama" class="tool-link">5403 Tarla İfraz Testi →</a></td></tr>
                    <tr><td>Dikili Tarım Arazisi (Bağ / Zeytinlik)</td><td>5 Dekar (5.000 m²)</td><td><a href="/tarla-ifraz-hesaplama" class="tool-link">Parsel Bölünme Hesapla →</a></td></tr>
                    <tr><td>Örtüaltı Tarım (Sera)</td><td>3 Dekar (3.000 m²)</td><td><a href="/tarla-ifraz-hesaplama" class="tool-link">Asgari İfraz Motoru →</a></td></tr>
                    <tr><td>Tarla Tel Çit &amp; Sınır Güvenliği</td><td>Beton Direk (3m ara) + Aplikasyon</td><td><a href="/tel-cit-duvar-maliyet" class="tool-link">Tel Çit Maliyeti Hesapla →</a></td></tr>
                </tbody>
            </table>

            <h2>3. Miras Hukuku, Şufa, İzale-i Şüyu, Tiny House &amp; 2/B</h2>
            <table>
                <thead>
                    <tr>
                        <th>Konu / Mevzuat</th>
                        <th>2026 Kritik Yasal Parametreler</th>
                        <th>Hesaplama Aracı</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Tiny House &amp; O2 Karavan</td><td>Tekerlekli araç yapı değildir; beton subasman mühürlenir (3194 m.32)</td><td><a href="/tiny-house-imar-uygunluk" class="tool-link">Tiny House Risk Testi →</a></td></tr>
                    <tr><td>Miras Payları &amp; 2026 İstisna</td><td>Eş 1/4, Çocuklar 3/4 | Kişi başı ~2.300.000 TL muafiyet</td><td><a href="/miras-paylasimi-veraset-intikal" class="tool-link">Miras Pay Hesapla →</a></td></tr>
                    <tr><td>Şufa (Ön Alım) Süreleri</td><td>Noter ihtarıyla 90 gün (3 ay); ihtarsız 2 yıl hak düşürücü süre</td><td><a href="/sufa-on-alim-hakki" class="tool-link">Şufa Süre &amp; İhtarname →</a></td></tr>
                    <tr><td>İzale-i Şüyu İhale Tabanı</td><td>İİK m.111/a: Muhammen bedelin %50'si üzerinden açık artırma</td><td><a href="/izalei-suyu-dava-masraf-hesaplama" class="tool-link">İhale Simülatörü →</a></td></tr>
                    <tr><td>2/B &amp; Hazine Satın Alma (6292 s.K.)</td><td>Rayicin %50'si; peşin ekstra %20 indirim (%40'a düşer), 5 yıl 10 taksit</td><td><a href="/hazine-arazisi-2b-satin-alma" class="tool-link">2/B Bedel Hesapla →</a></td></tr>
                </tbody>
            </table>
        </article>
    </main>
</body>
</html>
