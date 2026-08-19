<x-app-layout>
    <div class="flex flex-col gap-stack-lg max-w-4xl mx-auto">
        <div>
            <a href="{{ route('admin.employees.index') }}" class="text-primary-container hover:underline mb-4 inline-block">&larr; Kembali ke Daftar</a>
            <h2 class="text-h1-mobile font-h1-mobile md:text-h1 md:font-h1 text-primary">Tambah Pegawai</h2>
        </div>

        @if($errors->any())
            <div class="bg-error-container text-on-error-container p-4 rounded-lg">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-surface-container-lowest border border-outline-variant rounded-xl shadow-soft p-stack-lg">
            <form method="POST" action="{{ route('admin.employees.store') }}" class="flex flex-col gap-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-label-md mb-2">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="w-full border-outline-variant rounded-lg" required>
                    </div>
                    <div>
                        <label class="block text-label-md mb-2">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="w-full border-outline-variant rounded-lg" required>
                    </div>
                    <div>
                        <label class="block text-label-md mb-2">Password</label>
                        <input type="password" name="password" class="w-full border-outline-variant rounded-lg" required>
                    </div>
                    <div>
                        <label class="block text-label-md mb-2">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="w-full border-outline-variant rounded-lg" required>
                    </div>
                </div>
                
                <hr class="border-outline-variant border-t">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-label-md mb-2">Nomor Induk Pegawai (NIK)</label>
                        <input type="text" name="employee_number" value="{{ old('employee_number') }}" class="w-full border-outline-variant rounded-lg" required>
                    </div>
                    <div>
                        <label class="block text-label-md mb-2">Nomor Telepon</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" class="w-full border-outline-variant rounded-lg">
                    </div>
                    <div>
                        <label class="block text-label-md mb-2">Departemen</label>
                        <input type="text" name="department" value="{{ old('department') }}" class="w-full border-outline-variant rounded-lg" required>
                    </div>
                    <div>
                        <label class="block text-label-md mb-2">Posisi / Jabatan</label>
                        <input type="text" name="position" value="{{ old('position') }}" class="w-full border-outline-variant rounded-lg" required>
                    </div>
                    <div>
                        <label class="block text-label-md mb-2">Tanggal Bergabung</label>
                        <input type="date" name="join_date" value="{{ old('join_date') }}" class="w-full border-outline-variant rounded-lg" required>
                    </div>
                    <div>
                        <label class="block text-label-md mb-2">Kuota Cuti Tahunan</label>
                        <input type="number" name="annual_leave_quota" value="{{ old('annual_leave_quota', 12) }}" min="0" class="w-full border-outline-variant rounded-lg" required>
                    </div>
                    <div>
                        <label class="block text-label-md mb-2">Status</label>
                        <select name="status" class="w-full border-outline-variant rounded-lg" required>
                            <option value="ACTIVE" {{ old('status') == 'ACTIVE' ? 'selected' : '' }}>Aktif</option>
                            <option value="INACTIVE" {{ old('status') == 'INACTIVE' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>
                </div>

                <div class="flex justify-end pt-4">
                    <button type="submit" class="bg-primary-container text-on-primary px-6 py-3 rounded-lg text-label-md font-bold hover:bg-primary transition-colors">Simpan Data Pegawai</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
