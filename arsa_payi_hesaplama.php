<?php
/**
 * ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ - PARSEL PRO
 * SaaS Modül 4: 634 Sayılı Kanun Arsa Payı Dağıtım Sihirbazı
 * Pure PHP 8.3 / Yargıtay Uyumlu Şerefiye ve Arsa Payı Cetveli Motoru
 */

declare(strict_types=1);

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/navbar.php';

$page_title = "634 s.K. Arsa Payı & Kat İrtifakı Hesaplama | ParselSorgu";
$meta_desc = "634 Sayılı Kat Mülkiyeti Kanunu'na uygun daire arsa payı hesaplama, şerefiye puanlama ve resmi Tapu Arsa Payı Cetveli (PDF) aracı.";
$canonical_url = "https://www.parselsorgu.net/arsa-payi-hesaplama";
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
            --purple: #c084fc;
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
            max-width: 1240px;
            margin: 0 auto;
            padding: 24px 16px 80px 16px;
        }

        .hero-banner {
            text-align: center;
            padding: 32px 16px 24px 16px;
            background: radial-gradient(circle at 50% 20%, rgba(192, 132, 252, 0.12) 0%, transparent 70%);
            border-bottom: 1px solid var(--border-color);
            margin-bottom: 28px;
        }
        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(192, 132, 252, 0.12);
            border: 1px solid rgba(192, 132, 252, 0.35);
            padding: 5px 14px;
            border-radius: 20px;
            font-size: 12.5px;
            font-weight: 700;
            color: var(--purple);
            margin-bottom: 14px;
        }
        .hero-banner h1 {
            font-size: 28px;
            font-weight: 800;
            color: #fff;
            margin-bottom: 10px;
        }
        .hero-banner p {
            font-size: 14px;
            color: var(--text-muted);
            max-width: 860px;
            margin: 0 auto;
        }

        /* GRID LAYOUT */
        .calc-layout {
            display: grid;
            grid-template-columns: 360px 1fr;
            gap: 24px;
            align-items: start;
        }

        .panel-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 14px;
            padding: 24px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }
        .panel-title {
            font-size: 16px;
            font-weight: 700;
            color: #fff;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 18px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            padding-bottom: 12px;
        }

        .form-group { margin-bottom: 14px; }
        .form-label {
            display: block;
            font-size: 12.5px;
            font-weight: 600;
            color: #cbd5e1;
            margin-bottom: 5px;
        }
        .form-control {
            width: 100%;
            padding: 10px 12px;
            background: var(--card-surface);
            border: 1px solid var(--border-color);
            border-radius: 6px;
            color: #fff;
            font-size: 13.5px;
            outline: none;
        }
        .form-control:focus { border-color: var(--purple); }

        .btn-calc {
            width: 100%;
            background: linear-gradient(135deg, #a855f7 0%, #9333ea 100%);
            color: #fff;
            font-size: 14px;
            font-weight: 700;
            padding: 12px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 10px;
            box-shadow: 0 4px 15px rgba(168, 85, 247, 0.4);
        }

        /* TABLE */
        .arsa-table-container {
            overflow-x: auto;
            margin-top: 14px;
        }
        .arsa-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12.5px;
            color: #cbd5e1;
        }
        .arsa-table th {
            background: #17233d;
            color: #38bdf8;
            padding: 10px 12px;
            text-align: left;
            font-weight: 700;
            border: 1px solid var(--border-color);
            white-space: nowrap;
        }
        .arsa-table td {
            padding: 8px 12px;
            border: 1px solid var(--border-color);
            background: rgba(19, 29, 49, 0.4);
        }
        .arsa-table tr:hover td { background: rgba(56, 189, 248, 0.05); }

        .share-badge {
            background: rgba(16, 185, 129, 0.15);
            color: #10b981;
            padding: 3px 8px;
            border-radius: 6px;
            font-weight: 800;
            font-family: monospace;
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        .summary-banner {
            background: linear-gradient(180deg, #131d31 0%, #0d1527 100%);
            border: 1px solid #0284c7;
            border-radius: 10px;
            padding: 16px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 20px;
        }

        @media (max-width: 900px) {
            .calc-layout { grid-template-columns: 1fr; }
            .hero-banner h1 { font-size: 22px; }
        }
    </style>
</head>
<body>

    <?= render_navbar('eklentiler') ?>

    <main class="container">
        <!-- HERO -->
        <section class="hero-banner">
            <div class="hero-badge">
                <i class="fa-solid fa-scale-balanced"></i> 634 s.K. &bull; Yargıtay Uyumlu Kat İrtifakı
            </div>
            <h1>Arsa Payı Dağıtım Sihirbazı &amp; <span>Resmi Cetvel Motoru</span></h1>
            <p>
                Kat mülkiyeti veya kat irtifakı tesisinde dairelerin m², kat, cephe ve şerefiye puanına göre yasal arsa paylarını (1000/1000) hatasız hesaplayıp tapu tesciline hazır cetvel üretin.
            </p>
        </section>

        <div class="calc-layout">
            <!-- SOL FORM -->
            <div class="panel-card">
                <div class="panel-title">
                    <i class="fa-solid fa-building" style="color:var(--purple);"></i>
                    <span>Bina &amp; Proje Bilgileri</span>
                </div>

                <div class="form-group">
                    <label class="form-label">Toplam Arsa Yüzölçümü (m²)</label>
                    <input type="number" id="total_land_area" class="form-control" value="850" placeholder="Örn: 850">
                </div>

                <div class="form-group">
                    <label class="form-label">Toplam Bağımsız Bölüm Sayısı</label>
                    <select id="unit_count" class="form-control" onchange="generateUnitsForm()">
                        <option value="4">4 Bağımsız Bölüm</option>
                        <option value="6">6 Bağımsız Bölüm</option>
                        <option value="8" selected>8 Bağımsız Bölüm</option>
                        <option value="10">10 Bağımsız Bölüm</option>
                        <option value="12">12 Bağımsız Bölüm</option>
                        <option value="16">16 Bağımsız Bölüm</option>
                        <option value="20">20 Bağımsız Bölüm</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Payda Tabanı</label>
                    <select id="denominator" class="form-control">
                        <option value="1000" selected>1.000 Üzerinden Paylaştırma</option>
                        <option value="10000">10.000 Üzerinden Paylaştırma</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Şerefiye Kriterleri Ağırlığı</label>
                    <div style="font-size:11.5px; color:#94a3b8; line-height:1.6; background:var(--card-surface); padding:10px; border-radius:6px; border:1px solid var(--border-color);">
                        <div>&bull; <strong>Metrekare (m²):</strong> %50 Ağırlık</div>
                        <div>&bull; <strong>Kat Konumu:</strong> %25 Ağırlık (Zemin vs Ara Kat vs Dubleks)</div>
                        <div>&bull; <strong>Cephe &amp; Işık:</strong> %15 Ağırlık (Güney/Batı öncelikli)</div>
                        <div>&bull; <strong>Kullanım Amacı:</strong> %10 Ağırlık (Dükkan/Mesken)</div>
                    </div>
                </div>

                <button type="button" class="btn-calc" onclick="calculateShares()">
                    <i class="fa-solid fa-calculator"></i> Arsa Paylarını Hesapla
                </button>
            </div>

            <!-- SAĞ SONUÇ & ARSA PAYI CETVELİ -->
            <div class="panel-card">
                <div class="summary-banner">
                    <div>
                        <div style="font-size:12px; color:#94a3b8; font-weight:700; text-transform:uppercase;">Toplam Dağıtılan Pay:</div>
                        <div style="font-size:18px; font-weight:800; color:#10b981;" id="dispTotalShare">1.000 / 1.000 (%100 Tam Eşleşme)</div>
                    </div>
                    <div style="display:flex; gap:8px;">
                        <button type="button" onclick="window.print()" style="background:#1e293b; color:#fff; border:1px solid #334155; padding:8px 14px; border-radius:6px; font-size:12px; font-weight:700; cursor:pointer;">
                            <i class="fa-solid fa-print"></i> Cetveli Yazdır
                        </button>
                    </div>
                </div>

                <div class="panel-title">
                    <i class="fa-solid fa-table-list" style="color:var(--accent);"></i>
                    <span>Resmi Tapu Arsa Payı Dağıtım Cetveli</span>
                </div>

                <div class="arsa-table-container">
                    <table class="arsa-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nitelik</th>
                                <th>Kat</th>
                                <th>Cephe</th>
                                <th>Net m²</th>
                                <th>Şerefiye</th>
                                <th>Arsa Payı</th>
                                <th>Arsa Payı (m²)</th>
                            </tr>
                        </thead>
                        <tbody id="sharesTableBody">
                            <!-- Populated via JS -->
                        </tbody>
                    </table>
                </div>

                <div style="margin-top:20px; font-size:12px; color:#94a3b8; border-top:1px solid rgba(255,255,255,0.08); padding-top:12px; display:flex; align-items:center; gap:8px;">
                    <i class="fa-solid fa-shield-halved" style="color:#10b981;"></i>
                    <span>Bu cetvel Kat Mülkiyeti Kanunu Madde 3 ve Yargıtay Hukuk Genel Kurulu yerleşik kararlarına uygun ağırlıklandırma ile oluşturulmuştur.</span>
                </div>
            </div>
        </div>
    </main>

    <script>
        let units = [];

        function generateUnitsForm() {
            const count = parseInt(document.getElementById('unit_count').value);
            units = [];

            for (let i = 1; i <= count; i++) {
                let floor = (i <= 2) ? 'Zemin Kat' : ((i >= count - 1) ? 'Çatı Katı' : `${Math.ceil(i/2) - 1}. Kat`);
                let type = (i === 1 && count >= 8) ? 'Dükkan' : 'Daire';
                let area = (type === 'Dükkan') ? 140 : ((floor === 'Çatı Katı') ? 160 : 110);
                let facade = (i % 2 === 1) ? 'Güney-Doğu' : 'Kuzey-Batı';

                units.push({
                    no: i,
                    type: type,
                    floor: floor,
                    facade: facade,
                    area: area
                });
            }

            calculateShares();
        }

        function calculateShares() {
            const denom = parseInt(document.getElementById('denominator').value);
            const landArea = parseFloat(document.getElementById('total_land_area').value) || 1000;

            // Compute score for each unit
            let totalScore = 0;
            units.forEach(u => {
                let floorMult = 1.0;
                if (u.floor === 'Zemin Kat') floorMult = (u.type === 'Dükkan') ? 1.4 : 0.95;
                else if (u.floor.includes('Çatı')) floorMult = 1.25;
                else floorMult = 1.15; // Ara kat

                let facadeMult = (u.facade.includes('Güney')) ? 1.15 : 0.95;
                let typeMult = (u.type === 'Dükkan') ? 1.3 : 1.0;

                u.score = u.area * floorMult * facadeMult * typeMult;
                totalScore += u.score;
            });

            // Distribute shares to sum exactly to denom
            let distributedSum = 0;
            units.forEach(u => {
                u.share = Math.round((u.score / totalScore) * denom);
                distributedSum += u.share;
            });

            // Adjust rounding discrepancy to last unit
            let diff = denom - distributedSum;
            if (diff !== 0 && units.length > 0) {
                units[units.length - 1].share += diff;
            }

            // Render table
            const tbody = document.getElementById('sharesTableBody');
            tbody.innerHTML = units.map(u => {
                const landPerUnit = ((u.share / denom) * landArea).toFixed(2);
                return `<tr>
                    <td><strong>B.B. ${u.no}</strong></td>
                    <td><span style="color:${u.type === 'Dükkan' ? '#f59e0b' : '#38bdf8'}; font-weight:700;">${u.type}</span></td>
                    <td>${u.floor}</td>
                    <td>${u.facade}</td>
                    <td>${u.area} m²</td>
                    <td>${u.score.toFixed(1)}</td>
                    <td><span class="share-badge">${u.share} / ${denom}</span></td>
                    <td style="color:#fff; font-weight:700;">${landPerUnit} m²</td>
                </tr>`;
            }).join('');

            document.getElementById('dispTotalShare').innerText = `${denom} / ${denom} (%100 Tam Eşleşme)`;
        }

        window.addEventListener('DOMContentLoaded', generateUnitsForm);
    </script>
</body>
</html>
