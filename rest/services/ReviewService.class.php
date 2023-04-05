<?php
require_once __DIR__.'/BaseService.class.php';
require_once __DIR__.'/../dao/ReviewDao.class.php';

class ReviewService extends BaseService{

  public function __construct(){
    parent::__construct(new ReviewDao());
  }

  public function get_review_by_id($id){
    return $this->dao->get_review_by_id($id);
  }

}
?>