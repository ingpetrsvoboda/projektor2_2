<?php
/**
 * Tento model je vyřazen z požívání po rekonstrukci tabulky za_plan_flat_table.
 * Je přejmenován na Projektor2_Model_Flat_ZaPlanFlatTableBeforeRestore.
 */
class Projektor2_Model_Flat_ZaPlanFlatTableBeforeRestore extends Framework_Model_ItemFlatTableAbstract {
    public function __construct(Projektor2_Model_Zajemce $zajemce){
        parent::__construct("za_plan_flat_table",$zajemce);
        }
}
?>