<?php

class PersonService {
  private $db;

  public function __construct()
  {
    $this->db = Database::getConnection();
  }

  function getAllPersons()
  {
    $person = new PersonModel($this->db);
    return $person->getAllPersons();
  }

  function getPersonById($id)
  {
    $person = new PersonModel($this->db);

    if (!is_int($id) || $id <= 0) {
      throw new \Exception("Incorrect value");
    }

    $person->id = $id;
    return $person->getPersonById();
  }
    
  function insertPerson($personData)
  {
    $person = new PersonModel($this->db);
    $person->name = htmlspecialchars(strip_tags($personData->name));
    $person->gender = htmlspecialchars(strip_tags($personData->gender));
    $person->age = htmlspecialchars(strip_tags($personData->age));

    if (!in_array($person->gender, array('MALE', 'FEMALE'))){
      throw new \Exception("Incorrect Gender value");
    }

    $result = $person->insertPerson();

    if ($result) {
      return $person->getAllPersons();
    }

    return $result;
  }

  function deletePerson($id)
  {
    $person = new PersonModel($this->db);

    if (!is_int($id) || $id <= 0) {
      throw new \Exception("Incorrect value");
    }

    $person->id = $id;

    $result = $person->getPersonById();

    if (!is_array($result)) {
      throw new \Exception("Person not found");
    }

    $person->deletePerson();

    return $person->getAllPersons();
  }
}