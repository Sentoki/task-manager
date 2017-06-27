<?php
declare(strict_types=1);

use app\common\Pagination;
use app\common\Router;
use app\common\FileUpload;

?>
<div class="container theme-showcase" role="main">
    <h1>Администрирование списка задач</h1>
    <form class="form-inline" method="get" action="<?= Router::getUrl('Admin', 'TaskList') ?>">
        <div class="form-group">
            <label for="user_name">Пользователь: </label>
            <input name="user_name" class="form-control" id="user_name" placeholder="Имя"
                   value="<?=isset($_GET['user_name'])?$_GET['user_name']:''?>">
        </div>
        <div class="form-group">
            <label for="email">Email: </label>
            <input name="email" class="form-control" id="email" placeholder="Имя"
                   value="<?=isset($_GET['email'])?$_GET['email']:''?>">
        </div>
        <div class="form-group">
            <label for="sel1">Статус: </label>
            <select name="status" class="form-control" id="sel1">
                <?php
                $status_0 = (isset($_GET['status']) && $_GET['status'] == 0) ? ' selected' : '';
                $status_1 = (isset($_GET['status']) && $_GET['status'] == 1) ? ' selected' : '';
                $status_2 = (isset($_GET['status']) && $_GET['status'] == 2) ? ' selected' : '';
                ?>
                <option value="0"<?=$status_0?>>Все</option>
                <option value="1"<?=$status_1?>>Не завершённые</option>
                <option value="2"<?=$status_2?>>Завершённые</option>
            </select>
        </div>
        <input type="hidden" name="controller" value="Admin">
        <input type="hidden" name="action" value="TaskList">
        <input type="hidden" name="pagination" value="<?= $pagination ?>">
        <button type="submit" class="btn btn-default">Фильтровать</button>
    </form>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Имя пользователя</th>
            <th>Email</th>
            <th>Изображение</th>
            <th>Описание</th>
            <th>Время создания</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($tasks as $task) { ?>
        <tr>
            <td><?= $task['user_name'] ?></td>
            <td><?= $task['email'] ?></td>
            <td><img src="/web/uploads/<?= FileUpload::getImageName($task['image_id']) ?>"></td>
            <td><?= $task['description'] ?></td>
            <td><?= $task['create_at'] ?></td>
            <td>
                <?php
                if ($task['is_complete'] == 2) {
                    echo "Задача завершена";
                } else {
                    ?><a href="<?= Router::getUrl('Admin', 'MarkComplete', ['task_id' => $task['id']]) ?>">Отметить выполненной</a><?php
                }
                ?>
                <br>
                <a href="<?= Router::getUrl('Admin', 'EditTaskText', ['task_id' => $task['id']]) ?>">Редактировать</a>
            </td>
        </tr>
        <?php } ?>
        </tbody>
    </table>
    <?php
    $pagination = new Pagination();
    echo $pagination->getPaginationHtml($pages, 'Admin')
    ?>
</div>