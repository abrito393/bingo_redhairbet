<script type="text/javascript">
	$(document).ready(function(){
		var numeros = [];
		var sorteo = new Array();
		var VarGame ;
		var token = $( "input[name='_token']" ).val();
		var numero_generado;
		var numero_actual = '0';

		@if(isset($numero_sorteo) && $numero_sorteo != 0)
			var sorteo_id = parseInt("{{$numero_sorteo}}");
			searchSorteo();
		@else
			var sorteo_id = 0;
			GenerarSorteo();
		@endif

		$("#numeros_sorteados").hide();
		var x = document.getElementById("myAudio");

		function inicializar_juego(argument) {
			
			var urlx = "{{route('PlayGame')}}";
			$.ajax({
				url: urlx,
				type: 'POST',
				headers: {'X-CSRF-TOKEN': token},
				datatype: 'json',
				data:{
					numeros : numeros
				},
				success:function( respuesta ){
					sorteo_id = respuesta.sorte_id;
					window.location.href = "/bingo?sorteo="+sorteo_id;
				}
			});
				
		}

	 	$("#play").click(function(){
			$("#play").hide();
		});

		$("#check_line").click(function(){
				$("#play").show();
		});

		$("#backGame").click(function(){
			$("#play").show();
		});

		$("#GenerateCatones").click(function(){
			if(sorteo_id == 0){
				alert('Debe Dar click en la opcion Inicializar');
				return 1;
			}
			var urlx = "{{route('GenerarCartones')}}";
			$.ajax({
				url: urlx,
				type: 'POST',
				headers: {'X-CSRF-TOKEN': token},
				datatype: 'json',
				data:{
					sorteo_id : sorteo_id
				},
				success:function( respuesta ){
					if(respuesta != 0){
						window.open("/ViewCartones/"+respuesta);
						return 1;
					}
					alert('Debe inicializar el juego');
				}
			});
		});

		$("#GenerateSeries").click(function(){
			if(sorteo_id == 0){
				alert('Debe Dar click en la opcion Inicializar');
				return 1;
			}
			var urlx = "{{route('GenerateSeries')}}";
			$.ajax({
				url: urlx,
				type: 'POST',
				headers: {'X-CSRF-TOKEN': token},
				datatype: 'json',
				data:{
					sorteo_id : sorteo_id
				},
				success:function( respuesta ){
					if(respuesta != 0){
						window.open("/ViewSeries/"+respuesta);
						return 1;
					}
					//alert('Debe inicializar el juego');
				}
			});
		});

		

		$("#sonido").click(function(){
			document.getElementById("intento_fallido").play();
			//document.getElementById("carton_lleno").play();
			//document.getElementById("carton_linea").play();
			/*
			var r = Math.floor(Math.random()*90) + 1;
			document.getElementById("audio_"+r).play();*/
		});

		$("#inicializar").click(function(){
			inicializar_juego();
		});

		$("#play").click(function(){
			//alert('Inicia el juego');
			
			PlayGame();
			//GenerarNumero();
		});


		$("#sound_linea").click(function(){
			document.getElementById("check_linea").play();
		});

		$("#sound_bingo").click(function(){
			document.getElementById("check_bingo").play();
		});

		$("#close_modal_check").click(function(){

		});

		$("#backGame").click(function(){
			$("#bg_linea_win").hide();
			$("#bg_bingo_win").hide();
			$("#backGame").hide();
			$("#banner").show();
			$("#bg").show();

			document.getElementById("carton_lleno").pause();
			document.getElementById("intento_fallido").pause();
			document.getElementById("carton_linea").pause();

			document.getElementById("carton_lleno").currentTime = 0;
			document.getElementById("intento_fallido").currentTime = 0;
			document.getElementById("carton_linea").currentTime = 0;
		});

		$("#stop").click(function(){
			StopGame();
			alert('Se detuvo el juego');
		});

		$("#check_line").click(function(){
			StopGame();
		});

		GenerarSorteo();
		function GenerarSorteo() {
			while(numeros.length < 90){
			    var r = Math.floor(Math.random()*90) + 1;
			    if(numeros.indexOf(r) === -1) numeros.push(r);
			}
		}

		function GetAudio(numero = 0) {
			if(numero == 0) return 0;
			document.getElementById("audio_"+numero).play();
		}

		function GenerarNumero() {
			if(sorteo.length < 90){
				$("#"+numero_actual).css("color", "black");
				$("#"+numero_actual).css("background-color", "#00ff6e");
		    	$("#"+parseInt(numeros[0])).css("background-color", "#ff0000");
		    	$("#"+parseInt(numeros[0])).css("color", "white");
		    	GetAudio(parseInt(numeros[0]));

		    	insertar_numero(numeros[0]);
		    	$("#numeros_sorteados").text(parseInt(numeros[0]));
		    	numero_actual = parseInt(numeros[0]);
		    	sorteo.push(parseInt(numeros[0]));
				numeros.shift();
				
			}
		}

		function RellenarTablero(numeros) {
			var lastNumber = 0;
			for (var i = 0; i < numeros.length; i++) {
				$("#"+numeros[i]).css("color", "black");
				$("#"+numeros[i]).css("background-color", "#00ff6e");
				lastNumber = numeros[i];
			}
			$("#numeros_sorteados").text(parseInt(lastNumber));
			$("#numeros_sorteados").show();
		}

		function insertar_numero(numero) {
			var urlx = "{{route('NumerosJugado')}}";
			$.ajax({
				url: urlx,
				type: 'POST',
				headers: {'X-CSRF-TOKEN': token},
				datatype: 'json',
				data:{
					numeros : numero,
					sorteo : sorteo_id
				},
				success:function( respuesta ){
				}
			});
		}

		function searchSorteo() {
			
			var urlx = "{{route('searchSorteo')}}";
			$.ajax({
				url: urlx,
				type: 'POST',
				headers: {'X-CSRF-TOKEN': token},
				datatype: 'json',
				data:{
					sorteo : sorteo_id
				},
				success:function( respuesta ){
					numeros = respuesta.numeros_sorteados;
					if(respuesta.numeros_jugados.length > 0){
						var dialogo = confirm("Desea Continuar con el Sorteo?");
						if (dialogo == true) {
							numeros = respuesta.numeros_no_sorteados;
							RellenarTablero(respuesta.numeros_jugados);
						} else {
							InicializarNumerosJugados();
							numeros = respuesta.numeros_sorteados;
						}
					}
					
				}
			});
		}

		function InicializarNumerosJugados() {
			var urlx = "{{route('InicializarNumerosJugados')}}";
			$.ajax({
				url: urlx,
				type: 'GET',
				headers: {'X-CSRF-TOKEN': token},
				datatype: 'json',
				data:{
					sorteo : sorteo_id
				},
				success:function( respuesta ){}
			});
		}

		
		function ConfirmacionBingo() {
		  var txt;
		  var r = confirm("Desea Continuar con el Sorteo?");
		  if (r == true) {
		    txt = "You pressed OK!";
		  } else {
		    txt = "You pressed Cancel!";
		  }

		}

		function PlayGame() {
			GenerarNumero();
			VarGame = setInterval(GenerarNumero, 9000);
			$("#numeros_sorteados").show();
			console.log('Star Game');
		}

		function StopGame() {
			clearInterval(VarGame);
			console.log('Stop Game');
		}
	})
</script>