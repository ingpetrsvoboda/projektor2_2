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
class Projektor2_View_PDF_ApUkonceni extends Projektor2_View_PDF_ApIP {
    const FILE_NAME_PREFIX = "AP_ukonceni ";
    
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
        $textPaticky = "Ukončení účasti účastníka v projektu ".self::FILE_NAME_PREFIX. @$this->context["identifikator"].
                                "\n Projekt Alternativní práce v Plzeňském kraji CZ.1.04/2.1.00/70.00055 je financován z Evropského sociálního fondu prostřednictvím OP LZZ a ze státního rozpočtu ČR.";
        $textNadpisu1 = "UKONČENÍ ÚČASTI V PROJEKTU";
        $textNadpisu2 = 'Projekt „Alternativní práce v Plzeňském kraji“';
        $this->setHeaderFooter($textPaticky);
        //*****************************************************
        $this->tiskniTitulniStranu($textNadpisu1, $textNadpisu2);
        //*****************************************************        
        $this->tiskniOsobniUdaje();
        //**********************************************
        $blok = new Projektor2_PDF_Blok;
            $blok->Nadpis("Ukončení účasti v projektu");            
            $blok->PridejOdstavec("Účastník ukončil účast v projektu „Alternativní práce v Plzenském kraji“ z dále uvedeného důvodu. "
                    . "Ke dni ukončení účasti skončila účinnost Dohody o úcasti v projektu „Alternativní práce v Plzenském kraji“.");
            $blok->PridejOdstavec("Účastník bere na vědomí, že dle podmínek projektu daných zadávací dokumentací zadavatele jímž je "
                    . "Krajská pobočka ÚP ČR v Plzni, byl povinen nejpozději ke dni ukončení účasti v projektu dodat veškeré doklady k přímé podpoře "
                    . "a dále pak do 3 pracovních dnů od ukončení účasti v projektu veškeré doklady k důvodům neúčasti na aktivitách projektu (např. omluvenky) "
                    . "a k ukončení účasti v projektu (např. kopii pracovní smlouvy).");
        $this->pdf->TiskniBlok($blok);
        $ukonceniUcasti = new Projektor2_PDF_SadaBunek();
            $ukonceniUcasti->Nadpis("Údaje o účasti v projektu");
    //    	$ukonceniUcasti->PridejBunku("Datum zahájení účasti v projektu: ", @$pdfpole["datum_reg"]);
            $ukonceniUcasti->PridejBunku("Datum zahájení účasti v projektu: ", @$this->context["datum_vytvor_smlouvy"]);
            $ukonceniUcasti->PridejBunku(" Datum ukončení účasti v projektu: ", @$this->context['datum_ukonceni'], 1);

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
        
        //##################################################################################################
        $this->tiskniPodpisy(@$this->context["datum_vytvor_dok_ukonc"]);
    }
}

?>
