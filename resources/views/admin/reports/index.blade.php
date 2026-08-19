<x-app-layout>
    <div class="flex flex-col gap-stack-lg max-w-6xl mx-auto">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-stack-md">
            <div>
                <h2 class="text-h1-mobile font-h1-mobile md:text-h1 md:font-h1 text-primary">Laporan & Statistik</h2>
                <p class="text-body-md font-body-md text-on-surface-variant mt-unit">Ringkasan aktivitas cuti karyawan per departemen.</p>
            </div>
            <form method="GET" action="{{ route('admin.reports.index') }}" class="flex items-center gap-2">
                <select name="month" class="border-outline-variant rounded-lg" onchange="this.form.submit()">
                    @for($i = 1; $i <= 12; $i++)
                        <option value="{{ sprintf('%02d', $i) }}" {{ $month == sprintf('%02d', $i) ? 'selected' : '' }}>
                            {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                        </option>
                    @endfor
                </select>
                <select name="year" class="border-outline-variant rounded-lg" onchange="this.form.submit()">
                    @for($i = date('Y') - 2; $i <= date('Y') + 1; $i++)
                        <option value="{{ $i }}" {{ $year == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
            </form>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-stack-lg">
            <!-- Rekap per Departemen -->
            <div class="bg-surface-container-lowest border border-outline-variant rounded-xl shadow-soft p-stack-md">
                <h3 class="text-h3 font-h3 text-on-surface mb-stack-md">Rekap Departemen (Bulan Ini)</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-surface-container-low border-b border-outline-variant">
                                <th class="py-3 px-4 text-label-sm font-label-sm text-on-surface-variant">Departemen</th>
                                <th class="py-3 px-4 text-label-sm font-label-sm text-on-surface-variant text-center">Total Pegawai</th>
                                <th class="py-3 px-4 text-label-sm font-label-sm text-on-surface-variant text-center">Total Hari Cuti</th>
                            </tr>
                        </thead>
                        <tbody class="text-body-md font-body-md">
                            @forelse($departmentStats as $stat)
                            <tr class="border-b border-outline-variant hover:bg-surface-container-high transition-colors">
                                <td class="py-3 px-4 font-bold">{{ $stat->department }}</td>
                                <td class="py-3 px-4 text-center">{{ $stat->total_employees }}</td>
                                <td class="py-3 px-4 text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-label-sm font-label-sm bg-primary-fixed text-on-primary-fixed">
                                        {{ $stat->total_leave_days ?? 0 }} Hari
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="py-4 px-4 text-center text-on-surface-variant">Belum ada data departemen.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Tren Tipe Cuti -->
            <div class="bg-surface-container-lowest border border-outline-variant rounded-xl shadow-soft p-stack-md">
                <h3 class="text-h3 font-h3 text-on-surface mb-stack-md">Distribusi Jenis Cuti (Disetujui)</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-surface-container-low border-b border-outline-variant">
                                <th class="py-3 px-4 text-label-sm font-label-sm text-on-surface-variant">Tipe Cuti</th>
                                <th class="py-3 px-4 text-label-sm font-label-sm text-on-surface-variant text-center">Jumlah Pengajuan</th>
                            </tr>
                        </thead>
                        <tbody class="text-body-md font-body-md">
                            @forelse($leaveTypeStats as $typeStat)
                            <tr class="border-b border-outline-variant hover:bg-surface-container-high transition-colors">
                                <td class="py-3 px-4 font-bold">{{ $typeStat->leaveType->name ?? 'N/A' }}</td>
                                <td class="py-3 px-4 text-center">{{ $typeStat->count }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="2" class="py-4 px-4 text-center text-on-surface-variant">Belum ada pengajuan cuti yang disetujui bulan ini.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="bg-surface-container-low border border-outline-variant rounded-xl p-stack-md flex gap-stack-md items-start mt-stack-sm">
            <span class="material-symbols-outlined text-secondary">info</span>
            <div>
                <h4 class="text-label-md font-label-md text-on-surface mb-1">Catatan Laporan</h4>
                <p class="text-body-sm font-body-sm text-on-surface-variant">Laporan ini hanya menghitung data berdasarkan pengajuan cuti yang telah memiliki status "Disetujui" (Approved) pada bulan dan tahun yang dipilih.</p>
            </div>
        </div>
    </div>
</x-app-layout>
