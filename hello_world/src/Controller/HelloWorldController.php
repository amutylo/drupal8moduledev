<?php

namespace Drupal\hello_world\Controller;

use Drupal\Core\Controller\ControllerBase;

class HelloWorldController extends ControllerBase {

  public function helloWorld() {
    return [
      '#markup' => $this->t('Hello World')
    ];
  }

}
