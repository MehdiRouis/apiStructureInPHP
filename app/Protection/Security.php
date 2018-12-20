<?php

namespace App\Protection;

use App\Database\PDOConnect;

/**
* Class Router
* @package App\Init\Routes
*/
class Security {
  /**
  * @var PDOConnect Instance de la classe
  */
  private $db;

  public function __construct() {
    $this->db = new PDOConnect();
    //Verification des injections ( $_GET )
    $injection = 'INSERT|UNION|SELECT|NULL|COUNT|FROM|LIKE|DROP|TABLE|WHERE|COUNT|COLUMN|TABLES|INFORMATION_SCHEMA|OR';
    foreach($_GET as $getSearchs){
      $getSearch = explode(" ",$getSearchs);
      foreach($getSearch as $k=>$v){
        if(in_array(strtoupper(trim($v)),explode('|',$injection))){
          exit;
        }
      }
    }
  }

  /**
  * @param $val string
  * @return string
  */
  public function Show($val){
    return htmlspecialchars(utf8_encode($val), ENT_QUOTES, 'UTF-8');
  }

  /**
  * @param $val int|string
  * @return string
  */
  public function Post($val){
    return htmlspecialchars($val);
  }

  /**
  * @param $get_key string ($_GET[$get_key])
  * @param $table string Table name
  * @return bool
  */
  public function getVerification($get_key,$table) {
    if(isset($_GET[$get_key])) {
      if(intval($_GET[$get_key])) {
        $get_key = intval($_GET[$get_key]);
        $req = $this->db->query("SELECT * FROM $table WHERE id = ? LIMIT 1", [$get_key]);
        if($req->rowCount() > 0) {
          return true;
        } else {
          return false;
        }
      } else {
        return false;
      }
    } else {
      return false;
    }
  }

  /**
  * @param $id int
  * @param $table string
  * @return bool
  */
  public function postVerification($id,$table) {
    $verif = $this->db->query("SELECT id FROM $table WHERE id = ?", [intval($id)]);
    if($verif->rowCount() > 0) {
      return true;
    } else {
      return false;
    }
  }

  /**
   * @param string $link Lien de redirection
   * @return string
   */
  public function safeRedirect($link, $exit = true) {
    if (!headers_sent()){
      header('HTTP/1.1 301 Moved Permanently');
      header('Location: ' . $link);
      header("Connection: close");
    }
    print "<html>";
    print "<head><title>Redirection...</title>";
    print "<meta http-equiv='Refresh' content='0;url='{$link}' />";
    print "</head>";
    print "<body onload='location.replace('{$link}')'>";
    print "Vous rencontrez peut-être un problème.<br />";
    print "<a href='{$link}'>Se faire rediriger</a><br />";
    print "Si ceci est une erreur, merci de cliquer sur le lien.<br />";
    print "</body>";
    print "</html>";
    if ($exit) exit;
  }

  /**
   * @return bool
   */
  private function getAllowedIP() {
    $dbauth = new DBAuth();
    if ($dbauth->Logged()) {
      $req = $this->db->query('SELECT * FROM alive_users_allowed_ip WHERE userid = ? AND ip = ?', [$this->user->getId(), $this->session->getIP()]);
      if ($req->rowCount() > 0) {
        return true;
      } else {
        return false;
      }
    } else {
      return true;
    }
  }

  /**
   * @return void
   */
  public function securiseUserIP() {
    if(!$this->getAllowedIP()) {
      $this->safeRedirect(PROJECT_LINK.'/account/validation');
    }
  }

  /**
   * @param string $password Mot de passe non-crypté
   * @return string Mot de passe crypté
   */
  public function passwordEncryption($password) {
    return password_hash($password,PASSWORD_BCRYPT);
  }
}
