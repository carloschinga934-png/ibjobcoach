@extends('shared.layout')

@section('title', 'Acceder – IBJobCoach')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/auth/login.css') }}">
@endpush

@section('content')

    {{-- Caja de login --}}
    <section class="box-login py-5"  style="background-image:url('{{ asset('img/coworking.jpg') }}')">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">

                    <h1 class="titulo-login2 text-center mb-4">¡Ya soy cliente de IBJobCoach!</h1>

                    <form method="POST" action="{{ route('login.attempt') }}" id="iniciarSesion">
                        @csrf

                        {{-- CORREO --}}
                        <div class="mb-3">
                            <label for="correo" class="texto-login2 form-label">CORREO</label>
                            <input  type="email"
                                    id="correo"
                                    name="correo"
                                    class="form-control DatosLogin @error('correo') is-invalid @enderror"
                                    value="{{ old('correo') }}"
                                    required
                                    autofocus>
                            @error('correo')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- PASSWORD --}}
                        <div class="mb-3">
                            <label for="password" class="texto-login2 form-label">CONTRASEÑA</label>
                            <input  type="password"
                                    id="password"
                                    name="password"
                                    class="form-control DatosLogin @error('password') is-invalid @enderror"
                                    required>
                            @error('password')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Mensajes de error genéricos --}}
                        @if(session('status'))
                            <p class="text-danger">{{ session('status') }}</p>
                        @endif

                        {{-- RECORDAR --}}
                        <div class="form-check mb-3">
                            <input  class="form-check-input"
                                    type="checkbox"
                                    value="1"
                                    id="remember"
                                    name="remember">
                            <label class="form-check-label" for="remember">Recordarme</label>
                        </div>

                        {{-- BOTONES --}}
                        <button type="submit" class="btn DatosLogin w-100 mb-3" style="background-color:red;color:#fff;">
                            ENTRAR
                        </button>

                        <a href="#" class="btn DatosLogin w-100" style="background-color:#dc9f49;color:#fff;">
                            PRUEBA 
                        </a>

                        {{-- enlaces auxiliares --}}
                        <div class="text-center mt-3">
                            <a href="{{ route("password.request") }}" class="esqueceu-senha d-block mb-1">¿Olvidó su contraseña?</a>
                            <a href="{{ route("register.form") }}">No tengo cuenta creada</a>
                            {{--<a href="#" class="esqueceu-senha">Reenviar confirmación de e-mail</a>--}}
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </section>

    {{-- Carrusel de testimonios: puedes convertirlo en componente si lo usarás en más páginas --}}
    @include('auth.partials.testimonios')
@endsection
