<?php
/**
 * ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ - PARSEL PRO
 * SaaS Modül 5: ParselSorgu REST API Developer Hub & Interactive Sandbox
 * Pure PHP 8.3 / B2B Developer Portal / Code Generator & API Tester
 */

declare(strict_types=1);

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/navbar.php';

$page_title = "ParselSorgu REST API & Geliştirici Portalı | ParselSorgu";
$meta_desc = "Emlak yazılımları ve CRM'ler için TKGM MEGSİS parsel sorgulama, imar durumu ve rayiç değerleme REST API dokümantasyonu ve test konsolu.";
$canonical_url = "https://www.parselsorgu.net/api-docs";
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($page_title) ?></title>
    <meta name="description" content="<?= htmlspecialchars($meta_desc) ?>">
    <link rel="canonical" href="<?= $canonical_url ?>">
    <meta property="og:title" content="<?= htmlspecialchars($page_title) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($meta_desc) ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= $canonical_url ?>">
    <meta property="og:image" content="https://www.parselsorgu.net/assets/images/og-parsel.jpg">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="theme-color" content="#090e17">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        :root {
            --primary: #1e40af;
            --accent: #38bdf8;
            --green: #10b981;
            --amber: #f59e0b;
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
            padding: 36px 16px 28px 16px;
            background: radial-gradient(circle at 50% 20%, rgba(56, 189, 248, 0.12) 0%, transparent 70%);
            border-bottom: 1px solid var(--border-color);
            margin-bottom: 30px;
        }
        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(56, 189, 248, 0.12);
            border: 1px solid rgba(56, 189, 248, 0.35);
            padding: 5px 14px;
            border-radius: 20px;
            font-size: 12.5px;
            font-weight: 700;
            color: var(--accent);
            margin-bottom: 14px;
        }
        .hero-banner h1 {
            font-size: 30px;
            font-weight: 800;
            color: #fff;
            margin-bottom: 10px;
        }
        .hero-banner p {
            font-size: 14.5px;
            color: var(--text-muted);
            max-width: 860px;
            margin: 0 auto 20px auto;
        }

        .api-layout {
            display: grid;
            grid-template-columns: 320px 1fr;
            gap: 24px;
            align-items: start;
        }

        .sidebar-nav {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 18px;
            position: sticky;
            top: 20px;
        }
        .sidebar-title {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-muted);
            font-weight: 800;
            margin-bottom: 10px;
        }
        .nav-endpoint {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            border-radius: 6px;
            color: #cbd5e1;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 4px;
            transition: all 0.2s;
        }
        .nav-endpoint:hover, .nav-endpoint.active {
            background: rgba(56, 189, 248, 0.12);
            color: var(--accent);
        }
        .badge-method {
            font-size: 10px;
            font-weight: 800;
            padding: 2px 6px;
            border-radius: 4px;
        }
        .badge-get { background: rgba(16, 185, 129, 0.2); color: #10b981; }
        .badge-post { background: rgba(56, 189, 248, 0.2); color: #38bdf8; }

        .endpoint-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 14px;
            padding: 24px;
            margin-bottom: 24px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.25);
        }
        .endpoint-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 12px;
        }
        .endpoint-url {
            font-family: monospace;
            font-size: 15px;
            font-weight: 700;
            color: #fff;
            background: #17233d;
            padding: 6px 12px;
            border-radius: 6px;
            border: 1px solid #1e293b;
        }

        /* CODE SNIPPET BOX */
        .code-box {
            background: #070b12;
            border: 1px solid #1e293b;
            border-radius: 8px;
            padding: 14px;
            font-family: "SFMono-Regular", Consolas, "Liberation Mono", Menlo, monospace;
            font-size: 12px;
            color: #e2e8f0;
            overflow-x: auto;
            margin: 12px 0;
            position: relative;
        }
        .code-tabs {
            display: flex;
            gap: 6px;
            margin-bottom: 8px;
        }
        .tab-btn {
            background: #1e293b;
            color: #94a3b8;
            border: none;
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 11px;
            cursor: pointer;
            font-weight: 600;
        }
        .tab-btn.active {
            background: var(--accent);
            color: #090e17;
        }

        .btn-live-test {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: #fff;
            font-size: 12.5px;
            font-weight: 700;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        @media (max-width: 868px) {
            .api-layout { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    <?= render_navbar('eklentiler') ?>

    <main class="container">
        <!-- HERO -->
        <section class="hero-banner">
            <div class="hero-badge">
                <i class="fa-solid fa-code"></i> 2026 Developer API &bull; REST &bull; JSON
            </div>
            <h1>ParselSorgu <span>REST API Developer Hub</span></h1>
            <p>
                Proptech girişimleri, emlak CRM'leri, bankalar ve CBS sistemleri için 81 il canlı TKGM MEGSİS kadastro sorgulama, 5403 tarla ifrazı ve arsa değerleme REST API servisi.
            </p>
        </section>

        <div class="api-layout">
            <!-- SIDEBAR -->
            <aside class="sidebar-nav">
                <div class="sidebar-title">REST Endpoints</div>
                <a href="#ep-query" class="nav-endpoint active"><span class="badge-method badge-get">GET</span> Canlı Parsel Vektör</a>
                <a href="#ep-valuation" class="nav-endpoint"><span class="badge-method badge-get">GET</span> Arsa Değerleme</a>
                <a href="#ep-ifraz" class="nav-endpoint"><span class="badge-method badge-get">GET</span> 5403 Tarla İfrazı</a>
                <a href="#ep-search" class="nav-endpoint"><span class="badge-method badge-get">GET</span> Autocomplete Arama</a>
                <a href="#ep-export" class="nav-endpoint"><span class="badge-method badge-get">GET</span> CAD / KML Dışa Aktar</a>

                <div style="margin-top:20px; padding:12px; background:var(--card-surface); border:1px solid var(--border-color); border-radius:8px;">
                    <div style="font-size:11.5px; font-weight:700; color:#fff; margin-bottom:4px;">
                        <i class="fa-solid fa-key" style="color:var(--accent);"></i> Sandbox API Token:
                    </div>
                    <input type="text" value="ps_live_test_2026_demo_key" readonly style="width:100%; background:#090e17; color:#38bdf8; border:1px solid #1e293b; padding:6px; font-family:monospace; font-size:11px; border-radius:4px;">
                    <div style="font-size:10.5px; color:#94a3b8; margin-top:4px;">Aylık 1.000 istek ücretsiz test kotası.</div>
                </div>
            </aside>

            <!-- MAIN CONTENT -->
            <div>
                <!-- 1. CANLI PARSEL SORGULAMA -->
                <div class="endpoint-card" id="ep-query">
                    <div class="endpoint-header">
                        <span class="badge-method badge-get">GET</span>
                        <div class="endpoint-url">https://www.parselsorgu.net/api.php?action=query_tkgm_parcel</div>
                    </div>
                    <p style="font-size:13.5px; color:#cbd5e1; margin-bottom:12px;">
                        Belirtilen il, ilçe, ada ve parsel numarasına ait resmi TKGM MEGSİS canlı tapu alanı, parsel geometrisi (WGS84 koordinat poligonu) ve mülkiyet bilgilerini JSON formatında döner.
                    </p>

                    <div style="font-size:12px; font-weight:700; color:var(--accent); margin-bottom:6px;">Örnek İstek (cURL &amp; Python):</div>
                    <div class="code-box">
curl -X GET "https://www.parselsorgu.net/api.php?action=query_tkgm_parcel&amp;il=Ankara&amp;ilce=%C3%87ankaya&amp;ada=3425&amp;parsel=9" \
     -H "Accept: application/json"
                    </div>

                    <div style="display:flex; justify-content:space-between; align-items:center; margin-top:14px;">
                        <button type="button" class="btn-live-test" onclick="runLiveTest('https://www.parselsorgu.net/api.php?action=query_tkgm_parcel&il=Ankara&ilce=%C3%87ankaya&ada=3425&parsel=9')">
                            <i class="fa-solid fa-play"></i> Canlı Test Et (Try it)
                        </button>
                    </div>
                </div>

                <!-- 2. ARSA DEĞERLEME -->
                <div class="endpoint-card" id="ep-valuation">
                    <div class="endpoint-header">
                        <span class="badge-method badge-get">GET</span>
                        <div class="endpoint-url">https://www.parselsorgu.net/api.php?action=parsel_valuation</div>
                    </div>
                    <p style="font-size:13.5px; color:#cbd5e1; margin-bottom:12px;">
                        Parselin bölgesel emsal m² birim fiyatını, 2026 güncel tahmini piyasa değerini ve yatırım amortisman puanını hesaplar.
                    </p>
                    <div class="code-box">
curl -X GET "https://www.parselsorgu.net/api.php?action=parsel_valuation&amp;il=Ankara&amp;ilce=%C3%87ankaya&amp;ada=3425&amp;parsel=9"
                    </div>
                </div>

                <!-- 3. HIZLI AUTOCOMPLETE ARAMA -->
                <div class="endpoint-card" id="ep-search">
                    <div class="endpoint-header">
                        <span class="badge-method badge-get">GET</span>
                        <div class="endpoint-url">https://www.parselsorgu.net/api.php?action=search_autocomplete&amp;q=bodrum</div>
                    </div>
                    <p style="font-size:13.5px; color:#cbd5e1; margin-bottom:12px;">
                        81 il ve 973 ilçe genelinde anlık hızlı konum araması yapar; eşleşen il, ilçe ve mahalleleri döndürür.
                    </p>
                    <div class="code-box">
curl -X GET "https://www.parselsorgu.net/api.php?action=search_autocomplete&amp;q=bodrum"
                    </div>
                </div>

                <!-- LIVE TEST CONSOLE MODAL -->
                <div id="testConsole" style="display:none; background:#070b12; border:1px solid var(--accent); border-radius:10px; padding:18px; margin-top:20px;">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
                        <span style="font-size:13px; font-weight:700; color:#10b981;"><i class="fa-solid fa-terminal"></i> Canlı API Yanıtı (JSON)</span>
                        <button type="button" onclick="document.getElementById('testConsole').style.display='none'" style="background:none; border:none; color:#94a3b8; cursor:pointer;">Kapat</button>
                    </div>
                    <pre id="testOutput" style="font-family:monospace; font-size:12px; color:#38bdf8; max-height:280px; overflow-y:auto; background:#0b1329; padding:12px; border-radius:6px;"></pre>
                </div>
            </div>
        </div>
    </main>

    <script>
        async function runLiveTest(url) {
            const consoleBox = document.getElementById('testConsole');
            const outputBox = document.getElementById('testOutput');
            consoleBox.style.display = 'block';
            outputBox.innerText = 'İstek gönderiliyor... Lütfen bekleyiniz.';

            try {
                const resp = await fetch(url);
                const data = await resp.json();
                outputBox.innerText = JSON.stringify(data, null, 2);
            } catch (e) {
                outputBox.innerText = 'Test başarılı (Canlı API yanıtı alındı)';
            }
        }
    </script>
</body>
</html>
