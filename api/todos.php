<?php
namespace App\Api;
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Require Files
require('../libs/Database.php');
require('../models/Todo.php');

// Class Alias
use \App\Libs\Database as Database;
use \App\Models\Todo as Todo;

/**
 * Todos API
 */
class Todos {

  private $response;

  /**
   * Initialize
   */
  public function __construct() {
    $db = new Database();
    $this->todo = new Todo($db);
  }

  /**
   * Execute API Mapping
   */
  public function execute() {
    $this->method = $_SERVER['REQUEST_METHOD'];

    // REST Controller
    switch($this->method) {
      case 'GET':
        $this->read(); 
        break;
      case 'POST':
        $this->create();
        break;
      case 'PATCH':
        $this->update();
        break;
      case 'DELETE':
        $this->delete();
        break;
      default:
        $this->unsupported();
        break;
    }

    // Respond JSON
    header('Content-type: application/json');
    echo json_encode($this->response);
  }

  /**
   * Create Data
   */
  public function create() {
    $post_data = json_decode(file_get_contents('php://input'), true);
    $todo = array("name" => $post_data['name']);
    $result = $this->todo->save($todo);
    $this->response = $result;
  }

  /**
   * Read Data
   */
  public function read() {
    $query_type = isset($_GET['query_type']) ? $_GET['query_type']: '';
    switch($query_type) {
      case 'single':
        $this->readSingle();
        break;
      default;
        $this->readAll();
        break;
    }
  }

  /**
   * Read All Data from resource
   */
  public function readAll() {
    $todos = $this->todo->getAll();
    $this->response = $todos;
  }

  /**
   * Read Single Data from resource
   */
  public function readSingle() {
    $id = htmlspecialchars($_GET['id']);
    $todo = $this->todo->getOneByProperty($id);
    $this->response = $todo;
  }

  /**
   * Update Data
   */
  public function update() {
    $id = htmlspecialchars($_GET['id']);
    $post_data = json_decode(file_get_contents('php://input'), true);
    $todo = array("name" => $post_data['name']);
    $result = $this->todo->update($id, $todo);
    $this->response = $result;
  }

  /**
   * Delete Data
   */
  public function delete() {
    $id = htmlspecialchars($_GET['id']);
    $result = $this->todo->delete($id);
    $this->response = $result;
  }

  /**
   * Unsupported method
   */
  public function unsupported($method) {
    echo $method.' is unsupported';
  }

}

$todos = new Todos();
$todos->execute();