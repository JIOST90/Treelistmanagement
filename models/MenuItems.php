<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "menu_items".
 *
 * @property string $id Идентификатор
 * @property string $parent_id Идентификатор родительской категории
 * @property string $name Имя
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
            [['parent_id'], 'integer'],
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
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


    private function holders()
    {
        return [
            'parent_null' => 'parent_id IS NULL',
            'by_parent' => 'parent_id = :parent_id',
        ];
    }

    /**
     * @param $name string
     * @param array $params
     * @return \yii\db\Expression|null
     */
    public static function getHolder($name, $params = [])
    {
        if(!ArrayHelper::keyExists($name, ($holders = self::holders()), false)){
            return null;
        }

        $exp = new \yii\db\Expression($holders[$name], $params);

        return $exp;
    }
}
