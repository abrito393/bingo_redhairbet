<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Series - Sorteo #{{$cartones->first()->sorteo_id}}</title>
	<link rel="stylesheet" href="">
</head>
<style>
	table, th, td {
	  border: 1px solid black;
	  border-collapse: collapse;

	}
	th, td {
	  padding: 0.7rem;
	  text-align: left;
	  font-size: 1.5rem;
	}

	caption {
		color: #6c757d; 
		text-align: center; 
		caption-side: top; 
		border: 1px solid black;
		padding-top: 0; 
		padding-bottom: 0;
	}

	#numberBingo{
	    position: relative;
	    top: -2.6rem;
	    left: 8.3875rem;
	    font-weight: bold;
	}

	/* indicamos el salto de pagina */
		.saltoDePagina{
			height: 517px;
		}
	

	.grid-container {
	  display: grid;

	  grid-template-columns: auto auto;
	}

	.grid-item {
	  padding: 5px;
	  
	  text-align: center;
	} 
	body{
		margin: 0px;
		position: relative;
	}
</style>
<body>
	<div class="">
		<div class="grid-container" align="center">
			<?php $x = 0;$saltoLinea = 1;?>
			@foreach($cartones as $carton)
				<?php $cartonArray = json_decode($carton->numeros); ?>
				<div class="grid-item">
					<table>
						<caption align="center">
							<div >
								<div >
									<img style="width: 100%;height: 4rem;" src="{!! asset('img/carton-bingo.jpg') !!}"><span id="numberBingo">CARTON #{{$carton->codigo}}</span>
								</div>
							</div>
							
						</caption>
						<tr>
							@for ($i = 0; $i <= 8; $i++)
								
								@if($cartonArray[$i] == 0)
									<th align="center">
										<img src="{!! asset('img/iconfinder_hexagon-polygon-screw-block.png') !!}" alt="">
									</th>
								@else
									<th>{{$cartonArray[$i]}}</th>
								@endif
							@endfor
						</tr>

						<tr>
							@for ($i = 9; $i <= 17; $i++)
								@if($cartonArray[$i] == 0)
									<th align="center"><img src="{!! asset('img/iconfinder_hexagon-polygon-screw-block.png') !!}" alt=""></th>
								@else
									<th align="center">{{$cartonArray[$i]}}</th>
								@endif
							@endfor
						</tr>

						<tr>
							@for ($i = 18; $i <= 26; $i++)
								@if($cartonArray[$i] == 0)
									<th align="center"><img src="{!! asset('img/iconfinder_hexagon-polygon-screw-block.png') !!}" alt=""></th>
								@else
									<th align="center">{{$cartonArray[$i]}}</th>
								@endif
							@endfor
						</tr>
					</table>
				</div>
				<?php $x++;$saltoLinea++;?>

				@if($saltoLinea == 7)
					<div class="saltoDePagina"></div>
					<div class="saltoDePagina"></div>
					<?php $saltoLinea=1; ?>
				@endif
			@endforeach
		</div>
	</div>
</body>
</html>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" integrity="sha384-xrRywqdh3PHs8keKZN+8zzc5TX0GRTLCcmivcbNJWm2rs5C8PRhcEn3czEjhAO9o" crossorigin="anonymous"></script>