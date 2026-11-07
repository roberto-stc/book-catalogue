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
    $captcha = $_POST['captcha'];

// personal note: find the user with this username
    $sql = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $sql->execute([$username]);
    $user = $sql->fetch();

// personal note: password_verify checks the typed password against the saved hash
    if ($captcha != $_SESSION['captcha_answer']) {
        $message = "Wrong answer to the maths question.";
    } elseif ($user && password_verify($password, $user['password'])) {
        $_SESSION['username'] = $user['username'];
        header("Location: index.php");
        exit;
    } else {
        $message = "Wrong username or password.";
    }
}

// personal note: to show the page using the login.twig template
$num1 = rand(1, 10);
$num2 = rand(1, 10);
$_SESSION['captcha_answer'] = $num1 + $num2;
echo $twig->render('login.twig', ['message' => $message, 'num1' => $num1, 'num2' => $num2]);
