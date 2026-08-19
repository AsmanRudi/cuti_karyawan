<x-app-layout>
    <div class="max-w-container-max-width mx-auto flex flex-col gap-stack-lg">
        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-stack-md">
            <div>
                <h2 class="text-h1-mobile font-h1-mobile md:text-h1 md:font-h1 text-primary">Selamat Datang, {{ auth()->user()->name }}!</h2>
                <p class="text-body-md font-body-md text-on-surface-variant mt-unit">Berikut adalah ringkasan kuota dan aktivitas cuti Anda.</p>
            </div>
            <a href="{{ route('employee.leave-requests.create') }}" class="bg-primary-container text-on-primary border border-transparent px-6 py-3 rounded-lg text-label-md font-label-md shadow-sm hover:bg-primary transition-colors flex items-center gap-2 w-fit">
                <span class="material-symbols-outlined">edit_calendar</span>
                Ajukan Cuti
            </a>
        </div>
        
        @php
            $employee = auth()->user()->employee;
            $leaveQuota = $employee ? $employee->annual_leave_quota : 12;
            $usedLeave = $employee ? $employee->leaveRequests()->where('status', 'APPROVED')->sum('total_days') : 0;
            $remainingLeave = $leaveQuota - $usedLeave;
        @endphp

        <!-- Bento Grid Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-gutter">
            <!-- Left Column: Quotas & Activity -->
            <div class="lg:col-span-8 flex flex-col gap-stack-lg">
                <!-- Leave Quota Overview -->
                <section>
                    <h3 class="text-h3 font-h3 text-on-surface mb-stack-md">Ringkasan Kuota Cuti Tahunan</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-stack-md">
                        <!-- Annual Leave Card -->
                        <div class="bg-surface-container-lowest rounded-xl p-stack-md border border-outline-variant shadow-soft relative overflow-hidden group hover:border-primary-container transition-colors">
                            <div class="absolute top-0 left-0 w-full h-1 bg-primary-container"></div>
                            <div class="flex flex-col items-center justify-center pt-stack-sm">
                                <h4 class="text-body-md font-body-md text-on-surface-variant mb-stack-sm text-center">Cuti Tahunan</h4>
                                <div class="relative w-28 h-28 flex items-center justify-center">
                                    <svg class="w-full h-full transform -rotate-90" viewbox="0 0 36 36">
                                        <path class="text-surface-variant" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="3.5"></path>
                                        <path class="text-primary-container" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-dasharray="{{ $leaveQuota > 0 ? ($remainingLeave / $leaveQuota * 100) : 0 }}, 100" stroke-linecap="round" stroke-width="3.5"></path>
                                    </svg>
                                    <div class="absolute flex flex-col items-center">
                                        <span class="text-h2 font-h2 text-primary-container leading-none">{{ max(0, $remainingLeave) }}</span>
                                        <span class="text-label-sm font-label-sm text-on-surface-variant">/{{ $leaveQuota }} Hari</span>
                                    </div>
                                </div>
                                <p class="text-label-sm font-label-sm text-primary-container mt-stack-md bg-secondary-fixed px-3 py-1 rounded-full">Sisa {{ max(0, $remainingLeave) }} Hari</p>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Recent Activity / History -->
                <section>
                    <div class="flex items-center justify-between mb-stack-md">
                        <h3 class="text-h3 font-h3 text-on-surface">Aktivitas Terbaru</h3>
                        <a class="text-label-md font-label-md text-primary-container hover:underline flex items-center gap-1" href="{{ route('employee.leave-requests.index') }}">
                            Lihat Semua Riwayat
                            <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                        </a>
                    </div>
                    <div class="bg-surface-container-lowest border border-outline-variant rounded-xl shadow-soft overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-surface-container-low border-b border-outline-variant">
                                        <th class="py-3 px-4 text-label-sm font-label-sm text-on-surface-variant">Tipe Cuti</th>
                                        <th class="py-3 px-4 text-label-sm font-label-sm text-on-surface-variant">Tanggal</th>
                                        <th class="py-3 px-4 text-label-sm font-label-sm text-on-surface-variant">Durasi</th>
                                        <th class="py-3 px-4 text-label-sm font-label-sm text-on-surface-variant">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="text-body-md font-body-md">
                                    @forelse($employee ? $employee->leaveRequests()->latest()->take(5)->get() : [] as $request)
                                    <tr class="border-b border-outline-variant hover:bg-surface-container-high transition-colors">
                                        <td class="py-3 px-4 flex items-center gap-2">
                                            <span class="material-symbols-outlined text-primary-container">beach_access</span>
                                            {{ $request->leaveType->name }}
                                        </td>
                                        <td class="py-3 px-4 text-on-surface-variant">{{ $request->start_date->format('d M Y') }} - {{ $request->end_date->format('d M Y') }}</td>
                                        <td class="py-3 px-4">{{ $request->total_days }} Hari</td>
                                        <td class="py-3 px-4">
                                            @if($request->status === 'APPROVED')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-label-sm font-label-sm bg-primary-fixed text-on-primary-fixed">Disetujui</span>
                                            @elseif($request->status === 'REJECTED')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-label-sm font-label-sm bg-error-container text-on-error-container">Ditolak</span>
                                            @elseif($request->status === 'CANCELLED')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-label-sm font-label-sm bg-surface-variant text-on-surface-variant">Dibatalkan</span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-label-sm font-label-sm bg-tertiary-fixed text-on-tertiary-fixed">Menunggu</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="py-4 px-4 text-center text-on-surface-variant">Belum ada aktivitas cuti.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
            
            <!-- Right Column -->
            <div class="lg:col-span-4 flex flex-col gap-stack-lg">
                <!-- Quick Info Banner -->
                <div class="bg-surface-container-low border border-outline-variant rounded-xl p-stack-md flex gap-stack-md items-start">
                    <span class="material-symbols-outlined text-secondary">info</span>
                    <div>
                        <h4 class="text-label-md font-label-md text-on-surface mb-1">Informasi</h4>
                        <p class="text-body-sm font-body-sm text-on-surface-variant">Gunakan menu Request Leave untuk mengajukan cuti. Status pengajuan dapat dipantau pada tabel aktivitas.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
