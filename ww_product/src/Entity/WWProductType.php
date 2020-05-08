<?php

namespace Drupal\ww_product\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Wwproduct type entity.
 *
 * @ConfigEntityType(
 *   id = "w_w_product_type",
 *   label = @Translation("Wwproduct type"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\ww_product\WWProductTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\ww_product\Form\WWProductTypeForm",
 *       "edit" = "Drupal\ww_product\Form\WWProductTypeForm",
 *       "delete" = "Drupal\ww_product\Form\WWProductTypeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\ww_product\WWProductTypeHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "w_w_product_type",
 *   admin_permission = "administer site configuration",
 *   bundle_of = "w_w_product",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/w_w_product_type/{w_w_product_type}",
 *     "add-form" = "/admin/structure/w_w_product_type/add",
 *     "edit-form" = "/admin/structure/w_w_product_type/{w_w_product_type}/edit",
 *     "delete-form" = "/admin/structure/w_w_product_type/{w_w_product_type}/delete",
 *     "collection" = "/admin/structure/w_w_product_type"
 *   }
 * )
 */
class WWProductType extends ConfigEntityBundleBase implements WWProductTypeInterface {

  /**
   * The Wwproduct type ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Wwproduct type label.
   *
   * @var string
   */
  protected $label;

}
