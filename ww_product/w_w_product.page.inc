<?php

/**
 * @file
 * Contains w_w_product.page.inc.
 *
 * Page callback for Wwproduct entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Wwproduct templates.
 *
 * Default template: w_w_product.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_w_w_product(array &$variables) {
  // Fetch WWProduct Entity Object.
  $w_w_product = $variables['elements']['#w_w_product'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
