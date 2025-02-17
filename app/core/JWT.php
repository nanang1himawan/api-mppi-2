<?php
require '../vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTHandler
{
    private static $secret_key = "8eed8ej4kjd80akkm03ks0b";
    private static $algorithm = "HS256";

    public static function generateToken($payload)
    {
        return JWT::encode($payload, self::$secret_key, self::$algorithm);
    }

    public static function validateToken($token) {
        $db = Database::connect();
        $stmt = $db->prepare("SELECT * FROM tokens WHERE token = ?");
        $stmt->execute([$token]);
        $tokenData = $stmt->fetch(PDO::FETCH_ASSOC);
        
    
        if (!$tokenData) {
            return false; // Token tidak ditemukan (mungkin sudah logout)
            
        }
        try {
            // Decode token JWT
            $decoded = JWT::decode($token, new Key(self::$secret_key, 'HS256'));
            $decodedArray = (array) $decoded;
            
            $timestamp = time(); // Ambil waktu saat ini (UTC)
            $date = new DateTime("@$timestamp"); 
            $date->setTimezone(new DateTimeZone('Asia/Jakarta')); // Konversi ke UTC+7
            
            // Periksa apakah token sudah expired
            if ($decodedArray['exp'] < $date->format('Y-m-d H:i:s')) {
                // Hapus token yang sudah expired dari database
                $stmt = $db->prepare("DELETE FROM tokens WHERE token = ?");
                $stmt->execute([$token]);
    
                return false; // Token expired, return false
            }
    
            return $decodedArray; // Token valid
        } catch (Exception $e) {
            return false; // Token tidak valid
            
        }
    }
    
    
}
