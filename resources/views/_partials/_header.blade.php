<header id="header" class="fixed-top d-flex align-items-center">
    <div class="container d-flex align-items-center justify-content-between">
      
      <a href="{{ Auth::check() ? route('adminHome') : route('home') }}" class="logo d-flex align-items-center gap-2 text-decoration-none">
        <img src="{{ asset('assets/img/logo.png') }}" alt="Tech Memes" class="me-1">
        <span class="logo-text fw-extrabold fs-3 text-dark" style="font-family: 'Plus Jakarta Sans', sans-serif; letter-spacing: -0.03em;">Tech<span style="color: var(--color-primary);">Memes</span></span>
      </a>

      <nav id="navbar" class="navbar">
        <ul>
          @auth
            <li><a class="nav-link @if(Route::is('adminHome')) active @endif" href="{{ route('adminHome') }}"><i class="bi bi-house-door me-2"></i>Accueil</a></li>
            <li><a class="nav-link @if(Route::is('myPost')) active @endif" href="{{ route('myPost') }}"><i class="bi bi-collection me-2"></i>Mes publications</a></li>
            <li><a class="nav-link @if(Route::is('postMemeView')) active @endif" href="{{ route('postMemeView') }}"><i class="bi bi-plus-circle me-2"></i>Publier</a></li>
            
            @if(Auth::user()->role == "sadmin")
              <li><a class="nav-link @if(Route::is('admins')) active @endif" href="{{ route('admins') }}"><i class="bi bi-people me-2"></i>Admins</a></li>
            @endif
          @endauth

          @guest
            <li><a class="nav-link @if(Route::is('home')) active @endif" href="{{ route('home') }}"><i class="bi bi-house-door me-2"></i>Accueil</a></li>
            <li><a class="nav-link @if(Route::is('loginVue')) active @endif" href="{{ route('loginVue') }}"><i class="bi bi-box-arrow-in-right me-2"></i>Se connecter</a></li>
          @endguest
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav>

      @auth  
        <div class="dropdown">
          <a href="#" class="get-started-btn dropdown-toggle d-flex align-items-center gap-1" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="border: none;">
            <i class="bi bi-person-circle me-1"></i>{{ Auth::user()->pseudo }}
          </a>
          <ul class="dropdown-menu dropdown-menu-end mt-2 border-0 shadow-lg" aria-labelledby="profileDropdown" style="background-color: #ffffff !important; border-radius: 8px;">
            <li><a class="dropdown-item py-2 px-3 d-flex align-items-center gap-2" href="{{ route('profile') }}" style="font-size: 14px; color: #000000 !important;"><i class="bi bi-person text-primary"></i>Mon Profil</a></li>
            <li><hr class="dropdown-divider bg-dark opacity-10"></li>
            <li><a class="dropdown-item text-danger py-2 px-3 d-flex align-items-center gap-2" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#logoutConfirmModal" style="font-size: 14px; color: #dc3545 !important;"><i class="bi bi-box-arrow-right"></i>Déconnexion</a></li>
          </ul>
        </div>
      @endauth

      @guest
        <a href="{{ route('becomeAdmin') }}" class="get-started-btn"><i class="bi bi-shield-lock me-2"></i>Devenir Admin</a>
      @endguest

    </div>
  </header>