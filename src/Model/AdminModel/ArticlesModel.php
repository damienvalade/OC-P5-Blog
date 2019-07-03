<?php


namespace App\Model\AdminModel;


use Core\Model\Model;

class ArticlesModel extends Model
{
    public function innerJoin()
    {
        $querry = 'SELECT articles.id, articles.nom_article, articles.auteur_article, articles.date_creation, articles.date_maj, categories.titre
                    FROM articles
                    JOIN categories ON articles.id_categories = categories.id';

        return $this->queryMD($querry);
    }
}

