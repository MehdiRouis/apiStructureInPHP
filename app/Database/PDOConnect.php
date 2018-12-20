<?php

namespace App\Database;
use \PDO;

/**
 * Class PDOConnect
 * @package App\Database
 */
class PDOConnect {

    /**
     * @var PDO Appel de la fonction PDO.
     */
    private $pdo;

    /**
     * @var string Nom de la base de donnée.
     */
    private $db_name;

    /**
     * @var string Nom d'utilisateur de la base de donnée.
     */
    private $db_user;

    /**
     * @var string Mot de passe de la base de donnée.
     */
    private $db_pass;

    /**
     * @var string Hôte de la base de donnée.
     */
    private $db_host;

    /**
     * @param $db_name string Nom de la base de donnée.
     * @param $db_user string Nom d'utilisateur de la base de donnée.
     * @param $db_pass string Mot de passe de la base de donnée.
     * @param $db_host string Hôte de la base de donnée.
     */
    public function __construct($db_name = 'alivewebproject', $db_user = 'admin', $db_pass = 'root', $db_host = 'localhost') {
        $this->db_name = $db_name;
        $this->db_user = $db_user;
        $this->db_pass = $db_pass;
        $this->db_host = $db_host;
    }

    /**
     * @return PDO
     */
    private function getPDO() {
        if($this->pdo === null) {
            $pdo = new PDO('mysql:dbname='.$this->db_name.';host='.$this->db_host,$this->db_user,$this->db_pass);
            $this->pdo = $pdo;
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        }
        return $this->pdo;
    }

    /**
     * @param $statement
     * @param bool $parameters
     * @return \PDOStatement
     */
    public function query($statement, $parameters = false){

        if($parameters){
            $req = $this->getPDO()->prepare($statement);
            $req->execute($parameters);
        } else {
            $req = $this->getPDO()->query($statement);
        }
        return $req;
    }
}
