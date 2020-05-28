@extends('templates.template')

@section('contents')

@if(isset($info))
<div class="msg alert alert-info">
	{{$info}}
</div>
@endif

<div class="col-md-4 pr-0 pl-1 mt-1" id="home" data-home="{{route('home')}}">

	<h4 class="alert mb-0 bg-black text-light">
		<span class="col-md-4" id="title">Entrada</span>
		<span class="col-md-5 ">
			<a href="#" class="float-right btn btn-sm btn-secondary text-light mb-1" id="btn-output">Registro de Saída</a> 
			<a href="#" class="float-right btn btn-sm btn-secondary text-light mb-1" id="btn-input">Registro de Entrada</a>
		</span>
	</h4>
	<div class="card alert-secondary mt-0 card card-header" id="sidebar">
		<div id="inputPark">
			<form action="" method="post" id="form-atendimento">
				<div class="row">
					<div class="col-md-6">
						<label for="code" class="mb-0">Código do Cliente</label>
						<input disabled="" type="text" value="00{{$parkOrder}}" class="form-control" id="code">
					</div>
					<div class="col-md-6">                    
						<label for="vacancy_id" class="mb-0">Número da Vaga</label>
						<input type="text" name="vacancy_id" class="form-control" id="vacancy_id">
						<span id="error" class="text-danger fade"><small>Vaga Indisponível</small></span>
					</div>
					<div class="col-md-6">
						<label for="monthly" class="mb-0 col-md-12 pl-0"><strong>Mensalista?</strong></label>
						<input id="yes" type="radio" name="monthly" value="yes" class="form-checkbox">
						<label for="yes" class="mb-0">Sim</label>
						<input type="radio" name="monthly" id="no" value="no" checked="">
						<label class="mb-0 pb-0" for="no">Não</label>
					</div>
					<div class="col-md-6 div-cpf">
						<label for="cpf" class="mb-0">CPF</label>
						<input type="text" name="cpf" id="cpf" class="form-control" disabled="">
					</div>
					<div class="col-md-6 mb-1">
						<label for="model" class="mb-0">Modelo do Veículo</label>
						<input type="text" name="model" id="model" class="form-control">
					</div>
					<div class="col-md-6">
						<label for="board" class="mb-0">Placa</label>
						<input type="text" name="board" class="form-control" id="board">
					</div>
					<div class="col-md-12 ">
						<button data-addPark="{{route('addPark')}}" type="button" class="btn-sm mt-4 text-light btn bg-black " id="save">
							<span class="fas fa-save"></span>
							<span>Salvar</span> 
						</button>           
					</div>
				</div>
			</form>
		</div>
		<!-- // Register Of out -->
		<div id="outputPark">
			<form action="">
				<div class="row">
					<div class="col-md-6">
						<label class="mb-0" for="out-board">Placa</label>
						<input type="text" data-loadInput="{{url('loadOutput')}}" name="out-board" class="form-control" id="out-board">
						<span id="info" class="text-danger"><small>Nenhum registro encontrado</small></span>
					</div>
					<div class="col-md-6 pt-2">
						<button id="search" class="mt-3 mb-1 btn  btn-warning fas fa-search" type="button"></button>
					</div>
					<div class="col-md-6">
						<label class="mb-0" for="out-vacancy_id">N° Vaga</label>
						<input type="text" disabled="" name="out-vacancy_id" id="out-vacancy_id" class="form-control">
					</div>
					<div class="col-md-6">
						<label class="mb-0" for="totalPay" >Total</label>
						<input disabled="" type="text" name="totalPay" id="totalPay" class="text-danger form-control">
					</div>
					<div class="col-md-6">
						<label class="mb-0" for="out-model">Modelo</label>
						<input disabled="" type="text" name="out-model" class="form-control" id="out-model">
					</div>
					<div class="col-md-6">
						<label class="mb-0" for="permanency">Tempo de Permanência</label>
						<input disabled="" type="text" name="permanency" class="form-control" id="permanency">
					</div>
					<div class="col-md-6">
						<label class="mb-0" for="inputTime">Entrada</label>
						<input disabled="" type="text" name="inputTime" id="inputTime" class="form-control">
					</div>
					<div class="col-md-6">
						<label class="mb-0" for="outputTime">Saída</label>
						<input disabled="" type="text" name="outputTime" class="form-control" id="outputTime">
						<input type="hidden" name="id" id="id">
					</div>
					<div class="col-md-12 mt-3">
						<button disabled="" id="closeStay" type="button" class="btn btn-sm bg-black text-light">Fechar estada</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="col-md-8 pr-1 pl-1">
	<!-- Modal confirm-->
	<h4 class="alert mb-0 mt-1 bg-black text-light"> <span>Vagas disponíveis: <span class="badge badge-warning"> {{$vacancyFree}}</span></span> 
		<a class="btn-link float-right" id="btn-addVacancy"><small><span class="fas fa-cog text-warning"></span> Definições</small></a>
	</h4>
	<div class="mt-0 card alert-secondary">
		<div class="row card-body col-md-12 ml-1 mb-4">
			@foreach($vacancies as $v)
			<div class="col-md-2 text-center">
				<span class="badge badge-dark mb-1">{{$v->order}}</span>
				@if($v->status != "livre")
				<div class=" border border-dark text-center">
					<span id="vacancy{{$v->order}}" class="fas fa-car text-warning fa-3x" data-vFree="false"></span>
				</div>
				@else
				<div class=" border border-info text-center">
					<span id="vacancy{{$v->order}}" class="fas fa-car text-success fa-3x"  data-vFree="true"></span>
				</div>
				@endif
			</div>
			@endforeach
		</div>                
	</div>
