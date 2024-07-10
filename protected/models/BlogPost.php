<?php

class BlogPost extends CActiveRecord
{
    public function like($userId)
    {
        $like = new Like();
        $like->user_id = $userId;
        $like->post_id = $this->id;
        return $like->save();   
    }

    public function unlike($userId)
    {
        $like = Like::model()->findByAttributes(array('user_id' => $userId, 'post_id' => $this->id));
        if ($like) {
            return $like->delete();
        }
        return false;
    }

    public function isLikedByUser($userId)
    {
        return Like::model()->exists('user_id=:user_id AND post_id=:post_id', array(':user_id' => $userId, ':post_id' => $this->id));
    }
       /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return BlogPost the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'blog_posts';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // Define rules for the user_id, title, content, is_public, and other attributes
        return array(
            array('title, content, user_id', 'required'),
            array('user_id', 'numerical', 'integerOnly' => true),
            array('title', 'length', 'max' => 255),
            array('is_public', 'boolean'),
            array('created_at, updated_at', 'safe'),
            // The following rule is used by search().
            array('id, user_id, title, content, is_public, created_at, updated_at', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
            'likes' => array(self::HAS_MANY, 'Like', 'blog_post_id'),
            'comments' => array(self::HAS_MANY, 'Comment', 'blog_post_id'),
        );
    }

    /**
     * @return array customized attribute labels (name => label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'user_id' => 'User',
            'title' => 'Title',
            'content' => 'Content',
            'is_public' => 'Public',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        );
    }
    public function search()
    {
        $criteria = new CDbCriteria;

        if ($this->title) {
            $criteria->compare('title', $this->title, true);
        }

        if ($this->content) {
            $criteria->compare('content', $this->content, true);
        }

        // Add more criteria if needed

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getCommentCount() {
        return count($this->comments); // Example, adjust as per your logic
    }

    // Optionally define 'comment_count' as a virtual property
    public function getComment_count() {
        return $this->getCommentCount();
    }
}

?>
