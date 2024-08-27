<?php
require_once 'DogManager.php';

header('Content-Type: application/json');

$dogManager = new DogManager();

// Get the request method
$method = $_SERVER['REQUEST_METHOD'];

// Handle different HTTP methods
switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            // Get a specific dog
            $dog = $dogManager->getDog($_GET['id']);
            echo json_encode(['status' => 'success', 'data' => $dog]);
        } else {
            // Get all dogs
            $allDogs = $dogManager->getAllDogs();
            echo json_encode(['status' => 'success', 'data' => $allDogs]);
        }
        break;

    case 'POST':
        // Get the raw POST data
        $rawData = file_get_contents('php://input');
        parse_str($rawData, $data);

        // Check if required fields are present
        if (!isset($data['name'], $data['breed'], $data['age'], $data['weight'])) {
            echo json_encode(['status' => 'error', 'message' => 'Missing required fields in data.']);
            die();
        }

        // Add a new dog
        $newDogId = $dogManager->addDog($data['name'], $data['breed'], $data['age'], $data['weight']);
        echo json_encode(['status' => 'success', 'message' => 'New dog added', 'id' => $newDogId]);
        break;

    case 'PUT':
        // Get the raw PUT data
        $rawData = file_get_contents('php://input');
        parse_str($rawData, $data);

        // Check if required fields are present
        if (!isset($data['id'], $data['name'], $data['breed'], $data['age'], $data['weight'])) {
            echo json_encode(['status' => 'error', 'message' => 'Missing required fields in data.']);
            die();
        }

        // Update an existing dog
        $updated = $dogManager->updateDog($data['id'], $data['name'], $data['breed'], $data['age'], $data['weight']);
        echo json_encode(['status' => 'success', 'message' => 'Dog updated', 'updated' => $updated]);
        break;

    case 'DELETE':
        // Get the raw DELETE data
        $rawData = file_get_contents('php://input');
        parse_str($rawData, $data);

        // Check if required fields are present
        if (!isset($data['id'])) {
            echo json_encode(['status' => 'error', 'message' => 'Missing required fields in data.']);
            die();
        }

        // Delete an existing dog
        $deleted = $dogManager->deleteDog($data['id']);
        echo json_encode(['status' => 'success', 'message' => 'Dog deleted', 'deleted' => $deleted]);
        break;

    default:
        echo json_encode(['status' => 'error', 'message' => 'Unsupported request method.']);
        die();
}