</div>


<!-- Modal confirm -->
<div class="modal fade" id="confirm" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header bg-black text-light">
				<h5 class="modal-title text-center" id="title"><span class="fas fa-exclamation-triangle text-warning"></span> Fechar Estada</h5>
				<button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="alert alert-secondary">
					<strong>Vaga: </strong><span id="info-vacancy" class="badge badge-dark"></span><br>
					<strong>Modelo: </strong><span id="info-model" class="badge badge-dark" ></span><br>
					<strong>Permanência: </strong><span id="info-permanence" class="badge badge-dark"></span><br>
					<strong>Total a Pagar: </strong><span id="info-pay" class="badge badge-dark"></span>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancelar</button>
				<form id="formPrint" action="{{route('imprimir')}}" method="post">
					{{csrf_field()}}
					<input type="hidden" id="printBoard" name="id">
				<button type="submit" id="print" class="btn bg-black text-light btn-sm"><span class="fas fa-print"></span> Imprimir cupom Fiscal</button></form>
			</div>
		</div>
	</div>
</div>
<!-- Fim Modal -->

<!-- modal definitions -->
<div class="modal" tabindex="-1" id="addModal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header bg-black">
				<h4 class="text-center text-light"><span class="fas fa-cogs"></span> Definições</h4>
				<button class="close text-light" data-dismiss="modal" >&times</button>
			</div>
			<div class="modal-body ml-4">
				<div class="form-group row col-md-12">
					<div class="col-md-6">
						<h4 class="alert alert-secondary">Adicionar Vaga</h4>
						<div class="form-group">
							<span>
								<strong>Total de Vagas Atualmente: </strong>
								<span class="badge badge-dark">{{$order}}</span>
							</span>
							<br>
							<a class="btn btn-warning btn-sm mb-2 float-right" href="#" data-url="{{route('addVacancy')}}"><i class="fas fa-plus"></i><strong>Adicionar</strong>
								<form action="" method="post" id="formVacancy" data-home="{{route('home')}}">
									{{csrf_field()}}     
									<input type="hidden" id="order" name="order" value="{{$order}}">
								</form>
							</a>
						</div>
					</div>
					<div class="col-md-6">
						<h4 class="alert alert-secondary">Valor / Hora</h4>
						<form action="{{url('priceForHour')}}" method="post" id="formPrice">
							{!!csrf_field()!!}
							<label for="price"><strong>Digite o valor cobrado por hora</strong></label>
							<input type="text" name="price" id="price" class="form-control" value="{{$price}}">
							<div class="form-group mt-2 float-right">
								<button type="submit"  id="savePrice" class="btn bg-black text-light btn-sm"><span class="fas fa-save"></span> Salvar</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

