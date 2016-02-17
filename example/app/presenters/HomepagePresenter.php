<?php

namespace App\Presenters;

use Example\Model\Database;
use Nette;


class HomepagePresenter extends BasePresenter
{

    /** @var Database @inject */
    public $database;


    public function actionDefault()
    {
        //dump($this->database);

        dump($this->database->tableAuthor()->fetch()->bookCount());


        $this->terminate();
    }
}
