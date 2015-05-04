<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * POZOR!! Třída rodiče Framework_DAO_DbRowStatement zapůjčena an doladění do p2
 *
 * @author pes2704
 */
class Framework_DAO_DbRowStatementCached extends Framework_DAO_DbRowStatement implements Framework_DAO_DbRowStatementInterface {
    
    private $dbStatementCache;

    
//  injektuj  $dbStatementCache = new Framework_DAO_StatementCache()

    public function __construct(\Framework_Database_HandlerSqlInterface $databaseHandler, Framework_DAO_StatementCacheInterface $dbStatementCache) {
        $this->databaseHandler = $databaseHandler;
        $this->dbStatementCache = $dbStatementCache;
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
        $statementSignature = 'SELECT:'.$table.'->'.implode(',', $columns);            
        if ($whereBind) {
            $statementSignature .= '?'.implode('-',  array_keys($whereBind));
        }
        if ($this->dbStatementCache->isStatement($statementSignature)) {
            $statement = $this->dbStatementCache->getStatement($statementSignature);
        } else {
            $statement = $this->prepareSelectQuery($table, $columns, $whereBind, $boolOperator);
            $this->dbStatementCache->setStatement($statementSignature, $statement);
        }                
        return $statement;
    }
    
    /**
     * 
     * @param string $table Název tabulky
     * @param array $insertBinds Asociativní pole sloupec=>hodnota
     * @return Framework_Database_StatementSql
     */
    public function getInsert($table, array $insertBinds) {
        $columns = implode(', ', array_keys($insertBinds));
        $statementSignature = 'INSERT:'.$table.'->'.$columns;            
        if ($this->dbStatementCache->isStatement($statementSignature)) {
            $statement = $this->dbStatementCache->getStatement($statementSignature);
        } else {
            $values = implode(', ', $insertBinds);
            $statement = $this->prepareInsertQuery($table, $insertBinds);
            $this->dbStatementCache->setStatement($statementSignature, $statement);
        }                
        return $statement;        
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
        if ($this->dbStatementCache) {
            $statementSignature = 'UPDATE:'.implode(',', array_keys($setBinds)).'?'.implode(',', array_keys($whereBinds));
            if ($this->dbStatementCache->isStatement($statementSignature)) {
                $statement = $this->dbStatementCache->getStatement($statementSignature);
            } else {
                $statement = $this->prepareUpdateQuery($table, $setBinds, $whereBinds, $boolOperator);
                $this->dbStatementCache->setStatement($statementSignature, $statement);
            }                
        }
        return $statement;        
    }
    
    /**
     * 
     * @param type $table Název tabulky
     * @param array $whereBinds Asociativní pole sloupec=>hodnota
     * @param string $boolOperator
     * @return Framework_Database_StatementSql
     */
    public function getDeleteHard($table, array $whereBinds = array(), $boolOperator = "AND") {        
        $statementSignature = 'DELETEHARD:'.'?'.implode(',', array_keys($whereBinds));
        if ($this->dbStatementCache->isStatement($statementSignature)) {
            $statement = $this->dbStatementCache->getStatement($statementSignature);
        } else {
            $statement = $this->prepareDeleteHardQuery($table, $whereBinds, $boolOperator);
            $this->dbStatementCache->setStatement($statementSignature, $statement);
        }                
        return $statement;        
    }

    /**
     * 
     * @param type $table Název tabulky
     * @param array $whereBind Asociativní pole sloupec=>hodnota
     * @param string $boolOperator
     * @return Framework_Database_StatementSql
     */
    public function getDeleteSoft($table, array $whereBind = array(), $boolOperator = "AND", $validColumnName = "valid") {        
        $statementSignature = 'DELETESOFT:'.'?'.implode(',', array_keys($whereBind));
        if ($this->dbStatementCache->isStatement($statementSignature)) {
            $statement = $this->dbStatementCache->getStatement($statementSignature);
        } else {
            $statement = $this->prepareDeleteSoftQuery($table, $whereBind, $boolOperator);
            $this->dbStatementCache->setStatement($statementSignature, $statement);
        }                
        return $statement;        
    }
    
    /**
     * 
     * @param type $table Název tabulky
     * @param array $whereBind Asociativní pole sloupec=>hodnota
     * @param string $boolOperator
     * @return Framework_Database_StatementSql
     */
    public function getUndeleteSoft($table, array $whereBind = array(), $boolOperator = "AND", $validColumnName = "valid") {        
        $statementSignature = 'UNDELETESOFT:'.'?'.implode(',', array_keys($whereBind));
        if ($this->dbStatementCache->isStatement($statementSignature)) {
            $statement = $this->dbStatementCache->getStatement($statementSignature);
        } else {
            $statement = $this->prepareUndeleteSoftQuery($table, $whereBind, $boolOperator);
            $this->dbStatementCache->setStatement($statementSignature, $statement);
        }                
        return $statement;        
    }    
}
