<?php

// personal note: to get the book

require 'db.php';
$id = $_GET['id'];


// Personal note: this part to save the edited stuff //

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

// It stops here

$sql = $pdo->prepare("SELECT * FROM books WHERE id = ?");
$sql->execute([$id]);
$book = $sql->fetch();
?>

<h1>Edit a Book</h1>
<form method="post">

    <p>Title: <input type="text" name="title" value="<?php echo $book['title']; ?>"></p>
    <p>Author: <input type="text" name="author" value="<?php echo $book['author']; ?>"></p>
    <p>Genre: <input type="text" name="genre" value="<?php echo $book['genre']; ?>"></p>
    <p>Year: <input type="number" name="year" value="<?php echo $book['year']; ?>"></p>

    <p><button type="submit">Save</button></p>
</form>

<!-- Personal notes: GET reads the number from the link (edit.php?id=X, then SELEct finds the book, and value="..." puts the book details in each box) -->