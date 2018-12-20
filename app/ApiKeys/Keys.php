<?php

namespace App\ApiKeys;

use App\Database\PDOConnect;

/**
* Class Keys
* @package App\ApiKeys
*/
class Keys {

  /**
  * @var PDOConnect Instance de la classe
  */
  private $db;

  /**
  * @var string Clé API
  */
  private $apiKey;

  /**
  * @var string Domaine lié à la clé API
  */
  private $domain;

  /**
  * @var string (ENUM('public','private')) -> Type de clé ('invalid') si introuvable
  */
  private $restrictions;

  public function __construct($key = 0) {
    if(isset($_GET[$key])) {
      $this->db = new PDOConnect();
      $req = $this->db->query('SELECT * FROM alive_api_domains_allowed WHERE apiKey = ?', [$_GET[$key]]);
      if($req->rowCount() > 0) {
        $fetchKeys = $req->fetch();
        $this->apiKey = $fetchKeys->apiKey;
        $this->domain = $fetchKeys->domain;
        $this->restrictions = $fetchKeys->restrictions;
      } else {
        $this->apiKey = 'invalid';
      }
    } else {
      $this->apiKey = 'invalid';
    }
  }

  public function isValid() {
    if($this->apiKey !== 'invalid' && $_SERVER['HTTP_HOST'] === $this->domain) {
      return true;
    } else {
      return false;
    }
  }

}
