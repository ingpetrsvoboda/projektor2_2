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
class Projektor2_Controller_Head implements Projektor2_Controller_ControllerInterface  {
    protected $sessionStatus;
    protected $request;
    protected $response;
    
    public function __construct(Projektor2_SessionStatus $sessionStatus, Projektor2_Request $request, Projektor2_Response $response) {
        $this->sessionStatus = $sessionStatus;
        $this->request = $request;
        $this->response = $response;
    }
    
    public function getResult() {
        $view = new Projektor2_View_HTML_Head(array('projektText'=>  $this->sessionStatus->projekt->text, 'kancelarText'=>  $this->sessionStatus->kancelar->text));
        $html = $view->render();
        return $html;
    }
}

?>
