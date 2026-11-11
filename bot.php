<?php
/**
 * ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ - PARSEL PRO
 * bot.php - Dedicated Autonomous Real Estate & Cadastral Bot Engine
 * High-Traffic SEO, Instant Calculation & Traffic Conversion Engine
 */

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/navbar.php';

// Canonical domain
$site_domain = 'https://www.parselsorgu.net';


// 1.1 CONTEXTUAL PILLAR-CLUSTER GUIDES (INTERNAL LINKING ENGINE)
$PILLAR_GUIDES = [
    'koy-evi-imar' => [
        'title' => 'Plansız Alanlar İmar Yönetmeliği 2026 Şartları ve Köy Evi Kuralları',
        'desc' => 'Köy yerleşik alanında taban alanı (%40 TAKS), kadastral yol cephesi ve 5.000 m² kuralının tüm hukuki detaylarını rehberimizde inceleyin.',
        'url' => '/planli-alanlar-imar-yonetmeligi',
        'badge' => 'ÖNERİLEN İMAR REHBERİ'
    ],
    'tarla-ifraz-bolunme' => [
        'title' => 'İmar Durumu "Arazi", "Muhtelif" ve "Özel Kullanım" Ne Demek? Tarlaya Ev Yapılır mı?',
        'desc' => '5403 sayılı Toprak Koruma Kanunu tarla ifraz sınırları, hisseli tapu bölünme şartları ve izin süreçleri.',
        'url' => '/rehber/imar-durumu-arazi-muhtelif-ozel-kullanim-ne-demek-ev-yapilir-mi',
        'badge' => '5403 İFRAZ REHBERİ'
    ],
    'taks-kaks-emsal' => [
        'title' => 'İmar Çapı Nedir, Nasıl Alınır? 2026 İmar Durum Belgesi Örneği ve Rehberi',
        'desc' => 'Belediyeden resmi imar çapı alma adımları, TAKS, KAKS, Hmax ve çekme mesafelerinin mimari projelendirme kriterleri.',
        'url' => '/imar-capi',
        'badge' => 'İMAR ÇAPI & EMSAL REHBERİ'
    ],
    'imar-barisi-2b' => [
        'title' => 'İmar Affı 2026 Çıkacak mı? TBMM Meclis Son Durum, İmar Barışı ve Yapı Kayıt Belgesi',
        'desc' => '3194 sayılı Kanun Geçici 16. madde Yapı Kayıt Belgesi davaları ve 2026 imar para cezası hesaplama tablosu.',
        'url' => '/imar-affi',
        'badge' => 'İMAR AFFI & 2B REHBERİ'
    ],
    'google-news-imar-aski' => [
        'title' => 'Belediye E-İmar ve İmar Askı İlanları Sorgulama Rehberi',
        'desc' => 'İstanbul, Ankara, Antalya ve Ege belediyelerinde 1/1000 ve 1/5000 askı ilanları ve 30 günlük yasal itiraz süreci.',
        'url' => '/e-imar-sorgulama',
        'badge' => 'E-İMAR REHBERİ'
    ]
];

