<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Projektor2_Controller_Formular_HelpIP
 *
 * @author pes2704
 */
abstract class Projektor2_Controller_Formular_Help_IP extends Projektor2_Controller_Formular_Help_Menus {
    
    protected function contextSelectKurz($kurz_druh, $default=TRUE) {
        $filter = "(projekt_kod='".$this->sessionStatus->projekt->kod
                ."' AND kancelar_kod='".$this->sessionStatus->kancelar->kod
                ."' AND beh_cislo='".$this->sessionStatus->beh->beh_cislo
                ."' AND kurz_druh='".$kurz_druh."')";
        if ($default) {
            $filter .= " OR kurz_zkratka='*'";
        }
        $mapper = new Projektor2_Model_SKurzMapper();
        return $mapper->findAll($filter, 'razeni');       
    }
}
