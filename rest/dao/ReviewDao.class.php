<?php
require_once __DIR__.'/BaseDao.class.php';

class ReviewDao extends BaseDao{

  /**
  * constructor of dao class
  */
  public function __construct(){
    parent::__construct("reviews");
  }

  public function get_review_by_id($id){
    return $this->query("SELECT * FROM reviews WHERE book_book_id = :id", ['id' => $id]);
  }

}

?>