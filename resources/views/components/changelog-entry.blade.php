@props([
    'title',
    'date',
    'version',
])

<article class="changelog-entry">
    <div class="changelog-entry-marker" aria-hidden="true"></div>
    <div class="changelog-entry-content">
        <div class="changelog-entry-meta">
            <time datetime="{{ \Carbon\Carbon::parse($date)->toDateString() }}">{{ \Carbon\Carbon::parse($date)->translatedFormat('d \d\e F \d\e Y') }}</time>
            <span>v{{ $version }}</span>
        </div>
        <h2>{{ $title }}</h2>
        <div class="changelog-entry-body">
            {{ $slot }}
        </div>
    </div>
</article>
