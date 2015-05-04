<?php

/*
 * Testovací třída!!
 * http://stackoverflow.com/questions/7575751/how-to-load-child-objects-lazily-with-the-data-mapper-pattern
 */

/**
 * Description of UserMapper
 *
 * @author pes2704
 */
class UserMapper extends MapperAbstract {
    protected $_addressMapper;

    public function __construct( AddressMapper $addressMapper ) {
        $this->_addressMapper = $addressMapper;
    }

    public function getUserById( $id ) {
        $userData = $this->getUserDataSomehow();
        $user = new User( $userData );
        $user->addresses = new Framework_Model_Relation($this->_addressesMapper, 'getAddressesByUserId',array( $id ));
        return $user;
    }
}
