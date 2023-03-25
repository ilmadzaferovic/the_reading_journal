<?php
require_once __DIR__.'/BaseService.class.php';
require_once __DIR__.'/../dao/DnfDao.class.php';

class DnfService extends BaseService{

  public function __construct(){
    parent::__construct(new DnfDao());
  }

}
?>