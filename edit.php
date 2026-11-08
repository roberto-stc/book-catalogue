<?php
// personal note: only logged-in users can see this page
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// personal note: to get the book
require 'db.php';

// personal note: to load Twig
require 'twig.php';
$id = $_GET['id'];
$message = "";

// Personal note: this part to save the edited stuff
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

        // personal note: all good, so save the changes
    } else {
        $sql = $pdo->prepare("UPDATE books SET title = ?, author = ?, genre = ?, year = ? WHERE id = ?");
        $sql->execute([$title, $author, $genre, $year, $id]);
        header("Location: index.php");

        exit;
    }
}

// Personal note: GET reads the number from the link (edit.php?id=X), then SELECT finds the book
$sql = $pdo->prepare("SELECT * FROM books WHERE id = ?");
$sql->execute([$id]);
$book = $sql->fetch();

// personal note: to show the page using the edit.twig template (with the book details in the boxes)
echo $twig->render('edit.twig', ['book' => $book, 'message' => $message]);
