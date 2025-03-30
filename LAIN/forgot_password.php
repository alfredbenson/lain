<?php
session_start();
require 'db.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);

    if (empty($email)) {
        $errors['email'] = "Email is required";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Generate token
            $token = bin2hex(random_bytes(50));
            $stmt = $pdo->prepare("UPDATE users SET reset_token = :token WHERE email = :email");
            $stmt->execute([':token' => $token, ':email' => $email]);

            // Send email (Example: replace with actual email sending)
            $reset_link = "http://yourdomain.com/reset_password.php?token=$token";
            mail($email, "Password Reset", "Click here to reset: $reset_link");

            $_SESSION['success'] = "Password reset link has been sent!";
        } else {
            $errors['email'] = "Email not found";
        }
    }
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Forgot Password</title>
</head>
<body>
<div class="flex items-center justify-center min-h-screen bg-gradient-to-r from-blue-500 to-purple-600 p-6">
    <form method="POST" class="w-full max-w-md p-6 bg-white bg-opacity-10 backdrop-blur-md shadow-lg rounded-2xl">
        <h2 class="text-3xl font-bold text-center text-white mb-4">Forgot Password?</h2>
        <p class="text-sm text-gray-200 text-center mb-6">Enter your email to receive a password reset link.</p>

        <div class="mb-4">
            <label class="block text-gray-300 text-sm font-medium">Email Address</label>
            <input type="email" name="email" required 
                class="w-full mt-1 px-4 py-3 bg-transparent border border-gray-300 rounded-lg text-white placeholder-gray-400 focus:ring-2 focus:ring-blue-400 focus:border-blue-500 outline-none transition duration-200">
        </div>

        <button type="submit"
            class="w-full bg-gradient-to-r from-blue-500 to-purple-500 text-white font-semibold py-3 rounded-lg shadow-lg hover:opacity-90 focus:ring-4 focus:ring-blue-300 transition duration-300 transform hover:scale-105">
            Send Reset Link
        </button>

        <p class="text-xs text-gray-300 text-center mt-4">
            Remembered your password? <a href="login.php" class="text-blue-300 font-medium hover:underline">Login</a>
        </p>
    </form>
</div>
</body>
</html>
