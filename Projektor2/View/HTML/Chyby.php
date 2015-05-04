<?php
/**
 * Description of Chyby
 *
 * @author pes2704
 */
class Projektor2_View_HTML_Chyby extends Projektor2_View_Html_Base {
    
    const H1 = 'Ve formuláři se vyskytly chyby !!';
    const H2 = 'Prosíme, pokuste se je odstranit a uložte formulář znovu';
    
    public function render() {
        $htmlResult = "";
        $htmlResult .= "<div id='chyby'>";
        $h1 = $this->context['h1'] ? $this->context['h1'] : self::H1;
        $h2 = $this->context['h2'] ? $this->context['h2'] : self::H2;
        $htmlResult .= "<h1>".$h1."</h1>";
        $htmlResult .= "<br><h2>".$h2."</h2>";
        $htmlResult .= "<br>";     
        if ($this->context['info']) $htmlResult .= "<hr>".$this->context['info']."<br>";  
        $chyby = $this->context['chyby'];
        if ($chyby->pocet) {
            $htmlResult .= "<table border='1'>";       
            $htmlResult .= "<tr><td>Položka</td><td>Hodnota</td><td>Chyba</td><td>Popis chyby</td></tr>";
            for($i=0; $i<$chyby->pocet; $i++) {
                $hodnota = $chyby->hodnota[$i];
                if (!is_scalar($hodnota)) {
                    if (is_object($hodnota)) {
                        $hodnota = "";
                        if (is_a($hodnota, "Projektor2_Datum")) $hodnota = $hodnota->f_web;
                    } else {
                        $hodnota = "";
                    }                
                }
                $htmlResult .= "<tr>\n";
                $htmlResult .= "<td>".  $chyby->promnenna[$i]."&nbsp;</td>\n";
                $htmlResult .= "<td>".$hodnota."&nbsp;</td>\n";
                $htmlResult .= "<td>".$chyby->chyba_cislo[$i]."&nbsp;</td>\n";
                $htmlResult .= "<td>".$chyby->chyba_text[$i]."&nbsp;</td>\n";
                $htmlResult .= "</tr>\n";
            }
            $htmlResult .= "</table>";  
            $htmlResult .= "</div>";
        }
        return $htmlResult;
    }
    
    public function display() {
        echo $this->render();
    }    
}

?>
