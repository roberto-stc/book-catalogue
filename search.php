<?php
// personal note: to connect to the database
require 'db.php';

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


?>
<!DOCTYPE html>
<html>

<head>

    <title>Search Books</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>

    <h1>Search Books</h1>

    <form method="get" action="search.php">

        <label>Genre:</label>

        <input type="text" name="genre">
        <label>Year:</label>

        <input type="text" name="year">
        <button type="submit">Search</button>

    </form>


    <h2>Results</h2>

    <?php

    // personal note: if nothing matches, say so

    if (count($books) == 0) { ?>

        <p>No books found.</p>

    <?php } ?>

    <table border="1">

        <tr>
            <th>Title</th>
            <th>Author</th>
            <th>Genre</th>
            <th>Year</th>
        </tr>

        <?php

        // personal note: one row for each book found

        foreach ($books as $book) { ?>

            <tr>
                <td><?php echo $book['title']; ?></td>
                <td><?php echo $book['author']; ?></td>
                <td><?php echo $book['genre']; ?></td>
                <td><?php echo $book['year']; ?></td>
            </tr>

        <?php } ?>

    </table>


    <p><a href="index.php">Back to all books</a></p>
</body>

</html>