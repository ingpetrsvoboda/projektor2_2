<?php
/**
 * Description of Projektor2_Model_PersistableItem
 * Připojuje k Projektor2_Model_ItemAbstract vlastnosti pro mapper a unikátní identifikátor instance a odpovídající metody.
 *
 * @author pes2704
 */
abstract class Framework_Model_ItemPersistableAbstract extends Framework_Model_ItemAbstract implements Framework_Model_ItemPersistableInterface, Serializable {
    
    const DEFALT_MAPPER_CLASS_POSTFIX = 'Mapper';
    
    /**
     * @var Framework_Model_MapperInterface 
     */
    private $itemMapper;
    
    private static $itemsCounter = 1;
    
    private $isPersisted = FALSE;
    
    private $isModified = FALSE;
    
    private $itemSignature;

    public function serialize() {
        return serialize(array( 'itemsCounter' => self::$itemsCounter, 
                                'itemSignature' => $this->itemSignature, 
                                'isPersisted' => $this->isPersisted, 
                                'mapperClassName' => get_class($this->itemMapper)));
    }
    
    public function unserialize($serialized) {
        $arr = unserialize($serialized);
        if ($arr['isPersisted']) {
            $mapperClassName = $arr['mapperClassName'];
            $this->persist(new $mapperClassName);  // po deserializaci mají objekty jiné unikátní signatury
        }
    }
    
    /**
     * Setter, nastavuje jen public vlastnosti. Nastavuje jen hodnoty existujících vlastností, nepřidává další vlastnosti objektu. 
     * V případě, že $name neodpovídá existující vlastnosti objektu metoda jen tiše skončí. Jedinou výjimkou je pokus o nastevení vlastnosti 
     * odpovídající id objektu, v takovém případě metofa vyhodí výjimku.
     * @param type $name
     * @param type $value
     */
    public function __set($name, $value) {
        if (self::OBJECT_ID_NAME == $name) {
            throw new LogicException('Nelze nastavovat hodnotu vlastnosti '.$name.". Tato vlastnost odpovídá primárnímu klíči db tabulky.");
        }
        if ($this->getIterator()->offsetExists($name)) {
            $this->$name = $value;
            $this->isModified = TRUE;
        }
    }    
    
    /**
     * 
     * @param Framework_Model_MapperInterface $mapper
     */
    public function persist(Framework_Model_MapperInterface $mapper=NULL) {
        if (!$mapper) {
            $mapper = $this->getDefaultMapper();
        }
        $this->itemMapper = $mapper;
        $this->isPersisted = TRUE;
        $this->setItemSignature();
    }
    
    private function setItemSignature() {
        $this->itemSignature = get_called_class() . self::$itemsCounter++;
    }
    
    /**
     * 
     * @return boolean
     */
    public function isPersisted() {
        return $this->isPersisted;
    }
    
    /**
     * 
     * @return \Framework_Model_MapperInterface
     * @throws LogicException
     */
    private function getDefaultMapper() {
        $mapperClass = get_called_class() . self::DEFALT_MAPPER_CLASS_POSTFIX;
        if (!class_exists($mapperClass)) {
            throw new LogicException('Pokus o použití default mapperu. Ke třídě '.get_called_class().' neexituje defaultní mapper '.$mapperClass.'.');            
        }
        return new $mapperClass();
    }
    
    /**
     * Mapper, kterým byl objekt vytvořen (metoodu create()) a lterým bude dále obsluhována persistence objektu
     * @return Framework_Model_MapperInterface
     */
    public function getItemMapper() {
        return $this->itemMapper;
    }
    
    /**
     * Unikátní identifikátor instance itemu.
     * @return string
     */
    public function getItemSignature() {
        return $this->itemSignature;
    }
}
