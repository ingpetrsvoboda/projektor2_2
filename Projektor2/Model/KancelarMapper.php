<?php
class Projektor2_Model_KancelarMapper {
    public static function findById($id) {
        $dbh = Projektor2_AppContext::getDB();
        $query = "SELECT * FROM c_kancelar WHERE id_c_kancelar = :id_c_kancelar AND valid = 1";
        $bindParams = array('id_c_kancelar'=>$id);
        $sth = $dbh->prepare($query);
        $succ = $sth->execute($bindParams);
        $data = $sth->fetch(PDO::FETCH_ASSOC);  
        if(!$data) {
            return NULL;
        }
        return new Projektor2_Model_Kancelar($data['id_c_kancelar'],$data['kod'],$data['text'],$data['plny_text']);
    }

    public static function findByKod($kod) {
        $dbh = Projektor2_AppContext::getDB();
        $query = "SELECT * FROM c_kancelar WHERE kod = :kod AND valid = 1";
        $sth = $dbh->prepare($query);
        $bindParams = array('kod'=>$kod);
        $succ = $sth->execute($bindParams);
        $data = $sth->fetch(PDO::FETCH_ASSOC);        
        if(!$data) {
            return NULL;
        }
        return new Projektor2_Model_Kancelar($data['id_c_kancelar'],$data['kod'],$data['text'],$data['plny_text']);
    }
    
    public static function findByText($text) {
        $dbh = Projektor2_AppContext::getDB();
        $query = "SELECT * FROM c_kancelar WHERE text = :text AND valid = 1";
        $bindParams = array('text'=>$text);
        $sth = $dbh->prepare($query);
        $succ = $sth->execute($bindParams);
        $data = $sth->fetch(PDO::FETCH_ASSOC);  
        if(!$data) {
            return NULL;
        }        

        return new Projektor2_Model_Kancelar($data['id_c_kancelar'],$data['kod'],$data['text'],$data['plny_text']);
    }
}

?>