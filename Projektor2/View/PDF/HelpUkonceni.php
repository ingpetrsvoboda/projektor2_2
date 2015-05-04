<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of HeSmlouva
 *
 * @author pes2704
 */
class Projektor2_View_PDF_HelpUkonceni extends Projektor2_View_PDF_Help {
    const FILE_NAME_PREFIX = "HELP_ukonceni ";
    
    public function createPDFObject() {
        //**********************************************
        $pdfdebug = Projektor2_PDFContext::getDebug();
        $pdfdebug->debug(0);
        $this->pdf = new Projektor2_PDF_VytvorPDF ();
        $this->pdf->AddFont('Times','','times.php');
        $this->pdf->AddFont('Times','B','timesbd.php');
        $this->pdf->AddFont("Times","BI","timesbi.php");
        $this->pdf->AddFont("Times","I","timesi.php");
        //**********************************************
        $textPaticky = "Ukončení účasti účastníka v projektu „Help 50+“ ".self::FILE_NAME_PREFIX. @$this->context["identifikator"].
                            "\n Projekt Help 50+ CZ.1.04/3.3.05/96.00249 je financován z Evropského sociálního fondu prostřednictvím OP LZZ a ze státního rozpočtu ČR.";
        $this->setHeaderFooter($textPaticky);
        //************************************************
        //********************************************** 
        $textNadpisu1 = "Ukončení účasti účastníka v projektu";
        $textNadpisu2 = 'Projekt „Help 50+“';
        $this->tiskniTitulniStranu($textNadpisu1, $textNadpisu2);
        //*****************************************************
        $this->tiskniOsobniUdaje();
        //*****************************************************        
        
        $ukonceniUcasti = new Projektor2_PDF_SadaBunek();
            $ukonceniUcasti->Nadpis("Údaje o účasti v projektu");
    //    	$ukonceniUcasti->PridejBunku("Datum zahájení účasti v projektu: ", @$pdfpole["datum_reg"]);
            $ukonceniUcasti->PridejBunku("Datum zahájení účasti v projektu: ", @$this->context["datum_vytvor_smlouvy"]);
            $ukonceniUcasti->PridejBunku("Datum ukončení účasti v projektu: ", @$this->context['datum_ukonceni'], 1);

            $duvod_ukonceni_pole =  explode ("|", @$this->context['duvod_ukonceni']);
            $ukonceniUcasti->PridejBunku("Důvod ukončení účasti v projektu: ", $duvod_ukonceni_pole[0],1);
            if ( ($duvod_ukonceni_pole[0] == "2b ") or ($duvod_ukonceni_pole[0]== "3a ")  or ($duvod_ukonceni_pole[0] == "3b ")
                  and @$this->context['popis_ukonceni']
                ) {
                $ukonceniUcasti->PridejBunku("Podrobnější popis důvodu ukončení účasti v projektu: ", " " ,1);
                $ukonceniUcasti1 = new Projektor2_PDF_Blok;
                $ukonceniUcasti1->Odstavec( @$this->context['popis_ukonceni']);
            }
        $this->pdf->TiskniSaduBunek($ukonceniUcasti);
        if ($ukonceniUcasti1) $this->pdf->TiskniBlok($ukonceniUcasti1);
        $pozn = new Projektor2_PDF_Blok;
            $pozn->Nadpis("Možné důvody:");
            $pozn->Odstavec("1. řádné absolvování projektu");
            $pozn->PridejOdstavec("2. předčasným ukončením účasti ze strany klienta");
            $pozn->VyskaPismaNadpisu(8);
            $pozn->VyskaPismaTextu(8);
        $this->pdf->TiskniBlok($pozn);
        $pozn = new Projektor2_PDF_Blok;
            $pozn->Odstavec("a. dnem předcházejícím nástupu klienta do pracovního poměru (ve výjimečných případech může být dohodnuto jinak)");
            $pozn->PridejOdstavec("b. výpovědí dohody o účasti v projektu účastníkem nebo ukončením dohody z jiného důvodu než nástupu do zaměstnání (ukončení bude v den předcházející dni vzniku důvodu ukončení)");
            $pozn->VyskaPismaTextu(8);
            $pozn->OdsazeniZleva(3);
            $pozn->Predsazeni(3);
        $this->pdf->TiskniBlok($pozn);
        $pozn = new Projektor2_PDF_Blok;
            $pozn->Odstavec("3. předčasným ukončením účasti ze strany dodavatele");
            $pozn->VyskaPismaTextu(8);
        $this->pdf->TiskniBlok($pozn);
        $pozn = new Projektor2_PDF_Blok;
            $pozn->Odstavec("a. pokud účastník porušuje podmínky účasti v projektu, neplní své povinnosti při účasti na aktivitách projektu (zejména na rekvalifikaci) nebo jiným závažným způsobem maří účel účasti v projektu");
            $pozn->PridejOdstavec("b. ve výjimečných případech na základě podnětu vysílajícího ÚP, např. při sankčním vyřazení z evidence ÚP (ukončení bude v pracovní den předcházející dni vzniku důvodu ukončení)");
            $pozn->VyskaPismaTextu(8);
            $pozn->OdsazeniZleva(3);
            $pozn->Predsazeni(3);
        $this->pdf->TiskniBlok($pozn); 
        
        //**********************************************
        $this->tiskniPodpisy($this->context["datum_vytvor_dok_ukonc"]);
    }
}

?>
