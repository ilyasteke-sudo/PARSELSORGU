<?php
/**
 * ANT HARİTA MÜHENDİSLİK TEKNOLOJİLERİ - PARSEL PRO
 * IndexNow Anlık İndeksleme Motoru (indexnow_bot.php)
 * Bing, Yandex, Seznam & Naver'a Anlık URL Bildirimi
 */

declare(strict_types=1);

class IndexNowBot {
    private string $host = 'www.parselsorgu.net';
    private string $key = '7a8f9c1b2d3e4f5a6b7c8d9e0f1a2b3c';
    private string $keyLocation = 'https://www.parselsorgu.net/7a8f9c1b2d3e4f5a6b7c8d9e0f1a2b3c.txt';
    private string $endpoint = 'https://api.indexnow.org/indexnow';
    private ?PDO $pdo;

    public function __construct(?PDO $pdo = null) {
        $this->pdo = $pdo;
    }

    /**
     * Verilen URL listesini IndexNow API'sine POST eder
     * @param array<string> $urlList
     * @return array<string, mixed>
     */
    public function submitUrls(array $urlList): array {
        if (empty($urlList)) {
            return ['status' => 'error', 'message' => 'URL listesi boş.'];
        }

        // IndexNow maksimum 10.000 URL kabul eder
        $batch = array_slice($urlList, 0, 10000);

        $payload = [
            'host' => $this->host,
            'key' => $this->key,
            'keyLocation' => $this->keyLocation,
            'urlList' => array_values(array_unique($batch))
        ];

        $jsonPayload = json_encode($payload, JSON_UNESCAPED_SLASHES);

        $ch = curl_init($this->endpoint);
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $jsonPayload,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json; charset=utf-8',
                'User-Agent: ParselSorguIndexNowBot/2026.1'
            ],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 25,
            CURLOPT_SSL_VERIFYPEER => true
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        $isSuccess = ($httpCode === 200 || $httpCode === 202);

        return [
            'status' => $isSuccess ? 'success' : 'failed',
            'http_code' => $httpCode,
            'submitted_count' => count($batch),
            'response' => $response,
            'curl_error' => $curlError ?: null,
            'timestamp' => date('d.m.Y H:i:s')
        ];
    }

    /**
     * Veritabanından en son güncellenen/eklenen makale ve sayfaları çekip gönderir
     * @param int $limit
     * @return array<string, mixed>
     */
    public function submitLatestArticles(int $limit = 100): array {
        if (!$this->pdo) {
            return ['status' => 'error', 'message' => 'Veritabanı bağlantısı yok.'];
        }

        try {
            $stmt = $this->pdo->prepare("SELECT slug, category FROM blog_articles ORDER BY id DESC LIMIT :lim");
            $stmt->bindValue(':lim', $limit, PDO::PARAM_INT);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $urls = [];
            foreach ($rows as $r) {
                if (!empty($r['slug'])) {
                    $prefix = ($r['category'] === 'imar') ? 'imar' : 'makale';
                    $urls[] = "https://{$this->host}/{$prefix}/{$r['slug']}";
                }
            }

            // Ana sayfalar ve hub URL'leri de ekle
            $urls[] = "https://{$this->host}/";
            $urls[] = "https://{$this->host}/parsel-sorgu";
            $urls[] = "https://{$this->host}/ada-parsel-harita";
            $urls[] = "https://{$this->host}/imar-durumu-sorgulama";
            $urls[] = "https://{$this->host}/arsa-insaat-maliyeti";

            return $this->submitUrls($urls);
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    /**
     * Belirli bir il ve ilçedeki mahalleleri IndexNow'a bildirir
     */
    public function submitLocationHub(string $citySlug, string $districtSlug = ''): array {
        $urls = [
            "https://{$this->host}/parsel-sorgu/{$citySlug}"
        ];
        if (!empty($districtSlug)) {
            $urls[] = "https://{$this->host}/parsel-sorgu/{$citySlug}/{$districtSlug}";
        }
        return $this->submitUrls($urls);
    }
}
