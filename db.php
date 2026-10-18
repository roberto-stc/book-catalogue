<?php
// Personal Note: this is to connect to the book_catalogue database in MAMP
// Tinsiex that database runs on port 8889 with username root and password root.

$pdo = new PDO("mysql:host=127.0.0.1;port=8889;dbname=book_catalogue", "root", "root");



