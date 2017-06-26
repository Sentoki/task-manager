<?php
declare(strict_types=1);

use app\common\Pagination;


?>
<div class="container theme-showcase" role="main">
    <h1>Список задач</h1>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>user_id</th>
            <th>email</th>
            <th>image_id</th>
            <th>create_at</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($tasks as $task) { ?>
        <tr>
            <td><?= $task['user_name'] ?></td>
            <td><?= $task['email'] ?></td>
            <td><?= $task['image_id'] ?></td>
            <td><?= $task['create_at'] ?></td>
        </tr>
        <?php } ?>
        </tbody>
    </table>
    <?php
    $pagination = new Pagination();
    echo $pagination->getPaginationHtml($pages, 'Site')
    ?>
</div>