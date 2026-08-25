<div align="center">

# B2B Sipariş & Stok Yönetimi

**İlişkisel Veritabanı & Görsel Yükleme odaklı kurumsal toptan satış yönetim paneli**

[![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?style=flat-square&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=flat-square&logo=php&logoColor=white)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=flat-square&logo=mysql&logoColor=white)](https://www.mysql.com)
[![License](https://img.shields.io/badge/License-MIT-blue.svg?style=flat-square)](LICENSE)

</div>

---

## İçindekiler

- [Proje Hakkında](#proje-hakkında)
- [Özellikler](#özellikler)
- [Teknoloji Yığını](#teknoloji-yığını)
- [Veritabanı Şeması](#veritabanı-şeması)
- [Kurulum](#kurulum)
- [Route Yapısı](#route-yapısı)
- [Proje Yapısı](#proje-yapısı)
- [Lisans](#lisans)

---

## Proje Hakkında

Bu proje, kurumsal bir toptan satış platformu için geliştirilmiş modüler bir yönetim panelidir. **Kategori Yönetimi**, **Çoklu Ürün Kaydı**, **Ürün Görseli Yükleme** ve **Sipariş Oluşturma** süreçlerini uçtan uca kapsar. Uygulama; Eloquent ilişkileri, Laravel dosya depolama mekanizması, form validasyonları ve ilişkisel sorgu optimizasyonu (eager loading) prensipleri gözetilerek geliştirilmiştir.

## Özellikler

### Kategori & Ürün Yönetimi
- Kategori bazlı ürün organizasyonu (`hasMany` / `belongsTo` ilişkisi)
- Çoklu ürün kaydı: kategori, SKU, fiyat, stok bilgileriyle birlikte
- Ürün görseli yükleme (`jpeg`, `png`, `jpg`, `webp` — maks. 2MB), `storage:link` ile public erişim
- Ürün düzenleme ve soft delete ile silme
- Silinen ürünleri görüntüleme ve geri yükleme

### Listeleme & Arama
- Kategoriye göre filtreleme ve ürün adına göre arama
- Sayfalama (`paginate`)
- Eager loading (`with('category')`) ile N+1 sorgu probleminin önlenmesi

### Sipariş & Stok Mantığı
- Ürün satırından tek tıkla hızlı sipariş oluşturma
- Sipariş anında otomatik stok kontrolü (talep edilen adet stoktan fazlaysa engellenir)
- Sipariş onaylandığında stoğun otomatik düşürülmesi
- Toplam tutarın (adet × birim fiyat) otomatik hesaplanması
- Stoğu tükenen ürünlerde sipariş butonunun otomatik devre dışı kalması

## Teknoloji Yığını

| Katman | Teknoloji |
|---|---|
| Backend | Laravel 12 (PHP 8.2) |
| Veritabanı | MySQL |
| Görünüm | Blade + Bootstrap 5 |
| Dosya Depolama | Laravel Storage (local disk) |

## Veritabanı Şeması

| Tablo | Kritik Sütunlar | İlişki / Açıklama |
|---|---|---|
| `categories` | `id`, `name`, `slug` | Bir kategorinin birden çok ürünü olabilir (`hasMany`) |
| `products` | `id`, `category_id (FK)`, `name`, `sku`, `price`, `stock`, `image_path`, `deleted_at` | Bir kategoriye aittir (`belongsTo`), soft delete destekler |
| `orders` | `id`, `product_id (FK)`, `customer_name`, `quantity`, `total_price`, `status` | Sipariş oluşturulduğunda ilgili ürünün stoğu otomatik düşer |

## Kurulum

**1. Projeyi bilgisayarına indir**

```bash
git clone https://github.com/ibrahimhalilswe/b2b-siparis-stok.git
cd b2b-siparis-stok
```

Git kurulu değilse, GitHub'daki repo sayfasında **"Code" → "Download ZIP"** seçeneğiyle de indirip klasöre çıkarabilirsin.

**2. Bağımlılıkları yükle ve ortam dosyasını hazırla**

```bash
composer install
copy .env.example .env
php artisan key:generate
```

**3. Veritabanı bağlantısını yapılandır**

`.env` dosyasında aşağıdaki değerleri kendi ortamına göre düzenle:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=b2b_siparis_stok
DB_USERNAME=root
DB_PASSWORD=
```

**4. Veritabanını ve dosya depolama bağlantısını oluştur**

```bash
php artisan migrate
php artisan storage:link
```

**5. Örnek verileri yükle**

```bash
php artisan db:seed
```

**6. Uygulamayı başlat**

```bash
php artisan serve
```

Uygulama varsayılan olarak [http://127.0.0.1:8000/products](http://127.0.0.1:8000/products) adresinden erişilebilir.

## Route Yapısı

| Metot | URI | Açıklama |
|---|---|---|
| `GET` | `/products` | Ürün listesi (arama, filtreleme, sayfalama) |
| `GET` | `/products/create` | Ürün ekleme formu |
| `POST` | `/products` | Yeni ürün kaydı |
| `GET` | `/products/{product}/edit` | Ürün düzenleme formu |
| `PUT` | `/products/{product}` | Ürün güncelleme |
| `DELETE` | `/products/{product}` | Ürünü sil (soft delete) |
| `GET` | `/products/trashed` | Silinen ürünler |
| `POST` | `/products/{id}/restore` | Ürünü geri yükle |
| `GET` | `/categories` | Kategori listesi |
| `POST` | `/categories` | Yeni kategori ekleme |
| `GET` | `/orders` | Sipariş listesi |
| `POST` | `/orders` | Yeni sipariş oluşturma (stok kontrolü + düşürme) |

## Proje Yapısı

```
app/
├── Http/Controllers/
│   ├── CategoryController.php
│   ├── ProductController.php
│   └── OrderController.php
└── Models/
    ├── Category.php
    ├── Product.php
    └── Order.php

database/
├── migrations/
└── seeders/
    ├── CategorySeeder.php
    └── ProductSeeder.php

resources/views/
├── layouts/app.blade.php
├── categories/index.blade.php
├── products/{index,create,edit,trashed}.blade.php
└── orders/index.blade.php
```

## Lisans

Bu proje eğitim/staj amaçlı geliştirilmiştir.
