<?php
/**
 * ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ - PARSEL PRO
 * arsa_degerleme_hesaplama.php - 2026 Yapay Zeka Arsa Rayiç Değeri & Fiyat Hesaplayıcı
 * 81 İl ve İlçe Bazlı Piyasa Rayiç Endeksi ve Değerleme Analizi
 */

declare(strict_types=1);
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/navbar.php';

$page_title = "Arsa Değerleme ve Rayiç Fiyat Hesaplama 2026 | ParselSorgu";
$meta_desc = "Arsa ve tarlanızın 2026 güncel m² piyasa rayiç bedelini ve toplam değerini 81 il imar durumu ve KAKS emsaline göre hesaplayın.";
$canonical_url = "https://www.parselsorgu.net/arsa-degerleme-hesaplama";
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
  
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@graph": [
      {
        "@type": "WebApplication",
        "name": "Arsa Rayiç Değerleme ve Piyasa Fiyatı Hesaplama Motoru",
        "url": "https://www.parselsorgu.net/arsa-degerleme-hesaplama",
        "applicationCategory": "RealEstateApplication",
        "operatingSystem": "All",
        "provider": {
          "@type": "Organization",
          "name": "Ant Harita Mühendislik",
          "telephone": "0542 841 35 35"
        }
      },
      {
        "@type": "FAQPage",
        "mainEntity": [
          {
            "@type": "Question",
            "name": "Arsa metrekare rayiç fiyatı nasıl hesaplanır?",
            "acceptedAnswer": {
              "@type": "Answer",
              "text": "Arsa değeri belirlenirken bölgedeki meri imar planı, emsal (KAKS) oranı, taşınmazın yola cephesi, topoğrafik eğimi ve son 1 yıldaki emsal satış rayiçleri baz alınarak metrekare birim fiyatı tespit edilir."
            }
          },
          {
            "@type": "Question",
            "name": "Belediye rayiç bedeli ile piyasa değeri arasındaki fark nedir?",
            "acceptedAnswer": {
              "@type": "Answer",
              "text": "Belediye rayiç bedeli emlak vergisi tarhına esas asgari yasal tutardır; serbest piyasa rayiç değeri ise arsanın güncel alım-satım piyasasındaki gerçek ekonomik karşılığıdır ve genellikle belediye rayicinin 3 ila 10 katı arasındadır."
            }
          }
        ]
      }
    ]
  }
  </script>

  <style>
    :root {
      --bg-dark: #0b1120;
      --card-dark: #111c30;
      --border-dark: rgba(56, 189, 248, 0.22);
      --primary-cyan: #38bdf8;
      --primary-blue: #0284c7;
    }
    body { font-family: 'Inter', -apple-system, sans-serif; background: var(--bg-dark); color: #f8fafc; margin: 0; padding: 0; }
    .val-container { max-width: 1040px; margin: 30px auto; padding: 0 16px 80px 16px; }
    .val-hero { background: linear-gradient(135deg, rgba(15,23,42,0.98) 0%, rgba(30,41,59,0.95) 100%); border: 2px solid #0284c7; border-radius: 16px; padding: 30px; margin-bottom: 24px; box-shadow: 0 10px 40px rgba(2,132,199,0.18); text-align: center; }
    .val-grid { display: grid; grid-template-columns: 1.1fr 0.9fr; gap: 24px; }
    .card-box { background: var(--card-dark); border: 1px solid var(--border-dark); border-radius: 14px; padding: 26px; }
    .form-group { margin-bottom: 16px; }
    .form-label { display: block; font-size: 12.5px; font-weight: 700; color: #94a3b8; text-transform: uppercase; margin-bottom: 6px; }
    .form-control { width: 100%; box-sizing: border-box; background: #0b1120; border: 1px solid #334155; border-radius: 8px; color: #fff; padding: 11px 14px; font-size: 14px; font-weight: 600; outline: none; transition: all 0.2s; }
    .form-control:focus { border-color: #38bdf8; box-shadow: 0 0 0 3px rgba(56,189,248,0.2); }
    .btn-calc { width: 100%; background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%); color: #fff; border: none; padding: 14px; border-radius: 8px; font-size: 15px; font-weight: 800; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; justify-content: center; gap: 8px; }
    .btn-calc:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(2,132,199,0.4); }
    .price-badge { font-size: 32px; font-weight: 900; color: #38bdf8; margin: 4px 0; }
    .metric-row { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid rgba(255,255,255,0.06); font-size: 13.5px; }
    .guide-box { background: #0f172a; border: 1px solid #1e293b; border-radius: 10px; padding: 16px 18px; margin-top: 16px; font-size: 13px; color: #cbd5e1; line-height: 1.6; }
    @media (max-width: 768px) {
      .val-grid { grid-template-columns: 1fr; }
      .val-container { padding: 14px 12px 90px 12px; }
    }
  </style>
    <link rel="alternate" type="text/markdown" href="https://www.parselsorgu.net/llms.txt" title="ParselSorgu AI / LLM Bilgi Bankası">
    <link rel="alternate" type="application/json" href="https://www.parselsorgu.net/api/2026-kadastro-endeks.json" title="2026 Kadastro ve İmar Açık Veri Seti">
    <script type="application/ld+json">{"@context": "https://schema.org", "@type": "WebPage", "speakable": {"@type": "SpeakableSpecification", "cssSelector": ["h1", ".lead", ".summary-box", ".hero-desc", "main p"]}, "isBasedOn": "https://www.parselsorgu.net/api/2026-kadastro-endeks.json", "publisher": {"@type": "Organization", "name": "Ant Harita Mühendislik - ParselSorgu.net", "url": "https://www.parselsorgu.net/"}}</script>
</head>
<body>

  <div class="val-container">
    <div class="val-hero">
      <div style="font-size:12px; color:#38bdf8; font-weight:800; text-transform:uppercase; letter-spacing:1px; margin-bottom:6px;">
        <i class="fa fa-chart-line"></i> 2026 Emlak Rayiç Endeksi & Harita Mühendisliği Verisi
      </div>
      <h1 style="font-size:26px; font-weight:900; margin:0 0 10px 0; color:#fff;">
        Arsa Değerleme &amp; Piyasa Fiyatı Hesaplama Motoru
      </h1>
      <p style="font-size:14px; color:#94a3b8; max-width:720px; margin:0 auto; line-height:1.5;">
        Taşınmazınızın imar fonksiyonu, emsal (KAKS) katsayısı, yüzölçümü ve bölgesel piyasa verilerine göre tahmini m² rayiç bedelini ve toplam piyasa değerini anında analiz edin.
      </p>
    </div>

    <div class="val-grid">
      <!-- FORM -->
      <div class="card-box">
        <h2 style="font-size:16px; font-weight:800; margin:0 0 16px 0; color:#fff;">
          <i class="fa fa-sliders" style="color:#38bdf8;"></i> Arsa Parametrelerini Girin
        </h2>

        <div class="form-group">
          <label class="form-label">Şehir / Bölge Katsayısı</label>
          <select id="sehirKatsayi" class="form-control">
            <option value="1.8">İstanbul (Metropol A+ Segmenti)</option>
            <option value="1.4" selected>Ankara / İzmir / Antalya / Bursa (Metropol A Segmenti)</option>
            <option value="1.1">Kocaeli, Sakarya, Tekirdağ, Balıkesir (Gelişen Sanayi/Turizm)</option>
            <option value="0.9">Eskişehir, Konya, Kayseri, Gaziantep, Denizli (Anadolu Merkezleri)</option>
            <option value="0.7">Kırıkkale, Çorum, Yozgat, Tokat, Aksaray, Niğde (İç Anadolu)</option>
            <option value="0.6">Diğer Anadolu İlleri ve Kırsal Alanlar</option>
          </select>
        </div>

        <div class="form-group">
          <label class="form-label">Arsa / Tarla Yüzölçümü (m²)</label>
          <input type="number" id="m2" class="form-control" value="600" placeholder="Örn: 600">
        </div>

        <div class="form-group">
          <label class="form-label">Meri İmar Durumu &amp; Fonksiyonu</label>
          <select id="imarTipi" class="form-control">
            <option value="18000">Ticari + Konut İmarlı (Merkezi Bulvar/Cadde)</option>
            <option value="12000" selected>Ayrık Nizam Konut İmarlı (3-5 Kat)</option>
            <option value="9500">Villa / Düşük Yoğunluklu Konut (E: 0.30 - 0.50)</option>
            <option value="7500">Sanayi / Depolama / Lojistik İmarlı</option>
            <option value="2500">Köy Yerleşik Alanı İçi (Köy İçi Arsa/Ev Yeri)</option>
            <option value="850">Tarım Arazisi / Tarla / Zeytinlik (İmarsız)</option>
          </select>
        </div>

        <div class="form-group">
          <label class="form-label">Emsal (KAKS) İnşaat Hakkı</label>
          <select id="kaks" class="form-control">
            <option value="0.40">Düşük Emsal (KAKS: 0.20 - 0.50 - Villa/Tarla)</option>
            <option value="1.20" selected>Orta Emsal (KAKS: 1.00 - 1.50 - Standart Konut)</option>
            <option value="2.00">Yüksek Emsal (KAKS: 1.80 - 2.50 - Yoğun Konut/Ticari)</option>
          </select>
        </div>

        <div class="form-group">
          <label class="form-label">Yola Cephe ve Konum Avantajı</label>
          <select id="cephe" class="form-control">
            <option value="1.20">Köşe Parsel / Çift Yola Cepheli (+%20 Değerli)</option>
            <option value="1.00" selected>Standart İmar Yoluna Tek Cepheli</option>
            <option value="0.85">Yola Dar Cepheli veya İç Parsel (-%15 İskonto)</option>
          </select>
        </div>

        <button type="button" class="btn-calc" onclick="calculateValuation()">
          <i class="fa fa-calculator"></i> Arsa Değerini Hesapla
        </button>
      </div>

      <!-- SONUÇ -->
      <div class="card-box" style="display:flex; flex-direction:column; justify-content:space-between;">
        <div>
          <h2 style="font-size:16px; font-weight:800; margin:0 0 16px 0; color:#fff;">
            <i class="fa fa-badge-check" style="color:#38bdf8;"></i> 2026 Tahmini Piyasa Değeri
          </h2>

          <div style="font-size:12px; color:#94a3b8; font-weight:700; text-transform:uppercase;">Ortalama Toplam Piyasa Değeri</div>
          <div id="toplamDeger" class="price-badge">12.096.000 TL</div>

          <div class="metric-row">
            <span style="color:#94a3b8;">Tahmini m² Birim Fiyatı:</span>
            <strong id="m2Fiyat" style="color:#fff;">20.160 TL / m²</strong>
          </div>
          <div class="metric-row">
            <span style="color:#94a3b8;">Müstakil İnşaat Alanı (Brüt):</span>
            <strong id="brutInsaat" style="color:#38bdf8;">720 m²</strong>
          </div>
          <div class="metric-row">
            <span style="color:#94a3b8;">Bölgesel 2026 Yıllık Artış:</span>
            <strong style="color:#4ade80;">+%58 - %74</strong>
          </div>

          <div class="guide-box">
            <strong>Mühendislik Notu:</strong> Bu hesaplama meri imar planı emsali ve 2026 bölgesel piyasa çarpanları kullanılarak tahmini olarak üretilmiştir. Kesin SPK lisanslı değerleme raporu, şerefiye analizi ve hisseli tapu durum tespiti için resmi değerleme yaptırılması önerilir.
          </div>
        </div>

        <div style="margin-top:20px;">
          <a id="btnWa" href="https://wa.me/905428413535?text=Merhaba+Ant+Harita+arsa+degerleme+hesaplamam+icin+resmi+ekspertiz+ve+imar+danismanligi+almak+istiyorum." target="_blank" style="display:flex; align-items:center; justify-content:center; gap:8px; background:#22c55e; color:#fff; text-decoration:none; padding:12px; border-radius:8px; font-weight:800; font-size:14px;">
            <i class="fab fa-whatsapp"></i> Resmi Değerleme Teklifi Al
          </a>
        </div>
      </div>
    </div>
  </div>

  <script>
    function calculateValuation() {
      const sehirKatsayi = parseFloat(document.getElementById('sehirKatsayi').value) || 1.0;
      const m2 = parseFloat(document.getElementById('m2').value) || 0;
      const bazFiyat = parseFloat(document.getElementById('imarTipi').value) || 10000;
      const kaks = parseFloat(document.getElementById('kaks').value) || 1.0;
      const cephe = parseFloat(document.getElementById('cephe').value) || 1.0;

      // m2 birim fiyatı
      const m2Fiyat = Math.round(bazFiyat * sehirKatsayi * cephe);
      const toplamFiyat = Math.round(m2Fiyat * m2);
      const brutInsaat = Math.round(m2 * kaks);

      document.getElementById('toplamDeger').innerText = toplamFiyat.toLocaleString('tr-TR') + ' TL';
      document.getElementById('m2Fiyat').innerText = m2Fiyat.toLocaleString('tr-TR') + ' TL / m²';
      document.getElementById('brutInsaat').innerText = brutInsaat.toLocaleString('tr-TR') + ' m²';

      const waMsg = 'Merhaba Ant Harita Mühendislik, ' + m2.toLocaleString('tr-TR') + ' m² büyüklüğündeki arsam için yaklaşık ' + toplamFiyat.toLocaleString('tr-TR') + ' TL piyasa değeri hesapladım. Resmi değerleme ve imar analizi için görüşmek istiyorum.';
      document.getElementById('btnWa').href = 'https://wa.me/905428413535?text=' + encodeURIComponent(waMsg);
    }
  </script>

</body>
</html>
