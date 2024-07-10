<?php

class m240707_104227_create_blog_posts_table extends CDbMigration
{
    public function up()
    {
        // Drop tables if they exist
        $this->dropTableIfExists('comments');
        $this->dropTableIfExists('likes');
        $this->dropTableIfExists('blog_posts');
        $this->dropTableIfExists('users');

        // Create 'users' table
        $this->createTable('users', array(
            'id' => 'pk',
            'username' => 'string NOT NULL UNIQUE',
            'email' => 'string NOT NULL UNIQUE',
            'password_hash' => 'string NOT NULL',
            'email_verified' => 'boolean DEFAULT 0',
            'verification_token' => 'string',
        ));

        // Create 'blog_posts' table
        $this->createTable('blog_posts', array(
            'id' => 'pk',
            'user_id' => 'integer',
            'title' => 'string NOT NULL',
            'content' => 'text NOT NULL',
            'is_public' => 'boolean DEFAULT 1',
            'created_at' => 'timestamp DEFAULT CURRENT_TIMESTAMP',
            'updated_at' => 'timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
        ));

        // Create 'likes' table
        $this->createTable('likes', array(
            'id' => 'pk',
            'user_id' => 'integer',
            'blog_post_id' => 'integer',
        ));

        // Create 'comments' table
        $this->createTable('comments', array(
            'id' => 'pk',
            'user_id' => 'integer',
            'blog_post_id' => 'integer',
            'content' => 'text NOT NULL',
            'created_at' => 'timestamp DEFAULT CURRENT_TIMESTAMP',
        ));

        // Add foreign key constraints
        $this->addForeignKey('fk_blog_posts_user_id', 'blog_posts', 'user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_likes_user_id', 'likes', 'user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_likes_blog_post_id', 'likes', 'blog_post_id', 'blog_posts', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_comments_user_id', 'comments', 'user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_comments_blog_post_id', 'comments', 'blog_post_id', 'blog_posts', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        // Drop foreign key constraints first
        $this->dropForeignKey('fk_comments_blog_post_id', 'comments');
        $this->dropForeignKey('fk_comments_user_id', 'comments');
        $this->dropForeignKey('fk_likes_blog_post_id', 'likes');
        $this->dropForeignKey('fk_likes_user_id', 'likes');
        $this->dropForeignKey('fk_blog_posts_user_id', 'blog_posts');

        // Drop tables in reverse order if they exist
        $this->dropTableIfExists('comments');
        $this->dropTableIfExists('likes');
        $this->dropTableIfExists('blog_posts');
        $this->dropTableIfExists('users');
    }

    /**
     * Drops a table if it exists.
     * @param string $tableName the table name
     */
    protected function dropTableIfExists($tableName)
    {
        if ($this->getDbConnection()->schema->getTable($this->getDbConnection()->tablePrefix . $tableName) !== null) {
            $this->dropTable($tableName);
        }
    }
}
