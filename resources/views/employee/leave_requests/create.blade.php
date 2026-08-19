<x-app-layout>
    <div class="mb-stack-lg">
        <nav aria-label="Breadcrumb" class="flex text-label-sm font-label-sm text-on-surface-variant mb-2">
            <ol class="inline-flex items-center space-x-1 md:space-x-2">
                <li class="inline-flex items-center">
                    <a class="hover:text-primary transition-colors" href="{{ route('employee.dashboard') }}">HR Portal</a>
                </li>
                <li>
                    <div class="flex items-center">
                        <span class="material-symbols-outlined text-[16px] mx-1">chevron_right</span>
                        <span class="text-on-surface">Pengajuan Cuti</span>
                    </div>
                </li>
            </ol>
        </nav>
        <h2 class="text-h1 font-h1 text-primary">Formulir Pengajuan Cuti</h2>
        <p class="text-body-md font-body-md text-on-surface-variant mt-1">Silakan lengkapi rincian di bawah ini untuk mengajukan permohonan cuti Anda.</p>
    </div>

    @if($errors->any())
        <div class="bg-error-container text-on-error-container p-4 rounded-lg mb-6 shadow-soft">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    @if(session('error'))
        <div class="bg-error-container text-on-error-container p-4 rounded-lg mb-6 shadow-soft">
            {{ session('error') }}
        </div>
    @endif

    <!-- Layout Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-gutter items-start">
        <!-- Left Column: Main Form (Bento Style) -->
        <div class="lg:col-span-8 flex flex-col gap-stack-md">
            <form method="POST" action="{{ route('employee.leave-requests.store') }}" class="bg-surface-container-lowest border border-outline-variant rounded-xl shadow-soft p-stack-lg flex flex-col gap-stack-lg">
                @csrf
                
                <!-- Section: Leave Details -->
                <div class="flex flex-col gap-stack-md border-b border-surface-container-high pb-stack-md">
                    <h3 class="text-h3 font-h3 text-on-surface flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary-container">format_list_bulleted</span>
                        Rincian Cuti
                    </h3>
                    
                    <!-- Leave Type -->
                    <div>
                        <label class="text-label-md font-label-md text-on-surface block mb-1" for="leave_type_id">Jenis Cuti <span class="text-error">*</span></label>
                        <div class="relative">
                            <select name="leave_type_id" id="leave_type_id" class="w-full appearance-none bg-surface-container-lowest border border-outline-variant rounded-lg px-4 py-3 text-body-md font-body-md text-on-surface focus:outline-none focus:border-primary-container focus:ring-1 focus:ring-primary-container transition-colors cursor-pointer" required>
                                <option disabled selected value="">Pilih jenis cuti...</option>
                                @foreach($leaveTypes as $type)
                                    <option value="{{ $type->id }}" {{ old('leave_type_id') == $type->id ? 'selected' : '' }}>{{ $type->name }} ({{ $type->default_days }} hari)</option>
                                @endforeach
                            </select>
                            <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-outline">expand_more</span>
                        </div>
                    </div>
                    
                    <!-- Dates Row -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-stack-md">
                        <div>
                            <label class="text-label-md font-label-md text-on-surface block mb-1" for="start_date">Tanggal Mulai <span class="text-error">*</span></label>
                            <div class="relative">
                                <input name="start_date" id="start_date" type="date" value="{{ old('start_date') }}" class="w-full bg-surface-container-lowest border border-outline-variant rounded-lg px-4 py-3 text-body-md font-body-md text-on-surface focus:outline-none focus:border-primary-container focus:ring-1 focus:ring-primary-container transition-colors" required/>
                            </div>
                        </div>
                        <div>
                            <label class="text-label-md font-label-md text-on-surface block mb-1" for="end_date">Tanggal Selesai <span class="text-error">*</span></label>
                            <div class="relative">
                                <input name="end_date" id="end_date" type="date" value="{{ old('end_date') }}" class="w-full bg-surface-container-lowest border border-outline-variant rounded-lg px-4 py-3 text-body-md font-body-md text-on-surface focus:outline-none focus:border-primary-container focus:ring-1 focus:ring-primary-container transition-colors" required/>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section: Reason -->
                <div class="flex flex-col gap-stack-md">
                    <h3 class="text-h3 font-h3 text-on-surface flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary-container">description</span>
                        Keterangan Tambahan
                    </h3>
                    <div>
                        <label class="text-label-md font-label-md text-on-surface block mb-1" for="reason">Alasan Cuti <span class="text-error">*</span></label>
                        <textarea name="reason" id="reason" class="w-full bg-surface-container-lowest border border-outline-variant rounded-lg px-4 py-3 text-body-md font-body-md text-on-surface focus:outline-none focus:border-primary-container focus:ring-1 focus:ring-primary-container transition-colors resize-y" placeholder="Tuliskan rincian alasan pengajuan cuti Anda..." rows="4" required>{{ old('reason') }}</textarea>
                    </div>
                </div>
                
                <!-- Form Actions -->
                <div class="flex items-center justify-end gap-3 pt-4 mt-2 border-t border-surface-container-high">
                    <a href="{{ route('employee.dashboard') }}" class="px-6 py-2.5 rounded-lg border border-outline-variant text-on-surface-variant text-label-md font-label-md font-bold hover:bg-surface-container-high transition-colors">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-2.5 rounded-lg bg-primary-container text-on-primary-container text-label-md font-label-md font-bold hover:bg-surface-tint transition-colors shadow-sm flex items-center gap-2">
                        <span class="material-symbols-outlined text-[18px]">send</span>
                        Ajukan Cuti
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Right Column: Real-time Balance Checker (Sticky Bento Card) -->
        <div class="lg:col-span-4 sticky top-[88px]">
            <div class="bg-surface-container-lowest border border-outline-variant rounded-xl shadow-soft p-stack-md flex flex-col gap-4">
                <div class="flex items-center justify-between pb-3 border-b border-surface-container-high">
                    <h3 class="text-h3 font-h3 text-on-surface">Simulasi Saldo</h3>
                    <span class="material-symbols-outlined text-outline">account_balance_wallet</span>
                </div>
                <!-- Info Rows -->
                @php
                    $employee = auth()->user()->employee;
                    $leaveQuota = $employee ? $employee->annual_leave_quota : 12;
                    $usedLeave = $employee ? $employee->leaveRequests()->where('status', 'APPROVED')->sum('total_days') : 0;
                    $remainingLeave = $leaveQuota - $usedLeave;
                @endphp
                <div class="flex flex-col gap-3">
                    <div class="flex justify-between items-center">
                        <span class="text-body-sm font-body-sm text-on-surface-variant">Jenis Cuti Terkait</span>
                        <span class="text-label-md font-label-md text-on-surface">Cuti Tahunan</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-body-sm font-body-sm text-on-surface-variant">Sisa Saldo Saat Ini</span>
                        <span class="text-label-md font-label-md text-primary-container bg-primary-fixed px-2 py-0.5 rounded-md">{{ max(0, $remainingLeave) }} Hari</span>
                    </div>
                </div>
                <!-- Final Balance Calculation -->
                <div class="mt-2 pt-4 border-t border-surface-container-high bg-surface-container-low -mx-stack-md -mb-stack-md p-stack-md rounded-b-xl flex justify-between items-center">
                    <span class="text-body-md font-body-md font-bold text-on-surface">Info</span>
                    <span class="text-label-sm font-label-sm text-on-surface-variant text-right">Saldo akan terpotong<br>bila disetujui.</span>
                </div>
            </div>
            <!-- Helper Text under widget -->
            <div class="mt-4 flex gap-2 p-3 bg-surface-variant rounded-lg border border-outline-variant">
                <span class="material-symbols-outlined text-on-surface-variant text-[20px]">info</span>
                <p class="text-label-sm font-label-sm text-on-surface-variant">Simulasi ini hanya berlaku jika Anda memilih Cuti Tahunan. Saldo riil akan diperbarui setelah pengajuan disetujui oleh atasan dan HR.</p>
            </div>
        </div>
    </div>
</x-app-layout>
