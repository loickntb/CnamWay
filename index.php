<?php

session_start();

$config = require('config.php');

//----------PDO----------
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
];
$pdo = new PDO($config['dsn'], "root", "7002n*", $options);
//----------PDO----------

function render($view, $data = [])
{
    require('views/errors/error.php');
    require('views/header.php');
    require('views/' . $view . '.php');
    require('views/footer.php');
}

function redirect($controller)
{
    header('Location: index.php?c=' . $controller);
}

function connected()
{
    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true)
        return true;
    return false;
}


if (!empty($_GET['c'])) {
    $c = $_GET['c'];
} else
   $c = $config['default'];

if (!file_exists('controllers/' . $c . '.php')) {
    $c = "404";
    redirect('errors/error404');
}

//retourne le mail de l'admin, on considere qu'il n'y a qu'un seul admin dans notre système
function getAdminMail(){
    return "admin@mail.com";
}

require('controllers/' . $c . '.php');

?>