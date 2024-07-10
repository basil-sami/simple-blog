<?php
// models/Comment.php

class Comment extends CActiveRecord
{
    // Define the property to link to blog_post_id in the database
    public $blog_post_id;

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'comments'; // Ensure this matches your actual table name
    }

    public function rules()
    {
        return array(
            array('user_id, blog_post_id, content', 'required'),
            array('content', 'safe'),
        );
    }

    public function relations()
    {
        return array(
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
            'post' => array(self::BELONGS_TO, 'Post', 'blog_post_id'), // Ensure 'blog_post_id' matches your actual column name
        );
    }
}
