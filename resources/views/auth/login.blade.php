@extends('layouts.app')

@section('content')
<style>
      html, body {
        height: 100%;
        background-color: #0f172a;
        margin: 0;
        padding: 0;
    }

    #default-sidebar, #toggleSidebarBtn {
        display: none !important; /* Ocultar la barra izquierda */
    }

    

    .login-card {
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(10px);
    border-radius: 16px;
    padding: 30px;
    width: 120%;
    max-width: 500px; 
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
    color: #e2e8f0;
    text-align: center;
}
    .login-card label {
        color: #e2e8f0;
    }

    .form-control {
        background-color: rgba(255, 255, 255, 0.1);
        border: 1px solid #4b5563;
        color: #fff;
    }

    .form-control:focus {
        background-color: rgba(255, 255, 255, 0.15);
        border-color: #60a5fa;
        color: #fff;
        box-shadow: none;
    }

    .btn-primary {
        background-color: #3b82f6;
        border-color: #3b82f6;
    }

    .btn-primary:hover {
        background-color: #2563eb;
        border-color: #2563eb;
    }

    .btn-link {
        color: #93c5fd;
    }

    .btn-link:hover {
        color: #bfdbfe;
    }

    .invalid-feedback {
        color: #f87171;
    }

    .login-logo {
        width: 100px;
        height: auto;
        margin-bottom: 20px;
    }
</style>

<div class="position-absolute top-50 start-50 translate-middle">
    <div class="login-card">
        <!-- Logo centrado arriba del login -->
        <img src="{{ asset('images/innovalogo.png') }}" alt="Innova Logo" class="login-logo">
        
        <h4 class="mb-4">{{ __('INNOVA CORPORATIVO') }}</h4>
        
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3 text-start">
                <label for="email" class="form-label">{{ __('Correo electrónico') }}</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                       name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3 text-start">
                <label for="password" class="form-label">{{ __('Contraseña') }}</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                       name="password" required autocomplete="current-password">
                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3 form-check text-start">
                <input class="form-check-input" type="checkbox" name="remember" id="remember"
                       {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label" for="remember">
                    {{ __('Mantener sesión activa') }}
                </label>
            </div>

            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-primary">
                    {{ __('Iniciar sesión') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
