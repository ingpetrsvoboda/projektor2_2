<?php
/**
 * Description of Projektor2_Controller_ZobrazeniRegistraci
 *
 * @author pes2704
 */
class Projektor2_Controller_HelpZobrazeniRegistraci implements Projektor2_Controller_ControllerInterface {

    
// !!! Konstanty i pro staré projekty a zájemce !!!!!!!!!!!
    const FORMULAR_PLAN = ind_plan_uc;
    const FORMULAR_ZAM = ind_zam_uc;
    const FORMULAR_UKONC = ind_ukonc_uc;
    const FORMULAR_REG_DOT = ind_reg_dot;

    const FORMULAR_ZOBRAZ = ind_zobraz_reg;

    const FORMULAR_HE_PLAN = he_ind_plan_uc;
    const FORMULAR_HE_ZAM = he_ind_zam_uc;
    const FORMULAR_HE_UKONC = he_ind_ukonc_uc;
    const FORMULAR_HE_REG_DOT = he_ind_reg_dot;
    
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
        $htmlResult .= "<h3>Zobrazeni registrací</h3>";
        $htmlResult .= '<div class="left">
                                <ul id="menu">
                                    <li><a href="index.php?akce=select_beh">Zpět na výběr běhu</a></li>
                                    <li><a href="index.php?akce=form&form=he_novy_zajemce">Nová osoba</a></li>';
        if ( ($this->sessionStatus->user->username == "sys_admin" OR $this->sessionStatus->user->username == "he_manager")) {
            $htmlResult .= '        <li><a href="index.php?akce=he_export">Exportuj přehled</a></li>';
        }	
                                    
        $htmlResult .= '        </ul>
                        </div>';
        $htmlResult .= '<div class="content">';
        $htmlResult .= '<div ID="zaznamy">';

        $zajemciRegistrace = Projektor2_Model_ZajemceRegistraceMapper::findAll();
        $htmlResult .= '<table>';
        if ($zajemciRegistrace) {
            foreach ($zajemciRegistrace as $zajemceRegistrace) {
                $params = array('id' => $zajemceRegistrace->id);
                $tlacitkaController = new Projektor2_Controller_HelpTlacitkaMenu($this->sessionStatus, $this->request, $this->response, $params);
                $htmlResult .= $tlacitkaController->getResult($this->sessionStatus->zajemce->id);
            }
        }
        $htmlResult .= '</table>';
        $htmlResult .= '</div>';
        $htmlResult .= '</div>';
        return $htmlResult;
    }
}

?>
