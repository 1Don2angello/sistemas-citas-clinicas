<?php

    class cls_ope_citas{

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
                
        public $servicios_id;
        public $servicios_nombre;
        public $servicios_duracion;
        public $servicios_precio;

        public $categorias_id;
        public $categorias_nombre;

        public $clientes_id;
        public $clientes_nombre_completo;
        public $clientes_correo;
        public $clientes_telefono;

        public $proveedores_nombre_completo;

        
        function __construct(int $citas_id=0,
                                int $citas_servicios_id=0,    
                                int $citas_proveedor_id=0,    
                                int $citas_clientes_id=0,
                                string $citas_estatus="",    
                                string $citas_fecha="",    
                                string $citas_hora="",    
                                string $citas_notas="",
                                string $citas_fecha_creo="",
                                string $citas_sala="",

                                int $servicios_id=0,
                                string $servicios_nombre="",
                                string $servicios_duracion="",
                                float $servicios_precio=0,

                                int $categorias_id=0,
                                string $categorias_nombre="",

                                int $clientes_id=0,
                                string $clientes_nombre_completo="",
                                string $clientes_correo="",
                                string $clientes_telefono="",

                                string $proveedores_nombre_completo=""
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
            
            $this->servicios_id = $servicios_id;
            $this->servicios_nombre = $servicios_nombre;
            $this->servicios_duracion = $servicios_duracion;
            $this->servicios_precio = $servicios_precio;

            $this->categorias_id = $categorias_id;
            $this->categorias_nombre = $categorias_nombre;
            
            $this->clientes_id = $clientes_id;
            $this->clientes_nombre_completo = $clientes_nombre_completo;
            $this->clientes_correo = $clientes_correo;
            $this->clientes_telefono = $clientes_telefono;

            $this->proveedores_nombre_completo = $proveedores_nombre_completo;
            
            
        }        
    }


?>