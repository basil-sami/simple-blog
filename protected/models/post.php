<?php
class Post extends CActiveRecord
{
    public function rules()
    {
        return array(
            array('title, content', 'required'),
            // Add more validation rules as needed
        );
    }

    public function attributeLabels()
    {
        return array(
            'title' => 'Title',
            'content' => 'Content',
            // Define labels for other attributes
        );
    }
}
