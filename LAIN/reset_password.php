<?php
session_start();
require 'db.php';

$errors = [];

if (isset($_GET['token'])) {
    $token = $_GET['token'];
} else {
    die("Invalid token.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($password) || empty($confirm_password)) {
        $errors['password'] = "Both fields are required";
    } elseif ($password !== $confirm_password) {
        $errors['password'] = "Passwords do not match";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE reset_token = :token");
        $stmt->execute([':token' => $token]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE users SET password = :password, reset_token = NULL WHERE reset_token = :token");
            $stmt->execute([':password' => $hashed_password, ':token' => $token]);

            $_SESSION['success'] = "Password successfully reset!";
            header("Location: login.php");
            exit;
        } else {
            $errors['token'] = "Invalid or expired token";
        }
    }
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Reset Password </title>
</head>
<body>
<form method="POST" class="max-w-md mx-auto p-6 bg-white shadow-lg rounded-lg">
    <h2 class="text-2xl font-semibold text-center text-gray-700 mb-4">Reset Password</h2>

    <div class="mb-4">
        <label class="block text-gray-600 text-sm font-medium">New Password</label>
        <input type="password" name="password" required 
            class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-500 outline-none">
    </div>

    <div class="mb-4">
        <label class="block text-gray-600 text-sm font-medium">Confirm Password</label>
        <input type="password" name="confirm_password" required 
            class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-500 outline-none">
    </div>

    <button type="submit"
        class="w-full bg-blue-600 text-white font-semibold py-2 rounded-lg transition duration-200 hover:bg-blue-700 focus:ring-2 focus:ring-blue-400">
        Reset Password
    </button>
</form>
</body>
</html>
