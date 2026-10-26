## 5. Implementasi Laravel

Gunakan rancangan UI pada dokumen ini sebagai referensi utama. Implementasikan pada proyek Laravel yang sedang terbuka di VS Code.

### Controller

- Buat `SchedulerController` mengikuti namespace dan struktur Controller yang digunakan proyek.
- `index()` mengembalikan view `scheduler.index`.
- `loadDatatables()` menangani permintaan AJAX untuk memuat data tabel.
- `store()` memvalidasi dan menyimpan jadwal menggunakan Model yang sesuai.
- Sebelum menentukan nama Model, periksa apakah `MSchedulerModel` sudah ada. Jika tidak ada, periksa Model terkait dan konfirmasikan nama yang tepat sebelum membuat Model baru.
- Gunakan validasi server-side dan respons JSON yang konsisten dengan pola aplikasi.

### View

- Buat `resources/views/scheduler/index.blade.php`.
- Gunakan `@extends('layouts.newlayout')`.
- Gunakan `@section('newcontent')`.
- Gunakan `@push('scripts')` dan `@vite('resources/js/scheduler/scheduler.js')`.
- Pertahankan desain HTML yang sudah ditentukan dalam dokumen.
- Sesuaikan struktur section dan penempatan `@endsection` dengan pola Blade proyek.
- Tambahkan atribut `name` yang sesuai pada input yang dikirim ke server.
- Terapkan perlindungan CSRF sesuai mekanisme request yang digunakan.
- Pastikan event JavaScript bekerja saat file dimuat sebagai ES module. Hindari inline handler yang memanggil fungsi yang tidak tersedia pada scope global.

### JavaScript

Buat `resources/js/scheduler/scheduler.js`.

- Definisikan URL untuk memuat DataTables dan menyimpan jadwal menggunakan route Laravel atau pola URL yang konsisten dengan proyek.
- Inisialisasi DataTables menggunakan library dan pola konfigurasi yang sudah dipakai proyek.
- Tangani validasi JSON pada payload.
- Tangani format, minify, clear, preset waktu, ringkasan jadwal, reset form, dan submit.
- Gunakan AJAX sesuai pola jQuery atau Axios yang tersedia di proyek.
- Tampilkan pesan sukses dan gagal berdasarkan respons backend.
- Jangan hanya menampilkan simulasi request body; kirim data ke backend Laravel yang sebenarnya.

### Routes

Tambahkan route pada `routes/web.php` dalam middleware:

`auth` dan `check.menu.access`

Route yang dibutuhkan:
- `GET /scheduler` untuk `index`.
- `GET /scheduler/datatables` untuk `loadDatatables`.
- `POST /scheduler/simpan` untuk `store`.

Gunakan nama route yang konsisten, misalnya `scheduler.index`, `scheduler.datatables`, dan `scheduler.store`. Periksa potensi konflik dengan route yang sudah ada.

### Validasi dan keamanan

- `action_type` wajib diisi dan maksimal 50 karakter.
- `payload` harus JSON valid.
- Tanggal dan jam wajib diisi serta dikonversi secara konsisten ke zona waktu aplikasi.
- Zona waktu tampilan yang diminta adalah WIB (UTC+7).
- Tentukan status awal sesuai desain database dan Model yang benar-benar digunakan.
- Jangan percaya pada status atau identitas pembuat yang dikirim dari browser.
- Jangan menampilkan kredensial atau isi file `.env`.

### Verifikasi

- Periksa struktur proyek sebelum mengubah file.
- Pastikan layout `layouts.newlayout` dan penggunaan sidebar mengikuti pola proyek.
- Pastikan DataTables memuat data dari endpoint Laravel.
- Pastikan tombol Simpan menyimpan data ke database melalui Model.
- Laporkan file yang dibuat atau diubah.
- Jangan menjalankan migration, menghapus data, atau mengubah database tanpa persetujuan.

Implementasikan hanya fitur yang dijelaskan di dokumen ini. Jangan menambahkan fitur lain tanpa konfirmasi.