<?php

    class cls_salas_ocupadas{

        public $hora_inicio;
        public $duracion;
        public $citas_id;        
        public $citas_fecha;
        public $citas_sala;
                
        function __construct(string $hora_inicio="",
                                string $duracion="",
                                int $citas_id=0,
                                string $citas_fecha="",
                                string $citas_sala            
                             ){
            
            
            $this->hora_inicio = $hora_inicio;            
            $this->duracion = $duracion;            
            $this->citas_id = $citas_id;            
            $this->citas_fecha = $citas_fecha;            
            $this->citas_sala = $citas_sala;
        }        
    }


?>