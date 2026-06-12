@extends('layouts.master')

@section('container')
    <section id="contact" class="contact">
        <div class="container mt-connected">

            <div class="section-title">
                <h2 class="text-dark">MON PROFIL</h2>
            </div>

            <div class="row justify-content-center g-4">
                {{-- Edit profile info card --}}
                <div class="col-lg-5">
                    <div class="php-email-form shadow-lg h-100">
                        <div class="text-center mb-4 pb-2">
                            <h3 class="fw-bold text-dark mb-1">Informations</h3>
                            <p class="text-muted small">Modifiez vos informations de profil</p>
                        </div>

                        @if(session()->has('success_profile'))
                            <div class="alert alert-success d-flex align-items-center mb-3">
                                <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                                <div class="small">{{ session()->get('success_profile') }}</div>
                            </div>
                        @endif

                        <form action="{{ route('updateProfile') }}" method="post" role="form">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="pseudo" class="form-label text-muted small ms-1 mb-1">Nom d'utilisateur (Pseudo)</label>
                                <div class="position-relative">
                                    <input type="text" name="pseudo" class="auth-control @error('pseudo') is-invalid @enderror" id="pseudo" placeholder="Ex: jean_dupont" value="{{ old('pseudo', $user->pseudo) }}" required>
                                    <i class="bi bi-person auth-input-icon"></i>
                                </div>
                                @error('pseudo')
                                    <div class="text-danger small mt-1 ms-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-4">
                                <label for="email" class="form-label text-muted small ms-1 mb-1">Adresse Email</label>
                                <div class="position-relative">
                                    <input type="email" class="auth-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="Ex: jean@exemple.com" value="{{ old('email', $user->email) }}" required autocomplete="email">
                                    <i class="bi bi-envelope auth-input-icon"></i>
                                </div>
                                @error('email')
                                    <div class="text-danger small mt-1 ms-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-auth w-100">Enregistrer les modifications</button>
                        </form>
                    </div>
                </div>

                {{-- Change password card --}}
                <div class="col-lg-5">
                    <div class="php-email-form shadow-lg h-100">
                        <div class="text-center mb-4 pb-2">
                            <h3 class="fw-bold text-dark mb-1"></i>Mot de passe</h3>
                            <p class="text-muted small">Modifiez votre mot de passe pour sécuriser votre compte</p>
                        </div>

                        @if(session()->has('success_password'))
                            <div class="alert alert-success d-flex align-items-center mb-3">
                                <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                                <div class="small">{{ session()->get('success_password') }}</div>
                            </div>
                        @endif

                        <form action="{{ route('updatePassword') }}" method="post" role="form">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="current_password" class="form-label text-muted small ms-1 mb-1">Mot de passe actuel</label>
                                <div class="position-relative">
                                    <input type="password" name="current_password" class="auth-control password-input @error('current_password') is-invalid @enderror" id="current_password" placeholder="Entrez votre mot de passe actuel" required autocomplete="current-password">
                                    <i class="bi bi-lock auth-input-icon"></i>
                                    <button type="button" class="password-toggle-btn" tabindex="-1">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                                @error('current_password')
                                    <div class="text-danger small mt-1 ms-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="new_password" class="form-label text-muted small ms-1 mb-1">Nouveau mot de passe</label>
                                <div class="position-relative">
                                    <input type="password" name="new_password" class="auth-control password-input @error('new_password') is-invalid @enderror" id="new_password" placeholder="Nouveau mot de passe (min. 6 caractères)" required autocomplete="new-password">
                                    <i class="bi bi-shield-lock auth-input-icon"></i>
                                    <button type="button" class="password-toggle-btn" tabindex="-1">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                                @error('new_password')
                                    <div class="text-danger small mt-1 ms-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-4">
                                <label for="confirm_password" class="form-label text-muted small ms-1 mb-1">Confirmer le mot de passe</label>
                                <div class="position-relative">
                                    <input type="password" class="auth-control password-input @error('confirm_password') is-invalid @enderror" name="confirm_password" id="confirm_password" placeholder="Confirmez votre nouveau mot de passe" required autocomplete="new-password">
                                    <i class="bi bi-lock-fill auth-input-icon"></i>
                                    <button type="button" class="password-toggle-btn" tabindex="-1">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                                @error('confirm_password')
                                    <div class="text-danger small mt-1 ms-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-auth w-100">Mettre à jour le mot de passe</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
