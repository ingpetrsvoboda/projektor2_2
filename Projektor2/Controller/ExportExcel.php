<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Projektor2_Controller_ExportExcel{
    
    public $objPHPExcel;
    public $tabulka;
    
    protected $bylaVolanaMetodaExport = FALSE;
    protected $saved;
    protected $fullFileName;
    protected $htmlExportMessages;
    
    const EXPORT_PATH = "C:/_Export Projektor/Excel/";

    const SQL_FORMAT = "Y-m-d";
    const BUNKA_NADPIS = "A1";
    const LEVY_HORNI_ROH_TABULKY_RADEK = 3; //řádek s titulky - číslováno os nuly
    const LEVY_HORNI_ROH_TABULKY_SLOUPEC = 0; //číslováno os nuly


    public function __construct($tabulka) {
        $this->tabulka = $tabulka;

        $locale = 'cs_CZ';
        $validLocale = PHPExcel_Settings::setLocale($locale);
        if (!$validLocale) {
                echo 'Nepodařilo se nastavit lokalizaci '.$locale." - zůstává nastavena výchozí en_us<br />\n";
        }

        $dbh = Projektor2_AppContext::getDB();
        $query = "SHOW COLUMNS FROM ~1";
        $res= $dbh->prepare($query)->execute($this->tabulka);

        $this->objPHPExcel = new PHPExcel();
        $objWorksheet = $this->objPHPExcel->getActiveSheet();
        PHPExcel_Cell::setValueBinder( new PHPExcel_Cell_AdvancedValueBinder() );

        $this->objPHPExcel->getActiveSheet()->setCellValue(self::BUNKA_NADPIS, 'Obsah databázové tabulky (pohledu) '.$this->tabulka);
        $cisloSloupce = self::LEVY_HORNI_ROH_TABULKY_SLOUPEC;
        $cisloRadku = self::LEVY_HORNI_ROH_TABULKY_RADEK;
        //titulky sloupců
        while ($data = $res->fetch()){
            $var_typelengh[$cisloSloupce] = split('[()]',$data['Type']);
            $objWorksheet->getCellByColumnAndRow($cisloSloupce, $cisloRadku)->setValue($data['Field']);
            $cisloSloupce++;    
        }
        //data
        $cisloSloupce = self::LEVY_HORNI_ROH_TABULKY_SLOUPEC;
        $cisloRadku = self::LEVY_HORNI_ROH_TABULKY_RADEK + 1;
        $query = "SELECT * FROM ~1";                                 
        $data = $dbh->prepare($query)->execute($this->tabulka);
        while ($zaznam = $data->fetch()) {
            foreach ($zaznam as $value) {
                if ($var_typelengh[$cisloSloupce][0]=="date") {
                    $datum = PHPExcel_Shared_Date::PHPToExcel(DateTime::createFromFormat(self::SQL_FORMAT, $value));
                    $objWorksheet->getCellByColumnAndRow($cisloSloupce, $cisloRadku)->setValue($datum);                
                    $objWorksheet->getStyleByColumnAndRow($cisloSloupce, $cisloRadku)->getNumberFormat()->setFormatCode("D.M.YYYY");
                } else {
                    $objWorksheet->getCellByColumnAndRow($cisloSloupce, $cisloRadku)->setValue($value);
                }  
                $cisloSloupce++;                     
            }
            $cisloSloupce = 0;
            $cisloRadku++;
        }  
        
        $this->objPHPExcel->getProperties()->setCreator("Projektor ExportExcel");
        $this->objPHPExcel->getProperties()->setTitle("Projektor export - tabulka ".$tabulka);
        //$objPHPExcel->getProperties()->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.");
    }
    
    public function export($soubor = NULL, $pridejCasUlozeniKNazvuSouboru = FALSE) {
        $this->bylaVolanaMetodaExport = TRUE;
        $this->htmlExportMessages = '';
        if (!$soubor)
        {
//            $soubor = self::EXPORT_PATH . $this->tabulka . ".xlsx";
            $soubor = self::EXPORT_PATH . $this->tabulka . ".xls";
        }
            if ($pridejCasUlozeniKNazvuSouboru) {
            $s = split("[.]", $soubor);
            $soubor = $s[0] . "_" . date("Ymd_Hi") . "." . $s[1];
        } else {
            $soubor = $soubor;            
        }
//        $objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel, "Excel2007");
        $objWriter = new PHPExcel_Writer_Excel5($this->objPHPExcel);
        try {
        $objWriter->save($soubor); 
        } catch (Exception $e){
            $this->htmlExportMessages .= "<p>Do souboru ".$soubor." pro export seznamu nelze zapsat. </p>";
            $this->htmlExportMessages .= "<p>Pravděpodobně složka neexistuje nebo je soubor otevřen v nějakém programu - používán. Export seznamu neproběhl.</p>";
            $this->htmlExportMessages .= "<pre>". $e->getMessage()."</pre>";
            $this->saved = FALSE;
            $this->fullFileName = '';
            return FALSE;
        }
        $this->htmlExportMessages .= "<p>Data byla uložena do souboru ".$soubor." </p>";
            $this->saved = TRUE;
            $this->fullFileName = $soubor;
            return TRUE;
    }
    
    public function isSaved() {
        return $this->saved;
    }

    public function getFullFileName() {
        return $this->fullFileName;
    }
    
    public function getResult() {
        if ($this->bylaVolanaMetodaExport) {
            return $this->htmlExportMessages;
        } else {
            return "<p>Dosud nebyla zavolana metoda export().</p>";
        }
        
    }

}

