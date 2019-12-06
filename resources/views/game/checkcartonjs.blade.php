<script type="text/javascript">
	$(document).ready(function(){
		var token = $( "input[name='_token']" ).val();
		@if(isset($numero_sorteo) && $numero_sorteo != 0)
			var sorteo_id = parseInt("{{$numero_sorteo}}");
		@else
			var sorteo_id = 0;
		@endif

		$("#input_numero_carton").keypress(function(e) {
		    //mayor compatibilidad entre navegadores.
		    var code = (e.keyCode ? e.keyCode : e.which);
		    if(code==13){
		        print_carton();
		    }
		});

		$("#numero_carton").click(function(){
			print_carton();
		});

		$(".closeCheck").click(function(){
			print_carton();
		});



		function print_carton() {
			if(sorteo_id == 0){
				alert('Debe Dar click en la opcion Inicializar');
				return 1;
			}

			if($("#input_numero_carton").val() == ""){
				alert('Debe Introducir un valor');
				return 1;
			}

			var urlx = "{{route('searchCarton')}}";
			$.ajax({
				url: urlx,
				type: 'post',
				headers: {'X-CSRF-TOKEN': token},
				datatype: 'json',
				data:{
					sorteo_id : sorteo_id,
					carton : $("#input_numero_carton").val()
				},
				success:function( respuesta ){
					$("#container-carton").empty();
					for (var i = 0; i < respuesta.carton.length; i++) {
						numero_actual = '<img src="{!! asset("img/iconfinder_hexagon-polygon-screw-block.png") !!}" alt="">'
						if(respuesta.carton[i] != 0){
							numero_actual = respuesta.carton[i];
						}

						$("#container-carton").append('<div class="grid-item number_box" style="padding: 0.5rem;" ><div id="check-carton'+respuesta.carton[i]+'"  class="card " style="background-color: white;"><div><div style="font-size: 1rem;font-weight: bold;padding: 0.5rem;" class="sales_number  text-center" id="orders_countup">'+numero_actual+'</div></div></div></div>')
					}

					carton_lleno = 0;linea_1 = 0;linea_2 = 0; linea_3 = 0;
					for (var i = 0; i < respuesta.numeros_sorteados.length; i++) {	
						console.log(respuesta.numeros_sorteados[i]);
						if(respuesta.carton.includes(parseInt(respuesta.numeros_sorteados[i]))){
							$("#check-carton"+respuesta.numeros_sorteados[i]).css({'background-color' : "#54c458"});
							carton_lleno++;
						} 

						if(respuesta.linea_1.includes(parseInt(respuesta.numeros_sorteados[i]))){
							$("#check-carton"+respuesta.numeros_sorteados[i]).css({'background-color' : "#54c458"});
							linea_1++;
						} 

						if(respuesta.linea_2.includes(parseInt(respuesta.numeros_sorteados[i]))){
							$("#check-carton"+respuesta.numeros_sorteados[i]).css({'background-color' : "#54c458"});

							linea_2++;
						} 

						if(respuesta.linea_3.includes(parseInt(respuesta.numeros_sorteados[i]))){
							$("#check-carton"+respuesta.numeros_sorteados[i]).css({'background-color' : "#54c458"});
							linea_3++;
						} 
						
					}	

					$("#resultados").empty();
					if(carton_lleno == 15){
						$("#resultados").append('<h2>Carton LLeno: <span style="color:green;font-weight: bold"><button type="button" class="btn btn-success sound_bingo_correcta">CORRECTA</button></span></h2>');

					}else{
						$("#resultados").append('<h2>Carton LLeno: <span style="color:red;font-weight: bold"><button type="button" class="btn btn-danger sound_bingo_incorrecto">INCORRECTO</button></span></h2>');
					}
					

					if(linea_1 == 5){
						$("#resultados").append('<h2>Linea uno: <span style="color:green;font-weight: bold"><button type="button" class="btn btn-success sound_linea_correcta">CORRECTA</button></span></h2>');
					}else{
						$("#resultados").append('<h2>Linea uno: <span style="color:red;font-weight: bold"><button type="button" class="btn btn-danger sound_linea_incorrecta">INCORRECTA</button></span></h2>');
					}

					if(linea_2 == 5){
						$("#resultados").append('<h2>Linea dos: <span style="color:green;font-weight: bold"><button type="button" class="btn btn-success sound_linea_correcta">CORRECTA</button></span></h2>');
					}else{
						$("#resultados").append('<h2>Linea dos: <span style="color:red;font-weight: bold"><button type="button" class="btn btn-danger sound_linea_incorrecta">INCORRECTA</button></span></h2>');
					}

					if(linea_3 == 5){
						$("#resultados").append('<h2>Linea tres: <span style="color:green;font-weight: bold"><button type="button" class="btn btn-success sound_linea_correcta">CORRECTA</button></span></h2>');
					}else{
						$("#resultados").append('<h2>Linea tres: <span style="color:red;font-weight: bold"><button type="button" class="btn btn-danger sound_linea_incorrecta">INCORRECTA</button></span></h2>');
					}


					$(".sound_bingo_correcta").click(function(){
						document.getElementById("carton_lleno").play();
						$("#play").hide();
						$("#banner").hide();
						$("#bg").hide();
						$("#bg_linea_win").hide();
						$("#backGame").show();
						$("#bg_bingo_win").show();
					});

					$(".sound_bingo_incorrecto").click(function(){
						document.getElementById("bingo_incorrecto").play();
						$("#play").show();
					});

					$(".sound_linea_incorrecta").click(function(){
						document.getElementById("linea_incorrecta").play();
						$("#play").show();
					});

					$(".sound_linea_correcta").click(function(){
						document.getElementById("carton_linea").play();
						$("#play").hide();
						$("#banner").hide();
						$("#bg").hide();
						$("#bg_bingo_win").hide();
						$("#backGame").show();
						$("#bg_linea_win").show();
					});


				}
			});
		}


	})
</script>