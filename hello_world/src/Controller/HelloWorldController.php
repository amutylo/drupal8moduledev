<?php

namespace Drupal\hello_world\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\hello_world\HelloWorldSalutation;
use Symfony\Component\DependencyInjection\ContainerInterface;

class HelloWorldController extends ControllerBase {

  protected $salutation;

  /**
   * HelloWorldController constructor.
   *
   * @param \Drupal\hello_world\HelloWorldSalutation $salutation
   */
  public function __construct(HelloWorldSalutation $salutation) {
    $this->salutation = $salutation;
  }

  /**
   * {@inheridoc}
   */
  public static function create(ContainerInterface $container) {
    return new static($container->get('hello_world.salutation'));
  }

  /**
   * @return array
   */
  public function helloWorld() {
    return [
      '#markup' => $this->salutation->getSalutation()
    ];
  }

}
