@extends('layouts.dashboard')

@section('content')

@if (session('status'))
<div class="alert alert-success" role="alert">
  {{ session('status') }}
</div>
@endif
@if (session('statusFail'))
<div class="alert alert-danger" role="alert">
  {{ session('statusFail') }}
</div>
@endif
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header card-header-primary">
        <h4 class="card-title ">Registro de Emisión de Documentos</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table id="users" class="table table-bordered" style="width:100%">
            <thead class=" text-primary">
              <th>Código</th>
              <th>Nombre</th>
              <th>Apellido Paterno</th>
              <th>Apellido Mterno</th>
              <th>Correo</th>
              <th>Acceso</th>
              <th>Asignar</th>
            </thead>
            <tbody>
              @forelse ($employees as $employee)
              <tr>
                <td>{{ $employee->ccod_traba}}</td>
                <td>{{ $employee->cnomb_traba}}</td>
                <td>{{ $employee->capat_traba}}</td>
                <td>{{ $employee->camat_traba}}</td>
                <td>{{ $employee->cemail_traba}}</td>
                @if ($employee->acceso_web_traba == true)
                <td>Si</td>
                <td>
                  <a href="{{ route('employee.show', $employee->ccod_traba) }}"><input type="submit" value="Retirar"
                      class="btn-danger"></a>
                </td>
                @else
                <td>No</td>
                <td>
                  <form method="POST" action="{{ route('employees.update') }}" id="accessEmployee">
                    @csrf
                    <input type="hidden" value="{{ $employee->ccod_traba}}" id="id" name="id">
                    <input type="submit" value="Asignar" class="btn-success">
                  </form>
                </td>
                @endif
              </tr>
              @empty
              <tr>
                <td colspan="6" style="text-align: center">No se encontraron facturas</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection