<?php

    class cls_combo{

        public $id;
        public $texto;
        public $extra;        

        function __construct(int $id=0,
                             string $texto="",
                             string $extra=""
                             ){
            
            $this->id = $id;
            $this->texto = $texto;
            $this->extra = $extra;                        
        }        
    }


?>