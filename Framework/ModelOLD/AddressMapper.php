<?php

/*
 * Testovací třída!!
 * http://stackoverflow.com/questions/7575751/how-to-load-child-objects-lazily-with-the-data-mapper-pattern
 */

/**
 * Description of AddressMapper
 *
 * @author pes2704
 */
class AddressMapper extends MapperAbstract {
    public function getAddressesByUserId( $id ) {
        $addressData = $this->getAddressDataSomehow();
        $addresses = new SomeAddressIterator( $addressData );
        return $addresses;
    }
}
