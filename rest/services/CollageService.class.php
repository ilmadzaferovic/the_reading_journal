<?php
require_once __DIR__.'/BaseService.class.php';
require_once __DIR__.'/../dao/CollageDao.class.php';

class CollageService extends BaseService{

  public function __construct(){
    parent::__construct(new CollageDao());
  }

}
?>