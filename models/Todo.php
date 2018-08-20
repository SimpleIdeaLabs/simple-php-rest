<?php
namespace App\Models;

/**
 * Todo Model
 */
class Todo {

  // Database Connection Instance
  private $db;

  // Table Name
  private $table = 'todo';

  // Initialize
  public function __construct($db) {
    $this->db = $db->con;
  }

  /**
   * Get Single data by property
   */
  public function getOneByProperty($value, $prop = 'id') {
    $sql = "SELECT * FROM $this->table WHERE $prop = :value";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam('value', $value);
    $stmt->execute();
    $result = $stmt->fetch(\PDO::FETCH_ASSOC);
    return $result;
  }

  /**
   * Get all data
   */
  public function getAll() {
    $sql = "SELECT * FROM $this->table";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    $result_arr = array();
    while($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
      extract($row);
      $result_item = array(
        'id' => $id,
        'name' => $name,
      );
      array_push($result_arr, $result_item);
    }
    return $result_arr;
  }

  /**
   * Save Data
   */
  public function save($todo) {
    $query = "INSERT INTO $this->table SET name = :name";
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':name', $todo['name']);
    return $stmt->execute();
  }

  /**
   * Update Data
   */
  public function update($id, $todo) {
    $query = "UPDATE $this->table SET name = :name WHERE id = :id";
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':name', $todo['name']);
    $stmt->bindParam(':id', $id);
    return $stmt->execute();
  }

  /**
   * Delete Data
   */
  public function delete($id) {
    $query = "DELETE FROM $this->table WHERE id = :id";
    $stmt = $this->db->prepare($query);
    $stmt->bindParam('id', $id);
    return $stmt->execute();
  }

}