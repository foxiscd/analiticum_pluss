<?php

spl_autoload_register(function ($className) {
    require_once __DIR__ . '/' . $className . '.php';
});

$comment = $_POST['comment'];
$parent_id = $_POST['parent_id'];

$commentCreator = new \src\models\Comment();
if (!empty($comment) && !empty($parent_id)) {
    $commentCreator->createCommentWithParent($comment, $parent_id);
} elseif (!empty($comment)) {
    $commentCreator->createComment($comment);
}

