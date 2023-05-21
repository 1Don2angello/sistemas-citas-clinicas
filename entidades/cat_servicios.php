<?php

    class cat_servicios{

        public $servicios_id;
        public $servicios_categoria_id;
        public $servicios_descripcion;
        public $servicios_nombre;
        public $servicios_duracion;
        public $servicios_precio;

        public $cls_nombre_categoria;
        public $cls_descripcion_categoria;
                

        function __construct(int $servicios_id=0,
                             int $servicios_categoria_id=0,    
                             string $servicios_descripcion="",    
                             string $servicios_nombre="",    
                             string $servicios_duracion="",    
                             float $servicios_precio=0,

                             string $cls_nombre_categoria="",
                             string $cls_descripcion_categoria=""
                             ){
            
            $this->servicios_id = $servicios_id;
            $this->servicios_categoria_id = $servicios_categoria_id;
            $this->servicios_descripcion = $servicios_descripcion;
            $this->servicios_nombre = $servicios_nombre;
            $this->servicios_duracion = $servicios_duracion;
            $this->servicios_precio = $servicios_precio;            

            $this->cls_nombre_categoria = $cls_nombre_categoria;            
            $this->cls_descripcion_categoria = $cls_descripcion_categoria;
        }        
    }


?>