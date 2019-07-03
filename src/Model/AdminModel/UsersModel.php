<?php

namespace App\Model\AdminModel;

use Core\Model\Model;

/**
 * Class UsersModel
 * @package App\Model\AdminModel
 */
class UsersModel extends Model
{
    /**
     * @return array|false|mixed|\PDOStatement
     */
    public function innerJoin()
    {
        $querry = 'SELECT users.id, users.name, users.firstname, users.username, users.email, users.image,  administration_type.type
                    FROM users
                    JOIN administration_type ON users.level_administration = administration_type.id';

        return $this->queryMD($querry);
    }
}
