<!-- Include Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<style>
    .title-background {
        background-color: #007bff;
        color: white;
        padding: 15px;
        border-radius: 5px;
    }
</style>

<div class="container mt-5">
    <div class="blog-post">
        <h1 class="display-4 title-background"><?php echo CHtml::encode($model->title); ?></h1>
        <p class="lead"><?php echo CHtml::encode($model->content); ?></p>
        <hr class="my-4">
    </div>

    <!-- Display existing comments -->
    <div class="comments-section">
        <h2 class="h3">Comments</h2>
        <?php foreach ($comments as $comment): ?>
            <div class="comment border p-3 mb-3">
                <p><?php echo CHtml::encode($comment->content); ?></p>
                <p class="text-muted"><small>Posted by <?php echo CHtml::encode($comment->user->username); ?> on <?php echo CHtml::encode($comment->created_at); ?></small></p>
            </div>
        <?php endforeach; ?>
    </div>

    <hr>

    <!-- Form for adding new comments -->
    <div class="comment-form mt-4">
        <h2 class="h4">Leave a Comment</h2>
        <?php $form = $this->beginWidget('CActiveForm', array(
            'id' => 'comment-form',
            'enableAjaxValidation' => false,
            'action' => array('/blogPost/comment', 'id' => $model->id), // Replace with your actual controller action
        )); ?>

        <?php echo $form->hiddenField($newComment, 'blog_post_id', array('value' => $model->id)); ?>

        <div class="form-group">
            <?php echo $form->labelEx($newComment, 'content', array('class' => 'form-label')); ?>
            <?php echo $form->textArea($newComment, 'content', array('rows' => 6, 'cols' => 50, 'class' => 'form-control')); ?>
            <?php echo $form->error($newComment, 'content', array('class' => 'text-danger')); ?>
        </div>

        <div class="form-group">
            <?php echo CHtml::submitButton('Post Comment', array('class' => 'btn btn-primary')); ?>
        </div>

        <?php $this->endWidget(); ?>
    </div>
</div>

<!-- Include Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
