@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
  @if (session('status'))
  <div class="alert alert-success" role="alert">
    {{ session('status') }}
  </div>
  @endif
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header card-header-primary">
          <h4 class="card-title">Editar perfil</h4>
          <p class="card-category">Completar datos</p>
        </div>
        <div class="card-body">
          <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            <input type="hidden" id="ccod_traba" name="ccod_traba" value="{{$profile->ccod_traba}}">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label class="bmd-label-floating">Nombres</label>
                  <input type="text" id="cnomb_traba" name="cnomb_traba" class="form-control"
                    value="{{$profile->cnomb_traba}}">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="bmd-label-floating">Apellido Paterno</label>
                  <input type="text" id="capat_traba" name="capat_traba" class="form-control"
                    value="{{$profile->capat_traba}}">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="bmd-label-floating">Apellido Materno</label>
                  <input type="text" id="camat_traba" name="camat_traba" class="form-control"
                    value="{{$profile->camat_traba}}">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="bmd-label-floating">DNI</label>
                  <input type="text" id="cndni_traba" name="cndni_traba" class="form-control"
                    value="{{$profile->cndni_traba}}">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="bmd-label-floating">RUC</label>
                  <input type="text" id="cnruc_traba" name="cnruc_traba" class="form-control"
                    value="{{$profile->cnruc_traba}}">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label class="bmd-label-floating">Dirección</label>
                  <input type="text" id="cdire_traba" name="cdire_traba" class="form-control"
                    value="{{$profile->cdire_traba}}">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label class="bmd-label-floating">Email</label>
                  <input type="text" id="cemail_traba" name="cemail_traba" class="form-control"
                    value="{{$profile->cemail_traba}}">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="bmd-label-floating">Contraseña</label>

                  <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                    name="password" required autocomplete="new-password">

                  @error('password')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="bmd-label-floating">Repita Contraseña</label>
                  <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                    required autocomplete="new-password">
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