// 1. ALL 19 BOT DEFINITIONS & METADATA
$BOTS = [
    'google-news-imar-aski' => [
        'key' => 'googlenews',
        'slug' => 'google-news-imar-aski',
        'aliases' => ['google-news', 'resmi-aski', 'google-news-imar', 'imar-aski'],
        'title' => 'Google News Canlı İmar Değişiklikleri & Resmi Askı İlanı Botu 2026',
        'badge' => 'Google News TR & ÇŞİDB Canlı Askı Takibi',
        'icon' => '📰',
        'h1' => 'Google News Canlı İmar Değişiklikleri & Resmi Askı İlanı Botu',
        'subtitle' => '81 il ve 973 ilçede askıya çıkan güncel 1/1000 ve 1/5000 imar planı değişikliklerini, belediye meclis kararlarını, parselasyon ilanlarını ve 30 günlük yasal itiraz sürelerini anlık sorgulayın, inceleyin ve paylaşın.',
        'meta_title' => 'İmar Planı Değişikliği Askı İlanı Sorgulama (2026) | ParselSorgu',
        'meta_desc' => '81 il belediyesi askıdaki 1/1000 ve 1/5000 imar planı değişiklikleri, 3194 s.K. 8. madde 30 günlük askı itiraz süresi, Resmi Gazete ve Google News canlı imar haberleri.',
        'law_code' => '3194 Sayılı İmar Kanunu Madde 8 & Mekânsal Planlar Yapım Yönetmeliği',
        'category_keyword' => 'İmar Planı Değişikliği',
        'default_area' => 30,
        'params_type' => 'googlenews',
        'guide_title' => '3194 Sayılı İmar Kanunu 8. Madde Uyarınca İmar Planı Askı ve İtiraz Süreci',
        'guide_text' => '<p>Belediye meclislerince veya ÇŞİDB tarafından onaylanan 1/5000 ölçekli Nazım İmar Planları ve 1/1000 ölçekli Uygulama İmar Planı değişiklikleri, ilgili idarelerin ilan panolarında ve internet sitelerinde <strong>30 gün süreyle askıya çıkarılır</strong>. Taşınmaz sahipleri veya menfaati etkilenen vatandaşlar bu 30 günlük yasal süre içinde belediyeye yazılı itiraz dilekçesi sunabilir. Süresinde itiraz edilmeyen planlar kesinleşir.</p>',
        'faqs' => [
            [
                'q' => 'İmar planı askı süresi kaç gündür?',
                'a' => '3194 sayılı İmar Kanunu nun 8/b maddesi uyarınca imar planları ve değişiklikleri belediye veya valilikçe ilan panosunda ve internet ortamında kesintisiz 30 gün süreyle askıda kalır.'
            ],
            [
                'q' => 'Askıdaki imar planına nasıl itiraz edilir?',
                'a' => 'Taşınmazın ada, parsel bilgileri ve itiraz gerekçelerini içeren ıslak imzalı bir itiraz dilekçesi ile askı süresi (30 gün) dolmadan ilgili ilçe belediyesi veya büyükşehir belediyesi Yazı İşleri Müdürlüğü ne başvurulur.'
            ],
            [
                'q' => 'Belediye itirazı reddederse veya cevap vermezse ne yapılır?',
                'a' => 'Belediye Meclisi itirazı 30 gün içinde karara bağlar. İtirazın reddi halinde ret kararının tebliğinden itibaren veya 60 günlük zımni ret süresinden sonra yetkili İdare Mahkemesinde "İmar Planının İptali ve Yürütmenin Durdurulması" davası açılabilir.'
            ],
            [
                'q' => 'Google News imar haberleri ve askı ilanları nereden taranır?',
                'a' => 'Ant Harita otonom botları; Resmi Gazete, Çevre Şehircilik ve İklim Değişikliği Bakanlığı duyuruları, Basın İlan Kurumu ve 81 ilin yerel belediye meclisi askı panolarını Google News RSS ve kamu açık veri servisleri üzerinden canlı olarak derler.'
            ]
        ]
    ],
    'koy-evi-imar' => [
        'key' => 'koyevi',
        'slug' => 'koy-evi-imar',
        'aliases' => ['koyevi', 'koy-evi', 'koy-imar'],
        'title' => 'Köyde Ev Yapma İzni & Plansız Alanlar İmar Botu 2026',
        'badge' => 'Plansız Alanlar İmar Yön. & 3194 s.K.',
        'icon' => '🏡',
        'h1' => 'Köyde Ev Yapma İzni & Plansız Alanlar İmar Hesaplama Botu',
        'subtitle' => 'Tarlaya ev yapılır mı? %5 emsal kuralı, 250 m² azami inşaat hakkı, kadastro yolu ve İl Özel İdaresi ruhsat şartlarını anında hesaplayın.',
        'meta_title' => 'Köyde Ev Yapma İzni – 5000 m² Şartı ve İmarı (2026) | ParselSorgu',
        'meta_desc' => 'Tarlaya ev yapma şartları: 2026 Plansız Alanlar İmar Yönetmeliği %5 emsal, 250 m² tavan inşaat hakkı, kadastro yoluna 25m cephe ve ruhsat ön fizibilite hesaplaması.',
        'law_code' => 'Plansız Alanlar İmar Yönetmeliği Madde 51-62 & 3194 Sayılı İmar Kanunu',
        'category_keyword' => 'Köy İmarı',
        'default_area' => 6500,
        'params_type' => 'koyevi',
        'guide_title' => 'Tarlaya Köy Evi Yapma Mevzuatı ve Şartları (2026 Rehberi)',
        'guide_text' => '<p>Köy yerleşik alanı civarı ve plansız alanlarda bulunan tarlalara ev yapabilmek için <strong>Plansız Alanlar İmar Yönetmeliği</strong> hükümlerine uyulması zorunludur. Tarlanın yüzölçümü en az 5.000 m² olmalı, kadastro yoluna asgari 25 metre cephesi bulunmalı ve inşa edilecek toplam inşaat alanı parsel büyüklüğünün %5 ini (en fazla 250 m²) geçmemelidir. İzin ve ruhsat mercii İl Özel İdaresi veya ilgili ilçe belediyesidir.</p>',
        'faqs' => [
            [
                'q' => 'Köy yerleşik alanında taban alanı ne kadardır?',
                'a' => 'Plansız Alanlar İmar Yönetmeliği Madde 51 uyarınca, köy yerleşik alanı ve civarı sınırları içerisinde yapılacak konut ve tarımsal yapılarda taban alanı kat sayısı (TAKS) en fazla %40\'tır. Yapı inşaat alanı toplamda azami 250 m²\'yi ve bina yüksekliği 2 katı (H: 6.50 m) aşamaz.'
            ],
            [
                'q' => '5.000 m² den küçük tarlaya köy evi yapılabilir mi?',
                'a' => 'Plansız Alanlar İmar Yönetmeliğine göre tarlanın plansız alanda bulunması durumunda asgari 5.000 m² büyüklük şartı aranır. Ancak parsel "Köy Yerleşik Alan Sınırı" içerisindeyse 5.000 m² şartı aranmaz; köy içi imar şartlarına göre (genelde min 300-500 m²) ev yapılabilir.'
            ],
            [
                'q' => 'Kadastro yolu olmayan tarlaya ev ruhsatı verilir mi?',
                'a' => 'Hayır. Kadastro yoluna fiilen ve tapuda cephesi olmayan parsellere inşaat ruhsatı düzenlenemez. Komşu parsellerden mahkeme veya noter kanalıyla "Geçit Hakkı" tesis edilmeden ruhsat süreci başlatılamaz.'
            ],
            [
                'q' => 'Köy evinde maksimum kaç kat ve metrekare inşaat yapılabilir?',
                'a' => 'Yönetmeliğe göre parsel alanının maksimum %5 i kadar taban alanı kullanılabilir ve saçak seviyesine kadar bina yüksekliği en fazla 2 kat (6.50 metre), toplam kapalı inşaat alanı ise hiçbir surette 250 m² yi geçemez.'
            ],
            [
                'q' => 'Köy evi yapmak için nereye başvurulur?',
                'a' => 'Büyükşehir statüsünde olmayan illerde İl Özel İdaresi İmar ve Kentsel İyileştirme Müdürlüğü ne; büyükşehir sınırları içerisindeki kırsal mahallelerde ise bağlı olunan İlçe Belediyesi İmar Müdürlüğü ne mimari, statik ve kadastro projeleriyle başvurulur.'
            ]
        ]
    ],
    'miras-tarla-5403' => [
        'key' => 'mirastarla',
        'slug' => 'miras-tarla-5403',
        'aliases' => ['mirastarla', 'miras-tarla', 'tarla-intikal', 'veraset-tarla'],
        'title' => 'Miras Kalan Tarla, 5403 İntikal & Paylaşım Botu 2026',
        'badge' => '5403 s.K. & TMK Miras Hukuku',
        'icon' => '📜',
        'h1' => 'Miras Kalan Tarla, 5403 İntikal & Paylaşım Hesaplama Botu',
        'subtitle' => 'Kardeşler arasında tarla bölünür mü? 5403 sayılı Kanun asgari tarımsal arazi büyüklükleri, veraset intikali ve hisse devir şartlarını sorgulayın.',
        'meta_title' => 'Miras Kalan Tarla Paylaşımı & 5403 İntikal (2026) | ParselSorgu',
        'meta_desc' => 'Miras kalan tarla nasıl bölünür? 5403 s.K. asgari tarımsal arazi büyüklüğü (kuru 40 dekar, sulu 20 dekar, dikili 5 dekar), intikal harçları ve kardeşler arası taksim analizi.',
        'law_code' => '5403 Sayılı Toprak Koruma ve Arazi Kullanımı Kanunu & 4721 Sayılı TMK',
        'category_keyword' => 'Miras Tarla',
        'default_area' => 35000,
        'params_type' => 'mirastarla',
        'guide_title' => 'Miras Kalan Tarımsal Arazilerin Bölünmesi ve İntikali (5403 Sayılı Kanun)',
        'guide_text' => '<p>5403 sayılı Toprak Koruma ve Arazi Kullanımı Kanunu kapsamında tarım arazileri miras yoluyla bölünemez parçalara ayrılamaz. Kuru tarım arazilerinde 40 dekar (40.000 m²), sulu arazilerde 20 dekar, dikili arazilerde (zeytinlik/meyvelik) 5 dekar ve örtüaltı seralarda 3 dekar asgari sınır vardır. Bu büyüklüklerin altındaki tarlalar mirasçılar arasında ifraz edilemez; tek bir mirasçıya devredilebilir, aile ortaklığı kurulabilir veya satılabilir.</p>',
        'faqs' => [
            [
                'q' => 'Miras kalan tarla kardeşler arasında rızaen taksim edilebilir mi?',
                'a' => 'Eğer hisse başına düşen arazi miktarı 5403 sayılı kanunda belirtilen asgari büyüklüklerin üzerindeyse (kuru arazide kardeş başına 40 dönüm) noterde taksim sözleşmesi yapılıp ifraz edilebilir. Altındaysa müstakil tapulara ayrılamaz.'
            ],
            [
                'q' => 'Veraset intikali yapılmazsa ne olur?',
                'a' => 'Vefat tarihinden itibaren 1 yıl içinde intikal yapılmazsa Tarım ve Orman Bakanlığı mirasçılara 3 aylık süre verir. Bu sürede devir yapılmazsa Bakanlık yetkili sulh hukuk mahkemesinde ehil mirasçıya devir veya satış davası açar.'
            ],
            [
                'q' => 'Miras kalan tarlada kardeşlerden biri hissesini yabancıya satabilir mi?',
                'a' => '5403 sayılı Kanun ve TMK 732 uyarınca, diğer mirasçıların (hissedarların) öncelikli yasal önalım (şufa) hakkı ve tarımsal komşu parsel önalım hakkı bulunur. Yabancıya satış halinde diğer hissedarlar aynı bedelle payı geri alabilir.'
            ],
            [
                'q' => 'Miras intikalinde tapu harcı ödenir mi?',
                'a' => 'Vefat tarihinden itibaren yasal süreler içinde yapılan intikallerde tapu harcı muafiyeti uygulanabilir; yalnızca döner sermaye bedeli tahsil edilir. İntikalden sonraki kardeşler arası pay devirlerinde ise binde 22.5 harç uygulanır.'
            ]
        ]
    ],
    'izale-i-suyu' => [
        'key' => 'izaleisuyu',
        'slug' => 'izale-i-suyu',
        'aliases' => ['izaleisuyu', 'izalei-suyu', 'ortakligin-giderilmesi'],
        'title' => 'İzale-i Şüyu (Ortaklığın Giderilmesi) & e-Satış İhale Botu 2026',
        'badge' => 'TMK Madde 698-699 & İİK e-Satış',
        'icon' => '⚖️',
        'h1' => 'İzale-i Şüyu & UYAP e-Satış İhalesi Hesaplama Botu',
        'subtitle' => 'Hisseli arsa ve tarlalarda ortaklığın giderilmesi davası, aynen taksim imkanı, mahkeme bilirkişi keşfi ve UYAP e-Satış %50 taban fiyat analizi.',
        'meta_title' => 'İzale-i Şüyu Davası & Ortaklığın Giderilmesi (2026) | ParselSorgu',
        'meta_desc' => 'İzale-i şüyu davası nasıl sonuçlanır? Taşınmaz değeri, %50 muhammen bedelle açık artırma, mahkeme ve avukatlık masrafları ile hissedar payını anında hesaplayın.',
        'law_code' => 'Türk Medeni Kanunu Madde 698-699 & İcra ve İflas Kanunu',
        'category_keyword' => 'İzale-i Şüyu',
        'default_area' => 6000000,
        'params_type' => 'izaleisuyu',
        'guide_title' => 'Ortaklığın Giderilmesi (İzale-i Şüyu) Davası ve İhale Süreci Rehberi',
        'guide_text' => '<p>Taşınmaza müşterek veya elbirliği mülkiyetiyle malik olan hissedarlardan herhangi biri, ortaklığın giderilmesini talep edebilir. Mahkeme ilk olarak taşınmazın fiziken aynen taksim edilip edilemeyeceğini (imar ve kadastro şartlarına göre) inceler. Aynen taksim mümkün değilse satış suretiyle ortaklığın giderilmesine karar verilir. Satış İcra Dairesi / Sulh Hukuk Satış Memurluğu tarafından UYAP e-Satış portalında %50 muhammen bedel tabanıyla açık artırma usulüyle yapılır.</p>',
        'faqs' => [
            [
                'q' => 'İzale-i şüyu davasını tek bir hissedar açabilir mi?',
                'a' => 'Evet. Taşınmazda en ufak hisseye sahip olan tek bir paydaş dahi diğer tüm paydaşlara karşı sulh hukuk mahkemesinde ortaklığın giderilmesi davası açabilir. Çoğunluk aranmaz.'
            ],
            [
                'q' => 'UYAP e-Satış ihalesinde ilk teklif ne kadar olmalıdır?',
                'a' => 'İcra ve İflas Kanunu uyarınca ilk açık artırma, bilirkişi tarafından belirlenen muhammen bedelin %50 si + satış ve takip masrafları toplamından başlar.'
            ],
            [
                'q' => 'Hissedarlar ihaleye teminatsız katılabilir mi?',
                'a' => 'Hissedarların hissesi teminat tutarını (muhammen bedelin %10-20 si) karşılıyorsa ayrıca nakit teminat yatırmadan ihaleye pey sürebilirler.'
            ],
            [
                'q' => 'İhale bedeli hissedarlara nasıl paylaştırılır?',
                'a' => 'İhale kesinleştikten sonra elde edilen satış bedelinden mahkeme, tebligat, bilirkişi, tellaliye ve satış memurluğu masrafları ile harçlar düşülür; kalan net tutar tapudaki hisse oranlarına göre doğrudan banka hesaplarına aktarılır.'
            ]
        ]
    ],
    'belediye-rayic-bedel' => [
        'key' => 'belediyerayic',
        'slug' => 'belediye-rayic-bedel',
        'aliases' => ['belediyerayic', 'belediye-rayic', 'emlak-vergisi'],
        'title' => '2026 Belediye Rayiç Bedel & Emlak Vergisi Hesaplama Botu',
        'badge' => '1319 Emlak Vergisi Kanunu & 213 VUK',
        'icon' => '🏛️',
        'h1' => '2026 Belediye Rayiç Bedeli & Emlak Vergisi Hesaplama Botu',
        'subtitle' => 'Arsa, konut, tarla ve işyeri m² birim rayiçleri, Büyükşehir ve normal il binde vergi oranları, 2026 taksitleri ve tapu asgari beyan tutarını hesaplayın.',
        'meta_title' => '2026 Belediye Rayiç Bedeli & Emlak Vergisi | ParselSorgu',
        'meta_desc' => 'Belediye rayiç bedeli nasıl hesaplanır? 2026 arsa, tarla, mesken ve ticari emlak vergisi binde oranları, yıllık vergi tutarı ve tapu devir asgari matrahı sorgulama.',
        'law_code' => '1319 Sayılı Emlak Vergisi Kanunu & Vergi Usul Kanunu Genel Tebliğleri',
        'category_keyword' => 'Belediye Rayiç',
        'default_area' => 500,
        'params_type' => 'belediyerayic',
        'guide_title' => 'Belediye Asgari Rayiç Değeri ve Emlak Vergisi Oranları (2026)',
        'guide_text' => '<p>Belediyelerce her 4 yılda bir takdir komisyonlarınca belirlenen ve her yıl yeniden değerleme oranıyla güncellenen m² birim değerleri taşınmazın asgari rayiç bedelini oluşturur. Tapu devirlerinde satış bedeli belediye rayicinden düşük gösterilemez. Emlak vergisi oranları Büyükşehir belediyesi sınırları içinde 2 kat uygulanır: Konutlarda binde 2, işyerlerinde binde 4, arsalarda binde 6, tarlalarda binde 2 dir.</p>',
        'faqs' => [
            [
                'q' => 'Tapuda gösterilen satış bedeli belediye rayicinden düşük olabilir mi?',
                'a' => 'Kesinlikle olamaz. Tapu müdürlükleri belediye rayiç belgesindeki asgari değerin altındaki devir beyanlarını kabul etmez. Düşük beyan tespit edilirse vergi ziyaı cezası ve gecikme faizi uygulanır.'
            ],
            [
                'q' => 'Emlak vergisi ne zaman ödenir?',
                'a' => 'Emlak vergisi yılda iki eşit taksitte ödenir. 1. taksit Mart-Nisan-Mayıs ayları sonuna kadar, 2. taksit ise Kasım ayı sonuna kadar ilgili belediyeye yatırılır.'
            ],
            [
                'q' => 'Kimler konut emlak vergisinden muaftır (Sıfır Oranlı Vergi)?',
                'a' => 'Brüt 200 m² yi geçmeyen tek bir meskene sahip olan emekliler, hiçbir geliri olmadığını belgeleyen ev hanımları, gaziler, engelliler, şehit dul ve yetimleri sıfır oranlı emlak vergisi muafiyetinden faydalanabilir.'
            ],
            [
                'q' => 'Rayiç bedel belgesi nereden alınır?',
                'a' => 'Taşınmazın bağlı bulunduğu ilçe belediyesinin Emlak ve İstimlak Müdürlüğü veznelerinden veya e-Devlet Kapısı üzerinden belediye online hizmetlerinden temin edilebilir.'
            ]
        ]
    ],
    'kentsel-donusum-kira' => [
        'key' => 'kentseldonusum',
        'slug' => 'kentsel-donusum-kira',
        'aliases' => ['kentseldonusum', 'kentsel-donusum', '6306-donusum'],
        'title' => '6306 Kentsel Dönüşüm, 2026 Kira Yardımı & %50+1 Çoğunluk Botu',
        'badge' => '6306 sayılı Afet Riski Kanunu',
        'icon' => '🏗️',
        'h1' => '6306 Kentsel Dönüşüm, Kira Yardımı & %50+1 Çoğunluk Botu',
        'subtitle' => 'Riskli bina tespiti, 2026 aylık kira yardımı hibesi (İstanbul, Ankara, İzmir vb.), salt çoğunluk (%50+1) karar nisabı ve müteahhit paylaşım haklarınızı hesaplayın.',
        'meta_title' => '6306 Kentsel Dönüşüm Kira Yardımı & %50+1 (2026) | ParselSorgu',
        'meta_desc' => '6306 sayılı Kanun kentsel dönüşüm kira yardımı 2026 tutarları, %50+1 salt çoğunluk karar şartı, tapu harç muafiyetleri ve müteahhit sözleşme analizi.',
        'law_code' => '6306 Sayılı Afet Riski Altındaki Alanların Dönüştürülmesi Hakkında Kanun',
        'category_keyword' => 'Kentsel Dönüşüm',
        'default_area' => 4500000,
        'params_type' => 'kentseldonusum',
        'guide_title' => '6306 Sayılı Kanun Kentsel Dönüşüm ve Devlet Destekleri (2026)',
        'guide_text' => '<p>Yapılan son yasal düzenlemelerle riskli yapıların dönüşümünde aranan 2/3 çoğunluk şartı kaldırılarak <strong>%50+1 (salt çoğunluk)</strong> kuralı getirilmiştir. Kat malikleri hisse çoğunluğu ile bina yıkımı, müteahhit seçimi ve sözleşme akdi yapabilir. Çevre, Şehircilik ve İklim Değişikliği Bakanlığı maliklere 18 ay boyunca geri ödemesiz kira desteği ve faiz sübvansiyonlu dönüşüm kredisi sağlar.</p>',
        'faqs' => [
            [
                'q' => 'Kentsel dönüşümde karar almak için kaç malik imzası gerekir?',
                'a' => 'Yasa değişikliğiyle birlikte bina hisse oranlarının %50 si + 1 pay çoğunluğunun karara onay vermesi yeterlidir. Karara katılmayan azınlığın payı diğer paydaşlara açık artırmayla satılır.'
            ],
            [
                'q' => '2026 kentsel dönüşüm kira yardımı ne kadar sürelidir?',
                'a' => 'Riskli yapılarda maliklere 18 ay, riskli alan / rezerv yapı alanlarında ise azami 48 ay süreyle karşılıksız aylık kira yardımı ödenir.'
            ],
            [
                'q' => 'Kiracılar kentsel dönüşümde kira yardımı alabilir mi?',
                'a' => 'Kiracılara aylık kira ödemesi yapılmaz; ancak tahliye anında taşınma masraflarını karşılamak üzere defaten 2 aylık kira yardımı tutarında taşınma bedeli hibesi verilir.'
            ],
            [
                'q' => 'Kentsel dönüşümde tapu harcı ve noter masrafı ödenir mi?',
                'a' => '6306 sayılı kanun kapsamında yapılan devirler, ifraz, tevhid, kat irtifakı ve kat mülkiyeti işlemleri tapu harcından, noter harçlarından ve belediye resimlerinden tamamen muaftır.'
            ]
        ]
    ],
    'kiyi-kenar-cizgisi' => [
        'key' => 'kiyikenar',
        'slug' => 'kiyi-kenar-cizgisi',
        'aliases' => ['kiyikenar', 'kiyi-kenar', '3621-kiyi'],
        'title' => '3621 Kıyı Kenar Çizgisi & DSİ Taşkın Koruma Bandı Botu',
        'badge' => '3621 s.K. & DSİ Taşkın Koruma',
        'icon' => '🌊',
        'h1' => '3621 Kıyı Kenar Çizgisi & Taşkın Koruma Bandı Hesaplama Botu',
        'subtitle' => 'Deniz, göl ve akarsu kenarındaki arazilerde ilk 50m ve ikinci 50m sahil şeridi kısıtlamalarını, inşaat yasaklarını ve DSİ taşkın koruma bandı mesafelerini sorgulayın.',
        'meta_title' => '3621 Kıyı Kenar Çizgisi Sahil Yapılaşma Yasağı | ParselSorgu',
        'meta_desc' => '3621 Kıyı Kanunu kıyı kenar çizgisi sorgulama, ilk 50m mutlak yapı yasağı, ikinci 50m günübirlik tesis şartı ve DSİ dere taşkın koruma bandı analizi.',
        'law_code' => '3621 Sayılı Kıyı Kanunu & DSİ Akarsu Taşkın Koruma Yönetmeliği',
        'category_keyword' => 'Kıyı Kenar',
        'default_area' => 35,
        'params_type' => 'kiyikenar',
        'guide_title' => '3621 Sayılı Kıyı Kanunu ve Sahil Şeridi İmar Kısıtlamaları',
        'guide_text' => '<p>3621 sayılı Kıyı Kanununa göre kıyı kenar çizgisinden kara yönüne doğru en az 100 metre genişliğindeki alan <strong>Sahil Şeridi</strong> olarak adlandırılır. İlk 50 metrede hiçbir şekilde konut, ticari yapı veya kalıcı bina inşa edilemez; yalnızca açık alan, yeşil alan ve gezinti amaçlı düzenlemeler yapılabilir. İkinci 50 metrede ise imar planı bulunması kaydıyla sadece günübirlik turizm tesisleri yapılabilir.</p>',
        'faqs' => [
            [
                'q' => 'Kıyı kenar çizgisi içinde kalan özel tapulu arazinin durumu nedir?',
                'a' => 'Kıyı kenar çizgisinin deniz tarafında kalan tapulu araziler Anayasa ve Kıyı Kanunu gereğince kamunun kullanımına aittir. Tapu iptal ve Hazine adına tescil davalarıyla kamulaştırmasız el atma veya tazminat süreçleri işletilir.'
            ],
            [
                'q' => 'İlk 50 metrede bungalov veya prefabrik ev kurulabilir mi?',
                'a' => 'Hayır. İlk 50 metrelik sahil şeridinde kalıcı veya seyyar, prefabrik ya da konteyner dahil hiçbir konaklama amaçlı yapıya izin verilmez.'
            ],
            [
                'q' => 'Dere ve çay kenarında kaç metre taşkın koruma bandı bırakılmalıdır?',
                'a' => 'DSİ Taşkın Koruma Yönetmeliği ve ilgili Havza Yönetim Planlarına göre akarsu şev üstünden itibaren her iki yakada asgari 10 ile 25 metre genişliğinde taşkın koruma bandı bırakılması zorunludur.'
            ],
            [
                'q' => 'Kıyı kenar çizgisini kim belirler?',
                'a' => 'Valilik bünyesinde kurulan ve jeoloji mühendisi, harita mühendisi ve ziraat mühendislerinden oluşan Kıyı Kenar Çizgisi Tespit Komisyonu belirler ve ÇŞİDB onaylar.'
            ]
        ]
    ],
    'ges-arazi-uygunluk' => [
        'key' => 'ges',
        'slug' => 'ges-arazi-uygunluk',
        'aliases' => ['ges', 'ges-fizibilite', 'gunes-enerjisi'],
        'title' => 'GES Güneş Enerjisi Santrali Arazi Uygunluk & 1 MW Botu 2026',
        'badge' => '5346 s.K. & EPDK Lisanssız Elektrik',
        'icon' => '☀️',
        'h1' => 'Arazi GES Uygunluk & 1 MW Güneş Santrali Fizibilite Botu',
        'subtitle' => 'Tarlaya güneş enerjisi santrali (GES) kurulur mu? Marjinal tarım raporu, trafo kapasitesi ve 1 MW için arazi ihtiyaç analizi.',
        'meta_title' => 'GES Güneş Santrali Arazi Uygunluk Testi (2026) | ParselSorgu',
        'meta_desc' => 'Tarlada GES kurulumu şartları: 1 MW için dönüm hesabı (~15-18 dönüm), marjinal tarım arazisi raporu, güney eğim ve trafo bağlantı mesafesi analizi.',
        'law_code' => '5346 Sayılı Yenilenebilir Enerji Kanunu & EPDK Lisanssız Elektrik Yönetmeliği',
        'category_keyword' => 'GES',
        'default_area' => 20000,
        'params_type' => 'ges',
        'guide_title' => 'Arazi GES Kurulumu, Marjinal Tarım İzni ve Trafo Şartları (2026)',
        'guide_text' => '<p>Güneş Enerjisi Santrali (GES) kurabilmek için arazinin mutlaka İl Tarım ve Orman Müdürlüğü tarafından düzenlenmiş <strong>Marjinal Tarım Arazisi</strong> (tarımsal niteliği düşük) raporuna sahip olması gerekir. Mutlak tarım arazilerine, zeytinliklere veya sulama alanlarına GES kurulamaz. 1 MW kurulu güç için ortalama 15.000 - 20.000 m² arazi gereklidir ve TEİAŞ / EDAŞ trafo merkezinde lisanssız üretim kapasitesi bulunmalıdır.</p>',
        'faqs' => [
            [
                'q' => '1 MW Güneş Santrali (GES) için kaç dönüm arazi gerekir?',
                'a' => 'Panel teknolojisine ve arazi eğimine bağlı olarak 1 MW DC/AC kurulu güç için ortalama 14.000 ile 18.000 m² (yaklaşık 15-18 dönüm) net arazi alanı gereklidir.'
            ],
            [
                'q' => 'Sulu veya verimli tarım tarlasına GES kurulabilir mi?',
                'a' => 'Hayır. 5403 sayılı Kanun gereğince I. II. ve III. sınıf mutlak tarım arazilerine ve özel ürün arazilerine GES kurulması kanunen yasaktır.'
            ],
            [
                'q' => 'GES için trafo merkezine azami mesafe ne olmalıdır?',
                'a' => 'Yatırımın ekonomik fizibilitesi için arazi ile bağlantı yapılacak trafo merkezi (veya dağıtım hattı) arasındaki mesafenin azami 3-5 km olması tavsiye edilir; mesafe uzadıkça ENH (Enerji Nakil Hattı) maliyeti katlanır.'
            ],
            [
                'q' => 'Lisanssız GES elektrik satış geliri nasıl tahsil edilir?',
                'a' => 'EPDK Lisanssız Elektrik Üretim Yönetmeliği uyarınca ihtiyaç fazlası üretilen elektrik, görevli tedarik şirketi üzerinden YEKDEM veya serbest piyasa takas fiyatıyla şebekeye satılarak aylık mahsuplaşılır.'
            ]
        ]
    ],
    'kat-karsiligi-oran' => [
        'key' => 'katkarsiligi',
        'slug' => 'kat-karsiligi-oran',
        'aliases' => ['katkarsiligi', 'kat-karsiligi'],
        'title' => 'Kat Karşılığı İnşaat Oranı & Daire Paylaşım Botu 2026',
        'badge' => 'TBK Eser & Arsa Payı Sözleşmesi',
        'icon' => '🏢',
        'h1' => 'Kat Karşılığı İnşaat Oranı & Daire Paylaşım Hesaplama Botu',
        'subtitle' => 'Arsanıza kaç daire çıkar? Arsa sahibi ve müteahhit paylaşım oranını (%20-%80) manuel belirleyip bağımsız bölüm dağılımını anında hesaplayın.',
        'meta_title' => 'Kat Karşılığı İnşaat Oranı Hesaplama (2026) | ParselSorgu',
        'meta_desc' => 'Arsa kat karşılığı yüzde kaç verilmeli? Arsa alanı, emsal KAKS, toplam inşaat alanı, müteahhit payı ve net daire adedi simülatörü.',
        'law_code' => 'Türk Borçlar Kanunu Eser & Arsa Payı Karşılığı İnşaat Sözleşmeleri',
        'category_keyword' => 'Kat Karşılığı',
        'default_area' => 1200,
        'params_type' => 'katkarsiligi',
        'guide_title' => 'Kat Karşılığı İnşaat Sözleşmeleri ve Daire Paylaşım Esasları',
        'guide_text' => '<p>Kat karşılığı inşaat projelerinde bölgenin arsa rayici ve inşaat maliyet endekslerine göre %40-%60 aralığında arsa payı taksimi yapılır. Emsal inşaat alanına ek olarak otopark, sığınak ve yangın holü gibi emsal harici alanlar dahil brüt inşaat hacmi hesaplanır. Sözleşmenin mutlaka noter huzurunda "Düzenleme Şeklinde Arsa Payı Karşılığı İnşaat Sözleşmesi" olarak akdedilmesi şarttır.</p>',
        'faqs' => [
            [
                'q' => 'Kat karşılığı sözleşmesinde müteahhit gecikirse arsa sahibinin hakları nelerdir?',
                'a' => 'Sözleşmeye eklenecek cezai şart ve rayiç kira tazminatı hükümleri uyarınca gecikilen her ay için arsa sahiplerine kira bedeli ödenir; 6 aydan fazla gecikmelerde sözleşmenin tek taraflı feshi talep edilebilir.'
            ],
            [
                'q' => 'İnşaatta daire paylaşımı hangi kritere göre yapılır?',
                'a' => 'Paylaşım yalnızca metrekareye göre değil; bağımsız bölümlerin cephe, kat yüksekliği, deniz/manzara şerefiyesi dikkate alınarak SPK lisanslı değerleme raporu veya şerefiye puanlama cetveliyle yapılmalıdır.'
            ],
            [
                'q' => 'Müteahhit hissesini arsa sahibi inşaat bitmeden devretmeli midir?',
                'a' => 'Hayır. Müteahhide tapu devirleri kat irtifakı kurulduktan sonra inşaat hakediş seviyesine göre kademeli (%20 kaba yapı, %50 ince yapı, %80 tesisat, kalan %20 iskan ruhsatı alındıktan sonra) yapılmalıdır.'
            ],
            [
                'q' => 'Kat karşılığı sözleşmesi notersiz adi yazılı yapılabilir mi?',
                'a' => 'Hayır. Gayrimenkul mülkiyetini devir borcu doğuran sözleşmeler resmi şekilde yapılmadıkça (noterde düzenleme şeklinde) hukuken geçersizdir.'
            ]
        ]
    ],
    'tarla-ifraz-bolunme' => [
        'key' => 'ifraz',
        'slug' => 'tarla-ifraz-bolunme',
        'aliases' => ['ifraz', 'tarla-ifraz'],
        'title' => 'Otomatik Tarla İfraz & 5403 s.K. Bağ Evi İmar Botu 2026',
        'badge' => '5403 s.K. & 3194 Madde 15-16',
        'icon' => '✂️',
        'h1' => 'Otomatik Tarla İfraz (Bölünme) & İmar Hesaplama Botu',
        'subtitle' => 'Tarlayı kaç parçaya bölebilirsiniz? 5403 sayılı Kanun arazi sınıfları, asgari parsel büyüklükleri ve kadastro yolu terk şartlarını hesaplayın.',
        'meta_title' => 'Tarla İfraz & Bölünme Şartları Sorgulama (2026) | ParselSorgu',
        'meta_desc' => 'Tarla kaç metrekareden sonra bölünür? 5403 sayılı kanun ifraz şartları, kuru/sulu tarım asgari parsel sınırları ve kadastro yoluna cephe hesaplama.',
        'law_code' => '5403 Sayılı Toprak Koruma Kanunu & 3194 İmar Kanunu Madde 15 ve 16',
        'category_keyword' => 'İfraz',
        'default_area' => 85000,
        'params_type' => 'ifraz',
        'guide_title' => 'Tarımsal ve İmarlı Parsellerde İfraz (Ayırma) Şartları (2026)',
        'guide_text' => '<p>İfraz, bir parselin harita mühendislerince hazırlanan ayırma krokisi ve belediye encümeni / il encümeni kararıyla iki veya daha fazla bağımsız parsele bölünmesidir. Tarım arazilerinde ifraz için İl Tarım ve Orman Müdürlüğü nün olumlu görüşü zorunludur. Oluşacak her yeni parselin kadastro yoluna en az 25 metre cephesi bulunmalıdır.</p>',
        'faqs' => [
            [
                'q' => '5403 sayılı kanuna göre tarla nasıl bölünür?',
                'a' => '5403 sayılı Toprak Koruma ve Arazi Kullanımı Kanunu gereğince tarım arazileri asgari tarımsal arazi büyüklüklerinin altına düşecek şekilde bölünemez (ifraz edilemez). Kuru tarım arazilerinde asgari 40.000 m² (40 dekar), sulu arazilerde 20.000 m², dikili ve örtüaltı tarım arazilerinde ise 5.000 m² den küçük parçalar oluşturulamaz. Bu sınırların altındaki hisseli arazilerde ifraz yapılamaz; pay devri veya ehil mirasçıya devir yolu izlenir.'
            ],
            [
                'q' => 'Tarla kaç metrekareden küçükse ifraz edilemez?',
                'a' => 'Kuru tarım arazilerinde 40.000 m² (40 dekar), sulu arazilerde 20.000 m², dikili arazilerde ise 5.000 m² den küçük parçalar oluşturacak şekilde ifraz yapılamaz.'
            ],
            [
                'q' => 'İmar planı olan bir arsa nasıl ifraz edilir?',
                'a' => 'Uygulama İmar Planında belirtilen asgari parsel büyüklüğü (genellikle 300 - 500 m²) ve asgari cephe genişliği (en az 12 - 15 m) sağlandığı takdirde belediye encümeni kararıyla ifraz edilebilir.'
            ],
            [
                'q' => 'İfraz işleminde yola terk zorunlu mudur?',
                'a' => 'Parselin imar planındaki yol veya yeşil alan hatlarına tecavüzü varsa veya yol genişletme gerekiyorsa terk işlemi yapılmadan ifraz tamamlanamaz.'
            ],
            [
                'q' => 'İfraz dosyasını kim hazırlar?',
                'a' => 'İfraz harita ve planları yalnızca Tescilli Serbest Harita ve Kadastro Mühendisleri (SHKM) tarafından hazırlanır, Kadastro Müdürlüğü nce kontrol edilir ve Tapuya tescil edilir.'
            ]
        ]
    ],
    'imar-barisi-2b' => [
        'key' => '2b',
        'slug' => 'imar-barisi-2b',
        'aliases' => ['2b', 'imar-barisi', '6292-hazine'],
        'title' => '6292 sayılı Kanun 2B Hazine Arazisi & İmar Barışı Botu',
        'badge' => '6292 s.K. & 3194 Geçici Madde 16',
        'icon' => '📜',
        'h1' => '6292 sayılı Kanun 2B Arazisi & İmar Barışı Sorgulama Botu',
        'subtitle' => '2B orman vasfını yitirmiş arazilerde doğrudan satın alma hakkı, Milli Emlak rayiç bedel taksitleri ve Yapı Kayıt Belgesi güncel durum analizi.',
        'meta_title' => '6292 Sayılı 2B Hazine Arazisi Satın Alma (2026) | ParselSorgu',
        'meta_desc' => '6292 sayılı kanun 2B arazisi doğrudan satın alma şartları, Milli Emlak rayiç bedeli, peşin %20 indirim veya faizsiz 5 yıl taksit hesaplama motoru.',
        'law_code' => '6292 Sayılı 2B Kanunu & 3194 Sayılı İmar Kanunu Geçici 16. Madde',
        'category_keyword' => '2B',
        'default_area' => 1500,
        'params_type' => '2b',
        'guide_title' => '6292 Sayılı 2B Yasası ile Hazine Taşınmazlarının Satışı',
        'guide_text' => '<p>2B arazileri, 31.12.1981 tarihinden önce bilim ve fen bakımından orman niteliğini tam olarak kaybetmiş ve Hazine adına orman sınırları dışına çıkarılmış arazilerdir. 6292 sayılı Kanun kapsamında bu taşınmazları fiilen kullanan zilyetlere veya mirasçılarına rayiç bedelin %70 i üzerinden doğrudan satın alma hakkı tanınmıştır. Peşin ödemede %20 indirim veya 5 yıl (10 eşit taksit) vade imkanı mevcuttur.</p>',
        'faqs' => [
            [
                'q' => '2B arazisini satın almak için kimler başvurabilir?',
                'a' => 'Kadastro tutanaklarında veya güncelleme listelerinde zilyet (fiili kullanıcı) olarak adı geçen hak sahipleri ve bunların yasal mirasçıları Milli Emlak Müdürlüğü ne başvurabilir.'
            ],
            [
                'q' => '2B arazisi peşin alınırsa indirim yapılır mı?',
                'a' => 'Evet. Satış bedelinin tamamı peşin ödenirse belirlenen rayiç tutar üzerinden ilave %20 indirim uygulanır.'
            ],
            [
                'q' => 'Yeni bir İmar Barışı çıkacak mı?',
                'a' => 'TBMM ve ÇŞİDB nin 2026 gündeminde 3194 Geçici 16. madde benzeri genel bir af bulunmamaktadır; mevcut Yapı Kayıt Belgelerinden aykırılık içermeyenlerin güçlendirme ve ruhsatlandırma süreçleri devam etmektedir.'
            ],
            [
                'q' => '2B tapusu alındıktan sonra arsa ifraz edilebilir mi?',
                'a' => 'Müstakil tapu tescil edildikten sonra parselin bulunduğu bölgedeki imar planı ve tarım mevzuatı şartlarına göre ifraz işlemi yapılabilir.'
            ]
        ]
    ],
    'tapu-harci-hesaplama' => [
        'key' => 'tapuharci',
        'slug' => 'tapu-harci-hesaplama',
        'aliases' => ['tapuharci', 'tapu-harci', 'alim-satim-harci'],
        'title' => '2026 Tapu Harcı (%4), Döner Sermaye & Masraf Botu',
        'badge' => '492 sayılı Harçlar Kanunu',
        'icon' => '💰',
        'h1' => '2026 Tapu Harcı, Döner Sermaye & Alım Masrafı Hesaplama Botu',
        'subtitle' => 'Konut, arsa ve tarla alım-satımında %4 toplam tapu harcı (alıcı %2 + satıcı %2), 2026 döner sermaye bedeli ve ilave masrafları hesaplayın.',
        'meta_title' => '2026 Tapu Harcı Hesaplama & Döner Sermaye | ParselSorgu',
        'meta_desc' => '2026 yılı tapu harcı ne kadar? Alıcı ve satıcı %2 + %2 harç tutarı, belediye rayiç kontrolü ve güncel döner sermaye katsayılarını tek tıkla hesaplayın.',
        'law_code' => '492 Sayılı Harçlar Kanunu (4 Sayılı Tarife) & 6083 Sayılı TKGM Kanunu',
        'category_keyword' => 'Tapu Harcı',
        'default_area' => 3500000,
        'params_type' => 'tapuharci',
        'guide_title' => '2026 Tapu Harçları, Döner Sermaye ve Devir Masrafları Rehberi',
        'guide_text' => '<p>Gayrimenkul devirlerinde 492 sayılı Harçlar Kanunu gereğince gerçek satış bedeli üzerinden hem alıcıdan hem satıcıdan binde 20 (toplam %4) oranında tapu harcı tahsil edilir. Bu bedel taşınmazın belediyedeki emlak vergisi rayiç değerinden düşük olamaz. Ayrıca TKGM döner sermaye işletmesi tarafından her yıl güncellenen maktu döner sermaye bedeli ve yöresel katsayı ilave edilir.</p>',
        'faqs' => [
            [
                'q' => 'Tapu harcını kanunen kim öder?',
                'a' => '492 sayılı Kanuna göre harç alıcı ve satıcı arasında yarı yarıya (%2 alıcı, %2 satıcı) paylaşılır. Ancak taraflar sözleşmeyle harcın tamamının alıcı tarafından ödeneceğini kararlaştırabilir.'
            ],
            [
                'q' => 'Tapu harcını az ödemek için rayiç bedelden göstermenin cezası nedir?',
                'a' => 'Gelir İdaresi Başkanlığı banka transferleri ve ekspertiz raporlarıyla gerçek bedeli tespit ettiğinde, eksik ödenen harcı %25 vergi ziyaı cezası ve gecikme faizi ile birlikte tahsil eder.'
            ],
            [
                'q' => '2026 yılı döner sermaye bedeli ne kadardır?',
                'a' => 'TKGM döner sermaye bedeli her ilin gelişmişlik katsayısına göre (0.5 ile 3.0 katı arasında) değişmekte olup ortalama 2.000 TL ile 6.500 TL arasında tahsil edilir.'
            ],
            [
                'q' => 'Tapu harcı nereye ödenir?',
                'a' => 'Tapu müdürlüğünden gelen SMS teki e-Tahsilat seri numarası ile Gelir İdaresi Başkanlığı (İnteraktif Vergi Dairesi), kamu bankaları veya anlaşmalı kredi kartlarıyla online ödenebilir.'
            ]
        ]
    ],
    'tiny-house-imar' => [
        'key' => 'tinyhouse',
        'slug' => 'tiny-house-imar',
        'aliases' => ['tinyhouse', 'tiny-house', 'bungalov-imar'],
        'title' => 'Tiny House, Prefabrik & Bungalov Tarla İmar İzin Botu',
        'badge' => 'O2 Tip Onay Belgesi & 3194 s.K.',
        'icon' => '🏡',
        'h1' => 'Tiny House, Prefabrik & Bungalov Tarla İmar İzin Botu',
        'subtitle' => 'Tarlaya, zeytinliğe veya sit alanına tekerlekli ev ya da bungalov konur mu? 3194 s.K. 32-42. madde yıkım ve para cezası riskini test edin.',
        'meta_title' => 'Tarlaya Tiny House Konur mu? İmar Para Cezası (2026) | ParselSorgu',
        'meta_desc' => 'Tarlaya ve zeytinliğe tekerlekli tiny house konulması yasal mı? O2 karavan ruhsatı, beton zemin yasağı, foseptik şartı ve belediye ceza risk analizi.',
        'law_code' => 'Karayolları Trafik Yönetmeliği O2 Belgesi & 3194 Sayılı İmar Kanunu',
        'category_keyword' => 'Tiny House',
        'default_area' => 1,
        'params_type' => 'tinyhouse',
        'guide_title' => 'Tarlada Tiny House ve Prefabrik Yapıların Hukuki Statüsü',
        'guide_text' => '<p>Plakalı, ruhsatlı ve O2 Tip Onay Belgesine sahip tekerlekli Tiny House lar Karayolları Trafik Kanununa göre <strong>Römork / Çekme Karavan</strong> niteliğindedir. Ancak altına beton dökülmesi, verandaya sabitlenmesi, şebeke elektriği ve fosseptik bağlanması halinde Danıştay kararları uyarınca "İmar Kanununa Tabi Yapı" kabul edilir ve ruhsatsız yapı muamelesiyle yıkım ve ceza uygulanır.</p>',
        'faqs' => [
            [
                'q' => 'Tarlaya tekerlekli Tiny House koymak için belediyeden izin gerekir mi?',
                'a' => 'Araç niteliğini koruyan (tekerlekleri üzerinde, çekilebilir, zemine sabitlenmemiş) plakalı araçlar için imar izni gerekmez. Ancak tarımsal niteliği bozucu çevre düzenlemesi yapılırsa Tarım İl Müdürlüğü ve Belediye ceza kesebilir.'
            ],
            [
                'q' => 'Zeytinliğe veya sit alanına Tiny House konulabilir mi?',
                'a' => '3573 sayılı Zeytincilik Kanunu ve 2863 sayılı Tabiat Varlıklarını Koruma Kanunu uyarınca zeytinliklere ve I./II. Derece doğal sit alanlarına kalıcı veya geçici araç ve yapı konulması kesinlikle yasaktır.'
            ],
            [
                'q' => 'Tiny House için elektrik ve su aboneliği nasıl alınır?',
                'a' => 'Yapı ruhsatı olmayan taşınmazlarda şebeke aboneliği verilmez. Bu nedenle güneş paneli (off-grid GES) ve su deposu kullanılmalı, atık su için sızdırmaz taşınabilir fosseptik tankı tercih edilmelidir.'
            ],
            [
                'q' => 'Tarlaya beton platform dökülürse ne olur?',
                'a' => 'Beton zemin döküldüğü anda yapı 3194 İmar Kanununa tabi olur; belediye zabıtası tarafından mühürlenir, 32. maddeye göre yıkım ve 42. maddeye göre ağır para cezası uygulanır.'
            ]
        ]
    ],
    'taks-kaks-emsal' => [
        'key' => 'takskaks',
        'slug' => 'taks-kaks-emsal',
        'aliases' => ['takskaks', 'taks-kaks', 'emsal-hesaplama'],
        'title' => 'TAKS KAKS Hesaplama 2026 | Arsa İnşaat Emsal ve Kat Alanı Hesaplama Aracı',
        'badge' => 'Planlı Alanlar İmar Yönetmeliği',
        'icon' => '📐',
        'h1' => 'TAKS KAKS Hesaplama & İnşaat Emsal Alanı Simülatörü',
        'subtitle' => 'Arsanıza ne kadar inşaat yapabilirsiniz? Taban Alanı Katsayısı (TAKS), Kat Alanı Kat Sayısı (KAKS), bina oturumu ve emsal harici alan kazancını hesaplayın.',
        'meta_title' => 'TAKS KAKS Emsal Hesabı – Arsaya Kaç m² Yapılır? | ParselSorgu',
        'meta_desc' => 'Arsa TAKS KAKS hesaplama nasıl yapılır? Arsa m², emsal katsayısı, toplam kapalı inşaat alanı, taban alanı ve kat adedi formülü anında hesaplayın.',
        'law_code' => 'Planlı Alanlar İmar Yönetmeliği Madde 5, 20 ve 22',
        'category_keyword' => 'TAKS KAKS',
        'default_area' => 800,
        'params_type' => 'takskaks',
        'guide_title' => 'İmar Çapında TAKS, KAKS ve Emsal Hesaplama Formülleri',
        'guide_text' => '<p><strong>TAKS (Taban Alanı Kat Sayısı):</strong> Binanın parsel üzerinde oturacağı maksimum taban alanının parsel yüzölçümüne oranıdır (Genellikle 0.20 - 0.40 arası). <strong>KAKS (Emsal):</strong> Parsel üzerine yapılabilecek toplam net inşaat alanını belirleyen çarpandır (Örn. KAKS 1.50 ise 1.000 m² arsaya 1.500 m² emsale dahil inşaat yapılabilir). Otopark, yangın merdiveni, sığınak gibi alanlar %30 oranında emsal dışı tutulur.</p>',
        'faqs' => [
            [
                'q' => 'TAKS ve KAKS nedir, emsal nasıl hesaplanır?',
                'a' => 'TAKS (Taban Alanı Kat Sayısı), binanın arsa tabanına oturabileceği azami alanı; KAKS (Kat Alanı Kat Sayısı veya Emsal) ise arsa üzerinde inşa edilebilecek toplam brüt kapalı inşaat alanını belirler. Örneğin 1.000 m² bir arsada TAKS: 0.30 ise taban alanı maks 300 m²; KAKS: 1.50 ise toplam inşaat alanı en fazla 1.500 m² olabilir.'
            ],
            [
                'q' => 'KAKS ve Emsal aynı şey midir?',
                'a' => 'Evet. İmar hukukunda ve belediye çap belgelerinde KAKS ile Emsal terimleri aynı anlama gelir ve toplam satılabilir / net inşaat alanını ifade eder.'
            ],
            [
                'q' => 'Emsal dışı alanlar (%30 fazlalık) neleri kapsar?',
                'a' => 'Planlı Alanlar İmar Yönetmeliğine göre yangın merdiveni, asansör boşluğu, zorunlu sığınak, otopark alanları ve açık balkonların belirli bir kısmı toplam emsal alanının %30 unu aşmamak kaydıyla emsal hesabına katılmaz.'
            ],
            [
                'q' => 'İmar çapı nereden alınır?',
                'a' => 'İmar çapı (İmar Durum Belgesi), arsa sahibinin tapu fotokopisi ve aplikasyon krokisiyle ilgili ilçe belediyesi İmar ve Şehircilik Müdürlüğü ne başvurması ile alınır.'
            ],
            [
                'q' => 'Bahçe mesafeleri (çekme mesafesi) inşaat tabanını kısıtlar mı?',
                'a' => 'Evet. Yönetmeliğe göre yoldan en az 5 metre, komşu parsellerden ise en az 3 metre (4 kattan sonra her kat için 0.5m ilave) çekme mesafesi bırakılmak zorundadır.'
            ]
        ]
    ],
    'hisseli-tapu-sufa' => [
        'key' => 'sufa',
        'slug' => 'hisseli-tapu-sufa',
        'aliases' => ['sufa', 'hisseli-tapu', 'on-alim-davasi'],
        'title' => 'Hisseli Tapu, Şufa (Ön Alım) Davası & Süre Botu',
        'badge' => 'TMK Madde 732, 733, 734',
        'icon' => '🚜',
        'h1' => 'Hisseli Tapu Şufa (Ön Alım) Hakkı & Dava Süresi Hesaplama Botu',
        'subtitle' => 'Hisseli taşınmaz satışında diğer hissedarların 3 aylık ve 2 yıllık yasal önalım (şufa) hak düşürücü sürelerini ve bedelde muvazaa riskini hesaplayın.',
        'meta_title' => 'Hisseli Tapu Şufa (Ön Alım) Hakkı 90 Gün (2026) | ParselSorgu',
        'meta_desc' => 'Hisseli tapuda şufa (önalım) hakkı nasıl kullanılır? 3 aylık noter ihtarı ve 2 yıllık kesin hak düşürücü süre hesabı ile hisse geri alım analizi.',
        'law_code' => '4721 Sayılı Türk Medeni Kanunu Madde 732, 733 ve 734',
        'category_keyword' => 'Şufa',
        'default_area' => 1500000,
        'params_type' => 'sufa',
        'guide_title' => 'TMK 732 Kapsamında Yasal Önalım (Şufa) Hakkı ve Süreleri',
        'guide_text' => '<p>Paylı mülkiyette bir paydaşın taşınmaz üzerindeki hissesini tamamen veya kısmen üçüncü bir kişiye satması halinde, diğer paydaşlar <strong>yasal önalım (şufa) hakkına</strong> sahiptir. Satışın alıcı veya satıcı tarafından noter kanalıyla diğer paydaşlara bildirilmesinden itibaren <strong>3 ay</strong>, bildirim yapılmamışsa satış tarihinden itibaren <strong>2 yıl</strong> içinde dava açılmalıdır. Süreler kesin hak düşürücü süredir.</p>',
        'faqs' => [
            [
                'q' => 'Şufa davası açıldığında pay hangi bedelle satın alınır?',
                'a' => 'Kural olarak tapuda gösterilen resmi satış bedeli + alıcının ödediği tapu harcı ve döner sermaye bedeli mahkeme veznesine depo edilir. Ancak alıcı bedelde muvazaa (düşük gösterme) yapılmışsa gerçek bedeli ispatlayabilir.'
            ],
            [
                'q' => 'Hisseli tapu satışı noterden ihtar edilmezse ne olur?',
                'a' => 'Satış noter ihtarıyla tebliğ edilmezse 3 aylık kısa süre işlemez; diğer paydaşlar satış tarihinden itibaren 2 yıl boyunca diledikleri zaman dava açabilir.'
            ],
            [
                'q' => 'Fiilen taksim edilmiş (ayrılmış) arazide şufa hakkı kullanılabilir mi?',
                'a' => 'Yargıtay Hukuk Genel Kurulu yerleşik içtihatlarına göre, hissedarlar arasında fiili taksim yapılmış ve herkes kendi yerini kullanıyorsa dürüstlük kuralı gereğince şufa davası açılamaz.'
            ],
            [
                'q' => 'Hissedar payını başka bir hissedara satarsa şufa hakkı doğar mı?',
                'a' => 'Hayır. Şufa hakkı yalnızca payın dışarıdan üçüncü kişilere (yabancıya) satılması halinde doğar; paydaşların birbirine satışında diğer hissedarların şufa hakkı yoktur.'
            ]
        ]
    ],
    'madde-18-dop' => [
        'key' => 'madde18',
        'slug' => 'madde-18-dop',
        'aliases' => ['madde18', 'madde-18', 'dop-kesintisi'],
        'title' => '18. Madde DOP Hesabı 2026 | 3194 İmar Kanunu Düzenleme Ortaklık Payı Kesintisi',
        'badge' => '3194 Sayılı İmar Kanunu Madde 18',
        'icon' => '⚖️',
        'h1' => '18. Madde DOP Hesabı & Düzenleme Ortaklık Payı Simülatörü',
        'subtitle' => 'Ham kadastro parselinden belediyenin kesebileceği yasal azami %45 Düzenleme Ortaklık Payı (DOP) terkini ve elinizde kalacak net imar arsasını hesaplayın.',
        'meta_title' => '18. Madde İmar DOP Kesintisi Hesaplama (2026) | ParselSorgu',
        'meta_desc' => '3194 sayılı Kanun 18. madde imar uygulaması DOP kesintisi: Azami %45 kamu terki, ham kadastrodan net imar parseline geçiş ve KOP hisse analizi.',
        'law_code' => '3194 Sayılı İmar Kanunu Madde 18 & Arazi ve Arsa Düzenlemeleri Yönetmeliği',
        'category_keyword' => 'Madde 18',
        'default_area' => 4500,
        'params_type' => 'madde18',
        'guide_title' => '3194 Sayılı İmar Kanunu 18. Madde İmar Parselasyonu ve DOP',
        'guide_text' => '<p>Belediyeler imar sınırları içindeki ham kadastro arazilerini parselasyon planıyla imar adalarına dönüştürürken yol, meydan, park, otopark, çocuk bahçesi, yeşil saha, ibadet yeri ve karakol gibi kamu hizmetleri için arazilerden bedelsiz <strong>Düzenleme Ortaklık Payı (DOP)</strong> kesintisi yapar. 7181 sayılı kanun değişikliği ile yasal azami DOP kesinti tavanı <strong>%45</strong> olarak belirlenmiştir.</p>',
        'faqs' => [
            [
                'q' => 'Belediye DOP oranını %45 in üzerinde uygulayabilir mi?',
                'a' => 'Hayır. 3194 sayılı kanunun 18. maddesi gereğince DOP oranı hiçbir surette %45 i geçemez. Kamu hizmet alanları için %45 yetersiz kalırsa belediye kalan kısmı kamulaştırmak zorundadır.'
            ],
            [
                'q' => 'Daha önce yola terk yapılmış parselden tekrar DOP kesilir mi?',
                'a' => 'Daha önce rızaen veya parselasyonla yola terk yapılmış parsellerde, önceki terk oranı %45 e tamamlanacak kadar fark kesilebilir; mükerrer ve haksız kesinti yapılamaz.'
            ],
            [
                'q' => '18. Madde uygulamasına karşı nasıl itiraz edilir?',
                'a' => 'Parselasyon planı belediyede 30 gün süreyle askıya çıkarılır. Bu sürede belediyeye yazılı itiraz edilmeli; itiraz reddedilirse 60 gün içinde İdare Mahkemesinde yürütmeyi durdurma ve iptal davası açılmalıdır.'
            ],
            [
                'q' => 'DOP kesintisinden sonra hisseli imar tapusu çıkar mı?',
                'a' => 'İmar adasındaki parsel büyüklükleri ve DOP sonrası alan gereği belediye mümkün olduğunca müstakil imar parseli verir; ancak alan yetmezse aynı adada komşu ile hisseli tapu tescil edilebilir.'
            ]
        ]
    ],
    'zeytinlik-imar-ifraz' => [
        'key' => 'zeytinlik',
        'slug' => 'zeytinlik-imar-ifraz',
        'aliases' => ['zeytinlik', 'zeytinlik-imar', '3573-zeytin'],
        'title' => '3573 sayılı Zeytincilik Kanunu & Zeytinlik İmar / İfraz Botu',
        'badge' => '3573 sayılı Zeytincilik Kanunu',
        'icon' => '🫒',
        'h1' => '3573 Sayılı Zeytincilik Kanunu & Zeytinlik İmar / İfraz Botu',
        'subtitle' => 'Zeytinliğe ev veya bağ evi yapılır mı? Zeytinlik tarlalar kaç dekardan küçükse bölünemez? 3 km mesafe ve zeytin ağacı koruma şartlarını hesaplayın.',
        'meta_title' => '3573 Zeytinlik İmar Durumu & 25 Dönüm İfraz | ParselSorgu',
        'meta_desc' => 'Zeytinliğe ev yapılır mı? 3573 sayılı Zeytinciliğin Islahı Kanunu: 5 dekar bölünemez sınır, zeytin sahasına 3 km sanayi yasağı ve ziraat izin şartları.',
        'law_code' => '3573 Sayılı Zeytinciliğin Islahı ve Yabanilerinin Aşılattırılması Hakkında Kanun',
        'category_keyword' => 'Zeytinlik',
        'default_area' => 8500,
        'params_type' => 'zeytinlik',
        'guide_title' => '3573 Sayılı Zeytincilik Kanunu Kapsamında Yapılaşma ve İfraz Esasları',
        'guide_text' => '<p>3573 sayılı Kanunun 20. maddesi uyarınca zeytinlik sahalarında ve bu sahalara en az <strong>3 kilometre mesafede</strong> zeytinyağı fabrikaları hariç toz ve duman çıkaran hiçbir sanayi veya konut tesisi yapılamaz. Zeytinlik arazileri 5403 s.K. dikili tarım arazisi statüsünde olup 5 dekardan (5.000 m²) küçük parçalara bölünemez. Yalnızca tarımsal amaçlı depo/bağ evi için Tarım İl Müdürlüğü nden özel zeytin kesim izni alınması şarttır.</p>',
        'faqs' => [
            [
                'q' => 'Zeytinlik vasfındaki tapuya ev yapılabilir mi?',
                'a' => 'Zeytinlik vasıflı parsellere kural olarak konut inşa edilemez. Ancak 5.000 m² den büyük ve kadastro yolu olan parsellerde, zeytin ağaçlarına zarar vermemek ve Tarım İl Müdürlüğü onayını almak şartıyla zeytin sıkma/depo gibi tarımsal tesis yapılabilir.'
            ],
            [
                'q' => 'Zeytin ağaçları izinsiz kesilebilir veya sökülebilir mi?',
                'a' => 'Kesinlikle hayır. 3573 sayılı Kanuna göre izinsiz zeytin ağacı kesmek, sökmek veya budamak ağır idari para cezası ve Türk Ceza Kanunu kapsamında adli işlem gerektirir.'
            ],
            [
                'q' => 'Zeytinlik mirasta kardeşler arasında nasıl paylaşılır?',
                'a' => '5403 sayılı Kanun uyarınca zeytinliklerde asgari bölünemez parsel büyüklüğü 5.000 m² dir. Hisse başına 5.000 m² den az düşüyorsa müstakil tapu ifrazı yapılamaz, paylı intikal edilir.'
            ],
            [
                'q' => 'Zeytinlik vasfı tarlaya veya arsaya dönüştürülebilir mi?',
                'a' => 'Zeytinlik vasfı Tarım ve Orman Bakanlığı nın çok sıkı denetimi altındadır; arazide zeytin ağaçları bulunduğu sürece vasıf değişikliği yapılması kanunen mümkün değildir.'
            ]
        ]
    ],
    'sit-alani-imar' => [
        'key' => 'sitalani',
        'slug' => 'sit-alani-imar',
        'aliases' => ['sitalani', 'sit-alani', '2863-sit'],
        'title' => '2863 Doğal & Arkeolojik Sit Alanı İmar Durumu & Trampa Botu',
        'badge' => '2863 sayılı Kültür ve Tabiat Varlıkları',
        'icon' => '🏛️',
        'h1' => '2863 Sit Alanı İmar Durumu & Hazine Trampa (Takas) Botu',
        'subtitle' => '1. 2. ve 3. Derece Arkeolojik & Doğal Sit alanlarında yapılaşma şartları, Koruma Kurulu izinleri ve Hazine arazisi ile takas (trampa) hakkı sorgulama.',
        'meta_title' => '2863 Sit Alanı İmar Durumu & Hazine Trampa (2026) | ParselSorgu',
        'meta_desc' => 'Sit alanındaki arsaya çivi çakılır mı? 1. 2. ve 3. Derece Doğal ve Arkeolojik sit kısıtlamaları, Koruma Amaçlı İmar Planı ve Hazine arazisi trampa hesaplama.',
        'law_code' => '2863 Sayılı Kültür ve Tabiat Varlıklarını Koruma Kanunu',
        'category_keyword' => 'Sit Alanı',
        'default_area' => 2500,
        'params_type' => 'sitalani',
        'guide_title' => '2863 Sayılı Kanun Kapsamında Sit Dereceleri ve Trampa Esasları',
        'guide_text' => '<p><strong>I. Derece Sit:</strong> Kesin korunacak hassas alanlardır; bilimsel kazı hariç hiçbir yapılaşmaya izin verilmez. <strong>II. Derece Sit:</strong> Koruma Amaçlı İmar Planı doğrultusunda nitelikli koruma alanıdır. <strong>III. Derece Sit:</strong> Koruma Bölge Kurulu onaylı projelere uygun olarak düşük yoğunluklu yapılaşmaya açılabilir. I. ve II. derece sit alanında kalan özel mülkiyetli taşınmazlar için Hazine arazisi ile takas (trampa) başvuru hakkı mevcuttur.</p>',
        'faqs' => [
            [
                'q' => 'Sit alanında kalan taşınmaz Hazine ile nasıl takas edilir (Trampa)?',
                'a' => 'I. derece arkeolojik veya doğal sit alanında kalan ve kesin yapı yasağı getirilen tapulu arazilerin malikleri, Kültür ve Turizm Bakanlığı ile ÇŞİDB ye başvurarak arazilerini eşdeğer bir Hazine taşınmazı ile trampa edebilir.'
            ],
            [
                'q' => 'Sit alanında Koruma Kurulu izni olmadan tamirat veya tadilat yapılabilir mi?',
                'a' => 'Hayır. 2863 sayılı kanun uyarınca tescilli yapılarda ve sit alanlarında basit onarım için KUDEB den, esaslı tadilat ve inşai faaliyetler için Koruma Bölge Kurulu ndan izin alınması zorunludur. Aksi halde 2 yıldan 5 yıla kadar hapis cezası uygulanır.'
            ],
            [
                'q' => 'Doğal Sit alanı ile Arkeolojik Sit arasındaki fark nedir?',
                'a' => 'Arkeolojik sit alanları Kültür ve Turizm Bakanlığı Koruma Kurulları yetkisindedir; Doğal sit alanları (Kesin Korunacak Hassas Alan, Nitelikli Doğal Koruma Alanı) ise ÇŞİDB Tabiat Varlıklarını Koruma Genel Müdürlüğü yetkisindedir.'
            ],
            [
                'q' => 'Sit alanındaki arazinin emlak vergisi muafiyeti var mıdır?',
                'a' => 'Evet. 2863 sayılı Kanun ve 1319 sayılı Emlak Vergisi Kanunu gereğince I. ve II. derece sit alanında bulunan ve üzerinde yapılaşma yasağı olan parseller emlak vergisinden tamamen muaftır.'
            ]
        ]
    ],
    'deger-artis-kazanci' => [
        'key' => 'degerartis',
        'slug' => 'deger-artis-kazanci',
        'aliases' => ['degerartis', 'deger-artisi', '5-yil-kurali'],
        'title' => '5 Yıl Kuralı: Gayrimenkul Değer Artış Kazancı & Vergi Botu',
        'badge' => '193 sayılı Gelir Vergisi Mük. Madde 80',
        'icon' => '📈',
        'h1' => '5 Yıl Kuralı Gayrimenkul Değer Artış Kazancı Vergisi Botu',
        'subtitle' => 'Evinizi veya arsanızı 5 yıl dolmadan satarsanız ne kadar vergi ödersiniz? Yİ-ÜFE enflasyon endekslemesi, istisna tutarı ve gelir vergisi hesabı.',
        'meta_title' => '5 Yıl Kuralı Gayrimenkul Değer Artış Vergisi (2026) | ParselSorgu',
        'meta_desc' => '5 yıl dolmadan satılan ev ve arsanın gelir vergisi hesabı: Yİ-ÜFE enflasyon endeksleme formülü, 2026 istisna tutarı ve vergi dilimi hesaplama motoru.',
        'law_code' => '193 Sayılı Gelir Vergisi Kanunu Mükerrer Madde 80/6 ve 81',
        'category_keyword' => 'Değer Artış Kazancı',
        'default_area' => 1500000,
        'params_type' => 'degerartis',
        'guide_title' => 'Gayrimenkul Satışında 5 Yıl Kuralı ve Değer Artış Kazancı Rehberi',
        'guide_text' => '<p>193 sayılı Gelir Vergisi Kanununun mükerrer 80. maddesi uyarınca, bedel karşılığı iktisap edilen konut, arsa, tarla ve işyerlerinin iktisap (satın alma) tarihinden itibaren <strong>5 yıl (60 ay)</strong> içinde elden çıkarılmasından doğan kazançlar <strong>Değer Artışı Kazancı</strong> olarak vergiye tabidir. Alış bedeli satış ayından bir önceki ayın TÜİK Yurt İçi Üretici Fiyat Endeksi (Yİ-ÜFE) ile endekslenerek enflasyondan arındırılır ve yıllık istisna tutarı düşüldükten sonra artan oranlı gelir vergisi (%15 - %40) hesaplanır.</p>',
        'faqs' => [
            [
                'q' => 'Miras veya bağış yoluyla kalan gayrimenkulde 5 yıl kuralı geçerli midir?',
                'a' => 'Hayır! İvazsız (karşılıksız) yolla, yani miras veya hibe (bağış) yoluyla edinilen taşınmazlar ne zaman satılırsa satılsın değer artış kazancı vergisine tabi değildir. 5 yıllık süre aranmaz.'
            ],
            [
                'q' => '5 yıl tam olarak nasıl hesaplanır?',
                'a' => 'Tapudaki tescil tarihinden gün/ay/yıl olarak 5 tam yılın dolması gerekir. Örneğin 15 Mart 2021 tarihinde alınan bir konut 16 Mart 2026 tarihinde satılırsa vergi doğmaz; ancak 14 Mart 2026 da satılırsa vergiye tabi olur.'
            ],
            [
                'q' => 'Enflasyon (Yİ-ÜFE) endekslemesi ne zaman uygulanır?',
                'a' => 'Satın alma ve satış arasındaki Yİ-ÜFE artış oranı en az %10 ise alış bedeli bu katsayı ile artırılarak reel kâr tespit edilir. Böylece mükellef enflasyondan kaynaklanan fiktif artışın vergisini ödemez.'
            ],
            [
                'q' => 'Değer artış kazancı beyannamesi ne zaman verilir?',
                'a' => 'Taşınmazın satıldığı yılı takip eden yılın Mart ayının 1 inci gününden son gününe kadar Gelir İdaresi Başkanlığı nın Hazır Beyan Sistemi üzerinden beyan edilir ve iki eşit taksitte (Mart ve Temmuz) ödenir.'
            ]
        ]
    ],
    'parsel-tevhid-birlestirme' => [
        'key' => 'tevhid',
        'slug' => 'parsel-tevhid-birlestirme',
        'aliases' => ['tevhid', 'parsel-tevhid', 'parsel-birlestirme'],
        'title' => '3194 Parsel Tevhid (Birleştirme) & Emsal Teşvik Bonusu Botu',
        'badge' => '3194 s.K. Madde 15-16 & Planlı Alanlar',
        'icon' => '🧩',
        'h1' => '3194 Parsel Tevhid (Birleştirme) & Emsal Bonusu Botu',
        'subtitle' => 'Komşu parselleri birleştirerek daha büyük imar hakkı kazanabilir misiniz? Tevhid şartları, encümen onay süreçleri ve imar yönetmeliği emsal teşvik bonusları.',
        'meta_title' => '3194 Parsel Tevhid (Birleştirme) & Emsal Bonusu | ParselSorgu',
        'meta_desc' => 'Komşu arsa birleştirme (tevhid) nasıl yapılır? 3194 s.K. 15-16. madde tevhid şartları, belediye encümen harçları ve +%15 emsal artış bonusu hesaplama.',
        'law_code' => '3194 Sayılı İmar Kanunu Madde 15-16 & Planlı Alanlar İmar Yönetmeliği',
        'category_keyword' => 'Tevhid',
        'default_area' => 600,
        'params_type' => 'tevhid',
        'guide_title' => 'Parsel Tevhid (Birleştirme) İşlemleri ve İmar Teşvik Avantajları',
        'guide_text' => '<p>Tevhid, tapu kütüğünde ayrı kayıtlı olan birbirine bitişik iki veya daha fazla parselin tek bir imar parseli haline getirilmesidir. Planlı Alanlar İmar Yönetmeliğine göre parsellerin birleştirilmesiyle ada bazında veya belirli metrekare büyüklüklerini aşan yeni parsellere belediyelerce <strong>+%10 ile +%25 arasında ilave emsal teşviki</strong> (inşaat alanı bonusu) verilebilir. Harita mühendislerince hazırlanan birleştirme krokisi belediye encümenince onaylanır.</p>',
        'faqs' => [
            [
                'q' => 'Farklı kişilere ait komşu parseller birleştirilebilir mi?',
                'a' => 'Evet. Parsel maliklerinin tamamının noterden muvafakati veya bizzat tapuda imzasıyla iki farklı kişiye ait arsalar tevhid edilerek müşterek (hisseli) tek bir parsel oluşturulabilir.'
            ],
            [
                'q' => 'Üzerinde ipotek veya haciz olan parsel tevhid edilebilir mi?',
                'a' => 'Parsel üzerinde rehin, ipotek veya haciz varsa, alacaklı kurumun (banka, icra dairesi vb.) tevhid işlemine resmi muvafakat vermesi şarttır.'
            ],
            [
                'q' => 'Tevhid ile parsel büyüyünce kat sayısı veya emsal artar mı?',
                'a' => 'Birçok büyükşehir imar yönetmeliğinde parsel genişliği ve alanı büyüdükçe taban oturumu esnekleşir ve belirli m² barajları aşıldığında (örn. 1.000 m² veya 2.000 m² üzeri) emsal bonusu uygulanır.'
            ],
            [
                'q' => 'Tevhid işlemi ne kadar sürede sonuçlanır?',
                'a' => 'Serbest Harita Mühendisinin dosyayı hazırlaması, Kadastro kontrolü, Belediye Encümen Kararı ve Tapu tescili ortalama 2 ile 4 hafta arasında tamamlanır.'
            ]
        ]
    ]
];

