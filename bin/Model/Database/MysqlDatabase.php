<?php

namespace Core\Model\Database;

use \pdo;


/**
 * Class MysqlDatabase
 * @package Core\Model\Database
 */
class MysqlDatabase extends Database
{

    /**
     * @var
     */
    private $pdo;

    /**
     * @return pdo
     */
    private function getPDO()
    {
        if ($this->pdo === null) {
            $pdo = new PDO('mysql:host=localhost;dbname=blog', 'root', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo = $pdo;
        }
        return $this->pdo;
    }

    /**
     * @param string $statement
     * @param null $one
     * @return array|false|mixed|\PDOStatement
     */
    public function queryMD(string $statement, $one = Null)
    {

        $req = self::getPDO()->query($statement);


        if (
            strpos($statement, 'UPDATE') === 0 ||
            strpos($statement, 'INSERT') === 0 ||
            strpos($statement, 'DELETE') === 0
        ) {
            return $req;
        }

        if ($one) {
            $data = $req->fetch();
        } else {
            $data = $req->fetchAll();
        }

        return $data;
    }

    /**
     * @param string $statement
     * @param array $attributes
     * @param bool $one
     * @return array|bool|mixed
     */
    public function prepareMD(string $statement, array $attributes = [], $one = false)
    {
        $req = self::getPDO()->prepare($statement);

        $res = $req->execute($attributes);

        if (
            strpos($statement, 'UPDATE') === 0 ||
            strpos($statement, 'INSERT') === 0 ||
            strpos($statement, 'DELETE') === 0
        ) {
            return $res;
        }

        if ($one) {
            $data = $req->fetch();
        } else {
            $data = $req->fetchAll();
        }

        return $data;
    }

    /**
     * @return string
     */
    public function lasInsertId()
    {
        return $this->getPDO()->lastInsertId();
    }
}
