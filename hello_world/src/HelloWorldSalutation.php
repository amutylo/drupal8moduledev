<?php

namespace Drupal\hello_world;

use Drupal\Core\StringTranslation\StringTranslationTrait;

/**
 * Prepare salutation for the world.
 *
 * @package Drupal\hello_world
 */
class HelloWorldSalutation {
  use StringTranslationTrait;

  public function getSalutation() {
    $time = new \DateTime();

    if ((int) $time->format('G') >= 06 && (int) $time->format('G') < 12) {
      return $this->t('Good morning world');
    }

    if ((int) $time->format('G') >= 12 && (int) $time->format('G') < 18) {
      return $this->t('Good afternoon world');
    }

    if ((int) $time->format('G') >= 18) {
      return $this->t('Good evening world');
    }
  }
}
