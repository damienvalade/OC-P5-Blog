<?php

namespace App\Model\AdminModel;

use Core\Model\Model;

class UserssettingsModel extends Model
{
    public function innerJoin(string $table, string $value, string $on)
    {
        $querry = 'SELECT users.id, users.name, users.Firstname, users.username, users.email, users.image,  administration_type.type
                    FROM users
                    JOIN administration_type ON users.level_administration = administration_type.id';

        return $this->query($querry);
    }
}