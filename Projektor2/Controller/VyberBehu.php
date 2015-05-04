<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of VyberBehu
 *
 * @author pes2704
 */
class Projektor2_Controller_VyberBehu implements Projektor2_Controller_ControllerInterface {

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
        $dbh = Projektor2_AppContext::getDB();
        $this->response->setCookie("beh_id");
        /** CONTEXT **/
        $htmlResult .= '<div id="select_beh">';
        $htmlResult .= '<h2>Výběr běhu</h2>
            <form name="Beh" ID="Beh" action="index.php" method="post">
            <input type="hidden" name="akce" value="zobraz_reg">
            <label for="beh" >Vyberte běh projektu:</label>
            <select ID="beh" size="1" name="beh">';
        
        $behy = Projektor2_Model_BehMapper::findAll();    
        foreach ($behy as $beh) {
            $htmlResult .= "<option value=\"".$beh->id."\">".$beh->text."</option>\n";            
        }
        
        $htmlResult .= '
            </select>
            <br><br>
            <input type="submit" value="Zobrazit registrace">
            </form>';
        $htmlResult .= '</div>';
        /** /CONTEXT **/
        return $htmlResult;
    }
}

?>
