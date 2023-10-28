@extends('adminlte::page')
@section('title', 'Perfil')
@section('content_header')
<h1 class="text-center">Perfil</h1>
@stop
@section('content')
<div class="row justify-content-center">
<div class="col-md-8">
    <div class="card">
        <div class="card-body justify-content-center d-flex pl-0 pr-0">
            <div  class="row col-lg-12 col-md-12">
                <div class="col-lg-12 col-md-12">
                    <div id="table_wrapper" class="wrapper dt-bootstrap4">
                        <!--Sección de información general del usuario-->
                        <div class="row">
                            <div class="col-lg-12 col-md-12 mb-3">
                                <div class="card">
                                    <div class="card-header d-flex align-items-center">
                                        <h3 class="card-title">Información General</h3>
                                        <div class="card-tools ml-auto">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                            <i class="fas fa-minus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        {!! Form::model($user, ['method' => 'PATCH', 'route' => ['perfil.updateInfo', $user->id]]) !!}
                                        <div id="table_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                            <div class="row">
                                                <div class="col-sm-12 card-body table-responsive p-0">
                                                    <div class="col-lg-12 col-md-12 mb-3">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="name" class="text-secondary">Nombre</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-8">
                                                                {!! Form::text('name', null, [
                                                                'class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : '')
                                                                ]) !!}
                                                                @error('name')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12 card-body table-responsive p-0">
                                                    <div class="col-lg-12 col-md-12 mb-3">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="last_name" class="text-secondary">Apellido</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-8">
                                                                {!! Form::text('last_name', null, [
                                                                'class' => 'form-control' . ($errors->has('last_name') ? ' is-invalid' : '')
                                                                ]) !!}
                                                                @error('last_name')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12 card-body table-responsive p-0">
                                                    <div class="col-lg-12 col-md-12 mb-3">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="email" class="text-secondary">Correo</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-8">
                                                                {!! Form::email('email', null, [
                                                                'class' => 'form-control' . ($errors->has('email') ? ' is-invalid' : '')
                                                                ]) !!}
                                                                @error('email')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12 card-body table-responsive p-0 text-right">
                                                    <div class="col-lg-12 col-md-12 mb-3">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <button type="submit" class="btn btn-secondary">Guardar</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Sección de cambio de contraseña-->
                        <div class="row">
                            <div class="col-lg-12 col-md-12 mb-3">
                                <div class="card">
                                    <div class="card-header d-flex align-items-center">
                                        <h3 class="card-title">Contraseña</h3>
                                        <div class="card-tools ml-auto">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                            <i class="fas fa-minus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        {!! Form::open(['method' => 'POST', 'route' => ['perfil.updatePass']]) !!}
                                        <div id="table_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                            <div class="row">
                                                <div class="col-sm-12 card-body table-responsive p-0">
                                                    <div class="col-lg-12 col-md-12 mb-3">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="old-password" class="text-secondary">Contraseña Actual</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-9">
                                                                {!! Form::password('old-password', [
                                                                'class' => 'form-control' . ($errors->has('old-password') ? ' is-invalid' : '')
                                                                ]) !!}
                                                                @error('old-password')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12 card-body table-responsive p-0">
                                                    <div class="col-lg-12 col-md-12 mb-3">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="password" class="text-secondary">Contraseña Nueva</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-9">
                                                                {!! Form::password('password', [
                                                                'class' => 'form-control' . ($errors->has('password') ? ' is-invalid' : '')
                                                                ]) !!}
                                                                @error('password')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12 card-body table-responsive p-0">
                                                    <div class="col-lg-12 col-md-12 mb-3">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="confirm-password" class="text-secondary">Confirmar Contraseña</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-9">
                                                                {!! Form::password('confirm-password', [
                                                                'class' => 'form-control' . ($errors->has('confirm-password') ? ' is-invalid' : '')
                                                                ]) !!}
                                                                @error('confirm-password')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12 card-body table-responsive p-0 text-right">
                                                    <div class="col-lg-12 col-md-12 mb-3">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <button type="submit" class="btn btn-secondary">Guardar</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Autenticación de doble factor-->
                        <div class="row">
                            <div class="col-lg-12 col-md-12 mb-3">
                                <div class="card">
                                    <div class="card-header d-flex align-items-center">
                                        <h3 class="card-title">Autenticación de Doble Factor</h3>
                                        <div class="card-tools ml-auto">
                                            @if ($factorEnabled)
                                            <a href="{{ route('deshabilitarFA') }}"class="btn btn-sm btn-outline-danger my-0">Deshabilitar</a>
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse"><i class="fas fa-minus"></i></button>
                                            @else
                                            <a href="{{ route('habilitarFA') }}"class="btn btn-sm btn-outline-info my-0">Habilitar</a>
                                            @endif
                                        </div>
                                    </div>
                                    @if ($factorEnabled)
                                    <div class="card-body">
                                        <div id="table_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                            <div class="row">
                                                <div class="col-sm-12 card-body table-responsive p-0">
                                                    <p>Escanee su código QR para su uso posterior</p>
                                                    <div class="row m-4">
                                                        <div class="col-md-12 text-center">
                                                            {!! $qrCode !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('js')
<script>
    jQuery.noConflict();
    (function($) {      
        toastr.options = {"closeButton": true, "progressBar": true}
        @if (Session::has('success'))
        toastr.success("{{ session('success') }}");
        @endif
    
        @if (Session::has('error'))
        toastr.error("{{ session('error') }}");
        @endif
    })(jQuery);
</script>
@stop