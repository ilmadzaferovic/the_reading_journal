<?php
require_once __DIR__.'/BaseDao.class.php';

class BookDao extends BaseDao{

  /**
  * constructor of dao class
  */
  public function __construct(){
    parent::__construct("book");
  }

  public function get_books_by_user($id){
    return $this->query("SELECT * FROM book WHERE user_id = :id", ['id' => $id]);
  }
}

?>