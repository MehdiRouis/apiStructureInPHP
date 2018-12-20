<?php

namespace App\Controllers;

/**
 * Class IndexController
 * @package App\Controllers
 */
class IndexController extends Controller {

    public function getHomepage() {
      $_SESSION['content'] = ['welcomeMessage' => 'Welcome to AliveWebProject\'s API!'];
      $this->render();
    }
}
