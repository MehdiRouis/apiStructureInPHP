<?php

namespace App\Controllers;

use App\Database\PDOConnect;
use App\Protection\Security;
use App\Configuration\Settings;
use App\User\Infos;
use App\ApiKeys\Keys;

/**
* Class Controller
* @package App\Controllers
*/
class Controller {

  /**
  * @var PDOConnect Instance de la classe
  **/
  protected $db;

  /**
  * @var Errors Instance de la classe
  **/
  protected $errors;

  /**
  * @var Security Instance de la classe
  **/
  protected $security;

  /**
  * @var Settings Instance de la classe
  **/
  protected $settings;

  /**
  * @var Infos Instance de la classe ( User\Infos )
  **/
  protected $user;

  /**
  * @var Keys Instance de la classe ( ApiKeys\Keys )
  **/
  protected $apiKey;

  public function __construct() {
    $this->db = new PDOConnect();
    $this->errors = new \App\JsonErrors\Errors();
    $this->security = new Security();
    $this->settings = new Settings();
    $this->user = new Infos();
    $this->apiKey = new Keys('apiKey');
    if(!$this->apiKey->isValid()) {
      $this->errors->add('INVALID_APIKEY');
    }
  }


  protected function render() {
      $content = $_SESSION['content'];
      if(isset($content)) {
	  if($this->errors->countRows() > 0) {
	      $content = false;
	  }
      }
    $errors = $this->errors->countRows() > 0 ? $this->errors->parse()['errors'] : false;

    echo json_encode(['content' => $content, 'errors' => $errors]);    
    
}

}
