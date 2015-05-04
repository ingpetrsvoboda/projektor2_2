<?php
/**
 * Kontajner na globalni promenne
 * @author Petr Svoboda
 */

abstract class Projektor2_AppContext
{
    const DEFAULT_DB_NICK = 'projektor';
    
    /**
     *
     * @var Framework_Database_HandlerSqlInterface 
     */
    private static $db = array();

    /**
     * Metoda vrací objekt pro přístup k databázi. Metoda se podle označení databáze (nick) zadaném jako prametr rozhoduje, 
     * který objekt pro přístup k databázi vytvoří. Ke každé databázi vytváří jednu instanci objektu.
     * @param string $nick Označení databáze používané v tomto projektu
     * @return Framework_Database_HandlerSqlInterface
     * @throws UnexpectedValueException
     */
    public static function getDB($nick = self::DEFAULT_DB_NICK)
    {
        switch ($nick) {
            case 'projektor':
                if(!self::$db['projektor']) {
//                    $dbh = new Framework_Database_HandlerSqlMysql_Radon();
                    $dbh = new Framework_Database_HandlerSqlMysql_Localhost();
                    self::$db['projektor'] = $dbh;
                }
                return self::$db['projektor'];

                break;

            default:
                throw new UnexpectedValueException('Neznámy název databáze '.$nick.'.');
        }
    }
    
    public static function getDefaultDatabaseName() {
        return 'projektor';
    }
    
