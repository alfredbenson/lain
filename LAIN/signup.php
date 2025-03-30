<?php
session_start();
require 'db.php'; 
require 'validation.php';

$errors = [];
$success = "";
$old_values = $_POST; // Retain old values from form submission

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = validateForm($_POST);

    // If no errors, store data in database
    if (empty($errors)) {
        $stmt = $pdo->prepare("INSERT INTO users (lastname, firstname, nickname, email, username, password) 
                               VALUES (:lastname, :firstname, :nickname, :email, :username, :password)");

        $stmt->execute([
            ':lastname' => trim($_POST['lastname']),
            ':firstname' => trim($_POST['firstname']),
            ':nickname' => trim($_POST['nickname']),
            ':email' => trim($_POST['email']),
            ':username' => trim($_POST['username']),
            ':password' => password_hash($_POST['password'], PASSWORD_DEFAULT)
        ]);

        $_SESSION['success'] = "Registration successful! 🎉"; 
        header("Location: login.php"); 
        exit;
    }
}

// Retrieve success message and clear session
if (isset($_SESSION['success'])) {
    $success = $_SESSION['success'];
    unset($_SESSION['success']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | IT Portal 🚀</title>
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
    <div class="w-full max-w-lg p-8 glassmorphism">
        <h2 class="text-3xl font-extrabold text-center mb-2">Registration Portal</h2>
        <p class="text-sm text-center text-gray-300 mb-6">Join the future of technology! 🚀</p>

        <?php if (!empty($success)) { ?>
            <div class="mb-4 p-3 bg-green-500 text-center rounded-md text-black font-bold">
                <?= $success; ?>
            </div>
        <?php } ?>

        <form method="POST" action="" class="space-y-4">
            <?php
            $fields = [
                "lastname" => "Last Name",
                "firstname" => "First Name",
                "nickname" => "Nickname",
                "email" => "Email",
                "username" => "Username",
            ];
            foreach ($fields as $field => $label) { ?>
                <div>
                    <label class="block text-sm font-medium text-gray-300"><?= $label; ?></label>
                    <input type="text" name="<?= $field; ?>" value="<?= htmlspecialchars($old_values[$field] ?? '') ?>" class="w-full p-3 glow-input rounded-lg">
                    <?php if (isset($errors[$field])) { ?>
                        <p class="text-red-400 text-xs mt-1"><?= $errors[$field]; ?></p>
                    <?php } ?>
                </div>
            <?php } ?>

            <div>
                <label class="block text-sm font-medium text-gray-300">Password</label>
                <input type="password" name="password" class="w-full p-3 glow-input rounded-lg">
                <?php if (isset($errors['password'])) { ?>
                    <p class="text-red-400 text-xs mt-1"><?= $errors['password']; ?></p>
                <?php } ?>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-300">Confirm Password</label>
                <input type="password" name="confirm_password" class="w-full p-3 glow-input rounded-lg">
                <?php if (isset($errors['confirm_password'])) { ?>
                    <p class="text-red-400 text-xs mt-1"><?= $errors['confirm_password']; ?></p>
                <?php } ?>
            </div>

            <div class="text-center">
                <button type="submit" class="w-full py-3 glow-button text-white font-semibold rounded-lg">
                    Register Now
                </button>
            </div>
        </form>

        <p class="text-xs text-gray-300 text-center mt-4">
            Already have an account? <a href="login.php" class="text-blue-300 font-medium hover:underline">Sign in</a>
        </p>
    </div>
</body>

</html>
