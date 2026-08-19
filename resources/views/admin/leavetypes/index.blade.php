<x-app-layout>
    <div class="flex flex-col gap-stack-lg">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-stack-md">
            <div>
                <h2 class="text-h1-mobile font-h1-mobile md:text-h1 md:font-h1 text-primary">Manajemen Tipe Cuti</h2>
                <p class="text-body-md font-body-md text-on-surface-variant mt-unit">Kelola berbagai jenis cuti yang tersedia.</p>
            </div>
            <a href="{{ route('admin.leavetypes.create') }}" class="bg-primary-container text-on-primary border border-transparent px-6 py-3 rounded-lg text-label-md font-label-md shadow-sm hover:bg-primary transition-colors flex items-center gap-2 w-fit">
                <span class="material-symbols-outlined">add_task</span>
                Tambah Tipe Cuti
            </a>
        </div>

        @if(session('success'))
            <div class="bg-primary-fixed text-on-primary-fixed p-4 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-surface-container-lowest border border-outline-variant rounded-xl shadow-soft p-stack-md">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-surface-container-low border-b border-outline-variant">
                            <th class="py-3 px-4 text-label-sm font-label-sm text-on-surface-variant">Nama Tipe Cuti</th>
                            <th class="py-3 px-4 text-label-sm font-label-sm text-on-surface-variant">Deskripsi</th>
                            <th class="py-3 px-4 text-label-sm font-label-sm text-on-surface-variant">Jatah Default (Hari)</th>
                            <th class="py-3 px-4 text-label-sm font-label-sm text-on-surface-variant">Status</th>
                            <th class="py-3 px-4 text-label-sm font-label-sm text-on-surface-variant text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-body-md font-body-md">
                        @forelse($leaveTypes as $type)
                        <tr class="border-b border-outline-variant hover:bg-surface-container-high transition-colors">
                            <td class="py-3 px-4 font-bold">{{ $type->name }}</td>
                            <td class="py-3 px-4 text-on-surface-variant">{{ Str::limit($type->description, 50) }}</td>
                            <td class="py-3 px-4">{{ $type->default_days }} Hari</td>
                            <td class="py-3 px-4">
                                @if($type->is_active)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-label-sm font-label-sm bg-primary-fixed text-on-primary-fixed">Aktif</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-label-sm font-label-sm bg-error-container text-on-error-container">Nonaktif</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-right">
                                <a href="{{ route('admin.leavetypes.edit', $type->id) }}" class="text-secondary hover:underline mr-3">Edit</a>
                                <form action="{{ route('admin.leavetypes.destroy', $type->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menonaktifkan tipe cuti ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-error hover:underline">Nonaktifkan</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-4 px-4 text-center text-on-surface-variant">Tidak ada data tipe cuti.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $leaveTypes->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
