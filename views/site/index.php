<?php
use app\common\Router;
?>
<h1>Index page</h1>

<p>Index test</p>

<a href="<?= Router::getUrl('Site', 'NewTask') ?>">Создать новую задачу</a><br>

<?= $some_var ?>