@props(['active' => false, 'route', 'icon', 'title'])

<li class="nav-item {{ $active ? 'active' : '' }}">
    <a href="{{ route($route) }}" class="nav-link">
        <i class="fas fa-fw {{ $icon }}"></i>
        <span>{{ $title }}</span>
    </a>
</li>
