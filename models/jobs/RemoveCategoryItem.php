<?php

namespace app\models\jobs;

use app\models\MenuItems;

/**
 * Class RemoveCategoryItem
 * @package app\models\jobs
 */
class RemoveCategoryItem extends Job
{
    /**
     * @var MenuItems
     */
    private $model;

    /**
     * CreateCategoryItem constructor.
     */
    public function __construct($id)
    {
        $this->model = MenuItems::findOne($id);;
    }

    /**
     * @return bool
     */
    public function handle()
    {
        return $this->model->delete();
    }
}
