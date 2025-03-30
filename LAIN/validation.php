<?php
function validateForm($data) {
    $errors = [];
    
    // Validation rules
    $namePattern = "/^[A-Z][a-zA-Z]*$/"; // Starts with uppercase, no spaces, no numbers, no special characters
    $noSpacePattern = "/^\S*$/"; // No spaces allowed

    // Last Name Validation
    if (empty(trim($data['lastname']))) {
        $errors['lastname'] = "Last name is required.";
    } elseif (!preg_match($namePattern, $data['lastname'])) {
        $errors['lastname'] = "Last name must start with a capital letter and contain only letters.";
    } elseif (!preg_match($noSpacePattern, $data['lastname'])) {
        $errors['lastname'] = "Last name must not contain spaces.";
    }

    // First Name Validation
    if (empty(trim($data['firstname']))) {
        $errors['firstname'] = "First name is required.";
    } elseif (!preg_match($namePattern, $data['firstname'])) {
        $errors['firstname'] = "First name must start with a capital letter and contain only letters.";
    } elseif (!preg_match($noSpacePattern, $data['firstname'])) {
        $errors['firstname'] = "First name must not contain spaces.";
    }

    // Nickname Validation
    if (empty(trim($data['nickname']))) {
        $errors['nickname'] = "Nickname is required.";
    } elseif (!preg_match($namePattern, $data['nickname'])) {
        $errors['nickname'] = "Nickname must start with a capital letter and contain only letters.";
    } elseif (!preg_match($noSpacePattern, $data['nickname'])) {
        $errors['nickname'] = "Nickname must not contain spaces.";
    }

    // Validate Email
    if (empty(trim($data['email']))) {
        $errors['email'] = "Email is required.";
    } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format.";
    }

    if (empty(trim($data['username']))) {
        $errors['username'] = "Username is required.";
    } elseif (!preg_match($noSpacePattern, $data['username'])) {
        $errors['username'] = "Username must not contain spaces.";
    }

    // Password validation
    if (empty(trim($data['password']))) {
        $errors['password'] = "Password is required.";
    } elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,16}$/', $data['password'])) {
        $errors['password'] = "Password must be 8-16 characters long, include at least one uppercase letter, one lowercase letter, one number, and one special character.";
    }

    // Confirm password validation
    if (empty($data['confirm_password'])) {
        $errors['confirm_password'] = "Confirm password is required.";
    } elseif ($data['password'] !== $data['confirm_password']) {
        $errors['confirm_password'] = "Passwords do not match.";
    }

    return $errors;
}
?>
