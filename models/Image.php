<?php
declare(strict_types=1);

namespace app\models;

class Image extends Model {
    public $id;
    public $name;
    public $create_at;
    public $update_at;

    public function tableName()
    {
        return 'image';
    }

}
