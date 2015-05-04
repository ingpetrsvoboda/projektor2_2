<?php
/**
 * Description of Projektor2_Controller_Formular_Base
 *
 * @author pes2704
 */
abstract class Projektor2_Controller_Formular_Ap_Menus extends Projektor2_Controller_Formular_Base {
    protected function getLeftMenu() {
        $leftMenuController = new Projektor2_Controller_ApLeftMenu($this->sessionStatus, $this->request, $this->response);
        $htmlResult .= $leftMenuController->getResult();
        return $htmlResult;
    }

    protected function getContentMenu() {
        // nezobrazuje se pro novou osobu
        if ($this->sessionStatus->zajemce) {
            $contentMenuController = new Projektor2_Controller_ApContentMenu($this->sessionStatus, $this->request, $this->response);
            $htmlResult .= $contentMenuController->getResult();
        }
        return $htmlResult;
    }
}

?>
