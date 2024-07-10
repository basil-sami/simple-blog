<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
    <style>
        body {
            padding-top: 70px;
            background-color: #f8f9fa;
        }

        .jumbotron {
            background-color: #007bff;
            color: white;
            padding: 2rem 1rem;
            margin-bottom: 2rem;
            border-radius: 0;
        }

        .jumbotron h1 {
            font-size: 3rem;
        }

        .jumbotron p.lead {
            font-size: 1.5rem;
        }

        .list-group-item {
            font-size: 1.2rem;
            border: none;
            padding: 1rem;
        }

        .footer {
            margin-top: 20px;
            padding: 10px 0;
            background: #f8f9fa;
            border-top: 1px solid #e7e7e7;
            text-align: center;
        }

        .form-horizontal .form-group {
            margin-bottom: 15px;
        }

        .form-horizontal .form-group label {
            text-align: left;
        }

        .form-horizontal .form-group .form-control {
            width: 100%;
        }

        .form-horizontal .form-group .btn-primary {
            margin-top: 10px;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <div class="container">
        <a class="navbar-brand" href="<?php echo Yii::app()->homeUrl; ?>"><?php echo CHtml::encode(Yii::app()->name); ?></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><?php echo CHtml::link('Home', array('/site/index'), array('class' => 'nav-link')); ?></li>
                <?php if (Yii::app()->user->isGuest): ?>
                    <li class="nav-item"><?php echo CHtml::link('Register', array('/user/register'), array('class' => 'nav-link')); ?></li>
                    <li class="nav-item"><?php echo CHtml::link('Login', array('/user/login'), array('class' => 'nav-link')); ?></li>
                <?php else: ?>
                    <li class="nav-item"><?php echo CHtml::link('Create Post', array('/blogPost/create'), array('class' => 'nav-link')); ?></li>
                    <li class="nav-item"><?php echo CHtml::link('Logout (' . Yii::app()->user->name . ')', array('/user/logout'), array('class' => 'nav-link')); ?></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <div class="jumbotron text-center">
        <h1 class="display-4">My Web Application</h1>
        <p class="lead"></p>
    </div>

    <!-- Sidebar Here -->
    <!-- Add your sidebar content or leave it empty with comments -->

    <?php echo $content; ?>
</div>

<footer class="footer">
    <div class="container">
        <p>&copy; <?php echo date('Y'); ?> by <?php echo CHtml::encode(Yii::app()->name); ?>. All Rights Reserved.</p>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
