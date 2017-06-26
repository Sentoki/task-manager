<?php
declare(strict_types=1);

namespace app\controllers;

use app\common\AccessControl;
use app\common\Pagination;
use app\common\Router;
use app\models\Task;

class Admin extends Controller {
    public function actionIndex()
    {
        AccessControl::isAuthorized();
        return $this->render('admin/index');
    }

    public function actionTaskList()
    {
        $tasks = Task::find()->limit(Site::TASKS_PER_PAGE);
        if (isset($_GET['pagination'])) {
            $offset = ((int)$_GET['pagination'] - 1) * Site::TASKS_PER_PAGE;
            $tasks->offset($offset);
        }
        $tasksNum = Task::find()->count();
        $pagination = new Pagination();
        $pagination->setPagesNumber((int)ceil($tasksNum / Site::TASKS_PER_PAGE));
        $pages = $pagination->getPages();

        $tasks = $tasks->all();
        return $this->render(
            'admin/task_list',
            [
                'tasks' => $tasks,
                'pages' => $pages,
            ]
        );
    }

    public function actionMarkComplete()
    {
        $taskArray = Task::find()->where(['id' => $_GET['task_id']])->all();
        $taskArray = current($taskArray);

        $task = new Task();
        $task->load($taskArray);
        /** @var Task $task */
        $task->is_complete = true;
        $task->save();
        $this->redirect(Router::getUrl('Admin', 'TaskList'));
    }
}
