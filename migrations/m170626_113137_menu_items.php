<?php

use yii\db\Migration;

class m170626_113137_menu_items extends Migration
{
    public function safeUp()
    {
        $this->execute("CREATE TABLE IF NOT EXISTS `menu_items` (
          `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Идентификатор',
          `parent_id` int(11) UNSIGNED DEFAULT NULL COMMENT 'Идентификатор родительской категории',
          `name` varchar(255) NOT NULL COMMENT 'Имя',
          `title` varchar(255) NOT NULL COMMENT 'Название',
          `sort` tinyint(3) UNSIGNED NOT NULL COMMENT 'Сортировка',
          `level` int(11) DEFAULT NULL,
          PRIMARY KEY (`id`),
          UNIQUE KEY `index1` (`name`),
          KEY `parent_id` (`parent_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Пункты меню'");
    }

    public function safeDown()
    {
        $this->dropTable('menu_items');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170626_113137_category cannot be reverted.\n";

        return false;
    }
    */
}
