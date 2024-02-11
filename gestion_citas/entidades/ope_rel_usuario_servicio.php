<?php

    class ope_rel_usuario_servicio{

        public $relacion_id;
        public $usuarios_id;
        public $servicios_id;
                
        
        function __construct(int $relacion_id=0,
                             int $usuarios_id=0,    
                             int $servicios_id=0                                                      
                             ){
            
            $this->relacion_id = $relacion_id;
            $this->usuarios_id = $usuarios_id;
            $this->servicios_id = $servicios_id;                       
        }        
    }


?>