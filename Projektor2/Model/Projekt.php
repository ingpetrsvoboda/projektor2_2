<?php
class Projektor2_Model_Projekt extends Framework_Model_ItemAbstract {
    //tabulka c_projekt
    public $id;
    public $kod;
    public $text;
    public $plny_text;
    public $valid;
    
    public function __construct($id = false,$kod = false,$text = false,$plny_text = false,$valid = true) {
        $this->id = $id;
        $this->kod = $kod;
        $this->text = $text;
        $this->plny_text = $plny_text;
        $this->valid = $valid;
    }
}

?>