<?php
use app\common\Router;
?>
<div class="container theme-showcase" role="main">
    <h1>Admin index</h1>
    <a href="<?= Router::getUrl('Admin', 'TaskList') ?>">Список задач</a><br>
</div>