<?php
// personal note: to connect with database
require 'db.php';

// personal note: to load Twig
require 'twig.php';

// personal note: to add a new book, click on the save click
if (isset($_POST['title'])) {
    
$title = $_POST['title'];
$author = $_POST['author'];
$genre = $_POST['genre'];
$year = $_POST['year'];
    
// The ? marks are placeholders

$sql = $pdo->prepare("INSERT INTO books (title, author, genre, year) VALUES (?, ?, ?, ?)");
$sql->execute([$title, $author, $genre, $year]);
    
header("Location: index.php");
    
exit;
}

// personal note: to show the page using the add.twig template
echo $twig->render('add.twig');
