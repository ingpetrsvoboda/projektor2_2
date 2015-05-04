<?php
/**
 * Description of Framework_DAO_DbTable
 *
 * @author pes2704
 */
class Framework_DAO_DbTable implements Framework_DAO_DbTableInterface {
    
    private $dbStatement;
    private $tableName;
    
    private $andConditions = array(); 
    
    public function __construct(\Framework_Database_HandlerSqlInterface $databaseHandler, $tableName, Framework_DAO_StatementCacheInterface $dbStatementCache = NULL) {
        $this->dbStatement = new Framework_DAO_DbRowStatement($databaseHandler, $dbStatementCache);
        $this->tableName = $tableName;
    }
    
    /**
     * 
     * @param Framework_Model_ItemAbstract $rowObject
     * @return \Framework_Model_ItemAbstract
     */
    public function updateRow(Framework_Model_ItemAbstract $rowObject) {
        $statement = $this->dbStatement->getUpdate($this->tableName, $setBind, $whereBind, $boolOperator)
        return $statement->execute($this->createWhereIdValue($rowObject))->countAffectedRows();          
    }
    
    /**
     * 
     * @param Framework_Model_ItemAbstract $rowObject
     * @return integer
     */
    public function insertRow(Framework_Model_ItemAbstract $rowObject) {
        $statement = $this->dbStatement->getInsert($this->tableName, $this->createWhereIdBind($rowObject));
        return $statement->execute($this->createWhereIdValue($rowObject))->countAffectedRows();        
    }

    /**
     * 
     * @param \Framework_Model_ItemPersistableAbstract $rowObject
     * @return integer
     */
    public function deleteRow(\Framework_Model_ItemPersistableAbstract $rowObject, $useValidColumn) {
        if ($useValidColumn) {
            $statement = $this->dbStatement->getDeleteSoft($this->tableName, $this->createWhereIdBind($rowObject));
        } else {
            $statement = $this->dbStatement->getDeleteHard($this->tableName, $this->createWhereIdBind($rowObject));
        }
        return $statement->execute($this->createWhereIdValue($rowObject))->countAffectedRows();        
    }    
    
    /**
     * Metoda slouží k vytvoření nového objektu.
     * Toto je varianta s použitím PDO::FETCH_CLASS se nevolá  __set() při nastavování properties při fetch() 
     * (properties objektu se nastavují "zevnitř objektu"), s použitím PDO::FETCH_PROPS_LATE se volá konstruktor před nastavením properties,
     * Pokud nejsou načtena žádná data z databáze, metoda vrací NULL.
     * @param string $className Název třídy objektu, která metoda vytvoří.
     * @param type $useValidColumn
     * @param array $whereBind Asociativní pole název atributu=>hodnota
     * @return object
     */
    public function selectRow($className, $useValidColumn, array $whereBind = array()) {  
        if ($useValidColumn) {
            $whereBind['valid'] = 1;  //přidá podmínku
        }        
        $statement = $this->dbStatement->getSelect($this->tableName, array('*'), $whereBind);
        $statement->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, $className);    
        $succ = $statement->execute($whereBind);
        if ($succ) {
            $hydratedItem = $statement->fetch();  //$hydratedItem se vytvoří POUZE pokud byla nějaká data načtena 
        }
        return $hydratedItem;        
    }
    
    /**
     * Metoda slouží k načítání hodnot vlastností přímo do objektů modelu (typu Framework_Model_ItemAbstract).
     * Toto je varianta s použitím FETCH_INTO - v tomto případě se volá __set() při nastavování properties při fetch() 
     * (properties objektu se nastavují "zvenku"). 
     * Pokud nejsou načtena žádná data z databáze, metoda vrací NULL.
     * @param Framework_Model_ItemAbstract $item
     * @param array $whereBind Asociativní pole název atributu=>hodnota
     * @param boolean $useValidColumn Indikuje, jestli se má použít sloupec db tabulky valid, používaný pro "měkký delete"
     * @return Framework_Model_ItemAbstract
     */
    public function selectRowInto(Framework_Model_ItemAbstract $item, array $whereBind = array(), $useValidColumn=FALSE) {  
        if ($useValidColumn) {
            $whereBind['valid'] = 1;
        }        
        $statement = $this->dbStatement->getSelect($this->tableName, array('*'), $whereBind);
        $statement->setFetchMode(PDO::FETCH_INTO, $item); 
        $succ = $statement->execute($whereBind);
        if ($succ) {
            $hydratedItem = $statement->fetch();  //$hydratedItem se vytvoří POUZE pokud byla nějaká data načtena 
        }
        return $hydratedItem;        
    }
    
    protected function selectRows($orderBy = NULL, $order = 'ASC', $params = NULL) {
//        $query = "SELECT * FROM ".static::TABLE." WHERE ";
//        self::addFilterAndOrderToQuery($query, $this->getWhereFilter(), $orderBy, $order);
//        $dbh = Projektor2_AppContext::getDB();
//        $radky = $dbh->prepare($query)->execute($params)->fetchall();
//        if ($radky) {
//            foreach($radky as $radek) {
//                $model = $this->create();
//                $kolekce[] = $this->hydrate($model, $data);
//            }
//            return $kolekce;     
//        } else {
//            return array();
//        }
        $this->addAndCondition($filter);
        return $this->loadAll($orderBy, $order, $params);        
    }

########## PRIVATE METODY ################################################# 

    private function createWhereIdBind(Framework_Model_ItemInterface $rowObject) {
        return array($rowObject->getIdName() => $rowObject->getId());
    }
    
    private function createWhereIdValue(Framework_Model_ItemInterface $rowObject) {
        return array($rowObject->getId())        ;
    }
    
    private function createDataSet(Framework_Model_ItemInterface $rowObject) {
        return $rowObject->getValuesAssoc();
    }  
    
    /**
     * Pokud parametr $data byl zadán, naplní model daty. Pokouší se zapsat všechny prvky pole $data, ale modely díky metodě __set()
     * přijímají pouze data odpovídající vlastnostem (nepřidávají další vlastnosti)
     * @param Framework_Model_ItemAbstract $model
     * @param type $data
     * @return \Framework_Model_ItemAbstract
     */
    private function hydrate(Framework_Model_ItemAbstract $model, $data=NULL) {
        if ($data AND is_array($data)) {
            foreach ($data as $key => $value) {
                if ($key == $this->primaryKeyColumnName) {
                    $pk = self::DEFAULT_ID_NAME;
                    $model->$pk = $value;
                } else {
                    $model->$key = $value;                
                }
            }
        }
        return $model;
    }    
    
    private function addFilterAndOrderToQuery($query, $filter = NULL, $orderBy = NULL, $order = 'ASC') {
        if ($filter AND is_string($filter)) {
            $query .= " AND ".$filter;
        }
        if ($orderBy AND is_string($orderBy)) {
            $query .= " ORDER BY ".$orderBy;
            if ($order AND is_string($order)) {
                $query .= " ".$order;
            }
        }    
        return $query;
    }
    
    private function getWhereFilter() {
        return implode(' AND ', $this->andConditions);
    }    

    private function resetAndConditions() {
        $this->andConditions = array();
    }    
        
    public function addAndCondition($condition) {
        $this->andConditions[] = $condition;
    }        
    
    
}
