<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\cartones;
use App\sorteo;
use App\configuracion;
use App\Http\Controllers\CartonController;
class CartonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function GenerarCartones(Request $request)
    {
        if(isset($request->sorteo_id)){
            return $request->sorteo_id;
        }
        return "false";
    }

    public function GenerateSeries(Request $request)
    {
        if(isset($request->sorteo_id)){
            return $request->sorteo_id;
        }
        return "false";
    }


    
    public function bingo(Request $request)
    {
        $sorteo = 0;
        if(isset($request->sorteo)) $sorteo = $request->sorteo;
        return view("game.bingo")->with("numero_sorteo",$sorteo)->with('configuracion',configuracion::first());
    }

    public function searchCarton(Request $request)
    {
        $carton = cartones::where("sorteo_id",$request->sorteo_id)->where("codigo",$request->carton)->first();
        if(is_object($carton)) 
            return [
                "numeros_sorteados" => json_decode(sorteo::find($carton->sorteo_id)->numeros_jugados), 
                "carton" => json_decode($carton->numeros), 
                "linea_1" => json_decode($carton->linea_1),
                "linea_2" => json_decode($carton->linea_2),
                "linea_3" => json_decode($carton->linea_3),
            ];
        return "not_found";
    }
    

    public static  function GenerarCarton(Request $request, $maxValue = 90, $cantidad_cartones=5)
    {   

        $cartones = [];
        //Generando Espacios Libres
        if(!isset($request->cantidad_cartones)){
            $cantidad_cartones = 500;
        }else{
            $cantidad_cartones = $request->cantidad_cartones;
        }


        $numbers = [];
        $space_free = [];
        $star_num_space = 1;
        $end_num_space = 9;
        $index_space = 4;
        $carton=[];
        $cartonFinal = [];
        for ($i=0; $i < 3; $i++) { 
            while (count($space_free) < $index_space) {
                $random_space_free = rand($star_num_space,$end_num_space);
                if (!in_array($random_space_free, $space_free)) {
                    $space_free[]=$random_space_free;
                } 
            }
            $star_num_space += 9;
            $end_num_space += 9;
            $index_space += 4;
        }


        //Generando numeros aleatorios no repetidos
        $minValue = 1;
        $maxValue = 10;
        $maxNumberForColumn = 3;
        while (count($numbers) < 27) {
            $random_number = rand($minValue, $maxValue);
            if (!in_array($random_number, $numbers)) {               
               $numbers[] = $random_number;
            }

            if (count($numbers) >= $maxNumberForColumn) {             
                $minValue += 10;
                $maxValue += 10;
                $maxNumberForColumn += 3;
            }
        }
        
        $NumerosPorColumnas = array_chunk($numbers, 3);
        for ($i=0; $i < 3; $i++) { 
            $cartonFinal[] = $NumerosPorColumnas[0][$i];
            $cartonFinal[] = $NumerosPorColumnas[1][$i];
            $cartonFinal[] = $NumerosPorColumnas[2][$i];
            $cartonFinal[] = $NumerosPorColumnas[3][$i];
            $cartonFinal[] = $NumerosPorColumnas[4][$i];
            $cartonFinal[] = $NumerosPorColumnas[5][$i];
            $cartonFinal[] = $NumerosPorColumnas[6][$i];
            $cartonFinal[] = $NumerosPorColumnas[7][$i];
            $cartonFinal[] = $NumerosPorColumnas[8][$i];
        }

        foreach ($space_free as $space_free_single ) {
            $cartonFinal[$space_free_single-1] = 0;
        }

        return $cartonFinal ;
        return view("game.cartones")->with("cartones",$cartones);
    }

    public static  function getRow($numero)
    {

        if($numero == 0){return 1;}
        if($numero == 1){return 1;}
        if($numero == 2){return 1;}
        if($numero == 3){return 1;}
        if($numero == 4){return 1;}
        if($numero == 5){return 1;}
        if($numero == 6){return 1;}
        if($numero == 7){return 1;}
        if($numero == 8){return 1;}

        if($numero == 9){return 2;}
        if($numero == 10){return 2;}
        if($numero == 11){return 2;}
        if($numero == 12){return 2;}
        if($numero == 13){return 2;}
        if($numero == 14){return 2;}
        if($numero == 15){return 2;}
        if($numero == 16){return 2;}
        if($numero == 17){return 2;}

        if($numero == 18){return 3;}
        if($numero == 19){return 3;}
        if($numero == 20){return 3;}
        if($numero == 21){return 3;}
        if($numero == 22){return 3;}
        if($numero == 23){return 3;}
        if($numero == 24){return 3;}
        if($numero == 25){return 3;}
        if($numero == 26){return 3;}
        if($numero == 27){return 3;}
    }

    public static  function getColumn($numero)
    {
        if($numero == 1){return 1;}
        if($numero == 2){return 2;}
        if($numero == 3){return 3;}
        if($numero == 4){return 4;}
        if($numero == 5){return 5;}
        if($numero == 6){return 6;}
        if($numero == 7){return 7;}
        if($numero == 8){return 8;}
        if($numero == 9){return 9;}

        if($numero == 10){return 1;}
        if($numero == 11){return 2;}
        if($numero == 12){return 3;}
        if($numero == 13){return 4;}
        if($numero == 14){return 5;}
        if($numero == 15){return 6;}
        if($numero == 16){return 7;}
        if($numero == 17){return 8;}
        if($numero == 18){return 9;}

        if($numero == 19){return 1;}
        if($numero == 20){return 2;}
        if($numero == 21){return 3;}
        if($numero == 22){return 4;}
        if($numero == 23){return 5;}
        if($numero == 24){return 6;}
        if($numero == 25){return 7;}
        if($numero == 26){return 8;}
        if($numero == 27){return 9;}
    }


    public static function sortCarton($carton)
    {
        $cartonFinal = [];
        $NumerosPorColumnas = array_chunk($carton, 3);
        for ($i=0; $i < 3; $i++) { 
            if(isset($NumerosPorColumnas[0][$i])) {$cartonFinal[] = $NumerosPorColumnas[0][$i];}
            if(isset($NumerosPorColumnas[1][$i])) {$cartonFinal[] = $NumerosPorColumnas[1][$i];}
            if(isset($NumerosPorColumnas[2][$i])) {$cartonFinal[] = $NumerosPorColumnas[2][$i];}
            if(isset($NumerosPorColumnas[3][$i])) {$cartonFinal[] = $NumerosPorColumnas[3][$i];}
            if(isset($NumerosPorColumnas[4][$i])) {$cartonFinal[] = $NumerosPorColumnas[4][$i];}
            if(isset($NumerosPorColumnas[5][$i])) {$cartonFinal[] = $NumerosPorColumnas[5][$i];}
            if(isset($NumerosPorColumnas[6][$i])) {$cartonFinal[] = $NumerosPorColumnas[6][$i];}
            if(isset($NumerosPorColumnas[7][$i])) {$cartonFinal[] = $NumerosPorColumnas[7][$i];}
            if(isset($NumerosPorColumnas[8][$i])) {$cartonFinal[] = $NumerosPorColumnas[8][$i];}


            if(!isset($NumerosPorColumnas[0][$i])) {$cartonFinal[] = 0;}
            if(!isset($NumerosPorColumnas[1][$i])) {$cartonFinal[] = 0;}
            if(!isset($NumerosPorColumnas[2][$i])) {$cartonFinal[] = 0;}
            if(!isset($NumerosPorColumnas[3][$i])) {$cartonFinal[] = 0;}
            if(!isset($NumerosPorColumnas[4][$i])) {$cartonFinal[] = 0;}
            if(!isset($NumerosPorColumnas[5][$i])) {$cartonFinal[] = 0;}
            if(!isset($NumerosPorColumnas[6][$i])) {$cartonFinal[] = 0;}
            if(!isset($NumerosPorColumnas[7][$i])) {$cartonFinal[] = 0;}
            if(!isset($NumerosPorColumnas[8][$i])) {$cartonFinal[] = 0;}
        }
        return $cartonFinal;
    }

    public static function getRangeRandon($array)
    {
        foreach ($array as $key => $value) {

                $num1 = 1;$num2 = 10;$num3 = 19;
                if($key == 'columna0'){
                    $numeros = [$num1,$num2,$num3];
                    return $numeros;
                    break;
                }

                if($key == 'columna1'){
                    $numeros = [$num1+1,$num2+1,$num3+1];
                    return $numeros;
                    break;
                }

                if($key == 'columna2'){
                    $numeros = [$num1+2,$num2+2,$num3+2];
                    return $numeros;
                    break;
                }

                if($key == 'columna3'){
                    $numeros = [$num1+3,$num2+3,$num3+3];
                    return $numeros;
                    break;
                }

                if($key == 'columna4'){
                    $numeros = [$num1+4,$num2+4,$num3+4];
                    return $numeros;
                    break;
                }

                if($key == 'columna5'){
                    $numeros = [$num1+5,$num2+5,$num3+5];
                    return $numeros;
                    break;
                }

                if($key == 'columna6'){
                    $numeros = [$num1+6,$num2+6,$num3+6];
                    return $numeros;
                    break;
                }

                if($key == 'columna7'){
                    $numeros = [$num1+7,$num2+7,$num3+7];
                    return $numeros;
                    break;
                }

                if($key == 'columna8'){
                    $numeros = [$num1+8,$num2+8,$num3+8];
                    return $numeros;
                    break;
                }  


        }

        return false;
    }

    public static function checkColumnRow($carton)
    {
        $CartonController = new CartonController();
        $lineasPorCarton = array_chunk($carton, 9);
        $columna0=0;$columna1=0;$columna2=0;$columna3=0;$columna4=0;$columna5=0;
        $columna6=0;$columna7=0;$columna8=0;$total=0;

        $dataRow = [];
        $dataColumn = [];
        foreach ($lineasPorCarton as $linea ) {
            $dataRow[] = $CartonController::CountElementArray($linea);
        }

        foreach ($carton as $key => $value) {
            $lineaCarton = $key;
            if($key > 8) $lineaCarton = $key - 9;
            if($key > 17) $lineaCarton = $key - 18;

            if($value == 0){
                ${"columna$lineaCarton"}++;
            }
        }
        $dataColumn = [
            'columna0' => $columna0,
            'columna1' => $columna1,
            'columna2' => $columna2,
            'columna3' => $columna3,    
            'columna4' => $columna4,
            'columna5' => $columna5,
            'columna6' => $columna6,
            'columna7' => $columna7,
            'columna8' => $columna8
        ];

        return ['columnas' => $dataColumn , 'filas' => $dataRow];
    }  

    public static function getColumnNumero($numero){
        if ($numero >= 1 && $numero <= 10) return 0;
        if ($numero >= 11 && $numero <= 20) return 1;
        if ($numero >= 21 && $numero <= 30) return 2;
        if ($numero >= 31 && $numero <= 40) return 3;
        if ($numero >= 41 && $numero <= 50) return 4;
        if ($numero >= 51 && $numero <= 60) return 5;
        if ($numero >= 61 && $numero <= 70) return 6;
        if ($numero >= 71 && $numero <= 80) return 7;
        if ($numero >= 81 && $numero <= 90) return 8;
    }

    public static  function CartonSerie()
    {   
        $fin = true;
        while($fin){
            $cartones = [];
            $numbers = [];
            $maxValue = 90;
            $CartonController = new CartonController();

            $columna0=([1,2,3,4,5,6,7,8,9,10]);
            $columna1=([11,12,13,14,15,16,17,18,19,20]);
            $columna2=([21,22,23,24,25,26,27,28,29,30]);
            $columna3=([31,32,33,34,35,36,37,38,39,40]);
            $columna4=([41,42,43,44,45,46,47,48,49,50]);
            $columna5=([51,52,53,54,55,56,57,58,59,60]);
            $columna6=([61,62,63,64,65,66,67,68,69,70]);
            $columna7=([71,72,73,74,75,76,77,78,79,80]);
            $columna8=([81,82,83,84,85,86,87,88,89,90]);
            shuffle($columna0);shuffle($columna1);shuffle($columna3);shuffle($columna4);
            shuffle($columna5);shuffle($columna6);shuffle($columna7);shuffle($columna8);
            shuffle($columna2);

            for ($numeroCarton=0; $numeroCarton < 6; $numeroCarton++) { 
                $cartonSort = [];
                $numbersCarton = [];

                for ($i=0; $i < 3; $i++) { 

                    for ($indexCarton=0; $indexCarton < 9; $indexCarton++){
                        $arrayColumnas["columna$indexCarton"] = ${"columna$indexCarton"};
                    }

                    if($numeroCarton > 3){
                        asort($arrayColumnas);

                        $index = 0;$columna = [];
                        foreach ($arrayColumnas as $key => $value) {
                            $numero_columna = (int)str_replace('columna', '', $key);
                            if(count($columna) < 4){
                                $columna[] = $numero_columna;
                            }
                        }
                        //dd($cartones);
                    }else{
                        $columna = [0,1,2,3,4,5,6,7,8];
                        shuffle($columna);shuffle($columna);
                        for ($z=0; $z < 5; $z++) { 
                            unset($columna[$z]);
                            $columna = array_values($columna);
                        } 
                        
                    }
                      
                    for ($indexCarton=0; $indexCarton < 9; $indexCarton++) { 

                        $flag_position = 0;
                        foreach ($columna as $value) {
                            if($indexCarton == $value){
                                $flag_position = 1;  
                            }
                        }

                        if($flag_position == 1){
                            $cartonSort[] =  0;
                        }else{
                            if(isset(${"columna$indexCarton"}[0])){
                                $cartonSort[] =  ${"columna$indexCarton"}[0];
                                unset(${"columna$indexCarton"}[0]);
                                ${"columna$indexCarton"} = array_values(${"columna$indexCarton"});  
                            }else{
                                $cartonSort[] =  0;
                            }
                        }

                    }
                }
                
                $cartones[] = $cartonSort;
                
            }
            $numerosFaltantes = [];

            for ($indexCarton=0; $indexCarton < 9; $indexCarton++){
                foreach (${"columna$indexCarton"} as $value) {
                    $numerosFaltantes[] = $value;
                }
            }

            if(count($numerosFaltantes) <= 0){
                $fin = false;
            }
        }
        return $cartones ;

    }

    public static function GenerarCartonesSerie()
    {
        $numbers = [];
        $space_free = [];
        $star_num_space = 1;
        $end_num_space = 10;
        $index_space = 4;
        $carton=[];
        $cartonFinal = [];
        $array_space_free = [];
        $numeros_desechados = [];
        $minValue = 1;
        $maxValue = 10;
        $CartonController = new CartonController();
        for ($x=0; $x < 9; $x++) {
            while (count($space_free) < 8) {
                $random_space_free = rand($minValue,$maxValue);
                if (!in_array($random_space_free, $space_free)) {
                    $space_free[]=$random_space_free;
                } 
            }


            while (count($numbers) < 10) {
                $random_number = rand($minValue, $maxValue);
                if (!in_array($random_number, $numbers)) {               
                   $numbers[] = $random_number;
                }
            }

            foreach ($space_free as $key => $value) {
                $posicion = array_keys($numbers, $value)[0];
                $aux = $numbers[$posicion] ;
                $numbers[$posicion] = 0;
                array_push($numbers, $aux);
            }
            shuffle($numbers);
            $array_numbers[]= $numbers;

            /*
            while (count($numbers) < 27) {
                $random_number = rand($minValue, $maxValue);
                if (!in_array($random_number, $numbers)) {               
                   $numbers[] = $random_number;
                }
            }*/

            $minValue += 10;
            $maxValue += 10;
            $space_free = [];
            $numbers = [];
        }

        $minValue = 1;
        $maxValue = 10;


        $carton1=[];$carton2=[];$carton3=[];
        $carton4=[];$carton5=[];$carton6=[];
        $posicion_fila1 = 1;
        $posicion_fila2 = 10;
        $posicion_fila3 = 19;



        foreach ($array_numbers as $linea) {
            $lineaPorCarton = array_chunk($linea, 3);
            $carton1[$posicion_fila1] = $lineaPorCarton[0][0];
            $carton1[$posicion_fila2] = $lineaPorCarton[0][1];
            $carton1[$posicion_fila3] = $lineaPorCarton[0][2];

            $carton2[$posicion_fila1] = $lineaPorCarton[1][0];
            $carton2[$posicion_fila2] = $lineaPorCarton[1][1];
            $carton2[$posicion_fila3] = $lineaPorCarton[1][2];

            $carton3[$posicion_fila1] = $lineaPorCarton[2][0];
            $carton3[$posicion_fila2] = $lineaPorCarton[2][1];
            $carton3[$posicion_fila3] = $lineaPorCarton[2][2];

            $carton4[$posicion_fila1] = $lineaPorCarton[3][0];
            $carton4[$posicion_fila2] = $lineaPorCarton[3][1];
            $carton4[$posicion_fila3] = $lineaPorCarton[3][2];

            $carton5[$posicion_fila1] = $lineaPorCarton[4][0];
            $carton5[$posicion_fila2] = $lineaPorCarton[4][1];
            $carton5[$posicion_fila3] = $lineaPorCarton[4][2];

            $carton6[$posicion_fila1] = $lineaPorCarton[5][0];
            $carton6[$posicion_fila2] = $lineaPorCarton[5][1];
            $carton6[$posicion_fila3] = $lineaPorCarton[5][2];

            $posicion_fila1++;$posicion_fila2++;$posicion_fila3++;

              
        }
        
        $carton1_final=[];$carton2_final=[];$carton3_final=[];
        $carton4_final=[];$carton5_final=[];$carton6_final=[];

        

        for ($i=1; $i < count($carton1)+1; $i++) {$carton1_final[] = $carton1[$i];}
        for ($i=1; $i < count($carton2)+1; $i++) {$carton2_final[] = $carton2[$i];}
        for ($i=1; $i < count($carton3)+1; $i++) {$carton3_final[] = $carton3[$i];}
        for ($i=1; $i < count($carton4)+1; $i++) {$carton4_final[] = $carton4[$i];}
        for ($i=1; $i < count($carton5)+1; $i++) {$carton5_final[] = $carton5[$i];}
        for ($i=1; $i < count($carton6)+1; $i++) {$carton6_final[] = $carton6[$i];}  


        $final = '_final';
        $flag = 'no';
        $log_elementosPorLinea = [];
        $Auxcarton1_final = $carton1_final;

        for ($numeroCarton=1; $numeroCarton < 7; $numeroCarton++) { 
            $posicionActual = 0;
            for ($lineaCarton=0; $lineaCarton < 3 ; $lineaCarton++) { 
                $lineaEstable = true;
                $lineasPorCarton = array_chunk(${"carton$numeroCarton$final"}, 9);
                $elementosPorLinea = $CartonController::CountElementArray($lineasPorCarton[$lineaCarton]); 
                for ($numeroCartonInterno=1; $numeroCartonInterno < 7; $numeroCartonInterno++) { 
                    for ($i=0; $i < 9; $i++) { 
                        $posicionBuscar = $i + ($lineaCarton * 9);
                        if($elementosPorLinea > 4){
                            
                                $lineasPorCartonInterno = array_chunk(${"carton$numeroCartonInterno$final"}, 9);
                                $elementosPorLineaInterno = $CartonController::CountElementArray($lineasPorCartonInterno[$lineaCarton]);
                                if($elementosPorLineaInterno > 4 && ${"carton$numeroCartonInterno$final"}[$posicionBuscar] != 0){
                                    $AuxEementoCartonBuscar = ${"carton$numeroCartonInterno$final"}[$posicionBuscar];
                                    $AuxEementoCartonActual = ${"carton$numeroCarton$final"}[$posicionBuscar];
                                    ${"carton$numeroCartonInterno$final"}[$posicionBuscar] = $AuxEementoCartonActual;
                                    ${"carton$numeroCarton$final"}[$posicionBuscar] =$AuxEementoCartonBuscar;
                                }
                           
                        }elseif ($elementosPorLinea < 4) {
                           
                                $lineasPorCartonInterno = array_chunk(${"carton$numeroCartonInterno$final"}, 9);
                                $elementosPorLineaInterno = $CartonController::CountElementArray($lineasPorCartonInterno[$lineaCarton]);
                                if($elementosPorLineaInterno > 4 && ${"carton$numeroCartonInterno$final"}[$posicionBuscar] == 0){
                                    $AuxEementoCartonBuscar = ${"carton$numeroCartonInterno$final"}[$posicionBuscar];
                                    $AuxEementoCartonActual = ${"carton$numeroCarton$final"}[$posicionBuscar];
                                    ${"carton$numeroCartonInterno$final"}[$posicionBuscar] = $AuxEementoCartonActual;
                                    ${"carton$numeroCarton$final"}[$posicionBuscar] =$AuxEementoCartonBuscar;
                                }
                          
                        }
                        $lineasPorCarton = array_chunk(${"carton$numeroCarton$final"}, 9);
                        $elementosPorLinea = $CartonController::CountElementArray($lineasPorCarton[$lineaCarton]);
                    }
                }
                $lineasPorCarton = array_chunk(${"carton$numeroCarton$final"}, 9);
                $elementosPorLinea = $CartonController::CountElementArray($lineasPorCarton[$lineaCarton]);
            }   
        }

        for ($numeroCarton=1; $numeroCarton < 7; $numeroCarton++) {
            $cartonVerificado = true;
            while ($cartonVerificado) {
                $lineasPorCarton = array_chunk(${"carton$numeroCarton$final"}, 9);
                for ($lineaCarton=0; $lineaCarton < 3 ; $lineaCarton++) { 
                    $lineaEstable = true;
                    $lineasPorCarton = array_chunk(${"carton$numeroCarton$final"}, 9);
                    $elementosPorLinea = $CartonController::CountElementArray($lineasPorCarton[$lineaCarton]);
                    if($elementosPorLinea != 4){
                        for ($numeroCartonInterno=1; $numeroCartonInterno < 7; $numeroCartonInterno++) { 
                            $lineasPorCartonInterno = array_chunk(${"carton$numeroCartonInterno$final"}, 9);
                            $check1Interno = $CartonController::CountElementArray($lineasPorCartonInterno[0]);
                            $check2Interno = $CartonController::CountElementArray($lineasPorCartonInterno[1]);
                            $check3Interno = $CartonController::CountElementArray($lineasPorCartonInterno[2]); 
                            if($check1Interno != 4 || $check2Interno != 4 || $check3Interno != 4){
                                for ($i=0; $i < 9; $i++) { 
                                    $posicionBuscar = $i + ($lineaCarton * 9);
                                    $lineasPorCartonInterno = array_chunk(${"carton$numeroCartonInterno$final"}, 9);
                                    $elementosPorLineaInterno = $CartonController::CountElementArray($lineasPorCartonInterno[$lineaCarton]);
                                    if($elementosPorLineaInterno > 4 && ${"carton$numeroCartonInterno$final"}[$posicionBuscar] == 0){
                                        $AuxEementoCartonBuscar = ${"carton$numeroCartonInterno$final"}[$posicionBuscar];
                                        $AuxEementoCartonActual = ${"carton$numeroCarton$final"}[$posicionBuscar];
                                        ${"carton$numeroCartonInterno$final"}[$posicionBuscar] = $AuxEementoCartonActual;
                                        ${"carton$numeroCarton$final"}[$posicionBuscar] =$AuxEementoCartonBuscar;
                                    }

                                    if($elementosPorLineaInterno < 4 && ${"carton$numeroCartonInterno$final"}[$posicionBuscar] != 0){
                                        $AuxEementoCartonBuscar = ${"carton$numeroCartonInterno$final"}[$posicionBuscar];
                                        $AuxEementoCartonActual = ${"carton$numeroCarton$final"}[$posicionBuscar];
                                        ${"carton$numeroCartonInterno$final"}[$posicionBuscar] = $AuxEementoCartonActual;
                                        ${"carton$numeroCarton$final"}[$posicionBuscar] =$AuxEementoCartonBuscar;
                                    }
                                    
                                }
                            }
                            $lineasPorCarton = array_chunk(${"carton$numeroCarton$final"}, 9);
                            $elementosPorLinea = $CartonController::CountElementArray($lineasPorCarton[$lineaCarton]);
                        }  
                    }
                }
                $cartonVerificado = false; 
            }
                
        }
        
        $salir = true;
        $carton_inicial = 1;
        $carton_final = 1;
        $numeroCarton=1;
        for ($h=0; $h < 3; $h++) { 

            while ($numeroCarton < 7) {
                $lineasPorCarton = array_chunk(${"carton$numeroCarton$final"}, 9);
                $check1 = $CartonController::CountElementArray($lineasPorCarton[0]);
                $check2 = $CartonController::CountElementArray($lineasPorCarton[1]);
                $check3 = $CartonController::CountElementArray($lineasPorCarton[2]);
                if($check1 != 4 || $check2 != 4 || $check3 != 4){ 
                    for ($lineaCarton = 0 ; $lineaCarton < 3 ; $lineaCarton++) {
                        $lineasPorCarton = array_chunk(${"carton$numeroCarton$final"}, 9);
                        if($CartonController::CountElementArray($lineasPorCarton[$lineaCarton]) > 4){
                            for ($z=0; $z < $CartonController::CountElementArray($lineasPorCarton[$lineaCarton])-4 ; $z++){
                                $lineasPorCarton = array_chunk(${"carton$numeroCarton$final"}, 9);
                                foreach ($lineasPorCarton[$lineaCarton] as $key => $value) {
                                    if($value == 0){
                                        $positionChange = $key + ($lineaCarton * 9); 
                                    }
                                }
                                for ($numeroCartonInterno=1; $numeroCartonInterno < 7; $numeroCartonInterno++) { 
                                    for ($lineaCartonInterno = 0 ; $lineaCartonInterno < 3 ; $lineaCartonInterno++) {  
                                        $lineasPorCartonInterno = array_chunk(${"carton$numeroCartonInterno$final"}, 9);
                      
                                        if($CartonController::CountElementArray($lineasPorCartonInterno[$lineaCartonInterno]) < 4 ){
                                            $posicionBuscar = $key + ($lineaCartonInterno * 9);
                                            if(${"carton$numeroCartonInterno$final"}[$posicionBuscar] != 0){
                                                $AuxEementoCartonBuscar = ${"carton$numeroCartonInterno$final"}[$posicionBuscar];
                                                $AuxEementoCartonActual = ${"carton$numeroCarton$final"}[$positionChange];
                                                ${"carton$numeroCartonInterno$final"}[$positionChange] = $AuxEementoCartonActual;
                                                ${"carton$numeroCarton$final"}[$posicionBuscar] =$AuxEementoCartonBuscar;
                                            }
                                        }
                                      
                                    }
                                }
                                

                                $lineasPorCarton = array_chunk(${"carton$numeroCarton$final"}, 9);
                                //dd($CartonController::CountElementArray($lineasPorCarton[$lineaCarton]));
                            }
                        }elseif ($CartonController::CountElementArray($lineasPorCarton[$lineaCarton]) < 4) {
                            for ($z=0; $z < 4 - $CartonController::CountElementArray($lineasPorCarton[$lineaCarton]) ; $z++){
                                $lineasPorCarton = array_chunk(${"carton$numeroCarton$final"}, 9);
                                foreach ($lineasPorCarton[$lineaCarton] as $key => $value) {
                                    if($value != 0){
                                        $positionChange = $key + ($lineaCarton * 9);  // 0
                                    }
                                }
                                for ($numeroCartonInterno=1; $numeroCartonInterno < 7; $numeroCartonInterno++) { 
                                    for ($lineaCartonInterno = 0 ; $lineaCartonInterno < 3 ; $lineaCartonInterno++) {  
                                        $lineasPorCartonInterno = array_chunk(${"carton$numeroCartonInterno$final"}, 9);
                      
                                        if($CartonController::CountElementArray($lineasPorCartonInterno[$lineaCartonInterno]) > 4 ){
                                            $posicionBuscar = $key + ($lineaCartonInterno * 9);
                                            if(${"carton$numeroCartonInterno$final"}[$posicionBuscar] == 0){
                                                 $AuxEementoCartonBuscar = ${"carton$numeroCartonInterno$final"}[$posicionBuscar]; 
                                                $AuxEementoCartonActual = ${"carton$numeroCarton$final"}[$positionChange];
                                                ${"carton$numeroCartonInterno$final"}[$positionChange] = $AuxEementoCartonActual;
                                                ${"carton$numeroCarton$final"}[$posicionBuscar] =$AuxEementoCartonBuscar;
                                            }
                                        }
                                      
                                    }
                                }
                                $lineasPorCarton = array_chunk(${"carton$numeroCarton$final"}, 9);
                            }
                        }
                    }
                    $lineasPorCarton = array_chunk(${"carton$numeroCarton$final"}, 9);
                    $check1 = $CartonController::CountElementArray($lineasPorCarton[0]);
                    $check2 = $CartonController::CountElementArray($lineasPorCarton[1]);
                    $check3 = $CartonController::CountElementArray($lineasPorCarton[2]);
                
                
                    $datax[] = [
                        'linea1' => $check1,
                        'linea2' => $check2,
                        'linea3' => $check3,
                        'carton' => $numeroCarton,
                        'numeros_carton' => json_encode(${"carton$numeroCarton$final"})
                    ];
                }

                $numeroCarton++;
                
            }
            $numeroCarton=1;
        }
        

        dd($datax);
        $data=[ 
            "carton1_final" => $carton1_final,
            "carton2_final" => $carton2_final,
            "carton3_final" => $carton3_final,
            "carton4_final" => $carton4_final,
            "carton5_final" => $carton5_final,
            "carton6_final" => $carton6_final

        ];


        return ($data);
    }

    public static function ChangeValueArray($linea , $carton, $posicion)
    {
        $AuxEementoLinea = $linea[$posicion];
        $AuxEementoCarton = $carton[$posicion];
        $carton[$posicion] = $AuxEementoLinea;
        $linea[$posicion] = $AuxEementoCarton;

        return [ "carton" => $carton, "linea" => $linea];
    }

    public static function CountElementArray($arreglo)
    {
        $count = 0;
        for ($i=0; $i < count($arreglo); $i++) { 
            if($arreglo[$i] == 0) $count++;
        }
        return $count;
    }


    public static function GenerarSerie($sorteo_id)
    {

        $CartonController = new CartonController();
        $salir = true;
        
        $sorteo = sorteo::find($sorteo_id);
        $resultados = [];
        while($salir){
            $FlagCompletoProceso = 1;
            $serieCompleta = $CartonController::CartonSerie();
            foreach ($serieCompleta as $cartonSerie ) {
                $resultadocarton = $CartonController::checkCarton(json_encode($cartonSerie),$sorteo->numeros_sorteados);
                if($resultadocarton < 53) {$FlagCompletoProceso = 0; break;}
                $resultados[] =  $resultadocarton;
            }
            if($FlagCompletoProceso == 1) $salir = false;
            
        }
        
        //dd($serieCompleta);
        /*
        $salir = true;
        $posicion_enrosque = 1;
        while($salir){

            $resultadocarton1 = $CartonController::checkCarton(json_encode($carton1_final),$sorteo->numeros_sorteados);

            if($resultadocarton1 < 53){
                $aux1 = $carton1_final[$posicion_enrosque-1];
                $aux2 = $carton2_final[$posicion_enrosque-1];
                $aux3 = $carton3_final[$posicion_enrosque-1];
                $aux4 = $carton4_final[$posicion_enrosque-1];
                $aux5 = $carton5_final[$posicion_enrosque-1];
                $aux6 = $carton6_final[$posicion_enrosque-1];

                $carton1_final[$posicion_enrosque-1] = $aux6;
                $carton2_final[$posicion_enrosque-1] = $aux1;
                $carton3_final[$posicion_enrosque-1] = $aux2;
                $carton4_final[$posicion_enrosque-1] = $aux3;
                $carton5_final[$posicion_enrosque-1] = $aux4;
                $carton6_final[$posicion_enrosque-1] = $aux5;

                $posicion_enrosque += 1;
 
            }

            $resultadocarton2 = $CartonController::checkCarton(json_encode($carton2_final),$sorteo->numeros_sorteados);
            if($resultadocarton2 < 53){
                $aux1 = $carton1_final[$posicion_enrosque-1];
                $aux2 = $carton2_final[$posicion_enrosque-1];
                $aux3 = $carton3_final[$posicion_enrosque-1];
                $aux4 = $carton4_final[$posicion_enrosque-1];
                $aux5 = $carton5_final[$posicion_enrosque-1];
                $aux6 = $carton6_final[$posicion_enrosque-1];

                $carton1_final[$posicion_enrosque-1] = $aux6;
                $carton2_final[$posicion_enrosque-1] = $aux1;
                $carton3_final[$posicion_enrosque-1] = $aux2;
                $carton4_final[$posicion_enrosque-1] = $aux3;
                $carton5_final[$posicion_enrosque-1] = $aux4;
                $carton6_final[$posicion_enrosque-1] = $aux5;

                $posicion_enrosque += 1;
  
            }


            $resultadocarton3 = $CartonController::checkCarton(json_encode($carton3_final),$sorteo->numeros_sorteados);
            if($resultadocarton3 < 53){
                $aux1 = $carton1_final[$posicion_enrosque-1];
                $aux2 = $carton2_final[$posicion_enrosque-1];
                $aux3 = $carton3_final[$posicion_enrosque-1];
                $aux4 = $carton4_final[$posicion_enrosque-1];
                $aux5 = $carton5_final[$posicion_enrosque-1];
                $aux6 = $carton6_final[$posicion_enrosque-1];

                $carton1_final[$posicion_enrosque-1] = $aux6;
                $carton2_final[$posicion_enrosque-1] = $aux1;
                $carton3_final[$posicion_enrosque-1] = $aux2;
                $carton4_final[$posicion_enrosque-1] = $aux3;
                $carton5_final[$posicion_enrosque-1] = $aux4;
                $carton6_final[$posicion_enrosque-1] = $aux5;

                $posicion_enrosque += 1;

 
            }
            $resultadocarton4 = $CartonController::checkCarton(json_encode($carton4_final),$sorteo->numeros_sorteados);
            if($resultadocarton4 < 53){
                $aux1 = $carton1_final[$posicion_enrosque-1];
                $aux2 = $carton2_final[$posicion_enrosque-1];
                $aux3 = $carton3_final[$posicion_enrosque-1];
                $aux4 = $carton4_final[$posicion_enrosque-1];
                $aux5 = $carton5_final[$posicion_enrosque-1];
                $aux6 = $carton6_final[$posicion_enrosque-1];

                $carton1_final[$posicion_enrosque-1] = $aux6;
                $carton2_final[$posicion_enrosque-1] = $aux1;
                $carton3_final[$posicion_enrosque-1] = $aux2;
                $carton4_final[$posicion_enrosque-1] = $aux3;
                $carton5_final[$posicion_enrosque-1] = $aux4;
                $carton6_final[$posicion_enrosque-1] = $aux5;

                $posicion_enrosque += 1; 
            }


            $resultadocarton5 = $CartonController::checkCarton(json_encode($carton5_final),$sorteo->numeros_sorteados);
            if($resultadocarton5 < 53){
                $aux1 = $carton1_final[$posicion_enrosque-1];
                $aux2 = $carton2_final[$posicion_enrosque-1];
                $aux3 = $carton3_final[$posicion_enrosque-1];
                $aux4 = $carton4_final[$posicion_enrosque-1];
                $aux5 = $carton5_final[$posicion_enrosque-1];
                $aux6 = $carton6_final[$posicion_enrosque-1];

                $carton1_final[$posicion_enrosque-1] = $aux6;
                $carton2_final[$posicion_enrosque-1] = $aux1;
                $carton3_final[$posicion_enrosque-1] = $aux2;
                $carton4_final[$posicion_enrosque-1] = $aux3;
                $carton5_final[$posicion_enrosque-1] = $aux4;
                $carton6_final[$posicion_enrosque-1] = $aux5;

                $posicion_enrosque += 1;

            }

 
            $resultadocarton6 = $CartonController::checkCarton(json_encode($carton6_final),$sorteo->numeros_sorteados);
            if($resultadocarton6 < 53){
                $aux1 = $carton1_final[$posicion_enrosque-1];
                $aux2 = $carton2_final[$posicion_enrosque-1];
                $aux3 = $carton3_final[$posicion_enrosque-1];
                $aux4 = $carton4_final[$posicion_enrosque-1];
                $aux5 = $carton5_final[$posicion_enrosque-1];
                $aux6 = $carton6_final[$posicion_enrosque-1];

                $carton1_final[$posicion_enrosque-1] = $aux6;
                $carton2_final[$posicion_enrosque-1] = $aux1;
                $carton3_final[$posicion_enrosque-1] = $aux2;
                $carton4_final[$posicion_enrosque-1] = $aux3;
                $carton5_final[$posicion_enrosque-1] = $aux4;
                $carton6_final[$posicion_enrosque-1] = $aux5;

                $posicion_enrosque += 1;

            }
            if($posicion_enrosque > 26){break;}
            $resultadocarton1 = $CartonController::checkCarton(json_encode($carton1_final),$sorteo->numeros_sorteados);
            $resultadocarton2 = $CartonController::checkCarton(json_encode($carton2_final),$sorteo->numeros_sorteados);
            $resultadocarton3 = $CartonController::checkCarton(json_encode($carton3_final),$sorteo->numeros_sorteados);
            $resultadocarton4 = $CartonController::checkCarton(json_encode($carton4_final),$sorteo->numeros_sorteados);
            $resultadocarton5 = $CartonController::checkCarton(json_encode($carton5_final),$sorteo->numeros_sorteados);
            $resultadocarton6 = $CartonController::checkCarton(json_encode($carton6_final),$sorteo->numeros_sorteados);

            if($resultadocarton1 >= 52 && $resultadocarton2 >= 52 && $resultadocarton3 >= 52 && $resultadocarton4 >= 52 && $resultadocarton5 >= 52 && $resultadocarton6 >= 52){
                $salir = false;
                //return 101;
            }
        }

        //return [$resultadocarton1,$resultadocarton2,$resultadocarton3,$resultadocarton4,$resultadocarton5,$resultadocarton6];

        $data[] = $carton1_final;$data[] = $carton2_final;
        $data[] = $carton3_final;$data[] = $carton4_final;
        $data[] = $carton5_final;$data[] = $carton6_final;*/

        return $serieCompleta;
    }


    public static function checkCarton($carton_parametro,$numeros_sorteados_parametro)
    {
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

    public function getPositionArray($value='')
    {
        # code...
    }
}
