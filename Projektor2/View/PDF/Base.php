<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Base
 *
 * @author pes2704
 */
abstract class Projektor2_View_PDF_Base extends Projektor2_View_Base implements Projektor2_View_PDF_ViewPdfInterface {
    const FPDF_FONTPATH = 'Projektor2/PDF/Fonts/';
//    const FILE_PATH_PREFIX = "C:/_Export Projektor/PDF/";
    const FILE_PATH_PREFIX = "./doku/";

    protected $fullFileName;
    /**
     *
     * @var Projektor2_PDF_VytvorPDF 
     */
    protected $pdf;
    
    protected $pdfString;
    
    /**
     * Tuto metodu musí potomci implementovat. Je volána v metodě $this->save().
     */
    abstract function createPDFObject();
        
    /**
     * Metoda ukládá vytvořené PDF do souboru.
     * @return bool TRUE pokud byl soubor s PDF vytvořen, jinak FALSE
     */
    public function save() {
        //TODO: Exception !! neexistuje $context["identifikator"]
        $this->fullFileName = static::FILE_PATH_PREFIX.static::FILE_NAME_PREFIX.$this->context["identifikator"].".pdf";
        define('FPDF_FONTPATH', self::FPDF_FONTPATH);  //běhová konstanta potřebná pro fpdf
        $this->createPDFObject();        
        if (file_exists($this->fullFileName))  	{
            unlink($this->fullFileName);
        }
        $this->pdf->Output($this->fullFileName, F);
            return $this->isSaved();
        }

    public function isSaved() {
        if (file_exists($this->fullFileName))  	{
            return TRUE;
        }
        return FALSE;
    }

    public function getFullFileName() {
        return $this->fullFileName;
    }
    
    public function render() {
        $this->pdfString = $this->pdf->Output($this->fullFileName, S);
        return $this->pdfString;
    }

    public function getNewWindowOpenerCode() {
        if (!$this->isSaved()) {
            $this->save();
        }
//        echo '<script type ="text/javascript">
//                FullFileName="' . $this->getFullFileName(). '";
//                NadpisOkna="' . $this->getFileName(). '";  
//              </script>';
        $code =  '<script type ="text/javascript">
                    FullFileName="' . $this->getFullFileName(). '";
                  </script>';
        return $code;
    }
    
    protected function setHeaderFooter($logoFileName=NULL, $textPaticky=NULL) {
        $pdfhlavicka = Projektor2_PDFContext::getHlavicka();
        $pdfhlavicka->zarovnani("C");
        $pdfhlavicka->vyskaPisma(14);
        if ($logoFileName) {
            if (is_readable($logoFileName)) {
                $pdfhlavicka->obrazek($logoFileName, null, null,165,12);
            } else {
                throw new UnexpectedValueException('Zadán neexistující soubor s obrázkem do hlavičky dokumentu.');
            }
        }
        $pdfpaticka = Projektor2_PDFContext::getPaticka();
        if ($textPaticky) {
            $pdfpaticka->Odstavec($textPaticky);
        }
        $pdfpaticka->zarovnani("C");
        $pdfpaticka->vyskaPisma(6);
        $pdfpaticka->cislovani = true;
    }
    
    protected function tiskniTitulniStranu($textNadpisu1, $textNadpisu2) {
        $titulka1 = new Projektor2_PDF_Blok;
        $titulka1->Nadpis($textNadpisu1);
        $titulka1->MezeraPredNadpisem(0);
        $titulka1->ZarovnaniNadpisu("C");
        $titulka1->VyskaPismaNadpisu(14);
        $titulka2 = new Projektor2_PDF_Blok;
        $titulka2->Nadpis($textNadpisu2);
        $titulka2->MezeraPredNadpisem(10);
        $titulka2->ZarovnaniNadpisu("C");
        $titulka2->VyskaPismaNadpisu(14);
        $this->pdf->AddPage();   //uvodni stranka
        $this->pdf->TiskniBlok($titulka1);
        $this->pdf->TiskniBlok($titulka2);        
    }
}

?>
