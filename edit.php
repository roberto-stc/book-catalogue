<?php
// personal note: to get the book
require 'db.php';
// personal note: to load Twig
require 'twig.php';
$id = $_GET['id'];
// Personal note: this part to save the edited stuff
if (isset($_POST['title'])) {
    
$title = $_POST['title'];
    
$author = $_POST['author'];
    
$genre = $_POST['genre'];
    
$year = $_POST['year'];
    
$sql = $pdo->prepare("UPDATE books SET title = ?, author = ?, genre = ?, year = ? WHERE id = ?");
    
$sql->execute([$title, $author, $genre, $year, $id]);
    
header("Location: index.php");
    
exit;
}
// Personal note: GET reads the number from the link (edit.php?id=X), then SELECT finds the book
$sql = $pdo->prepare("SELECT * FROM books WHERE id = ?");
$sql->execute([$id]);
$book = $sql->fetch();
// personal note: to show the page using the edit.twig template (with the book details in the boxes)
echo $twig->render('edit.twig', ['book' => $book]);
