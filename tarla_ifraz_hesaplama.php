<?php
/**
 * ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ - PARSEL PRO
 * tarla_ifraz_hesaplama.php - 5403 Sayılı Kanun Tarla İfraz & Bölünme Hesaplama Aracı
 * TMMOB HKMO Mühendislik Kriterleriyle Canlı Analiz
 */

declare(strict_types=1);
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/navbar.php';

$page_title = "5403 Tarla İfraz Hesaplama (Bölünür mü?) | ParselSorgu";
$meta_desc = "Tarlanız 5403 sayılı Kanuna göre bölünebilir mi? Dikili, sulu ve kuru tarım asgari parsel büyüklükleri ve ifraz hesaplayıcı.";
$canonical_url = "https://www.parselsorgu.net/tarla-ifraz-hesaplama";
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
        "name": "5403 Tarla İfraz ve Bölünme Hesaplama Motoru",
        "url": "https://www.parselsorgu.net/tarla-ifraz-hesaplama",
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
            "name": "5403 sayılı Kanun'a göre tarlalar kaça bölünebilir?",
            "acceptedAnswer": {
              "@type": "Answer",
              "text": "5403 sayılı Toprak Koruma Kanunu gereği dikili tarım arazilerinde en az 5.000 m², örtü altı tarımda 3.000 m², sulu ve kuru tarım arazilerinde ise en az 20.000 m² büyüklük aranmaktadır. Bu miktarların altındaki araziler bölünemez (ifraz edilemez)."
            }
          },
          {
            "@type": "Question",
            "name": "Tarlaya ifraz yapılabilmesi için yola cephe şartı nedir?",
            "acceptedAnswer": {
              "@type": "Answer",
              "text": "İfraz sonucu oluşacak her yeni parselin resmi kadastral yola en az 25 metre cephesi ve en az 30 metre parsel derinliği bulunması yasal zorunluluktur. Yolu olmayan parsellere geçit hakkı tesis edilmeden ifraz yapılamaz."
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
    .calc-container { max-width: 1000px; margin: 30px auto; padding: 0 16px 80px 16px; }
    .hero-card { background: linear-gradient(135deg, rgba(15,23,42,0.98) 0%, rgba(30,41,59,0.95) 100%); border: 2px solid #0284c7; border-radius: 16px; padding: 30px; margin-bottom: 24px; box-shadow: 0 10px 40px rgba(2,132,199,0.18); text-align: center; }
    .calc-grid { display: grid; grid-template-columns: 1.1fr 0.9fr; gap: 24px; }
    .form-box { background: var(--card-dark); border: 1px solid var(--border-dark); border-radius: 14px; padding: 26px; }
    .form-group { margin-bottom: 18px; }
    .form-label { display: block; font-size: 13px; font-weight: 700; color: #94a3b8; text-transform: uppercase; margin-bottom: 6px; }
    .form-control { width: 100%; box-sizing: border-box; background: #0b1120; border: 1px solid #334155; border-radius: 8px; color: #fff; padding: 12px 14px; font-size: 14px; font-weight: 600; outline: none; transition: all 0.2s; }
    .form-control:focus { border-color: #38bdf8; box-shadow: 0 0 0 3px rgba(56,189,248,0.2); }
    .btn-calc { width: 100%; background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%); color: #fff; border: none; padding: 14px; border-radius: 8px; font-size: 15px; font-weight: 800; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; justify-content: center; gap: 8px; }
    .btn-calc:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(2,132,199,0.4); }
    .result-box { background: var(--card-dark); border: 1px solid var(--border-dark); border-radius: 14px; padding: 26px; display: flex; flex-direction: column; justify-content: space-between; }
    .res-badge { display: inline-block; padding: 6px 14px; border-radius: 20px; font-size: 13px; font-weight: 800; text-transform: uppercase; margin-bottom: 12px; }
    .badge-ok { background: #064e3b; color: #34d399; border: 1px solid #059669; }
    .badge-no { background: #7f1d1d; color: #f87171; border: 1px solid #dc2626; }
    .res-metric { font-size: 34px; font-weight: 900; color: #38bdf8; margin: 4px 0; }
    .guide-box { background: #0f172a; border: 1px solid #1e293b; border-radius: 10px; padding: 18px 20px; margin-top: 18px; font-size: 13px; color: #cbd5e1; line-height: 1.6; }
    .faq-card { background: var(--card-dark); border: 1px solid #1e293b; border-radius: 12px; padding: 20px 24px; margin-top: 24px; }
    .faq-q { font-size: 15px; font-weight: 800; color: #f8fafc; margin-bottom: 8px; }
    .faq-a { font-size: 13.5px; color: #94a3b8; line-height: 1.6; margin: 0; }
    @media (max-width: 768px) {
      .calc-grid { grid-template-columns: 1fr; }
      .calc-container { padding: 14px 12px 90px 12px; }
    }
  </style>
    <link rel="alternate" type="text/markdown" href="https://www.parselsorgu.net/llms.txt" title="ParselSorgu AI / LLM Bilgi Bankası">
    <link rel="alternate" type="application/json" href="https://www.parselsorgu.net/api/2026-kadastro-endeks.json" title="2026 Kadastro ve İmar Açık Veri Seti">
    <script type="application/ld+json">{"@context": "https://schema.org", "@type": "WebPage", "speakable": {"@type": "SpeakableSpecification", "cssSelector": ["h1", ".lead", ".summary-box", ".hero-desc", "main p"]}, "isBasedOn": "https://www.parselsorgu.net/api/2026-kadastro-endeks.json", "publisher": {"@type": "Organization", "name": "Ant Harita Mühendislik - ParselSorgu.net", "url": "https://www.parselsorgu.net/"}}</script>
</head>
<body>

  <div class="calc-container">
    <div class="hero-card">
      <div style="font-size:12px; color:#38bdf8; font-weight:800; text-transform:uppercase; letter-spacing:1px; margin-bottom:6px;">
        <i class="fa fa-scale-balanced"></i> 5403 Sayılı Kanun & Tarım İl Müdürlüğü Kriterleri
      </div>
      <h1 style="font-size:26px; font-weight:900; margin:0 0 10px 0; color:#fff;">
        Tarlam Bölünür mü? Tarla İfraz Hesaplayıcı (2026)
      </h1>
      <p style="font-size:14px; color:#94a3b8; max-width:700px; margin:0 auto; line-height:1.5;">
        Arazinizin dikili, sulu veya kuru tarım vasfına göre yasal olarak kaça bölünebileceğini, asgari parsel sınırlarını ve yola cephe zorunluluklarını anında hesaplayın.
      </p>
    </div>

    <div class="calc-grid">
      <!-- FORM -->
      <div class="form-box">
        <h2 style="font-size:16px; font-weight:800; margin:0 0 18px 0; color:#fff;">
          <i class="fa fa-sliders" style="color:#38bdf8;"></i> Arazi Kriterlerini Girin
        </h2>

        <div class="form-group">
          <label class="form-label">Toplam Tarla Alanı (m²)</label>
          <input type="number" id="alan" class="form-control" value="25000" placeholder="Örn: 25000">
        </div>

        <div class="form-group">
          <label class="form-label">Tarım Arazisi Niteliği / Sınıfı</label>
          <select id="sinif" class="form-control">
            <option value="5000">Dikili Tarım (Bağ, Meyve Bahçesi, Zeytinlik - Asgari 5.000 m²)</option>
            <option value="3000">Örtü Altı Tarım (Sera Arazisi - Asgari 3.000 m²)</option>
            <option value="20000" selected>Sulu Tarım Arazisi (Asgari 20.000 m²)</option>
            <option value="20000">Kuru Tarım Arazisi (Asgari 20.000 m²)</option>
          </select>
        </div>

        <div class="form-group">
          <label class="form-label">Kadastral Yola Cephe Durumu</label>
          <select id="yol" class="form-control">
            <option value="var">Evet, Resmi Kadastral Yola Cephesi Var</option>
            <option value="yok">Hayır, Resmi Yolu Yok (Sadece Arazi Yolu / Geçit)</option>
          </select>
        </div>

        <div class="form-group">
          <label class="form-label">Köy Yerleşik Alan Durumu</label>
          <select id="koy" class="form-control">
            <option value="disinda" selected>Köy Yerleşik Alanı Dışında (Tarım Arazisi)</option>
            <option value="icinde">Köy Yerleşik Alanı ve Civarı İçinde</option>
          </select>
        </div>

        <button type="button" class="btn-calc" onclick="calculateIfraz()">
          <i class="fa fa-calculator"></i> İfraz Uygunluğunu Hesapla
        </button>
      </div>

      <!-- SONUÇ -->
      <div class="result-box">
        <div>
          <h2 style="font-size:16px; font-weight:800; margin:0 0 16px 0; color:#fff;">
            <i class="fa fa-chart-pie" style="color:#38bdf8;"></i> 5403 İfraz Değerlendirmesi
          </h2>

          <div id="resBadge" class="res-badge badge-ok">BÖLÜNEBİLİR (İFRAZ UYGUN)</div>
          
          <div style="font-size:12px; color:#94a3b8; font-weight:700; text-transform:uppercase;">Çıkabilecek Azami Parsel Sayısı</div>
          <div id="resParsel" class="res-metric">1 Parsel</div>

          <div class="guide-box" id="resAciklama">
            Girdiğiniz 25.000 m² sulu tarım arazisi, yasal asgari 20.000 m² sınırını sağladığı için 1 adet müstakil parsel olarak muhafaza edilebilir; 2 parçaya bölünemez (en az 40.000 m² gerekir).
          </div>
        </div>

        <div style="margin-top:20px;">
          <a id="btnWa" href="https://wa.me/905428413535?text=Merhaba+Ant+Harita+5403+tarla+ifraz+hesaplamam+icin+harita+muhendisligi+teklifi+almak+istiyorum." target="_blank" style="display:flex; align-items:center; justify-content:center; gap:8px; background:#22c55e; color:#fff; text-decoration:none; padding:12px; border-radius:8px; font-weight:800; font-size:14px;">
            <i class="fab fa-whatsapp"></i> Mühendisimizden İfraz Teklifi Al
          </a>
        </div>
      </div>
    </div>

    <!-- SSS SECTION -->
    <div class="faq-card">
      <div class="faq-q"><i class="fa fa-circle-question" style="color:#38bdf8;"></i> 5403 sayılı Kanun'a göre tarlamı kaça bölebilirim?</div>
      <p class="faq-a">Dikili arazilerde en az 5 dönüm (5.000 m²), seralarda 3 dönüm (3.000 m²), sulu ve kuru tarım arazilerinde ise en az 20 dönüm (20.000 m²) parsel büyüklüğü şartı aranır. Örneğin 35.000 m² sulu tarla 2 parçaya bölünemez; en az 40.000 m² olmalıdır.</p>
    </div>

    <div class="faq-card">
      <div class="faq-q"><i class="fa fa-circle-question" style="color:#38bdf8;"></i> Yolu olmayan tarla bölünebilir mi?</div>
      <p class="faq-a">Hayır. 3194 ve 5403 sayılı kanunlar gereği ifraz edilecek her yeni parselin resmi kadastral yola en az 25 metre cephesi bulunması zorunludur. Kadastral yolu olmayan parseller ifraz edilemez.</p>
    </div>
  </div>

  <script>
    function calculateIfraz() {
      const alan = parseFloat(document.getElementById('alan').value) || 0;
      const minLimit = parseFloat(document.getElementById('sinif').value) || 20000;
      const yol = document.getElementById('yol').value;
      const koy = document.getElementById('koy').value;

      const badge = document.getElementById('resBadge');
      const parselVal = document.getElementById('resParsel');
      const aciklama = document.getElementById('resAciklama');

      if (koy === 'icinde') {
        badge.className = 'res-badge badge-ok';
        badge.innerText = 'KÖY YERLEŞİK ALANINDA (AVANTAJLI)';
        const tahmini = Math.max(1, Math.floor(alan / 1000));
        parselVal.innerText = tahmini + ' Parsel Çıkabilir';
        aciklama.innerHTML = 'Köy yerleşik alanı içindeki parsellerde 5403 tarım kısıtlamaları yerine <strong>Plansız Alanlar İmar Yönetmeliği</strong> uygulanır. Kadastral yola cephe varsa ve köy dokusuna uygunsa köy içi parseller daha küçük ebatlarda (min 500-1000 m²) bölünebilir.';
        return;
      }

      if (yol === 'yok') {
        badge.className = 'res-badge badge-no';
        badge.innerText = 'YOL OLMADIĞI İÇİN İFRAZ EDİLEMEZ';
        parselVal.innerText = '0 Parsel (Bölünemez)';
        aciklama.innerHTML = 'Kadastral yola cephesi olmayan taşınmazlarda <strong>ifraz ve parselasyon işlemi yapılamaz</strong>. Öncelikle komşu parsellerden resmi geçit hakkı tesis edilmesi veya kadastro yolu ihdas edilmesi gerekmektedir.';
        return;
      }

      const parselSayisi = Math.floor(alan / minLimit);

      if (parselSayisi >= 2) {
        badge.className = 'res-badge badge-ok';
        badge.innerText = 'BÖLÜNEBİLİR (İFRAZ UYGUN)';
        parselVal.innerText = parselSayisi + ' Yeni Parsel';
        const kalan = alan % minLimit;
        aciklama.innerHTML = 'Girdiğiniz ' + alan.toLocaleString('tr-TR') + ' m² arazi, asgari ' + minLimit.toLocaleString('tr-TR') + ' m² şartını sağlamakta olup azami <strong>' + parselSayisi + ' bağımsız parsele</strong> ifraz edilebilir. Artık kalan alan: ' + kalan.toLocaleString('tr-TR') + ' m². İl Tarım Müdürlüğü ve Kadastro onayına tabidir.';
      } else if (parselSayisi === 1) {
        badge.className = 'res-badge badge-ok';
        badge.innerText = 'MÜSTAKİL KORUNUR (BÖLÜNEMEZ)';
        parselVal.innerText = '1 Parsel (Tek Parça)';
        aciklama.innerHTML = 'Taşınmaz mevcut haliyle asgari büyüklük şartını sağlamaktadır ancak 2 parçaya bölünemez. İki parçaya bölünebilmesi için arazinin en az <strong>' + (minLimit * 2).toLocaleString('tr-TR') + ' m²</strong> büyüklüğe ulaşması gerekir.';
      } else {
        badge.className = 'res-badge badge-no';
        badge.innerText = 'YASAL LİMİT ALTI (BÖLÜNEMEZ)';
        parselVal.innerText = 'Bölünemez (Hisseli)';
        aciklama.innerHTML = 'Taşınmaz büyüklüğü (' + alan.toLocaleString('tr-TR') + ' m²), bu arazi sınıfı için aranan asgari sınırın (' + minLimit.toLocaleString('tr-TR') + ' m²) altındadır. Taşınmaz tek parça olarak kullanılabilir veya hisseli olarak devredilebilir; ifraz yoluyla ayrı tapulara bölünemez.';
      }
    }
  </script>

</body>
</html>
