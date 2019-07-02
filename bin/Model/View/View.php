<?php


namespace Core\Model\View;

use Core\Model\Model;

/**
 * Class View
 * @package Core\Model\View
 */
class View
{

    /**
     * @var
     */
    protected $data;
    /**
     * @var Model
     */
    protected $database;

    /**
     * View constructor.
     */
    public function __construct()
    {
        $this->database = new Model();
    }

    /**
     *
     */
    public function addView(){

        $pageName = filter_input(INPUT_GET, 'rubric', FILTER_SANITIZE_STRING);
        $pageNickname = filter_input(INPUT_GET, 'name', FILTER_SANITIZE_STRING);

        if ($pageNickname === null) {
            $pageNickname = 'home';
        }

        $andValue = [
            "page = '" . $pageName ."'",
            "url = '" . $pageNickname ."'"
        ];

        $view = $this->database->read('view', '*', null, true, false, true, $andValue);

        date_default_timezone_set('Europe/Paris');
        $date = date('Y-m-d');

        if ($view === []) {

            $details = [
                'page' => $pageName,
                'url' => $pageNickname,
                'nb_view' => 0.5,
                'day' => $date
            ];

            $this->data = $this->database->create('view', $details);

        }

        if (isset($view[0])) {
            if ($view[0]['day'] !== $date) {
                $details = [
                    'page' => $pageName,
                    'url' => $pageNickname,
                    'nb_view' => 0.5,
                    'day' => $date
                ];

                $this->data = $this->database->create('view', $details);

            } elseif ($view[0]['day'] === $date) {
                $nb_view = $view[0]['nb_view'] + 0.5;
                $details = ['nb_view' => $nb_view];
                $this->data = $this->database->update('view', $view[0]['id'], $details);
            }
        }
    }

}