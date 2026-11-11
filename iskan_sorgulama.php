<?php
/**
 * ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ - PARSEL PRO
 * SaaS: 2026 İskan (Yapı Kullanma İzin Belgesi) Sorgulama & Kat Mülkiyeti Kontrolü
 * URL: https://www.parselsorgu.net/iskan-sorgulama
 */
declare(strict_types=1);

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/navbar.php';

$page_title = "2026 İskan Sorgulama & Yapı Kullanma İzni | ParselSorgu";
$meta_desc = "E-Devlet ve belediye üzerinden iskan belgesi sorgulama, kat mülkiyeti kontrolü, Cins Değişikliği LİHKAB masrafı ve iskan uygunluk hesaplayıcı.";
$canonical_url = "https://www.parselsorgu.net/iskan-sorgulama";
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
            --rose: #ef4444;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            background: var(--bg-dark);
            color: var(--text-main);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            line-height: 1.6;
            padding-bottom: 70px;
        }
        .container { max-width: 1180px; margin: 0 auto; padding: 24px 16px; }
        .breadcrumb { font-size: 12px; color: var(--text-muted); margin-bottom: 14px; display: flex; gap: 8px; align-items: center; flex-wrap: wrap; }
        .breadcrumb a { color: var(--accent); text-decoration: none; }
        .hero { text-align: center; padding: 28px 16px 24px; }
        .hero-badge {
            display: inline-flex; align-items: center; gap: 8px;
            background: rgba(16, 185, 129, 0.14); color: #34d399;
            border: 1px solid rgba(16, 185, 129, 0.35);
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
        .form-control:focus { border-color: var(--accent); }
        .status-banner {
            border-radius: 12px; padding: 18px; margin-bottom: 18px;
            border: 1.5px solid #10b981; background: rgba(16, 185, 129, 0.1);
        }
        .status-title { font-size: 17px; font-weight: 900; margin-bottom: 6px; }
        .step-list { list-style: none; display: flex; flex-direction: column; gap: 10px; margin-top: 12px; }
        .step-list li {
            background: #0b1329; border: 1px solid #1e293b; border-radius: 10px;
            padding: 12px 14px; font-size: 13.5px; color: #cbd5e1; display: flex; gap: 10px; align-items: flex-start;
        }
        .step-list li i { color: var(--accent); margin-top: 3px; }
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
          "@id": "https://www.parselsorgu.net/iskan-sorgulama#app",
          "name": "2026 İskan Sorgulama & Yapı Kullanma İzni Kontrol Motoru",
          "url": "https://www.parselsorgu.net/iskan-sorgulama",
          "description": "Tapu türü, yapı ruhsatı ve LİHKAB cins değişikliği kriterlerine göre iskan (yapı kullanma izni) ve kat mülkiyeti durumunu analiz eden araç.",
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
            { "@type": "ListItem", "position": 3, "name": "İskan Sorgulama", "item": "https://www.parselsorgu.net/iskan-sorgulama" }
          ]
        },
        {
          "@type": "FAQPage",
          "mainEntity": [
            {
              "@type": "Question",
              "name": "Bir binanın iskanı (yapı kullanma izni) olduğu nasıl anlaşılır?",
              "acceptedAnswer": { "@type": "Answer", "text": "Tapu senedinde taşınmazın niteliği 'Kat Mülkiyeti' olarak geçiyorsa ve e-Devlet Takbis / WebTapu kaydında mesken/dükkan niteliği tescil edilmişse binanın iskanı alınmış ve cins değişikliği tamamlanmıştır. Tapu 'Kat İrtifakı' veya 'Arsa' görünüyorsa belediye İmar ve Şehircilik Müdürlüğü'nden ruhsat/iskan sorgulanmalıdır." }
            },
            {
              "@type": "Question",
              "name": "İskan alındıktan sonra LİHKAB cins değişikliği zorunlu mudur?",
              "acceptedAnswer": { "@type": "Answer", "text": "Evet. 3194 sayılı İmar Kanunu ve TKGM uygulamaları gereği belediye yapı kullanma izin belgesinin düzenlenmesini takiben, Lisanslı Harita Kadastro Bürosu (LİHKAB) tarafından cins değişikliği beyannamesi hazırlanarak tapuda arsa vasfının bina/kat mülkiyetine çevrilmesi gerekir." }
            },
            {
              "@type": "Question",
              "name": "İskansız (kat irtifaklı) dairede oturmak veya kredi çekmek mümkün mü?",
              "acceptedAnswer": { "@type": "Answer", "text": "Kat irtifaklı ve iskanı olmayan yapılarda şantiye elektriği/suyu tarifesi uygulanabilir; bazı bankalar konut kredisi ekspertizinde iskan veya yapı kayıt belgesi eksikliği nedeniyle kredi onayını sınırlandırabilir." }
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
            <span style="color:#fff; font-weight:700;">İskan (Yapı Kullanma İzni) Sorgulama</span>
        </nav>

        <section class="hero">
            <div class="hero-badge"><i class="fa-solid fa-file-shield"></i> 3194 İMAR KANUNU MADDE 30 &bull; KALKINMA &amp; KAT MÜLKİYETİ</div>
            <h1>2026 <span>İskan Sorgulama</span> &amp; Yapı Kullanma İzni</h1>
            <p class="hero-desc">Tapu senedi vasfına (Kat Mülkiyeti, Kat İrtifakı, Arsa) ve belediye ruhsat durumuna göre binanızın iskan, SGK ilişiksizlik ve LİHKAB cins değişikliği durumunu anında analiz edin.</p>
        </section>

        <div class="grid-2">
            <div class="card">
                <h2><i class="fa-solid fa-sliders" style="color:var(--accent);"></i> Taşınmaz &amp; Tapu Kriterleri</h2>
                <div class="form-group">
                    <label>Tapu Senedindeki Mülkiyet Durumu</label>
                    <select id="tapuTip" class="form-control" onchange="checkIskan()">
                        <option value="kat_mulkiyeti">Kat Mülkiyeti (Bağımsız Bölüm Tapusu)</option>
                        <option value="kat_irtifaki" selected>Kat İrtifakı (İnşaat / Proje Aşaması Tapusu)</option>
                        <option value="arsa_hisseli">Arsa / Tarla Tapusu (Bina İşlenmemiş)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Belediye Yapı Ruhsatı / Proje Durumu</label>
                    <select id="ruhsatDurum" class="form-control" onchange="checkIskan()">
                        <option value="iskan_var">Belediyeden Yapı Kullanma İzin Belgesi Alındı</option>
                        <option value="iskan_basvuru" selected>Bina Bitti, İskan / SGK İlişiksizlik Aşamasında</option>
                        <option value="yapi_kayit">Yapı Kayıt Belgesi Var (İmar Barışı)</option>
                        <option value="ruhsat_yok">Ruhsat / İskan Kaydı Bulunmuyor</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Bağımsız Bölüm (Daire / İşyeri) Sayısı</label>
                    <input type="number" id="daireSayi" class="form-control" value="8" min="1" max="500" oninput="checkIskan()">
                </div>
                <div class="form-group">
                    <label>Doğalgaz / Elektrik / Su Abonelik Durumu</label>
                    <select id="abonelikTip" class="form-control" onchange="checkIskan()">
                        <option value="bireysel">Bireysel Konut / İşyeri Aboneliği Açık</option>
                        <option value="santiye" selected>Şantiye Elektriği / Suyu Kullanılıyor</option>
                        <option value="yok">Henüz Abonelik Bağlanmadı</option>
                    </select>
                </div>
            </div>

            <div class="card">
                <h2><i class="fa-solid fa-clipboard-check" style="color:var(--green);"></i> İskan &amp; LİHKAB Durum Analizi</h2>
                <div id="statusBox" class="status-banner">
                    <div class="status-title" id="statusTitle">İskan Tamamlanmamış — LİHKAB Cins Değişikliği &amp; Kat Mülkiyeti Gerekli</div>
                    <p id="statusText" style="font-size:13.5px; color:#e2e8f0;"></p>
                </div>

                <ul class="step-list" id="checkSteps"></ul>

                <div class="cta-row">
                    <a href="/lihkab-hesaplama" class="btn btn-primary"><i class="fa-solid fa-calculator"></i> LİHKAB Cins Değişikliği Ücreti</a>
                    <a href="/tkgm-canli-parsel" class="btn btn-ghost"><i class="fa-solid fa-map-location-dot"></i> TKGM Parsel &amp; Nitelik Gör</a>
                    <a href="https://wa.me/905428413535?text=Merhaba,%20yap%C4%B1%20kullanma%20izni%20(iskan)%20ve%20L%C4%B0HKAB%20cins%20de%C4%9Fi%C5%9Fikli%C4%9Fi%20i%C5%9Flemleri%20i%C3%A7in%20bilgi%20almak%20istiyorum." target="_blank" rel="noopener" class="btn btn-green"><i class="fa-brands fa-whatsapp"></i> LİHKAB 06-042 Mühendise Danış</a>
                </div>
            </div>
        </div>

        <section class="card faq-card">
            <h2><i class="fa-solid fa-circle-question" style="color:var(--amber);"></i> İskan &amp; Yapı Kullanma İzni Hakkında Sık Sorulan Sorular</h2>
            <div class="faq-item">
                <div class="faq-q">İskan belgesi e-Devlet veya WebTapu üzerinden nasıl sorgulanır?</div>
                <div class="faq-a">e-Devlet'te <strong>"Tapu Bilgileri Sorgulama"</strong> veya belediyelerin e-Belediye / e-İmar portallarından ada-parsel ile yapı ruhsatı ve kat mülkiyeti durumu görülebilir. Taşınmaz niteliği "Kat Mülkiyeti" ise iskan ve cins değişikliği tamamlanmıştır.</div>
            </div>
            <div class="faq-item">
                <div class="faq-q">2026 yılında iskan için SGK ilişiksizlik ve yapı denetim onayı nasıl işler?</div>
                <div class="faq-a">Yapının projesine uygun tamamlandığı Yapı Denetim Kuruluşu tutanağı, sığınak/asansör uygunluk raporları ve SGK asgari işçilik prim borcunun kapatılmasıyla belediye İmar Müdürlüğü tarafından yapı kullanma izin belgesi düzenlenir.</div>
            </div>
            <div class="faq-item">
                <div class="faq-q">Cins değişikliği yapılmazsa kat mülkiyeti tapusu çıkar mı?</div>
                <div class="faq-a">Çıkmaz. Belediyeden genel veya kısmi iskan alındıktan sonra yetkili LİHKAB bürosunca cins değişikliği dosyası hazırlanarak Kadastro ve Tapu Müdürlüğü'nde kat irtifakının kat mülkiyetine dönüştürülmesi zorunludur.</div>
            </div>
        </section>
    </main>

    <script>
    function checkIskan() {
        const tapu = document.getElementById('tapuTip').value;
        const ruhsat = document.getElementById('ruhsatDurum').value;
        const daire = Math.max(1, parseInt(document.getElementById('daireSayi').value || '1', 10));
        const abonelik = document.getElementById('abonelikTip').value;
        const box = document.getElementById('statusBox');
        const title = document.getElementById('statusTitle');
        const text = document.getElementById('statusText');
        const steps = document.getElementById('checkSteps');

        let badgeColor = '#f59e0b';
        let bgCol = 'rgba(245, 158, 11, 0.1)';
        let sTitle = '';
        let sText = '';
        const list = [];

        if (tapu === 'kat_mulkiyeti' && ruhsat === 'iskan_var') {
            badgeColor = '#10b981';
            bgCol = 'rgba(16, 185, 129, 0.12)';
            sTitle = 'TAM UYGUNLUK — İskan ve Kat Mülkiyeti Tescilli';
            sText = `${daire} bağımsız bölümlü yapıda hem belediye yapı kullanma izni hem de LİHKAB cins değişikliği tamamlanmış görünmektedir. Konut kredisi ve bireysel abonelikler için yasal engel bulunmaz.`;
            list.push(['fa-check-double', 'WebTapu / Takbis çıktısında cins "Kat Mülkiyeti" olarak teyit edilir.']);
            list.push(['fa-bolt', 'Elektrik, su ve doğalgaz bireysel mesken tarifesinden sorunsuz bağlanır.']);
        } else if (ruhsat === 'iskan_var' && tapu !== 'kat_mulkiyeti') {
            badgeColor = '#38bdf8';
            bgCol = 'rgba(56, 189, 248, 0.12)';
            sTitle = 'İSKAN VAR — LİHKAB Cins Değişikliği Bekliyor';
            sText = `Belediyeden iskan alınmış olsa da tapunuz hâlâ ${tapu === 'kat_irtifaki' ? 'Kat İrtifakı' : 'Arsa'} görünmektedir. Kat mülkiyetine geçiş için LİHKAB cins değişikliği dosyası hazırlanmalıdır.`;
            list.push(['fa-compass-drafting', 'Yetkili LİHKAB bürosuna iskan belgesi ve röperli kroki ile cins değişikliği başvurusu yapın.']);
            list.push(['fa-stamp', 'Kadastro onayı sonrası Tapu Müdürlüğü harçsız/döner sermaye ile Kat Mülkiyetine çevirir.']);
        } else if (ruhsat === 'ruhsat_yok' || abonelik === 'santiye') {
            badgeColor = '#ef4444';
            bgCol = 'rgba(239, 68, 68, 0.12)';
            sTitle = 'RİSKLİ DURUM — İskan Eksikliği / Şantiye Aboneliği Riski';
            sText = `Şantiye aboneliği veya ruhsatsız kullanım durumu yüksek fatura maliyetine ve konut kredisi reddine yol açar. Öncelikle belediye İmar Müdürlüğü üzerinden ruhsat, tadilat projesi ve SGK ilişiksizlik durumu sorgulanmalıdır.`;
            list.push(['fa-building-columns', 'İlçe belediyesi İmar ve Şehircilik Müdürlüğü arşivinden ada/parsel ruhsat ve proje uygunluğu kontrol edilmelidir.']);
            list.push(['fa-file-invoice-dollar', 'SGK asgari işçilik prim borcu ve yapı denetim %100 seviye raporu tamamlanmadan iskan verilmez.']);
            list.push(['fa-map', 'Taşınmazın güncel imar ve kadastral uydu konumunu TKGM Parsel Sorgu ile teyit edin.']);
        } else {
            sTitle = 'SÜREÇ DEVAM EDİYOR — İskan & SGK İlişiksizlik Aşaması';
            sText = `${daire} bağımsız bölüm için belediye iskan onayı sonrasında LİHKAB cins değişikliği ve MAKS/UAVT numarataj güncellemesi sırayla tamamlanmalıdır.`;
            list.push(['fa-list-check', 'Yapı denetim iş bitirme tutanağı ve asansör/yangın uygunluk raporlarını belediyeye sunun.']);
            list.push(['fa-house-circle-check', 'Belediye Numarataj biriminden 10 haneli UAVT adres kodu eşleşmesini kontrol edin.']);
        }

        box.style.borderColor = badgeColor;
        box.style.background = bgCol;
        title.textContent = sTitle;
        title.style.color = badgeColor;
        text.textContent = sText;
        steps.innerHTML = list.map(i => `<li><i class="fa-solid ${i[0]}"></i><span>${i[1]}</span></li>`).join('');
    }
    checkIskan();
    </script>
</body>
</html>
