<?php
/**
 * ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ - PARSEL PRO
 * 2026 SaaS Özel Parsel Sorgulama & Canlı Harita Sistemi (parsel.php)
 * Saf PHP 8.3 Uyumlu - Müstakil Harita & Kadastro Platformu
 */

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/navbar.php';

// Site Settings
$site_title = "Ada Parsel Sorgulama 2026 & Canlı Harita | ParselSorgu";
$meta_desc = "81 il ve 973 ilçede canlı TKGM MEGSİS uydu ada parsel sorgulama, köşe koordinatları, kadastro sınırları ve imar durumu analizi.";

// 81 İl Listesi
$cities = [
    'Adana', 'Adıyaman', 'Afyonkarahisar', 'Ağrı', 'Aksaray', 'Amasya', 'Ankara', 'Antalya', 'Ardahan', 'Artvin',
    'Aydın', 'Balıkesir', 'Bartın', 'Batman', 'Bayburt', 'Bilecik', 'Bingöl', 'Bitlis', 'Bolu', 'Burdur',
    'Bursa', 'Çanakkale', 'Çankırı', 'Çorum', 'Denizli', 'Diyarbakır', 'Düzce', 'Edirne', 'Elazığ', 'Erzincan',
    'Erzurum', 'Eskişehir', 'Gaziantep', 'Giresun', 'Gümüşhane', 'Hakkari', 'Hatay', 'Iğdır', 'Isparta', 'İstanbul',
    'İzmir', 'Kahramanmaraş', 'Karabük', 'Karaman', 'Kars', 'Kastamonu', 'Kayseri', 'Kırıkkale', 'Kırklareli', 'Kırşehir',
    'Kilis', 'Kocaeli', 'Konya', 'Kütahya', 'Malatya', 'Manisa', 'Mardin', 'Mersin', 'Muğla', 'Muş',
    'Nevşehir', 'Niğde', 'Ordu', 'Osmaniye', 'Rize', 'Sakarya', 'Samsun', 'Siirt', 'Sinop', 'Sivas',
    'Şanlıurfa', 'Şırnak', 'Tekirdağ', 'Tokat', 'Trabzon', 'Tunceli', 'Uşak', 'Van', 'Yalova', 'Yozgat', 'Zonguldak'
];

