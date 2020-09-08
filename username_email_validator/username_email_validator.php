<?php

/* THIS CODE VALIDATES THE USERNAME AND THE EMAIL POSTED FROM HTML FORM
THE USERNAME IS CHECKED TO SEE IF IT CONTAINS FROM 6-12 CHARACTERS. TO CHANGE THIS, EDIT THE REGEX IN LINE 44 */

class UserValidator {

  public $posted_data = [];
  public $errors = [];
  private $fields = ['username','email'];
  public $username;
  public $email;

  // FETCHING THE POSTED DATA
  public function __construct($posted_data){
    $this->posted_data = $posted_data;
  }

  // CHECKING IF THE FIELDS IN THE FIELDS ARRAY EXIST IN THE POSTED DATA
  public function checkFieldsAvailability(){
    foreach ($this->fields as $field) {
      if (!array_key_exists($field, $this->posted_data)) {
        trigger_error("$field doesn't exist", E_USER_ERROR);
      }
    }
    $this->checkEmptiness();
  }

  // CHECKING IF ANY FIELD VALUE IS EMPTY
  public function checkEmptiness(){
    foreach ($this->posted_data as $field => $val) {
      if (empty(trim($val))) {
        $this->addError($field, "$field cannot be empty");
      }
    }
    if (count($this->errors) == 0) {
      $this->validateUsername();
      $this->validateEmail();
    }
  }

  // VALIDATING THE USERNAME ACCORDING TO THE REGEX IN LINE 44
  public function validateUsername(){
    if (!preg_match('/^[A-Za-z0-9]{6,12}$/', $this->posted_data['username'])) {
      $this->addError('username','The username should be from 6 to 12 characters');
    }
  }

  // VALIDATING THE EMAIL
  public function validateEmail(){
    if (!filter_var($this->posted_data['email'], FILTER_VALIDATE_EMAIL)) {
      $this->addError('email','The email is not valid');
    }
  }

  // ADDING ERROR TO THE ERRORS ARRAY
  public function addError($error_field, $error_msg){
    $this->errors[$error_field] = $error_msg;
  }

}

/* EXAMPLE:
    $newUser = new UserValidator(['username'=> 'username', 'email'=> 'username@info.com']);
    $newUser->checkFieldsAvailability();
    $errors = $newUser->errors; */

?>
