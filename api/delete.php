<!-- Removing a user from the database by providing his id -->
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


if (!empty($data->id)) {
    $user->id = $data->id;

    if ($user->delete()) {
        http_response_code(200);
        echo json_encode(array("message" => "The user has been deleted"));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Cannot delete the user"));
    }
} else {
    http_response_code(400);
    echo json_encode(array(
        "message" => "Error! Data is incomplete"
    ));
}
