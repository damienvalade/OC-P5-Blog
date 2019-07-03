<?php


namespace App\Model\AdminModel;


use Core\Model\Model;

/**
 * Class ArticlesModel
 * @package App\Model\AdminModel
 */
class ArticlesModel extends Model
{
    /**
     * @return array|false|mixed|\PDOStatement
     */
    public function innerJoin()
    {
        $querry = 'SELECT articles.id, articles.nom_article, articles.auteur_article, articles.date_creation, articles.date_maj, categories.titre
                    FROM articles
                    JOIN categories ON articles.id_categories = categories.id';

        return $this->queryMD($querry);
    }
}
