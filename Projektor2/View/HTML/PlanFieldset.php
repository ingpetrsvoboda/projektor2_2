<?php
/**
 * Description of Projektor2_View_HTML_PlanFieldset
 *
 * @author pes2704
 */
class Projektor2_View_HTML_PlanFieldset {

    const READONLY_NAME_PREFIX = "readonly_";  //tento prefix se připojí před jména všech readonly proměnných ve formuláři
    const MULTI_SELECTED_VARIABLE_PREFIX = 'multiselect';

    /**
     * Jednoúčelová funkce vázaná na strukturu tabulky za_plan_flat_table.
     * Renderuje pole formuláře (fieldset) s údaji pro jeden kurz. Očekává strukturu dat z tabulky za_plan_flat_table,
     * zejména předpokládá správně pojmenované proměnné v contextu.
     * Při nastavení readonly=TRUE se před jména všech readonly proměnných ve formuláři připojí  prefix. Jména proměnných v requestu post 
     * po odeslání formuláře jsou tak změněna a nedojde k pokusu o uložení hodnot takových proměnných do databáze. 
     * @param array $context View kontext.
     * @param string $druh Druh kurzu - je použit zcela specificky v souladu s použitím ve flat table za_plan_flat_table.
     * @param array $modelsArray Pole objektů (modelů) pro vygenerování selectu.
     * @param string $returnedModelProperty Název vlastnosti objektů (modelů) použité pro nastavení návratových hodnot selectu.
     * @param string $nadpis Použit jako legend fieldsetu.
     * @param boolean $readonly Nastavení na TRUE uvede včechny elementy input do stavu readonly nebo disabled a navíc ještě změní názvy post proměnných připojením prefixu zadaného konstantou READONLY_NAME_PREFIX
     * @param type $kurzSCertifikatem Nstavení na TRUE způsobí zobrazení pole pro zadání datumu vydání certifikátu.
     * @return string HTML kód fieldsetu
     */   
    public static function renderFieldsetKurz($context, $druh, $modelsArray, $returnedModelProperty=NULL, $nadpis, $readonly=FALSE, $kurzSCertifikatem=FALSE) {
        if ($readonly) {
            $readonlyAttribute = ' readonly="readonly" ';
            $disabledAttribute = ' disabled="disabled" ';
            $readonlyNamePrefix = self::READONLY_NAME_PREFIX;
        }
        $checkedAttribute = ' checked="checked" ';
        $fieldsetElement = "<FIELDSET><LEGEND>".$nadpis."</LEGEND>";   
        $fieldsetElement .= 
                "<p>"
                .$nadpis.": ".self::htmlSelectCode($context, 'id_s_kurz_'.$druh.'_FK', $modelsArray, "id", 'self::text_retezec_kurz', $readonly)
                ."</p>";
        $fieldsetElement .= 
                "<p>Počet absolvovaných hodin: "
                . "<input ID='".$druh."_poc_abs_hodin' type='number' pattern='\d+' name='".$readonlyNamePrefix.$druh."_poc_abs_hodin' "
                . "size='8' maxlength='10' value='".$context[$druh.'_poc_abs_hodin']."' ".$readonlyAttribute."></p>";
        $fieldsetElement .= 
                "<p>V případě, že neabsolvoval plný počet hodin, uveďte proč: "
                . "<input ID='".$druh."_duvod_absence' type='text' name='".$readonlyNamePrefix.$druh."_duvod_absence' size='120' maxlength='120' "
                . "value='".$context[$druh.'_duvod_absence']."' ".$readonlyAttribute."></p>";
        $fieldsetElement .= 
                "<p>Dokončeno úspěšně: "
                . "<input ID='".$druh."_dokoceno_uspech' type='radio' name='".$readonlyNamePrefix.$druh."_dokonceno' value='Ano' ";
                if ($context[$druh.'_dokonceno'] == 'Ano') {
                    $fieldsetElement .= $checkedAttribute;
                } else {
                    $fieldsetElement .= $disabledAttribute;                    
                }
                $fieldsetElement .=">";
        $fieldsetElement .="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dokončeno neúspěšně:"
                    . "<input ID='".$druh."_dokoceno_neuspech' type='radio' name='".$readonlyNamePrefix.$druh."_dokonceno' value='Ne' ";
                if ($context[$druh.'_dokonceno'] == 'Ne') {
                    $fieldsetElement .= $checkedAttribute;
                } else {
                    $fieldsetElement .= $disabledAttribute;                 
                }
                $fieldsetElement .="></p>";
        $fieldsetElement .="<p>Při neúspěšném ukončení - důvod: "
                . "<input ID='".$druh."_duvod_neukonceni' type='text' name='".$readonlyNamePrefix.$druh."_duvod_neukonceni' size='120' maxlength='120' "
                . "value='".$context[$druh.'_duvod_neukonceni']."' ".$readonlyAttribute."></p>";
        if ($kurzSCertifikatem) {
            $fieldsetElement .="<p>Datum vydání osvědčení: "
                    . "<input ID='".$readonlyNamePrefix.$druh."_datum_certif' ";
            if ($readonly) {
                $fieldsetElement .=" type='text' ";
            } else {
                $fieldsetElement .=" type='date' ";
            }
            $fieldsetElement .=" name='".$readonlyNamePrefix.$druh."_datum_certif' size='8' maxlength='10' "
                    . "value='".$context[$druh.'_datum_certif']."' ".$readonlyAttribute."></p>";
        }
        $fieldsetElement .="</FIELDSET>   "; 
        return $fieldsetElement;        
    }
    
