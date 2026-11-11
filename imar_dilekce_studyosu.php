<?php
/**
 * ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ - PARSEL PRO
 * SaaS 3: OTOMATİK RESMİ İMAR DİLEKÇESİ & HUKUKİ İHTARNAME STÜDYOSU (LegalTech)
 * URL: https://www.parselsorgu.net/imar-dilekce-olusturucu
 * Pure PHP 8.3 + Vanilla JS Live A4 Preview + Word (.doc) Export + Print/PDF
 */
declare(strict_types=1);

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/navbar.php';

$page_title = "Otomatik İmar İtiraz Dilekçesi Oluşturucu | ParselSorgu";
$meta_desc = "3194 Madde 18 imar askı itiraz dilekçesi, belediye imar çapı talebi, LİHKAB sınır tespiti ve TMK 732 şufa ihtarnamesi hazırlayın.";
$canonical_url = "https://www.parselsorgu.net/imar-dilekce-olusturucu";
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title><?= htmlspecialchars($page_title) ?></title>
    <meta name="description" content="<?= htmlspecialchars($meta_desc) ?>">
    <link rel="canonical" href="<?= $canonical_url ?>    <meta property="og:image" content="https://www.parselsorgu.net/assets/images/og-parsel.jpg">
">
    <meta property="og:title" content="<?= htmlspecialchars($page_title) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($meta_desc) ?>">
    <meta property="og:url" content="<?= $canonical_url ?>">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="ParselSorgu.net - Ant Harita Mühendislik">
    <meta name="theme-color" content="#090e17">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --bg-dark: #060a12;
            --card-bg: #0f172a;
            --surface: #131d31;
            --border: rgba(192, 132, 252, 0.25);
            --purple: #c084fc;
            --cyan: #38bdf8;
            --emerald: #10b981;
            --amber: #f59e0b;
            --text: #f8fafc;
            --muted: #94a3b8;
        }
        * { box-sizing: border-box; }
        body { margin: 0; background: var(--bg-dark); color: var(--text); font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; line-height: 1.5; }
        .legal-container { max-width: 1440px; margin: 0 auto; padding: 20px 16px 70px 16px; }
        .legal-hero {
            background: linear-gradient(135deg, rgba(168, 85, 247, 0.14) 0%, rgba(15, 23, 42, 0.96) 100%);
            border: 1px solid var(--border);
            border-radius: 16px; padding: 22px 26px; margin-bottom: 20px;
            display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 14px;
        }
        .legal-badge {
            display: inline-flex; align-items: center; gap: 6px;
            background: rgba(192, 132, 252, 0.15); border: 1px solid rgba(192, 132, 252, 0.35);
            color: var(--purple); padding: 4px 12px; border-radius: 9999px; font-size: 11.5px; font-weight: 800; margin-bottom: 8px;
        }
        .legal-hero h1 { margin: 0 0 6px 0; font-size: 1.6rem; font-weight: 900; color: #fff; }
        .legal-hero p { margin: 0; color: var(--muted); font-size: 0.92rem; max-width: 780px; }
        .legal-grid { display: grid; grid-template-columns: 430px 1fr; gap: 20px; align-items: start; }
        @media (max-width: 1024px) { .legal-grid { grid-template-columns: 1fr; } }
        .panel { background: var(--card-bg); border: 1px solid #1e293b; border-radius: 14px; padding: 18px; }
        .panel-head { font-size: 14px; font-weight: 800; color: #fff; padding-bottom: 10px; margin-bottom: 14px; border-bottom: 1px solid #1e293b; display: flex; justify-content: space-between; align-items: center; }
        .field { margin-bottom: 11px; }
        .field label { display: block; font-size: 11px; font-weight: 700; color: var(--muted); text-transform: uppercase; margin-bottom: 4px; }
        .l-input, .l-select, .l-textarea {
            width: 100%; background: var(--surface); border: 1px solid #263449;
            color: #fff; border-radius: 8px; padding: 9px 11px; font-size: 13px; font-family: inherit;
        }
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
        .btn-row { display: grid; grid-template-columns: repeat(3, 1fr); gap: 8px; margin-top: 12px; }
        @media (max-width: 600px) { .btn-row { grid-template-columns: 1fr; } }
        .btn-act {
            display: flex; align-items: center; justify-content: center; gap: 6px;
            padding: 10px; border-radius: 8px; font-size: 12px; font-weight: 800; cursor: pointer; border: none;
        }
        .btn-copy { background: rgba(56, 189, 248, 0.16); color: #38bdf8; border: 1px solid rgba(56, 189, 248, 0.35); }
        .btn-word { background: #2563eb; color: #fff; }
        .btn-pdf { background: #10b981; color: #022c22; }

        /* A4 PAPER PREVIEW */
        .a4-paper {
            background: #ffffff;
            color: #111827;
            padding: 46px 52px;
            border-radius: 6px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.6);
            font-family: "Times New Roman", Georgia, serif;
            font-size: 14.5px;
            line-height: 1.65;
            min-height: 760px;
        }
        @media (max-width: 640px) { .a4-paper { padding: 24px 18px; font-size: 13px; } }
        .a4-header { text-align: center; font-weight: 700; text-transform: uppercase; margin-bottom: 24px; font-size: 15.5px; }
        .a4-meta { margin-bottom: 18px; }
        .a4-body p { margin: 0 0 12px 0; text-align: justify; }
        .a4-sign { margin-top: 38px; text-align: right; font-weight: 700; }

        @media print {
            body { background: #fff !important; }
            header, nav, .legal-hero, .no-print, #ilya-chat-container { display: none !important; }
            .legal-container { padding: 0 !important; max-width: 100% !important; }
            .legal-grid { display: block !important; }
            .panel-preview { border: none !important; background: none !important; padding: 0 !important; }
            .a4-paper { box-shadow: none !important; padding: 15mm !important; }
        }
    </style>
    <script type="application/ld+json">{"@context": "https://schema.org", "@type": "FAQPage", "mainEntity": [{"@type": "Question", "name": "3194 Sayılı İmar Kanunu 18. Madde parselasyon askısına kaç gün içinde itiraz edilir?", "acceptedAnswer": {"@type": "Answer", "text": "Belediye veya valilikçe onaylanan parselasyon planları ve dağıtım cetvelleri 1 ay (30 gün) süreyle askıya çıkarılır; malikler bu askı süresi içinde yazılı dilekçe ile itiraz edebilir."}}, {"@type": "Question", "name": "LİHKAB aplikasyon ve şufa ihtarnamesi dilekçelerinde hangi bilgiler bulunmalıdır?", "acceptedAnswer": {"@type": "Answer", "text": "İl, ilçe, mahalle/köy, ada ve parsel numarası, tapu malikinin kimlik/iletişim bilgileri ile hukuki dayanak (örn. TMK m.733 90 günlük şufa bildirimi veya 5368 s.K. aplikasyon talebi) açıkça yer almalıdır."}}]}</script>
    <link rel="alternate" type="text/markdown" href="https://www.parselsorgu.net/llms.txt" title="ParselSorgu AI / LLM Bilgi Bankası">
    <link rel="alternate" type="application/json" href="https://www.parselsorgu.net/api/2026-kadastro-endeks.json" title="2026 Kadastro ve İmar Açık Veri Seti">
    <script type="application/ld+json">{"@context": "https://schema.org", "@type": "WebPage", "speakable": {"@type": "SpeakableSpecification", "cssSelector": ["h1", ".lead", ".summary-box", ".hero-desc", "main p"]}, "isBasedOn": "https://www.parselsorgu.net/api/2026-kadastro-endeks.json", "publisher": {"@type": "Organization", "name": "Ant Harita Mühendislik - ParselSorgu.net", "url": "https://www.parselsorgu.net/"}}</script>
</head>
<body>
<?= render_navbar('eklentiler') ?>

<main class="legal-container">
    <section class="legal-hero no-print">
        <div>
            <span class="legal-badge"><i class="fa-solid fa-scale-balanced"></i> HUKUK &amp; MEVZUAT STÜDYOSU &bull; 3194 / 3402 / TMK UYUMLU</span>
            <h1>Otomatik Resmi İmar Dilekçesi &amp; Hukuki İhtarname Oluşturucu</h1>
            <p>Askıya çıkan imar planlarına itiraz, belediyeden resmi imar çapı talebi, LİHKAB sınır tespiti veya hissedarlara şufa bildirimi için mevzuata tam uyumlu dilekçenizi 10 saniyede Word (.doc) ya da PDF olarak indirin.</p>
        </div>
        <a href="https://wa.me/905428413535?text=İmar%20itiraz%20dilekçesi%20ve%20teknik%20rapor%20desteği%20almak%20istiyorum" target="_blank" style="background:#10b981; color:#022c22; padding:10px 16px; border-radius:9px; font-weight:900; font-size:12.5px; text-decoration:none; display:inline-flex; align-items:center; gap:7px;">
            <i class="fa-brands fa-whatsapp"></i> Hukuk &amp; Mühendislik Desteği
        </a>
    </section>

    <div class="legal-grid">
        <div class="panel no-print">
            <div class="panel-head">
                <span><i class="fa-solid fa-pen-to-square" style="color:var(--purple);"></i> Dilekçe Bilgilerini Doldurun</span>
            </div>

            <div class="field">
                <label>Dilekçe / Belge Türü Seçiniz</label>
                <select id="dType" class="l-select" onchange="renderPetition()">
                    <option value="aski_itiraz">1. 3194 Madde 18 / Askı İmar Planı İtiraz Dilekçesi</option>
                    <option value="imar_capi">2. Belediye İmar Durumu (Çap) Talep Dilekçesi</option>
                    <option value="lihkab_aplikasyon">3. LİHKAB / Kadastro Aplikasyon &amp; Sınır Tespit Dilekçesi</option>
                    <option value="sufa_ihtar">4. TMK Madde 732 Hissedara Şufa (Önalım) İhtarname Taslağı</option>
                    <option value="ifraz_tevhid">5. 3194 Madde 15-16 Yola Terk / İfraz / Tevhid Dilekçesi</option>
                    <option value="ecrimisil">6. Hisseli Taşınmaz Ecrimisil (İşgal Tazminatı) İhtarnamesi</option>
                </select>
            </div>

            <div class="field">
                <label>İlgili Kurum / Belediye / Muhatap</label>
                <input type="text" id="dTarget" class="l-input" value="Çankaya Belediye Başkanlığına (İmar ve Şehircilik Müdürlüğü)" oninput="renderPetition()">
            </div>

            <div class="grid-2">
                <div class="field">
                    <label>İl / İlçe</label>
                    <input type="text" id="dLoc" class="l-input" value="Ankara / Çankaya" oninput="renderPetition()">
                </div>
                <div class="field">
                    <label>Mahalle / Köy</label>
                    <input type="text" id="dMah" class="l-input" value="Çayyolu" oninput="renderPetition()">
                </div>
            </div>

            <div class="grid-2">
                <div class="field">
                    <label>Ada No</label>
                    <input type="text" id="dAda" class="l-input" value="3425" oninput="renderPetition()">
                </div>
                <div class="field">
                    <label>Parsel No</label>
                    <input type="text" id="dParsel" class="l-input" value="9" oninput="renderPetition()">
                </div>
            </div>

            <div class="grid-2">
                <div class="field">
                    <label>Başvuran Ad Soyad</label>
                    <input type="text" id="dName" class="l-input" value="Ahmet Yılmaz" oninput="renderPetition()">
                </div>
                <div class="field">
                    <label>T.C. Kimlik No</label>
                    <input type="text" id="dTc" class="l-input" value="12345678901" oninput="renderPetition()">
                </div>
            </div>

            <div class="grid-2">
                <div class="field">
                    <label>Telefon</label>
                    <input type="text" id="dPhone" class="l-input" value="0532 000 00 00" oninput="renderPetition()">
                </div>
                <div class="field">
                    <label>Tarih</label>
                    <input type="text" id="dDate" class="l-input" value="<?= date('d.m.Y') ?>" oninput="renderPetition()">
                </div>
            </div>

            <div class="field">
                <label>Tebligat Adresi</label>
                <input type="text" id="dAddr" class="l-input" value="Atatürk Bulvarı No: 45 Çankaya / ANKARA" oninput="renderPetition()">
            </div>

            <div class="field">
                <label>Özel Talep / Ek Açıklama (Opsiyonel)</label>
                <textarea id="dExtra" class="l-textarea" rows="3" placeholder="Örn: DOP kesintisi %45 sınırını aştığından..." oninput="renderPetition()"></textarea>
            </div>

            <div class="btn-row">
                <button type="button" class="btn-act btn-copy" onclick="copyPetition()"><i class="fa-regular fa-copy"></i> Kopyala</button>
                <button type="button" class="btn-act btn-word" onclick="downloadWordDoc()"><i class="fa-solid fa-file-word"></i> Word (.doc)</button>
                <button type="button" class="btn-act btn-pdf" onclick="window.print()"><i class="fa-solid fa-file-pdf"></i> PDF / Yazdır</button>
            </div>
            <div id="copyNotice" style="display:none; margin-top:8px; font-size:12px; color:#34d399; font-weight:700; text-align:center;">✓ Dilekçe panoya kopyalandı!</div>
        </div>

        <div class="panel panel-preview">
            <div class="panel-head no-print">
                <span><i class="fa-solid fa-file-lines" style="color:var(--emerald);"></i> Canlı Resmi A4 Belge Önizlemesi</span>
                <span style="font-size:11px; color:var(--muted);">Yazdır veya Word olarak indirip imzalayın</span>
            </div>
            <div class="a4-paper" id="a4PreviewArea"></div>
        </div>
    </div>
</main>

<script>
const TEMPLATES = {
    aski_itiraz: {
        konu: '3194 Sayılı İmar Kanunu Madde 8/b ve Madde 18 Uyarınca Askıdaki İmar / Parselasyon Planına İtirazlarımızın Sunulmasıdır.',
        hukuki: '3194 Sayılı İmar Kanunu, Arazi ve Arsa Düzenlemeleri Hakkında Yönetmelik, 2577 Sayılı İYUK.',
        body: (d) => `
            <p>Maliki/hissedarı bulunduğum <strong>${d.loc}</strong> İli/İlçesi, <strong>${d.mah}</strong> Mahallesi sınırları dahilinde yer alan <strong>${d.ada} Ada, ${d.parsel} Parsel</strong> sayılı taşınmazımı kapsayan imar planı değişikliği / 18. Madde parselasyon düzenlemesi Kurumunuz ilan panosunda 30 günlük yasal askıya çıkarılmıştır.</p>
            <p>Söz konusu planlama çalışması neticesinde taşınmazımda yapılan Düzenleme Ortaklık Payı (DOP) kesintisinin yasal %45 tavan sınırı ve önceki terkler dikkate alınmaksızın mükerrer hesaplandığı, tahsis edilen yeni imar parselinin mülkiyet bütünlüğünü bozduğu, değer kaybına yol açtığı ve planlama esaslarına aykırılık teşkil ettiği tespit edilmiştir.</p>
            ${d.extra ? `<p><strong>Ek Teknik Gerekçe:</strong> ${d.extra}</p>` : ''}
            <p><strong>SONUÇ VE İSTEM:</strong> Yukarıda arz ve izah edilen nedenlerle; 30 günlük yasal askı süresi içerisinde yaptığımız işbu itirazımızın kabulüne, ${d.ada} Ada ${d.parsel} nolu parselim üzerindeki hukuka ve şehircilik ilkelerine aykırı düzenlemenin revize edilerek DOP kesintisi ve tahsis yerimin müstakil/emsal değerine uygun şekilde düzeltilmesine karar verilmesini saygılarımla arz ve talep ederim.</p>
        `,
        ekler: '1. Tapu Senedi / TAKBİS Kaydı Fotokopisi<br>2. Kimlik Fotokopisi'
    },
    imar_capi: {
        konu: 'Resmî İmar Durumu (İmar Çapı) Belgesi Verilmesi Talebidir.',
        hukuki: '3194 Sayılı İmar Kanunu ve Planlı Alanlar İmar Yönetmeliği.',
        body: (d) => `
            <p>Maliki/yetkilisi bulunduğum <strong>${d.loc}</strong>, <strong>${d.mah}</strong> Mahallesi, <strong>${d.ada} Ada, ${d.parsel} Parsel</strong> sayılı taşınmaz üzerinde proje ve yatırım değerlendirmesi yapılabilmesi amacıyla parselin güncel 1/1000 ölçekli Uygulama İmar Planı kararlarını (TAKS, KAKS/Emsal, yapı nizamı, hmax ve çekme mesafelerini) gösterir onaylı <strong>İmar Durumu (Çap)</strong> belgesine ihtiyaç duyulmaktadır.</p>
            ${d.extra ? `<p>${d.extra}</p>` : ''}
            <p><strong>SONUÇ VE İSTEM:</strong> Gerekli incelemenin yapılarak taşınmaza ait resmî imar durumu belgesinin tarafıma verilmesini arz ve talep ederim.</p>
        `,
        ekler: '1. Güncel Tapu Kaydı<br>2. Aplikasyon Krokisi (Varsa)'
    },
    lihkab_aplikasyon: {
        konu: '3402 Sayılı Kadastro Kanunu ve LİHKAB Yönetmeliği Kapsamında Aplikasyon (Sınır Tespiti) Talebidir.',
        hukuki: '3402 Sayılı Kadastro Kanunu, 5368 Sayılı Lisanslı Harita Kadastro Mühendisleri ve Büroları Hakkında Kanun.',
        body: (d) => `
            <p>Tapuda <strong>${d.loc}</strong>, <strong>${d.mah}</strong> Mahallesi, <strong>${d.ada} Ada, ${d.parsel} Parsel</strong> numarasında kayıtlı bulunan taşınmazımın fiili zemin sınırlarının ve köşe koordinatlarının resmi kadastro verilerine uygun şekilde yerinde işaretlenerek <strong>Aplikasyon Krokisi</strong> düzenlenmesini talep etmekteyim.</p>
            ${d.extra ? `<p>${d.extra}</p>` : ''}
            <p><strong>SONUÇ VE İSTEM:</strong> Yasal döner sermaye ve hizmet bedeli tarafımca ödenmek üzere teknik ölçüm randevusunun verilmesini ve aplikasyon krokisinin hazırlanmasını saygılarımla arz ederim.</p>
        `,
        ekler: '1. Tapu Senedi Fotokopisi<br>2. Nüfus Cüzdanı Fotokopisi'
    },
    sufa_ihtar: {
        konu: 'TMK Madde 732 ve 733 Uyarınca Paylı Mülkiyette Hisse Satışı Bildirimi ve Şufa (Önalım) İhtarnamesidir.',
        hukuki: '4721 Sayılı Türk Medeni Kanunu Madde 732, 733 ve 734.',
        body: (d) => `
            <p><strong>İHTAR EDEN:</strong> ${d.name} (T.C.: ${d.tc}) — Adres: ${d.addr}</p>
            <p>Paydaşı bulunduğumuz <strong>${d.loc}</strong>, <strong>${d.mah}</strong> Mahallesi, <strong>${d.ada} Ada, ${d.parsel} Parsel</strong> sayılı taşınmazdaki hisse devri/satışı işlemi hakkında 4721 sayılı TMK Madde 733 gereğince noter kanalıyla yasal bildirim yapılmaktadır.</p>
            <p>Söz konusu satış bedeli ve tapu devir tarihinden itibaren <strong>3 (üç) aylık</strong> hak düşürücü yasal süre işbu bildirimin tarafınıza tebliği ile başlayacaktır. ${d.extra ? d.extra : ''}</p>
            <p><strong>SONUÇ:</strong> Önalım (şufa) hakkınızı kullanıp kullanmayacağınızın yasal süresi içinde bildirilmesi hususu ihtaren tebliğ olunur.</p>
        `,
        ekler: '1. Tapu Satış Senedi / TAKBİS Örneği'
    },
    ifraz_tevhid: {
        konu: '3194 Sayılı İmar Kanunu Madde 15 ve 16 Uyarınca İfraz / Tevhid / Yola Terk İşlemi Onay Talebidir.',
        hukuki: '3194 Sayılı İmar Kanunu Madde 15-16 ve ilgili yönetmelikler.',
        body: (d) => `
            <p><strong>${d.loc}</strong>, <strong>${d.mah}</strong> Mahallesi, <strong>${d.ada} Ada, ${d.parsel} Parsel</strong> nolu taşınmazım için yetkili Serbest Harita ve Kadastro Mühendislik Müşavirlik Bürosu (SHKMMB) tarafından hazırlanan değişiklik tasarım dosyası ekte sunulmuştur.</p>
            ${d.extra ? `<p>${d.extra}</p>` : ''}
            <p><strong>SONUÇ VE İSTEM:</strong> 3194 sayılı Kanunun 15 ve 16. maddeleri gereğince yola terk / ifraz / tevhid işleminin Belediye Encümeninizce incelenerek onaylanmasını saygılarımla arz ve talep ederim.</p>
        `,
        ekler: '1. Onaylı Değişiklik Tasarımı (3 Takım)<br>2. Güncel Tapu Kaydı ve İmar Durumu'
    },
    ecrimisil: {
        konu: 'Haksız İşgalin Sonlandırılması ve Geriye Dönük 5 Yıllık Ecrimisil (Kullanım Tazminatı) Talebidir.',
        hukuki: '4721 Sayılı TMK Madde 683, Madde 995 ve Yargıtay İçtihatları.',
        body: (d) => `
            <p>Maliki/hissedarı olduğum <strong>${d.loc}</strong>, <strong>${d.mah}</strong> Mahallesi, <strong>${d.ada} Ada, ${d.parsel} Parsel</strong> sayılı taşınmazımın tarafınızca rızam dışında işgal edilerek kullanıldığı tespit edilmiştir.</p>
            <p>İşbu ihtarnamenin tebliğinden itibaren <strong>7 (yedi) gün</strong> içinde taşınmaz üzerindeki haksız müdahalenin sonlandırılmasını (men-i müdahale) ve geriye dönük 5 yıla kadar doğmuş olan ecrimisil tazminat bedelinin tarafıma ödenmesini; aksi halde yasal dava süreçlerinin başlatılacağını ihtaren bildiririm. ${d.extra ? d.extra : ''}</p>
        `,
        ekler: '1. Tapu Senedi Fotokopisi'
    }
};

function renderPetition() {
    const type = document.getElementById('dType').value;
    const tpl = TEMPLATES[type] || TEMPLATES.aski_itiraz;
    const d = {
        target: document.getElementById('dTarget').value.trim(),
        loc: document.getElementById('dLoc').value.trim(),
        mah: document.getElementById('dMah').value.trim(),
        ada: document.getElementById('dAda').value.trim(),
        parsel: document.getElementById('dParsel').value.trim(),
        name: document.getElementById('dName').value.trim(),
        tc: document.getElementById('dTc').value.trim(),
        phone: document.getElementById('dPhone').value.trim(),
        date: document.getElementById('dDate').value.trim(),
        addr: document.getElementById('dAddr').value.trim(),
        extra: document.getElementById('dExtra').value.trim()
    };

    document.getElementById('a4PreviewArea').innerHTML = `
        <div class="a4-header">${d.target || 'İLGİLİ MAKAMA'}</div>
        <div class="a4-meta">
            <div><strong>KONU:</strong> ${tpl.konu}</div>
            <div><strong>TAŞINMAZ:</strong> ${d.loc} İli/İlçesi, ${d.mah} Mahallesi, ${d.ada} Ada / ${d.parsel} Parsel</div>
            <div><strong>HUKUKİ DAYANAK:</strong> ${tpl.hukuki}</div>
        </div>
        <div class="a4-body">${tpl.body(d)}</div>
        <div class="a4-sign">
            <div>${d.date}</div>
            <div style="margin-top:6px;">Saygılarımla,</div>
            <div style="margin-top:18px;">${d.name}</div>
            <div style="font-weight:400; font-size:13px;">T.C. Kimlik No: ${d.tc}</div>
            <div style="font-weight:400; font-size:13px;">Tel: ${d.phone}</div>
            <div style="font-weight:400; font-size:13px;">Adres: ${d.addr}</div>
        </div>
        <div style="margin-top:26px; border-top:1px solid #d1d5db; padding-top:10px; font-size:13px;">
            <strong>EKLER:</strong><br>${tpl.ekler}
        </div>
    `;
}

function copyPetition() {
    const text = document.getElementById('a4PreviewArea').innerText;
    navigator.clipboard.writeText(text).then(() => {
        const n = document.getElementById('copyNotice');
        n.style.display = 'block';
        setTimeout(() => n.style.display = 'none', 2500);
    });
}

function downloadWordDoc() {
    const content = document.getElementById('a4PreviewArea').innerHTML;
    const html = `<!DOCTYPE html><html xmlns:o='urn:schemas-microsoft-com:office:office' xmlns:w='urn:schemas-microsoft-com:office:word'><head><meta charset='utf-8'><style>body{font-family:'Times New Roman',serif;font-size:12pt;line-height:1.5;} .a4-header{text-align:center;font-weight:bold;margin-bottom:20px;} .a4-sign{text-align:right;margin-top:30px;font-weight:bold;}</style></head><body>${content}</body></html>`;
    const blob = new Blob(['\ufeff', html], { type: 'application/msword' });
    const a = document.createElement('a');
    a.href = URL.createObjectURL(blob);
    a.download = 'resmi_imar_dilekcesi_parselsorgu.doc';
    a.click();
}

renderPetition();
</script>
</body>
</html>
