@extends('shared.layout')
@section('title', 'Recuperar Contraseña – IBJobCoach')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/auth/email.css') }}">
@endpush

@section('content')
<section class="pw-email-area py-5" style="background-image:url('{{ asset('img/coworking.jpg') }}')">
    <div class="pw-email-wrap">
        <h2 class="pw-email-title text-center mb-4">Recuperar Contraseña</h2>
        @if(session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="mb-3">
                <label for="correo" class="pw-email-label form-label">Correo electrónico</label>
                <input type="email" id="correo" name="correo" value="{{ old('correo') }}" class="form-control pw-email-input @error('correo') is-invalid @enderror" required autofocus>
                @error('correo') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
            <button type="submit" class="btn pw-email-btn w-100 mb-3">Enviar código</button>
            <a href="{{ route('login') }}" class="btn pw-email-btn-sec w-100">Volver al login</a>
        </form>
    </div>
</section>
@endsection
