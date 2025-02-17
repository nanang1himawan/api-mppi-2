<?php
require_once __DIR__ . '/../app/models/User.php';

$userModel = new User(); // Inisialisasi class User
$email = "admin3@mail.com";  // Ganti dengan username yang diinginkan
$password = "admin@Mppi2"; // Ganti dengan password yang diinginkan
$role = "Admin"; // Ganti dengan role yang diinginkan
$fullname = "Dito"; // Ganti dengan fullname yang diinginkan

if ($userModel->createUser($email, $password, $role, $fullname)) {
    echo "User berhasil didaftarkan!";
} else {
    echo "Gagal mendaftarkan user.";
}
?>
