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
            <div style="min-height: 60px">
                <strong>Текст комментария :</strong><br>
                <?= $comment['text'] ?>
            </div>
            <div id="answer<?= $comment['id'] ?>">
                <button class="answer<?= $comment['id'] ?>">Ответить</button>
            </div>
            <div class="send<?= $comment['id'] ?>">
                <textarea class="comment<?= $comment['id'] ?>" id="" cols="60" rows="3"></textarea><br>
                <input type="hidden" class="id<?= $comment['id'] ?>" value="<?= $comment['id'] ?>">
                <button class="send<?= $comment['id'] ?>">Отправить</button>
            </div>
            <script type="text/javascript">
                $(document).ready(function () {
                    $('div.send<?= $comment['id']?>').hide();
                    $('button.answer<?= $comment['id']?>').on('click', function () {
                        $('div.send<?= $comment['id']?>').fadeIn();
                        $('div#answer<?= $comment['id']?>').hide();
                    });
                    $('button.send<?= $comment['id']?>').on('click', function () {
                        var comment = $('textarea.comment<?= $comment['id']?>').val();
                        var parent_id = $('input.id<?= $comment['id']?>').val();
                        $('div.send<?= $comment['id']?>').hide();
                        $('div#answer<?= $comment['id']?>').fadeIn();
                        $.ajax({
                            method: "POST",
                            url: "commentCreator.php",
                            data: {comment: comment, parent_id: parent_id}
                        })
                    })
                })
            </script>
            <hr>
            <?php
//            Вызываем рекурсию для нахождения всех цепочек комментариев
            getParentComment($comment['id']);
        }
    }
    echo '</div>';
}