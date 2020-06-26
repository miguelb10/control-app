@extends('layouts.dashboard')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Home</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if ($validateFirstLogin == true)
                        <h5 style="Color: red"><strong>Por seguridad debe cambiar su contraseña antes de continuar!</strong></h5>
                        <a href="/profile" class="btn btn-success">Cambiar Contraseña</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
