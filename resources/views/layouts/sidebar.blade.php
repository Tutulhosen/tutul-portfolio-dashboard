<div class="sidebar" id="sidebar">
    <div class="logo">
        Logo
        <!-- Mobile Toggle Icon -->
        <i id="mobileToggleSidebar" class="fas fa-bars toggle-btn d-md-none"></i>
    </div>
    <ul id="sidebarMenu">
        <li class="nav-item">
            <a class="nav-link" href="{{route('dashboard')}}">
                <i class="fas fa-home"></i>
                <span>Home</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('about.show')}}">
                <i class="fas fa-user"></i>
                <span>About Me</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('project.show')}}">
                <i class="fas fa-briefcase"></i>
                <span>Projects</span>
            </a>
        </li>
        <li class="nav-item">
           
            <a class="nav-link" href="{{route('skill.show')}}">
                <i class="fas fa-laptop-code"></i>
                <span>Skills</span>
            </a>
          
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('contact.show')}}">
                <i class="fas fa-envelope"></i>
                <span>Contact</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('profile.setting')}}">
                <i class="fas fa-cogs"></i>
                <span>Settings</span>
            </a>
        </li>
    </ul>
</div>