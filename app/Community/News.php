<?php

namespace App\Community;


use App\Database\PDOConnect;

/**
 * Class News
 * @package App\Community
 */
class News {

  /**
  * @var PDOConnect ( Instance de la classe )
  */
  private $db;

  /**
   * @var string Titre de l'article
   */
  private $title;

  /**
   * @var string Drescription de l'article
   */
  private $descr;

  /**
   * @var string Image de l'article
   */
  private $img;

  /**
   * @var string Contenu de l'article
   */
  private $content;

  /**
   * @var string Date de création ( timestamp )
   */
  private $createdAt;

  /**
   * @var string ID du créateur de l'article
   */
  private $createdBy;

  private $status;

  public function __construct($newId = 0) {
    $this->db = new PDOConnect();
    $req = $this->db->query('SELECT * FROM alive_news WHERE id = ?', [intval($newId)]);
    if($req->rowCount() > 0) {
      $newFetched = $req->fetch();
      $this->title = $newFetched->title;
      $this->descr = $newFetched->description;
      $this->content = $newFetched->content;
      $this->createdAt = $newFetched->createdAt;
      $this->createdBy = $newFetched->createdBy;
      $this->status = 'valid';
    } else {
      $this->status = 'invalid';
    }
  }

  public function getAllNews() {
    $req = $this->db->query('SELECT * FROM alive_news ORDER BY id DESC');
    return $req->fetchAll();
  }

  public function getFullNew() {
    return ['title' => $this->title, 'description' => $this->descr, 'content' => $this->content, 'createdAt' => $this->createdAt, 'createdBy' => $this->createdBy];
  }

  public function getTitle() {
    return $this->title;
  }

  public function getStatus() {
    return $this->status;
  }

}
