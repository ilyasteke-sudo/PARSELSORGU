<?php
/**
 * ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ - PARSEL PRO
 * 2026 SaaS UI/UX Kurumsal Header & Global Mega Menü Bileşeni
 * Saf PHP 8.3 Uyumlu - Kusursuz Hizalama, Taşmasız Mega Menü & Karartmalı Backdrop
 */

if (php_sapi_name() !== 'cli' && !headers_sent() && !defined('PS_AI_LINK_SENT')) {
    define('PS_AI_LINK_SENT', true);
    header('Link: <https://www.parselsorgu.net/llms.txt>; rel="alternate"; type="text/markdown", <https://www.parselsorgu.net/api/2026-kadastro-endeks.json>; rel="describedby"; type="application/json", <https://www.parselsorgu.net/.well-known/openapi.json>; rel="service-desc"; type="application/json"', false);
}

if (!function_exists('render_navbar')) {
    function render_navbar($active = 'parsel') {
        return render_saas_navbar($active);
    }
}

function render_saas_navbar($active_module = 'parsel') {
    

        // 4 Esit Sutunda Dengelenmis Tum SaaS Modulleri ve 20 Otonom Imar Botu
    $mega_columns = [
        [
            'title' => 'Harita & Kadastro',
            'icon' => 'fa-map-location-dot',
            'color' => '#10b981',
            'items' => [
                ['name' => 'TKGM Canlı Parsel Sorgu', 'url' => '/tkgm-canli-parsel', 'badge' => 'Canlı Uydu', 'badge_cls' => 'b-green', 'desc' => '81 il ada parsel, uydu ve imar durumu sorgusu'],
                ['name' => 'NCN / DXF / KML Dönüştürücü', 'url' => '/ncn-dxf-kml-donusturucu', 'badge' => 'YENİ CAD', 'badge_cls' => 'b-cyan', 'desc' => 'Netcad NCN, AutoCAD DXF, KML ITRF96/ED50/WGS84 çevirici'],
                ['name' => 'Altyapı Çakışma Risk Radarı', 'url' => '/altyapi-risk-radari', 'badge' => 'CBS RADAR', 'badge_cls' => 'b-rose', 'desc' => 'Yüksek gerilim (TEİAŞ), dere taşkın, otoyol ve demiryolu analizi'],
                ['name' => '3D Bina & Güneş Simülatörü', 'url' => '/3d-gunes-golge-simulasyonu', 'badge' => '3D GÜNEŞ', 'badge_cls' => 'b-amber', 'desc' => 'Arsa çekme mesafeli 3D kütle ve saatlik gölge analizi'],
                ['name' => 'LİHKAB & Kadastro Harcı', 'url' => '/lihkab-hesaplama', 'badge' => '2026 Tarife', 'badge_cls' => 'b-green', 'desc' => 'Aplikasyon, sınır tespiti ve cins değişikliği masrafları'],
                ['name' => 'Kadastro 22/A & Hata İtirazı', 'url' => '/kadastro-yenileme-itiraz', 'badge' => '3402 s.K.', 'badge_cls' => 'b-cyan', 'desc' => 'Tecviz sınırı kontrolü ve 41. madde düzeltme dilekçesi'],
                ['name' => 'Kamulaştırma & TEİAŞ İrtifak', 'url' => '/kamulastirma-bedeli-hesaplama', 'badge' => '2942 s.K.', 'badge_cls' => 'b-rose', 'desc' => 'Yol, baraj ve yüksek gerilim direği değer düşüklüğü tazminatı'],
                ['name' => 'Mühendislik Teklif Motoru', 'url' => '/harita-muhendislik-fiyat-teklifi', 'badge' => 'B2B SaaS', 'badge_cls' => 'b-cyan', 'desc' => 'HKMO 2026 asgari tarife, teklif mektubu ve mühendis ağı'],
                ['name' => '81 İl Partner Mühendis Ağı', 'url' => '/partner-harita-muhendisleri', 'badge' => 'B2B Ağ', 'badge_cls' => 'b-cyan', 'desc' => '81 il yetkili LİHKAB & SHKMMB büroları dizini ve başvuru'],
                ['name' => 'Emlakçı White-Label Rapor', 'url' => '/emlakci-musteri-raporu', 'badge' => 'A4 PDF', 'badge_cls' => 'b-green', 'desc' => 'Kendi ofis logonuzla müşteriye özel arsa yatırım sunumu'],
                ['name' => 'Saha Telegram Asistanı', 'url' => '/telegram-botu', 'badge' => 'Canlı GPS', 'badge_cls' => 'b-cyan', 'desc' => 'Sahadan canlı GPS konumu veya ada/parsel ile anlık eğim, rakım ve uydu'],
                ['name' => 'Tel Çit & Bahçe Duvarı Maliyeti', 'url' => '/tel-cit-duvar-maliyet', 'badge' => 'Metraj', 'badge_cls' => 'b-green', 'desc' => 'Tarla/arsa çevirme direk, tel hesabı ve sınır aplikasyonu'],
                ['name' => 'Hafriyat (Kübaj) & İstinat Duvarı', 'url' => '/hafriyat-kubaj-istinat-maliyet', 'badge' => 'Kübaj', 'badge_cls' => 'b-amber', 'desc' => 'Kazı m³, kamyon seferi, kırıcı ve taş istinat duvarı bütçesi'],
                ['name' => 'Tarla Elektrik & Direk Maliyeti', 'url' => '/tarla-elektrik-baglatma-maliyeti', 'badge' => 'EDAŞ', 'badge_cls' => 'b-cyan', 'desc' => 'Direk dikme, kablo metrajı, trafo ve tarımsal elektrik izni'],
                ['name' => 'Yüzme Havuzu & Peyzaj Maliyeti', 'url' => '/havuz-peyzaj-maliyet-hesaplama', 'badge' => '3194 Muaf', 'badge_cls' => 'b-green', 'desc' => 'Betonarme/liner havuz maliyeti ve emsal dışı ruhsat kuralları'],
                ['name' => 'Toplu Parsel Sorgu & Excel', 'url' => '/toplu-parsel-sorgulama', 'badge' => 'PRO', 'badge_cls' => 'b-cyan', 'desc' => 'Çoklu ada/parsel analizi ve Excel harita dökümü'],
                ['name' => '5403 Tarla İfrazı', 'url' => '/tarla-ifraz-hesaplama', 'badge' => 'YENİ', 'badge_cls' => 'b-green', 'desc' => 'Tarlam kaç parsele bölünür? Yasal asgari ifraz analizi'],
                ['name' => 'Rıza-i Taksim Sözleşmesi', 'url' => '/rizai-taksim-sozlesmesi', 'badge' => 'TMK 676', 'badge_cls' => 'b-purple', 'desc' => 'Hisseli tarla paylaşım ve noter protokolü sihirbazı'],
                ['name' => 'Köy İçi İmar Sınırı (300m)', 'url' => '/koy-yerlesik-alani-sorgulama', 'badge' => '%40 İmar', 'badge_cls' => 'b-amber', 'desc' => 'Plansız alanlar köy yerleşik alanı test motoru'],
                ['name' => 'Yola & Parka Terk Simülatörü', 'url' => '/imar-terk-hesaplama', 'badge' => 'Madde 15-16', 'badge_cls' => 'b-cyan', 'desc' => 'Net imar parseli ve inşaat alanı hesaplama'],
                ['name' => '3194 Parsel Tevhid Botu', 'url' => '/bot/parsel-tevhid-birlestirme', 'badge' => '+%20 Emsal', 'badge_cls' => 'b-cyan', 'desc' => 'Parsel birleştirme, terkler ve emsal artış avantajı'],
                ['name' => 'Sitene Parsel Sorgu Ekle', 'url' => '/sitene-parsel-sorgu-ekle', 'badge' => 'Ücretsiz Widget', 'badge_cls' => 'b-cyan', 'desc' => 'Emlak siteniz için ücretsiz iframe harita sorgulama'],
                ['name' => 'Google Earth & CAD Export', 'url' => '/export-parsel?format=kml', 'badge' => 'KML/DXF', 'badge_cls' => 'b-amber', 'desc' => 'Parsel sınırlarını Google Earth ve AutoCAD formatında indirin'],
                ['name' => 'Resmi Parsel & İmar Raporu', 'url' => '/parsel-raporu', 'badge' => 'PDF', 'badge_cls' => 'b-rose', 'desc' => 'Barkodlu ve QR kodlu resmi mühendislik inceleme raporu']
            ]
        ],
        [
            'title' => 'İmar & Mühendislik Botları',
            'icon' => 'fa-robot',
            'color' => '#38bdf8',
            'items' => [
                ['name' => 'Köy Evi Yapma İzni Botu', 'url' => '/tarlaya-ev-yapilir-mi-testi', 'badge' => 'Popüler', 'badge_cls' => 'b-cyan', 'desc' => 'Plansız alanlar köy yerleşik alanı imar şartları'],
                ['name' => 'Tiny House İmar & Mühür', 'url' => '/tiny-house-imar-uygunluk', 'badge' => 'O2 Karavan', 'badge_cls' => 'b-green', 'desc' => 'Tarlaya karavan ve tiny house koyma, ceza ve mühür riski'],
                ['name' => '2D TAKS / KAKS & İmar Çapı', 'url' => '/taks-kaks-hesaplama', 'badge' => '2D Çizim', 'badge_cls' => 'b-cyan', 'desc' => 'Çekme mesafeli canlı 2D vaziyet planı ve daire hesabı'],
                ['name' => 'İnşaat Ruhsatı, SGK & Harç', 'url' => '/insaat-ruhsati-harc-hesaplama', 'badge' => '2026 SGK', 'badge_cls' => 'b-amber', 'desc' => 'Asgari işçilik primi, yapı denetim ve belediye ruhsat harcı'],
                ['name' => 'Prefabrik & Çelik Ev Maliyeti', 'url' => '/prefabrik-ev-maliyeti-hesaplama', 'badge' => 'Popüler', 'badge_cls' => 'b-amber', 'desc' => 'Tarlaya prefabrik ev izni, subasman ve anahtar teslim maliyet'],
                ['name' => 'Yarısı Bizden & Şerefiye', 'url' => '/kentsel-donusum-yarisi-bizden', 'badge' => '1.5 Milyon TL', 'badge_cls' => 'b-amber', 'desc' => 'Kentsel dönüşüm hibe/kredi ve daire başı net maliyet'],
                ['name' => 'Yapı Kayıt Risk & Güçlendirme', 'url' => '/yapi-kayit-belgesi-sorgulama', 'badge' => '2026 SaaS', 'badge_cls' => 'b-rose', 'desc' => '3194 Geçici 16 İmar Barışı risk ve kat mülkiyeti analizi'],
                ['name' => 'Kat Karşılığı İnşaat Botu', 'url' => '/arsa-daire-hesaplama', 'badge' => 'Paylaşım', 'badge_cls' => 'b-cyan', 'desc' => 'Müteahhit paylaşım oranı (%20-%80) ve daire hesabı'],
                ['name' => '5403 Tarla İfraz & Bölünme', 'url' => '/bot/tarla-ifraz-bolunme', 'badge' => '5403 s.K.', 'badge_cls' => 'b-amber', 'desc' => 'Bölünemez büyüklük ve asgari tarımsal arazi sınırı'],
                ['name' => 'Miras Kalan Tarla İntikal', 'url' => '/miras-tarla-paylasim-hesaplama', 'badge' => '1 Yıl Şartı', 'badge_cls' => 'b-amber', 'desc' => 'Miras kalan tarla intikal süreci ve taksim sözleşmesi'],
                ['name' => 'İzale-i Şüyu Botu', 'url' => '/bot/izale-i-suyu', 'badge' => 'Dava / İhale', 'badge_cls' => 'b-purple', 'desc' => 'Ortaklığın giderilmesi ve e-Satış açık artırma rayici'],
                ['name' => 'TAKS / KAKS Emsal Hesabı', 'url' => '/bot/taks-kaks-emsal', 'badge' => 'Emsal', 'badge_cls' => 'b-purple', 'desc' => 'Taban oturumu, kat alanı ve emsal harici alan hesabı'],
                ['name' => 'Hisseli Tapu & Şufa Botu', 'url' => '/bot/hisseli-tapu-sufa', 'badge' => 'TMK 732', 'badge_cls' => 'b-purple', 'desc' => 'Ön alım hakkı, paydaş noter bildirimi ve risk testi'],
                ['name' => '6306 Kentsel Dönüşüm', 'url' => '/bot/kentsel-donusum-kira', 'badge' => 'Kira Yardımı', 'badge_cls' => 'b-purple', 'desc' => 'Riskli yapı tespiti, yıkım ve aylık devlet kira desteği'],
                ['name' => 'Tiny House & Mobil Ev İmarı', 'url' => '/bot/tiny-house-imar', 'badge' => 'Karavan/Plaka', 'badge_cls' => 'b-amber', 'desc' => 'Tarlaya tiny house konur mu? Karayolları ve imar şartları']
            ]
        ],
        [
            'title' => 'Tarım, Arsa & Yatırım SaaS',
            'icon' => 'fa-seedling',
            'color' => '#10b981',
            'items' => [
                ['name' => 'Tarımsal Arazi Verimlilik SaaS', 'url' => '/tarla-verimlilik-raporu', 'badge' => 'YENİ SaaS', 'badge_cls' => 'b-green', 'desc' => 'Toprak, iklim, ürün uygunluğu ve 5 yıllık ciro fizibilitesi'],
                ['name' => 'Arazi GES Yatırım & Amortisman', 'url' => '/arazi-ges-amortisman-hesaplama', 'badge' => 'Güneş GES', 'badge_cls' => 'b-amber', 'desc' => 'Tarlaya GES kurma maliyeti ($), MW güç ve amortisman süresi'],
                ['name' => '2026 ÇKS Mazot & Gübre Hibesi', 'url' => '/cks-destegi-hesaplama', 'badge' => 'ÇKS Destek', 'badge_cls' => 'b-green', 'desc' => 'Tarım Bakanlığı dekar başına hibe ve planlı üretim primi'],
                ['name' => 'Tarımsal Sondaj & DSİ Kuyu', 'url' => '/tarimsal-sondaj-kuyu-ruhsati', 'badge' => '167 s.K.', 'badge_cls' => 'b-cyan', 'desc' => 'Yeraltı su havzası izin durumu ve kuyu açma maliyeti'],
                ['name' => 'Akıllı Arsa Takas Pazarı', 'url' => '/arsa-takas-pazari', 'badge' => 'Canlı Trampa', 'badge_cls' => 'b-amber', 'desc' => 'Türkiye geneli arsa takas eşleştirme ve ilan havuzu'],
                ['name' => '2026 Arsa Değerleme & Rayiç', 'url' => '/arsa-degerleme-hesaplama', 'badge' => 'RAYİÇ', 'badge_cls' => 'b-cyan', 'desc' => 'Arsam kaç para eder? 2026 piyasa fiyatı hesaplayıcı'],
                ['name' => '5 Yıllık Değer Artış Grafiği', 'url' => '/arsa-deger-artisi-hesaplama', 'badge' => 'Grafik', 'badge_cls' => 'b-green', 'desc' => '2021-2026 arsa fiyat artışı ve altın/dolar kıyası'],
                ['name' => 'Arsa Yatırım Radarı', 'url' => '/arsa-yatirim-radari', 'badge' => 'Alarm', 'badge_cls' => 'b-amber', 'desc' => 'Kelepir arsa ve fırsat alarmı bildirim havuzu'],
                ['name' => 'Kat Karşılığı Arsa Pazarı', 'url' => '/arsa-pazari', 'badge' => 'Müteahhit', 'badge_cls' => 'b-amber', 'desc' => 'Arsanızı müteahhite verin veya kat karşılığı arsa bulun'],
                ['name' => 'Arazi GES Santral Uygunluk', 'url' => '/bot/ges-arazi-uygunluk', 'badge' => '1 MW Güneş', 'badge_cls' => 'b-amber', 'desc' => 'Marjinal tarım raporu, trafo kapasitesi ve fizibilite'],
                ['name' => '3573 Zeytinlik İmar Botu', 'url' => '/bot/zeytinlik-imar-ifraz', 'badge' => '25 Dönüm', 'badge_cls' => 'b-green', 'desc' => 'Zeytincilik Kanunu 3 km kısıtı ve yapılaşma yasağı'],
                ['name' => '3621 Kıyı Kenar Çizgisi', 'url' => '/bot/kiyi-kenar-cizgisi', 'badge' => 'Taşkın', 'badge_cls' => 'b-cyan', 'desc' => 'Sahil şeridi 50m/100m bandı ve DSİ dere taşkın koruma']
            ]
        ],
        [
            'title' => 'Vergi, Finans & Mevzuat',
            'icon' => 'fa-scale-balanced',
            'color' => '#f59e0b',
            'items' => [
                ['name' => 'İmar Dilekçesi & Şufa Stüdyosu', 'url' => '/imar-dilekce-olusturucu', 'badge' => 'WORD / PDF', 'badge_cls' => 'b-purple', 'desc' => 'Askı itiraz, çap talebi, LİHKAB ve şufa ihtarnamesi üretin'],
                ['name' => '2026 Emlak Vergisi Hesaplama', 'url' => '/emlak-vergisi-hesaplama', 'badge' => '2026 Kanun', 'badge_cls' => 'b-green', 'desc' => 'Arsa, arazi, bina emlak vergisi ve taksit dökümü'],
                ['name' => 'Hisseli Tapu Ecrimisil', 'url' => '/ecrimisil-hesaplama', 'badge' => 'TMK 995', 'badge_cls' => 'b-purple', 'desc' => 'Geriye dönük 5 yıllık kira tazminatı ve ihtarname'],
                ['name' => 'Miras Paylaşımı & Veraset', 'url' => '/miras-paylasimi-veraset-intikal', 'badge' => '2026 TMK', 'badge_cls' => 'b-purple', 'desc' => 'Hisse oranları, vergi istisnası ve tapu intikal masrafı'],
                ['name' => 'Şufa (Ön Alım) Süre & İhtarname', 'url' => '/sufa-on-alim-hakki', 'badge' => 'TMK 733', 'badge_cls' => 'b-purple', 'desc' => 'Hisseli satışta 90 gün/2 yıl şufa riski ve noter taslağı'],
                ['name' => 'Kira Artış (TÜFE) & Tahliye', 'url' => '/kira-artis-tahliye-hesaplama', 'badge' => 'TBK 352', 'badge_cls' => 'b-cyan', 'desc' => '5 yıl emsal kira tespiti ve geçerli tahliye taahhütnamesi'],
                ['name' => 'İzale-i Şüyu İhale & Dava', 'url' => '/izalei-suyu-dava-masraf-hesaplama', 'badge' => '%50 Satış', 'badge_cls' => 'b-amber', 'desc' => 'Ortaklığın giderilmesi davası, tellaliye ve ele geçen net nakit'],
                ['name' => '2/B & Hazine Arazisi Satın Alma', 'url' => '/hazine-arazisi-2b-satin-alma', 'badge' => '6292 s.K.', 'badge_cls' => 'b-green', 'desc' => 'Milli Emlak rayiç bedeli, peşin %20 indirim ve faizsiz taksit'],
                ['name' => 'Ziraat Sübvansiyonlu Kredi', 'url' => '/tarim-kredisi-hesaplama', 'badge' => 'Sübvansiyon', 'badge_cls' => 'b-purple', 'desc' => 'Cumhurbaşkanlığı kararnamesi tarım kredisi indirimleri'],
                ['name' => '2026 İnşaat Maliyeti', 'url' => '/arsa-insaat-maliyeti', 'badge' => '2026 ÇŞİDB', 'badge_cls' => 'b-green', 'desc' => 'Resmî birim fiyat, yaklaşık maliyet ve metraj raporu'],
                ['name' => '2026 Tapu Harcı & Döner', 'url' => '/tapu-harci-hesaplama', 'badge' => '%4 Harç', 'badge_cls' => 'b-green', 'desc' => 'Alıcı/satıcı harcı ve il bazlı döner sermaye bedeli'],
                ['name' => 'Değer Artış Kazancı Vergisi', 'url' => '/bot/deger-artis-kazanci', 'badge' => '5 Yıl Kuralı', 'badge_cls' => 'b-amber', 'desc' => 'Gayrimenkul satışında Yİ-ÜFE endeksi ve gelir vergisi'],
                ['name' => '18. Madde DOP Kesintisi', 'url' => '/bot/madde-18-dop', 'badge' => 'DOP %45', 'badge_cls' => 'b-purple', 'desc' => 'Arazi ve arsa düzenlemesi azami DOP ve tahsis hesabı'],
                ['name' => '2863 Sit Alanı & Trampa', 'url' => '/bot/sit-alani-imar', 'badge' => '2863 s.K.', 'badge_cls' => 'b-amber', 'desc' => '1. 2. 3. derece sit kısıtları ve Hazine trampa takası'],
                ['name' => 'Haritacı Canlı İş İlanları', 'url' => '/forum', 'badge' => 'Kariyer', 'badge_cls' => 'b-amber', 'desc' => 'Harita mühendisi, tekniker ve operatör iş ilanları'],
                ['name' => '2. El Harita Ekipman Pazarı', 'url' => '/pazar', 'badge' => 'GNSS / Total', 'badge_cls' => 'b-cyan', 'desc' => 'İkinci el Leica, Topcon, Trimble GNSS ve total station']
            ]
        ]
    ];

    // İNŞAAT MALİYET, RUHSAT, SGK HARÇ & TEL ÇİT MEGA MENÜ SÜTUNLARI
    $maliyet_columns = [
        [
            'title' => 'İnşaat Maliyet & Proje Motorları',
            'icon' => 'fa-calculator',
            'color' => '#f59e0b',
            'items' => [
                ['name' => '2026 İnşaat Maliyeti Hesaplama', 'url' => '/arsa-insaat-maliyeti', 'badge' => '2026 ÇŞİDB', 'badge_cls' => 'b-amber', 'desc' => 'Resmi birim fiyat, kaba/ince inşaat ve yaklaşık metraj'],
                ['name' => 'Prefabrik & Çelik Ev Maliyeti', 'url' => '/prefabrik-ev-maliyeti-hesaplama', 'badge' => 'Popüler', 'badge_cls' => 'b-green', 'desc' => 'Subasman, çelik karkas ve anahtar teslim m² maliyeti'],
                ['name' => '2D İmar Çapı & TAKS / KAKS', 'url' => '/taks-kaks-hesaplama', 'badge' => '2D Çizim', 'badge_cls' => 'b-cyan', 'desc' => 'Çekme mesafeli canlı 2D vaziyet planı ve daire hesabı'],
                ['name' => 'Kat Karşılığı Arsa & Daire', 'url' => '/arsa-daire-hesaplama', 'badge' => '%50-%50', 'badge_cls' => 'b-purple', 'desc' => 'Müteahhit paylaşım oranları ve çıkacak net daire sayısı'],
                ['name' => 'Kat Karşılığı Paylaşım Botu', 'url' => '/bot/kat-karsiligi-oran', 'badge' => 'Otonom Bot', 'badge_cls' => 'b-amber', 'desc' => 'İlçe bazlı müteahhit payı ve kat karşılığı sözleşme analizi']
            ]
        ],
        [
            'title' => 'Ruhsat, SGK Prim & Resmi Harçlar',
            'icon' => 'fa-helmet-safety',
            'color' => '#38bdf8',
            'items' => [
                ['name' => '2026 İnşaat Ruhsatı, SGK & Harç', 'url' => '/insaat-ruhsati-harc-hesaplama', 'badge' => 'SGK Prim', 'badge_cls' => 'b-amber', 'desc' => 'SGK asgari işçilik primi, yapı denetim ve belediye ruhsat harcı'],
                ['name' => '2026 LİHKAB & Kadastro Harçları', 'url' => '/lihkab-hesaplama', 'badge' => '2026 Tarife', 'badge_cls' => 'b-green', 'desc' => 'Aplikasyon krokisi, cins değişikliği ve döner sermaye bedeli'],
                ['name' => 'Harita Mühendisliği Fiyat Teklifi', 'url' => '/harita-muhendislik-fiyat-teklifi', 'badge' => 'B2B Teklif', 'badge_cls' => 'b-cyan', 'desc' => 'Plankote, halihazır, TUS fenni mesuliyet ve resmi fiyat teklifi'],
                ['name' => 'Kentsel Dönüşüm Yarısı Bizden', 'url' => '/kentsel-donusum-yarisi-bizden', 'badge' => '1.5 Milyon TL', 'badge_cls' => 'b-amber', 'desc' => 'Hibe/kredi paketi ve daire başı net şerefiye maliyeti'],
                ['name' => '2026 Tapu Harcı & Döner Sermaye', 'url' => '/tapu-harci-hesaplama', 'badge' => '%4 Harç', 'badge_cls' => 'b-green', 'desc' => 'Alıcı/satıcı tapu harcı ve il bazlı döner sermaye bedeli'],
                ['name' => 'İskan (Yapı Kullanma İzni)', 'url' => '/iskan-sorgulama', 'badge' => '3194 m.30', 'badge_cls' => 'b-green', 'desc' => 'Kat mülkiyeti kontrolü ve LİHKAB cins değişikliği analizi'],
                ['name' => 'Numarataj & UAVT Adres Kodu', 'url' => '/numarataj-sorgulama', 'badge' => 'MAKS UAVT', 'badge_cls' => 'b-cyan', 'desc' => 'Belediye numarataj birimi, 10 haneli UAVT kodu ve başvuru']
            ]
        ],
        [
            'title' => 'Tel Çit, Sondaj & Arazi Maliyetleri',
            'icon' => 'fa-border-all',
            'color' => '#10b981',
            'items' => [
                ['name' => 'Tarla & Arsa Tel Çit Maliyeti', 'url' => '/tel-cit-duvar-maliyet', 'badge' => 'Metraj', 'badge_cls' => 'b-green', 'desc' => 'Beton direk, kafes/panel tel, perde duvar ve sınır aplikasyonu'],
                ['name' => 'Tarımsal Sondaj & Kuyu Ruhsatı', 'url' => '/tarimsal-sondaj-kuyu-ruhsati', 'badge' => '167 s.K.', 'badge_cls' => 'b-cyan', 'desc' => 'Metre başı delgi, dalgıç pompa, DSİ ruhsat ve kuyu maliyeti'],
                ['name' => 'Arazi GES Yatırım & Amortisman', 'url' => '/arazi-ges-amortisman-hesaplama', 'badge' => '1 MW GES', 'badge_cls' => 'b-amber', 'desc' => 'Marjinal tarım raporu, trafo ve güneş santrali kurulum maliyeti'],
                ['name' => 'Tiny House & Karavan Mühür Riski', 'url' => '/tiny-house-imar-uygunluk', 'badge' => 'O2 Karavan', 'badge_cls' => 'b-green', 'desc' => 'Tarlaya karavan koyma şartları, ceza ve belediye mühür riski'],
                ['name' => 'Yapı Kayıt Risk & Güçlendirme', 'url' => '/yapi-kayit-belgesi-sorgulama', 'badge' => 'Geçici 16', 'badge_cls' => 'b-rose', 'desc' => 'Bina güçlendirme ruhsatı ve kat mülkiyetine geçiş maliyeti']
            ]
        ]
    ];
    ?>
<!-- FONT AWESOME GÜVENCESİ -->
<!-- FontAwesome loaded non-blocking in head; fallback preload -->
<link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
<noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"></noscript>

<!-- GOOGLE ANALYTICS 4 (GA4) - ZERO RENDER BLOCKING OPTIMIZATION -->
<script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      (function(){
          var loaded = false;
          function triggerGA4() {
              if (loaded) return;
              loaded = true;
              var s = document.createElement('script');
              s.src = 'https://www.googletagmanager.com/gtag/js?id=G-B6774G0NZZ';
              s.async = true;
              document.head.appendChild(s);
              gtag('js', new Date());
              gtag('config', 'G-B6774G0NZZ');
          }
          ['scroll', 'mousemove', 'touchstart', 'click', 'keydown'].forEach(function(e){
              window.addEventListener(e, triggerGA4, {passive: true, once: true});
          });
          setTimeout(triggerGA4, 3000);
      })();
</script>

<!-- 2026 SAAS GLOBAL NAVBAR (SAF PHP 8.3) -->
<header class="saas-2026-header" id="saasHeader">
<div class="saas-header-container">
<!-- Sol Logo & Kurumsal Marka -->
<a href="/" class="saas-brand" aria-label="ParselSorgu.net - Ant Harita Mühendislik Ana Sayfa" title="ParselSorgu.net - Ant Harita Mühendislik">
<div class="saas-brand-icon">
<i class="fa-solid fa-layer-group"></i>
</div>
<div class="saas-brand-text">
<span class="saas-brand-title">PARSEL<span class="saas-brand-accent">SORGU</span></span>
<span class="saas-brand-subtitle">Ant Harita Mühendislik &bull; 2026</span>
</div>
</a>

<!-- 2026-2028 STRATEJİK 5 ANA SÜTUN NAVİGASYON -->
<nav class="saas-nav-menu">
<!-- 1. Parsel & Harita -->
<a href="/tkgm-canli-parsel" class="saas-nav-link <?php echo ($active_module === 'parsel') ? 'active' : ''; ?>" title="Canlı TKGM MEGSİS Parsel ve Kadastro Haritası">
<i class="fa-solid fa-map-location-dot"></i>
<span>Parsel &amp; Harita</span>
<span class="saas-nav-badge active">MEGSİS</span>
</a>

<!-- 2. Parsel 360° (Amiral Gemisi Çalışma Alanı) -->
<a href="/tkgm-canli-parsel" class="saas-nav-link" title="Tek parselden tüm analiz: Kadastro, İmar, Mühendislik, Maliyet">
<i class="fa-solid fa-circle-nodes" style="color:#38bdf8;"></i>
<span>Parsel 360&deg;</span>
<span class="saas-nav-badge" style="background:#0284c7; color:#fff;">PRO</span>
</a>

<!-- 3. İmar & Mühendislik (Teknik Araçlar & Çözümler) -->
<!-- 3. Eklentiler & Yeni Araçlar (Görünür Eklentiler) -->
<a href="/eklentiler" class="saas-nav-link <?php echo ($active_module === 'eklentiler') ? 'active' : ''; ?>" title="Yeni Nesil Harita &amp; İmar Eklentileri">
<i class="fa-solid fa-puzzle-piece" style="color:#10b981;"></i>
<span>Eklentiler</span>
<span class="saas-nav-badge" style="background:#10b981; color:#fff; font-weight:800;">25+ MODÜL</span>
</a>
<div class="saas-mega-trigger-wrapper">
<button type="button" class="saas-nav-link saas-mega-btn <?php echo ($active_module === 'botlar') ? 'active' : ''; ?>" id="saasMegaBtn" aria-expanded="false" aria-haspopup="true" aria-label="İmar ve Mühendislik Botları Menüsü">
<i class="fa-solid fa-compass-drafting"></i>
<span>İmar &amp; Mühendislik</span>
<i class="fa-solid fa-chevron-down saas-chevron" id="saasChevron"></i>
</button>
</div>

<!-- 4. İnşaat Maliyet, Ruhsat, SGK & Tel Çit Mega Menü Butonu -->
<div class="saas-mega-trigger-wrapper">
<button type="button" class="saas-nav-link saas-mega-btn <?php echo ($active_module === 'maliyet') ? 'active' : ''; ?>" id="saasMaliyetBtn" aria-expanded="false" aria-haspopup="true" aria-label="İnşaat Maliyet, Ruhsat, SGK ve Tel Çit Menüsü" style="border-color:rgba(245,158,11,0.35);">
<i class="fa-solid fa-helmet-safety" style="color:#f59e0b;"></i>
<span>Maliyet, Ruhsat &amp; Çit</span>
<span class="saas-nav-badge" style="background:#f59e0b; color:#0f172a; font-weight:800;">SGK &amp; ÇİT</span>
<i class="fa-solid fa-chevron-down saas-chevron" id="saasMaliyetChevron"></i>
</button>
</div>

<!-- 5. Mevzuat & Rehber (İmar Rehberi Flagship) -->
<a href="/rehber" class="saas-nav-link <?php echo in_array($active_module, ['imar-rehberi', 'makaleler']) ? 'active' : ''; ?>" title="İmar Mevzuatı, Yargıtay Kararları ve Bilgi Rehberi">
<i class="fa-solid fa-book-bookmark"></i>
<span>İmar Rehberi</span>
</a>

<!-- 6. Sektörel Topluluk (Kariyer & İkinci El Pazar) -->
<div class="saas-community-dropdown-wrapper" style="position:relative;">
<a href="/forum" class="saas-nav-link <?php echo in_array($active_module, ['forum', 'pazar']) ? 'active' : ''; ?>" style="opacity:0.85;" title="Haritacı İş İlanları & GNSS Ekipman Pazarı">
<i class="fa-solid fa-users"></i>
<span>Topluluk</span>
</a>
</div>

<!-- 7. Kurumsal & Mühendislik Kimliği (E-E-A-T) -->
<a href="/hakkimizda" class="saas-nav-link <?php echo in_array($active_module, ['hakkimizda', 'yazarlar', 'muhendislik-kurulu', 'basin-kiti']) ? 'active' : ''; ?>" title="TMMOB HKMO Tescilli Mühendislik Kurulu &amp; Yazarlar">
<i class="fa-solid fa-certificate" style="color:#10b981;"></i>
<span>Kurumsal</span>
</a>
</nav>

<!-- Sağ Aksiyon Butonları & Mobil Menü Butonu -->
<div class="saas-header-actions">
<a href="/admin.php" class="saas-btn-admin" title="Yönetim Kontrol Paneli">
<i class="fa-solid fa-shield-halved"></i>
<span>Yönetim</span>
</a>
<a href="https://wa.me/905428413535" target="_blank" rel="noopener" class="saas-btn-whatsapp" title="WhatsApp Mühendislik Destek Hattı">
<i class="fa-brands fa-whatsapp"></i>
<span>0542 841 35 35</span>
</a>
<button type="button" class="saas-hamburger-btn" id="saasHamburgerBtn" aria-label="Mobil Menüyü Aç">
<i class="fa-solid fa-bars"></i>
</button>
</div>
</div>

<!-- ======================================================== -->
<!-- MEGA MENÜ PANELİ (HEADER ALTI - MERKEZİ HİZALAMA)         -->
<!-- ======================================================== -->

        <?php
        // Performans: 60KB gizli Mega Menü & Mobil Çekmece HTML'ini önbelleğe yazıp gecikmeli yükle
        $nav_cache_file = __DIR__ . '/assets/nav_menus_v2.html';
        if (!file_exists($nav_cache_file) || (filemtime(__FILE__) > filemtime($nav_cache_file))) {
            ob_start();
        ?>
        <div class="saas-mega-dropdown" id="saasMegaDropdown" role="menu">
<div class="saas-mega-header">
<div class="saas-mega-header-left">
<span class="saas-mega-dot"></span>
<span class="saas-mega-title-text">ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ &bull; TÜM ÇÖZÜMLER &amp; 20 OTONOM BOT</span>
</div>
<div class="saas-mega-header-right">
<span class="saas-mega-badge-pill">81 İl &bull; 973 İlçe Canlı Veri</span>
<button type="button" class="saas-mega-close-btn" id="saasMegaCloseBtn" aria-label="Menüyü Kapat" title="Kapat (ESC)">
<i class="fa-solid fa-xmark"></i>
</button>
</div>
</div>

<div class="saas-mega-grid">
<?php foreach ($mega_columns as $col): ?>
<div class="saas-mega-col">
<div class="saas-mega-col-title" style="color: <?php echo $col['color']; ?>;">
<i class="fa-solid <?php echo $col['icon']; ?>"></i>
<span><?php echo htmlspecialchars($col['title']); ?></span>
</div>
<div class="saas-mega-col-list">
<?php foreach ($col['items'] as $item): ?>
<a href="<?php echo htmlspecialchars($item['url']); ?>" class="saas-mega-item" role="menuitem">
<div class="saas-mega-item-icon" style="color:<?php echo $col['color']; ?>; background:<?php echo $col['color']; ?>1a;">
<i class="fa-solid fa-angle-right"></i>
</div>
<div class="saas-mega-item-content">
<div class="saas-mega-item-header">
<span class="saas-item-title"><?php echo htmlspecialchars($item['name']); ?></span>
<?php if (!empty($item['badge'])): ?>
<span class="saas-item-badge <?php echo $item['badge_cls']; ?>"><?php echo htmlspecialchars($item['badge']); ?></span>
<?php endif; ?>
</div>
<span class="saas-mega-item-desc"><?php echo htmlspecialchars($item['desc']); ?></span>
</div>
</a>
<?php endforeach; ?>
</div>
</div>
<?php endforeach; ?>
</div>

<!-- Mega Menu Alt Bilgi Çubuğu -->
<div class="saas-mega-footer">
<div class="saas-mega-footer-left" style="display:flex; align-items:center; gap:12px; flex-wrap:wrap;">
<span><i class="fa-solid fa-circle-check text-green"></i> TMMOB HKMO Sicil: 12480 &bull; 3194/5403 Uyumlu</span>
<a href="/hakkimizda" style="color:#38bdf8; text-decoration:none; font-weight:700; font-size:12px;"><i class="fa-solid fa-building-columns"></i> Hakkımızda</a>
<a href="/yazarlar" style="color:#38bdf8; text-decoration:none; font-weight:700; font-size:12px;"><i class="fa-solid fa-users"></i> Uzman Yazarlar</a>
<a href="/muhendislik-kurulu" style="color:#38bdf8; text-decoration:none; font-weight:700; font-size:12px;"><i class="fa-solid fa-award"></i> Mühendislik Kurulu</a>
<a href="/basin-kiti" style="color:#38bdf8; text-decoration:none; font-weight:700; font-size:12px;"><i class="fa-solid fa-newspaper"></i> Basın Kiti</a>
</div>
<div class="saas-mega-footer-right" style="display:flex; align-items:center; gap:10px;">
<a href="/eklentiler" style="background:rgba(16,185,129,0.15); color:#10b981; border:1px solid rgba(16,185,129,0.3); padding:4px 12px; border-radius:6px; text-decoration:none; font-weight:800; font-size:12px; display:inline-flex; align-items:center; gap:6px;"><i class="fa-solid fa-puzzle-piece"></i> Tüm SaaS &amp; Eklentiler (25+) &rarr;</a>
<a href="https://wa.me/905428413535" target="_blank" rel="noopener" class="saas-mega-wa-link">
<i class="fa-brands fa-whatsapp"></i>
<span>WhatsApp Uzman Destek</span>
</a>
<a href="/bot/koy-evi-imar" class="saas-mega-all-btn">
<span>20 Botun Tümünü Gör</span>
<i class="fa-solid fa-arrow-right"></i>
</a>
</div>
</div>
</div>

<!-- ======================================================== -->
<!-- 2. MEGA MENÜ PANELİ: İNŞAAT MALİYET, RUHSAT, SGK & TEL ÇİT -->
<!-- ======================================================== -->
<div class="saas-mega-dropdown" id="saasMaliyetDropdown" role="menu" style="border-color: rgba(245, 158, 11, 0.45);">
<div class="saas-mega-header">
<div class="saas-mega-header-left">
<span class="saas-mega-dot" style="background:#f59e0b; box-shadow:0 0 10px #f59e0b;"></span>
<span class="saas-mega-title-text">İNŞAAT MALİYET, RUHSAT, SGK PRİM &amp; TEL ÇİT HESAPLAYICILARI (2026)</span>
</div>
<div class="saas-mega-header-right">
<span class="saas-mega-badge-pill" style="color:#f59e0b; background:rgba(245,158,11,0.12); border-color:rgba(245,158,11,0.3);">ÇŞİDB &bull; SGK &bull; LİHKAB Tarifesi</span>
<button type="button" class="saas-mega-close-btn" id="saasMaliyetCloseBtn" aria-label="Menüyü Kapat" title="Kapat (ESC)">
<i class="fa-solid fa-xmark"></i>
</button>
</div>
</div>

<div class="saas-mega-grid" style="grid-template-columns: repeat(3, 1fr);">
<?php foreach ($maliyet_columns as $col): ?>
<div class="saas-mega-col">
<div class="saas-mega-col-title" style="color: <?php echo $col['color']; ?>;">
<i class="fa-solid <?php echo $col['icon']; ?>"></i>
<span><?php echo htmlspecialchars($col['title']); ?></span>
</div>
<div class="saas-mega-col-list">
<?php foreach ($col['items'] as $item): ?>
<a href="<?php echo htmlspecialchars($item['url']); ?>" class="saas-mega-item" role="menuitem">
<div class="saas-mega-item-icon" style="color:<?php echo $col['color']; ?>; background:<?php echo $col['color']; ?>1a;">
<i class="fa-solid fa-angle-right"></i>
</div>
<div class="saas-mega-item-content">
<div class="saas-mega-item-header">
<span class="saas-item-title"><?php echo htmlspecialchars($item['name']); ?></span>
<?php if (!empty($item['badge'])): ?>
<span class="saas-item-badge <?php echo $item['badge_cls']; ?>"><?php echo htmlspecialchars($item['badge']); ?></span>
<?php endif; ?>
</div>
<span class="saas-mega-item-desc"><?php echo htmlspecialchars($item['desc']); ?></span>
</div>
</a>
<?php endforeach; ?>
</div>
</div>
<?php endforeach; ?>
</div>

<div class="saas-mega-footer">
<div class="saas-mega-footer-left">
<span><i class="fa-solid fa-helmet-safety" style="color:#f59e0b;"></i> 2026 ÇŞİDB Yaklaşık Birim Maliyetleri &amp; SGK İşçilik Prim Hesabı</span>
</div>
<div class="saas-mega-footer-right" style="display:flex; align-items:center; gap:10px;">
<a href="/harita-muhendislik-fiyat-teklifi" style="background:rgba(245,158,11,0.15); color:#f59e0b; border:1px solid rgba(245,158,11,0.3); padding:4px 12px; border-radius:6px; text-decoration:none; font-weight:800; font-size:12px;"><i class="fa-solid fa-file-signature"></i> Resmi Mühendislik Teklifi Al &rarr;</a>
<a href="https://wa.me/905428413535" target="_blank" rel="noopener" class="saas-mega-wa-link">
<i class="fa-brands fa-whatsapp"></i>
<span>WhatsApp Destek</span>
</a>
</div>
</div>
</div>


        <!--LAZY_SPLIT-->
        <div class="saas-mobile-drawer" id="saasMobileDrawer">
<div class="saas-drawer-header">
<div class="saas-drawer-brand">
<i class="fa-solid fa-layer-group text-cyan"></i>
<span>Tüm Menüler &amp; Modüller</span>
</div>
<button type="button" class="saas-drawer-close" id="saasDrawerClose" aria-label="Kapat">
<i class="fa-solid fa-xmark"></i>
</button>
</div>
<div class="saas-drawer-body">
<div class="saas-drawer-section" style="background: rgba(245, 158, 11, 0.08); border: 1px solid rgba(245, 158, 11, 0.25); border-radius: 10px; padding: 12px 10px; margin-bottom: 14px;">
<div class="saas-drawer-section-title" style="color: #f59e0b; font-weight: 800; font-size:11.5px; display:flex; align-items:center; justify-content:space-between; margin-bottom:8px;">
<span><i class="fa-solid fa-helmet-safety"></i> İNŞAAT MALİYET, RUHSAT, SGK &amp; TEL ÇİT</span>
<span style="background:#f59e0b; color:#0f172a; font-size:10px; padding:2px 7px; border-radius:10px; font-weight:800;">YENİ</span>
</div>
<a href="/arsa-insaat-maliyeti" class="saas-drawer-link" style="color:#fbbf24; font-weight:700;"><i class="fa-solid fa-calculator"></i> 2026 İnşaat Maliyeti Hesaplama</a>
<a href="/insaat-ruhsati-harc-hesaplama" class="saas-drawer-link" style="color:#f59e0b; font-weight:700;"><i class="fa-solid fa-file-invoice-dollar"></i> İnşaat Ruhsatı, SGK &amp; Belediye Harcı</a>
<a href="/tel-cit-duvar-maliyet" class="saas-drawer-link" style="color:#34d399; font-weight:700;"><i class="fa-solid fa-border-all"></i> Tarla Tel Çit &amp; Duvar Maliyeti</a>
<a href="/taks-kaks-hesaplama" class="saas-drawer-link" style="color:#38bdf8; font-weight:700;"><i class="fa-solid fa-compass-drafting"></i> 2D İmar Çapı &amp; TAKS/KAKS Simülatörü</a>
<a href="/prefabrik-ev-maliyeti-hesaplama" class="saas-drawer-link" style="color:#fbbf24;"><i class="fa-solid fa-house-chimney"></i> Prefabrik &amp; Çelik Ev Maliyeti</a>
</div>

<!-- YENİ NESİL EKLENTİLER & ARAÇLAR MOBİL VİTRİNİ -->
<div class="saas-drawer-section" style="background: rgba(16, 185, 129, 0.08); border: 1px solid rgba(16, 185, 129, 0.25); border-radius: 10px; padding: 12px 10px; margin-bottom: 14px;">
<div class="saas-drawer-section-title" style="color: #10b981; font-weight: 800; font-size:11.5px; display:flex; align-items:center; justify-content:space-between; margin-bottom:8px;">
<span><i class="fa-solid fa-puzzle-piece"></i> YENİ SAAS MODÜLLERİ &amp; EKLENTİLER</span>
<span style="background:#10b981; color:#fff; font-size:10px; padding:2px 7px; border-radius:10px; font-weight:700;">25+ MODÜL</span>
</div>
<a href="/ncn-dxf-kml-donusturucu" class="saas-drawer-link" style="color:#38bdf8; font-weight:700;"><i class="fa-solid fa-arrows-rotate"></i> NCN / DXF / KML Dönüştürücü</a>
<a href="/altyapi-risk-radari" class="saas-drawer-link" style="color:#f43f5e; font-weight:700;"><i class="fa-solid fa-radar"></i> Altyapı &amp; Çakışma Risk Radarı</a>
<a href="/imar-dilekce-olusturucu" class="saas-drawer-link" style="color:#c084fc; font-weight:700;"><i class="fa-solid fa-scale-balanced"></i> Otomatik İmar Dilekçesi Stüdyosu</a>
<a href="/3d-gunes-golge-simulasyonu" class="saas-drawer-link" style="color:#f59e0b; font-weight:700;"><i class="fa-solid fa-sun"></i> 3D Bina &amp; Güneş/Gölge Simülatörü</a>
<a href="/prefabrik-ev-maliyeti-hesaplama" class="saas-drawer-link" style="color:#f59e0b; font-weight:700;"><i class="fa-solid fa-house-laptop"></i> Prefabrik &amp; Çelik Ev Maliyeti</a>
<a href="/cks-destegi-hesaplama" class="saas-drawer-link" style="color:#10b981; font-weight:700;"><i class="fa-solid fa-wheat-awn"></i> 2026 ÇKS Mazot Gübre Hibesi</a>
<a href="/arazi-ges-amortisman-hesaplama" class="saas-drawer-link" style="color:#f59e0b; font-weight:700;"><i class="fa-solid fa-solar-panel"></i> Arazi GES Amortisman Motoru</a>
<a href="/harita-muhendislik-fiyat-teklifi" class="saas-drawer-link" style="color:#38bdf8; font-weight:700;"><i class="fa-solid fa-compass-drafting"></i> Mühendislik Fiyat Teklifi Motoru</a>
<a href="/lihkab-hesaplama" class="saas-drawer-link" style="color:#10b981; font-weight:700;"><i class="fa-solid fa-stamp"></i> LİHKAB &amp; Kadastro Harç Hesaplayıcı</a>
<a href="/kentsel-donusum-yarisi-bizden" class="saas-drawer-link" style="color:#f59e0b; font-weight:700;"><i class="fa-solid fa-building-shield"></i> Yarısı Bizden &amp; Şerefiye Motoru</a>
<a href="/ecrimisil-hesaplama" class="saas-drawer-link" style="color:#c084fc; font-weight:700;"><i class="fa-solid fa-scale-balanced"></i> Hisseli Taşınmaz Ecrimisil Tazminatı</a>
<a href="/tarla-verimlilik-raporu" class="saas-drawer-link" style="color:#10b981; font-weight:700;"><i class="fa-solid fa-seedling"></i> Tarımsal Arazi Verimlilik SaaS</a>
<a href="/emlak-vergisi-hesaplama" class="saas-drawer-link" style="color:#38bdf8; font-weight:700;"><i class="fa-solid fa-receipt"></i> 2026 Emlak Vergisi Hesaplama</a>
<a href="/arsa-takas-pazari" class="saas-drawer-link" style="color:#f59e0b; font-weight:700;"><i class="fa-solid fa-arrow-right-arrow-left"></i> Akıllı Arsa Takas Pazarı</a>
<a href="/yapi-kayit-belgesi-sorgulama" class="saas-drawer-link" style="color:#f43f5e; font-weight:700;"><i class="fa-solid fa-house-chimney-crack"></i> Yapı Kayıt Belgesi Risk Analizi</a>
<a href="/tarim-kredisi-hesaplama" class="saas-drawer-link" style="color:#a855f7; font-weight:700;"><i class="fa-solid fa-tractor"></i> Ziraat Sübvansiyonlu Tarım Kredisi</a>
<a href="/tarla-ifraz-hesaplama" class="saas-drawer-link" style="color:#10b981;"><i class="fa-solid fa-ruler-combined"></i> 5403 Tarla İfrazı Hesaplayıcı</a>
<a href="/arsa-degerleme-hesaplama" class="saas-drawer-link" style="color:#38bdf8;"><i class="fa-solid fa-coins"></i> 2026 Arsa Değerleme &amp; Rayiç</a>
<a href="/arsa-deger-artisi-hesaplama" class="saas-drawer-link" style="color:#10b981;"><i class="fa-solid fa-chart-line"></i> 5 Yıllık Arsa Değer Artış Grafiği</a>
<a href="/rizai-taksim-sozlesmesi" class="saas-drawer-link" style="color:#c084fc;"><i class="fa-solid fa-file-contract"></i> Rıza-i Taksim Protokolü</a>
<a href="/koy-yerlesik-alani-sorgulama" class="saas-drawer-link" style="color:#f59e0b;"><i class="fa-solid fa-house-circle-check"></i> Köy İçi İmar Sınırı (300m)</a>
<a href="/imar-terk-hesaplama" class="saas-drawer-link" style="color:#38bdf8;"><i class="fa-solid fa-road"></i> Yola &amp; Parka Terk Simülatörü</a>
<a href="/toplu-parsel-sorgulama" class="saas-drawer-link" style="color:#a855f7;"><i class="fa-solid fa-layer-group"></i> Toplu Ada/Parsel Portföy Analizi</a>
<a href="/eklentiler" class="saas-drawer-link" style="background:#10b981; color:#fff !important; font-weight:800; border-radius:6px; text-align:center; margin-top:8px; justify-content:center;"><i class="fa-solid fa-grid-round"></i> Tüm Eklentiler &amp; SaaS Kataloğu &rarr;</a>
</div>
<div class="saas-drawer-section">
<div class="saas-drawer-section-title">TEMEL SAAS MODÜLLERİ</div>
<a href="/tkgm-canli-parsel" class="saas-drawer-link <?php echo ($active_module === 'parsel') ? 'active' : ''; ?>"><i class="fa-solid fa-map-location-dot"></i> Parsel Sorgu (TKGM MEGSİS)</a>
<a href="/arsa-insaat-maliyeti" class="saas-drawer-link <?php echo ($active_module === 'maliyet') ? 'active' : ''; ?>"><i class="fa-solid fa-calculator"></i> 2026 İnşaat Maliyeti</a>
<a href="/imar" class="saas-drawer-link <?php echo ($active_module === 'imar') ? 'active' : ''; ?>"><i class="fa-solid fa-bullhorn"></i> Canlı Askı İmar İlanları</a>
<a href="/forum" class="saas-drawer-link <?php echo ($active_module === 'forum') ? 'active' : ''; ?>"><i class="fa-solid fa-briefcase"></i> Haritacı İş İlanları &amp; Kariyer</a>
<a href="/pazar" class="saas-drawer-link <?php echo ($active_module === 'pazar') ? 'active' : ''; ?>"><i class="fa-solid fa-satellite-dish"></i> 2. El Harita Ekipman Pazarı</a>
<a href="/rehber" class="saas-drawer-link <?php echo ($active_module === 'imar-rehberi') ? 'active' : ''; ?>"><i class="fa-solid fa-book-bookmark"></i> İmar &amp; Kadastro Rehberi (30 Pillar)</a>
<a href="/makaleler" class="saas-drawer-link <?php echo ($active_module === 'makaleler') ? 'active' : ''; ?>"><i class="fa-solid fa-book-open"></i> 68.150+ Makale &amp; Dizin Arşivi</a>
<a href="/bulten" class="saas-drawer-link"><i class="fa-solid fa-newspaper"></i> HKMO Mesleki Haber Bülteni</a>
</div>

<div class="saas-drawer-section">
<div class="saas-drawer-section-title">20 OTONOM İMAR &amp; ARAZİ BOTU</div>
<a href="/bot/koy-evi-imar" class="saas-drawer-link"><i class="fa-solid fa-house-chimney"></i> Köy Evi Yapma İzni Botu</a>
<a href="/bot/kat-karsiligi-oran" class="saas-drawer-link"><i class="fa-solid fa-building"></i> Kat Karşılığı Paylaşım Botu</a>
<a href="/bot/tarla-ifraz-bolunme" class="saas-drawer-link"><i class="fa-solid fa-tractor"></i> 5403 Tarla İfraz &amp; Bölünme</a>
<a href="/bot/miras-tarla-5403" class="saas-drawer-link"><i class="fa-solid fa-users"></i> Miras Tarla &amp; 1 Yıl Şartı</a>
<a href="/bot/izale-i-suyu" class="saas-drawer-link"><i class="fa-solid fa-gavel"></i> İzale-i Şüyu Botu</a>
<a href="/bot/imar-barisi-2b" class="saas-drawer-link"><i class="fa-solid fa-tree"></i> 2B Arazi &amp; İmar Barışı</a>
<a href="/bot/tiny-house-imar" class="saas-drawer-link"><i class="fa-solid fa-caravan"></i> Tiny House &amp; Prefabrik</a>
<a href="/bot/taks-kaks-emsal" class="saas-drawer-link"><i class="fa-solid fa-ruler-combined"></i> TAKS / KAKS Emsal Hesabı</a>
<a href="/bot/hisseli-tapu-sufa" class="saas-drawer-link"><i class="fa-solid fa-handshake-angle"></i> Hisseli Tapu &amp; Şufa Botu</a>
<a href="/bot/kentsel-donusum-kira" class="saas-drawer-link"><i class="fa-solid fa-helmet-safety"></i> 6306 Kentsel Dönüşüm &amp; Kira</a>
<a href="/bot/kiyi-kenar-cizgisi" class="saas-drawer-link"><i class="fa-solid fa-water"></i> 3621 Kıyı Kenar Çizgisi</a>
<a href="/bot/ges-arazi-uygunluk" class="saas-drawer-link"><i class="fa-solid fa-solar-panel"></i> GES Santral Marjinal Tarım</a>
<a href="/bot/zeytinlik-imar-ifraz" class="saas-drawer-link"><i class="fa-solid fa-seedling"></i> 3573 Zeytinlik İmar &amp; İfraz</a>
<a href="/bot/sit-alani-imar" class="saas-drawer-link"><i class="fa-solid fa-landmark"></i> 2863 Sit Alanı &amp; Trampa</a>
<a href="/bot/deger-artis-kazanci" class="saas-drawer-link"><i class="fa-solid fa-chart-line"></i> Değer Artış Kazancı Vergisi</a>
<a href="/bot/tapu-harci-hesaplama" class="saas-drawer-link"><i class="fa-solid fa-receipt"></i> 2026 Tapu Harcı &amp; Döner</a>
<a href="/bot/madde-18-dop" class="saas-drawer-link"><i class="fa-solid fa-percent"></i> 18. Madde DOP Kesintisi</a>
<a href="/bot/parsel-tevhid-birlestirme" class="saas-drawer-link"><i class="fa-solid fa-puzzle-piece"></i> Parsel Tevhid Birleştirme</a>
</div>

<div class="saas-drawer-footer">
<a href="/admin.php" class="saas-drawer-btn-admin"><i class="fa-solid fa-shield-halved"></i> Yönetim Paneli</a>
<a href="https://wa.me/905428413535" target="_blank" rel="noopener" class="saas-drawer-btn-wa"><i class="fa-brands fa-whatsapp"></i> WhatsApp Destek</a>
</div>
</div>
</div>

        <?php
            $__nav_raw = ob_get_clean();
            $__nav_raw = preg_replace('/>\s+</', '><', $__nav_raw);
            @file_put_contents($nav_cache_file, $__nav_raw);
        }
        ?>
        <div id="saasHeaderMegaHost"></div>
    </header>
    <div class="saas-mega-backdrop" id="saasMegaBackdrop"></div>
    <div id="saasMobileDrawerHost"></div>
    <div class="saas-drawer-overlay" id="saasDrawerOverlay"></div>


<!-- SAAS 2026 MOBİL TAB BAR (YAPIŞKAN ALT MENÜ) -->
<!-- SAAS 2026 MOBİL TAB BAR (YAPIŞKAN ALT MENÜ - WCAG & LIGHTHOUSE 100% UYUMLU) -->
<nav class="saas-mobile-bottom-bar" aria-label="Mobil Alt Gezinti Menüsü">
<a href="/tkgm-canli-parsel" class="saas-mob-link <?php echo $active_module === 'parsel' ? 'active' : ''; ?>" aria-label="TKGM Canlı Parsel Sorgulama">
<i class="fa-solid fa-map-location-dot" aria-hidden="true"></i>
<span>Parsel</span>
</a>
<button type="button" onclick="toggleSaasMobileMenu()" class="saas-mob-link <?php echo $active_module === 'botlar' ? 'active' : ''; ?>" aria-label="20 Otonom Mühendislik Botu Menüsü" style="background:none; border:none; padding:0; cursor:pointer;">
<i class="fa-solid fa-cubes-stacked" aria-hidden="true"></i>
<span>20 Bot</span>
</button>
<a href="/arsa-insaat-maliyeti" class="saas-mob-link <?php echo $active_module === 'maliyet' ? 'active' : ''; ?>" aria-label="2026 İnşaat Maliyeti Hesaplama">
<i class="fa-solid fa-calculator" aria-hidden="true"></i>
<span>Maliyet</span>
</a>
<a href="/imar" class="saas-mob-link <?php echo $active_module === 'imar' ? 'active' : ''; ?>" aria-label="Belediye Askı İmar Planı İlanları">
<i class="fa-solid fa-bullhorn" aria-hidden="true"></i>
<span>Askı</span>
</a>
<a href="/rehber" class="saas-mob-link <?php echo in_array($active_module, ['imar-rehberi', 'makaleler']) ? 'active' : ''; ?>" aria-label="İmar ve Kadastro Mevzuatı Rehberi">
<i class="fa-solid fa-book-open" aria-hidden="true"></i>
<span>Rehber</span>
</a>
</nav>

<!-- SAAS 2026 CSS STİLLERİ -->
<link rel="stylesheet" href="/assets/css/navbar_core.css?v=2026.1">

<!-- SAAS 2026 JAVASCRIPT MEGA MENÜ & MOBİL KONTROLÜ -->
<script>
        document.addEventListener('DOMContentLoaded', function() {
            let menusLoaded = false;
            let menusLoadingPromise = null;

            function bindMegaEvents() {
                const megaBtn = document.getElementById('saasMegaBtn');
                const megaDropdown = document.getElementById('saasMegaDropdown');
                const maliyetBtn = document.getElementById('saasMaliyetBtn');
                const maliyetDropdown = document.getElementById('saasMaliyetDropdown');
                const maliyetCloseBtn = document.getElementById('saasMaliyetCloseBtn');
                const megaBackdrop = document.getElementById('saasMegaBackdrop');
                const megaCloseBtn = document.getElementById('saasMegaCloseBtn');
                const drawer = document.getElementById('saasMobileDrawer');
                const drawerOverlay = document.getElementById('saasDrawerOverlay');
                const drawerClose = document.getElementById('saasDrawerClose');

                window._closeAllSaasMenus = function() {
                    if (megaDropdown) megaDropdown.classList.remove('open');
                    if (maliyetDropdown) maliyetDropdown.classList.remove('open');
                    if (megaBackdrop) megaBackdrop.classList.remove('open');
                    if (megaBtn) { megaBtn.classList.remove('open'); megaBtn.setAttribute('aria-expanded', 'false'); }
                    if (maliyetBtn) { maliyetBtn.classList.remove('open'); maliyetBtn.setAttribute('aria-expanded', 'false'); }
                };
                window.closeSaasMegaMenu = window._closeAllSaasMenus;

                if (megaCloseBtn) megaCloseBtn.onclick = function(e) { e.preventDefault(); window._closeAllSaasMenus(); };
                if (maliyetCloseBtn) maliyetCloseBtn.onclick = function(e) { e.preventDefault(); window._closeAllSaasMenus(); };
                if (megaBackdrop) megaBackdrop.onclick = function() { window._closeAllSaasMenus(); };
                if (drawerClose) drawerClose.onclick = function(e) { e.preventDefault(); window.toggleSaasMobileMenu(); };
                if (drawerOverlay) drawerOverlay.onclick = function(e) { e.preventDefault(); window.toggleSaasMobileMenu(); };
            }

            function ensureMenusLoaded() {
                if (menusLoaded) return Promise.resolve();
                if (menusLoadingPromise) return menusLoadingPromise;
                menusLoadingPromise = fetch('/assets/nav_menus_v2.html?v=2026.1')
                    .then(r => r.text())
                    .then(html => {
                        const parts = html.split('<!--LAZY_SPLIT-->');
                        const hostHeader = document.getElementById('saasHeaderMegaHost');
                        const hostDrawer = document.getElementById('saasMobileDrawerHost');
                        if (hostHeader && parts[0]) hostHeader.innerHTML = parts[0];
                        if (hostDrawer && parts[1]) hostDrawer.innerHTML = parts[1];
                        menusLoaded = true;
                        bindMegaEvents();
                    }).catch(() => {});
                return menusLoadingPromise;
            }

            const megaBtn = document.getElementById('saasMegaBtn');
            const maliyetBtn = document.getElementById('saasMaliyetBtn');
            const hamburgerBtn = document.getElementById('saasHamburgerBtn');

            if (megaBtn) {
                megaBtn.addEventListener('mouseenter', ensureMenusLoaded, { once: true });
                megaBtn.addEventListener('click', function(e) {
                    e.preventDefault(); e.stopPropagation();
                    ensureMenusLoaded().then(() => {
                        const dd = document.getElementById('saasMegaDropdown');
                        const bd = document.getElementById('saasMegaBackdrop');
                        const wasOpen = dd && dd.classList.contains('open');
                        if (window._closeAllSaasMenus) window._closeAllSaasMenus();
                        if (!wasOpen && dd && bd) {
                            dd.classList.add('open'); bd.classList.add('open');
                            megaBtn.classList.add('open'); megaBtn.setAttribute('aria-expanded', 'true');
                        }
                    });
                });
            }

            if (maliyetBtn) {
                maliyetBtn.addEventListener('mouseenter', ensureMenusLoaded, { once: true });
                maliyetBtn.addEventListener('click', function(e) {
                    e.preventDefault(); e.stopPropagation();
                    ensureMenusLoaded().then(() => {
                        const dd = document.getElementById('saasMaliyetDropdown');
                        const bd = document.getElementById('saasMegaBackdrop');
                        const wasOpen = dd && dd.classList.contains('open');
                        if (window._closeAllSaasMenus) window._closeAllSaasMenus();
                        if (!wasOpen && dd && bd) {
                            dd.classList.add('open'); bd.classList.add('open');
                            maliyetBtn.classList.add('open'); maliyetBtn.setAttribute('aria-expanded', 'true');
                        }
                    });
                });
            }

            window.toggleSaasMobileMenu = function() {
                ensureMenusLoaded().then(() => {
                    const dr = document.getElementById('saasMobileDrawer');
                    const ov = document.getElementById('saasDrawerOverlay');
                    if (dr && ov) { dr.classList.toggle('open'); ov.classList.toggle('open'); }
                });
            };

            if (hamburgerBtn) {
                hamburgerBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    window.toggleSaasMobileMenu();
                });
            }

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    if (window._closeAllSaasMenus) window._closeAllSaasMenus();
                    const dr = document.getElementById('saasMobileDrawer');
                    const ov = document.getElementById('saasDrawerOverlay');
                    if (dr) dr.classList.remove('open');
                    if (ov) ov.classList.remove('open');
                }
            });

            // Prefetch silently after initial paint
            setTimeout(ensureMenusLoaded, 1500);
        });
    </script>
