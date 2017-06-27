<?php
declare(strict_types=1);

use app\common\Router;
?>
<div class="container theme-showcase" role="main">
    <h1>Создание новой задачи</h1>

    <?php if ($message != '') { ?>
        <div class="alert alert-success">
        <?= $message ?>
    </div>
    <?php } ?>

    <form enctype="multipart/form-data" method="post" action="<?= Router::getUrl('Site', 'NewTask') ?>">
        <div class="form-group">
            <label for="user_name">Пользователь:</label>
            <input name="user_name" class="form-control" id="user_name" placeholder="Имя">
        </div>

        <div class="form-group">
            <label for="InputEmail">Email</label>
            <input name="email" type="email" class="form-control" id="InputEmail" placeholder="Email">
        </div>
        <div class="form-group">
            <label for="description">Описание задачи:</label>
            <textarea class="form-control" rows="5" id="description" name="description"></textarea>
        </div>
        <div class="form-group">
            <label for="exampleInputFile">Изображение</label>
            <input name="file" type="file" id="exampleInputFile">
            <p class="help-block">Изображение для иллюстрации задачи</p>
        </div>
        <button type="submit" class="btn btn-primary">Создать задачу</button>
        <button id="preview" type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal">Предпросмотр</button>
    </form>

    <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Предпросмотр</h4>
                </div>
                <div class="modal-body">
                    <p>Имя: <span id="preview_username"></span></p>
                    <p>Email: <span id="preview_email"></span></p>
                    <p>Описание: <span id="preview_description"></span></p>
                    <p>Изображение: <img style="max-width: 320px; max-height: 240px;"></p>
                </div>
            </div>

        </div>
    </div>
</div>