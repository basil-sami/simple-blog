<!-- Include Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<h1 class="mb-4">Blog Posts</h1>

<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>

<?php $form = $this->beginWidget('CActiveForm', array(
    'method' => 'get',
    'action' => Yii::app()->createUrl($this->route),
    'htmlOptions' => array('class' => 'form-inline mb-4'),
)); ?>

<div class="form-group mr-2">
    <?php echo $form->label($model, 'title', array('class' => 'mr-2')); ?>
    <?php echo $form->textField($model, 'title', array('class' => 'form-control')); ?>
</div>

<div class="form-group mr-2">
    <?php echo $form->label($model, 'content', array('class' => 'mr-2')); ?>
    <?php echo $form->textField($model, 'content', array('class' => 'form-control')); ?>
</div>

<div class="form-group">
    <?php echo CHtml::submitButton('Search', array('class' => 'btn btn-primary')); ?>
</div>

<?php $this->endWidget(); ?>

<div class="blog-posts">
    <?php foreach ($dataProvider->getData() as $post): ?>
        <div class="post border rounded p-3 mb-4">
            <h2><?php echo CHtml::link(CHtml::encode($post->title), array('view', 'id' => $post->id)); ?></h2>
            <p><?php echo CHtml::encode($post->content); ?></p>

            <div class="post-actions mb-3">
                <button class="like-button btn btn-primary mr-2" data-id="<?php echo $post->id; ?>">
                    <?php echo $post->isLikedByUser(Yii::app()->user->id) ? 'Unlike' : 'Like'; ?>
                </button>

                <?php if (Yii::app()->user->id === $post->user_id || Yii::app()->user->isAdmin): ?>
                    <?php echo CHtml::link('Update', array('update', 'id' => $post->id), array('class' => 'btn btn-secondary mr-2')); ?>
                    <?php echo CHtml::link('Delete', array('delete', 'id' => $post->id), array('class' => 'btn btn-danger', 'confirm' => 'Are you sure you want to delete this post?')); ?>
                <?php endif; ?>
            </div>

            <?php $comments = $post->comments; ?>
            <?php if (!empty($comments)): ?>
                <?php $recentComment = end($comments); ?>
                <div class="recent-comment">
                    <h5 class="font-weight-bold">Most Recent Comment:</h5>
                    <p><?php echo CHtml::encode($recentComment->content); ?></p>
                    <p class="text-muted"><small>Posted by <?php echo CHtml::encode($recentComment->user->username); ?> on <?php echo CHtml::encode($recentComment->created_at); ?></small></p>
                </div>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>

<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script>
    jQuery(document).ready(function($) {
        $(document).on('click', '.like-button', function() {
            var postId = $(this).data('id');
            var button = $(this);

            $.ajax({
                url: '<?php echo Yii::app()->createUrl("blogPost/Like"); ?>',
                type: 'POST',
                data: {
                    id: postId,
                    <?php echo Yii::app()->request->csrfTokenName; ?>: '<?php echo Yii::app()->request->csrfToken; ?>'
                },
                success: function(response) {
                    try {
                        var data = JSON.parse(response);
                        if (data.status === 'liked') {
                            button.text('Unlike');
                        } else if (data.status === 'unliked') {
                            button.text('Like');
                        }
                    } catch (e) {
                        console.error('Invalid JSON response:', response);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        });
    });
</script>
<!-- File: protected/views/site/index.php -->

<div id="real-time-blog-posts">
    <!-- Real-time blog posts will be loaded here -->
</div>

<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script>
    $(document).ready(function() {
        fetchRealTimeBlogPosts();

        function fetchRealTimeBlogPosts() {
            $.ajax({
                url: '<?php echo Yii::app()->createUrl("blogPost/realTimeBlogPosts"); ?>',
                type: 'GET',
                success: function(response) {
                    $('#real-time-blog-posts').html(response);
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching real-time blog posts:', error);
                }
            });

            setTimeout(fetchRealTimeBlogPosts, 5000); // Fetch every 5 seconds (adjust as needed)
        }
    });
</script>
