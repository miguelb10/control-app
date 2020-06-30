@extends('layouts.dashboard')

@section('content')
@if ($tryCorrect == true)
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
                    <a href="{{ route('profile') }}" class="btn btn-success">Cambiar Contraseña</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@if (Auth::user()->crole_traba == 'admin')
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

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">Cambiar tema</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-1 text-center">
                        </div>
                        <div class="col-md-2 text-center">
                            <form method="POST" action="{{ route('home.change') }}" id="changeV">
                                @csrf
                                <input type="hidden" value="verde" id="tema" name="tema">
                                <a href="#" class="btn btn-success"
                                    onclick="document.getElementById('changeV').submit()"></a>
                            </form>
                        </div>
                        <div class="col-md-2 text-center">
                            <form method="POST" action="{{ route('home.change') }}" id="changeR">
                                @csrf
                                <input type="hidden" value="rojo" id="tema" name="tema">
                                <a href="#" class="btn btn-danger"
                                    onclick="document.getElementById('changeR').submit()"></a>
                            </form>
                        </div>
                        <div class="col-md-2 text-center">
                            <form method="POST" action="{{ route('home.change') }}" id="changeA">
                                @csrf
                                <input type="hidden" value="azul" id="tema" name="tema">
                                <a href="#" class="btn btn-primary"
                                    onclick="document.getElementById('changeA').submit()"></a>
                            </form>
                        </div>
                        <div class="col-md-2 text-center">
                            <form method="POST" action="{{ route('home.change') }}" id="changeC">
                                @csrf
                                <input type="hidden" value="celeste" id="tema" name="tema">
                                <a href="#" class="btn btn-celeste"
                                    onclick="document.getElementById('changeC').submit()"></a>
                            </form>
                        </div>
                        <div class="col-md-2 text-center">
                            <form method="POST" action="{{ route('home.change') }}" id="changeN">
                                @csrf
                                <input type="hidden" value="naranja" id="tema" name="tema">
                                <a href="#" class="btn btn-naranja"
                                    onclick="document.getElementById('changeN').submit()"></a>
                            </form>
                        </div>
                        <div class="col-md-1 text-center">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@else
<div class="alert alert-danger" role="alert">
  Error en el sistema, por favor comuníquese con el administrador
</div>
@endif
@endsection