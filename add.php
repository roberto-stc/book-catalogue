<?php
// personal note: only logged-in users can see this page
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// personal note: to connect with database
require 'db.php';

// personal note: to load Twig
require 'twig.php';

$message = "";
// personal note: to add a new book, click on the save click
if (isset($_POST['title'])) {

    // personal note: trim() removes extra spaces at the start and end
    $title = trim($_POST['title']);
    $author = trim($_POST['author']);
    $genre = trim($_POST['genre']);
    $year = trim($_POST['year']);

    // personal note: check 1 - no empty boxes
    if ($title == "" || $author == "" || $genre == "" || $year == "") {
        $message = "Please fill in all the boxes.";

        // personal note: check 2 - the year must be a number
    } elseif (!is_numeric($year)) {
        $message = "The year must be a number.";

        // personal note: check 3 - the title must not be too long
    } elseif (strlen($title) > 100) {
        $message = "The title is too long.";

        // personal note: all good, so save the book
    } else {
        $sql = $pdo->prepare("INSERT INTO books (title, author, genre, year) VALUES (?, ?, ?, ?)");
        $sql->execute([$title, $author, $genre, $year]);
        header("Location: index.php");

        exit;
    }
}

// personal note: to show the page using the add.twig template
echo $twig->render('add.twig', ['message' => $message]);
