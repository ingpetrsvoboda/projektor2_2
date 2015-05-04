<?php
/**
 *
 * @author pes2704
 */
interface Framework_Model_ItemPersistableInterface extends Framework_Model_ItemInterface {
    
    public function persist();
    public function isPersisted();
    public function getItemMapper();
    public function getItemSignature();

}
