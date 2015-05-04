<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AgpSmlouva
 *
 * @author pes2704
 */
class Projektor2_View_PDF_AgpSmlouva extends Projektor2_View_PDF_Base{
    const FILE_NAME_PREFIX = "AGP_smlouva ";
    
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
                        $pdfpaticka->Odstavec("Dohoda o zprostředkování zaměstnání v projektu Personal Service  Zájemce: ".self::FILE_NAME_PREFIX.  @$this->context["identifikator"]."\n");
                        $pdfpaticka->zarovnani("C");
                        $pdfpaticka->vyskaPisma(6);
                        $pdfpaticka->cislovani = true;
        //**********************************************             

    $titulka1 = new Projektor2_PDF_Blok;
            $titulka1->Nadpis("DOHODA O ZPROSTŘEDKOVÁNÍ ZAMĚSTNÁNÍ ");
            $titulka1->ZarovnaniNadpisu("C");
            $titulka1->VyskaPismaNadpisu(14);
    $titulka2 = new Projektor2_PDF_Blok;
            $titulka2->Nadpis('„Personal Service“');
            $titulka2->ZarovnaniNadpisu("C");
            $titulka2->VyskaPismaNadpisu(14);

    $strany = new Projektor2_PDF_Blok;
            $strany->Nadpis("S t r a n y   d o h o d y ");
            $strany->ZarovnaniNadpisu("L");
            $strany->VyskaPismaNadpisu(11);

    $stranaPrijemce = new Projektor2_PDF_Blok;
            $stranaPrijemce->Odstavec("Grafia, společnost s ručením omezeným" . chr(13) . chr(10).
                                "zapsaná v obchodním rejstříku vedeném Krajským soudem v Plzni, odd. C, vl. 3067" . chr(13) . chr(10).
                                "sídlo: Plzeň, Budilova 4, PSČ 301 21" . chr(13) . chr(10).
                                "zastupující: Mgr. Jana Brabcová, jednatelka společnosti" . chr(13) . chr(10).
                                "IČ: 47714620" . chr(13) . chr(10).
                                "DIČ: CZ 47714620" . chr(13) . chr(10).
                                "bankovní spojení: ČSOB" . chr(13) . chr(10).
                                "č. účtu:  275795033/0300" . chr(13) . chr(10).
                                "zapsán v obchodním rejstříku vedeném Krajským soudem v Plzni, v oddílu C vložka 3067" . chr(13) . chr(10).
                                "(dále jen „Dodavatel“)" . chr(13) . chr(10));
    $a = new Projektor2_PDF_Blok;
	    $a->Odstavec("a        ");

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
//    $stranaUcastnik = new Projektor2_PDF_SadaBunek();
//	          $celeJmeno =  @$this->pdfpole["titul"]." ".@$this->pdfpole["jmeno"]." ".@$this->pdfpole["prijmeni"];
//	          if (@$this->pdfpole["titul_za"])
//		  {
//			$celeJmeno = $celeJmeno.", ".@$this->pdfpole["titul_za"];
//		  }
//	    $stranaUcastnik->PridejBunku("jméno, příjmení, titul: ", $celeJmeno,1);
//		$adresapole="";
//                if (@$this->pdfpole["ulice"]) {
//                    $adresapole .=   @$this->pdfPole["ulice"];
//                    if  (@$this->pdfpole["mesto"])  {  $adresapole .=  ", ".   @$this->pdfpole["mesto"];}
//                    if  (@$this->pdfpole["psc"])    {  $adresapole .= ", " . @$this->pdfpole["psc"]; }
//                }
//                else {
//                    if  (@$this->pdfpole["mesto"])  {
//                        $adresapole .= @$this->pdfpole["mesto"];
//                        if  (@$this->pdfpole["psc"])    {  $adresapole .= ", " . @$this->pdfpole["psc"]; }
//                    }
//                    else {
//                         if  (@$this->pdfpole["psc"])  {$adresapole .=  @$this->pdfpole["psc"];}
//                    }
//                }
//            $stranaUcastnik->PridejBunku("bydliště: ", $adresapole,1);
//
//	    $stranaUcastnik->PridejBunku("nar.: ", @$this->pdfpole["datum_narozeni"],1);

