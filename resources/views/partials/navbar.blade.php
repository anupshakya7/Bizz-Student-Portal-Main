@if(auth()->check())
  <nav class="navbar">
    <div class="container-fluid">
      <div class="nav_left">
        <a href="#" class="back btn btn-primary"><i class="fas fa-arrow-left"></i></a>
        <ul class="breadcrumb">
          <li><a href="">Home</a></li>
          <li><i class="fas fa-chevron-right"></i></li>
          <li>Dashboard</li>
        </ul>
      </div>
      <div class="nav_right">
        <div class="hamburger">
          <i class="fa fa-bars"></i>
        </div>
          <form class="d-flex users_profile" role="search">
        <div class="dropdown">
          <a class="dropdown-toggle me-4" type="button" id="profileSetup" aria-expanded="false">
            <img src="{{auth()->user()->profile_image ? Voyager::image(auth()->user()->profile_image) : asset('images/login/user.png')}}" alt="{{auth()->user()->firstname}}">
        </a>
          <ul class="dropdown-menu" style="left:auto;right: 25px;" aria-labelledby="profileSetup">
            <li><a class="dropdown-item {{(request()->route()->getName() == 'profile.editProfile') ? 'active':''}}" href="{{route('profile.editProfile')}}">Edit Profile</a></li>
            <li><a class="dropdown-item {{(request()->route()->getName() == 'profile.changePassword') ? 'active':''}}" href="{{route('profile.changePassword')}}">Change Password</a></li>
            <li><a class="dropdown-item" href="{{route('logout')}}">Logout</a></li>
          </ul>
        </div>
        {{-- @else
        <a href="{{route('login')}}" class="btn btn-outline-success mx-1" type="submit">Login</a>
        <a href="{{route('register')}}" class="btn btn-outline-danger mx-1" type="submit">Register</a> --}}
        </form>
      </div>
      

    </div>
  </nav>
@endif