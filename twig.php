<?php
// personal note: to load Twig (installed with Composer)
require 'vendor/autoload.php';
// personal note: tell Twig that my templates are in the templates folder
$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);
