<?php
class Projektor2_Model_SKurz {
    public $id;
    public $razeni;
    public $projekt_kod;
    public $kurz_druh;
    public $kurz_cislo;
    public $beh_cislo;
    public $kurz_lokace;
    public $kurz_zkratka;
    public $kurz_nazev;
    public $kurz_termin;
    public $date_zacatek;
    public $date_konec;
    public $valid;
    
    public function __construct($id=false, $razeni=false, $projekt_kod=false, 
                                $kurz_druh=false, $kurz_cislo=false, $beh_cislo=false, $kurz_lokace=false, $kurz_zkratka=false, 
                                $kurz_nazev=false, $kurz_termin=false, $date_zacatek=false, $date_konec=false, $valid=false) {
        $this->id = $id;
        $this->razeni = $razeni;
        $this->projekt_kod = $projekt_kod;
        $this->kurz_druh = $kurz_druh;
        $this->kurz_cislo = $kurz_cislo;
        $this->beh_cislo = $beh_cislo;
        $this->kurz_lokace = $kurz_lokace;
        $this->kurz_zkratka = $kurz_zkratka;
        $this->kurz_nazev = $kurz_nazev;
        $this->kurz_termin = $kurz_termin;
        $this->date_zacatek = $date_zacatek;
        $this->date_konec = $date_konec;
        $this->valid = $valid;        
    }
}

?>