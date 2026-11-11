<?php
/**
 * ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ A.Ş.
 * Gizlilik Politikası & KVKK Aydınlatma Metni (gizlilik_politikasi.php)
 */

require_once __DIR__ . '/navbar.php';

$page_title = "Gizlilik Politikası ve KVKK Metni | ParselSorgu";
$meta_desc = "ParselSorgu.net 6698 Sayılı KVKK kapsamında kişisel verilerin korunması, çerez politikası ve veri güvenliği ilkeleri.";
$canonical_url = "https://www.parselsorgu.net/gizlilik-politikasi";
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
            <h1>Gizlilik Politikası ve KVKK Aydınlatma Metni</h1>
            <p><strong>Son Güncelleme:</strong> 1 Ocak 2026 &bull; <strong>Veri Sorumlusu:</strong> Ant Harita Mühendislik Teknolojileri A.Ş.</p>

            <p>
                ParselSorgu.net olarak, 6698 sayılı Kişisel Verilerin Korunması Kanunu ("KVKK") ve ilgili mevzuat uyarınca kullanıcılarımızın kişisel verilerinin güvenliğine en üst düzeyde önem veriyoruz. Bu metin, sitemizi ziyaret eden ve hizmetlerimizden faydalanan kullanıcılarımızın verilerinin nasıl işlendiğini açıklamaktadır.
            </p>

            <h2>1. İşlenen Kişisel Veriler</h2>
            <p>Sitemiz üzerinden aşağıdaki veriler toplanabilmektedir:</p>
            <ul>
                <li><b>İletişim Verileri:</b> Danışma ve teklif formları üzerinden iletilen Ad, Soyad, Telefon Numarası ve E-Posta adresi.</li>
                <li><b>Taşınmaz Bilgileri:</b> Kullanıcı tarafından sorgulanan İl, İlçe, Mahalle, Ada ve Parsel numaraları.</li>
                <li><b>İşlem ve Teknik Veriler:</b> IP adresi, tarayıcı türü, ziyaret edilen sayfalar ve çerez (cookie) kayıtları.</li>
            </ul>

            <h2>2. Verilerin İşlenme Amaçları</h2>
            <p>Toplanan kişisel verileriniz;</p>
            <ul>
                <li>Kadastro ve imar sorgulama taleplerinizin karşılanması,</li>
                <li>Talep ettiğiniz mühendislik danışmanlığı ve ekspertiz tekliflerinin tarafınıza iletilmesi,</li>
                <li>Site altyapısının güvenliğinin sağlanması ve yasal yükümlülüklerin yerine getirilmesi amaçlarıyla işlenmektedir.</li>
            </ul>

            <h2>3. Çerez (Cookie) Politikası</h2>
            <p>
                Sitemiz, kullanıcı deneyimini iyileştirmek, performansı ölçmek ve analiz amacıyla zorunlu ve işlevsel çerezler kullanmaktadır. Tarayıcı ayarlarınız üzerinden dilediğiniz zaman çerez kullanımını kısıtlayabilir veya silebilirsiniz.
            </p>

            <h2>4. İletişim ve Haklarınız</h2>
            <p>
                KVKK'nın 11. maddesi kapsamındaki haklarınızı kullanmak veya kişisel verilerinizle ilgili bilgi almak için <b>destek@parselsorgu.net</b> adresinden veya <b>0542 841 35 35</b> numaralı hattımızdan bizimle iletişime geçebilirsiniz.
            </p>
        </div>
    </div>
</body>
</html>
