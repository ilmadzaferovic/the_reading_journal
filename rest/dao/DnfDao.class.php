<?php
require_once __DIR__.'/BaseDao.class.php';

class DnfDao extends BaseDao{

  /**
  * constructor of dao class
  */
  public function __construct(){
    parent::__construct("dnf");
  }

}

?>