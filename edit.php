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

// personal note: VALIDATION - the id in the link (edit.php?id=X) must be a whole number
// filter_input() gives false if it is not a number, and null if it is missing
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($id == false) {
    header("Location: index.php");
    exit;
}

$message = "";

// Personal note: this part to save the edited stuff
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

        // personal note: all good, so save the changes (prepared statement stops SQL injection)
    } else {
        $sql = $pdo->prepare("UPDATE books SET title = ?, author = ?, genre = ?, year = ? WHERE id = ?");
        $sql->execute([$title, $author, $genre, $year, $id]);
        header("Location: index.php");

        exit;
    }
}

// Personal note: SELECT finds the book with this id
$sql = $pdo->prepare("SELECT * FROM books WHERE id = ?");
$sql->execute([$id]);
$book = $sql->fetch();

// personal note: if there is no book with this id, go back to the book list
if (!$book) {
    header("Location: index.php");
    exit;
}

// personal note: to show the page using the edit.twig template (with the book details in the boxes)
echo $twig->render('edit.twig', ['book' => $book, 'message' => $message]);
