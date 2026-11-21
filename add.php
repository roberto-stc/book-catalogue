<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
require 'db.php';
require 'twig.php';
$message = "";
if (isset($_POST['title'])) {

    // SANITISATION

    $title = trim(strip_tags($_POST['title']));
    $author = trim(strip_tags($_POST['author']));
    $genre = trim(strip_tags($_POST['genre']));
    $year = filter_input(INPUT_POST, 'year', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1000, 'max_range' => 2100]]);

    // personal note: check 1 - no empty boxes
    if ($title == "" || $author == "" || $genre == "") {
        $message = "Please fill in all the boxes.";

        // personal note: check 2 - the year must be a real year
    } elseif ($year == false) {
        $message = "The year must be a number between 1000 and 2100.";

        // personal note: check 3 - the text must not be longer than the database allows
    } elseif (strlen($title) > 200 || strlen($author) > 150 || strlen($genre) > 50) {
        $message = "Some of the text is too long.";

        // personal note: all good, so save the book (prepared statement stops SQL injection)
    } else {
        $sql = $pdo->prepare("INSERT INTO books (title, author, genre, year) VALUES (?, ?, ?, ?)");
        $sql->execute([$title, $author, $genre, $year]);
        header("Location: index.php");
        exit;
    }
}

echo $twig->render('add.twig', ['message' => $message]);
