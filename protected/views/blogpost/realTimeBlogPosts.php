<?php if (empty($dataProvider->getData())): ?>
    <p>No populated posts are available.</p>
<?php else: ?>
    <?php foreach ($dataProvider->getData() as $post): ?>
        <div class="post border rounded p-3 mb-4">
            <h2><?php echo CHtml::link(CHtml::encode($post->title), array('view', 'id' => $post->id)); ?></h2>
            <p><?php echo CHtml::encode($post->content); ?></p>
            <p class="text-muted">Author: <?php echo ($post->user !== null) ? CHtml::encode($post->user->username) : 'Unknown'; ?></p>
            <p class="text-muted">Comments: <?php echo CHtml::encode($post->comment_count); ?></p>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
