<?php
// personal note: start the session so we can end it
session_start();

// personal note: delete everything in the session (this logs the user out)
session_destroy();

// personal note: go back to the login page
header("Location: login.php");
exit;
