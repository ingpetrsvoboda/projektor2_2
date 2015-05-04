<?php
class Projektor2_Model_ZajemceMapper {
    
    public static function findById($id) {
        $dbh = Projektor2_AppContext::getDB();
        $query = "SELECT * FROM zajemce WHERE id_zajemce = :id_zajemce AND valid = 1";
        $bindParams = array('id_zajemce'=>$id);
        $sth = $dbh->prepare($query);
        $succ = $sth->execute($bindParams);
        $data = $sth->fetch(PDO::FETCH_ASSOC);  
        if(!$data) {
            return NULL;
        }
        return new Projektor2_Model_Zajemce($data['cislo_zajemce'], $data['identifikator'], $data['znacka'], $data['id_c_projekt_FK'], $data['id_c_kancelar_FK'], $data['id_s_beh_projektu_FK'], $data['id_zajemce']);
    }
    
    public static function create() {
        $appStatus = Projektor2_SessionStatus::getSessionStatus();
        if(!$appStatus->kancelar OR !$appStatus->projekt OR !$appStatus->beh) {
            throw new Exception ("Cannot create new zajemce - kancelar,projekt,beh - one or more are not setted or setted improperly");
        }
        $dbh = Projektor2_AppContext::getDB(); 
        $query = "SELECT Max(zajemce.cislo_zajemce) AS maxU  FROM zajemce
                  WHERE (id_c_projekt_FK = :id_c_projekt_FK AND id_c_kancelar_FK = :id_c_kancelar_FK )";  //vybírá i nevalidní
        $bindParams = array('id_c_projekt_FK'=>$appStatus->projekt->id, 'id_c_kancelar_FK'=>$appStatus->kancelar->id);
        $sth = $dbh->prepare($query);
        $succ = $sth->execute($bindParams);
        $data = $sth->fetch(PDO::FETCH_ASSOC);  
        if(!$data) {
            return NULL;
        }        
        if ($data['maxU']) {
            $nove_cislo_ucastnika= $data['maxU'] + 1 ;
        } else {
            $nove_cislo_ucastnika = 1;
        }
        $identifikator = new Projektor2_ItemID($appStatus->projekt->id, $appStatus->kancelar->id,1);
        $identifikator->u_cislo_polozky = $nove_cislo_ucastnika;
        $identifikator->c_cislo_behu = $appStatus->beh->beh_cislo; 
        $identifikator->c_oznaceni_turnusu = $appStatus->beh->oznaceni_turnusu;
        
        $retezec = strval($nove_cislo_ucastnika);
        $retezec = str_pad($retezec, 3, "0", STR_PAD_LEFT); // doplní zleva nulami na 3 místa
        $znacka = $appStatus->beh->oznaceni_turnusu.'-'.$appStatus->kancelar->kod.'-'.$retezec;
        
        $query = "INSERT INTO  zajemce (cislo_zajemce, identifikator, znacka, id_c_projekt_FK, id_c_kancelar_FK,id_s_beh_projektu_FK )
                  VALUES (:cislo_zajemce, :identifikator, :znacka, :id_c_projekt_FK, :id_c_kancelar_FK, :id_s_beh_projektu_FK)";             
        $bindParams = array('cislo_zajemce'=>$nove_cislo_ucastnika, 'identifikator'=>$identifikator->generuj_cislo(), 
                            'znacka'=>$znacka, 'id_c_projekt_FK'=>$appStatus->projekt->id, 
                            'id_c_kancelar_FK'=>$appStatus->kancelar->id, 'id_s_beh_projektu_FK'=>$appStatus->beh->id);
        $sth = $dbh->prepare($query);
        $succ = $sth->execute($bindParams);
        $data = $sth->fetch(PDO::FETCH_ASSOC);  
        if(!$data) {
            return NULL;
        }
        return Projektor2_Model_ZajemceMapper::findById($dbh->lastInsertId());
    }
    
    public static function findAll($order = NULL) {
        $dbh = Projektor2_AppContext::getDB(); 
        $sessionStatus = Projektor2_SessionStatus::getSessionStatus();
        $query = "SELECT * FROM `zajemce` WHERE `zajemce`.`id_s_beh_projektu_FK` = :id_s_beh_projektu_FK AND `id_c_kancelar_FK` = :id_c_kancelar_FK AND valid = 1";
        if ($order AND is_string($order)) {
            $query .= " ORDER ".$order;
        }
        $bindParams = array('id_s_beh_projektu_FK'=>$sessionStatus->beh->id, 'id_c_kancelar_FK'=>$sessionStatus->kancelar->id);
        $sth = $dbh->prepare($query);
        $succ = $sth->execute($bindParams);
        $radky = $sth->fetchAll(PDO::FETCH_ASSOC);  
        if(!$radky) {
            return NULL;
        }  
        foreach($radky as $radek) {
            $vypis[] =  new Projektor2_Model_Zajemce($radek['cislo_zajemce'], $radek['identifikator'], $radek['id_c_projekt_FK'], $radek['id_c_kancelar_FK'], $radek['id_s_beh_projektu_FK'], $radek['id_zajemce']);
        }

        return $vypis;
    }
    
    //TODO: dodělat metodu setUpdated do ZajemceMapper - nastaví sloupec updated na 1, volá se při zápisu do libovolné FT (v metodě save)
}

?>