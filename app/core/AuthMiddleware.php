<?php
require_once __DIR__ . "/JWT.php"; // Sesuaikan dengan lokasi class JWTHandler
include __DIR__ . '/../../header.php';

class AuthMiddleware {
    public static function authenticate() {
        $headers = apache_request_headers();
        
        if (!isset($headers['Authorization'])) {
            http_response_code(401);
            echo json_encode(["message" => "Token tidak ditemukan"]);
            exit;
        }

        
        // Mendapatkan token dari Header "Authorization: Bearer <token>"
        $token = str_replace("Bearer ", "", $headers['Authorization']);
        $decoded = JWTHandler::validateToken($token);

        if (!$decoded) {
            http_response_code(401);
            echo json_encode(["message" => "Token tidak valid"]);
            exit;
        }

        return $decoded; // Berisi data user dari JWT
    }
}
?>
