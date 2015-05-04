<?php
/**
 * Třída Projektor2_View_HTML_HeSmlouva zabaluje původní PHP4 kód do objektu. Funkčně se jedná o konponentu View, 
 * na základě dat předaných konstruktoru a šablony obsažené v metodě display() generuje HTML výstup
 *
 * @author pes2704
 */
class Projektor2_View_HTML_Ap_Export extends Projektor2_View_Html_Base {

    /**
     * Konstruktor
     */
    public function __construct() {

    }

    public function render() {
        $htmlResult .= "<h3>Export tabulkových přehledů</h3>";
        $htmlResult .= '<div class="left">
                                <ul id="menu">
                                    <hr>
                                    <li><a href="index.php?akce=select_beh">Zpět na výběr běhu</a></li>
                                    <li><a href="index.php?akce=seznam">Zpět na zobrazení registrací</a></li>';                                    
        $htmlResult .= '        </ul>
                        </div>';
        $htmlResult .= '<div class="content">';
            $htmlResult .= '
                            <form method="POST" action="index.php?akce=ap_export" name="vyber_tabulky">
                                  Databázové tabulky: <br>
                                <select ID="dbtabulka" size="1" name="dbtabulka">
                                <option >------------</option>
                                <option >v_ap_zajemci</option>
                                <option >v_ap_kurzy</option>
                                <option >v_ap_plan_kurzu</option>
                                </select><br>
                                <input type="submit" value="Export" name="E1">
                            </form>';
        $htmlResult .= '</div>';
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
