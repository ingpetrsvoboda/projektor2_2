<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Akce
 *
 * @author pes2704
 */
class Projektor2_Router_Form {  

    protected $sessionStatus;
    protected $request;
    protected $response;
    
    public function __construct(Projektor2_SessionStatus $sessionStatus, Projektor2_Request $request, Projektor2_Response $response) {
        $this->sessionStatus = $sessionStatus;
        $this->request = $request;
        $this->response = $response;
    }
            
    public function getController() {
        //Volba akce
        switch($this->request->get('form')) {

    /** STARÉ PROJEKTY **/        
    //        case "zobraz_reg":
    //            include INC_PATH."ind_zobraz_reg.inc";
    //            break;
    //        case "zobraz_uc":
    //            setcookie("id_ucastnik",$_GET['id_ucastnik']);
    //            if ($_GET['save']) include INC_PATH.'ind_save_form';
    //            include INC_PATH."ind_reg_dot.inc";
    //            break;        
    //        case "reg_dot":
    //            setcookie("id_ucastnik");
    //            if ($_GET['save']) include INC_PATH.'ind_save_form.inc';
    //            include INC_PATH."ind_reg_dot.inc";
    //            break;
    //        case "sml_uc":
    //            setcookie("id_ucastnik");
    //            if ($_GET['save']) include INC_PATH.'ind_save_form.inc';
    //            include INC_PATH."ind_sml_uc.inc";
    //            break;
    //        case "ind_plan_uc":
    //            setcookie("id_ucastnik");
    //            if ($_GET['save']) include INC_PATH.'ind_save_plan_uc.inc';
    //            include INC_PATH."ind_plan_uc.inc";
    //            //include INC_PATH."ind_kolize_kterenejsouveskriptuvolane_uc.inc"; //tady nelze, protoze nejde ulozit sloupecky revidovano
    //            break;
    //        case "testpc_uc":
    //            setcookie("id_ucastnik");
    //            if ($_GET['save']) {
    //                    include INC_PATH.'ind_save_testpc_uc.inc';
    //                    include INC_PATH."ind_zobraz_reg.inc";
    //            } else {
    //                    include INC_PATH."ind_testpc_uc.inc";
    //            }
    //            break;
    //        case "doprk_uc":
    //            setcookie("id_ucastnik");
    //            if ($_GET['save']) include INC_PATH.'ind_save_doprk_uc.inc';
    //            include INC_PATH."ind_doprk_uc.inc";
    //            break;
    //        case "doprk_dopl1":
    //            setcookie("id_ucastnik");
    //            if ($_GET['save']) include INC_PATH.'ind_save_doprk_uc.inc';
    //            include INC_PATH."ind_doprk_uc_dopl1.inc";
    //            break;
    //        case "doprk_dopl2":
    //            setcookie("id_ucastnik");
    //            if ($_GET['save']) include INC_PATH.'ind_save_doprk_uc.inc';
    //            include INC_PATH."ind_doprk_uc_dopl2.inc";
    //            break;
    //        case "doprk_dopl3":
    //            setcookie("id_ucastnik");
    //            if ($_GET['save']) include INC_PATH.'ind_save_doprk_uc.inc';
    //            include INC_PATH."ind_doprk_uc_dopl3.inc";
    //            break;
    //        case "doprk_vyraz":
    //            setcookie("id_ucastnik");
    //            if ($_GET['save']) include INC_PATH.'ind_save_doprk_uc.inc';
    //            include INC_PATH."ind_doprk_uc_vyraz.inc";
    //            break;
    //        case "ukonceni_uc":
    //            setcookie("id_ucastnik");
    //            if ($_GET['save']) include INC_PATH.'ind_save_ukonc_uc.inc';
    //            include INC_PATH."ind_ukonc_uc.inc";
    //            break;
    //        case "zam_uc":
    //            setcookie("id_ucastnik");
    //            if ($_GET['save']) include INC_PATH.'ind_save_zam_uc.inc';
    //            include INC_PATH."ind_zam_uc.inc";
    //            break;
    //        case "zobraz_reg_export":
    //            include INC_PATH."ind_zobraz_reg.inc";  //v ind_zobraz_reg.inc na konci proběhne export do excelu
    //            break;
    //        case "zobraz_reg_vahy":
    //            include INC_PATH."ind_zobraz_reg.inc";  //v ind_zobraz_reg.inc na konci proběhne vypocet a zapis do db
    //            break;
    //        case "zobraz_stat":
    //            include INC_PATH."ind_zobraz_stat.inc";
    //            break;        
    //        case "uloz_vyplnil_stat":
    //            include INC_PATH."set_stat_form_fill.inc";
    //            include INC_PATH."ind_zobraz_stat.inc";
    //            break;
    //        case "zarad_agp_uc":
    //            setcookie("id_ucastnik");
    //            include INC_PATH."ind_zarad_do_agp.inc";
    //            include INC_PATH."ind_zobraz_reg.inc";
    //            break;        
    //        
    ///** AGP **/                
           case "agp_novy_zajemce":
                return new Projektor2_Controller_Formular_Agp_Smlouva($this->sessionStatus, $this->request, $this->response);
                break;
           case "agp_reg_dot":
                return new Projektor2_Controller_Formular_Agp_Dotaznik($this->sessionStatus, $this->request, $this->response);
                break;
           case "agp_sml_uc":
                return new Projektor2_Controller_Formular_Agp_Smlouva($this->sessionStatus, $this->request, $this->response);
                break;
           case "agp_souhlas_uc":
                return new Projektor2_Controller_Formular_Agp_Souhlas($this->sessionStatus, $this->request, $this->response);
                break;
           case "agp_ind_plan_uc":
                setcookie("id_zajemce");
                if ($_GET['save']) {/*include INC_PATH.'za_ind_save_plan_uc.inc';*/ }
                include INC_PATH."za_ind_plan_uc.inc";
                //include INC_PATH."ind_kolize_kterenejsouveskriptuvolane_uc.inc"; //tady nelze, protoze nejde ulozit sloupecky revidovano
                break;            
           case "agp_ukonceni_uc":
                setcookie("id_zajemce");
                if ($_GET['save']) {/*include INC_PATH.'za_ind_save_ukonc_uc.inc';*/}
                include INC_PATH."za_ind_ukonc_uc.inc";
                break;
           case "agp_zam_uc":
                setcookie("id_zajemce");
                if ($_GET['save']) {/*include INC_PATH.'za_ind_save_zam_uc.inc';*/ }
                include INC_PATH."za_ind_zam_uc.inc";
                break;      

    /** HELP **/        
           case "he_novy_zajemce":
                return new Projektor2_Controller_Formular_Help_Smlouva($this->sessionStatus, $this->request, $this->response);
                break;
            case "he_reg_dot":
                return new Projektor2_Controller_Formular_Help_Dotaznik($this->sessionStatus, $this->request, $this->response);
                break;
           case "he_sml_uc":
                return new Projektor2_Controller_Formular_Help_Smlouva($this->sessionStatus, $this->request, $this->response);
                break;
           case "he_souhlas_uc":
                return new Projektor2_Controller_Formular_Help_Souhlas($this->sessionStatus, $this->request, $this->response);
                break;
           case "he_plan_uc":
                return new Projektor2_Controller_Formular_Help_IP1($this->sessionStatus, $this->request, $this->response);
                break;
           case "he_ukonceni_uc":
                return new Projektor2_Controller_Formular_Help_IP2($this->sessionStatus, $this->request, $this->response);
                break;

    /** AP **/        
           case "ap_novy_zajemce":
                return new Projektor2_Controller_Formular_Ap_Smlouva($this->sessionStatus, $this->request, $this->response);
                break;
            case "ap_reg_dot":
                return new Projektor2_Controller_Formular_Ap_Dotaznik($this->sessionStatus, $this->request, $this->response);
                break;
           case "ap_sml_uc":
                return new Projektor2_Controller_Formular_Ap_Smlouva($this->sessionStatus, $this->request, $this->response);
                break;
           case "ap_souhlas_uc":
                return new Projektor2_Controller_Formular_Ap_Souhlas($this->sessionStatus, $this->request, $this->response);
                break;
           case "ap_ip1_uc":
                return new Projektor2_Controller_Formular_Ap_IP1($this->sessionStatus, $this->request, $this->response);
                break;
            case "ap_plan_uc":
                return new Projektor2_Controller_Formular_Ap_IPKurzy($this->sessionStatus, $this->request, $this->response);
                break;
            case "ap_porad_uc":
                return new Projektor2_Controller_Formular_Ap_IPPoradenstvi($this->sessionStatus, $this->request, $this->response);
                break;
            case "ap_ukonceni_uc":
                return new Projektor2_Controller_Formular_Ap_IP2($this->sessionStatus, $this->request, $this->response);
                break;
           case "ap_zamestnani_uc":
                return new Projektor2_Controller_Formular_Ap_Zamestnani($this->sessionStatus, $this->request, $this->response);
                break;
        }            
    }
}

?>
