<?php

// personal note: start the session, so PHP can remember who is logged in
session_start();

// personal note: to connect with database
require 'db.php';

// personal note: to load Twig
require 'twig.php';
$message = "";

// personal note: when the Log in button is clicked
if (isset($_POST['username'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

// personal note: find the user with this username
    $sql = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $sql->execute([$username]);
    $user = $sql->fetch();

// personal note: password_verify checks the typed password against the saved hash
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['username'] = $user['username'];
        header("Location: index.php");
        exit;
    } else {
        $message = "Wrong username or password.";
    }
}

// personal note: to show the page using the login.twig template
echo $twig->render('login.twig', ['message' => $message]);
