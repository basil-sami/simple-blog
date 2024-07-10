<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<div class="jumbotron text-center">
    <h1>Welcome to <?php echo CHtml::encode(Yii::app()->name); ?></h1>
    <p class="lead">Your one-stop solution for blogging.</p>
    <p>
        <a class="btn btn-primary btn-lg" href="<?php echo Yii::app()->createUrl('user/register'); ?>">Register</a>
        <a class="btn btn-success btn-lg" href="<?php echo Yii::app()->createUrl('user/login'); ?>">Login</a>
    </p>
</div>

<div class="container">
    <h2>Features</h2>
    <ul class="list-group">
        <li class="list-group-item"><?php echo CHtml::link('View Blog Posts', array('blogPost/index')); ?></li>
        <li class="list-group-item"><?php echo CHtml::link('Create a Blog Post', array('blogPost/create')); ?></li>
    </ul>
</div>

<div class="container">
    <h2>Need Help?</h2>
    <p>For more details on how to further develop this application, please read the documentation.</p>
    <p>Feel free to ask in the forum, should you have any questions.</p>
</div>
