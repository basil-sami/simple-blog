<!-- protected/views/blogPost/create.php -->
<h1>Create Blog Post</h1>

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'blog-post-form',
    'enableAjaxValidation'=>true, // Enable Ajax validation
)); ?>

<div class="row">
    <?php echo $form->labelEx($model,'title'); ?>
    <?php echo $form->textField($model,'title'); ?>
    <?php echo $form->error($model,'title'); ?>
</div>

<div class="row">
    <?php echo $form->labelEx($model,'content'); ?>
    <?php echo $form->textArea($model,'content'); ?>
    <?php echo $form->error($model,'content'); ?>
</div>

<div class="row">
    <?php echo $form->labelEx($model,'is_public'); ?>
    <?php echo $form->dropDownList($model,'is_public', array(
        '1' => 'Public',
        '0' => 'Private',
    )); ?>
    <?php echo $form->error($model,'is_public'); ?>
</div>

<div class="row buttons">
    <?php echo CHtml::submitButton('Create'); ?>
</div>

<?php $this->endWidget(); ?>
