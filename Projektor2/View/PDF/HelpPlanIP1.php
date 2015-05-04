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
class Projektor2_View_PDF_HelpPlanIP1 extends Projektor2_View_PDF_Help{
    const FILE_NAME_PREFIX = "HELP_IP_cast1 ";

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
        $textPaticky = "Individuální plán účastníka v projektu „Help 50+“ - část 1".self::FILE_NAME_PREFIX. @$this->context["identifikator"].
            "\n Projekt Help 50+ CZ.1.04/3.3.05/96.00249 je financován z Evropského sociálního fondu prostřednictvím OP LZZ a ze státního rozpočtu ČR.";
        $this->setHeaderFooter($textPaticky);
        //********************************************** 
        $textNadpisu1 = "INDIVIDUÁLNÍ PLÁN ÚČASTNÍKA - část 1";
        $textNadpisu2 = 'Projekt „Help 50+“';
        $this->tiskniTitulniStranu($textNadpisu1, $textNadpisu2);
        //*****************************************************
        $this->tiskniOsobniUdaje();
        //*****************************************************        
        $kurzSadaBunek = new Projektor2_PDF_SadaBunek();
        $kurzSadaBunek->SpustSadu(true);
        $aktivity = Projektor2_AppContext::getAktivityProjektu();   
        foreach ($aktivity as $druh=>$aktivita) {
            if ($aktivita['typ']!='kurz') {
                $nabidkaNekurzovychAktivit .= $nabidkaNekurzovychAktivit ? ', '.$aktivita['nadpis'] : $aktivita['nadpis'];
            }
        }
        $nabidkaNekurzovychAktivit .= $nabidkaNekurzovychAktivit ? '.' : '';
        foreach ($aktivity as $druh=>$aktivita) {
            if ($aktivita['typ']=='kurz') {
                $nabidkaKurzovychAktivit .= $nabidkaKurzovychAktivit ? ', '.$aktivita['nadpis'] : $aktivita['nadpis'];
            }
        }
        $nabidkaKurzovychAktivit .= $nabidkaKurzovychAktivit ? '.' : '';
        $blok = new Projektor2_PDF_Blok;
            $blok->Nadpis("Preambule");            
            $blok->PridejOdstavec("První část IP je předběžný plán průběhu účasti v projektu, který se bude během projektu vyvíjet a výsledný průběh účasti v projektu bude zachycen v druhé části IP.");
            $blok->PridejOdstavec("Účastníkovi projektu jsou plánovány aktivity vybrané z těchto základních aktivit: ".$nabidkaNekurzovychAktivit);
            $blok->PridejOdstavec("Účastníkovi projektu jsou plánovány aktivity vybrané z těchto aktivit, které mají charakter kurzu, školení: ".$nabidkaKurzovychAktivit);
            $blok->predsazeni(0);
            $blok->odsazeniZleva(0);
        $this->pdf->TiskniBlok($blok);        
        //##################################################################################################
        $kurzSadaBunek->Nadpis("Plánované aktivity účastníka:");
        $kurzSadaBunek->MezeraPredNadpisem(4);
        $kurzSadaBunek->ZarovnaniNadpisu("L");
        $kurzSadaBunek->VyskaPismaNadpisu(11);
        $kurzSadaBunek->MezeraPredSadouBunek(0);
        $kurzSadaBunek->PridejBunku("", "Účastníkovi byla naplánována účast na těchto aktivitách projektu:", 1);
        $kurzSadaBunek->PridejBunku("", "", 1);
        foreach ($aktivity as $druh=>$aktivita) {
            if ($this->context[$druh.'_kurz'] AND $this->context[$druh.'_kurz']->kurz_zkratka != '*') {

                $kurzSadaBunek->PridejBunku("Název aktivity: ",$aktivita['nadpis'], 1);
            }
        }
        $this->pdf->TiskniSaduBunek($kurzSadaBunek); 
        //##################################################################################################
        $podpisy = new Projektor2_PDF_SadaBunek();
        $podpisy->MezeraPredSadouBunek(16);
        $podpisy->PridejBunku("Konzultační centrum: ", @$this->context['kancelar_plny_text'], 1);
        $podpisy->PridejBunku("Dne ", @$this->context["datum_vytvor_smlouvy"],1);
        $podpisy->NovyRadek(0,1);
        $podpisy->PridejBunku("                       Účastník:                                                                                   Příjemce dotace:","",1);
        $podpisy->NovyRadek(0,5);
        //  $podpisy->NovyRadek(0,3);
        $podpisy->PridejBunku("                       ......................................................                                            ......................................................","",1);
        $podpisy->PridejBunku("                        " . str_pad(str_pad($celeJmeno, 30, " ", STR_PAD_BOTH) , 92) . @$this->context['user_name'],"",1);
        //	$podpisy->PridejBunku("                           " . $celeJmeno . "                                                                         " . $User->name,"",1);

        //$podpisy->PridejBunku("                                     podpis účastníka                                                                podpis, jméno a příjmení","",1);
        $podpisy->PridejBunku("                                                                                                                                 okresní poradce projektu","");
        $this->pdf->TiskniSaduBunek($podpisy, 0, 1);

        return $this->pdf;
    }
}

?>
