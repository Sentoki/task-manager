<?php
declare(strict_types=1);

namespace app\models;

/**
 * Модель изображения
 *
 * Class Image
 * @package app\models
 */
class Image extends Model {
    public $id;
    public $name;
    public $create_at;
    public $update_at;

    /**
     * @inheritdoc
     */
    public function tableName() : string
    {
        return 'image';
    }
}
