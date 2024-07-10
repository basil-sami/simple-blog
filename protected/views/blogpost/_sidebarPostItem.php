<div class="post border rounded p-3 mb-4">
    <h4><?php echo CHtml::link(CHtml::encode($data->title), array('view', 'id' => $data->id)); ?></h4>
    <p><?php echo CHtml::encode($data->content); ?></p>
    <p class="text-muted">Author: <?php echo ($data->user !== null) ? CHtml::encode($data->user->username) : 'Unknown'; ?></p>
    <p class="text-muted">Comments: <?php echo CHtml::encode($data->comment_count); ?></p>
</div>
