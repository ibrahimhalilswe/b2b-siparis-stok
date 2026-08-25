# B2B Sipariş & Stok Yönetimi

Kurumsal bir toptan satış platformu için Kategori Yönetimi, Çoklu Ürün Kaydı, Ürün Görseli Yükleme ve Sipariş Oluşturma süreçlerini kapsayan Laravel tabanlı yönetim paneli.

## Teknoloji Yığını

- Laravel 12
- MySQL
- Blade (Bootstrap 5)

## Özellikler

- Kategori ve ürün yönetimi (1-to-N ilişki, `hasMany` / `belongsTo`)
- Ürün görseli yükleme (Laravel Storage, `storage:link`)
- Ürün listeleme: arama, kategoriye göre filtreleme, sayfalama (`paginate`)
- Eager loading ile N+1 sorgu probleminin önlenmesi (`with('category')`)
- Hızlı sipariş oluşturma: stok kontrolü, otomatik stok düşürme, toplam tutar hesaplama
- Stoğu 0 olan ürünlerde sipariş butonu otomatik devre dışı kalır
- Soft delete: silinen ürünler veritabanından silinmez, geri yüklenebilir

## Kurulum

```bash
composer install
copy .env.example .env
php artisan key:generate
```

`.env` dosyasında MySQL bağlantı bilgilerini ayarlayın:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=b2b_siparis_stok
DB_USERNAME=root
DB_PASSWORD=
```

Veritabanı ve depolama linkini oluşturun:

```bash
php artisan migrate
php artisan storage:link
```

Örnek verileri (kategori ve ürünler) yükleyin:

```bash
php artisan db:seed
```

Sunucuyu başlatın:

```bash
php artisan serve
```

Uygulama `http://127.0.0.1:8000/products` adresinden erişilebilir.

## Veritabanı Şeması

| Tablo | Açıklama |
|---|---|
| `categories` | id, name, slug |
| `products` | id, category_id (FK), name, sku, price, stock, image_path, deleted_at (soft delete) |
| `orders` | id, product_id (FK), customer_name, quantity, total_price, status |

## Route Yapısı

- `GET /products` — Ürün listesi (arama, filtreleme, pagination)
- `GET /products/create`, `POST /products` — Ürün ekleme
- `GET /products/{product}/edit`, `PUT /products/{product}` — Ürün düzenleme
- `DELETE /products/{product}` — Ürün silme (soft delete)
- `GET /products/trashed` — Silinen ürünler
- `POST /products/{id}/restore` — Ürünü geri yükle
- `GET /categories`, `POST /categories` — Kategori listeleme ve ekleme
- `GET /orders`, `POST /orders` — Sipariş listeleme ve oluşturma
