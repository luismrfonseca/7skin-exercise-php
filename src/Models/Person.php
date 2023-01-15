<?php

class PersonModel {
  private $conn;
  private $table = 'person';

  public $id;
  public $name;
  public $gender;
  public $age;

  public function __construct($db)
  {
    $this->conn = $db;
  }

  public function getAllPersons() {
    $sql = 'SELECT id, name, gender, age FROM ' . $this->table . ' ORDER BY id;';

    $result = $this->conn->query($sql);

    if (mysqli_num_rows($result) > 0){
      return mysqli_fetch_all($result, MYSQLI_ASSOC);;
    } else {
      return [];
    }
  }

  public function getPersonById() {
    $sql = 'SELECT id, name, gender, age FROM ' . $this->table . ' WHERE id = ?;';

    $stmt = $this->conn->prepare($sql);

    $stmt->bind_param('i', $this->id);

    $stmt->execute();

    $result = $stmt->get_result();

    if (mysqli_num_rows($result) > 0){
      return $result->fetch_assoc();
    } else {
      throw new \Exception("Person not found");
    }
  }
  
  public function insertPerson() {
    $sql = 'INSERT INTO person(name, gender, age) VALUES (?, ?, ?); ';

    $stmt = $this->conn->prepare($sql);

    $stmt->bind_param('ssi', $this->name, $this->gender, $this->age);

    if($stmt->execute()){
      return true;
    }

    return $stmt->connect_errno;
  }

  public function deletePerson() {
    $sql = 'DELETE FROM person WHERE id = ?; ';

    $stmt = $this->conn->prepare($sql);

    $stmt->bind_param('i', $this->id);

    if($stmt->execute()){
      return true;
    }

    return $stmt->connect_errno;
  }
}