<?php

session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// personal note: to connect to the database
require 'db.php';

// personal note: to load Twig
require 'twig.php';

// personal note: to get all the books from the database
$result = $pdo->query("SELECT * FROM books");
$books = $result->fetchAll();

echo $twig->render('index.twig', ['books' => $books]);
