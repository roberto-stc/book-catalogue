<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

require 'db.php';
require 'twig.php';
$genre = '';
if (isset($_GET['genre'])) {
    $genre = trim(strip_tags($_GET['genre']));
}
if (strlen($genre) > 50) {
    $genre = '';
}

// personal note: VALIDATION - filter_input() checks the year is a whole number (false if not, null if empty)
$year = filter_input(INPUT_GET, 'year', FILTER_VALIDATE_INT);
if ($year == false) {
    $year = '';
}

// personal note: only search after the Search button is pressed
$searched = isset($_GET['genre']) || isset($_GET['year']);
$books = [];
if ($searched) {
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
    $query = $pdo->prepare($sql);
    $query->execute($values);
    $books = $query->fetchAll();
}
echo $twig->render('search.twig', ['books' => $books, 'genre' => $genre, 'year' => $year, 'searched' => $searched]);
