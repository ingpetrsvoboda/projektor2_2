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
class Projektor2_Controller_Logout implements Projektor2_Controller_ControllerInterface  {
    
    protected $sessionStatus;
    protected $request;
    protected $response;
    
    public function __construct(Projektor2_SessionStatus $sessionStatus, Projektor2_Request $request, Projektor2_Response $response) {
        $this->sessionStatus = $sessionStatus;
        $this->request = $request;
        $this->response = $response;
    }

    public function getResult() {
        // kontroler logout se volá při každém requestu (zobrazení formuláře logout je součástí layoutu celé staránky
        // přesměruje se na login
        if ($this->request->isPost()) {
            if ($this->request->get('akce') == 'logout') {
                try {
                    $authCookie = new Projektor2_Auth_Cookie($this->response);
                    $authCookie->validate();  // pokud není uživatel přihlášen, dojde k přesměrování na login
                    // zde se pokračuje, jen pokud je uživatel přihlášen
                    $this->response->setCookie("lastname",$name,time()+3600);
                    $this->response->setCookie("lastprojektkod",$projektkod,time()+3600);
                    $this->response->setCookie("lastkancelarkod",$kancelarkod,time()+3600);
                    $this->response->setCookie("lastkancelarkod",$kancelarkod,time()+3600);
                    $authCookie->logout();
                    header("Location: ./login.php?originating_uri=".$_SERVER['REQUEST_URI']);
                    $this->response->send();
                    exit;
                } catch (Projektor2_Auth_Exception $e) {
                    header("Location: ./login.php?originating_uri=".$_SERVER['REQUEST_URI']);
                    $this->response->send();
                    exit;
                }
            }
        }
        $view = new Projektor2_View_HTML_Logout();
        $html = $view->render();
        return $html;
    }
}

?>
