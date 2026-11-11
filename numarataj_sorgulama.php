<?php
/**
 * ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ - PARSEL PRO
 * SaaS: 2026 Belediye Numarataj Sorgulama & MAKS UAVT Adres Kodu Rehberi
 * URL: https://www.parselsorgu.net/numarataj-sorgulama
 */
declare(strict_types=1);

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/navbar.php';

$page_title = "Numarataj Sorgulama & MAKS UAVT Adres Kodu | ParselSorgu";
$meta_desc = "Belediye numarataj sorgulama, 10 haneli UAVT adres kodu ve MAKS parsel-bina eşleştirme kontrolü. Başvuru evrakları ve DASK/abonelik rehberi.";
$canonical_url = "https://www.parselsorgu.net/numarataj-sorgulama";

$BUYUKSEHIRLER = [
    "Adana", "Ankara", "Antalya", "Aydın", "Balıkesir", "Bursa", "Denizli", "Diyarbakır", "Erzurum", "Eskişehir",
    "Gaziantep", "Hatay", "İstanbul", "İzmir", "Kahramanmaraş", "Kayseri", "Kocaeli", "Konya", "Malatya", "Manisa",
    "Mardin", "Mersin", "Muğla", "Ordu", "Sakarya", "Samsun", "Şanlıurfa", "Tekirdağ", "Trabzon", "Van"
];

