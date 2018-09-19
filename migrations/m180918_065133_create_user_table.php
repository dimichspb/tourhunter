<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user`.
 */
class m180918_065133_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'username' => $this->string(64)->unique()->notNull(),
            'access_token' => $this->string(255)->unique()->notNull(),
            'auth_key' => $this->string(255)->unique()->notNull(),
            'balance' => $this->decimal()->notNull()->defaultValue(0)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('user');
    }
}
