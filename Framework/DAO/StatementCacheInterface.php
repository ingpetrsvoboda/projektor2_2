<?php 
interface Framework_DAO_StatementCacheInterface { 
    public function getStatement($statementSignature);
    public function setStatement($statementSignature, $query);
    public function isStatement($statementSignature);
}