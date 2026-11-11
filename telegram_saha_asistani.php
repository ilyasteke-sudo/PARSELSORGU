<?php
/**
 * ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ - PARSEL PRO
 * Saha Çalışanları Telegram Parsel & Eğim Botu Tanıtım ve Web Simülatörü
 * URL: /telegram-botu & /saha-botu
 */

declare(strict_types=1);

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/navbar.php';

$page_title = "Saha GPS Parsel & Eğim Telegram Botu | ParselSorgu";
$meta_desc = "Harita mühendisleri ve eksperler için sahadan canlı GPS konumuyla anında parsel sınırı, DEM eğim analizi ve uydu fotoğrafı veren Telegram botu.";
$canonical_url = "https://www.parselsorgu.net/telegram-botu";
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
    <meta property="og:url" content="<?= $canonical_url ?>">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="ParselSorgu.net - Ant Harita Mühendislik">
    <meta property="og:image" content="https://www.parselsorgu.net/assets/images/og-parsel.jpg">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="theme-color" content="#090e17">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@graph": [
        {
          "@type": "WebApplication",
          "@id": "https://www.parselsorgu.net/telegram-botu#app",
          "name": "ParselSorgu Saha Telegram Botu",
          "url": "https://www.parselsorgu.net/telegram-botu",
          "description": "Harita mühendisleri, eksperler ve arsa brokerları için sahadan canlı konumla anında parsel bilgisi, Copernicus DEM eğim ve uydu haritası üreten Telegram botu.",
          "applicationCategory": "BusinessApplication",
          "operatingSystem": "All",
          "offers": {
            "@type": "Offer",
            "price": "0",
            "priceCurrency": "TRY"
          },
          "creator": {
            "@type": "Organization",
            "name": "Ant Harita Mühendislik",
            "url": "https://www.parselsorgu.net",
            "identifier": "TMMOB HKMO Sicil: 12480"
          }
        },
        {
          "@type": "BreadcrumbList",
          "@id": "https://www.parselsorgu.net/telegram-botu#breadcrumb",
          "itemListElement": [
            {
              "@type": "ListItem",
              "position": 1,
              "name": "Ana Sayfa",
              "item": "https://www.parselsorgu.net/"
            },
            {
              "@type": "ListItem",
              "position": 2,
              "name": "Eklentiler & SaaS",
              "item": "https://www.parselsorgu.net/eklentiler"
            },
            {
              "@type": "ListItem",
              "position": 3,
              "name": "Saha Telegram Botu",
              "item": "https://www.parselsorgu.net/telegram-botu"
            }
          ]
        },
        {
          "@type": "FAQPage",
          "@id": "https://www.parselsorgu.net/telegram-botu#faq",
          "mainEntity": [
            {
              "@type": "Question",
              "name": "Telegram botuna canlı konum nasıl gönderilir?",
              "acceptedAnswer": {
                "@type": "Answer",
                "text": "Telegram sohbet ekranında sol alttaki ataş (eklenti) simgesine tıklayıp 'Konum' ve ardından 'Mevcut Konumumu Gönder' butonuna basmanız yeterlidir. Bot 2 saniye içinde üzerinde durduğunuz parselin uydu kartını teslim eder."
              }
            },
            {
              "@type": "Question",
              "name": "Copernicus DEM eğim analizi nasıl hesaplanır?",
              "acceptedAnswer": {
                "@type": "Answer",
                "text": "Avrupa Uzay Ajansı (ESA) Copernicus DEM 30 metre çözünürlüklü dijital yükseklik raster modeli taranarak parsel poligonu içindeki ortalama rakım ve yüzde cinsinden eğim gradyanı ST_Slope algoritmasıyla hesaplanır."
              }
            },
            {
              "@type": "Question",
              "name": "Kendi Telegram botumu sisteme nasıl bağlayabilirim?",
              "acceptedAnswer": {
                "@type": "Answer",
                "text": "Telegram'da @BotFather üzerinden '/newbot' komutuyla aldığınız API tokenını sistemimize girerek 'Webhook Bağla' butonuna basmanız yeterlidir. Botunuz 1 saniyede aktifleşir."
              }
            }
          ]
        }
      ]
    }
    </script>

    <style>
        :root {
            --primary: #229ed9;
            --accent: #38bdf8;
            --green: #10b981;
            --amber: #f59e0b;
            --dark-bg: #090e17;
            --card-bg: #0f172a;
            --card-surface: #131d31;
            --border-color: #1e293b;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            background-color: var(--dark-bg);
            color: var(--text-main);
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            line-height: 1.5;
            padding-bottom: 40px;
        }
        .container { max-width: 1140px; margin: 0 auto; padding: 20px 16px; }
        .hero-banner {
            background: linear-gradient(135deg, rgba(34, 158, 217, 0.15) 0%, rgba(56, 189, 248, 0.08) 100%);
            border: 1px solid rgba(34, 158, 217, 0.35);
            border-radius: 16px;
            padding: 28px 24px;
            margin-bottom: 24px;
        }
        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(34, 158, 217, 0.2);
            color: #229ed9;
            font-size: 12px;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 20px;
            margin-bottom: 12px;
            border: 1px solid rgba(34, 158, 217, 0.4);
        }
        .hero-title { font-size: 26px; font-weight: 900; color: #fff; margin-bottom: 8px; }
        .hero-desc { color: var(--text-muted); font-size: 14px; max-width: 820px; }

        .grid-layout { display: grid; grid-template-columns: 1.1fr 1fr; gap: 24px; }
        @media (max-width: 860px) { .grid-layout { grid-template-columns: 1fr; } }

        .saas-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 14px;
            padding: 22px;
        }
        .feature-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 12px 0;
            border-bottom: 1px solid #1e293b;
        }
        .feature-item:last-child { border-bottom: none; }
        .feature-icon {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background: rgba(34, 158, 217, 0.15);
            color: #229ed9;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }

        /* Mockup Telegram Chat Box */
        .telegram-chat-mockup {
            background: #0e1621;
            border: 1px solid #17212b;
            border-radius: 12px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            height: 480px;
        }
        .tg-header {
            background: #17212b;
            padding: 10px 14px;
            display: flex;
            align-items: center;
            gap: 10px;
            border-bottom: 1px solid #242f3d;
        }
        .tg-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: #229ed9;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 16px;
        }
        .tg-body {
            flex: 1;
            padding: 14px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        .tg-msg {
            max-width: 85%;
            padding: 10px 14px;
            border-radius: 10px;
            font-size: 12.5px;
            line-height: 1.5;
        }
        .tg-msg-user {
            align-self: flex-end;
            background: #2b5278;
            color: #fff;
            border-bottom-right-radius: 2px;
        }
        .tg-msg-bot {
            align-self: flex-start;
            background: #182533;
            color: #f8fafc;
            border-bottom-left-radius: 2px;
            border: 1px solid #242f3d;
        }
        .tg-footer {
            background: #17212b;
            padding: 10px;
            display: flex;
            gap: 8px;
            border-top: 1px solid #242f3d;
        }
        .tg-input {
            flex: 1;
            background: #0e1621;
            border: 1px solid #242f3d;
            border-radius: 8px;
            padding: 8px 12px;
            color: #fff;
            font-size: 12.5px;
            outline: none;
        }
        .btn-tg-send {
            background: #229ed9;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 0 14px;
            cursor: pointer;
            font-size: 13px;
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            background: var(--primary);
            color: #fff;
            padding: 12px 18px;
            border-radius: 8px;
            font-weight: 800;
            font-size: 14px;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            margin-top: 10px;
        }
        .btn-action:hover { opacity: 0.9; transform: translateY(-1px); }
    </style>
    <link rel="alternate" type="text/markdown" href="https://www.parselsorgu.net/llms.txt" title="ParselSorgu AI / LLM Bilgi Bankası">
    <link rel="alternate" type="application/json" href="https://www.parselsorgu.net/api/2026-kadastro-endeks.json" title="2026 Kadastro ve İmar Açık Veri Seti">
    <script type="application/ld+json">{"@context": "https://schema.org", "@type": "WebPage", "speakable": {"@type": "SpeakableSpecification", "cssSelector": ["h1", ".lead", ".summary-box", ".hero-desc", "main p"]}, "isBasedOn": "https://www.parselsorgu.net/api/2026-kadastro-endeks.json", "publisher": {"@type": "Organization", "name": "Ant Harita Mühendislik - ParselSorgu.net", "url": "https://www.parselsorgu.net/"}}</script>
</head>
<body>
    <?php render_navbar('eklentiler'); ?>

    <div class="container">
        <div class="hero-banner">
            <div class="hero-badge">
                <i class="fa-brands fa-telegram"></i> CANLI GPS &amp; COPERNICUS DEM ENTEGRASYONU
            </div>
            <h1 class="hero-title">Saha Çalışanları İçin Canlı Telegram Parsel Botu</h1>
            <p class="hero-desc">
                Harita mühendisleri, gayrimenkul danışmanları ve değerleme uzmanları için tasarlandı. Sahadayken Telegram'dan tek tuşla canlı konum atın veya metinle ada/parsel yazın; ST_Contains ile parsel sınırları, Copernicus DEM eğim/rakım kartı ve uydu fotoğrafı 2 saniyede cebinize gelsin.
            </p>
        </div>

        <div class="grid-layout">
            <!-- Sol Sütun: Yetenekler ve Hızlı Bağlantı -->
            <div class="saas-card">
                <h2 style="font-size: 17px; font-weight: 800; margin-bottom: 16px; color:#fff; display:flex; align-items:center; gap:8px;">
                    <i class="fa-solid fa-satellite-dish" style="color:#229ed9;"></i> Saha Botunun Avantajları
                </h2>

                <div class="feature-item">
                    <div class="feature-icon"><i class="fa-solid fa-location-crosshairs"></i></div>
                    <div>
                        <div style="font-weight:700; color:#fff; font-size:13.5px;">Ataş &rarr; Konum ile Otomatik Parsel Bulma</div>
                        <div style="font-size:12px; color:var(--text-muted);">Parsel numarasını bilmeseniz bile tarlanın üzerindeyken konum attığınızda poligon otomatik yakalanır.</div>
                    </div>
                </div>

                <div class="feature-item">
                    <div class="feature-icon"><i class="fa-solid fa-mountain"></i></div>
                    <div>
                        <div style="font-weight:700; color:#fff; font-size:13.5px;">Copernicus DEM Eğim ve Rakım Analizi</div>
                        <div style="font-size:12px; color:var(--text-muted);">Arazinin yüzde cinsinden ortalama eğimi, denizden yüksekliği (rakım) ve hafriyat/inşaat elverişlilik durumu saniyeler içinde dökülür.</div>
                    </div>
                </div>

                <div class="feature-item">
                    <div class="feature-icon"><i class="fa-solid fa-image"></i></div>
                    <div>
                        <div style="font-weight:700; color:#fff; font-size:13.5px;">Statik Yüksek Çözünürlüklü Uydu Haritası</div>
                        <div style="font-size:12px; color:var(--text-muted);">Parselin merkezine kırmızı pin atılmış 600x400 yüksek çözünürlüklü uydu fotoğrafı sohbete teslim edilir.</div>
                    </div>
                </div>

                <div class="feature-item">
                    <div class="feature-icon"><i class="fa-solid fa-terminal"></i></div>
                    <div>
                        <div style="font-weight:700; color:#fff; font-size:13.5px;">Metin ile Hızlı Sorgulama</div>
                        <div style="font-size:12px; color:var(--text-muted);"><code>/sorgu &lt;il&gt; &lt;ilce&gt; &lt;mahalle&gt; &lt;ada&gt; &lt;parsel&gt;</code> komutuyla bürodan veya yoldayken anında analiz imkanı.</div>
                    </div>
                </div>

                <!-- Webhook Bağlantı Kutusu -->
                <div style="background:rgba(34,158,217,0.08); border:1px solid rgba(34,158,217,0.3); border-radius:10px; padding:16px; margin-top:20px;">
                    <div style="font-weight:800; font-size:13px; color:#229ed9; margin-bottom:6px;">
                        <i class="fa-solid fa-plug"></i> Kendi Botunuza Webhook Bağlayın
                    </div>
                    <p style="font-size:11.5px; color:#94a3b8; margin-bottom:10px;">
                        Telegram @BotFather üzerinden oluşturduğunuz Bot Token'ı girerek tek tıkla webhook'u bağlayabilirsiniz:
                    </p>
                    <div style="display:flex; gap:8px;">
                        <input type="text" id="tgTokenInput" class="tg-input" placeholder="123456789:ABCdefGHIjklMNOpqrSTUvwxYZ">
                        <button type="button" class="btn-tg-send" onclick="connectWebhook()" style="font-weight:700;">Bağla</button>
                    </div>
                    <div id="webhookResult" style="font-size:11px; margin-top:6px; color:#10b981; display:none;"></div>
                </div>

                <a href="https://t.me/ParselSorguBot" target="_blank" class="btn-action" style="background:#229ed9;">
                    <i class="fa-brands fa-telegram"></i> Telegram'da Botu Başlat (@ParselSorguBot)
                </a>
            </div>

            <!-- Sağ Sütun: Canlı Telegram Simülatörü -->
            <div class="saas-card" style="padding:16px;">
                <h3 style="font-size:14.5px; font-weight:800; color:#fff; margin-bottom:10px; display:flex; align-items:center; justify-content:space-between;">
                    <span><i class="fa-solid fa-mobile-screen-button" style="color:#229ed9;"></i> Canlı Saha Botu Simülatörü</span>
                    <button type="button" onclick="sendGpsSimulation()" style="background:rgba(16,185,129,0.2); color:#10b981; border:1px solid rgba(16,185,129,0.4); padding:3px 8px; border-radius:6px; font-size:11px; cursor:pointer;">
                        <i class="fa-solid fa-crosshairs"></i> Canlı Konum Gönder
                    </button>
                </h3>

                <div class="telegram-chat-mockup">
                    <div class="tg-header">
                        <div class="tg-avatar"><i class="fa-solid fa-map-pin"></i></div>
                        <div>
                            <div style="font-size:13px; font-weight:800; color:#fff;">ParselSorgu Asistanı</div>
                            <div style="font-size:10.5px; color:#10b981;">bot &bull; çevrimiçi</div>
                        </div>
                    </div>

                    <div class="tg-body" id="chatBody">
                        <div class="tg-msg tg-msg-bot">
                            👋 <strong>ParselSorgu Saha Asistanı'na Hoş Geldiniz!</strong><br><br>
                            1️⃣ <strong>Canlı Konum:</strong> Sahadayken Telegram'dan <em>Ataş &rarr; Konum</em> gönderin.<br>
                            2️⃣ <strong>Metin ile Sorgu:</strong> <code>/sorgu antalya dosemealti yenikoy 105 14</code>
                        </div>
                    </div>

                    <div class="tg-footer">
                        <input type="text" id="simInput" class="tg-input" placeholder="Örn: /sorgu konya karatay feyziye 101 5" onkeydown="if(event.key==='Enter') sendSimMessage()">
                        <button type="button" class="btn-tg-send" onclick="sendSimMessage()"><i class="fa-solid fa-paper-plane"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ANT HARITA SAAS CROSS-LINKING & INTERNAL DISCOVERY ENGINE -->
    <section class="saas-crosslinks-section" style="max-width:1100px; margin:40px auto 20px; padding:24px 20px; background:linear-gradient(135deg, #0b1329 0%, #0f172a 100%); border:1px solid #1e293b; border-radius:16px;">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px; flex-wrap:wrap; gap:10px;">
            <div>
                <h3 style="color:#fff; font-size:15px; font-weight:800; margin:0 0 4px 0; display:flex; align-items:center; gap:8px;">
                    <i class="fa-solid fa-layer-group" style="color:#38bdf8;"></i> Diğer Popüler Harita, Kadastro &amp; Gayrimenkul SaaS Araçlarımız
                </h3>
                <p style="color:#94a3b8; font-size:12px; margin:0;">Ant Harita Mühendislik altyapısıyla geliştirilen diğer akıllı analiz modüllerini keşfedin.</p>
            </div>
            <a href="/eklentiler" style="background:#10b981; color:#fff; padding:6px 14px; border-radius:8px; font-size:12px; font-weight:700; text-decoration:none; display:inline-flex; align-items:center; gap:6px;">
                <i class="fa-solid fa-grid-round"></i> Tüm Modüller (25+) &rarr;
            </a>
        </div>
        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); gap:12px;">
            <a href="/lihkab-hesaplama" style="display:flex; align-items:center; gap:10px; padding:10px 12px; background:#131d31; border:1px solid #1e293b; border-radius:10px; text-decoration:none; color:#f8fafc;">
                <div style="width:36px; height:36px; border-radius:8px; background:rgba(16,185,129,0.15); color:#10b981; display:flex; align-items:center; justify-content:center; font-size:16px;"><i class="fa-solid fa-stamp"></i></div>
                <div><div style="font-size:12.5px; font-weight:700;">LİHKAB &amp; Kadastro Harcı</div><div style="font-size:11px; color:#94a3b8;">Aplikasyon &amp; cins değişikliği</div></div>
            </a>
            <a href="/harita-muhendislik-fiyat-teklifi" style="display:flex; align-items:center; gap:10px; padding:10px 12px; background:#131d31; border:1px solid #1e293b; border-radius:10px; text-decoration:none; color:#f8fafc;">
                <div style="width:36px; height:36px; border-radius:8px; background:rgba(56,189,248,0.15); color:#38bdf8; display:flex; align-items:center; justify-content:center; font-size:16px;"><i class="fa-solid fa-compass-drafting"></i></div>
                <div><div style="font-size:12.5px; font-weight:700;">Mühendislik Teklif Motoru</div><div style="font-size:11px; color:#94a3b8;">HKMO 2026 asgari tarife</div></div>
            </a>
            <a href="/prefabrik-ev-maliyeti-hesaplama" style="display:flex; align-items:center; gap:10px; padding:10px 12px; background:#131d31; border:1px solid #1e293b; border-radius:10px; text-decoration:none; color:#f8fafc;">
                <div style="width:36px; height:36px; border-radius:8px; background:rgba(245,158,11,0.15); color:#f59e0b; display:flex; align-items:center; justify-content:center; font-size:16px;"><i class="fa-solid fa-house-laptop"></i></div>
                <div><div style="font-size:12.5px; font-weight:700;">Prefabrik &amp; Çelik Ev</div><div style="font-size:11px; color:#94a3b8;">Maliyet &amp; ruhsat analizi</div></div>
            </a>
            <a href="/cks-destegi-hesaplama" style="display:flex; align-items:center; gap:10px; padding:10px 12px; background:#131d31; border:1px solid #1e293b; border-radius:10px; text-decoration:none; color:#f8fafc;">
                <div style="width:36px; height:36px; border-radius:8px; background:rgba(16,185,129,0.15); color:#10b981; display:flex; align-items:center; justify-content:center; font-size:16px;"><i class="fa-solid fa-wheat-awn"></i></div>
                <div><div style="font-size:12.5px; font-weight:700;">2026 ÇKS Destekleri</div><div style="font-size:11px; color:#94a3b8;">Mazot &amp; gübre hibesi</div></div>
            </a>
            <a href="/arazi-ges-amortisman-hesaplama" style="display:flex; align-items:center; gap:10px; padding:10px 12px; background:#131d31; border:1px solid #1e293b; border-radius:10px; text-decoration:none; color:#f8fafc;">
                <div style="width:36px; height:36px; border-radius:8px; background:rgba(245,158,11,0.15); color:#f59e0b; display:flex; align-items:center; justify-content:center; font-size:16px;"><i class="fa-solid fa-solar-panel"></i></div>
                <div><div style="font-size:12.5px; font-weight:700;">Arazi GES Amortisman</div><div style="font-size:11px; color:#94a3b8;">Güneş santrali kurulumu</div></div>
            </a>
            <a href="/kentsel-donusum-yarisi-bizden" style="display:flex; align-items:center; gap:10px; padding:10px 12px; background:#131d31; border:1px solid #1e293b; border-radius:10px; text-decoration:none; color:#f8fafc;">
                <div style="width:36px; height:36px; border-radius:8px; background:rgba(245,158,11,0.15); color:#f59e0b; display:flex; align-items:center; justify-content:center; font-size:16px;"><i class="fa-solid fa-building-shield"></i></div>
                <div><div style="font-size:12.5px; font-weight:700;">Yarısı Bizden &amp; Şerefiye</div><div style="font-size:11px; color:#94a3b8;">Kentsel dönüşüm hibe/kredi</div></div>
            </a>
        </div>
    </section>

    <script>
        function appendMsg(text, isUser = false, imgUrl = null) {
            const body = document.getElementById('chatBody');
            const msg = document.createElement('div');
            msg.className = 'tg-msg ' + (isUser ? 'tg-msg-user' : 'tg-msg-bot');
            
            if (imgUrl) {
                msg.innerHTML = `<img src="${imgUrl}" style="width:100%; border-radius:6px; margin-bottom:8px; display:block;" alt="Uydu Haritası">` + text;
            } else {
                msg.innerHTML = text;
            }
            body.appendChild(msg);
            body.scrollTop = body.scrollHeight;
        }

        function sendSimMessage() {
            const input = document.getElementById('simInput');
            const txt = input.value.trim();
            if (!txt) return;
            appendMsg(txt, true);
            input.value = '';

            setTimeout(() => {
                const parts = txt.replace('/sorgu', '').trim().split(/\s+/);
                const il = parts[0] || "Antalya";
                const ilce = parts[1] || "Döşemealtı";
                const mah = parts[2] || "Yeniköy";
                const ada = parts[3] || "105";
                const parsel = parts[4] || "14";

                const mapUrl = `https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/export?bbox=30.50,37.00,30.51,37.01&size=600,400&format=png&f=image`;
                const botReply = `📍 <strong>PARSEL DETAY KARTI</strong><br>`
                               + `━━━━━━━━━━━━━━━━━━<br>`
                               + `🏛️ <strong>Konum:</strong> ${il} / ${ilce} / ${mah}<br>`
                               + `📌 <strong>Ada / Parsel:</strong> <code>${ada} / ${parsel}</code><br>`
                               + `📐 <strong>Kadastral Alan:</strong> 1.250 m²<br>`
                               + `🏷️ <strong>Nitelik:</strong> Arsa (Ayrık Nizam 2 Kat)<br><br>`
                               + `⛰️ <strong>TOPOĞRAFYA &amp; EĞİM ANALİZİ</strong><br>`
                               + `━━━━━━━━━━━━━━━━━━<br>`
                               + `📈 <strong>Ortalama Eğim:</strong> %4.2<br>`
                               + `⛰️ <strong>Ortalama Rakım:</strong> 295 m<br>`
                               + `🧭 <strong>Durum:</strong> 🟢 Düz / Hafif Eğimli (İnşaat için elverişli)<br><br>`
                               + `<a href="/parsel" style="color:#38bdf8; text-decoration:none;">🌐 ParselSorgu.net'te Canlı 3D İncele &rarr;</a>`;

                appendMsg(botReply, false, mapUrl);
            }, 600);
        }

        function sendGpsSimulation() {
            appendMsg('📍 <em>Canlı Konum Paylaşıldı: 36.8841° N, 30.7056° E</em>', true);
            setTimeout(() => {
                const mapUrl = `https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/export?bbox=30.70,36.88,30.71,36.89&size=600,400&format=png&f=image`;
                const botReply = `📍 <strong>PARSEL DETAY KARTI</strong><br>`
                               + `━━━━━━━━━━━━━━━━━━<br>`
                               + `🏛️ <strong>Konum:</strong> Antalya / Muratpaşa / Şirinyalı<br>`
                               + `📌 <strong>Ada / Parsel:</strong> <code>204 / 8</code><br>`
                               + `📐 <strong>Kadastral Alan:</strong> 850 m²<br>`
                               + `🏷️ <strong>Nitelik:</strong> Arsa (Konut İmarlı)<br><br>`
                               + `⛰️ <strong>TOPOĞRAFYA &amp; EĞİM ANALİZİ</strong><br>`
                               + `━━━━━━━━━━━━━━━━━━<br>`
                               + `📈 <strong>Ortalama Eğim:</strong> %2.1<br>`
                               + `⛰️ <strong>Ortalama Rakım:</strong> 38 m<br>`
                               + `🧭 <strong>Durum:</strong> 🟢 Düz / Hafif Eğimli<br><br>`
                               + `<a href="/parsel" style="color:#38bdf8; text-decoration:none;">🌐 ParselSorgu.net'te Canlı 3D İncele &rarr;</a>`;
                appendMsg(botReply, false, mapUrl);
            }, 800);
        }

        function connectWebhook() {
            const token = document.getElementById('tgTokenInput').value.trim();
            const resEl = document.getElementById('webhookResult');
            if (!token) {
                alert('Lütfen BotFather tokenınızı girin.');
                return;
            }
            resEl.style.display = 'block';
            resEl.innerText = "Webhook bağlanıyor...";

            fetch('/telegram_webhook.php?action=set_webhook&token=' + encodeURIComponent(token))
                .then(r => r.json())
                .then(data => {
                    if (data.ok) {
                        resEl.innerHTML = `<i class="fa-solid fa-circle-check"></i> Webhook başarıyla bağlandı! Botunuz aktif: ${data.description || 'OK'}`;
                    } else {
                        resEl.innerHTML = `<span style="color:#ef4444;"><i class="fa-solid fa-triangle-exclamation"></i> Hata: ${data.description || 'Geçersiz Token'}</span>`;
                    }
                })
                .catch(err => {
                    resEl.innerHTML = `<span style="color:#ef4444;">İletişim hatası oluştu.</span>`;
                });
        }
    </script>
</body>
</html>
