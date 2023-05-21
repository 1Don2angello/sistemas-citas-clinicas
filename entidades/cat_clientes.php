<?php

    class cat_clientes{

        public $clientes_id;
        public $clientes_nombre;
        public $clientes_apellido_p;
        public $clientes_apellido_m;
        public $clientes_telefono;
        public $clientes_correo;
        public $clientes_direccion;
        public $clientes_sexo;
        public $clientes_edad;
                

        function __construct(int $clientes_id=0,
                             string $clientes_nombre="",    
                             string $clientes_apellido_p="",    
                             string $clientes_apellido_m="",    
                             string $clientes_telefono="",    
                             string $clientes_correo="",    
                             string $clientes_direccion="",    
                             string $clientes_sexo="",                              
                             int $clientes_edad=0
                             ){
            
            $this->clientes_id = $clientes_id;
            $this->clientes_nombre = $clientes_nombre;
            $this->clientes_apellido_p = $clientes_apellido_p;
            $this->clientes_apellido_m = $clientes_apellido_m;
            $this->clientes_telefono = $clientes_telefono;
            $this->clientes_correo = $clientes_correo;
            $this->clientes_direccion = $clientes_direccion;
            $this->clientes_sexo = $clientes_sexo;
            $this->clientes_edad = $clientes_edad;
        }        
    }


?>