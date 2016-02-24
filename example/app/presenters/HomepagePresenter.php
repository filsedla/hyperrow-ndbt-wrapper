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

        //dump($this->database->tableAuthor()->get(1));

        $result = $this->database->tableAuthor()->insert([[
            'name' => 'Vladimír Novotný Jr.',
            'born' => 1985,
        ], [
            'name' => 'Jana Kučerová',
            'born' => 1989,
        ]]);

        //dump($result);

        dump($result->update([
            'name' => 'Name changed'
        ]));


        $this->terminate();
    }
}
