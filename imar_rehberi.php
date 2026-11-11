<?php
/**
 * ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ - PARSEL PRO
 * Flagship Knowledge Base: Türkiye İmar ve Kadastro Bilgi Rehberi (imar_rehberi.php)
 * Pure PHP 8.3 + Semantic SEO + Breadcrumb & ItemList Schema
 */

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/SeoManager.php';

$active_module = 'imar-rehberi';
require_once __DIR__ . '/navbar.php';

// Site Settings
$site_title = "İmar & Kadastro Bilgi Rehberi 2026 | ParselSorgu";
$site_desc = "Türkiye geneli ada parsel sorgulama, imar durumu, TAKS/KAKS emsal, 18. madde DOP, tarlaya ev yapma ve 2026 inşaat maliyeti rehberi.";
$canonical_url = "https://www.parselsorgu.net/rehber";

// The 30 Master Pillar Articles
$pillar_articles = [
    [
        'id' => 1,
        'pillar' => 'kadastro',
        'pillar_label' => 'Kadastro & Parsel',
        'law_ref' => '3402 Sayılı Kadastro Kanunu',
        'title' => 'Parsel Sorgulama Nasıl Yapılır? 2026 Adım Adım TKGM Rehberi',
        'slug' => 'parsel-sorgulama-nasil-yapilir',
        'summary' => 'TKGM parsel sorgu sistemi üzerinden il, ilçe, mahalle, ada ve parsel girerek alan, vasıf ve pafta bilgilerini harita üzerinde adım adım öğrenme kılavuzu.',
        'read_time' => '5 dk',
        'tool_link' => '/ada-parsel-harita',
        'tool_label' => 'Canlı Haritada Sorgula'
    ],
    [
        'id' => 2,
        'pillar' => 'kadastro',
        'pillar_label' => 'Kadastro & Parsel',
        'law_ref' => 'TKGM Parselasyon Mevzuatı',
        'title' => 'Ada Parsel Numarası Nasıl Öğrenilir? Tapusuz veya Konumdan Tespit',
        'slug' => 'ada-parsel-numarasi-nasil-ogrenilir',
        'summary' => 'Tapusu olmayan, sınırları bilinmeyen veya sadece arazide bulunan bir yerin GPS koordinatları ve TKGM uydu katmanı üzerinden ada ve parsel numarasını tespit etme yöntemleri.',
        'read_time' => '6 dk',
        'tool_link' => '/parsel-koordinat-sorgulama',
        'tool_label' => 'GPS / Koordinat Bulucu'
    ],
    [
        'id' => 3,
        'pillar' => 'imar',
        'pillar_label' => 'İmar & Emsal',
        'law_ref' => '3194 Sayılı İmar Kanunu Madde 8',
        'title' => 'İmar Durumu Nasıl Sorgulanır? 2026 E-İmar ve Belediye Rehberi',
        'slug' => 'imar-durumu-nasil-sorgulanir',
        'summary' => 'Belediyelerin e-imar portalları, imar çapı belgesi başvuru süreci, TAKS, KAKS, hmax (kat adedi) ve ön-yan çekme mesafelerinin resmî analizi.',
        'read_time' => '7 dk',
        'tool_link' => '/imar-durumu-sorgulama',
        'tool_label' => 'E-İmar Portalı'
    ],
    [
        'id' => 4,
        'pillar' => 'kadastro',
        'pillar_label' => 'Kadastro & Parsel',
        'law_ref' => 'Tapu ve Kadastro Bilgi Sistemi (TAKBİS)',
        'title' => 'TKGM Parsel Sorgu Nasıl Kullanılır? 2026 Resmî Kullanım Rehberi',
        'slug' => 'tkgm-parsel-sorgu-nasil-kullanilir',
        'summary' => 'Tapu ve Kadastro Genel Müdürlüğü (TKGM) resmî coğrafi bilgi sistemi arayüzünde filtreleme, uydu görünümü, KML/DXF dışa aktarma ve koordinat dönüşümü püf noktaları.',
        'read_time' => '6 dk',
        'tool_link' => '/tkgm-parsel-sorgulama',
        'tool_label' => 'TKGM Parsel Haritası'
    ],
    [
        'id' => 5,
        'pillar' => 'tarla',
        'pillar_label' => 'Tarla & Köy Evi',
        'law_ref' => 'Plansız Alanlar Tip İmar Yönetmeliği Madde 63',
        'title' => 'Tarlaya Ev Yapılır mı? 2026 Mevzuatı ve İzin Şartları',
        'slug' => 'tarlaya-ev-yapilir-mi',
        'summary' => 'Tarım arazilerinde bağ evi yapım şartları: 5000 m² asgari alan kuralı, %5 TAKS taban oturumu, maksimum 250 m² inşaat alanı ve kadastro yolu zorunluluğu.',
        'read_time' => '8 dk',
        'tool_link' => '/5403-tarla-ifraz',
        'tool_label' => 'Tarla Yapılaşma Botu'
    ],
    [
        'id' => 6,
        'pillar' => 'tarla',
        'pillar_label' => 'Tarla & Köy Evi',
        'law_ref' => 'Plansız Alanlar İmar Yönetmeliği',
        'title' => 'İmarsız Arsaya Ev Yapılır mı? 2026 Plansız Alanlar Rehberi',
        'slug' => 'imarsiz-arsaya-ev-yapilir-mi',
        'summary' => 'Uygulama imar planı (1/1000) bulunmayan kadastro parsellerinde yapı izni, İl Özel İdaresi ruhsat süreci ve imarsız arazilerde yasal konut inşası şartları.',
        'read_time' => '7 dk',
        'tool_link' => '/imar-durumu-sorgulama',
        'tool_label' => 'İmar Durumu İncele'
    ],
    [
        'id' => 7,
        'pillar' => 'imar',
        'pillar_label' => 'İmar & Emsal',
        'law_ref' => 'Planlı Alanlar İmar Yönetmeliği Madde 5',
        'title' => 'TAKS ve KAKS Nedir? Taban Alanı ve Emsal Katsayısı Nasıl Hesaplanır?',
        'slug' => 'taks-ve-kaks-nedir',
        'summary' => 'Taban Alanı Kat Sayısı (TAKS) ve Kat Alanı Kat Sayısı (KAKS / Emsal) kavramlarının mühendislik açıklaması, arsa inşaat alanı hesabı ve formüller.',
        'read_time' => '6 dk',
        'tool_link' => '/taks-kaks-hesaplama',
        'tool_label' => 'TAKS / KAKS Hesaplayıcı'
    ],
    [
        'id' => 8,
        'pillar' => 'imar',
        'pillar_label' => 'İmar & Emsal',
        'law_ref' => '3194 Sayılı Kanun & ÇŞİDB Tebliğleri',
        'title' => 'Emsal Hesabı Nasıl Yapılır? 2026 İnşaat Alanı ve Kat Hesabı Formülü',
        'slug' => 'emsal-hesabi-nasil-yapilir',
        'summary' => 'Net parsel alanı üzerinden toplam emsale dahil kapalı inşaat alanı, balkon ve bodrum muafiyetleri ve bağımsız bölüm sayısı hesaplama rehberi.',
        'read_time' => '7 dk',
        'tool_link' => '/arsa-insaat-maliyeti',
        'tool_label' => 'Maliyet & Metraj Hesapla'
    ],
    [
        'id' => 9,
        'pillar' => 'yatirim',
        'pillar_label' => 'Yatırım & Değerleme',
        'law_ref' => 'Planlı Alanlar Tip İmar Esasları',
        'title' => '1000 m² Arsaya Kaç Daire Yapılır? Kat Karşılığı ve Daire Sayısı Hesabı',
        'slug' => '1000-m2-arsaya-kac-daire-yapilir',
        'summary' => '1000 metrekare büyüklüğündeki bir arsada emsal oranına (0.80, 1.20, 1.50, 2.00) göre brüt metraj, kat adedi, daire büyüklükleri ve arsa payı simülasyonu.',
        'read_time' => '8 dk',
        'tool_link' => '/bot/kat-karsiligi-oran',
        'tool_label' => 'Kat Karşılığı Simülasyonu'
    ],
    [
        'id' => 10,
        'pillar' => 'tarla',
        'pillar_label' => 'Tarla & Köy Evi',
        'law_ref' => 'Plansız Alanlar İmar Yönetmeliği Madde 63',
        'title' => '5000 m² Tarlaya Ev Yapılır mı? 2026 Bağ Evi İmar Şartları',
        'slug' => '5000-m2-tarlaya-ev-yapilir-mi',
        'summary' => '5 dönüm tarla üzerine yasal çiftlik ve bağ evi yapımı: İl Tarım ve Orman Müdürlüğü uygunluk yazısı, kadastro cephesi (en az 25 metre) ve yapı ruhsatı adımları.',
        'read_time' => '7 dk',
        'tool_link' => '/5403-tarla-ifraz',
        'tool_label' => 'Tarla Analiz Botu'
    ],
    [
        'id' => 11,
        'pillar' => 'hukuk',
        'pillar_label' => 'İmar Hukuku & Mülkiyet',
        'law_ref' => '4721 Sayılı Türk Medeni Kanunu',
        'title' => 'Hisseli Tapu Nasıl Bölünür? 2026 Rızai Taksim ve İfraz Rehberi',
        'slug' => 'hisseli-tapu-nasil-bolunur',
        'summary' => 'Müşterek veya iştirak halinde mülkiyete tabi gayrimenkullerde rızai taksim sözleşmesi, hissedarlar arası anlaşma, izale-i şüyu davası ve ifraz koşulları.',
        'read_time' => '8 dk',
        'tool_link' => '/ada-parsel-harita',
        'tool_label' => 'Hisseli Parseli İncele'
    ],
    [
        'id' => 12,
        'pillar' => 'kadastro',
        'pillar_label' => 'Kadastro & Parsel',
        'law_ref' => '3194 Sayılı İmar Kanunu Madde 15 ve 16',
        'title' => 'İfraz Nedir? Parsel Ayırma Şartları, Süreci ve 2026 Masrafları',
        'slug' => 'ifraz-nedir',
        'summary' => 'Bir parselin birden fazla bağımsız parsele bölünmesi (ayırma) işlemi: Belediye Encümeni veya İl Encümeni onayı, LİHKAB tescil beyannamesi ve kadastro tescili.',
        'read_time' => '7 dk',
        'tool_link' => '/5403-tarla-ifraz',
        'tool_label' => 'İfraz Şartları Hesapla'
    ],
    [
        'id' => 13,
        'pillar' => 'kadastro',
        'pillar_label' => 'Kadastro & Parsel',
        'law_ref' => '3194 Sayılı İmar Kanunu Madde 15 ve 16',
        'title' => 'Tevhid Nedir? Parsel Birleştirme Şartları ve Emsal Avantajı',
        'slug' => 'tevhid-nedir',
        'summary' => 'Birbirine komşu iki veya daha fazla parselin tek bir tapu kütüğü sayfasında birleştirilmesi, ada bazında tevhid teşvikleri ve inşaat emsal artışı kazanımları.',
        'read_time' => '6 dk',
        'tool_link' => '/imar-rehberi/tevhid-nedir',
        'tool_label' => 'Tevhid Analiz Botu'
    ],
    [
        'id' => 14,
        'pillar' => 'hukuk',
        'pillar_label' => 'İmar Hukuku & Mülkiyet',
        'law_ref' => '3194 Sayılı İmar Kanunu Madde 18',
        'title' => 'DOP Kesintisi Nedir? 2026 Azami Oran ve İmar Terkleri Hesabı',
        'slug' => 'dop-kesintisi-nedir',
        'summary' => 'Düzenleme Ortaklık Payı (DOP): İmar parselasyonunda kamusal alanlar (yol, yeşil alan, okul) için alınan kesinti, yasal tavan olan %45 sınırı ve Danıştay emsal kararları.',
        'read_time' => '7 dk',
        'tool_link' => '/imar-rehberi/dop-kesintisi',
        'tool_label' => 'DOP Kesintisi Botu'
    ],
    [
        'id' => 15,
        'pillar' => 'hukuk',
        'pillar_label' => 'İmar Hukuku & Mülkiyet',
        'law_ref' => '3194 Sayılı Kanun Madde 18 Uygulama Yönetmeliği',
        'title' => '18. Madde Uygulaması Nedir? İmar Parselasyonu ve Askı İlanı Süreci',
        'slug' => '18-madde-uygulamasi-nedir',
        'summary' => 'Ham kadastro arazilerinin modern yapı adalarına dönüştürülmesi süreci, parselasyon planlarının hazırlanması, 1 aylık askı süresi ve itiraz mekanizması.',
        'read_time' => '9 dk',
        'tool_link' => '/imar-aski-ilanlari',
        'tool_label' => 'İmar Askı İlanlarını Gör'
    ],
    [
        'id' => 16,
        'pillar' => 'tarla',
        'pillar_label' => 'Tarla & Köy Evi',
        'law_ref' => 'Türk Medeni Kanunu Madde 747 & İmar Mevzuatı',
        'title' => 'Kadastro Yolu Olmayan Tarlaya Ev Yapılır mı? Geçit Hakkı ve İmar Yolu Şartı',
        'slug' => 'kadastro-yolu-olmayan-tarlaya-ev-yapilir-mi',
        'summary' => 'Kadastro paftasında resmî yolu bulunmayan arazilerde yapılaşma yasağı, geçit hakkı davası, fiili yol ile kadastro yolu farkı ve ruhsat alma engelleri.',
        'read_time' => '6 dk',
        'tool_link' => '/ada-parsel-harita',
        'tool_label' => 'Kadastro Yolunu Kontrol Et'
    ],
    [
        'id' => 17,
        'pillar' => 'yatirim',
        'pillar_label' => 'Yatırım & Değerleme',
        'law_ref' => 'Gayrimenkul Değerleme & Kadastro Hukuku',
        'title' => 'Arsa Alırken Nelere Dikkat Edilmeli? 2026 Hayati Kontrol Listesi',
        'slug' => 'arsa-alirken-nelere-dikkat-edilmeli',
        'summary' => 'Arsa ve arazi yatırımı öncesinde incelenmesi gereken 10 altın kural: Tapu şerhleri, haciz/ipotek, sit alanı durumu, zemin yapısı, enerji nakil hatları ve taşkın riski.',
        'read_time' => '8 dk',
        'tool_link' => '/ada-parsel-harita',
        'tool_label' => 'Parsel Risk Analizi'
    ],
    [
        'id' => 18,
        'pillar' => 'imar',
        'pillar_label' => 'İmar & Emsal',
        'law_ref' => 'Mekânsal Planlar Yapım Yönetmeliği',
        'title' => 'İmar Planı Nasıl Okunur? Lejant Renkleri, Plan Notları ve Ölçekler',
        'slug' => 'imar-plani-nasil-okunur',
        'summary' => '1/1000 Uygulama ve 1/5000 Nazım imar planlarında kullanılan standart renk kodları (kahverengi konut, kırmızı ticaret vb.), plan notları ve yapı nizamı işaretleri.',
        'read_time' => '7 dk',
        'tool_link' => '/imar-durumu-sorgulama',
        'tool_label' => 'Plan Notları Sorgula'
    ],
    [
        'id' => 19,
        'pillar' => 'kadastro',
        'pillar_label' => 'Kadastro & Parsel',
        'law_ref' => 'BÖHHBÜY (Büyük Ölçekli Harita Yönetmeliği)',
        'title' => 'Parsel Koordinatı Nasıl Bulunur? ITRF95 Metrik ve GPS Dönüşümü',
        'slug' => 'parsel-koordinati-nasil-bulunur',
        'summary' => 'Köşe koordinatlarının ITRF95, ED50 ve WGS84 coğrafi sistemleri arasında dönüşümü, el GPS cihazı veya cep telefonu ile sahada köşe kazığı bulma teknikleri.',
        'read_time' => '6 dk',
        'tool_link' => '/parsel-koordinat-sorgulama',
        'tool_label' => 'Koordinat Dönüştürücü'
    ],
    [
        'id' => 20,
        'pillar' => 'kadastro',
        'pillar_label' => 'Kadastro & Parsel',
        'law_ref' => 'Kadastro Ölçü ve Hesaplama Esasları',
        'title' => 'Parsel Alanı Nasıl Hesaplanır? Gauss Alan Formülü ve Kadastro Tecviz Payı',
        'slug' => 'parsel-alani-nasil-hesaplanir',
        'summary' => 'Çokgen köşe koordinatları üzerinden Gauss alan formülü ile net metrekare hesabı, tapu alanı ile harita alanı arasındaki yasal yanılma (tecviz) payı toleransı.',
        'read_time' => '7 dk',
        'tool_link' => '/ada-parsel-harita',
        'tool_label' => 'Haritada Alanı Ölç'
    ],
    [
        'id' => 21,
        'pillar' => 'tarla',
        'pillar_label' => 'Tarla & Köy Evi',
        'law_ref' => 'Plansız Alanlar İmar Yönetmeliği Madde 43-56',
        'title' => 'Köy Yerleşik Alanı Nedir? 2026 Köy İçi İmar ve Yapılaşma Kuralları',
        'slug' => 'koy-yerlesik-alani-nedir',
        'summary' => 'Köy ve mezraların yerleşik alan sınırı (köy içi), muhtarlık yapı izni koşulları, 2 kat veya hmax=6.50m yapılaşma hakkı ve parsel minimum büyüklükleri.',
        'read_time' => '6 dk',
        'tool_link' => '/imar-durumu-sorgulama',
        'tool_label' => 'Köy İmar Durumu'
    ],
    [
        'id' => 22,
        'pillar' => 'tarla',
        'pillar_label' => 'Tarla & Köy Evi',
        'law_ref' => 'Karayolları Trafik Kanunu & 3194 Sayılı İmar Kanunu',
        'title' => 'Tiny House İçin İmar İzni Gerekir mi? 2026 Yasal Mevzuat ve Ceza Riskleri',
        'slug' => 'tiny-house-icin-imar-izni-gerekir-mi',
        'summary' => 'Tekerlekli mobil evlerde O2 tip onay belgesi ve plaka şartı, sabit beton su basmanı veya platform yapılması durumunda kaçak yapı cezası ve yıkım kararı riskleri.',
        'read_time' => '7 dk',
        'tool_link' => '/ada-parsel-harita',
        'tool_label' => 'Arazini Haritada İncele'
    ],
    [
        'id' => 23,
        'pillar' => 'tarla',
        'pillar_label' => 'Tarla & Köy Evi',
        'law_ref' => '3573 Sayılı Zeytinciliğin Islahı ve Yabanilerinin Aşılattırılması Hakkında Kanun',
        'title' => 'Zeytinlik Alırken Nelere Dikkat Edilmeli? 3573 Sayılı Kanun Kısıtları',
        'slug' => 'zeytinlik-alirken-nelere-dikkat-edilmeli',
        'summary' => 'Zeytinlik vasıflı arazilerde mutlak yapılaşma yasağı, en az 25 dekarlık (25.000 m²) zeytinlik şartı, zeytinyağı fabrikası veya tarımsal tesis istisnaları.',
        'read_time' => '7 dk',
        'tool_link' => '/ada-parsel-harita',
        'tool_label' => 'Zeytinlik Vasıf Analizi'
    ],
    [
        'id' => 24,
        'pillar' => 'tarla',
        'pillar_label' => 'Tarla & Köy Evi',
        'law_ref' => '5403 Sayılı Toprak Koruma ve Arazi Kullanımı Kanunu',
        'title' => 'Tarla Bölünme Şartları Nelerdir? 5403 Sayılı Kanun Asgari Parsel Sınırları',
        'slug' => 'tarla-bolunme-sartlari-nelerdir',
        'summary' => 'Mutlak tarım arazilerinde 20.000 m², dikili tarım arazilerinde 5.000 m², örtü altı seralarda 3.000 m² ve kuru marjinal tarım arazilerinde bölünemez asgari parsel büyüklükleri.',
        'read_time' => '8 dk',
        'tool_link' => '/5403-tarla-ifraz',
        'tool_label' => 'Tarla Bölünme Botu'
    ],
    [
        'id' => 25,
        'pillar' => 'yatirim',
        'pillar_label' => 'Yatırım & Değerleme',
        'law_ref' => 'Borçlar Kanunu Arsa Payı Karşılığı İnşaat Sözleşmesi',
        'title' => 'Arsa Kat Karşılığı Nasıl Hesaplanır? Arsa Sahibi ve Müteahhit Paylaşımı',
        'slug' => 'arsa-kat-karsiligi-nasil-hesaplanir',
        'summary' => 'Lokasyon, emsal ve daire metrekare satış fiyatlarına göre %40 / %60 veya %50 / %50 kat karşılığı paylaşım formülü ve arsa sahibinin net daire kazanımı hesabı.',
        'read_time' => '8 dk',
        'tool_link' => '/bot/kat-karsiligi-oran',
        'tool_label' => 'Kat Karşılığı Hesaplayıcı'
    ],
    [
        'id' => 26,
        'pillar' => 'hukuk',
        'pillar_label' => 'İmar Hukuku & Mülkiyet',
        'law_ref' => '492 Sayılı Harçlar Kanunu (4 Sayılı Tarife)',
        'title' => 'Tapu Harcı Nasıl Hesaplanır? 2026 Alıcı ve Satıcı Oranları ve Döner Sermaye',
        'slug' => 'tapu-harci-nasil-hesaplanir',
        'summary' => 'Gayrimenkul alım satımında beyan edilen gerçek bedel üzerinden %2 alıcı + %2 satıcı (toplam %4) tapu devir harcı ve 2026 yılı TKGM döner sermaye bedeli cetveli.',
        'read_time' => '5 dk',
        'tool_link' => '/bot/tapu-harci-hesaplama',
        'tool_label' => 'Tapu Harcı Hesapla'
    ],
    [
        'id' => 27,
        'pillar' => 'hukuk',
        'pillar_label' => 'İmar Hukuku & Mülkiyet',
        'law_ref' => '3194 Sayılı İmar Kanunu Madde 8 & Madde 19',
        'title' => 'İmar Askı İlanı Nedir? 30 Günlük Yasal İtiraz ve İptal Süreci',
        'slug' => 'imar-aski-ilani-nedir',
        'summary' => 'Belediye veya ÇŞİDB tarafından onaylanan 1/1000 uygulama imar planı ve 18. madde parselasyon planlarının muhtarlık ve internette 1 ay süreyle askıya çıkarılması.',
        'read_time' => '7 dk',
        'tool_link' => '/imar-aski-ilanlari',
        'tool_label' => 'Güncel Askı İlanları'
    ],
    [
        'id' => 28,
        'pillar' => 'imar',
        'pillar_label' => 'İmar & Emsal',
        'law_ref' => 'Planlı Alanlar İmar Yönetmeliği',
        'title' => 'Arsa Üzerindeki Yapılaşma Hakkı Nasıl Öğrenilir? E-İmar ve İmar Çapı',
        'slug' => 'arsa-uzerindeki-yapilasma-hakki-nasil-ogrenilir',
        'summary' => 'İlgili ilçe belediyesi imar ve şehircilik müdürlüğünden imar çapı alma süreci, mimari avan proje hazırlığı ve arsaya yapılacak maksimum inşaat hakkı tespiti.',
        'read_time' => '6 dk',
        'tool_link' => '/imar-durumu-sorgulama',
        'tool_label' => 'Yapılaşma Hakkını Gör'
    ],
    [
        'id' => 29,
        'pillar' => 'kadastro',
        'pillar_label' => 'Kadastro & Parsel',
        'law_ref' => '5368 Sayılı Lisanslı Harita Kadastro Mühendisleri Kanunu',
        'title' => 'Parsel Sınırı Nasıl Tespit Edilir? LİHKAB Aplikasyon ve Kazık Çakımı',
        'slug' => 'parsel-siniri-nasil-tespit-edilir',
        'summary' => 'Arsa ve tarlalarda sınır ihtilaflarını çözmek için Lisanslı Harita Kadastro Mühendislik Büroları (LİHKAB) tarafından yapılan aplikasyon krokisi ve sınır kazığı işlemi.',
        'read_time' => '6 dk',
        'tool_link' => '/ada-parsel-harita',
        'tool_label' => 'Haritada Sınırları İncele'
    ],
    [
        'id' => 30,
        'pillar' => 'yatirim',
        'pillar_label' => 'Yatırım & Değerleme',
        'law_ref' => 'Gayrimenkul Geliştirme ve İmar Hukuku',
        'title' => 'Arsa Yatırımında İmar Durumu Neden Önemlidir? Değer Artışı ve Riskler',
        'slug' => 'arsa-yatiriminda-imar-durumu-neden-onemlidir',
        'summary' => 'Ham araziden imarlı arsaya geçişte oluşan prim potansiyeli, kamulaştırma şerhi bulunan veya yeşil alanda kalan arazilerin taşıdığı yüksek sermaye riskleri.',
        'read_time' => '8 dk',
        'tool_link' => '/ada-parsel-harita',
        'tool_label' => 'Parsel Değerleme Analizi'
    ]
];
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title><?php echo htmlspecialchars($site_title); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($site_desc); ?>">
    <link rel="canonical" href="<?php echo htmlspecialchars($canonical_url); ?>    <meta property="og:image" content="https://www.parselsorgu.net/assets/images/og-parsel.jpg">
