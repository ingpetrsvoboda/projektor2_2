<?php
class Projektor2_Model_ZajemceRegistraceMapper {
    public static function findById($id) {
        $dbh = Projektor2_AppContext::getDB();
        $query = "SELECT `zajemce`.`id_zajemce` AS `id_zajemce`,
                 concat_ws(' ',`za_flat_table`.`prijmeni`,`za_flat_table`.`jmeno`,`za_flat_table`.`titul`,`za_flat_table`.`titul_za`) AS `jmeno_cele`,
                 `zajemce`.`identifikator` AS `identifikator`,
                 `zajemce`.`znacka` AS `znacka`,
                 `za_flat_table`.`datum_reg` AS `datum_reg`,
                 concat(`za_flat_table`.`vzdelani1`,`za_flat_table`.`vzdelani2`,`za_flat_table`.`vzdelani3`,`za_flat_table`.`vzdelani4`,`za_flat_table`.`vzdelani5`) AS `vyplneno_vzdelani`                
          FROM (`zajemce` join `za_flat_table` on (`zajemce`.`id_zajemce` = `za_flat_table`.`id_zajemce`))        
          WHERE `zajemce`.`id_zajemce` = :id_zajemce AND valid = 1";
        $bindParams = array('id_zajemce'=>$id);
        $sth = $dbh->prepare($query);
        $succ = $sth->execute($bindParams);
        $data = $sth->fetch(PDO::FETCH_ASSOC);  
        if(!$data) {
            return NULL;
        }
        return new Projektor2_Model_ZajemceRegistrace($data['jmeno_cele'], $data['identifikator'], $data['znacka'], $data['datum_reg'], $data['vyplneno_vzdelani'], $data['id_zajemce']);
    }
    
    public static function findAll($filter = NULL, $order = NULL) {
        $dbh = Projektor2_AppContext::getDB(); 
        $sessionStatus = Projektor2_SessionStatus::getSessionStatus();        
        $query = "SELECT `zajemce`.`id_zajemce` AS `id_zajemce`,
                         concat_ws(' ',`za_flat_table`.`prijmeni`,`za_flat_table`.`jmeno`,`za_flat_table`.`titul`,`za_flat_table`.`titul_za`) AS `jmeno_cele`,
                         `zajemce`.`identifikator` AS `identifikator`,
                         `zajemce`.`znacka` AS `znacka`,
                         `za_flat_table`.`datum_reg` AS `datum_reg`,
                         concat(`za_flat_table`.`vzdelani1`,`za_flat_table`.`vzdelani2`,`za_flat_table`.`vzdelani3`,`za_flat_table`.`vzdelani4`,`za_flat_table`.`vzdelani5`) AS `vyplneno_vzdelani`                
                  FROM (`zajemce` join `za_flat_table` on (`zajemce`.`id_zajemce` = `za_flat_table`.`id_zajemce`))        
                  WHERE `id_s_beh_projektu_FK` = :id_s_beh_projektu_FK AND `id_c_kancelar_FK` = :id_c_kancelar_FK AND valid = 1";
        if ($filter AND is_string($filter)) {
            $query .= " AND ".$filter;
        }
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
            $vypis[] = new Projektor2_Model_ZajemceRegistrace($radek['jmeno_cele'], $radek['identifikator'], $radek['znacka'], $radek['datum_reg'], $radek['vyplneno_vzdelani'], $radek['id_zajemce']);
        }
        return $vypis;
    }
}

?>