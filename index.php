<?php
// personal note: to connect to the database
require 'db.php';

// personal note: to get all the books from the database
$result = $pdo->query("SELECT * FROM books");
$books = $result->fetchAll();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Book Catalogue</title>
</head>

<body>

    <h1>Book Catalogue</h1>

    <table border="1">
        <tr>
            <th>Title</th>
            <th>Author</th>
            <th>Genre</th>
            <th>Year</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>


        <?php
        // table for books

        foreach ($books as $book) { ?>
            <tr>
                <td><?php echo $book['title']; ?></td>
                <td><?php echo $book['author']; ?></td>
                <td><?php echo $book['genre']; ?></td>
                <td><?php echo $book['year']; ?></td>
                <td><a href="edit.php?id=<?php echo $book['id']; ?>">Edit</a></td>
                <td><a href="delete.php?id=<?php echo $book['id']; ?>">Delete</a></td>

            </tr>
        <?php } ?>

    </table>

</body>

</html>