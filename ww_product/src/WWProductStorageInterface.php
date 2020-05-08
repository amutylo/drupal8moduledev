<?php

namespace Drupal\ww_product;

use Drupal\Core\Entity\ContentEntityStorageInterface;
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
interface WWProductStorageInterface extends ContentEntityStorageInterface {

  /**
   * Gets a list of Wwproduct revision IDs for a specific Wwproduct.
   *
   * @param \Drupal\ww_product\Entity\WWProductInterface $entity
   *   The Wwproduct entity.
   *
   * @return int[]
   *   Wwproduct revision IDs (in ascending order).
   */
  public function revisionIds(WWProductInterface $entity);

  /**
   * Gets a list of revision IDs having a given user as Wwproduct author.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user entity.
   *
   * @return int[]
   *   Wwproduct revision IDs (in ascending order).
   */
  public function userRevisionIds(AccountInterface $account);

  /**
   * Counts the number of revisions in the default language.
   *
   * @param \Drupal\ww_product\Entity\WWProductInterface $entity
   *   The Wwproduct entity.
   *
   * @return int
   *   The number of revisions in the default language.
   */
  public function countDefaultLanguageRevisions(WWProductInterface $entity);

  /**
   * Unsets the language for all Wwproduct with the given language.
   *
   * @param \Drupal\Core\Language\LanguageInterface $language
   *   The language object.
   */
  public function clearRevisionsLanguage(LanguageInterface $language);

}
