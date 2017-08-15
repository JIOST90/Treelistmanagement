<?php

use yii\db\Migration;

class m170814_120522_menu_items_delete_columns extends Migration
{
    public function safeUp()
    {
        $this->dropColumn('menu_items', 'title');
        $this->dropColumn('menu_items', 'sort');
        $this->dropColumn('menu_items', 'level');
    }

    public function safeDown()
    {
        echo "m170814_120522_menu_items_delete_columns cannot be reverted.\n";

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170814_120522_menu_items_delete_colums cannot be reverted.\n";

        return false;
    }
    */
}
