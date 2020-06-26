@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title">Restringir acceso web</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('employees.update') }}">
                        @csrf
                        <input type="hidden" id="id" name="id" value="{{$employee->ccod_traba}}">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Nombres</label>
                                    <input type="text" id="cnomb_traba" name="cnomb_traba" class="form-control"
                                        value="{{$employee->cnomb_traba}}" disabled>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Apellido Paterno</label>
                                    <input type="text" id="capat_traba" name="capat_traba" class="form-control"
                                        value="{{$employee->capat_traba}}" disabled>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Apellido Materno</label>
                                    <input type="text" id="camat_traba" name="camat_traba" class="form-control"
                                        value="{{$employee->camat_traba}}" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="bmd-label-floating">DNI</label>
                                    <input type="text" id="cndni_traba" name="cndni_traba" class="form-control"
                                        value="{{$employee->cndni_traba}}" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Email</label>
                                    <input type="text" id="cemail_traba" name="cemail_traba" class="form-control"
                                        value="{{$employee->cemail_traba}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Fecha de caducidad</label>
                                    <input class="form-control" type="date" value="{{ date('yy-m-d') }}" id="fechaCaducidad" name="fechaCaducidad">
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success pull-right">Actualizar</button>
                        <div class="clearfix"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection