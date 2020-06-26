@extends('layouts.dashboard')

@section('content')

<div class="row">

  <div class="col-md-12">
    <div class="card">
      <div class="card-header card-header-primary">
        <h4 class="card-title">Filtros</h4>
      </div>
      <div class="card-body">
        <form method="POST" action="{{ route('logs.show') }}">
          @csrf
          <div class="row">
            <div class="form-group row col-md-4">
              <label for="staticEmail" class="col-sm-2 col-form-label">Filtro</label>
              <div class="col-sm-10">
                <select class="form-control" name="filtro" id="filtro">
                  <option value="trabajador">Trabajador</option>
                  <option value="todos">Todos</option>
                </select>
              </div>
            </div>
            <div class="form-group row col-md-4">
              <label class="bmd-label-floating">Código</label>
              <input type="text" id="ccod_traba" name="ccod_traba" class="form-control">
            </div>
            <div class="form-group row col-md-4">
              <label for="staticEmail" class="col-sm-2 col-form-label">Año</label>
              <div class="col-sm-10">
                <select class="form-control" name="anio" id="anio"></select>
              </div>
            </div>
            <div class="form-group row col-md-4">
              <label for="inputPassword" class="col-sm-2 col-form-label">Tipo</label>
              <div class="col-sm-10">
                <select class="form-control" name="tipo" id="tipo">
                  @forelse ($selectTipo as $tipo)
                  <option value="{{ $tipo->ccod_tpla }}">{{ $tipo->cabr_tpla }}</option>
                  @empty
                  <option>Todos</option>
                  @endforelse
                </select>
              </div>
            </div>
          </div>
          <button type="submit" class="btn btn-success pull-right">Filtrar</button>
          <div class="clearfix"></div>
        </form>
      </div>
    </div>
  </div>
  @if ($logs)
  <div class="col-md-12">
    <div class="card">
      <div class="card-header card-header-primary">
        <h4 class="card-title ">Listado de incidencia</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table">
            <thead class=" text-primary">
              <th>Código usuario</th>
              <th>Periodo</th>
              <th>Mes</th>
              <th>Ruta de Archivo</th>
              <th>Nombre de Archivo</th>
              <th>Total Descargas</th>
              <th>Detalle</th>
            </thead>
            <tbody>
              @forelse ($logs as $log)
              <tr>
                <td>{{ $log->Codigo}}</td>
                <td>{{ $log->Periodo}}</td>
                <td>{{ $log->Mes}}</td>
                <td>{{ $log->Ruta}}</td>
                <td>{{ $log->Nombre_Archivo}}</td>
                <td>{{ $log->Total_Descargas}}</td>
                <td></td>
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

  @endif
</div>

@endsection

<script>
  function loadPage() {
    ComboAno();
}

function ComboAnio() {
    var n = (new Date()).getFullYear()
    var select = document.getElementById("anio");
    for (var i = n; i >= 1900; i--) select.options.add(new Option(i, i));
};
window.onload = ComboAnio;
</script>