<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado Beneficios (Sem 2)</title>
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
                echo('<br><a href="../html/index.html" class="btn">Volver</a>');
            } else { 
                echo ('<p>Conexi&oacute;n exitosa</p>');
                echo('<br><a href="../html/index.html" class="btn">Volver</a><br>');
                echo ('<h1>Tabla Semana 2</h1>');
                echo ('<table><thead><tr><th>Nº Semana</th><th>Beneficios</th></tr></thead><tbody>');
                    
                // Si la conexión es exitosa mostramos los datos.
                if (crearEstructuraBBDD($conn)) {
                    // Realizamos consulta a la BBDD
                    $resultado = $conn->total(2);
                    
                    // Imprimir tabla de datos.                                
                    if ($resultado != null) {

                        // Mostramos la fila de resultados de la semana.
                            echo ('<tr>');
                            echo ('<td>Semana 2</td>');
                            $beneficio = $resultado[1]['total'] - $resultado[0]['total'];
                            echo ('<td>' . $beneficio . ' &euro;</td>');
                            echo ('</tr>');
                    } else {
                        echo('<p>Sin resultados</p>');
                    };
                };
            };    
        ?>
       
    </div>
</body>
</html>