# Cerita Dibalik Project LeaveFlow (Sistem Manajemen Cuti)

Halo! Jadi, project ini namanya **LeaveFlow**. Sederhananya, ini adalah aplikasi manajemen cuti karyawan berbasis web yang saya bangun dari awal. Saya membuat project ini karena melihat banyak perusahaan yang masih mengurus cuti karyawannya secara manual atau pakai Excel, yang kadang bikin pusing HRD-nya sendiri.

Project ini dibangun menggunakan **Laravel 11** dan **Tailwind CSS**. Untuk databasenya, saat ini menggunakan SQLite biar gampang di-setup (tapi tentu saja sangat siap untuk di-scale ke MySQL atau PostgreSQL).

**🔗 Link Github Project:**
[https://github.com/AsmanRudi/cuti_karyawan](https://github.com/AsmanRudi/cuti_karyawan)

---

### Kenapa Project Ini Menarik?

Menurut saya, project ini bukan sekadar aplikasi CRUD (Create, Read, Update, Delete) biasa. Ada beberapa tantangan teknis yang berhasil saya selesaikan di sini:

1. **Keamanan & Akses (RBAC):** Saya memisahkan antara ruang untuk HRD (Admin) dan Karyawan. Karyawan biasa nggak akan bisa ngintip atau mengakses halaman persetujuan cuti yang khusus buat HRD.
2. **Cegah Tabrakan Cuti:** Sistemnya cukup pintar untuk nolak pengajuan cuti kalau tanggal yang diajukan bertabrakan, atau kalau jatah cuti tahunan karyawannya ternyata udah habis. Jadi HRD nggak perlu ngecek satu-satu lagi secara manual.
3. **Database yang Aman (ACID Transactions):** Kalau ada karyawan yang pengajuan cutinya di-approve, sistem akan memastikan kuota cuti berkurang secara presisi tanpa ada error walau diakses bebarengan.
4. **Siap Jadi API:** Aplikasi ini juga udah dibekali sistem API (pakai Laravel Sanctum). Jadi ke depannya kalau mau dibikinin versi aplikasi mobile-nya (Android/iOS), backend-nya udah siap banget!

---

### Tampilan Aplikasinya Kayak Gimana Sih?

Berikut ini beberapa cuplikan antarmuka aplikasinya. Saya mendesainnya sebersih mungkin biar gampang dipakai.

**1. Halaman Dashboard Admin (HRD)**
Di halaman ini, HRD bisa langsung melihat rangkuman data cuti, grafik, dan bisa langsung memproses persetujuan (approve/reject) pengajuan cuti yang masuk.
<img src="./database/docs/dashboard HRD.png" width="100%">

**2. Halaman Laporan (HRD)**
HRD butuh laporan akhir bulan? Ada! Di halaman ini HRD bisa memfilter rekap data cuti berdasarkan bulan atau departemen.
<img src="./database/docs/laporan.png" width="100%">

**3. Halaman Dashboard Karyawan**
Nah, kalau ini tampilan pas karyawan login. Karyawan bisa langsung tahu sisa kuota cuti mereka berapa, dan bisa memantau status pengajuan cuti yang udah pernah dibuat.
<img src="./database/docs/dashboard karyawan.png" width="100%">

**4. Formulir Pengajuan Cuti**
Formulir buat ngajuin cutinya. Cukup simpel, pilih tanggal mulai dan selesai, pilih tipe cuti, terus masukin alasannya. Kalau jatah cuti nggak cukup, sistem bakal langsung ngasih peringatan.
<img src="./database/docs/formulir pengajuan cuti.png" width="100%">

---

### 🐛 Bug Paling Sulit yang Pernah Saya Hadapi

Di setiap project pasti ada tantangan, dan di LeaveFlow ini, ada satu *bug* yang cukup bikin pusing. Namanya **Race Condition pada Kuota Cuti**.

**🔍 Bagaimana Saya Menemukannya?**
Waktu itu saya sedang melakukan *stress test* (menguji aplikasi dengan cara ekstrem). Saya mensimulasikan kejadian di mana seorang HRD melakukan *klik ganda (double click)* dengan sangat cepat pada tombol "Approve", atau saat karyawan mencoba mengeklik tombol "Submit" pengajuan cuti berkali-kali dalam hitungan milidetik.
Ternyata, aplikasinya sempat kebingungan! Kuota cuti karyawan yang tadinya sisa 2 hari, tiba-tiba malah tembus dan menjadi minus (-1). Hal ini terjadi karena sistem membaca dan menyetujui dua permintaan secara persis bersamaan sebelum sistem sempat memotong sisa kuota di database.

**🛠️ Bagaimana Cara Memperbaikinya?**
Solusinya tidak bisa sekadar mematikan tombol di sisi tampilan antarmuka (karena gampang diakali). Saya harus memperbaikinya dari akar (sistem Backend). 
Saya mengimplementasikan teknik **Pessimistic Locking** dipadukan dengan **Database Transactions** bawaan Laravel (`DB::transaction` dan metode `lockForUpdate()`).
Logika barunya menjadi begini: Ketika sistem sedang memproses persetujuan satu cuti, baris data kuota karyawan tersebut akan "dikunci" secara ketat. Permintaan klik kedua yang masuk di milidetik yang sama akan dipaksa antre menunggu sampai proses pertama selesai memotong kuota. Setelah proses pertama selesai dan gembok dibuka, sistem akan mengecek ulang kuotanya untuk permintaan kedua (yang mana pastinya akan ditolak karena jatahnya sudah habis).

**🎉 Apa Hasil Akhirnya?**
Hasilnya sangat melegakan! Sekarang, sistem benar-benar kebal. Walaupun tombolnya diklik 100 kali secara brutal atau diserang menggunakan *script* secara bersamaan, kuota cuti karyawan akan selalu terpotong secara akurat dan mustahil bisa menjadi minus (bernilai negatif). Integritas data cuti perusahaan 100% dijamin aman.

---

---

### 💻 Contoh Kode yang Paling Rapi (Clean Code)

Salah satu bagian kode di project ini yang menurut saya paling rapi dan menggambarkan penerapan *Best Practices* Laravel ada di bagian **`LeaveApprovalController`** saat memproses persetujuan cuti.

Kode ini sangat mudah dibaca (*readable*), ringkas, tapi sangat kokoh. Berikut adalah kodenya:

```php
public function update(Request $request, LeaveRequest $leaveRequest)
{
    // 1. Validasi Input (Hanya menerima APPROVED atau REJECTED)
    $request->validate([
        'status' => ['required', 'in:APPROVED,REJECTED'],
        'admin_notes' => ['nullable', 'string'],
    ]);

    // 2. State Guard (Mencegah pengajuan yang sama diproses 2 kali)
    if ($leaveRequest->status !== 'PENDING') {
        return back()->with('error', 'Pengajuan ini sudah diproses sebelumnya.');
    }

    // 3. Database Transaction (Memastikan tidak ada data yang corrupt jika server mati mendadak)
    DB::transaction(function () use ($request, $leaveRequest) {
        $leaveRequest->update([
            'status'      => $request->status,
            'admin_notes' => $request->admin_notes,
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);
    });

    // 4. Clean Redirect dengan Pesan Dinamis
    return redirect()->route('admin.approvals.index')
        ->with('success', 'Pengajuan cuti berhasil ' . ($request->status === 'APPROVED' ? 'disetujui' : 'ditolak') . '.');
}
```

**Kenapa saya suka dengan kode ini?**
- **Satu Fungsi, Satu Tujuan (Single Responsibility):** Fungsinya jelas hanya untuk memperbarui status persetujuan.
- **Aman (*Fail-Fast*):** Saya mengecek apakah status masih `PENDING` di awal (Baris 10). Kalau bukan, langsung *return error* tanpa mengeksekusi kode di bawahnya.
- **Efektif:** Menggunakan `DB::transaction` agar kalau terjadi error saat menyimpan data, sistem akan membatalkannya secara otomatis (Rollback).
- **Elegan:** Di bagian *return*, saya menggunakan *Ternary Operator* `(...) ? 'disetujui' : 'ditolak'` agar tidak perlu menulis `if-else` berulang kali hanya untuk menampilkan pesan sukses.

---

Secara keseluruhan, LeaveFlow ini adalah bentuk pembuktian kemampuan saya dalam membangun sebuah sistem HR skala perusahaan (Enterprise) yang aman, cepat, dan punya tampilan yang modern. 

Semoga project ini bisa memberikan gambaran jelas tentang cara saya ngoding dan membangun arsitektur sebuah aplikasi!
