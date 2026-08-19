<x-app-layout>
    <div class="flex flex-col gap-stack-lg max-w-4xl mx-auto">
        <div>
            <nav aria-label="Breadcrumb" class="flex text-label-sm font-label-sm text-on-surface-variant mb-2">
                <ol class="inline-flex items-center space-x-1 md:space-x-2">
                    <li class="inline-flex items-center">
                        <a class="hover:text-primary transition-colors" href="{{ route('admin.dashboard') }}">Dashboard Admin</a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <span class="material-symbols-outlined text-[16px] mx-1">chevron_right</span>
                            <span class="text-on-surface">Tambah Admin</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <h2 class="text-h1-mobile font-h1-mobile md:text-h1 md:font-h1 text-primary">Tambah User Admin</h2>
            <p class="text-body-md font-body-md text-on-surface-variant mt-unit">Buat akun dengan hak akses penuh (Administrator) untuk pengelola sistem HR.</p>
        </div>

        @if($errors->any())
            <div class="bg-error-container text-on-error-container p-4 rounded-lg shadow-soft">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <div class="bg-surface-container-lowest border border-outline-variant rounded-xl shadow-soft p-stack-lg">
            <form method="POST" action="{{ route('admin.users.store-admin') }}" class="flex flex-col gap-6">
                @csrf
                
                <div class="flex flex-col gap-stack-md pb-stack-md border-b border-surface-container-high">
                    <h3 class="text-h3 font-h3 text-steel-blue flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary-container">shield_person</span>
                        Kredensial Admin Baru
                    </h3>
                    
                    <div>
                        <label class="block text-label-md mb-2 text-on-surface">Nama Lengkap <span class="text-error">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" class="w-full bg-surface-container-lowest border border-outline-variant rounded-lg px-4 py-3 text-body-md text-on-surface focus:border-primary-container focus:ring-1 focus:ring-primary-container transition-colors" required>
                    </div>
                    
                    <div>
                        <label class="block text-label-md mb-2 text-on-surface">Alamat Email <span class="text-error">*</span></label>
                        <input type="email" name="email" value="{{ old('email') }}" class="w-full bg-surface-container-lowest border border-outline-variant rounded-lg px-4 py-3 text-body-md text-on-surface focus:border-primary-container focus:ring-1 focus:ring-primary-container transition-colors" required>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-label-md mb-2 text-on-surface">Password <span class="text-error">*</span></label>
                            <input type="password" name="password" class="w-full bg-surface-container-lowest border border-outline-variant rounded-lg px-4 py-3 text-body-md text-on-surface focus:border-primary-container focus:ring-1 focus:ring-primary-container transition-colors" required>
                        </div>
                        <div>
                            <label class="block text-label-md mb-2 text-on-surface">Konfirmasi Password <span class="text-error">*</span></label>
                            <input type="password" name="password_confirmation" class="w-full bg-surface-container-lowest border border-outline-variant rounded-lg px-4 py-3 text-body-md text-on-surface focus:border-primary-container focus:ring-1 focus:ring-primary-container transition-colors" required>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end pt-2">
                    <a href="{{ route('admin.dashboard') }}" class="px-6 py-2.5 rounded-lg border border-outline-variant text-on-surface-variant text-label-md font-bold hover:bg-surface-container-high transition-colors mr-3">Batal</a>
                    <button type="submit" class="bg-primary-container text-on-primary-container px-6 py-2.5 rounded-lg text-label-md font-bold hover:bg-surface-tint transition-colors flex items-center gap-2 shadow-sm">
                        <span class="material-symbols-outlined text-[18px]">person_add</span>
                        Simpan Admin
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
