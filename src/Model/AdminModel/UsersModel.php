<?php

namespace App\Model\AdminModel;

use Core\Model\Model;

class UsersModel extends Model
{
    public function innerJoin()
    {
        $querry = 'SELECT users.id, users.name, users.firstname, users.username, users.email, users.image,  administration_type.type
                    FROM users
                    JOIN administration_type ON users.level_administration = administration_type.id';

        return $this->queryMD($querry);
    }
}
