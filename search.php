<?php
// personal note: to connect to the database
require 'db.php';
// personal note: to load Twig
require 'twig.php';
// personal note: get what the user typed in the boxes (empty if nothing typed)
$genre = '';
$year = '';
if (isset($_GET['genre'])) {

    $genre = $_GET['genre'];
}
if (isset($_GET['year'])) {

    $year = $_GET['year'];
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
