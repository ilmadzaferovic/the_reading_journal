<?php
require_once __DIR__.'/BaseService.class.php';
require_once __DIR__.'/../dao/BookDao.class.php';

class BookService extends BaseService{

  public function __construct(){
    parent::__construct(new BookDao());
  }

  public function get_books_by_user($id){
    return $this->dao->get_books_by_user($id);
  }
}
?>