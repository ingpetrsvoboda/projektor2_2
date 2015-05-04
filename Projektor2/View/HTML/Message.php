<?php
/**
 * Description of Chyby
 *
 * @author pes2704
 */
class Projektor2_View_HTML_Message extends Projektor2_View_Html_Base {

    public function render() {
        $htmlResult = "";
        if (isset($this->context['message'])) {
            $htmlResult .= '<div class="message">';
            $htmlResult .= '<h1>'.$this->context['message'].'</h1>';
            $htmlResult .= '</div>';
        }
        return $htmlResult;
    }
    
    public function display() {
        echo $this->render();
    }    
}

?>
