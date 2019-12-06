<style type="text/css" media="screen">
	.input-carton{
		border-radius: 20px;
		border-top-right-radius: 20px;
		border-bottom-right-radius: 20px;
	}	
</style>

<div class="input-group mb-3">
  <input   id="input_numero_carton" type="number" class="form-control input-carton" placeholder="Número de carton" aria-describedby="basic-addon2">
  <div class="input-group-append">
    <button id="numero_carton" class="btn btn-outline-secondary" type="button">Buscar</button>
  </div>
</div>
<div class="row" align="center">
	<div class="col-6">
		<button id="sound_linea" class="btn btn-success btn-block" type="button">VERIFICACION DE LINEA</button>
	</div>
	<div class="col-6">
		<button id="sound_bingo"  class="btn btn-warning btn-block" type="button">VERIFICACION DE BINGO</button>
	</div>
</div>
<h2 align="center">CARTON</h2>
<div class="container check-grid-container" id="container-carton">	
</div><br>
<div class="container" id="resultados">	
</div><br>

<div class="row" align="center">
	<div class="col-12">
		<button id="close_modal_check" class="btn btn-warning closeCheck" onclick="document.getElementById('id01').style.display='none'" type="button">Cerrar</button>
	</div>
</div><br>

