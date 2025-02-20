<?php
require_once __DIR__ . '/../app/controllers/UserController.php';
$uri = explode("/", trim($_SERVER["REQUEST_URI"], "/"));
$method = $_SERVER["REQUEST_METHOD"];
if ($uri[1] == "active-user" && $method == "POST") {
    $user = new UserController();
    $user->activeUser();
}
 else {
    http_response_code(404);
    echo json_encode(["message" => "Endpoint not found"]);
}
