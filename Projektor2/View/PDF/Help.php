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
abstract class Projektor2_View_PDF_Help extends Projektor2_View_PDF_Base{
    
    protected function setHeaderFooter($textPaticky=NULL) {
        parent::setHeaderFooter("./img/loga/loga_HELP50+_BW.png", $textPaticky);
    }
    
    protected function tiskniOsobniUdaje() {
        $osobniUdaje = new Projektor2_PDF_SadaBunek();
        $osobniUdaje->Nadpis("Osobní údaje");
        $osobniUdaje->vyskaPismaNadpisu(12);  //neumi

        $osobniUdaje->PridejBunku("jméno, příjmení, titul: ", $this->celeJmeno(),1);
        $celaAdresa=  $this->celaAdresa($this->context["ulice"], $this->context["mesto"], $this->context["psc"]);
        $osobniUdaje->PridejBunku("bydliště: ", $celaAdresa,1);
        $celaAdresa2=  $this->celaAdresa($this->context["ulice2"], $this->context["mesto2"], $this->context["psc2"]);
        if  ($celaAdresa2) {
            $osobniUdaje->PridejBunku( "adresa dojíždění odlišná od místa bydliště: ", $celaAdresa2,1);
        }
        $osobniUdaje->PridejBunku("nar.: ", $this->context["datum_narozeni"],1);
        $osobniUdaje->PridejBunku("identifikační číslo účastníka: ", $this->context["identifikator"],1);
        $osobniUdaje->PridejBunku("(dále jen „Účastník“)", "",1);
        $this->pdf->Ln(5);
        $this->pdf->TiskniSaduBunek($osobniUdaje);        
    }
    
    protected function tiskniPodpisy($datum) {
        $podpisy = new Projektor2_PDF_SadaBunek();
        $podpisy->MezeraPredSadouBunek(8);
        $podpisy->PridejBunku("Konzultační centrum: ", $this->context['kancelar_plny_text'], 1);
        $podpisy->PridejBunku("Dne ",$datum,1);
        $podpisy->NovyRadek(0,1);
        $podpisy->PridejBunku("                       Účastník:                                                                                   Příjemce dotace:","",1);
        $podpisy->NovyRadek(0,5);
        $podpisy->PridejBunku("                       ......................................................                                            ......................................................","",1);
        $podpisy->PridejBunku("                        " . $this->celeJmeno().$this->context['user_name'],"",1);
        $podpisy->PridejBunku("                                                                                                                                 okresní poradce projektu","");
        $this->pdf->TiskniSaduBunek($podpisy, 0, 1);        
    }
    
    protected function celeJmeno() {
        $celeJmeno = $this->context["titul"]." ".  $this->context["jmeno"]." ".  $this->context["prijmeni"];
        if ($this->context["titul_za"]) {
            $celeJmeno = $celeJmeno.", ".  $this->context["titul_za"];
        }       
        return str_pad(str_pad($celeJmeno, 30, " ", STR_PAD_BOTH) , 92) ;        
    }
    
    protected function celaAdresa($ulice='', $mesto='', $psc='') {
        if ($ulice) {
            $celaAdresa .= $ulice;
            if  ($mesto) {
                $celaAdresa .=  ", ".$mesto;
            }
            if  ($psc) {
                $celaAdresa .= ", ".$psc;
            }
        } else {
            if  ($mesto)  {
                $celaAdresa .= $mesto;
                if  ($psc) {
                    $celaAdresa .= ", " .$psc;
                }
            } else {
                if  ($psc) {
                    $celaAdresa .= $psc;
                }
            }
        }  
        return $celaAdresa;
    }
}

?>
