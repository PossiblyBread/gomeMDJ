<?php
$mysqli = require __DIR__ . "/db_conn.php";

$token = $_POST["token"];

$token_hash = hash("sha256", $token);

$sql = "SELECT * FROM accounts
        WHERE reset_token_hash = ?";

$stmt = $mysqli = $conn->prepare($sql);

$stmt->bind_param("s", $token_hash);

$stmt->execute();

$result = $stmt->get_result();

$accounts = $result->fetch_assoc();

if ($accounts === null) {
    die("token not found");
}

if (strtotime($accounts["reset_token_expires_at"]) <= time()) {
    die("token has expired");
}

$password_hash = password_hash($_POST["h_password"], PASSWORD_DEFAULT);

$sql = "UPDATE accounts
        SET h_password = ?,
            reset_token_hash = NULL,
            reset_token_expires_at = NULL
        WHERE id = ?";

$stmt = $mysqli = $conn->prepare($sql);

$stmt->bind_param("ss", $password_hash, $accounts["id"]);

$stmt->execute();

header("Location: index.php");