		$adresapole="";
                if (@$this->context["ulice2"]) {
                    $adresapole .=   @$this->context["ulice2"];
                    if  (@$this->context["mesto2"])  {  $adresapole .= ", " . @$this->context["mesto2"];}
                    if  (@$this->context["psc2"])    {  $adresapole .= ", " . @$this->context["psc2"]; }
                }
                else {
                    if  (@$this->context["mesto2"])  {
                        $adresapole .= @$this->context["mesto2"];
                        if  (@$this->context["psc2"])   {  $adresapole .= ", " . @$this->context["psc2"]; }
                    }
                    else {
                         if  (@$this->context["psc2"])  {  $adresapole .= @$this->context["psc2"];}
                    }
                }
            if  ($adresapole)   {
                $stranaUcastnik->PridejBunku( "adresa dojíždění odlišná od místa bydliště: ", $adresapole,1);
            }

	    $stranaUcastnik->PridejBunku("identifikační číslo zájemce: ", @$this->context["identifikator"],1);
	    $stranaUcastnik->PridejBunku("(dále jen „Zájemce“)", "",1);


    $spolecneUzaviraji1 = new Projektor2_PDF_Blok;
	$spolecneUzaviraji1->Odstavec("Dodavatel a Zájemce společně (dále jen „Strany dohody“) a každý z nich (dále jen „Strana dohody“)");
			     //chr(13) . chr(10). chr(13) . chr(10). chr(13) . chr(10).chr(13) . chr(10).
    $spolecneUzaviraji2 = new Projektor2_PDF_Blok;
	$spolecneUzaviraji2->Odstavec("uzavírají níže uvedeného dne, měsíce a roku tuto" );

    $dohoda1 = new Projektor2_PDF_Blok;
	    $dohoda1->Nadpis("DOHODA O ZPROSTŘEDKOVÁNÍ ZAMĚSTNÁNÍ ");
	    $dohoda1->ZarovnaniNadpisu("C");
            $dohoda1->VyskaPismaNadpisu(12);
    $dohoda2 = new Projektor2_PDF_Blok;
	    $dohoda2->Nadpis("„Personal Service“");
	    $dohoda2->ZarovnaniNadpisu("C");
            $dohoda2->VyskaPismaNadpisu(12);


        $pdf->AddPage();   //uvodni stranka
        $pdf->Ln(100);
        $pdf->TiskniBlok($titulka1);
        $pdf->TiskniBlok($titulka2);



  	$pdf->AddPage();   //dalsi stranky

	$pdf->Ln(5);

        $pdf->TiskniBlok($strany);
	$pdf->Ln(10);
        $pdf->TiskniBlok($stranaPrijemce);

	$pdf->Ln(10);
	$pdf->TiskniBlok($a);

        $pdf->Ln(10);
        $pdf->TiskniSaduBunek($stranaUcastnik);

	$pdf->Ln(10);
	$pdf->TiskniBlok($spolecneUzaviraji1);
	$pdf->Ln(5);
	$pdf->TiskniBlok($spolecneUzaviraji2);

	$pdf->Ln(15);
	$pdf->TiskniBlok($dohoda1);
	$pdf->TiskniBlok($dohoda2);