    /**
     * Při nastavení readonly=TRUE se před jména všech readonly proměnných ve formuláři připojí  prefix. Jména proměnných v requestu post 
     * po odeslání formuláře josu tak změněna a nedojde k pokusu o uložení hodnot takových proměnných do databáze.
     * @param type $pole
     * @param type $druh
     * @param type $aktivita
     * @param type $readonly
     * @return string
     */
    public static function renderFieldsetHodnoceni($pole, $druh, $modelsArray, $returnedModelProperty, $nadpis, $help, $readonly=FALSE, $kurzSCertifikatem=FALSE) {
        if ($readonly) {
            $readonlyAttribute = ' readonly="readonly" ';
            $disabledAttribute = ' disabled="disabled" ';
            $readonlyNamePrefix = self::READONLY_NAME_PREFIX;
        }
        $fieldsetElement = "<FIELDSET><LEGEND>".$nadpis."</LEGEND>";  
        if ($aktivita['typ']=='kurz') {
            $fieldsetElement .= "<div class=readonly>";
            $fieldsetElement .= self::renderFieldsetKurz($context, $druh, $modelsArray, $returnedModelProperty, $readonly, $kurzSCertifikatem);
            $fieldsetElement .= "</div>";
        }
        $fieldsetElement .= "<p><input ID='".$druh."_znamka' type='number' name='".$readonlyNamePrefix.$druh."_znamka' size=1 maxlength=1 value='".$pole[$druh.'_znamka']."' ".$readonlyAttribute.">"; 
        $fieldsetElement .= "<span class='help'> (zde uveďte známku hodnotící účast od 1 do 5 jako ve škole - známka je pro interní použití)</span></p>";
        $fieldsetElement .= "<p><textarea ID='".$druh."_hodnoceni' name='".$druh."_hodnoceni' cols=100 rows=3>".$pole[$druh.'_hodnoceni']."</textarea> 
                            <span class='help'> (zde uveďte slovní hodnocení účasti - pro individuální plán)<br>"
                           . $help
                        ."</span>
                          </p>";
        
        $fieldsetElement .="</FIELDSET>   "; 
        return $fieldsetElement;        
    }
    
