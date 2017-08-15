<?php

namespace app\models;

use yii\base\Model;

class MenuItemsForm extends Model
{
    /**
     * @var
     */
    public $parent_id;

    /**
     * @var
     */
    public $name;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['parent_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'parent_id' => 'Идентификатор родительской категории',
            'name' => 'Имя',
        ];
    }
}