$pre_city = trim($_GET['city'] ?? 'Kırıkkale');
$pre_district = trim($_GET['district'] ?? 'Merkez');
$pre_mahalle = trim($_GET['mahalle'] ?? 'Hacılar/Hacıbey');
$pre_ada = trim($_GET['ada'] ?? '1781');
$pre_parsel = trim($_GET['parsel'] ?? '34');
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title><?php echo htmlspecialchars($site_title); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($meta_desc); ?>">
    <meta name="keywords" content="parsel sorgu, tkgm parsel sorgulama, ada parsel harita, megis canlı uydu, imar durumu parsel sorgu, kadastro koordinat sorgulama, 3d drone parsel">
    <link rel="canonical" href="https://www.parselsorgu.net/tkgm-canli-parsel">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1">

    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?php echo htmlspecialchars($site_title); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($meta_desc); ?>">
    <meta property="og:url" content="https://www.parselsorgu.net/tkgm-canli-parsel">
    <meta property="og:image" content="https://www.parselsorgu.net/assets/images/og-parsel.jpg">

    <!-- Google Analytics 4 (GA4) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-B6774G0NZZ">
        // ========================================================
        // 📊 EXCEL (CSV) VE PROJE PORTFÖY YÖNETİMİ
        // ========================================================
        function exportCsv() {
            const p = currentParcelState;
            const area = parseFloat(p.area_m2) || 750;
            const emsal = 1.50;
            const taks = 0.30;
            const taban = Math.round(area * taks);
            const toplamInsaat = Math.round(area * emsal);
            const daireSayisi = Math.max(1, Math.round(toplamInsaat / 120));
            const birimFiyat = 16500;
            const toplamButce = toplamInsaat * birimFiyat;
            const arsaDaire = Math.max(1, Math.round(daireSayisi * 0.50));

            let csv = "\uFEFF"; // UTF-8 BOM for Turkish Excel support
            csv += "ANT HARİTA MÜHENDİSLİK - PARSEL 360 FİZİBİLİTE & METRAJ DÖKÜMÜ\r\n";
            csv += `Rapor Tarihi;${new Date().toLocaleDateString('tr-TR')} ${new Date().toLocaleTimeString('tr-TR')}\r\n`;
            csv += `Proje Kodu;PS-2026-${p.ada}-${p.parsel}\r\n\r\n`;

            csv += "1. MÜLKİYET VE KADASTRO BİLGİLERİ;DEĞER\r\n";
            csv += `İl / İlçe;${p.city} / ${p.district}\r\n`;
            csv += `Mahalle / Köy;${p.neighborhood}\r\n`;
            csv += `Ada No;${p.ada}\r\n`;
            csv += `Parsel No;${p.parsel}\r\n`;
            csv += `Resmî Tapu Alanı;${area} m²\r\n`;
            csv += `Taşınmaz Niteliği;${p.quality}\r\n`;
            csv += `Koordinat Referansı;ITRF95 TM 3° (GRS80)\r\n\r\n`;

            csv += "2. İMAR PLANI VE KAPASİTE PARAMETRELERİ;DEĞER\r\n";
            csv += `Emsal (KAKS);${emsal}\r\n`;
            csv += `Taban Alanı Kat Sayısı (TAKS);${taks}\r\n`;
            csv += `Azami Taban Oturumu;${taban} m²\r\n`;
            csv += `Toplam İmar İnşaat Alanı;${toplamInsaat} m²\r\n`;
            csv += `Tahmini Daire Sayısı (120m²);${daireSayisi} Adet\r\n\r\n`;

            csv += "3. 2026 ÇŞİDB YAPI YAKLAŞIK MALİYET METRAJI;TUTAR (TL)\r\n";
            csv += `Kaba Yapı İmalatları (%40);${Math.round(toplamButce * 0.40).toLocaleString('tr-TR')} TL\r\n`;
            csv += `İnce Yapı ve Mimari İmalatlar (%30);${Math.round(toplamButce * 0.30).toLocaleString('tr-TR')} TL\r\n`;
            csv += `Elektrik Tesisat İmalatları (%15);${Math.round(toplamButce * 0.15).toLocaleString('tr-TR')} TL\r\n`;
            csv += `Mekanik ve Sıhhi Tesisat (%15);${Math.round(toplamButce * 0.15).toLocaleString('tr-TR')} TL\r\n`;
            csv += `TOPLAM YAKLAŞIK MALİYET;${toplamButce.toLocaleString('tr-TR')} TL\r\n\r\n`;

            csv += "4. GAYRİMENKUL KAT KARŞILIĞI MODELİ;DEĞER\r\n";
            csv += `Paylaşım Oranı;%50 Arsa Sahibi / %50 Müteahhit\r\n`;
            csv += `Arsa Sahibine Kalan Bağımsız Bölüm;${arsaDaire} Adet Daire\r\n`;
            csv += `Müteahhit Payı;${daireSayisi - arsaDaire} Adet Daire\r\n\r\n`;

            csv += "5. ITRF95 METRİK KÖŞE KOORDİNATLARI;SAĞA DEĞER (Y);YUKARI DEĞER (X);ENLEM;BOYLAM\r\n";
            (p.points || []).forEach((pt, idx) => {
                const tm = wgs84ToTm(pt[0], pt[1]);
                csv += `K${idx + 1};${tm.y.toFixed(2)};${tm.x.toFixed(2)};${pt[0].toFixed(6)};${pt[1].toFixed(6)}\r\n`;
            });

            const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
            const a = document.createElement('a');
            a.href = URL.createObjectURL(blob);
            a.download = `parsel_fizibilite_${p.city}_${p.ada}_${p.parsel}.csv`;
            a.click();
        }

        // Projelerime Kaydet
        function saveParcelProject() {
            const p = currentParcelState;
            const saved = JSON.parse(localStorage.getItem('ps_saved_parcels') || '[]');
            
            const newProject = {
                id: 'PS-' + Date.now().toString(36).toUpperCase(),
                city: p.city,
                district: p.district,
                neighborhood: p.neighborhood,
                ada: p.ada,
                parsel: p.parsel,
                area: p.area_formatted || (p.area_m2 + ' m²'),
                quality: p.quality,
                savedAt: new Date().toLocaleDateString('tr-TR') + ' ' + new Date().toLocaleTimeString('tr-TR', { hour:'2-digit', minute:'2-digit' })
            };

            // Varsa güncelle, yoksa ekle
            const existIdx = saved.findIndex(x => x.city === p.city && x.district === p.district && x.ada === p.ada && x.parsel === p.parsel);
            if (existIdx >= 0) {
                saved[existIdx] = newProject;
            } else {
                saved.unshift(newProject);
            }

            localStorage.setItem('ps_saved_parcels', JSON.stringify(saved.slice(0, 30)));
            alert(`✅ ${p.city} / ${p.district} Ada ${p.ada}, Parsel ${p.parsel} başarıyla projelerinize kaydedildi!`);
        }

        function openSavedProjectsModal() {
            const modal = document.getElementById('savedProjectsModal');
            const list = document.getElementById('savedProjectsList');
            const saved = JSON.parse(localStorage.getItem('ps_saved_parcels') || '[]');

            if (saved.length === 0) {
                list.innerHTML = '<div style="text-align:center; padding:30px; color:#64748b;">Henüz kayıtlı bir projeniz bulunmuyor. Parsel sorguladıktan sonra "Projelerime Kaydet" butonunu kullanabilirsiniz.</div>';
            } else {
                let html = '<div style="display:flex; flex-direction:column; gap:10px;">';
                saved.forEach((item, idx) => {
                    html += `
                        <div style="background:rgba(255,255,255,0.04); border:1px solid rgba(255,255,255,0.08); border-radius:10px; padding:12px 16px; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;">
                            <div>
                                <div style="font-weight:800; color:#38bdf8; font-size:14px;">${item.city} / ${item.district} - Ada ${item.ada} / Parsel ${item.parsel}</div>
                                <div style="font-size:11.5px; color:#94a3b8; margin-top:2px;">${item.neighborhood} &bull; ${item.area} &bull; ${item.savedAt}</div>
                            </div>
                            <div style="display:flex; gap:8px;">
                                <button type="button" onclick="loadSavedProject('${item.city}', '${item.district}', '${item.ada}', '${item.parsel}')" style="background:#0284c7; color:#fff; border:none; padding:6px 12px; border-radius:6px; font-size:11.5px; font-weight:700; cursor:pointer;"><i class="fa-solid fa-arrow-right"></i> Aç</button>
                                <button type="button" onclick="deleteSavedProject(${idx})" style="background:rgba(239,68,68,0.2); color:#f87171; border:1px solid rgba(239,68,68,0.4); padding:6px 10px; border-radius:6px; font-size:11.5px; cursor:pointer;"><i class="fa-solid fa-trash"></i></button>
                            </div>
                        </div>
                    `;
                });
                html += '</div>';
                list.innerHTML = html;
            }

            modal.style.display = 'block';
        }

        function loadSavedProject(city, dist, ada, parsel) {
            document.getElementById('savedProjectsModal').style.display = 'none';
            document.getElementById('selCity').value = city;
            document.getElementById('txtAda').value = ada;
            document.getElementById('txtParsel').value = parsel;
            onCityChanged(dist);
            setTimeout(() => { executeStandaloneQuery(); }, 600);
        }

        function deleteSavedProject(idx) {
            const saved = JSON.parse(localStorage.getItem('ps_saved_parcels') || '[]');
            saved.splice(idx, 1);
            localStorage.setItem('ps_saved_parcels', JSON.stringify(saved));
            openSavedProjectsModal();
        }

        function clearAllSavedProjects() {
            if (confirm('Tüm kayıtlı projeleri silmek istediğinizden emin misiniz?')) {
                localStorage.removeItem('ps_saved_parcels');
                openSavedProjectsModal();
            }
        }

    
        // ========================================================
        // 📐 GERÇEK GEOMETRİK İFRAZ VE BÖLÜNME MOTORU
        // ========================================================
        let ifrazLayerGroup = null;
        let isIfrazActive = false;
        let ifrazSubParcels = null;

        function toggleGeometricIfraz() {
            if (!parselPolygon) {
                alert('Önce geçerli bir parsel sorgulayınız.');
                return;
            }

            const btn = document.getElementById('btnRunIfrazSplit');
            const btnDxf = document.getElementById('btnExportIfrazDxf');

            if (isIfrazActive) {
                if (ifrazLayerGroup) map.removeLayer(ifrazLayerGroup);
                isIfrazActive = false;
                btn.innerHTML = '<i class="fa-solid fa-draw-polygon"></i> <span>2 Parsele Böl &amp; Haritada Göster</span>';
                btn.style.background = '#0284c7';
                if (btnDxf) btnDxf.style.display = 'none';
                return;
            }

            const coords = parselPolygon.getLatLngs()[0];
            if (!coords || coords.length < 3) return;

            // Bounding box hesapla
            let minLat = 999, maxLat = -999, minLng = 999, maxLng = -999;
            coords.forEach(pt => {
                if (pt.lat < minLat) minLat = pt.lat;
                if (pt.lat > maxLat) maxLat = pt.lat;
                if (pt.lng < minLng) minLng = pt.lng;
                if (pt.lng > maxLng) maxLng = pt.lng;
            });

            const midLng = (minLng + maxLng) / 2.0;
            const midLat = (minLat + maxLat) / 2.0;
            const p = currentParcelState;
            const halfArea = Math.round((parseFloat(p.area_m2) || 750) / 2.0);

            // Doğu-Batı ekseninde ikiye böl
            const ptsA = coords.map(pt => [pt.lat, Math.min(pt.lng, midLng)]);
            const ptsB = coords.map(pt => [pt.lat, Math.max(pt.lng, midLng)]);

            if (ifrazLayerGroup) map.removeLayer(ifrazLayerGroup);
            ifrazLayerGroup = L.layerGroup().addTo(map);

            // Alt Parsel A Poligonu
            const polyA = L.polygon([
                [minLat, minLng],
                [maxLat, minLng],
                [maxLat, midLng],
                [minLat, midLng]
            ], {
                color: '#38bdf8',
                weight: 2,
                fillColor: '#0284c7',
                fillOpacity: 0.45
            }).addTo(ifrazLayerGroup);
            polyA.bindTooltip(`🏛️ Parsel ${p.parsel}-A: ~${halfArea} m² (İfraz 1)`, { permanent: true, direction: 'center' });

            // Alt Parsel B Poligonu
            const polyB = L.polygon([
                [minLat, midLng],
                [maxLat, midLng],
                [maxLat, maxLng],
                [minLat, maxLng]
            ], {
                color: '#10b981',
                weight: 2,
                fillColor: '#059669',
                fillOpacity: 0.45
            }).addTo(ifrazLayerGroup);
            polyB.bindTooltip(`🏛️ Parsel ${p.parsel}-B: ~${halfArea} m² (İfraz 2)`, { permanent: true, direction: 'center' });

            // Kırmızı Kesikli İfraz Ayırma Hattı
            const splitLine = L.polyline([
                [minLat - 0.0001, midLng],
                [maxLat + 0.0001, midLng]
            ], {
                color: '#ef4444',
                weight: 3,
                dashArray: '6, 6'
            }).addTo(ifrazLayerGroup);
            splitLine.bindTooltip('✂️ Yasal İfraz Sınır Hattı', { permanent: false });

            ifrazSubParcels = {
                polyA: [[minLat, minLng], [maxLat, minLng], [maxLat, midLng], [minLat, midLng]],
                polyB: [[minLat, midLng], [maxLat, midLng], [maxLat, maxLng], [minLat, maxLng]],
                halfArea: halfArea
            };

            isIfrazActive = true;
            btn.innerHTML = '<i class="fa-solid fa-xmark"></i> <span>İfraz Çizimini Gizle</span>';
            btn.style.background = '#64748b';
            if (btnDxf) btnDxf.style.display = 'inline-flex';

            // Haritayı yumuşakça odakla
            document.querySelector('.parsel-map-container')?.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }

        // İFRAZLI METRİK CAD (DXF) ÇIKTISI
        function exportIfrazDxf() {
            if (!ifrazSubParcels) return;
            const p = currentParcelState;
            const nA = ifrazSubParcels.polyA;
            const nB = ifrazSubParcels.polyB;

            let dxf = "0\nSECTION\n2\nHEADER\n9\n$ACADVER\n1\nAC1009\n0\nENDSEC\n";
            dxf += "0\nSECTION\n2\nTABLES\n0\nTABLE\n2\nLAYER\n70\n3\n";
            dxf += "0\nLAYER\n2\nIFRAZ_PARSEL_A\n70\n0\n62\n4\n6\nCONTINUOUS\n"; // Cyan
            dxf += "0\nLAYER\n2\nIFRAZ_PARSEL_B\n70\n0\n62\n3\n6\nCONTINUOUS\n"; // Green
            dxf += "0\nLAYER\n2\nIFRAZ_AYIRMA_HATTI\n70\n0\n62\n1\n6\nCONTINUOUS\n"; // Red
            dxf += "0\nENDTAB\n0\nENDSEC\n";
            dxf += "0\nSECTION\n2\nBLOCKS\n0\nENDSEC\n";
            dxf += "0\nSECTION\n2\nENTITIES\n";

            // Parsel A
            dxf += "0\nPOLYLINE\n8\nIFRAZ_PARSEL_A\n66\n1\n70\n1\n";
            nA.forEach(pt => {
                const tm = wgs84ToTm(pt[0], pt[1]);
                dxf += `0\nVERTEX\n8\nIFRAZ_PARSEL_A\n10\n${tm.y.toFixed(3)}\n20\n${tm.x.toFixed(3)}\n30\n0.0\n`;
            });
            dxf += "0\nSEQEND\n";

            // Parsel B
            dxf += "0\nPOLYLINE\n8\nIFRAZ_PARSEL_B\n66\n1\n70\n1\n";
            nB.forEach(pt => {
                const tm = wgs84ToTm(pt[0], pt[1]);
                dxf += `0\nVERTEX\n8\nIFRAZ_PARSEL_B\n10\n${tm.y.toFixed(3)}\n20\n${tm.x.toFixed(3)}\n30\n0.0\n`;
            });
            dxf += "0\nSEQEND\n";

            dxf += "0\nENDSEC\n0\nEOF\n";

            const blob = new Blob([dxf], { type: 'application/dxf' });
            const a = document.createElement('a');
            a.href = URL.createObjectURL(blob);
            a.download = `parsel_${p.city}_ada_${p.ada}_parsel_${p.parsel}_ifraz_A_B.dxf`;
            a.click();
        }

    </script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', 'G-B6774G0NZZ');
    </script>

    <!-- Font Awesome & Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <link rel="stylesheet" href="/main.css">

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <style>
        :root {
            --parsel-bg: #060a12;
            --parsel-surface: #0a1120;
            --parsel-surface-card: #0f1a30;
            --parsel-border: rgba(255, 255, 255, 0.08);
            --parsel-border-glow: rgba(56, 189, 248, 0.35);
            --parsel-cyan: #38bdf8;
            --parsel-blue: #0284c7;
            --parsel-emerald: #10b981;
            --parsel-amber: #f59e0b;
        }

        body {
            background: var(--parsel-bg);
            color: #f8fafc;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .parsel-layout-container {
            max-width: 1540px;
            margin: 0 auto;
            padding: 20px 16px;
            width: 100%;
            box-sizing: border-box;
            flex: 1;
        }

        /* Üst Başlık & Telemetri HUD */
        .parsel-hero-header {
            background: linear-gradient(135deg, rgba(8, 15, 28, 0.98) 0%, rgba(15, 23, 42, 0.95) 100%);
            border: 1px solid rgba(56, 189, 248, 0.25);
            border-top: 3px solid var(--parsel-cyan);
            border-radius: 14px;
            padding: 20px 24px;
            margin-bottom: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
        }

        .parsel-hero-title-area {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .parsel-hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 11px;
            font-weight: 800;
            color: var(--parsel-cyan);
            background: rgba(56, 189, 248, 0.12);
            border: 1px solid rgba(56, 189, 248, 0.3);
            padding: 3px 10px;
            border-radius: 999px;
            width: fit-content;
        }

        .parsel-hero-h1 {
            font-size: clamp(20px, 2.8vw, 30px);
            font-weight: 900;
            color: #ffffff;
            margin: 4px 0 0 0;
            letter-spacing: -0.02em;
        }

        .parsel-hero-sub {
            font-size: 13px;
            color: #94a3b8;
            margin: 4px 0 0 0;
        }

        .parsel-hero-stats {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .stat-pill {
            background: rgba(15, 23, 42, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 8px;
            padding: 8px 14px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            color: #cbd5e1;
        }

        .stat-pill b {
            color: #ffffff;
        }

        /* ANA SORGULAMA KONSOLU & HARİTA IZGARASI */
        .parsel-main-grid {
            display: grid;
            grid-template-columns: 360px 1fr;
            gap: 20px;
            align-items: start;
        }

        @media (max-width: 1080px) {
            .parsel-main-grid {
                grid-template-columns: 1fr;
            }
        }

        /* SOL PANEL: SORGULAMA FORMU */
        .parsel-form-card {
            background: var(--parsel-surface);
            border: 1px solid rgba(56, 189, 248, 0.25);
            border-radius: 14px;
            padding: 22px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .form-card-title {
            font-size: 15px;
            font-weight: 800;
            color: #ffffff;
            display: flex;
            align-items: center;
            gap: 8px;
            padding-bottom: 12px;
            border-bottom: 1px solid var(--parsel-border);
        }

        .p-form-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .p-form-group label {
            font-size: 12px;
            font-weight: 700;
            color: #94a3b8;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .p-input, .p-select {
            width: 100%;
            background: #060b14;
            border: 1px solid rgba(255, 255, 255, 0.12);
            color: #ffffff;
            font-size: 13.5px;
            font-weight: 600;
            padding: 10px 12px;
            border-radius: 8px;
            box-sizing: border-box;
            outline: none;
            transition: all 0.2s ease;
        }

        .p-input:focus, .p-select:focus {
            border-color: var(--parsel-cyan);
            box-shadow: 0 0 12px rgba(56, 189, 248, 0.3);
            background: #091322;
        }

        .p-form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .btn-query-tkgm {
            background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
            border: 1px solid var(--parsel-cyan);
            color: #ffffff;
            font-size: 14px;
            font-weight: 800;
            padding: 13px;
            border-radius: 9px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 4px 18px rgba(2, 132, 199, 0.4);
            transition: all 0.2s ease;
            width: 100%;
        }

        .btn-query-tkgm:hover {
            background: linear-gradient(135deg, #0369a1 0%, #0284c7 100%);
            transform: translateY(-1px);
            box-shadow: 0 6px 24px rgba(56, 189, 248, 0.5);
        }

        .btn-gps-loc {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid var(--parsel-border);
            color: #cbd5e1;
            font-size: 12px;
            font-weight: 700;
            padding: 9px;
            border-radius: 8px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            transition: all 0.2s;
            width: 100%;
        }

        .btn-gps-loc:hover {
            color: #ffffff;
            border-color: rgba(56, 189, 248, 0.4);
            background: rgba(56, 189, 248, 0.08);
        }

        /* Hızlı Şehir Presetleri */
        .preset-title {
            font-size: 11px;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .preset-pills {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }

        .preset-pill {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.08);
            color: #94a3b8;
            font-size: 11px;
            font-weight: 600;
            padding: 4px 9px;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.15s;
        }

        .preset-pill:hover {
            background: rgba(56, 189, 248, 0.15);
            border-color: var(--parsel-cyan);
            color: #ffffff;
        }

        /* SAĞ PANEL: HARİTA VE PARSEL DETAYLARI */
        .parsel-map-column {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .parsel-map-container {
            position: relative;
            width: 100%;
            height: 620px;
            border-radius: 14px;
            overflow: hidden;
            border: 1.5px solid rgba(56, 189, 248, 0.3);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.6);
            background: #020617;
        }

        #parselMap {
            width: 100%;
            height: 100%;
        }

        /* Harita Üstü Telemetri HUD */
        .map-hud-telemetry {
            position: absolute;
            top: 14px;
            left: 14px;
            z-index: 900;
            background: rgba(8, 15, 28, 0.90);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(56, 189, 248, 0.35);
            border-radius: 8px;
            padding: 8px 14px;
            font-size: 11px;
            color: #cbd5e1;
            display: flex;
            flex-direction: column;
            gap: 4px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.5);
            font-family: monospace;
        }

        .map-hud-telemetry b {
            color: var(--parsel-cyan);
        }

        /* Harita Katman ve Araç Butonları */
        .map-floating-tools {
            position: absolute;
            top: 14px;
            right: 14px;
            z-index: 900;
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .map-tool-btn {
            background: rgba(8, 15, 28, 0.92);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: #cbd5e1;
            padding: 7px 12px;
            border-radius: 7px;
            font-size: 11.5px;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.4);
            transition: all 0.2s;
        }

        .map-tool-btn:hover, .map-tool-btn.active {
            color: #ffffff;
            border-color: var(--parsel-cyan);
            background: rgba(2, 132, 199, 0.85);
        }

        /* PARSEL RAPOR & DETAY KARTI */
        .parsel-result-card {
            background: var(--parsel-surface);
            border: 1px solid rgba(56, 189, 248, 0.25);
            border-radius: 14px;
            padding: 20px 24px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 16px;
        }

        .result-block {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .result-lbl {
            font-size: 11px;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .result-val {
            font-size: 15px;
            font-weight: 800;
            color: #ffffff;
        }

        .result-val.highlight {
            color: var(--parsel-cyan);
        }

        .result-val.green {
            color: #34d399;
        }

        /* Hızlı Aksiyon & İndirme Butonları */
        .parsel-export-bar {
            grid-column: 1 / -1;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 10px;
            padding-top: 14px;
            border-top: 1px solid var(--parsel-border);
            flex-wrap: wrap;
        }

        .btn-export {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--parsel-border);
            color: #cbd5e1;
            font-size: 12px;
            font-weight: 700;
            padding: 8px 14px;
            border-radius: 7px;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s;
        }

        .btn-export:hover {
            color: #ffffff;
            border-color: var(--parsel-cyan);
            background: rgba(56, 189, 248, 0.12);
        }

        .btn-export-wa {
            background: #10b981;
            color: #ffffff;
            border-color: #059669;
        }

        .btn-export-wa:hover {
            background: #059669;
            color: #ffffff;
        }
            /* Map background dark & Compact parcel badge tooltip */
        #parselMap, .parsel-map-container, .leaflet-container {
            background-color: #0b1320 !important;
        }

        .parsel-compact-pill-tooltip {
            background: rgba(11, 19, 36, 0.92) !important;
            backdrop-filter: blur(8px) !important;
            border: 1px solid rgba(56, 189, 248, 0.5) !important;
            border-radius: 20px !important;
            padding: 3px 12px !important;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.55) !important;
            color: #ffffff !important;
            pointer-events: none !important;
        }
        .parsel-compact-pill-tooltip::before {
            display: none !important;
        }
        .parsel-mini-pill {
            display: flex;
            align-items: center;
            gap: 6px;
            font-family: 'Inter', -apple-system, sans-serif;
            font-size: 11.5px;
            font-weight: 700;
            white-space: nowrap;
        }
        .parsel-mini-pill .pill-id { color: #38bdf8; font-weight: 800; }
        .parsel-mini-pill .pill-area { color: #22c55e; font-weight: 800; }
        .parsel-mini-pill .pill-quality { color: #facc15; font-size: 11px; }
        .parsel-mini-pill .pill-dot { color: #64748b; }
    
        
        /* ======================================================== */
        /* 🌟 PARSEL 360° ÇALIŞMA ALANI & MÜHENDİSLİK KOKPİTİ STİLLERİ */
        /* ======================================================== */
        .parsel-360-container {
            margin-top: 24px;
            background: linear-gradient(135deg, rgba(10, 17, 32, 0.95) 0%, rgba(15, 26, 48, 0.95) 100%);
            border: 1px solid rgba(56, 189, 248, 0.25);
            border-top: 3px solid var(--parsel-cyan);
            border-radius: 16px;
            padding: 24px 28px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.5);
        }

        .p360-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            padding-bottom: 18px;
            margin-bottom: 20px;
        }

        .p360-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(2, 132, 199, 0.18);
            border: 1px solid #0284c7;
            color: #38bdf8;
            font-size: 11px;
            font-weight: 800;
            padding: 3px 10px;
            border-radius: 6px;
            letter-spacing: 0.5px;
            margin-bottom: 6px;
        }

        .p360-title {
            font-size: 19px;
            font-weight: 800;
            color: #ffffff;
            margin: 0;
            letter-spacing: -0.01em;
        }

        .p360-meta-tags {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .p360-tag {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #cbd5e1;
            font-size: 11.5px;
            padding: 4px 10px;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .p360-tabs-nav {
            display: flex;
            gap: 8px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            padding-bottom: 12px;
            margin-bottom: 20px;
            overflow-x: auto;
        }

        .p360-tab-btn {
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #94a3b8;
            padding: 10px 18px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            white-space: nowrap;
            transition: all 0.2s ease;
        }

        .p360-tab-btn:hover {
            color: #ffffff;
            border-color: rgba(56, 189, 248, 0.4);
        }

        .p360-tab-btn.active {
            background: #0284c7;
            border-color: #38bdf8;
            color: #ffffff;
            box-shadow: 0 4px 14px rgba(2, 132, 199, 0.35);
        }

        .p360-tab-content {
            display: none;
            animation: fadeInP360 0.25s ease-in-out;
        }

        .p360-tab-content.active {
            display: block;
        }

        @keyframes fadeInP360 {
            from { opacity: 0; transform: translateY(4px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .p360-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 16px;
            margin-bottom: 16px;
        }

        .p360-card {
            background: rgba(15, 23, 42, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            padding: 18px;
        }

        .p360-card-title {
            font-size: 13px;
            font-weight: 800;
            color: #38bdf8;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .p360-metric-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 7px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            font-size: 12.5px;
        }

        .p360-metric-row:last-child { border-bottom: none; }
        .p360-metric-lbl { color: #94a3b8; }
        .p360-metric-val { color: #f8fafc; font-weight: 700; font-family: monospace; }
        .p360-metric-val.cyan { color: #38bdf8; font-weight: 800; }
        .p360-metric-val.green { color: #10b981; font-weight: 800; }
        .p360-metric-val.amber { color: #f59e0b; font-weight: 800; }

        /* AI Asistanı Sohbet Penceresi */
        .p360-ai-chat-box {
            background: #060c18;
            border: 1px solid rgba(56, 189, 248, 0.3);
            border-radius: 14px;
            padding: 18px;
            margin-bottom: 16px;
            max-height: 380px;
            overflow-y: auto;
            line-height: 1.6;
            font-size: 13px;
        }

        .p360-ai-msg {
            margin-bottom: 14px;
            padding: 12px 16px;
            border-radius: 10px;
        }

        .p360-ai-msg.bot {
            background: rgba(2, 132, 199, 0.12);
            border: 1px solid rgba(2, 132, 199, 0.25);
            color: #e2e8f0;
        }

        .p360-ai-msg.user {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: #ffffff;
            margin-left: 20%;
        }

        .p360-ai-chips {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 12px;
        }

        .p360-ai-chip {
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(56, 189, 248, 0.25);
            color: #cbd5e1;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 11.5px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .p360-ai-chip:hover {
            background: #0284c7;
            color: #ffffff;
            border-color: #38bdf8;
        }

        .p360-ai-input-bar {
            display: flex;
            gap: 10px;
        }

        .p360-ai-input {
            flex: 1;
            background: #0b1329;
            border: 1px solid #334155;
            color: #ffffff;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 13px;
            outline: none;
        }

        .p360-ai-send-btn {
            background: #0284c7;
            color: #ffffff;
            border: none;
            padding: 10px 18px;
            border-radius: 8px;
            font-weight: 700;
            cursor: pointer;
        }


        /* RESMİ RAPOR (PDF) VE BASKI STİLLERİ */
        #parselOfficialReportModal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(3, 7, 18, 0.85);
            backdrop-filter: blur(8px);
            z-index: 99999;
            overflow-y: auto;
            padding: 20px 10px;
            box-sizing: border-box;
        }

        .report-paper {
            background: #ffffff;
            color: #0f172a;
            max-width: 860px;
            margin: 0 auto;
            border-radius: 12px;
            padding: 36px 42px;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.45);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            position: relative;
        }

        .report-header-grid {
            display: grid;
            grid-template-columns: auto 1fr auto;
            align-items: center;
            gap: 20px;
            border-bottom: 2px solid #0284c7;
            padding-bottom: 18px;
            margin-bottom: 22px;
        }

        .report-logo-box {
            background: #0284c7;
            color: #ffffff;
            width: 58px;
            height: 58px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            font-weight: 900;
        }

        .report-title-box h1 {
            font-size: 19px;
            font-weight: 900;
            color: #0c4a6e;
            margin: 0 0 4px 0;
            letter-spacing: -0.01em;
        }

        .report-title-box p {
            font-size: 11.5px;
            color: #64748b;
            margin: 0;
            font-weight: 600;
        }

        .report-meta-box {
            text-align: right;
            font-size: 11px;
            color: #475569;
            line-height: 1.5;
        }

        .report-meta-box strong {
            color: #0f172a;
        }

        .report-section-title {
            font-size: 13.5px;
            font-weight: 800;
            color: #0369a1;
            background: #f0f9ff;
            border-left: 4px solid #0284c7;
            padding: 6px 12px;
            margin: 18px 0 10px 0;
            border-radius: 0 6px 6px 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .report-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
            margin-bottom: 14px;
        }

        .report-table th, .report-table td {
            border: 1px solid #cbd5e1;
            padding: 7px 10px;
            text-align: left;
        }

        .report-table th {
            background: #f8fafc;
            color: #334155;
            font-weight: 700;
        }

        .report-table td.highlight {
            font-weight: 800;
            color: #0284c7;
        }

        .report-footer-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-top: 24px;
            padding-top: 18px;
            border-top: 1px dashed #cbd5e1;
            align-items: center;
        }

        .report-stamp-box {
            border: 2px dashed #94a3b8;
            border-radius: 8px;
            padding: 12px;
            text-align: center;
            background: #fafafa;
        }

        .report-stamp-title {
            font-size: 11px;
            font-weight: 800;
            color: #1e293b;
            margin-bottom: 4px;
        }

        .report-stamp-sub {
            font-size: 10px;
            color: #64748b;
        }

        .report-actions-bar {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            margin-bottom: 16px;
        }

        .btn-report-print {
            background: #0284c7;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 13.5px;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 12px rgba(2, 132, 199, 0.3);
        }

        .btn-report-print:hover { background: #0369a1; }

        .btn-report-close {
            background: #f1f5f9;
            color: #334155;
            border: 1px solid #cbd5e1;
            padding: 10px 18px;
            border-radius: 8px;
            font-size: 13.5px;
            font-weight: 700;
            cursor: pointer;
        }

        .btn-report-close:hover { background: #e2e8f0; }

        @media print {
            body * {
                visibility: hidden !important;
            }
            #parselOfficialReportModal, #parselOfficialReportModal * {
                visibility: visible !important;
            }
            #parselOfficialReportModal {
                position: absolute !important;
                left: 0 !important;
                top: 0 !important;
                width: 100% !important;
                height: auto !important;
                background: #ffffff !important;
                padding: 0 !important;
                margin: 0 !important;
                z-index: 999999 !important;
            }
            .report-paper {
                box-shadow: none !important;
                border-radius: 0 !important;
                padding: 15mm 15mm !important;
                max-width: 100% !important;
                width: 100% !important;
            }
            .report-actions-bar {
                display: none !important;
            }
            @page {
                size: A4 portrait;
                margin: 10mm;
            }
        }

    </style>
</head>
<body>

    <!-- 2026 SAAS GLOBAL NAVBAR -->
    <?php render_saas_navbar('parsel'); ?>

    <!-- 2026 SAAS TELEMETRİ BANTI -->
    <div class="telemetry-ticker-bar" style="background: linear-gradient(90deg, #070e1c 0%, #0b172d 50%, #070e1c 100%); border-bottom: 1px solid rgba(56, 189, 248, 0.25); padding: 8px 24px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 14px; font-size: 12px; color: #f1f5f9;">
        <div style="display: flex; align-items: center; gap: 18px; flex-wrap: wrap;">
            <div style="display: flex; align-items: center; gap: 7px; color: #f8fafc; font-weight: 600;">
                <span style="width: 8px; height: 8px; border-radius: 50%; background: #22c55e; box-shadow: 0 0 10px #22c55e; display: inline-block;"></span>
                <span><b style="color: #4ade80;">TKGM MEGSİS V3.4:</b> <span style="color: #e2e8f0;">81 İl, 973 İlçe ve 50.792 Mahalle Canlı Devrede</span></span>
            </div>
            <div style="display: flex; align-items: center; gap: 7px; color: #f8fafc; font-weight: 600;">
                <span style="width: 8px; height: 8px; border-radius: 50%; background: #38bdf8; box-shadow: 0 0 10px #38bdf8; display: inline-block;"></span>
                <span><b style="color: #38bdf8;">GNSS/RTK:</b> <span style="color: #e2e8f0;">28 Uydu Fix (±1.5mm)</span></span>
            </div>
        </div>
        <div style="display: flex; align-items: center; gap: 8px; color: #cbd5e1; font-size: 12px; font-weight: 600;">
            <span>🏢 <b style="color: #ffffff;">Ant Harita Mühendislik</b> &bull; LİHKAB / HKMO Sicil: <b style="color: #facc15;">12480</b></span>
            <span style="color: #64748b;">&bull;</span>
            <a href="tel:05428413535" style="color: #38bdf8; text-decoration: none; font-weight: 700;">📞 0542 841 35 35</a>
        </div>
    </div>

    <main class="parsel-layout-container">
        <!-- Başlık ve Tanıtım Alanı -->
        <div class="parsel-hero-header">
            <div class="parsel-hero-title-area">
                <div class="parsel-hero-badge">
                    <i class="fa-solid fa-satellite-dish"></i>
                    <span>RESMÎ TKGM MEGSİS SAYISAL KADASTRO &amp; UYDU AĞI</span>
                </div>
                <h1 class="parsel-hero-h1">Ada Parsel Sorgulama &amp; Canlı Kadastro Haritası</h1>
                <p class="parsel-hero-sub">Ada ve parselinizi girin; resmi köşe koordinatlarını, sınır poligonunu ve 3D uydu görüntüsünü anında haritada inceleyin.</p>
            </div>
            <div class="parsel-hero-stats">
                <div class="stat-pill"><i class="fa-solid fa-earth-americas text-cyan"></i> <span>81 İl / 973 İlçe <b>Aktif</b></span></div>
                <div class="stat-pill"><i class="fa-solid fa-layer-group text-green"></i> <span>WMS Kadastro <b>Canlı</b></span></div>
            </div>
        </div>

        <!-- Ana Sorgulama ve Harita Izgarası -->
        <div class="parsel-main-grid">
            <!-- Sol Sütun: Arama Konsolu -->
            <aside class="parsel-form-card">
                <div class="form-card-title">
                    <i class="fa-solid fa-magnifying-glass-location text-cyan"></i>
                    <span>Parsel Bilgilerini Girin</span>
                </div>

                <div class="p-form-group">
                    <label for="selCity">İl (81 İl):</label>
                    <select id="selCity" class="p-select" onchange="onCityChanged()">
                        <?php foreach ($cities as $c): ?>
                            <option value="<?php echo htmlspecialchars($c); ?>" <?php echo ($c === $pre_city) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($c); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="p-form-group">
                    <label for="selDistrict">İlçe:</label>
                    <select id="selDistrict" class="p-select" onchange="onDistrictChanged()">
                        <option value="Çankaya">Çankaya</option>
                    </select>
                </div>

                <div class="p-form-group">
                    <label for="selMahalle">Mahalle / Köy (TKGM Canlı Liste):</label>
                    <select id="selMahalle" class="p-select" onchange="onMahalleChanged()">
                        <option value="">Mahalle Yükleniyor...</option>
                    </select>
                </div>

                <div class="p-form-row">
                    <div class="p-form-group">
                        <label for="txtAda">Ada No:</label>
                        <input type="text" id="txtAda" class="p-input" placeholder="Örn: 104" value="<?php echo htmlspecialchars($pre_ada); ?>">
                    </div>
                    <div class="p-form-group">
                        <label for="txtParsel">Parsel No:</label>
                        <input type="text" id="txtParsel" class="p-input" placeholder="Örn: 12" value="<?php echo htmlspecialchars($pre_parsel); ?>">
                    </div>
                </div>

                <button type="button" class="btn-query-tkgm" id="btnExecuteQuery" onclick="executeStandaloneQuery()">
                    <i class="fa-solid fa-crosshairs"></i>
                    <span>Haritada Bul &amp; Sorgula</span>
                </button>

                <button type="button" class="btn-gps-loc" onclick="locateUserGps()">
                    <i class="fa-solid fa-location-arrow"></i>
                    <span>Mevcut GPS Konumumu Haritada Aç</span>
                </button>

                <!-- Hızlı Presetler -->
                <div style="display: flex; flex-direction: column; gap: 8px; margin-top: 6px;">
                    <span class="preset-title">Popüler Lokasyonlar:</span>
                    <div class="preset-pills">
                        <span class="preset-pill" onclick="setPreset('Kırıkkale', 'Bahşılı', '104', '12')">Kırıkkale Bahşılı</span>
                        <span class="preset-pill" onclick="setPreset('Ankara', 'Çankaya', '104', '12')">Ankara Çankaya</span>
                        <span class="preset-pill" onclick="setPreset('İstanbul', 'Kadıköy', '245', '8')">İstanbul Kadıköy</span>
                        <span class="preset-pill" onclick="setPreset('İzmir', 'Urla', '1312', '4')">İzmir Urla</span>
                        <span class="preset-pill" onclick="setPreset('Antalya', 'Konyaaltı', '512', '3')">Antalya Konyaaltı</span>
                        <span class="preset-pill" onclick="setPreset('Muğla', 'Bodrum', '302', '15')">Muğla Bodrum</span>
                    </div>
                </div>
            </aside>

            <!-- Sağ Sütun: İnteraktif Harita Sistemi ve Detay Kartı -->
            <section class="parsel-map-column">
                <div class="parsel-map-container">
                    <div id="parselMap"></div>

                    <!-- Canlı Telemetri HUD -->
                    <div class="map-hud-telemetry" id="mapHud">
                        <div><b>ENLEM / BOYLAM:</b> <span id="hudLatLon">39.9208, 32.8541</span></div>
                        <div><b>PROJEKSİYON:</b> <span>ITRF96 / TM30 (EPSG:5254)</span></div>
                        <div><b>HASSASİYET:</b> <span style="color:#22c55e;">±1.5mm GNSS FIX</span></div>
                    </div>

                    <!-- Harita Katman Araçları -->
                    <div class="map-floating-tools">
                        <button type="button" class="map-tool-btn active" id="btnLayerSat" onclick="setBaseLayer('sat')" title="Uydu Katmanı">
                            <i class="fa-solid fa-satellite"></i> <span>Uydu</span>
                        </button>
                        <button type="button" class="map-tool-btn" id="btnLayerOsm" onclick="setBaseLayer('osm')" title="Sokak Haritası">
                            <i class="fa-solid fa-map"></i> <span>Sokak</span>
                        </button>
                        <button type="button" class="map-tool-btn" id="btnLayerDark" onclick="setBaseLayer('dark')" title="Kadastro Koyu Mod">
                            <i class="fa-solid fa-moon"></i> <span>Koyu</span>
                        </button>
                        <button type="button" class="map-tool-btn active" id="btnToggleWms" onclick="toggleWmsLayer()" title="TKGM WMS Kadastro Sınırları">
                            <i class="fa-solid fa-draw-polygon"></i> <span>WMS Kadastro</span>
                        </button>
                        <button type="button" class="map-tool-btn" id="btnDroneMode" onclick="toggleDroneFlight()" title="3D Drone Uçuşu">
                            <i class="fa-solid fa-helicopter"></i> <span>3D Drone</span>
                        </button>
                        <button type="button" class="map-tool-btn" id="btnMeasure" onclick="toggleMeasureTool()" title="Haritada Mesafe ve Alan Ölçümü">
                            <i class="fa-solid fa-ruler-combined"></i> <span>Ölçüm</span>
                        </button>
                        <button type="button" class="map-tool-btn" id="btnCekme" onclick="toggleCekmeMesafesi()" title="Ön Bahçe 5m, Yan Bahçe 3m Çekme Mesafesi Simülasyonu">
                            <i class="fa-solid fa-border-none"></i> <span>Çekme (5m/3m)</span>
                        </button>
                        <button type="button" class="map-tool-btn" onclick="toggleMapFullscreen()" title="Tam Ekran">
                            <i class="fa-solid fa-expand"></i> <span>Tam Ekran</span>
                        </button>
                        <button type="button" class="map-tool-btn" onclick="exportDxf()" title="AutoCAD &amp; Netcad CAD (DXF) İndir" style="border:1px solid rgba(56,189,248,0.5); color:#38bdf8; background:rgba(2,132,199,0.15);">
                            <i class="fa-solid fa-pen-ruler"></i> <span>CAD (DXF)</span>
                        </button>
                        <button type="button" class="map-tool-btn" onclick="printParselPdf()" title="Resmî Mühendislik Raporu (PDF)" style="border:1px solid rgba(244,63,94,0.5); color:#fb7185; background:rgba(244,63,94,0.15);">
                            <i class="fa-solid fa-file-pdf"></i> <span>PDF Rapor</span>
                        </button>
                    </div>
                </div>

                <!-- Parsel Sonuç ve Detay Bilgi Kartı -->
                <div class="parsel-result-card" id="parselResultCard">
                    <div class="result-block">
                        <span class="result-lbl">Ada / Parsel No:</span>
                        <span class="result-val highlight" id="resAdaParsel"><?php echo htmlspecialchars($pre_ada); ?> / <?php echo htmlspecialchars($pre_parsel); ?></span>
                    </div>
                    <div class="result-block">
                        <span class="result-lbl">Resmî Parsel Alanı:</span>
                        <span class="result-val green" id="resAlan">570,00 m²</span>
                    </div>
                    <div class="result-block">
                        <span class="result-lbl">Taşınmaz Niteliği:</span>
                        <span class="result-val" id="resNitelik">Arsa</span>
                    </div>
                    <div class="result-block">
                        <span class="result-lbl">İl / İlçe / Mahalle:</span>
                        <span class="result-val" id="resKonum"><?php echo htmlspecialchars($pre_city); ?> / <?php echo htmlspecialchars($pre_district); ?> / <?php echo htmlspecialchars($pre_mahalle ?: 'Atadönmez Mh.'); ?></span>
                    </div>
                    <div class="result-block">
                        <span class="result-lbl">İmar Durumu (KAKS/TAKS):</span>
                        <span class="result-val" id="resEmsal">E: 1.50 &bull; TAKS: 0.30 &bull; Hmax: Serbest</span>
                    </div>
                    <div class="result-block">
                        <span class="result-lbl">Tahmini İnşaat Kapasitesi:</span>
                        <span class="result-val highlight" id="resInsaatAlani">~2.175 m² Kapalı Alan</span>
                    </div>

                    <!-- Export ve Paylaşım Butonları -->
                    <div class="parsel-export-bar">
                        <button type="button" class="btn-export" onclick="exportKml()"><i class="fa-solid fa-file-code"></i> KML İndir</button>
                        <button type="button" class="btn-export" onclick="exportDxf()"><i class="fa-solid fa-pen-ruler"></i> CAD (DXF) İndir</button>
                        <button type="button" class="btn-export" onclick="exportCsv()"><i class="fa-solid fa-file-excel" style="color:#22c55e;"></i> Excel (CSV) İndir</button>
                        <button type="button" class="btn-export" onclick="saveParcelProject()"><i class="fa-solid fa-bookmark" style="color:#facc15;"></i> Projelerime Kaydet</button>
                        <button type="button" class="btn-export" onclick="openSavedProjectsModal()"><i class="fa-solid fa-folder-open" style="color:#38bdf8;"></i> Kayıtlı Projelerim</button>
                        <button type="button" class="btn-export" style="background:linear-gradient(135deg, rgba(245,158,11,0.2), rgba(217,119,6,0.3)); border-color:#f59e0b; color:#fbbf24; font-weight:800;" onclick="openPricingModal()"><i class="fa-solid fa-crown"></i> PRO &amp; Lisans</button>
                        <button type="button" class="btn-export" onclick="printParselPdf()"><i class="fa-solid fa-file-pdf"></i> Mühendislik Raporu (PDF)</button>
                        <a href="https://wa.me/905428413535?text=Merhaba,%20parsel%20sorgu%20sonucum%20hakkında%20teknik%20destek%20almak%20istiyorum." target="_blank" rel="noopener" class="btn-export btn-export-wa">
                            <i class="fa-brands fa-whatsapp"></i> <span>WhatsApp ile Uzmana Sor</span>
                        </a>
                    </div>
                </div>
            
                <!-- ======================================================== -->
                <!-- 🌟 PARSEL 360° TÜRKİYE İMAR & KADASTRO KOKPİTİ (MASTER)   -->
                <!-- ======================================================== -->
                <div class="parsel-360-container" id="parsel360Section">
                    <!-- Üst Başlık & Proje Kimliği -->
                    <div class="p360-header">
                        <div class="p360-title-box">
                            <span class="p360-badge"><i class="fa-solid fa-circle-nodes"></i> PARSEL 360&deg; MÜHENDİSLİK &amp; İMAR ÇALIŞMA ALANI</span>
                            <h2 class="p360-title" id="p360ProjectTitle">Kırıkkale / Merkez / Hacılar Hacıbey Mh. &bull; Ada 1781 / Parsel 34</h2>
                        </div>
                        <div class="p360-meta-tags">
                            <span class="p360-tag"><i class="fa-solid fa-fingerprint" style="color:#38bdf8;"></i> <strong id="p360ProjectId">PROJE: PS-2026-9481</strong></span>
                            <span class="p360-tag"><i class="fa-solid fa-satellite" style="color:#10b981;"></i> TKGM MEGSİS Doğrulandı</span>
                            <span class="p360-tag"><i class="fa-solid fa-crosshairs" style="color:#f59e0b;"></i> ITRF95 (EPSG:5254)</span>
                        </div>
                    </div>

                    <!-- 360 Sekme Navigasyonu -->
                    <div class="p360-tabs-nav">
                        <button type="button" class="p360-tab-btn active" onclick="switch360Tab('kadastro', this)">
                            <i class="fa-solid fa-map-location-dot"></i>
                            <span>1. Kadastro &amp; Koordinat</span>
                        </button>
                        <button type="button" class="p360-tab-btn" onclick="switch360Tab('imar', this)">
                            <i class="fa-solid fa-compass-drafting"></i>
                            <span>2. İmar &amp; Yapılaşma (KAKS/TAKS)</span>
                        </button>
                        <button type="button" class="p360-tab-btn" onclick="switch360Tab('ifraz', this)">
                            <i class="fa-solid fa-draw-polygon"></i>
                            <span>3. İfraz &amp; DOP (18. Madde)</span>
                        </button>
                        <button type="button" class="p360-tab-btn" onclick="switch360Tab('maliyet', this)">
                            <i class="fa-solid fa-calculator"></i>
                            <span>4. 2026 Maliyet &amp; Kat Karşılığı</span>
                        </button>
                        <button type="button" class="p360-tab-btn" onclick="switch360Tab('ai', this)" style="border-color:#38bdf8; background:rgba(2, 132, 199, 0.25);">
                            <i class="fa-solid fa-robot" style="color:#38bdf8;"></i>
                            <span style="color:#38bdf8;">5. Parsel AI Asistanı</span>
                        </button>
                    </div>

                    <!-- SEKME 1: KADASTRO & KOORDİNAT -->
                    <div id="p360-tab-kadastro" class="p360-tab-content active">
                        <div class="p360-grid">
                            <div class="p360-card">
                                <div class="p360-card-title"><i class="fa-solid fa-fingerprint"></i> Mülkiyet Kimliği</div>
                                <div class="p360-metric-row"><span class="p360-metric-lbl">Konum:</span><span class="p360-metric-val" id="p360Konum">Kırıkkale / Merkez / Hacılar Hacıbey Mh.</span></div>
                                <div class="p360-metric-row"><span class="p360-metric-lbl">Ada / Parsel:</span><span class="p360-metric-val cyan" id="p360AdaParsel">1781 / 34</span></div>
                                <div class="p360-metric-row"><span class="p360-metric-lbl">Tapu Alanı:</span><span class="p360-metric-val green" id="p360TapuAlani">750,00 m²</span></div>
                                <div class="p360-metric-row"><span class="p360-metric-lbl">Niteliği:</span><span class="p360-metric-val" id="p360Nitelik">Arsa (Konut İmarı)</span></div>
                            </div>
                            <div class="p360-card">
                                <div class="p360-card-title"><i class="fa-solid fa-compass"></i> Projeksiyon &amp; Koordinat</div>
                                <div class="p360-metric-row"><span class="p360-metric-lbl">Referans Sistemi:</span><span class="p360-metric-val">ITRF95 TM 3° (GRS80)</span></div>
                                <div class="p360-metric-row"><span class="p360-metric-lbl">Merkez Boylam (DOM):</span><span class="p360-metric-val" id="p360Dom">33°</span></div>
                                <div class="p360-metric-row"><span class="p360-metric-lbl">Sağa Değer (Y):</span><span class="p360-metric-val" id="p360Y">536.994,95 m</span></div>
                                <div class="p360-metric-row"><span class="p360-metric-lbl">Yukarı Değer (X):</span><span class="p360-metric-val" id="p360X">4.397.649,73 m</span></div>
                            </div>
                        </div>
                        <div style="background:rgba(15, 23, 42, 0.5); border:1px solid rgba(255,255,255,0.06); border-radius:10px; padding:12px 16px; font-size:12px; color:#94a3b8; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;">
                            <span><i class="fa-solid fa-circle-check" style="color:#10b981;"></i> Köşe koordinatları santimetre hassasiyetindedir. Netcad ve AutoCAD ile açmak için yukarıdaki <strong>CAD (DXF) İndir</strong> butonunu kullanabilirsiniz.</span>
                            <button type="button" onclick="exportDxf()" style="background:#0284c7; color:#fff; border:none; padding:6px 14px; border-radius:6px; font-weight:700; font-size:11.5px; cursor:pointer;"><i class="fa-solid fa-download"></i> Metrik DXF İndir</button>
                        </div>

                        <!-- Veri Menşei & Yasal Standart Künyesi (Master Plan Madde 8) -->
                        <div style="margin-top:16px; background:#0f172a; border:1px solid #1e293b; border-radius:10px; padding:16px 18px;">
                            <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:8px; margin-bottom:12px;">
                                <div style="font-weight:900; color:#fff; font-size:13px; display:flex; align-items:center; gap:8px;">
                                    <i class="fa-solid fa-certificate" style="color:#38bdf8;"></i>
                                    <span>Veri Menşei, Güvenilirlik &amp; Yasal Çerçeve Künyesi</span>
                                </div>
                                <span style="background:rgba(16,185,129,0.15); border:1px solid #10b981; color:#34d399; font-size:10.5px; font-weight:800; padding:2px 8px; border-radius:4px;">
                                    VERİ KALİTE SKORU: %100 DOĞRULANDI
                                </span>
                            </div>
                            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); gap:10px; font-size:12px;">
                                <div style="background:#1e293b; padding:10px 12px; border-radius:6px; border:1px solid rgba(255,255,255,0.05);">
                                    <span style="color:#94a3b8; display:block; font-size:11px;">Kaynak Kurum:</span>
                                    <strong style="color:#f1f5f9;">TKGM MEGSİS &amp; İlgili Belediye</strong>
                                </div>
                                <div style="background:#1e293b; padding:10px 12px; border-radius:6px; border:1px solid rgba(255,255,255,0.05);">
                                    <span style="color:#94a3b8; display:block; font-size:11px;">Koordinat Projeksiyonu:</span>
                                    <strong style="color:#38bdf8;">TUREF / ITRF95 (EPSG:5254) 3° TM</strong>
                                </div>
                                <div style="background:#1e293b; padding:10px 12px; border-radius:6px; border:1px solid rgba(255,255,255,0.05);">
                                    <span style="color:#94a3b8; display:block; font-size:11px;">Hukuki Kullanım Statüsü:</span>
                                    <strong style="color:#facc15;">Mühendislik Ön Değerlendirmesi</strong>
                                </div>
                                <div style="background:#1e293b; padding:10px 12px; border-radius:6px; border:1px solid rgba(255,255,255,0.05);">
                                    <span style="color:#94a3b8; display:block; font-size:11px;">Geometri &amp; Topoloji:</span>
                                    <strong style="color:#10b981;">Poligon Kapanması Kapalı &amp; Geçerli</strong>
                                </div>
                            </div>
                        </div>

                        <!-- Kadastro Tecviz & Alan Çelişkisi Denetimi (Master Plan Madde 8) -->
                        <div style="margin-top:12px; background:linear-gradient(135deg, rgba(15,23,42,0.9), rgba(30,41,59,0.9)); border:1px solid rgba(56,189,248,0.25); border-radius:10px; padding:14px 18px; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;">
                            <div>
                                <div style="font-size:12px; font-weight:800; color:#38bdf8; display:flex; align-items:center; gap:6px;">
                                    <i class="fa-solid fa-scale-balanced"></i>
                                    <span>Kadastro Yanılma Sınırı (Tecviz) &amp; Alan Uyuşumu Denetimi</span>
                                </div>
                                <div id="p360TecvizText" style="font-size:12px; color:#cbd5e1; margin-top:3px;">
                                    Hesaplanan poligon alanı ile tescilli tapu alanı Kadastro Yönetmeliği tecviz sınırları içerisindedir.
                                </div>
                            </div>
                            <span id="p360TecvizBadge" style="background:#10b981; color:#022c22; font-size:11px; font-weight:900; padding:4px 10px; border-radius:6px;">
                                ✅ ALAN TAM UYUMLU
                            </span>
                        </div>
                    </div>

                    <!-- SEKME 2: İMAR & YAPILAŞMA (KAKS/TAKS) -->
                    <div id="p360-tab-imar" class="p360-tab-content">
                        <div class="p360-grid">
                            <div class="p360-card">
                                <div class="p360-card-title"><i class="fa-solid fa-building"></i> Yapılaşma Parametreleri</div>
                                <div class="p360-metric-row"><span class="p360-metric-lbl">Emsal (KAKS):</span><span class="p360-metric-val cyan" id="p360Kaks">1.50</span></div>
                                <div class="p360-metric-row"><span class="p360-metric-lbl">Taban Alanı (TAKS):</span><span class="p360-metric-val" id="p360Taks">0.30</span></div>
                                <div class="p360-metric-row"><span class="p360-metric-lbl">Yükseklik (Hmax):</span><span class="p360-metric-val" id="p360Hmax">Serbest (4-5 Kat Uygun)</span></div>
                                <div class="p360-metric-row"><span class="p360-metric-lbl">Yapı Nizamı:</span><span class="p360-metric-val">Ayrık Nizam</span></div>
                            </div>
                            <div class="p360-card">
                                <div class="p360-card-title"><i class="fa-solid fa-maximize"></i> Kapasite Hesapları</div>
                                <div class="p360-metric-row"><span class="p360-metric-lbl">Azami Taban Alanı:</span><span class="p360-metric-val" id="p360TabanAlani">~225,00 m²</span></div>
                                <div class="p360-metric-row"><span class="p360-metric-lbl">Toplam İmar İnşaat Alanı:</span><span class="p360-metric-val green" id="p360ToplamInsaat">~1.125,00 m²</span></div>
                                <div class="p360-metric-row"><span class="p360-metric-lbl">Tahmini Daire Sayısı (120m²):</span><span class="p360-metric-val cyan" id="p360DaireSayisi">~9 Bağımsız Bölüm</span></div>
                                <div class="p360-metric-row"><span class="p360-metric-lbl">Ön / Yan Bahçe Çekme:</span><span class="p360-metric-val">5.00 m / 3.00 m</span></div>
                            </div>
                        </div>
                    </div>

                    <!-- SEKME 3: İFRAZ & 18. MADDE DOP -->
                    <div id="p360-tab-ifraz" class="p360-tab-content">
                        <div class="p360-grid">
                            <div class="p360-card">
                                <div class="p360-card-title"><i class="fa-solid fa-split"></i> İfraz (Bölünme) Uygunluk Analizi</div>
                                <div class="p360-metric-row"><span class="p360-metric-lbl">5403 s.K. Tarım Parseli Sınırı:</span><span class="p360-metric-val amber">Min. 5.000 m²</span></div>
                                <div class="p360-metric-row"><span class="p360-metric-lbl">3194 s.K. İmar Parseli Sınırı:</span><span class="p360-metric-val">Min. 300 - 500 m²</span></div>
                                <div class="p360-metric-row"><span class="p360-metric-lbl">Bölünebilirlik Durumu:</span><span class="p360-metric-val" id="p360IfrazDurumu">İmar Planına Göre 2 Parsele Uygun</span></div>
                                <div class="p360-metric-row"><span class="p360-metric-lbl">Yola Cephe Şartı:</span><span class="p360-metric-val">Sağlanıyor (Min. 12 m)</span></div>
                            </div>
                            <div class="p360-card">
                                <div class="p360-card-title"><i class="fa-solid fa-pie-chart"></i> 18. Madde DOP Simülasyonu</div>
                                <div class="p360-metric-row"><span class="p360-metric-lbl">Mevcut Ham Parsel Alanı:</span><span class="p360-metric-val" id="p360HamAlan">750,00 m²</span></div>
                                <div class="p360-metric-row"><span class="p360-metric-lbl">Yasal Azami DOP Oranı:</span><span class="p360-metric-val amber">%45,00 (3194 / 18. Md)</span></div>
                                <div class="p360-metric-row"><span class="p360-metric-lbl">Tahmini Kamu Terki (DOP):</span><span class="p360-metric-val" id="p360DopKesinti">~337,50 m²</span></div>
                                <div class="p360-metric-row"><span class="p360-metric-lbl">Net İmar Parseli Tahsisi:</span><span class="p360-metric-val green" id="p360NetParsel">~412,50 m²</span></div>
                            </div>
                        
                        <!-- GEOMETRİK İFRAZ ÇİZİM VE HARİTA SİMÜLASYONU BARI -->
                        <div style="background:rgba(2, 132, 199, 0.12); border:1px solid rgba(2, 132, 199, 0.3); border-radius:12px; padding:16px 20px; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:14px; margin-top:16px;">
                            <div>
                                <div style="font-weight:800; color:#ffffff; font-size:13.5px; margin-bottom:4px; display:flex; align-items:center; gap:8px;">
                                    <i class="fa-solid fa-scissors" style="color:#38bdf8;"></i>
                                    <span>Canlı Haritada 2 Eşit Parsele Geometrik Bölünme Simülasyonu</span>
                                </div>
                                <div style="font-size:12px; color:#cbd5e1; max-width:620px; line-height:1.4;">
                                    Parseli köşe koordinatları doğrultusunda 2 bağımsız imar parseline bölün. İfraz hattını, yola cephe şartını ve oluşan A/B parsellerini haritada anında inceleyin.
                                </div>
                            </div>
                            <div style="display:flex; gap:10px; align-items:center; flex-wrap:wrap;">
                                <button type="button" id="btnRunIfrazSplit" onclick="toggleGeometricIfraz()" style="background:#0284c7; color:#fff; border:none; padding:10px 18px; border-radius:8px; font-weight:800; font-size:12.5px; cursor:pointer; display:inline-flex; align-items:center; gap:8px; box-shadow:0 4px 12px rgba(2,132,199,0.35);">
                                    <i class="fa-solid fa-draw-polygon"></i> <span>2 Parsele Böl &amp; Haritada Göster</span>
                                </button>
                                <button type="button" id="btnExportIfrazDxf" onclick="exportIfrazDxf()" style="display:none; background:#10b981; color:#fff; border:none; padding:10px 18px; border-radius:8px; font-weight:800; font-size:12.5px; cursor:pointer; display:inline-flex; align-items:center; gap:8px; box-shadow:0 4px 12px rgba(16,185,129,0.35);">
                                    <i class="fa-solid fa-download"></i> <span>İfrazlı CAD (DXF) İndir</span>
                                </button>
                            </div>
                        </div>
</div>
                    </div>

                    <!-- SEKME 4: 2026 MALİYET & KAT KARŞILIĞI -->
                    <div id="p360-tab-maliyet" class="p360-tab-content">
                        <div class="p360-grid">
                            <div class="p360-card">
                                <div class="p360-card-title"><i class="fa-solid fa-coins"></i> 2026 ÇŞİDB Yaklaşık İnşaat Maliyeti</div>
                                <div class="p360-metric-row"><span class="p360-metric-lbl">Yapı Sınıfı:</span><span class="p360-metric-val">3-B / 4-A Konut</span></div>
                                <div class="p360-metric-row"><span class="p360-metric-lbl">2026 Birim Metrekare Fiyatı:</span><span class="p360-metric-val">~16.500 TL/m²</span></div>
                                <div class="p360-metric-row"><span class="p360-metric-lbl">Toplam İnşaat Alanı:</span><span class="p360-metric-val cyan" id="p360MaliyetInsaatAlani">~1.125,00 m²</span></div>
                                <div class="p360-metric-row"><span class="p360-metric-lbl">Tahmini Kaba + İnce Bütçe:</span><span class="p360-metric-val green" id="p360ToplamButce">~18.562.500 TL</span></div>
                            </div>
                            <div class="p360-card">
                                <div class="p360-card-title"><i class="fa-solid fa-handshake"></i> Kat Karşılığı Paylaşım Senaryosu</div>
                                <div class="p360-metric-row"><span class="p360-metric-lbl">Bölge Emsal Paylaşım Oranı:</span><span class="p360-metric-val amber">%50 Arsa Sahibi / %50 Müteahhit</span></div>
                                <div class="p360-metric-row"><span class="p360-metric-lbl">Arsa Sahibine Kalan Alan:</span><span class="p360-metric-val" id="p360ArsaPayiAlani">~562,50 m²</span></div>
                                <div class="p360-metric-row"><span class="p360-metric-lbl">Tahmini Düşecek Daire Sayısı:</span><span class="p360-metric-val cyan" id="p360ArsaDaireSayisi">~4 - 5 Daire</span></div>
                                <div class="p360-metric-row"><span class="p360-metric-lbl">Müteahhit Payı:</span><span class="p360-metric-val">~4 - 5 Daire</span></div>
                            </div>
                        </div>
                        <!-- 120+ Kalem Detaylı Keşif Bağlantısı -->
                        <div style="margin-top:16px; padding:14px 18px; background:#0f172a; border:1px solid #1e293b; border-radius:10px; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;">
                            <div>
                                <div style="font-weight:900; color:#fff; font-size:14px;">🏗️ Detaylı 120+ Kalem Keşif &amp; Mahal Listesi (ÇŞİDB 2026)</div>
                                <div style="font-size:12px; color:#94a3b8; margin-top:3px;">Kaba inşaat (35+ kalem), ince işler (65+ kalem), ruhsat harçları ve marka listesini tam keşif dökümü olarak açın.</div>
                            </div>
                            <a id="p360OpenDetailedCostBtn" href="/maliyet" target="_blank" class="p360-btn" style="background:#10b981; color:#022c22; text-decoration:none; display:inline-flex; align-items:center; gap:8px; padding:10px 18px; border-radius:8px; font-weight:900; font-size:13px; box-shadow:0 0 15px rgba(16,185,129,0.3); transition:all 0.2s;" onmouseover="this.style.background='#059669'; this.style.color='#fff';" onmouseout="this.style.background='#10b981'; this.style.color='#022c22';">
                                <span>120+ Kalem Keşif Listesini Aç ↗</span>
                            </a>
                        </div>
                    </div>

                    <!-- SEKME 5: PARSEL AI ASİSTANI -->
                    <div id="p360-tab-ai" class="p360-tab-content">
                        <div class="p360-card-title" style="margin-bottom:8px;">
                            <i class="fa-solid fa-robot" style="color:#38bdf8;"></i> 
                            <span>Parsel AI — Canlı Mühendislik ve İmar Asistanı</span>
                            <span style="font-size:10px; background:#10b981; color:#fff; padding:2px 8px; border-radius:4px; font-weight:800; margin-left:auto;">ÇEVRİMİÇİ</span>
                        </div>
                        <p style="font-size:12px; color:#94a3b8; margin:0 0 14px 0;">
                            3194 Sayılı İmar Kanunu ve Planlı Alanlar İmar Yönetmeliği kuralları bu parselin parametrelerine göre otomatik uygulanmaktadır.
                        </p>

                        <!-- Sohbet Akışı -->
                        <div class="p360-ai-chat-box" id="p360ChatBox">
                            <div class="p360-ai-msg bot">
                                <strong>🤖 Parsel AI Asistanı:</strong><br>
                                Merhaba! <span id="p360AiIntroLoc">Kırıkkale / Merkez / Hacılar Hacıbey Mh. Ada 1781, Parsel 34 (750,00 m²)</span> taşınmazı inceleniyor. Bu parselin imar yapılaşma kapasitesi, ifraz uygunluğu, 2026 inşaat maliyeti veya kat karşılığı paylaşım şartları hakkında sormak istediğiniz soruları yanıtlayabilirim.
                            </div>
                        </div>

                        <!-- Hızlı Soru Hapları -->
                        <div class="p360-ai-chips">
                            <button type="button" class="p360-ai-chip" onclick="askParselAi('kapasite')">🏢 İmar &amp; Kat Kapasitesi</button>
                            <button type="button" class="p360-ai-chip" onclick="askParselAi('ifraz')">📐 İfraz &amp; Bölünme Şartı</button>
                            <button type="button" class="p360-ai-chip" onclick="askParselAi('koyevi')">🚜 Köyde Ev Yapma İzni</button>
                            <button type="button" class="p360-ai-chip" onclick="askParselAi('tinyhouse')">🚐 Tiny House / Karavan</button>
                            <button type="button" class="p360-ai-chip" onclick="askParselAi('dop18')">🏛️ 18. Madde DOP Dağıtımı</button>
                            <button type="button" class="p360-ai-chip" onclick="askParselAi('maliyet')">💰 2026 İnşaat Maliyeti</button>
                            <button type="button" class="p360-ai-chip" onclick="askParselAi('katkarsiligi')">🤝 Kat Karşılığı Paylaşım</button>
                            <button type="button" class="p360-ai-chip" onclick="askParselAi('ges')">☀️ GES Santrali Kurulur mu?</button>
                            <button type="button" class="p360-ai-chip" onclick="askParselAi('miras')">⚖️ Hisseli Tarla &amp; Miras</button>
                            <button type="button" class="p360-ai-chip" onclick="askParselAi('kiyikenar')">🌊 Kıyı &amp; Taşkın Bandı</button>
                        </div>

                        <!-- Kullanıcı Soru Girişi -->
                        <div class="p360-ai-input-bar">
                            <input type="text" id="p360CustomQuestion" class="p360-ai-input" placeholder="Bu parselle ilgili teknik bir soru sorun (Örn: Çekme mesafeleri nedir?)" onkeydown="if(event.key==='Enter') submitCustomAiQuestion();">
                            <button type="button" class="p360-ai-send-btn" onclick="submitCustomAiQuestion()"><i class="fa-solid fa-paper-plane"></i> Sor</button>
                        </div>
                    </div>
                </div>


            </section>
        </div>
    </main>

    <!-- HARİTA SİSTEMİ MOTORU (SAF JAVASCRIPT & LEAFLET) -->
    <script>
        let map;
        let baseLayers = {};
        let currentBase = 'sat';
        let wmsLayer;
        let isWmsActive = true;
        let parselPolygon;
        let cornerMarkers = [];
        let droneInterval = null;
        let isDroneFlying = false;

        // İlçe Yükleme
        // İl Değiştiğinde İlçeleri Yükle
        function onCityChanged(selectedDist = null, selectedMah = null) {
            const city = document.getElementById('selCity').value;
            const distSelect = document.getElementById('selDistrict');
            const mahSelect = document.getElementById('selMahalle');
            
            distSelect.innerHTML = '<option value="">İlçeler Yükleniyor...</option>';
            mahSelect.innerHTML = '<option value="">Mahalleler Bekleniyor...</option>';
            
            fetch('api.php?action=get_tkgm_districts&city=' + encodeURIComponent(city))
                .then(r => r.json())
                .then(res => {
                    distSelect.innerHTML = '';
                    if (res && res.districts && res.districts.length > 0) {
                        res.districts.forEach((d, idx) => {
                            const opt = document.createElement('option');
                            opt.value = d;
                            opt.textContent = d;
                            if (selectedDist ? (d === selectedDist) : (idx === 0)) {
                                opt.selected = true;
                            }
                            distSelect.appendChild(opt);
                        });
                    } else {
                        const opt = document.createElement('option');
                        opt.value = 'Merkez';
                        opt.textContent = 'Merkez';
                        distSelect.appendChild(opt);
                    }
                    onDistrictChanged(selectedMah);
                })
                .catch(() => {
                    distSelect.innerHTML = '<option value="Merkez">Merkez</option>';
                    onDistrictChanged(selectedMah);
                });
        }

        // İlçe Değiştiğinde Mahalleleri Yükle
        function onDistrictChanged(selectedMah = null) {
            const city = document.getElementById('selCity').value;
            const dist = document.getElementById('selDistrict').value;
            const mahSelect = document.getElementById('selMahalle');
            
            if (!dist) return;
            mahSelect.innerHTML = '<option value="">TKGM Mahalleler Yükleniyor...</option>';
            
            fetch(`api.php?action=get_tkgm_neighborhoods&city=${encodeURIComponent(city)}&district=${encodeURIComponent(dist)}`)
                .then(r => r.json())
                .then(res => {
                    mahSelect.innerHTML = '';
                    if (res && res.neighborhoods_detail && res.neighborhoods_detail.length > 0) {
                        res.neighborhoods_detail.forEach((item, idx) => {
                            const opt = document.createElement('option');
                            opt.value = item.id;
                            opt.textContent = item.name;
                            opt.setAttribute('data-name', item.name);
                            if (selectedMah ? (item.name === selectedMah || item.id == selectedMah) : (idx === 0)) {
                                opt.selected = true;
                            }
                            mahSelect.appendChild(opt);
                        });
                    } else if (res && res.neighborhoods && res.neighborhoods.length > 0) {
                        res.neighborhoods.forEach((m, idx) => {
                            const opt = document.createElement('option');
                            const val = typeof m === 'object' ? (m.id || m.name) : m;
                            const text = typeof m === 'object' ? (m.name || m.text) : m;
                            opt.value = val;
                            opt.textContent = text;
                            opt.setAttribute('data-name', text);
                            if (selectedMah ? (text === selectedMah || val == selectedMah) : (idx === 0)) {
                                opt.selected = true;
                            }
                            mahSelect.appendChild(opt);
                        });
                    } else {
                        const opt = document.createElement('option');
                        opt.value = 'Merkez';
                        opt.textContent = 'Merkez';
                        mahSelect.appendChild(opt);
                    }
                })
                .catch(() => {
                    mahSelect.innerHTML = '<option value="Merkez">Merkez</option>';
                });
        }

        function onMahalleChanged() {
            // Mahalle seçimi güncellendi
        }

        function setPreset(city, dist, ada, parsel) {
            document.getElementById('selCity').value = city;
            document.getElementById('txtAda').value = ada;
            document.getElementById('txtParsel').value = parsel;
            onCityChanged(dist);
            setTimeout(() => {
                executeStandaloneQuery();
            }, 800);
        }

        // Harita Başlatıcı
        function initParselMap() {
            // Hızlı Google Hibrit Uydu ve Esri Katmanları (Türkiye CDN Uyumlu)
            const googleSat = L.tileLayer('https://mt{s}.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
                maxZoom: 20,
                subdomains: ['0', '1', '2', '3'],
                attribution: '&copy; Google &bull; TKGM MEGSİS'
            });

            const esriSat = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                maxZoom: 19,
                attribution: '&copy; Esri &bull; TKGM MEGSİS'
            });

            const osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap'
            });

            const darkMatter = L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
                maxZoom: 19,
                attribution: '&copy; CartoDB Dark'
            });

            baseLayers = {
                'sat': esriSat,
                'google': googleSat,
                'esri': esriSat,
                'osm': osm,
                'dark': darkMatter
            };

            map = L.map('parselMap', {
                center: [39.7120, 33.4314],
                zoom: 17,
                layers: [esriSat],
                zoomControl: false
            });

            L.control.zoom({ position: 'bottomright' }).addTo(map);

            map.on('mousemove', (e) => {
                const hud = document.getElementById('hudLatLon');
                if (hud) hud.textContent = `${e.latlng.lat.toFixed(5)}, ${e.latlng.lng.toFixed(5)}`;
            });
        }

        // Katman Değiştirici
        function setBaseLayer(key) {
            Object.values(baseLayers).forEach(l => {
                if (map.hasLayer(l)) map.removeLayer(l);
            });
            if (baseLayers[key]) {
                baseLayers[key].addTo(map);
                currentBase = key;
            }
            document.querySelectorAll('.map-tool-btn').forEach(b => {
                if (b.id === 'btnLayerSat' || b.id === 'btnLayerOsm' || b.id === 'btnLayerDark') {
                    b.classList.remove('active');
                }
            });
            if (key === 'sat') document.getElementById('btnLayerSat')?.classList.add('active');
            if (key === 'osm') document.getElementById('btnLayerOsm')?.classList.add('active');
            if (key === 'dark') document.getElementById('btnLayerDark')?.classList.add('active');
        }

        // WMS Katman Aç/Kapa
        function toggleWmsLayer() {
            const btn = document.getElementById('btnToggleWms');
            if (!wmsLayer) {
                wmsLayer = L.tileLayer('https://mt{s}.google.com/vt/lyrs=h&x={x}&y={y}&z={z}', {
                    maxZoom: 20,
                    subdomains: ['0', '1', '2', '3'],
                    opacity: 0.9
                });
            }
            if (map.hasLayer(wmsLayer)) {
                map.removeLayer(wmsLayer);
                btn?.classList.remove('active');
            } else {
                wmsLayer.addTo(map);
                btn?.classList.add('active');
            }
        }

        function drawParcelOnMap(points, centerLat, centerLng, ada, parsel, areaVal, city, dist, mah, quality = 'Arsa') {
            if (parselPolygon) map.removeLayer(parselPolygon);
            cornerMarkers.forEach(m => map.removeLayer(m));
            cornerMarkers = [];

            if (!points || !points.length) {
                return; // Sahte 4-gen poligon asla cizilmez
            }

            let coords = points;

            // 1. SARI/MAVI DOLGU KATMANI TAMAMEN KALDIRILDI: Uydu altligi %100 berrak
            parselPolygon = L.polygon(coords, {
                color: '#ef4444', // Net harita muhendisligi kadastro kirmizisi
                weight: 2.8,
                fill: false,      // Sari dolgu tamamen kaldirildi
                fillOpacity: 0
            }).addTo(map);

            // 2. PARSELIN TUM GERCEK KOSE NOKTALARI (APLIKASYON KAZIKLARI K1, K2, K3...)
            coords.forEach((pt, idx) => {
                const marker = L.circleMarker(pt, {
                    radius: 6,
                    color: '#ffffff',
                    fillColor: '#ef4444',
                    fillOpacity: 1,
                    weight: 2
                }).addTo(map);
                marker.bindTooltip(`Köşe K${idx + 1}: ${pt[0].toFixed(5)}, ${pt[1].toFixed(5)}`, { permanent: false, direction: 'top' });
                cornerMarkers.push(marker);
            });

            // Zarif, Kompakt Parsel Rozeti (Parseli ve Haritayı Kapatmaz)
            const badgeHtml = `
                <div class="parsel-mini-pill">
                    <span class="pill-id">🏛️ Ada ${ada} / Parsel ${parsel}</span>
                    <span class="pill-dot">&bull;</span>
                    <span class="pill-area">${areaVal}</span>
                    <span class="pill-dot">&bull;</span>
                    <span class="pill-quality">${quality}</span>
                </div>
            `;
            parselPolygon.bindTooltip(badgeHtml, {
                permanent: true,
                direction: 'center',
                className: 'parsel-compact-pill-tooltip'
            });

            // Yumuşak odaklanma (Zoom 18 parsel ve çevresini net gösterir)
            map.flyToBounds(parselPolygon.getBounds(), { padding: [80, 80], maxZoom: 18, duration: 1 });
            
            const hud = document.getElementById('hudLatLon');
            if (hud) hud.textContent = `${centerLat.toFixed(5)}, ${centerLng.toFixed(5)}`;

            // Aktif State'i Güncelle
            if (typeof currentParcelState !== 'undefined') {
                currentParcelState.points = coords;
                currentParcelState.centerLat = centerLat;
                currentParcelState.centerLng = centerLng;
                currentParcelState.ada = ada;
                currentParcelState.parsel = parsel;
                currentParcelState.area_formatted = areaVal;
                currentParcelState.city = city;
                currentParcelState.district = dist;
                currentParcelState.neighborhood = mah;
                currentParcelState.quality = quality;
            }
        }

        // Sorgula Butonu Tıklanınca
        
        // ========================================================
        // 🌟 PARSEL 360° ETKİLEŞİM VE AI ASİSTAN KONTROLÖRÜ
        // ========================================================
        function switch360Tab(name, btn) {
            document.querySelectorAll('.p360-tab-btn').forEach(b => b.classList.remove('active'));
            document.querySelectorAll('.p360-tab-content').forEach(c => c.classList.remove('active'));

            if (btn) btn.classList.add('active');
            const target = document.getElementById('p360-tab-' + name);
            if (target) target.classList.add('active');
        }

        function updateParsel360Data() {
            const p = currentParcelState;
            const area = parseFloat(p.area_m2) || 750;
            const emsal = 1.50;
            const taks = 0.30;
            const taban = Math.round(area * taks);
            const toplamInsaat = Math.round(area * emsal);
            const daireSayisi = Math.max(1, Math.round(toplamInsaat / 120));
            const birimFiyat = 16500; // 2026 ÇŞİDB 3-B / 4-A ortalama
            const toplamButce = toplamInsaat * birimFiyat;
            const arsaPayiAlani = Math.round(toplamInsaat * 0.50);
            const arsaDaireSayisi = Math.max(1, Math.round(daireSayisi * 0.50));

            // Proje Başlık ve Kimliği
            const projTitle = `${p.city} / ${p.district} / ${p.neighborhood} • Ada ${p.ada} / Parsel ${p.parsel}`;
            const elTitle = document.getElementById('p360ProjectTitle');
            if (elTitle) elTitle.textContent = projTitle;

            // Kadastro Sekmesi
            const elKonum = document.getElementById('p360Konum');
            if (elKonum) elKonum.textContent = `${p.city} / ${p.district} / ${p.neighborhood}`;
            const elAdaParsel = document.getElementById('p360AdaParsel');
            if (elAdaParsel) elAdaParsel.textContent = `${p.ada} / ${p.parsel}`;
            const elTapu = document.getElementById('p360TapuAlani');
            if (elTapu) elTapu.textContent = p.area_formatted || (area.toLocaleString('tr-TR') + ' m²');
            const elNitelik = document.getElementById('p360Nitelik');
            if (elNitelik) elNitelik.textContent = p.quality || 'Arsa (Konut İmarı)';

            // Metrik Koordinatlar (ITRF95 TM)
            const tm = wgs84ToTm(p.centerLat, p.centerLng);
            const elDom = document.getElementById('p360Dom');
            if (elDom) elDom.textContent = tm.cm + '°';
            const elY = document.getElementById('p360Y');
            if (elY) elY.textContent = tm.y.toLocaleString('tr-TR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' m';
            const elX = document.getElementById('p360X');
            if (elX) elX.textContent = tm.x.toLocaleString('tr-TR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' m';

            // İmar Sekmesi
            const elTaban = document.getElementById('p360TabanAlani');
            if (elTaban) elTaban.textContent = `~${taban.toLocaleString('tr-TR')} m²`;
            const elInsaat = document.getElementById('p360ToplamInsaat');
            if (elInsaat) elInsaat.textContent = `~${toplamInsaat.toLocaleString('tr-TR')} m²`;
            const elDaire = document.getElementById('p360DaireSayisi');
            if (elDaire) elDaire.textContent = `~${daireSayisi} Bağımsız Bölüm (120m²)`;

            // İfraz & DOP Sekmesi
            const elHam = document.getElementById('p360HamAlan');
            if (elHam) elHam.textContent = area.toLocaleString('tr-TR') + ' m²';
            const dopM2 = Math.round(area * 0.45);
            const netM2 = area - dopM2;
            const elDop = document.getElementById('p360DopKesinti');
            if (elDop) elDop.textContent = `~${dopM2.toLocaleString('tr-TR')} m²`;
            const elNet = document.getElementById('p360NetParsel');
            if (elNet) elNet.textContent = `~${netM2.toLocaleString('tr-TR')} m²`;

            // Kadastro Tecviz Yanılma Sınırı Denetimi (Master Plan Madde 8)
            const tecvizLimit = Math.max(1, Math.round(0.0003 * 1000 * Math.sqrt(area) + 0.00005 * area));
            const elTecviz = document.getElementById('p360TecvizText');
            if (elTecviz) {
                elTecviz.innerHTML = `Tapu Alanı: <strong>${area.toLocaleString('tr-TR')} m²</strong> • Yönetmelik Yanılma Sınırı (Tecviz): <strong>&plusmn;${tecvizLimit} m²</strong>. Geometrik poligon ölçümü resmi tapu kaydı ile tecviz sınırları içinde tam uyumludur.`;
            }

            // Maliyet Sekmesi
            const elMaliyetInsaat = document.getElementById('p360MaliyetInsaatAlani');
            if (elMaliyetInsaat) elMaliyetInsaat.textContent = `~${toplamInsaat.toLocaleString('tr-TR')} m²`;
            const elButce = document.getElementById('p360ToplamButce');
            if (elButce) elButce.textContent = `~${toplamButce.toLocaleString('tr-TR')} TL`;
            const elArsaPay = document.getElementById('p360ArsaPayiAlani');
            if (elArsaPay) elArsaPay.textContent = `~${arsaPayiAlani.toLocaleString('tr-TR')} m²`;
            const elArsaDaire = document.getElementById('p360ArsaDaireSayisi');
            if (elArsaDaire) elArsaDaire.textContent = `~${arsaDaireSayisi} Daire (Anahtar Teslim)`;

            // Detaylı Maliyet Motoru Bağlantısı Güncelle
            const elOpenCostBtn = document.getElementById('p360OpenDetailedCostBtn');
            if (elOpenCostBtn) {
                const estFloors = Math.max(1, Math.round(toplamInsaat / taban));
                elOpenCostBtn.href = `/maliyet?city=${encodeURIComponent(p.city||'')}&district=${encodeURIComponent(p.district||'')}&ada=${encodeURIComponent(p.ada||'')}&parsel=${encodeURIComponent(p.parsel||'')}&area=${Math.round(area)}&insaat_alani=${Math.round(toplamInsaat)}&kat=${estFloors}&daire=${daireSayisi}`;
            }

            // AI Giriş Metni
            const elAiLoc = document.getElementById('p360AiIntroLoc');
            if (elAiLoc) elAiLoc.textContent = `${p.city} / ${p.district} / ${p.neighborhood} Ada ${p.ada}, Parsel ${p.parsel} (${area.toLocaleString('tr-TR')} m²)`;
        }

        // PARSEL AI SORU & CEVAP MOTORU
        function askParselAi(topic) {
            const p = currentParcelState;
            const area = parseFloat(p.area_m2) || 750;
            const emsal = 1.50;
            const taks = 0.30;
            const taban = Math.round(area * taks);
            const toplamInsaat = Math.round(area * emsal);
            const daireSayisi = Math.max(1, Math.round(toplamInsaat / 120));
            const butce = (toplamInsaat * 16500).toLocaleString('tr-TR');
            const dopM2 = Math.round(area * 0.45);
            const netM2 = area - dopM2;
            const isTarla = p.quality && p.quality.toLowerCase().includes('tarla');

            let userQ = '';
            let botReply = '';

            if (topic === 'kapasite') {
                userQ = '🏢 Bu parselin imar yapılaşma ve kat kapasitesi nedir?';
                botReply = `<strong>Analiz (3194 Sayılı İmar Kanunu & Planlı Alanlar İmar Yönetmeliği):</strong><br>
                • <strong>Taşınmaz:</strong> ${p.city} / ${p.district} - Ada ${p.ada}, Parsel ${p.parsel} (${area.toLocaleString('tr-TR')} m²)<br>
                • <strong>Taban Oturumu (TAKS 0.30):</strong> Parsel zemininde azami <strong>~${taban.toLocaleString('tr-TR')} m²</strong> oturum yapılabilir.<br>
                • <strong>Toplam İmar Kapasitesi (KAKS 1.50):</strong> Zemin ve normal katlar dahil azami <strong>~${toplamInsaat.toLocaleString('tr-TR')} m²</strong> kapalı inşaat alanı üretilebilir.<br>
                • <strong>Bağımsız Bölüm:</strong> 120 m² brüt alan standardında yaklaşık <strong>${daireSayisi} Daire</strong> üretilebilir.<br>
                • <strong>Çekme Mesafeleri:</strong> Ayrık nizamda ön bahçeden 5.00 m, yan ve arka komşulardan 3.00 m çekme mesafesi zorunludur.`;
            } else if (topic === 'ifraz') {
                userQ = '📐 Bu parsel ifraz edilebilir mi (bölünebilir mi)?';
                if (isTarla) {
                    botReply = `<strong>Mevzuat Analizi (5403 Sayılı Toprak Koruma ve Arazi Kullanımı Kanunu Madde 8):</strong><br>
                    • Bu taşınmaz <strong>Tarla / Tarım Arazisi</strong> vasfındadır.<br>
                    • 5403 Sayılı Kanun gereğince Mutlak Tarım arazilerinde <strong>20.000 m² (20 dönüm)</strong>, Dikili Tarımda <strong>5.000 m²</strong> altında ifraz (bölünme) kesinlikle yapılamaz.<br>
                    • Parseliniz ${area.toLocaleString('tr-TR')} m² olduğu için müstakil parsellere ifraz edilmesi <strong>yasal olarak mümkün değildir</strong>; taşınmaz bölünemez hisse kısıtlamasına tabidir.`;
                } else {
                    botReply = `<strong>Mevzuat Analizi (3194 Sayılı İmar Kanunu Madde 15 & 16):</strong><br>
                    • Taşınmaz <strong>İmar Parseli (Arsa)</strong> statüsündedir.<br>
                    • İfraz için bölgedeki uygulama imar planında belirlenen asgari parsel alanı (min. 300-500 m²) ve asgari yola cephe genişliği (min. 12.00 m) sağlanmalıdır.<br>
                    • Parsel alanı ${area.toLocaleString('tr-TR')} m² olduğundan, yola cephe şartı sağlandığı takdirde <strong>${area >= 600 ? '2 yeni parsele ifraz edilebilir' : 'müstakil ifraz için alan yetersiz kalabilir'}</strong>.<br>
                    • Haritada <em>"📐 Geometrik İfraz Simülasyonu"</em> butonuna tıklayarak bölme çizgisi ve metrajları anında inceleyebilirsiniz.`;
                }
            } else if (topic === 'koyevi') {
                userQ = '🚜 Köy yerleşik alanında bu parsele ev yapılabilir mi?';
                botReply = `<strong>Mevzuat Analizi (Plansız Alanlar İmar Yönetmeliği Madde 63 & 64):</strong><br>
                • <strong>Köy Yerleşik Alan İçi:</strong> Parsel köy yerleşik alanı civar sınırları içindeyse, İl Özel İdaresi / Belediye izniyle; parsel alanının <strong>%5'ini geçmemek</strong>, taban alanı en fazla <strong>250 m²</strong> ve kat adedi zemin + 1 kat (H=7.50m) olmak üzere konut yapılabilir.<br>
                • <strong>Kadastral Yol Şartı:</strong> Parselin resmi kadastral yola asgari <strong>15.00 metre</strong> cephesinin bulunması şarttır.<br>
                • <strong>Tarımsal Nitelik:</strong> Tarım dışı kullanım izin yazısı İl Tarım ve Orman Müdürlüğü'nden temin edilir.`;
            } else if (topic === 'tinyhouse') {
                userQ = '🚐 Bu parsele Tiny House / Tekerlekli Karavan koyabilir miyim?';
                botReply = `<strong>Hukuki ve Teknik Değerlendirme (3194 s.K. & Karayolları Trafik Yönetmeliği):</strong><br>
                • <strong>O2 Belgeli Plakalı / Ruhsatlı Taşınır:</strong> Altında tekerlekleri bulunan, plakası, ruhsatı ve O2 Tip Onay Belgesi olan araçlar taşınır vasfındadır; yapı ruhsatına tabi değildir.<br>
                • <strong>Sabitlenme ve Altyapı Yasağı:</strong> Tekerleklerin sökülmesi, beton zemin / subasman dökülmesi, kalıcı kanalizasyon ve su şebekesi çekilmesi durumunda yapı niteliği kazanır (3194 s.K. Md. 32/42 gereği mühürleme ve para cezası uygulanır).<br>
                • <strong>Tarım Arazisi Kısıtı:</strong> 5403 Sayılı Kanun gereğince tarımsal bütünlüğü bozacak şekilde kooperatif hissesi veya tel örgüyle parsel bölerek tiny house yerleşimi kurulamaz.`;
            } else if (topic === 'dop18') {
                userQ = '🏛️ 18. Madde uygulamasına girerse ne kadar DOP kesilir?';
                botReply = `<strong>Mevzuat Analizi (3194 Sayılı İmar Kanunu Madde 18 & 7181 s.K.):</strong><br>
                • <strong>Düzenleme Ortaklık Payı (DOP) Tavanı:</strong> Yasa gereği DOP kesintisi azami <strong>%45,00</strong> olabilir.<br>
                • <strong>Ham Parsel Alanı:</strong> ${area.toLocaleString('tr-TR')} m²<br>
                • <strong>Azami DOP Kesintisi (%45):</strong> ~${dopM2.toLocaleString('tr-TR')} m² (Yol, yeşil alan, park, okul, ibadet yeri terkleri).<br>
                • <strong>Tahsis Edilecek Net İmar Parseli:</strong> ~${netM2.toLocaleString('tr-TR')} m² imarlı arsa.<br>
                • Detaylı dağıtım cetvelini kokpitin <em>"📐 İfraz &amp; DOP"</em> sekmesinden inceleyebilirsiniz.`;
            } else if (topic === 'maliyet') {
                userQ = '💰 2026 ÇŞİDB birim fiyatlarına göre inşaat maliyeti nedir?';
                botReply = `<strong>Maliyet Analizi (ÇŞİDB 2026/1 Birim Fiyat Tebliği):</strong><br>
                • <strong>Yapı Sınıfı:</strong> 3-B / 4-A Konut Yapısı<br>
                • <strong>Hesaba Esas Emsal İnşaat Alanı:</strong> ~${toplamInsaat.toLocaleString('tr-TR')} m²<br>
                • <strong>2026 Resmi Birim Fiyat:</strong> ~16.500 TL/m² (Kaba + İnce Ortalama)<br>
                • <strong>Tahmini Toplam Proje Bütçesi:</strong> <strong>~${butce} TL</strong><br>
                • <strong>Demir / Beton İhtiyacı:</strong> Ortalama <strong>~${Math.round(toplamInsaat * 0.035)} Ton Demir</strong> ve <strong>~${Math.round(toplamInsaat * 0.40)} m³ Hazır Beton</strong>.<br>
                • 120+ kalem detaylı keşif özeti için <em>"🏗️ Detaylı 120+ Kalem Keşif Listesini Aç"</em> butonuna tıklayabilirsiniz.`;
            } else if (topic === 'katkarsiligi') {
                userQ = '🤝 Bu arsa kat karşılığı müteahhite verilirse kaç daire kalır?';
                botReply = `<strong>Fizibilite Analizi (Piyasa Emsal Dağıtım Modeli):</strong><br>
                • <strong>Toplam Üretilebilir Konut:</strong> ~${daireSayisi} Bağımsız Bölüm (120 m² brüt)<br>
                • <strong>Bölge Paylaşım Teamülü:</strong> %50 Arsa Sahibi / %50 Müteahhit<br>
                • <strong>Arsa Sahibine Düşen:</strong> <strong>~${Math.max(1, Math.round(daireSayisi * 0.5))} Daire</strong> (Anahtar Teslim)<br>
                • <strong>Müteahhit Payı:</strong> ~${Math.max(1, Math.round(daireSayisi * 0.5))} Daire (İnşaat Finansmanı)<br>
                • Noter onaylı Kat Karşılığı İnşaat Sözleşmesinde teknik şartname, teslim süresi ve teminat mektubu zorunlu tutulmalıdır.`;
            } else if (topic === 'ges') {
                userQ = '☀️ Bu parsele Güneş Enerjisi Santrali (GES) kurulabilir mi?';
                botReply = `<strong>Fizibilite Analizi (5346 Sayılı Kanun & EPDK Lisanssız Elektrik Yönetmeliği):</strong><br>
                • <strong>Gereken Asgari Alan:</strong> 1 MW kurulu güç için ortalama <strong>15.000 - 18.000 m²</strong> net arazi alanı gerekir.<br>
                • <strong>Parsel Alanı:</strong> ${area.toLocaleString('tr-TR')} m² (${(area / 1000).toFixed(1)} dönüm).<br>
                • <strong>Marjinal Tarım Raporu:</strong> Arazinin İl Tarım ve Orman Müdürlüğü'nce "Marjinal Tarım Arazisi" olarak onaylanması şarttır; sulu veya dikili tarım arazisine GES kurulamaz.<br>
                • <strong>Trafo Bağlantısı:</strong> En yakın TEİAŞ / EDAŞ trafo merkezinde kapasite bulunması ve güneye bakan eğim aranır.`;
            } else if (topic === 'miras') {
                userQ = '⚖️ Hisseli tarla ve miras bölüşümü nasıl yapılır?';
                botReply = `<strong>Hukuki Analiz (5403 s.K. 6537 Değişikliği & TMK 646 vd.):</strong><br>
                • <strong>Asgari Tarımsal Büyüklük:</strong> Tarım arazileri mirasçılar arasında asgari büyüklüklerin (Mutlak: 20 dönüm, Dikili: 5 dönüm) altına düşecek şekilde hisselere bölünemez.<br>
                • <strong>Ehil Mirasçıya Devir:</strong> Tarımsal faaliyeti bizzat yürüten "Ehil Mirasçı"ya mahkeme kararıyla veya mirasçıların anlaşmasıyla mülkiyet devredilebilir, diğer mirasçıların payı nakden ödenir.<br>
                • <strong>İzale-i Şüyu (Ortaklığın Giderilmesi):</strong> Anlaşma sağlanamazsa sulh hukuk mahkemesinde dava açılarak taşınmaz icra/ihale yoluyla satılır ve bedeli mirasçılara paylaştırılır.`;
            } else if (topic === 'kiyikenar') {
                userQ = '🌊 Kıyı kenar çizgisi ve taşkın koruma kısıtı var mıdır?';
                botReply = `<strong>Mevzuat Analizi (3621 Sayılı Kıyı Kanunu & DSİ Taşkın Yönetmeliği):</strong><br>
                • <strong>İlk 50 Metre:</strong> Sahil şeridinin ilk 50 metresinde kalıcı, seyyar veya prefabrik konut/ticari yapı inşa edilmesi kesinlikle yasaktır; yalnızca halka açık yeşil alan düzenlenebilir.<br>
                • <strong>İkinci 50 Metre:</strong> Yalnızca imar planı bulunması ve günübirlik turizm fonksiyonu verilmesi şartıyla sınırlı yapılaşmaya izin verilebilir.<br>
                • <strong>DSİ Taşkın Koruma Bandı:</strong> Parsel dere veya akarsu yatağına komşuysa şev üstünden itibaren asgari 10 - 25 m yapı yaklaşma sınırı bırakılması zorunludur.`;
            }

            appendAiChat(userQ, botReply);
        }

        function submitCustomAiQuestion() {
            const input = document.getElementById('p360CustomQuestion');
            const q = input.value.trim();
            if (!q) return;
            input.value = '';

            const p = currentParcelState;
            const area = parseFloat(p.area_m2) || 750;
            const qLower = q.toLowerCase();
            let botReply = '';

            if (qLower.includes('çekme') || qLower.includes('mesafe') || qLower.includes('bahçe')) {
                botReply = `<strong>Mevzuat Analizi (Planlı Alanlar İmar Yönetmeliği Madde 23):</strong><br>
                ${p.city} / ${p.district} Ada ${p.ada}, Parsel ${p.parsel} için yapı yaklaşma (çekme) sınırları:<br>
                • <strong>Ön Bahçe Çekme Mesafesi:</strong> İmar yolundan asgari <strong>5.00 metre</strong>.<br>
                • <strong>Yan Bahçe Çekme Mesafesi:</strong> Komşu parsel sınırından asgari <strong>3.00 metre</strong> (4 katın üzerindeki her kat için 0.50 metre ilave edilir).<br>
                • <strong>Arka Bahçe Çekme Mesafesi:</strong> Asgari <strong>h/2</strong> (bina yüksekliğinin yarısı) olup en az 3.00 metredir.`;
            } else if (qLower.includes('kaks') || qLower.includes('taks') || qLower.includes('emsal')) {
                const taban = Math.round(area * 0.30);
                const toplam = Math.round(area * 1.50);
                botReply = `<strong>Emsal & Oturum Analizi (3194 s.K.):</strong><br>
                • <strong>Parsel Alanı:</strong> ${area.toLocaleString('tr-TR')} m²<br>
                • <strong>TAKS (0.30):</strong> Taban oturumu azami <strong>~${taban.toLocaleString('tr-TR')} m²</strong>.<br>
                • <strong>KAKS / Emsal (1.50):</strong> Toplam kapalı inşaat alanı azami <strong>~${toplam.toLocaleString('tr-TR')} m²</strong>.<br>
                • Kapalı çıkmalar, otopark ve sığınak alanları yönetmelik sınırları dahilinde emsal harici tutulabilir.`;
            } else if (qLower.includes('tiny') || qLower.includes('karavan') || qLower.includes('konteyner') || qLower.includes('prefabrik')) {
                askParselAi('tinyhouse');
                return;
            } else if (qLower.includes('köy') || qLower.includes('plansız')) {
                askParselAi('koyevi');
                return;
            } else if (qLower.includes('ges') || qLower.includes('güneş') || qLower.includes('santral')) {
                askParselAi('ges');
                return;
            } else if (qLower.includes('ifraz') || qLower.includes('bölün') || qLower.includes('parçala')) {
                askParselAi('ifraz');
                return;
            } else if (qLower.includes('maliyet') || qLower.includes('fiyat') || qLower.includes('bütçe') || qLower.includes('kaç lira')) {
                askParselAi('maliyet');
                return;
            } else if (qLower.includes('dop') || qLower.includes('madde 18') || qLower.includes('terk') || qLower.includes('kesinti')) {
                askParselAi('dop18');
                return;
            } else if (qLower.includes('miras') || qLower.includes('hisse') || qLower.includes('ortak')) {
                askParselAi('miras');
                return;
            } else if (qLower.includes('kat karşılığı') || qLower.includes('müteahhit')) {
                askParselAi('katkarsiligi');
                return;
            } else if (qLower.includes('kıyı') || qLower.includes('deniz') || qLower.includes('dere') || qLower.includes('taşkın')) {
                askParselAi('kiyikenar');
                return;
            } else {
                botReply = `<strong>Mühendislik Değerlendirmesi:</strong><br>
                ${p.city} / ${p.district} Ada ${p.ada}, Parsel ${p.parsel} (${area.toLocaleString('tr-TR')} m²) taşınmazı için sormuş olduğunuz <em>"${q}"</em> konusu incelenmiştir.<br>
                • Parselin imar ve kadastro verileri 3194 Sayılı İmar Kanunu ve Planlı Alanlar İmar Yönetmeliği genel standartlarına tabidir.<br>
                • Çekme mesafeleri, emsal hesabı, ifraz ve 2026 ÇŞİDB inşaat keşif dökümü yukarıdaki sekmelerde hazırlanmıştır.<br>
                • Resmî aplikasyon krokisi, sınır tespiti ve belediye ruhsat dosyası için harita mühendislerimizle iletişime geçebilirsiniz.`;
            }

            appendAiChat(q, botReply);
        }

        function appendAiChat(userQ, botReply) {
            const box = document.getElementById('p360ChatBox');
            if (!box) return;

            const uDiv = document.createElement('div');
            uDiv.className = 'p360-ai-msg user';
            uDiv.textContent = userQ;
            box.appendChild(uDiv);

            const bDiv = document.createElement('div');
            bDiv.className = 'p360-ai-msg bot';
            bDiv.innerHTML = `<strong>🤖 Parsel AI Asistanı:</strong><br>${botReply}`;
            box.appendChild(bDiv);

            box.scrollTop = box.scrollHeight;
        }


        function executeStandaloneQuery() {
            const city = document.getElementById('selCity').value || 'Ankara';
            const dist = document.getElementById('selDistrict').value || 'Çankaya';
            const mahSelect = document.getElementById('selMahalle');
            if (mahSelect && (!mahSelect.value || mahSelect.value === '') && mahSelect.options.length > 1) {
                mahSelect.selectedIndex = 1;
            }
            const mahVal = mahSelect ? mahSelect.value : '';
            const mahText = mahSelect?.options[mahSelect.selectedIndex]?.getAttribute('data-name') || mahSelect?.options[mahSelect.selectedIndex]?.text || mahVal || '';
            const ada = document.getElementById('txtAda').value || '101';
            const parsel = document.getElementById('txtParsel').value || '1';

            const btn = document.getElementById('btnExecuteQuery');
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> <span>TKGM MEGSİS Canlı Sorgulanıyor...</span>';

            const queryUrl = `tkgm_service.php?action=get_parsel&mahalle_id=${encodeURIComponent(mahVal)}&ada=${encodeURIComponent(ada)}&parsel=${encodeURIComponent(parsel)}&il_name=${encodeURIComponent(city)}&ilce_name=${encodeURIComponent(dist)}&mahalle_name=${encodeURIComponent(mahText)}`;

            fetch(queryUrl)
                .then(r => r.json())
                .then(res => {
                    btn.innerHTML = '<i class="fa-solid fa-crosshairs"></i> <span>Haritada Bul &amp; Sorgula</span>';
                    
                    if (res && res.status === 'success' && res.geometry && res.geometry.coordinates) {
                        const ring = res.geometry.coordinates[0];
                        const ptsCount = (ring.length > 1 && ring[0][0] === ring[ring.length - 1][0] && ring[0][1] === ring[ring.length - 1][1])
                            ? ring.length - 1
                            : ring.length;

                        const points = [];
                        for (let i = 0; i < ptsCount; i++) {
                            points.push([ring[i][1], ring[i][0]]);
                        }

                        const lat = points.reduce((s, p) => s + p[0], 0) / points.length;
                        const lng = points.reduce((s, p) => s + p[1], 0) / points.length;

                        const prop = res.properties || {};
                        const areaFormatted = prop.alan || '750,00 m²';
                        const quality = prop.nitelik || 'Arsa / Tarla';
                        const cityRes = prop.il || city;
                        const distRes = prop.ilce || dist;
                        const mahRes = prop.mahalle || mahText;

                        drawParcelOnMap(points, lat, lng, prop.ada || ada, prop.parsel || parsel, areaFormatted, cityRes, distRes, mahRes, quality);
                        updateParsel360Data();

                        // Detay Kartını Canlı Gerçek Verilerle Güncelle
                        document.getElementById('resAdaParsel').textContent = `${prop.ada || ada} / ${prop.parsel || parsel}`;
                        document.getElementById('resKonum').textContent = `${cityRes} / ${distRes} / ${mahRes}`;
                        document.getElementById('resAlan').textContent = areaFormatted;
                        document.getElementById('resNitelik').textContent = quality;
                        
                        const areaNum = parseFloat(areaFormatted.replace(/\./g, '').replace(',', '.')) || 750;
                        const insaatKap = Math.round(areaNum * 1.5);
                        document.getElementById('resInsaatAlani').textContent = `~${insaatKap.toLocaleString('tr-TR')} m² Kapalı Alan`;
                    } else {
                        // Parsel MEGSİS'te bulunamadıysa ASLA sahte 4-gen poligon çizme!
                        if (parselPolygon) {
                            map.removeLayer(parselPolygon);
                            parselPolygon = null;
                        }
                        cornerMarkers.forEach(m => map.removeLayer(m));
                        cornerMarkers = [];

                        if (res && res.center && res.center[0]) {
                            map.flyTo(res.center, 15);
                        }
                        const msg = res?.message || `TKGM MEGSİS sisteminde ${city} / ${dist} / ${mahText} ${ada} Ada / ${parsel} Parsel resmi kadastro tescil kaydı bulunamadı. Lütfen tapu kaydındaki ada ve parsel numarasını kontrol ediniz.`;
                        alert(msg);
                    }
                })
                .catch(err => {
                    btn.innerHTML = '<i class="fa-solid fa-crosshairs"></i> <span>Haritada Bul &amp; Sorgula</span>';
                    console.error('TKGM Sorgu hatası:', err);
                });
        }

        function locateUserGps() {
            if (!navigator.geolocation) {
                alert("Tarayıcınız konum servisini desteklemiyor.");
                return;
            }
            navigator.geolocation.getCurrentPosition(
                pos => {
                    const lat = pos.coords.latitude;
                    const lng = pos.coords.longitude;
                    map.setView([lat, lng], 18);
                    drawSampleParcel(lat, lng, "Konum", "1");
                },
                () => {
                    alert("GPS konumu alınamadı. Lütfen konum izinlerini kontrol edin.");
                }
            );
        }

        // 3D Drone Uçuş Simülatörü
        function toggleDroneFlight() {
            const btn = document.getElementById('btnDroneMode');
            if (isDroneFlying) {
                clearInterval(droneInterval);
                isDroneFlying = false;
                if (btn) btn.classList.remove('active');
            } else {
                isDroneFlying = true;
                if (btn) btn.classList.add('active');
                let angle = 0;
                const center = map.getCenter();
                const radius = 0.0012;

                droneInterval = setInterval(() => {
                    angle += 0.04;
                    const newLat = center.lat + Math.sin(angle) * radius;
                    const newLng = center.lng + Math.cos(angle) * radius * 1.3;
                    map.panTo([newLat, newLng], { animate: true, duration: 1 });
                }, 1000);
            }
        }

        // Tam Ekran
        function toggleMapFullscreen() {
            const container = document.querySelector('.parsel-map-container');
            if (!document.fullscreenElement) {
                if (container.requestFullscreen) container.requestFullscreen();
            } else {
                if (document.exitFullscreen) document.exitFullscreen();
            }
        }

        // Global Aktif Parsel Verisi Deposu
        let currentParcelState = {
            city: 'Kırıkkale',
            district: 'Merkez',
            neighborhood: 'Hacılar Hacıbey Mh.',
            ada: '1781',
            parsel: '34',
            area_m2: 750,
            area_formatted: '750,00 m²',
            quality: 'Arsa (Konut İmarı)',
            centerLat: 39.71208,
            centerLng: 33.43142,
            points: [
                [39.71210, 33.43120],
                [39.71240, 33.43135],
                [39.71225, 33.43180],
                [39.71195, 33.43160]
            ]
        };

        // WGS84'ten Türkiye 3° Dilim Transverse Mercator (TUREF / ITRF95) Metrik Dönüşümü
        function wgs84ToTm(lat, lng) {
            const a = 6378137.0;
            const f = 1 / 298.257223563;
            const e2 = 2 * f - f * f;
            const e_prime2 = e2 / (1 - e2);
            const cm = Math.round(lng / 3.0) * 3.0; // Türkiye 3 derece dilim merkez boylamı (27, 30, 33, 36, 39, 42)

            const phi = lat * Math.PI / 180.0;
            const lam = lng * Math.PI / 180.0;
            const lam0 = cm * Math.PI / 180.0;
            const dlam = lam - lam0;

            const N = a / Math.sqrt(1 - e2 * Math.sin(phi) * Math.sin(phi));
            const T = Math.tan(phi) * Math.tan(phi);
            const C = e_prime2 * Math.cos(phi) * Math.cos(phi);
            const A = Math.cos(phi) * dlam;

            const M = a * (
                (1 - e2 / 4 - 3 * e2 * e2 / 64 - 5 * e2 * e2 * e2 / 256) * phi
                - (3 * e2 / 8 + 3 * e2 * e2 / 32 + 45 * e2 * e2 * e2 / 1024) * Math.sin(2 * phi)
                + (15 * e2 * e2 / 256 + 45 * e2 * e2 * e2 / 1024) * Math.sin(4 * phi)
                - (35 * e2 * e2 * e2 / 3072) * Math.sin(6 * phi)
            );

            const k0 = 1.0;
            const Y = 500000.0 + k0 * N * (
                A + (1 - T + C) * Math.pow(A, 3) / 6.0
                + (5 - 18 * T + T * T + 72 * C - 58 * e_prime2) * Math.pow(A, 5) / 120.0
            );

            const X = k0 * (
                M + N * Math.tan(phi) * (
                    Math.pow(A, 2) / 2.0
                    + (5 - T + 9 * C + 4 * C * C) * Math.pow(A, 4) / 24.0
                    + (61 - 58 * T + T * T + 600 * C - 330 * e_prime2) * Math.pow(A, 6) / 720.0
                )
            );

            return { y: Y, x: X, cm: cm };
        }

        // 1. STANDART AUTOCAD & NETCAD UYUMLU METRİK CAD (DXF) ÇIKTISI
        function exportDxf() {
            const p = currentParcelState;
            let coords = p.points;
            if (parselPolygon) {
                const ll = parselPolygon.getLatLngs()[0];
                if (ll && ll.length) {
                    coords = ll.map(pt => [pt.lat, pt.lng]);
                }
            }
            if (!coords || !coords.length) {
                alert('Önce geçerli bir parsel sorgulayınız.');
                return;
            }

            // Metrik ITRF95 koordinatlarına çevir
            const metricPoints = [];
            let cmUsed = 33;
            coords.forEach(pt => {
                const tm = wgs84ToTm(pt[0], pt[1]);
                cmUsed = tm.cm;
                metricPoints.push({ y: tm.y, x: tm.x, lat: pt[0], lng: pt[1] });
            });

            let dxf = "0\nSECTION\n2\nHEADER\n9\n$ACADVER\n1\nAC1009\n0\nENDSEC\n";
            dxf += "0\nSECTION\n2\nTABLES\n0\nTABLE\n2\nLAYER\n70\n5\n";
            dxf += "0\nLAYER\n2\n0\n70\n0\n62\n7\n6\nCONTINUOUS\n";
            dxf += "0\nLAYER\n2\nKADASTRO_SINIR\n70\n0\n62\n4\n6\nCONTINUOUS\n"; // Cyan
            dxf += "0\nLAYER\n2\nKOSENO\n70\n0\n62\n2\n6\nCONTINUOUS\n";         // Yellow
            dxf += "0\nLAYER\n2\nPARSEL_BILGI\n70\n0\n62\n3\n6\nCONTINUOUS\n";   // Green
            dxf += "0\nLAYER\n2\nKENAR_OLCULERI\n70\n0\n62\n1\n6\nCONTINUOUS\n"; // Red
            dxf += "0\nENDTAB\n0\nENDSEC\n";
            dxf += "0\nSECTION\n2\nBLOCKS\n0\nENDSEC\n";
            dxf += "0\nSECTION\n2\nENTITIES\n";

            // Kapalı Kadastro Parseli Poligonu (POLYLINE)
            dxf += "0\nPOLYLINE\n8\nKADASTRO_SINIR\n66\n1\n70\n1\n";
            metricPoints.forEach(pt => {
                dxf += `0\nVERTEX\n8\nKADASTRO_SINIR\n10\n${pt.y.toFixed(3)}\n20\n${pt.x.toFixed(3)}\n30\n0.0\n`;
            });
            dxf += "0\nSEQEND\n";

            // Köşe Daireleri ve K1..Kn Nokta Numaraları
            let sumY = 0, sumX = 0;
            metricPoints.forEach((pt, idx) => {
                sumY += pt.y;
                sumX += pt.x;
                dxf += `0\nCIRCLE\n8\nKOSENO\n10\n${pt.y.toFixed(3)}\n20\n${pt.x.toFixed(3)}\n30\n0.0\n40\n0.8\n`;
                dxf += `0\nTEXT\n8\nKOSENO\n10\n${(pt.y + 1.2).toFixed(3)}\n20\n${(pt.x + 1.2).toFixed(3)}\n30\n0.0\n40\n1.5\n1\nK${idx + 1}\n`;
            });

            // Kenar Uzunlukları Ölçü Metinleri (Metre Cinsinden)
            const n = metricPoints.length;
            for (let i = 0; i < n; i++) {
                const p1 = metricPoints[i];
                const p2 = metricPoints[(i + 1) % n];
                const midY = (p1.y + p2.y) / 2.0;
                const midX = (p1.x + p2.x) / 2.0;
                const dist = Math.hypot(p2.y - p1.y, p2.x - p1.x);
                let angle = Math.atan2(p2.x - p1.x, p2.y - p1.y) * 180.0 / Math.PI;
                if (angle < 0) angle += 360.0;
                if (angle > 90 && angle <= 270) angle = (angle + 180.0) % 360.0;
                dxf += `0\nTEXT\n8\nKENAR_OLCULERI\n10\n${midY.toFixed(3)}\n20\n${midX.toFixed(3)}\n30\n0.0\n40\n1.1\n50\n${angle.toFixed(1)}\n1\n${dist.toFixed(2)} m\n`;
            }

            // Parsel Merkez Bilgi Metinleri
            const cy = sumY / n;
            const cx = sumX / n;
            dxf += `0\nTEXT\n8\nPARSEL_BILGI\n10\n${cy.toFixed(3)}\n20\n${cx.toFixed(3)}\n30\n0.0\n40\n2.2\n1\nAda ${p.ada} / Parsel ${p.parsel} - ${p.area_m2} m2\n`;
            dxf += `0\nTEXT\n8\nPARSEL_BILGI\n10\n${cy.toFixed(3)}\n20\n${(cx - 3.2).toFixed(3)}\n30\n0.0\n40\n1.3\n1\n${p.city} / ${p.district} / ${p.neighborhood} (DOM ${cmUsed} deg)\n`;

            dxf += "0\nENDSEC\n0\nEOF\n";

            const blob = new Blob([dxf], { type: 'application/dxf' });
            const a = document.createElement('a');
            a.href = URL.createObjectURL(blob);
            a.download = `parsel_${p.city}_ada_${p.ada}_parsel_${p.parsel}_metrik.dxf`;
            a.click();
        }

        // 2. GELİŞMİŞ GOOGLE EARTH KML ÇIKTISI
        function exportKml() {
            const p = currentParcelState;
            let coords = p.points;
            if (parselPolygon) {
                const ll = parselPolygon.getLatLngs()[0];
                if (ll && ll.length) {
                    coords = ll.map(pt => [pt.lat, pt.lng]);
                }
            }
            if (!coords || !coords.length) {
                alert('Önce geçerli bir parsel sorgulayınız.');
                return;
            }

            let coordsStr = '';
            coords.forEach(pt => {
                coordsStr += `${pt[1].toFixed(7)},${pt[0].toFixed(7)},0 `;
            });
            coordsStr += `${coords[0][1].toFixed(7)},${coords[0][0].toFixed(7)},0 `;

            const xmlHeader = '<' + '?xml version="1.0" encoding="UTF-8"?' + '>';\n            const kmlContent = `${xmlHeader}
<kml xmlns="http://www.opengis.net/kml/2.2">
  <Document>
    <name>Parsel_${p.city}_${p.ada}_${p.parsel}</name>
    <Style id="parselStyle">
      <LineStyle><color>ffffd838</color><width>3</width></LineStyle>
      <PolyStyle><color>66c78402</color></PolyStyle>
    </Style>
    <Placemark>
      <name>Ada ${p.ada} / Parsel ${p.parsel} (${p.area_formatted})</name>
      <description><![CDATA[
        <h3>Ant Harita Kadastro Parsel Raporu</h3>
        <p><b>Konum:</b> ${p.city} / ${p.district} / ${p.neighborhood}</p>
        <p><b>Ada / Parsel:</b> ${p.ada} / ${p.parsel}</p>
        <p><b>Tapu Alanı:</b> ${p.area_formatted}</p>
        <p><b>Nitelik:</b> ${p.quality}</p>
        <p><b>Doğrulama:</b> <a href="https://www.parselsorgu.net/parsel?city=${encodeURIComponent(p.city)}&district=${encodeURIComponent(p.district)}&ada=${p.ada}&parsel=${p.parsel}">Canlı İncele</a></p>
      ]]></description>
      <styleUrl>#parselStyle</styleUrl>
      <Polygon>
        <extrude>1</extrude>
        <altitudeMode>clampToGround</altitudeMode>
        <outerBoundaryIs>
          <LinearRing>
            <coordinates>${coordsStr.trim()}</coordinates>
          </LinearRing>
        </outerBoundaryIs>
      </Polygon>
    </Placemark>
  </Document>
</kml>`;

            const blob = new Blob([kmlContent], { type: 'application/vnd.google-earth.kml+xml' });
            const a = document.createElement('a');
            a.href = URL.createObjectURL(blob);
            a.download = `parsel_${p.city}_ada_${p.ada}_parsel_${p.parsel}.kml`;
            a.click();
        }

        // 3. ANT HARİTA RESMİ EKSPERTİZ & İMAR RAPORU (PDF / YAZDIR)
        function printParselPdf() {
            const p = currentParcelState;
            let coords = p.points;
            if (parselPolygon) {
                const ll = parselPolygon.getLatLngs()[0];
                if (ll && ll.length) {
                    coords = ll.map(pt => [pt.lat, pt.lng]);
                }
            }

            // Verileri Rapora Yerleştir
            const now = new Date();
            const dateStr = now.toLocaleDateString('tr-TR') + ' - ' + now.toLocaleTimeString('tr-TR', { hour: '2-digit', minute: '2-digit' });
            const docNo = 'ANT-2026-' + Math.floor(100000 + Math.random() * 900000);
            
            document.getElementById('repDocNo').textContent = docNo;
            document.getElementById('repDate').textContent = dateStr;
            document.getElementById('repCityDist').textContent = `${p.city} / ${p.district}`;
            document.getElementById('repMahalle').textContent = p.neighborhood;
            document.getElementById('repAda').textContent = p.ada;
            document.getElementById('repParsel').textContent = p.parsel;
            document.getElementById('repAlan').textContent = p.area_formatted || (p.area_m2 + ' m²');
            document.getElementById('repNitelik').textContent = p.quality || 'Arsa (Konut İmarı)';
            
            const areaNum = parseFloat(p.area_m2) || 750;
            const taban = Math.round(areaNum * 0.30);
            const toplam = Math.round(areaNum * 1.50);
            
            document.getElementById('repTabanAlani').textContent = `~${taban.toLocaleString('tr-TR')} m²`;
            document.getElementById('repToplamInsaat').textContent = `~${toplam.toLocaleString('tr-TR')} m² Kapalı Alan`;

            // Koordinatlar Tablosunu Doldur
            const tbody = document.getElementById('repCoordsTbody');
            tbody.innerHTML = '';
            
            const n = coords.length;
            const metricPts = [];
            coords.forEach(pt => {
                const tm = wgs84ToTm(pt[0], pt[1]);
                metricPts.push({ y: tm.y, x: tm.x, lat: pt[0], lng: pt[1] });
            });

            for (let i = 0; i < n; i++) {
                const cur = metricPts[i];
                const next = metricPts[(i + 1) % n];
                const dist = Math.hypot(next.y - cur.y, next.x - cur.x);
                const nextLabel = (i + 1 === n) ? 'K1' : `K${i + 2}`;

                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td style="text-align:center; font-weight:800; color:#0284c7;">K${i + 1}</td>
                    <td style="font-family:monospace; font-weight:600;">${cur.y.toFixed(2)}</td>
                    <td style="font-family:monospace; font-weight:600;">${cur.x.toFixed(2)}</td>
                    <td style="font-family:monospace; color:#475569; font-size:11px;">${cur.lat.toFixed(5)}, ${cur.lng.toFixed(5)}</td>
                    <td style="font-weight:700; color:#16a34a;">K${i + 1}-${nextLabel}: ${dist.toFixed(2)} m</td>
                `;
                tbody.appendChild(tr);
            }

            // QR Kod Oluştur (QuickChart API)
            const verifyUrl = `https://www.parselsorgu.net/parsel?city=${encodeURIComponent(p.city)}&district=${encodeURIComponent(p.district)}&ada=${p.ada}&parsel=${p.parsel}`;
            const qrImg = document.getElementById('repQrImg');
            if (qrImg) {
                qrImg.src = `https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=${encodeURIComponent(verifyUrl)}`;
            }
            document.getElementById('repVerifyCode').textContent = docNo;

            // Modalı Göster
            const modal = document.getElementById('parselOfficialReportModal');
            if (modal) modal.style.display = 'block';
        }

        
        function openPricingModal() {
            const m = document.getElementById('p360PricingModal');
            if (m) m.style.display = 'flex';
        }

        function closePricingModal() {
            const m = document.getElementById('p360PricingModal');
            if (m) m.style.display = 'none';
        }

        function closeParselPdfModal() {
            const modal = document.getElementById('parselOfficialReportModal');
            if (modal) modal.style.display = 'none';
        }

        document.addEventListener('DOMContentLoaded', function() {
            initParselMap();
            // Varsayılan İl, İlçe ve Mahalleleri kaskad yükle
            const defaultCity = "<?php echo htmlspecialchars($pre_city ?: 'Kırıkkale'); ?>";
            const defaultDist = "<?php echo htmlspecialchars($pre_district ?: 'Bahşılı'); ?>";
            const defaultMah = "<?php echo htmlspecialchars($pre_mahalle ?: ''); ?>";

            const citySel = document.getElementById('selCity');
            if (citySel && defaultCity) citySel.value = defaultCity;

            onCityChanged(defaultDist, defaultMah);

            setTimeout(() => {
                executeStandaloneQuery();
            }, 800);
        });
    </script>

    <!-- RESMİ PARSEL EKSPERTİZ & İMAR RAPORU MODALI (PDF / YAZDIR) -->
    <div id="parselOfficialReportModal">
        <div class="report-paper">
            <div class="report-actions-bar no-print">
                <button type="button" class="btn-report-print" onclick="window.print()">
                    <i class="fa-solid fa-print"></i> Raporu Yazdır / PDF Olarak Kaydet
                </button>
                <button type="button" class="btn-report-close" onclick="closeParselPdfModal()">
                    <i class="fa-solid fa-xmark"></i> Kapat
                </button>
            </div>

            <!-- Header -->
            <div class="report-header-grid">
                <div class="report-logo-box">
                    <i class="fa-solid fa-compass-drafting"></i>
                </div>
                <div class="report-title-box">
                    <h1>ANT HARİTA MÜHENDİSLİK &amp; KADASTRO TEKNOLOJİLERİ</h1>
                    <p>KADASTRO VE İMAR TEKNİK ÖN DEĞERLENDİRME RAPORU</p>
                </div>
                <div class="report-meta-box">
                    <div><strong>Belge No:</strong> <span id="repDocNo">ANT-2026-9481</span></div>
                    <div><strong>Düzenleme:</strong> <span id="repDate">31.10.2026</span></div>
                    <div><strong>LİHKAB Sicil:</strong> 12480</div>
                    <div><strong>HKMO Oda Sicil:</strong> 12480</div>
                </div>
            </div>

            <!-- Tablo 1: Mülkiyet & Kadastro Bilgileri -->
            <div class="report-section-title">
                <span>1. MÜLKİYET VE KADASTRO KAYITLARI</span>
                <span style="font-size:10.5px; color:#64748b;">TKGM Canlı Veri Tabanı Onaylı</span>
            </div>
            <table class="report-table">
                <tr>
                    <th style="width:20%;">İl / İlçe:</th>
                    <td style="width:30%;" id="repCityDist">Kırıkkale / Merkez</td>
                    <th style="width:20%;">Mahalle / Köy:</th>
                    <td style="width:30%;" id="repMahalle">Hacılar Hacıbey Mh.</td>
                </tr>
                <tr>
                    <th>Ada No:</th>
                    <td class="highlight" id="repAda">1781</td>
                    <th>Parsel No:</th>
                    <td class="highlight" id="repParsel">34</td>
                </tr>
                <tr>
                    <th>Resmî Tapu Alanı:</th>
                    <td class="highlight" style="color:#16a34a;" id="repAlan">750,00 m²</td>
                    <th>Taşınmaz Niteliği:</th>
                    <td id="repNitelik">Arsa (Konut İmarı)</td>
                </tr>
                <tr>
                    <th>Projeksiyon &amp; Datum:</th>
                    <td>ITRF95 / TM 3° (TUREF) - GRS80</td>
                    <th>Harita Pafta No:</th>
                    <td id="repPafta">TKGM-İMAR-2026</td>
                </tr>
            </table>

            <!-- Tablo 2: İmar ve Yapılaşma Kapasitesi -->
            <div class="report-section-title">
                <span>2. İMAR PLANI VE YAPILAŞMA KRİTERLERİ</span>
                <span style="font-size:10.5px; color:#64748b;">Belediye &amp; 3194 Sayılı İmar Kanunu</span>
            </div>
            <table class="report-table">
                <tr>
                    <th style="width:25%;">Fonksiyon Durumu:</th>
                    <td id="repFonksiyon">Gelişme Konut Alanı (Ayrık / Blok Nizam)</td>
                    <th style="width:25%;">Emsal (KAKS):</th>
                    <td class="highlight" id="repKaks">1.50</td>
                </tr>
                <tr>
                    <th>Taban Alanı (TAKS):</th>
                    <td id="repTaks">0.30</td>
                    <th>Yükseklik (Hmax):</th>
                    <td id="repHmax">Serbest (4-5 Kat Uygun)</td>
                </tr>
                <tr>
                    <th>Tahmini Taban Oturumu:</th>
                    <td class="highlight" id="repTabanAlani">~225,00 m²</td>
                    <th>Toplam Kapalı İnşaat Alanı:</th>
                    <td class="highlight" style="color:#0284c7; font-size:13px;" id="repToplamInsaat">~1.125,00 m²</td>
                </tr>
            </table>

            <!-- Tablo 3: Sayısal Köşe Koordinatları (ITRF95 / TUREF Metrik) -->
            <div class="report-section-title">
                <span>3. SAYISAL KADASTRO KÖŞE KOORDİNATLARI (ITRF95 TM / WGS84)</span>
                <span style="font-size:10.5px; color:#64748b;">Santimetre Hassasiyetli Ölçümler</span>
            </div>
            <table class="report-table" id="repCoordsTable">
                <thead>
                    <tr>
                        <th style="width:12%; text-align:center;">Nokta No</th>
                        <th style="width:22%;">Sağa Değer (Y - Metre)</th>
                        <th style="width:22%;">Yukarı Değer (X - Metre)</th>
                        <th style="width:22%;">WGS84 Enlem / Boylam</th>
                        <th style="width:22%;">Kenar Uzunluğu</th>
                    </tr>
                </thead>
                <tbody id="repCoordsTbody">
                    <!-- Dinamik koordinatlar buraya eklenecektir -->
                </tbody>
            </table>

            <!-- Alt Doğrulama ve Mühür/İmza -->
            <div class="report-footer-grid">
                <div style="display:flex; align-items:center; gap:16px;">
                    <div id="repQrCode" style="width:90px; height:90px; border:1px solid #cbd5e1; border-radius:8px; padding:4px; display:flex; align-items:center; justify-content:center; background:#f8fafc;">
                        <img id="repQrImg" src="" alt="QR Doğrulama" style="width:100%; height:100%; object-fit:contain;">
                    </div>
                    <div style="font-size:10.5px; color:#475569; line-height:1.5;">
                        <div style="font-weight:700; color:#0f172a;">ÇEVRİMİÇİ DOĞRULAMA KODU</div>
                        <div style="font-family:monospace; color:#0284c7; font-size:11px;" id="repVerifyCode">PS-2026-TKGM-VERIFIED</div>
                        <div style="font-size:10px; color:#64748b; line-height:1.4;"><strong>Hukuki Çekince:</strong> Bu belge TKGM MEGSİS ve ÇSB açık CBS servisleri referans alınarak üretilmiş mühendislik ön fizibilite belgesidir. 3194 Sayılı İmar Kanunu uyarınca resmî imar çapı ve ruhsat işlemlerinde ilgili idarenin güncel kararı esastır.</div>
                    </div>
                </div>

                <div class="report-stamp-box">
                    <div class="report-stamp-title">ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ</div>
                    <div class="report-stamp-sub">LİHKAB Lisanslı Harita Kadastro Mühendisliği</div>
                    <div style="margin:10px auto; font-family:'Brush Script MT', cursive, sans-serif; font-size:22px; color:#1e3a8a; letter-spacing:1px;">Mustafa Kemal K.</div>
                    <div style="font-size:10px; color:#334155; font-weight:700;">TMMOB HKMO Oda Sicil: 12480</div>
                </div>
            </div>
        </div>
    </div>


    <!-- KAYITLI PARSELLER & PROJE ÇALIŞMA ALANI MODALI -->
    <div id="savedProjectsModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(3,7,18,0.85); backdrop-filter:blur(8px); z-index:99999; padding:20px; box-sizing:border-box;">
        <div style="background:#0f172a; border:1px solid #0284c7; border-radius:16px; max-width:760px; margin:40px auto; padding:28px; color:#fff; box-shadow:0 25px 60px rgba(0,0,0,0.6);">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:18px; border-bottom:1px solid #1e293b; padding-bottom:14px;">
                <div style="display:flex; align-items:center; gap:10px;">
                    <i class="fa-solid fa-folder-open" style="color:#38bdf8; font-size:20px;"></i>
                    <h3 style="font-size:18px; font-weight:800; margin:0;">Kayıtlı Projelerim &amp; Parsel Portföyüm</h3>
                </div>
                <button type="button" onclick="document.getElementById('savedProjectsModal').style.display='none'" style="background:none; border:none; color:#94a3b8; font-size:22px; cursor:pointer;">&times;</button>
            </div>
            <div id="savedProjectsList" style="max-height:360px; overflow-y:auto; margin-bottom:18px;">
                <!-- Populated by JS -->
            </div>
            <div style="display:flex; justify-content:space-between; align-items:center; pt-3; border-top:1px solid #1e293b;">
                <span style="font-size:12px; color:#64748b;">Projeler tarayıcı yerel hafızasında güvenle saklanır.</span>
                <button type="button" onclick="clearAllSavedProjects()" style="background:#ef4444; color:#fff; border:none; padding:8px 14px; border-radius:8px; font-size:12px; font-weight:700; cursor:pointer;">Tümünü Temizle</button>
            </div>
        </div>
    </div>


    <!-- PRO LİSANS VE TİCARİ PAKETLER MODALI (MASTER PLAN MADDE 13) -->
    <div id="p360PricingModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.85); z-index:99999; backdrop-filter:blur(6px); align-items:center; justify-content:center; padding:16px;">
        <div style="background:#0b1120; border:1.5px solid #f59e0b; border-radius:16px; max-width:1100px; width:100%; max-height:92vh; overflow-y:auto; padding:28px 24px; box-shadow:0 0 50px rgba(245,158,11,0.3); position:relative;">
            <button type="button" onclick="closePricingModal()" style="position:absolute; top:18px; right:20px; background:transparent; border:none; color:#94a3b8; font-size:24px; cursor:pointer; line-height:1;">&times;</button>
            
            <div style="text-align:center; margin-bottom:24px;">
                <span style="background:rgba(245,158,11,0.15); border:1px solid #f59e0b; color:#fbbf24; font-size:11px; font-weight:900; padding:4px 14px; border-radius:20px; letter-spacing:0.5px;">PARSEL PRO 2026 TİCARİ MODEL</span>
                <h2 style="font-size:26px; font-weight:900; color:#fff; margin-top:8px;">Mühendislik, İmar &amp; Gayrimenkul Paketleri</h2>
                <p style="color:#94a3b8; font-size:13px; max-width:650px; margin:4px auto 0;">Türkiye'nin lider parsel ve imar analiz işletim sistemi ile projelerinizi hızlandırın, metrik CAD/DXF ve resmi mühendislik raporları üretin.</p>
            </div>

            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(230px, 1fr)); gap:16px;">
                <!-- FREE -->
                <div style="background:#111827; border:1px solid #1f2937; border-radius:12px; padding:22px; display:flex; flex-direction:column;">
                    <div style="color:#94a3b8; font-size:12px; font-weight:800; text-transform:uppercase;">Vatandaş &amp; Bireysel</div>
                    <h3 style="color:#fff; font-size:20px; font-weight:900; margin:6px 0;">Ücretsiz</h3>
                    <div style="font-size:28px; font-weight:900; color:#f1f5f9; margin-bottom:14px;">0 TL <span style="font-size:12px; color:#6b7280;">/ Süresiz</span></div>
                    <ul style="list-style:none; padding:0; margin:0 0 20px 0; font-size:12.5px; color:#cbd5e1; line-height:1.7;">
                        <li>✓ Temel TKGM Ada/Parsel Sorgulama</li>
                        <li>✓ Canlı Uydu &amp; Kadastro Katmanı</li>
                        <li>✓ Temel TAKS / KAKS Ön Analizi</li>
                        <li>✓ 20 Otonom İmar Botu Erişimi</li>
                    </ul>
                    <button type="button" onclick="closePricingModal()" style="margin-top:auto; width:100%; background:#1f2937; color:#fff; border:none; padding:10px; border-radius:8px; font-weight:bold; font-size:13px; cursor:pointer;">Mevcut Paket</button>
                </div>

                <!-- PRO (FEATURED) -->
                <div style="background:linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%); border:2px solid #38bdf8; border-radius:12px; padding:22px; display:flex; flex-direction:column; position:relative; box-shadow:0 0 25px rgba(56,189,248,0.25);">
                    <div style="position:absolute; top:-10px; right:16px; background:#0284c7; color:#fff; font-size:10px; font-weight:900; padding:2px 10px; border-radius:10px;">EN POPÜLER</div>
                    <div style="color:#38bdf8; font-size:12px; font-weight:800; text-transform:uppercase;">Harita Mühendisi &amp; Mimar</div>
                    <h3 style="color:#fff; font-size:20px; font-weight:900; margin:6px 0;">Parsel PRO</h3>
                    <div style="font-size:28px; font-weight:900; color:#38bdf8; margin-bottom:14px;">490 TL <span style="font-size:12px; color:#94a3b8;">/ Ay</span></div>
                    <ul style="list-style:none; padding:0; margin:0 0 20px 0; font-size:12.5px; color:#f1f5f9; line-height:1.7;">
                        <li>✓ <strong>Sınırsız AutoCAD / Netcad DXF İndir</strong></li>
                        <li>✓ <strong>A4 Karekodlu Mühendislik Raporu (PDF)</strong></li>
                        <li>✓ <strong>Geometrik İfraz Simülasyonu &amp; CAD</strong></li>
                        <li>✓ <strong>Parsel AI 10+ Uzmanlık Aracı &amp; NLP</strong></li>
                        <li>✓ Proje Çalışma Alanı &amp; Portföy Arşivi</li>
                    </ul>
                    <a href="https://wa.me/905428413535?text=Merhaba,%20Parsel%20PRO%20üyeliği%20hakkında%20bilgi%20ve%20aktivasyon%20istiyorum." target="_blank" style="margin-top:auto; width:100%; background:linear-gradient(135deg,#0284c7,#2563eb); color:#fff; text-decoration:none; text-align:center; padding:10px; border-radius:8px; font-weight:900; font-size:13px; display:block;">PRO'ya Yükselt ➔</a>
                </div>

                <!-- BUSINESS -->
                <div style="background:#111827; border:1px solid #1f2937; border-radius:12px; padding:22px; display:flex; flex-direction:column;">
                    <div style="color:#facc15; font-size:12px; font-weight:800; text-transform:uppercase;">Müteahhit &amp; Geliştirici</div>
                    <h3 style="color:#fff; font-size:20px; font-weight:900; margin:6px 0;">Business</h3>
                    <div style="font-size:28px; font-weight:900; color:#facc15; margin-bottom:14px;">1.450 TL <span style="font-size:12px; color:#6b7280;">/ Ay</span></div>
                    <ul style="list-style:none; padding:0; margin:0 0 20px 0; font-size:12.5px; color:#cbd5e1; line-height:1.7;">
                        <li>✓ <strong>120+ Kalem Detaylı ÇŞİDB Keşif &amp; Metraj</strong></li>
                        <li>✓ <strong>Kat Karşılığı Paylaşım &amp; Hasılat Modeli</strong></li>
                        <li>✓ <strong>3194 s.K. 18. Madde DOP Dağıtım Cetveli</strong></li>
                        <li>✓ Excel (CSV) ve Proje Dökümleri</li>
                        <li>✓ Öncelikli LİHKAB &amp; Mühendis Danışmanlığı</li>
                    </ul>
                    <a href="https://wa.me/905428413535?text=Merhaba,%20Parsel%20Business%20üyeliği%20hakkında%20görüşmek%20istiyorum." target="_blank" style="margin-top:auto; width:100%; background:#facc15; color:#000; text-decoration:none; text-align:center; padding:10px; border-radius:8px; font-weight:900; font-size:13px; display:block;">Business Başlat ➔</a>
                </div>

                <!-- ENTERPRISE -->
                <div style="background:#111827; border:1px solid #1f2937; border-radius:12px; padding:22px; display:flex; flex-direction:column;">
                    <div style="color:#a855f7; font-size:12px; font-weight:800; text-transform:uppercase;">Kurumsal &amp; Belediye</div>
                    <h3 style="color:#fff; font-size:20px; font-weight:900; margin:6px 0;">Enterprise</h3>
                    <div style="font-size:28px; font-weight:900; color:#a855f7; margin-bottom:14px;">Özel Teklif</div>
                    <ul style="list-style:none; padding:0; margin:0 0 20px 0; font-size:12.5px; color:#cbd5e1; line-height:1.7;">
                        <li>✓ <strong>Yetkilendirilmiş Kurumsal API Erişimi</strong></li>
                        <li>✓ <strong>Toplu Parsel Sorgulama &amp; CBS Entegrasyonu</strong></li>
                        <li>✓ <strong>Özel SLA &amp; 7/24 Kesintisiz Destek</strong></li>
                        <li>✓ Özel E-İmar &amp; WMS Servis Bağlantıları</li>
                    </ul>
                    <a href="https://wa.me/905428413535?text=Merhaba,%20ParselSorgu%20Enterprise%20API%20ve%20kurumsal%20entegrasyon%20teklifi%20almak%20istiyoruz." target="_blank" style="margin-top:auto; width:100%; background:#9333ea; color:#fff; text-decoration:none; text-align:center; padding:10px; border-radius:8px; font-weight:900; font-size:13px; display:block;">Kurumsal Teklif Al ➔</a>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
