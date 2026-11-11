<?php
declare(strict_types=1);

/**
 * ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ - PARSEL PRO
 * NeighborhoodSEOGenerator.php - Programmatik Lokasyon SEO & Zengin Schema Motoru
 * 81 İl, 973 İlçe ve 50.000+ Mahalle İçin Zengin SSS (FAQ), Meta ve Breadcrumb Motoru
 */

class NeighborhoodSEOGenerator {
    private string $baseUrl;

    public function __construct(string $baseUrl = "https://www.parselsorgu.net") {
        $this->baseUrl = rtrim($baseUrl, '/');
    }

    /**
     * Türkçe karakterleri kusursuz SEO dostu slug formatına dönüştürür
     */
    public function slugify(string $text): string {
        $from = ['Ç', 'ç', 'Ğ', 'ğ', 'İ', 'I', 'ı', 'i', 'Ö', 'ö', 'Ş', 'ş', 'Ü', 'ü'];
        $to   = ['c', 'c', 'g', 'g', 'i', 'i', 'i', 'i', 'o', 'o', 's', 's', 'u', 'u'];
        $text = str_replace($from, $to, $text);
        $text = mb_strtolower($text, 'UTF-8');
        $text = preg_replace('/[^a-z0-9\-]+/', '-', $text);
        return trim($text, '-');
    }

    /**
     * Mahalle eklerini temizler
     */
    public function cleanNeighborhoodName(string $name): string {
        return trim(preg_replace('/\b(mah|mh|mahallesi|koyu|köyü)\b\.?/iu', '', (string)$name));
    }

