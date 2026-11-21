<?php
require 'db.php';
require 'twig.php';
$message = "";
if (isset($_POST['username'])) {

    // personal note: SANITISATION - trim() removes extra spaces at the start and end
    $username = trim($_POST['username']);

    // personal note: the password is NOT cleaned, because it gets hashed and is never shown on a page
    $password = $_POST['password'];

    // personal note: check if this username is already taken
    $sql = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $sql->execute([$username]);
    $user = $sql->fetch();
    if ($username == "" || $password == "") {
        $message = "Please fill in both boxes.";

        // personal note: VALIDATION - ctype_alnum() checks the username only has letters and numbers 
    } elseif (!ctype_alnum($username)) {
        $message = "The username can only have letters and numbers.";
    } elseif (strlen($username) > 50) {
        $message = "The username is too long (50 letters max).";

        // personal note: the password must be at least 6 letters 
    } elseif (strlen($password) < 6) {
        $message = "The password must be at least 6 letters.";
    } elseif ($user) {
        $message = "This username is already taken.";
    } else {

        // personal note: turn the password into a hash, so the real password is never saved
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $sql->execute([$username, $hash]);
        $message = "Account created! You can now log in.";
    }
}

echo $twig->render('register.twig', ['message' => $message]);
