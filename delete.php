<?php
// personal note: only logged-in users can see this page
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

require 'db.php';
$id = $_GET['id'];
$sql = $pdo->prepare("DELETE FROM books WHERE id = ?");
$sql->execute([$id]);
header("Location: index.php");
exit;
