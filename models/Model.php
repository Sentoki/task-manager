<?php
declare(strict_types=1);

namespace app\models;

use app\common\Database;

/**
 * Общая логика работы с моделями
 *
 * Class Model
 * @package app\models
 */
abstract class Model {
    public $offset = null;
    public $limit = null;
    public $where = null;

    /**
     * @return string название таблицы
     */
    abstract function tableName() : string;

    public function load(array $modelData) : bool
    {
        foreach ($this as $property => $value) {
            if (isset($modelData[$property])) {
                $this->$property = $modelData[$property];
            }
        }
        return true;
    }

    public function save()
    {
        $db = Database::getInstance();
        if (isset($this->id)) {
            $db->update($this);
        } else {
            $db->insert($this);
        }
        return $db->lastInsertedId();
    }

    public function where(array $where) : self
    {
        $this->where = $where;
        return $this;
    }

    public function offset(int $offset) : self
    {
        $this->offset = $offset;
        return $this;
    }

    public function limit(int $limit) : self
    {
        $this->limit = $limit;
        return $this;
    }

    public static function find() : self
    {
        $model = new static();
        return $model;
    }

    public function all() : array
    {
        $db = Database::getInstance();
        $data = $db->select($this);
        return $data;
    }

    public function count() : int
    {
        $db = Database::getInstance();
        $data = $db->count($this);
        return $data['count'];
    }
}