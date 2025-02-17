<?php
require_once __DIR__ . '/../core/AuthMiddleware.php';
class UserController {
    public function getUserProfile() {
        // Validasi token sebelum menjalankan fungsi
        $userData = AuthMiddleware::authenticate();
        
        echo json_encode([
            "message" => "Token valid",
            "data" => $userData
        ]);
    }
    public function logout() {
        $userData = AuthMiddleware::authenticate(); // Validasi token
        $userModel = new User();

        if ($userModel->deleteToken($userData['user_id'])) {
            echo json_encode(["message" => "Logout berhasil"]);
        } else {
            echo json_encode(["message" => "Gagal logout"], JSON_PRETTY_PRINT);
        }
    }
}
?>
