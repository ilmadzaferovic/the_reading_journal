<?php
require_once __DIR__.'/BaseDao.class.php';

class DnfDao extends BaseDao{

  /**
  * constructor of dao class
  */
  public function __construct(){
    parent::__construct("dnf");
  }

  public function get_dnf_by_user($id){
    return $this->query("SELECT * FROM dnf WHERE user_id = :id", ['id' => $id]);
  }
}

?>