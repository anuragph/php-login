<?php

class LogInValidation {
    
    protected $form_data;
    protected $errors = [];
    
    public function __construct($form_data) {
        $this->form_data = $form_data;
    }

    public function validate() {
        $this->validateUsername();
        $this->validatePassword();
        
        return $this->errors;
    }
    
    // Check if username is empty
    protected function validateUsername() {

        $username = trim($this->form_data['username']);

        if(empty($username)) {
            $this->addError('username', 'Username cannot be empty');
        }
    }

    // Check if password is empty
    protected function validatePassword() {

        $password = trim($this->form_data['password']);

        if(empty($password)) {
            $this->addError('password', 'Password cannot be empty');
        }
    }

    protected function addError($key, $val) {
        $this->errors[$key] = $val; 
    }    
}

class SignUpValidation extends LogInValidation {

    protected $existing_users;
  
    public function __construct($form_data, $existing_users) {
        parent::__construct($form_data);
        $this->existing_users = $existing_users;
    }
    
    // Override parent method.
    // -- Check if username is empty.
    // -- Check if username already exists.
    protected function validateUsername() {

        $username = trim($this->form_data['username']);

        if(empty($username)) {
            $this->addError('username', 'Username cannot be empty');
        } else {
            if(in_array($username, $this->existing_users)) {
                $this->addError('username', 'Oops! This username already exists');
            }
        }
    }
}

?>