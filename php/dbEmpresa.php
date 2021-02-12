<?php  

    class dbEmpresa {
        
        // Atributos
        
        private $host = 'localhost';
        private $user = ''; // Cambiar
        private $pass = ''; // Cambiar
        private $bbdd = 'beneficios';
        private $port = 3306; 
        
        // Conexión
        private $conexion;

        // Errores
        private $err = false;
        private $err_msg = '';

        // Constructor
        public function __construct() {
            $this->conexion = new mysqli($this->host, $this->user, $this->pass, $this->bbdd, $this->port);
           
            if ($this->conexion->connect_errno) {                           
                $this->err = true;                
                $this->err_msg = 'No se puede conectar a la BBDD, por favor revise los datos de conexi&oacute;n';
            };           
        }
        
        // No incluimos los métodos Get y Set ya que no interesa que estos datos sean accesibles en este caso.

        // Otros métodos
        
        // Método para saber si hay un error
        public function hayError() {
            return $this->err;
        }

        // Método que devuelve el mensaje de error
        public function msgError() {
            return $this->err_msg;
        }             
        
        // Método para realizar consultas;
        public function consulta($sql) {
            if ($this->err == false) {
                $res = $this->conexion->query($sql);
                return $res;
            } else {
                $this->err_msg = 'No se puede completar la consulta: ' . $sql;
                return null;
            };
        }       
        
        // Método para obtener todos los datos.
        public function obtenerDatos($tabla) {
            
            $sql = 'SELECT * FROM ' . $tabla;
                        
            // Realizamos la consulta.
            $res = $this->consulta($sql);
            
            // Si se completa la consulta montamos la tabla de respuesta.
            if ($res != null) {
                $tabla = []; 
                while($row = $res->fetch_assoc()) {
                    $tabla[] = $row;
                };
                return $tabla;
            } else {
                return null;
            };
        }

        
        // Método para obtener totales por semana.
         public function total($semana) {
       
            $sql_gasto = 'SELECT SUM(gasto) AS total FROM gastos WHERE num_semana = ' . $semana;
            $sql_venta = 'SELECT SUM(venta) AS total FROM ventas WHERE num_semana = ' . $semana;
                        
            // Realizamos la consulta.
            $res_gastos = $this->consulta($sql_gasto);
            $res_ventas = $this->consulta($sql_venta);
           
            // Si se completa la consulta montamos la tabla de respuesta.
            if (($res_gastos != null) && ($res_ventas != null)) {
                $tabla_semana = []; 
                while($row = $res_gastos->fetch_assoc()) {
                    $tabla_semana[] = $row;
                }; // La posicion 0 contendrá los gastos totales.
                
                while($row = $res_ventas->fetch_assoc()) {
                    $tabla_semana[] = $row;
                }; // La posicion 1 contendrá las ventas totales.

                return $tabla_semana;    

            } else {
                return null;
            };
        }
        
    }
?>