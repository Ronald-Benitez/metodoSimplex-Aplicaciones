<?php require_once "../header.php";?>
<title>Asignacion</title>
</head>
<body class="d-flex justify-content-center">
    
    <div class="row align-items-center">

        <div class="col align-self-center" id="hungaro">

            <div class="row" style="text-align: center">
                <h4 class="mt-4">Número de variables</h3>
                <input class="form-control m-4" type="number" id="num_variables" />
            </div>

            <div class="row" style="text-align: center">
                <button class="btn btn-primary mx-4 mt-2" onclick="crearCampos()">Desplegar</button><hr>
            </div>

        </div>

        <div class="row align-items-center">
        <div class="col align-self-center">

            <form action="funcionesA.php" method="post">
                <div id="llenar_datos" style="text-align: center; display: none" class="row">
                    <label class="form-label">Tabla: </label>
                        
                    <div id="tabla" class="m-4"></div>
                    <select class="form-select" aria-label="Default select example" name="tipo">
                        <option value="0" selected>Tipo de caso</option>
                        <option value="0">Minimizar</option>
                        <option value="1">Maximizar</option>
                    </select>
                            
                    <div class="row marketing" style="text-align: center">
                        <input class="btn btn-primary m-4" type="submit" id="calcular" value="Calcular"/>
                    </div>
                    
                </div>
            </form>

        </div>
        </div>
    </div>
    
    <script>
        function crearCampos(){
            
            $("#tabla").html("");
            var num_variables = parseInt($("#num_variables").val());
            
            var tabla = "";
            for(var i = 0; i<num_variables; i++){
                for(var j = 0; j<num_variables; j++){
                    tabla += "<input class='m-1' style='height: 30px; width: 60px;' type='number' name='valor"+i+j+"'/>";
                }
                tabla+= "<br>";
            }
            
            $("#llenar_datos").css("display", "block");
            $("#llenar_datos").append("<input type='hidden' name='num_variables' value='"+num_variables+"'/>");
            $("#tabla").append(tabla);
            
        }
    </script>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<?php require_once "../footer.php";?>