<?php
class Like extends CActiveRecord
{
    public function tableName()
    {
        return 'likes';
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function rules()
    {
        return array(
            array('user_id, post_id', 'required'),
            array('user_id, post_id', 'numerical', 'integerOnly' => true),
        );
    }
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Like the static model class
     */
    

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
            'blogPost' => array(self::BELONGS_TO, 'BlogPost', 'blog_post_id'),
        );
    }

    /**
     * @return array customized attribute labels (name => label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'user_id' => 'User ID',
            'blog_post_id' => 'Blog Post ID',
        );
    }

    /**
     * Checks if a user has liked a specific blog post.
     * @param integer $userId the ID of the user.
     * @param integer $postId the ID of the blog post.
     * @return boolean true if the user has liked the post, false otherwise.
     */
    public static function hasUserLiked($userId, $postId)
    {
        return self::model()->exists('user_id=:user_id AND blog_post_id=:blog_post_id', array(
            ':user_id' => $userId,
            ':blog_post_id' => $postId,
        ));
    }
}
