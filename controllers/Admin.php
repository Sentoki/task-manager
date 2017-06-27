<?php
declare(strict_types=1);

namespace app\controllers;

use app\common\AccessControl;
use app\common\Pagination;
use app\common\Router;
use app\models\Task;

/**
 * Контроллер административных страниц
 *
 * Class Admin
 * @package app\controllers
 */
class Admin extends Controller {

    /**
     * Главная страница админки
     *
     * @return string
     */
    public function actionIndex()
    {
        AccessControl::isAuthorized();
        return $this->render('admin/index');
    }

    /**
     * Страница списка задач
     *
     * @return string
     */
    public function actionTaskList()
    {
        AccessControl::isAuthorized();
        $tasks = Task::find();
        $where = [];
        if (isset($_GET['user_name']) && $_GET['user_name'] != '') {
            $where['user_name'] = $_GET['user_name'];
        }
        if (isset($_GET['email']) && $_GET['email'] != '') {
            $where['email'] = $_GET['email'];
        }
        if (isset($_GET['status']) && $_GET['status'] != 0) {
            $where['is_complete'] = $_GET['status'];
        }
        if (!empty($where)) {
            $tasks = $tasks->where($where);
        }

        $tasks = $tasks->limit(Site::TASKS_PER_PAGE);
        if (isset($_GET['pagination'])) {
            $offset = ((int)$_GET['pagination'] - 1) * Site::TASKS_PER_PAGE;
            $tasks->offset($offset);
        }

        $tasksNum = Task::find();
        if (!empty($where)) {
            $tasksNum = $tasksNum->where($where);
        }
        $tasksNum = $tasksNum->count();
        $pagination = new Pagination();
        $pagination->setPagesNumber((int)ceil($tasksNum / Site::TASKS_PER_PAGE));
        $pages = $pagination->getPages();

        $tasks = $tasks->all();
        return $this->render(
            'admin/task_list',
            [
                'tasks' => $tasks,
                'pages' => $pages,
                'pagination' => isset($_GET['pagination']) ? (int)$_GET['pagination'] : 1,
            ]
        );
    }

    /**
     * Контроллер переводящий задачи в статус "выполнено"
     */
    public function actionMarkComplete()
    {
        AccessControl::isAuthorized();
        $taskArray = Task::find()->where(['id' => $_GET['task_id']])->all();
        $taskArray = current($taskArray);

        $task = new Task();
        $task->load($taskArray);
        /** @var Task $task */
        $task->is_complete = 2;
        $task->save();
        $this->redirect(Router::getUrl('Admin', 'TaskList'));
    }

    public function actionEditTaskText()
    {
        AccessControl::isAuthorized();
        $taskArray = Task::find()->where(['id' => $_GET['task_id']])->all();
        $taskArray = current($taskArray);

        $task = new Task();
        $task->load($taskArray);

        if (!empty($_POST) && isset($_POST['description'])) {
            /** @var Task $task */
            $task->description = $_POST['description'];
            $task->save();
            $message = 'Задача была успешно отредактирована';
        } else {
            $message = '';
        }
        return $this->render('admin/edit_task', ['task' => $task, 'message' => $message]);
    }
}
