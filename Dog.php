<?php
class Dog {
    private $conn;
    private $table = 'dogs';

    public $id;
    public $name;
    public $breed;
    public $age;
    public $weight;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create
public function create() {
    $query = "INSERT INTO " . $this->table . " (name, breed, age, weight) VALUES (?, ?, ?, ?)";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("ssid", $this->name, $this->breed, $this->age, $this->weight);

    if ($stmt->execute()) {
        return $this->conn->insert_id;
    }
    return false;
}

// Read
public function read($id = null) {
    if ($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
    } else {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
    }

    $stmt->execute();
    return $stmt->get_result();
}

// Update
public function update() {
    $query = "UPDATE " . $this->table . " SET name = ?, breed = ?, age = ?, weight = ? WHERE id = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("ssidi", $this->name, $this->breed, $this->age, $this->weight, $this->id);

    if ($stmt->execute()) {
        return true;
    }
    return false;
}

// Delete
public function delete() {
    $query = "DELETE FROM " . $this->table . " WHERE id = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("i", $this->id);

    if ($stmt->execute()) {
        return true;
    }
    return false;
}
}