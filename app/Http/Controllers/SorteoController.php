<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\sorteo;
use App\cartones;
use App\Http\Controllers\CartonController;
class SorteoController extends Controller
{

    public function create(Request $request)
    {
        return view("admin.create");
    }

    public function play($id)
    {
        header("Location: http://localhost:8888/bingo?sorteo=".$id);
        exit();
    }

    public function PlayGame(Request $request)
    {
        //set_time_limit(300);
        $numeros = [];
        $GenerarCartones = new CartonController();
        for ($i=0; $i < 90; $i++) { 
            array_push($numeros,strval($i+1));
        }
        shuffle($numeros);
        $dividirNumeros = array_chunk($numeros, 9);
        $numeros_sorteados = [];
        
        foreach ($dividirNumeros as $key => $value) {
            ksort($dividirNumeros[$key]);
        }

        foreach ($dividirNumeros as $dividirNumerosChunl ) {
            foreach ($dividirNumerosChunl as $dividirNumerosSingle) {
                $numeros_sorteados[] = $dividirNumerosSingle;
            } 
        }      

        /*Nuevo sorteo */
        $sorteo = new sorteo();
        $sorteo->codigo = time();
        $sorteo->status = "success";
        $sorteo->numeros_sorteados = json_encode($numeros_sorteados);
        $sorteo->save();
        /*Fin Nuevo sorteo */


        /*Generar Cartones*/
        for ($i=0; $i < (int)$request->nCartones; $i++) { 
            /*Genera el carton*/
            $carton_completo = $GenerarCartones::GenerarCarton($request,90,5);
            $carton_divido = array_chunk($carton_completo,9);
            if($this->checkCarton(json_encode($carton_completo),$sorteo->numeros_sorteados) > 52){
                /*Guarda en la Base de datos*/
                $carton = new cartones();
                $carton->codigo = $i+1;
                $carton->numeros = json_encode($carton_completo);
                $carton->linea_1 = json_encode($carton_divido[0]);
                $carton->linea_2 = json_encode($carton_divido[1]);
                $carton->linea_3 = json_encode($carton_divido[2]);
                $carton->sorteo_id = $sorteo->id;
                $carton->tipo = 'normal';
                $carton->save();
            }
        }
        /*Fin Generar Cartones */
            $count = $carton->codigo;
            $count++;
        
        /*Generar Series Cartones*/
            // for ($i=0; $i < 20; $i++) { 
            //     /*Genera el cartones de la serie*/
            //     $GenerarCartones = new CartonController();
            //     $serie_generadas = $GenerarCartones::GenerarSerie($sorteo->id);
            //     while ($serie_generadas == 101) {
            //         $serie_generadas = $GenerarCartones::GenerarSerie($sorteo->id);
            //     }
            //     foreach ($serie_generadas as $serie ) {
            //         /*Guarda en la Base de datos*/
            //         $carton_divido = array_chunk($serie,9);
            //         $carton = new cartones();
            //         $carton->codigo = $count;
            //         $carton->numeros = json_encode($serie);
            //         $carton->linea_1 = json_encode($carton_divido[0]);
            //         $carton->linea_2 = json_encode($carton_divido[1]);
            //         $carton->linea_3 = json_encode($carton_divido[2]);  
            //         $carton->sorteo_id = $sorteo->id;
            //         $carton->tipo = 'serie';
            //         $carton->numero_serie = $i;
            //         $carton->save();
            //         $count++;
            //     }
            // }
        /*Generar Series Cartones*/
        
        header("Location: http://localhost:8888/bingo?sorteo=".$sorteo->id);
        exit();
        //return ["status" => 'success', "msg" => "!Play Game¡" , "numeros" => $request->numeros , "sorte_id" => $sorteo->id];
    }

    public function ViewCartones($id)
    {

        $sorteo = sorteo::find($id);
        $cartones = $sorteo->cartones;
        return view("game.cartones")->with("cartones",$cartones);
    }

    public function ViewSeries($id)
    {

        $sorteo = sorteo::find($id);
        $cartones = $sorteo->series;
        return view("game.series")->with("cartones",$cartones);
    }

    

    public function CleanArray($carton_array)
    {
        $sorteo = sorteo::find(9);
        return $carton_array;
    }

    public function checkLinea($carton)
    {
        $sorteo = sorteo::find(15);
        $cartones = cartones::find($carton);

        return $carton_array;
    }

