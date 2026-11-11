<?php
/**
 * ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ - PARSEL PRO
 * Miras Paylaşımı & Veraset İntikal Harç / Vergi Hesaplayıcı (TMK & 2026 Mevzuatı)
 * Pure PHP 8.3 / Responsive / Schema.org WebApplication & FAQPage
 */
require_once __DIR__ . '/navbar.php';

$page_title = "Miras Paylaşımı & Veraset İntikal Harcı 2026 | ParselSorgu";
$page_desc = "Türk Medeni Kanunu hisse paylaşımı, vefat eden aile büyüğü tarlasının intikali, 2026 veraset vergisi istisnası ve tapu harcı hesaplayıcı.";
$canonical_url = "https://www.parselsorgu.net/miras-paylasimi-veraset-intikal";
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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-dark: #0a0f1d;
            --card-bg: #111827;
            --card-border: #1f2937;
            --accent: #8b5cf6;
            --accent-glow: rgba(139, 92, 246, 0.2);
            --emerald: #10b981;
            --cyan: #38bdf8;
            --amber: #f59e0b;
            --rose: #f43f5e;
            --text-main: #f3f4f6;
            --text-muted: #9ca3af;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            background-color: var(--bg-dark);
            color: var(--text-main);
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            padding-bottom: 60px;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 24px 16px;
        }
        .hero {
            text-align: center;
            padding: 40px 16px 30px;
            background: radial-gradient(circle at center, rgba(139, 92, 246, 0.08) 0%, transparent 70%);
        }
        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(139, 92, 246, 0.15);
            color: var(--accent);
            padding: 6px 14px;
            border-radius: 9999px;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 16px;
            border: 1px solid rgba(139, 92, 246, 0.3);
        }
        .hero h1 {
            font-size: 32px;
            font-weight: 800;
            letter-spacing: -0.02em;
            margin-bottom: 12px;
            color: #fff;
        }
        .hero h1 span { color: var(--accent); }
        .hero p {
            font-size: 16px;
            color: var(--text-muted);
            max-width: 780px;
            margin: 0 auto;
        }

        .calc-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 28px;
            margin-top: 32px;
        }
        @media (max-width: 900px) {
            .calc-grid { grid-template-columns: 1fr; }
        }

        .panel {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 16px;
            padding: 28px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.5);
        }
        .panel-title {
            font-size: 20px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            border-bottom: 1px solid var(--card-border);
            padding-bottom: 14px;
        }
        .panel-title i { color: var(--accent); }

        .form-group { margin-bottom: 18px; }
        .form-group label {
            display: block;
            font-size: 13.5px;
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--text-main);
        }
        .form-group select, .form-group input {
            width: 100%;
            padding: 12px 14px;
            background: #1f2937;
            border: 1px solid #374151;
            border-radius: 10px;
            color: #fff;
            font-size: 14px;
            outline: none;
            transition: border-color 0.2s;
        }
        .form-group select:focus, .form-group input:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 2px var(--accent-glow);
        }

        .btn-calc {
            width: 100%;
            background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%);
            color: #fff;
            font-size: 16px;
            font-weight: 700;
            padding: 14px 24px;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.2s;
            box-shadow: 0 4px 15px rgba(139, 92, 246, 0.4);
            margin-top: 10px;
        }
        .btn-calc:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(139, 92, 246, 0.6);
        }

        /* TABLES & SHARE CARDS */
        .share-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        .share-table th, .share-table td {
            padding: 12px 14px;
            text-align: left;
            border-bottom: 1px solid var(--card-border);
            font-size: 13.5px;
        }
        .share-table th {
            color: var(--text-muted);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 12px;
        }
        .share-table td { color: #fff; }

        .stat-badge {
            background: rgba(139, 92, 246, 0.15);
            color: var(--accent);
            padding: 3px 8px;
            border-radius: 6px;
            font-weight: 700;
            font-size: 12px;
        }

        .summary-card {
            background: #1a2234;
            border: 1px solid #283548;
            border-radius: 12px;
            padding: 18px;
            margin-top: 20px;
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
            font-size: 13.5px;
        }
        .summary-row:last-child { margin-bottom: 0; padding-top: 8px; border-top: 1px solid rgba(255,255,255,0.08); font-weight: 700; font-size: 15px; }

        .faq-section {
            margin-top: 48px;
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 16px;
            padding: 28px;
        }
        .faq-title {
            font-size: 22px;
            font-weight: 800;
            color: #fff;
            margin-bottom: 20px;
        }
        .faq-item {
            margin-bottom: 16px;
            border-bottom: 1px solid var(--card-border);
            padding-bottom: 14px;
        }
        .faq-item:last-child { border-bottom: none; }
        .faq-question {
            font-size: 15px;
            font-weight: 700;
            color: #e5e7eb;
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .faq-answer {
            font-size: 13.5px;
            color: var(--text-muted);
            line-height: 1.6;
        }
    </style>

    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@graph": [
        {
          "@type": "WebApplication",
          "name": "Miras Paylaşımı & Veraset İntikal Harç Hesaplayıcı",
          "url": "https://www.parselsorgu.net/miras-paylasimi-veraset-intikal",
          "description": "TMK miras payları ve 2026 veraset intikal vergisi istisnası ile tapu döner sermaye harç hesaplama aracı.",
          "applicationCategory": "BusinessApplication",
          "operatingSystem": "All",
          "provider": {
            "@type": "Organization",
            "name": "Ant Harita Mühendislik",
            "url": "https://www.antharita.com"
          }
        },
        {
          "@type": "FAQPage",
          "mainEntity": [
            {
              "@type": "Question",
              "name": "Sağ kalan eşin miras payı ne kadardır?",
              "acceptedAnswer": {
                "@type": "Answer",
                "text": "Türk Medeni Kanunu'na göre sağ kalan eş; mirasbırakanın çocuklarıyla birlikte mirasçı olursa mirasın 1/4'ünü alır. Çocuk yoksa ve mirasbırakanın anne-babası (veya kardeşleri) ile birlikte mirasçı olursa mirasın 1/2'sini alır. Büyükanne ve büyükbabalarla birlikte olursa 3/4'ünü alır."
              }
            },
            {
              "@type": "Question",
              "name": "2026 Veraset ve İntikal Vergisi istisna tutarı ne kadardır?",
              "acceptedAnswer": {
                "@type": "Answer",
                "text": "2026 yılı için evlatlıklar dahil olmak üzere füruğ ve eşten her birine isabet eden miras paylarında yaklaşık 2.300.000 TL veraset vergisi istisnası uygulanmaktadır. Bu tutarın altındaki miras payları için vergi ödenmez, yalnızca tapu intikal döner sermaye ücreti ödenir."
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

    <?= render_saas_navbar('eklentiler') ?>

    <main class="container">
        <section class="hero">
            <div class="hero-badge">
                <i class="fa-solid fa-scroll"></i> TMK 495-501 & 2026 Veraset İstisna Hadleri
            </div>
            <h1>Miras Paylaşımı & <span>Veraset İntikal Hesaplayıcı</span></h1>
            <p>
                Vefat eden muristen kalan tarla, arsa ve konutların mirasçılar arasındaki yasal hisse oranlarını (1/4, 3/8 vb.), 2026 vergi istisnasını ve tapu devir masraflarını tek tıkla hesaplayın.
            </p>
        </section>

        <div class="calc-grid">
            <!-- INPUT PANEL -->
            <div class="panel">
                <h2 class="panel-title"><i class="fa-solid fa-users"></i> Mirasçılar & Taşınmaz Değeri</h2>

                <div class="form-group">
                    <label>Sağ Kalan Eş Durumu</label>
                    <select id="esDurumu">
                        <option value="var">Sağ Kalan Eş Var</option>
                        <option value="yok">Sağ Kalan Eş Yok (Vefat Etmiş / Boşanmış)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Çocuk (Füruğ) Sayısı</label>
                    <input type="number" id="cocukSayisi" min="0" max="20" value="3">
                    <div style="font-size:12px; color:var(--text-muted); margin-top:4px;">Çocuk yoksa 0 yazınız (Miras anne-baba ve kardeşlere geçer).</div>
                </div>

                <div class="form-group" id="kardesGroup" style="display:none;">
                    <label>Kardeş Sayısı (Çocuk Olmadığı Durumda)</label>
                    <input type="number" id="kardesSayisi" min="1" max="15" value="2">
                </div>

                <div class="form-group">
                    <label>Toplam Taşınmaz Değeri (Emlak Rayiç / Piyasa Değeri TL)</label>
                    <input type="number" id="toplamDeger" min="10000" step="50000" value="4500000">
                </div>

                <div class="form-group">
                    <label>Miras Kalan Parsel / Taşınmaz Sayısı</label>
                    <input type="number" id="parselSayisi" min="1" max="50" value="2">
                </div>

                <button class="btn-calc" onclick="calculateInheritance()">
                    <i class="fa-solid fa-calculator"></i> Miras ve Harç Tablosunu Çıkar
                </button>
            </div>

            <!-- RESULT PANEL -->
            <div class="panel">
                <h2 class="panel-title"><i class="fa-solid fa-table"></i> Yasal Paylaşım & Masraf Raporu</h2>

                <table class="share-table">
                    <thead>
                        <tr>
                            <th>Mirasçı</th>
                            <th>Hisse Oranı</th>
                            <th>Değer (TL)</th>
                            <th>Tahmini Vergi</th>
                        </tr>
                    </thead>
                    <tbody id="shareTableBody">
                        <!-- Populated by JS -->
                    </tbody>
                </table>

                <div class="summary-card">
                    <div class="summary-row">
                        <span style="color:var(--text-muted);">Toplam Miras Değeri:</span>
                        <strong id="sumMirasDeger">4.500.000 TL</strong>
                    </div>
                    <div class="summary-row">
                        <span style="color:var(--text-muted);">2026 Kişi Başı Vergi İstisnası:</span>
                        <strong style="color:var(--emerald);">2.300.000 TL</strong>
                    </div>
                    <div class="summary-row">
                        <span style="color:var(--text-muted);">Tapu Döner Sermaye Bedeli:</span>
                        <strong id="sumDonerSermaye">2.850 TL</strong>
                    </div>
                    <div class="summary-row">
                        <span>Toplam Tahmini İntikal Masrafı:</span>
                        <strong id="sumToplamMasraf" style="color:var(--accent);">2.850 TL</strong>
                    </div>
                </div>

                <div style="background:rgba(56,189,248,0.1); border-left:4px solid var(--cyan); padding:12px; border-radius:8px; margin-top:16px; font-size:12.5px; color:#bae6fd;">
                    <i class="fa-solid fa-circle-info"></i> <strong>Tapu İntikal Adımları:</strong> Sulh Hukuk Mahkemesi veya Noterden <em>Veraset İlamı (Mirasçılık Belgesi)</em> alınır, Vergi Dairesinden <em>İlişik Kesme Yazısı</em> alınır ve Web-Tapu üzerinden tek tıkla elbirliği mülkiyeti intikali yapılır.
                </div>
            </div>
        </div>

        <!-- FAQ SECTION -->
        <section class="faq-section">
            <h2 class="faq-title"><i class="fa-solid fa-circle-question" style="color:var(--accent);"></i> Sıkça Sorulan Sorular</h2>
            
            <div class="faq-item">
                <div class="faq-question"><i class="fa-solid fa-check text-success"></i> Elbirliği mülkiyeti ile Paylı mülkiyet arasındaki fark nedir?</div>
                <div class="faq-answer">İntikal ilk yapıldığında taşınmaz 'Elbirliği Mülkiyeti' (iştirak halinde) olarak tescil edilir. Bu durumda hiçbir mirasçı tek başına kendi hissesini satamaz, tüm hissedarların imzası gerekir. Noterde Rıza-i Taksim Sözleşmesi yapılarak veya tapuda 'Paylı Mülkiyete' çevrilerek herkes kendi hissesini serbestçe satabilir hale gelir.</div>
            </div>

            <div class="faq-item">
                <div class="faq-question"><i class="fa-solid fa-check text-success"></i> Miras kalan tarlanın intikali için zaman aşımı var mıdır?</div>
                <div class="faq-answer">Miras hakkı mülkiyet hakkı olduğu için zamanaşımına uğramaz; vefatın üzerinden 50 yıl geçse dahi intikal yapılabilir. Ancak 5403 sayılı Kanun uyarınca tarım arazilerinin vefattan itibaren 1 yıl içinde intikal ettirilmemesi halinde Bakanlık resen dava açıp tasfiye hakkına sahiptir.</div>
            </div>
        </section>
    </main>

    <script>
        document.getElementById('cocukSayisi').addEventListener('input', function() {
            const val = parseInt(this.value) || 0;
            document.getElementById('kardesGroup').style.display = val === 0 ? 'block' : 'none';
        });

        function calculateInheritance() {
            const esVar = document.getElementById('esDurumu').value === 'var';
            const cocukSayisi = parseInt(document.getElementById('cocukSayisi').value) || 0;
            const kardesSayisi = parseInt(document.getElementById('kardesSayisi').value) || 1;
            const toplamDeger = parseFloat(document.getElementById('toplamDeger').value) || 0;
            const parselSayisi = parseInt(document.getElementById('parselSayisi').value) || 1;

            const istisna2026 = 2300000;
            let rows = [];
            let totalVergi = 0;

            if (cocukSayisi > 0) {
                // 1. Zümre: Çocuklar var
                let esOran = esVar ? 0.25 : 0;
                let cocukTopOran = 1 - esOran;
                let cocukBasiOran = cocukTopOran / cocukSayisi;

                if (esVar) {
                    let esVal = toplamDeger * esOran;
                    let matrah = Math.max(0, esVal - istisna2026);
                    let vergi = matrah * 0.01; // %1 vergi dilimi
                    totalVergi += vergi;
                    rows.push({
                        name: 'Sağ Kalan Eş',
                        share: '1/4 (%25)',
                        val: esVal,
                        tax: vergi
                    });
                }

                for (let i = 1; i <= cocukSayisi; i++) {
                    let cVal = toplamDeger * cocukBasiOran;
                    let matrah = Math.max(0, cVal - istisna2026);
                    let vergi = matrah * 0.01;
                    totalVergi += vergi;
                    let kesir = esVar ? `${3}/${4 * cocukSayisi}` : `1/${cocukSayisi}`;
                    let yuzde = (cocukBasiOran * 100).toFixed(1);
                    rows.push({
                        name: `${i}. Çocuk`,
                        share: `${kesir} (%${yuzde})`,
                        val: cVal,
                        tax: vergi
                    });
                }
            } else {
                // 2. Zümre: Çocuk yok, anne/baba veya kardeşler
                let esOran = esVar ? 0.50 : 0;
                let kardesTopOran = 1 - esOran;
                let kardesBasiOran = kardesTopOran / kardesSayisi;

                if (esVar) {
                    let esVal = toplamDeger * esOran;
                    let matrah = Math.max(0, esVal - istisna2026);
                    let vergi = matrah * 0.01;
                    totalVergi += vergi;
                    rows.push({
                        name: 'Sağ Kalan Eş',
                        share: '1/2 (%50)',
                        val: esVal,
                        tax: vergi
                    });
                }

                for (let i = 1; i <= kardesSayisi; i++) {
                    let kVal = toplamDeger * kardesBasiOran;
                    let matrah = Math.max(0, kVal - istisna2026);
                    let vergi = matrah * 0.01;
                    totalVergi += vergi;
                    let yuzde = (kardesBasiOran * 100).toFixed(1);
                    rows.push({
                        name: `${i}. Kardeş`,
                        share: `%${yuzde}`,
                        val: kVal,
                        tax: vergi
                    });
                }
            }

            const tbody = document.getElementById('shareTableBody');
            tbody.innerHTML = '';
            rows.forEach(r => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td><strong>${r.name}</strong></td>
                    <td><span class="stat-badge">${r.share}</span></td>
                    <td>${Number(Math.round(r.val)).toLocaleString('tr-TR')} TL</td>
                    <td>${r.tax > 0 ? Number(Math.round(r.tax)).toLocaleString('tr-TR') + ' TL' : '<span style="color:#10b981;">Muaf (0 TL)</span>'}</td>
                `;
                tbody.appendChild(tr);
            });

            const donerSermaye = parselSayisi * 1425;
            const totalMasraf = totalVergi + donerSermaye;

            document.getElementById('sumMirasDeger').innerText = Number(Math.round(toplamDeger)).toLocaleString('tr-TR') + ' TL';
            document.getElementById('sumDonerSermaye').innerText = Number(Math.round(donerSermaye)).toLocaleString('tr-TR') + ' TL';
            document.getElementById('sumToplamMasraf').innerText = Number(Math.round(totalMasraf)).toLocaleString('tr-TR') + ' TL';
        }

        calculateInheritance();
    </script>
</body>
</html>
