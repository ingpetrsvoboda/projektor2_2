<?php
class Projektor2_View_HTML_Footer extends Projektor2_View_Html_Base {
    
    public function __construct() {
    }
    
    public function render() {
        $htmlResult = "";
        $htmlResult .= '<div class="footer">';
        $htmlResult .= '</div>'; 
        return $htmlResult;
    }
    
    public function display() {
        echo $this->render();
    }    
}

?>
