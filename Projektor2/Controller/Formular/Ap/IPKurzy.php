<?php
/**
 * Description of SaveForm
 *
 * @author pes2704
 */
class Projektor2_Controller_Formular_Ap_IPKurzy extends Projektor2_Controller_Formular_Ap_IP {
    

    protected function createFormModels($zajemce) {
        $this->flatTable = new Projektor2_Model_Flat_ZaPlanFlatTable($zajemce); 
    }
    
    protected function getResultFormular() {
        $view = new Projektor2_View_HTML_Ap_IPKurzy();
        $view->appendContext($this->flatTable->getValuesAssoc());        
        $this->assignKurzyToHtmlView($view);
        
        $htmlResult = $view->render();
        return $htmlResult;
    }
    
    protected function getResultPdf() {
        // metoda se volá při ukládání dat z formuláře - tedy při post požadavku a pole params obsahuje post data z aktuálního formuláře
        $view = new Projektor2_View_PDF_ApIPAktivity($this->request->params);

        $zaFlatTable = new Projektor2_Model_Flat_ZaFlatTable($this->flatTable->mainObject);  //$this->flat_table je Projektor2_Flat_ZaPlanFlatTable
        $view->appendContext($zaFlatTable->getValuesAssoc());
        $view->appendContext($this->flatTable->getValuesAssoc());
        $view->assign('kancelar_plny_text', $this->sessionStatus->kancelar->plny_text);
        $view->assign('user_name', $this->sessionStatus->user->name);
        $view->assign('identifikator', $this->sessionStatus->zajemce->identifikator);
        $view->assign('znacka', $this->sessionStatus->zajemce->znacka);        
        $this->assignKurzyToPdfView($this->flatTable, $view);
        
        $view->save();
        $htmlResult .= $view->getNewWindowOpenerCode();
        
        return $htmlResult;
    }
}

?>
