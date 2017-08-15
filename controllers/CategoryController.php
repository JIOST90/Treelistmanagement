<?php

namespace app\controllers;

use app\models\jobs\CreateUpdateCategoryItem;
use app\models\jobs\RemoveCategoryItem;
use app\models\MenuItems;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\MenuItemsForm;
use yii\helpers\Json;
use app\models\jobs\GetCategoryItem;

class CategoryController extends BaseController
{
    public function actionCreateElement()
    {
        if(!$data = $this->request->post('MenuItemsForm')){
            return false;
        }

        $form = new MenuItemsForm();
        $form->attributes = $data;

        $this->dispatch((new CreateUpdateCategoryItem($form)));

        return $this->redirect(['/']);
    }

    public function actionUpdateElement($id)
    {
        if(!$data = $this->request->post('MenuItemsForm')){
            return false;
        }

        $form = new MenuItemsForm();
        $form->attributes = $data;

        $model = MenuItems::findOne($id);

        $this->dispatch((new CreateUpdateCategoryItem($form, $model)));

        return $this->redirect(['/']);
    }

    public function actionDeleteElement($id)
    {
        if(!$data = $this->request->post('MenuItemsForm')){
            return false;
        }

        $this->dispatch((new RemoveCategoryItem($id)));
        return $this->redirect(['/']);
    }

    public function actionGetChildrenElements($id)
    {
        /**
         * @var $menuItem MenuItems
         */
        if(!$menuItem = MenuItems::findOne($id)){
            return false;
        }

        $categories = $this->dispatch(
            (new GetCategoryItem($menuItem))
                ->gatParents()
        );

        $breadCrumbs = null;
        foreach ($categories as $key => &$val){
            $breadCrumbs = (!$breadCrumbs ? $val['parentName'] : $breadCrumbs . ' > ' . $val['parentName']);
            $val['parentName'] = $breadCrumbs;
        }

        return Json::encode($categories);
    }
}
