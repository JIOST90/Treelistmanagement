<?php

namespace app\models\jobs;

use app\models\MenuItems;
use app\models\MenuItemsForm;

/**
 * Class CreateCategoryItem
 * @package app\models\jobs
 */
class CreateCategoryItem extends Job
{
    /**
     * @var MenuItemsForm
     */
    private $form;

    /**
     * @var MenuItems
     */
    private $model;

    /**
     * CreateCategoryItem constructor.
     */
    public function __construct(MenuItemsForm $form)
    {
        $this->model = new MenuItems();
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

        return !$this->model->save() ?: $this->model;
    }
}
