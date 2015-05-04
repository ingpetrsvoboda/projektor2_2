<?php
/**
 * Description of Projektor2_Controller_ZobrazeniRegistraci
 *
 * @author pes2704
 */
class Projektor2_Controller_ApTlacitkaMenu implements Projektor2_Controller_ControllerParamsInterface {

    
// !!! Konstanty i pro staré projekty a zájemce !!!!!!!!!!!
    const FORMULAR_PLAN = ind_plan_uc;
    const FORMULAR_ZAM = ind_zam_uc;
    const FORMULAR_UKONC = ind_ukonc_uc;
    const FORMULAR_REG_DOT = ind_reg_dot;

    const FORMULAR_ZOBRAZ = ind_zobraz_reg;

    const FORMULAR_AP_PLAN = ap_ind_plan_uc;
    const FORMULAR_AP_ZAM = ap_ind_zam_uc;
    const FORMULAR_AP_UKONC = ap_ind_ukonc_uc;
    const FORMULAR_AP_REG_DOT = ap_ind_reg_dot;
    
    protected $sessionStatus;
    protected $request;
    protected $response;
    protected $params;
    
    public function __construct(Projektor2_SessionStatus $sessionStatus, Projektor2_Request $request, Projektor2_Response $response, array $params=array()) {
        $this->sessionStatus = $sessionStatus;
        $this->request = $request;
        $this->response = $response;
        $this->params = $params;
    }
     
