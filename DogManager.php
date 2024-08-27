<?php
require_once 'config.php';
require_once 'Dog.php';

class DogManager {
    private $conn;
    private $dog;

    public function __construct() {
        global $conn;
        $this->conn = $conn;
        $this->dog = new Dog($this->conn);
    }

    public function addDog($name, $breed, $age, $weight) {
        $this->dog->name = $name;
        $this->dog->breed = $breed;
        $this->dog->age = $age;
        $this->dog->weight = $weight;
        return $this->dog->create();
    }

    public function getDog($id) {
        $result = $this->dog->read($id);
        return $result->fetch_assoc();
    }

    public function getAllDogs() {
        $result = $this->dog->read();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function updateDog($id, $name, $breed, $age, $weight) {
        $this->dog->id = $id;
        $this->dog->name = $name;
        $this->dog->breed = $breed;
        $this->dog->age = $age;
        $this->dog->weight = $weight;
        return $this->dog->update();
    }

    public function deleteDog($id) {
        $this->dog->id = $id;
        return $this->dog->delete();
    }
}