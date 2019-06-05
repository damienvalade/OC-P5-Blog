<?php


namespace App\Model\AdminModel;


use Core\Model\Model;

class CommentariesModel extends Model
{
    public function innerJoin()
    {
        $querry = 'SELECT articles.nomArticle, commentaire.commentaire, users.firstname, commentaire.dateCreation
                    FROM commentaire
                    JOIN articles ON commentaire.id_article = articles.id
                    JOIN users ON commentaire.id_auteur = users.id';

        return $this->query($querry);
    }
}
