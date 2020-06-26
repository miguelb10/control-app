@extends('layouts.dashboard')

@section('content')

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header card-header-primary">
        <h4 class="card-title ">Registro de Emisión de Documentos</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table id="invoices" class="table table-bordered" style="width:100%">
            <thead class=" text-primary">
              <th>Periodo</th>
              <th>Mes</th>
              <th>Desde</th>
              <th>Hasta</th>
              <th>Total Ingreso</th>
              <th>Total Egreso</th>
              <th>Total Aporte</th>
              <th>Neto</th>
              <th>Descargar</th>
            </thead>
            <tbody>
              @forelse ($invoices as $invoiceItem)
              <tr>
                <td>{{ $invoiceItem->Periodo}}</td>
                <td>{{ $invoiceItem->Mes}}</td>
                <td>{{ $invoiceItem->Desde}}</td>
                <td>{{ $invoiceItem->Hasta}}</td>
                <td>{{ $invoiceItem->Total_Ingreso}}</td>
                <td>{{ $invoiceItem->Total_Egreso}}</td>
                <td>{{ $invoiceItem->Total_Aporte}}</td>
                <td>{{ $invoiceItem->Neto}}</td>
                <td><a href="{{ $invoiceItem->cruta_file}}"><span class="material-icons">
                      cloud_download
                    </span></a></td>
              </tr>
              @empty
              <tr>
                <td colspan="9" style="text-align: center">No se encontraron facturas</td>
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