<?php
class Projektor2_Model_ZajemceRegistrace {
    //tabulka zajemce
    CONST TABLE = "zajemce";
    public $id;
    public $jmeno_cele;
    public $identifikator;
    public $znacka;
    public $datum_reg;
    public $vyplneno_vzdelani;
    
    public function __construct($jmeno_cele, $identifikator, $znacka, $datum_reg, $vyplneno_vzdelani, $id=false) {
        $this->id = $id;
        $this->jmeno_cele = $jmeno_cele;
        $this->identifikator = $identifikator;
        $this->znacka = $znacka;
        $this->datum_reg = $datum_reg;
        $this->vyplneno_vzdelani = $vyplneno_vzdelani;
    }
}
?>
