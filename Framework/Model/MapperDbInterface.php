<?php
/**
 *
 * @author pes2704
 */
interface Framework_Model_MapperDbInterface {

############ INFO O DATABÁZI ###########################
    public function getDatabaseNick();
    public function getTableName();
    public function getPrimaryKeyColumnName();
    public function getDbTableHasValidColumn();

############ INFO O OBJEKTU ###########################    
    /**
     * id objektu
     */
    public function getIdName();

}