<!-- iLya AI Mühendis Widget Entegrasyonu -->
<script>
    (function(){
        var chatLoaded = false;
        function loadIlyaChat() {
            if (chatLoaded) return;
            chatLoaded = true;
            var c = document.createElement('script');
            c.src = '/ilya-chat.js?v=2026.3';
            c.defer = true;
            document.body.appendChild(c);
        }
        ['scroll', 'mousemove', 'touchstart', 'click'].forEach(function(e){
            window.addEventListener(e, loadIlyaChat, {passive: true, once: true});
        });
        setTimeout(loadIlyaChat, 3500);
        setTimeout(function(){ fetch('/cron_auto_publisher.php?key=AntHarita2026DeploySecretKey').catch(function(){}); }, 5000);
        // PWA Service Worker & Telefona Yukle Butonu
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('/sw.js').catch(function(){});
            });
        }
        var deferredPwaPrompt = null;
        window.addEventListener('beforeinstallprompt', function(e) {
            e.preventDefault();
            deferredPwaPrompt = e;
            try { if (localStorage.getItem('ps_pwa_dismissed')) return; } catch(ex) {}
            if (document.getElementById('ps-pwa-install-pill')) return;
            var pill = document.createElement('div');
            pill.id = 'ps-pwa-install-pill';
            pill.style.cssText = 'position:fixed;bottom:74px;left:16px;z-index:9998;display:flex;align-items:center;gap:8px;background:linear-gradient(135deg,#0284c7,#0f172a);border:1px solid rgba(56,189,248,0.45);color:#fff;padding:8px 14px;border-radius:9999px;box-shadow:0 8px 24px rgba(0,0,0,0.45);font-size:12px;font-weight:800;cursor:pointer;';
            pill.innerHTML = '<span>📱 Uygulamayı Telefona Kur</span><button type="button" id="ps-pwa-close" style="background:none;border:none;color:#cbd5e1;font-size:14px;cursor:pointer;padding:0 2px;margin-left:2px;">&times;</button>';
            pill.addEventListener('click', function(ev) {
                if (ev.target && ev.target.id === 'ps-pwa-close') {
                    pill.remove();
                    try { localStorage.setItem('ps_pwa_dismissed', '1'); } catch(ex) {}
                    return;
                }
                if (deferredPwaPrompt) {
                    deferredPwaPrompt.prompt();
                    deferredPwaPrompt.userChoice.then(function() {
                        deferredPwaPrompt = null;
                        pill.remove();
                    });
                }
            });
            document.body.appendChild(pill);
        });
    })();
</script>
<?php
}
