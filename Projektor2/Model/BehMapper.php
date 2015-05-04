<?php
class Projektor2_Model_BehMapper {
    public static function findById($id) {
        $dbh = Projektor2_AppContext::getDB();
        $query = "SELECT * FROM s_beh_projektu WHERE id_s_beh_projektu = :id_s_beh_projektu AND valid = 1";
        $bindParams = array('id_s_beh_projektu'=>$id);
        $sth = $dbh->prepare($query);
        $succ = $sth->execute($bindParams);
        $data = $sth->fetch(PDO::FETCH_ASSOC);  
        if(!$data) {
            return NULL;
        }
        $zacatek=new Projektor2_Datum($data['zacatek'],"MySQL");
        $konec = new Projektor2_Datum($data['konec'],"MySQL");
        return new Projektor2_Model_Beh($data['id_s_beh_projektu'],$data['beh_cislo'],$data['oznaceni_turnusu'],$data['text'],$zacatek,$konec,$data['closed']);
    }

    public static function findAll($filter = NULL, $order = NULL) {
        $dbh = Projektor2_AppContext::getDB(); 
        $sessionStatus = Projektor2_SessionStatus::getSessionStatus();    
        // vždy vybírá běhy jen pro aktuální projekt        
        $query = "SELECT * FROM s_beh_projektu WHERE id_c_projekt = :id_c_projekt AND valid = 1";
        if ($filter AND is_string($filter)) {
            $query .= " AND ".$filter;
        }
        if ($order AND is_string($order)) {
            $query .= " ORDER BY ".$order;
        }
        
        $bindParams = array('id_c_projekt'=>$sessionStatus->projekt->id);
        $sth = $dbh->prepare($query);
        $succ = $sth->execute($bindParams);
        $radky = $sth->fetchAll(PDO::FETCH_ASSOC);  
        if(!$radky) {
            return NULL;
        }        
        foreach($radky as $radek) {
            $zacatek=new Projektor2_Datum($radek['zacatek'],"MySQL");
            $konec = new Projektor2_Datum($radek['konec'],"MySQL");
            $vypis[] = new Projektor2_Model_Beh($radek['id_s_beh_projektu'],$radek['beh_cislo'],$radek['oznaceni_turnusu'],$radek['text'],$zacatek,$konec,$radek['closed']);
        }
        return $vypis;        
    }
}

?>