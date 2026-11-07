<?php
// personal note: only logged-in users can see this page
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// personal note: to connect to the database

require 'db.php';

// personal note: get what the user typed (empty if nothing typed)

$title = '';
if (isset($_GET['title'])) {
    $title = $_GET['title'];
}


// personal note: prepared statement, find books whose title contains what was typed

$query = $pdo->prepare("SELECT * FROM books WHERE title LIKE ?");
$query->execute(["%" . $title . "%"]);
$books = $query->fetchAll(PDO::FETCH_ASSOC);

// personal note: send the books back as JSON (not a web page) so JavaScript can read them

header('Content-Type: application/json');
echo json_encode($books);
