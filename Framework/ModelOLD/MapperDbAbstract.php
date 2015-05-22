<?php
/**
 * Description of Framework_Model_BaseMapper
 * Rozšiřuje Framework_Model_AbstractMapper o defaultní metodu create(), která překládá název db tabulky na název objektu Item.
 *
 * @author pes2704
 */
abstract class Framework_Model_MapperDbAbstract extends Framework_Model_MapperAbstract implements Framework_Model_MapperDbInterface {
    const DEFAULT_ID_NAME = 'id';
    const HAS_VALID = TRUE;    
    
    public function __construct() {
Projektor2_AppContext - to ne, asi inject DAO
        $dbhHandler = Projektor2_AppContext::getDB($this->getDatabaseNick());
cache se nepoužívá??
        $dbStatementCache = new Framework_DAO_StatementCache($databaseHandler);
        $this->dao = new Framework_DAO_DbTable($dbhHandler);
    }    

########## DEFAULTNÍ METODY ROZHRANÍ #################################################    

    public function getDbTableHasValidColumn() {
        return self::HAS_VALID;
    }
    
    public function getIdName() {
        return self::DEFAULT_ID_NAME;
    }
    
    public function getPrimaryKeyColumnName() {
        return $this->getIdName().'_'.$this->getTableName();
    }    
    
    /**
     * Defaultní metoda findById(), možno přetížit.
     * @param type $id
     * @return type
     */
    public function findById($id) {
        $whereBind = array($this->getIdName()=>$id);
        return $this->findOne($whereBind);
    }    
}
