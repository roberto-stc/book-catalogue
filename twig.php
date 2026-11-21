<?php
// personal note: to load Twig (installed with Composer)
require 'vendor/autoload.php';
// personal note: tell Twig that my templates are in the templates folder
$loader = new \Twig\Loader\FilesystemLoader('templates');

// personal note: ESCAPING - autoescape 'html' means Twig escapes everything inside {{ }}
// so < > " ' & are turned into safe codes (like &lt;) and can never run as HTML or JavaScript (stops XSS)
$twig = new \Twig\Environment($loader, ['autoescape' => 'html']);
