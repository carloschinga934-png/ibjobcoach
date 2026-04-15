@extends('auth.layout.dash_layout')

@section('title', 'Registrar Nuevo Empleado')

@section('body')
<div class="ib-wrapper">
    @include('auth.layout.partials.sidebar')
    <main class="ib-main-panel">
        @include('auth.layout.partials.navbar')

        <section class="ib-content">
            <div class="row justify-content-center">
                <div class="col-md-7">
                    <div class="card ib-tecnicas-card">
                        <div class="ib-tecnicas-header card-header-primary">
                            <h4 class="ib-tecnicas-title" style="color:white;">Registrar Nuevo Empleado</h4>
                            <p class="ib-tecnicas-desc" style="color:white;">Completa todos los campos requeridos</p>
                        </div>
                        <div class="card-body">
                            @if(session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul style="margin-bottom: 0;">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('admin.empleados.guardar') }}" method="POST" autocomplete="off">
                                @csrf
                                <div class="form-group">
                                    <label for="nombre">Nombre</label>
                                    <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="apellido">Apellido</label>
                                    <input type="text" name="apellido" class="form-control" value="{{ old('apellido') }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="correo">Correo electrónico</label>
                                    <input type="email" name="correo" class="form-control" value="{{ old('correo') }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="password">Contraseña</label>
                                    <input type="password" name="password" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label for="password_confirmation">Confirmar Contraseña</label>
                                    <input type="password" name="password_confirmation" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label for="role_id">Rol</label>
                                    <select name="role_id" class="form-control" required>
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primary">Registrar Empleado</button>
                                <a href="{{ route('admin.empleados') }}" class="btn btn-secondary">Cancelar</a>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="card card-profile ib-tecnicas-card">
                        <div class="card-avatar">
                            <img class="img" src="{{ asset('img/auth/dashboard/javier2.png') }}" alt="Empleado">
                        </div>
                        <div class="card-body">
                            <h6 class="card-category text-gray">Información</h6>
                            <h4 class="card-title">IBJobCoach</h4>
                            <p class="card-description">
                                Los empleados registrados podrán monitorear usuarios y brindar acompañamiento personalizado. Elige correctamente el rol de empleado.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        @include('auth.layout.partials.footer')
    </main>
</div>
@endsection
