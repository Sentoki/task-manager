<?php
declare(strict_types=1);

use app\common\Router;
?>
<div class="container theme-showcase" role="main">
    <h1>Создание новой задачи</h1>

    <form enctype="multipart/form-data" method="post" action="<?= Router::getUrl('Site', 'NewTask') ?>">
        <div class="form-group">
            <label for="user_name">Пользователь:</label>
            <input name="user_name" class="form-control" id="user_name" placeholder="Имя">
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">Email</label>
            <input name="email" type="email" class="form-control" id="exampleInputEmail1" placeholder="Email">
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
        <button type="submit" class="btn btn-default">Создать задачу</button>
    </form>
</div>