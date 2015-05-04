<?php
class Projektor2_Model_SysAccUsrKancelarMapper {
    public static function findById($userId, $kancelarId) {
        $dbh = Projektor2_AppContext::getDB();
        $query = "SELECT * FROM sys_acc_usr_kancelar
                    WHERE id_sys_users =:id_sys_users
                    AND id_c_kancelar =:id_c_kancelar";
        $bindParams = array('id_sys_users'=>$userId, 'id_c_kancelar'=>$kancelarId);
        $sth = $dbh->prepare($query);
        $succ = $sth->execute($bindParams);
        $data = $sth->fetch(PDO::FETCH_ASSOC);  
        if(!$data) {
            return NULL;
        }
        return new Projektor2_Model_SysAccUsrKancelar($data['id_sys_acc_usr_kancelar'],$data['id_sys_users'],$data['id_c_kancelar']);
    }
}

?>