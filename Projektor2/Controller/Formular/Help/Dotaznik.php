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
class Projektor2_Controller_Formular_Help_Dotaznik extends Projektor2_Controller_Formular_Help_Menus {
    

    protected function createFormModels($zajemce) {
        $this->flatTable = new Projektor2_Model_Flat_ZaFlatTable($zajemce); 
    }
    
    protected function getResultFormular() {
        $htmlResult = "";
        $pole = $this->flatTable->getValuesAssoc();
        $view = new Projektor2_View_HTML_Help_Dotaznik($pole);
        $htmlResult .= $view->render();
        
        return $htmlResult;
    }
    
    protected function getResultPdf() {
        $html = '<div><img src="./img/loga/loga_HELP50+_BW.png"></div>';
        $view = new Projektor2_View_HTML2PDF_HelpDotaznik($this->request->params);
        $html .= $this->getResultFormular();

        $view->assign('html', $html);        
        $view->assign('identifikator', $this->sessionStatus->zajemce->identifikator);

        $view->save();
        $htmlResult .= $view->getNewWindowOpenerCode();
        
        return $htmlResult;
    }


}

?>
