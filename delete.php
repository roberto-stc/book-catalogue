<?php
require 'db.php';
$id = $_GET['id'];
$sql = $pdo->prepare("DELETE FROM books WHERE id = ?");
$sql->execute([$id]);
header("Location: index.php");
exit;