// 2. RESOLVE REQUESTED BOT SLUG, CITY & DISTRICT (DYNAMIC GEO-TARGETING)
$raw_slug = isset($_GET['slug']) ? trim($_GET['slug']) : '';
$req_city = isset($_GET['city']) ? trim($_GET['city']) : '';
$req_district = isset($_GET['district']) ? trim($_GET['district']) : '';

$bot = null;
if (!empty($raw_slug) && isset($BOTS[$raw_slug])) {
    $bot = $BOTS[$raw_slug];
} else {
    foreach ($BOTS as $b_slug => $b_data) {
        if ($raw_slug === $b_data['key'] || in_array($raw_slug, $b_data['aliases'])) {
            $bot = $b_data;
            break;
        }
    }
}
if (!$bot) {
    $bot = $BOTS['koy-evi-imar'];
}

// Helper: Slugify Turkish strings
function bot_tr_slugify($str) {
    $str = (string)$str;
    $find = ['ç', 'Ç', 'ğ', 'Ğ', 'ı', 'I', 'İ', 'i', 'ö', 'Ö', 'ş', 'Ş', 'ü', 'Ü'];
    $repl = ['c', 'c', 'g', 'g', 'i', 'i', 'i', 'i', 'o', 'o', 's', 's', 'u', 'u'];
    $str = str_replace($find, $repl, $str);
    $str = mb_strtolower($str, 'UTF-8');
    return strtolower(trim(preg_replace('/[^a-z0-9]+/', '-', $str), '-'));
}

