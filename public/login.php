<?php
require_once __DIR__ . '/../app/controllers/AuthController.php';
$uri = explode("/", trim($_SERVER["REQUEST_URI"], "/"));
$method = $_SERVER["REQUEST_METHOD"];
if ($uri[1] == "login" && $method == "POST") {
    $auth = new AuthController();
    $auth->login();
} else {
    http_response_code(404);
    echo json_encode(["message" => "Endpoint not found"]);
}
