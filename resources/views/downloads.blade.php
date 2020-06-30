@extends('layouts.dashboard')

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-primary">
                <h4 class="card-title ">Detalle de descargas</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="logs" class="table table-bordered nowrap" style="width:100%">
                        <thead class="text-primary text-center">
                            <th>ID documento</th>
                            <th>Fecha y hora</th>
                            <th>IP</th>
                        </thead>
                        <tbody>
                            @if ($details != null)
                            @forelse ($details as $detail)
                            <tr class="text-center">
                                <td>{{ $detail->id_cbdocumentos}}</td>
                                <td>{{ $detail->dfch_descarga}}</td>
                                <td>{{ $detail->cpc_descarga}}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" style="text-align: center">No se encontraron registros</td>
                            </tr>
                            @endforelse
                            @else
                            <tr>
                              <td colspan="3" style="text-align: center">No se encontraron registros</td>
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