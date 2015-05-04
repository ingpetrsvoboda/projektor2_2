<?php 
interface Framework_DAO_DbTableInterface {   
    public function updateRow(Framework_Model_ItemAbstract $rowObject);
    public function insertRow(Framework_Model_ItemAbstract $rowObject);
    public function deleteRow(\Framework_Model_ItemPersistableAbstract $rowObject);
    public function selectRow($param);
    public function selectRowInto($param);
    public function selectRows($param);
}