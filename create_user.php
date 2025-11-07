<?php
session_start();

// 1. Connect to database
$conn = new mysqli("localhost", "root", "", "myfirstdatabase");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 2. Get form inputs
$username = $_POST['username'];
$pwd = $_POST['pwd'];
$email = $_POST['email'];
$role = $_POST['role'];
$fname = $_POST['first_name'];
$lname = $_POST['last_name'];
$phone = $_POST['phone'];

// 3. Hash the password BEFORE inserting
$hashedPwd = password_hash($pwd, PASSWORD_BCRYPT);

// 4. Insert into database
$stmt = $conn->prepare("INSERT INTO users (username, pwd, email, role, first_name, last_name, phone)
VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssss", $username, $hashedPwd, $email, $role, $fname, $lname, $phone);

if ($stmt->execute()) {
    echo "<script>alert('User created successfully!'); window.location.href='dashboard3.php';</script>";
} else {
    echo "<script>alert('Error creating user: " . $conn->error . "');</script>";
}

$stmt->close();
$conn->close();
?>