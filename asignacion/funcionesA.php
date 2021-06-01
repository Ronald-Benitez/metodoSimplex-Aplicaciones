<?php
include "num_hungaro.php";
include "../header.php";

function imprimirTablaHungaro ($matriz,$matriz2){
    $html_hungaro = "<table class='table table-striped' border='1'><tbody>";
    for($i = 0; $i<count($matriz); $i++){
        $html_hungaro.= "<tr>";
        for($j = 0; $j<count($matriz[0]); $j++){
            if($matriz[$i][$j]->num==0){
                $html_hungaro .= "<td>".$matriz2[$i][$j]."</td>";
            }else{
                $html_hungaro .= "<td>-</td>";
            }     
        }
        $html_hungaro.= "</tr>";
    }
        
    return $html_hungaro."<tbody></table>";
}

function minimizar($matriz){
    $mayor=0;
    $tamanio = $_POST['num_variables'];

    for($i=0; $i < $tamanio; $i++){

        for($j = 0; $j < $tamanio; $j++){

            if($matriz[$i][$j]->num>$mayor){
                $mayor=$matriz[$i][$j]->num;
            }
        }
    }

    for($i=0;$i<$tamanio;$i++){

        for($j = 0; $j < $tamanio; $j++){
            $matriz[$i][$j]->num = $mayor-$matriz[$i][$j]->num;
        }
    }

    return $matriz;
}

$num_variables = $_POST['num_variables'];

$matriz = array();
$matriz2 = array();

for($i = 0; $i<$num_variables; $i++){
    $fila = array();
    for($j = 0; $j<$num_variables; $j++){
        array_push($fila, new num_hungaro($_POST['valor_hungaro'.$i.$j], false, false));
        $matriz2[$i][$j] =$_POST['valor_hungaro'.$i.$j];
    }
    array_push($matriz, $fila);
    
}

if($_POST['tipo']==2){
    $matriz= minimizar($matriz);
}

    //encontrar el menor de cada fila
    for($i = 0; $i<count($matriz); $i++){
        $menor = 10000;
        for($j = 0; $j<count($matriz[0]); $j++){
            if($menor > $matriz[$i][$j]->num && !$matriz[$i][$j]->linea)
                $menor = $matriz[$i][$j]->num;
        }
    //restarlo a toda la fila
        for($j = 0; $j<count($matriz[0]); $j++){
            if(!$matriz[$i][$j]->linea)
                $matriz[$i][$j]->num -= $menor;
        }
    }
    
