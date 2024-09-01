<?php
$root = $_SERVER['DOCUMENT_ROOT'] . "/7learn-exer/";
include  $root . "loader.php";

use App\Utilities\Response;

$request_method = $_SERVER["REQUEST_METHOD"];

$request_body = json_decode(file_get_contents("php://input"), true);

switch ($request_method) {
    case "GET":
        $user_id = $_GET["id"] ?? null;

        $request_data = [
            'id' => $user_id,

        ];
        $response = getUsers($request_data);
        if (empty($response)) {
            Response::respondDie("Error : Province not found", Response::HTTP_NOT_FOUND);
        }
        Response::respondDie($response, Response::HTTP_OK);
    case "POST":
       
        $response = addUser($request_body);
        Response::respondDie($response, Response::HTTP_CREATED);

    case "PUT":
        [$name , $id ] = [$request_body['name'], $request_body['id']];
        $result = updateUser($name, $id);
        if ($result == 0) {
            Response::respondDie("Error : please change your name or enter correct id", Response::HTTP_NOT_ACCEPTABLE);
        }
        Response::respondDie($result . " id : $id successfuly changed , now its city name is $name", Response::HTTP_OK);

    case "DELETE":
        $id = (int) $_GET["deleteUser"] ?? 0; // with QUERY paramets
        // $city_id = $request_body['city_id']; // QUERY BODY 
        $result = deleteUser($id);
        if ($result == 0) {
            Response::respondDie("Error : please enter the correct id", Response::HTTP_NOT_FOUND);
        }
        Response::respondDie($result, Response::HTTP_OK);

    default:
        Response::respondDie("Invalid request Method", Response::HTTP_METHOD_NOT_ALLOWED);
}
