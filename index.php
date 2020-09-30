<?php
spl_autoload_register(function ($className) {
    require_once __DIR__ . '/' . $className . '.php';
});

$comments = (new \src\models\Comment())->fetchAll();

require __DIR__ . '/functions.php';
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script
            src="https://code.jquery.com/jquery-3.5.1.js"
            integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
            crossorigin="anonymous"></script>
</head>
<body>
<div style="margin: auto; width: 80%">
    <div>
        <h1>Древовидные комментарии</h1>
        <h3>Написать новый комментарий</h3>
        <textarea class="comment" cols="60" rows="3"></textarea><br>
        <button class="sendComment">Отправить</button>
        <br><br>
        <script type="text/javascript">
            $(document).ready(function () {
                $('button.sendComment').on('click', function () {
                    var comment = $('textarea.comment').val();
                    $.ajax({
                        method: "POST",
                        url: "commentCreator.php",
                        data: {comment: comment}
                    })
                    $('textarea.comment').val('');
                })
            })
        </script>
    </div>
    <div id="content">
        <div>
            <!-- ВЫВОДИМ КОММЕНТАРИИ БЕЗ parent_id -->
            <?php foreach ($comments as $comment): ?>
                <?php if (empty($comment['parent_id'])): ?>
                    <div id="createComments">
                        <div style="border: 1px solid black">
                            <div style=''><strong>Комментарий номер : </strong><?= $comment['id'] ?></div>
                            <div style="min-height: 60px"><strong>Текст комментария:</strong><br><?= $comment['text'] ?>
                            </div>
                            <div id="answer<?= $comment['id'] ?>">
                                <button class="answer<?= $comment['id'] ?>">Ответить</button>
                            </div>
                            <div class="send<?= $comment['id'] ?>">
                                <textarea class="comment<?= $comment['id'] ?>" cols="60" rows="3"></textarea><br>
                                <input type="hidden" class="id<?= $comment['id'] ?>" value="<?= $comment['id'] ?>">
                                <button class="send<?= $comment['id'] ?>">Отправить</button>
                            </div>
                            <hr>
                            <!-- ВЫЗЫВАЕМ ФУНКЦИЮ, КОТОРАЯ ВОЗВРАЩАЕТ ВСЕ ПОДКОММЕНТАРИИ -->
                            <?php getParentComment($comment['id']) ?>
                        </div>
                    </div>
                    <!-- Создаем скрипт -->
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
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>
</body>
</html>
