<?php
class Projektor2_Model_Flat_UcDoprkFlatTable extends Framework_Model_ItemFlatTableAbstract {
    public function __construct(Projektor2_Model_Ucastnik $ucastnik){
        parent::__construct("uc_doporucenirk_flat_table",$ucastnik);
        }
}
?>