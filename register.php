<?php

// personal note: to connect with database
require 'db.php';


// personal note: to load Twig
require 'twig.php';
$message = "";


// personal note: when the Register button is clicked
if (isset($_POST['username'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // personal note: check if this username is already taken

    $sql = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $sql->execute([$username]);
    $user = $sql->fetch();

    if ($username == "" || $password == "") {
        $message = "Please fill in both boxes.";
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

// personal note: to show the page using the register.twig template
echo $twig->render('register.twig', ['message' => $message]);
