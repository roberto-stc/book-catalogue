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

    // personal note: SANITISATION - clean what the user typed before using it
    // strip_tags() removes any HTML tags (like <script>), trim() removes extra spaces
    $title = trim(strip_tags($_POST['title']));
    $author = trim(strip_tags($_POST['author']));
    $genre = trim(strip_tags($_POST['genre']));

    // personal note: VALIDATION - filter_input() checks the year is a whole number between 1000 and 2100
    // if it is not, $year becomes false
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

// personal note: to show the page using the add.twig template
echo $twig->render('add.twig', ['message' => $message]);