    public static function renderFieldsetPoradenstvi($context, $contextIndexName, $modelsArray, $returnedModelProperty=NULL, $nadpis, $readonly=FALSE, $poradenstviSHodnocenim=FALSE, $poradenstviSCertifikatem=FALSE) {
        if ($readonly) {
            $readonlyAttribute = ' readonly="readonly" ';
            $disabledAttribute = ' disabled="disabled" ';
            $readonlyNamePrefix = self::READONLY_NAME_PREFIX;
        }
        $checkedAttribute = ' checked="checked" ';
        $fieldsetElement = "<FIELDSET><LEGEND>".$nadpis."</LEGEND>";   
        $fieldsetElement .= self::htmlCheckboxesGridCode($context, $contextIndexName, $modelsArray, $returnedModelProperty, 'self::text_retezec_kurz', $readonly);
        if (count($modelsArray)) {
            if ($poradenstviSHodnocenim) {
                $fieldsetElement .= "<p>Počet absolvovaných hodin: "
                        . "<input ID='poc_abs_hodin' type='number' pattern='\d+' name='".$readonlyNamePrefix."poc_abs_hodin' "
                        . "size='8' maxlength='10' value='".$context['poc_abs_hodin']."' ".$readonlyAttribute."></p>";
                $fieldsetElement .= "<p>V případě, že neabsolvoval plný počet hodin, uveďte proč: "
                        . "<input ID='duvod_absence' type='text' name='".$readonlyNamePrefix."duvod_absence' size='120' maxlength='120' "
                        . "value='".$context['duvod_absence']."' ".$readonlyAttribute."></p>";
                $fieldsetElement .= "<p>Dokončeno úspěšně: "
                        . "<input ID='dokoceno_uspech' type='radio' name='".$readonlyNamePrefix."dokonceno' value='Ano' ";
                    if ($context['dokonceno'] == 'Ano') {
                        $fieldsetElement .= $checkedAttribute;
                    } else {
                            $fieldsetElement .= $disabledAttribute;                    
                    }
                    $fieldsetElement .=">";
                    $fieldsetElement .="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dokončeno neúspěšně:"
                            . "<input ID='dokoceno_neuspech' type='radio' name='".$readonlyNamePrefix."dokonceno' value='Ne' ";
                    if ($context['dokonceno'] == 'Ne') {
                        $fieldsetElement .= $checkedAttribute;
                    } else {
                        $fieldsetElement .= $disabledAttribute;                 
                    }
                    $fieldsetElement .="></p>";
                $fieldsetElement .="<p>Při neúspěšném ukončení - důvod: "
                        . "<input ID='duvod_neukonceni' type='text' name='".$readonlyNamePrefix."duvod_neukonceni' size='120' maxlength='120' "
                        . "value='".$context['duvod_neukonceni']."' ".$readonlyAttribute."></p>";
            }
            if ($poradenstviSCertifikatem) {
                $fieldsetElement .="<p>Datum vydání osvědčení: "
                        . "<input ID='".$readonlyNamePrefix."datum_certif' ";
                if ($readonly) {
                    $fieldsetElement .=" type='text' ";
                } else {
                    $fieldsetElement .=" type='date' ";
                }
                $fieldsetElement .=" name='".$readonlyNamePrefix."datum_certif' size='8' maxlength='10' "
                        . "value='".$context['datum_certif']."' ".$readonlyAttribute."></p>";
            }
        }
        $fieldsetElement .="</FIELDSET>   "; 
        return $fieldsetElement;        
    }
     
