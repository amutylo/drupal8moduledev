<?php

namespace Drupal\ww_product;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Wwproduct entity.
 *
 * @see \Drupal\ww_product\Entity\WWProduct.
 */
class WWProductAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\ww_product\Entity\WWProductInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished wwproduct entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published wwproduct entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit wwproduct entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete wwproduct entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add wwproduct entities');
  }

}
