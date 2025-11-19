<div class="card mb-3 shadow-sm">
    @isset($header)
        <div class="card-header bg-light fw-bold">{{ $header }}</div>
    @endisset

    <div class="card-body">
        {{ $slot }}
    </div>

    @isset($footer)
        <div class="card-footer text-muted">{{ $footer }}</div>
    @endisset
</div>
