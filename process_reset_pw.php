<?php
$token = $_POST["token"];

$token_hash = hash("sha256", $token);

$connection = require __DIR__ . "/initialize.php";

$sql = "SELECT * FROM users_tb
        WHERE reset_token_hash = ?";

$stmt = $connection->prepare($sql);

$stmt->bind_param("s", $token_hash);

$stmt->execute();

$result = $stmt->get_result();

$user = $result->fetch_assoc();

if ($user === null) {
    die("token not found");
}

if (strtotime($user["reset_token_expires_at"]) <= time()) {
    die("token has expired");
}

if (strlen($_POST["password"]) < 8) {
    die("Password must be at least 8 characters");
}

if ( ! preg_match("/[a-z]/i", $_POST["password"])) {
    die("Password must contain at least one letter");
}

if ( ! preg_match("/[0-9]/", $_POST["password"])) {
    die("Password must contain at least one number");
}

if ($_POST["password"] !== $_POST["password_confirmation"]) {
    die("Passwords must match");
}

$password = $_POST["password"];

$sql = "UPDATE users_tb
        SET password = ?,
            reset_token_hash = NULL,
            reset_token_expires_at = NULL
        WHERE userid = ?";

$stmt = $connection->prepare($sql);

$stmt->bind_param("ss", $password, $user["userid"]);

$stmt->execute();

echo "Password updated. You can now login.";