    public static function getAktivityProjektu($kod=NULL) {
        switch ($kod) {
######## AP #################            
            case 'AP':
    $aktivity = array(
            'zztp'=>array(
                'typ'=>'kurz', 
                'vyberovy'=> 0,
                'nadpis'=>'Kurz základních znalostí trhu práce', 
                's_certifikatem' => TRUE,
                'help'=>'Příklady známek a slovního zhodnocení Motivačního programu<br> 
    1 = Účastník absolvoval kurz v plném rozsahu a se stoprocentní docházkou.<br>
    2 = Účastník úspěšně absolvoval kurz, jeho docházka byla postačující.<br>
    3 = Kurz účastník neabsolvoval v plném rozsahu, jeho účast na kurzu byla minimální.<br>'
                ), 
        
            'fg'=>array(
                'typ'=>'kurz', 
                'vyberovy'=> 0,
                'nadpis'=>'Kurz finanční gramotnosti', 
                's_certifikatem' => TRUE,
                'help'=>'Příklady známek a slovního zhodnocení Rekvalifikačního kurzu<br>
    Rekvalifikační kurzy (známku 3 a 5  je možné použít i jako doporučení pro ÚP)<br>
    1 = Účastník měl jasnou představu o dalším doplňujícím vzdělání. Rekvalifikační kurz, který si zvolil, úspěšně absolvoval, a pomohl mu najít odpovídající zaměstnání.<br>
    2 = Účastník projevoval během účasti v projektu aktivní zájem o možnosti svého dalšího vzdělávání. Vybral si proto odpovídající kurz podle svých dosavadních znalostí a vědomostí. Bohužel díky osobním problémům (nebo zdravotním komplikací nebo rodinným problémům) nemohl vybraný kurz dokončit. Bylo by zřejmě rozumné umožnit Účastníkovi absolvovat tento kurz znovu, pokud bude naplánován.<br>
    3 = Účastník si vzhledem ke svému dosavadnímu vzdělání a dosavadní činnosti vybral odpovídající kurz s cílem zaměstnání v požadovaném oboru. Bohužel nebyl tento kurz do harmonogramu kurzů zařazen. Proto doporučujeme konzultantům Úřadu práce, aby jmenovanému umožnili tento kurz, pokud bude plánován, absolvovat. Jmenovanému se zatím, přes zřejmou snahu, nepodařilo najít zaměstnání.<br>
    5 = Účastník pasivně přistupoval k výběru vhodného rekvalifikačního kurzu. Doporučení okresního koordinátora projektu ignoroval  a nejevil zájem o další vzdělávání.<br>'
                ), 
        
            'pc1'=>array(
                'typ'=>'kurz', 
                'vyberovy'=> 0,
                'nadpis'=>'Kurz komunikace včetně obsluhy PC', 
                's_certifikatem' => TRUE,
                'help'=>'Příklady známek a slovního zhodnocení Kurzu obsluhy PC<br>
    1 = Účastník Kurz obsluhy PC absolvoval s maximální úspěšností a stoprocentní docházkou.<br> 
    3 = Účastník úspěšně absolvoval a Kurz obsluhy PC.<br>
    5 = Kurz obsluhy PC neabsolvoval účastník v plném rozsahu. Jeho docházka nebyla dostačující.<br>'
                ), 
 
            'im'=>array(
                'typ'=>'kurz', 
                'vyberovy'=> 1,
                'nadpis'=>'Image poradna', 
                's_certifikatem' => TRUE,
                'help'=>'Image poradna'
                ), 
        
            'spp'=>array(
                'typ'=>'kurz', 
                'vyberovy'=> 1,
                'nadpis'=>'Motivační setkání pro podnikavé', 
                's_certifikatem' => TRUE,
                'help'=>'Motivační setkání pro podnikavé'
                ), 

            'sebas'=>array(
                'typ'=>'kurz', 
                'vyberovy'=> 1,
                'nadpis'=>'Podpora sebevědomí a asertivita', 
                's_certifikatem' => TRUE,
                'help'=>'Podpora sebevědomí a asertivita'
                ), 
        
            'forpr'=>array(
                'typ'=>'kurz', 
                'vyberovy'=> 1,
                'nadpis'=>'Moderní formy práce', 
                's_certifikatem' => TRUE,
                'help'=>'Moderní formy práce'
                ),         
        
            'prdi'=>array(
                'typ'=>'kurz', 
                'vyberovy'=> 1,
                'nadpis'=>'Pracovní diagnostika', 
                's_certifikatem' => FALSE,
                'help'=>'Help Pracovní diagnostika'), 
        
            'porad'=>array(
                'typ'=>'poradenstvi', 
                'vyberovy'=> 0,
                'nadpis'=>'Individuální poradenství a zprostředkování zaměstnání', 
                's_hodnocenim' => FALSE,
                's_certifikatem' => FALSE,
                'help'=>'Příklady známek a slovního zhodnocení spolupráce s poradcem<br>
    1 = Klient se projektu zúčastnil úspěšně a aktivně spolupracoval s okresním koordinátorem projektu. Společně s ním se snažil najít uplatnění na trhu práce, docházel na všechny smluvené konzultace, zúčastňoval se klubových setkání. Sám aktivně vyhledával volné pracovní pozice ve svém regionu.<br>
    3 = Projektu se klient zúčastnil s ohledem na jeho možnosti (rodinné poměry, zdravotní problémy atd.) úspěšně. Vyvíjel snahu ve spolupráci s okresním koordinátorem, docházel na klubová setkání. Aktivně vyhledával za pomoci koordinátora projektu volné pracovní pozice ve svém regionu.<br>
    5 = Aktivity projektu klient absolvoval s nedostatečnou účastí. S okresním poradcem projektu spolupracoval na základě opakovaných výzev, klubových setkání se neúčastnil.<br>'), 
        
            'klub'=>array(
                'typ'=>'poradenstvi', 
                'vyberovy'=> 1,
                'nadpis'=>'Klubová setkání', 
                's_hodnocenim' => FALSE,
                's_certifikatem' => FALSE,
                'help'=>'Klubová setkání'
                ), 
        
            'doporuceni'=>array(
                'typ'=>'poradenstvi', 
                'vyberovy'=> 0,
                'nadpis'=>'Doporučení při ukončení účasti', 
                's_hodnocenim' => TRUE,
                's_certifikatem' => FALSE,
                'help'=>'Příklady známek a slovního zhodnocení<br>
    1 = Účastník vyvíjí maximální snahu ve zdokonalování svých znalostí a dovedností a také v hledání zaměstnání. S pomocí konzultanta z Úřadu práce by měl najít vhodné zaměstnání.<br>
    2 = Účastník se zúčastnil projektu aktivně, jeho uplatnění na trhu práce je velmi pravděpodobné. S pomocí konzultanta z Úřadu práce by mohl najít vhodné zaměstnání.<br>
    3 = Účast Účastníka na aktivitách projektu byla uspokojivá, jmenovaný vyvíjel průměrné úsilí v hledání zaměstnání. Konzultantům na Úřadu práce doporučujeme, aby pokračovali ve snaze motivovat jmenovaného při uplatnění se na trhu práce.<br>
    4 = S přihlédnutím na pasivní účast účastníka v aktivitách projektu je možné konstatovat, že jmenovaný nevyvíjí optimální snahu ve zdokonalování svých znalostí a dovedností a rovněž v hledání zaměstnání. Tedy jeho uplatnění na trhu práce  podle nás závisí na podpoře a pomoci konzultantů Úřadu práce.<br>
    5 = Vzhledem ke zkušenostem z jednání a konzultací s účastníkem lze konstatovat, že jmenovaný nevyvíjí optimální snahu ve zdokonalování svých znalostí a dovedností a rovněž v hledání zaměstnání. Možnost uplatnění účastníka je tedy na trhu práce poněkud omezená, zřejmě by potřeboval intenzivní pomoc konzultantů Úřadu práce.<br>'), 
            );  

                break;
######## HELP #################            
            case 'HELP':
            default:

    $aktivity = array(
            'mot'=>array(
                'typ'=>'kurz', 
                'nadpis'=>'Motivační kurz', 
                's_certifikatem' => TRUE,
                'help'=>'Příklady známek a slovního zhodnocení Motivačního programu<br> 
    1 = Účastník absolvoval kurzy Motivačního programu v plném rozsahu a se stoprocentní docházkou.<br>
    2 = Účastník úspěšně absolvoval kurzy Motivačního programu, jeho docházka byla postačující.<br>
    3 = Kurzy Motivačního programu účastník neabsolvoval v plném rozsahu, jeho účast na kurzu byla minimální.<br>'
                ), 
            'pc1'=>array(
                'typ'=>'kurz', 
                'nadpis'=>'PC kurz', 
                's_certifikatem' => TRUE,
                'help'=>'Příklady známek a slovního zhodnocení Kurzu obsluhy PC<br>
    1 = Účastník Kurz obsluhy PC absolvoval s maximální úspěšností a stoprocentní docházkou.<br> 
    3 = Účastník úspěšně absolvoval a Kurz obsluhy PC.<br>
    5 = Kurz obsluhy PC neabsolvoval účastník v plném rozsahu. Jeho docházka nebyla dostačující.<br>'
                ), 
            'prof1'=>array(
                'typ'=>'kurz', 
                'nadpis'=>'Rekvalifikační kurz 1', 
                's_certifikatem' => TRUE,
                'help'=>'Příklady známek a slovního zhodnocení Rekvalifikačního kurzu<br>
    Rekvalifikační kurzy (známku 3 a 5  je možné použít i jako doporučení pro ÚP)<br>
    1 = Účastník měl jasnou představu o dalším doplňujícím vzdělání. Rekvalifikační kurz, který si zvolil, úspěšně absolvoval, a pomohl mu najít odpovídající zaměstnání.<br>
    2 = Účastník projevoval během účasti v projektu aktivní zájem o možnosti svého dalšího vzdělávání. Vybral si proto odpovídající kurz podle svých dosavadních znalostí a vědomostí. Bohužel díky osobním problémům (nebo zdravotním komplikací nebo rodinným problémům) nemohl vybraný kurz dokončit. Bylo by zřejmě rozumné umožnit Účastníkovi absolvovat tento kurz znovu, pokud bude naplánován.<br>
    3 = Účastník si vzhledem ke svému dosavadnímu vzdělání a dosavadní činnosti vybral odpovídající kurz s cílem zaměstnání v požadovaném oboru. Bohužel nebyl tento kurz do harmonogramu kurzů zařazen. Proto doporučujeme konzultantům Úřadu práce, aby jmenovanému umožnili tento kurz, pokud bude plánován, absolvovat. Jmenovanému se zatím, přes zřejmou snahu, nepodařilo najít zaměstnání.<br>
    5 = Účastník pasivně přistupoval k výběru vhodného rekvalifikačního kurzu. Doporučení okresního koordinátora projektu ignoroval  a nejevil zájem o další vzdělávání.<br>'
                ), 
            'prof2'=>array(
                'typ'=>'kurz', 
                'nadpis'=>'Rekvalifikační kurz 2', 
                's_certifikatem' => TRUE,
                'help'=>'Příklady známek a slovního zhodnocení Rekvalifikačního kurzu<br>
    Rekvalifikační kurzy (známku 3 a 5  je možné použít i jako doporučení pro ÚP)<br>
    1 = Účastník měl jasnou představu o dalším doplňujícím vzdělání. Rekvalifikační kurz, který si zvolil, úspěšně absolvoval, a pomohl mu najít odpovídající zaměstnání.<br>
    2 = Účastník projevoval během účasti v projektu aktivní zájem o možnosti svého dalšího vzdělávání. Vybral si proto odpovídající kurz podle svých dosavadních znalostí a vědomostí. Bohužel díky osobním problémům (nebo zdravotním komplikací nebo rodinným problémům) nemohl vybraný kurz dokončit. Bylo by zřejmě rozumné umožnit Účastníkovi absolvovat tento kurz znovu, pokud bude naplánován.<br>
    3 = Účastník si vzhledem ke svému dosavadnímu vzdělání a dosavadní činnosti vybral odpovídající kurz s cílem zaměstnání v požadovaném oboru. Bohužel nebyl tento kurz do harmonogramu kurzů zařazen. Proto doporučujeme konzultantům Úřadu práce, aby jmenovanému umožnili tento kurz, pokud bude plánován, absolvovat. Jmenovanému se zatím, přes zřejmou snahu, nepodařilo najít zaměstnání.<br>
    5 = Účastník pasivně přistupoval k výběru vhodného rekvalifikačního kurzu. Doporučení okresního koordinátora projektu ignoroval  a nejevil zájem o další vzdělávání.<br>'
                ), 
            'prof3'=>array(
                'typ'=>'kurz', 
                'nadpis'=>'Rekvalifikační kurz 3', 
                's_certifikatem' => TRUE,
                'help'=>'Příklady známek a slovního zhodnocení Rekvalifikačního kurzu<br>
    Rekvalifikační kurzy (známku 3 a 5  je možné použít i jako doporučení pro ÚP)<br>
    1 = Účastník měl jasnou představu o dalším doplňujícím vzdělání. Rekvalifikační kurz, který si zvolil, úspěšně absolvoval, a pomohl mu najít odpovídající zaměstnání.<br>
    2 = Účastník projevoval během účasti v projektu aktivní zájem o možnosti svého dalšího vzdělávání. Vybral si proto odpovídající kurz podle svých dosavadních znalostí a vědomostí. Bohužel díky osobním problémům (nebo zdravotním komplikací nebo rodinným problémům) nemohl vybraný kurz dokončit. Bylo by zřejmě rozumné umožnit Účastníkovi absolvovat tento kurz znovu, pokud bude naplánován.<br>
    3 = Účastník si vzhledem ke svému dosavadnímu vzdělání a dosavadní činnosti vybral odpovídající kurz s cílem zaměstnání v požadovaném oboru. Bohužel nebyl tento kurz do harmonogramu kurzů zařazen. Proto doporučujeme konzultantům Úřadu práce, aby jmenovanému umožnili tento kurz, pokud bude plánován, absolvovat. Jmenovanému se zatím, přes zřejmou snahu, nepodařilo najít zaměstnání.<br>
    5 = Účastník pasivně přistupoval k výběru vhodného rekvalifikačního kurzu. Doporučení okresního koordinátora projektu ignoroval  a nejevil zájem o další vzdělávání.<br>'
                ), 
            'im'=>array(
                'typ'=>'kurz', 
                'nadpis'=>'Image poradna', 
                's_certifikatem' => TRUE,
                'help'=>'Help Image poradna'
                ), 
            'spp'=>array(
                'typ'=>'kurz', 
                'nadpis'=>'Setkání pro podnikavé', 
                's_certifikatem' => TRUE,
                'help'=>'Help Setkání pro podnikavé'), 
            'prdi'=>array(
                'typ'=>'kurz', 
                'nadpis'=>'Pracovní diagnostika', 
                's_certifikatem' => FALSE,
                'help'=>'Help Pracovní diagnostika'), 
            'porad'=>array(
                'typ'=>'poradenství', 
                'nadpis'=>'Individuální poradenství a zprostředkování zaměstnání', 
                's_certifikatem' => TRUE,
                'help'=>'Příklady známek a slovního zhodnocení spolupráce s poradcem<br>
    1 = Klient se projektu zúčastnil úspěšně a aktivně spolupracoval s okresním koordinátorem projektu. Společně s ním se snažil najít uplatnění na trhu práce, docházel na všechny smluvené konzultace, zúčastňoval se klubových setkání. Sám aktivně vyhledával volné pracovní pozice ve svém regionu.<br>
    3 = Projektu se klient zúčastnil s ohledem na jeho možnosti (rodinné poměry, zdravotní problémy atd.) úspěšně. Vyvíjel snahu ve spolupráci s okresním koordinátorem, docházel na klubová setkání. Aktivně vyhledával za pomoci koordinátora projektu volné pracovní pozice ve svém regionu.<br>
    5 = Aktivity projektu klient absolvoval s nedostatečnou účastí. S okresním poradcem projektu spolupracoval na základě opakovaných výzev, klubových setkání se neúčastnil.<br>'), 
            'doporuceni'=>array(
                'typ'=>'poradenství', 
                'nadpis'=>'Doporučení', 
                'help'=>'Příklady známek a slovního zhodnocení<br>
    1 = Účastník vyvíjí maximální snahu ve zdokonalování svých znalostí a dovedností a také v hledání zaměstnání. S pomocí konzultanta z Úřadu práce by měl najít vhodné zaměstnání.<br>
    2 = Účastník se zúčastnil projektu aktivně, jeho uplatnění na trhu práce je velmi pravděpodobné. S pomocí konzultanta z Úřadu práce by mohl najít vhodné zaměstnání.<br>
    3 = Účast Účastníka na aktivitách projektu byla uspokojivá, jmenovaný vyvíjel průměrné úsilí v hledání zaměstnání. Konzultantům na Úřadu práce doporučujeme, aby pokračovali ve snaze motivovat jmenovaného při uplatnění se na trhu práce.<br>
    4 = S přihlédnutím na pasivní účast účastníka v aktivitách projektu je možné konstatovat, že jmenovaný nevyvíjí optimální snahu ve zdokonalování svých znalostí a dovedností a rovněž v hledání zaměstnání. Tedy jeho uplatnění na trhu práce  podle nás závisí na podpoře a pomoci konzultantů Úřadu práce.<br>
    5 = Vzhledem ke zkušenostem z jednání a konzultací s účastníkem lze konstatovat, že jmenovaný nevyvíjí optimální snahu ve zdokonalování svých znalostí a dovedností a rovněž v hledání zaměstnání. Možnost uplatnění účastníka je tedy na trhu práce poněkud omezená, zřejmě by potřeboval intenzivní pomoc konzultantů Úřadu práce.<br>'), 
            );  
                break;
        }    
    return $aktivity;
    }
}
?>