// Load Administrative Turkey Data (Provinces & Districts)
$turkey_geo_file = __DIR__ . '/data/turkey_administrative_complete.json';
$turkey_geo = [];
if (file_exists($turkey_geo_file)) {
    $turkey_geo = @json_decode(file_get_contents($turkey_geo_file), true) ?: [];
}

$selected_city = '';
$selected_district = '';

// Match requested city slug
if (!empty($req_city)) {
    $clean_req_city = bot_tr_slugify($req_city);
    foreach ($turkey_geo as $c_name => $districts_arr) {
        if (bot_tr_slugify($c_name) === $clean_req_city) {
            $selected_city = $c_name;
            // Match requested district slug
            if (!empty($req_district)) {
                $clean_req_dist = bot_tr_slugify($req_district);
                if (is_array($districts_arr)) {
                    foreach (array_keys($districts_arr) as $d_name) {
                        if (bot_tr_slugify($d_name) === $clean_req_dist) {
                            $selected_district = $d_name;
                            break;
                        }
                    }
                }
            }
            break;
        }
    }
}

// Compute Dynamic SEO Tags, H1 & Canonical URL
$page_meta_title = $bot['meta_title'];
$page_meta_desc  = $bot['meta_desc'];
$page_h1         = $bot['h1'];
$page_badge      = $bot['badge'];
$bot_custom_routes = [
    'koy-evi-imar' => '/tarlaya-ev-yapilir-mi',
    'tarla-ifraz-bolunme' => '/5403-tarla-ifraz',
    'taks-kaks-emsal' => '/taks-kaks-hesaplama'
];
$base_bot_route = $bot_custom_routes[$bot['slug']] ?? ('/bot/' . $bot['slug']);
$canonical_url   = $site_domain . $base_bot_route;

if (!empty($selected_city) && !empty($selected_district)) {
    $loc_label = "{$selected_city} {$selected_district}";
    $page_meta_title = "{$loc_label} " . $bot['h1'] . " (2026) | ParselSorgu";
    $page_meta_desc  = "{$selected_city} ili {$selected_district} ilçesi için " . mb_strtolower($bot['h1'], 'UTF-8') . " hesaplaması, 2026 yasal mevzuat sınırları ve resmi başvuru rehberi.";
    $page_h1         = "{$loc_label} " . $bot['h1'];
    $page_badge      = "📍 {$loc_label} Özel Analiz";
    $canonical_url   = $site_domain . '/bot/' . $bot['slug'] . '/' . bot_tr_slugify($selected_city) . '/' . bot_tr_slugify($selected_district);
} elseif (!empty($selected_city)) {
    $loc_label = "{$selected_city}";
    $page_meta_title = "{$loc_label} " . $bot['h1'] . " (2026) | ParselSorgu";
    $page_meta_desc  = "{$selected_city} geneli için " . mb_strtolower($bot['h1'], 'UTF-8') . " hesaplaması, 2026 yasal mevzuat sınırları ve resmi ilçe başvuru şartları.";
    $page_h1         = "{$loc_label} " . $bot['h1'];
    $page_badge      = "📍 {$loc_label} İl Geneli Analiz";
    $canonical_url   = $site_domain . '/bot/' . $bot['slug'] . '/' . bot_tr_slugify($selected_city);
}

// 3. FETCH RELATED ARTICLES FROM DB (LIGHTNING FAST INDEX SCAN)
$related_articles = [];
if ($pdo) {
    try {
        $stmt = $pdo->query("SELECT id, title, slug, summary, category, city, district, read_time FROM blog_articles ORDER BY id DESC LIMIT 30");
        $all_recent = $stmt->fetchAll();
        $filtered = [];
        $target_kw = mb_strtolower($bot['category_keyword'], 'UTF-8');
        foreach ($all_recent as $art) {
            $combined = mb_strtolower(($art['category'] ?? '') . ' ' . ($art['title'] ?? ''), 'UTF-8');
            if (mb_strpos($combined, $target_kw) !== false) {
                $filtered[] = $art;
                if (count($filtered) >= 4) break;
            }
        }
        if (count($filtered) < 4) {
            foreach ($all_recent as $art) {
                if (!in_array($art, $filtered)) {
                    $filtered[] = $art;
                    if (count($filtered) >= 4) break;
                }
            }
        }
        $related_articles = $filtered;
    } catch (Exception $e) {
        $related_articles = [];
    }
}

// 4. PREPARE JSON-LD SCHEMAS
$faq_schema_items = [];
foreach ($bot['faqs'] as $faq) {
    $faq_schema_items[] = [
        "@type" => "Question",
        "name" => $faq['q'],
        "acceptedAnswer" => [
            "@type" => "Answer",
            "text" => $faq['a']
        ]
    ];
}

$web_app_schema = [
    "@context" => "https://schema.org",
    "@type" => "WebApplication",
    "name" => $bot['title'],
    "applicationCategory" => "BusinessApplication",
    "operatingSystem" => "All",
    "offers" => [
        "@type" => "Offer",
        "price" => "0",
        "priceCurrency" => "TRY"
    ],
    "description" => $bot['meta_desc'],
    "url" => $canonical_url,
    "provider" => [
        "@type" => "Organization",
        "name" => "Ant Harita Mühendislik",
        "url" => $site_domain
    ]
];

$faq_schema = [
    "@context" => "https://schema.org",
    "@type" => "FAQPage",
    "mainEntity" => $faq_schema_items
];

$breadcrumb_schema = [
    "@context" => "https://schema.org",
    "@type" => "BreadcrumbList",
    "itemListElement" => [
        [
            "@type" => "ListItem",
            "position" => 1,
            "name" => "Ana Sayfa",
            "item" => $site_domain . "/"
        ],
        [
            "@type" => "ListItem",
            "position" => 2,
            "name" => "İmar & Kadastro Botları",
            "item" => $site_domain . "/#tab-botlar"
        ],
        [
            "@type" => "ListItem",
            "position" => 3,
            "name" => $bot['title'],
            "item" => $canonical_url
        ]
    ]
];

// 81 PROVINCES LIST
$PROVINCES = [
    "Adana", "Adıyaman", "Afyonkarahisar", "Ağrı", "Aksaray", "Amasya", "Ankara", "Antalya", "Ardahan", "Artvin",
    "Aydın", "Balıkesir", "Bartın", "Batman", "Bayburt", "Bilecik", "Bingöl", "Bitlis", "Bolu", "Burdur",
    "Bursa", "Çanakkale", "Çankırı", "Çorum", "Denizli", "Diyarbakır", "Düzce", "Edirne", "Elazığ", "Erzincan",
    "Erzurum", "Eskişehir", "Gaziantep", "Giresun", "Gümüşhane", "Hakkari", "Hatay", "Iğdır", "Isparta", "İstanbul",
    "İzmir", "Kahramanmaraş", "Karabük", "Karaman", "Kars", "Kastamonu", "Kayseri", "Kilis", "Kırıkkale", "Kırklareli",
    "Kırşehir", "Kocaeli", "Konya", "Kütahya", "Malatya", "Manisa", "Mardin", "Mersin", "Muğla", "Muş",
    "Nevşehir", "Niğde", "Ordu", "Osmaniye", "Rize", "Sakarya", "Samsun", "Şanlıurfa", "Siirt", "Sinop",
    "Sivas", "Şırnak", "Tekirdağ", "Tokat", "Trabzon", "Tunceli", "Uşak", "Van", "Yalova", "Yozgat", "Zonguldak"
];

