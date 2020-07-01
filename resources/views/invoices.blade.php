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
          <table id="alltable" class="table table-bordered nowrap" style="width:100%">
            <thead class="text-primary text-center">
              <th>Tipo</th>
              <th>Periodo</th>
              <th>Mes</th>
              <th>Desde</th>
              <th>Hasta</th>
              <th>Total Ingreso</th>
              <th>Total Egreso</th>
              <th>Total Aporte</th>
              <th>Neto</th>
              <th>Total Descargas</th>
              <th>Descargar</th>
            </thead>
            <tbody>
              @if ($invoices != null)  
              @forelse ($invoices as $invoiceItem)
              <tr>
                <td>{{ $invoiceItem->Tipo}}</td>
                <td class="text-center">{{ $invoiceItem->Periodo}}</td>
                <td>{{ $invoiceItem->Mes}}</td>
                <td class="text-center">{{ $invoiceItem->Desde}}</td>
                <td class="text-center">{{ $invoiceItem->Hasta}}</td>
                <td class="text-right">{{ $invoiceItem->Total_Ingreso}}</td>
                <td class="text-right">{{ $invoiceItem->Total_Egreso}}</td>
                <td class="text-right">{{ $invoiceItem->Total_Aporte}}</td>
                <td class="text-right">{{ $invoiceItem->Neto}}</td>
                <td class="text-center">{{ $invoiceItem->Total_Descargas}}</td>
                <td class="text-center">
                  @if ($invoiceItem->id_cbdocumentos != NULL)
                  <form method="POST" action="{{ route('invoices.download') }}" id="download{{ $invoiceItem->id_cbdocumentos}}">
                    @csrf
                    <input type="hidden" value="{{ $invoiceItem->id_cbdocumentos}}" id="id_doc" name="id_doc">
                    <a href="#" onclick="document.getElementById('download'+{{ $invoiceItem->id_cbdocumentos}}).submit()"><span class="material-icons">
                        cloud_download
                      </span></a>
                  </form>
                  @else
                  <form method="POST" action="{{ route('invoices.download') }}" id="download">
                    @csrf
                    <input type="hidden" value="{{ $invoiceItem->id_cbdocumentos}}" id="id_doc" name="id_doc">
                    <a href="#" onclick="document.getElementById('download').submit()"><span class="material-icons">
                        cloud_download
                      </span></a>
                  </form>                      
                  @endif
                </td>

              </tr>
              @empty
              <tr>
                <td colspan="9" style="text-align: center">No se encontraron boletas</td>
              </tr>
              @endforelse
              @else
              <tr>
                <td colspan="9" style="text-align: center">No se encontraron boletas</td>
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