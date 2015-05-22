<?php
/**
 * verze 2.1 - je potomkem Framework_Model_ItemAbstract nikoli Persistable Item
 */
abstract class Framework_Model_ItemFlatTableAbstract extends Framework_Model_ItemPersistableAbstract {
    protected $tableName;
    protected $mainObjectIdColumnName;
    protected $id;
    protected $mainObject;

    protected $dbh;
    protected $attributes;
    protected $changed;
    protected $primaryKeyColumnName;
    
    private $isHydrated;
    private $isPersisted;

    /**
     * Konstruktor
     * @param type $tableName Název db tabulky
     * @param type $mainObject
     * @param type $idColumnName Název sloupce s primátním klíčem db tabulky $table_name. Pokud parametr není zadán, 
     * metoda použije default hodnotu složenou z prefixu 'id_' a názvu tabulky (např. pro název tabulky 'osoba' použije !id_osoba'
     * @throws Exception
     */
    public function __construct($tableName,$mainObject, $idColumnName=NULL) {          
        $this->tableName = $tableName;
        $this->mainObject = $mainObject;
        $mainObjectClassName = get_class($mainObject);
        if ($idColumnName){
            $this->mainObjectIdColumnName = $idColumnName;
        } elseif ($mainObjectClassName::TABLE) {
            $this->mainObjectIdColumnName = 'id_'.$mainObjectClassName::TABLE;
            } else {
                throw new LogicException("Parametr \$idColumnName nebyl nastaven a hlavní objekt $mainObjectClassName nemá konstantu TABLE, ue které lze odvodit default ehodnotu." );
            }

            $this->dbh = Projektor2_AppContext::getDB();
        //Nacteni struktury tabulky, datovych typu a ost parametru tabulky
        $query = "SHOW COLUMNS FROM ".$this->tableName;
        $sth = $this->dbh->prepare($query);
        $succ = $sth->execute();
        while ($data = $sth->fetch(PDO::FETCH_ASSOC)){
            $this->attributes[$data['Field']] = $data['Default'];
            if ($data['Key']=="PRI") $this->primaryKeyColumnName = $data['Field'];        
        }
    }

    /**
     * Getter, vrací jen existující vlastnosti.
     * @param type $name
     * @return type
     */
    public function __get($name){
        $this->hydrate();
        if ($this->getIterator()->offsetExists($name)) {
            return $this->attributes[$name];
        }
    }
    
    /**
     * Setter, přetěžuje setter rodiče. Nastavuje jen hodnoty existujících vlastností, nepřidává další vlastnosti. 
     * V případě, že $name neodpovídá existující vlastnosti metoda jen tiše skončí. Jedinou výjimkou je pokus o nastevení vlastnosti 
     * odpovídající id objektu, v takovém případě metoda vyhodí výjimku.
     * @param type $name
     * @param type $value
     * @return mixed
     * @throws UnexpectedValueException
     */
    public function __set($name,$value){
        $this->hydrate();
        if ($name == $this->primaryKeyColumnName) {
            throw new UnexpectedValueException("nelze nastavovat vlastnost $name odpovídající primárnímu klíči tabulky $this->tableName");
        }
        if ($this->getIterator()->offsetExists($name)) {        
            $this->attributes[$name] = $value;
            $this->changed[$name] = $value;
            return $value;
        }
    }
    
