@extends('templates.template')
@section('contents')
<div class="col ">
	<div class="mb-0 mt-1">
		<h3 class=" mb-0 bg-black alert text-light text-center">Controle de Veículos</h3>
	</div>
	<table class="table-responsive-lg text-center table table-bordered table-hover">
		<thead class="table-sm bg-dark text-light">
			<tr>
				<th scope="col">N° Vaga</th>
				<th scope="col">CPF </th>
				<th scope="col">Entrada</th>
				<th scope="col">Permanência</th>
				<th scope="col">Modelo</th>
				<th scope="col">Placa</th>
				<th scope="col">Data</th>
				<th scope="col">Mensalista</th>
				<th scope="col">Total R$</th>
			</tr>
		</thead>
		<tbody class=" table-sm">
			@forelse($vacancies as $vacancy)
				<tr>
					<td>{{$vacancy->order}}</td>
					<td>{{$vacancy->park->cpf}}</td>
					<td>{{$vacancy->park->timeIn}}</td>
					<td><span class="badge badge-warning">{{gmdate('H:i:s',$vacancy->timeOut)}}</span></td>
					<td>{{$vacancy->park->model}}</td>
					<td>{{$vacancy->park->board}}</td>
					<td>{{date('d-m-Y',strtotime($vacancy->created_at))}}</td>
					@if($vacancy->park->cpf!=0)
					<td><span class="badge badge-success">Sim</span></td>
					<td>--</td>
					@else
					<td><span class="badge badge-danger">Não</span></td>
					<td><span class="badge badge-dark">R$ {{number_format($vacancy->timeOut * ($price->price / 3600), 2)}}</span></td>
					@endif
				</tr>
			@empty
			<h2 class="alert alert-info">Nenhuma vaga ocupada!</h2>
			@endforelse
		</tbody>
	</table>
</div>
@endsection