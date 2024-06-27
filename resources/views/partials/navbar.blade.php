@if(auth()->check())
<nav class="navbar navbar-expand-lg bg-light">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Bizz Portal</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          @if(auth()->check())
            <li class="nav-item">
              <a class="nav-link {{(request()->route()->getName() == 'dashboard') ? 'active':''}}" aria-current="page" href="{{route('dashboard')}}">Dashboard</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Link</a>
            </li>
          @endif
        </ul>
        <form class="d-flex" role="search">
          @if(auth()->check())
            <div class="dropdown">
              <button class="btn btn-light dropdown-toggle me-4" type="button" id="profileSetup" data-bs-toggle="dropdown" aria-expanded="false">
                {{auth()->user()->firstname}}
              </button>
              <ul class="dropdown-menu" style="left:auto;right: 25px;" aria-labelledby="profileSetup">
                <li><a class="dropdown-item {{(request()->route()->getName() == 'profile.editProfile') ? 'active':''}}" href="{{route('profile.editProfile')}}">Edit Profile</a></li>
                <li><a class="dropdown-item {{(request()->route()->getName() == 'profile.changePassword') ? 'active':''}}" href="{{route('profile.changePassword')}}">Change Password</a></li>
                <li><a class="dropdown-item" href="{{route('logout')}}">Logout</a></li>
              </ul>
            </div>
          {{-- @else
            <a href="{{route('login')}}" class="btn btn-outline-success mx-1" type="submit">Login</a>
            <a href="{{route('register')}}" class="btn btn-outline-danger mx-1" type="submit">Register</a> --}}
          @endif
        </form>
      </div>
    </div>
  </nav>
  @endif