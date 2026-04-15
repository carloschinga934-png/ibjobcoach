@extends('shared.layout')

@section('title', 'Registrarse – IBJobCoach')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/auth/register.css') }}">
    <script src="{{ asset('js/register/register.js') }}" defer></script>
@endpush

@section('content')
<section class="area-registro py-5" style="background-image:url('{{ asset('img/coworking.jpg') }}')">
    <div class="registro-wrap">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-12">
                <h1 class="titulo-registro text-center mb-5">Crea tu cuenta en IBJobCoach</h1>
                <form method="POST" action="{{ route('register.attempt') }}" id="formRegistro">
                    @csrf
                    <div class="row gx-4 gy-3">
                        <div class="col-md-6">
                            <label for="nombre" class="texto-registro form-label">Nombre</label>
                            <input type="text" id="nombre" name="nombre" class="form-control campo-registro @error('nombre') is-invalid @enderror" required autofocus>
                            @error('nombre') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="apellido" class="texto-registro form-label">Apellido</label>
                            <input type="text" id="apellido" name="apellido" class="form-control campo-registro @error('apellido') is-invalid @enderror" required>
                            @error('apellido') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="telefono" class="texto-registro form-label">Teléfono</label>
                            <input type="text" id="telefono" name="telefono" class="form-control campo-registro @error('telefono') is-invalid @enderror">
                            @error('telefono') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="pais" class="texto-registro form-label">País</label>
                            <input type="text" id="pais" name="pais" class="form-control campo-registro @error('pais') is-invalid @enderror" required>
                            @error('pais') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="cargo" class="texto-registro form-label">Cargo</label>
                            <input type="text" id="cargo" name="cargo" class="form-control campo-registro @error('cargo') is-invalid @enderror">
                            @error('cargo') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="correo" class="texto-registro form-label">Correo electrónico</label>
                            <input type="email" id="correo" name="correo" class="form-control campo-registro @error('correo') is-invalid @enderror" required>
                            @error('correo') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="password" class="texto-registro form-label">Contraseña</label>
                            <div class="input-icono">
                                <input type="password" id="password" name="password" class="form-control campo-registro @error('password') is-invalid @enderror" required>
                                <span class="icono-ojo" onclick="togglePassword('password', this)">
                                    <!-- SVG ICONO OJO -->
                                    <svg xmlns="http://www.w3.org/2000/svg" height="22" viewBox="0 0 24 24" width="22">
                                        <path d="M12 4.5C7.305 4.5 3.134 7.273 1 12c2.134 4.727 6.305 7.5 11 7.5s8.866-2.773 11-7.5C20.866 7.273 16.695 4.5 12 4.5zm0 13c-3.857 0-7.124-2.173-8.942-6C4.876 7.673 8.143 5.5 12 5.5s7.124 2.173 8.942 6c-1.818 3.827-5.085 6-8.942 6zm0-9a3 3 0 110 6 3 3 0 010-6zm0 4a1 1 0 100-2 1 1 0 000 2z"/>
                                    </svg>
                                </span>
                            </div>
                            @error('password') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="password_confirmation" class="texto-registro form-label">Repetir Contraseña</label>
                            <div class="input-icono">
                                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control campo-registro" required>
                                <span class="icono-ojo" onclick="togglePassword('password_confirmation', this)">
                                    <!-- SVG ICONO OJO -->
                                    <svg xmlns="http://www.w3.org/2000/svg" height="22" viewBox="0 0 24 24" width="22">
                                        <path d="M12 4.5C7.305 4.5 3.134 7.273 1 12c2.134 4.727 6.305 7.5 11 7.5s8.866-2.773 11-7.5C20.866 7.273 16.695 4.5 12 4.5zm0 13c-3.857 0-7.124-2.173-8.942-6C4.876 7.673 8.143 5.5 12 5.5s7.124 2.173 8.942 6c-1.818 3.827-5.085 6-8.942 6zm0-9a3 3 0 110 6 3 3 0 010-6zm0 4a1 1 0 100-2 1 1 0 000 2z"/>
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn boton-registro w-100 mb-3 mt-4">
                        Registrarme
                    </button>
                    <a href="{{ route('login') }}" class="btn boton-registro-secundario w-100">
                        Ya tengo cuenta
                    </a>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
