<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-{{ $color }} text-white d-flex justify-content-between align-items-center">
        <div>
            <i class="{{ $icon }}"></i> <strong>{{ $title }}</strong>
        </div>
        @isset($action)
            <div>{{ $action }}</div>
        @endisset
    </div>
    <div class="card-body">
        {{ $slot }}
    </div>
</div>
