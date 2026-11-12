# 2026 TAKS / KAKS (Emsal) ve İnşaat Alanı Hesaplama Rehberi

> **Canlı Araç:** [ParselSorgu.net — TAKS / KAKS Emsal Hesaplayıcı](https://www.parselsorgu.net/taks-kaks-hesaplama)  
> **Açık Veri JSON:** [2026 Kadastro & İnşaat Endeksi](https://www.parselsorgu.net/api/2026-kadastro-endeks.json)

## 1. Temel Formüller (Planlı Alanlar İmar Yönetmeliği)

- **TAKS (Taban Alanı Kat Sayısı):** Binanın arsa zemininde kaplayabileceği azami oturum alanı oranıdır.
  $$\text{Maksimum Taban Alanı (m}^2\text{)} = \text{Arsa Alanı} \times \text{TAKS}$$
- **KAKS / Emsal (Kat Alanı Kat Sayısı):** Parselde inşa edilebilecek toplam emsale dahil inşaat alanı oranıdır.
  $$\text{Maksimum Emsal İnşaat Alanı (m}^2\text{)} = \text{Arsa Alanı} \times \text{KAKS}$$
- **Tahmini Kat Adedi:**
  $$\text{Kat Adedi} \approx \frac{\text{KAKS}}{\text{TAKS}}$$

## 2. Örnek Hesaplama (500 m² Konut Parseli)

| Parametre | Değer | Sonuç |
| :--- | :--- | :--- |
| Arsa Alanı | 500 m² | — |
| TAKS | 0.30 (%30) | Maks. Taban Oturumu: **150 m²** |
| KAKS (Emsal) | 1.50 | Maks. İnşaat Alanı: **750 m²** |
| Kat Adedi | `1.50 / 0.30` | **5 Kat** |

## 3. Emsal Harici Alanlar (%30 Kuralı)

Planlı Alanlar İmar Yönetmeliği uyarınca asansör boşlukları, yangın merdivenleri, teknik hacimler ve sığınakların belirli oranları (toplam emsal alanının %30'unu aşmamak kaydıyla) KAKS hesabının dışında tutulabilir.

- **Detaylı Parsel Bazlı Hesaplama:** https://www.parselsorgu.net/taks-kaks-hesaplama
- **81 İl Canlı TKGM Parsel Sorgulama:** https://www.parselsorgu.net/
