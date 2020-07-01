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
        <h4 class="card-title ">Administrar accesos</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table id="alltable" class="table table-bordered nowrap" style="width:100%">
            <thead class=" text-primary text-center">
              <th>Código</th>
              <th>Nombre</th>
              <th>Apellido Paterno</th>
              <th>Apellido Mterno</th>
              <th>Correo</th>
              <th>Acceso</th>
              <th>Acción</th>
            </thead>
            <tbody>
              @if ($employees != null)                  
              @forelse ($employees as $employee)
              <tr>
                <td class="text-center">{{ $employee->ccod_traba}}</td>
                <td>{{ $employee->cnomb_traba}}</td>
                <td>{{ $employee->capat_traba}}</td>
                <td>{{ $employee->camat_traba}}</td>
                <td>{{ $employee->cemail_traba}}</td>
                @if ($employee->acceso_web_traba == true)
                <td class="text-center">Si</td>
                <td class="text-center">
                  <a href="{{ route('employee.show', $employee->ccod_traba) }}"><input type="submit" value="Restringir"
                      class="btn-danger"></a>
                </td>
                @else
                <td class="text-center">No</td>
                <td class="text-center">
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
                <td colspan="6" style="text-align: center">No se encontraron usuarios</td>
              </tr>
              @endforelse
              @else
              <tr>
                <td colspan="6" style="text-align: center">No se encontraron usuarios</td>
              </tr>
              @endif
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection