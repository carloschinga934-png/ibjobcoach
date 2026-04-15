@extends('shared.layout')
@section('title', 'Verificar Código – IBJobCoach')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/auth/code.css') }}">
@endpush

@section('content')
<section class="pw-code-area py-5" style="background-image:url('{{ asset('img/coworking.jpg') }}')">
    <div class="pw-code-wrap">
        <h2 class="pw-code-title text-center mb-4">Restablecer Contraseña</h2>
        @if(session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="correo" value="{{ old('correo', $correo) }}">
            <div class="mb-3">
                <label for="codigo" class="pw-code-label form-label">Código de verificación</label>
                <input type="text" id="codigo" name="codigo" class="form-control pw-code-input @error('codigo') is-invalid @enderror" required>
                @error('codigo') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
            <div class="mb-3">
                <label for="password" class="pw-code-label form-label">Nueva Contraseña</label>
                <input type="password" id="password" name="password" class="form-control pw-code-input @error('password') is-invalid @enderror" required>
                @error('password') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="pw-code-label form-label">Repetir Nueva Contraseña</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control pw-code-input" required>
            </div>
            <button type="submit" class="btn pw-code-btn w-100 mb-3">Restablecer contraseña</button>
        </form>
    </div>
</section>
@endsection
