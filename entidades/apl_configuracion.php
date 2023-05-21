<?php

    class apl_configuracion{

        public $configuracion_id;
        public $configuracion_nombre;        
        public $configuracion_clase;
        public $configuracion_valor;            


        function __construct(int $configuracion_id=0,
                             string $configuracion_nombre="",                                                           
                             string $configuracion_clase="",
                             string $configuracion_valor=""
                             ){
            
            $this->configuracion_id = $configuracion_id;
            $this->configuracion_nombre = $configuracion_nombre;            
            $this->configuracion_clase = $configuracion_clase;
            $this->configuracion_valor = $configuracion_valor;
        }        
    }


?>