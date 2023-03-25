<?php
require_once __DIR__.'/BaseService.class.php';
require_once __DIR__.'/../dao/DnfRsnDao.class.php';

class DnfRsnService extends BaseService{

  public function __construct(){
    parent::__construct(new DnfRsnDao());
  }

}
?>