$ALL_CITIES = [
    "Adana", "Adıyaman", "Afyonkarahisar", "Ağrı", "Amasya", "Ankara", "Antalya", "Artvin", "Aydın", "Balıkesir",
    "Bilecik", "Bingöl", "Bitlis", "Bolu", "Burdur", "Bursa", "Çanakkale", "Çankırı", "Çorum", "Denizli",
    "Diyarbakır", "Edirne", "Elazığ", "Erzincan", "Erzurum", "Eskişehir", "Gaziantep", "Giresun", "Gümüşhane", "Hakkari",
    "Hatay", "Isparta", "Mersin", "İstanbul", "İzmir", "Kars", "Kastamonu", "Kayseri", "Kırklareli", "Kırşehir",
    "Kocaeli", "Konya", "Kütahya", "Malatya", "Manisa", "Kahramanmaraş", "Mardin", "Muğla", "Muş", "Nevşehir",
    "Niğde", "Ordu", "Rize", "Sakarya", "Samsun", "Siirt", "Sinop", "Sivas", "Tekirdağ", "Tokat",
    "Trabzon", "Tunceli", "Şanlıurfa", "Uşak", "Van", "Yozgat", "Zonguldak", "Aksaray", "Bayburt", "Karaman",
    "Kırıkkale", "Batman", "Şırnak", "Bartın", "Ardahan", "Iğdır", "Yalova", "Karabük", "Kilis", "Osmaniye", "Düzce"
];
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($page_title) ?></title>
    <meta name="description" content="<?= htmlspecialchars($meta_desc) ?>">
    <link rel="canonical" href="<?= $canonical_url ?>">
    <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large">
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?= htmlspecialchars($page_title) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($meta_desc) ?>">
    <meta property="og:url" content="<?= $canonical_url ?>">
    <meta property="og:image" content="https://www.parselsorgu.net/assets/images/og-parsel.jpg">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="theme-color" content="#090e17">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        :root {
            --bg-dark: #090d16;
            --card-bg: #0f172a;
            --card-surface: #131d31;
            --border-col: rgba(56, 189, 248, 0.22);
            --accent: #38bdf8;
            --green: #10b981;
            --amber: #f59e0b;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            background: var(--bg-dark); color: var(--text-main);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            line-height: 1.6; padding-bottom: 70px;
        }
        .container { max-width: 1180px; margin: 0 auto; padding: 24px 16px; }
        .breadcrumb { font-size: 12px; color: var(--text-muted); margin-bottom: 14px; display: flex; gap: 8px; align-items: center; flex-wrap: wrap; }
        .breadcrumb a { color: var(--accent); text-decoration: none; }
        .hero { text-align: center; padding: 28px 16px 24px; }
        .hero-badge {
            display: inline-flex; align-items: center; gap: 8px;
            background: rgba(56, 189, 248, 0.14); color: var(--accent);
            border: 1px solid rgba(56, 189, 248, 0.35);
            border-radius: 999px; padding: 6px 16px; font-size: 12.5px; font-weight: 700; margin-bottom: 14px;
        }
        .hero h1 { font-size: clamp(1.7rem, 3.5vw, 2.4rem); font-weight: 900; color: #fff; margin-bottom: 10px; }
        .hero h1 span { color: var(--accent); }
        .hero p { font-size: 15px; color: var(--text-muted); max-width: 780px; margin: 0 auto; }
        .grid-2 { display: grid; grid-template-columns: 1fr 1.15fr; gap: 24px; margin-top: 24px; }
        @media (max-width: 900px) { .grid-2 { grid-template-columns: 1fr; } }
        .card {
            background: var(--card-bg); border: 1px solid var(--border-col);
            border-radius: 16px; padding: 24px; box-shadow: 0 10px 30px rgba(0,0,0,0.35);
        }
        .card h2 { font-size: 17.5px; font-weight: 800; color: #fff; margin-bottom: 16px; display: flex; align-items: center; gap: 10px; border-bottom: 1px solid rgba(255,255,255,0.08); padding-bottom: 12px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; font-size: 12.5px; font-weight: 700; color: #cbd5e1; margin-bottom: 6px; }
        .form-control {
            width: 100%; padding: 11px 13px; background: var(--card-surface);
            border: 1px solid #334155; border-radius: 9px; color: #fff; font-size: 14px; outline: none;
        }
        .info-panel {
            background: rgba(56, 189, 248, 0.08); border: 1px solid rgba(56, 189, 248, 0.35);
            border-radius: 12px; padding: 16px; margin-bottom: 16px;
        }
        .doc-list { list-style: none; display: flex; flex-direction: column; gap: 9px; }
        .doc-list li {
            background: #0b1329; border: 1px solid #1e293b; border-radius: 9px;
            padding: 11px 14px; font-size: 13.5px; color: #cbd5e1; display: flex; gap: 10px; align-items: flex-start;
        }
        .doc-list li i { color: var(--green); margin-top: 3px; }
        .cta-row { display: flex; gap: 10px; flex-wrap: wrap; margin-top: 18px; }
        .btn {
            display: inline-flex; align-items: center; gap: 8px; padding: 11px 18px;
            border-radius: 10px; font-size: 13.5px; font-weight: 800; text-decoration: none;
        }
        .btn-primary { background: #0284c7; color: #fff; }
        .btn-green { background: #10b981; color: #052e16; }
        .btn-ghost { background: #1e293b; color: #e2e8f0; border: 1px solid #334155; }
        .faq-card { margin-top: 28px; }
        .faq-item { border-bottom: 1px solid rgba(255,255,255,0.08); padding: 14px 0; }
        .faq-item:last-child { border-bottom: none; }
        .faq-q { font-weight: 800; font-size: 15px; color: #fff; margin-bottom: 5px; }
        .faq-a { font-size: 13.5px; color: #cbd5e1; }
    </style>
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@graph": [
        {
          "@type": "WebApplication",
          "@id": "https://www.parselsorgu.net/numarataj-sorgulama#app",
          "name": "2026 Belediye Numarataj Sorgulama & MAKS UAVT Başvuru Rehberi",
          "url": "https://www.parselsorgu.net/numarataj-sorgulama",
          "description": "İl ve işlem türüne göre yetkili belediye numarataj birimini, MAKS/UAVT 10 haneli adres kodu sorgulama adımlarını ve gerekli evrakları listeleyen rehber araç.",
          "applicationCategory": "BusinessApplication",
          "operatingSystem": "All",
          "offers": { "@type": "Offer", "price": "0", "priceCurrency": "TRY" },
          "provider": { "@type": "Organization", "name": "Ant Harita Mühendislik", "url": "https://www.parselsorgu.net/" }
        },
        {
          "@type": "BreadcrumbList",
          "itemListElement": [
            { "@type": "ListItem", "position": 1, "name": "Ana Sayfa", "item": "https://www.parselsorgu.net/" },
            { "@type": "ListItem", "position": 2, "name": "Eklentiler", "item": "https://www.parselsorgu.net/eklentiler" },
            { "@type": "ListItem", "position": 3, "name": "Numarataj Sorgulama", "item": "https://www.parselsorgu.net/numarataj-sorgulama" }
          ]
        },
        {
          "@type": "FAQPage",
          "mainEntity": [
            {
              "@type": "Question",
              "name": "Numarataj belgesi ve UAVT 10 haneli adres kodu nereden sorgulanır?",
              "acceptedAnswer": { "@type": "Answer", "text": "Büyükşehir belediyesi bulunan 30 ilde Büyükşehir veya ilçe belediyesi Numarataj Şube Müdürlüğü'nden; diğer illerde il/ilçe belediyesi Fen/İmar İşleri biriminden ve NVİ Adres Kayıt Sistemi / e-Devlet üzerinden 10 haneli UAVT adres kodu sorgulanabilir." }
            },
            {
              "@type": "Question",
              "name": "Numarataj başvurusu için aplikasyon krokisi gerekir mi?",
              "acceptedAnswer": { "@type": "Answer", "text": "Yeni yapı ruhsatı, müstakil ev veya arsanın sokak cephesinin/giriş kapısının tespiti sırasında belediyeler güncel tapu senedi, yapı ruhsatı/projesi ile birlikte LİHKAB veya harita mühendisi onaylı aplikasyon krokisi talep edebilmektedir." }
            },
            {
              "@type": "Question",
              "name": "DASK ve abonelikler için kapı numarası ile parsel uyuşmuyorsa ne yapılır?",
              "acceptedAnswer": { "@type": "Answer", "text": "MAKS (Mekânsal Adres Kayıt Sistemi) üzerinde parsel–bina eşleştirmesi hatalıysa belediye Numarataj biriminden adres güncelleme veya düzeltme belgesi alınarak DASK ve dağıtım şirketlerine iletilmelidir." }
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
    <?php render_saas_navbar('eklentiler'); ?>

    <main class="container">
        <nav class="breadcrumb">
            <a href="/">Ana Sayfa</a> <span>&rsaquo;</span>
            <a href="/eklentiler">SaaS Araçları</a> <span>&rsaquo;</span>
            <span style="color:#fff; font-weight:700;">Numarataj &amp; UAVT Adres Kodu</span>
        </nav>

        <section class="hero">
            <div class="hero-badge"><i class="fa-solid fa-map-pin"></i> NVİ MAKS &bull; 10 HANELİ UAVT ADRES KODU</div>
            <h1>2026 <span>Numarataj Sorgulama</span> &amp; MAKS Adres Rehberi</h1>
            <p class="hero-desc">Büyükşehir ve ilçe belediyesi Numarataj birimleri üzerinden kapı numarası alma, 10 haneli UAVT adres kodu sorgulama ve parsel-bina MAKS eşleştirme kontrol listesi.</p>
        </section>

        <div class="grid-2">
            <div class="card">
                <h2><i class="fa-solid fa-building-flag" style="color:var(--accent);"></i> İl ve İşlem Seçimi</h2>
                <div class="form-group">
                    <label>Taşınmazın Bulunduğu İl</label>
                    <select id="numCity" class="form-control" onchange="updateNumarataj()">
                        <?php foreach ($ALL_CITIES as $c): ?>
                            <option value="<?= htmlspecialchars($c) ?>" data-metro="<?= in_array($c, $BUYUKSEHIRLER, true) ? '1' : '0' ?>" <?= $c === 'Ankara' ? 'selected' : '' ?>>
                                <?= htmlspecialchars($c) ?><?= in_array($c, $BUYUKSEHIRLER, true) ? ' (Büyükşehir)' : '' ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Numarataj Talebi / Sorgu Amacı</label>
                    <select id="numProcess" class="form-control" onchange="updateNumarataj()">
                        <option value="yeni_ruhsat" selected>Yeni Bina / Yapı Ruhsatı Kapı Numarası</option>
                        <option value="iskan">İskan (Yapı Kullanma İzni) Öncesi Bağımsız Bölüm Onayı</option>
                        <option value="dask_uavt">DASK, Elektrik, Su &amp; Doğalgaz İçin 10 Haneli UAVT Kodu</option>
                        <option value="parsel_eslesme">Arsa / Köy Evi Parsel–Sokak Cephesi Eşleştirmesi</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Bölge Yerleşim Statüsü</label>
                    <select id="numAreaType" class="form-control" onchange="updateNumarataj()">
                        <option value="belediye" selected>Belediye / Mücavir Alan İçi</option>
                        <option value="koy">Köy / Kırsal Mahalle Statüsü</option>
                    </select>
                </div>
            </div>

            <div class="card">
                <h2><i class="fa-solid fa-clipboard-list" style="color:var(--green);"></i> Yetkili Kurum &amp; Başvuru Kontrol Listesi</h2>
                <div class="info-panel">
                    <div id="authTitle" style="font-size:15.5px; font-weight:900; color:#38bdf8; margin-bottom:4px;"></div>
                    <p id="authDesc" style="font-size:13px; color:#cbd5e1; margin:0;"></p>
                </div>

                <ul class="doc-list" id="docChecklist"></ul>

                <div class="cta-row">
                    <a href="/tkgm-canli-parsel" class="btn btn-primary"><i class="fa-solid fa-map-location-dot"></i> Ada/Parsel Sokak Cephesi Gör</a>
                    <a href="/iskan-sorgulama" class="btn btn-ghost"><i class="fa-solid fa-file-shield"></i> İskan Kontrolü</a>
                    <a href="https://wa.me/905428413535?text=Merhaba,%20belediye%20numarataj%20ve%20aplikasyon%20krokisi%20i%C5%9Flemleri%20i%C3%A7in%20destek%20almak%20istiyorum." target="_blank" rel="noopener" class="btn btn-green"><i class="fa-brands fa-whatsapp"></i> Mühendise Danış</a>
                </div>
            </div>
        </div>

        <section class="card faq-card">
            <h2><i class="fa-solid fa-circle-question" style="color:var(--amber);"></i> Numarataj ve UAVT Hakkında Sık Sorulan Sorular</h2>
            <div class="faq-item">
                <div class="faq-q">10 haneli UAVT adres kodu nasıl öğrenilir?</div>
                <div class="faq-a">e-Devlet üzerinden <strong>"Yerleşim Yeri ve Adres Bilgileri"</strong> veya NVİ Adres Kodu Doğrulama ekranından il, ilçe, mahalle, cadde/sokak ve dış kapı/iç kapı seçilerek 10 haneli UAVT kodu ücretsiz öğrenilir.</div>
            </div>
            <div class="faq-item">
                <div class="faq-q">Büyükşehirlerde numarataj belgesini hangi kurum verir?</div>
                <div class="faq-a">5216 sayılı Kanun gereği büyükşehir statüsündeki 30 ilde Numarataj ana koordinasyonu Büyükşehir Belediyesi Numarataj Şube Müdürlüğü tarafından (bazı illerde ilçe belediyesi ile ortak protokolle) yürütülür.</div>
            </div>
            <div class="faq-item">
                <div class="faq-q">Boş arsaya veya tarlaya numarataj verilir mi?</div>
                <div class="faq-a">Boş arsaya yapı ruhsatı düzenlenmeden dış kapı numarası tanımlanmaz; ancak yapı ruhsatı veya geçerli yapı kayıt belgesi ile MAKS sisteminde parsel üzerine bina/kapı kodu açılabilir.</div>
            </div>
        </section>
    </main>

    <script>
    function updateNumarataj() {
        const sel = document.getElementById('numCity');
        const city = sel.value;
        const isMetro = sel.options[sel.selectedIndex].getAttribute('data-metro') === '1';
        const proc = document.getElementById('numProcess').value;
        const areaType = document.getElementById('numAreaType').value;

        const authTitle = document.getElementById('authTitle');
        const authDesc = document.getElementById('authDesc');
        const listEl = document.getElementById('docChecklist');

        if (areaType === 'koy' && !isMetro) {
            authTitle.textContent = `${city} İl Özel İdaresi & İlgili Köy Muhtarlığı`;
            authDesc.textContent = `Büyükşehir dışındaki kırsal alanlarda numarataj ve MAKS güncellemeleri İl Özel İdaresi İmar/Kentsel İyileştirme birimi üzerinden yapılır.`;
        } else if (isMetro) {
            authTitle.textContent = `${city} Büyükşehir Belediyesi Numarataj Şube Müdürlüğü`;
            authDesc.textContent = `5216 sayılı Kanun kapsamında büyükşehir belediyesi Kent Bilgi Sistemi / MAKS Numarataj birimi (veya yetki devri yapılmışsa ilçe belediyesi) yetkilidir.`;
        } else {
            authTitle.textContent = `${city} Belediyesi Fen İşleri / Numarataj Servisi`;
            authDesc.textContent = `Belediye sınırları içindeki tüm mahalle ve parsellerin sokak/kapı numarası tanımları ilçe/il belediyesi Numarataj bürosunca verilir.`;
        }

        const docs = [
            'Güncel Tapu Senedi fotokopisi (veya WebTapu karekodlu tapu kaydı)',
            'Başvuru sahibi kimlik fotokopisi / şirketler için imza sirküleri veya vekaletname'
        ];

        if (proc === 'yeni_ruhsat') {
            docs.push('Onaylı mimari proje vaziyet planı (bina giriş kapısının baktığı cephe gösterilmeli)');
            docs.push('LİHKAB / Harita Mühendisi onaylı Aplikasyon Krokisi (parsel yol cephesini teyit için)');
        } else if (proc === 'iskan') {
            docs.push('Yapı Ruhsatı sureti ve varsa tadilat ruhsatı');
            docs.push('Kat irtifakı / bağımsız bölüm listesiyle uyumlu kapı ve daire numaralama dökümü');
        } else if (proc === 'dask_uavt') {
            docs.push('Mevcut kapı numarasının e-Devlet NVİ Adres Kodu Doğrulama ekranından kontrolü');
            docs.push('Parsel ile MAKS adres kodu uyuşmuyorsa belediyeden "Adres Tespit / Numarataj Belgesi"');
        } else {
            docs.push('TKGM MEGSİS üzerinden parselin cephe aldığı resmi kadastral yol tespiti');
            docs.push('Köy yerleşik alanı veya plansız alan yapısı ise mevcut Yapı Kayıt Belgesi / ruhsat evrakı');
        }

        listEl.innerHTML = docs.map(d => `<li><i class="fa-solid fa-circle-check"></i><span>${d}</span></li>`).join('');
    }
    updateNumarataj();
    </script>
</body>
</html>
