<?php

namespace App\Controllers;

use App\Community\News;

/**
 * Class CommunityController
 * @package App\Controllers
 */
class CommunityController extends Controller {

    public function getAllNews() {
      $news = new News();
      $_SESSION['content'] = $news->getAllNews();
      $this->render();
    }

    public function getNew($id) {
      $new = new News(intval($id));
      if($new->getStatus() === 'valid') {
        $_SESSION['content'] = $new->getFullNew();
      } else {
        $this->errors->add('INVALID_NEW_ID');
      }
      $this->render();
    }
    
    public function addNew() {
	
    }
}