$POPULAR_HUBS = ["İstanbul", "Ankara", "İzmir", "Antalya", "Bursa", "Muğla", "Balıkesir", "Çanakkale", "Aydın", "Kocaeli", "Tekirdağ", "Konya"];
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title><?= htmlspecialchars($page_meta_title) ?></title>
    <meta name="description" content="<?= htmlspecialchars($bot['meta_desc']) ?>">
    <link rel="canonical" href="<?= $canonical_url ?>">
    
    <!-- Open Graph & Twitter -->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Ant Harita Mühendislik">
    <meta property="og:title" content="<?= htmlspecialchars($page_meta_title) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($page_meta_desc) ?>">
    <meta property="og:url" content="<?= $canonical_url ?>">
    <meta property="og:image" content="<?= $site_domain ?>/assets/og-image.jpg">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= htmlspecialchars($page_meta_title) ?>">
    <meta name="twitter:description" content="<?= htmlspecialchars($page_meta_desc) ?>">

    <!-- Schema.org JSON-LD -->
    <script type="application/ld+json"><?= json_encode($web_app_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>
    <script type="application/ld+json"><?= json_encode($faq_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>
    <script type="application/ld+json"><?= json_encode($breadcrumb_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>

    <!-- Tailwind & Google Fonts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #070c14;
            color: #f1f5f9;
        }
        .glow-card {
            background: linear-gradient(135deg, rgba(15,23,42,0.95) 0%, rgba(30,41,59,0.92) 100%);
            border: 1px solid rgba(56,189,248,0.25);
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }
        .bot-input {
            background: #0f172a;
            border: 1.5px solid #334155;
            color: #fff;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .bot-input:focus {
            border-color: #38bdf8;
            box-shadow: 0 0 12px rgba(56,189,248,0.3);
        }
    
        @media print {
            body { background: #ffffff !important; color: #000000 !important; }
            header, nav, footer, #ilya-widget-container, .navbar, #btn-open-parsel360, .lg\:col-span-5 { display: none !important; }
            .lg\:col-span-7 { width: 100% !important; margin: 0 !important; padding: 0 !important; }
            #bot-report-card { border: 2px solid #000 !important; box-shadow: none !important; background: #fff !important; color: #000 !important; }
            #res-title, .text-white { color: #000000 !important; }
            .text-slate-400, .text-slate-300 { color: #444444 !important; }
            .bg-slate-900, .bg-slate-800 { background: #f8fafc !important; border: 1px solid #ccc !important; }
        }
</style>
    <!-- Google Analytics 4 (GA4) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-B6774G0NZZ"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', 'G-B6774G0NZZ', {
        'page_title': <?= json_encode($bot['title']) ?>,
        'page_location': window.location.href
      });
    </script>
    <!-- Microsoft Clarity -->
    <script type="text/javascript">
        (function(c,l,a,r,i,t,y){
            c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};
            t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/z46tj7yr8r";
            y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y);
        })(window, document, "clarity", "script", "z46tj7yr8r");
    </script>
    <link rel="stylesheet" href="/assets/css/main.css?v=2026.46">
    <link rel="alternate" type="text/markdown" href="https://www.parselsorgu.net/llms.txt" title="ParselSorgu AI / LLM Bilgi Bankası">
    <link rel="alternate" type="application/json" href="https://www.parselsorgu.net/api/2026-kadastro-endeks.json" title="2026 Kadastro ve İmar Açık Veri Seti">
    <script type="application/ld+json">{"@context": "https://schema.org", "@type": "WebPage", "speakable": {"@type": "SpeakableSpecification", "cssSelector": ["h1", ".lead", ".summary-box", ".hero-desc", "main p"]}, "isBasedOn": "https://www.parselsorgu.net/api/2026-kadastro-endeks.json", "publisher": {"@type": "Organization", "name": "Ant Harita Mühendislik - ParselSorgu.net", "url": "https://www.parselsorgu.net/"}}</script>
</head>
<body class="min-h-screen flex flex-col justify-between antialiased selection:bg-sky-500 selection:text-white">

    <?php render_saas_navbar('botlar'); ?>

    <!-- MAIN BODY -->
    <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full">

        <!-- BREADCRUMBS -->
        <nav class="flex items-center gap-2 text-xs text-slate-400 mb-6 flex-wrap" aria-label="Breadcrumb">
            <a href="/" class="hover:text-sky-400">Ana Sayfa</a>
            <span>&rsaquo;</span>
            <a href="/#tab-botlar" class="hover:text-sky-400">İmar &amp; Kadastro Botları</a>
            <span>&rsaquo;</span>
            <span class="text-sky-400 font-bold"><?= htmlspecialchars($bot['title']) ?></span>
        </nav>

        <!-- HERO SECTION -->
        <div class="glow-card rounded-2xl p-6 sm:p-8 mb-8 border-2 border-sky-500/40 relative overflow-hidden">
            <div class="absolute -right-12 -top-12 w-64 h-64 bg-sky-500/10 rounded-full blur-3xl pointer-events-none"></div>
            
            <div class="flex items-center gap-3 mb-3 flex-wrap">
                <span class="text-3xl"><?= $bot['icon'] ?></span>
                <span class="px-2.5 py-1 text-xs font-black bg-gradient-to-r from-sky-500 to-blue-600 text-white rounded-md tracking-wider">2026 CANLI BOT SÜRÜMÜ</span>
                <span class="px-2.5 py-1 text-xs font-bold bg-emerald-500/15 border border-emerald-500/40 text-emerald-400 rounded-md flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <?= htmlspecialchars($page_badge) ?>
                </span>
            </div>

            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-white mb-3">
                <?= htmlspecialchars($page_h1) ?>
            </h1>
            <p class="text-slate-300 text-sm sm:text-base leading-relaxed max-w-4xl">
                <?= htmlspecialchars($bot['subtitle']) ?>
            </p>
        </div>

        <!-- 2-COL ENGINE LAYOUT -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-12">

            <!-- LEFT COL: INTERACTIVE FORM (5 cols) -->
            <div class="lg:col-span-5 flex flex-col gap-6">
                
                <div class="glow-card rounded-xl p-6 border-sky-500/30">
                    <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-700">
                        <h2 class="text-base font-bold text-white flex items-center gap-2">
                            <span>⚙️</span>
                            <span>Taşınmaz ve Teknik Parametreler</span>
                        </h2>
                        <button type="button" onclick="runBotCalculation()" class="text-xs text-sky-400 font-bold hover:underline flex items-center gap-1">
                            <i class="fa-solid fa-rotate-right"></i>
                            <span>Yenile</span>
                        </button>
                    </div>

                    <form id="bot-live-form" onsubmit="event.preventDefault(); runBotCalculation();" class="flex flex-col gap-4">
                        
                        <!-- 1. KONUM: İL VE İLÇE -->
                        <div>
                            <label class="block text-xs font-bold text-slate-300 mb-1.5">1. Taşınmazın Bulunduğu İl ve İlçe:</label>
                            <div class="grid grid-cols-2 gap-3">
                                <select id="bot-city" onchange="onCityChanged(); runBotCalculation();" class="bot-input w-full">
                                    <?php 
                                    $default_c = !empty($selected_city) ? $selected_city : 'İstanbul';
                                    foreach ($PROVINCES as $p): ?>
                                        <option value="<?= $p ?>" <?= $p === $default_c ? 'selected' : '' ?>><?= $p ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <select id="bot-district" onchange="runBotCalculation();" class="bot-input w-full">
                                    <option value="Merkez">Merkez</option>
                                    <option value="1. Bölge">1. Bölge</option>
                                    <option value="2. Bölge">2. Bölge</option>
                                </select>
                            </div>
                        </div>

                        <!-- 2. ADA / PARSEL (OPSİYONEL) -->
                        <div>
                            <label class="block text-xs font-bold text-slate-300 mb-1.5">2. Ada ve Parsel Numarası (Opsiyonel):</label>
                            <div class="grid grid-cols-2 gap-3">
                                <input type="text" id="bot-ada" placeholder="Ada No (örn. 101)" oninput="runBotCalculation();" class="bot-input w-full">
                                <input type="text" id="bot-parsel" placeholder="Parsel No (örn. 5)" oninput="runBotCalculation();" class="bot-input w-full">
                            </div>
                        </div>

                        <!-- 3. BOT ÖZEL PARAMETRELERİ -->
                        <div class="pt-2 border-t border-slate-800">
                            <label class="block text-xs font-bold text-sky-400 mb-2">3. Teknik Parametreler:</label>
                            <div id="bot-dynamic-inputs" class="flex flex-col gap-3">
                                <!-- Populated dynamically by JS according to bot key -->
                            </div>
                        </div>

                        <!-- HESAPLA BUTONU -->
                        <button type="button" onclick="runBotCalculation()" class="w-full mt-2 py-3.5 px-4 bg-gradient-to-r from-sky-500 via-blue-600 to-indigo-600 hover:from-sky-400 hover:to-indigo-500 text-white font-extrabold text-sm rounded-xl shadow-lg shadow-sky-500/25 transition duration-200 flex items-center justify-center gap-2 cursor-pointer">
                            <span>⚡</span>
                            <span>Mühendislik Ön Fizibilitesini Hesapla</span>
                        </button>
                    </form>
                </div>

                <!-- WHATSAPP & EXPERT CARD -->
                <div class="bg-gradient-to-br from-emerald-950/60 to-slate-900 border border-emerald-500/30 rounded-xl p-5">
                    <div class="flex items-start gap-3.5">
                        <div class="w-10 h-10 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center shrink-0 text-lg">
                            <i class="fa-solid fa-user-shield"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-white mb-1">Mühendislik &amp; Hukuk Onayı İster misiniz?</h3>
                            <p class="text-xs text-slate-300 leading-relaxed mb-3">
                                Rapor sonuçlarını Ant Harita lisanslı Harita Mühendisi ve İmar Hukukçusu ile birebir değerlendirin.
                            </p>
                            <a id="btn-wa-consult" href="https://wa.me/905428413535" target="_blank" class="inline-flex items-center gap-2 text-xs font-bold text-emerald-400 hover:text-emerald-300">
                                <span>WhatsApp Mühendis İncelemesi Başlat</span>
                                <span>&rarr;</span>
                            </a>
                        </div>
                    </div>
                </div>

            </div>

            <!-- RIGHT COL: LIVE RESULT REPORT (7 cols) -->
            <div class="lg:col-span-7 flex flex-col gap-6">

                <!-- RAPOR KARTI -->
                <div id="bot-report-card" class="glow-card rounded-xl p-6 sm:p-7 border-2 border-emerald-500/40 relative">
                    
                    <div class="flex items-center justify-between flex-wrap gap-2 mb-4 pb-3 border-b border-slate-700">
                        <div>
                            <span class="text-[11px] font-black tracking-widest text-emerald-400 uppercase">MÜHENDİSLİK ÖN FİZİBİLİTE RAPORU</span>
                            <h2 id="res-title" class="text-lg sm:text-xl font-black text-white mt-0.5">
                                <?= htmlspecialchars($bot['title']) ?>
                            </h2>
                        </div>
                        <div id="res-badge" class="px-3 py-1 bg-slate-800/80 border border-slate-700 text-slate-400 text-xs font-bold rounded-full">
                            ⏳ HENÜZ DEĞERLENDİRİLMEDİ
                        </div>
                    </div>

                    <!-- 4-GRID METRICS -->
                    <div id="res-metrics" class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-6">
                        <!-- Populated by JS -->
                    </div>

                    <!-- DETAILED EXPLANATION BOX -->
                    <div id="res-explanation" class="bg-slate-900/90 border border-slate-800 rounded-xl p-4 sm:p-5 text-xs sm:text-sm text-slate-300 leading-relaxed mb-6 space-y-3">
                        <!-- Populated by JS -->
                    </div>
                    <!-- RAPOR ÇIKTI VE DANIŞMANLIK İŞLEMLERİ (PDF & WHATSAPP) -->
                    <div class="mb-6 p-4 bg-slate-900/90 border border-emerald-500/40 rounded-xl flex items-center justify-between flex-wrap gap-3 shadow-lg shadow-emerald-500/10">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-lg font-black border border-emerald-500/30">
                                <i class="fa-solid fa-file-pdf"></i>
                            </div>
                            <div>
                                <h4 class="text-xs font-black text-white uppercase tracking-wider">Resmi Ön Rapor Çıktısı</h4>
                                <p class="text-[11px] text-slate-400">TMMOB HKMO mevzuatına uygun analiz özetini PDF olarak kaydedin veya yazdırın.</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <button type="button" onclick="window.printBotReport()" class="px-4 py-2.5 bg-slate-800 hover:bg-slate-700 text-sky-400 border border-sky-500/40 rounded-xl text-xs font-bold flex items-center gap-2 transition cursor-pointer">
                                <i class="fa-solid fa-print"></i>
                                <span>PDF / Yazdır</span>
                            </button>
                            <a id="btn-report-wa" href="https://wa.me/905428413535" target="_blank" class="px-4 py-2.5 bg-emerald-600 hover:bg-emerald-500 text-white rounded-xl text-xs font-black flex items-center gap-2 shadow-lg shadow-emerald-600/30 transition">
                                <i class="fa-brands fa-whatsapp text-sm"></i>
                                <span>Mühendise Gönder</span>
                            </a>
                        </div>
                    </div>


                    <!-- PARSEL 360 ENTEGRASYON KÖPRÜSÜ -->
                    <div class="mb-6 p-4 bg-gradient-to-r from-sky-950/80 via-slate-900 to-indigo-950/80 border border-sky-500/50 rounded-xl flex items-center justify-between flex-wrap gap-4 shadow-lg shadow-sky-500/10">
                        <div>
                            <div class="text-[11px] font-black uppercase text-sky-400 tracking-wider flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                PARSEL 360° CANLI HARİTA &amp; CAD ENTEGRASYONU
                            </div>
                            <div class="text-sm font-bold text-white mt-1">
                                Bu analiz parametrelerini Türkiye CBS Kadastro Haritasında inceleyin
                            </div>
                            <div class="text-xs text-slate-300 mt-0.5">
                                Gerçek TKGM parsel sınırları, ITRF95 koordinat dökümü ve AutoCAD (DXF) çıktısı alın.
                            </div>
                        </div>
                        <a id="btn-open-parsel360" href="/ada-parsel-harita<?php echo !empty($selected_city) ? '?il=' . urlencode($selected_city) . (!empty($selected_district) ? '&ilce=' . urlencode($selected_district) : '') : ''; ?>" target="_blank" class="px-5 py-2.5 bg-gradient-to-r from-sky-500 to-blue-600 hover:from-sky-400 hover:to-blue-500 text-white text-xs font-black tracking-wide rounded-xl shadow-lg shadow-sky-500/25 transition-all transform hover:scale-[1.02] flex items-center gap-2 whitespace-nowrap">
                            <i class="fa-solid fa-map-location-dot"></i>
                            <span>🗺️ Bu Parseli Canlı Haritada Aç</span>
                        </a>
                    </div>
                    <!-- AKILLI ÇAPRAZ HESAPLAMA AKIŞI -->
                    <div class="mb-6 p-4 bg-slate-900/80 border border-slate-800 rounded-xl">
                        <div class="text-[11px] font-black uppercase text-slate-400 tracking-wider mb-3 flex items-center gap-2">
                            <i class="fa-solid fa-wand-magic-sparkles text-amber-400"></i>
                            Bu Parsel İçin Sonraki Adım &amp; İlgili Hesaplamalar
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2.5">
                            <a href="/arsa-insaat-maliyeti" class="p-3 bg-slate-800/80 hover:bg-slate-800 border border-slate-700/60 hover:border-sky-500/50 rounded-lg text-left transition block group">
                                <span class="text-[10px] font-bold text-sky-400 block mb-0.5">2026 ÇŞİDB BİRİM FİYAT</span>
                                <strong class="text-xs text-white group-hover:text-sky-300 transition block">İnşaat Maliyet Raporu &rarr;</strong>
                            </a>
                            <a href="/bot/kat-karsiligi-oran" class="p-3 bg-slate-800/80 hover:bg-slate-800 border border-slate-700/60 hover:border-emerald-500/50 rounded-lg text-left transition block group">
                                <span class="text-[10px] font-bold text-emerald-400 block mb-0.5">MÜTEAHHİT PAYLAŞIMI</span>
                                <strong class="text-xs text-white group-hover:text-emerald-300 transition block">Kat Karşılığı Oran Botu &rarr;</strong>
                            </a>
                            <a href="/bot/tarla-ifraz-bolunme" class="p-3 bg-slate-800/80 hover:bg-slate-800 border border-slate-700/60 hover:border-amber-500/50 rounded-lg text-left transition block group">
                                <span class="text-[10px] font-bold text-amber-400 block mb-0.5">5403 SAYILI KANUN</span>
                                <strong class="text-xs text-white group-hover:text-amber-300 transition block">Tarla İfraz &amp; Bölünme &rarr;</strong>
                            </a>
                        </div>
                    </div>

                    
                    <!-- HUKUKİ ÇEKİNCE & VERİ MENŞEİ STANDARDI -->
                    <div class="mt-4 p-3.5 bg-slate-900/90 border border-slate-800 rounded-xl text-[11.5px] text-slate-400 leading-relaxed flex items-start gap-3">
                        <i class="fa-solid fa-shield-halved text-sky-400 text-base mt-0.5 shrink-0"></i>
                        <div>
                            <div class="font-bold text-slate-200 mb-0.5">Yasal Bilgilendirme &amp; Mühendislik Ön Fizibilite Çekincesi:</div>
                            <div>İşbu simülasyon ve analiz sonuçları, 3194 Sayılı İmar Kanunu, 5403 Sayılı Toprak Koruma Kanunu ve Planlı Alanlar İmar Yönetmeliği genel prensipleri doğrultusunda hazırlanmış bir <strong class="text-slate-300">mühendislik ön fizibilite değerlendirmesidir</strong>. Resmî ifraz, tevhid, terk veya yapı ruhsatı süreçlerinde ilgili Belediye Başkanlığı, Kadastro Müdürlüğü veya İl Tarım ve Orman Müdürlüğü'nün yürürlükteki kesin plan kararları esastır.</div>
                        </div>
                    </div>

                    <!-- SOSYAL MEDYA PAYLAŞIM & SEO AKIŞI BARI -->
                    <div class="bg-slate-900/60 border border-slate-800 rounded-xl p-4 mb-6">
                        <div class="flex items-center justify-between flex-wrap gap-2 mb-3">
                            <span class="text-xs font-bold text-sky-400 flex items-center gap-1.5">
                                <i class="fa-solid fa-share-nodes"></i>
                                <span>Bu İmar ve Askı Raporunu Paylaşın (Viral SEO &amp; Trafik):</span>
                            </span>
                            <span class="text-[10px] text-slate-400">Tek Tıkla Gönder</span>
                        </div>
                        <div class="flex items-center gap-2 flex-wrap">
                            <a id="share-wa" href="https://api.whatsapp.com/send?text=Google%20News%20Canl%C4%B1%20%C4%B0mar%20De%C4%9Fi%C5%9Fikli%C4%9Fi%20ve%20Ask%C4%B1%20Raporu:%20https://www.parselsorgu.net/bot/google-news-imar-aski" target="_blank" class="px-3 py-1.5 bg-emerald-600/30 hover:bg-emerald-600/50 text-emerald-300 text-xs font-bold rounded-lg border border-emerald-500/30 flex items-center gap-1.5 transition">
                                <i class="fa-brands fa-whatsapp text-sm"></i> WhatsApp
                            </a>
                            <a id="share-tw" href="https://twitter.com/intent/tweet?text=Canl%C4%B1%20%C4%B0mar%20De%C4%9Fi%C5%9Fikli%C4%9Fi%20ve%20Belediye%20Ask%C4%B1%20%C4%B0lanlar%C4%B1%20Botu%202026&url=https://www.parselsorgu.net/bot/google-news-imar-aski" target="_blank" class="px-3 py-1.5 bg-sky-500/20 hover:bg-sky-500/40 text-sky-300 text-xs font-bold rounded-lg border border-sky-500/30 flex items-center gap-1.5 transition">
                                <i class="fa-brands fa-x-twitter text-sm"></i> X (Twitter)
                            </a>
                            <a id="share-tg" href="https://t.me/share/url?url=https://www.parselsorgu.net/bot/google-news-imar-aski&text=%C4%B0mar%20Plan%C4%B1%20Ask%C4%B1%20ve%20De%C4%9Fi%C5%9Fiklik%20Botu" target="_blank" class="px-3 py-1.5 bg-blue-600/20 hover:bg-blue-600/40 text-blue-300 text-xs font-bold rounded-lg border border-blue-500/30 flex items-center gap-1.5 transition">
                                <i class="fa-brands fa-telegram text-sm"></i> Telegram
                            </a>
                            <button type="button" onclick="navigator.clipboard.writeText(window.location.href); alert('Sayfa bağlantısı panoya kopyalandı!');" class="px-3 py-1.5 bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs font-bold rounded-lg border border-slate-700 flex items-center gap-1.5 transition">
                                <i class="fa-solid fa-link text-sm"></i> Linki Kopyala
                            </button>
                        </div>
                    </div>


                    <!-- ACTIONS / CTA BAR -->
                    <div class="flex items-center gap-3 flex-wrap pt-4 border-t border-slate-800">
                        <button type="button" onclick="window.print()" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-200 text-xs font-bold rounded-lg border border-slate-700 flex items-center gap-2 transition">
                            <i class="fa-solid fa-print"></i>
                            <span>Resmi A4 Raporu Yazdır / PDF</span>
                        </button>
                        <a href="/parsel-sorgulama" target="_blank" class="px-4 py-2 bg-sky-600/30 hover:bg-sky-600/50 text-sky-300 text-xs font-bold rounded-lg border border-sky-500/40 flex items-center gap-2 transition">
                            <i class="fa-solid fa-map-location-dot"></i>
                            <span>Parseli Canlı Uydu Haritasında Gör</span>
                        </a>
                    </div>
                </div>

                <!-- LEGAL GUIDE ACCORDION / CONTENT -->
                <div class="glow-card rounded-xl p-6 border-slate-800">
                    <h3 class="text-base font-extrabold text-white mb-3 flex items-center gap-2">
                        <span>📖</span>
                        <span><?= htmlspecialchars($bot['guide_title']) ?></span>
                    </h3>
                    <div class="text-xs sm:text-sm text-slate-300 leading-relaxed space-y-3">
                        <?= $bot['guide_text'] ?>
                    </div>
                </div>

            </div>

        </div>

        
        <!-- DAHİLİ LİNKLEME: KÜMELEME & PİLLAR REHBER KARTI (INTERNAL LINKING) -->
        <?php if (!empty($PILLAR_GUIDES[$bot['slug']])): 
            $pg = $PILLAR_GUIDES[$bot['slug']];
        ?>
        <div class="mb-12 p-6 bg-gradient-to-r from-slate-900 via-sky-950/80 to-slate-900 border-2 border-sky-500/50 rounded-2xl shadow-2xl flex flex-col md:flex-row items-start md:items-center justify-between gap-5">
            <div class="space-y-1.5 max-w-2xl">
                <div class="inline-flex items-center gap-2">
                    <span class="px-2.5 py-0.5 rounded text-[11px] font-black uppercase bg-amber-500/20 text-amber-300 border border-amber-500/40">
                        ⭐ <?= htmlspecialchars($pg['badge']) ?>
                    </span>
                    <span class="text-xs text-sky-400 font-bold">Resmi Mevzuat Analizi</span>
                </div>
                <h3 class="text-lg sm:text-xl font-black text-white"><?= htmlspecialchars($pg['title']) ?></h3>
                <p class="text-xs sm:text-sm text-slate-300 leading-relaxed"><?= htmlspecialchars($pg['desc']) ?></p>
            </div>
            <a href="<?= htmlspecialchars($pg['url']) ?>" class="px-6 py-3.5 rounded-xl bg-gradient-to-r from-sky-500 to-blue-600 hover:from-sky-400 hover:to-blue-500 text-white font-black text-xs sm:text-sm shadow-xl shadow-sky-500/30 transition-all flex items-center gap-2 whitespace-nowrap">
                <span>Rehberi İncele</span>
                <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
        <?php endif; ?>

        <!-- RELATED ARTICLES (TRAFFIC BOOSTER) -->
        <?php if (!empty($related_articles)): ?>
        <section class="mb-14">
            <div class="flex items-center justify-between mb-6 pb-2 border-b border-slate-800">
                <div>
                    <span class="text-xs font-bold text-sky-400 uppercase tracking-wider">GÜNCEL YAYINLAR &amp; REHBERLER</span>
                    <h2 class="text-xl font-black text-white mt-1">Bu Konuda En Çok Okunan 2026 İmar Makaleleri</h2>
                </div>
                <a href="/makaleler" class="text-xs text-sky-400 font-bold hover:underline flex items-center gap-1">
                    <span>Tüm Makaleler (<?= count($related_articles) ?>+)</span>
                    <span>&rarr;</span>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                <?php foreach ($related_articles as $art): ?>
                    <a href="/makale/<?= htmlspecialchars($art['slug']) ?>" class="group glow-card rounded-xl p-5 border-slate-800 hover:border-sky-500/50 transition duration-200 flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between gap-2 mb-2.5">
                                <span class="px-2 py-0.5 text-[10px] font-bold bg-sky-500/15 text-sky-300 rounded border border-sky-500/20 truncate max-w-[140px]">
                                    <?= htmlspecialchars($art['category']) ?>
                                </span>
                                <span class="text-[10px] text-slate-400"><?= $art['read_time'] ?? '4' ?> dk okuma</span>
                            </div>
                            <h3 class="text-sm font-bold text-white group-hover:text-sky-300 transition line-clamp-2 mb-2">
                                <?= htmlspecialchars($art['title']) ?>
                            </h3>
                            <p class="text-xs text-slate-400 line-clamp-3 leading-relaxed mb-4">
                                <?= htmlspecialchars($art['summary']) ?>
                            </p>
                        </div>
                        <div class="pt-3 border-t border-slate-800/80 flex items-center justify-between text-xs font-bold text-sky-400">
                            <span>İncele</span>
                            <span class="group-hover:translate-x-1 transition">&rarr;</span>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </section>
        <?php endif; ?>

        <!-- ALL OTHER 18 BOTS DIRECTORY (ENGAGEMENT MATRIX) -->
        <section class="mb-14">
            <div class="flex items-center justify-between mb-6 pb-2 border-b border-slate-800">
                <div>
                    <span class="text-xs font-bold text-purple-400 uppercase tracking-wider">TAM DİZİN</span>
                    <h2 class="text-xl font-black text-white mt-1">Diğer Popüler Otonom Gayrimenkul &amp; İmar Botları</h2>
                </div>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3.5">
                <?php foreach ($BOTS as $b_slug => $b_item): 
                    $is_current = ($b_slug === $bot['slug']);
                ?>
                    <a href="/bot/<?= $b_slug ?>" target="_blank" class="glow-card rounded-xl p-3.5 border-slate-800 hover:border-sky-500/50 hover:bg-slate-800/40 transition duration-150 flex flex-col justify-between <?= $is_current ? 'ring-2 ring-sky-500/60 bg-sky-950/20' : '' ?>">
                        <div>
                            <span class="text-2xl mb-1.5 block"><?= $b_item['icon'] ?></span>
                            <h4 class="text-xs font-bold text-white line-clamp-2 mb-1"><?= htmlspecialchars($b_item['title']) ?></h4>
                        </div>
                        <span class="text-[10px] font-bold text-sky-400 mt-2 block">&Acirc;yrı Sekmede A&ccedil; &rarr;</span>
                    </a>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- 81 PROVINCIAL HUBS (INTERNAL LINKING) -->
        <section class="mb-14 glow-card rounded-xl p-6 border-slate-800">
            <h3 class="text-sm font-bold text-white mb-3">📍 81 İl Özelinde TKGM Parsel ve İmar Sorgulama Merkezleri:</h3>
            <div class="flex flex-wrap gap-2">
                <?php foreach ($POPULAR_HUBS as $hub): ?>
                    <a href="/parsel-sorgulama/<?= mb_strtolower($hub, 'UTF-8') ?>" class="px-2.5 py-1 text-xs font-semibold bg-slate-900 border border-slate-700 hover:border-sky-500 hover:text-sky-300 text-slate-300 rounded-md transition">
                        <?= $hub ?> Parsel Sorgulama
                    </a>
                <?php endforeach; ?>
                <a href="/parsel-sorgulama" class="px-2.5 py-1 text-xs font-bold bg-sky-500/15 border border-sky-500/30 text-sky-400 rounded-md hover:bg-sky-500/25 transition">
                    Tüm 81 İli İncele &raquo;
                </a>
            </div>
        </section>

        <!-- FAQ SECTION -->
        <section class="mb-14">
            <h2 class="text-xl font-black text-white mb-4">Sıkça Sorulan Sorular (SSS)</h2>
            <div class="space-y-3">
                <?php foreach ($bot['faqs'] as $idx => $f): ?>
                    <details class="group glow-card rounded-xl p-4 sm:p-5 border-slate-800 cursor-pointer">
                        <summary class="font-bold text-sm sm:text-base text-slate-200 flex items-center justify-between list-none">
                            <span><?= htmlspecialchars($f['q']) ?></span>
                            <span class="text-sky-400 transition-transform group-open:rotate-180">&darr;</span>
                        </summary>
                        <p class="text-xs sm:text-sm text-slate-400 mt-3 pt-3 border-t border-slate-800 leading-relaxed">
                            <?= htmlspecialchars($f['a']) ?>
                        </p>
                    </details>
                <?php endforeach; ?>
            </div>
        </section>

    </main>

    <!-- FOOTER -->
    <footer class="bg-[#040810] border-t border-slate-800/80 py-10 text-xs text-slate-400">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div>
                <p class="font-bold text-white text-sm">ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ</p>
                <p class="text-slate-400 text-xs mt-1">TKGM MEGSİS, 3194 İmar Hukuku ve Otonom Gayrimenkul Analiz Platformu &copy; 2026</p>
            </div>
                        <div class="flex items-center gap-4 flex-wrap">
                <a href="/" class="hover:text-sky-400">Ana Sayfa</a>
                <a href="/parsel-sorgu" class="hover:text-sky-400">Parsel Sorgu</a>
                <a href="/arsa-insaat-maliyeti" class="hover:text-sky-400">Maliyet</a>
                <a href="/hakkimizda" class="hover:text-sky-400">Hakkımızda</a>
                <a href="/yazarlar" class="hover:text-sky-400">Yazarlar</a>
                <a href="/muhendislik-kurulu" class="hover:text-sky-400 text-sky-400 font-bold">Mühendislik Kurulu</a>
                <a href="/basin-kiti" class="hover:text-sky-400">Basın Kiti</a>
                <a href="https://wa.me/905428413535" target="_blank" class="text-emerald-400 hover:text-emerald-300 font-bold">WhatsApp İletişim</a>
            </div>
            <div class="mt-4 pt-4 border-t border-slate-800/60 w-full flex items-center justify-between flex-wrap gap-3">
                <span class="text-slate-500 font-semibold text-[11px]"><i class="fa-solid fa-puzzle-piece text-emerald-400 mr-1"></i> Yeni Nesil SaaS &amp; Kadastro Araçları:</span>
                <div class="flex items-center gap-3 flex-wrap text-[11.5px]">
                    <a href="/eklentiler" class="text-emerald-400 hover:text-emerald-300 font-bold">Tüm Modüller (25+)</a>
                    <a href="/tarla-verimlilik-raporu" class="text-slate-300 hover:text-sky-400">Tarla Verimlilik SaaS</a>
                    <a href="/emlak-vergisi-hesaplama" class="text-slate-300 hover:text-sky-400">2026 Emlak Vergisi</a>
                    <a href="/arsa-takas-pazari" class="text-slate-300 hover:text-sky-400">Arsa Takas Pazarı</a>
                    <a href="/yapi-kayit-belgesi-sorgulama" class="text-slate-300 hover:text-sky-400">Yapı Kayıt Risk Analizi</a>
                    <a href="/tarim-kredisi-hesaplama" class="text-slate-300 hover:text-sky-400">Ziraat Tarım Kredisi</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- JAVASCRIPT BOT CALCULATION ENGINE -->
    <script>
        const ACTIVE_BOT_KEY = "<?= $bot['key'] ?>";
        const BOT_TITLE = "<?= addslashes($bot['title']) ?>";

        const DISTRICTS_POPULAR = {
            "İstanbul": ["Kadıköy", "Beşiktaş", "Çatalca", "Silivri", "Beykoz", "Sarıyer", "Eyüpsultan", "Şile", "Pendik", "Tuzla", "Ümraniye"],
            "Ankara": ["Çankaya", "Keçiören", "Yenimahalle", "Gölbaşı", "Etimesgut", "Mamak", "Pursaklar", "Ayaş", "Beypazarı"],
            "İzmir": ["Bornova", "Karşıyaka", "Konak", "Urla", "Çeşme", "Seferihisar", "Menderes", "Foça", "Dikili", "Menemen"],
            "Antalya": ["Muratpaşa", "Kepez", "Konyaaltı", "Alanya", "Manavgat", "Kaş", "Kemer", "Serik", "Kumluca"],
            "Bursa": ["Nilüfer", "Osmangazi", "Yıldırım", "Mudanya", "Gemlik", "İnegöl", "Karacabey", "İznik"],
            "Muğla": ["Bodrum", "Fethiye", "Marmaris", "Milas", "Menteşe", "Ula", "Datça", "Ortaca", "Köyceğiz"],
            "Balıkesir": ["Ayvalık", "Edremit", "Burhaniye", "Bandırma", "Altıeylül", "Karesi", "Erdek", "Gömeç"],
            "Çanakkale": ["Merkez", "Ezine", "Ayvacık", "Bozcaada", "Gökçeada", "Biga", "Gelibolu", "Lapseki"]
        };

        function onCityChanged() {
            const city = document.getElementById('bot-city')?.value || 'İstanbul';
            const distSelect = document.getElementById('bot-district');
            if (!distSelect) return;
            distSelect.innerHTML = '';
            const list = DISTRICTS_POPULAR[city] || ['Merkez', '1. Bölge', '2. Bölge'];
            list.forEach(d => {
                const opt = document.createElement('option');
                opt.value = d;
                opt.innerText = d;
                distSelect.appendChild(opt);
            });
            // Try live fetch
            if (typeof fetch === 'function') {
                fetch('/api.php?action=get_tkgm_districts&city=' + encodeURIComponent(city))
                    .then(r => r.json())
                    .then(res => {
                        if (res && res.districts && res.districts.length > 0) {
                            distSelect.innerHTML = '';
                            res.districts.forEach(d => {
                                const name = typeof d === 'string' ? d : (d.ilceAd || d.name || d);
                                const opt = document.createElement('option');
                                opt.value = name;
                                opt.innerText = name;
                                distSelect.appendChild(opt);
                            });
                        }
                    }).catch(() => {});
            }
        }

        // FORMAT HELPERS
        const fmtTL = (n) => Math.round(n).toLocaleString('tr-TR') + ' TL';
        const fmtM2 = (n) => Math.round(n).toLocaleString('tr-TR') + ' m²';


        function renderDynamicInputs() {
            const container = document.getElementById('bot-dynamic-inputs');
            if (!container) return;

            let html = '';

                        if (ACTIVE_BOT_KEY === 'googlenews') {
                html = `
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">İmar Değişikliği / İlan Türü:</label>
                        <select id="p-plan-type" onchange="runBotCalculation()" class="bot-input w-full">
                            <option value="1000" selected>1/1000 Uygulama İmar Planı Değişikliği</option>
                            <option value="5000">1/5000 Nazım İmar Planı Değişikliği</option>
                            <option value="18">3194 Madde 18 Parselasyon Askı İlanı</option>
                            <option value="kentsel">Riskli Alan / Kentsel Dönüşüm İlanı</option>
                            <option value="kamu">Kamu Yatırımı & Kamulaştırma Duyurusu</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">Askı & İtiraz Durumu:</label>
                        <select id="p-status" onchange="runBotCalculation()" class="bot-input w-full">
                            <option value="aski" selected>Askıda (30 Günlük Yasal İtiraz Süresi Aktif)</option>
                            <option value="yeni">Yeni Onaylandı (Askı İlanı Bekleniyor)</option>
                            <option value="kesin">Askı Süresi Bitti (Plan Kesinleşti)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">Mevcut İmar / Fonksiyon Değişikliği:</label>
                        <select id="p-change-type" onchange="runBotCalculation()" class="bot-input w-full">
                            <option value="emsal" selected>Emsal / Kat Yüksekliği Artışı</option>
                            <option value="fonksiyon">Konut ➔ Ticaret / Karma Fonksiyon</option>
                            <option value="yol">Yol Genişletme & Donatı Alanı Terki</option>
                            <option value="sit">Sit / Koruma Amaçlı İmar Planı Revizyonu</option>
                        </select>
                    </div>
                `;
            } else if (ACTIVE_BOT_KEY === 'koyevi') {
                html = `
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">Tarla / Parsel Alanı (m²):</label>
                        <input type="number" id="p-area" value="6500" min="500" max="1000000" oninput="runBotCalculation()" class="bot-input w-full">
                    </div>
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">Kadastro Yoluna Cephe Durumu:</label>
                        <select id="p-road" onchange="runBotCalculation()" class="bot-input w-full">
                            <option value="var" selected>Kadastro Yoluna 25m+ Cephesi Var (Şartı Sağlıyor)</option>
                            <option value="yok">Kadastro Yolu Yok (Geçit Hakkı Gerekir)</option>
                            <option value="koyici">Köy Yerleşik Alanı İçi (Köy İçi Parseli)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">İnşa Edilecek Yapı Türü:</label>
                        <select id="p-type" onchange="runBotCalculation()" class="bot-input w-full">
                            <option value="koyevi" selected>Müstakil Köy Evi (Maks. 250 m² / 2 Kat)</option>
                            <option value="prefabrik">Prefabrik / Çelik Ev (Sabit Ruhsatlı)</option>
                            <option value="bagevi">Bağ Evi / Tarımsal Amaçlı Yapı (5403 s.K.)</option>
                        </select>
                    </div>
                `;
            } else if (ACTIVE_BOT_KEY === 'mirastarla') {
                html = `
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">Miras Kalan Tarla Alanı (m²):</label>
                        <input type="number" id="p-area" value="35000" min="1000" max="1000000" oninput="runBotCalculation()" class="bot-input w-full">
                    </div>
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">5403 Arazi Sınıfı:</label>
                        <select id="p-class" onchange="runBotCalculation()" class="bot-input w-full">
                            <option value="kuru" selected>Kuru Tarım Arazisi (Bölünemez Sınır: 40 Dekar)</option>
                            <option value="sulu">Sulu Tarım Arazisi (Bölünemez Sınır: 20 Dekar)</option>
                            <option value="dikili">Dikili / Zeytinlik / Meyvelik (Bölünemez Sınır: 5 Dekar)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">Mirasçı (Kardeş) Sayısı:</label>
                        <input type="number" id="p-siblings" value="3" min="1" max="25" oninput="runBotCalculation()" class="bot-input w-full">
                    </div>
                `;
            } else if (ACTIVE_BOT_KEY === 'izaleisuyu') {
                html = `
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">Taşınmaz Tahmini Değeri (TL):</label>
                        <input type="number" id="p-val" value="6000000" min="100000" max="500000000" step="50000" oninput="runBotCalculation()" class="bot-input w-full">
                    </div>
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">Kendi Hisse Oranınız (%):</label>
                        <input type="number" id="p-share" value="25" min="1" max="99" oninput="runBotCalculation()" class="bot-input w-full">
                    </div>
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">Toplam Hissedar Sayısı:</label>
                        <input type="number" id="p-count" value="4" min="2" max="50" oninput="runBotCalculation()" class="bot-input w-full">
                    </div>
                `;
            } else if (ACTIVE_BOT_KEY === 'belediyerayic') {
                html = `
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">Taşınmaz Cinsi:</label>
                        <select id="p-type" onchange="runBotCalculation()" class="bot-input w-full">
                            <option value="arsa" selected>İmarlı Arsa (Büyükşehir ‰6 / Diğer ‰3)</option>
                            <option value="konut">Konut / Mesken (Büyükşehir ‰2 / Diğer ‰1)</option>
                            <option value="tarla">Tarla / Ham Arazi (Büyükşehir ‰2 / Diğer ‰1)</option>
                            <option value="isyeri">İşyeri / Ticari (Büyükşehir ‰4 / Diğer ‰2)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">Taşınmaz Alanı (m²):</label>
                        <input type="number" id="p-area" value="500" min="10" max="100000" oninput="runBotCalculation()" class="bot-input w-full">
                    </div>
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">Belediye m² Birim Rayiç Değeri (TL):</label>
                        <input type="number" id="p-rate" value="1500" min="10" max="250000" step="50" oninput="runBotCalculation()" class="bot-input w-full">
                    </div>
                `;
            } else if (ACTIVE_BOT_KEY === 'tapuharci') {
                html = `
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">Gerçek Satış Bedeli (TL):</label>
                        <input type="number" id="p-price" value="3500000" min="50000" max="100000000" step="50000" oninput="runBotCalculation()" class="bot-input w-full">
                    </div>
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">Belediye Asgari Rayiç Bedeli (TL):</label>
                        <input type="number" id="p-rayic" value="1200000" min="10000" max="100000000" step="50000" oninput="runBotCalculation()" class="bot-input w-full">
                    </div>
                `;
            } else if (ACTIVE_BOT_KEY === 'kentseldonusum') {
                html = `
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">Hak Sahibi Statüsü:</label>
                        <select id="p-status" onchange="runBotCalculation()" class="bot-input w-full">
                            <option value="malik" selected>Konut Maliki (18 Ay Kira Hibesi)</option>
                            <option value="kiraci">Kiracı (Defaten 2 Aylık Taşınma Yardımı)</option>
                            <option value="isyeri">İşyeri Maliki (18 Ay Destek)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">Daire / Bağımsız Bölüm Değeri (TL):</label>
                        <input type="number" id="p-price" value="4500000" step="250000" oninput="runBotCalculation()" class="bot-input w-full">
                    </div>
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">Binadaki Bağımsız Bölüm Sayısı:</label>
                        <input type="number" id="p-units" value="12" oninput="runBotCalculation()" class="bot-input w-full">
                    </div>
                `;
            } else if (ACTIVE_BOT_KEY === 'kiyikenar') {
                html = `
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">Su Kaynağı Türü:</label>
                        <select id="p-source" onchange="runBotCalculation()" class="bot-input w-full">
                            <option value="deniz" selected>Deniz Kıyısı (Sahil Şeridi 100m)</option>
                            <option value="gol">Doğal Göl Kıyısı (50m Kıyı Bandı)</option>
                            <option value="akarsu">Akarsu / Dere (DSİ Taşkın Bandı)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">Parselin Su Kenarına Mesafesi (Metre):</label>
                        <input type="number" id="p-dist" value="35" min="0" max="1000" oninput="runBotCalculation()" class="bot-input w-full">
                    </div>
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">Taşınmaz Alanı (m²):</label>
                        <input type="number" id="p-area" value="1200" min="50" max="100000" oninput="runBotCalculation()" class="bot-input w-full">
                    </div>
                `;
            } else if (ACTIVE_BOT_KEY === 'ges') {
                html = `
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">Arazi Alanı (m²):</label>
                        <input type="number" id="p-area" value="20000" min="2000" max="1000000" step="1000" oninput="runBotCalculation()" class="bot-input w-full">
                    </div>
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">Trafo Merkezine Mesafe (km):</label>
                        <input type="number" id="p-dist" value="2.5" min="0.1" max="25" step="0.5" oninput="runBotCalculation()" class="bot-input w-full">
                    </div>
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">Tarım Görüşü / Toprak Niteliği:</label>
                        <select id="p-soil" onchange="runBotCalculation()" class="bot-input w-full">
                            <option value="marjinal" selected>Marjinal Tarım Arazisi (GES İçin Uygun)</option>
                            <option value="mutlak">Mutlak / Sulu Tarım Arazisi (GES Yasak)</option>
                            <option value="surecte">Henüz Başvuru Yapılmadı</option>
                        </select>
                    </div>
                `;
            } else if (ACTIVE_BOT_KEY === 'katkarsiligi') {
                html = `
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">Arsa Alanı (m²):</label>
                        <input type="number" id="p-area" value="1200" min="100" max="100000" oninput="runBotCalculation()" class="bot-input w-full">
                    </div>
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">Emsal (KAKS) Oranı:</label>
                        <input type="number" id="p-kaks" value="1.50" min="0.20" max="4.00" step="0.10" oninput="runBotCalculation()" class="bot-input w-full">
                    </div>
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">Arsa Sahibi Payı (%):</label>
                        <input type="number" id="p-share" value="45" min="20" max="80" step="5" oninput="runBotCalculation()" class="bot-input w-full">
                    </div>
                `;
            } else if (ACTIVE_BOT_KEY === 'ifraz') {
                html = `
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">Parsel Alanı (m²):</label>
                        <input type="number" id="p-area" value="85000" min="1000" max="1000000" oninput="runBotCalculation()" class="bot-input w-full">
                    </div>
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">Kadastro Yolu Cephesi (Metre):</label>
                        <input type="number" id="p-road" value="65" min="0" max="1000" oninput="runBotCalculation()" class="bot-input w-full">
                    </div>
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">Arazi Niteliği:</label>
                        <select id="p-type" onchange="runBotCalculation()" class="bot-input w-full">
                            <option value="kuru" selected>Kuru Tarım (Bölünemez Asgari 40 Dönüm)</option>
                            <option value="sulu">Sulu Tarım (Bölünemez Asgari 20 Dönüm)</option>
                            <option value="dikili">Dikili / Meyvelik (Bölünemez Asgari 5 Dönüm)</option>
                        </select>
                    </div>
                `;
            } else if (ACTIVE_BOT_KEY === 'tinyhouse') {
                html = `
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">Parsel Statüsü:</label>
                        <select id="p-status" onchange="runBotCalculation()" class="bot-input w-full">
                            <option value="tarla" selected>Kadastro Yolu Olan Tarla</option>
                            <option value="yolsuz">Yolu Olmayan Ham Arazi</option>
                            <option value="sit">Sit Alanı / Zeytinlik (Yasak Bölge)</option>
                            <option value="arsa">İmarlı Arsa</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">Zemin Uygulaması:</label>
                        <select id="p-ground" onchange="runBotCalculation()" class="bot-input w-full">
                            <option value="mobil" selected>Tekerlekleri Üzerinde / Seyyar (Betonsuz)</option>
                            <option value="beton">Beton Platform Dökülecek (İmar Yıkım Riski)</option>
                        </select>
                    </div>
                `;
            } else if (ACTIVE_BOT_KEY === 'takskaks') {
                html = `
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">Arsa Alanı (m²):</label>
                        <input type="number" id="p-area" value="800" min="50" max="50000" oninput="runBotCalculation()" class="bot-input w-full">
                    </div>
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">TAKS (Taban Oturumu):</label>
                        <input type="number" id="p-taks" value="0.30" min="0.10" max="0.60" step="0.05" oninput="runBotCalculation()" class="bot-input w-full">
                    </div>
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">KAKS / Emsal:</label>
                        <input type="number" id="p-kaks" value="1.50" min="0.20" max="4.00" step="0.10" oninput="runBotCalculation()" class="bot-input w-full">
                    </div>
                `;
            } else if (ACTIVE_BOT_KEY === 'sufa') {
                html = `
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">Tapuda Gösterilen Satış Bedeli (TL):</label>
                        <input type="number" id="p-price" value="1500000" min="50000" max="50000000" step="50000" oninput="runBotCalculation()" class="bot-input w-full">
                    </div>
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">Noter İhtarnamesi Tebliğ Edildi mi?:</label>
                        <select id="p-noter" onchange="runBotCalculation()" class="bot-input w-full">
                            <option value="hayir" selected>Hayır (2 Yıllık Süre Geçerli)</option>
                            <option value="evet">Evet (3 Aylık Hak Düşürücü Süre)</option>
                        </select>
                    </div>
                `;
            } else if (ACTIVE_BOT_KEY === 'madde18') {
                html = `
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">Ham Kadastro Parsel Alanı (m²):</label>
                        <input type="number" id="p-area" value="4500" min="100" max="1000000" oninput="runBotCalculation()" class="bot-input w-full">
                    </div>
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">Belediye DOP Kesinti Oranı (%):</label>
                        <input type="number" id="p-dop" value="40" min="1" max="45" oninput="runBotCalculation()" class="bot-input w-full">
                    </div>
                `;
            } else if (ACTIVE_BOT_KEY === 'zeytinlik') {
                html = `
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">Zeytinlik Alanı (m²):</label>
                        <input type="number" id="p-area" value="8500" min="500" max="100000" oninput="runBotCalculation()" class="bot-input w-full">
                    </div>
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">Kadastro Yol Durumu:</label>
                        <select id="p-road" onchange="runBotCalculation()" class="bot-input w-full">
                            <option value="var" selected>Kadastro Yoluna Cephesi Var</option>
                            <option value="yok">Kadastro Yolu Yok</option>
                        </select>
                    </div>
                `;
            } else if (ACTIVE_BOT_KEY === 'sitalani') {
                html = `
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">Sit Alanı Derecesi:</label>
                        <select id="p-degree" onchange="runBotCalculation()" class="bot-input w-full">
                            <option value="1" selected>1. Derece Sit (Mutlak Yapı Yasağı &amp; Trampa)</option>
                            <option value="2">2. Derece Sit (Nitelikli Koruma)</option>
                            <option value="3">3. Derece Sit (Düşük Yoğunluklu İzinli)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">Parsel Alanı (m²):</label>
                        <input type="number" id="p-area" value="2500" min="100" max="100000" oninput="runBotCalculation()" class="bot-input w-full">
                    </div>
                `;
            } else if (ACTIVE_BOT_KEY === 'degerartis') {
                html = `
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">İktisap (Alış) Bedeli (TL):</label>
                        <input type="number" id="p-buy" value="1000000" min="50000" max="100000000" step="50000" oninput="runBotCalculation()" class="bot-input w-full">
                    </div>
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">Satış Bedeli (TL):</label>
                        <input type="number" id="p-sell" value="3800000" min="50000" max="100000000" step="50000" oninput="runBotCalculation()" class="bot-input w-full">
                    </div>
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">Elde Tutma Süresi:</label>
                        <select id="p-years" onchange="runBotCalculation()" class="bot-input w-full">
                            <option value="2" selected>2 Yıl (Vergiye Tabi)</option>
                            <option value="4">4 Yıl (Vergiye Tabi)</option>
                            <option value="5">5 Yıl ve Üzeri (Tamamen Muaf)</option>
                        </select>
                    </div>
                `;
            } else if (ACTIVE_BOT_KEY === 'tevhid') {
                html = `
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">1. Parsel Alanı (m²):</label>
                        <input type="number" id="p-area1" value="600" min="50" max="50000" oninput="runBotCalculation()" class="bot-input w-full">
                    </div>
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">2. Parsel Alanı (m²):</label>
                        <input type="number" id="p-area2" value="750" min="50" max="50000" oninput="runBotCalculation()" class="bot-input w-full">
                    </div>
                `;
            } else if (ACTIVE_BOT_KEY === '2b') {
                html = `
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">2B Arazisi Alanı (m²):</label>
                        <input type="number" id="p-area" value="1500" min="100" max="100000" oninput="runBotCalculation()" class="bot-input w-full">
                    </div>
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">Milli Emlak m² Rayiç Bedeli (TL):</label>
                        <input type="number" id="p-rate" value="650" min="10" max="50000" step="50" oninput="runBotCalculation()" class="bot-input w-full">
                    </div>
                `;
            }

            container.innerHTML = html;
        }



        function runBotCalculation() {
            const city = document.getElementById('bot-city')?.value || 'İstanbul';
            const district = document.getElementById('bot-district')?.value || 'Merkez';
            const ada = document.getElementById('bot-ada')?.value.trim();
            const parsel = document.getElementById('bot-parsel')?.value.trim();
            const adaParselStr = (ada || parsel) ? ` (Ada: ${ada || '-'} / Parsel: ${parsel || '-'})` : '';

            const resTitle = document.getElementById('res-title');
            const resBadge = document.getElementById('res-badge');
            const resMetrics = document.getElementById('res-metrics');
            const resExp = document.getElementById('res-explanation');
            const btnWa = document.getElementById('btn-wa-consult');

            let titleText = `${city} ${district} ${BOT_TITLE}${adaParselStr}`;
            let badgeHtml = '';
            let metricsHtml = '';
            let expHtml = '';

                        if (ACTIVE_BOT_KEY === 'googlenews') {
                const planType = document.getElementById('p-plan-type')?.value || '1000';
                const status = document.getElementById('p-status')?.value || 'aski';
                const changeType = document.getElementById('p-change-type')?.value || 'emsal';

                let planLabel = '1/1000 Uygulama İmar Planı';
                if (planType === '5000') planLabel = '1/5000 Nazım İmar Planı';
                if (planType === '18') planLabel = '3194 Madde 18 Parselasyon İlanı';
                if (planType === 'kentsel') planLabel = 'Kentsel Dönüşüm & Rezerv Alanı';
                if (planType === 'kamu') planLabel = 'Kamu Yatırımı İlanı';

                let isAski = (status === 'aski');
                badgeHtml = isAski 
                    ? `<span class="px-3 py-1 bg-amber-500/20 border border-amber-500/40 text-amber-400 text-xs font-bold rounded-full">📢 30 GÜNLÜK YASAL ASKI İTİRAZ SÜRESİ AKTİF</span>`
                    : `<span class="px-3 py-1 bg-sky-500/20 border border-sky-500/40 text-sky-400 text-xs font-bold rounded-full">🏛️ RESMİ MECLİS KARARI KESİNLEŞTİ</span>`;

                metricsHtml = `
                    <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                        <span class="text-[11px] text-slate-400 block">Plan Türü</span>
                        <b class="text-white text-base">${planLabel}</b>
                    </div>
                    <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                        <span class="text-[11px] text-slate-400 block">Yasal Askı Süresi</span>
                        <b class="text-amber-400 text-base">30 Gün (Hak Düşürücü)</b>
                    </div>
                    <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                        <span class="text-[11px] text-slate-400 block">Haber Kaynağı</span>
                        <b class="text-sky-400 text-base">Google News & ÇŞİDB</b>
                    </div>
                    <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                        <span class="text-[11px] text-slate-400 block">Dava Açma Süresi</span>
                        <b class="text-emerald-400 text-base">60 Gün (İdare Mahk.)</b>
                    </div>
                `;

                expHtml = `
                    <p class="font-bold text-white text-sm">📰 Google News &amp; Resmi Gazete Canlı İmar Değişikliği Analizi:</p>
                    <p>• <strong>Bölge / Konum:</strong> ${city} ili, ${district} ilçesi sınırlarında <strong>${planLabel}</strong> değişikliği tespit edilmiştir.</p>
                    <p>• <strong>30 Günlük Yasal Askı Kuralı:</strong> 3194 sayılı İmar Kanunu 8. maddesi gereği ilan panosuna çıktığı tarihten itibaren <strong>30 gün içinde</strong> belediye meclisine itiraz edilmeyen planlar idari açıdan kesinleşir.</p>
                    <p>• <strong>İtiraz &amp; Hukuki Yol:</strong> Askı süresi dolmadan dilekçe verilmeli; belediyenin itirazı reddetmesi veya 30 gün içinde yanıt vermemesi halinde 60 gün içinde İdare Mahkemesinde iptal davası açılmalıdır.</p>
                `;
            } else if (ACTIVE_BOT_KEY === 'koyevi') {
                const area = parseFloat(document.getElementById('p-area')?.value) || 6500;
                const road = document.getElementById('p-road')?.value || 'var';
                const yapiType = document.getElementById('p-type')?.value || 'koyevi';

                const maxEmsalArea = Math.min(250, area * 0.05);
                const roadEligible = (road === 'var' || road === 'koyici');
                const isAreaEligible = (area >= 5000 || road === 'koyici');

                if (roadEligible && isAreaEligible) {
                    badgeHtml = `<span class="px-3 py-1 bg-emerald-500/20 border border-emerald-500/40 text-emerald-400 text-xs font-bold rounded-full">✅ İNŞAATA UYGUN</span>`;
                } else {
                    badgeHtml = `<span class="px-3 py-1 bg-rose-500/20 border border-rose-500/40 text-rose-400 text-xs font-bold rounded-full">⚠️ KISITLI / ŞARTLAR EKSİK</span>`;
                }

                metricsHtml = `
                    <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                        <span class="text-[11px] text-slate-400 block">Parsel Alanı</span>
                        <b class="text-white text-base">${fmtM2(area)}</b>
                    </div>
                    <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                        <span class="text-[11px] text-slate-400 block">Maks. İnşaat (%5)</span>
                        <b class="text-sky-400 text-base">${fmtM2(maxEmsalArea)}</b>
                    </div>
                    <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                        <span class="text-[11px] text-slate-400 block">Kat Sınırı</span>
                        <b class="text-emerald-400 text-base">2 Kat (6.50m)</b>
                    </div>
                    <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                        <span class="text-[11px] text-slate-400 block">Kadastro Yolu</span>
                        <b class="text-white text-base">${road === 'var' ? '25m+ Cephe Var' : (road === 'koyici' ? 'Köy İçi' : 'Yol Yok ⚠️')}</b>
                    </div>
                `;

                expHtml = `
                    <p class="font-bold text-white text-sm">📋 Plansız Alanlar İmar Yönetmeliği İnceleme Sonucu:</p>
                    <p>• <strong>İnşaat İzni:</strong> Taşınmazınız üzerinde %5 inşaat emsali ile en fazla <strong>${fmtM2(maxEmsalArea)}</strong> büyüklüğünde ruhsatlı yapı projelendirilebilir.</p>
                    <p>• <strong>Yol Şartı:</strong> ${road === 'yok' ? '<span class="text-rose-400 font-bold">Kadastro yoluna cephesi bulunmadığı için doğrudan ruhsat alınamaz; komşu parsellerden irtifak/geçit hakkı kurulması şarttır.</span>' : 'Kadastro yoluna cephe şartı sağlanmaktadır; İl Özel İdaresi / Belediye ruhsat başvurusu yapılabilir.'}</p>
                    <p>• <strong>Ruhsat Makamı:</strong> ${city} Valiliği İl Özel İdaresi İmar Müdürlüğü veya ilgili İlçe Belediyesinden mimari, statik ve kadastro aplikasyon projeleriyle yapı ruhsatı talep edilmelidir.</p>
                `;
            } else if (ACTIVE_BOT_KEY === 'mirastarla') {
                const area = parseFloat(document.getElementById('p-area')?.value) || 35000;
                const aClass = document.getElementById('p-class')?.value || 'kuru';
                const siblings = parseInt(document.getElementById('p-siblings')?.value) || 3;

                let minLimit = 40000;
                if (aClass === 'sulu') minLimit = 20000;
                if (aClass === 'dikili') minLimit = 5000;

                const sharePerPerson = area / siblings;
                const canIfraz = (sharePerPerson >= minLimit);

                badgeHtml = canIfraz 
                    ? `<span class="px-3 py-1 bg-emerald-500/20 border border-emerald-500/40 text-emerald-400 text-xs font-bold rounded-full">✅ MÜSTAKİL İFRAZ MÜMKÜN</span>`
                    : `<span class="px-3 py-1 bg-amber-500/20 border border-amber-500/40 text-amber-400 text-xs font-bold rounded-full">⚠️ BÖLÜNEMEZ (HİSSELİ KALIR)</span>`;

                metricsHtml = `
                    <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                        <span class="text-[11px] text-slate-400 block">Toplam Tarla</span>
                        <b class="text-white text-base">${fmtM2(area)}</b>
                    </div>
                    <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                        <span class="text-[11px] text-slate-400 block">Kardeş Başı Pay</span>
                        <b class="text-amber-400 text-base">${fmtM2(sharePerPerson)}</b>
                    </div>
                    <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                        <span class="text-[11px] text-slate-400 block">Yasal Alt Sınır</span>
                        <b class="text-sky-400 text-base">${fmtM2(minLimit)}</b>
                    </div>
                    <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                        <span class="text-[11px] text-slate-400 block">İfraz Durumu</span>
                        <b class="text-${canIfraz ? 'emerald' : 'rose'}-400 text-base">${canIfraz ? 'Bölünebilir' : 'Bölünemez'}</b>
                    </div>
                `;

                expHtml = `
                    <p class="font-bold text-white text-sm">📜 5403 Sayılı Kanun Miras Taksim Analizi:</p>
                    <p>• <strong>Bölünemez Asgari Parsel:</strong> Seçilen arazi türünde yasal alt sınır <strong>${fmtM2(minLimit)}</strong> dir. Kardeş başına düşen <strong>${fmtM2(sharePerPerson)}</strong> m² bu sınırın ${canIfraz ? 'üzerinde olduğu için harita mühendisi ifraz krokisi ile müstakil tapulara ayrılabilir.' : 'altında kaldığı için müstakil tapu ifrazı yapılamaz.'}</p>
                    <p>• <strong>Hukuki Çözüm:</strong> ${canIfraz ? 'Mirasçılar noterde Rızaen Taksim Sözleşmesi imzalayarak tapuda ifraz yapabilirler.' : 'Arazi tek bir ehil mirasçıya devredilebilir, üçüncü şahsa satılabilir veya tüm kardeşler hisseli mülkiyet olarak tapuda intikal ettirebilir.'}</p>
                `;
            } else if (ACTIVE_BOT_KEY === 'izaleisuyu') {
                const val = parseFloat(document.getElementById('p-val')?.value) || 6000000;
                const share = parseFloat(document.getElementById('p-share')?.value) || 25;
                const count = parseInt(document.getElementById('p-count')?.value) || 4;

                const baseBid = val * 0.50;
                const myShareVal = val * (share / 100);
                const minShareWin = baseBid * (share / 100);

                badgeHtml = `<span class="px-3 py-1 bg-sky-500/20 border border-sky-500/40 text-sky-400 text-xs font-bold rounded-full">⚖️ %50 TABAN İHALE ANALİZİ</span>`;

                metricsHtml = `
                    <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                        <span class="text-[11px] text-slate-400 block">Muhammen Değer</span>
                        <b class="text-white text-base">${fmtTL(val)}</b>
                    </div>
                    <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                        <span class="text-[11px] text-slate-400 block">%50 Açık Artırma Tabanı</span>
                        <b class="text-rose-400 text-base">${fmtTL(baseBid)}</b>
                    </div>
                    <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                        <span class="text-[11px] text-slate-400 block">Sizin Hisseniz (%${share})</span>
                        <b class="text-emerald-400 text-base">${fmtTL(myShareVal)}</b>
                    </div>
                    <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                        <span class="text-[11px] text-slate-400 block">Taban Fiyatta Payınız</span>
                        <b class="text-amber-400 text-base">${fmtTL(minShareWin)}</b>
                    </div>
                `;

                expHtml = `
                    <p class="font-bold text-white text-sm">⚖️ Ortaklığın Giderilmesi (İzale-i Şüyu) Simülasyonu:</p>
                    <p>• <strong>e-Satış Başlangıç Fiyatı:</strong> UYAP e-Satış portalında ilk artırma muhammen bedelin %50 si olan <strong>${fmtTL(baseBid)}</strong> den başlar.</p>
                    <p>• <strong>Teminatsız Teklif Verme:</strong> Sizin hisseniz (${fmtTL(myShareVal)}) gerekli ihale teminatını karşıladığı için nakit teminat yatırmadan açık artırmaya teklif verebilir ve diğer payları satın alabilirsiniz.</p>
                    <p>• <strong>Masraf Kesintileri:</strong> İhale sonuçlandığında mahkeme, satış memurluğu, bilirkişi ve tellaliye masrafları (ortalama %5-8) düşüldükten sonra net bedel banka hesaplarına aktarılır.</p>
                `;
            } else if (ACTIVE_BOT_KEY === 'belediyerayic') {
                const yType = document.getElementById('p-type')?.value || 'arsa';
                const area = parseFloat(document.getElementById('p-area')?.value) || 500;
                const rate = parseFloat(document.getElementById('p-rate')?.value) || 1500;

                const totalRayic = area * rate;
                let taxPerMille = 6;
                if (yType === 'konut') taxPerMille = 2;
                if (yType === 'tarla') taxPerMille = 2;
                if (yType === 'isyeri') taxPerMille = 4;

                const annualTax = (totalRayic * taxPerMille) / 1000;
                const tapuMinHarci = totalRayic * 0.04;

                badgeHtml = `<span class="px-3 py-1 bg-sky-500/20 border border-sky-500/40 text-sky-400 text-xs font-bold rounded-full">🏛️ 2026 RESMİ BEYAN MATRAHI</span>`;

                metricsHtml = `
                    <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                        <span class="text-[11px] text-slate-400 block">Toplam Rayiç Değer</span>
                        <b class="text-white text-base">${fmtTL(totalRayic)}</b>
                    </div>
                    <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                        <span class="text-[11px] text-slate-400 block">Yıllık Emlak Vergisi</span>
                        <b class="text-amber-400 text-base">${fmtTL(annualTax)}</b>
                    </div>
                    <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                        <span class="text-[11px] text-slate-400 block">1. &amp; 2. Taksit Tutarı</span>
                        <b class="text-sky-400 text-base">${fmtTL(annualTax / 2)}</b>
                    </div>
                    <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                        <span class="text-[11px] text-slate-400 block">Min. Tapu Harcı (%4)</span>
                        <b class="text-emerald-400 text-base">${fmtTL(tapuMinHarci)}</b>
                    </div>
                `;

                expHtml = `
                    <p class="font-bold text-white text-sm">🏛️ 1319 Sayılı Emlak Vergisi &amp; Rayiç Değer Raporu:</p>
                    <p>• <strong>Asgari Tapu Beyanı:</strong> Bu taşınmaz tapuda satılırken beyan edilecek satış bedeli <strong>${fmtTL(totalRayic)}</strong> den düşük gösterilemez; aksi takdirde vergi ziyaı cezası kesilir.</p>
                    <p>• <strong>Vergi Oranı:</strong> ${city} Büyükşehir Belediyesi sınırlarında arsa vergisi binde ${taxPerMille} olarak tahsil edilir. Yıllık toplam vergi <strong>${fmtTL(annualTax)}</strong> dir.</p>
                `;
            } else if (ACTIVE_BOT_KEY === 'tapuharci') {
                const price = parseFloat(document.getElementById('p-price')?.value) || 3500000;
                const rayic = parseFloat(document.getElementById('p-rayic')?.value) || 1200000;
                const baseVal = Math.max(price, rayic);

                const aliciHarci = baseVal * 0.02;
                const saticiHarci = baseVal * 0.02;
                const toplamHarci = baseVal * 0.04;
                const donerSermaye = 4250;

                badgeHtml = `<span class="px-3 py-1 bg-emerald-500/20 border border-emerald-500/40 text-emerald-400 text-xs font-bold rounded-full">💰 %4 HARÇ HESAPLANDI</span>`;

                metricsHtml = `
                    <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                        <span class="text-[11px] text-slate-400 block">Matrah Değeri</span>
                        <b class="text-white text-base">${fmtTL(baseVal)}</b>
                    </div>
                    <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                        <span class="text-[11px] text-slate-400 block">Alıcı Payı (%2)</span>
                        <b class="text-sky-400 text-base">${fmtTL(aliciHarci)}</b>
                    </div>
                    <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                        <span class="text-[11px] text-slate-400 block">Satıcı Payı (%2)</span>
                        <b class="text-amber-400 text-base">${fmtTL(saticiHarci)}</b>
                    </div>
                    <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                        <span class="text-[11px] text-slate-400 block">Döner Sermaye</span>
                        <b class="text-white text-base">${fmtTL(donerSermaye)}</b>
                    </div>
                `;

                expHtml = `
                    <p class="font-bold text-white text-sm">💰 492 Sayılı Harçlar Kanunu Hesap Özeti:</p>
                    <p>• <strong>Toplam Tapu Masrafı:</strong> Alıcı ve satıcı için toplam tapu harcı <strong>${fmtTL(toplamHarci)}</strong> + Döner sermaye <strong>${fmtTL(donerSermaye)}</strong> olmak üzere toplam <strong>${fmtTL(toplamHarci + donerSermaye)}</strong> dir.</p>
                `;
            } else if (ACTIVE_BOT_KEY === 'kentseldonusum') {
                const status = document.getElementById('p-status')?.value || 'malik';
                const price = parseFloat(document.getElementById('p-price')?.value) || 4500000;
                const units = parseInt(document.getElementById('p-units')?.value) || 12;

                let monthlyRent = (city === 'İstanbul') ? 5500 : ((city === 'Ankara' || city === 'İzmir') ? 4500 : 3750);
                let totalGrant = (status === 'malik') ? (monthlyRent * 18) : (monthlyRent * 2);
                const reqVotes = Math.floor(units / 2) + 1;

                badgeHtml = `<span class="px-3 py-1 bg-emerald-500/20 border border-emerald-500/40 text-emerald-400 text-xs font-bold rounded-full">🏗️ %50+1 KARAR NİSABI SAĞLANIYOR</span>`;

                metricsHtml = `
                    <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                        <span class="text-[11px] text-slate-400 block">Aylık Kira Hibesi</span>
                        <b class="text-emerald-400 text-base">${fmtTL(monthlyRent)}</b>
                    </div>
                    <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                        <span class="text-[11px] text-slate-400 block">Toplam Kira Desteği</span>
                        <b class="text-sky-400 text-base">${fmtTL(totalGrant)}</b>
                    </div>
                    <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                        <span class="text-[11px] text-slate-400 block">Gereken İmza Sayısı</span>
                        <b class="text-amber-400 text-base">${reqVotes} / ${units} Malik</b>
                    </div>
                    <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                        <span class="text-[11px] text-slate-400 block">Harç Muafiyeti</span>
                        <b class="text-white text-base">%100 Muaf</b>
                    </div>
                `;

                expHtml = `
                    <p class="font-bold text-white text-sm">🏗️ 6306 Kentsel Dönüşüm Hibe &amp; Karar Raporu:</p>
                    <p>• <strong>Salt Çoğunluk (%50+1):</strong> ${units} bağımsız bölümlü binanızda kentsel dönüşüm kararı ve müteahhit sözleşmesi için <strong>en az ${reqVotes} malikin</strong> imzası yeterlidir.</p>
                    <p>• <strong>Kira Yardımı Hibesi:</strong> ${city} ili için belirlenen aylık <strong>${fmtTL(monthlyRent)}</strong> geri ödemesiz kira desteği 18 ay boyunca ÇŞİDB tarafından doğrudan hesabınıza yatırılır.</p>
                `;
            } else if (ACTIVE_BOT_KEY === 'kiyikenar') {
                const source = document.getElementById('p-source')?.value || 'deniz';
                const dist = parseFloat(document.getElementById('p-dist')?.value) || 35;
                const area = parseFloat(document.getElementById('p-area')?.value) || 1200;

                let isForbidden = (dist < 50);
                badgeHtml = isForbidden
                    ? `<span class="px-3 py-1 bg-rose-500/20 border border-rose-500/40 text-rose-400 text-xs font-bold rounded-full">🚫 İLK 50M: MUTLAK YAPI YASAĞI</span>`
                    : `<span class="px-3 py-1 bg-amber-500/20 border border-amber-500/40 text-amber-400 text-xs font-bold rounded-full">⚠️ İKİNCİ 50M: GÜNÜBİRLİK ŞARTI</span>`;

                metricsHtml = `
                    <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                        <span class="text-[11px] text-slate-400 block">Kıyıya Mesafe</span>
                        <b class="text-${isForbidden ? 'rose' : 'amber'}-400 text-base">${dist} Metre</b>
                    </div>
                    <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                        <span class="text-[11px] text-slate-400 block">Kıyı Bandı Statüsü</span>
                        <b class="text-white text-base">${isForbidden ? 'İlk 50 Metre' : '50 - 100 Metre'}</b>
                    </div>
                    <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                        <span class="text-[11px] text-slate-400 block">Konut Yapılabilir mi?</span>
                        <b class="text-rose-400 text-base">YASAK</b>
                    </div>
                    <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                        <span class="text-[11px] text-slate-400 block">İzinli Kullanım</span>
                        <b class="text-sky-400 text-base">${isForbidden ? 'Sadece Açık Alan' : 'Günübirlik Tesis'}</b>
                    </div>
                `;

                expHtml = `
                    <p class="font-bold text-white text-sm">🌊 3621 Kıyı Kanunu Sahil Şeridi Değerlendirmesi:</p>
                    <p>• Parseliniz su kenarından <strong>${dist} metre</strong> mesafededir. Kıyı kenar çizgisinden itibaren ilk 50 metre mutlak koruma bandında yer aldığı için kalıcı konut, prefabrik veya betonarme yapı yapılması <strong>kanunen yasaktır</strong>.</p>
                `;
            } else if (ACTIVE_BOT_KEY === 'ges') {
                const area = parseFloat(document.getElementById('p-area')?.value) || 20000;
                const dist = parseFloat(document.getElementById('p-dist')?.value) || 2.5;
                const soil = document.getElementById('p-soil')?.value || 'marjinal';

                const estimatedMw = (area / 16000).toFixed(2);
                const isSoilEligible = (soil === 'marjinal');
                const isDistEligible = (dist <= 5.0);

                badgeHtml = (isSoilEligible && isDistEligible)
                    ? `<span class="px-3 py-1 bg-emerald-500/20 border border-emerald-500/40 text-emerald-400 text-xs font-bold rounded-full">☀️ GES FİZİBİLİTESİ OLUMLU</span>`
                    : `<span class="px-3 py-1 bg-rose-500/20 border border-rose-500/40 text-rose-400 text-xs font-bold rounded-full">⚠️ TOPRAK VEYA HAT KISITLI</span>`;

                metricsHtml = `
                    <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                        <span class="text-[11px] text-slate-400 block">Arazi Alanı</span>
                        <b class="text-white text-base">${fmtM2(area)}</b>
                    </div>
                    <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                        <span class="text-[11px] text-slate-400 block">Tahmini GES Kapasitesi</span>
                        <b class="text-amber-400 text-base">${estimatedMw} MW AC</b>
                    </div>
                    <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                        <span class="text-[11px] text-slate-400 block">Trafo Mesafesi</span>
                        <b class="text-${dist <= 5 ? 'emerald' : 'rose'}-400 text-base">${dist} km</b>
                    </div>
                    <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                        <span class="text-[11px] text-slate-400 block">Toprak Durumu</span>
                        <b class="text-white text-base">${soil === 'marjinal' ? 'Marjinal (Uygun)' : 'İnceleme Gerekir'}</b>
                    </div>
                `;

                expHtml = `
                    <p class="font-bold text-white text-sm">☀️ Güneş Enerji Santrali (GES) Uygunluk Analizi:</p>
                    <p>• <strong>Kapasite:</strong> ${fmtM2(area)} büyüklüğündeki arazinize ortalama <strong>${estimatedMw} MW</strong> kurulu güçte güneş santrali kurulabilir.</p>
                    <p>• <strong>Şebeke Bağlantısı:</strong> Trafo merkezine ${dist} km mesafe ekonomik hat maliyeti sınırları ${dist <= 5 ? 'içindedir.' : 'dışındadır, ENH hattı maliyeti yüksek çıkabilir.'}</p>
                `;
            } else if (ACTIVE_BOT_KEY === 'katkarsiligi') {
                const area = parseFloat(document.getElementById('p-area')?.value) || 1200;
                const kaks = parseFloat(document.getElementById('p-kaks')?.value) || 1.50;
                const share = parseFloat(document.getElementById('p-share')?.value) || 45;

                const emsalArea = area * kaks;
                const grossArea = emsalArea * 1.30;
                const arsaSahibiArea = grossArea * (share / 100);
                const muteahhitArea = grossArea * ((100 - share) / 100);
                const daireAdedi = Math.floor(grossArea / 120);

                badgeHtml = `<span class="px-3 py-1 bg-sky-500/20 border border-sky-500/40 text-sky-400 text-xs font-bold rounded-full">🏢 %${share} ARSA SAHİBİ PAYI</span>`;

                metricsHtml = `
                    <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                        <span class="text-[11px] text-slate-400 block">Toplam Brüt İnşaat</span>
                        <b class="text-white text-base">${fmtM2(grossArea)}</b>
                    </div>
                    <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                        <span class="text-[11px] text-slate-400 block">Arsa Sahibi Alanı</span>
                        <b class="text-sky-400 text-base">${fmtM2(arsaSahibiArea)}</b>
                    </div>
                    <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                        <span class="text-[11px] text-slate-400 block">Müteahhit Alanı</span>
                        <b class="text-emerald-400 text-base">${fmtM2(muteahhitArea)}</b>
                    </div>
                    <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                        <span class="text-[11px] text-slate-400 block">Tahmini Daire (120m²)</span>
                        <b class="text-amber-400 text-base">~${daireAdedi} Daire</b>
                    </div>
                `;

                expHtml = `
                    <p class="font-bold text-white text-sm">🏢 Kat Karşılığı Proje &amp; Daire Dağılım Raporu:</p>
                    <p>• ${fmtM2(area)} arsanıza KAKS ${kaks} ile emsal dışı alanlar dahil yaklaşık <strong>${fmtM2(grossArea)}</strong> toplam inşaat hacmi çıkmaktadır.</p>
                    <p>• <strong>Daire Paylaşımı:</strong> Toplam ~${daireAdedi} daireden <strong>${Math.round(daireAdedi * (share / 100))} adedi</strong> arsa sahibine, kalan <strong>${Math.round(daireAdedi * ((100 - share) / 100))} adedi</strong> müteahhide ait olacaktır.</p>
                `;
            } else if (ACTIVE_BOT_KEY === 'ifraz') {
                const area = parseFloat(document.getElementById('p-area')?.value) || 85000;
                const road = parseFloat(document.getElementById('p-road')?.value) || 65;
                const aType = document.getElementById('p-type')?.value || 'kuru';

                let minLimit = 40000;
                if (aType === 'sulu') minLimit = 20000;
                if (aType === 'dikili') minLimit = 5000;

                const maxPieces = Math.floor(area / minLimit);
                const roadPieces = Math.floor(road / 25);
                const realPieces = Math.min(maxPieces, roadPieces);

                badgeHtml = (realPieces >= 2)
                    ? `<span class="px-3 py-1 bg-emerald-500/20 border border-emerald-500/40 text-emerald-400 text-xs font-bold rounded-full">✂️ ${realPieces} PARÇAYA BÖLÜNEBİLİR</span>`
                    : `<span class="px-3 py-1 bg-rose-500/20 border border-rose-500/40 text-rose-400 text-xs font-bold rounded-full">⚠️ İFRAZ ŞARTI SAĞLANAMIYOR</span>`;

                metricsHtml = `
                    <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                        <span class="text-[11px] text-slate-400 block">Parsel Alanı</span>
                        <b class="text-white text-base">${fmtM2(area)}</b>
                    </div>
                    <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                        <span class="text-[11px] text-slate-400 block">Yol Cephesi</span>
                        <b class="text-white text-base">${road} Metre</b>
                    </div>
                    <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                        <span class="text-[11px] text-slate-400 block">Asgari Parça Büyüklüğü</span>
                        <b class="text-sky-400 text-base">${fmtM2(minLimit)}</b>
                    </div>
                    <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                        <span class="text-[11px] text-slate-400 block">Çıkabilecek Parsel</span>
                        <b class="text-emerald-400 text-base">${realPieces >= 2 ? realPieces + ' Yeni Parsel' : 'Bölünemez'}</b>
                    </div>
                `;

                expHtml = `
                    <p class="font-bold text-white text-sm">✂️ 5403 Sayılı Kanun Tarla İfraz Uygunluk Raporu:</p>
                    <p>• Arazi büyüklüğünüz ve ${road} metre yol cepheniz dikkate alındığında taşınmaz <strong>${realPieces >= 2 ? realPieces + ' bağımsız parsele' : 'müstakil parçalara'}</strong> ifraz edilebilir.</p>
                `;
            } else if (ACTIVE_BOT_KEY === 'tinyhouse') {
                const status = document.getElementById('p-status')?.value || 'tarla';
                const ground = document.getElementById('p-ground')?.value || 'mobil';

                let isRiskHigh = (ground === 'beton' || status === 'sit');
                badgeHtml = isRiskHigh
                    ? `<span class="px-3 py-1 bg-rose-500/20 border border-rose-500/40 text-rose-400 text-xs font-bold rounded-full">🚫 YÜKSEK İMAR RİSKİ / YIKIM CEZASI</span>`
                    : `<span class="px-3 py-1 bg-emerald-500/20 border border-emerald-500/40 text-emerald-400 text-xs font-bold rounded-full">✅ ÇEKME KARAVAN STATÜSÜ UYGUN</span>`;

                metricsHtml = `
                    <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                        <span class="text-[11px] text-slate-400 block">Araç Statüsü</span>
                        <b class="text-white text-base">O2 Plakalı Karavan</b>
                    </div>
                    <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                        <span class="text-[11px] text-slate-400 block">Zemin Tipi</span>
                        <b class="text-${ground === 'beton' ? 'rose' : 'emerald'}-400 text-base">${ground === 'beton' ? 'Beton Zemin (Yasak)' : 'Tekerlek Üzerinde'}</b>
                    </div>
                    <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                        <span class="text-[11px] text-slate-400 block">İmar Kanunu Riski</span>
                        <b class="text-${isRiskHigh ? 'rose' : 'emerald'}-400 text-base">${isRiskHigh ? '3194 s.K. 32-42 Ceza' : 'Düşük Risk'}</b>
                    </div>
                    <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                        <span class="text-[11px] text-slate-400 block">Altyapı Önerisi</span>
                        <b class="text-sky-400 text-base">Off-Grid GES + Depo</b>
                    </div>
                `;

                expHtml = `
                    <p class="font-bold text-white text-sm">🏡 Tiny House &amp; Prefabrik Hukuki Risk Raporu:</p>
                    <p>• ${ground === 'beton' ? '<span class="text-rose-400 font-bold">DİKKAT: Zemin betonu döküldüğünde araç statüsü kaybolur ve bina sayılır; belediye tarafından yapı tatil zaptı tutularak yıkım kararı verilir.</span>' : 'Tekerlekleri üzerinde seyyar bırakıldığı ve zemine beton dökülmediği sürece Karayolları Trafik Kanununa tabi çekme karavan kabul edilir.'}</p>
                `;
            } else if (ACTIVE_BOT_KEY === 'takskaks') {
                const area = parseFloat(document.getElementById('p-area')?.value) || 800;
                const taks = parseFloat(document.getElementById('p-taks')?.value) || 0.30;
                const kaks = parseFloat(document.getElementById('p-kaks')?.value) || 1.50;

                const tabanAlani = area * taks;
                const emsalInsaat = area * kaks;
                const grossInsaat = emsalInsaat * 1.30;
                const katSayisi = Math.round(emsalInsaat / tabanAlani);

                badgeHtml = `<span class="px-3 py-1 bg-sky-500/20 border border-sky-500/40 text-sky-400 text-xs font-bold rounded-full">📐 İMAR EMSAL HESABI HAZIR</span>`;

                metricsHtml = `
                    <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                        <span class="text-[11px] text-slate-400 block">Taban Oturumu (TAKS)</span>
                        <b class="text-white text-base">${fmtM2(tabanAlani)}</b>
                    </div>
                    <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                        <span class="text-[11px] text-slate-400 block">Emsal İnşaat (KAKS)</span>
                        <b class="text-sky-400 text-base">${fmtM2(emsalInsaat)}</b>
                    </div>
                    <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                        <span class="text-[11px] text-slate-400 block">Toplam Brüt (+%30)</span>
                        <b class="text-emerald-400 text-base">${fmtM2(grossInsaat)}</b>
                    </div>
                    <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                        <span class="text-[11px] text-slate-400 block">Tahmini Kat Sayısı</span>
                        <b class="text-amber-400 text-base">~${katSayisi} Kat</b>
                    </div>
                `;

                expHtml = `
                    <p class="font-bold text-white text-sm">📐 Planlı Alanlar İmar Yönetmeliği Emsal Çözümü:</p>
                    <p>• Arsanızın bina taban oturumu azami <strong>${fmtM2(tabanAlani)}</strong>, toplam satılabilir net inşaat alanı ise <strong>${fmtM2(emsalInsaat)}</strong> dir.</p>
                `;
            } else if (ACTIVE_BOT_KEY === 'sufa') {
                const price = parseFloat(document.getElementById('p-price')?.value) || 1500000;
                const noter = document.getElementById('p-noter')?.value || 'hayir';

                let sureStr = (noter === 'evet') ? 'Tebliğden İtibaren 3 AY' : 'Satış Tarihinden İtibaren 2 YIL';
                let depoBedeli = price * 1.04 + 4250;

                badgeHtml = `<span class="px-3 py-1 bg-amber-500/20 border border-amber-500/40 text-amber-400 text-xs font-bold rounded-full">🚜 ŞUFA DAVA SÜRESİ AKTİF</span>`;

                metricsHtml = `
                    <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                        <span class="text-[11px] text-slate-400 block">Tapu Satış Bedeli</span>
                        <b class="text-white text-base">${fmtTL(price)}</b>
                    </div>
                    <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                        <span class="text-[11px] text-slate-400 block">Mahkeme Depo Bedeli</span>
                        <b class="text-sky-400 text-base">${fmtTL(depoBedeli)}</b>
                    </div>
                    <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                        <span class="text-[11px] text-slate-400 block">Hak Düşürücü Süre</span>
                        <b class="text-amber-400 text-base">${sureStr}</b>
                    </div>
                    <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                        <span class="text-[11px] text-slate-400 block">Yetkili Mahkeme</span>
                        <b class="text-white text-base">Sulh Hukuk Mahk.</b>
                    </div>
                `;

                expHtml = `
                    <p class="font-bold text-white text-sm">🚜 TMK 732 Yasal Önalım (Şufa) Hakkı Raporu:</p>
                    <p>• Noter tebligatı yapılmadıysa satış tarihinden itibaren <strong>2 yıl</strong> içinde dava açarak hisseyi tapuda gösterilen <strong>${fmtTL(depoBedeli)}</strong> bedeli mahkeme veznesine depo ederek kendi adınıza tescil ettirebilirsiniz.</p>
                `;
            } else if (ACTIVE_BOT_KEY === 'madde18') {
                const area = parseFloat(document.getElementById('p-area')?.value) || 4500;
                let dop = parseFloat(document.getElementById('p-dop')?.value) || 40;
                if (dop > 45) dop = 45; // 7181 Sayılı Kanun gereği azami %45 yasal tavan

                const dopTerk = area * (dop / 100);
                const netParsel = area - dopTerk;
                const emsalAlan = Math.round(netParsel * 1.50);
                const tahminiKonut = Math.max(1, Math.round(emsalAlan / 120));

                badgeHtml = `<span class="px-3 py-1 bg-purple-500/20 border border-purple-500/40 text-purple-400 text-xs font-bold rounded-full">⚖️ %${dop} YASAL DOP &amp; DAĞITIM PLANI</span>`;

                metricsHtml = `
                    <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                        <span class="text-[11px] text-slate-400 block">Ham Kadastro Alanı</span>
                        <b class="text-white text-base">${fmtM2(area)}</b>
                    </div>
                    <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                        <span class="text-[11px] text-slate-400 block">Kamuya Bedelsiz Terk (DOP)</span>
                        <b class="text-rose-400 text-base">-${fmtM2(dopTerk)}</b>
                    </div>
                    <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                        <span class="text-[11px] text-slate-400 block">Tahsis Edilecek Net İmar Parseli</span>
                        <b class="text-emerald-400 text-base">${fmtM2(netParsel)}</b>
                    </div>
                    <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                        <span class="text-[11px] text-slate-400 block">Net İmar İnşaat Kapasitesi</span>
                        <b class="text-sky-400 text-base">~${fmtM2(emsalAlan)}</b>
                    </div>
                `;

                expHtml = `
                    <div class="space-y-4">
                        <div class="p-3 bg-purple-950/30 border border-purple-500/30 rounded-xl">
                            <h4 class="font-black text-white text-sm mb-1 flex items-center gap-2">
                                <i class="fa-solid fa-scale-balanced text-purple-400"></i>
                                <span>3194 Sayılı İmar Kanunu 18. Madde &amp; Arazi Düzenleme Analizi</span>
                            </h4>
                            <p class="text-xs text-slate-300 leading-relaxed">
                                7181 sayılı kanun değişikliği uyarınca belediyelerin düzenleme ortaklık payı (DOP) tavanı azami <strong>%45'tir</strong>. Uygulanan %${dop} kesinti yasal sınırlar içerisindedir.
                            </p>
                        </div>

                        <!-- ÖRNEK DAĞITIM VE TAHSİS CETVELİ (CETVEL NO: 1) -->
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-xs border border-slate-800 rounded-lg overflow-hidden">
                                <thead class="bg-slate-800 text-slate-300 font-bold">
                                    <tr>
                                        <th class="p-2.5">Kadastro Parseli</th>
                                        <th class="p-2.5">Giren Alan</th>
                                        <th class="p-2.5">DOP Kesintisi (%${dop})</th>
                                        <th class="p-2.5">Net İmar Alanı</th>
                                        <th class="p-2.5">Örnek Tahsis Adası</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-800 font-mono text-slate-300">
                                    <tr class="bg-slate-900/50">
                                        <td class="p-2.5 font-bold text-sky-400">Parseliniz (Müstakil)</td>
                                        <td class="p-2.5">${fmtM2(area)}</td>
                                        <td class="p-2.5 text-rose-400">-${fmtM2(dopTerk)}</td>
                                        <td class="p-2.5 font-bold text-emerald-400">${fmtM2(netParsel)}</td>
                                        <td class="p-2.5 text-purple-300 font-sans">İmar Adası / Müstakil Parsel</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                            <div class="p-3 bg-slate-900 border border-slate-800 rounded-lg">
                                <span class="font-bold text-sky-400 block mb-1"><i class="fa-solid fa-road"></i> Kamuya Terk Edilen Donatılar:</span>
                                <span class="text-slate-400 text-[11.5px] leading-relaxed">Yol, meydan, park, otopark, yeşil saha, çocuk bahçesi, ibadethane ve karakol alanları için bedelsiz kamu terki olarak kullanılır.</span>
                            </div>
                            <div class="p-3 bg-slate-900 border border-slate-800 rounded-lg">
                                <span class="font-bold text-emerald-400 block mb-1"><i class="fa-solid fa-building"></i> Yapılaşma ve Emsal Avantajı:</span>
                                <span class="text-slate-400 text-[11.5px] leading-relaxed">Net ${fmtM2(netParsel)} imar arsanızda KAKS: 1.50 emsalle ~<strong>${tahminiKonut} adet bağımsız bölüm (120m²)</strong> konut inşaat potansiyeli doğmaktadır.</span>
                            </div>
                        </div>
                    </div>
                `;
            } else if (ACTIVE_BOT_KEY === 'zeytinlik') {
                const area = parseFloat(document.getElementById('p-area')?.value) || 8500;
                const road = document.getElementById('p-road')?.value || 'var';

                badgeHtml = (area >= 5000 && road === 'var')
                    ? `<span class="px-3 py-1 bg-emerald-500/20 border border-emerald-500/40 text-emerald-400 text-xs font-bold rounded-full">🫒 3573 KAPSAMINDA İNCELEMEYE UYGUN</span>`
                    : `<span class="px-3 py-1 bg-rose-500/20 border border-rose-500/40 text-rose-400 text-xs font-bold rounded-full">⚠️ BÖLÜNEMEZ / YOL VE ALAN EKSİK</span>`;

                metricsHtml = `
                    <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                        <span class="text-[11px] text-slate-400 block">Zeytinlik Alanı</span>
                        <b class="text-white text-base">${fmtM2(area)}</b>
                    </div>
                    <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                        <span class="text-[11px] text-slate-400 block">Asgari İfraz Sınırı</span>
                        <b class="text-sky-400 text-base">5.000 m² (5 Dekar)</b>
                    </div>
                    <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                        <span class="text-[11px] text-slate-400 block">Konut İzni</span>
                        <b class="text-rose-400 text-base">YASAK</b>
                    </div>
                    <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                        <span class="text-[11px] text-slate-400 block">Tarımsal Tesis İzni</span>
                        <b class="text-emerald-400 text-base">Tarım İl Müd. Onaylı</b>
                    </div>
                `;

                expHtml = `
                    <p class="font-bold text-white text-sm">🫒 3573 Sayılı Zeytincilik Kanunu Hükümleri:</p>
                    <p>• Zeytinlik vasfındaki taşınmazlar 5 dekardan küçük bölünemez. Konut yapımı kanunen yasak olup yalnızca zeytin bakım/depo amaçlı tarımsal tesis için izin verilebilir.</p>
                `;
            } else if (ACTIVE_BOT_KEY === 'sitalani') {
                const degree = document.getElementById('p-degree')?.value || '1';
                const area = parseFloat(document.getElementById('p-area')?.value) || 2500;

                badgeHtml = (degree === '1')
                    ? `<span class="px-3 py-1 bg-purple-500/20 border border-purple-500/40 text-purple-400 text-xs font-bold rounded-full">🏛️ 1. DERECE SİT: HAZİNE TRAMPA HAKKI</span>`
                    : `<span class="px-3 py-1 bg-sky-500/20 border border-sky-500/40 text-sky-400 text-xs font-bold rounded-full">🏛️ KORUMA AMAÇLI PLAN ŞART</span>`;

                metricsHtml = `
                    <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                        <span class="text-[11px] text-slate-400 block">Sit Derecesi</span>
                        <b class="text-white text-base">${degree}. Derece Sit</b>
                    </div>
                    <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                        <span class="text-[11px] text-slate-400 block">Yapılaşma İzni</span>
                        <b class="text-rose-400 text-base">${degree === '1' ? 'KESİN YASAK' : 'Kurul İznine Bağlı'}</b>
                    </div>
                    <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                        <span class="text-[11px] text-slate-400 block">Hazine Takası (Trampa)</span>
                        <b class="text-emerald-400 text-base">${degree === '1' ? 'Başvuru Hakkı Var' : 'Kısıtlı'}</b>
                    </div>
                    <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                        <span class="text-[11px] text-slate-400 block">Emlak Vergisi</span>
                        <b class="text-white text-base">%100 Muaf</b>
                    </div>
                `;

                expHtml = `
                    <p class="font-bold text-white text-sm">🏛️ 2863 Sayılı Sit Alanı İmar &amp; Trampa Raporu:</p>
                    <p>• ${degree}. Derece Sit alanında kalan taşınmazınız için ${degree === '1' ? 'Kültür ve Turizm Bakanlığı ile ÇŞİDB ye başvurarak eşdeğer Hazine arazisi ile takas (trampa) talep edebilirsiniz.' : 'Koruma Amaçlı İmar Planı kapsamında Bölge Koruma Kurulu izniyle proje geliştirilebilir.'}</p>
                `;
            } else if (ACTIVE_BOT_KEY === 'degerartis') {
                const buy = parseFloat(document.getElementById('p-buy')?.value) || 1000000;
                const sell = parseFloat(document.getElementById('p-sell')?.value) || 3800000;
                const years = parseInt(document.getElementById('p-years')?.value) || 2;

                const isMuaf = (years >= 5);
                const indexedBuy = buy * 2.10;
                const rawProfit = sell - indexedBuy;
                const istisna = 87000;
                const taxable = Math.max(0, rawProfit - istisna);
                const vergi = isMuaf ? 0 : taxable * 0.27;

                badgeHtml = isMuaf
                    ? `<span class="px-3 py-1 bg-emerald-500/20 border border-emerald-500/40 text-emerald-400 text-xs font-bold rounded-full">✅ 5 YIL DOLDU: VERGİDEN TAM MUAF</span>`
                    : `<span class="px-3 py-1 bg-amber-500/20 border border-amber-500/40 text-amber-400 text-xs font-bold rounded-full">📈 DEĞER ARTIŞ KAZANCI DOĞUYOR</span>`;

                metricsHtml = `
                    <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                        <span class="text-[11px] text-slate-400 block">Endekslenmiş Maliyet</span>
                        <b class="text-white text-base">${fmtTL(indexedBuy)}</b>
                    </div>
                    <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                        <span class="text-[11px] text-slate-400 block">Reel Vergi Matrahı</span>
                        <b class="text-sky-400 text-base">${isMuaf ? '0 TL' : fmtTL(taxable)}</b>
                    </div>
                    <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                        <span class="text-[11px] text-slate-400 block">Tahmini Gelir Vergisi</span>
                        <b class="text-${isMuaf ? 'emerald' : 'amber'}-400 text-base">${isMuaf ? '0 TL (Muaf)' : fmtTL(vergi)}</b>
                    </div>
                    <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                        <span class="text-[11px] text-slate-400 block">Elde Tutma Süresi</span>
                        <b class="text-white text-base">${years} Yıl</b>
                    </div>
                `;

                expHtml = `
                    <p class="font-bold text-white text-sm">📈 193 Sayılı Gelir Vergisi Kanunu 5 Yıl Kuralı:</p>
                    <p>• ${isMuaf ? 'Gayrimenkulün iktisap tarihinden itibaren 5 tam yıl geçtiği için satış kazancı gelir vergisinden tamamen muaftır.' : '5 yıl dolmadığı için Yİ-ÜFE enflasyon endekslemesi sonrası tahmini <strong>' + fmtTL(vergi) + '</strong> gelir vergisi beyan edilmelidir.'}</p>
                `;
            } else if (ACTIVE_BOT_KEY === 'tevhid') {
                const area1 = parseFloat(document.getElementById('p-area1')?.value) || 600;
                const area2 = parseFloat(document.getElementById('p-area2')?.value) || 750;
                const totalArea = area1 + area2;
                const emsalBonus = (totalArea >= 1000) ? '+%15 Emsal Teşviki' : '+%10 Esnek Oturum';

                badgeHtml = `<span class="px-3 py-1 bg-emerald-500/20 border border-emerald-500/40 text-emerald-400 text-xs font-bold rounded-full">🧩 BİRLEŞTİRME VE EMSAL KAZANCI OLUMLU</span>`;

                metricsHtml = `
                    <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                        <span class="text-[11px] text-slate-400 block">Yeni Tevhid Parseli</span>
                        <b class="text-white text-base">${fmtM2(totalArea)}</b>
                    </div>
                    <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                        <span class="text-[11px] text-slate-400 block">Emsal Teşvik Bonusu</span>
                        <b class="text-emerald-400 text-base">${emsalBonus}</b>
                    </div>
                    <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                        <span class="text-[11px] text-slate-400 block">Encümen Onayı</span>
                        <b class="text-sky-400 text-base">3194 Madde 15-16</b>
                    </div>
                    <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                        <span class="text-[11px] text-slate-400 block">İşlem Süresi</span>
                        <b class="text-white text-base">2 - 3 Hafta</b>
                    </div>
                `;

                expHtml = `
                    <p class="font-bold text-white text-sm">🧩 3194 Parsel Tevhid (Birleştirme) Analizi:</p>
                    <p>• İki parselin birleşimiyle oluşan <strong>${fmtM2(totalArea)}</strong> büyüklüğündeki yeni arsa, belediye imar yönetmeliği uyarınca <strong>${emsalBonus}</strong> avantajı elde etmektedir.</p>
                `;
            } else if (ACTIVE_BOT_KEY === '2b') {
                const area = parseFloat(document.getElementById('p-area')?.value) || 1500;
                const rate = parseFloat(document.getElementById('p-rate')?.value) || 650;
                const totalRayic = area * rate;
                const yasaBedel = totalRayic * 0.70;
                const pesinIndirim = yasaBedel * 0.80;

                badgeHtml = `<span class="px-3 py-1 bg-purple-500/20 border border-purple-500/40 text-purple-400 text-xs font-bold rounded-full">⚖️ 6292 DOĞRUDAN SATIN ALMA HAKKI</span>`;

                metricsHtml = `
                    <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                        <span class="text-[11px] text-slate-400 block">Milli Emlak Rayici</span>
                        <b class="text-white text-base">${fmtTL(totalRayic)}</b>
                    </div>
                    <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                        <span class="text-[11px] text-slate-400 block">Yasal Satış Fiyatı (%70)</span>
                        <b class="text-sky-400 text-base">${fmtTL(yasaBedel)}</b>
                    </div>
                    <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                        <span class="text-[11px] text-slate-400 block">Peşin İndirimli (%20)</span>
                        <b class="text-emerald-400 text-base">${fmtTL(pesinIndirim)}</b>
                    </div>
                    <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                        <span class="text-[11px] text-slate-400 block">Taksit Seçeneği</span>
                        <b class="text-white text-base">5 Yıl (10 Taksit)</b>
                    </div>
                `;

                expHtml = `
                    <p class="font-bold text-white text-sm">⚖️ 6292 Sayılı 2B Kanunu Satın Alma Özeti:</p>
                    <p>• Hak sahipleri rayiç değerin %70 i olan <strong>${fmtTL(yasaBedel)}</strong> üzerinden doğrudan satın alabilir; peşin ödemede bu tutar <strong>${fmtTL(pesinIndirim)}</strong> ye düşer.</p>
                `;
            }

            // Update DOM elements safely
            if (resTitle) resTitle.innerText = titleText;
            if (resBadge) resBadge.innerHTML = badgeHtml;
            if (resMetrics) resMetrics.innerHTML = metricsHtml;
            if (resExp) resExp.innerHTML = expHtml;

            // Update Open Map link
            const btnMap = document.getElementById('btn-open-parsel360');
            if (btnMap) {
                let mapUrl = `/ada-parsel-harita?il=${encodeURIComponent(city)}&ilce=${encodeURIComponent(district)}`;
                if (ada) mapUrl += `&ada=${encodeURIComponent(ada)}`;
                if (parsel) mapUrl += `&parsel=${encodeURIComponent(parsel)}`;
                btnMap.href = mapUrl;
            }

            // Update WhatsApp link
            if (btnWa) {
                const waMsg = `Merhaba, ${city} ${district} taşınmazım için ${BOT_TITLE} raporu oluşturdum. Detaylı harita mühendisliği incelemesi talep ediyorum.`;
                btnWa.href = `https://wa.me/905428413535?text=${encodeURIComponent(waMsg)}`;
            }
        }


        // Initialize on load
        const PRESELECTED_CITY = "<?= addslashes($selected_city) ?>";
        const PRESELECTED_DISTRICT = "<?= addslashes($selected_district) ?>";

        document.addEventListener('DOMContentLoaded', () => {
            renderDynamicInputs();
            if (PRESELECTED_CITY) {
                const cEl = document.getElementById('bot-city');
                if (cEl) cEl.value = PRESELECTED_CITY;
            }
            onCityChanged();
            if (PRESELECTED_DISTRICT) {
                setTimeout(() => {
                    const dEl = document.getElementById('bot-district');
                    if (dEl) {
                        dEl.value = PRESELECTED_DISTRICT;
                        runBotCalculation();
                    }
                }, 150);
            } else {
                runBotCalculation();
            }
        });
    </script>
    <!-- Real-Time Web Analytics Engine -->
    <script src="/analytics.js" defer>
        // PDF / Yazdırma ve Dinamik WhatsApp Motoru
        window.printBotReport = function() {
            window.print();
        };

        // Rapor WhatsApp Linkini Dinamik Güncelle
        function updateReportWhatsAppLink() {
            const city = document.getElementById('bot-city')?.value || 'İl';
            const district = document.getElementById('bot-district')?.value || 'İlçe';
            const ada = document.getElementById('bot-ada')?.value.trim();
            const parsel = document.getElementById('bot-parsel')?.value.trim();
            const adaParselStr = (ada || parsel) ? ` (Ada: ${ada || '-'} / Parsel: ${parsel || '-'})` : '';

            const resTitle = document.getElementById('res-title')?.innerText || BOT_TITLE;
            const waBtn = document.getElementById('btn-report-wa');
            const waBtn2 = document.getElementById('btn-wa-consult');

            const text = `Merhaba İlyas Bey, parselsorgu.net üzerinden ${city} ${district}${adaParselStr} için "${resTitle}" analizi yaptım. Resmi imar çapı ve harita mühendisliği danışmanlığı almak istiyorum.`;
            const waUrl = 'https://wa.me/905428413535?text=' + encodeURIComponent(text);

            if (waBtn) waBtn.href = waUrl;
            if (waBtn2) waBtn2.href = waUrl;
        }

        // MutationObserver ile sonuç değiştikçe linki güncelle
        const targetNode = document.getElementById('res-metrics');
        if (targetNode) {
            const observer = new MutationObserver(updateReportWhatsAppLink);
            observer.observe(targetNode, { childList: true, subtree: true });
        }
</script>

    <!-- ========================================================================= -->
    <!-- 📱 MOBİL UYGULAMA SABİT ALT MENÜSÜ (NATIVE APP BOTTOM BAR) -->
    <!-- ========================================================================= -->
    <nav class="mobile-bottom-app-bar" role="navigation" aria-label="Mobil Hızlı Menü">
        <a href="/" class="mobile-app-btn" id="mob-btn-parsel" title="Canlı Parsel Sorgulama">
            <span class="app-icon">🗺️</span>
            <span>Parsel</span>
        </a>
        <a href="/imar-durumu-sorgulama" class="mobile-app-btn" id="mob-btn-imar" title="İmar Durumu Öğren">
            <span class="app-icon">📐</span>
            <span>İmar</span>
        </a>
        <a href="/arsa-insaat-maliyeti" class="mobile-app-btn" id="mob-btn-maliyet" title="2026 İnşaat Maliyeti">
            <span class="app-icon">⚡</span>
            <span>Maliyet</span>
        </a>
        <a href="/5403-tarla-ifraz" class="mobile-app-btn" id="mob-btn-tarla" title="5403 Tarla İfrazı">
            <span class="app-icon">🌾</span>
            <span>Tarla</span>
        </a>
        <a href="/rehber/" class="mobile-app-btn" id="mob-btn-rehber" title="Teknik ve Hukuki Rehber">
            <span class="app-icon">📚</span>
            <span>Rehber</span>
        </a>
        <button type="button" class="mobile-app-btn" onclick="if(typeof toggleSaasMobileMenu==='function'){toggleSaasMobileMenu();}else if(typeof toggleSidebar==='function'){toggleSidebar(true);}" title="Tüm Menüyü Aç">
            <span class="app-icon">☰</span>
            <span>Menü</span>
        </button>
    </nav>

</body>
</html>