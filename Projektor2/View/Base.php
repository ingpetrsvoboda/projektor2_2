<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Base
 *
 * @author pes2704
 */
class Projektor2_View_Base {
    protected $context = array();

    public function __construct(array $context=NULL) {
        $this->context = $context;
    }
    
    public function appendContext(array $appendContext=NULL) {
        if ($this->context) {
            $this->context = array_merge($this->context, $appendContext);
        } else {
            $this->context = $appendContext;            
        }
    }
    
    public function assign($name, $value){
        $this->context[$name] = $value;
    }
    
}

?>
