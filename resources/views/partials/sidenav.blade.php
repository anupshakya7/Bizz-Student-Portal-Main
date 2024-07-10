<div class="sidenav">
    <div class="sidenav_inner">
        <div class="logo">
            <a href="#">
                <img src="{{asset('images/Asset.png')}}" alt="logo" class="small_logo">
                <img src="{{asset('images/logo.png')}}" alt="logo" class="full_logo">
            </a>
        </div>
        <ul class="sidemenu_list">
            <li><a class="sidemenu_list_link {{(request()->route()->getName() == 'dashboard') ? 'active':''}}" aria-current="page" href="{{route('dashboard')}}"><i class="fa fa-home"></i> <span>Dashboard</span></a></li>
            <li><a class="sidemenu_list_link {{(request()->route()->getName() == 'course.index') ? 'active':''}}" href="{{route('course.index')}}"><i class="fa fa-search"></i><span>Courses Search</span></a></li>
            <li><a class="sidemenu_list_link {{(request()->route()->getName() == 'status.index') ? 'active':''}}" href="{{route('status.index')}}"><i class="fas fa-spinner"></i><span>Status</span></a></li>
            <li class="dropdown">
                <a class="sidemenu_list_link dropdown-toggle" href="#" role="button" id="dropdownMenuLink" aria-expanded="false">
                    <i class="fa fa-cog"></i><span>Settings</span>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Profile</a></li>
                    <li><a class="dropdown-item" href="#">Account</a></li>
                    <li><a class="dropdown-item" href="#">Logout</a></li>
                </ul>
            </li>
            <li><a class="sidemenu_list_link {{(request()->route()->getName() == 'status.index') ? 'active':''}}" href="{{route('status.index')}}"><i class="fas fa-user"></i><span>Profile</span></a></li>
        </ul>
    </div>
</div>

