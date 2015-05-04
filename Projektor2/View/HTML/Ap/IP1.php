<?php
/**
 * Třída Projektor2_View_HTML_HeSmlouva zabaluje původní PHP4 kód do objektu. Funkčně se jedná o konponentu View, 
 * na základě dat předaných konstruktoru a šablony obsažené v metodě display() generuje HTML výstup
 *
 * @author pes2704
 */
class Projektor2_View_HTML_Ap_IP1 extends Projektor2_View_HTML_FormularPHP4 {
    /**
     * Metoda obsahuje php kod (ve stylu PHP4), který užívá PHP jako šablonovací jazyk. Na základě dat zadaných v konstruktoru 
     * do paramentru $context metoda generuje přímo html výstup. Metoda nemá návratovou hodnotu.
     */
    public function display() {
        $pole = $this->context;
        // nadpis je v původním kódu někde v inc - přesunout nadpisy vždy sem
        echo '<H3>INDIVIDUÁLNÍ PLÁN ÚČASTNÍKA PROJEKTU Alternativní práce</H3>';
        echo '<form method="POST" action="index.php?akce=form&form=ap_ip1_uc" name="form_ip1">';
               
        
     //dále následuje původní kód 
?>

<br>
<p>Datum vytvoření:
    <input ID="datum_vytvor_dok" type="date" name="datum_vytvor_dok_plan" size="8" maxlength="10" value="<?php
                                        if (@$pole['datum_vytvor_dok_plan']) {echo @$pole['datum_vytvor_dok_plan'];}
                                        else {echo $pole['datum_vytvor_dotazniku']; }
                                        ?>">
</p>
<p>
    <input type="submit" value="Uložit" name="save">&nbsp;&nbsp;&nbsp;
</p>
<?php
    //TISK
    if ($pole['id_zajemce']){
        echo ('<p><input type="submit" value="Tiskni IP 1.část" name="pdf">&nbsp;&nbsp;&nbsp;</p> ');        
    }
?>
</form>
<?php        
    }
}
?>
