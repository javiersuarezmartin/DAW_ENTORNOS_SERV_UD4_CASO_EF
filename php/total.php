<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado Total</title>
    <link rel="stylesheet" href="../css/styles.css" type="text/css">
</head>
<body>
    <div class="container"> 
        
        <?php

            // Incluimos el archivo con el código de funciones relacionada con la creación de la BBDD.
            include './dbEmpresa.php';
            include './bbdd.php';
    
            // Creamos un nuevo objeto para manejar la BBDD
            $conn = new dbEmpresa();
    
            // Mostramos si la conexión ha sido exitosa o errónea
            if ($conn->hayError()) {
                echo ('<p>Fallo al conectar a MySQL: ( ' . $conn->msgError() . ' )</p>');
                echo ('<br><a href="../html/index.html" class="btn">Volver</a>');
            } else { 
                echo ('<p>Conexi&oacute;n exitosa</p>');
                echo ('<br><a href="../html/index.html" class="btn">Volver</a><br>');
                echo ('<h1>Tabla Total</h1>');
                echo ('<table><thead><tr><th>Nº Semana</th><th>Gastos</th><th>Ventas</th></tr></thead><tbody>');
                
                // Comprobamos si las tablas ya estan creadas y llenas con datos.
                     
                if (crearEstructuraBBDD($conn)) {
                    
                    // Si las tablas están creadas correctamente con todos los datos, se muestran.
                    
                    for ($semana = 1; $semana <=3; $semana++) {
                        
                        // Realizamos consulta a la BBDD
                        $resultado = $conn->total($semana);
                        
                        // Imprimir tabla de datos.                                
                        if ($resultado != null) {
        
                            // Mostramos la fila de resultados de la semana.
                                echo ('<tr>');
                                echo ('<td>Semana ' . $semana . '</td>');
                            
                                foreach ($resultado as $op) {
                                    
                                    if ($op['total'] != null) {
                                        echo ('<td>' . $op['total'] . ' &euro;</td>');                                      
                                    } else {
                                        echo ('<td>' . 0 . ' &euro;</td>');
                                    };
                                };
                            
                                echo ('</tr>');
                                
                        } else {
                            echo('<p>Sin resultados</p>');
                        };
                    };  
                };  
            };    
        ?>
       
    </div>
</body>
</html>