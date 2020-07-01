@extends('layouts.dashboard')

@section('content')

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header card-header-primary">
        <h4 class="card-title ">Listado de incidencia</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table id="alltable" class="table table-bordered nowrap" style="width:100%">
            <thead class="text-primary text-center">
              <th>Código usuario</th>
              <th>Periodo</th>
              <th>Año</th>
              <th>Mes</th>
              <th>Ruta de Archivo</th>
              <th>Nombre de Archivo</th>
              <th>Total Descargas</th>
              <th>Detalle</th>
            </thead>
            <tbody>
              @if ($logs != null)
              @forelse ($logs as $log)
              <tr>
                <td class="text-center">{{ $log->Codigo}}</td>
                <td class="text-center">{{ $log->Periodo}}</td>
                <td class="text-center">{{ $log->Anio}}</td>
                <td>{{ $log->Mes}}</td>
                <td>{{ $log->Ruta}}</td>
                <td>{{ $log->Nombre_Archivo}}</td>
                <td class="text-center">{{ $log->Total_Descargas}}</td>
                <td class="text-center">
                  <form method="POST" action="{{ route('logs.show') }}" id="downloads{{ $log->id_doc}}">
                    @csrf
                    <input type="hidden" value="{{ $log->id_doc}}" id="id_doc" name="id_doc">
                    <a href="#" onclick="document.getElementById('downloads'+{{ $log->id_doc}}).submit()"><span class="material-icons">
                        remove_red_eye
                      </span></a>
                  </form>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="8" style="text-align: center">No se encontraron regitros</td>
              </tr>
              @endforelse
              @else
              <tr>
                <td colspan="8" style="text-align: center">No se encontraron registros</td>
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