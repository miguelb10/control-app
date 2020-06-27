@extends('layouts.dashboard')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">Vista principal</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    @if ($validateFirstLogin == true)
                    <h5 style="Color: red"><strong>Por seguridad debe cambiar su contraseña antes de continuar!</strong>
                    </h5>
                    <a href="/profile" class="btn btn-success">Cambiar Contraseña</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@if (Auth::user()->role == 'admin')
<div class="row">
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-header card-header-warning card-header-icon">
                <div class="card-icon">
                    <i class="material-icons">login</i>
                </div>
                <p class="card-category">Ingresos a la web</p>
                <h3 class="card-title">{{ sizeOf($cantLogin)}}</h3>
            </div>
            <div class="card-footer">
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-header card-header-success card-header-icon">
                <div class="card-icon">
                    <i class="material-icons">store</i>
                </div>
                <p class="card-category">Visitas Página Inicio</p>
                <h3 class="card-title">{{ sizeOf($cantHome)}}</h3>
            </div>
            <div class="card-footer">
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-header card-header-danger card-header-icon">
                <div class="card-icon">
                    <i class="material-icons">find_in_page</i>
                </div>
                <p class="card-category">Visitas Página Boletas</p>
                <h3 class="card-title">{{ sizeOf($cantBoletas)}}</h3>
            </div>
            <div class="card-footer">
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-header card-header-info card-header-icon">
                <div class="card-icon">
                    <i class="material-icons">cloud_download</i>
                </div>
                <p class="card-category">Descargas Totales</p>
                <h3 class="card-title">{{ sizeOf($cantDescargas)}}</h3>
            </div>
            <div class="card-footer">
            </div>
        </div>
    </div>
</div>
@endif
@endsection