" />
    <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1" />
    <meta name="author" content="Ant Harita Mühendislik" />

    <!-- Open Graph (OG) -->
    <meta property="og:type" content="website" />
    <meta property="og:title" content="<?php echo htmlspecialchars($site_title); ?>" />
    <meta property="og:description" content="<?php echo htmlspecialchars($site_desc); ?>" />
    <meta property="og:url" content="<?php echo htmlspecialchars($canonical_url); ?>" />
    <meta property="og:site_name" content="ParselSorgu.net" />

    <!-- Schema.org BreadcrumbList & CollectionPage Structured Data -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "CollectionPage",
      "name": "Türkiye İmar ve Kadastro Bilgi Rehberi (2026)",
      "description": "<?php echo htmlspecialchars($site_desc); ?>",
      "url": "<?php echo htmlspecialchars($canonical_url); ?>",
      "mainEntity": {
        "@type": "ItemList",
        "numberOfItems": <?php echo count($pillar_articles); ?>,
        "itemListElement": [
          <?php foreach ($pillar_articles as $idx => $art): ?>
          {
            "@type": "ListItem",
            "position": <?php echo $idx + 1; ?>,
            "name": <?php echo json_encode($art['title']); ?>,
            "url": "https://www.parselsorgu.net/makale/<?php echo $art['slug']; ?>"
          }<?php echo ($idx < count($pillar_articles) - 1) ? ',' : ''; ?>
          <?php endforeach; ?>
        ]
      }
    }
    </script>
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "BreadcrumbList",
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
          "name": "İmar Rehberi",
          "item": "https://www.parselsorgu.net/imar-rehberi"
        }
      ]
    }
    </script>

    <!-- Tailwind / Modern CSS Styling -->
    <style>
        :root {
            --bg-dark: #090d16;
            --card-dark: #0f172a;
            --card-border: #1e293b;
            --primary-accent: #0284c7;
            --primary-hover: #0369a1;
            --gold-accent: #f59e0b;
            --emerald-accent: #10b981;
            --purple-accent: #8b5cf6;
        }

        body {
            background-color: var(--bg-dark);
            color: #f1f5f9;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            margin: 0;
            padding: 0;
            line-height: 1.6;
        }

        .hub-container {
            max-width: 1300px;
            margin: 0 auto;
            padding: 24px 16px 80px 16px;
        }

        /* Hero Section */
        .hub-hero {
            text-align: center;
            padding: 40px 16px 36px 16px;
            background: radial-gradient(circle at 50% 10%, rgba(2, 132, 199, 0.18) 0%, rgba(15, 23, 42, 0) 70%);
            border-bottom: 1px solid var(--card-border);
            margin-bottom: 32px;
        }

        .hub-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 9999px;
            background: rgba(2, 132, 199, 0.15);
            border: 1px solid rgba(56, 189, 248, 0.3);
            color: #38bdf8;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            margin-bottom: 16px;
        }

        .hub-title {
            font-size: 2.3rem;
            font-weight: 900;
            color: #ffffff;
            margin: 0 0 14px 0;
            line-height: 1.25;
            letter-spacing: -0.5px;
        }

        @media (min-width: 768px) {
            .hub-title {
                font-size: 2.85rem;
            }
        }

        .hub-subtitle {
            max-width: 820px;
            margin: 0 auto 28px auto;
            color: #94a3b8;
            font-size: 15.5px;
            line-height: 1.65;
        }

        /* Search & Live Filter Bar */
        .search-box-wrapper {
            max-width: 680px;
            margin: 0 auto;
            position: relative;
        }

        .search-box-input {
            width: 100%;
            padding: 15px 20px 15px 48px;
            font-size: 15px;
            background: #111827;
            border: 1.5px solid #334155;
            border-radius: 14px;
            color: #ffffff;
            outline: none;
            box-shadow: 0 4px 20px rgba(0,0,0,0.3);
            transition: all 0.2s ease;
            box-sizing: border-box;
        }

        .search-box-input:focus {
            border-color: #0284c7;
            box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.25);
            background: #0b1120;
        }

        .search-icon {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
            font-size: 18px;
        }

        /* 4 Core Gateways (Pillar Action Cards) */
        .pillar-gateways {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 16px;
            margin-bottom: 40px;
        }

        .gateway-card {
            background: linear-gradient(135deg, rgba(30, 41, 59, 0.7) 0%, rgba(15, 23, 42, 0.9) 100%);
            border: 1px solid var(--card-border);
            border-radius: 14px;
            padding: 20px;
            transition: all 0.25s ease;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .gateway-card:hover {
            transform: translateY(-3px);
            border-color: rgba(56, 189, 248, 0.4);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4);
        }

        .gateway-icon {
            font-size: 26px;
            margin-bottom: 12px;
        }

        .gateway-title {
            font-size: 16px;
            font-weight: 800;
            color: #f8fafc;
            margin: 0 0 6px 0;
        }

        .gateway-desc {
            font-size: 13px;
            color: #94a3b8;
            margin: 0 0 14px 0;
            line-height: 1.5;
        }

        .gateway-link {
            font-size: 13px;
            font-weight: 700;
            color: #38bdf8;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .gateway-link:hover {
            text-decoration: underline;
        }

        /* Filter Tabs */
        .filter-tabs {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: center;
            margin-bottom: 30px;
        }

        .filter-btn {
            background: #1e293b;
            border: 1px solid #334155;
            color: #cbd5e1;
            padding: 9px 18px;
            border-radius: 9999px;
            font-size: 13.5px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .filter-btn:hover {
            background: #334155;
            color: #fff;
        }

        .filter-btn.active {
            background: #0284c7;
            border-color: #38bdf8;
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(2, 132, 199, 0.35);
        }

        /* Articles Grid */
        .articles-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 20px;
        }

        .article-card {
            background: #0f172a;
            border: 1px solid #1e293b;
            border-radius: 14px;
            padding: 22px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: all 0.25s ease;
            position: relative;
            overflow: hidden;
        }

        .article-card:hover {
            border-color: #38bdf8;
            transform: translateY(-4px);
            box-shadow: 0 12px 30px rgba(0,0,0,0.45);
        }

        .card-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 12px;
        }

        .pill-badge {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            padding: 3px 9px;
            border-radius: 6px;
            letter-spacing: 0.3px;
        }

        .pill-kadastro { background: rgba(56, 189, 248, 0.15); color: #38bdf8; border: 1px solid rgba(56, 189, 248, 0.3); }
        .pill-imar { background: rgba(245, 158, 11, 0.15); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.3); }
        .pill-tarla { background: rgba(16, 185, 129, 0.15); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.3); }
        .pill-hukuk { background: rgba(168, 85, 247, 0.15); color: #c084fc; border: 1px solid rgba(168, 85, 247, 0.3); }
        .pill-yatirim { background: rgba(236, 72, 153, 0.15); color: #f472b6; border: 1px solid rgba(236, 72, 153, 0.3); }

        .law-ref-badge {
            font-size: 11px;
            color: #94a3b8;
            background: #1e293b;
            padding: 3px 8px;
            border-radius: 5px;
            font-family: monospace;
            max-width: 60%;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .card-title {
            font-size: 17px;
            font-weight: 700;
            color: #ffffff;
            margin: 0 0 10px 0;
            line-height: 1.4;
        }

        .card-title a {
            color: #ffffff;
            text-decoration: none;
            transition: color 0.15s;
        }

        .card-title a:hover {
            color: #38bdf8;
        }

        .card-summary {
            font-size: 13.5px;
            color: #94a3b8;
            line-height: 1.55;
            margin: 0 0 16px 0;
            flex-grow: 1;
        }

        .card-footer {
            border-top: 1px solid #1e293b;
            padding-top: 14px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .author-stamp {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 11.5px;
            color: #10b981;
            font-weight: 600;
        }

        .author-stamp i {
            color: #10b981;
        }

        .btn-read {
            background: #0284c7;
            color: #ffffff;
            font-size: 12.5px;
            font-weight: 700;
            padding: 6px 14px;
            border-radius: 8px;
            text-decoration: none;
            transition: background 0.15s ease;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .btn-read:hover {
            background: #0369a1;
        }

        /* Tools Callout Banner */
        .hub-cta-banner {
            background: linear-gradient(135deg, rgba(2, 132, 199, 0.15) 0%, rgba(15, 23, 42, 0.8) 100%);
            border: 1px solid rgba(56, 189, 248, 0.3);
            border-radius: 16px;
            padding: 32px 24px;
            margin: 50px 0 35px 0;
            text-align: center;
        }

        .hub-cta-title {
            font-size: 22px;
            font-weight: 800;
            color: #ffffff;
            margin: 0 0 8px 0;
        }

        .hub-cta-desc {
            font-size: 14.5px;
            color: #94a3b8;
            max-width: 700px;
            margin: 0 auto 20px auto;
        }

        .hub-cta-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            justify-content: center;
        }

        .btn-cta-tool {
            background: #1e293b;
            border: 1px solid #334155;
            color: #f8fafc;
            font-size: 13.5px;
            font-weight: 700;
            padding: 10px 18px;
            border-radius: 10px;
            text-decoration: none;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-cta-tool:hover {
            background: #0284c7;
            border-color: #38bdf8;
            color: #fff;
            transform: translateY(-2px);
        }

        /* Disclaimer Section */
        .hub-disclaimer {
            background: #0b1120;
            border: 1px solid #1e293b;
            border-radius: 12px;
            padding: 20px;
            font-size: 12.5px;
            color: #64748b;
            line-height: 1.6;
            margin-top: 40px;
        }

        .hub-disclaimer strong {
            color: #94a3b8;
        }

        /* No Results Box */
        #noResults {
            display: none;
            text-align: center;
            padding: 40px 20px;
            background: #0f172a;
            border: 1px dashed #334155;
            border-radius: 14px;
            color: #94a3b8;
            grid-column: 1 / -1;
        }
    </style>
<?php echo SeoManager::renderBreadcrumbJson(['Ana Sayfa' => 'https://www.parselsorgu.net/', 'İmar ve Parsel Rehberi' => 'https://www.parselsorgu.net/rehber']); ?>
    <script type="application/ld+json">{"@context": "https://schema.org", "@type": "FAQPage", "mainEntity": [{"@type": "Question", "name": "İmar durumu belgesi ve imar çapı nereden alınır?", "acceptedAnswer": {"@type": "Answer", "text": "Taşınmazın bağlı bulunduğu ilçe belediyesi İmar ve Şehircilik Müdürlüğü'nden (veya büyükşehir/il özel idaresinden) parsel maliki ya da vekili tarafından resmi başvuru ile alınır."}}, {"@type": "Question", "name": "TAKS, KAKS (Emsal) ve Hmax değerleri ne anlama gelir?", "acceptedAnswer": {"@type": "Answer", "text": "TAKS taban alanı katsayısını, KAKS tüm katların toplam inşaat alanı katsayısını, Hmax ise yapının ulaşabileceği azami saçak/bina yüksekliğini ifade eder."}}]}</script>
    <link rel="alternate" type="text/markdown" href="https://www.parselsorgu.net/llms.txt" title="ParselSorgu AI / LLM Bilgi Bankası">
    <link rel="alternate" type="application/json" href="https://www.parselsorgu.net/api/2026-kadastro-endeks.json" title="2026 Kadastro ve İmar Açık Veri Seti">
    <script type="application/ld+json">{"@context": "https://schema.org", "@type": "WebPage", "speakable": {"@type": "SpeakableSpecification", "cssSelector": ["h1", ".lead", ".summary-box", ".hero-desc", "main p"]}, "isBasedOn": "https://www.parselsorgu.net/api/2026-kadastro-endeks.json", "publisher": {"@type": "Organization", "name": "Ant Harita Mühendislik - ParselSorgu.net", "url": "https://www.parselsorgu.net/"}}</script>
</head>
<body>

<div class="hub-container">

    <!-- Breadcrumb Bar -->
    <nav style="font-size: 12.5px; color: #64748b; margin-bottom: 20px;" aria-label="Breadcrumb">
        <a href="/" style="color: #94a3b8; text-decoration: none;">Ana Sayfa</a>
        <span style="margin: 0 6px;">/</span>
        <span style="color: #38bdf8; font-weight: 600;">İmar Rehberi &amp; Kadastro Kütüphanesi</span>
    </nav>

    <!-- Hero Header -->
    <header class="hub-hero">
        <div class="hub-badge">
            <i class="fa-solid fa-scale-balanced"></i> RESMÎ MEVZUAT &amp; MÜHENDİSLİK KÜTÜPHANESİ 2026
        </div>
        <h1 class="hub-title">Türkiye İmar ve Kadastro Bilgi Rehberi</h1>
        <p class="hub-subtitle">
            3194 Sayılı İmar Kanunu, Plansız Alanlar Tip İmar Yönetmeliği, Kadastro Kanunu ve güncel belediye uygulamalarına dair harita mühendisi onaylı teknik rehberler, emsal ve maliyet formülleri.
        </p>

        <!-- Search Input with Instant Javascript Filtering -->
        <div class="search-box-wrapper">
            <span class="search-icon"><i class="fa-solid fa-magnifying-glass"></i></span>
            <input type="text" id="articleSearch" class="search-box-input" placeholder="Konu, kanun maddesi veya anahtar kelime arayın... (Örn: DOP kesintisi, 5000 m2 tarla, TAKS KAKS)">
        </div>
    </header>

    <!-- 4 Core SEO Pillar Gateways (User Section 4 Architecture) -->
    <section class="pillar-gateways">
        <div class="gateway-card">
            <div>
                <div class="gateway-icon">📐</div>
                <h3 class="gateway-title">A. Parsel Sorgulama Merkezi</h3>
                <p class="gateway-desc">Ada parsel, GPS koordinatları, kadastro paftası ve sınır aplikasyon rehberleri.</p>
            </div>
            <a href="/tkgm-canli-parsel" class="gateway-link">Haritada Sorgula <i class="fa-solid fa-arrow-right"></i></a>
        </div>

        <div class="gateway-card">
            <div>
                <div class="gateway-icon">🏗️</div>
                <h3 class="gateway-title">B. İmar &amp; Mevzuat Merkezi</h3>
                <p class="gateway-desc">TAKS/KAKS emsal hesabı, imar çapı, yapılaşma hakkı ve 1/1000 uygulama planları.</p>
            </div>
            <a href="/imar-durumu" class="gateway-link">E-İmar Portalı <i class="fa-solid fa-arrow-right"></i></a>
        </div>

        <div class="gateway-card">
            <div>
                <div class="gateway-icon">💰</div>
                <h3 class="gateway-title">C. Gayrimenkul Hesaplama</h3>
                <p class="gateway-desc">2026 ÇŞİDB birim inşaat maliyeti, kat karşılığı paylaşım ve tapu harcı motoru.</p>
            </div>
            <a href="/arsa-insaat-maliyeti" class="gateway-link">Maliyet Hesapla <i class="fa-solid fa-arrow-right"></i></a>
        </div>

        <div class="gateway-card">
            <div>
                <div class="gateway-icon">🏛️</div>
                <h3 class="gateway-title">D. İmar Askı ve Haberleri</h3>
                <p class="gateway-desc">81 il ve ilçe belediyelerinin güncel parselasyon planları, 18. madde askı ilanları.</p>
            </div>
            <a href="/imar-aski" class="gateway-link">Askı İlanlarını Gör <i class="fa-solid fa-arrow-right"></i></a>
        </div>
    </section>

    <!-- Filter Buttons -->
    <div class="filter-tabs">
        <button class="filter-btn active" data-filter="all">
            <i class="fa-solid fa-layer-group"></i> Tüm Rehberler (30)
        </button>
        <button class="filter-btn" data-filter="kadastro">
            <i class="fa-solid fa-map-location-dot"></i> Kadastro &amp; Parsel (7)
        </button>
        <button class="filter-btn" data-filter="imar">
            <i class="fa-solid fa-city"></i> İmar &amp; Emsal (5)
        </button>
        <button class="filter-btn" data-filter="tarla">
            <i class="fa-solid fa-seedling"></i> Tarla, Köy Evi &amp; Tiny House (8)
        </button>
        <button class="filter-btn" data-filter="hukuk">
            <i class="fa-solid fa-gavel"></i> İmar Hukuku &amp; DOP (5)
        </button>
        <button class="filter-btn" data-filter="yatirim">
            <i class="fa-solid fa-chart-line"></i> Yatırım &amp; Değerleme (5)
        </button>
    </div>

    <!-- Articles Grid (30 Master Articles) -->
    <div class="articles-grid" id="articlesGrid">
        <?php foreach ($pillar_articles as $art): ?>
            <?php
            $pill_class = 'pill-kadastro';
            if ($art['pillar'] === 'imar') $pill_class = 'pill-imar';
            elseif ($art['pillar'] === 'tarla') $pill_class = 'pill-tarla';
            elseif ($art['pillar'] === 'hukuk') $pill_class = 'pill-hukuk';
            elseif ($art['pillar'] === 'yatirim') $pill_class = 'pill-yatirim';
            ?>
            <article class="article-card" data-pillar="<?php echo $art['pillar']; ?>">
                <div>
                    <div class="card-top">
                        <span class="pill-badge <?php echo $pill_class; ?>">
                            <?php echo htmlspecialchars($art['pillar_label']); ?>
                        </span>
                        <span class="law-ref-badge" title="<?php echo htmlspecialchars($art['law_ref']); ?>">
                            <?php echo htmlspecialchars($art['law_ref']); ?>
                        </span>
                    </div>

                    <h2 class="card-title">
                        <a href="/makale/<?php echo $art['slug']; ?>">
                            <?php echo htmlspecialchars($art['title']); ?>
                        </a>
                    </h2>

                    <p class="card-summary">
                        <?php echo htmlspecialchars($art['summary']); ?>
                    </p>
                </div>

                <div class="card-footer">
                    <div class="author-stamp">
                        <i class="fa-solid fa-circle-check"></i>
                        <span>Ant Harita Mühendislik Onaylı</span>
                    </div>
                    <a href="/makale/<?php echo $art['slug']; ?>" class="btn-read">
                        İncele <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
            </article>
        <?php endforeach; ?>

        <!-- No Results Fallback -->
        <div id="noResults">
            <i class="fa-solid fa-magnifying-glass" style="font-size: 32px; margin-bottom: 12px; color: #475569;"></i>
            <h3 style="font-size: 16px; color: #f8fafc; margin-bottom: 6px;">Eşleşen rehber bulunamadı</h3>
            <p style="font-size: 13px; margin: 0;">Lütfen arama teriminizi değiştirin veya filtreleri temizleyin.</p>
        </div>
    </div>

    <!-- Mega CTA Action Strip -->
    <section class="hub-cta-banner">
        <h2 class="hub-cta-title">İmar ve Kadastro İşlemlerinizi Hemen Hesaplayın</h2>
        <p class="hub-cta-desc">
            Ant Harita Mühendislik CBS altyapısıyla geliştirilen yapay zekâ destekli analiz motorlarımızla Türkiye genelindeki tüm parsellerin maliyet, ifraz ve yapılaşma durumunu saniyeler içinde simüle edin.
        </p>
        <div class="hub-cta-buttons">
            <a href="/tkgm-canli-parsel" class="btn-cta-tool">
                <i class="fa-solid fa-map"></i> Canlı Parsel Haritası
            </a>
            <a href="/arsa-insaat-maliyeti" class="btn-cta-tool">
                <i class="fa-solid fa-calculator"></i> 2026 İnşaat Maliyeti
            </a>
            <a href="/taks-kaks-hesaplama" class="btn-cta-tool">
                <i class="fa-solid fa-ruler-combined"></i> TAKS / KAKS Hesaplayıcı
            </a>
            <a href="/bot/madde-18-dop" class="btn-cta-tool">
                <i class="fa-solid fa-percent"></i> DOP Kesintisi Botu
            </a>
            <a href="/makaleler" class="btn-cta-tool" style="background: #2563eb; color: #fff;">
                <i class="fa-solid fa-database"></i> 68.150+ Makale Arşivi &raquo;
            </a>
        </div>
    </section>

    <!-- Regulatory & Legal Disclaimer -->
    <footer class="hub-disclaimer">
        <strong>Yasal Bilgilendirme ve E-E-A-T Mühendislik Beyanı:</strong><br>
        ParselSorgu.net, bağımsız bir harita mühendisliği ve gayrimenkul teknolojileri yazılım platformudur. Bu platformda yayımlanan imar, kadastro ve mevzuat rehberleri; 3194 Sayılı İmar Kanunu, 3402 Sayılı Kadastro Kanunu, Plansız Alanlar Tip İmar Yönetmeliği, Planlı Alanlar İmar Yönetmeliği ve ilgili kamu mevzuatları referans alınarak Ant Harita Mühendislik uzman kadrosu tarafından bilgilendirme amacıyla hazırlanmıştır. Hesaplama ve simülasyon sonuçları teknik birer ön fizibilite niteliğindedir; resmî belediye "İmar Durum Belgesi" veya kadastro "Aplikasyon Krokisi" yerine geçmez. Resmî işlemleriniz için ilgili belediye ve kadastro müdürlüklerine başvurunuz.
    </footer>

</div>

<!-- Client-side Fast Filter JS -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('articleSearch');
    const filterBtns = document.querySelectorAll('.filter-btn');
    const articles = document.querySelectorAll('.article-card');
    const noResults = document.getElementById('noResults');

    let currentFilter = 'all';

    function filterArticles() {
        const query = searchInput.value.trim().toLowerCase();
        let visibleCount = 0;

        articles.forEach(card => {
            const pillar = card.getAttribute('data-pillar');
            const title = card.querySelector('.card-title').textContent.toLowerCase();
            const summary = card.querySelector('.card-summary').textContent.toLowerCase();
            const lawRef = card.querySelector('.law-ref-badge').textContent.toLowerCase();

            const matchesCategory = (currentFilter === 'all' || pillar === currentFilter);
            const matchesQuery = (query === '' || title.includes(query) || summary.includes(query) || lawRef.includes(query));

            if (matchesCategory && matchesQuery) {
                card.style.display = 'flex';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        if (visibleCount === 0) {
            noResults.style.display = 'block';
        } else {
            noResults.style.display = 'none';
        }
    }

    // Category button clicks
    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            filterBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            currentFilter = this.getAttribute('data-filter');
            filterArticles();
        });
    });

    // Realtime search input
    searchInput.addEventListener('input', filterArticles);
});
</script>

    <!-- SITE FOOTER -->
    <footer style="margin-top: 60px; padding: 40px 16px; text-align: center; border-top: 1px solid #1e293b; color: #94a3b8; font-size: 13px;">
        <div style="max-width: 1200px; margin: 0 auto;">
            <p style="margin: 0 0 8px 0; font-weight: 600; color: #cbd5e1;">
                <strong>Ant Harita Mühendislik Teknolojileri A.Ş.</strong> &bull; LİHKAB No: 06-042 | TMMOB HKMO Sicil: 12480
            </p>
            <p style="margin: 0 0 10px 0; font-size: 12px; color: #64748b;">
                Yeni Mah. Ulubatlı Hasan Cad. No:78/A Kırıkkale / Merkez &bull; Tel: 0542 841 35 35 &bull; E-Posta: iletisim@parselsorgu.net
            </p>
            <p style="margin: 0; color: #475569; font-size: 12px;">
                &copy; 2026 ParselSorgu.net &bull; Türkiye'nin Akıllı Parsel ve İmar Sorgulama Platformu. Tüm Hakları Saklıdır.
            </p>
        </div>
    </footer>
    <script src="/analytics.js" defer></script>
</body>
</html>
