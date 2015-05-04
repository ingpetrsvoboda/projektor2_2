<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Projektor2_Controller_Formular_ApIPPoradenstvi
 *
 * @author pes2704
 */
class Projektor2_Controller_Formular_Ap_IPPoradenstvi extends Projektor2_Controller_Formular_Ap_IP {
    
    /**
     * Bázová třída Projektor2_Controller_Formular_Base volá tuto metodu a ukládá flat table zájemce pro další použití.
     * @param Projektor2_Model_Zajemce $Zajemce
     * @return \Projektor2_Model_Flat_ZaPlanFlatTable
     */
    protected function createFormModels($zajemce) {
        $this->flatTable = new Projektor2_Model_Flat_ZaPlanFlatTable($zajemce); 
        $mapper = new Projektor2_Model_ZaPlanPoradenstviMapper();
        $kluby = $this->contextSelectKurz('KLUB', FALSE);
        foreach ($kluby as $klub) {
            $model = $mapper->findByIdZajemceAndIdSKurz($this->sessionStatus->zajemce->id, $klub->id);
            if (!$model) {
                $model = $mapper->create();
                $model->id_zajemce_FK = $this->sessionStatus->zajemce->id;
            }
            $this->models['zaPlanPoradnestvi'][] = $model;
        }
    }
    
    protected function getResultFormular() {
        $view = new Projektor2_View_HTML_Ap_IPPoradenstvi();
        $view->appendContext($this->flatTable->getValuesAssoc());        
        $this->assignKurzyToHtmlView($view);        
        $this->assignPoradenstviToHtmlView($view);
        
        $htmlResult = $view->render();
        return $htmlResult;
    }
    
    protected function getResultPdf() {
        // metoda se volá při ukládání dat z formuláře - tedy při post požadavku, pole params obsahuje post data z aktuálního formuláře
        $view = new Projektor2_View_PDF_ApIPKurzy($this->request->params);
        //přidání dalších dat 
        $mapper = new Projektor2_Model_ZaPlanPoradenstviMapper();        
        $zaPlanPoradenstvi = $mapper->findByIdZajemce($this->flatTable->mainObject->id);

        $zaFlatTable = new Projektor2_Model_Flat_ZaFlatTable($this->flatTable->mainObject);  //$this->flat_table je Projektor2_Flat_ZaPlanFlatTable
        $view->appendContext($zaFlatTable->getValuesAssoc());  //zájemce
        $view->appendContext($this->flatTable->getValuesAssoc());  //plán kurzů - jeden objekt
        $view->appendContext(array('plan_poradenstvi'=>$zaPlanPoradenstvi)); //plán poradenství - pole modelů
        $view->assign('kancelar_plny_text', $this->sessionStatus->kancelar->plny_text);
        $view->assign('user_name', $this->sessionStatus->user->name);
        $view->assign('identifikator', $this->sessionStatus->zajemce->identifikator);
        $view->assign('znacka', $this->sessionStatus->zajemce->znacka);        
        $this->assignKurzyToPdfView($this->flatTable, $view);
        $this->assignPoradenstviToPdfView($planFlatTable, $view);
        
        $view->save();
        $htmlResult .= $view->getNewWindowOpenerCode();
        
        return $htmlResult;
    }
}

?>
