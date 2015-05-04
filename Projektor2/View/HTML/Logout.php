<?php
/**
 * Třída Projektor2_View_HTML_HeSmlouva zabaluje původní PHP4 kód do objektu. Funkčně se jedná o konponentu View, 
 * na základě dat předaných konstruktoru a šablony obsažené v metodě display() generuje HTML výstup
 *
 * @author pes2704
 */
class Projektor2_View_HTML_Logout extends Projektor2_View_Html_Base {

    public function render() {
        $htmlResult = '<form name="Logout" ID="Logout" action="index.php?akce=logout" method="post">
                           <input type="Submit" value="Odhlásit">
                       </form>';
        return $htmlResult;
    }

    /**
     * Metoda generuje přímo html výstup. Metoda nemá návratovou hodnotu.
     */
    public function display() {
        echo $this->render();
    }
}

?>
