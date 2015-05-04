<?php
/**
 * View_PDF třídy musí mít metody save() a getFullFileName(), neboť metoda display() v Projektor2_View_PDF_Base předpokládá užití těchto metod.
 * @author pes2704
 */
interface Projektor2_View_PDF_ViewPdfInterface {
    public function save();
    public function isSaved();
    public function getFullFileName();
    public function render();
    public function getNewWindowOpenerCode();
}

?>
