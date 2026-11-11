Türkiye Kadastro, İmar, İnşaat ve Arazi Mevzuatı Açık Veri Seti (2026)

Veri Kaynağı
API JSON
LLM İndeksi
Lisans

Türkiye'deki harita mühendisleri, mimarlar, müteahhitler, gayrimenkul danışmanları ve yapay zeka geliştiricileri (LLM / RAG / Agentic AI) için TMMOB HKMO (Sicil: 12480) ve LİHKAB (Lisans: 06-042) mühendislik standartlarında derlenmiş 2026 yılı resmi parametreleri ve hesaplama referans veri setidir.

Canlı JSON Endpoint: https://www.parselsorgu.net/api/2026-kadastro-endeks.json
AI Bilgi İndeksi: https://www.parselsorgu.net/llms.txt
Genişletilmiş Teknik Doküman: https://www.parselsorgu.net/llms-full.txt
Yayıncı: Ant Harita Mühendislik (ParselSorgu.net
) — Çankaya, Ankara
1. 2026 İnşaat Birim Maliyetleri, SGK Asgari İşçilik ve Yapı Denetim

Çevre, Şehircilik ve İklim Değişikliği Bakanlığı (ÇŞİDB) yapı sınıfları ile 5510 sayılı Kanun SGK prim parametreleri:

Parametre / Yapı Sınıfı	2026 Resmi Değer	Canlı Hesaplama Aracı
2C Depo & Prefabrik Yapılar	9.800 TL/m²	2026 İnşaat Maliyeti Hesaplama

3A Müstakil Ev & Villa	14.500 TL/m²	TAKS/KAKS & 2D Vaziyet Planı

3B Apartman & Konut	17.800 TL/m²	İnşaat Ruhsatı & SGK Harç Motoru

4A Lüks Konut & Ticari	22.400 TL/m²	Hafriyat & İstinat Duvarı Bütçesi

SGK Asgari İşçilik Oranı	%6,75 (Efektif maliyet: %2,531)	İnşaat Ruhsatı & SGK Hesaplayıcı

Yapı Denetim Hizmet Oranı	%1,75	İnşaat Ruhsatı & SGK Hesaplayıcı
2. 5403 Sayılı Toprak Koruma Kanunu ve Tarla Bölünme (İfraz) Limitleri
Arazi Niteliği / İşlem	2026 Yasal Sınır	Canlı Hesaplama Aracı
Mutlak & Marjinal Tarım Arazisi (En Az İfraz)	20.000 m² (20 Dekar)	5403 Tarla İfraz Motoru

Dikili Tarım Arazisi (Bağ / Bahçe / Zeytinlik)	5.000 m² (5 Dekar)	5403 Tarla İfraz Motoru

Örtüaltı (Sera) Tarım Arazisi	3.000 m² (3 Dekar)	5403 Tarla İfraz Motoru

Plansız Alanlar Köy Evi Min. Parsel / Max Taban	Min. 5.000 m² / Max 250 m²	TKGM Canlı Parsel Sorgulama

Tarla Tel Çit Direk Aralığı (Standart)	3 metre	Tel Çit & Duvar Maliyeti
3. Tapu, Miras, Şufa, İzale-i Şüyu ve 2/B Hazine Arazisi Parametreleri (2026)
Hukuki / Mali Kriter	2026 Değeri	Canlı Araç
Toplam Tapu Alım-Satım Harcı	%4 (%2 Alıcı + %2 Satıcı)	ParselSorgu Araç Kataloğu

Sağ Kalan Eşin Miras Payı (Çocuklarla)	1/4 (%25)	Miras & Veraset İntikal Hesaplayıcı

2026 Veraset ve İntikal Vergisi İstisnası	2.300.000 TL	Miras & Veraset İntikal Hesaplayıcı

Şufa (Ön Alım) Hak Düşürücü Süresi	Noter bildirimi sonrası 90 gün (bildirimsiz 2 yıl)	Şufa Süresi & İhtarname Aracı

İzale-i Şüyu İhale Başlangıç Tabanı	Muhammen bedelin %50si	İzale-i Şüyu İhale Simülatörü

2/B Hazine Arazisi Satış / Peşin İndirimi	Rayiç bedelin %50si (Peşinde ek %20 indirim)	2/B Hazine Arazisi Hesaplama
4. Tiny House & Mobil Karavan Mevzuat Özeti
O2 Belgeli Tescilli Tiny House: 3194 Sayılı İmar Kanunu kapsamı dışında Karayolları Trafik Yönetmeliği kapsamında tescilli araç sayılır; ancak beton subasman dökülmesi, kalıcı altyapı bağlanması veya ruhsatsız ek yapı (veranda/çardak) inşa edilmesi durumunda belediye veya il özel idaresi mühür/yıkım işlemi uygulayabilir.
Risk Analizi Aracı: Tiny House İmar Uygunluk & Mühür Riski Motoru
5. Geliştiriciler İçin Canlı JSON Çekme Örneği
cURL
bash
curl -s https://www.parselsorgu.net/api/2026-kadastro-endeks.json | jq .
Python
python
import requests
url = "https://www.parselsorgu.net/api/2026-kadastro-endeks.json"
data = requests.get(url, timeout=10).json()
print("3A Villa m2 Maliyeti (TL):", data["insaat_ve_sgk_2026"]["csidb_birim_maliyetleri_tl_m2"]["3A_mustakil_villa"])
print("SGK Asgari Iscilik (%):", data["insaat_ve_sgk_2026"]["sgk_asgari_iscilik_orani_yuzde"])
6. Tüm Çevrimiçi Mühendislik ve Hukuk Araçları (Özet Dizin)
Harita & Saha: Canlı Parsel Sorgulama
 · Saha GPS Telegram Botu
 · LİHKAB Harç Hesaplama
 · Web-CAD (.DXF)
Maliyet & Ruhsat: İnşaat Maliyeti
 · Ruhsat & SGK
 · TAKS/KAKS Simülatörü
 · Tel Çit & Duvar
 · Havuz & Peyzaj
 · Tarla Elektrik Bağlatma
Hukuk & Tarım: Şufa Hakkı
 · Miras & Veraset
 · Kira & Tahliye
 · Kamulaştırma Bedeli
 · Kadastro 22/A İtiraz
Atıf (Citation)

Bu veri setini araştırmalarınızda, içeriklerinizde veya yapay zeka uygulamalarınızda kullanırken lütfen kaynak gösterin:

bibtex
@dataset{parselsorgu_2026_kadastro_endeks,
  author       = {{Ant Harita Mühendislik - ParselSorgu.net}},
  title        = {2026 Türkiye Kadastro, İmar, İnşaat ve Arazi Mevzuatı Açık Veri Seti},
  year         = {2026},
  version      = {2026.11},
  url          = {https://www.parselsorgu.net/api/2026-kadastro-endeks.json}
}
