<?php
/**
 * Description of Framework_Model_Relation
 *
 * @author pes2704
 */
class Framework_Model_Relation implements IteratorAggregate {
    protected $_iterator;
    protected $_mapper;
    protected $_method;
    protected $_arguments;

    public function __construct( MapperAbstract $mapper, $method, array $arguments = array() ) {
        $this->_mapper    = $mapper;
        $this->_method    = $method;
        $this->_arguments = $arguments;
    }

    public function getIterator() {
        if( $this->_iterator === null ) {
            $this->_iterator = call_user_func_array( array( $this->_mapper, $this->_method ), $this->_arguments );
        }
        return $this->_iterator;
    }

    public function __call( $name, array $arguments ) {        
        return call_user_func_array( array( $this->getIterator(), $name ), $arguments );
    }
}
