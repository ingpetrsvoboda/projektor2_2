<?php
/**
 * Description of Pdo
 *
 * @author pes2704
 */
class Framework_DAO_StatementCache implements Framework_DAO_StatementCacheInterface {
        
    protected $statements = array();
    
    /**
     * Vrací uložený statement se zadanou signaturou.
     * @param string $statementSignature
     * @return Framework_Database_StatementSql
     */
    public function getStatement($statementSignature) {
        return $this->statements[$statementSignature];
    }
    
    /**
     * Podle zadaného sql příkazu vytvoří prepared statement. Vytvořený statement uloží pod zadanou signaturou.
     * @param string $statementSignature
     * @param string $query
     */
    public function setStatement($statementSignature, Framework_DAO_DbRowStatementInterface $dbSDtatement) {
        if(!is_scalar($statementSignature)) {
            throw new UnexpectedValueException('Signatura musí být skalárního typu.');
        }
        $this->statements[$statementSignature] =  $dbSDtatement;
    }
    
    /**
     * Informuje zde existuje uložený statement se zadanou signaturou.
     * @param type $statementSignature
     * @return boolean
     */
    public function isStatement($statementSignature) {
        if ($this->statements[$statementSignature]) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}
