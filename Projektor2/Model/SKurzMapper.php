<?php
class Projektor2_Model_SKurzMapper {
    public static function findById($id) {
        $dbh = Projektor2_AppContext::getDB();
        $query = "SELECT * FROM s_kurz WHERE id_s_kurz = :id_s_kurz AND valid = 1";
        $bindParams = array('id_s_kurz'=>$id);
        $sth = $dbh->prepare($query);
        $succ = $sth->execute($bindParams);
        $data = $sth->fetch(PDO::FETCH_ASSOC);  
        if(!$data) {
            return NULL;
        } 
//        $dateZacatek = new Projektor2_Datum($radek['date_zacatek'],"MySQL");
//        $dateKonec = new Projektor2_Datum($radek['date_konec'],"MySQL");
        $datetimeZacatek = Projektor2_DatumB::zSQL($radek['date_zacatek']);
        $datetimeKonec = Projektor2_DatumB::zSQL($radek['date_konec']);
        $dateZacatek = $datetimeZacatek->dejDatumRetezec();
        $dateKonec = $datetimeKonec->dejDatumRetezec();
        return new Projektor2_Model_SKurz($radek['id_s_kurz'],$radek['razeni'],$radek['projekt_kod'],
                $radek['kurz_druh'],$radek['kurz_cislo'],$radek['beh_cislo'],$radek['kurz_lokace'],$radek['kurz_zkratka'],
                $radek['kurz_nazev'],$radek['kurz_termin'],
                $dateZacatek,$dateKonec,$radek['valid']);
    }

    public static function findAll($filter = NULL, $order = NULL) {
        $dbh = Projektor2_AppContext::getDB(); 
        $query = "SELECT * FROM s_kurz WHERE valid = 1";
        if ($filter AND is_string($filter)) {
            $query .= " AND ".$filter;
        }
        if ($order AND is_string($order)) {
            $query .= " ORDER BY ".$order;
        }
        $sth = $dbh->prepare($query);
        $succ = $sth->execute();
        $radky = $sth->fetchAll(PDO::FETCH_ASSOC);  
        if(!$radky) {
            return NULL;
        }        foreach($radky as $radek) {
            $datetimeZacatek = Projektor2_DatumB::zSQL($radek['date_zacatek']);
            $datetimeKonec = Projektor2_DatumB::zSQL($radek['date_konec']);
            $dateZacatek = $datetimeZacatek->dejDatumRetezec();
            $dateKonec = $datetimeKonec->dejDatumRetezec();
            $vypis[] = new Projektor2_Model_SKurz($radek['id_s_kurz'],$radek['razeni'],$radek['projekt_kod'],
                $radek['kurz_druh'],$radek['kurz_cislo'],$radek['beh_cislo'],$radek['kurz_lokace'],$radek['kurz_zkratka'],
                $radek['kurz_nazev'],$radek['kurz_termin'],
                $dateZacatek,$dateKonec,$radek['valid']);
        }
        return $vypis;        
    }
}

?>