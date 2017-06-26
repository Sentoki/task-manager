<?php
declare(strict_types=1);

namespace app\models;

class Task extends Model {
    public $id;
    public $user_name;
    public $email;
    public $description;
    public $image_id;
    public $create_at;
    public $update_at;
    public $is_complete;

    public function tableName()
    {
        return 'task';
    }
}
