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
                    <table id="logs" class="table table-bordered" style="width:100%">
                        <thead class="text-primary text-center">
                            <th>ID documento</th>
                            <th>Fecha y hora</th>
                            <th>IP</th>
                        </thead>
                        <tbody>
                            @forelse ($details as $detail)
                            <tr class="text-center">
                                <td>{{ $detail->id_cbdocumentos}}</td>
                                <td>{{ $detail->dfch_descarga}}</td>
                                <td>{{ $detail->cpc_descarga}}</td>
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