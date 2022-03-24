@php
    $routeActive = Route::currentRouteName();
@endphp

<li class="nav-item">
    <a class="nav-link {{ $routeActive == 'home' ? 'active' : '' }}" href="{{ route('home') }}">
        <i class="ni ni-tv-2 text-primary"></i>
        <span class="nav-link-text">Dashboard</span>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link {{ $routeActive == 'profile' ? 'active' : '' }}" href="{{ route('profile') }}">
        <i class="fas fa-user-tie text-warning"></i>
        <span class="nav-link-text">Profile</span>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link {{ $routeActive == 'villas.index' ? 'active' : '' }}" href="{{ route('villas.index') }}">
        <i class="fas fa-building text-info"></i>
        <span class="nav-link-text">Data Villa</span>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link {{ $routeActive == 'bookings.index' ? 'active' : '' }}" href="{{ route('bookings.index') }}">
        <i class="fas fa-building text-danger"></i>
        <span class="nav-link-text">Data Sewa Villa</span>
    </a>
</li>