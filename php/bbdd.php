<?php
    require_once './Operacion.php';

    // Funcion para crear las tablas de la BBDD
    function crearTablasBBDD($conexion) {    
           
        // Creamos la tabla gastos
        $sql_gastos = 
            'CREATE TABLE IF NOT EXISTS gastos(
                id INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY, 
                gasto INT(10) NULL,
                num_semana INT(1) NULL                    
            );'
        ;
        
        // Creamos la tabla ventas
        $sql_ventas = 
            'CREATE TABLE IF NOT EXISTS ventas(
                id INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY, 
                venta INT(10) NULL,
                num_semana INT(1) NULL
            );'
        ;
            
        $result_gastos = $conexion->consulta($sql_gastos);        
        $result_ventas = $conexion->consulta($sql_ventas);
        
        // Devolvemos si se han creado correctamente las tablas o no.
        if (($result_gastos != null) && ($result_gastos != null)) {
            return true;
        } else {
            return false;
        };
    }
    

    // Funcion genérica para llenar ambas BBDD (Gastos / Ventas)
    function llenarBBDD($tabla, $conexion) {

        $conexion->consulta('USE '.$tabla.';');

        // Comprobamos si la tabla esta vacia antes de llenarla.
        if ($conexion->obtenerDatos($tabla) == null) {
            // Declaramos 6 nuevos objetos Gasto/Venta aleatorios.
            for ($i=0; $i<=5; $i++) {
                
                // 3 en la semana 1 y 3 en la semana 2
                if ($i<=2) {
                    $semana = 1;
                } else {
                    $semana = 2;
                };

                $operacion = new Operacion (rand(10,1000), $semana);          

                // Añadimos los datos a las tablas
                $sql_op = 'INSERT INTO '.$tabla.' VALUES (NULL,' . $operacion->getValor() . ', ' . $operacion->getNumSemana() . ');';
                $res_insert = $conexion->consulta($sql_op);
                
                // Comprobamos si hemos tenido algun fallo en las inserciones.
                if ($res_insert == null) {
                    $i = 6; // Forzamos salida del for
                };               
            };

            return $res_insert;
        } else {
            return true; // Ya esta llena.
        };     
    };

    // Método para crar toda la estructura de datos.
    function crearEstructuraBBDD($conexion){
        // Creamos las tablas Gastos y Ventas.
        if(crearTablasBBDD($conexion)) {
        
            // Llenamos la tabla Gastos con datos.
            if(llenarBBDD('gastos', $conexion) == null) {
                return false;// Error en el llenado de datos de la tabla.
            } else {
                if (llenarBBDD('ventas', $conexion) == null) {
                    // Error en el llenado de datos de la tabla.
                    return false;
                } else {
                    return true;
                };            
            };

        } else {
            return false; // Error en creación de las tablas.
        }; 
    };    
?>