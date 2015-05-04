<?php
/**
 * Používá zrekonstruovanou tabulku za_plan_flat_table_restore
 * (Model s původní tabulkou je přejmenován na Projektor2_Model_Flat_ZaPlanFlatTableBeforeRestore)
 */
class Projektor2_Model_Flat_ZaPlanFlatTable extends Framework_Model_ItemFlatTableAbstract {
    public function __construct(Projektor2_Model_Zajemce $zajemce){
        parent::__construct("za_plan_flat_table_restore",$zajemce);
    }
}
?>