<?php
require_once 'includes/functions.php';

// Destruction de la session
session_unset();
session_destroy();

// Redirection vers l'accueil
redirect('index.php');
?>
