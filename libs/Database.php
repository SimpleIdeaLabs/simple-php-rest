<?php
namespace App\Libs;


/**
 * Database Class Wrapper
 */
class Database {
  
  private $host = 'localhost';
  private $db_name = 'todos';
  private $user = 'root';
  private $password = 'root';
  public $con;

  /**
   * Create PDO Connection
   * Returns connection object
   */
  public function __construct() {
    $this->con = null;
    try{
      $this->con = new \PDO('mysql:host='.$this->host.';dbname='.$this->db_name, $this->user, $this->password);
      $this->con->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }catch(PDOException $e) {
      echo 'PDO connection error '.$e->getMessage();
      die();
    }
  }
}