<?php

namespace App\Presenters;

use Example\Model\Database\Database;
use Nette;


class HomepagePresenter extends BasePresenter
{

    /** @var Database @inject */
    public $database;


    public function actionDefault()
    {
        //dump($this->database);

        dump($this->database->tableAuthor()->get(1));


        $this->terminate();
    }
}
