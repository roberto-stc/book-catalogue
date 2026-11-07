<?php

// personal note: only logged-in users can see this page
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
// personal note: to show the page using the index.twig template
echo $twig->render('index.twig', ['books' => $books]);
