@extends('pdf.layouts')
@section('content')
<div>
    <table id="facarticulo" >
        <thead class="" style="background-color:white ; color:black;">
            <tr id="">
                <th>ID Contrato</th>
                <th>Tipo de Contrato</th>
                <th>Inicio del Contrato</th>
                <th>Extinsión del Contrato</th>

            </tr>
        </thead>
        <tbody style="background-color:white ; color:black;">
            @if ($count>0)

            @foreach ($contratos as $contrato)
            <tr style="text-align: right">

                <td>{{$contrato->id}} </td>

                <td>{{$contrato->nombreTipoContrato}} </td>
                <td>{{\Carbon\Carbon::parse($contrato->inicioLaboral)->format('d/m/Y')}} </td>
                <td>{{\Carbon\Carbon::parse($contrato->finLaboral)->format('d/m/Y')}} </td>
                {{-- <td >{{$contrato->getFechaMovimiento()}} </td> --}}
                {{-- <td>{{$contrato->fecha}} </td> --}}
            </tr>
            @endforeach
            @endif
        </tbody>


    </table>
</div>
@endsection