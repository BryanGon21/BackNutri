@extends('blank')

@section('content')
  
<div class="text-section">I. DATOS GENERALES</div>

  <table class="bordes table-inf">
    <tr>
      <td style="width: 40%;" class="text-upper">apellidos y nombres: </td>
      <td style="width: 60%;">{{ $datos->apellidos }}, {{ $datos->nombres }}</td>
    </tr>
    <tr>
      <td class="text-upper">género: </td>
      <td>{{ $datos->genero }}</td>
    </tr>
    <tr>
      <td class="text-upper">FECHA DE NACIMIENTO: </td>
      <td>{{ date('d/m/Y',strtotime($datos->fecha_nacimiento)) }}</td>
    </tr>
    {{-- <tr>
      <td class="text-upper">edad: </td>
      <td>{{ $datos->edad }}</td>
    </tr> --}}
    <tr>
      <td class="text-upper">ocupación: </td>
      <td>{{ $datos->ocupacion }}</td>
    </tr>
    <tr>
      <td class="text-upper">CELULAR: </td>
      <td>{{ $datos->celular }}</td>
    </tr>
    <tr>
      <td class="text-upper">Correo electrónico: </td>
      <td>{{ $datos->email }}</td>
    </tr>
    <tr>
      <td class="text-upper">residencia: </td>
      <td>{{ $datos->residencia }}</td>
    </tr>
  </table>

  <div class="text-section">II. DATOS DE CONSULTAS</div>
    @foreach ($datos->citas as $item)
      @if ($item->consulta)
        <div class="separe"></div>
        <table class="table-inf">
          <tr>
            <td style="width: 35%;">Fecha: {{ date('d/m/Y',strtotime($item->fecha_inicio)) }}</td>
            <td style="width: 35%;">Hora: {{ date('H:i',strtotime($item->fecha_inicio)) }} - {{ date('H:i',strtotime($item->fecha_fin)) }}</td>
            <td style="width: 30%;">Estado: {{ $item->estado }}</td>
          </tr>
        </table>
        <div>Observación: {{ $item->observacion }}</div>
        <table class="bordes table-inf">
          <tr>
            <td style="width: 20%;" class="negrita cel-title">MOTIVO</td>
            <td style="width: 80%;">{{ $item->consulta->motivo }}</td>
          </tr>
          <tr>
            <td class="negrita cel-title">EXPECTATIVAS</td>
            <td>{{ $item->consulta->expectativas }}</td>
          </tr>
          <tr>
            <td class="negrita cel-title">EXAMEN FISICO</td>
            <td>{{ $item->consulta->examen_fisico }}</td>
          </tr>
          <tr>
            <td class="negrita cel-title">DIAGNOSTICO</td>
            <td>{{ $item->consulta->diagnostico }}</td>
          </tr>
          <tr>
            <td class="negrita cel-title">TRATAMIENTO</td>
            <td>{{ $item->consulta->tratamiento }}</td>
          </tr>
          <tr>
            <td class="negrita cel-title">OBSERVACION</td>
            <td>{{ $item->consulta->observacion }}</td>
          </tr>
        </table>
      @endif
    @endforeach
@endsection

@section('scripts')
  <style>
    .table-inf {
      width: 100%;
    }
    .text-section {
      margin-top: 10px;
      font-weight: bold;
    }
    .text-upper {
      text-transform: uppercase;
    }
    .separe {
      height: 20px;
    }
  </style>
@endsection