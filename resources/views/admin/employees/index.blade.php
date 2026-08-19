<x-app-layout>
    <div class="flex flex-col gap-stack-lg">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-stack-md">
            <div>
                <h2 class="text-h1-mobile font-h1-mobile md:text-h1 md:font-h1 text-primary">Manajemen Pegawai</h2>
                <p class="text-body-md font-body-md text-on-surface-variant mt-unit">Kelola data pegawai di sistem ini.</p>
            </div>
            <a href="{{ route('admin.employees.create') }}" class="bg-primary-container text-on-primary border border-transparent px-6 py-3 rounded-lg text-label-md font-label-md shadow-sm hover:bg-primary transition-colors flex items-center gap-2 w-fit">
                <span class="material-symbols-outlined">person_add</span>
                Tambah Pegawai
            </a>
        </div>

        @if(session('success'))
            <div class="bg-primary-fixed text-on-primary-fixed p-4 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-surface-container-lowest border border-outline-variant rounded-xl shadow-soft p-stack-md">
            <form method="GET" action="{{ route('admin.employees.index') }}" class="flex flex-wrap gap-4 mb-stack-md">
                <input type="text" name="search" placeholder="Cari nama, email, NIK..." value="{{ request('search') }}" class="border-outline-variant rounded-lg flex-grow">
                <select name="department" class="border-outline-variant rounded-lg">
                    <option value="">Semua Departemen</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept }}" {{ request('department') == $dept ? 'selected' : '' }}>{{ $dept }}</option>
                    @endforeach
                </select>
                <select name="status" class="border-outline-variant rounded-lg">
                    <option value="">Semua Status</option>
                    <option value="ACTIVE" {{ request('status') == 'ACTIVE' ? 'selected' : '' }}>Aktif</option>
                    <option value="INACTIVE" {{ request('status') == 'INACTIVE' ? 'selected' : '' }}>Nonaktif</option>
                </select>
                <button type="submit" class="bg-surface-variant text-on-surface-variant px-4 py-2 rounded-lg hover:bg-outline-variant transition-colors">Filter</button>
                <a href="{{ route('admin.employees.index') }}" class="text-on-surface-variant hover:underline flex items-center px-2">Reset</a>
            </form>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-surface-container-low border-b border-outline-variant">
                            <th class="py-3 px-4 text-label-sm font-label-sm text-on-surface-variant">NIK</th>
                            <th class="py-3 px-4 text-label-sm font-label-sm text-on-surface-variant">Nama / Email</th>
                            <th class="py-3 px-4 text-label-sm font-label-sm text-on-surface-variant">Departemen & Posisi</th>
                            <th class="py-3 px-4 text-label-sm font-label-sm text-on-surface-variant">Kuota Cuti</th>
                            <th class="py-3 px-4 text-label-sm font-label-sm text-on-surface-variant">Status</th>
                            <th class="py-3 px-4 text-label-sm font-label-sm text-on-surface-variant text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-body-md font-body-md">
                        @forelse($employees as $emp)
                        <tr class="border-b border-outline-variant hover:bg-surface-container-high transition-colors">
                            <td class="py-3 px-4">{{ $emp->employee_number }}</td>
                            <td class="py-3 px-4">
                                <div class="font-bold">{{ $emp->user->name }}</div>
                                <div class="text-sm text-on-surface-variant">{{ $emp->user->email }}</div>
                            </td>
                            <td class="py-3 px-4">
                                <div>{{ $emp->department }}</div>
                                <div class="text-sm text-on-surface-variant">{{ $emp->position }}</div>
                            </td>
                            <td class="py-3 px-4">{{ $emp->annual_leave_quota }} Hari</td>
                            <td class="py-3 px-4">
                                @if($emp->status == 'ACTIVE')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-label-sm font-label-sm bg-primary-fixed text-on-primary-fixed">Aktif</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-label-sm font-label-sm bg-error-container text-on-error-container">Nonaktif</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-right">
                                <a href="{{ route('admin.employees.edit', $emp->id) }}" class="text-secondary hover:underline mr-3">Edit</a>
                                <form action="{{ route('admin.employees.destroy', $emp->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menonaktifkan pegawai ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-error hover:underline">Nonaktifkan</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-4 px-4 text-center text-on-surface-variant">Tidak ada data pegawai.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $employees->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
