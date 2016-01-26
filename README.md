# Bootstrap Uyumlu S�per Lig ve 1. Lig Puan Durumu Tablosu
Bootsrap tablo yap�s�na uygun olarak kodlanm�� **S�per Lig** ve **1. Lig** Puan Durumu Tablosu. Cache sayesinde s�rekli d�� siteye istek g�ndermez ve sitenizi yava�latmaz.

## Kullan�m
```php
@include 'puan_durumu.php';
LigPuanTablosu:get(); // S�per Lig Puan Tablosu
LigPuanTablosu:get(1); // 1. Lig Puan Tablosu
```

## Ayarlar
***puan_durumu.php*** dosyas�n� herhangi bir editor ile a�arak gerekli de�i�iklikleri ger�ekle�tirebilirsiniz.

#### Cache S�resi
```php
private static $cacheTime = 3600; // Saniye olarak yenileme s�resi de�i�tirilebilir
```

**Not**: Veri sa�lay�c� sitenin ilgili sayfas� de�i�ti�i takdirde pattern d�zenlenmelidir!