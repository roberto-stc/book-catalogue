<?php

header('Content-Type: application/json');
session_start();
if (!isset($_SESSION['username'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Please log in first.']);

    exit;
}
// personal note: to connect to the database
require 'db.php';

// personal note: get what the user typed (empty if nothing typed)
$title = '';
if (isset($_GET['title'])) {
    $title = trim($_GET['title']);
}

// personal note: if the box is empty, send back an empty list
if ($title == '') {
    echo json_encode([]);
    exit;
}

// personal note: if the text is too long, send a JSON error message
if (strlen($title) > 100) {
    http_response_code(400);
    echo json_encode(['error' => 'The search text is too long.']);
    exit;
}

// personal note: prepared statement, find books whose title contains what was typed
// I only ask for the 4 columns the page needs, and at most 10 books
$query = $pdo->prepare("SELECT title, author, genre, year FROM books WHERE title LIKE ? ORDER BY title LIMIT 10");
$query->execute(["%" . $title . "%"]);
$books = $query->fetchAll(PDO::FETCH_ASSOC);
// personal note: send the books back as JSON so JavaScript can read them
echo json_encode($books);
