# Bootstrap Uyumlu Süper Lig ve 1. Lig Puan Durumu Tablosu
Bootsrap tablo yapýsýna uygun olarak kodlanmýþ **Süper Lig** ve **1. Lig** Puan Durumu Tablosu. Cache sayesinde sürekli dýþ siteye istek göndermez ve sitenizi yavaþlatmaz.

## Kullaným
```php
@include 'puan_durumu.php';
LigPuanTablosu:get(); // Süper Lig Puan Tablosu
LigPuanTablosu:get(1); // 1. Lig Puan Tablosu
```

## Ayarlar
***puan_durumu.php*** dosyasýný herhangi bir editor ile açarak gerekli deðiþiklikleri gerçekleþtirebilirsiniz.

#### Cache Süresi
```php
private static $cacheTime = 3600; // Saniye olarak yenileme süresi deðiþtirilebilir
```

**Not**: Veri saðlayýcý sitenin ilgili sayfasý deðiþtiði takdirde pattern düzenlenmelidir!