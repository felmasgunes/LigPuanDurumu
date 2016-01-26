# Bootstrap Uyumlu Süper Lig ve 1. Lig Puan Durumu Tablosu
Bootsrap tablo yapısına uygun olarak kodlanmış **Süper Lig** ve **1. Lig** Puan Durumu Tablosu. Cache sayesinde sürekli dış siteye istek göndermez ve sitenizi yavaşlatmaz.

## Kurulum
puan_durumu.php, .superlig.cache ve .1lig.cache dosyalarını kullanacağınız  klasöre kopyalayın. PHP dosyasının değiştirebilmesi için cache dosyalarına gerekli izinleri verin.

## Kullanım
puan_durumu.php dosyasını tabloyu eklemek istediğiniz php dosyasına include edin. Puan tablosunun ekrana basılması için LigPuanTablosu:get(); komutunu kullanabilirsiniz.
```php
@include 'puan_durumu.php';
LigPuanTablosu:get(); // Süper Lig Puan Tablosu
LigPuanTablosu:get(1); // 1. Lig Puan Tablosu
```

## Ayarlar
***puan_durumu.php*** dosyasını herhangi bir editor ile açarak gerekli değişiklikleri gerçekleştirebilirsiniz.

#### Cache Süresi
```php
private static $cacheTime = 3600; // Saniye olarak yenileme süresi değiştirilebilir
```

**Not**: Veri sağlayıcı sitenin ilgili sayfası değiştiği takdirde pattern düzenlenmelidir!
