<?php
// personal note: only logged-in users can see this page
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

require 'db.php';

// personal note: VALIDATION - the id in the link (delete.php?id=X) must be a whole number
// filter_input() gives false if it is not a number, and null if it is missing
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($id == false) {
    header("Location: index.php");
    exit;
}

// personal note: prepared statement, so the id can never change the SQL
$sql = $pdo->prepare("DELETE FROM books WHERE id = ?");
$sql->execute([$id]);
header("Location: index.php");
exit;
