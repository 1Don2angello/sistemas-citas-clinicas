<?php

    class cat_usuarios{

        public $usuarios_id;
        public $usuarios_nombre;
        public $usuarios_apellido_p;
        public $usuarios_apellido_m;
        public $usuarios_telefono;
        public $usuarios_correo;
        public $usuarios_direccion;
        public $usuarios_usuario;
        public $usuarios_clave;
        public $usuarios_rol;

        
        function __construct(int $usuarios_id=0,
                             string $usuarios_nombre="",    
                             string $usuarios_apellido_p="",    
                             string $usuarios_apellido_m="",    
                             string $usuarios_telefono="",    
                             string $usuarios_correo="",    
                             string $usuarios_direccion="",    
                             string $usuarios_usuario="",                              
                             string $usuarios_clave="",
                             string $usuarios_rol=""
                             ){
            
            $this->usuarios_id = $usuarios_id;
            $this->usuarios_nombre = $usuarios_nombre;
            $this->usuarios_apellido_p = $usuarios_apellido_p;
            $this->usuarios_apellido_m = $usuarios_apellido_m;
            $this->usuarios_telefono = $usuarios_telefono;
            $this->usuarios_correo = $usuarios_correo;
            $this->usuarios_direccion = $usuarios_direccion;
            $this->usuarios_usuario = $usuarios_usuario;
            $this->usuarios_clave = $usuarios_clave;
            $this->usuarios_rol = $usuarios_rol;
        }        
    }


?>