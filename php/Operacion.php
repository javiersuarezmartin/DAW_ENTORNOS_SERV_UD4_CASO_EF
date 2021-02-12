<?php
    class Operacion {
        
	    private $valor;
	    private $num_semana;        

        // Constructor

        public function __construct($valor, $num_semana) {
            $this->valor = $valor;
	        $this->num_semana = $num_semana;	        
        }

        // Métodos Get

        public function getValor() {
            return $this->valor;
        }

        public function getNumSemana() {
            return $this->num_semana;
        }

        // Métodos Set

        public function setValor($valor) {
            $this->valor = $valor;
        }

        public function setNumSemana($num_semana) {
            $this->num_semana = $num_semana;
        }
       
        // Otros métodos

    };
?>