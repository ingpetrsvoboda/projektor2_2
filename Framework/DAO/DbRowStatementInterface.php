<?php 
interface Framework_DAO_DbRowStatementInterface {    
    public function getSelect($table, array $columns, array $whereBind, $boolOperator);
    public function getInsert($tableName, array $bind);
    public function getUpdate($table, array $setBind, array $whereBind, $boolOperator);
    public function getDeleteHard($table, array $whereBind, $boolOperator);
    public function getDeleteSoft($table, array $whereBind, $boolOperator);
    public function getUndeleteSoft($table, array $whereBind, $boolOperator);
}