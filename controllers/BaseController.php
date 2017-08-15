<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 02.08.2017
 * Time: 15:44
 */

namespace app\controllers;

use Yii;
use yii\base\Module;
use yii\web\Controller;
use app\models\MenuItems;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use Codeception\Step\Condition;
use app\models\jobs\JobDispatcher;
use app\models\jobs\CreateCategoryItem;

class BaseController extends Controller
{
    use JobDispatcher;

    /**
     * @var \yii\console\Request|\yii\web\Request
     */
    public $request;

    public function __construct($id, Module $module, array $config = [])
    {
        $this->request = Yii::$app->request;

        parent::__construct($id, $module, $config);
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
}