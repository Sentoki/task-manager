<?php
declare(strict_types=1);

namespace app\controllers;

use app\common\FileUpload;
use app\common\Pagination;
use app\models\Image;
use app\models\Task;

/**
 * Контроллер доступной пользователю части
 *
 * Class Site
 * @package app\controllers
 */
class Site extends Controller {
    const TASKS_PER_PAGE = 3;

    /**
     * Главная страница
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('site/index', []);
    }

    /**
     * Создание новой задачи
     *
     * @return string
     */
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
            $message = 'Задача была успешно добавлена';
        } else {
            $message = '';
        }
        return $this->render('site/new_task', ['message' => $message]);
    }
}
