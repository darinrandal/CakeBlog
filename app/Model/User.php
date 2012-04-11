<?php
// app/Model/User.php
App::uses('AuthComponent', 'Controller/Component');
class User extends AppModel {
    public $name = 'User';
    public $validate = array(
        'username' => array(
            'required' => array(
                'rule' => 'notEmpty',
                'message' => 'You must enter a username'
            ),
            'alphaNumeric' => array(
                'rule' => 'alphaNumeric',
                'message' => 'Your username must contain alphanumeric characters only'
            ),
            'between' => array(
                'rule' => array('between', 3, 26),
                'message' => 'Your username must be between 3 and 26 characters in length'
            )
        ),
        'password' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'You must enter a password'
            )
        ),
        'email' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'You must enter an email'
            ),
            'email' => array(
                'rule' => 'email',
                'message' => 'Please enter a valid email'
            )
        ),
        'invitekey' => array(
            'numeric' => array(
                'rule' => 'numeric',
                'message' => 'Invite keys are numeric characters only',
                'allowEmpty' => true
            ),
            'length' => array(
                'rule' => array('between', 12, 12),
                'message' => 'Invite key is an invalid length'
            )
        )
    );

    public function beforeSave() {
        if (isset($this->data[$this->alias]['password'])) {
            $this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
        }
        return true;
    }
}