<?php

class PersonController {
  function getAllPersons()
  {
    $person = new PersonService();
    return $person->getAllPersons();
  }

  function getPerson($data)
  {
    $person = new PersonService();
    return $person->getPersonById(intval($data['id']));
  }
  
  function insertPerson($personData)
  {
    $person = new PersonService();

    return $person->insertPerson($personData);
  }

  function deletePerson($data)
  {
    $person = new PersonService();
    return $person->deletePerson(intval($data['id']));
  }
}