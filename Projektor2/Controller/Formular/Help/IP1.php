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
class Projektor2_Controller_Formular_Help_IP1 extends Projektor2_Controller_Formular_Help_IP {
    

    protected function createFormModels($zajemce) {
        $this->flatTable = new Projektor2_Model_Flat_ZaPlanFlatTable($zajemce); 
    }
    
    protected function getResultFormular() {
        $view = new Projektor2_View_HTML_Help_IP1();
        $view->appendContext($this->flatTable->getValuesAssoc());        
        $view->assign('kurzy_mot', $this->contextSelectKurz('MOT'));
        $view->assign('kurzy_pc1', $this->contextSelectKurz('PC'));
        $view->assign('kurzy_im', $this->contextSelectKurz('IM'));
        $view->assign('kurzy_spp', $this->contextSelectKurz('SPP'));
        $view->assign('kurzy_prdi', $this->contextSelectKurz('PD'));
        $view->assign('kurzy_prof1', $this->contextSelectKurz('RK'));    
        $view->assign('kurzy_prof2', $this->contextSelectKurz('RK'));    
        $view->assign('kurzy_prof3', $this->contextSelectKurz('RK'));    
        
        $htmlResult = $view->render();
        return $htmlResult;
    }
    
    protected function getResultPdf() {
        // metoda se volá při ukládání dat z formuláře - tedy při post požadavku a pole params obsahuje post data z aktuálního formuláře
        $view = new Projektor2_View_PDF_HelpPlanIP1($this->request->params);

        $zaFlatTable = new Projektor2_Model_Flat_ZaFlatTable($this->flatTable->mainObject);
        $view->appendContext($zaFlatTable->getValuesAssoc());
        $view->appendContext($this->flatTable->getValuesAssoc());
        $view->assign('kancelar_plny_text', $this->sessionStatus->kancelar->plny_text);
        $view->assign('user_name', $this->sessionStatus->user->name);
        $view->assign('identifikator', $this->sessionStatus->zajemce->identifikator);
        $view->assign('mot_kurz', Projektor2_Model_SKurzMapper::findById($this->flatTable->id_s_kurz_mot_FK));
        $view->assign('pc1_kurz', Projektor2_Model_SKurzMapper::findById($this->flatTable->id_s_kurz_pc1_FK));
        $view->assign('im_kurz', Projektor2_Model_SKurzMapper::findById($this->flatTable->id_s_kurz_im_FK));
        $view->assign('spp_kurz', Projektor2_Model_SKurzMapper::findById($this->flatTable->id_s_kurz_spp_FK));
        $view->assign('prdi_kurz', Projektor2_Model_SKurzMapper::findById($this->flatTable->id_s_kurz_prdi_FK));
        $view->assign('prof1_kurz', Projektor2_Model_SKurzMapper::findById($this->flatTable->id_s_kurz_prof1_FK));        
        $view->assign('prof2_kurz', Projektor2_Model_SKurzMapper::findById($this->flatTable->id_s_kurz_prof2_FK));        
        $view->assign('prof3_kurz', Projektor2_Model_SKurzMapper::findById($this->flatTable->id_s_kurz_prof3_FK));        
        
        $view->save();
        $htmlResult .= $view->getNewWindowOpenerCode();
        
        return $htmlResult;
    }
}

?>