$debug = 0;
$num_lineas = 0;
while($num_lineas != $num_variables){
$num_lineas = 0;
    //guardar las coordenadas de todos los 0s
    $coordenadas = array();
    for($i = 0; $i<count($matriz); $i++){
        for($j = 0; $j<count($matriz[0]); $j++){
            if($matriz[$i][$j]->num == 0 && !$matriz[$i][$j]->linea)
                    array_push($coordenadas, ($i.$j));
        }
    }   
        //buscar en cada coordenada cuantos 0s toca por fila y por columna
        $fila = array();
        $columna = array();
        
        for($i = 0; $i<count($coordenadas); $i++){
            $cont_filas = 0;
            $cont_columnas = 0;
            //para columnas
            for($j = 0; $j<count($matriz[0]); $j++){
                if(!$matriz[$coordenadas[$i][0]][$j]->linea && $matriz[$coordenadas[$i][0]][$j]->num == 0){
                    $cont_filas++;
                }
            }
            array_push($fila, $cont_filas);

            //para filas
            for($j = 0; $j<count($matriz); $j++){
                if(!$matriz[$j][$coordenadas[$i][1]]->linea && $matriz[$j][$coordenadas[$i][1]]->num == 0)
                    $cont_columnas++;
            }
            array_push($columna, $cont_columnas);
        }
        
        //Ordenar los arreglos 
        $n = count($fila) - 1;
        do {
            $swapped = false;
            for ($i = 0; $i < $n; ++$i) {
                if ($fila[$i] > $fila[$i + 1]) {
                    $t = $fila[$i];
                    $fila[$i] = $fila[$i + 1];
                    $fila[$i + 1] = $t;
                    
                    $t = $columna[$i];
                    $columna[$i] = $columna[$i + 1];
                    $columna[$i + 1] = $t;
                    
                    $t = $coordenadas[$i];
                    $coordenadas[$i] = $coordenadas[$i + 1];
                    $coordenadas[$i + 1] = $t;
                    $swapped = true;
                }
            }
        } while ($swapped);
        
        for($pos = 0; $pos < count($coordenadas); $pos++){
            $i = $pos;
             if(!$matriz[$coordenadas[$pos][0]][$coordenadas[$pos][1]]->linea){
                //vamos a hacer true la variable que indica que una línea pasó sobre un núm
                if($columna[$i] > $fila[$i])
                    for($i = 0; $i < count($matriz[0]); $i++){
                        $matriz[$i][$coordenadas[$pos][1]]->linea = true;
                    }
                else if($columna[$i] <= $fila[$i])
                    for($i = 0; $i < count($matriz); $i++)
                        $matriz[$coordenadas[$pos][0]][$i]->linea = true;
                $num_lineas++;
            }
        }        
    
//buscar intersecciones de línea
    for($i = 0; $i<count($matriz); $i++){
        for($j = 0; $j<count($matriz[0]); $j++){
            $izq = false;
            $der = false;
            $arr = false;
            $aba = false;
            
            if ($j-1 >= 0)
                $izq = true;
            if ($j+1 < count($matriz))
                $der = true;
            if ($i-1 >= 0)
                $arr = true;
            if ($i+1 < count($matriz[0]))
                $aba = true;
            
           if($izq && $aba){
                if($matriz[$i][$j-1]->linea && $matriz[$i+1][$j]->linea){
                    $validar_linea = true;
                    $validar_columna = true;
                    
                    for($k = 0; $k<count($matriz); $k++){
                        if(!$matriz[$k][$j]->linea){
                            $validar_columna = false;
                            break;
                        }
                    }
                    
                    for($k = 0; $k<count($matriz[0]); $k++){
                        if(!$matriz[$i][$k]->linea){
                            $validar_linea = false;
                            break;
                        }
                    }
                    
                    if($validar_columna && $validar_linea)
                        $matriz[$i][$j]->interseccion = true;
                }
            }
            else{
                if($der && $aba){
                    if($matriz[$i][$j+1]->linea && $matriz[$i+1][$j]->linea){
                        $validar_linea = true;
                        $validar_columna = true;

                        for($k = 0; $k<count($matriz); $k++){
                            if(!$matriz[$k][$j]->linea){
                                $validar_columna = false;
                                break;
                            }
                        }

                        for($k = 0; $k<count($matriz[0]); $k++){
                            if(!$matriz[$i][$k]->linea){
                                $validar_linea = false;
                                break;
                            }
                        }
                        
                        if($validar_columna && $validar_linea)
                            $matriz[$i][$j]->interseccion = true;
                    }
                }

                else{
                    if($izq && $arr){
                        if($matriz[$i][$j-1]->linea && $matriz[$i-1][$j]->linea){
                            $validar_linea = true;
                            $validar_columna = true;

                            for($k = 0; $k<count($matriz); $k++){
                                if(!$matriz[$k][$j]->linea){
                                    $validar_columna = false;
                                    break;
                                }
                            }

                            for($k = 0; $k<count($matriz[0]); $k++){
                                if(!$matriz[$i][$k]->linea){
                                    $validar_linea = false;
                                    break;
                                }
                            }

                            if($validar_columna && $validar_linea)
                                $matriz[$i][$j]->interseccion = true;
                        }
                    }
                    else{
                        if($der && $arr){
                           if($matriz[$i][$j+1]->linea && $matriz[$i-1][$j]->linea){
                                $validar_linea = true;
                                $validar_columna = true;

                                for($k = 0; $k<count($matriz); $k++){
                                    if(!$matriz[$k][$j]->linea){
                                        $validar_columna = false;
                                        break;
                                    }
                                }

                                for($k = 0; $k<count($matriz[0]); $k++){
                                    if(!$matriz[$i][$k]->linea){
                                        $validar_linea = false;
                                        break;
                                    }
                                }

                                if($validar_columna && $validar_linea)
                                    $matriz[$i][$j]->interseccion = true;
                            }
                        }
                    }
                }
            }
        }
    }

//buscar el menor número de aquellos que no han sido tocados por una línea
    $menor = 100000;
    for($i = 0; $i<count($matriz); $i++){
        for($j = 0; $j<count($matriz[0]); $j++){
            if(!$matriz[$i][$j]->linea){
                if($menor > $matriz[$i][$j]->num){
                    $menor = $matriz[$i][$j]->num;
                }
            }
        }
    }
    
    //restar el valor menor a aquellos que no han sido tocados por una línea
    for($i = 0; $i<count($matriz); $i++){
        for($j = 0; $j<count($matriz[0]); $j++){
            if(!$matriz[$i][$j]->linea){
                $matriz[$i][$j]->num -= $menor;
            }
        }
    }
    
    //sumar el menor en las intersecciones 
    for($i = 0; $i<count($matriz); $i++){
        for($j = 0; $j<count($matriz[0]); $j++){
            if($matriz[$i][$j]->interseccion)
                $matriz[$i][$j]->num += $menor;
        }
    }
   
    //borrar lineas e intersecciones
    for($i = 0; $i<count($matriz); $i++){
        for($j = 0; $j<count($matriz[0]); $j++){
            $matriz[$i][$j]->interseccion = false;
            $matriz[$i][$j]->linea = false;
        }
    }
} 
?>
<title>Matriz resultante</title>
</head>
<body>
    <div class="d-flex justify-content-center">
    <div class="col-md-4">
    <div class="row">
            <div class="col">
                <h2 class="m-4 text-center">Matriz resultante</h2>
                <?php echo (imprimirTablaHungaro($matriz,$matriz2)); ?>
            </div>
        </div>
        <div class="row">
            <a href="interfazAsignacion.php" class="btn btn-primary">Regresar</a>
        </div>
    </div>
        
        
    </div>

<?php
include "../footer.php";
?>