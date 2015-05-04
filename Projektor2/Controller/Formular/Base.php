<?php
/**
 * Description of Projektor2_Controller_Formular_Base
 *
 * @author pes2704
 */
abstract class Projektor2_Controller_Formular_Base implements Projektor2_Controller_ControllerInterface {

    /**
     * @var Projektor2_SessionStatus 
     */
    protected $sessionStatus;
    /**
     * @var Projektor2_Request 
     */
    protected $request;
    /**
     * @var Projektor2_Response 
     */
    protected $response;
    
    /**
     * Základní model formuláře - model, který je naplněn daty a ukládán při POST requestu
     * @var Framework_Model_ItemFlatTableAbstract 
     */
    protected $flatTable;
    /**
     * Další modely formuláře, které budou naplňovány daty a ukládání po odeslání fotmuláře-
     * @var type 
     */
    protected $models;
        
    public function __construct(Projektor2_SessionStatus $sessionStatus, Projektor2_Request $request, Projektor2_Response $response) {
        $this->sessionStatus = $sessionStatus;
        $this->request = $request;
        $this->response = $response;
    }
    
    /**
     * Potomkovské třídy musí implementovat matodu getFlatTable, která vrací vlastní flat table
     */
    abstract protected function createFormModels($zajemce);
    
    /**
     * Potomkovské třídy musí implementovat matodu getResultFormular, která vrací html kód vlastního formuláře
     */
    abstract protected function getResultFormular();
    
    /**
     * Potomkovské třídy musí implementovat metodu getResultPdf, která vytvoří pdf dokument a vrátí kód 
     * pro zobrazení pdf dokumentu v novém panelu prohlížeče.
     * Pokud k formuláři není přisružen pdf dokument, bude taková metoda prázdná.
     */
    abstract protected function getResultPdf();
    
    /**
     * Potomkovské třídy musí implementovat metodu getLeftMenu(), která vrací html kód levého menu
     */
    abstract protected function getLeftMenu();
            
    /**
     * Potomkovské třídy musí implementovat metodu getContentMenu(), která vrací html kód menu pro zobrazený obsah. 
     * Typicky menu pro volbu formulážů odpovídajících jednotlivým flat tabulkám jednoho hlavního objektu - pak se levé menu nemění, mění se jen 
     * zobrazený formulář
     */    
    abstract protected function getContentMenu();
    
    public function getResult() {
        if ($this->sessionStatus->zajemce) {
            $this->createFormModels($this->sessionStatus->zajemce);
        }
        if ($this->request->isPost()) {
            if (!$this->sessionStatus->zajemce) {
                return 'CHYBA - POST request volá '.__CLASS__.'->'.__METHOD__.' a není správně nastavena session cookie zájemce';
            }
            // ukládání dat
            if ($this->sessionStatus->user->povolen_zapis) {
                $this->setModelsFromPost($this->request->postArray());
                if ($this->flatTable) {
                    $this->flatTable->save();   
                }
                if ($this->models) {
                    foreach ($this->models as $model) {
                        $model->save();
                    }
                }
            }
        } else { // request == GET
                if($this->request->get('id_zajemce')){
                    // existující zájemce
                    $zajemce = Projektor2_Model_ZajemceMapper::findById($this->request->get('id_zajemce'));
                    $this->response->setCookie("id_zajemce", $this->request->get('id_zajemce'));            
                } else {
                    // nový zájemce
                    $zajemce = Projektor2_Model_ZajemceMapper::create();   
                    $this->createFormModels($tajemce);
                }
        }
        
        $htmlResult .= $this->getLeftMenu();
        // CONTENT
        $htmlResult .= "<div class='content'>";
        $htmlResult .= $this->getContentMenu();

        // chybové hlášení
        if($this->flatTable->chyby->pocet) {
            $chyby = new Projektor2_View_HTML_Chyby(array('chyby'=>$this->flatTable->chyby, 'info'=>'Chyby v ostatních datech:'));        
            $htmlResult .= $chyby->render();
        }        
        // formulář
        $htmlResult .= $this->getResultFormular();
        $htmlResult .= "</div>"; // KONEC <div class='content'>  
        // pdf
        if ($this->request->isPost() AND ($this->request->post('T1') OR $this->request->post('pdf')) AND !$this->flatTable->chyby->pocet) {
            $htmlResult .= $this->getResultPdf();
        }
        return $htmlResult;        
    }
    
    protected function createContextFromModels() {
        foreach ($this->models as $modelSign => $model) {
            $assoc = $model->getValuesAssoc();
            foreach ($assoc as $key => $value) {
                $context[$modelSign.'->'.$key] = $value;
            }
        }        
        return $context;
    }
    
