@extends('layouts.master')

@section('body-class', 'auth-body')

@section('container')
    <div class="auth-wrapper">
        <div class="auth-logo-container text-center mb-4">
            <a href="{{ request()->url() }}" class="d-inline-flex align-items-center gap-2 text-decoration-none">
                <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" class="auth-logo me-1">
                <span class="logo-text fw-extrabold fs-2 text-dark" style="font-family: 'Plus Jakarta Sans', sans-serif; letter-spacing: -0.03em;">Tech<span style="color: var(--color-primary);">Memes</span></span>
            </a>
        </div>

        <div class="auth-card-container">
            <div class="php-email-form">
                <form method="post" role="form">
                    @csrf

                    <div class="text-center mb-4 pb-2">
                        <h2 class="auth-title mb-0">Devenir Admin</h2>
                    </div>

                    @if($error = session()->get('error'))
                        <div class="alert alert-danger p-2 small mb-3">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ $error }}
                        </div>
                    @endif

                    @if($success = session()->get('success'))
                        <div class="alert alert-success p-2 small mb-3">
                            <i class="bi bi-check-circle-fill me-2"></i>{{ $success }}
                        </div>
                    @endif

                    <div class="auth-input-wrapper">
                        <input type="text" class="auth-control" name="pseudo" id="pseudo" placeholder="Choisissez un pseudo" value="{{ old('pseudo') }}" required autocomplete="username">
                        <i class="bi bi-person auth-input-icon"></i>
                    </div>
                    @error('pseudo')
                        <div class="alert alert-danger mt-1 mb-3 p-2 small">{{ $message }}</div>
                    @enderror

                    <div class="auth-input-wrapper">
                        <input type="email" class="auth-control" name="email" id="email" placeholder="Adresse email" value="{{ old('email') }}" required autocomplete="email">
                        <i class="bi bi-envelope auth-input-icon"></i>
                    </div>
                    @error('email')
                        <div class="alert alert-danger mt-1 mb-3 p-2 small">{{ $message }}</div>
                    @enderror

                    <div class="auth-input-wrapper">
                        <input type="password" class="auth-control password-input" name="password" id="password" placeholder="Mot de passe" required autocomplete="new-password">
                        <i class="bi bi-lock auth-input-icon"></i>
                        <button type="button" class="password-toggle-btn" tabindex="-1">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="alert alert-danger mt-1 mb-3 p-2 small">{{ $message }}</div>
                    @enderror

                    <div class="auth-input-wrapper">
                        <input type="password" class="auth-control password-input" name="confirm_password" id="confirm_password" placeholder="Confirmer mot de passe" required autocomplete="new-password">
                        <i class="bi bi-lock-fill auth-input-icon"></i>
                        <button type="button" class="password-toggle-btn" tabindex="-1">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    @error('confirm_password')
                        <div class="alert alert-danger mt-1 mb-3 p-2 small">{{ $message }}</div>
                    @enderror

                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-auth w-100">S'inscrire</button>
                        
                        <div class="mt-4 pt-2">
                            <a href="{{ route('loginVue') }}" class="text-muted small text-decoration-none d-block mb-2">Déjà inscrit ? Se connecter</a>
                            <a href="{{ request()->url() }}" class="text-muted small text-decoration-none"><i class="bi bi-arrow-left me-2"></i>Retour à l'accueil</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="auth-footer-simple mt-4 text-center">
            <span class="d-block mb-3">Copyright © 2023 - 2026. Réalisé avec ❤️ par <a href="https://github.com/Cyrus2401" target="_blank" rel="noopener noreferrer" class="text-decoration-none">Cyrus2401</a>.</span>
            <div class="d-flex justify-content-center gap-3 footer-icons justify-content-center">
                <a href="https://github.com/Cyrus2401/tech-memes" target="_blank" rel="noopener noreferrer" aria-label="GitHub" class="text-muted text-decoration-none">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                </a>
                <a href="https://www.linkedin.com/in/yao-cyrus-junior-hessou-b6a58122b/" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn" class="text-muted text-decoration-none">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                </a>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            // Animate card entrance
            if (typeof gsap !== 'undefined') {
                gsap.from('.auth-card-container', {
                    duration: 0.4,
                    opacity: 0,
                    y: 20,
                    ease: 'power2.out'
                });
            }
        });
    </script>
@endsection