<?php


namespace App\Model;

use App\Database\MysqlDatabase;

class Model
{

    protected $database;
    protected $table;


    public function create(array $data)
    {
        $keys = implode(', ', array_keys($data));
        $values = implode('", "', $data);
        $query = 'INSERT INTO ' . $this->table . ' ( ' . $keys . ' ) VALUES ("' . $values . '")';

        return MysqlDatabase::query($query);
    }

    public function read(string $value, string $key = null)
    {
        if (isset($key)) {
            $query = 'SELECT * FROM ' . $this->table . ' WHERE ' . $key . ' = ?';
        } else {
            $query = 'SELECT * FROM ' . $this->table . ' WHERE id = ?';
        }

        return MysqlDatabase::query($query, [$value]);
    }

    public function update(string $value, array $data, string $key = null)
    {
        $set = null;

        foreach ($data as $dataKey => $dataValue) {
            $set .= $dataKey . ' = "' . $dataValue . '", ';
        }
        $set = substr_replace($set, '', -2);
        if (isset($key)) {
            $query = 'UPDATE ' . $this->table . ' SET ' . $set . ' WHERE ' . $key . ' = ?';
        } else {
            $query = 'UPDATE ' . $this->table . ' SET ' . $set . ' WHERE id = ?';
        }

        return MysqlDatabase::query($query, [$value]);
    }

    public function delete(string $value, string $key = null)
    {
        if (isset($key)) {
            $query = 'DELETE FROM ' . $this->table . ' WHERE ' . $key . ' = ?';
        } else {
            $query = 'DELETE FROM ' . $this->table . ' WHERE id = ?';
        }
        return MysqlDatabase::query($query, [$value]);
    }
}