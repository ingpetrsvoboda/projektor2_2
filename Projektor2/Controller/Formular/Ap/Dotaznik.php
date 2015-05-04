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
class Projektor2_Controller_Formular_Ap_Dotaznik extends Projektor2_Controller_Formular_Ap_Menus {
    

    protected function createFormModels($zajemce) {
        $this->flatTable = new Projektor2_Model_Flat_ZaFlatTable($zajemce); 
    }
    
    protected function getResultFormular() {
        $htmlResult = "";
        $pole = $this->flatTable->getValuesAssoc();
        $view = new Projektor2_View_HTML_Ap_Dotaznik($pole);
        $htmlResult .= $view->render();
        
        return $htmlResult;
    }
    
    protected function getResultPdf() {
        $html = '<div><img src="./img/loga/loga_AP_BW.png"></div>';
        $view = new Projektor2_View_HTML2PDF_ApDotaznik($this->request->params);
        $html .= $this->getResultFormular();

        $view->assign('html', $html);        
        $view->assign('identifikator', $this->sessionStatus->zajemce->identifikator);

        $view->save();
        $htmlResult .= $view->getNewWindowOpenerCode();
        
        return $htmlResult;
    }


}

?>