    /**
     * MAHALLE DÜZEYİ: generatePagePayload()
     * Dinamik FAQPage, Plansız Alanlar / Köy vs İmar Çapı, Tapu Müdürlüğü, DEM Eğim ve DOP Analizi
     */
    public function generatePagePayload(array $data): array {
        $il = $data['il'] ?? 'Kırıkkale';
        $ilce = $data['ilce'] ?? 'Merkez';
        $mahalle = $data['mahalle'] ?? 'Merkez';
        $cleaned_mahalle = $this->cleanNeighborhoodName($mahalle);

        $ilSlug = $this->slugify($il);
        $ilceSlug = $this->slugify($ilce);
        $mahSlug = $this->slugify($cleaned_mahalle);

        $canonical = "{$this->baseUrl}/parsel-sorgu/{$ilSlug}/{$ilceSlug}/{$mahSlug}";
        $title = "{$il} {$ilce} {$cleaned_mahalle} Parsel Sorgu | ParselSorgu";
        $desc = "{$il} {$ilce} {$cleaned_mahalle} canlı TKGM ada parsel sorgulama, imar durumu ve TAKS/KAKS analiz rehberi.";
        $h1 = "{$il} {$ilce} {$cleaned_mahalle} Mahallesi Parsel Sorgulama";

        // Yerleşim tipi tespiti ('koy' | 'kentsel_mahalle')
        $tip = $data['tip'] ?? '';
        if (empty($tip)) {
            $tip = preg_match('/\b(koyu|köyü|koy|köy)\b/iu', $mahalle) ? 'koy' : 'kentsel_mahalle';
        }

        $tapuMudurlugu = $data['tapuMudurlugu'] ?? "{$ilce} Tapu Müdürlüğü";
        $belediyeAdi = $data['belediyeAdi'] ?? "{$ilce} Belediyesi";
        $ortalamaEgim = isset($data['ortalamaEgim']) ? (float)$data['ortalamaEgim'] : 7.5;
        $ortalamaYukseklik = isset($data['ortalamaYukseklik']) ? (int)$data['ortalamaYukseklik'] : null;
        $dopUygulandiMi = $data['dopUygulandiMi'] ?? ($tip === 'koy' ? false : true);

        $faqs = [];

        // 1. Soru: Ada/Parsel Sorgulama & MEGSİS Altyapısı
        $faqs[] = [
            "question" => "{$il} {$ilce} {$cleaned_mahalle} Mahallesi ada parsel sorgulama nasıl yapılır?",
            "answer" => "{$il} ili {$ilce} ilçesine bağlı {$cleaned_mahalle} Mahallesi sınırlarında ada ve parsel tespiti yapmak için ParselSorgu.net arayüzündeki harita ekranından veya TKGM MEGSİS altyapısından yararlanabilirsiniz. Sorgulama için tapu senedinizde yer alan ada ve parsel numaralarını ilgili kutucuklara girerek mülkiyet sınırlarını, koordinatlı köşe noktalarını ve geometrik alanı uydu görüntüsü üzerinde inceleyebilirsiniz."
        ];

        // 2. Soru: İmar Durumu ve İdare İrtibatı (Köy vs Kentsel Mahalle Şartlı Mantığı)
        if ($tip === 'koy') {
            $faqs[] = [
                "question" => "{$cleaned_mahalle} sınırlarında arsa ve tarla için imar durumu nasıl öğrenilir?",
                "answer" => "{$cleaned_mahalle} köy statüsünde olduğundan, yapılaşma ve ifraz şartları Plansız Alanlar İmar Yönetmeliği ile {$il} İl Özel İdaresi İmar ve Kentsel İyileştirme Müdürlüğü yetki alanındadır. Parselinizin Köy Yerleşik Alanı ve Civarı sınırları içinde kalıp kalmadığı kontrol edilmeli; plansız alanda ise parsel büyüklüğü, kadastral yola cephe uzunluğu ve yapı taban alanı katsayıları (maksimum %5 veya 250 m²) dikkate alınmalıdır."
            ];
        } else {
            $faqs[] = [
                "question" => "{$cleaned_mahalle} Mahallesi imar çapı ve yapılaşma şartları nereden alınır?",
                "answer" => "{$cleaned_mahalle} Mahallesi sınırları içerisindeki taşınmazların güncel 1/1000 ölçekli Uygulama İmar Planı notları, TAKS/KAKS (emsal) değerleri ve kat yükseklikleri için {$belediyeAdi} İmar ve Şehircilik Müdürlüğü'ne tapu fotokopisi ve aplikasyon krokisi ile resmi imar çapı başvurusunda bulunulması gerekmektedir."
            ];
        }

        // 3. Soru: Resmi Tapu & Kadastro İşlemleri Yetki Alanı
        $faqs[] = [
            "question" => "{$cleaned_mahalle} Mahallesi tapu devir ve intikal işlemleri hangi müdürlükte yapılır?",
            "answer" => "{$il} {$ilce} {$cleaned_mahalle} Mahallesi bölgesindeki satış, bağış, intikal ve irtifak hakkı tesisi gibi tescil işlemleri {$tapuMudurlugu} bünyesinde yürütülmektedir. Randevular doğrudan e-Devlet veya WebTapu sistemi üzerinden alınmalıdır."
        ];

        // 4. Soru: Topografik Yapı & Eğime Bağlı Yapılaşma İpucu (DEM Analizi)
        if ($ortalamaEgim !== null) {
            $egimDurumu = $ortalamaEgim > 15
                ? "ortalama %{$ortalamaEgim} seviyesinde dik/eğimli bir topografyaya sahiptir. Yüksek eğimli parsellerde yapı aplikasyonu öncesinde istinat duvarı, zemin etüt raporu ve hafriyat/dolgu hesaplarının dikkatle yapılması tavsiye edilir"
                : "yaklaşık %{$ortalamaEgim} seviyesinde yatay ve az eğimli bir zemin profiline sahiptir. Düşük eğim, temel kazı maliyetlerini ve inşaat altyapı süreçlerini optimize eder";

            $rakimMetni = $ortalamaYukseklik ? "ortalama {$ortalamaYukseklik} metre rakıma ve " : "";
            $faqs[] = [
                "question" => "{$cleaned_mahalle} arazisinin zemin eğimi ve topografik özellikleri nasıldır?",
                "answer" => "Bölgesel yükseklik modelleri (DEM) analizlerine göre {$cleaned_mahalle}, {$rakimMetni}{$egimDurumu}."
            ];
        }

        // 5. Soru: İmar Uygulaması (18. Madde / DOP Kesintisi Durumu)
        if ($dopUygulandiMi !== null) {
            $dopMetni = $dopUygulandiMi
                ? "Bu bölgede parselasyon ve 3194 sayılı İmar Kanunu 18. Madde uygulaması tamamlanmış olup parseller çoğunlukla müstakil imar parseli vasfındadır."
                : "Bölgedeki bazı taşınmazlar henüz ham kadastral parsel statüsünde olabilir. İmar planı etaplarına göre yapılacak parselasyon işleminde yasal azami Düzenleme Ortaklık Payı (DOP) kesintisi uygulanabilir.";

            $faqs[] = [
                "question" => "{$cleaned_mahalle} parsellerinde 18. Madde uygulaması ve DOP kesintisi var mı?",
                "answer" => $dopMetni
            ];
        }

        // 6. Soru: Piyasa Rayiç Değerleme
        $faqs[] = [
            "question" => "{$cleaned_mahalle} mahallesinde arsa metrekare birim fiyatları ne kadar?",
            "answer" => "Bölgedeki arsa rayiçleri imar durumu ve yola cephesine göre değişmektedir. Sitemizdeki Yapay Zeka değerleme aracıyla anlık piyasa fiyatını hesaplayabilirsiniz."
        ];

        // Schema.org Graph
        $json_ld = [
            "@context" => "https://schema.org",
            "@graph" => [
                [
                    "@type" => "BreadcrumbList",
                    "itemListElement" => [
                        ["@type" => "ListItem", "position" => 1, "name" => "Ana Sayfa", "item" => "{$this->baseUrl}/"],
                        ["@type" => "ListItem", "position" => 2, "name" => $il, "item" => "{$this->baseUrl}/parsel-sorgu/{$ilSlug}"],
                        ["@type" => "ListItem", "position" => 3, "name" => $ilce, "item" => "{$this->baseUrl}/parsel-sorgu/{$ilSlug}/{$ilceSlug}"],
                        ["@type" => "ListItem", "position" => 4, "name" => "{$cleaned_mahalle} Mah.", "item" => $canonical]
                    ]
                ],
                [
                    "@type" => "FAQPage",
                    "mainEntity" => array_map(function($f) {
                        return [
                            "@type" => "Question",
                            "name" => $f["question"],
                            "acceptedAnswer" => ["@type" => "Answer", "text" => $f["answer"]]
                        ];
                    }, $faqs)
                ],
                [
                    "@type" => "ProfessionalService",
                    "name" => "Ant Harita Mühendislik & Kadastro",
                    "url" => $canonical,
                    "image" => "{$this->baseUrl}/assets/images/og-parsel.jpg",
                    "telephone" => "+905428413535"
                ]
            ]
        ];

        return [
            "seo" => [
                "title" => $title,
                "description" => $desc,
                "h1" => $h1
            ],
            "canonical_url" => $canonical,
            "content" => [
                "intro_text" => "{$il} ili {$ilce} ilçesi {$cleaned_mahalle} mahallesi güncel kadastro ve imar durumu rehberi.",
                "stats" => [
                    "toplam_parsel" => $data["toplam_parsel"] ?? 2450,
                    "ortalama_alan_m2" => $data["ortalama_alan_m2"] ?? 850,
                    "baskin_imar_tipi" => $tip === 'koy' ? "Köy Yerleşik & Tarımsal" : "Konut & Ticari"
                ],
                "faqs" => $faqs
            ],
            "json_ld" => json_encode($json_ld, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
        ];
    }

    /**
     * İLÇE DÜZEYİ: generateLocationSEO()
     */
    public function generateLocationSEO(array $data): array {
        $il = $data['il'] ?? 'Kırıkkale';
        $ilce = $data['ilce'] ?? '';
        $ilSlug = $this->slugify($il);
        $ilceSlug = !empty($ilce) ? $this->slugify($ilce) : '';

        $canonical = !empty($ilce) ? "{$this->baseUrl}/parsel-sorgu/{$ilSlug}/{$ilceSlug}" : "{$this->baseUrl}/parsel-sorgu/{$ilSlug}";
        if (!empty($ilce)) {
            $fullDistrictTitle = "{$il} {$ilce} E-İmar & Parsel Sorgu | ParselSorgu";
            $metaTitle = mb_strlen($fullDistrictTitle, 'UTF-8') <= 60 ? $fullDistrictTitle : "{$ilce} E-İmar & Parsel Sorgu | ParselSorgu";
            $metaDesc = "{$il} {$ilce} e-imar durumu sorgulama, e-çap, TAKS/KAKS emsal hesabı ve tüm mahallelerde canlı TKGM ada parsel haritası.";
        } else {
            $metaTitle = "{$il} Parsel Sorgu & E-İmar Haritası | ParselSorgu";
            $metaDesc = "{$il} ili ve tüm ilçeleri resmi TKGM MEGSİS parsel sorgulama, e-imar durumu haritası ve arsa değerleme raporu.";
        }

        $faqs = [
            [
                "question" => !empty($ilce) ? "{$il} {$ilce} genelinde ada parsel sorgulama nereden yapılır?" : "{$il} genelinde ada parsel sorgulama nereden yapılır?",
                "answer" => !empty($ilce)
                    ? "{$ilce} Tapu Müdürlüğü yetki alanındaki tüm taşınmazlar www.parselsorgu.net üzerinden TKGM MEGSİS uydu haritası ile ada ve parsel numarası girilerek ücretsiz sorgulanabilir."
                    : "{$il} genelindeki tüm ilçeler www.parselsorgu.net üzerinden TKGM canlı kadastro haritasıyla ada ve parsel bazında anında sorgulanabilir."
            ],
            [
                "question" => !empty($ilce) ? "{$ilce} e-imar ve imar durumu sorgulaması nasıl yapılır?" : "{$il} e-imar ve imar durumu nasıl öğrenilir?",
                "answer" => !empty($ilce)
                    ? "{$ilce} Belediyesi İmar ve Şehircilik Müdürlüğü e-imar / e-çap portalı veya sitemizdeki imar durumu sorgulama ekranı üzerinden ada/parsel bazlı meri plan ve TAKS/KAKS koşulları incelenebilir."
                    : "İlgili ilçe belediyesi e-imar birimlerinden veya platformumuzdaki ilçe sayfalarından 1/1000 uygulama imar planı notlarına ulaşabilirsiniz."
            ],
            [
                "question" => !empty($ilce) ? "{$ilce} ilçesinde 2026 yılı tapu harcı ne kadar çıkar?" : "{$il} tapu devir harcı ne kadar?",
                "answer" => "Tapu devirlerinde alıcıdan %2, satıcıdan %2 olmak üzere toplam %4 tapu harcı ile 2026 yılı bölgesel tapu döner sermaye bedeli tahsil edilmektedir."
            ]
        ];

        $json_ld = [
            "@context" => "https://schema.org",
            "@graph" => [
                [
                    "@type" => "BreadcrumbList",
                    "itemListElement" => !empty($ilce) ? [
                        ["@type" => "ListItem", "position" => 1, "name" => "Ana Sayfa", "item" => "{$this->baseUrl}/"],
                        ["@type" => "ListItem", "position" => 2, "name" => $il, "item" => "{$this->baseUrl}/parsel-sorgu/{$ilSlug}"],
                        ["@type" => "ListItem", "position" => 3, "name" => $ilce, "item" => $canonical]
                    ] : [
                        ["@type" => "ListItem", "position" => 1, "name" => "Ana Sayfa", "item" => "{$this->baseUrl}/"],
                        ["@type" => "ListItem", "position" => 2, "name" => $il, "item" => $canonical]
                    ]
                ],
                [
                    "@type" => "FAQPage",
                    "mainEntity" => array_map(function($f) {
                        return [
                            "@type" => "Question",
                            "name" => $f["question"],
                            "acceptedAnswer" => ["@type" => "Answer", "text" => $f["answer"]]
                        ];
                    }, $faqs)
                ]
            ]
        ];

        return [
            "metaTitle" => $metaTitle,
            "metaDescription" => $metaDesc,
            "canonicalUrl" => $canonical,
            "faqs" => $faqs,
            "json_ld" => json_encode($json_ld, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
        ];
    }
}
