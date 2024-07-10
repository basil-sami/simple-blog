<div class="view">
    <h2><?php echo CHtml::encode($data->title); ?></h2>
    <p><?php echo CHtml::encode($data->content); ?></p>
    <p>Visibility: <?php echo CHtml::encode($data->visibility); ?></p>
    <p>Created: <?php echo CHtml::encode($data->created_at); ?></p>
    <p>Author: <?php echo CHtml::encode($data->user->username); ?></p>
    <p>
        <?php echo CHtml::link('View', array('view', 'id'=>$data->id)); ?>
        <?php if (Yii::app()->user->id === $data->user_id): ?>
            <?php echo CHtml::link('Update', array('update', 'id'=>$data->id)); ?>
            <?php echo CHtml::linkButton('Delete', array(
                'submit'=>array('delete','id'=>$data->id),
                'confirm'=>"Are you sure you want to delete this item?",
            )); ?>
        <?php endif; ?>
    </p>
</div>
