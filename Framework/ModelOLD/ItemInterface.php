<?php
/**
 *
 * @author pes2704
 */
interface Framework_Model_ItemInterface {
    public function getId();
    public function getIdName();
    public function setIdName($name);

    public function getValues();
    public function getNames();
    public function getValuesAssoc();
        
}