    public function checkCarton($carton_parametro,$numeros_sorteados_parametro)
    {
        
        //$cartones = cartones::find($carton);
        //$sorteo = sorteo::find($carton->sorteo_id);

        $numeros_sorteados = json_decode($numeros_sorteados_parametro);
        $cartonesSmulados = [];

        $contadorNumeros = 0;
        $carton_array = array_unique(json_decode($carton_parametro));
        //$carton_array = $this->CleanArray($carton_array);
        for ($i=0; $i < count($numeros_sorteados); $i++) { 
            if (in_array($numeros_sorteados[$i], $carton_array)) {
                $contadorNumeros++;
                if($contadorNumeros == 15) break;
            } 
        }
            
        return $i-$contadorNumeros;
    }

    
    public function searchSorteo(Request $request)
    {
        $sorteo = sorteo::find($request->sorteo);
        $numeros_no_sorteados = [];
        $arrayNumerosSorteados = json_decode($sorteo->numeros_sorteados);
        $arrayNumerosJugados = json_decode($sorteo->numeros_jugados);

        if(is_null(json_decode($sorteo->numeros_jugados))){
            $sorteo->numeros_jugados = "[]";
        }

        if(!is_null($arrayNumerosJugados)){
            foreach ($arrayNumerosSorteados as $NumerosSorteado ) {
                if (!in_array($NumerosSorteado, $arrayNumerosJugados)) {
                    $numeros_no_sorteados[] = $NumerosSorteado;
                } 
            }
        }

        return [ 'numeros_sorteados' => json_decode($sorteo->numeros_sorteados) , 'numeros_jugados' => json_decode($sorteo->numeros_jugados) , 'numeros_no_sorteados' => $numeros_no_sorteados ];
    }

    public function NumerosJugado(Request $request)
    {
        $sorteo = sorteo::find($request->sorteo);

        if(is_null(json_decode($sorteo->numeros_jugados))){
            $sorteo->numeros_jugados = "[]";
        }

        $arrayNumerosJugados = json_decode($sorteo->numeros_jugados);
        array_push($arrayNumerosJugados, $request->numeros);
        $sorteo->numeros_jugados = json_encode($arrayNumerosJugados);
        $sorteo->save();
        return 1;
    }

    public function InicializarNumerosJugados(Request $request)
    {
        $sorteo = sorteo::find($request->sorteo);
        $sorteo->numeros_jugados = null;
        $sorteo->save();
        return 1;
    }

    


    public function SimulateGame(Request $request)
    {
        /*CHECK CARTON FULL */
        $sorteo = sorteo::find($request->sorteo);
        $cartones = $sorteo->series;
        $numeros_sorteados = json_decode($sorteo->numeros_sorteados);
        $cartonesSmulados = [];
        
        /*
        foreach ($cartones as $carton ) {
            $contadorNumeros = 0;
            $carton_array = array_unique(json_decode($carton->numeros));
            $carton_array = $this->CleanArray($carton_array);
            for ($i=0; $i < count($numeros_sorteados); $i++) { 
                if (in_array($numeros_sorteados[$i], $carton_array)) {
                    $contadorNumeros++;
                    if($contadorNumeros == 15) break;
                } 
            }
            $cartonesSmulados['data']['serie'."$carton->numero_serie"][] = [
                "tipo" => $carton->tipo,
                "codigo" => $carton->numero_serie,
                "sorteo" => $i-$contadorNumeros
            ];
            
        }

        return $cartonesSmulados;*/

        /*CHECK LINEA*/



        foreach ($cartones as $carton ) {
            $linea_1 = array_unique(json_decode($carton->linea_1));
            $linea_2 = array_unique(json_decode($carton->linea_2));
            $linea_3 = array_unique(json_decode($carton->linea_3));
            $linea_1_contador = 0;
            $linea_2_contador = 0;
            $linea_3_contador = 0;

            foreach ($linea_1 as $key => $value) {
                if( 0 == $value){
                    unset($linea_1[$key]);
                }
            }

            foreach ($linea_2 as $key => $value) {
                if( 0 == $value){
                    unset($linea_2[$key]);
                }
            }

            foreach ($linea_3 as $key => $value) {
                if( 0 == $value){
                    unset($linea_3[$key]);
                }
            }

            for ($i=0; $i < count($numeros_sorteados); $i++) { 
                if (in_array($numeros_sorteados[$i], $linea_1)) {
                    for ($x=0; $x < count($linea_1); $x++) { 
                        foreach ($linea_1 as $key => $value) {
                            if($numeros_sorteados[$i] == $value){
                                unset($linea_1[$key]);
                            }
                        }
                    }
                    if(count($linea_1) == 0) break;
                } 
                $linea_1_contador++;
            

                if (in_array($numeros_sorteados[$i], $linea_2)) {
                    for ($x=0; $x < count($linea_2); $x++) { 
                        foreach ($linea_2 as $key => $value) {
                            if($numeros_sorteados[$i] == $value){
                                unset($linea_2[$key]);
                            }
                        }
                    }
                    if(count($linea_2) == 0) break;
                } 
                $linea_2_contador++;
            


                if (in_array($numeros_sorteados[$i], $linea_3)) {
                    for ($x=0; $x < count($linea_3); $x++) { 
                        foreach ($linea_3 as $key => $value) {
                            if($numeros_sorteados[$i] == $value){
                                unset($linea_3[$key]);
                            }
                        }
                    }
                    if(count($linea_3) == 0) break;
                } 
                $linea_3_contador++;
            }

            $cartonesSmulados[] = [
                "tipo" => $carton->tipo.' - '.$carton->numero_serie,
                "linea_1" => $linea_1_contador,
                "linea_2" => $linea_2_contador,
                "linea_3" => $linea_3_contador
            ];

            
        }
        return $cartonesSmulados;

    }

    public function sorteolist()
    {
        $sorteo = sorteo::paginate(10);
        return view('admin.sorteo.index')->with('data',$sorteo);
    }


    
}
