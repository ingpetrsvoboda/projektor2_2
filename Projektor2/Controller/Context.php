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
class Projektor2_Controller_Context implements Projektor2_Controller_ControllerInterface  {
    protected $sessionStatus;
    protected $request;
    protected $response;
    
    public function __construct(Projektor2_SessionStatus $sessionStatus, Projektor2_Request $request, Projektor2_Response $response) {
        $this->sessionStatus = $sessionStatus;
        $this->request = $request;
        $this->response = $response;
    }
    
    public function getResult() {
        $dbh = Projektor2_AppContext::getDB();
            if ($dbh->getDbHost() == 'localhost') {
                $html .= '<DIV class="connection development">';  
            } else {
                $html .= '<DIV class="connection production">';   
            }
            $html .= '            Uživatel '.$this->sessionStatus->user->username.'<br> pracuje s databází '. 
                    $dbh->getDbName().'<br> na stroji '.$dbh->getDbHost().' jako '.$dbh->getUser().'.';
            $html .= '     </DIV>';
        return $html;
    }
}

?>