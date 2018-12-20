<?php

namespace App\Init\Routes;

/**
* Class RouterExceptions
* @package App\Init\Routes
*/
class RouterExceptions  extends \Exception {

    public function __construct($message) {
        //throw new \Exception($message);
    }

}
