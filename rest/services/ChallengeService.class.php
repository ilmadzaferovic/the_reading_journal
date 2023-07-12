<?php
require_once __DIR__.'/BaseService.class.php';
require_once __DIR__.'/../dao/ChallengeDao.class.php';

class ChallengeService extends BaseService{

  public function __construct(){
    parent::__construct(new ChallengeDao());
  }

  public function get_challenge_by_user($id){
    return $this->dao->get_challenge_by_user($id);
  }
}
?>