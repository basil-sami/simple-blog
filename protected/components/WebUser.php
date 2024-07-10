<?php

class WebUser extends CWebUser
{
    /**
     * Checks if the user's email is verified.
     * @return bool whether the user's email is verified
     */
    private $_model;

    // Load user model.
    protected function loadUser()
    {
        if ($this->_model === null) {
            $this->_model = User::model()->findByPk($this->id);
        }
        return $this->_model;
    }

    // Check if the user is an admin.
    public function getIsAdmin()
    {
        $user = $this->loadUser();
        return $user && $user->role === 'admin';
    }

    // Check if the user's email is verified.
    public function getIsVerified()
    {
        $user = $this->loadUser();
        return $user && $user->email_verified;
    }
    public function isVerified()
    {
        if (!$this->isGuest) {
            $userId = $this->getId();
            $user = User::model()->findByPk($userId);
            if ($user !== null) {
                return $user->email_verified == 1; // Adjust based on your database schema
            }
        }
        return false;
    }

    /**
     * Override login to store last login time or perform other actions.
     * @param IUserIdentity $identity
     * @return bool
     */
    public function login($identity, $duration = 0)
    {
        if (parent::login($identity, $duration)) {
            // Perform additional actions upon successful login
            $user = User::model()->findByAttributes(array('username' => $identity->username));
            if ($user !== null) {
                // Example: Update last login time
                $user->last_login_at = new CDbExpression('NOW()');
                $user->save(false); // Save without validation
            }
            return true;
        }
        return false;
    }

}
