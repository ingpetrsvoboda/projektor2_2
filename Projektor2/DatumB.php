<?php
class Projektor2_DatumB
{
    /**
     * @var DateTime 
     */
    private $dateTime;

    const SQL_FORMAT = "Y-m-d";
    const STRING_FORMAT = "d.m.Y";

    private function __construct($dateTime)
    {
        $this->dateTime = $dateTime;
    }

    public static function zRetezce($retezecDatum=false) 
    {
        $retezecDatum=trim($retezecDatum);
//        $regex_pattern="^([1-9]|0[0-9]|1[0-9]|2[0-9]|3[0-1])\.( [1-9]|[1-9]|1[0-2]|0[1-9])\.( [1-2][0-9]{3}|[1-2][0-9]{3})";
//        if (ereg($regex_pattern, $retezecDatum, $regs) && checkdate($regs[2],$regs[1],$regs[3]))   // SVOBODA This function has been DEPRECATED as of PHP 5.3.0. Relying on this feature is highly discouraged.
        //preg_match()
        $regex_pattern="/^([1-9]|0[0-9]|1[0-9]|2[0-9]|3[0-1])\.( [1-9]|[1-9]|1[0-2]|0[1-9])\.( [1-2][0-9]{3}|[1-2][0-9]{3})/";
        if(preg_match($regex_pattern, $retezecDatum, $regs) && checkdate($regs[2],$regs[1],$regs[3]))
        {        
                $datum = DateTime::createFromFormat(self::SQL_FORMAT, trim($regs[3])."-".trim($regs[2])."-".trim($regs[1]));
                return new self($datum);
        }
    }

    public static function zSQL($sqlDatum)
    {
        $datum = DateTime::createFromFormat(self::SQL_FORMAT, $sqlDatum);
        return new self($datum);
    }

    public static function zQuickForm($pole)
    {
        $datum = DateTime::createFromFormat(self::SQL_FORMAT, $pole["Y"]."-".$pole["m"]."-".$pole["d"]);
        return new self($datum);
    }

    public function dejDateTime()
    {
        return $this->dateTime();
    }

    public function dejDatumForm()
    {
        if ($this->dateTime) {
            return array("Y" => $this->dateTime->format("Y"), "m" => $this->dateTime->format("m"), "d" => $this->dateTime->format("d"));
        } else {
            return array("Y" => "", "m" => "", "d" => "");
        }        
    }

    public function dejDatumproSQL()
    {
        if ($this->dateTime) {
            return $this->dateTime->format(self::SQL_FORMAT);
        } else {
            return NULL;
        }
    }

    public function dejDatumRetezec() {
        if ($this->dateTime) {
            return $this->dateTime->format(self::STRING_FORMAT);
        } else {
            return "";
        }
    }
}