	$pdf->AddPage();   //cislovane odstavce
//*************************************************************************************

$odstavec1 = new Projektor2_PDF_Blok;
    $odstavec1 -> Nadpis("1. PREAMBULE");
    $odstavec1->Odstavec("1.1 Projekt „Personal Service“ je projekt společnosti Grafia, s.r.o., Plzeň.");
    $odstavec1->PridejOdstavec("1.2 Hlavním cílem aktivit projektu „Personal Service“  pro Zájemce je zprostředkování zaměstnání. Zprostředkováním zaměstnání pro účly této dohody se rozumí vyhledání zaměstnání pro fyzickou osobu, která se o práci uchází (Zájemce), a vyhledání zaměstnanců pro zaměstnavatele, který hledá nové pracovní síly.");
    $odstavec1->predsazeni(6);
    $odstavec1->odsazeniZleva(6);
    $pdf->TiskniBlok($odstavec1);

$odstavec2 = new Projektor2_PDF_Blok;
    $odstavec2 -> Nadpis("2. Předmět dohody");
    $odstavec2->Odstavec("2.1. Předmětem dohody je stanovení podmínek účasti Zájemce na aktivitách projektu Personal Service a úprava práv a povinností Stran dohody při realizaci těchto aktivit.");
    $odstavec2->predsazeni(6);
    $odstavec2->odsazeniZleva(6);
    $pdf->TiskniBlok($odstavec2);

$odstavec3 = new Projektor2_PDF_Blok;
    $odstavec3 -> Nadpis("3. Povinnosti a práva Zájemce o služby projektu „Personal Service“");
    $odstavec3->Odstavec("3.1. Zájemce potvrzuje, že se účastnil vstupní schůzky, kde sdělil údaje pro tuto dohodu a registrační dotazník. Současně Zájemce souhlasí se zpracováním osobních údajů pro účely zprostředkování zaměstnání a poskytování dalších služeb projektu Personal Service.");
    $odstavec3->PridejOdstavec("3.2. Zájemce se zavazuje k tomu, že se bude v dohodnutých termínech účastnit schůzek a dalších aktivit projektu Personal Service. Zájemce se zavazuje, že poskytne Dodavateli v maximální míře kopie dokladů osvědčujících uváděné skutečnosti, zejména doklady o ukončeném vzdělání, kurzech a předchozích zaměstnáních. Porušení těchto závazků může být důvodem okamžité výpovědi této dohody ze strany Dodavatele. ");
    $odstavec3->PridejOdstavec("3.3. Zájemce se zavazuje bezodkladně informovat Dodavatele o všech skutečnostech, souvisejících s jeho účastí na projektu, zejména o důvodech absence na aktivitách projektu a o překážkách bránících mu v účasti na pohovorech a výběrových řízeních u potenciálních zaměstnavatelů.");
    $odstavec3->PridejOdstavec("3.4. Zájemce souhlasí se zařazením do databáze zájemců o zaměstnání Personal service, kterou vlastní Dodavatel, a s poskytováním osobních, vzdělanostních, kvalifikačních a dalších údajů potenciálním zaměstnavatelům za účelem zprostředkování zaměstnání u těchto zaměstnavatelů.");
    $odstavec3->PridejOdstavec("3.5. Zájemce, který získal zaměstnání anebo se sebezaměstnal v průběhu své účasti v projektu anebo kdykoli v případě, že získal zaměstnání na základě doporučení Dodavatele:");
    $odstavec3->predsazeni(6);
    $odstavec3->odsazeniZleva(6);
    $pdf->TiskniBlok($odstavec3);

$odstavec3_5 = new Projektor2_PDF_Blok;
    $odstavec3_5->Odstavec("a)   zavazuje se informovat do 3 pracovních dnů Dodavatele o této skutečnosti");
    $odstavec3_5->PridejOdstavec("b)   souhlasí se svým uvedením v seznamu osob, které získaly pomocí služeb Personal Service zaměstnání anebo se sebezaměstnaly, a to bez uvedení osobních údajů, tedy anonymně.");
    $odstavec3_5->PridejOdstavec("c)   Zájemce, který získal zaměstnání na základě doporučení Dodavatele, se zavazuje dodat Dodavateli kopii těch částí své uzavřené pracovní smlouvy, dohody či obdobné smlouvy, z nichž bude zřejmý zaměstnavatel, datum zahájení pracovního poměru, pracovní pozice, případně náplň práce. Zájemce může poskytnout i údaj o své skutečné nástupní mzdě nebo platu, pokud se nezavázal tento údaj nesdělovat a pokud to sám uzná za přijatelné.");
    $odstavec3_5->predsazeni(6);
    $odstavec3_5->odsazeniZleva(14);
    $pdf->TiskniBlok($odstavec3_5);

$odstavec4 = new Projektor2_PDF_Blok;
    $odstavec4->Nadpis("4. Ukončení dohody");
    $odstavec4->Odstavec("4.1. Tuto dohodu lze ukončit dohodou stran nebo jednostranou výpovědí jedné smluvní strany. K ukončení účasti výpovědí dojde dnem, kdy byla výpověď doručena druhé smluvní straně.");
    $odstavec4->PridejOdstavec("4.2. Ukončením Dohody zanikají veškeré závazky z této Dohody s výjimkou závazků dle bodu 3.5 . ");
    $odstavec4->predsazeni(6);
    $odstavec4->odsazeniZleva(6);
    $pdf->TiskniBlok($odstavec4);

$odstavec5 = new Projektor2_PDF_Blok;
    $odstavec5->Nadpis("5. Povinnosti dodavatele");
    $odstavec5->Odstavec("5.1. Dodavatel se zavazuje poskytnout Zájemci zdarma aktivity projektu bezprostředně související se zprostředkováním zaměstnání. Na případné další služby a dodávky se tato dohoda nevztahuje.");
    $odstavec5->PridejOdstavec("5.2. Dodavatel se bude snažit v součinnosti s potenciálním zaměstnavatelem co nejlépe informovat Zájemce o všech podmínkách účasti na pohovorech a výběrových řízeních (například o termínech, místech, nutných dokladech či jejich kopiích, potvrzení od lékaře, nutného očkování).");
    $odstavec5->predsazeni(6);
    $odstavec5->odsazeniZleva(6);
    $pdf->TiskniBlok($odstavec5);


$odstavec6 = new Projektor2_PDF_Blok;
    $odstavec6->Nadpis("6. Závěrečná ustanovení");
    $odstavec6->Odstavec("6.1. Tuto Dohodu lze měnit či doplňovat pouze po dohodě smluvních stran formou písemných a číslovaných dodatků.");
    $odstavec6->PridejOdstavec("6.2. Tato Dohoda je sepsána ve dvou vyhotoveních s platností originálu, přičemž Zájemce i Dodavatel obdrží po jednom vyhotovení.");
    $odstavec6->PridejOdstavec("6.3. Tato Dohoda nabývá platnosti a účinnosti dnem jejího podpisu oběma smluvními stranami; tímto dnem jsou její účastníci svými projevy vázáni.");
    $odstavec6->PridejOdstavec("6.4. Dodavatel i Zájemce shodně prohlašují, že si tuto Dohodu před jejím podpisem přečetli, že byla uzavřena podle jejich pravé a svobodné vůle, určitě, vážně a srozumitelně, nikoliv v tísni za nápadně nevýhodných podmínek. Smluvní strany potvrzují autentičnost této Dohody svým podpisem.");
    $odstavec6->predsazeni(6);
    $odstavec6->odsazeniZleva(6);
    $pdf->TiskniBlok($odstavec6);

$podpisy = new Projektor2_PDF_SadaBunek();
      /*  $kk = @$this->pdfpole["z_up"];
        if ( @$this->pdfpole["z_up"] == "Klatovy")
        {
        	if (@$this->pdfpole["prac_up"] <> "Klatovy - pracoviště Klatovy")
        	{
        		$kk = "Sušice";
        	}
        }   */

