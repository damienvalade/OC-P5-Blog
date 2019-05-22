<?php

namespace Core\Model;

use Core\Model\Database\MysqlDatabase;

class Model extends MysqlDatabase
{

    public function create(string $table, array $data)
    {
        $keys = implode(', ', array_keys($data));
        $values = implode('", "', $data);
        $query = 'INSERT INTO ' . $table . ' ( ' . $keys . ' ) VALUES ("' . $values . '")';

        return $this->query($query);
    }

    public function read(string $table,string $value = null, string $key = null, $one = false)
    {

        if($one){
            if (isset($key)) {
                $query = 'SELECT * FROM ' . $table . ' WHERE ' . $key . ' = ?';
            } else {
                $query = 'SELECT * FROM ' . $table . ' WHERE id = ?';
            }

            return $this->prepare($query, [$value], $one);
        }else{

            $query = 'SELECT * FROM ' . $table;

            return $this->query($query);

        }

    }

    public function update(string $table, string $value, array $data, string $key = null, $one = false)
    {
        $set = null;

        foreach ($data as $dataKey => $dataValue) {
            $set .= $dataKey . ' = "' . $dataValue . '", ';
        }
        $set = substr_replace($set, '', -2);
        if (isset($key)) {
            $query = 'UPDATE ' . $table . ' SET ' . $set . ' WHERE ' . $key . ' = ?';
        } else {
            $query = 'UPDATE ' . $table . ' SET ' . $set . ' WHERE id = ?';
        }

        return $this->prepare($query, [$value], $one);
    }

    public function delete(string $value, string $key = null)
    {
        if (isset($key)) {
            $query = 'DELETE FROM ' . $this->table . ' WHERE ' . $key . ' = ?';
        } else {
            $query = 'DELETE FROM ' . $this->table . ' WHERE id = ?';
        }
        return $this->query($query, [$value]);
    }

}