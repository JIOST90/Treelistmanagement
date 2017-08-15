<?php

namespace app\components;

use yii\base\Widget;
use app\models\jobs\JobDispatcher;
use app\models\jobs\GetCategoryItem;

class CommonWidget extends Widget
{
    use JobDispatcher;

    public $categories;

    public function init()
    {
        parent::init();

        if ($this->categories === null) {
            $this->categories = $this->dispatch(
                (new GetCategoryItem())
                    ->parent()
                    ->findAll()
            );
        }
    }

    public function run()
    {
        return $this->render('view_category', ['categories' => $this->categories, 'level' => 1]);
    }

    public function getViewPath()
    {
        return parent::getViewPath() . "\\..\\..\\views\\widget\\common";
    }
}