    	$podpisy->PridejBunku("Kontaktní kancelář: ", @$this->context['kancelar_plny_text'], 1);
    	$podpisy->PridejBunku("Dne ", @$this->pdfpole["datum_vytvor_smlouvy"],1);
	$podpisy->NovyRadek(0,1);
	$podpisy->PridejBunku("                       Zájemce:                                                                                   Dodavatel:","",1);
        $podpisy->NovyRadek(0,5);
        //  $podpisy->NovyRadek(0,3);
    	$podpisy->PridejBunku("                       ......................................................                                            ......................................................","",1);
     	$podpisy->PridejBunku("                           " . str_pad(str_pad($celeJmeno, 30, " ", STR_PAD_BOTH) , 92) . @$this->context['user_name'],"",1);
//	$podpisy->PridejBunku("                           " . $celeJmeno . "                                                                         " . $User->name,"",1);

        //$podpisy->PridejBunku("                                     podpis účastníka                                                                podpis, jméno a příjmení","",1);
	$podpisy->PridejBunku("                                                                                                                                    okresní koordinátor","");
        $podpisy->NovyRadek();



//**********************************************




        $pdf->Ln(20);
        $pdf->TiskniSaduBunek($podpisy, 0, 1);
        
        return $pdf;
    }
}

?>
