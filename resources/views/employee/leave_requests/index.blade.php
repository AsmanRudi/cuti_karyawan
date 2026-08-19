<x-app-layout>
    <div class="flex flex-col gap-stack-lg max-w-5xl mx-auto">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-h1-mobile font-h1-mobile md:text-h1 md:font-h1 text-primary">Riwayat Cuti</h2>
                <p class="text-body-md font-body-md text-on-surface-variant mt-unit">Daftar seluruh pengajuan cuti Anda.</p>
            </div>
            <a href="{{ route('employee.leave-requests.create') }}" class="bg-primary-container text-on-primary border border-transparent px-6 py-3 rounded-lg text-label-md font-label-md shadow-sm hover:bg-primary transition-colors flex items-center gap-2">
                <span class="material-symbols-outlined">add</span>
                Ajukan Cuti
            </a>
        </div>

        @if(session('success'))
            <div class="bg-primary-fixed text-on-primary-fixed p-4 rounded-lg">
                {{ session('success') }}
            </div>
        @endif
        
        @if(session('error'))
            <div class="bg-error-container text-on-error-container p-4 rounded-lg">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-surface-container-lowest border border-outline-variant rounded-xl shadow-soft p-stack-md">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-surface-container-low border-b border-outline-variant">
                            <th class="py-3 px-4 text-label-sm font-label-sm text-on-surface-variant">Tipe Cuti</th>
                            <th class="py-3 px-4 text-label-sm font-label-sm text-on-surface-variant">Tanggal</th>
                            <th class="py-3 px-4 text-label-sm font-label-sm text-on-surface-variant">Durasi</th>
                            <th class="py-3 px-4 text-label-sm font-label-sm text-on-surface-variant">Status</th>
                            <th class="py-3 px-4 text-label-sm font-label-sm text-on-surface-variant">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-body-md font-body-md">
                        @forelse($leaveRequests as $req)
                        <tr class="border-b border-outline-variant hover:bg-surface-container-high transition-colors">
                            <td class="py-3 px-4 font-bold">{{ $req->leaveType->name }}</td>
                            <td class="py-3 px-4 text-on-surface-variant">{{ $req->start_date->format('d M Y') }} - {{ $req->end_date->format('d M Y') }}</td>
                            <td class="py-3 px-4">{{ $req->total_days }} Hari</td>
                            <td class="py-3 px-4">
                                @if($req->status === 'APPROVED')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-label-sm font-label-sm bg-primary-fixed text-on-primary-fixed">Disetujui</span>
                                @elseif($req->status === 'REJECTED')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-label-sm font-label-sm bg-error-container text-on-error-container">Ditolak</span>
                                @elseif($req->status === 'CANCELLED')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-label-sm font-label-sm bg-surface-variant text-on-surface-variant">Dibatalkan</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-label-sm font-label-sm bg-tertiary-fixed text-on-tertiary-fixed">Menunggu</span>
                                @endif
                            </td>
                            <td class="py-3 px-4">
                                @if($req->status === 'PENDING')
                                <form action="{{ route('employee.leave-requests.destroy', $req->id) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan pengajuan cuti ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-error hover:underline text-sm">Batalkan</button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-4 px-4 text-center text-on-surface-variant">Anda belum memiliki riwayat pengajuan cuti.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $leaveRequests->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
