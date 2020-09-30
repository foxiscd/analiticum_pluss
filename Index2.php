<?php
spl_autoload_register(function ($className) {
    require_once __DIR__ . '/' . $className . '.php';
});

$comments = (new \src\models\Comment())->fetchAll();

require __DIR__ . '/functions.php';
?>

