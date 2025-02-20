<?php

class Database {
    private static $host = "localhost";
    private static $db_name = "mppi_dev_v1"; // Ganti dengan nama database Anda
    private static $username = "root"; // Sesuaikan dengan konfigurasi MySQL Anda
    private static $password = ""; // Jika ada password, isi di sini

    //private static $db_name = "nana6202_api-mppi-v1"; // Ganti dengan nama database Anda
    //private static $username = "nana6202_mppi-v1"; // Sesuaikan dengan konfigurasi MySQL Anda
    //private static $password = "Jbiqd,CVEg_c"; // Jika ada password, isi di sini

    private static $conn = null;

    public static function connect() {
        if (self::$conn === null) {
            try {
                self::$conn = new PDO(
                    "mysql:host=" . self::$host . ";dbname=" . self::$db_name,
                    self::$username,
                    self::$password
                );
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $exception) {
                die("Connection error: " . $exception->getMessage());
            }
        }
        return self::$conn;
    }
}
?>