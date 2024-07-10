<?php
class UserController extends Controller
{
    public function accessRules()
{
    return array(
        array('allow',  // allow all users to access 'login', 'register', and other specified actions
        'actions' => array('login', 'register', 'like', 'comment','create', 'update'),
    ),
        array('allow', // allow authenticated users to perform 'create' and 'update' actions
            'actions' => array('create', 'update'),
            'users' => array('@'),
        ),
        array('deny',  // deny all users
            'users' => array('*'),
        ),
    );
}
public function actionView($id)
{
    $model = User::model()->findByPk($id);
    if ($model === null) {
        throw new CHttpException(404, 'The requested user does not exist.');
    }
    $this->render('view', array(
        'model' => $model,
    ));
}
public function actionRegister()
{
    $model = new User(User::SCENARIO_REGISTER);

    // Check if the form is submitted
    if (isset($_POST['User'])) {
        $model->attributes = $_POST['User'];

        // Validate user input and save the user
        if ($model->save()) {
            $this->redirect(array('login'));
        }
    }

    // Display the registration form
    $this->render('register', array('model' => $model));
}

public function actionLogin()
{
    $model = new User(User::SCENARIO_LOGIN);

    // Check if the form is submitted
    if (isset($_POST['User'])) {
        $model->attributes = $_POST['User'];

        // Validate user input and perform login
        if ($model->login()) {
            $this->redirect(Yii::app()->user->returnUrl);
        }
    }

    // Display the login form
    $this->render('login', array('model' => $model));
}

public function actionLogout()
{
    Yii::app()->user->logout();
    $this->redirect(Yii::app()->homeUrl);
}

    public function actionValidateEmail()
{
    if (Yii::app()->request->isAjaxRequest && isset($_POST['email'])) {
        $email = $_POST['email'];
        $user = User::model()->findByAttributes(array('email' => $email));
        echo CJSON::encode(array('exists' => $user !== null));
        Yii::app()->end();
    }
}
public function actionProfile()
{
    if (!Yii::app()->user->isGuest) {
        $userId = Yii::app()->user->id;
        $user = User::model()->findByPk($userId);
        if ($user !== null && $user->isVerified()) {
            // User's email is verified, proceed with action
            $this->render('profile', array('user' => $user));
        } else {
            // User's email is not verified, handle accordingly
            Yii::app()->user->setFlash('error', 'Please verify your email to access this page.');
            $this->redirect(array('site/index')); // Redirect to home page or login page
        }
    } else {
        $this->redirect(array('site/login')); // Redirect to login page if user is not logged in
    }
}
public function actionVerify($token)
{
    $user = User::model()->findByAttributes(array('verification_token' => $token));

    if ($user !== null) {
        if ($user->verifyEmail($token)) {
            Yii::app()->user->setFlash('success', 'Your email has been successfully verified.');
        } else {
            Yii::app()->user->setFlash('error', 'Failed to verify your email. Please try again.');
        }
    } else {
        Yii::app()->user->setFlash('error', 'Invalid verification token.');
    }

    $this->redirect(Yii::app()->homeUrl);
}


}
