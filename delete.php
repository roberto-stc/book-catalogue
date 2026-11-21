<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

require 'db.php';
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($id == false) {
    header("Location: index.php");
    exit;
}

$sql = $pdo->prepare("DELETE FROM books WHERE id = ?");
$sql->execute([$id]);
header("Location: index.php");
exit;
