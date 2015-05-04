<?php
/**
 * Description of Projektor2_Model_AbstractMapper
 *
 * @author pes2704
 */
abstract class Framework_Model_MapperAbstract implements Framework_Model_MapperInterface {
    
    private $dao;
  
########## PRIVATE METODY ################################################# 
    

    
    /**
     * Defaultní metoda create(), možno přetížit. Tato defaultní metoda vytvoří objekt Item s použitím defaultního překladu 
     * názvu db tabulky na název objektu.
     * Defaultně se překládá název db tabulky psaný malými písmeny s podtržítky (bez mezer) na název třídy ve formě CamelCase (včetně prvního velkého 
     * písmena) tedy na používaný systém názvů tříd, např. tab_osob => TabOsob.
     * Očekává, že potomkovský objekt (mapper) má definovanou konstantu TABLE
     * @return \Framework_Model_ItemPersistableInterface
     */
    public function create($itemClassName = NULL) {
        if (!$itemClassName) {
            $itemClassName = $this->getDefaultItemClassName();
        }
        $item = new $itemClassName();
        $item->persist($this);
        return $item;
    }
    
    public function getDefaultItemClassName() {
        return str_replace(Framework_Model_ItemPersistableAbstract::DEFALT_MAPPER_CLASS_POSTFIX, '', get_called_class());
    }
    
    /**
     * Metoda se pokusí vytvořit objekt item, který byl předtím persistován. 
     * @param array $whereBind
     * @param type $useSetter
     * @return type
     */
    public function findOne(array $whereBind = array(), $useSetter = FALSE) {
        $this->dao->
            if ($hydratedItem) {
                $hydratedItem->persist($this);
            }                
    }
            
    public function findAll($filter = NULL, $orderBy = NULL, $order = 'ASC', $params = NULL) {

    }    
    
    /**
     * 
     * @param \Framework_Model_ItemAbstract $rowObject
     * @return \Framework_Model_ItemAbstract
     */
    public function save(\Framework_Model_ItemPersistableInterface $rowObject) {
        if ($rowObject->isPersisted()) {
            return $this->dao->save($rowObject);
        }else {
            return $this->dao->insertRow($rowObject);
        }
    }
    
    /**
     * Default metoda delete. Předpokládá, že parametr je 
     * @param \Framework_Model_ItemAbstract $rowObject
     * @return null
     */
    public function destroy(\Framework_Model_ItemPersistableInterface $rowObject) {
        $this->dao->delete($rowObject);
    }
    
########## PROTECTED SLUŽEBNÍ METODY PRO POTOMKY #################################################    
           
}
