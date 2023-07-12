<?php
require_once __DIR__.'/BaseDao.class.php';

class ChallengeDao extends BaseDao{

  /**
  * constructor of dao class
  */
  public function __construct(){
    parent::__construct("challenges");
  }

  public function get_challenge_by_user($id){
    return $this->query("SELECT * FROM challenges WHERE user_id = :id", ['id' => $id]);
  }

}

?>