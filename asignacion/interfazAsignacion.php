<?php require_once "../header.php";?>
<title>Asignacion</title>
</head>
<body class="d-flex justify-content-center">
    
    <div class="row align-items-center">

        <div class="col align-self-center" id="hungaro">

            <div class="row" style="text-align: center">
                <h4 class="mt-4">Número de variables</h3>
                <input class="form-control m-4" type="number" id="num_variables_hungaro" />
            </div>

            <div class="row" style="text-align: center">
                <button class="btn btn-primary mx-4 mt-2" onclick="crearCamposHungaro()">Desplegar</button><hr>
            </div>

        </div>

        <div class="row align-items-center">
        <div class="col align-self-center">

            <form action="funcionesA.php" method="post">
                <div id="llenar_datos_hungaro" style="text-align: center; display: none" class="row">
                    <label class="form-label">Tabla: </label>
                        
                    <div id="tabla_hungaro" class="m-4"></div>
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
        function crearCamposHungaro(){
            
            $("#tabla_hungaro").html("");
            var num_variables_hungaro = parseInt($("#num_variables_hungaro").val());
            
            var tabla_hungaro = "";
            for(var i = 0; i<num_variables_hungaro; i++){
                for(var j = 0; j<num_variables_hungaro; j++){
                    tabla_hungaro += "<input class='m-1' style='height: 30px; width: 60px;' type='number' name='valor_hungaro"+i+j+"'/>";
                }
                tabla_hungaro+= "<br>";
            }
            
            $("#llenar_datos_hungaro").css("display", "block");
            $("#llenar_datos_hungaro").append("<input type='hidden' name='num_variables' value='"+num_variables_hungaro+"'/>");
            $("#tabla_hungaro").append(tabla_hungaro);
            
        }
    </script>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<?php require_once "../footer.php";?>