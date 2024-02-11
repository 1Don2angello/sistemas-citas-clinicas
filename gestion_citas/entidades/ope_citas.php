<?php

    class ope_citas{

        public $citas_id;
        public $citas_servicios_id;
        public $citas_proveedor_id;
        public $citas_clientes_id;
        public $citas_fecha;
        public $citas_hora;
        public $citas_notas;
        public $citas_fecha_creo;
        public $citas_estatus;
        public $citas_sala;
                
        
        function __construct(int $citas_id=0,
                             int $citas_servicios_id=0,    
                             int $citas_proveedor_id=0,    
                             int $citas_clientes_id=0,
                             string $citas_estatus="",    
                             string $citas_fecha="",    
                             string $citas_hora="",    
                             string $citas_notas="",
                             string $citas_fecha_creo="",
                             string $citas_sala=""
                             ){
            
            $this->citas_id = $citas_id;
            $this->citas_servicios_id = $citas_servicios_id;
            $this->citas_proveedor_id = $citas_proveedor_id;
            $this->citas_clientes_id = $citas_clientes_id;
            $this->citas_estatus = $citas_estatus;
            $this->citas_fecha = $citas_fecha;
            $this->citas_hora = $citas_hora;
            $this->citas_notas = $citas_notas;
            $this->citas_fecha_creo = $citas_fecha_creo;
            $this->citas_sala = $citas_sala;
        }        
    }


?>