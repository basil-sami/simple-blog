<h1>Search Blog Posts</h1>
<form action="<?php echo Yii::app()->createUrl('blogPost/search'); ?>" method="get">
    <div class="form-group">
        <input type="text" name="query" class="form-control" placeholder="Search by title or content">
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary">Search</button>
    </div>
</form>
