<?php
class Projektor2_Model_Ucastnik {
    //tabulka ucastnik
    CONST TABLE = "ucastnik";

    public $id;
    public $cislo;
    public $identifikator;
    public $projekt;
    public $kancelar;
    public $beh;
    
    public function __construct(Projektor2_Model_Projekt $projekt,Projektor2_Model_Kancelar $kancelar,Projektor2_Model_Beh $beh,$id=false,$cislo=false,$identifikator=false) {
        $this->id = $id;
        $this->cislo = $cislo;
        $this->identifikator = $identifikator;
        $this->projekt = $projekt;
        $this->kancelar = $kancelar;
        $this->beh = $beh;
    }
   
}

?>