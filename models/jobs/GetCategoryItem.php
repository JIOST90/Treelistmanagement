<?php

namespace app\models\jobs;

use app\models\MenuItems;
use yii\helpers\ArrayHelper;

/**
 * Class GetCategoryItem
 * @package app\models\jobs
 */
class GetCategoryItem extends Job
{
    /**
     * @var MenuItems
     */
    private $model;

    /**
     * @var MenuItems|array|null
     */
    private $result = null;

    public function __construct(MenuItems $model = null)
    {
        if($model){
            $this->model = $model;
            $this->result = $model;
        } else {
            $this->model = (new MenuItems())->find();
        }
    }

    /**
     * @return MenuItems|array|null
     */
    public function handle()
    {
        return $this->result;
    }

    /**
     * @return $this
     */
    public function parent()
    {
        $this->model->andWhere(MenuItems::getHolder('parent_null'));

        return $this;
    }

    /**
     * @return $this
     */
    public function withChildren()
    {
        $this->model->with('children');

        return $this;
    }

    /**
     * @return $this
     */
    public function forCategory()
    {
        $this->result = $this->model
            ->addSelect(['name', 'id'])
            ->indexBy('id')
            ->column();

        return $this;
    }

    /**
     * @return $this
     */
    public function findAll()
    {
        $this->result = $this->model->all();

        return $this;
    }

    public function byCategory($parentId)
    {
        $this->model->andWhere(MenuItems::getHolder('by_parent', ['parent_id' => $parentId]));

        return $this;
    }

    public function children()
    {
        $this->model = $this->model->getChildren();

        return $this;
    }

    public function getLevelByParent()
    {
        if (!($this->model instanceof MenuItems)) {
            return $this;
        }

        return $this;
    }

    public function gatParents()
    {
        if (!($this->model instanceof MenuItems)) {
            return $this;
        }

        $this->result = $this->hasParent($this->model);

        return $this;
    }

    private function hasParent(MenuItems $model)
    {
        $category = ($category = $this->dispatch(
            (new GetCategoryItem($model))
                ->children()
                ->forCategory()))
            ? [
                $model->id => [
                    'parentName' => $model->name,
                    'categories' => $category,
                ]
            ] : [];

        if($parent = $model->parent){
            $hasParent = $this->hasParent($parent);
            $categories = ArrayHelper::merge($hasParent, $category);

            return $categories;
        } else {
            return $category;
        }
    }
}
