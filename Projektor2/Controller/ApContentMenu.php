<?php
/**
 * Description of Projektor2_Controller_ZobrazeniRegistraci
 *
 * @author pes2704
 */
class Projektor2_Controller_ApContentMenu implements Projektor2_Controller_ControllerInterface {
    
    protected $sessionStatus;
    protected $request;
    protected $response;
    
    public function __construct(Projektor2_SessionStatus $sessionStatus, Projektor2_Request $request, Projektor2_Response $response) {
        $this->sessionStatus = $sessionStatus;
        $this->request = $request;
        $this->response = $response;
    }
     
     public function getResult() {         
        $htmlResult = '';
        $htmlResult .= '<div ID="zaznamy">';
//        $htmlResult .= "<h1>Menu zájemce</h1>";

        $htmlResult .= '<table>';
        $params = array('id' => $this->sessionStatus->zajemce->id);
        $tlacitkaController = new Projektor2_Controller_ApTlacitkaMenu($this->sessionStatus, $this->request, $this->response, $params);
        $htmlResult .= $tlacitkaController->getResult();
        $htmlResult .= '</table>';
        $htmlResult .= '</div>';
        return $htmlResult;
    }
}

?>