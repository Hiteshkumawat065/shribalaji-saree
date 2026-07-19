@if(session('success'))
    <div class="mx-auto max-w-7xl px-4 lg:px-8 pt-4">
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 text-emerald-800 px-4 py-3 text-sm">
            {{ session('success') }}
        </div>
    </div>
@endif

@if(session('error'))
    <div class="mx-auto max-w-7xl px-4 lg:px-8 pt-4">
        <div class="rounded-2xl border border-red-200 bg-red-50 text-red-800 px-4 py-3 text-sm">
            {{ session('error') }}
        </div>
    </div>
@endif

@if(isset($errors) && $errors->any())
    <div class="mx-auto max-w-7xl px-4 lg:px-8 pt-4">
        <div class="rounded-2xl border border-red-200 bg-red-50 text-red-800 px-4 py-3 text-sm">
            <strong>Please fix the following:</strong>
            <ul class="mt-2 list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
