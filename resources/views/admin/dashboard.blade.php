<x-app-layout>
    <div class="mb-stack-lg">
        <h2 class="text-h1 font-h1 text-royal-blue mb-2">Kotak Masuk Persetujuan & Dashboard</h2>
        <p class="text-body-md font-body-md text-on-surface-variant">Tinjau dan kelola pengajuan cuti tim Anda serta ringkasan data sistem.</p>
    </div>

    @php
        $totalEmployees = \App\Models\Employee::count();
        $totalRequests = \App\Models\LeaveRequest::count();
        $pendingRequests = \App\Models\LeaveRequest::where('status', 'PENDING')->count();
        $approvedRequests = \App\Models\LeaveRequest::where('status', 'APPROVED')->count();
        $recentLeaves = \App\Models\LeaveRequest::with('employee.user', 'leaveType')->latest()->take(5)->get();
        $pendingLeaves = \App\Models\LeaveRequest::with('employee.user', 'leaveType')->where('status', 'PENDING')->latest()->take(5)->get();
    @endphp

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-gutter">
        <!-- Analytics Panel (Left/Top) -->
        <div class="lg:col-span-4 flex flex-col gap-stack-md">
            <!-- Team Availability Card -->
            <div class="bg-surface-container-lowest rounded-xl p-6 shadow-soft border border-outline-variant">
                <h3 class="text-h3 font-h3 text-steel-blue mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined">groups</span>
                    Ringkasan Sistem
                </h3>
                <div class="flex items-center justify-between mb-4">
                    <div class="text-center">
                        <div class="text-h1 font-h1 text-primary">{{ $totalEmployees }}</div>
                        <div class="text-label-sm font-label-sm text-on-surface-variant">Pegawai</div>
                    </div>
                    <div class="w-px h-12 bg-outline-variant"></div>
                    <div class="text-center">
                        <div class="text-h1 font-h1 text-[#ba1a1a]">{{ $pendingRequests }}</div>
                        <div class="text-label-sm font-label-sm text-on-surface-variant">Menunggu</div>
                    </div>
                    <div class="w-px h-12 bg-outline-variant"></div>
                    <div class="text-center">
                        <div class="text-h1 font-h1 text-[#2F578A]">{{ $approvedRequests }}</div>
                        <div class="text-label-sm font-label-sm text-on-surface-variant">Disetujui</div>
                    </div>
                </div>

                <!-- Mini Chart Placeholder -->
                <div class="mt-6 relative h-32 bg-surface-container rounded-lg overflow-hidden flex items-end px-4 gap-2 pb-2">
                    <div class="w-1/5 bg-teal-accent h-3/4 rounded-t-sm opacity-80"></div>
                    <div class="w-1/5 bg-teal-accent h-full rounded-t-sm"></div>
                    <div class="w-1/5 bg-outline-variant h-1/2 rounded-t-sm opacity-50"></div>
                    <div class="w-1/5 bg-teal-accent h-4/5 rounded-t-sm opacity-90"></div>
                    <div class="w-1/5 bg-outline-variant h-1/4 rounded-t-sm opacity-50"></div>
                </div>
                <p class="text-label-sm font-label-sm text-on-surface-variant text-center mt-2">Aktivitas Sistem</p>
            </div>

            <!-- Quick Actions -->
            <div class="bg-surface-container-lowest rounded-xl p-6 shadow-soft border border-outline-variant">
                <h3 class="text-h3 font-h3 text-steel-blue mb-4">Aksi Cepat</h3>
                <div class="space-y-3">
                    <a href="{{ route('admin.approvals.index') }}" class="w-full text-left px-4 py-3 rounded-lg border border-outline-variant hover:bg-surface-container flex items-center justify-between transition-colors">
                        <span class="text-body-md font-body-md">Lihat Semua Persetujuan ({{ $pendingRequests }})</span>
                        <span class="material-symbols-outlined text-teal-accent">pending_actions</span>
                    </a>
                    <a href="{{ route('admin.reports.index') }}" class="w-full text-left px-4 py-3 rounded-lg border border-outline-variant hover:bg-surface-container flex items-center justify-between transition-colors">
                        <span class="text-body-md font-body-md">Unduh Laporan</span>
                        <span class="material-symbols-outlined text-on-surface-variant">assessment</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Inbox & Calendar Panel (Right/Bottom) -->
        <div class="lg:col-span-8 flex flex-col gap-stack-md">
            <!-- Approval Inbox Table -->
            <div class="bg-surface-container-lowest rounded-xl shadow-soft border border-outline-variant overflow-hidden">
                <div class="p-6 border-b border-outline-variant flex justify-between items-center bg-surface">
                    <h3 class="text-h3 font-h3 text-royal-blue flex items-center gap-2">
                        <span class="material-symbols-outlined">pending_actions</span>
                        Menunggu Persetujuan
                    </h3>
                    @if($pendingRequests > 0)
                        <span class="bg-[#ba1a1a] text-white text-label-sm font-label-sm px-2 py-1 rounded-full">{{ $pendingRequests }} Baru</span>
                    @endif
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-surface-container-lowest border-b border-outline-variant">
                                <th class="py-3 px-6 text-label-md font-label-md text-on-surface-variant font-semibold">Karyawan</th>
                                <th class="py-3 px-6 text-label-md font-label-md text-on-surface-variant font-semibold">Tipe & Tanggal</th>
                                <th class="py-3 px-6 text-label-md font-label-md text-on-surface-variant font-semibold">Status</th>
                                <th class="py-3 px-6 text-label-md font-label-md text-on-surface-variant font-semibold text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pendingLeaves as $req)
                            <tr class="border-b border-outline-variant hover:bg-surface-container-lowest/50 transition-colors">
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-3">
                                        <div>
                                            <p class="text-body-md font-body-md font-semibold text-on-surface">{{ $req->employee->user->name ?? 'N/A' }}</p>
                                            <p class="text-label-sm font-label-sm text-on-surface-variant">{{ $req->employee->position ?? '' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-6">
                                    <p class="text-body-md font-body-md font-medium">{{ $req->leaveType->name }}</p>
                                    <p class="text-label-sm font-label-sm text-on-surface-variant">{{ $req->start_date->format('d M') }} - {{ $req->end_date->format('d M') }} ({{ $req->total_days }} Hari)</p>
                                </td>
                                <td class="py-4 px-6">
                                    <span class="bg-amber-100 text-amber-800 text-label-sm font-label-sm px-3 py-1 rounded-full inline-block">Menunggu</span>
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <div class="flex justify-end gap-2">
                                        <form action="{{ route('admin.approvals.update', $req->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="APPROVED">
                                            <button type="submit" class="p-2 rounded-lg text-teal-accent hover:bg-teal-50 transition-colors" title="Setujui" onclick="return confirm('Setujui pengajuan ini?')">
                                                <span class="material-symbols-outlined">check</span>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.approvals.update', $req->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="REJECTED">
                                            <button type="submit" class="p-2 rounded-lg text-[#ba1a1a] hover:bg-red-50 transition-colors" title="Tolak" onclick="return confirm('Tolak pengajuan ini?')">
                                                <span class="material-symbols-outlined">close</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="py-4 px-6 text-center text-on-surface-variant">Tidak ada pengajuan baru.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-4 border-t border-outline-variant text-center bg-surface">
                    <a href="{{ route('admin.approvals.index') }}" class="text-label-md font-label-md text-[#2F578A] hover:underline">Lihat Semua Pengajuan</a>
                </div>
            </div>

            <!-- Team Calendar Mini-View Placeholder (Matching the design) -->
            <div class="bg-surface-container-lowest rounded-xl p-6 shadow-soft border border-outline-variant">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-h3 font-h3 text-steel-blue flex items-center gap-2">
                        <span class="material-symbols-outlined">calendar_month</span>
                        Pengajuan Terbaru (Semua Status)
                    </h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-surface-container-lowest border-b border-outline-variant">
                                <th class="py-2 px-4 text-label-sm font-label-sm text-on-surface-variant font-semibold">Karyawan</th>
                                <th class="py-2 px-4 text-label-sm font-label-sm text-on-surface-variant font-semibold">Tipe Cuti</th>
                                <th class="py-2 px-4 text-label-sm font-label-sm text-on-surface-variant font-semibold">Tanggal</th>
                                <th class="py-2 px-4 text-label-sm font-label-sm text-on-surface-variant font-semibold">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentLeaves as $recent)
                            <tr class="border-b border-outline-variant hover:bg-surface-container-lowest/50 transition-colors">
                                <td class="py-2 px-4 font-semibold text-on-surface">{{ $recent->employee->user->name ?? 'N/A' }}</td>
                                <td class="py-2 px-4">{{ $recent->leaveType->name }}</td>
                                <td class="py-2 px-4 text-on-surface-variant">{{ $recent->start_date->format('d M') }} - {{ $recent->end_date->format('d M') }}</td>
                                <td class="py-2 px-4">
                                    @if($recent->status === 'APPROVED')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-label-sm font-label-sm bg-primary-fixed text-on-primary-fixed">Disetujui</span>
                                    @elseif($recent->status === 'REJECTED')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-label-sm font-label-sm bg-error-container text-on-error-container">Ditolak</span>
                                    @elseif($recent->status === 'CANCELLED')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-label-sm font-label-sm bg-surface-variant text-on-surface-variant">Dibatalkan</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-label-sm font-label-sm bg-amber-100 text-amber-800">Menunggu</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
