<?php

namespace App\Configuration;
use App\Database\PDOConnect;
use App\Protection\Security;
use \PDO;

/**
* Class Settings
* @package Config
*/
class Settings {

  /**
  * @var PDOConnect
  */
  private $db;

  /**
  * @var string Configuration complète
  */

  private $settings;
  /**
  * @var string Nom du site
  */
  private $name = 'AliveWebProject';

  /**
  * @var boolean Maintenance activée ou non.
  */
  private $maintenance = 'true';

  /**
  * @var string
  */
  private $contact = 'esskapro@gmail.com';

  public function __construct() {
    if($this->db === null) {
      $this->db = new PDOConnect();
      $settings = $this->db->query('SELECT * FROM alive_settings WHERE id = ?', [1]);
      if($settings) {
        if ($settings->rowCount() > 0) {
          $setting = $settings->fetch();
          $this->settings = $setting;
          $this->name = $setting->siteName;
          $this->maintenance = $setting->maintenanceStatus;
          $this->contact = $setting->contact;
        }
      }
    }
  }

  private function Show($value) {
    $security = new Security();
    return $security->Show($value);
  }

  public function getAllSettings() {
    return $this->settings;
  }

  /**
  * @return string Retourne le nom du site.
  */
  public function getName() {
    return $this->Show($this->name);
  }

  /**
  * @return string Connaître l'état du site.
  */
  public function getMaintenance() {
    return $this->Show($this->maintenance);
  }

  public function getContact() {
    if(filter_var($this->contact,FILTER_VALIDATE_URL)) {
      return $this->Show($this->contact);
    }
  }
}
