<?php
declare(strict_types=1);

use app\common\Pagination;
use app\common\Router;

?>
<div class="container theme-showcase" role="main">
    <h1>Администрирование списка задач</h1>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>user_id</th>
            <th>email</th>
            <th>image_id</th>
            <th>create_at</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($tasks as $task) { ?>
        <tr>
            <td><?= $task['user_name'] ?></td>
            <td><?= $task['email'] ?></td>
            <td><?= $task['image_id'] ?></td>
            <td><?= $task['create_at'] ?></td>
            <td>
                <?php
                if ($task['is_complete'] == true) {
                    echo "<p>Задача завершена</p>";
                } else {
                    ?><a href="<?= Router::getUrl('Admin', 'MarkComplete', ['task_id' => $task['id']]) ?>">Отметить выполненной</a><?php
                }
                ?>
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