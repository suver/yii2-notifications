<?php

use yii\db\Migration;

class m161008_180332_notifications extends Migration
{
    public function up()
    {


        $this->db->createCommand("CREATE TABLE `suver_notifications_template` ( 
                `key` VARCHAR(100) NOT NULL , 
                `language` VARCHAR(10) NOT NULL DEFAULT 'default', 
                `bind` TINYINT NULL DEFAULT '0', 
                `title` VARCHAR(255) NULL DEFAULT NULL ,
                `description` TEXT NULL DEFAULT NULL , 
                `subject` VARCHAR(255) NULL DEFAULT NULL ,
                `template` TEXT NULL DEFAULT NULL , 
                `params` TEXT NULL DEFAULT NULL , 
                `created_at` TIMESTAMP NULL DEFAULT NULL , 
                `updated_at` TIMESTAMP NULL DEFAULT NULL , 
                PRIMARY KEY (`key`, `language`)
            ) ENGINE = InnoDB;")->execute();

        $this->db->createCommand("CREATE TABLE `suver_notifications` ( 
                `id` BIGINT(20) NOT NULL AUTO_INCREMENT , 
                `user_id` BIGINT(20) NOT NULL , 
                `type` TINYINT(2) NULL DEFAULT NULL ,
                `subject` VARCHAR(255) NULL DEFAULT NULL , 
                `message` TEXT NULL DEFAULT NULL , 
                `params` TEXT NULL DEFAULT NULL , 
                `channel` TINYINT(2) NULL DEFAULT NULL , 
                `updated_at` TIMESTAMP NULL DEFAULT NULL , 
                `created_at` TIMESTAMP NULL DEFAULT NULL , 
                `viewed_at` TIMESTAMP NULL DEFAULT NULL , 
                PRIMARY KEY (`id`), 
                INDEX `user_id` (`user_id`)
            ) ENGINE = InnoDB;")->execute();
    }

    public function down()
    {
        echo "m161008_180332_notifications cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
