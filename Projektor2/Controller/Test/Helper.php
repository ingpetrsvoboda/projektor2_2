<?php
/**
 * Description of Helper
 *
 * @author pes2704
 */
class Projektor2_Controller_Test_Helper {
    //==== balíček funkcí pro testy ====================================================
    /**
     * Vrací textovou informaci o čase uplynulém od posledního volání této metody. Při prvním zavolání
     * (po instancování objektu helper) nastaví do interní proměnné počáteční čas a vrací informaci
     * o resetování intervalu.
     * @staticvar type $lasttime
     * @return string
     */
    public function interval() {
        static $lasttime;
        if ($lasttime)
        {
            $t = $this->microtime_float()-$lasttime;
            $lasttime = $this->microtime_float();
            return 'Interval: '.$t.' sec';
        } else {
            $t = 0;
            $lasttime = $this->microtime_float();
            return 'Reset interval';
        }

    }

    private function microtime_float() {
        list($usec, $sec) = explode(" ", microtime());
        return ((float)$usec + (float)$sec);
    }

    /**
     * vypíše výstup funkce interval(), zobrazí formátovaný html výpis obsahu funkce zadané jako parametr, funkci spustí
     * a po skončení běhu funkce vypíše výstup funkce interval().
     * @param callable $closure
     */
//    public function runTestFunction($className, $methodName) {
//        $oldBufferContent = ob_get_clean();
//        if ($oldBufferContent===FALSE) ob_start();
//        echo "<p >".interval()."</p>";
//        $html = $this->getMethodCode($closure);
//        echo "Kód: <br><pre class='kod'>".$html."</pre>";
//        $closure();
//        echo "<p >".interval()."</p>";
//        $html = ob_get_clean() ;
//        if ($oldBufferContent===FALSE) {
//            ob_end_clean(); //Clean (erase) the output buffer and turn off output buffering
//        } else {
//            ob_get_clean();
//            echo $oldBufferContent;
//        }
//    }

    /**
     * Vrací formátovaný html výpis obsahu funkce zadané jako parametr.
     * @param callable $closure
     */
    public function listTestMethod($className, $methodName) {
        $html = "Kód: <br><pre class='kod'>".$this->getMethodCode($className, $methodName)."</pre>";
        return $html;
    }
    
    /**
     * Vrací formátovaný html výpis obsahu funkce zadané jako parametr.
     * @param mixed $functionName Jméno (identifikátor) funkce (string) nebo proměnná typu callable
     * @param bool $highlightedHTML Pokud je TRUE, funkce vrací kód ve formátu HTML a se zvýrazněním pomocí PEAR třídy Text_Highlighter. Default TRUE.
     * @return string
     * @author http://stackoverflow.com/questions/7026690/reconstruct-get-code-of-php-function & Petr Svoboda
     */
    public function getMethodCode($className, $methodName, $highlightedHTML=TRUE, $complete=FALSE) {
        $func = new ReflectionMethod($className, $methodName);
        $filename = $func->getFileName();
        $start_line = $func->getStartLine() - 1; // it's actually - 1, otherwise you wont get the function() block
        $end_line = $func->getEndLine();
        $length = $end_line - $start_line;

        $source = file($filename);  // vrací pole, každá položka obsahuje jeden řádek souboru
        $code = implode("", array_slice($source, $start_line, $length));
    //    $body = htmlspecialchars($body);
        if ($highlightedHTML) {
    //        $options = array(
    //            'numbers' => HL_NUMBERS_LI,
    //            'tabsize' => 8,
    //        );
    //        $renderer = new Text_Highlighter_Renderer_HTML($options);
            $renderer = new Text_Highlighter_Renderer_HTML();
            $phpHighlighter = Text_Highlighter::factory('php');  /** 'php' funguje jen na kód začínající <?php a končící ?>   **/
            $phpHighlighter->setRenderer($renderer);

            $code = $phpHighlighter->highlight('<?php'.$code.'?>');  
            if ($complete) {
                // včetně klíčových slov (function) a jména funkce
                $code = str_replace('&lt;?php', '', $code);
                $code = str_replace('?&gt;', '', $code);
            } else {
                $startCode = strpos($code, '{')+1;
                $lengthCode = strrpos($code, '}')-$startCode;
                $code = substr($code, $startCode, $lengthCode);   
            }
            $code = '<div class="hl-main"><pre><span>'.$code.'</span></pre></div>';
        }
        return $code;
    }
    
}
