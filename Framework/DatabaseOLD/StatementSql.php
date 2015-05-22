<?php
/**
 * Description of Framework_Database_StatementSql.
 * Základní statement objekt pro SQL databáze. Využívá hotovou abstrakci PHP PDOStatement a jde o adapter a současně wrapper 
 * pro PDOStatement. Implementuje Framework_Database_StatementInterface.
 *
 * @author Petr Svoboda
 */
class Framework_Database_StatementSql extends \PDOStatement implements Framework_Database_StatementInterface {
    
    
    protected function __construct() {  
    // konstruktor musí být deklarován i když je prázdný
    // bez toho nefunguje PDO::setAttribute(PDO::ATTR_STATEMENT_CLASS, ...
    }
    
    public function setFetchMode($fetchMode, $arg2 = null, $arg3 = null) {
        // This thin wrapper is necessary to shield against the weird signature
        // of PDOStatement::setFetchMode(): even if the second and third
        // parameters are optional, PHP will not let us remove it from this
        // declaration.
        if ($arg2 === null && $arg3 === null) {
        return parent::setFetchMode($fetchMode);
        }
        if ($arg3 === null) {
        return parent::setFetchMode($fetchMode, $arg2);
        }
        return parent::setFetchMode($fetchMode, $arg2, $arg3);
    }
    
    public function fetch($fetch_style = null, $cursor_orientation = PDO::FETCH_ORI_NEXT, $cursor_offset = 0) {
        return parent::fetch($fetch_style, $cursor_orientation, $cursor_offset);
    }
    
    public function fetchAll($fetch_style = null, $fetch_argument = null, array $ctor_args = NULL) {
        // This thin wrapper is necessary to shield against the weird signature
        // of PDOStatement::setFetchMode(): even if the second and third
        // parameters are optional, PHP will not let us remove it from this
        // declaration.
        if ($fetch_argument === null && $ctor_args === null) {
        return parent::fetchAll($fetch_style);
        }
        if ($ctor_args === null) {
        return parent::fetchAll($fetch_style, $fetch_argument);
        }
        return parent::fetchAll($fetch_style, $fetch_argument, $ctor_args);        
    }
    
    public function execute(array $input_parameters = null) {
        return parent::execute($input_parameters);
    }
}
