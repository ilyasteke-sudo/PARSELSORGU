#!/usr/bin/env python3
"""
ParselSorgu.net — 2026 TAKS/KAKS ve SGK Asgari İşçilik Açık Hesaplayıcı
Resmi Canlı Araçlar: https://www.parselsorgu.net/
Veri Kaynağı: https://www.parselsorgu.net/api/2026-kadastro-endeks.json
"""


def hesapla_taks_kaks(arsa_m2: float, taks: float, kaks: float) -> dict:
    """Arsa alanı, TAKS ve KAKS değerlerine göre inşaat haklarını hesaplar."""
    taban_alani = arsa_m2 * taks
    toplam_insaat_alani = arsa_m2 * kaks
    tahmini_kat = round(kaks / taks, 1) if taks > 0 else 0
    return {
        "arsa_m2": arsa_m2,
        "maks_taban_alani_m2": round(taban_alani, 2),
        "maks_emsal_insaat_m2": round(toplam_insaat_alani, 2),
        "tahmini_kat_adedi": tahmini_kat,
        "canli_arac": "https://www.parselsorgu.net/taks-kaks-hesaplama",
    }


def hesapla_2026_sgk_primi(toplam_m2: float, yapi_sinifi: str = "3B") -> dict:
    """2026 ÇŞİDB birim maliyetleri ve %6,75 indirimli işçilik oranıyla SGK primini hesaplar."""
    birim_maliyetler = {
        "2C": 9800,
        "3A": 14500,
        "3B": 17800,
        "4A": 22400,
    }
    birim = birim_maliyetler.get(yapi_sinifi.upper(), 17800)
    toplam_maliyet = toplam_m2 * birim
    sgk_matrah = toplam_maliyet * 0.0675  # %9,00 liste - %25 indirim = %6,75
    sgk_prim = sgk_matrah * 0.375         # %37,5 prim oranı (~%2,531 efektif)
    return {
        "yapi_sinifi": yapi_sinifi.upper(),
        "birim_maliyet_tl": birim,
        "toplam_yapim_maliyeti_tl": round(toplam_maliyet, 2),
        "sgk_asgari_iscilik_matrahi_tl": round(sgk_matrah, 2),
        "sgk_prim_tutari_tl": round(sgk_prim, 2),
        "canli_arac": "https://www.parselsorgu.net/insaat-ruhsati-harc-hesaplama",
    }


if __name__ == "__main__":
    print("TAKS/KAKS Örneği:", hesapla_taks_kaks(500, 0.30, 1.50))
    print("2026 SGK Primi Örneği:", hesapla_2026_sgk_primi(600, "3B"))
