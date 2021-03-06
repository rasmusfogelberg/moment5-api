<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../config/Database.php';
include_once '../classes/Course.php';


$db = new Database();
$course = new Course($db);

$data = json_decode(file_get_contents('php://input'));

// If there is value set to the following parameters
if (isset($data->id, $data->code, $data->name, $data->progression, $data->course_syllabus)) {

    // Update that particular course
    $result = $course->updateCourse($data);

    if ($result->rowCount() > 0) {
        http_response_code(200);
        echo json_encode(['message' => 'Course was updated successfully.']);
    } else {
        http_response_code(404);
        echo json_encode(['message' => 'There is nothing to update.']);
    }
} else {
    http_response_code(400);
    echo json_encode(['message' => 'Must fill out all fields.']);
}
