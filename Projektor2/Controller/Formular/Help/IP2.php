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
class Projektor2_Controller_Formular_Help_IP2 extends Projektor2_Controller_Formular_Help_IP {

    protected function createFormModels($zajemce) {
        $this->flatTable = new Projektor2_Model_Flat_ZaUkoncFlatTable($zajemce); 
    }
    
    protected function getResultFormular() {
        $view = new Projektor2_View_HTML_Help_IP2();        
        $zaFlatTable = new Projektor2_Model_Flat_ZaPlanFlatTable($this->flatTable->mainObject);
        $view->appendContext($zaFlatTable->getValuesAssoc());        
        $view->appendContext($this->flatTable->getValuesAssoc());
        $view->assign('kurzy_mot', $this->contextSelectKurz('MOT'));
        $view->assign('kurzy_pc1', $this->contextSelectKurz('PC'));
        $view->assign('kurzy_im', $this->contextSelectKurz('IM'));
        $view->assign('kurzy_spp', $this->contextSelectKurz('SPP'));
        $view->assign('kurzy_prdi', $this->contextSelectKurz('PD'));
        $view->assign('kurzy_prof1', $this->contextSelectKurz('RK'));  
        
        $htmlResult = $view->render();
        return $htmlResult;
    }
    
    protected function getResultPdf() {
        if ($this->request->post('pdf') == "Tiskni IP 2.část") {
            $view = new Projektor2_View_PDF_HelpPlanIP2($this->request->params);
        }
        if ($this->request->post('pdf') == "Tiskni ukončení účasti") {
            $view = new Projektor2_View_PDF_HelpUkonceni($this->request->params);
        }
        $zaFlatTable = new Projektor2_Model_Flat_ZaFlatTable($this->flatTable->mainObject);
        $planFlatTable = new Projektor2_Model_Flat_ZaPlanFlatTable($this->flatTable->mainObject);
        //osobní
        $view->appendContext($zaFlatTable->getValuesAssoc());
        //ukonc
        $view->appendContext($this->flatTable->getValuesAssoc());
        //status proměnné
        $view->assign('kancelar_plny_text', $this->sessionStatus->kancelar->plny_text);
        $view->assign('user_name', $this->sessionStatus->user->name);
        $view->assign('identifikator', $this->sessionStatus->zajemce->identifikator);
        //plan a kurzy z plán
        $view->appendContext($planFlatTable->getValuesAssoc());
        $view->assign('mot_kurz', Projektor2_Model_SKurzMapper::findById($planFlatTable->id_s_kurz_mot_FK));
        $view->assign('pc1_kurz', Projektor2_Model_SKurzMapper::findById($planFlatTable->id_s_kurz_pc1_FK));
        $view->assign('im_kurz', Projektor2_Model_SKurzMapper::findById($planFlatTable->id_s_kurz_im_FK));
        $view->assign('spp_kurz', Projektor2_Model_SKurzMapper::findById($planFlatTable->id_s_kurz_spp_FK));
        $view->assign('prdi_kurz', Projektor2_Model_SKurzMapper::findById($planFlatTable->id_s_kurz_prdi_FK));
        $view->assign('prof1_kurz', Projektor2_Model_SKurzMapper::findById($planFlatTable->id_s_kurz_prof1_FK));          
        
        $view->save();
        $htmlResult .= $view->getNewWindowOpenerCode();
        
        return $htmlResult;
    }
}

?>
