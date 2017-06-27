<?php
declare(strict_types=1);

use app\common\Router;
?>
<div class="container theme-showcase" role="main">
    <h1>Редактирование задачи</h1>
    <?php if ($message != '') { ?>
        <div class="alert alert-success">
            <?= $message ?>
        </div>
    <?php } ?>
    <form method="post" action="<?= Router::getUrl('Admin', 'EditTaskText', ['task_id' => $task->id]) ?>">
        <div class="form-group">
            <label for="description">Описание задачи:</label>
            <textarea class="form-control" rows="5" id="description" name="description"><?= $task->description ?></textarea>
        </div>
        <button type="submit" class="btn btn-default">Редактировать задачу</button>
    </form>
</div>