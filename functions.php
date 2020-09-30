<?php
function getParentComment(int $id): void
{
    echo '<div style="padding-left: 20px">';
//    Находим все комментарии по родственному ID
    $comments = (new \src\models\Comment())->getByParentId($id);

    if (!empty($comments)) {
        foreach ($comments as $comment) { ?>
            <strong>Комментарий номер : </strong> <?= $comment['id'] ?> |
            <strong>Родительский комментарий : </strong><?= $comment['parent_id'] ?>
            <div style="min-height: 60px"><strong>Текст комментария :</strong><br><?= $comment['text'] ?></div>
            <div class="opened<?= $comment['id'] ?>">
                <button class="answer" data-id="<?= $comment['id'] ?>">Ответить</button>
            </div>
            <div class="closed<?= $comment['id'] ?>" id="closed">
                <textarea class="area<?= $comment['id'] ?>" cols="60" rows="3"></textarea><br>
                <button class="send" data-id="<?= $comment['id'] ?>">Отправить</button>
            </div>
            <hr>
            <?php
//            Вызываем рекурсию для нахождения всех цепочек комментариев
            getParentComment($comment['id']);
        }
    }
    echo '</div>';
}