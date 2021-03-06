<?php

/*
* První část IP (v rozsahu 1-2 strany A4) – která bude obsahovat:
charakteristiku účastníka (klientovy nacionále, údaje o dosaženém vzdělání a získaných dovednostech, o předchozích pracovních zkušenostech, o zdravotním stavu a charakterových předpokladech, motivaci k práci, potřebách na doplnění vzdělání, představách o dalším pracovním zařazení atd.),
plán účasti v projektu (doporučení aktivit, jichž by se klient měl účastnit, zaměstnavatelů, na které by se měl zaměřit při hledání práce, zjištění zájmu a doporučení pro eventuální zařazení do některého rekvalifikačního kurzu organizovaného a hrazeného mimo tento projekt, apod.).
První část IP je předběžný plán průběhu účasti v projektu, který se může během projektu vyvíjet, tento vývoj bude zachycen ve druhé části IP.
Druhou část IP zpracuje poradce s klientem při ukončení účasti v projektu. Tato část bude obsahovat:
vyhodnocení účasti klienta v projektu (případné změny oproti první části IP, shrnutí absolvovaných aktivit a provedených kontaktů se zaměstnavateli a v případě, že klient nezíská při účasti v projektu zaměstnání, také doporučení vysílajícímu KoP pro další práci s klientem).
Obě části IP budou podepsány poradcem i klientem. Kopie IP budou předány spolu s měsíční zprávou o realizaci Zadavateli a také vysílajícímu KoP.

*/
/**
* Description of Projektor2_View_PDF_HelpPlanIP1
*
* @author pes2704
*/
class Projektor2_View_PDF_ApIPAktivity extends Projektor2_View_PDF_ApIP {
    const FILE_NAME_PREFIX = "AP_IP_cast1_aktivity ";

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
        $textPaticky = "Individuální plán účastníka v projektu „Alternativní práce v Plzeňském kraji“ - část 1 - plán aktivit".self::FILE_NAME_PREFIX. @$this->context["identifikator"].
            "\n Projekt Alternativní práce v Plzeňském kraji CZ.1.04/2.1.00/70.00055 je financován z Evropského sociálního fondu prostřednictvím OP LZZ a ze státního rozpočtu ČR.";
        $textNadpisu1 = "INDIVIDUÁLNÍ PLÁN ÚČASTNÍKA - část 1 - plán aktivit";
        $textNadpisu2 = 'Projekt „Alternativní práce v Plzeňském kraji“';
        $this->setHeaderFooter($textPaticky);
        //*****************************************************
        $this->tiskniTitulniStranu($textNadpisu1, $textNadpisu2);
        //*****************************************************
        $this->tiskniOsobniUdaje();
        //********************************************************
        $blok = new Projektor2_PDF_Blok;
            $blok->Nadpis("Preambule");            
//$blok->PridejOdstavec("Druhá část IP obsahuje vyhodnocení účasti klienta v projektu členěné podle absolvovaných aktivit a v případě, že klient nezíská při účasti v projektu zaměstnání, také doporučení vysílajícímu KoP pro další práci s klientem.");
            
            $blok->PridejOdstavec("Plán aktivit doplňuje 1. část IP. Obsahuje plán konkrétních aktivit klienta v projektu členěný podle plánovaných aktivit."
                    );
            $blok->predsazeni(0);
            $blok->odsazeniZleva(0);
        $this->pdf->TiskniBlok($blok);        
        //##################################################################################################
        $aktivity = Projektor2_AppContext::getAktivityProjektu('AP'); 
        $blok = new Projektor2_PDF_Blok;
            $blok->Nadpis("Individuální plán projektu členěný podle absolvovaných aktivit");            
            $blok->predsazeni(0);
            $blok->odsazeniZleva(0);
        $this->pdf->TiskniBlok($blok);
        $count = 0;
        foreach ($aktivity as $druh=>$aktivita) {
            if ($aktivita['typ']=='kurz') {
                if ($this->context[$druh.'_kurz'] AND $this->context[$druh.'_kurz']->kurz_zkratka != '*') {
                    $count++;
                    if ((($count+1) % 5)==0) {
                        $this->pdf->AddPage();   //uvodni stranka                    
                    }
                    $kurzSadaBunek = new Projektor2_PDF_SadaBunek();
                    $kurzSadaBunek->SpustSadu(true);
                    $kurzSadaBunek->Nadpis($aktivita['nadpis']);
                    $kurzSadaBunek->MezeraPredNadpisem(4);
                    $kurzSadaBunek->ZarovnaniNadpisu("L");
                    $kurzSadaBunek->VyskaPismaNadpisu(11);
                    $kurzSadaBunek->MezeraPredSadouBunek(1);
                    $kurzSadaBunek->PridejBunku("Název kurzu: ",$this->context[$druh.'_kurz']->kurz_nazev, 1);
                    $kurzSadaBunek->PridejBunku("Termín konání: ",$this->context[$druh.'_kurz']->date_zacatek.' - '.$this->context[$druh.'_kurz']->date_konec, 1);
                    $this->pdf->TiskniSaduBunek($kurzSadaBunek);                             
                }
            }
        }
        if ($count == 0) {
            $bezAktivit = new Projektor2_PDF_Blok();
            $bezAktivit->Odstavec("Účastník nemá naplánovány žádné konkrétní aktivity projektu.");
            $this->pdf->TiskniBlok($bezAktivit);                    
        }
        //##################################################################################################
        $this->tiskniPodpisy(@$this->context["datum_upravy_dok_plan"]);

        return $this->pdf;
    }
    

}

?>
