<?php

use yii\db\Migration;

class m170814_150748_menu_items_edit_fogeign_key extends Migration
{
    public function safeUp()
    {
        $this->execute("ALTER TABLE `menu_items` DROP FOREIGN KEY `fk_item_menu_id`;");
        $this->execute("ALTER TABLE `menu_items` ADD CONSTRAINT `fk_item_menu_id` 
            FOREIGN KEY (`parent_id`) 
            REFERENCES `menu_items`(`id`) 
            ON DELETE CASCADE ON UPDATE CASCADE;
        ");
    }

    public function safeDown()
    {
        echo "m170814_150748_menu_items_edit_fogeign_key cannot be reverted.\n";

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170814_150748_menu_items_edit_fogeign_key cannot be reverted.\n";

        return false;
    }
    */
}
