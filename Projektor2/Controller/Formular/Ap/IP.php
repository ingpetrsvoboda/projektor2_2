<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Projektor2_Controller_Formular_HelpIP
 *
 * @author pes2704
 */
abstract class Projektor2_Controller_Formular_Ap_IP extends Projektor2_Controller_Formular_Ap_Menus {
    
    /**
     * Metoda vrací pole objektů Projektor2_Model_SKurz pro aktuální projekt, běh, kancelář a zadaný druh kurzu. 
     * Metoda vytvoří filtr z kontextu aplikace 
     * (projekti, běh a kancelář) a druhu kurzu zadaného jako parametr. Do výběru přidá vždy i kurzy, 
     * kde kurz_zkratka='*'. S tímto filtrem pak volá Projektor2_Model_SKurzMapper, metodu findAll().
     * @param string $kurz_druh Parametr musí obsahovat hodnotu ze sloupce kurz_druh db tabulky s_kurz
     * @return array of Projektor2_Model_SKurz
     */
    protected function contextSelectKurz($kurz_druh, $default=TRUE) {
        $filter = "(projekt_kod='".$this->sessionStatus->projekt->kod
                ."' AND kancelar_kod='".$this->sessionStatus->kancelar->kod
                ."' AND beh_cislo='".$this->sessionStatus->beh->beh_cislo
                ."' AND kurz_druh='".$kurz_druh."')";
        if ($default) {
            $filter .= " OR kurz_zkratka='*'";
        }
        $mapper = new Projektor2_Model_SKurzMapper();
        return $mapper->findAll($filter, 'razeni');        
    }
    
    /**
     * Specializovaná metoda pro projekt, vybírá kurzy podle sloupců flat tabulky s id kurzů použitých v daném projektu.
     * @param Projektor2_View_Base $view
     */
    protected function assignKurzyToHtmlView(Projektor2_View_Base $view) {
        $view->assign('kurzy_zztp', $this->contextSelectKurz('ZZTP'));
        $view->assign('kurzy_pc1', $this->contextSelectKurz('PC'));
        $view->assign('kurzy_fg', $this->contextSelectKurz('FG'));
        $view->assign('kurzy_im', $this->contextSelectKurz('IM'));
        $view->assign('kurzy_spp', $this->contextSelectKurz('SPP'));
        $view->assign('kurzy_sebas', $this->contextSelectKurz('SEBAS'));
        $view->assign('kurzy_forpr', $this->contextSelectKurz('FORPR'));
        $view->assign('kurzy_prdi', $this->contextSelectKurz('PD'));
        $view->assign('kurzy_prof1', $this->contextSelectKurz('RK'));    
        $view->assign('kurzy_prof2', $this->contextSelectKurz('RK'));    
        $view->assign('kurzy_prof3', $this->contextSelectKurz('RK'));          
    }
    
    /**
     * Specializovaná metoda pro projekt, nastavuje proměnné pro pdf podle kurzů použitých v daném projektu.
     * Současně supluje model - tato metoda dělá vazbu mezi za_plan_flat_table a s_kurz (pro každý sloupec 
     * za_plan_flat_table s cizím klíčem kurzu jedna vazba 1:1).
     * @param Projektor2_Model_Flat_ZaPlanFlatTable $planFlatTable
     * @param Projektor2_View_Base $view
     */
    protected function assignKurzyToPdfView(Projektor2_Model_Flat_ZaPlanFlatTable $planFlatTable, Projektor2_View_Base $view) {
        $view->assign('zztp_kurz', Projektor2_Model_SKurzMapper::findById($planFlatTable->id_s_kurz_zztp_FK));
        $view->assign('pc1_kurz', Projektor2_Model_SKurzMapper::findById($planFlatTable->id_s_kurz_pc1_FK));
        $view->assign('fg_kurz', Projektor2_Model_SKurzMapper::findById($planFlatTable->id_s_kurz_fg_FK));
        $view->assign('im_kurz', Projektor2_Model_SKurzMapper::findById($planFlatTable->id_s_kurz_im_FK));
        $view->assign('spp_kurz', Projektor2_Model_SKurzMapper::findById($planFlatTable->id_s_kurz_spp_FK));
        $view->assign('prdi_kurz', Projektor2_Model_SKurzMapper::findById($planFlatTable->id_s_kurz_prdi_FK));
        $view->assign('prof1_kurz', Projektor2_Model_SKurzMapper::findById($planFlatTable->id_s_kurz_prof1_FK));        
        $view->assign('prof2_kurz', Projektor2_Model_SKurzMapper::findById($planFlatTable->id_s_kurz_prof2_FK));        
        $view->assign('prof3_kurz', Projektor2_Model_SKurzMapper::findById($planFlatTable->id_s_kurz_prof3_FK));           
    }

    
    protected function assignPoradenstviToHtmlView(Projektor2_View_Base $view) {
        $view->assign('poradenstvi_klub', $this->contextSelectKurz('KLUB', FALSE));
        
    }
    
    /**
     * Specializovaná metoda pro projekt, nastavuje proměnné pro pdf podle kurzů použitých v daném projektu.
     * Současně supluje model - tato metoda dělá vazbu mezi za_plan_poradenstvi a s_kurz (pro každý řádek 
     * v datasetu za_plan_poradenstvi vybraném metodou Projektor2_Model_ZaPlanPoradenstvi->findByIdZajemce() jedna vazba 1:1 na 
     * s_kurz). Dále rozdělí jednotlivé poradenské kurzy podle druhu kurzu do polí pro view. Výsledná data pro 
     * view kontext jsou pole objektů Projektor2_Model_SKurz, pro každý druh kurzu jedno pole.
     * @param Projektor2_Model_ZaPlanPoradenstvi $planPoradenstvi
     * @param Projektor2_View_Base $view
     */
    protected function assignPoradenstviToPdfView(Projektor2_Model_ZaPlanPoradenstvi $planPoradenstvi, Projektor2_View_Base $view) {
        foreach ($planPoradenstvi as $poradenstvi) {
            $mapper = new Projektor2_Model_SKurzMapper();
            $sKurz = $mapper->findById($poradenstvi->id_s_kurz_FK);
            switch ($sKurz->kurz_druh) {
                case 'KLUB':
                    $poradenstviKlub[] = $sKurz;

                    break;

                default:
                    break;
            }
        }
        $view->assign('poradenstvi_klub', $poradenstviKlub);
          
    }    
}
