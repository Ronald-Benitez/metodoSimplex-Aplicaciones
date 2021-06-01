<?php
include ("funcionesA.php");
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";

    $tareas = $_POST['tareas'];
    $recursos = $_POST['recursos'];
    $mTareas;
    $mRecursos;

    for($i=0;$i<$tareas;$i++) {
        $mTareas[$i]=$_POST['t'.$i];
    }

    for($i=0;$i<$recursos;$i++) {
        $mRecursos[$i]=$_POST['r'.$i];
    }

    $matrizCostos;
    
    for($i=0;$i<$recursos;$i++) {
        for($j=0;$j<$tareas;$j++) {
            $matrizCostos[$i][$j]=$_POST[$i.$j];
        }
    }

    /*
    echo "<pre>";
    print_r($mTareas);
    echo "</pre>";
    echo "<pre>";
    print_r($mRecursos);
    echo "</pre>";
    echo "<pre>";
    print_r($matrizCostos);
    echo "</pre>";
*/
    $solucion = asignarTareas($matrizCostos);
    echo "<pre>";
    print_r($solucion);
    echo "</pre>";


?>