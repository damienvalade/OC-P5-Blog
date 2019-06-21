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

        return $this->queryMD($query);
    }

    public function read(string $table,string $value = null, string $key = null, $one = true, $exotic = false, $and = false, array $andValue = [])
    {

        if(!$one){
            if (isset($key)) {
                $query = 'SELECT * FROM ' . $table . ' WHERE ' . $key . ' = ?';
            } else {
                $query = 'SELECT * FROM ' . $table . ' WHERE id = ?';
            }

            return $this->prepareMD($query, [$value], $one);
        }else{


            if($exotic){
                $query = "SELECT $value FROM $table GROUP BY $value";
                return $this->queryMD($query);
            }

            if($and === true){
                $keys = implode(" AND ", $andValue);
                $query = "SELECT $value FROM $table WHERE $keys";

                return $this->queryMD($query);
            }

            $query = 'SELECT * FROM ' . $table;

            return $this->queryMD($query);

        }



    }

    public function update(string $table, string $value, array $data, string $key = null)
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

        return $this->prepareMD($query, [$value]);
    }

    public function delete(string $value, string $key = null)
    {
        if (isset($key)) {
            $query = 'DELETE FROM ' . $this->table . ' WHERE ' . $key . ' = ?';
        } else {
            $query = 'DELETE FROM ' . $this->table . ' WHERE id = ?';
        }
        return $this->queryMD($query, [$value]);
    }

}