<?php
class Projektor2_Model_Flat_ZaFlatTable extends Framework_Model_ItemFlatTableAbstract {
    
    public function __construct(Projektor2_Model_Zajemce $zajemce){
        parent::__construct("za_flat_table",$zajemce);
        }
}
?>