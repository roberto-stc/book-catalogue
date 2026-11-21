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

// personal note: SANITISATION - get the genre the user typed and clean it (empty if nothing typed)
// strip_tags() removes any HTML tags, trim() removes extra spaces
$genre = '';
if (isset($_GET['genre'])) {
    $genre = trim(strip_tags($_GET['genre']));
}

// personal note: if the genre is too long, ignore it (the longest genre in the database is 50 letters)
if (strlen($genre) > 50) {
    $genre = '';
}

// personal note: VALIDATION - filter_input() checks the year is a whole number (false if not, null if empty)
$year = filter_input(INPUT_GET, 'year', FILTER_VALIDATE_INT);

// personal note: if the year is not a number, ignore it
if ($year == false) {
    $year = '';
}


// personal note: start with "all books", then add each filter the user filled in
$sql = "SELECT * FROM books WHERE 1=1";
$values = [];
if ($genre != '') {
    $sql = $sql . " AND genre LIKE ?";
    $values[] = "%" . $genre . "%";
}
if ($year != '') {
    $sql = $sql . " AND year = ?";
    $values[] = $year;
}

// personal note: prepared statement, the ? are filled in safely by execute
$query = $pdo->prepare($sql);
$query->execute($values);
$books = $query->fetchAll();

// personal note: to show the page using the search.twig template
echo $twig->render('search.twig', ['books' => $books, 'genre' => $genre, 'year' => $year]);
