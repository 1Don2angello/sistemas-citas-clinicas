<?php

    class cls_horas_ocupadas{

        public $hora_inicio;
        public $duracion;
        public $citas_proveedor_id;        
        public $citas_fecha;
                
        function __construct(string $hora_inicio="",
                                string $duracion="",
                                int $citas_proveedor_id=0,
                                string $citas_fecha=""            
                             ){
            
            
            $this->hora_inicio = $hora_inicio;            
            $this->duracion = $duracion;            
            $this->citas_proveedor_id = $citas_proveedor_id;            
            $this->citas_fecha = $citas_fecha;            
        }        
    }


?>