<?php
require_once __DIR__ . '/../core/Database.php';

class User
{
    private $conn;
    public function __construct()
    {
        $this->conn = Database::connect();
    }

    public function findUserByEmail($email)
    {
        $stmt = $this->conn->prepare("SELECT * FROM masteruser WHERE email = :email");
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createUser($email, $password, $role, $fullname)
    {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        var_dump($hashedPassword);
        $stmt = $this->conn->prepare("INSERT INTO masteruser (email, password, role, fullname) VALUES (:email, :password, :role, :fullname)");
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":password", $hashedPassword);
        $stmt->bindParam(":role", $role);
        $stmt->bindParam(":fullname", $fullname);
        return $stmt->execute();
    }
    public function deleteToken($user_id)
    {
        $db = Database::connect();
        $stmt = $db->prepare("DELETE FROM tokens WHERE user_id = ?");
        return $stmt->execute([$user_id]);
    }

    public function activeUser()
    {
        $db = Database::connect();

        $stmt = $db->prepare("SELECT m.masterUserID, m.fullname, m.email, m.role FROM masteruser m JOIN tokens t ON m.masterUserID = t.user_id GROUP BY m.masterUserID");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
