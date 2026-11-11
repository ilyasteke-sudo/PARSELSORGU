<?php
/**
 * ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ - PARSEL PRO
 * toplu_parsel_sorgulama.php - Toplu Ada/Parsel Analiz ve Harita Listeleme Aracı
 * Emlak Danışmanları, Gayrimenkul Yatırımcıları ve Harita Büroları İçin
 */

declare(strict_types=1);
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/navbar.php';

$page_title = "Toplu Ada Parsel Sorgulama ve Excel Analizi | ParselSorgu";
$meta_desc = "Çok sayıda ada ve parseli tek tıkla sorgulayın. Excel / CSV listesi yükleyerek alan, imar ve harita konumlarını anında listeleyin.";
$canonical_url = "https://www.parselsorgu.net/toplu-parsel-sorgulama";
?>
<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
  <title><?= $page_title ?></title>
  <meta name="description" content="<?= $meta_desc ?>">
  <link rel="canonical" href="<?= $canonical_url ?>    <meta property="og:image" content="https://www.parselsorgu.net/assets/images/og-parsel.jpg">
">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
  
  <style>
    :root {
      --bg-dark: #0b1120;
      --card-dark: #111c30;
      --border-dark: rgba(56, 189, 248, 0.22);
      --primary-cyan: #38bdf8;
      --primary-blue: #0284c7;
    }
    body { font-family: 'Inter', -apple-system, sans-serif; background: var(--bg-dark); color: #f8fafc; margin: 0; padding: 0; }
    .bulk-container { max-width: 1100px; margin: 30px auto; padding: 0 16px 80px 16px; }
    .hero-card { background: linear-gradient(135deg, rgba(15,23,42,0.98) 0%, rgba(30,41,59,0.95) 100%); border: 2px solid #0284c7; border-radius: 16px; padding: 30px; margin-bottom: 24px; box-shadow: 0 10px 40px rgba(2,132,199,0.18); text-align: center; }
    .card-box { background: var(--card-dark); border: 1px solid var(--border-dark); border-radius: 14px; padding: 26px; margin-bottom: 24px; }
    .bulk-textarea { width: 100%; box-sizing: border-box; background: #0b1120; border: 1px solid #334155; border-radius: 8px; color: #fff; padding: 14px; font-family: monospace; font-size: 13.5px; height: 160px; outline: none; }
    .bulk-textarea:focus { border-color: #38bdf8; }
    .btn-parse { background: #0284c7; color: #fff; border: none; padding: 12px 24px; border-radius: 8px; font-weight: 800; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; font-size: 14px; }
    .btn-parse:hover { background: #0369a1; }
    .data-table { width: 100%; border-collapse: collapse; margin-top: 16px; font-size: 13px; }
    .data-table th { background: #0f172a; color: #38bdf8; text-align: left; padding: 12px 14px; font-weight: 700; border-bottom: 1px solid #1e293b; }
    .data-table td { padding: 12px 14px; border-bottom: 1px solid rgba(255,255,255,0.06); color: #cbd5e1; }
    .data-table tr:hover td { background: rgba(56, 189, 248, 0.05); }
    .badge-parsel { background: rgba(56,189,248,0.15); color: #38bdf8; padding: 3px 8px; border-radius: 4px; font-weight: 800; text-decoration: none; }
  </style>
    <link rel="alternate" type="text/markdown" href="https://www.parselsorgu.net/llms.txt" title="ParselSorgu AI / LLM Bilgi Bankası">
    <link rel="alternate" type="application/json" href="https://www.parselsorgu.net/api/2026-kadastro-endeks.json" title="2026 Kadastro ve İmar Açık Veri Seti">
    <script type="application/ld+json">{"@context": "https://schema.org", "@type": "WebPage", "speakable": {"@type": "SpeakableSpecification", "cssSelector": ["h1", ".lead", ".summary-box", ".hero-desc", "main p"]}, "isBasedOn": "https://www.parselsorgu.net/api/2026-kadastro-endeks.json", "publisher": {"@type": "Organization", "name": "Ant Harita Mühendislik - ParselSorgu.net", "url": "https://www.parselsorgu.net/"}}</script>
</head>
<body>

  <div class="bulk-container">
    <div class="hero-card">
      <div style="font-size:12px; color:#38bdf8; font-weight:800; text-transform:uppercase; letter-spacing:1px; margin-bottom:6px;">
        <i class="fa fa-layer-group"></i> Çoklu Portföy &amp; Arsa Listesi Analizi
      </div>
      <h1 style="font-size:26px; font-weight:900; margin:0 0 10px 0; color:#fff;">
        Toplu Ada/Parsel Sorgulama &amp; Harita Listeleme
      </h1>
      <p style="font-size:14px; color:#94a3b8; max-width:700px; margin:0 auto; line-height:1.5;">
        Emlak portföyünüzdeki veya yatırım listenizdeki parselleri tek tek aramak yerine topluca yapıştırın; anında harita linklerini, tahmini değerlerini ve raporlarını tek tabloda görün.
      </p>
    </div>

    <div class="card-box">
      <h2 style="font-size:16px; font-weight:800; margin:0 0 10px 0; color:#fff;">
        <i class="fa fa-paste" style="color:#38bdf8;"></i> Parsel Listesini Yapıştırın (Her satıra bir parsel)
      </h2>
      <p style="font-size:12.5px; color:#94a3b8; margin:0 0 12px 0;">
        Format: <code>Şehir, İlçe, Mahalle, Ada, Parsel</code> (Virgülle veya boşlukla ayırabilirsiniz)
      </p>

      <textarea id="bulkInput" class="bulk-textarea" placeholder="Ankara, Çankaya, Alacaatlı, 101, 1&#10;Ankara, Çankaya, Çayyolu, 102, 5&#10;Kırıkkale, Keskin, Gündoğdu, 205, 12">Ankara, Çankaya, Alacaatlı, 101, 1
Ankara, Çankaya, Çayyolu, 102, 5
Kırıkkale, Keskin, Gündoğdu, 205, 12</textarea>

      <div style="margin-top:14px; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;">
        <button type="button" class="btn-parse" onclick="processBulk()">
          <i class="fa fa-play"></i> Toplu Parselleri Analiz Et
        </button>
        <span id="parselCount" style="font-size:13px; color:#94a3b8; font-weight:600;">3 Parsel Algılandı</span>
      </div>
    </div>

    <!-- SONUÇ TABLOSU -->
    <div class="card-box" id="resultCard" style="display:none;">
      <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
        <h2 style="font-size:16px; font-weight:800; margin:0; color:#fff;">
          <i class="fa fa-table-list" style="color:#38bdf8;"></i> Analiz Edilen Portföy Tablosu
        </h2>
        <button onclick="window.print()" style="background:#1e293b; color:#fff; border:1px solid #334155; padding:6px 14px; border-radius:6px; cursor:pointer; font-size:12px; font-weight:700;">
          <i class="fa fa-print"></i> Yazdır / PDF Al
        </button>
      </div>

      <div style="overflow-x:auto;">
        <table class="data-table">
          <thead>
            <tr>
              <th>#</th>
              <th>İl / İlçe</th>
              <th>Mahalle</th>
              <th>Ada / Parsel</th>
              <th>Canlı Harita</th>
              <th>İmar &amp; Rapor</th>
              <th>İşlemler</th>
            </tr>
          </thead>
          <tbody id="tableBody"></tbody>
        </table>
      </div>
    </div>
  </div>

  <script>
    function processBulk() {
      const text = document.getElementById('bulkInput').value.trim();
      const lines = text.split('\n');
      const tbody = document.getElementById('tableBody');
      tbody.innerHTML = '';

      let validCount = 0;

      lines.forEach((line, idx) => {
        const cleanLine = line.trim();
        if (!cleanLine) return;

        const parts = cleanLine.split(/[,;\t]+/).map(p => p.trim());
        if (parts.length >= 3) {
          validCount++;
          const city = parts[0] || 'Ankara';
          const dist = parts[1] || 'Merkez';
          const mah = parts[2] || '';
          const ada = parts[3] || '1';
          const par = parts[4] || '1';

          const mapUrl = '/ada-parsel-harita?city=' + encodeURIComponent(city) + '&district=' + encodeURIComponent(dist) + '&mahalle=' + encodeURIComponent(mah) + '&ada=' + encodeURIComponent(ada) + '&parsel=' + encodeURIComponent(par);
          const raporUrl = '/parsel_raporu.php?city=' + encodeURIComponent(city) + '&district=' + encodeURIComponent(dist) + '&mahalle=' + encodeURIComponent(mah) + '&ada=' + encodeURIComponent(ada) + '&parsel=' + encodeURIComponent(par);
          const kmlUrl = '/export_parsel.php?format=kml&city=' + encodeURIComponent(city) + '&district=' + encodeURIComponent(dist) + '&mahalle=' + encodeURIComponent(mah) + '&ada=' + encodeURIComponent(ada) + '&parsel=' + encodeURIComponent(par);

          const tr = document.createElement('tr');
          tr.innerHTML = `
            <td><strong>${validCount}</strong></td>
            <td>${city} / ${dist}</td>
            <td>${mah || '-'}</td>
            <td><span class="badge-parsel">${ada}/${par}</span></td>
            <td><a href="${mapUrl}" target="_blank" style="color:#38bdf8; font-weight:700; text-decoration:none;"><i class="fa fa-map-location-dot"></i> Haritada Gör</a></td>
            <td><a href="${raporUrl}" target="_blank" style="color:#4ade80; font-weight:700; text-decoration:none;"><i class="fa fa-file-pdf"></i> PDF Raporu</a></td>
            <td><a href="${kmlUrl}" style="color:#cbd5e1; font-size:12px; text-decoration:none;"><i class="fa fa-download"></i> KML</a></td>
          `;
          tbody.appendChild(tr);
        }
      });

      document.getElementById('parselCount').innerText = validCount + ' Parsel Listelendi';
      document.getElementById('resultCard').style.display = validCount > 0 ? 'block' : 'none';
    }

    // İlk açılışta çalıştır
    document.addEventListener('DOMContentLoaded', processBulk);
  </script>

</body>
</html>
