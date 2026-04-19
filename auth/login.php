<?php
session_start();
include("../config/db.php");

header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    echo json_encode([
        "success" => false,
        "message" => "Invalid request."
    ]);
    exit;
}

$number = trim($data["number"] ?? "");
$password = trim($data["password"] ?? "");

if (empty($number) || empty($password)) {
    echo json_encode([
        "success" => false,
        "message" => "Number and password are required."
    ]);
    exit;
}

$stmt = $conn->prepare("SELECT id, first_name, role, password FROM users WHERE number = ?");
$stmt->bind_param("s", $number);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    if (password_verify($password, $user["password"])) {
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["user_name"] = $user["first_name"];
        $_SESSION["user_role"] = $user["role"];

        echo json_encode([
            "success" => true,
            "role" => $user["role"]
        ]);
        exit;
    }
}

echo json_encode([
    "success" => false,
    "message" => "Invalid login credentials."
]);
?>