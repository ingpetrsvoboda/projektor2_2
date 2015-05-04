<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Export
 *
 * @author pes2704
 */
class Projektor2_Controller_HelpExport implements Projektor2_Controller_ControllerInterface {

    protected $sessionStatus;
    protected $request;
    protected $response;
    
    public function __construct(Projektor2_SessionStatus $sessionStatus, Projektor2_Request $request, Projektor2_Response $response) {
        $this->sessionStatus = $sessionStatus;
        $this->request = $request;
        $this->response = $response;
    }
    
    public function getResult() {
        if($this->request->post('dbtabulka') AND substr($this->request->post('dbtabulka'),0,3)<>"---") {
            $tabulka = $this->request->post('dbtabulka');
            $exportExcel = new Projektor2_Controller_ExportExcel($tabulka);
            if ($exportExcel->export(NULL, 1)) {
                Projektor2_VynucenyDownload::download($exportExcel->getFullFileName());                    
            } else {
                return $exportExcel->getResult();
            }
        } else {
            $view = new Projektor2_View_HTML_Help_Export();
            return $view->render();
        }
    }


}

?>
