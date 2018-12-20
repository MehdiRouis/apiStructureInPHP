<?php

namespace App\User;

use App\Database\PDOConnect;
use App\Protection\Security;

class Infos {

    private $db;

    /**
     * @var array
     */
    public $user;

    public function __construct($userid = 0){
        $this->db = new PDOConnect();
        if($userid != 0) {
            $this->user = $this->db->query('SELECT * FROM users WHERE id = ?', [$userid])->fetch();
        }
    }

    private function getInfo($key) {
        $security = new Security();
        return $security->Show($this->user->$key);
    }

    public function getId() {
        return intval($this->getInfo('id'));
    }

    public function getUsername() {
        return $this->getInfo('username');
    }

    public function matchPassword($pass) {
        return password_verify($pass, $this->getInfo('password'));
    }

    public function setPassword($newpass) {
        $newpass = password_hash($newpass, PASSWORD_BCRYPT);
        $this->db->query('UPDATE users SET password = ? WHERE id = ?', [$newpass, $this->getInfo('id')]);
    }

    public function getRank($string = false) {
        if(!$string) {
            return intval($this->getInfo('rank'));
        } else {
            $rankuser = $this->db->query('SELECT id,name FROM alive_ranks WHERE id = ?', [$this->getInfo('rank')]);
            if($rankuser->rowCount() > 0) {
                return $rankuser->fetch()->name;
            } else {
                return 'Rang inconnu';
            }
        }
    }

    public function getMail() {
        return $this->getInfo('mail');
    }
    public function getPoints() {
        return $this->getInfo('vip_points');
    }

    public function isLogged() {
        return $this->existValue('auth');
    }

}
