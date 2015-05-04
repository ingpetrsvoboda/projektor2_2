<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AppStatus
 *
 * @author pes2704
 */
class Projektor2_SessionStatus {
    protected static $userId;
    protected static $behId;
    protected static $ucastnikId;
    protected static $zajemceId;
    
    /**
     * Poslední načtený stav
     * @var Projektor2_SessionStatus 
     */
    protected static $sessionStatus;
     
    public $kancelar;
    public $projekt;
    public $beh;
    public $user;
    public $opravneniKancelar;
    public $opravneniProjekt;

    public $ucastnik;
    public $zajemce;
    
    /**
     * Konstruktor 
     * Objekt vždy má vlastnosti $kancelar, $projekt, $beh, $user a jednu z vlastností $ucastnik nebo $zajemce.
     * @param type $kancelar
     * @param type $projekt
     * @param type $beh
     * @param type $user
     * @param type $ucastnik
     * @param type $zajemce
     */
    private function __construct(Projektor2_Model_User $user, Projektor2_Model_Kancelar $kancelar, Projektor2_Model_Projekt $projekt, Projektor2_Model_Beh $beh=NULL, 
                        Projektor2_Model_SysAccUsrKancelar $opravneniKancelar=NULL, Projektor2_Model_SysAccUsrProjekt $opravneniProjekt=NULL, 
                        Projektor2_Model_Ucastnik $ucastnik=NULL, Projektor2_Model_Zajemce $zajemce=NULL) {
        $this->kancelar = $kancelar;
        $this->projekt = $projekt;
        $this->beh = $beh;
        $this->user = $user;
        $this->opravneniKancelar = $opravneniKancelar;
        $this->opravneniProjekt = $opravneniProjekt;
        $this->ucastnik = $ucastnik;
        $this->zajemce = $zajemce;
    }

    public function __get($name) {
        return $this->$name;   //TODO: nekontroluje existenci vlastnosti
    }
    
    public function __set($name, $value) { 
        return FALSE; //TODO: nehlasi zadnym způsobem chybné volání
    }
    
    public static function setUserId($userId=NULL) {
        self::$userId = $userId;
        return self::$userId;
    }

    public static function setBehId($behId=NULL) {
        self::$behId = $behId;
        return self::$behId;
    }

    public static function setZajemceId($ZajemceId=NULL) {
        self::$zajemceId = $ZajemceId;
        return self::$zajemceId;
    }

    public static function setUcastnikId($UcastnikId=NULL) {
        self::$ucastnikId = $UcastnikId;
        return self::$ucastnikId;
    }

    public static function createSessionStatus() {
        if (!self::$sessionStatus) {   //sigleton
            // status hodnoty z cookie
            $kancelar = Projektor2_Model_KancelarMapper::findById($_COOKIE['kancelarId']);
            $projekt = Projektor2_Model_ProjektMapper::findById($_COOKIE['projektId']);
            if(!$kancelar OR !$projekt) {
                throw new Exception("Chybné volání metody. Není správná cookie nastavená login procesem.");
            }
            if (self::$behId) {
                $beh = Projektor2_Model_BehMapper::findById(self::$behId);  //nový běh
                setcookie('behId', self::$behId);  //buď nastaví id nového běhu nebo vymaže cookie, pokud self::getBehId() je FALSE
            } elseif (isset($_COOKIE['behId'])) {
                $beh = Projektor2_Model_BehMapper::findById($_COOKIE['behId']);
            }

            // status hodnoty z předem nastevené statické proměnné třídy
            if(!self::$userId) {
                throw new Exception("Chybné volání metody. Object musí mít nejprve nastavenu identitu přihlášeného uživatele pomocí setUserId() statické metody.");
            }
            $user = Projektor2_Model_UserMapper::findById(self::$userId);
            if(!$user) {
                throw new Exception("Neexistuje uživatel s nastavenou identitou.");
            }
            //Overeni prav - neexistence práv někončí výjimkou (vypisuje se upozornění pro uživatele ve stránce)
            $sysAccUsrKancelar = Projektor2_Model_SysAccUsrKancelarMapper::findById($user->id, $kancelar->id);
            $sysAccUsrProjekt = Projektor2_Model_SysAccUsrProjektMapper::findById($user->id, $projekt->id);

            if (($projekt->kod=="AGP") or ($projekt->kod=="HELP") or ($projekt->kod=="AP")) {
                //Nový zajemce nebo UPDATE
                if(self::$zajemceId) {
                    $zajemce = Projektor2_Model_ZajemceMapper::findById(self::$zajemceId);
                    setcookie('id_zajemce', $zajemce->id);
                } elseif (isset($_COOKIE['id_zajemce']) && $_COOKIE['id_zajemce'] != "") {
                    //Kontrola a nalezeni zajemce
                    if(!$zajemce = Projektor2_Model_ZajemceMapper::findById($_COOKIE['id_zajemce'])) {
                        throw new Exception("Pokoušíte se pracovat s neexistujícím nebo smazaným objektem Zajemce");
                    }
                    //Kontrola zda je zvoleny zajemce ve zvolenem projektu, kancelari a behu
                    if(!($zajemce->id_c_projekt_FK == $projekt->id
                         && $zajemce->id_c_kancelar_FK == $kancelar->id
                        && $zajemce->id_s_beh_projektu_FK == $beh->id)){
                        throw new Exception("Objekt Zajemce s id:".self::getUserId()." není v aktuální kanceláři nebo běhu.");
                    }
                }   
            } else {
                //Nový účastník nebo UPDATE
                if (self::$ucastnikId) {
                    $ucastnik = Projektor2_Model_UcastnikMapper::find_by_id(self::$ucastnikId);
                    setcookie('id_ucastnik', $zajemce->id);
                } elseif (isset($_COOKIE['id_ucastnik']) && $_COOKIE['id_ucastnik'] != "") {
                    //Kontrola a nalezeni ucastnika
                    if(!$ucastnik = Projektor2_Model_UcastnikMapper::find_by_id($_COOKIE['id_ucastnik'])) {
                        throw new Exception("Pokoušíte se pracovat s neexistujícím nebo smazaným objektem Ucastnik");
                    }
                    //Kontrola zda je zvoleny ucastnik ve zvolenem projektu, kancelari a behu
                    if(!($ucastnik->projekt->id == $projekt->id
                         && $ucastnik->kancelar->id == $kancelar->id
                         && $ucastnik->beh->id == $beh->id)){
                        throw new Exception("Objekt Ucastnik s id:".self::getUserId()." není v aktuální kanceláři nebo běhu.");
                    }
                } 
            }
            self::$sessionStatus = new Projektor2_SessionStatus($user, $kancelar, $projekt, $beh, $sysAccUsrKancelar, $sysAccUsrProjekt, $ucastnik, $zajemce);
        }
        return self::$sessionStatus;
    }
    
    public static function getSessionStatus() {
        return self::$sessionStatus;
    }
}

?>
