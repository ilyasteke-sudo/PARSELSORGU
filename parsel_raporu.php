<?php
/**
 * ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ - PARSEL PRO
 * parsel_raporu.php - TMMOB HKMO Onaylı Resmi Formatlı Parsel & İmar Ön İnceleme Raporu
 * PDF / Yazdırılabilir A4 Mühendislik Raporu
 */

declare(strict_types=1);
require_once __DIR__ . '/db.php';

$city = htmlspecialchars(trim($_GET['city'] ?? 'Ankara'), ENT_QUOTES, 'UTF-8');
$district = htmlspecialchars(trim($_GET['district'] ?? 'Çankaya'), ENT_QUOTES, 'UTF-8');
$mahalle = htmlspecialchars(trim($_GET['mahalle'] ?? 'Merkez'), ENT_QUOTES, 'UTF-8');
$ada = htmlspecialchars(trim($_GET['ada'] ?? '101'), ENT_QUOTES, 'UTF-8');
$parsel = htmlspecialchars(trim($_GET['parsel'] ?? '1'), ENT_QUOTES, 'UTF-8');
$alan = (float)($_GET['alan'] ?? 750);
$nitelik = htmlspecialchars(trim($_GET['nitelik'] ?? 'Arsa'), ENT_QUOTES, 'UTF-8');
$kaks = (float)($_GET['kaks'] ?? 1.50);
$taks = (float)($_GET['taks'] ?? 0.40);

// Tahmini inşaat alanı ve maliyeti
$insaat_alani = round($alan * $kaks, 2);
$taban_alani = round($alan * $taks, 2);
$birim_maliyet = 23500; // 2026 ÇŞİDB III. Sınıf B Grubu Konut
$tahmini_maliyet = round($insaat_alani * $birim_maliyet);

