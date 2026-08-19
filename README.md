# LeaveFlow - Employee Leave Management System

LeaveFlow adalah aplikasi manajemen cuti pegawai berbasis web (HR Portal) yang dirancang dengan **Laravel 11**, **Tailwind CSS**, dan **SQLite**. Sistem ini menggunakan arsitektur peran (Role-Based Access Control) yang membedakan hak akses antara Karyawan (Employee) dan Admin/HR.

Proyek ini dibangun sebagai *production-ready portfolio project* yang mengedepankan kualitas kode, *clean architecture*, keamanan, dan desain UI/UX yang modern.

---

## 🏗️ Arsitektur Teknologi

- **Framework:** Laravel 11 (PHP 8.2+)
- **Database:** SQLite (lokasi: `database/database.sqlite`)
- **Frontend/UI:** Blade Templating Engine + Tailwind CSS (Custom Design System)
- **Authentication:** Laravel Breeze (Session untuk Web) & Laravel Sanctum (Token untuk REST API)

---

## 👥 Alur Akses (Role System)

Sistem memiliki dua peran utama (`role` pada tabel `users`):

### 1. `EMPLOYEE` (Karyawan)
- **Tujuan:** Melakukan pengajuan cuti dan melihat riwayat.
- **Fitur Utama:**
  - **Dashboard:** Melihat simulasi kuota cuti tahunan dan riwayat aktivitas terakhir.
  - **Request Leave:** Mengisi form pengajuan cuti. Sistem akan melakukan **validasi otomatis**:
    1. Memastikan tanggal yang diajukan tidak bertabrakan (*overlap*) dengan pengajuan cuti lain.
    2. Memastikan sisa **kuota cuti tahunan** cukup (khusus untuk tipe cuti tahunan).
  - **Leave History:** Melihat status cuti (PENDING, APPROVED, REJECTED, CANCELLED) dan dapat membatalkan pengajuan yang masih PENDING.

### 2. `ADMIN` (HR / Manager)
- **Tujuan:** Mengelola data master dan menyetujui/menolak pengajuan cuti.
- **Fitur Utama:**
  - **Dashboard:** Ringkasan jumlah pegawai dan pengajuan cuti yang masih *pending*.
  - **Approval Inbox:** Menyetujui (`APPROVED`) atau Menolak (`REJECTED`) cuti. Saat disetujui, kuota cuti tahunan karyawan akan langsung dikalkulasi ulang secara dinamis.
  - **Employee Data:** CRUD (Create, Read, Update, Delete) data pegawai, termasuk menentukan kuota cuti awal tiap pegawai.
  - **Leave Types:** CRUD jenis cuti (Cuti Tahunan, Cuti Sakit, Cuti Melahirkan, dll).
  - **Reports:** Melihat laporan tren cuti per bulan dan rekapitulasi data cuti berdasarkan departemen.

---

## 🗄️ Struktur Database (Relasi)

1. **`users`**
   - Menyimpan akun login (email, password ter-enkripsi, dan `role`).
2. **`employees`**
   - Relasi `1-to-1` dengan `users`.
   - Menyimpan data spesifik pegawai: NIP, jabatan, departemen, tanggal bergabung, status, dan **kuota cuti tahunan** (`annual_leave_quota`).
3. **`leave_types`**
   - Master data jenis cuti.
4. **`leave_requests`**
   - Relasi `Many-to-1` ke `employees` dan `leave_types`.
   - Menyimpan riwayat pengajuan cuti: tanggal mulai, tanggal selesai, total hari, alasan, dan status (`PENDING`, `APPROVED`, `REJECTED`, `CANCELLED`).

---

## 🌐 Dokumentasi REST API (Sanctum)

Selain aplikasi Web, sistem ini juga menyediakan REST API yang siap dihubungkan ke aplikasi *Mobile* atau *Frontend JS* terpisah.

**Base URL:** `http://localhost:8000/api`

### Auth Endpoints
- `POST /login`: Login menggunakan `email` & `password`. Mengembalikan `token`.
- `POST /logout` (Requires Token): Menghapus token aktif.

### Employee Endpoints (Memerlukan Token Karyawan)
- `GET /employee/leaves`: Mengambil daftar riwayat cuti karyawan.
- `GET /employee/leaves/quota`: Mengambil data sisa kuota cuti.
- `POST /employee/leaves`: Membuat pengajuan cuti baru.
  - *Payload:* `leave_type_id`, `start_date`, `end_date`, `reason`

### Admin Endpoints (Memerlukan Token Admin)
- `GET /admin/approvals`: Mengambil daftar semua pengajuan cuti (bisa di-filter berdasarkan `status`).
- `PUT /admin/approvals/{id}`: Memproses pengajuan cuti.
  - *Payload:* `status` (APPROVED / REJECTED), `admin_notes`

---

## 💻 Cara Menjalankan Project (Development)

Jika di masa depan Anda ingin mengembangkan ulang atau menjalankan proyek ini di mesin baru, ikuti langkah berikut:

1. Pastikan Anda memiliki PHP (>= 8.2), Composer, dan Node.js / NPM.
2. Clone atau buka folder project ini.
3. Jalankan instalasi dependensi backend:
   ```bash
   composer install
   ```
4. Jalankan instalasi dependensi frontend:
   ```bash
   npm install
   ```
5. *Build* aset UI (Tailwind):
   ```bash
   npm run build
   # atau untuk mode development: npm run dev
   ```
6. Setup Database (SQLite sudah dikonfigurasi). Pastikan file `database/database.sqlite` tersedia. Jika ingin me-reset database beserta data *dummy*, jalankan:
   ```bash
   php artisan migrate:fresh --seed
   ```
7. Jalankan server lokal:
   ```bash
   php artisan serve
   ```
8. Akses di `http://localhost:8000`.

**Akun Default untuk Testing (Berdasarkan Seeder):**
- **Admin:** `admin@example.com` (Password: `password`)
- **Karyawan:** `employee@example.com` (Password: `password`)

---

## 🎨 Design System & UI/UX

Sistem antarmuka (*interface*) dibangun dengan patokan file HTML referensi (`design/stitch_integrated_leave_management_system`). Komponen utama:
- **Font:** Inter (via Google Fonts)
- **Icons:** Material Symbols Outlined
- **Custom Colors (Tailwind):** Menggunakan skema warna korporat seperti `royal-blue` (#232F72), `steel-blue` (#2F578A), `primary-container` (#121358), dan `teal-accent` (#36ADA3).
- **Layout:** Responsive *Side Navigation* + *Top App Bar* dengan arsitektur Grid Bento (Card).
- Layout terpusat di `resources/views/layouts/app.blade.php`. Mengubah struktur navigasi bisa dilakukan di file ini.

---
*Dokumen ini dibuat secara otomatis pada fase terakhir (Documentation & Polish) untuk memandu pengembang selanjutnya.*
