<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "menu_items".
 *
 * @property string $id Идентификатор
 * @property string $parent_id Идентификатор родительской категории
 * @property string $name Имя
 * @property string $title Название
 * @property int $sort Сортировка
 * @property int $level
 */
class MenuItems extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menu_items';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'sort', 'level'], 'integer'],
            [['name', 'title', 'sort'], 'required'],
            [['name', 'title'], 'string', 'max' => 255],
            [['name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Идентификатор',
            'parent_id' => 'Идентификатор родительской категории',
            'name' => 'Имя',
            'title' => 'Название',
            'sort' => 'Сортировка',
            'level' => 'Level',
        ];
    }

    public function getParent()
    {
        // a comment has one customer
        return $this->hasOne(MenuItems::className(), ['id' => 'parent_id']);
    }

    public function getChildren()
    {
        // a customer has many comments
        return $this->hasMany(MenuItems::className(), ['parent_id' => 'id']);
    }
}
