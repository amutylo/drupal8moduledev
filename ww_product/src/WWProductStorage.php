<?php

namespace Drupal\ww_product;

use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\ww_product\Entity\WWProductInterface;

/**
 * Defines the storage handler class for Wwproduct entities.
 *
 * This extends the base storage class, adding required special handling for
 * Wwproduct entities.
 *
 * @ingroup ww_product
 */
class WWProductStorage extends SqlContentEntityStorage implements WWProductStorageInterface {

  /**
   * {@inheritdoc}
   */
  public function revisionIds(WWProductInterface $entity) {
    return $this->database->query(
      'SELECT vid FROM {w_w_product_revision} WHERE id=:id ORDER BY vid',
      [':id' => $entity->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function userRevisionIds(AccountInterface $account) {
    return $this->database->query(
      'SELECT vid FROM {w_w_product_field_revision} WHERE uid = :uid ORDER BY vid',
      [':uid' => $account->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function countDefaultLanguageRevisions(WWProductInterface $entity) {
    return $this->database->query('SELECT COUNT(*) FROM {w_w_product_field_revision} WHERE id = :id AND default_langcode = 1', [':id' => $entity->id()])
      ->fetchField();
  }

  /**
   * {@inheritdoc}
   */
  public function clearRevisionsLanguage(LanguageInterface $language) {
    return $this->database->update('w_w_product_revision')
      ->fields(['langcode' => LanguageInterface::LANGCODE_NOT_SPECIFIED])
      ->condition('langcode', $language->getId())
      ->execute();
  }

}
