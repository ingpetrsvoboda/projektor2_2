<?php
class Projektor2_Controller_Footer implements Projektor2_Controller_ControllerInterface  {
    
    protected $sessionStatus;
    protected $request;
    protected $response;
    
    public function __construct(Projektor2_SessionStatus $sessionStatus, Projektor2_Request $request, Projektor2_Response $response) {
        $this->sessionStatus = $sessionStatus;
        $this->request = $request;
        $this->response = $response;
    }

    public function getResult() {
        $view = new Projektor2_View_HTML_Footer();
        $html = $view->render();
        return $html;
    }
}

?>
