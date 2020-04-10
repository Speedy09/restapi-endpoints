<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once './connect.php';
include_once './users.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);

$data = json_decode(file_get_contents("php://input"));

if (
    !empty($data->id) &&
    !empty($data->name) &&
    !empty($data->email) &&
    !empty($data->password)
) {
    $user->id = $data->id;
    $user->name = $data->name;
    $user->email = $data->email;
    $user->password = $data->password;

    if ($user->update()) {
        http_response_code(200);
        echo json_encode(array("message" => "The user has been edited"));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Cannot edit user"));
    }
} else {
    http_response_code(400);
    echo json_encode(array(
        "message" => "Error! Data is incomplete"
    ));
}