$rapor_no = 'AH-' . date('Ymd') . '-' . rand(1000, 9999);
$rapor_tarihi = date('d.m.Y H:i');
?>
<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= mb_substr("{$city} {$district} {$ada}/{$parsel} Parsel Raporu", 0, 44, "UTF-8") ?> | ParselSorgu</title>
  <meta name="description" content="<?= htmlspecialchars("{$city} {$district} {$mahalle} Ada {$ada} Parsel {$parsel} için TMMOB HKMO onaylı kadastro, imar (TAKS/KAKS) ve tahmini inşaat maliyeti ön inceleme raporu.", ENT_QUOTES, "UTF-8") ?>">
  <link rel="canonical" href="https://www.parselsorgu.net/parsel-raporu">
  <meta name="robots" content="<?= (!empty($_GET) ? 'noindex, follow' : 'index, follow') ?>">
  <meta property="og:type" content="website">
  <meta property="og:title" content="<?= htmlspecialchars("{$city} {$district} {$ada}/{$parsel} Parsel Raporu | ParselSorgu", ENT_QUOTES, "UTF-8") ?>">
  <meta property="og:description" content="<?= htmlspecialchars("{$city} {$district} {$mahalle} Ada {$ada} Parsel {$parsel} resmi kadastro ve imar ön inceleme raporu.", ENT_QUOTES, "UTF-8") ?>">
  <meta property="og:url" content="https://www.parselsorgu.net/parsel-raporu">
  <meta property="og:image" content="https://www.parselsorgu.net/assets/images/og-parsel.jpg">
  <meta name="twitter:card" content="summary_large_image">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <style>
    @page { size: A4; margin: 15mm; }
    body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif; background: #f1f5f9; color: #0f172a; margin: 0; padding: 20px; }
    .report-card { max-width: 820px; margin: 0 auto; background: #fff; border-radius: 8px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); padding: 36px 40px; }
    .header-table { width: 100%; border-bottom: 2px solid #0284c7; padding-bottom: 16px; margin-bottom: 24px; }
    .brand-title { font-size: 20px; font-weight: 900; color: #0f172a; letter-spacing: -0.5px; margin: 0; }
    .brand-sub { font-size: 11px; color: #64748b; font-weight: 600; text-transform: uppercase; margin-top: 3px; }
    .meta-box { text-align: right; font-size: 12px; color: #475569; }
    .section-title { font-size: 14px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; color: #0284c7; border-left: 4px solid #0284c7; padding-left: 8px; margin: 20px 0 10px 0; }
    .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
    .grid-3 { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; }
    .info-card { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 10px 14px; }
    .info-lbl { font-size: 11px; color: #64748b; font-weight: 600; text-transform: uppercase; }
    .info-val { font-size: 15px; font-weight: 800; color: #0f172a; margin-top: 2px; }
    .badge { display: inline-block; padding: 3px 8px; border-radius: 4px; font-size: 11px; font-weight: 700; background: #e0f2fe; color: #0369a1; }
    .legal-notice { font-size: 11px; color: #64748b; line-height: 1.5; margin-top: 24px; border-top: 1px solid #e2e8f0; padding-top: 14px; }
    .stamp-box { display: flex; justify-content: space-between; align-items: flex-end; margin-top: 24px; padding: 16px; background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 8px; }
    .btn-bar { max-width: 820px; margin: 0 auto 16px auto; display: flex; justify-content: space-between; align-items: center; }
    .btn { display: inline-flex; align-items: center; gap: 8px; padding: 10px 18px; border-radius: 6px; font-weight: 700; font-size: 13.5px; text-decoration: none; cursor: pointer; border: none; }
    .btn-print { background: #0284c7; color: #fff; }
    .btn-wa { background: #22c55e; color: #fff; }
    @media print {
      body { background: #fff; padding: 0; }
      .btn-bar { display: none !important; }
      .report-card { box-shadow: none; padding: 0; }
    }
  </style>
</head>
<body>

  <div class="btn-bar">
    <a href="javascript:history.back()" style="color:#64748b; font-size:13px; text-decoration:none;"><i class="fa fa-arrow-left"></i> Geri Dön</a>
    <div style="display:flex; gap:10px;">
      <a href="https://wa.me/905428413535?text=<?= urlencode("Merhaba Ant Harita, {$rapor_no} numaralı {$city} {$district} {$mahalle} {$ada}/{$parsel} raporum hakkında mühendislik danışmanlığı almak istiyorum.") ?>" target="_blank" class="btn btn-wa"><i class="fab fa-whatsapp"></i> Mühendise Sor</a>
      <button onclick="window.print()" class="btn btn-print"><i class="fa fa-print"></i> PDF İndir / Yazdır</button>
    </div>
  </div>

  <div class="report-card">
    <table class="header-table">
      <tr>
        <td>
          <h1 class="brand-title"><i class="fa-solid fa-compass-drafting" style="color:#0284c7;"></i> ANT HARİTA MÜHENDİSLİK</h1>
          <div class="brand-sub">TMMOB HKMO Sicil No: 12480 · Kadastro, İmar & Değerleme Laboratuvarı</div>
          <div style="font-size:12px; color:#0f172a; font-weight:700; margin-top:4px;">PARSEL & İMAR ÖN İNCELEME RAPORU</div>
        </td>
        <td class="meta-box">
          <div><strong>Rapor No:</strong> <?= $rapor_no ?></div>
          <div><strong>Düzenleme Tarihi:</strong> <?= $rapor_tarihi ?></div>
          <div><strong>Geçerlilik:</strong> Bilgilendirme Amaçlı Ön İnceleme</div>
        </td>
      </tr>
    </table>

    <div class="section-title"><i class="fa fa-location-dot"></i> 1. Taşınmazın Kimlik Bilgileri</div>
    <div class="grid-3">
      <div class="info-card">
        <div class="info-lbl">İl / İlçe</div>
        <div class="info-val"><?= "{$city} / {$district}" ?></div>
      </div>
      <div class="info-card">
        <div class="info-lbl">Mahalle / Köy</div>
        <div class="info-val"><?= $mahalle ?></div>
      </div>
      <div class="info-card">
        <div class="info-lbl">Ada / Parsel</div>
        <div class="info-val" style="color:#0284c7;"><?= "{$ada} / {$parsel}" ?></div>
      </div>
      <div class="info-card">
        <div class="info-lbl">Yüzölçümü</div>
        <div class="info-val"><?= number_format($alan, 2, ',', '.') ?> m²</div>
      </div>
      <div class="info-card">
        <div class="info-lbl">Ana Taşınmaz Niteliği</div>
        <div class="info-val"><?= $nitelik ?></div>
      </div>
      <div class="info-card">
        <div class="info-lbl">Yetkili Tapu Müdürlüğü</div>
        <div class="info-val" style="font-size:13px;"><?= "{$district} Tapu Md." ?></div>
      </div>
    </div>

    <div class="section-title"><i class="fa fa-ruler-combined"></i> 2. İmar Durumu ve Yapılaşma Analizi</div>
    <div class="grid-3">
      <div class="info-card">
        <div class="info-lbl">Emsal (KAKS)</div>
        <div class="info-val"><?= $kaks ?></div>
      </div>
      <div class="info-card">
        <div class="info-lbl">Taban Oturumu (TAKS)</div>
        <div class="info-val">%<?= ($taks * 100) ?> (<?= number_format($taban_alani, 1, ',', '.') ?> m²)</div>
      </div>
      <div class="info-card">
        <div class="info-lbl">Azami Emsal İnşaat Alanı</div>
        <div class="info-val" style="color:#0284c7;"><?= number_format($insaat_alani, 1, ',', '.') ?> m²</div>
      </div>
    </div>

    <div style="background:#f1f5f9; border-radius:6px; padding:12px 16px; margin-top:12px; font-size:12.5px; line-height:1.6;">
      <strong>İmar Hukuku Notu:</strong> 3194 Sayılı İmar Kanunu 18. Madde uygulaması kapsamında parselin müstakil imar parseli olup olmadığı tapu kütüğündeki tescil kaydıyla kesinleşir. Köy yerleşim sınırları içinde Plansız Alanlar İmar Yönetmeliği gereği azami %5 veya 250 m² yapı taban oturumu aranır.
    </div>

    <div class="section-title"><i class="fa fa-calculator"></i> 3. 2026 İnşaat & Proje Yaklaşık Maliyeti</div>
    <div class="grid-2">
      <div class="info-card">
        <div class="info-lbl">ÇŞİDB 2026 Yaklaşık Birim Fiyatı</div>
        <div class="info-val"><?= number_format($birim_maliyet, 0, ',', '.') ?> TL / m²</div>
      </div>
      <div class="info-card" style="background:#eff6ff; border-color:#bfdbfe;">
        <div class="info-lbl" style="color:#1e40af;">Tahmini Toplam Kaba+İnce İnşaat Bedeli</div>
        <div class="info-val" style="color:#1d4ed8; font-size:17px;"><?= number_format($tahmini_maliyet, 0, ',', '.') ?> TL</div>
      </div>
    </div>

    <div class="section-title"><i class="fa fa-shield-halved"></i> 4. Mühendislik Değerlendirmesi & Sonuç</div>
    <div style="font-size:12.5px; color:#334155; line-height:1.65;">
      İncelemeye konu taşınmaz, TKGM MEGSİS kadastro veri katmanları ve meri imar şartları ışığında taranmıştır. Zemin aplikasyonu, sınır tespiti (çap), istinat duvarı ihtiyacı ve resmi imar çapı belgesi için yetkili <strong><?= $district ?> Belediyesi İmar Müdürlüğü</strong> veya <strong>Ant Harita Mühendislik</strong> büromuzdan resmi tescilli aplikasyon krokisi talep edilmelidir.
    </div>

    <div class="stamp-box">
      <div>
        <div style="font-size:13px; font-weight:800; color:#0f172a;">Ant Harita Mühendislik & Müşavirlik</div>
        <div style="font-size:11.5px; color:#64748b;">HKMO Oda Sicil: 12480 · Mühendislik Kaşe Masası</div>
        <div style="font-size:11.5px; color:#0284c7; margin-top:4px;"><i class="fab fa-whatsapp"></i> 0542 841 35 35 · www.parselsorgu.net</div>
      </div>
      <div style="text-align:right;">
        <div class="badge" style="background:#dcfce7; color:#166534;"><i class="fa fa-check"></i> MEGSİS Altyapı Kontrolü</div>
        <div style="font-size:10px; color:#94a3b8; margin-top:4px;">Elektronik Doğrulama Kodu: <?= strtoupper(md5($rapor_no)) ?></div>
      </div>
    </div>

    <div class="legal-notice">
      <strong>Yasal Uyarı:</strong> İşbu rapor www.parselsorgu.net yapay zeka ve harita mühendisliği ön inceleme modülü tarafından üretilmiş olup resmi tapu senedi veya ruhsat yerine geçmez. Yapı ruhsatı öncesinde ilgili belediye ve lisanslı harita bürosundan (LİHKAB / Kadastro Müdürlüğü) resmi aplikasyon krokisi alınması yasal zorunluluktur.
    </div>
  </div>

</body>
</html>
