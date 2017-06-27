<?php
declare(strict_types=1);

namespace app\models;

/**
 * Модель задачи
 *
 * Class Task
 * @package app\models
 */
class Task extends Model {
    public $id;
    public $user_name;
    public $email;
    public $description;
    public $image_id;
    public $create_at;
    public $update_at;
    public $is_complete;

    /**
     * @inheritdoc
     */
    public function tableName() : string
    {
        return 'task';
    }
}
