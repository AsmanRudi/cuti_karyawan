<x-app-layout>
    <div class="flex flex-col gap-stack-lg max-w-4xl mx-auto">
        <div>
            <a href="{{ route('admin.leavetypes.index') }}" class="text-primary-container hover:underline mb-4 inline-block">&larr; Kembali ke Daftar</a>
            <h2 class="text-h1-mobile font-h1-mobile md:text-h1 md:font-h1 text-primary">Edit Tipe Cuti: {{ $leaveType->name }}</h2>
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
            <form method="POST" action="{{ route('admin.leavetypes.update', $leaveType->id) }}" class="flex flex-col gap-6">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-label-md mb-2">Nama Tipe Cuti</label>
                        <input type="text" name="name" value="{{ old('name', $leaveType->name) }}" class="w-full border-outline-variant rounded-lg" required>
                    </div>
                    <div>
                        <label class="block text-label-md mb-2">Jatah Default (Hari)</label>
                        <input type="number" name="default_days" value="{{ old('default_days', $leaveType->default_days) }}" min="1" class="w-full border-outline-variant rounded-lg" required>
                    </div>
                </div>
                
                <div>
                    <label class="block text-label-md mb-2">Deskripsi</label>
                    <textarea name="description" class="w-full border-outline-variant rounded-lg" rows="3">{{ old('description', $leaveType->description) }}</textarea>
                </div>
                
                <div>
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="is_active" value="1" class="rounded border-outline-variant text-primary shadow-sm" {{ old('is_active', $leaveType->is_active) ? 'checked' : '' }}>
                        <span class="ml-2 text-label-md">Status Aktif</span>
                    </label>
                </div>

                <div class="flex justify-end pt-4">
                    <button type="submit" class="bg-primary-container text-on-primary px-6 py-3 rounded-lg text-label-md font-bold hover:bg-primary transition-colors">Perbarui Tipe Cuti</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
