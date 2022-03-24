<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>B I N G O</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="img/logo1.ico"/>
    <!-- global styles-->
    <link  rel="stylesheet" href="{!! asset('admin/css/components.css') !!}"/>
    <link  rel="stylesheet" href="{!! asset('admin/css/custom.css') !!}"/>
    <link rel="stylesheet" href="{!! asset('css/w3.css') !!}">
    
    <!--End of the global styles-->
    <!-- end of page level styles -->
    <link rel="stylesheet"  href="{!! asset('admin/css/pages/widgets.css') !!}">
    <link rel="stylesheet" href="{!! asset('css/bingo.css') !!}">
</head>
<style type="text/css" media="screen">
    body{
		background-color: black; 
		background-image:url('{{asset('img/bg2.jpg')}}'); 
		background-repeat: no-repeat; background-position:left top;
    }

	#bg_bingo_win, #bg_linea_win{
  		width: 100%;
  		height: 100%;
	}


    #bg{
		background-image:url('{{asset('img/bg.jpg')}}'); 
  		background-repeat: no-repeat; background-position:left top;
  	}


</style>
<body>
	<div class="">
	{{ csrf_field() }}
	<div class="row">
		
		<div class="col-2">

		</div>
		<div class="col-8">
			<img id="banner" style="width: 100%;" src="{!! asset('img/banner-bingo.gif') !!}"> 
		</div>
		
		<div class="col-2"  align="center" style="padding-top: 5px;">
			<h1 id="numeros_sorteados"> </h1>
		</div>
	</div>

	<img src="{{asset('img/bingo-sin-fondo.gif')}}"  id="bg_bingo_win" >

	<img src="{{asset('img/linea-sin-fondo.gif')}}"  id="bg_linea_win" >

	
	<div id="bg" >
		<div class="grid-container">
	    	@for ($i = 1; $i < 91; $i++)
				<div class="grid-item number_box" style="padding: 0.5rem;">
					<div id="{{$i}}"  class=" card " style="background-color: white;">
						<div>
							<div style="font-size: 2rem;font-weight: bold" class="sales_number  text-center" id="orders_countup">{{$i}}</div>
						</div>
					</div>
				</div>
			@endfor
		</div>

		<!-- INCIO Inclusion de numeros en formato de audio -->
			@include('game.audio')
		<!-- FIN Inclusion de numeros en formato de audio -->
		

	</div>

		<div class="container" align="center" style="padding: 0.5rem;">
			@if(isset($numero_sorteo) && $numero_sorteo == 0)
				<!--<button type="button" id="inicializar" class="btn btn-primary">INICIALIZAR</button>-->
			@endif
			<button type="button" id="play" class="btn btn-black">JUGAR</button>
			<!--<button type="button" id="stop" class="btn btn-danger">DETENER</button>-->
			<!--<button type="button" class="btn btn-success">CARGAR JUEGO</button>-->
			<!--<button type="button" class="btn btn-info">REINICIAR</button>-->
			<!--<button type="button" class="btn btn-warning">CANCELAR JUEGO</button>-->
			<button type="button" class="btn btn-warning" id="check_line" onclick="document.getElementById('id01').style.display='block'" class="w3-button w3-black">PAUSAR</button>
			<button type="button" id="GenerateSeries" class="btn btn-success">SERIES</button>
			<!--<button type="button" id="sonido" class="btn btn-success">TEST SONIDO</button>-->
			<button type="button" id="GenerateCatones" class="btn btn-danger">CARTONES </button>
			<button type="button" id="administrador" class="btn btn-dark">ADMINISTRADOR </button> 
			<button type="button" id="backGame" class="btn ">REGRESAR </button>  
		</div>

	<div class="row">
		<div class="w3-container">
		  <div id="id01" class="w3-modal">
		    <div class="w3-modal-content">
		      <div class="w3-container">
		        <span onclick="document.getElementById('id01').style.display='none'"  class="w3-button w3-display-topright closeCheck">&times;</span>
		        <div class="container">
		        	<br><br>
			        @include('game.check_carton')
		        </div>
		      </div>
		    </div>
		  </div>
		</div>
	</div>

</body>
</html>

@include('call_js')
<script src="{!! asset('js/get_audio.js') !!}"></script>
@include('game.gameplayjs')
@include('game.checkcartonjs')
