<?php

    class ope_descansos{
        
        public $descansos_id;
        public $descansos_dia;
        public $descansos_inicio;
        public $descansos_final;
        
                        
        function __construct(int $descansos_id=0,
                             string $descansos_dia="",    
                             int $descansos_inicio=0,
                             int $descansos_final=0
                             ){
            
            $this->descansos_id = $descansos_id;
            $this->descansos_dia = $descansos_dia;
            $this->descansos_inicio = $descansos_inicio;
            $this->descansos_final = $descansos_final;
        }        
    }


?>