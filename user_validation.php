<?php

class SignUpValidation {

    private $form_data;
    private $existing_users;
    public $errors = [];
  
    public function __construct($form_data, $existing_users) {
        $this->form_data = $form_data;
        $this->existing_users = $existing_users;
    }

    public function validate() {
        $this->validateUsername();
        $this->validatePassword();
        
        return $this->errors;
    }

    // Check if username is empty
    // Check if username already exists
    private function validateUsername() {

        $username = trim($this->form_data['username']);

        if(empty($username)) {
            $this->addError('username', 'Username cannot be empty');
        } else {
            if(in_array($username, $this->existing_users)) {
                $this->addError('username', 'Oops! This username already exists');
            }
        }
    }

    // Check if password is empty
    private function validatePassword() {

        $password = trim($this->form_data['password']);

        if(empty($password)) {
            $this->addError('password', 'Password cannot be empty');
        }
    }
    
    private function addError($key, $val) {
        $this->errors[$key] = $val; 
    }
}
?>