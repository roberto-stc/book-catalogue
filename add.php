<?php
// personal note: to connect with database
require 'db.php';

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
?>

<!DOCTYPE html>
<html>

<head>

    <title>Add a Book</title>
</head>

<body>
    <h1>Add a Book</h1>
    <form method="post">
        <p>Title: <input type="text" name="title"></p>
        <p>Author: <input type="text" name="author"></p>
        <p>Genre: <input type="text" name="genre"></p>
        <p>Year: <input type="number" name="year"></p>
        <p><button type="submit">Save</button></p>
    </form>
    <p><a href="index.php">Back to the book list</a></p>
</body>

</html>

