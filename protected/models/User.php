<?php
class User extends CActiveRecord
{
    public $password; // Non-persistent attribute for password input
    public $password_repeat;
    public $role; // Define as a public property for default role assignment
    public $verification_token;
    public $last_login_at;
    public $rememberMe; // Add rememberMe property
    private $_identity;
    private $_oldAttributes = array();
    // Define roles attribute
    public $roles;

    // Existing code continues...

    /**
     * Returns the database table name.
     * @return string the table name
     */
    public function tableName()
    {
        return 'users';
    }
    const SCENARIO_REGISTER = 'register';
    const SCENARIO_LOGIN = 'login';

    // Returns the database table name.
   

    // Returns validation rules for attributes.
    public function rules()
    {
        return array(
            // Registration scenario
            array('username, email, password, password_repeat', 'required', 'on' => self::SCENARIO_REGISTER),
            array('email', 'email', 'on' => self::SCENARIO_REGISTER),
            array('username, email', 'unique', 'on' => self::SCENARIO_REGISTER),
            array('password', 'length', 'min' => 6, 'on' => self::SCENARIO_REGISTER),
            array('password_repeat', 'compare', 'compareAttribute' => 'password', 'message' => 'Passwords must match.', 'on' => self::SCENARIO_REGISTER),
            
            // Login scenario
            array('username, password', 'required', 'on' => self::SCENARIO_LOGIN),
            array('rememberMe', 'boolean', 'on' => self::SCENARIO_LOGIN),
            array('password', 'authenticate', 'on' => self::SCENARIO_LOGIN),
        );
    }

    // Custom validation for password
    public function authenticate($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = self::model()->findByAttributes(array('username' => $this->username));
            if ($user === null || !CPasswordHelper::verifyPassword($this->password, $user->password_hash)) {
                $this->addError('password', 'Incorrect username or password.');
            }
        }
    }

    // Method to generate a verification token
    public function generateVerificationToken()
    {
        $this->verification_token = Yii::app()->getSecurityManager()->generateRandomString(32);
        return $this->save(false, array('verification_token'));
    }

    // Method to check if the user is an admin (assuming you have a role field in the users table)
    public function getIsAdmin()
    {
        return $this->role === 'admin';
    }

    // Checks if the email is verified
    public function isVerified()
    {
        return $this->email_verified === 1;
    }

    // Before saving the model, hash the password if it's a new record or the password is changed
    public function beforeSave()
    {
        if ($this->isNewRecord || $this->isAttributeChanged('password')) {
            $this->password_hash = CPasswordHelper::hashPassword($this->password);
        }
        if ($this->isNewRecord) {
            $this->verification_token = md5(uniqid());
            $this->role = 'user'; // Assign default role
        }
        return parent::beforeSave();
    }

    // Perform login
    public function login()
    {
        if ($this->validate()) {
            $identity = new UserIdentity($this->username, $this->password);
            if ($identity->authenticate()) {
                Yii::app()->user->login($identity, $this->rememberMe ? 3600 * 24 * 30 : 0);
                return true;
            } else {
                $this->addError('password', 'Incorrect username or password.');
            }
        }
        return false;
    }

    // Returns the static model of the specified AR class
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    

    /**
     * Returns validation rules for attributes.
     * @return array validation rules for attributes
     */
    
    
    /**
     * Custom method to validate password
     * @param string $password the password to validate
     * @return boolean whether the password is valid
     */
    public function validatePassword($password)
    {
        return CPasswordHelper::verifyPassword($password, $this->password_hash);
    }
    public function isAttributeChanged($name)
    {
        return isset($this->_oldAttributes[$name]) && $this->$name !== $this->_oldAttributes[$name];
    }

    /**
     * Method to generate a verification token
     * @return boolean whether the token was generated and saved successfully
     */
   
    /**
     * Checks if the email is verified
     * @return boolean whether the email is verified
     */
  

    /**
     * Returns the static model of the specified AR class
     * @param string $className the class name of the model
     * @return User the static model class
     */
 
   

    // Perform login
    // Existing code...
}


