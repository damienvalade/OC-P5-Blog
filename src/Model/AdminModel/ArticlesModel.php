<?php


namespace App\Model\AdminModel;


use Core\Model\Model;

class ArticlesModel extends Model
{
    public function innerJoin(string $table, string $value, string $on)
    {
        $querry = 'SELECT articles.nomArticle, articles.auteurArticle, articles.dateCreation, articles.dateMaj, categories.titre
                    FROM articles
                    JOIN categories ON articles.id_categories = categories.id';

        return $this->query($querry);
    }
}
