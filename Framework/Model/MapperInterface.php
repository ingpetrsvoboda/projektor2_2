<?php
/**
 *
 * @author pes2704
 */
interface Framework_Model_MapperInterface {

############ ZÁKLADNÍ METODY MAPPERU ###########################    
    public function create();
    public function findOne(array $whereBind);
    public function findAll($filter, $orderBy, $order);
    public function save(\Framework_Model_ItemPersistableInterface $rowObject);
    public function destroy(\Framework_Model_ItemPersistableInterface $rowObject);
}
