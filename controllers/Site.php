<?php
declare(strict_types=1);

namespace app\controllers;

use app\common\FileUpload;
use app\common\Pagination;
use app\models\Image;
use app\models\Task;

class Site extends Controller {
    const TASKS_PER_PAGE = 3;

    public function actionIndex()
    {
        return $this->render('site/index', ['some_var' => 123]);
    }

    public function actionNewTask()
    {
        if (!empty($_POST)) {
            $imageFilename = FileUpload::saveFile();
            $image = new Image();
            $image->load([
                'name' => $imageFilename,
            ]);
            $imageId = $image->save();

            $task = new Task();
            $task->load(array_merge($_POST, ['image_id' => $imageId]));
            $task->save();

        }
        return $this->render('site/new_task', ['some_var' => 123]);
    }

    public function actionTaskList()
    {
        $tasks = Task::find()->limit(self::TASKS_PER_PAGE);
        if (isset($_GET['pagination'])) {
            $offset = ((int)$_GET['pagination'] - 1) * self::TASKS_PER_PAGE;
            $tasks->offset($offset);
        }
        $tasksNum = Task::find()->count();
        $pagination = new Pagination();
        $pagination->setPagesNumber((int)ceil($tasksNum / self::TASKS_PER_PAGE));
        $pages = $pagination->getPages();

        $tasks = $tasks->all();
        return $this->render(
            'site/task_list',
            [
                'tasks' => $tasks,
                'pages' => $pages,
            ]
        );
    }
}
