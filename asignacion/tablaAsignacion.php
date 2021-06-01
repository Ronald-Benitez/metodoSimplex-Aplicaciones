<?php require_once "header.php";?>
<title>Tabla de asignación</title>
</head>
<body>
<?php
    $recursos = $_POST['nRecursos'];
    $tareas = $_POST['nTareas'];
?>

<form method="post" action="asignacion.php"class="m-4">
    <table class="table">
    <thead>
        <tr>
        <th scope="col">Recursos/Tareas</th>
        <?php
            for($i=0; $i<$tareas;$i++){
                echo " <th scope='col'><input type='text' name='t$i' required></th>";
            }
        ?>
        </tr>
    </thead>
    <tbody>
    <?php
            for($i=0; $i<$recursos;$i++){
                echo"<tr>";
                echo" <th scope='row'><input type='text' name='r$i' required></th>";
                for($j=0; $j<$tareas;$j++){
                    echo "<td><input type='number' name='$i$j' required></td>";
                }
                echo"</tr>";
            }
        ?>
    </tbody>
    </table>
    <?="<input type='number' class='d-none' name='recursos' value='$recursos'>"?>
    <?="<input type='number' class='d-none' name='tareas' value='$tareas'>"?>
    <input type="submit" class="btn btn-success" value="Calcular asignación">
</form>


<?php require_once "footer.php";?>