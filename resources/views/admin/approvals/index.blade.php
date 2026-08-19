<x-app-layout>
    <div class="flex flex-col gap-stack-lg">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-stack-md">
            <div>
                <h2 class="text-h1-mobile font-h1-mobile md:text-h1 md:font-h1 text-primary">Persetujuan Cuti</h2>
                <p class="text-body-md font-body-md text-on-surface-variant mt-unit">Kelola dan proses pengajuan cuti pegawai.</p>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-primary-fixed text-on-primary-fixed p-4 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-surface-container-lowest border border-outline-variant rounded-xl shadow-soft p-stack-md">
            <form method="GET" action="{{ route('admin.approvals.index') }}" class="flex flex-wrap gap-4 mb-stack-md">
                <select name="status" class="border-outline-variant rounded-lg min-w-[200px]">
                    <option value="">Semua Status</option>
                    <option value="PENDING" {{ request('status') == 'PENDING' ? 'selected' : '' }}>Menunggu Persetujuan</option>
                    <option value="APPROVED" {{ request('status') == 'APPROVED' ? 'selected' : '' }}>Disetujui</option>
                    <option value="REJECTED" {{ request('status') == 'REJECTED' ? 'selected' : '' }}>Ditolak</option>
                    <option value="CANCELLED" {{ request('status') == 'CANCELLED' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
                <button type="submit" class="bg-surface-variant text-on-surface-variant px-4 py-2 rounded-lg hover:bg-outline-variant transition-colors">Filter</button>
            </form>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-surface-container-low border-b border-outline-variant">
                            <th class="py-3 px-4 text-label-sm font-label-sm text-on-surface-variant">Pegawai</th>
                            <th class="py-3 px-4 text-label-sm font-label-sm text-on-surface-variant">Tipe Cuti</th>
                            <th class="py-3 px-4 text-label-sm font-label-sm text-on-surface-variant">Tanggal</th>
                            <th class="py-3 px-4 text-label-sm font-label-sm text-on-surface-variant">Durasi</th>
                            <th class="py-3 px-4 text-label-sm font-label-sm text-on-surface-variant">Status</th>
                            <th class="py-3 px-4 text-label-sm font-label-sm text-on-surface-variant text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-body-md font-body-md">
                        @forelse($leaveRequests as $req)
                        <tr class="border-b border-outline-variant hover:bg-surface-container-high transition-colors">
                            <td class="py-3 px-4">
                                <div class="font-bold">{{ $req->employee->user->name ?? 'N/A' }}</div>
                                <div class="text-sm text-on-surface-variant">{{ $req->employee->department ?? '' }}</div>
                            </td>
                            <td class="py-3 px-4">{{ $req->leaveType->name }}</td>
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
                            <td class="py-3 px-4 text-right flex justify-end gap-2">
                                @if($req->status === 'PENDING')
                                    <form action="{{ route('admin.approvals.update', $req->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="APPROVED">
                                        <button type="submit" class="bg-primary-container text-on-primary px-3 py-1 rounded text-sm hover:opacity-90" onclick="return confirm('Setujui pengajuan ini?')">Setuju</button>
                                    </form>
                                    <form action="{{ route('admin.approvals.update', $req->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="REJECTED">
                                        <button type="submit" class="bg-error text-on-error px-3 py-1 rounded text-sm hover:opacity-90" onclick="return confirm('Tolak pengajuan ini?')">Tolak</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-4 px-4 text-center text-on-surface-variant">Tidak ada pengajuan cuti.</td>
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
