<?php
require_once __DIR__ . '/../core/Database.php';

class Token {
    private $conn;

    public function __construct() {
        $this->conn = Database::connect();
    }
    public function storeToken($user_id, $token, $expires_at) {
        $stmt = $this->conn->prepare("INSERT INTO tokens (user_id, token, expires_at) VALUES (:user_id, :token, :expires_at)");
        $stmt->bindParam(":user_id", $user_id);
        $stmt->bindParam(":token", $token);
        $stmt->bindParam(":expires_at", $expires_at);
        return $stmt->execute();

    }

    public function validateToken($token) {
        $stmt = $this->conn->prepare("SELECT * FROM tokens WHERE token = :token AND expires_at > NOW()");
        $stmt->bindParam(":token", $token);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
