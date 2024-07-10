<!-- protected/views/user/view.php -->
<h1>User Details</h1>

<p><strong>Username:</strong> <?php echo CHtml::encode($model->username); ?></p>
<p><strong>Email:</strong> <?php echo CHtml::encode($model->email); ?></p>
<p><strong>Email Verified:</strong> <?php echo $model->isEmailVerified() ? 'Yes' : 'No'; ?></p>

<!-- Optional: Display other user details -->
<!-- <p><strong>Full Name:</strong> <?php echo CHtml::encode($model->full_name); ?></p> -->
<!-- <p><strong>Role:</strong> <?php echo CHtml::encode($model->role); ?></p> -->

<!-- Link to update user profile -->
<?php echo CHtml::link('Update Profile', array('update', 'id'=>$model->id)); ?>
