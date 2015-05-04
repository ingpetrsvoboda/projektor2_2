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
class Projektor2_Controller_Formular_Ap_IP2 extends Projektor2_Controller_Formular_Ap_IP {

    protected function createFormModels($zajemce) {
        $this->flatTable = new Projektor2_Model_Flat_ZaUkoncFlatTable($zajemce); 
    }
    
    protected function getResultFormular() {
        $view = new Projektor2_View_HTML_Ap_IP2();        
        $zaPlanFlatTable = new Projektor2_Model_Flat_ZaPlanFlatTable($this->flatTable->getMainObject());
        $view->appendContext($zaPlanFlatTable->getValuesAssoc());        
        $view->appendContext($this->flatTable->getValuesAssoc());
        $this->assignKurzyToHtmlView($view);
        
        $htmlResult = $view->render();
        return $htmlResult;
    }
    
    protected function getResultPdf() {
        if ($this->request->post('pdf') == "Tiskni IP 2.část - vyhodnocení aktivit") {
            $view = new Projektor2_View_PDF_ApIP2($this->request->params);
        }
        if ($this->request->post('pdf') == "Tiskni ukončení účasti") {
            $view = new Projektor2_View_PDF_ApUkonceni($this->request->params);
        }
        $zaFlatTable = new Projektor2_Model_Flat_ZaFlatTable($this->flatTable->mainObject);
        $planFlatTable = new Projektor2_Model_Flat_ZaPlanFlatTable($this->flatTable->mainObject);
        //osobní
        $view->appendContext($zaFlatTable->getValuesAssoc());
        //plán
        $view->appendContext($planFlatTable->getValuesAssoc());
        //ukonc
        $view->appendContext($this->flatTable->getValuesAssoc());
        //status proměnné
        $view->assign('kancelar_plny_text', $this->sessionStatus->kancelar->plny_text);
        $view->assign('user_name', $this->sessionStatus->user->name);
        $view->assign('identifikator', $this->sessionStatus->zajemce->identifikator);
        $view->assign('znacka', $this->sessionStatus->zajemce->znacka);
        
        //plan a kurzy z plán
        $view->appendContext($planFlatTable->getValuesAssoc());
        $this->assignKurzyToPdfView($planFlatTable, $view);
        
        $view->save();
        $htmlResult .= $view->getNewWindowOpenerCode();
        
        return $htmlResult;
    }
}

?>
