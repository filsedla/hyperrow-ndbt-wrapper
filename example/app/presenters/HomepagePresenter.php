<?php

namespace App\Presenters;

use Filsedla\Hyperrow\SystemDatabase;
use Nette;


class HomepagePresenter extends BasePresenter
{

    /** @var SystemDatabase */
    public $database;


    /**
     * @param SystemDatabase $database
     */
    public function __construct(SystemDatabase $database)
    {
        parent::__construct();
        $this->database = $database;
    }


    public function actionDefault()
    {
        //dump($this->database);

        //dump($this->database->table('empty')->fetch());

        dump($this->database->tableAuthor()->fetch());

        $this->terminate();
    }
}
