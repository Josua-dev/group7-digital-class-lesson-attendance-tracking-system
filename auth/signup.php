<?php
include("../config/db.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $first_name = trim($_POST["first_name"]);
    $last_name  = trim($_POST["last_name"]);
    $gender     = trim($_POST["gender"]);
    $role       = trim($_POST["role"]);
    $number     = trim($_POST["number"]);
    $password   = trim($_POST["password"]);

    if (
        empty($first_name) || empty($last_name) || empty($gender) ||
        empty($role) || empty($number) || empty($password)
    ) {
        die("All fields are required.");
    }

    if (!in_array($role, ["student", "lecturer"])) {
        die("Invalid role selected.");
    }

    $checkStmt = $conn->prepare("SELECT id FROM users WHERE number = ?");
    $checkStmt->bind_param("s", $number);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        echo "<script>alert('User with that number already exists.'); window.location.href='../signup.html';</script>";
        exit;
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, gender, number, password, role) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $first_name, $last_name, $gender, $number, $hashedPassword, $role);

    if ($stmt->execute()) {
        header("Location: ../index.html");
        exit;
    } else {
        echo "Signup failed.";
    }
}
?>