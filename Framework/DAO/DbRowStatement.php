<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Framework_DAO_DbTable
 *
 * @author pes2704
 */
class Framework_DAO_DbRowStatement implements Framework_DAO_DbRowStatementInterface {
    
    protected $databaseHandler;
    
    public function __construct(\Framework_Database_HandlerSqlInterface $databaseHandler) {
        $this->databaseHandler = $databaseHandler;
    }
    
    /**
     * 
     * @param type $query
     * @return type
     */
    protected function prepare($query) {
        return $this->dbHandler->prepare($query);
    }
    
    /**
     * Vrací prepared statement typu select.
     * @param type $table
     * @param array $columns
     * @param array $whereBind
     * @param type $dbTableHasValidColumn
     * @param type $boolOperator
     * @param type $selectAll
     * @return Framework_Database_StatementInterface
     */
    public function getSelect($table, array $columns = array('*'), array $whereBind = array(), $boolOperator = "AND") {
        $statement = $this->prepareSelectQuery($table, $columns, $whereBind, $boolOperator);
        return $statement;
    }
    
    protected function prepareSelectQuery($table, array $columns, array $whereBind, $boolOperator) {
        $query = 'SELECT '.implode(', ', $columns).' FROM '.$table.' WHERE '.$this->whereExpression($whereBind, $boolOperator);
        return $this->prepare($query);        
    }
    
    /**
     * 
     * @param string $table Název tabulky
     * @param array $insertBinds Asociativní pole sloupec=>hodnota
     * @return Framework_Database_StatementSql
     */
    public function getInsert($table, array $insertBinds) {
        $statement = $this->prepareInsertQuery($table, $insertBinds);
        return $statement;        
    }
    
    protected function prepareInsertQuery($table, $insertBinds) {
        $query = "INSERT INTO ".$table." (".$this->columnsExpression($insertBinds).") VALUES (" .$this->valuesExpression($insertBinds).")";
        return $this->prepare($query);        
    }

    /**
     * 
     * @param string $table Název tabulky
     * @param array $setBinds Asociativní pole sloupec=>hodnota
     * @param array $whereBinds Asociativní pole sloupec=>hodnota
     * @param string $boolOperator
     * @return Framework_Database_StatementSql
     */
    public function getUpdate($table, array $setBinds = array(), array $whereBinds = array(), $boolOperator = "AND") {
        $statement = $this->prepareUpdateQuery($table, $setBinds, $whereBinds, $boolOperator);
        return $statement;        
    }
    
    protected function prepareUpdateQuery($table, $setBinds, $whereBinds, $boolOperator) {
        $query = "UPDATE ".$table." SET ".$this->setExpression($setBinds).' WHERE '.$this->whereExpression($whereBinds, $boolOperator);
        return $this->prepare($query);        
    }
    
    /**
     * 
     * @param type $table Název tabulky
     * @param array $whereBinds Asociativní pole sloupec=>hodnota
     * @param string $boolOperator
     * @return Framework_Database_StatementSql
     */
    public function getDeleteHard($table, array $whereBinds = array(), $boolOperator = "AND") {        
        $statement = $this->prepareDeleteHardQuery($table, $whereBinds, $boolOperator);
        return $statement;        
    }

    protected function prepareDeleteHardQuery($table, $whereBinds, $boolOperator) {
        $query = "DELETE FROM ".$table.' WHERE '.$this->whereExpression($whereBinds, $boolOperator);
        return $this->prepare($query);        
    }

    /**
     * 
     * @param type $table Název tabulky
     * @param array $whereBind Asociativní pole sloupec=>hodnota
     * @param string $boolOperator
     * @return Framework_Database_StatementSql
     */
    public function getDeleteSoft($table, array $whereBind = array(), $boolOperator = "AND", $validColumnName = "valid") {        
        $statement = $this->prepareDeleteSoftQuery($table, $whereBind, $boolOperator, $validColumnName);
        return $statement;        
    }

    protected function prepareDeleteSoftQuery($table, $whereBind, $boolOperator, $validColumnName) {
        $query = "UPDATE ".$table." SET (".$validColumnName."= FALSE) ".' WHERE '.$this->whereExpression($whereBind, $boolOperator);        
        return $this->prepare($query);        
    }    
    /**
     * 
     * @param type $table Název tabulky
     * @param array $whereBind Asociativní pole sloupec=>hodnota
     * @param string $boolOperator
     * @return Framework_Database_StatementSql
     */
    public function getUndeleteSoft($table, array $whereBind = array(), $boolOperator = "AND", $validColumnName = "valid") {        
        $statement = $this->prepareUndeleteSoftQuery($table, $whereBind, $boolOperator, $validColumnName);
        return $statement;        
    }

    protected function prepareUndeleteSoftQuery($table, $whereBind, $boolOperator, $validColumnName) {
        $query = "UPDATE ".$table." SET (".$validColumnName."= TRUE) ".' WHERE '.$this->whereExpression($whereBind, $boolOperator);        
        return $this->prepare($query);        
    }
    
######### PRIVATE ###########################################    
    
    private function whereExpression(array $binds, $boolOperator = "AND") {
        if($binds) {
            $whereConditions = array();
            foreach (\array_keys($binds) as $col) {
                $whereConditions[] = $col . " = :" . $col;
            }
            $expr = implode(" ".$boolOperator." ", $whereConditions);
        }
        return $expr;        
    }
    
    private function setExpression(array $binds) {
        if ($binds) {
            $set = array();
            foreach (\array_keys($binds) as $col) {
                $set[] = "(".$col . " = :" . $col.")";
            }
            $expr = implode(", ", $set);
        }
        return $expr;            
    }    
    
    private function columnsExpression(array $binds) {
        return implode(', ', array_keys($binds));
    }    
    
    private function valuesExpression(array $binds) {
        if (count($binds)>0) {
            $values = ':'.implode(', :', array_keys($binds));
        } else {
            $values = array();
        }
        return $values;
    }     
}
