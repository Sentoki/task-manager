<?php
declare(strict_types=1);

namespace app\common;

use app\models\Model;
use PDO;

class Database {
    private static $instance;
    private $pdo;

    private function __construct()
    {
        $dsn = 'pgsql:dbname=beejee;host=127.0.0.1';
        $user = 'postgres';
        $password = '123456';
        $this->pdo = new PDO($dsn, $user, $password);
    }

    public static function getInstance() : self
    {
        if (!isset(static::$instance)) {
            static::$instance = new static();
        }
        return static::$instance;
    }

    public function lastInsertedId()
    {
        return $this->pdo->lastInsertId();
    }

    public function insert(Model $model)
    {
        $properties = get_object_vars($model);
        foreach ($properties as $col => $val) {
            if (is_null($val)) {
                unset($properties[$col]);
            }
        }
        $columns = array_keys($properties);
        $placeholders = array_map(function ($element){
            $element = ':' . $element;
            return $element;
        }, $columns);
        $columns = implode(', ', $columns);
        $placeholders = implode(', ', $placeholders);
        $table = $model->tableName();

        $sql = "INSERT INTO {$table} 
  ({$columns})
VALUES
  ({$placeholders});";
        $stm = $this->pdo->prepare($sql);
        $stm->execute($properties);

    }

    public function update(Model $model)
    {
        $properties = get_object_vars($model);
        if (array_key_exists('where', $properties)) {
            unset($properties['where']);
        }
        if (array_key_exists('limit', $properties)) {
            unset($properties['limit']);
        }
        if (array_key_exists('offset', $properties)) {
            unset($properties['offset']);
        }
        $columns = array_keys($properties);

        $placeholders = array_map(function ($element){
            $element = $element.'=:' . $element;
            return $element;
        }, $columns);
        $placeholders = implode(', ', $placeholders);
        $table = $model->tableName();

        $sql = "UPDATE {$table} 
  set {$placeholders}
WHERE id=:id";
        $stm = $this->pdo->prepare($sql);
        $stm->execute($properties);


    }

    public function select(Model $model) : array
    {
        $bindes = [];
        $table = $model->tableName();
        $sql = "select * from {$table}";
        if (is_array($model->where)) {
            $temp = [];
            foreach ($model->where as $column => $where) {
                $temp[] = "{$column}=:{$column}";
                $bindes[$column] = $where;
            }
            $sql .= ' where ' . implode(' and ', $temp);
        }
        $sql .= ' order by id asc';
        if (!is_null($model->limit)) {
            $sql .= ' limit :limit';
            $bindes['limit'] = $model->limit;
        }
        if (!is_null($model->offset)) {
            $sql .= ' offset :offset';
            $bindes['offset'] = $model->offset;
        }
        $stm = $this->pdo->prepare($sql);
        $stm->execute($bindes);
        $data = $stm->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function count(Model $model)
    {
        $table = $model->tableName();
        $sql = "select count(id) from {$table}";
        $bindes = [];
        if (is_array($model->where)) {
            $temp = [];
            foreach ($model->where as $column => $where) {
                $temp[] = "{$column}=:{$column}";
                $bindes[$column] = $where;
            }
            $sql .= ' where ' . implode(' and ', $temp);
        }
        $stm = $this->pdo->prepare($sql);
        $stm->execute($bindes);
        $count = $stm->fetch(PDO::FETCH_ASSOC);
        return $count;
    }
}