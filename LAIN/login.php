<?php
session_start();
require 'db.php'; 
require 'validation.php';

$errors = [];
$old_values = $_POST;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username)) {
        $errors['username'] = "Username is required";
    }
    if (empty($password)) {
        $errors['password'] = "Password is required";
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute([':username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: home.php");
            exit;
        } else {
            $errors['login'] = "Incorrect Username or Password";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | IT Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: url('images/money.jpg') no-repeat center center fixed;
            background-size: cover;
            color: white;
        }
        .glassmorphism {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: 15px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.25);
        }
        .glow-input {
            background: rgba(255, 255, 255, 0.1);
            border: none;
            color: white;
            transition: all 0.3s ease-in-out;
        }
        .glow-input:focus {
            outline: none;
            box-shadow: 0 0 10px rgba(0, 255, 255, 0.8);
            background: rgba(255, 255, 255, 0.2);
        }
        .glow-button {
            background: linear-gradient(90deg, #00c6ff, #0072ff);
            transition: all 0.3s ease-in-out;
        }
        .glow-button:hover {
            box-shadow: 0 0 20px rgba(0, 255, 255, 0.8);
            transform: scale(1.05);
        }
    </style>
</head>

<body class="flex items-center justify-center min-h-screen p-6">
    <div class="w-full max-w-md p-8 glassmorphism">
        <h2 class="text-3xl font-extrabold text-center mb-2">Login Portal</h2>
        <p class="text-sm text-center text-gray-300 mb-6">Welcome back! 🔐</p>

        <?php if (!empty($errors['login'])) { ?>
            <div class="mb-4 p-3 bg-red-500 text-center rounded-md text-black font-bold">
                <?= $errors['login']; ?>
            </div>
        <?php } ?>

        <form method="POST" action="" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-300">Username</label>
                <input type="text" name="username" value="<?= htmlspecialchars($old_values['username'] ?? '') ?>" class="w-full p-3 glow-input rounded-lg">
                <?php if (isset($errors['username'])) { ?>
                    <p class="text-red-400 text-xs mt-1"><?= $errors['username']; ?></p>
                <?php } ?>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-300">Password</label>
                <input type="password" name="password" class="w-full p-3 glow-input rounded-lg">
                <?php if (isset($errors['password'])) { ?>
                    <p class="text-red-400 text-xs mt-1"><?= $errors['password']; ?></p>
                <?php } ?>
            </div>

            <div class="text-center">
                <button type="submit" class="w-full py-3 glow-button text-white font-semibold rounded-lg">
                    Login
                </button>
            </div>
        </form>

        <p class="text-xs text-gray-300 text-center mt-4">
            Forgot your password? <a href="forgot_password.php" class="text-blue-300 font-medium hover:underline">Reset it</a>
        </p>
        <p class="text-xs text-gray-300 text-center mt-2">
            Don't have an account? <a href="signup.php" class="text-blue-300 font-medium hover:underline">Sign up</a>
        </p>
    </div>
</body>

</html>
