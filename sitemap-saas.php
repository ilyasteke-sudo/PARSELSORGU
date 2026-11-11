<?php
/**
 * ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ - PARSEL PRO
 * sitemap-saas.php - Dynamic XML Sitemap for all SaaS & Extension Modules
 */
header('Content-Type: application/xml; charset=utf-8');

$lastmod = date('Y-m-d\TH:i:s+03:00');

$pages = [
    ['loc' => 'https://www.parselsorgu.net/eklentiler', 'priority' => '1.0', 'freq' => 'daily'],
    ['loc' => 'https://www.parselsorgu.net/havuz-peyzaj-maliyet-hesaplama', 'priority' => '0.95', 'freq' => 'daily'],
    ['loc' => 'https://www.parselsorgu.net/kadastro-yenileme-itiraz', 'priority' => '0.95', 'freq' => 'daily'],
    ['loc' => 'https://www.parselsorgu.net/kamulastirma-bedeli-hesaplama', 'priority' => '0.95', 'freq' => 'daily'],
    ['loc' => 'https://www.parselsorgu.net/tarla-elektrik-baglatma-maliyeti', 'priority' => '0.95', 'freq' => 'daily'],
    ['loc' => 'https://www.parselsorgu.net/hafriyat-kubaj-istinat-maliyet', 'priority' => '0.95', 'freq' => 'daily'],
    ['loc' => 'https://www.parselsorgu.net/emlakci-musteri-raporu', 'priority' => '0.95', 'freq' => 'daily'],
    ['loc' => 'https://www.parselsorgu.net/partner-harita-muhendisleri', 'priority' => '0.95', 'freq' => 'daily'],
    ['loc' => 'https://www.parselsorgu.net/2026-kadastro-insaat-referans-verileri', 'priority' => '1.0', 'freq' => 'daily'],
    ['loc' => 'https://www.parselsorgu.net/ncn-dxf-kml-donusturucu', 'priority' => '0.98', 'freq' => 'daily'],
    ['loc' => 'https://www.parselsorgu.net/altyapi-risk-radari', 'priority' => '0.98', 'freq' => 'daily'],
    ['loc' => 'https://www.parselsorgu.net/imar-dilekce-olusturucu', 'priority' => '0.98', 'freq' => 'daily'],
    ['loc' => 'https://www.parselsorgu.net/3d-gunes-golge-simulasyonu', 'priority' => '0.98', 'freq' => 'daily'],
    ['loc' => 'https://www.parselsorgu.net/kira-artis-tahliye-hesaplama', 'priority' => '0.95', 'freq' => 'daily'],
    ['loc' => 'https://www.parselsorgu.net/insaat-ruhsati-harc-hesaplama', 'priority' => '0.95', 'freq' => 'daily'],
    ['loc' => 'https://www.parselsorgu.net/sufa-on-alim-hakki', 'priority' => '0.95', 'freq' => 'daily'],
    ['loc' => 'https://www.parselsorgu.net/tel-cit-duvar-maliyet', 'priority' => '0.95', 'freq' => 'daily'],
    ['loc' => 'https://www.parselsorgu.net/taks-kaks-hesaplama', 'priority' => '0.95', 'freq' => 'daily'],
    ['loc' => 'https://www.parselsorgu.net/hazine-arazisi-2b-satin-alma', 'priority' => '0.95', 'freq' => 'daily'],
    ['loc' => 'https://www.parselsorgu.net/tarimsal-sondaj-kuyu-ruhsati', 'priority' => '0.95', 'freq' => 'daily'],
    ['loc' => 'https://www.parselsorgu.net/izalei-suyu-dava-masraf-hesaplama', 'priority' => '0.95', 'freq' => 'daily'],
    ['loc' => 'https://www.parselsorgu.net/miras-paylasimi-veraset-intikal', 'priority' => '0.95', 'freq' => 'daily'],
    ['loc' => 'https://www.parselsorgu.net/tiny-house-imar-uygunluk', 'priority' => '0.95', 'freq' => 'daily'],
    ['loc' => 'https://www.parselsorgu.net/telegram-botu', 'priority' => '0.95', 'freq' => 'daily'],
    ['loc' => 'https://www.parselsorgu.net/prefabrik-ev-maliyeti-hesaplama', 'priority' => '0.95', 'freq' => 'daily'],
    ['loc' => 'https://www.parselsorgu.net/cks-destegi-hesaplama', 'priority' => '0.95', 'freq' => 'daily'],
    ['loc' => 'https://www.parselsorgu.net/arazi-ges-amortisman-hesaplama', 'priority' => '0.95', 'freq' => 'daily'],
    ['loc' => 'https://www.parselsorgu.net/harita-muhendislik-fiyat-teklifi', 'priority' => '0.95', 'freq' => 'daily'],
    ['loc' => 'https://www.parselsorgu.net/lihkab-hesaplama', 'priority' => '0.95', 'freq' => 'daily'],
    ['loc' => 'https://www.parselsorgu.net/kentsel-donusum-yarisi-bizden', 'priority' => '0.95', 'freq' => 'daily'],
    ['loc' => 'https://www.parselsorgu.net/ecrimisil-hesaplama', 'priority' => '0.95', 'freq' => 'daily'],
    ['loc' => 'https://www.parselsorgu.net/tarla-verimlilik-raporu', 'priority' => '0.95', 'freq' => 'daily'],
    ['loc' => 'https://www.parselsorgu.net/emlak-vergisi-hesaplama', 'priority' => '0.95', 'freq' => 'daily'],
    ['loc' => 'https://www.parselsorgu.net/arsa-takas-pazari', 'priority' => '0.95', 'freq' => 'daily'],
    ['loc' => 'https://www.parselsorgu.net/yapi-kayit-belgesi-sorgulama', 'priority' => '0.95', 'freq' => 'daily'],
    ['loc' => 'https://www.parselsorgu.net/tarim-kredisi-hesaplama', 'priority' => '0.95', 'freq' => 'daily'],
    ['loc' => 'https://www.parselsorgu.net/arsa-deger-artisi-hesaplama', 'priority' => '0.90', 'freq' => 'daily'],
    ['loc' => 'https://www.parselsorgu.net/rizai-taksim-sozlesmesi', 'priority' => '0.90', 'freq' => 'weekly'],
    ['loc' => 'https://www.parselsorgu.net/koy-yerlesik-alani-sorgulama', 'priority' => '0.90', 'freq' => 'weekly'],
    ['loc' => 'https://www.parselsorgu.net/imar-terk-hesaplama', 'priority' => '0.90', 'freq' => 'weekly'],
    ['loc' => 'https://www.parselsorgu.net/arsa-yatirim-radari', 'priority' => '0.90', 'freq' => 'daily'],
    ['loc' => 'https://www.parselsorgu.net/arsa-pazari', 'priority' => '0.90', 'freq' => 'daily'],
    ['loc' => 'https://www.parselsorgu.net/sitene-parsel-sorgu-ekle', 'priority' => '0.85', 'freq' => 'monthly'],
    ['loc' => 'https://www.parselsorgu.net/tarla-ifraz-hesaplama', 'priority' => '0.90', 'freq' => 'daily'],
    ['loc' => 'https://www.parselsorgu.net/arsa-degerleme-hesaplama', 'priority' => '0.90', 'freq' => 'daily'],
    ['loc' => 'https://www.parselsorgu.net/toplu-parsel-sorgulama', 'priority' => '0.90', 'freq' => 'daily'],
    ['loc' => 'https://www.parselsorgu.net/tarlaya-ev-yapilir-mi-testi', 'priority' => '0.90', 'freq' => 'weekly'],
    ['loc' => 'https://www.parselsorgu.net/arsa-daire-hesaplama', 'priority' => '0.90', 'freq' => 'weekly'],
    ['loc' => 'https://www.parselsorgu.net/iskan-sorgulama', 'priority' => '0.95', 'freq' => 'daily'],
    ['loc' => 'https://www.parselsorgu.net/numarataj-sorgulama', 'priority' => '0.95', 'freq' => 'daily']
];

echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
echo '<?xml-stylesheet type="text/xsl" href="/sitemap.xsl"?>' . "\n";
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
foreach ($pages as $p) {
    echo "  <url>\n";
    echo "    <loc>{$p['loc']}</loc>\n";
    echo "    <lastmod>{$lastmod}</lastmod>\n";
    echo "    <changefreq>{$p['freq']}</changefreq>\n";
    echo "    <priority>{$p['priority']}</priority>\n";
    echo "  </url>\n";
}
echo '</urlset>' . "\n";
