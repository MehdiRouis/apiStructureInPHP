<?php

namespace App\Controllers;

use App\Configuration\Settings;

/**
 * Class SettingsController
 * @package App\Controllers
 */
class SettingsController extends Controller {

    public function getSettings() {
      $settings = new Settings();
      $_SESSION['content'] = $settings->getAllSettings();
      $this->render();
    }
}
