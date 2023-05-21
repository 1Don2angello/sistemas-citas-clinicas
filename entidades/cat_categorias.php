<?php

    class cat_categorias{

        
        public $categorias_id;
        public $categorias_nombre;
        public $categorias_descripcion;
        

        function __construct(int $categorias_id=0,
                             string $categorias_nombre="",                              
                             string $categorias_descripcion=""
                             ){
            
            $this->categorias_id = $categorias_id;
            $this->categorias_nombre = $categorias_nombre;
            $this->categorias_descripcion = $categorias_descripcion;            
        }        
    }


?>