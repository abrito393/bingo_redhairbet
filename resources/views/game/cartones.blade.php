<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="{!! asset('css/cartones.css') !!}" />
	<title>Cartones</title>
</head>

<body>

	<div class="">
		<div class="grid-container" align="center">
			<?php $x = 0;$saltoLinea = 1;?>
			@foreach($cartones as $carton)
				<?php $cartonArray = json_decode($carton->numeros); ?>
				<div class="grid-item" >
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

				@if($saltoLinea == 9)

				@endif
			@endforeach
		</div>
	</div>
</body>
</html>
