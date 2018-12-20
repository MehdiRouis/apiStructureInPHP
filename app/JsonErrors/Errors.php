<?php

namespace App\JsonErrors;

/**
* Class Errors
* @package App\JsonErrors
**/
class Errors {

  /*
  POSSIBLE ERRORS:
  INVALID_APIKEY ( $_GET['apiKey'] is invalid )
  INVALID_NEW_ID ( ID of new is invalid )

  */
  private $errors = ['errors' => []];

  public function __construct() {

  }

  public function countRows() {
    return count($this->errors['errors']);
  }

  public function add($content) {
    $errorExists = false;
    for($i = 0; $i < count($this->errors['errors']); $i++) {
      if($this->errors['errors'][$i]['content'] === $content) {
        $errorExists = true;
      }
    }
    if($errorExists === false) {
      array_push($this->errors['errors'], ['value' => $content]);
      $this->errors['content'] = false;
    }
  }

  public function parse() {
    if(count($this->errors['errors']) === 0) {
      return false;
    } else {
      return $this->errors;
    }
  }

}
