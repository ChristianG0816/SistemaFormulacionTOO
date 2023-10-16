<!DOCTYPE html>
<html lang="es">
<head>
  <title>Autenticar</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container min-vh-100 d-flex flex-column justify-content-center">
        <h1 class="text-center">Autenticación de Dos Pasos</h1>
        <div class="row justify-content-center m-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 m-4">
                                {!! Form::open(['method' => 'POST', 'route' => 'verificar']) !!}
                                <div class="form-row align-items-center">
                                    <div class="form-group col-md-3">
                                        <label for="two_factor_key" class="col-form-label text-secondary">Código de Autenticación:</label>
                                    </div>
                                    <div class="form-group col-md-6">
                                        {!! Form::text('two_factor_key', null, ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="form-group col-md-3">
                                        <button type="submit" class="btn btn-info">Guardar</button>
                                        <a href="{{ route('cancel') }}" class="btn btn-danger">Cancelar</a>
                                    </div>
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
