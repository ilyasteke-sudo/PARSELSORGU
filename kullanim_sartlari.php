<?php
/**
 * ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ A.Ş.
 * Kullanım Şartları & Yasal Sorumluluk Reddi (kullanim_sartlari.php)
 */

require_once __DIR__ . '/navbar.php';

$page_title = "Kullanım Şartları ve Yasal Uyarı | ParselSorgu";
$meta_desc = "ParselSorgu.net kullanım şartları, harita kadastro verileri sorumluluk reddi beyanı ve yasal haklar.";
$canonical_url = "https://www.parselsorgu.net/kullanim-sartlari";
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
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #090d16;
            color: #cbd5e1;
            margin: 0;
            padding: 0;
            line-height: 1.7;
        }
        .container {
            max-width: 960px;
            margin: 40px auto;
            padding: 0 20px;
        }
        .content-box {
            background: #0f172a;
            border: 1px solid #1e293b;
            border-radius: 12px;
            padding: 36px;
        }
        h1 { color: #fff; font-size: 28px; font-weight: 800; margin-bottom: 20px; }
        h2 { color: #38bdf8; font-size: 20px; font-weight: 700; margin: 28px 0 12px 0; }
        p { margin-bottom: 16px; font-size: 14.5px; }
        ul { padding-left: 24px; margin-bottom: 16px; font-size: 14.5px; }
        li { margin-bottom: 8px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="content-box">
            <h1>Kullanım Şartları ve Yasal Uyarı Beyanı</h1>
            <p><strong>Yürürlük Tarihi:</strong> 1 Ocak 2026 &bull; <strong>Yayıncı:</strong> Ant Harita Mühendislik Teknolojileri A.Ş.</p>

            <p>
                ParselSorgu.net web sitesini ziyaret eden tüm kullanıcılar aşağıdaki kullanım koşullarını kabul etmiş sayılır.
            </p>

            <h2>1. Hizmetin Niteliği ve Bilgilendirme Amacı</h2>
            <p>
                ParselSorgu.net, açık kaynaklı coğrafi bilgi sistemleri (CBS), kamuya açık mevzuat kaynakları ve kullanıcı girdilerini derleyerek bilgilendirme amaçlı analizler ve harita araçları sunar. Sitede sunulan veriler <b>resmi kadastro ve tapu belgesi yerine geçmez.</b>
            </p>

            <h2>2. Resmi İşlemler ve Mühendislik Sorumluluğu</h2>
            <p>
                Alım-satım, ipotek, inşaat ruhsatı veya ifraz gibi hukuki ve mali sonuç doğuran tüm işlemlerde Tapu ve Kadastro Müdürlükleri, yetkili Belediyeler ve LİHKAB bürolarından resmi imar durum belgesi ve aplikasyon krokisi alınması yasal zorunluluktur. Sitedeki tahmin ve hesaplamalara dayanılarak yapılan işlemlerden doğabilecek doğrudan veya dolaylı zararlardan sitemiz sorumlu tutulamaz.
            </p>

            <h2>3. Fikri Mülkiyet Hakları</h2>
            <p>
                ParselSorgu.net üzerinde yer alan tüm yazılımlar, tasarım unsurları, algoritmalar, hesaplama motorları ve özgün makale içerikleri Ant Harita Mühendislik Teknolojileri A.Ş.'ye aittir. İzinsiz kopyalanamaz, çoğaltılamaz veya otomatik botlarla izinsiz veri madenciliği yapılamaz.
            </p>

            <h2>4. İletişim</h2>
            <p>
                Kullanım koşulları hakkındaki sorularınız için <b>destek@parselsorgu.net</b> adresinden bize ulaşabilirsiniz.
            </p>
        </div>
    </div>
</body>
</html>
