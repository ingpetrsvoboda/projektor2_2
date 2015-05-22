<?php
/**
 * Description of Projektor2_Model_RowModelAbstract
 *
 * @author pes2704
 */
abstract class Framework_Model_ItemAbstract implements Framework_Model_ItemInterface, IteratorAggregate {
    
    const OBJECT_ID_NAME = 'id';

    private $idName;
    
    public function __construct() {
        $this->idName = self::OBJECT_ID_NAME;
    }
    
    /**
     * Metoda vrací hodnotu identifikátoru objektu
     * @return mixed
     */
    public function getId() {
        $id = $this->idName;
        return $this->$id;
    }
    
    /**
     * Metoda vrací název vlastnosti, která je identifikátorem objektu.
     * @return string
     */
    public function getIdName() {
        return $this->idName;
    }
    
    /**
     * Metoda nastaví název vlastnosti, která je identifikátorem objektu.
     * @param string $name
     * @throws UnexpectedValueException
     */
    public function setIdName($name) {
        if (!is_string($name)) {
            throw new UnexpectedValueException('Jméno vlastnosti s id objektu musí být řetězec. Zadáno: '.  print_r($name, TRUE));
        }
        $this->idName = $name;
    }
    
    /**
     * Getter, vrací jen hodnoty existujících vlastnosti.
     * @param type $name
     * @return type
     */
    public function __get($name) {
        if ($this->getIterator()->offsetExists($name)) {
            return $this->$name;
        }
    }
    
    /**
     * Setter, nastavuje jen hodnoty existujících vlastností, nepřidává další vlastnosti objektu. 
     * V případě, že $name neodpovídá existující vlastnosti objektu metoda jen tiše skončí. 
     * @param type $name
     * @param type $value
     */
    public function __set($name, $value) {
        if ($this->getIterator()->offsetExists($name)) {
            $this->$name = $value;
        }
    }
    
    /**
     * Metoda vrací názvy public vlastností modelu v číselně indexovaném poli.
     * @return array
     */
    public function getNames() {
        return array_keys($this->getValuesAssoc());
    }

    /**
     * Metoda vrací hodnoty public vlastností modelu v číselně indexovaném poli.
     * @return array
     */    
    public function getValues() {
        return iterator_to_array($this->getIterator(), FALSE);
    }
    
    /**
     * Metoda vrací hodnoty a názvy public vlastností modelu jako asociativní pole.
     * @return array
     */    
    public function getValuesAssoc() {
        return iterator_to_array($this->getIterator(), TRUE);
    }
    
    /**
     * Metoda vrací iterátor obsahující vlastnosti objektu. Do iterátoru jsou zahrnuty
     * všechny vlastnosti objektu (jde o vlastnosti viditelné zevnitř objektu (z této metody)).
     * @return \ArrayIterator
     */
    public function getIterator() {
        return new ArrayIterator(get_object_vars($this));  // vrací viditelné properties
    }
}
