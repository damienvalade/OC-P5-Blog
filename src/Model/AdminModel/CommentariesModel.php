<?php


namespace App\Model\AdminModel;


use Core\Model\Model;

/**
 * Class CommentariesModel
 * @package App\Model\AdminModel
 */
class CommentariesModel extends Model
{
    /**
     * @return array|false|mixed|\PDOStatement
     */
    public function innerJoin()
    {
        $querry = 'SELECT articles.nom_article, commentaire.commentaire, users.firstname, commentaire.date_creation, commentaire.id, commentaire.id_article
                    FROM commentaire
                    JOIN articles ON commentaire.id_article = articles.id
                    JOIN users ON commentaire.id_auteur = users.id';

        return $this->queryMD($querry);
    }
}
