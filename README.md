<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Bloomie Flowers

Bloomie Flowers is a Laravel application for browsing a flower catalogue and managing products. Customers browse and filter the catalogue, then contact the seller through WhatsApp. Admins sign in to manage products and uploaded photos.

### Product API

- `GET /api/products` returns the catalogue. Add `?category=bouquet` to filter by category.
- `GET /api/products/{id}` returns one product.

Both endpoints return a `data` object or collection with the product title, description, price, category, menu item, and photo URL. Admin product create, update, and delete pages require login.

### Database

Product data is stored in the `admins` table to match the project requirements document. Its UUID key and product fields are `photo`, `title`, `description`, `price`, `category`, and `menu`, with timestamps. Login accounts are stored in `users`.

### Local setup

Configure the database connection in `.env`, then run:

```bash
php artisan migrate
```

Set up an admin account before signing in at `/login`.

### Docker Compose and service architecture

The Compose stack runs Nginx, Laravel, and PostgreSQL as separate services. Nginx is the only service published to the host on port 80. Laravel listens on port 8000 inside the Compose network, and PostgreSQL listens on port 5432 inside that network. The database port is not published to client networks. `DB_HOST=database` resolves through Compose service discovery. PostgreSQL data, Laravel storage, and uploaded photos use persistent Docker volumes.

1. Make sure `.env` exists and contains an `APP_KEY`. If needed, create it from `.env.example`, then generate a key:

   ```powershell
   Copy-Item .env.example .env
   php artisan key:generate
   ```

   Skip `Copy-Item` when `.env` already exists so you keep your local configuration.

2. Build and start the containers, then migrate the Compose database:

   ```powershell
   docker compose up --build -d
   docker compose exec app php artisan migrate --force
   ```

3. Open `http://localhost` (or `http://localhost:8080` if `HTTP_PORT=8080` is set in `.env`). The Compose database is separate from the PostgreSQL database installed on Windows.

Useful commands:

```powershell
docker compose ps
docker compose logs -f nginx app database
docker compose down
```

Do not add `-v` to `docker compose down` unless you intend to delete the Compose database and uploaded-file volumes.

### GNS3 network and access policy

Run Docker Compose on the Linux Docker Host attached to the GNS3 server segment. Assign that host an unused address in `192.168.102.0/24`, with `192.168.102.1` as its gateway. Docker Compose keeps Nginx, Laravel, and PostgreSQL on a private container network; only Nginx port 80 is published on the Docker Host.

The project address plan is:

```text
LAN Client:         192.168.101.0/24, gateway 192.168.101.1
LAN Server/Docker:  192.168.102.0/24, gateway 192.168.102.1
LAN Admin:          192.168.103.0/24, gateway 192.168.103.1
```

The MikroTik CHR routes between these segments. Allow clients to reach the Docker Host on TCP port 80. Do not expose PostgreSQL port 5432 to the client segment; Laravel reaches it internally as `database:5432`. Restrict the admin segment and router-management access to authorized devices. The expected HTTP path is client, switch, CHR, server switch, Docker Host Nginx, Laravel, then PostgreSQL.

From a client in the GNS3 LAN Client segment, browse to `http://<Docker-Host-IP>` and `/api/products`. That request should cross the CHR; it should not use `localhost` or access PostgreSQL directly.

### Skenario penerimaan manual

| Kebutuhan | Langkah | Hasil yang diharapkan |
| --- | --- | --- |
| KF-01 Katalog | Buka halaman utama. | Semua produk menampilkan foto, judul, deskripsi, harga, dan kategori. |
| KF-02 Filter kategori | Pilih tombol kategori, lalu pilih **All products**. | Hanya kategori terpilih yang tampil; tombol All mengembalikan semua produk. |
| KF-03 WhatsApp | Tekan produk atau tombol pemesanan. | WhatsApp penjual terbuka dengan nama produk pada pesan. |
| KF-04/KF-05 Login dan akses | Buka `/admin` tanpa login, lalu coba login dengan sandi salah dan benar. | Pengunjung diarahkan ke login; sandi salah ditolak; akun sah masuk ke admin. |
| KF-06–KF-10 Kelola produk | Buat produk dengan foto dan seluruh kolom; edit produk; ganti foto; hapus produk. | Perubahan tersimpan di PostgreSQL dan langsung terlihat di katalog. Form menolak kolom wajib kosong atau file foto yang tidak didukung. |
| KF-11 Logout | Tekan logout lalu buka `/admin` lagi. | Sesi berakhir dan halaman admin meminta login kembali. |

| Jalur jaringan | Pengujian | Hasil yang diharapkan |
| --- | --- | --- |
| Client → Docker Host TCP 80 | Dari LAN Client, buka `http://<Docker-Host-IP>` atau jalankan `curl -I http://<Docker-Host-IP>`. | Katalog terjawab melalui CHR dan Nginx. |
| Client → PostgreSQL TCP 5432 | Coba koneksi dari LAN Client ke port database. | Koneksi ditolak; PostgreSQL hanya menerima trafik internal Compose. |
| Persistensi | Tambah produk, restart Compose tanpa `-v`, lalu buka katalog lagi. | Produk dan foto tetap tersimpan. |

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

In addition, [Laracasts](https://laracasts.com) contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

You can also watch bite-sized lessons with real-world projects on [Laravel Learn](https://laravel.com/learn), where you will be guided through building a Laravel application from scratch while learning PHP fundamentals.

## Agentic Development

Laravel's predictable structure and conventions make it ideal for AI coding agents like Claude Code, Cursor, and GitHub Copilot. Install [Laravel Boost](https://laravel.com/docs/ai) to supercharge your AI workflow:

```bash
composer require laravel/boost --dev

php artisan boost:install
```

Boost provides your agent 15+ tools and skills that help agents build Laravel applications while following best practices.

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