     public function getResult() {         
        $htmlResult = '';
        if (isset($this->params['id'])) {

            $zajemceRegistrace = Projektor2_Model_ZajemceRegistraceMapper::findById($this->params['id']);
            $zajemce = Projektor2_Model_ZajemceMapper::findById($zajemceRegistrace->id);
            $zaPlanFlatTable = new Projektor2_Model_Flat_ZaPlanFlatTable($zajemce);
//            $zaPlanFlatTable->read_values();            
            $zaUkoncFlatTable = new Projektor2_Model_Flat_ZaUkoncFlatTable($zajemce);
//            $zaUkoncFlatTable->read_values();
            $zaZamFlatTable = new Projektor2_Model_Flat_ZaZamFlatTable($zajemce);
//            $zaZamFlatTable->read_values();
            
            $htmlResult .= '<tr>';
            $htmlResult .= '<td class=identifikator>' . $zajemceRegistrace->identifikator . '</td>';
            $htmlResult .= '<td class=identifikator>' . $zajemceRegistrace->znacka . '</td>';
            
//            $htmlResult .= '<td class=jmeno>' . $zaznam['jmeno_cele'].'</td>';
            $htmlResult .= '<td class=jmeno>' . $zajemceRegistrace->jmeno_cele.'</td>';
            //smlouva
            if ($this->sessionStatus->user->tl_ap_sml) {
                $htmlResult .= "<td class='editace'><a title='editace' href=\"index.php?akce=form&form=ap_sml_uc&id_zajemce="
                            .$zajemceRegistrace->id."\">"."Smlouva</a></td>";
            }
            //souhlas se zpracováním osobních údajů
            if ($this->sessionStatus->user->tl_ap_souhlas) {
                $htmlResult .= "<td class='editace'><a title='editace' href=\"index.php?akce=form&form=ap_souhlas_uc&id_zajemce="
                            .$zajemceRegistrace->id."\">"."Souhlas</a></td>";
            }	
            //registrační dotazník
            if ($this->sessionStatus->user->tl_ap_dot) {
                //KOLIZE
                if (Projektor2_Table_UcKolizeData::Najdi_kolize_pro_formular($zajemceRegistrace->id, self::FORMULAR_AP_REG_DOT)  and
                Projektor2_Table_UcKolizeData::$nastava_kolize_ve_zjistovanych ) {
                    $htmlResult .= "<td class='editace_kolize'><a title='editace - opravte chyby' "; 
                }   elseif ($zajemceRegistrace->vyplneno_vzdelani) {
                        $htmlResult .= "<td class='editace'><a title='editace' ";
                    } else {
                        $htmlResult .= "<td class='novy'><a title='nový' ";
                    }
                $htmlResult .= " href=\"index.php?akce=form&form=ap_reg_dot&id_zajemce="
                            .$zajemceRegistrace->id."\">"."Dotazník"."</a>";
                $htmlResult .= "</td>";                    
            }
            //IP1
            if ($this->sessionStatus->user->tl_ap_ip1) {
                //KOLIZE
                if (Projektor2_Table_UcKolizeData::Najdi_kolize_pro_formular($zajemceRegistrace->id, self::FORMULAR_AP_PLAN)
                    AND
                    Projektor2_Table_UcKolizeData::$nastava_kolize_ve_zjistovanych ) {
                    $htmlResult .= "<td class='editace_kolize'><a title='' "; 
                }   elseif ($zaPlanFlatTable->vyplneny_kurzy) {
                        $htmlResult .= "<td class='editace'><a title='editace' ";
                    } else {
                        $htmlResult .= "<td class='novy'><a title='nový' ";
                    }
                $htmlResult .= " href=\"index.php?akce=form&form=ap_ip1_uc&id_zajemce="
                            .$zajemceRegistrace->id."\">"."IP1"."</a>";
                $htmlResult .= "</td>";        
            }
            //plan
            if ($this->sessionStatus->user->tl_ap_plan) {
                //KOLIZE
                if (Projektor2_Table_UcKolizeData::Najdi_kolize_pro_formular($zajemceRegistrace->id, self::FORMULAR_AP_PLAN)
                    AND
                    Projektor2_Table_UcKolizeData::$nastava_kolize_ve_zjistovanych ) {
                    $htmlResult .= "<td class='editace_kolize'><a title='' "; 
                }   elseif ($zaPlanFlatTable->vyplneny_kurzy) {
                        $htmlResult .= "<td class='editace'><a title='editace' ";
                    } else {
                        $htmlResult .= "<td class='novy'><a title='nový' ";
                    }
                $htmlResult .= " href=\"index.php?akce=form&form=ap_plan_uc&id_zajemce="
                            .$zajemceRegistrace->id."\">"."Plán kurzů"."</a>";
                $htmlResult .= "</td>";        
            }
            //plan kurzy a poradenstvi
            if ($this->sessionStatus->user->tl_ap_plan) {
                //KOLIZE
                if (Projektor2_Table_UcKolizeData::Najdi_kolize_pro_formular($zajemceRegistrace->id, self::FORMULAR_AP_PLAN)
                    AND
                    Projektor2_Table_UcKolizeData::$nastava_kolize_ve_zjistovanych ) {
                    $htmlResult .= "<td class='editace_kolize'><a title='' "; 
                }   elseif ($zaPlanFlatTable->vyplneny_kurzy) {
                        $htmlResult .= "<td class='editace'><a title='editace' ";
                    } else {
                        $htmlResult .= "<td class='novy'><a title='nový' ";
                    }
                $htmlResult .= " href=\"index.php?akce=form&form=ap_porad_uc&id_zajemce="
                            .$zajemceRegistrace->id."\">"."Plán kurzů a poradenství"."</a>";
                $htmlResult .= "</td>";        
            }
            //ukonceni
            if ($this->sessionStatus->user->tl_ap_ukon) {
                //KOLIZE
                if (Projektor2_Table_UcKolizeData::Najdi_kolize_pro_formular($zaznam['id_zajemce'], self::FORMULAR_AP_UKONC) and
                    Projektor2_Table_UcKolizeData::$nastava_kolize_ve_zjistovanych ) {
                    $htmlResult .= "<td class='editace_kolize'><a title='' "; 
                }   elseif ($zaUkoncFlatTable->duvod_ukonceni) {
                        $htmlResult .= "<td class='editace'><a title='editace' ";
                    } else {
                        $htmlResult .= "<td class='novy'><a title='nový' ";
                    }
                $htmlResult .= " href=\"index.php?akce=form&form=ap_ukonceni_uc&id_zajemce=".$zajemceRegistrace->id."\">"
                            ."Ukončení IP2"."</a></td>";
            }
            //zamestnani
            if ($this->sessionStatus->user->tl_ap_zam) { 
                //KOLIZE
                if (Projektor2_Table_UcKolizeData::Najdi_kolize_pro_formular($zaznam['id_zajemce'], self::FORMULAR_AP_ZAM) and
                    Projektor2_Table_UcKolizeData::$nastava_kolize_ve_zjistovanych ) {
                    $htmlResult .= "<td class='editace_kolize'><a title='' "; 
                }   elseif ($zaZamFlatTable->zam_datum_vstupu AND $zaZamFlatTable->zam_nazev AND $zaZamFlatTable->zam_ic) {
                        $htmlResult .= "<td class='editace'><a title='editace' ";
                    } else {
                        $htmlResult .= "<td class='novy'><a title='nový' ";
                    }
                $htmlResult .= " href=\"index.php?akce=form&form=ap_zamestnani_uc&id_zajemce=".$zajemceRegistrace->id."\">"
                            ."Zaměstnání" . "</a></td>";
            }
            $htmlResult .= '</tr>';
        }

        return $htmlResult;
    }
}

?>