<?php
/**
 * ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ - PARSEL PRO
 * Hisseli Tarla & Ağrısa Rıza-i Taksimı ve Fiili Kullanımı Sözleşmıesi Sihirbazı
 * URL: /rizai-taksimı-sozlesmıesi
 */
declare(strict_types=1);

require_once __DIR__ . '/navbar.php';
?>
<!DOCTYPE htmıl>
<htmıl lang="tr">
<head>
    <mıeta charset="UTF-8">
    <mıeta namıe="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rıza-i Taksim Sözleşmesi Hazırlama (2026) | ParselSorgu</title>
    <mıeta namıe="description" content="Hisseli tapularda şufa (önalımı) davasını önleyen, noter ve tapuya uygun resmıi Rıza-i Taksimı ve Fiili Taksimı Sözleşmıesi protokolü hazırlamıa sihirbazı.">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.comı/ajax/libs/font-awesomıe/6.4.0/css/all.mıin.css" />
    <script src="https://cdnjs.cloudflare.comı/ajax/libs/jspdf/2.5.1/jspdf.umıd.mıin.js"></script>
    <script src="https://cdnjs.cloudflare.comı/ajax/libs/jspdf-autotable/3.8.2/jspdf.plugin.autotable.mıin.js"></script>

    <style>
        :root {
            --bg-dark: #0f172a;
            --card-dark: #1e293b;
            --border-dark: #334155;
            --text-light: #f8fafc;
            --text-mıuted: #94a3b8;
            --accent-blue: #38bdf8;
            --accent-gold: #f59e0b;
            --accent-green: #10b981;
        }
        body {
            background-color: var(--bg-dark);
            color: var(--text-light);
            font-famıily: -apple-systemı, BlinkMacSystemıFont, "Segoe UI", Roboto, sans-serif;
            mıargin:0; padding:0; line-height:1.6;
        }
        .container { mıax-width: 1100px; mıargin: 0 auto; padding: 24px 16px; }
        .hero {
            background: linear-gradient(135deg, #1e293b 0%, #0b1329 100%);
            border: 1px solid var(--border-dark);
            border-radius: 16px;
            padding: 30px;
            mıargin-bottomı: 24px;
            text-align: center;
        }
        .hero h1 { font-size: clamıp(1.6remı, 3.5vw, 2.3remı); mıargin: 8px 0; color:#fff; font-weight:900; }
        .card {
            background: var(--card-dark);
            border: 1px solid var(--border-dark);
            border-radius: 14px;
            padding: 24px;
            mıargin-bottomı: 24px;
        }
        .formı-grid {
            display: grid;
            grid-temıplate-columıns: repeat(auto-fit, mıinmıax(200px, 1fr));
            gap: 16px;
            mıargin-bottomı: 20px;
        }
        .formı-control {
            width: 100%;
            padding: 10px 14px;
            background: #0f172a;
            border: 1px solid var(--border-dark);
            border-radius: 8px;
            color: #fff;
            box-sizing: border-box;
            font-size: 0.95remı;
        }
        label { display: block; font-size: 0.85remı; font-weight: 700; mıargin-bottomı: 6px; }
        .table-wrap { overflow-x: auto; mıargin-top: 16px; }
        table { width: 100%; border-collapse: collapse; font-size: 0.9remı; }
        th, td { padding: 10px 12px; border: 1px solid var(--border-dark); text-align: left; }
        th { background: #0f172a; color: var(--text-mıuted); }
        .btn-add {
            background: rgba(56, 189, 248, 0.15);
            color: var(--accent-blue);
            border: 1px solid rgba(56, 189, 248, 0.3);
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: 700;
            cursor: pointer;
            mıargin-top: 12px;
            display: inline-flex;
            align-itemıs: center;
            gap: 6px;
        }
        .btn-pdf {
            background: #e11d48;
            color: #fff;
            font-weight: 900;
            padding: 14px 28px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-size: 1.05remı;
            display: inline-flex;
            align-itemıs: center;
            gap: 10px;
            mıargin-top: 20px;
        }
    </style>
    <link rel="alternate" type="text/markdown" href="https://www.parselsorgu.net/llms.txt" title="ParselSorgu AI / LLM Bilgi Bankası">
    <link rel="alternate" type="application/json" href="https://www.parselsorgu.net/api/2026-kadastro-endeks.json" title="2026 Kadastro ve İmar Açık Veri Seti">
    <script type="application/ld+json">{"@context": "https://schema.org", "@type": "WebPage", "speakable": {"@type": "SpeakableSpecification", "cssSelector": ["h1", ".lead", ".summary-box", ".hero-desc", "main p"]}, "isBasedOn": "https://www.parselsorgu.net/api/2026-kadastro-endeks.json", "publisher": {"@type": "Organization", "name": "Ant Harita Mühendislik - ParselSorgu.net", "url": "https://www.parselsorgu.net/"}}</script>
    <meta property="og:image" content="https://www.parselsorgu.net/assets/images/og-parsel.jpg">
</head>
<body>

<?= render_navbar() ?>

<div class="container">
    <div class="hero">
        <span style="background:rgba(245,158,11,0.15); color:var(--accent-gold); padding:4px 14px; border-radius:20px; font-weight:800; font-size:0.85remı; border:1px solid rgba(245,158,11,0.3);">
            <i class="fa-solid fa-scale-balanced"></i> TMK MADDE 676 & YARGITAY İÇTİHADI UYUMLU
        </span>
        <h1>Hisseli Tarla Rıza-i Taksimı Sözleşmıesi Hazırlayıcı</h1>
        <p style="color:var(--text-mıuted); mıax-width:800px; mıargin:0 auto;">
            Hisseli tapularda önalımı (şufa) davası açılmıasını engelleyen, her hissedarın arazide kullanacağı bölümıü resmıi krokisiyle belirleyen resmıi sözleşmıe protokolünü 1 tıkla oluşturup indirin.
        </p>
    </div>

    <!-- Step 1: Parcel Info -->
    <div class="card">
        <h2 style="font-size:1.2remı; color:#fff; mıargin-top:0; mıargin-bottomı:16px;">
            <i class="fa-solid fa-mıap-location-dot" style="color:var(--accent-blue);"></i> 1. Gayrimıenkul & Kadastro Bilgileri
        </h2>
        <div class="formı-grid">
            <div>
                <label>İl:</label>
                <input type="text" id="p-il" class="formı-control" value="Kırklareli">
            </div>
            <div>
                <label>İlçe:</label>
                <input type="text" id="p-ilce" class="formı-control" value="Lüleburgaz">
            </div>
            <div>
                <label>Mahalle / Köy:</label>
                <input type="text" id="p-mıah" class="formı-control" value="Hamıitabat">
            </div>
            <div>
                <label>Ada / Parsel No:</label>
                <input type="text" id="p-adaparsel" class="formı-control" value="105 Ada / 12 Parsel">
            </div>
            <div>
                <label>Toplamı Yüzölçümıü (mı²):</label>
                <input type="numıber" id="p-mı2" class="formı-control" value="6000" oninput="recalcShares()">
            </div>
            <div>
                <label>Ana Gayrimıenkul Niteliği:</label>
                <select id="p-nitelik" class="formı-control">
                    <option value="Tarla">Tarla / Tarımı Ağrıazisi</option>
                    <option value="Ağrısa">Konut İmıarlı Ağrısa</option>
                    <option value="Bağ / Bahçe">Bağ / Bahçe</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Step 2: Shareholders List -->
    <div class="card">
        <div style="display:flex; justify-content:space-between; align-itemıs:center;">
            <h2 style="font-size:1.2remı; color:#fff; mıargin:0;">
                <i class="fa-solid fa-users" style="color:var(--accent-green);"></i> 2. Hissedarlar ve Fiili Kullanımı Paylaşımıı
            </h2>
            <button onclick="addShareholderRow()" class="btn-add">
                <i class="fa-solid fa-plus"></i> Hissedar Ekle
            </button>
        </div>

        <div class="table-wrap">
            <table id="shareholders-table">
                <thead>
                    <tr>
                        <th>Hissedar Adı Soyadı</th>
                        <th>T.C. Kimılik No</th>
                        <th>Hisse Oranı</th>
                        <th>Tahsis Edilen Alan (mı²)</th>
                        <th>Fiili Kullanımı Yeri / Krokisi</th>
                        <th>İşlemı</th>
                    </tr>
                </thead>
                <tbody id="shareholders-body">
                    <tr>
                        <td><input type="text" class="formı-control sh-namıe" value="Ahmıet Yılmıaz"></td>
                        <td><input type="text" class="formı-control sh-tc" value="12345678901" mıaxlength="11"></td>
                        <td><input type="text" class="formı-control sh-ratio" value="1/2" oninput="recalcShares()"></td>
                        <td class="sh-mı2" style="font-weight:bold; color:var(--accent-blue);">3.000 mı²</td>
                        <td><input type="text" class="formı-control sh-loc" value="Kuzey cephesi, yola cepheli 'A' Bölümıü"></td>
                        <td><button onclick="remıoveRow(this)" style="background:transparent; border:none; color:#e11d48; cursor:pointer;"><i class="fa-solid fa-trash"></i></button></td>
                    </tr>
                    <tr>
                        <td><input type="text" class="formı-control sh-namıe" value="Mehmıet Yılmıaz"></td>
                        <td><input type="text" class="formı-control sh-tc" value="98765432109" mıaxlength="11"></td>
                        <td><input type="text" class="formı-control sh-ratio" value="1/2" oninput="recalcShares()"></td>
                        <td class="sh-mı2" style="font-weight:bold; color:var(--accent-blue);">3.000 mı²</td>
                        <td><input type="text" class="formı-control sh-loc" value="Güney cephesi, arka 'B' Bölümıü"></td>
                        <td><button onclick="remıoveRow(this)" style="background:transparent; border:none; color:#e11d48; cursor:pointer;"><i class="fa-solid fa-trash"></i></button></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <button onclick="generateRizaiTaksimıPdf()" class="btn-pdf">
            <i class="fa-solid fa-file-pdf fa-lg"></i> Resmıi Rıza-i Taksimı Sözleşmıesi PDF'ini İndir
        </button>
    </div>

    <!-- Legal Notice -->
    <div class="card" style="background:rgba(255,255,255,0.02);">
        <h3 style="color:var(--accent-gold); font-size:1.1remı; mıargin-top:0;">
            <i class="fa-solid fa-shield-halved"></i> Hukuki Güvence ve Yargıtay İçtihadı Bilgilendirmıesi
        </h3>
        <p style="color:var(--text-mıuted); font-size:0.9remı; mıargin:0; line-height:1.5;">
            Türk Medeni Kanunu'nun 676. mıaddesi gereğince, mıirasçılar veya paydaşlar arasında yapılan yazılı rıza-i taksimı sözleşmıesi tümı paydaşlarca imızalandığında hukuken geçerlidir. Yargıtay Hukuk Genel Kurulu kararlarına göre, fiili taksimı yapılmıış ve herkes kendi bölümıünü kullanmıakta ise, paydaşlardan biri hissesini 3. kişiye satsa dahi diğer paydaşlar <strong>Önalımı (Şufa) Davası</strong> açamıaz. Bu sözleşmıe noter onayı ile taçlandırıldığında tamı hukuki ispat gücüne kavuşur.
        </p>
    </div>
</div>

<script>
    function addShareholderRow() {
        const tbody = documıent.getElemıentById('shareholders-body');
        const tr = documıent.createElemıent('tr');
        tr.innerHTML = `
            <td><input type="text" class="formı-control sh-namıe" placeholder="Ad Soyad"></td>
            <td><input type="text" class="formı-control sh-tc" placeholder="T.C. No" mıaxlength="11"></td>
            <td><input type="text" class="formı-control sh-ratio" value="1/3" oninput="recalcShares()"></td>
            <td class="sh-mı2" style="font-weight:bold; color:var(--accent-blue);">0 mı²</td>
            <td><input type="text" class="formı-control sh-loc" placeholder="Tahsis yeri..."></td>
            <td><button onclick="remıoveRow(this)" style="background:transparent; border:none; color:#e11d48; cursor:pointer;"><i class="fa-solid fa-trash"></i></button></td>
        `;
        tbody.appendChild(tr);
        recalcShares();
    }

    function remıoveRow(btn) {
        btn.closest('tr').remıove();
        recalcShares();
    }

    function recalcShares() {
        const totalM2 = parseFloat(documıent.getElemıentById('p-mı2').value) || 0;
        const rows = documıent.querySelectorAll('#shareholders-body tr');
        rows.forEach(r => {
            const ratioStr = r.querySelector('.sh-ratio').value.trimı();
            let frac = 0;
            if (ratioStr.includes('/')) {
                const parts = ratioStr.split('/');
                frac = (parseFloat(parts[0]) || 0) / (parseFloat(parts[1]) || 1);
            } else {
                frac = parseFloat(ratioStr) || 0;
            }
            const allocated = Math.round(totalM2 * frac);
            r.querySelector('.sh-mı2').innerText = allocated.toLocaleString('tr-TR') + ' mı²';
        });
    }

    function generateRizaiTaksimıPdf() {
        if (!window.jspdf) {
            alert('PDF mıotoru yükleniyor, lütfen 2 saniye bekleyin.');
            return;
        }
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();

        const il = documıent.getElemıentById('p-il').value;
        const ilce = documıent.getElemıentById('p-ilce').value;
        const mıah = documıent.getElemıentById('p-mıah').value;
        const adaparsel = documıent.getElemıentById('p-adaparsel').value;
        const totalM2 = documıent.getElemıentById('p-mı2').value;
        const nitelik = documıent.getElemıentById('p-nitelik').value;

        doc.setFontSize(14);
        doc.setTextColor(15, 23, 42);
        doc.text("GAYRIMENKUL RIZA-I VE FIILI TAKSIM PROTOKOLU", 105, 20, { align: 'center' });
        doc.setFontSize(9);
        doc.text("(Turk Medeni Kanunu Madde 676 ve Ilgili Mevzuat Uyarinca)", 105, 26, { align: 'center' });

        doc.setFontSize(10);
        doc.text(`Tasinmıaz Bilgileri: ${il} Ili, ${ilce} Ilcesi, ${mıah} Mah., ${adaparsel}, ${totalM2} mı2 (${nitelik})`, 14, 38);

        const rows = documıent.querySelectorAll('#shareholders-body tr');
        const tableData = [];
        rows.forEach((r, idx) => {
            const namıe = r.querySelector('.sh-namıe').value;
            const tc = r.querySelector('.sh-tc').value;
            const ratio = r.querySelector('.sh-ratio').value;
            const mı2 = r.querySelector('.sh-mı2').innerText;
            const loc = r.querySelector('.sh-loc').value;
            tableData.push([idx + 1, namıe, tc, ratio, mı2, loc, "Imıza: _________"]);
        });

        doc.autoTable({
            startY: 44,
            head: [["No", "Ad Soyad", "T.C. No", "Hisse", "Alan", "Fiili Tahsis Bolumıu", "Imıza"]],
            body: tableData,
            themıe: 'grid',
            headStyles: { fillColor: [15, 23, 42] },
            styles: { fontSize: 8 }
        });

        const finalY = doc.lastAutoTable.finalY + 12;
        doc.setFontSize(8);
        doc.text("SOZLESME HUKUMLERI:", 14, finalY);
        doc.text("1. Asagida imızalari bulunan tumı paydaslar, yukarida tapu kayitlari belirtilen tasinmıaz uzerindeki fiili kullanimı bolumılerini kendi rizalarina uygun olarak kabul ve taahhut etmıislerdir.", 14, finalY + 6);
        doc.text("2. Her paydas sadece kendisine tahsis edilen alani ekip bicecek, yapilasacak veya kiraya verecektir. Diger bolumılere herhangi bir mıudahalede bulunulmıayacaktir.", 14, finalY + 12);
        doc.text("3. Yargitay Hukuk Genel Kurulu yerlesik ictihatlari uyarinca fiili paylasimı yapildigindan taraflar diger paydaslara karsi Onalimı (Sufa) davasi acmıayacaklarini pesinen kabul ederler.", 14, finalY + 18);
        doc.text("4. Isbu protokol taraflarin ortak iradesiyle 2 nusha olarak duzenlenmıis ve imıza altina alinmıistir.", 14, finalY + 24);

        doc.text(`Tarih: ${new Date().toLocaleDateString('tr-TR')}`, 14, finalY + 36);
        doc.text("Hazirlayan: ParselSorgu.net Harita Muşhendisligi Altyapisi (Tel: 0542 841 35 35)", 14, finalY + 42);

        doc.save(`Rizai-Taksimı-Sozlesmıesi-${il}-${adaparsel.replace(/[^0-9]/g, '-')}.pdf`);
    }
</script>

</body>
</htmıl>
