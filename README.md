# Fleet Management System

Sistem manajemen armada kendaraan yang komprehensif dengan fitur administrasi dan persetujuan berjenjang.

## Fitur Utama

### 1. Administrasi
- **Input Pemesanan Kendaraan**: Admin dapat menginputkan pemesanan kendaraan dengan menentukan driver serta penyetuju berjenjang
- **Persetujuan Berjenjang**: Sistem persetujuan minimal 2 level untuk pemesanan kendaraan
- **Dashboard Admin**: Dashboard yang menampilkan grafik pemakaian kendaraan dan statistik keseluruhan
- **Laporan Periodik**: Sistem laporan pemesanan kendaraan yang dapat di-export ke Excel

### 2. Manajemen Booking
- **Pemesanan Kendaraan**: Pengguna dapat memesan kendaraan dengan detail tujuan dan waktu
- **Pemilihan Driver**: Menetapkan driver untuk setiap pemesanan
- **Status Booking**: Pelacakan status booking dari draft hingga selesai

### 3. Sistem Persetujuan
- **Approval Berjenjang**: Minimal 2 level persetujuan untuk setiap pemesanan
- **Dashboard Approval**: Daftar pemesanan yang menunggu persetujuan dengan tombol approve/reject
- **Filter Tanggal**: Fitur filter tanggal di halaman approval
- **Tombol Approve/Reject**: Akses langsung untuk menyetujui atau menolak pemesanan

### 4. Dashboard Pengguna
- **Statistik Keseluruhan**: Tampilan menyeluruh tentang sistem manajemen armada
- **Grafik dan Visualisasi**: Tren booking dan penggunaan kendaraan
- **Statistik Real-time**: Total bookings, pending approval, approved, kendaraan, dll

### 5. Laporan dan Export
- **Laporan Booking**: Filter berdasarkan tanggal dan status
- **Export Excel**: Fitur export laporan ke format Excel
- **Pagination**: Sistem pagination di laporan booking
- **Filter Tanggal**: Filter tanggal di laporan booking

### 6. Keamanan dan Otentikasi
- **Otentikasi Laravel Fortify**: Sistem login dan registrasi yang aman
- **Otorisasi Berbasis Peran**: Pembatasan akses berdasarkan peran pengguna (admin, approver, employee)
- **Validasi dan Error Handling**: Validasi input dan penanganan error yang komprehensif

## Teknologi yang Digunakan

- **Laravel 12**: Framework PHP untuk pengembangan backend
- **Livewire**: Framework untuk mengembangkan komponen interaktif dengan PHP
- **Alpine.js**: Framework JavaScript untuk interaktivitas frontend
- **Tailwind CSS**: Framework CSS untuk styling
- **PostgreSQL**: Database untuk menyimpan data (kompatibel juga dengan MySQL)
- **Chart.js**: Visualisasi data grafik

## Instalasi

1. Clone repositori ini:
   ```bash
   git clone <repository-url>
   cd fleet-management-system
   ```

2. Install dependensi PHP:
   ```bash
   composer install
   ```

3. Install dependensi Node.js:
   ```bash
   npm install
   ```

4. Salin file `.env` dan atur konfigurasi database:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. Atur konfigurasi database di file `.env`

6. Jalankan migrasi database:
   ```bash
   php artisan migrate --seed
   ```

7. Jalankan server pengembangan:
   ```bash
   php artisan serve
   npm run dev
   ```

## Cara Menjalankan Aplikasi

### Development Mode
Untuk menjalankan aplikasi dalam mode pengembangan:

1. Jalankan server PHP Laravel:
   ```bash
   php artisan serve
   ```

2. Jalankan development server Vite (untuk hot reload CSS/JS):
   ```bash
   npm run dev
   ```

Aplikasi akan berjalan di `http://localhost:8000`

### Production Mode
Untuk menjalankan aplikasi di lingkungan produksi:

1. Build asset untuk produksi:
   ```bash
   npm run build
   ```

2. Pastikan server web (Apache/Nginx) mengarah ke direktori `public/`

### Migrasi dan Seeder
Untuk menjalankan migrasi dan seed data dummy:
```bash
php artisan migrate:fresh --seed
```

Untuk me-reset data dan menjalankan migrasi ulang:
```bash
php artisan migrate:refresh --seed
```

### Testing
Untuk menjalankan unit tests:
```bash
php artisan test
```

Atau dengan phpunit langsung:
```bash
./vendor/bin/phpunit
```

## Struktur Pengguna

- **Admin**: Pengguna dengan akses penuh untuk semua fitur sistem
- **Approver**: Pengguna dengan izin untuk menyetujui pemesanan kendaraan
- **Employee**: Pengguna biasa yang dapat memesan kendaraan

## Penggunaan

### Bagi Admin
1. Login sebagai admin
2. Gunakan menu "Admin Dashboard" untuk mengakses fitur admin
3. Gunakan "Create Booking" untuk membuat pemesanan kendaraan
4. Akses "Booking Reports" untuk melihat laporan dan export ke Excel
5. Gunakan "Approvals" untuk menyetujui pemesanan yang menunggu

### Bagi Pengguna Biasa
1. Login dengan akun user biasa
2. Akses dashboard untuk melihat statistik keseluruhan
3. Gunakan "Create Booking" untuk memesan kendaraan
4. Gunakan "My Approvals" untuk menyetujui pemesanan jika memiliki peran approver

## Kontribusi

Silakan fork repositori ini dan kirim pull request untuk kontribusi fitur atau perbaikan.

## Lisensi

Proyek ini dilisensikan di bawah MIT License.