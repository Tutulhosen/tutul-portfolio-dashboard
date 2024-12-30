<header class="header">
    <div class="d-flex align-items-center">
        <!-- Mobile toggle (visible on mobile) -->
        <span id="mobileToggle" class="toggle-btn d-md-none">
            <i class="fas fa-bars"></i>
        </span>
        <!-- Desktop toggle (hidden on mobile) -->
        <span id="desktopToggle" class="toggle-btn d-none d-md-flex">
            <i class="fas fa-bars"></i>
        </span>
        <span class="fw-bold ms-3">MD TUTUL</span>
    </div>
    <div class="profile-dropdown">
        <div class="dropdown">
            <button class="btn btn-light dropdown-toggle" type="button" id="profileMenu" data-bs-toggle="dropdown" aria-expanded="false">
                {{Auth::user()->name}}
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileMenu">
                <li><a class="dropdown-item" href="{{route('profile.setting')}}">Settings</a></li>
                <li><a class="dropdown-item" href="{{route('custom.logout')}}">Logout</a></li>
            </ul>
        </div>
    </div>
</header>