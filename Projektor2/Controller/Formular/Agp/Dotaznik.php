<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SaveForm
 *
 * @author pes2704
 */
class Projektor2_Controller_Formular_Agp_Dotaznik extends Projektor2_Controller_Formular_Agp_Menus {
    

    protected function createFormModels($zajemce) {
        $this->flatTable = new Projektor2_Model_Flat_ZaFlatTable($zajemce); 
    }
    
    protected function getResultFormular() {
        $htmlResult = "";
        $context = $this->flatTable->getValuesAssoc();
        $view = new Projektor2_View_HTML_Agp_Dotaznik($context);
        $htmlResult .= $view->render();
        return $htmlResult;
    }
    
    protected function getResultPdf() {}

}

?>
