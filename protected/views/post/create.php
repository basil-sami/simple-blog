<form method="post" action="<?php echo Yii::app()->createUrl('post/create'); ?>">
    <input type="text" name="Post[title]" placeholder="Title">
    <textarea name="Post[content]" placeholder="Content"></textarea>
    <button type="submit">Create Post</button>
</form>