    public function persist() {
        return parent::persist(new Framework_Model_MapperFlatTable());
    }    
    private function hydrate() {
        if (!$this->isHydrated) {
            if(!$this->mainObject->id){
                throw new Exception("Flat table nemá nastaven hlavní objekt nebo hlavní objekt nemá id, nemohu načíst data z tabulky $this->tableName");
            } else {
                $whereParams = array($this->mainObjectIdColumnName=>$this->mainObject->id);
                $query = 'SELECT '.implode(', ', array_keys($this->attributes)).' FROM '.$this->tableName.$this->createWhereExpression($whereParams);                
                $sth = $this->dbh->prepare($query);
                $succ = $sth->execute($whereParams);
                if ($succ) {
                    $data = $sth->fetch(PDO::FETCH_ASSOC);  
                    if($data) {
                        foreach ($data as $key => $value) {  //$this->attributes = $data;
                            $this->attributes[$key] = $value;
                        }
                        $this->id = $this->attributes[$this->primaryKeyColumnName];
                        $this->isHydrated = TRUE;
                        $this->isPersisted = TRUE;
                    } else {
                        $this->isHydrated = TRUE;
                        $this->isPersisted = FALSE;                        
                    }
                }
            }
        }
        return $this;
    }
    
    /**
     * 
     * @return \Framework_Model_ItemFlatTableAbstract
     * @throws LogicException
     * @throws UnexpectedValueException
     */
    public function save() {
        if(!$this->mainObject->id){
            throw new LogicException("Hlavní objekt flat table $mainObjectClassName nemá id, nemohi ukládat podřízený objekt do ".$this->tableName);
        }
        if (!array_key_exists($this->mainObjectIdColumnName, $this->attributes)) {
            throw new UnexpectedValueException("Nenalezen očekávaný sloupec s názvem $this->mainObjectIdColumnName v tabulce $this->tableName");
        }
        if ($this->isPersisted) {
            $this->update();
        } else {
            $this->insert();
        }
        return $this;        
    }

    /**
     * 
     * @throws RuntimeException
     */
    private function update() {
        if ($this->changed) {
            $set = array();
            foreach ($this->changed as $col => $value) {
                    $set[] = $col . " = :" . $col;                    
            }
            $whereParams = array($this->primaryKeyColumnName=>$this->attributes[$this->primaryKeyColumnName]);
            $query = "UPDATE ".  $this->tableName." SET ".implode(", ", $set).$this->createWhereExpression($whereParams);
            $sth = $this->dbh->prepare($query);
            $succ = $sth->execute(array_merge($this->changed, $whereParams));
            if (!$succ) {
                throw new RuntimeException("Nepodařilo se provést příkaz $query.");
            }
            $this->changed = array();
        }        
    }

    /**
     * 
     * @throws RuntimeException
     */
    private function insert() {
        $this->attributes[$mainObjectIdColumnName] = $this->mainObject->id;
        $this->changed[$mainObjectIdColumnName] = $this->mainObject->id;
        $cols = implode(', ', array_keys($this->changed));
        $values = ':'.implode(', :', array_keys($this->changed));
        $query = "INSERT INTO ".$this->tableName." (".$cols.")  VALUES (" .$values.")";   
        $sth = $this->dbh->prepare($query);
        $succ = $sth->execute($this->attributes);
        if (!$succ) {
            throw new RuntimeException("Nepodařilo se provést příkaz $query.");
        }
        $this->id = $dbh->lastInsertId();
        $this->attributes[$this->primaryKeyColumnName] = $this->id;
        $this->changed = array();
        $this->isPersisted = TRUE;
    }    
    
    private function createWhereExpression($whereBind, $boolOperator = "AND") {
        if($whereBind) {
            $whereConditions = array();
            foreach (array_keys($whereBind) as $col) {
                $whereConditions[] = $col . " = :" . $col;
            }
            $expr = ' WHERE '.implode(" ".$boolOperator." ", $whereConditions);
        }
        return $expr;        
    }    
    
    public function getMainObject() {
        return $this->mainObject;
    }
    
    public function getTableName() {
        return $this->tableName;
    }
    
    public function getPrimaryKeyColumnName() {
        return $this->primaryKeyColumnName;
    }
    
    /**
     * Metoda vrací iterátor obsahující public vlastnosti objektu. Přetěžuje metodu rodiče.
     * @return \ArrayIterator
     */
    public function getIterator() {
        if ($this->isPersisted !== FALSE) {
            $this->hydrate();
        } 
        return new ArrayIterator($this->attributes); 
    }
}