    /**
     * 
     * @param array $context View kontext. Pokud je proměnná nastavovaná v selectu v view kontextu již nastavena, pak se příslušná položka selectu (option) automaticky označí jako selected.
     * @param string $contextIndexName Kam se dá výsledek - název proměnné POST, ve které je vracena vybraná hodnota a současně index pole $context, který určuje proměnnou kontextu, použitou pro určení, která položka se má označit jako "selected".. 
     * @param array $valuesArray Pole hodnot. Z čeho se vybírá - pokud jsou jednotlivé hodnoty pole skalární použijí se, pokud jsou to objekty, použije vždy vlastnost objektu zadaná parametrem $valueObjectProperty.
     * @param string $valueObjectProperty Název vlastnosti objektů $valuesArray, která se použije jako návratová hodnota.
     * @param callable $innerTextCallable Callback funkce používaná pro nastavení textového (zobrazovaného) obsahu jednotlivých option v selectu.
     * @param boolean $readonly Určuje zda je celý select readonly.
     * @return string HTML kód selectu
     */
    private static function htmlSelectCode($context, $contextIndexName, $valuesArray, $valueObjectProperty=NULL, $innerTextCallable=NULL, $readonly=FALSE) {
 // self::htmlSelectCode($context, 'id_s_kurz_'.$druh.'_FK', $context['kurzy_'.$druh], "id", 'self::text_retezec_kurz', $readonly)

        if ($readonly) {
            $disabledAttribute = ' disabled="disabled" ';
            $readonlyNamePrefix = self::READONLY_NAME_PREFIX;
        }
        $html = '<select size="1" name="'.$readonlyNamePrefix.$contextIndexName.'" '.$disabledAttribute.'>';
        if ($valuesArray) {
            foreach ($valuesArray as $value) {
            $html .= '<option ';
            if (is_object($value)) {
                if (isset($context[$contextIndexName]) AND $context[$contextIndexName] == $value->$valueObjectProperty) {
                    $html .= 'selected="selected"';
                }
                $html .= ' value='.$value->$valueObjectProperty.'>';
            } else {
                if (isset($context[$contextIndexName]) AND $context[$contextIndexName] == $value) {
                    $html .= 'selected="selected"';
                }
                $html .= ' value='.$value.'>';                
            }
            $html .= call_user_func($innerTextCallable, $value).'</option>';
        }
        }
        $html.= '</select>';
        return $html;
    }    
    /**
     * 
     * @param array $context View kontext. Pokud je proměnná nastavovaná v selectu v view kontextu již nastavena, pak se příslušná položka selectu (option) automaticky označí jako selected.
     * @param string $contextIndexName Kam se dá výsledek - parametr je použit jako prefix názvu proměnných POST, ve kterých jsou vraceny vybrané hodnoty a současně jako index pole $context, 
     *              který určuje proměnnou kontextu zypu pole, použitou pro určení, které položky se mají označit jako "selected".
     *              Názvy proměnných POST, ve kterých jsou vraceny vybrané hodnoty jsou tvořeny prefixem $index a pořadovým číslem proměnné, číslování začíná 0.
     *              Proměnné v kontextu jsou uloženy jako číslované pole s názvem shodným s parametrem. Např. pro dva checkboxy v POST jsou hodnota0 a hodnota1 
     *              a v poli context je položka $context['hodnota'], která je typu pole, má dva prvky číslovaní '0' a '1'.
     * @param array $valuesArray Pole hodnot. Z čeho se vybírá - pokud jsou jednotlivé hodnoty pole skalární použijí se, pokud jsou to objekty, použije vždy vlastnost objektu zadaná parametrem $valueObjectProperty.
     * @param string $valueObjectProperty Název vlastnosti objektů $valuesArray, která se použije jako návratová hodnota.
     * @param callable $innerTextCallable Callback funkce používaná pro nastavení textu zobrazovaného u jednotlivých checkboxů.
     * @param boolean $readonly Určuje zda je celý select readonly.
     * @return string HTML kód selectu
     */
    private static function htmlCheckboxesGridCode($context, $contextIndexName, $valuesArray, $valueObjectProperty=NULL, $innerTextCallable=NULL, $readonly=FALSE) {

        if ($readonly) {
            $disabledAttribute = ' disabled="disabled" ';
            $readonlyNamePrefix = self::READONLY_NAME_PREFIX;
        }
        $html = '<ul class="checkbox-grid">';
        if ($valuesArray) {
            foreach ($valuesArray as $key => $value) {
            $html .= '<li><input type="checkbox" name="'.$readonlyNamePrefix.$contextIndexName.'->'.self::MULTI_SELECTED_VARIABLE_PREFIX.$key.'" '.$disabledAttribute.' ';                
            if (is_object($value)) {
                if (isset($context[$contextIndexName][$key]) AND $context[$contextIndexName][$key] == $value->$valueObjectProperty) {
                    $html .= 'selected="selected"';
                }
                $html .= ' value='.$value->$valueObjectProperty.'>';
            } else {
                if (isset($context[$contextIndexName][$key]) AND $context[$contextIndexName][$key] == $value) {
                    $html .= 'selected="selected"';
                }
                $html .= ' value='.$value.'></li>';                
            }
            $html .= call_user_func($innerTextCallable, $value);
        }
        }
        $html.= '</ul>';
        return $html;
    }    
        
    /**
     * Callback funkce volaná při použití metody htmlSelectCode().
     * @param Projektor2_Model_SKurz $kurz
     * @return string
     */
    private static function text_retezec_kurz(Projektor2_Model_SKurz $kurz) {
        if ($kurz->kurz_zkratka == '*') {
            $ret = $kurz->kurz_nazev;
        } else {
            $ret = trim($kurz->projekt_kod). "_" .trim($kurz->kurz_druh). "_" . trim($kurz->kurz_cislo) . "_".
                    trim($kurz->beh_cislo) . "T_" . trim($kurz->kurz_zkratka). " | ".
                    trim($kurz->kurz_nazev)." | ".trim($kurz->date_zacatek)." - ".trim($kurz->date_konec). " | " . trim($kurz->kancelar_kod);
        }
        return $ret;
    }
}
