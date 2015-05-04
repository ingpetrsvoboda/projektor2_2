<?php
/**
 * Třída Projektor2_View_HTML_HeSmlouva zabaluje původní PHP4 kód do objektu. Funkčně se jedná o konponentu View, 
 * na základě dat předaných konstruktoru a šablony obsažené v metodě display() generuje HTML výstup
 *
 * @author pes2704
 */
class Projektor2_View_HTML_Logo extends Projektor2_View_Html_Base {

    public function render() {
        switch ($this->context['kodProjektu']) {
            case "NSP":
                $nadpis = 'PROJEKT NAJDI SI PRÁCI V PLZEŇSKÉM KRAJI';
                $src = "logoNSP.gif";
                $alt = "Logo projektu Najdi si práci";
                break;
            case "PNP":
                $nadpis = 'PROJEKT PŘÍPRAVA NA PRÁCI V PLZEŇSKÉM KRAJI';
                $src = "logoPNP.gif";
                $alt = "Logo projektu Příprava na práci";
                break;
            case "SPZP":
                $nadpis = 'PROJEKT S POMOCÍ ZA PRACÍ';
                $src = "logo_spzp.jpg";
                $alt = "Logo projektu S pomocí za prací";
                break;
            case "RNH":
                $nadpis = 'PROJEKT RODINA NENÍ HANDICAP';
                $src = "logo_rnh.jpg";
                $alt = "Logo projektu Rodina není handicap";
                break;
            case "RNH":
                $nadpis = 'PROJEKT RODINA NENÍ HANDICAP';
                $src = "logo_rnh.jpg";
                $alt = "Logo projektu Rodina není handicap";
                break;
            case "AGP":
                $nadpis = 'AGENTURA PRÁCE';
                $src = "logo_agp.png";
                $alt = "Logo Personal Service";
                break;
            case "HELP":
                $nadpis = 'PROJEKT HELP50+';
                $src = "logo_Help50.png";
                $alt = "Logo projektu Help50+";
                break;
            case "AP":
                $nadpis = 'PROJEKT ALTERNATIVNÍ PRÁCE';
                $src = "logo_AP.png";
                $alt = "Logo projektu Alternativní práce v Plzeňském kraji";
                break;
            default:
                break;
        }
        $path = "./img/loga/";
        $htmlResult = '<div id="logo_projektu"><h1>'.$nadpis.'</h1>
            <img src='.$path.$src.' alt='.$alt.'></div>';
        
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
