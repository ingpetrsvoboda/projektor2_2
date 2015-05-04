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
class Projektor2_View_PDF_AgpSouhlas extends Projektor2_View_PDF_Base{
    const FILE_NAME_PREFIX = "AGP_souhlas ";
    
    public function createPDFObject() {
        //**********************************************
            $pdfdebug = Projektor2_PDFContext::getDebug();
            $pdfdebug->debug(0);
            ob_clean;
            $pdf = new Projektor2_PDF_VytvorPDF ();
            $pdf->AddFont('Times','','times.php');
            $pdf->AddFont('Times','B','timesbd.php');
            $pdf->AddFont("Times","BI","timesbi.php");
            $pdf->AddFont("Times","I","timesi.php");
        //**********************************************
            $pdfhlavicka = Projektor2_PDFContext::getHlavicka();
                        $pdfhlavicka->zarovnani("C");
                        $pdfhlavicka->vyskaPisma(14);
                        $pdfhlavicka->obrazek("./img/loga/logo_agp_bw.png", null, null,85,12);
            $pdfpaticka = Projektor2_PDFContext::getPaticka();
                        $pdfpaticka->Odstavec("Souhlas účastníka projektu s poskytováním osobních údajů ".self::FILE_NAME_PREFIX.  @$this->context["identifikator"]);
                        $pdfpaticka->zarovnani("C");
                        $pdfpaticka->vyskaPisma(6);
                        $pdfpaticka->cislovani = true;
        //**********************************************
            $titulka1 = new Projektor2_PDF_Blok;
                    $titulka1->Nadpis("Souhlas účastníka projektu");
                    $titulka1->ZarovnaniNadpisu("C");
                    $titulka1->VyskaPismaNadpisu(14);
            $titulka2 = new Projektor2_PDF_Blok;
                    $titulka2->Nadpis('s poskytováním osobních údajů');
                    $titulka2->ZarovnaniNadpisu("C");
                    $titulka2->VyskaPismaNadpisu(14);
            $strany = new Projektor2_PDF_Blok;
                    $strany->Nadpis("Účastník projektu:");
                    $strany->ZarovnaniNadpisu("L");
                    $strany->VyskaPismaNadpisu(11);
            $stranaUcastnik = new Projektor2_PDF_SadaBunek();
                    $celeJmeno =  @$this->context["titul"]." ".@$this->context["jmeno"]." ".@$this->context["prijmeni"];
                    if (@$this->context["titul_za"])
                    {
                        $celeJmeno = $celeJmeno.", ".@$this->context["titul_za"];
                    }
                    $stranaUcastnik->PridejBunku("jméno, příjmení, titul: ", $celeJmeno,1);
                    $adresapole="";
                    if (@$this->context["ulice"]) {
                        $adresapole .=   @$this->context["ulice"];
                        if  (@$this->context["mesto"])  {  $adresapole .=  ", ".   @$this->context["mesto"];}
                        if  (@$this->context["psc"])    {  $adresapole .= ", " . @$this->context["psc"]; }
                    } else {
                        if  (@$this->context["mesto"]) {
                            $adresapole .= @$this->context["mesto"];
                            if  (@$this->context["psc"])    {  $adresapole .= ", " . @$this->context["psc"]; }
                        } else {
                             if  (@$this->context["psc"])  {$adresapole .=  @$this->context["psc"];}
                        }
                    }
                    $stranaUcastnik->PridejBunku("bydliště: ", $adresapole,1);
                    $stranaUcastnik->PridejBunku("nar.: ", @$this->context["datum_narozeni"],1);
                    $stranaUcastnik->PridejBunku("identifikační číslo zájemce: ", @$this->context["identifikator"],1);
            $dohoda1 = new Projektor2_PDF_Blok;
                    $dohoda1->Nadpis("Prohlášení");
                    $dohoda1->ZarovnaniNadpisu("C");
                    $dohoda1->VyskaPismaNadpisu(12);
            $pdf->AddPage();   //uvodni stranka
            $pdf->TiskniBlok($titulka1);
            $pdf->TiskniBlok($titulka2);
            $pdf->TiskniSaduBunek($stranaUcastnik);
            $pdf->TiskniBlok($dohoda1);
        //**********************************************
        $blok = new Projektor2_PDF_Blok;
            $blok->Odstavec("V souladu se zákonem č.101/2000 Sb. v platném znění tímto výslovně prohlašuji, že souhlasím se zpracováním, užitím a uchováním veškerých mých osobních a citlivých údajů správcem a zpracovatelem údajů, kterým je Grafia, společnost s ručením omezeným, sídlo: Budilova 1511/4, 301 21 Plzeň, IČ: 47714620, získaných při realizaci projektu Help 50+ v rozsahu uvedeném v mnou poskytnuté dokumentaci (Dohoda o účasti v projektu, registrační dotazník, strukturovaný životopis, reference apod.) a v rozsahu mnou osobně sdělených údajů zaznamenaných pracovníkem správce a včetně informací získaných při testování, pohovorech, pracovní diagnostice, zjišťování kulturních, týmových či osobnostních způsobilostí a kompetencí a to zejména pro účely zprostředkování zaměstnání a mé prezentace potenciálnímu zaměstnavateli jako příjemci.");
            $blok->PridejOdstavec("Konkrétně se jedná o základní osobní údaje (např. jméno a příjmení, datum a místo narození, rodinný stav, občanství, pohlaví, získané tituly), údaj o zdravotním stavu potřebný pro posouzení nezbytně dobrého zdravotního stavu v povoláních vyžadujících zvýšenou fyzickou a psychickou odolnost, dále o podrobné informace týkající se kontaktních údajů včetně trvalého bydliště, získaného vzdělání, současného mého postavení na trhu práce a získané dosavadní praxe, znalostí a dovedností, zdravotního stavu, představ a požadavků na mnou hledanou práci a dalších souvisejících údajů.");
            $blok->PridejOdstavec("Výslovně souhlasím s tím, aby mnou poskytnuté osobní údaje byly společností Grafia předány potenciálním zaměstnavatelům  v postavení uživatele osobních údajů.");
            $blok->PridejOdstavec("Tento souhlas uděluji společnosti Grafia s.r.o., se sídlem Plzeň, Budilova 4, IČO: 47714620 (dále jen Grafia), jakožto správci, a to na dobu 3 let ode dne poslední aktualizace informací.");
            $blok->PridejOdstavec("Pokud předám svůj životopis, průvodní dopis, dotazník, doklady o vzdělání a praxi, reference, jiné podklady a doklady či jejich kopie, ve kterých budou uvedena osobní data, beru na vědomí, že Grafia, s.r.o. nenese za ochranu v nich uvedených osobních dat žádnou odpovědnost. V případě předání takových podkladů a dokladů či jejich kopií souhlasím s tím, že tyto doklady budou předány potenciálnímu zaměstnavateli nebo budou pro potenciálního zaměstnavatele zhotoveny jejich kopie.");
            $blok->PridejOdstavec("Byl jsem seznámen se skutečností, že zaměstnanci správce, jiné fyzické osoby, které zpracovávají osobní údaje na základě smlouvy se správcem nebo zpracovatelem, a další osoby, které v rámci plnění zákonem stanovených oprávnění a povinností přicházejí do styku s osobními údaji u správce nebo zpracovatele, jsou povinni zachovávat mlčenlivost o osobních údajích a o bezpečnostních opatřeních, jejichž zveřejnění by ohrozilo zabezpečení osobních údajů.");
            $blok->PridejOdstavec("Je mi známo, že mohu kdykoli výše uvedené souhlasy odvolat.");
            $blok->Radkovani(1.25);
        $pdf->TiskniBlok($blok);

        $podpisy = new Projektor2_PDF_SadaBunek();

            $podpisy->PridejBunku("Kontaktní kancelář: ", @$this->context['kancelar_plny_text'], 1);
            $podpisy->PridejBunku("Dne ", @$this->context["datum_vytvor_smlouvy"],1);
            $podpisy->NovyRadek(0,1);
            $podpisy->PridejBunku("                       Zájemce:","",1);
            $podpisy->NovyRadek(0,3);
            //  $podpisy->NovyRadek(0,3);
            $podpisy->PridejBunku("                       ......................................................","",1);
            $podpisy->PridejBunku("                           " . str_pad($celeJmeno, 30, " ", STR_PAD_BOTH),"",1);
    //	$podpisy->PridejBunku("                           " . $celeJmeno . "                                                                         " . $User->name,"",1);

            //$podpisy->PridejBunku("                                     podpis účastníka                                                                podpis, jméno a příjmení","",1);
            $podpisy->NovyRadek();

                $pdf->Ln(5);
        $pdf->TiskniSaduBunek($podpisy, 0, 1);
        //**********************************************
        return $pdf;
    }
}

?>
