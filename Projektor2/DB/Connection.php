<?php
interface Projektor2_DB_Connection {
  public function prepare($query);
  public function execute($query);
}

?>