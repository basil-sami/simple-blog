<p>Click the following link to verify your email:</p>
<p><?php echo CHtml::link('Verify Email', Yii::app()->createAbsoluteUrl('/user/verify', array('token' => $model->verification_token))); ?></p>
