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
</head>
<style type="text/css" media="screen">
	.btn{
		font-weight: bold;
	

	}

	.input-carton{
		border-radius: 20px;
	}
    body{
      background-color: black; 
		background-image:url('{{asset('img/bg2.jpg')}}'); 
  		background-repeat: no-repeat; background-position:left top;
    }

    #bg{


		background-image:url('{{asset('img/bg.jpg')}}'); 
  		background-repeat: no-repeat; background-position:left top;
  	}



    .card{
		border-style: solid;
		border-width: 0.2rem;
		border-color: black;
		border-radius: 2rem;
		font-size: 30px;
    }

	.grid-container {
	  display: grid;
	  grid-gap: 10px;
	  padding: 10px;
	}

	.grid-item {
	  padding: 5px;
	  text-align: center;
	} 
	
	#resultados{
		display: grid;
		grid-template-columns: auto auto;
	}

	.check-grid-container {
		display: grid;
		grid-template-columns: auto auto auto auto auto auto auto auto auto;
		border-style: solid;
		border-width: 0.2rem;
		border-color: black;
	}

	/* Extra small devices (phones, 600px and down) */
	@media only screen and (max-width: 600px) {
		.grid-container {
		  grid-template-columns: auto auto auto auto;
		}
		#banner{height: 4rem;}
	}

	/* Small devices (portrait tablets and large phones, 600px and up) */
	@media only screen and (min-width: 600px) {
		.grid-container {
		  grid-template-columns: auto auto auto auto auto auto auto auto      ;
		}
		#banner{height: 4rem;}
	}

	/* Medium devices (landscape tablets, 768px and up) */
	@media only screen and (min-width: 768px) {
		.grid-container {
		  grid-template-columns: auto auto auto auto auto auto auto auto auto auto;
		}
		#banner{height: 7rem;}
	}
	
	/* Large devices (laptops/desktops, 992px and up) */
	@media only screen and (min-width: 992px) {
		.grid-container {
		  grid-template-columns: auto auto auto auto auto auto auto auto auto auto auto auto auto auto;
		}
		#banner{height: 7rem;}
	}

	/* Extra large devices (large laptops and desktops, 1200px and up) */
	@media only screen and (min-width: 1200px) {
		.grid-container {
		  grid-template-columns: auto auto auto auto auto auto auto auto auto auto auto auto auto auto;
		}
		#banner{height: 7rem;}
	}

	#numeros_sorteados{
		color: black;
		font-weight: bold;
		font-size: 80px;
		border-style: solid;
		border-width: 0.2rem;
		border-color: black;
		width: 120px;
		background-color: white;
		padding: 5px;
		border-radius: 20px;
	}
</style>
<body>
	<div class="">
		{{ csrf_field() }}
		<div class="row">
			<!--
			<div class="col-3">

			</div>-->
			<div class="col-12">
				<img id="banner" style="width: 100%;" src="{!! asset('img/banner-bingo.gif') !!}"> 
			</div>
			<!--
			<div class="col-3"  align="center" style="padding-top: 5px;">
				<h1 id="numeros_sorteados"> </h1>
			</div>-->
		</div>
		
	
		<div id="bg">
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
			
			<div class="container" align="center" style="padding: 0.5rem;">
			  <button type="button" id="inicializar" class="btn btn-primary">INICIALIZAR</button>
			  <button type="button" id="play" class="btn btn-black">JUGAR</button>
			  <!--<button type="button" id="stop" class="btn btn-danger">DETENER</button>-->
			  <!--<button type="button" class="btn btn-success">CARGAR JUEGO</button>-->
			  <!--<button type="button" class="btn btn-info">REINICIAR</button>-->
			  <!--<button type="button" class="btn btn-warning">CANCELAR JUEGO</button>-->
			  <button type="button" class="btn btn-warning" id="check_line" onclick="document.getElementById('id01').style.display='block'" class="w3-button w3-black">PAUSAR</button>
			  <button type="button" id="GenerateSeries" class="btn btn-success">SERIES</button>
			  <!--<button type="button" id="sonido" class="btn btn-success">TEST SONIDO</button>-->
			  <button type="button" id="GenerateCatones" class="btn btn-danger">CARTONES </button>  
			</div>
		</div>


	<div class="row">
		<div class="w3-container">
		  <div id="id01" class="w3-modal">
		    <div class="w3-modal-content">
		      <div class="w3-container">
		        <span onclick="document.getElementById('id01').style.display='none'" class="w3-button w3-display-topright">&times;</span>
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
