<?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'blog-post-form',
    'htmlOptions' => array('class' => 'form-horizontal'),
)); ?>

<div class="form-group">
    <?php echo $form->labelEx($model, 'title', array('class' => 'control-label')); ?>
    <?php echo $form->textField($model, 'title', array('class' => 'form-control')); ?>
    <?php echo $form->error($model, 'title'); ?>
</div>

<div class="form-group">
    <?php echo $form->labelEx($model, 'content', array('class' => 'control-label')); ?>
    <?php echo $form->textArea($model, 'content', array('class' => 'form-control', 'rows' => 6)); ?>
    <?php echo $form->error($model, 'content'); ?>
</div>



<div class="form-group">
    <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'btn btn-primary')); ?>
</div>

<?php $this->endWidget(); ?>