    protected function setModelsFromPost($post) {
        foreach ($post as $key => $value) {
            $keys = explode('->', $key);
            $cnt = count($keys);
            switch ($cnt) {
                case 1:
                    $this->flatTable->$keys[0] = $value;
                    break;
                case 2:
                    if (array_key_exists($keys[0], $this->models)) {
                        $modelSignature = $keys[0];
                        $model = $this->models[$modelSignature];
                        $model->$keys[1] = $value;
                    } else {
                        throw new LogicException('Název post proměnné '.$key.' neodpovídá žádnému nastavenému modelu formulářového kontroleru '.get_called_class().'.');
                    }
                    break;
                case 3:
                    $multiselectPrefix = Projektor2_View_HTML_PlanFieldset::MULTI_SELECTED_VARIABLE_PREFIX;
                    if (array_key_exists($keys[0], $this->models) AND strpos($keys[2], $multiselectPrefix)==0) {
                        $index = substr($keys[2], strlen($multiselectPrefix));
                        $modelSignature = $keys[0];
                        $model = $this->models[$modelSignature][$index];
                        $model->$keys[1] = $value;                        
                    } else {
                        throw new LogicException('Název post proměnné '.$key.' neodpovídá žádnému nastavenému modelu formulářového kontroleru '.get_called_class().' nebo má chybnou syntaxi.');
                    }                    
                    break;
                default:
                    throw new UnexpectedValueException('V názvu post proměnné '.$key. 'je více než jeden separátor ->.');
            }
        }
    }
    public function getResultOLD() {
        if ($this->request->isPost()) {
            if (!$this->sessionStatus->zajemce) return 'CHYBA - POST request volá '.__CLASS__.'->'.__METHOD__.' a není správně nastavena session cookie zájemce';

            $this->createFormModels();

            if ($this->request->post('B1') OR $this->request->post('save')) {
            // ukládání dat
                $post = $this->getVariablesToSave($this->request->postArray());
                // KOLIZE a nastavení vlastností objektu flat table s POST hodnot
                $idcka_skolizi_z_formulare =  array();
                foreach($post as $klic => $hodnota) {
                    if (strpos($klic, '§') !== false AND substr($klic, 0, strlen("uc_kolize_table")) == "uc_kolize_table") {  //tj. § tam nekde je, je mozne hledat pozici a klic zaříná na "uc_kolize_table"
                        //!! echo "<br>" .$klic  . "   pozice p: "  . mb_strpos($klic, 'p') .  " " . substr($klic,  mb_strpos($klic, '§')+1 , mb_strlen($klic) );
                        // !! pozor ! § zaujima dve pozice
                        //sesbirat, ktere s_typ_kolize jsou nyni aktualni - tj. byly vypsane, ve jmenu polozek je id_s_typ_kolize
                        $a1 = explode ("§", $klic );
                        $a2 = explode ("_", $a1[1] );
                        if (!in_array($a2[0], $idcka_skolizi_z_formulare)) {
                            $idcka_skolizi_z_formulare[]= $a2[0];
                        }  
                    } else {   //pro policka bez tabulkoveho § prefixu 
                        $this->flatTable->$klic = $hodnota;
                    }
                }
                //Nejsou-li chyby (v osobních udajích) - uložíme
                if (!$this->flatTable->chyby->pocet AND $this->sessionStatus->user->povolen_zapis) {
                        $this->flatTable->save();                
                        //*** KOLIZE - zapis  do tabulky uc_kolize_table
                        //TODO: tady to vyhazuje exception - prozatím vypnuto
        //                Projektor2_Table_UcKolizeData::Zapis_vsechny_kolize_v_zaveru_formulare($pole, $idcka_skolizi_z_formulare,  $Zajemce->id, FORMULAR_ZA_REG_DOT);
                }
            }
        } else { // request == GET
            if($this->request->isGet()) {
                if($this->request->get('id_zajemce')){
                    // existující zájemce
                    $zajemce = Projektor2_Model_ZajemceMapper::findById($this->request->get('id_zajemce'));
                    $this->response->setCookie("id_zajemce", $this->request->get('id_zajemce'));            
                } else {
                    // nový zájemce
                    $zajemce = Projektor2_Model_ZajemceMapper::create();          
                }
                $this->createFormModels();
            }
        }
        
        $htmlResult .= $this->getLeftMenu();
        // CONTENT
        $htmlResult .= "<div class='content'>";
        $htmlResult .= $this->getContentMenu();

        // chybové hlášení
        if($this->flatTable->chyby->pocet) {
            $chyby = new Projektor2_View_HTML_Chyby(array('chyby'=>$this->flatTable->chyby, 'info'=>'Chyby v ostatních datech:'));        
            $htmlResult .= $chyby->render();
        }        
        // formulář
        $htmlResult .= $this->getResultFormular();
        $htmlResult .= "</div>"; // KONEC <div class='content'>  
        // pdf
        if ($this->request->isPost() AND ($this->request->post('T1') OR $this->request->post('pdf')) AND !$this->flatTable->chyby->pocet) {
            $htmlResult .= $this->getResultPdf();
        }
        return $htmlResult;
    }
    
    
    /**
     * Metoda odstraní post proměnné odpovídající tlačítkům submit z post pole requestu. Tyto proměnné nemají (a nesmí mít) 
     * odpovídající sloupec v db tabulce. Odstraní proměnné 'T1', 'submit', 'reset', 'save', 'pdf'. 
     * Tyto názvy proměnných je tedy možno používat pro atribut name v inputech typu submit.
     * Metoda zkontroluje, jestli všechny proměnné
     */
    private function getVariablesToSave($post) {
        $columns = $this->flatTable->getNames();
        $toSave = array();
        foreach ($post as $name=>$value) {
            if (array_search($name, $columns)) {
                $toSave[$name] = $value;
            }            
        }
        return $toSave;
    }
}

