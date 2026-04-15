@extends('auth.layout.dash_layout')

@section('title', 'Editar Empleado')

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
                            <h4 class="ib-tecnicas-title" style="color:white;">Editar Empleado</h4>
                            <p class="ib-tecnicas-desc" style="color:white;">Actualiza los datos del empleado</p>
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

                            <form action="{{ route('admin.empleados.actualizar', $empleado->idusuario) }}" method="POST" autocomplete="off">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="nombre">Nombre</label>
                                    <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $empleado->nombre) }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="apellido">Apellido</label>
                                    <input type="text" name="apellido" class="form-control" value="{{ old('apellido', $empleado->apellido) }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="correo">Correo electrónico</label>
                                    <input type="email" name="correo" class="form-control" value="{{ old('correo', $empleado->correo) }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="role_id">Rol</label>
                                    <select name="role_id" class="form-control" required>
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id }}" {{ $empleado->role_id == $role->id ? 'selected' : '' }}>{{ $role->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primary">Actualizar Empleado</button>
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
                                Puedes actualizar los datos básicos del empleado y su rol. Si necesitas cambiar la contraseña, usa la sección de gestión de usuarios.
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
