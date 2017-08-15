<?php

namespace app\models\jobs;

use app\models\MenuItems;
use app\models\MenuItemsForm;

/**
 * Class UpdateCategoryItem
 * @package app\models\jobs
 */
class CreateUpdateCategoryItem extends Job
{
    /**
     * @var MenuItemsForm
     */
    private $form;

    /**
     * @var MenuItems
     */
    private $model;

    public function __construct(MenuItemsForm $form, MenuItems $model = null)
    {
        $this->model = $model ? $model : (new MenuItems());
        $this->form = $form;
    }

    /**
     * @return MenuItems|bool
     */
    public function handle()
    {
        if(!$this->form->validate()){
            return false;
        }

        $this->model->attributes = $this->form->attributes;

        if(!$this->model->save()){
            return false;
        }

        return $this->model;
    }
}
