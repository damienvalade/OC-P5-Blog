<?php


namespace App\Controller\ErrorsController;

use Core\Controller\FrontController;

/**
 * Class ErrorsController
 * @package App\Controller\ErrorsController
 */
class ErrorsController extends FrontController
{
    /**
     * @return array
     */
    public function errorsAction(){

        $error = filter_input(INPUT_GET,'type',FILTER_SANITIZE_NUMBER_INT);

        switch ($error) {
            case 401:
                $error = $this->unauthorized();
                break;
            case 403:
                $error = $this->forbidden();
                break;
            case 404:
                $error = $this->notfound();
                break;
            case 500:
                 $error = $this->serverError();
                break;
        }

        $response = [ 'path' => $error,
            'data' => [],
        ];

        return $response;
    }
}