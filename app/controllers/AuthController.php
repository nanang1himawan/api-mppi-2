<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Token.php';
require_once __DIR__ . '/../core/JWT.php';
class AuthController
{
    public function login()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data["email"]) || !isset($data["password"])) {
            http_response_code(400);
            echo json_encode(["message" => "Invalid input"]);
            return;
        }

        $userModel = new User();
        $user = $userModel->findUserByEmail($data["email"]);

        if (!$user || !password_verify($data["password"], $user["password"])) {
            http_response_code(401);
            echo json_encode(["message" => "Invalid credentials"]);
            return;
        }
        $timestamp = time() + 60 * 60; // Ambil waktu saat ini (UTC)
        $date = new DateTime("@$timestamp");
        $date->setTimezone(new DateTimeZone('Asia/Jakarta')); // Konversi ke UTC+7

        $payload = [
            "user_id" => $user["masterUserID"],
            "exp" => $date->format('Y-m-d H:i:s')
        ];

        $token = JWTHandler::generateToken($payload);
        $tokenModel = new Token();
        $tokenModel->storeToken($user["masterUserID"], $token, $payload["exp"]);

        echo json_encode(["token" => $token]);
    }
}
