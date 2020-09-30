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

$comments = (new \src\models\Comment())->fetchAll();

require __DIR__ . '/functions.php';
?>

<div>
    <!-- ВЫВОДИМ КОММЕНТАРИИ БЕЗ parent_id -->
    <?php foreach ($comments as $comment): ?>
        <?php if (empty($comment['parent_id'])): ?>
            <div>
                <div style="border: 1px solid black">
                    <div style=''><strong>Комментарий номер : </strong><?= $comment['id'] ?></div>
                    <div style="min-height: 60px"><strong>Текст комментария:</strong><br><?= $comment['text'] ?>
                    </div>
                    <div class="opened<?= $comment['id'] ?>">
                        <button class="answer" data-id="<?= $comment['id'] ?>">Ответить</button>
                    </div>
                    <div class="closed<?= $comment['id'] ?>" id="closed">
                        <textarea class="area<?= $comment['id'] ?>" cols="60" rows="3"></textarea><br>
                        <button class="send" data-id="<?= $comment['id'] ?>">Отправить</button>
                    </div>
                    <hr>
                    <!-- ВЫЗЫВАЕМ ФУНКЦИЮ, КОТОРАЯ ВОЗВРАЩАЕТ ВСЕ ПОДКОММЕНТАРИИ -->
                    <?php getParentComment($comment['id']); ?>
                </div>
            </div>
            <!-- Создаем скрипт -->
        <?php endif; ?>
    <?php endforeach; ?>
</div>
