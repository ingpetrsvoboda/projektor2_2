<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Hlavicka
 *
 * @author pes2704
 */
class Projektor2_Controller_Message implements Projektor2_Controller_ControllerInterface  {
    
    protected $sessionStatus;
    protected $request;
    protected $response;
    
    public function __construct(Projektor2_SessionStatus $sessionStatus, Projektor2_Request $request, Projektor2_Response $response) {
        $this->sessionStatus = $sessionStatus;
        $this->request = $request;
        $this->response = $response;
    }

    public function getResult() {
        if(!$this->sessionStatus->opravneniKancelar) {
        $message = "V této kanceláři nemáte přístupná žádná data, zkuste se odhlásit a vybrat jinou";
        }
        if(!$this->sessionStatus->opravneniProjekt) {
        $message = "V tomto projektu nemáte přístupná žádná data, zkuste se odhlásit a vybrat jiný";
        }
        $view = new Projektor2_View_HTML_Message(array('message' => $message));
        $html = $view->render();
        return $html;
    }
}

?>
