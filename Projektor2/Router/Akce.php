<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Akce
 *
 * @author pes2704
 */
class Projektor2_Router_Akce {  

    protected $sessionStatus;
    protected $request;
    protected $response;
    
    public function __construct(Projektor2_SessionStatus $sessionStatus, Projektor2_Request $request, Projektor2_Response $response) {
        $this->sessionStatus = $sessionStatus;
        $this->request = $request;
        $this->response = $response;
    }
            
    public function getController() {
        
        // Udělátko pro spuštění testů. Každý test musí být kontroler.
        if ($this->request->get('akce') == 'test') {
            $testClassName = $this->request->get('testclass');
            return new $testClassName();
        }        
        
        //Volba akce
        switch ($this->sessionStatus->projekt->kod) {
            case "AGP":
                switch($this->request->get('akce')) {
                ///** AGP **/                
                    case "seznam":
                        $this->response->setCookie("id_zajemce");
                        return new Projektor2_Controller_AgpZobrazeniRegistraci($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "agp_export":
                        return new Projektor2_Controller_HelpExport($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "select_beh":
                        $this->response->setCookie("behId");
                        $this->response->setCookie("id_zajemce");
                        return  new Projektor2_Controller_VyberBehu($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "form":
                        $router = new Projektor2_Router_Form($this->sessionStatus, $this->request, $this->response);
                        return $router->getController();
                        break;
                    case "logout":
                        return new Projektor2_Controller_Logout($this->sessionStatus, $this->request, $this->response);
                        break;
                    default:
                        if(!$this->sessionStatus->beh->id) {
                            return new Projektor2_Controller_VyberBehu($this->sessionStatus, $this->request, $this->response);
                        } else {
                            return new Projektor2_Controller_AgpZobrazeniRegistraci($this->sessionStatus, $this->request, $this->response);
                        }                    
                }
                break;
            case "HELP":
                switch($this->request->get('akce')) {            
                /** HELP **/        
                    case "seznam":
                        $this->response->setCookie("id_zajemce");
                        return new Projektor2_Controller_HelpZobrazeniRegistraci($this->sessionStatus, $this->request, $this->response);
                        break;            
                    case "he_export":
                        return new Projektor2_Controller_HelpExport($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "select_beh":
                        $this->response->setCookie("behId");
                        $this->response->setCookie("id_zajemce");
                        return new Projektor2_Controller_VyberBehu($this->sessionStatus, $this->request, $this->response);
                        break;                        
                    case "form":
                        $router = new Projektor2_Router_Form($this->sessionStatus, $this->request, $this->response);
                        return $router->getController();
                        break;
                    case "logout":
                        return new Projektor2_Controller_Logout($this->sessionStatus, $this->request, $this->response);
                        break;
                    default:
                        if(!$this->sessionStatus->beh->id) {
                            return new Projektor2_Controller_VyberBehu($this->sessionStatus, $this->request, $this->response);
                        } else {
                            return new Projektor2_Controller_HelpZobrazeniRegistraci($this->sessionStatus, $this->request, $this->response);
                        }
                }
            break;
            case "AP":
                switch($this->request->get('akce')) {            
                /** AP **/        
                    case "seznam":
                        $this->response->setCookie("id_zajemce");
                        return new Projektor2_Controller_ApZobrazeniRegistraci($this->sessionStatus, $this->request, $this->response);
                        break;            
                    case "ap_export":
                        return new Projektor2_Controller_ApExport($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "select_beh":
                        $this->response->setCookie("behId");
                        $this->response->setCookie("id_zajemce");
                        return new Projektor2_Controller_VyberBehu($this->sessionStatus, $this->request, $this->response);
                        break;                        
                    case "form":
                        $router = new Projektor2_Router_Form($this->sessionStatus, $this->request, $this->response);
                        return $router->getController();
                        break;
                    case "logout":
                        return new Projektor2_Controller_Logout($this->sessionStatus, $this->request, $this->response);
                        break;
                    default:
                        if(!$this->sessionStatus->beh->id) {
                            return new Projektor2_Controller_VyberBehu($this->sessionStatus, $this->request, $this->response);
                        } else {
                            return new Projektor2_Controller_ApZobrazeniRegistraci($this->sessionStatus, $this->request, $this->response);
                        }
                }
            break;
        }

    }
}

?>
